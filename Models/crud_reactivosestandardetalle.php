<?php

class DatosReactivosEstandarDetalle {
    function buscaSeccionesIndi($servicio, $vidiomau){
    $sql="SELECT
cue_reactivosestandardetalle.ser_claveservicio,
cue_reactivosestandardetalle.sec_numseccion AS seccion,
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,
cue_secciones.sec_nomsecesp,
cue_secciones.sec_nomsecing
FROM
cue_reactivosestandardetalle
Inner Join cue_secciones ON cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion AND cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio
WHERE
cue_reactivosestandardetalle.red_indicador =  '-1' AND
cue_reactivosestandardetalle.ser_claveservicio =  :servicio
GROUP BY
cue_reactivosestandardetalle.ser_claveservicio,
cue_reactivosestandardetalle.sec_numseccion
order by sec_ordsecind";
   
   
     $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
     $stmt->execute();
    
       if ($vidiomau == 1) {
        $nomcampo = "red_parametroesp";
    } else {
        $nomcampo = "red_parametroing";
    }
    $res=$stmt->fetchAll();
    foreach ($res as $row) {

        $nombre = $row[$nomcampo];
        $numero=$row["seccion"];
         $seccion=array($numero,$nombre); //creo arreglo
        $secciones[]=$seccion;
    }
  
 
    return $secciones;
    
}
    
    function buscaSubSeccionIndi($seccion, $vidiomau){
    $sql="SELECT
cue_reactivosestandardetalle.ser_claveservicio,
concat(cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2) AS seccion,
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing
FROM
cue_reactivosestandardetalle
WHERE
cue_reactivosestandardetalle.red_indicador =  '-1' AND
cue_reactivosestandardetalle.ser_claveservicio =  '1'
and cue_reactivosestandardetalle.sec_numseccion=:seccion";
   
   
     $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":seccion", $seccion, PDO::PARAM_INT);
     $stmt->execute();
       if ($vidiomau == 1) {
        $nomcampo = "red_parametroesp";
    } else {
        $nomcampo = "red_parametroing";
    }
    $res=$stmt->fetchAll();
    foreach ($res as $row) {

        $nombre = $row[$nomcampo];
        $numero=$row["seccion"];
         $seccion=array($numero,$nombre); //creo arreglo
        $secciones[]=$seccion;
    }
  
 
    return $secciones;
    
}

/*funcion que devuelve los indicadores por seccion en un arreglo
 * de la forma |3.8.0.0.1|nomseccion|estandar|
 * 
 */
function buscaIndicadores($seccion, $vidiomau,$servicio)
{
   
    $sql="SELECT
cue_reactivosestandardetalle.ser_claveservicio,concat(
cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2) as referencia,
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing
FROM
cue_reactivosestandardetalle
WHERE
cue_reactivosestandardetalle.red_indicador =  '-1' AND
cue_reactivosestandardetalle.ser_claveservicio = :servicio and  concat(
cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2)=:seccion";
     $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":seccion", $seccion, PDO::PARAM_STR);
      $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
      
     $stmt->execute();
    // $stmt->debugDumpParams();
       $res=$stmt->fetchAll(); 
      if ($vidiomau == 1) {
        $nomcampo = "red_parametroesp";
    } else {
        $nomcampo = "red_parametroing";
    }
    foreach ($res as $row) {
        $arr =array($row["referencia"], $row[$nomcampo] , $row["red_estandar"]);
        $reactivos[]=$arr;
    }
     
     return $reactivos;

}

function buscaRangosSem($referencia,$servicio)
{
     
    $sql="SELECT
   REPLACE(`red_rangor`,'^','-'),
     REPLACE(`red_rangoa`,'^','-'),
      REPLACE(`red_rangov`,'^','-')
    , `sec_numseccion`
    , `r_numreactivo`
    , `re_numcomponente`
    , `re_numcaracteristica`
    , `re_numcomponente2`
    , `red_numcaracteristica2`
FROM
    `cue_reactivosestandardetalle`
WHERE (`ser_claveservicio` =:servicio
   and concat( `sec_numseccion` ,'.',
     `r_numreactivo`,'.',
     `re_numcomponente`,'.',
     `re_numcaracteristica`,'.',
     `re_numcomponente2` ,'.',
     `red_numcaracteristica2`) =:referencia);";
      $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":referencia", $referencia, PDO::PARAM_STR);
      $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
       $stmt->execute();
   
       $res=$stmt->fetchAll(); 
     
    foreach ($res as $row) {
        $arr =array("r"=>$row[0],"a"=> $row[1] ,"v"=>$row[2] );
        
    }
  
     return $arr;
}
}
