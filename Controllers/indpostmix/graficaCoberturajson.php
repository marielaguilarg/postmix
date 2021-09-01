<?php

 class GraficaCoberturaJson
{

  
    public $filnivel;

    // llega en la forma 1.2.3.4.5.6
    public $filcuenta;

    // llega en la forma 1.2.3
    public $seccion;

    // llega en la forma [1.2.3,2.3.4]
    public $filperiodo;
    public $fmes_consulta;
    // llega en la forma mes.anio
    public $chart;
    
    public $nivel;
    public $servicio;
    public $filx;
    public $fily;
    public $filuni;
    public $mes_consulta_ant;
    public $soloanio;
    

    // array con los datos para json
    public function __construct()
    {
     
        $this->colores_cobertura=array("#CC0066", "#2683C6",    "#1D9BA1");
        
    }
    
  

    public function leerFiltros()
    {
      //  $seccion = filter_input(INPUT_GET,"sec",FILTER_SANITIZE_NUMBER_INT);
//$nivel = filter_input(INPUT_GET,"niv",FILTER_SANITIZE_NUMBER_INT);

        $gfilx=filter_input(INPUT_GET,"filx",FILTER_SANITIZE_SPECIAL_CHARS);

        $this->filcuenta=filter_input(INPUT_GET,"fily",FILTER_SANITIZE_SPECIAL_CHARS);
        $gfiluni=filter_input(INPUT_GET,"filuni",FILTER_SANITIZE_SPECIAL_CHARS);
        if ($gfiluni == "") {
           $gfiluni="1.1";
        }
        $this->filnivel=$gfiluni.".".$gfilx;
        $this->filperiodo=filter_input(INPUT_GET,"mes",FILTER_SANITIZE_SPECIAL_CHARS);
         $this->tipo=filter_input(INPUT_GET,"tipo",FILTER_SANITIZE_SPECIAL_CHARS);
        $this->servicio=1;
          //separo filtros
        
        if ($this->filnivel == "") {
            $this->filnivel="1.1";
        }


        $aux = explode(".", $this->filnivel);

       
       
        $auxy = explode(".", $this->filcuenta);

        $this->fily = array();

        $this->fily["cta"] = $auxy[0];
        $this->fily["fra"] = $auxy[1];
        $this->fily["pv"] = $auxy[2];
       

        $this->filuni=array();
        $this->filuni["reg"]=$aux[0];
        $this->filuni["uni"]=$aux[1];
        $this->filuni["zon"]=$aux[2];
         $this->filx = array();

        $this->filx["edo"] = $aux[3];

        $this->filx["ciu"] = $aux[4];
        $this->filx["niv6"] = $aux[5];

        $zona=$this->filuni["zon"];

        
        $aux=explode('.', $this->filperiodo);

        $this->soloanio = $aux[1];

        $this->mes_consulta_ant=$this->soloanio."-01-01";
               
        $this->fmes_consulta=$aux[1]."-".$aux[0]."-01";
    }

   
  
   
    
