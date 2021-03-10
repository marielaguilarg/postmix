<?php

require_once "Models/conexion.php";

class DatosProducto extends Conexion{

	public function vistaProductosModel($datosServ, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gf_nombreesp, gf_nombreing FROM $tabla Inner Join cue_generales ON gf_numdato = gen_numdatoref WHERE gf_idtabla = 'V' AND gen_claveservicio = :numser ORDER BY gen_numdato");

		$stmt-> bindParam(":numser", $datosServ, PDO::PARAM_INT);
				
		$stmt-> execute();

		return $stmt->fetchAll();
	}

    public function datosProductosModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gf_numdato, gf_nombreesp, gf_nombreing, gf_idtabla FROM $tabla WHERE gf_idtabla='V' order by gf_numdato");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	public function editarProductoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gen_tipodato from cue_generales where concat(gen_claveservicio,gen_numdato)=:ids");
	
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();


	}



	public function datosProductoModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gf_numdato, gf_nombreesp, gf_nombreing, gf_idtabla FROM $tabla WHERE gf_idtabla='V' order by gf_numdato");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

		public function actualizaProductosModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE cue_generales Set gen_lugarsyd=:lugarsyd, gen_numdatoref=:datoref where concat(gen_claveservicio,gen_numdato)=:nsec");

			$stmt-> bindParam(":nsec", $datosModel["nsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":lugarsyd", $datosModel["lugarsyd"], PDO::PARAM_INT);
			$stmt-> bindParam(":datoref", $datosModel["datoref"], PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

		}


	public function vistaRepProductosModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ip_numseccion,ip_numrenglon,ip_numsistema,ip_descripcionproducto,ip_numcajas, ip_fechaproduccion,ip_fechacaducidad,ip_condicion,ip_edaddias,ip_semana,ip_estatus,ip_sinetiqueta FROM $tabla WHERE ip_claveservicio =:sv AND ip_numseccion =:sec and ip_numreporte =:numrep");

			$stmt-> bindParam(":sec", $datosModel["sec"], PDO::PARAM_INT);
			$stmt-> bindParam(":sv", $datosModel["sv"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $datosModel["nrep"], PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetchAll();

			$stmt->close();

	}
	
	function getDetalleProducto($vservicio, $seccion, $reporte) {
	    
	    $SQL_FJARABER = "SELECT *
	 		   FROM ins_detalleproducto
			  WHERE ins_detalleproducto.ip_claveservicio = :idser
			    AND ip_numseccion =:idnumseccion
				AND ip_numreporte =:numrep";
	    //echo $SQL_FJARABER;
	    $stmt = Conexion::conectar()-> prepare($SQL_FJARABER);
	    
	    $stmt-> bindParam(":idnumseccion", $seccion, PDO::PARAM_STR);
	    $stmt-> bindParam(":numrep",$reporte , PDO::PARAM_INT);
	    $stmt-> bindParam(":idser", $vservicio, PDO::PARAM_INT);
	    $stmt-> execute();
	    
	    $result=$stmt->fetchall();
	
	    return $result;
	}
	
        
          function CumplimientoProducto($vservicio, $referencia, $reporte) {
   
    $SQL_FJARABER = "SELECT
(((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))) as NIVELACEPTACION,
				    cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning
FROM
ins_generales
Inner Join ins_detalleproducto ON ins_generales.i_claveservicio = ins_detalleproducto.ip_claveservicio AND ins_generales.i_numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE `ins_generales`.`i_numreporte` = :reporte and ins_generales.i_claveservicio=:servicio
				     AND  ins_detalleproducto.ip_numseccion =:referencia
					 AND ins_detalleproducto.ip_sinetiqueta<>-1
GROUP BY  `ins_detalleproducto`.`ip_numreporte`, `ins_detalleproducto`.`ip_numseccion`";
//echo $SQL_FJARABER;
   $stmt = Conexion::conectar()-> prepare($SQL_FJARABER);

    $stmt-> bindParam(":referencia", $referencia, PDO::PARAM_STR);
    $stmt-> bindParam(":reporte",$reporte , PDO::PARAM_INT);
    $stmt-> bindParam(":servicio", $vservicio, PDO::PARAM_INT);
    $stmt-> execute();

    $result=$stmt->fetchall();
    foreach ($result as $ROW_FJARABE) {

        if ($_SESSION["idiomaus"] == 2)
            $res[0] = $ROW_FJARABE ["sec_descripcioning"];
        else
            $res[0] = $ROW_FJARABE ["sec_descripcionesp"];
        $res[1] = "< 10 " . T_("semanas");
        if ($ROW_FJARABE ['NIVELACEPTACION'] >= 80)
            $res[2] = "paloma";
        else
            $res[2] = "tache";
        $res[3] = $referencia;
    }
    return $res;
}

    public function nombreOpProducto($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT cad_descripcionesp FROM ca_catalogosdetalle WHERE cad_idcatalogo =:idcat AND cad_idopcion =:idop");

			$stmt-> bindParam(":idcat", $datosModel["idcat"], PDO::PARAM_INT);
			$stmt-> bindParam(":idop", $datosModel["idop"], PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetch();

			$stmt->close();

	}

	public function buscarRenglon($idser,$numrep,$numseccom,$numren, $tabla){
		$ssqle=("SELECT count(*) FROM $tabla
 WHERE `ins_detallerpoducto`.`ip_claveservicio` = :idser
AND `ins_detalleproducto`.`ip_numreporte` = :numrep
AND concat(ip_numseccion,'.',ip_numreactivo,'.',ip_numcomponente,'.',ip_numcaracteristica1,'.',
ip_numcaracteristica2) = ':numseccom' and ip_numrenglon=:numren");
		$stmt=Conexion::conectar()->prepare($ssqle);
		
		$stmt-> bindParam(":idser",$idser , PDO::PARAM_INT);
		$stmt-> bindParam(":numrep",$numrep , PDO::PARAM_INT);
		$stmt-> bindParam(":numseccom",$numseccom , PDO::PARAM_STR);
		$stmt-> bindParam(":numren",$numren , PDO::PARAM_INT);
		
		$stmt-> execute();
		
		$res=$stmt->fetch();
		$total=$res[0];
		return $total;
		
		
		
	}
	public function buscarRenglon2($idser,$numrep,$numseccom, $tabla){
		$sqlnr="select max(ip_numrenglon) as claveren
FROM `ins_detalleproducto` WHERE `ins_detalleproducto`.`ip_claveservicio` = :idser
AND `ins_detalleproducto`.`ip_numreporte` = :numrep AND ip_numseccion = :numseccom;";
		
		$stmt=Conexion::conectar()->prepare($sqlnr);
		
		$stmt-> bindParam(":idser",$idser , PDO::PARAM_INT);
		$stmt-> bindParam(":numrep",$numrep , PDO::PARAM_INT);
		$stmt-> bindParam(":numseccom",$numseccom , PDO::PARAM_STR);
		
		$stmt-> execute();
		
		$res=$stmt->fetch();
		$renglones=$res["claveren"];
		return $renglones;
		
		
		
	}
	public function insertarProducto($idser,
 $numrep, $numsec, $numren, $lugarsisno, $lugarprod, $lugarcajasno,
 $fecprod, $feccad, $estatus, $valsinet){
		$sSQL= "insert into ins_detalleproducto 
(ip_claveservicio, ip_numreporte, 
ip_numseccion, ip_numrenglon, ip_numsistema, ip_descripcionproducto, ip_numcajas,
 ip_fechaproduccion, ip_fechacaducidad, ip_estatus, ip_sinetiqueta) 
values (:idser, :numrep,
 :numsec, :numren, :lugarsisno, :lugarprod, :lugarcajasno,
 :fecprod, :feccad, :estatus, :valsinet)";
		try{
		$stmt=Conexion::conectar()->prepare($sSQL);
		
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
		$stmt-> bindParam(":numrep",$numrep, PDO::PARAM_INT);
		$stmt-> bindParam(":numsec",$numsec, PDO::PARAM_INT);
		$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
		$stmt-> bindParam(":lugarsisno",$lugarsisno, PDO::PARAM_INT);
		$stmt-> bindParam(":lugarprod", $lugarprod, PDO::PARAM_STR);
		$stmt-> bindParam(":lugarcajasno",$lugarcajasno, PDO::PARAM_INT);
		$stmt-> bindParam(":fecprod", $fecprod, PDO::PARAM_STR);
		$stmt-> bindParam(":feccad", $feccad, PDO::PARAM_STR);
		$stmt-> bindParam(":estatus",$estatus, PDO::PARAM_STR);
		$stmt-> bindParam(":valsinet", $valsinet, PDO::PARAM_INT);
		
		if(!$stmt->execute())
			throw new Exception("Error al insertar registro");
		}catch(Exception $ex){
	
			throw new Exception("Error al insertar detalle producto");
		}
	
		
	}
	
	public function actualizarFechaProduccion($idser,$numrep,$numsec,$numren, $tabla){
		$sqlfecprod="update $tabla set 
ip_fechaproduccion=(ip_fechacaducidad+ interval -70 day) 
where ip_claveservicio=:idser and ip_numreporte=:numrep 
and ip_numseccion=:numsec and ip_numrenglon=:numren";
		
		try{
			$stmt=Conexion::conectar()->prepare($sqlfecprod);
			
			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $numsec, PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
			
			
			if(!$stmt->execute())
				throw new Exception("Error al actualizar registro");
		}catch(Exception $ex){
			
			throw new Exception("Error al actualizar detalle producto");
		}
		
		
	}
	
	public function actualizarEdad($idser,$numrep,$numsec,$numren,$fecins, $tabla){
		$sqlcal="update $tabla 
set ip_edaddias=datediff(:fecins,ip_fechaproduccion) , 
ip_condicion=if((datediff(:fecins,ip_fechaproduccion))<=70,'V','C'),  
ip_semana=if((datediff(:fecins,ip_fechaproduccion))>0,if(((datediff(:fecins,
ip_fechaproduccion))/7)>0 and ((datediff(:fecins,ip_fechaproduccion))/7)<=1,0,
ceil((datediff(:fecins,ip_fechaproduccion)/7))-1),0)  
where ip_claveservicio=:idser and ip_numreporte=:numrep and ip_numseccion=:numsec and ip_numrenglon=:numren";
		
		
		try{
			$stmt=Conexion::conectar()->prepare($sqlcal);
			
			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $numsec, PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
			
			$stmt-> bindParam(":fecins", $fecins, PDO::PARAM_STR);
			if(!$stmt->execute())
				throw new Exception("Error al actualizar registro");
		}catch(Exception $ex){
			$stmt->debugDumpParams();
			throw new Exception("Error al actualizar detalle producto");
		}
		
		
	}
	
	public function eliminarProducto($idser,$numrep,$numsec, $tabla){
		$ssqle=("DELETE FROM $tabla
WHERE ip_claveservicio = :idser AND ip_numreporte = :numrep
AND concat(ip_numseccion,'.',ip_numrenglon) = :numsec");
		
		try{
			$stmt=Conexion::conectar()->prepare($ssqle);
			
			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $numsec, PDO::PARAM_STR);
			
			if(!$stmt->execute())
				throw new Exception("Error al eliminar registro");
			
		}catch(Exception $ex){
		
			throw new Exception("Error al eliminar detalle producto");
		}
		
		
	}
	
	public function consultaGraficaCumplimiento($listasec,$vservicio,$usuario, $mesinicial,$mesfinal){
	  
	    $sql_reporte_e = "SELECT
(((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))) AS NIVELACEPTACION,
sum(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,
SUM(`ins_detalleproducto`.`ip_numcajas`) as total,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE
	 ins_detalleproducto.ip_numseccion in (".substr($listasec,0,strlen($listasec)-1).")
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null)  and tmp_estadistica.usuario=:usuario
    and ins_detalleproducto.ip_claveservicio=:vserviciou
     and  STR_TO_DATE(mes_asignacion,'%Y-%m-%d') >:mes_inicial 
  and  STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:mes_final


ORDER BY `ins_detalleproducto`.`ip_numseccion` ASC, `ins_detalleproducto`.`ip_numreporte` ASC";
	    $parametros = array("vserviciou" => $vservicio,  "usuario" => $usuario,"mes_inicial"=> $mesinicial,"mes_final"=> $mesfinal,);
	    $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e, $parametros);
	    return $rs_sql_reporte_e;
	}
	public function consultaGraficaCumplimientoMensual($listasec,$vservicio,$usuario,$mesfinal){
	    
	    $sql_reporte_e = "SELECT
(((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))) AS NIVELACEPTACION,
sum(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,
SUM(`ins_detalleproducto`.`ip_numcajas`) as total,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE
	 ins_detalleproducto.ip_numseccion in (".substr($listasec,0,strlen($listasec)-1).")
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null)  and tmp_estadistica.usuario=:usuario
    and ins_detalleproducto.ip_claveservicio=:vserviciou
   
  and  STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:mes_final
	     
	     
ORDER BY `ins_detalleproducto`.`ip_numseccion` ASC, `ins_detalleproducto`.`ip_numreporte` ASC";
	    $parametros = array("vserviciou" => $vservicio,  "usuario" => $usuario,"mes_final"=> $mesfinal);
	    $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e, $parametros);
	    return $rs_sql_reporte_e;
	}
	

}

?>