    public function consultarCobertura($nivelusuario=3){
        
      
    
      //consulta para solicitados y equipos en el mercado
            $sql_val = " SELECT sum(una_unegocioasignados) asignados,sum(una_numeroequipos) as equipos FROM ca_unegociosasignados
  WHERE una_anio=:anio";
              if($nivelusuario==4){
                $campo="ciudad";
                $sql_val.=" and n4_id=".$this->filx["edo"]."";
              }
               if($nivelusuario==5){
                $campo="ciudad";
                $sql_val.=" and n5_id=".$this->filx["ciu"]."";
              }
              $resultado = Conexion::ejecutarQuery($sql_val,array("anio"=>$this->soloanio));
              foreach($resultado as $row){
                  $solicitados=$row["asignados"];
                  $equipos=$row["equipos"];
              }
            //consulta para num. de inspecciones
            
            $sql_ins=" SELECT
 sum(IF(i_claveservicio IS NOT NULL,1,0) ) as tam_muestra
 ,if(ca_unegocios.une_cla_franquicia=482 or
ca_unegocios.une_cla_franquicia=491 or
ca_unegocios.une_cla_franquicia=493 or
ca_unegocios.une_cla_franquicia=496 or
ca_unegocios.une_cla_franquicia=498 or
ca_unegocios.une_cla_franquicia=502 or
ca_unegocios.une_cla_franquicia=507 or
ca_unegocios.une_cla_franquicia=508, 83, if(ca_unegocios.une_cla_ciudad=83,82, ca_unegocios.une_cla_ciudad) 
)as cla_ciudad 
 FROM
ins_generales
INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
 INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`
       INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad 
          INNER JOIN ca_nivel6 ON ca_nivel6.n6_id=ca_unegocios.une_cla_franquicia  
 /*LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` 
AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=8
 AND `ide_numreactivo`=0
  AND `ide_numcomponente`=2
  AND `ide_numcaracteristica1`=0
  AND `ide_numcaracteristica2`=0
  AND `ide_numcaracteristica3`=6
  AND `ide_numrenglon`=1 AND i_finalizado=-1*/
where

i_claveservicio =:servicio";
 $parametros = array("servicio" =>$this->servicio);
        if(isset($this->filuni["reg"])&&$this->filuni["reg"]!="")
        { $sql_ins.=" and  une_cla_region=".$this->filuni["reg"];
        }
        if(isset($this->filuni["uni"])&&$this->filuni["uni"]!="")
        {$sql_ins.=" and une_cla_pais=".$this->filuni["uni"];
        }
        if(isset($this->filuni["zon"])&&$this->filuni["zon"]!="")
        { $sql_ins.=" and une_cla_zona=".$this->filuni["zon"];
       }
    if (isset($this->filx["ciu"]) && $this->filx["ciu"] != "") {
            $sql_ins .= " and ca_unegocios.une_cla_ciudad=:ciu";
            $parametros["ciu"] = $this->filx["ciu"];
              
        }
        $sql_ins.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$this->fmes_consulta'


        and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$this->mes_consulta_ant'";

         if(isset($this->fily["cta"])&&$this->fily["cta"]!="")
          $sql_ins.=" and ca_unegocios.cue_clavecuenta=".$this->fily["cta"];
        if(isset($this->filx["edo"])&&$this->filx["edo"]!="")
        {  $sql_ins.=" and ca_unegocios.une_cla_estado=".$this->filx["edo"];
        }

       
        if(isset($this->filx["niv6"])&&$this->filx["niv6"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_franquicia=".$this->filx["niv6"];
        }
        if(isset($this->fily["fra"])&&$this->fily["fra"]!="")
            $sql_ins.=" and ca_unegocios.fc_idfranquiciacta=".$this->fily["fra"];
//         if(isset($this->filx["ciu"])&&$this->filx["ciu"]!="")
//        {   $sql_ins.=" having cla_ciudad=".$this->filx["ciu"];
//        }

       

        $result = Conexion::ejecutarQuery($sql_ins,$parametros);
       
        if ($result) {
            foreach ($result as $rowt) {
              $auditados= $rowt ["tam_muestra"];
              
            }
         
        }
        $this->chart [0] = array(T_("Auditorias restantes: ".($solicitados-$auditados)),$solicitados-$auditados,$this->colores_cobertura[ 1]);
            $this->chart [1] = array(T_("Avance: ".$auditados),$auditados+0,$this->colores_cobertura[0]);
            $this->chart[2]=array(T_("Equipos restantes: ".($equipos-$auditados)),$equipos-$auditados,$this->colores_cobertura[2]);
            $this->chart[3]=array(T_("Equipos auditados: ".$auditados),$auditados+0,$this->colores_cobertura[0]);
            $this->chart[4]=array(T_("Auditorias solicitadas: ".$solicitados));
            $this->chart[5]=array(T_("Equipos en el mercado: ".$equipos));
            
}

/***
 * 
 * 
 *     ATLACOMULCO 482
    LERMA 491
    METEPEC 493
    OCOYOACAC  496
    TEMOAYA 498
    TOLUCA  502
    SANTIAGO TIANGUISTENCO 507
    ACOLMAN 508
 */
    public function consultarCoberturaxRegion($nivelusuario,$grupo){
    //   echo "yo".$_SESSION["fniv"];
     //busco los pvs solicitados y equipos
        $sql_val = " SELECT sum(una_unegocioasignados) asignados,sum(una_numeroequipos) as equipos,
             n4_nombre";
              if($nivelusuario==4){ 
             $sql_val.=" ,ca_nivel5.n5_nombre";
              }
            $sql_val.=" FROM ca_unegociosasignados
   INNER JOIN ca_nivel4 ON ca_nivel4.n4_id=ca_unegociosasignados.n4_id";
         if($nivelusuario==4){ 
     $sql_val.=" inner join ca_nivel5 on ca_nivel5.n5_id=ca_unegociosasignados.n5_id";
         }
   $sql_val.=" WHERE una_anio=:anio";
        $campo="n4_nombre";
      
        if($nivelusuario==4){ //para busqueda por estado
                $campo="n5_nombre";
                $sql_val.=" and ca_nivel4.n4_id=".$this->filx["edo"]." group by n5_nombre";
        }else
            $sql_val.=" group by ca_unegociosasignados.n4_id";            
        $resultado = Conexion::ejecutarQuery($sql_val,array("anio"=>$this->soloanio));
            foreach($resultado as $row){
                $arre_resultado[]=array($row[$campo],$row["asignados"],$row["equipos"]);
             
            }
            //consulta para num. de inspecciones
            
         $sql_ins=" SELECT
 sum(IF(i_numreporte IS NOT NULL,1,0) ) as tam_muestra,
 n4_nombre,n5_nombre,n6_nombre ,if(ca_unegocios.une_cla_franquicia=482 or
ca_unegocios.une_cla_franquicia=491 or
ca_unegocios.une_cla_franquicia=493 or
ca_unegocios.une_cla_franquicia=496 or
ca_unegocios.une_cla_franquicia=498 or
ca_unegocios.une_cla_franquicia=502 or
ca_unegocios.une_cla_franquicia=507 or
ca_unegocios.une_cla_franquicia=508, 83, if(ca_unegocios.une_cla_ciudad=83,82, ca_unegocios.une_cla_ciudad) 
)as cla_ciudad 
 FROM
ins_generales
INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
   INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`
       INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad 
          INNER JOIN ca_nivel6 ON ca_nivel6.n6_id=ca_unegocios.une_cla_franquicia  
 /*LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` 
AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=8
 AND `ide_numreactivo`=0
  AND `ide_numcomponente`=2
  AND `ide_numcaracteristica1`=0
  AND `ide_numcaracteristica2`=0
  AND `ide_numcaracteristica3`=6
  AND `ide_numrenglon`=1 AND i_finalizado=-1*/
where
i_claveservicio =:servicio";

      

        $sql_ins.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$this->fmes_consulta'


        and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$this->mes_consulta_ant'";

         if(isset($this->fily["cta"])&&$this->fily["cta"]!="")
          $sql_ins.=" and ca_unegocios.cue_clavecuenta=".$this->fily["cta"];
        if(isset($this->filx["edo"])&&$this->filx["edo"]!="")
        {  $sql_ins.=" and ca_unegocios.une_cla_estado=".$this->filx["edo"];
        }

       
        if(isset($this->filx["niv6"])&&$this->filx["niv6"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_franquicia=".$this->filx["niv6"];
        }
        if(isset($this->fily["fra"])&&$this->fily["fra"]!="")
            $sql_ins.=" and ca_unegocios.fc_idfranquiciacta=".$this->fily["fra"];
 
        $parametros = array("servicio" =>$this->servicio);
        $campo="n4_nombre";
        if($grupo!="cue"){
         
            if($nivelusuario==4){
                $campo="n5_nombre";
                $sql_ins.=" group by cla_ciudad";
            }else
            if($nivelusuario==5){
                $campo="n6_nombre";
                $sql_ins.=" group by une_cla_franquicia";
            }else
                $sql_ins.=" group by une_cla_estado";
                 
        }else
            $sql_ins.=" group by une_cla_estado";
        if(isset($this->filx["ciu"])&&$this->filx["ciu"]!="")
        {   $sql_ins.=" having cla_ciudad=".$this->filx["ciu"];
        }
        $result = Conexion::ejecutarQuery($sql_ins,$parametros);
  
        if ($result) {
            foreach ($result as $rowt) {
              
               $arre_resultado2[$rowt [$campo]] = array($rowt [$campo],$rowt ["tam_muestra"]);
                $this->chart["dona"][] =array($rowt [$campo],$rowt ["tam_muestra"]); 
            }
          
          
        }
      
//        echo "<pre>";
//       print_r($arre_resultado);
//        echo "</pre>";
//        var_dump($arre_resultado2);
        //armo el arreglo para las barras
        foreach($arre_resultado as $region){
            $val=$arre_resultado2[$region[0]][1]==null?0:$arre_resultado2[$region[0]][1];
            $arre[]=array($region[0],$val,$region[1],$region[2]);
             //  $arre[]=array($arre_resultado2[$region[0]][1],$val,$region[1],$region[2]);

        }
       $this->chart["barras"]=$arre;
       //mando un error
         if($nivelusuario==5){
               $this->chart["barras"]=null;
         }
//         echo "<pre>";
//        print_r($this->chart["barras"] );
//       echo "</pre>";
}

  public function consultarCoberturaxCuenta($nivelusuario,$grupo){
    
        $sql_val = " SELECT sum(una_unegocioasignados) asignados,sum(una_numeroequipos) as equipos,
             ca_unegociosasignados.cue_id,cue_descripcion
             FROM ca_unegociosasignados
            inner join ca_cuentas on ca_cuentas.cue_id=ca_unegociosasignados.cue_id
  WHERE una_anio=:anio ";
        
               if($nivelusuario==4){
              
                $sql_val.=" and n4_id=".$this->filx["edo"]."";
              }
               if($nivelusuario==5){
               
                $sql_val.=" and n5_id=".$this->filx["ciu"]."";
              }        
        $resultado = Conexion::ejecutarQuery($sql_val." group by cue_id",array("anio"=>$this->soloanio));
            foreach($resultado as $row){
                $arre_resultado[$row["cue_id"]]=array($row["asignados"],$row["equipos"],$row["cue_descripcion"]);
             
            }
          //  var_dump($arre_resultado);
          //  die();
            //consulta para num. de inspecciones
            
         $sql_ins=" SELECT
 sum(IF(i_numreporte IS NOT NULL,1,0) ) as tam_muestra,cue_id, cue_descripcion
  ,if(ca_unegocios.une_cla_franquicia=482 or
ca_unegocios.une_cla_franquicia=491 or
ca_unegocios.une_cla_franquicia=493 or
ca_unegocios.une_cla_franquicia=496 or
ca_unegocios.une_cla_franquicia=498 or
ca_unegocios.une_cla_franquicia=502 or
ca_unegocios.une_cla_franquicia=507 or
ca_unegocios.une_cla_franquicia=508, 83, if(ca_unegocios.une_cla_ciudad=83,82, ca_unegocios.une_cla_ciudad) 
)as cla_ciudad 
 FROM
ins_generales
INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
     INNER JOIN ca_cuentas ON 
          ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
 INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`
       INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad 
          INNER JOIN ca_nivel6 ON ca_nivel6.n6_id=ca_unegocios.une_cla_franquicia  
/* LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` 
AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=8
 AND `ide_numreactivo`=0
  AND `ide_numcomponente`=2
  AND `ide_numcaracteristica1`=0
  AND `ide_numcaracteristica2`=0
  AND `ide_numcaracteristica3`=6
  AND `ide_numrenglon`=1 AND i_finalizado=-1*/
where
i_claveservicio =:servicio";

      

        $sql_ins.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$this->fmes_consulta'


        and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$this->mes_consulta_ant'";

        $parametros = array("servicio" =>$this->servicio);
        if(isset($this->filx["edo"])&&$this->filx["edo"]!="")
        {  $sql_ins.=" and ca_unegocios.une_cla_estado=".$this->filx["edo"];
        }

       
        if(isset($this->filx["niv6"])&&$this->filx["niv6"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_franquicia=".$this->filx["niv6"];
        }
         if (isset($this->filx["ciu"]) && $this->filx["ciu"] != "") {
            $sql_ins .= " and ca_unegocios.une_cla_ciudad=:ciu";
            $parametros["ciu"] = $this->filx["ciu"];
              
        }
      
       
         
        $sql_ins.=" group by cue_id";
//        if(isset($this->filx["ciu"])&&$this->filx["ciu"]!="")
//        {   $sql_ins.=" having cla_ciudad=".$this->filx["ciu"];
//        }
        $result = Conexion::ejecutarQuery($sql_ins,$parametros);
     //  die();
        if ($result) {
            foreach ($result as $rowt) {
              $arre_resultado2[$rowt["cue_id"]]= array($rowt ["cue_descripcion"],$rowt ["tam_muestra"]);
              $this->chart ["dona"][] =array($rowt ["cue_descripcion"],$rowt ["tam_muestra"]); 
            }
          
        }
//          echo "<pre>";
//        print_r($arre_resultado );
//        echo "</pre>";
      // var_dump($arre_resultado2);
        //armo el arreglo para las barras
        foreach($arre_resultado as $key=>$cuenta){
         
          if($arre_resultado2[$key][0]){
            $val=$arre_resultado2[$key][1]==null?0:$arre_resultado2[$key][1];
            $this->chart["barras"][]= array($cuenta[2],$val ,$cuenta[0],$cuenta[1]);
          }
          else
               $this->chart["barras"][]= array($cuenta[2],0 ,$cuenta[0],$cuenta[1]);
        }
//          echo "<pre>";
//       print_r($this->chart["barras"] );
//        echo "</pre>";
}

/*******
 * función con la lógica para seleccionar el tipo de gráfica y hacer la consulta
 */

    public function mostarGrafica()
    {
           $grupo = $_SESSION["GrupoUs"];
           // die("yo".$_SESSION["fniv"]);
           if(isset($_SESSION["fniv"]))
               $nivel= $_SESSION["fniv"];
         //  echo "++++".$nivel;
        if ($this->tipo == "Cob") {
         $this->consultarCobertura($nivel);
        }
        if ($this->tipo == "CobxReg") {
         $this->consultarCoberturaxRegion($nivel,$grupo);
        } 
        if ($this->tipo == "CobxCta") {
         $this->consultarCoberturaxCuenta($nivel,$grupo);
        }  
//          echo "<pre>";
//       print_r($this->chart );
//        echo "</pre>";
       // die();
        print json_encode($this->chart);
        
    }
}

