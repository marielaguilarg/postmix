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

   
  
   
    
    public function consultarCobertura(){
        
      
    
      //consulta para solicitados y equipos en el mercado
            $sql_val = " SELECT sum(una_unegocioasignados) asignados,sum(una_numeroequipos) as equipos FROM ca_unegociosasignados
  WHERE una_anio=:anio";
              $resultado = Conexion::ejecutarQuery($sql_val,array("anio"=>$this->soloanio));
              foreach($resultado as $row){
                  $solicitados=$row["asignados"];
                  $equipos=$row["equipos"];
              }
            //consulta para num. de inspecciones
            
            $sql_ins=" SELECT
 sum(IF(ide_numseccion IS NOT NULL,1,0) ) as tam_muestra
 FROM
ins_generales
INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
 LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` 
AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=8
 AND `ide_numreactivo`=0
  AND `ide_numcomponente`=2
  AND `ide_numcaracteristica1`=0
  AND `ide_numcaracteristica2`=0
  AND `ide_numcaracteristica3`=6
  AND `ide_numrenglon`=1 /*AND i_finalizado=1*/
where

i_claveservicio =:servicio";

        if(isset($this->filuni["reg"])&&$this->filuni["reg"]!="")
        { $sql_ins.=" and  une_cla_region=".$this->filuni["reg"];
        }
        if(isset($this->filuni["uni"])&&$this->filuni["uni"]!="")
        {$sql_ins.=" and une_cla_pais=".$this->filuni["uni"];
        }
        if(isset($zona)&&$zona!="")
        { $sql_ins.=" and une_cla_zona=".$zona;
       }

        $sql_ins.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$this->fmes_consulta'


        and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$this->mes_consulta_ant'";

         if(isset($this->fily["cta"])&&$this->fily["cta"]!="")
          $sql_ins.=" and ca_unegocios.cue_clavecuenta=".$this->fily["cta"];
        if(isset($this->filx["edo"])&&$this->filx["edo"]!="")
        {  $sql_ins.=" and ca_unegocios.une_cla_estado=".$this->filx["edo"];
        }

        if(isset($this->filx["ciu"])&&$this->filx["ciu"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_ciudad=".$this->filx["ciu"];
        }
        if(isset($this->filx["niv6"])&&$this->filx["niv6"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_franquicia=".$this->filx["niv6"];
        }
        if(isset($this->fily["fra"])&&$this->fily["fra"]!="")
            $sql_ins.=" and ca_unegocios.fc_idfranquiciacta=".$this->fily["fra"];

        $parametros = array("servicio" =>$this->servicio);

        $result = Conexion::ejecutarQuery($sql_ins,$parametros);
       
        if ($result) {
            foreach ($result as $rowt) {
              $auditados= $rowt ["tam_muestra"];
              
            }
            $this->chart [0] = array(T_("Solicitadas"),$solicitados+0);
            $this->chart [1] = array(T_("Avance"),$auditados+0);
            $this->chart[2]=array(T_("Equipos en el mercado"),$equipos+0);
              $this->chart[3]=array(T_("Equipos auditados"),$auditados+0);
        }
}

    public function consultarCoberturaxRegion($nivelusuario,$grupo){
//        echo "yo".$_SESSION["fniv"];
//      die("--".$nivelusuario);
        $sql_val = " SELECT sum(una_unegocioasignados) asignados,sum(una_numeroequipos) as equipos,
             n4_nombre,ciudad
            FROM ca_unegociosasignados
   INNER JOIN ca_nivel4 ON ca_nivel4.n4_id=ca_unegociosasignados.n4_id WHERE una_anio=:anio
";
        $campo="n4_nombre";
      
        if($nivelusuario==4){
                $campo="ciudad";
                $sql_val.=" and ca_nivel4.n4_id=".$this->filx["edo"]." group by ciudad";
        }else
            $sql_val.=" group by ca_unegociosasignados.n4_id";            
        $resultado = Conexion::ejecutarQuery($sql_val,array("anio"=>$this->soloanio));
            foreach($resultado as $row){
                $arre_resultado[]=array($row[$campo],$row["asignados"],$row["equipos"]);
             
            }
            //consulta para num. de inspecciones
            
         $sql_ins=" SELECT
 sum(IF(ide_numseccion IS NOT NULL,1,0) ) as tam_muestra,
 n4_nombre,n5_nombre,n6_nombre 
 FROM
ins_generales
INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
   INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`
       INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad 
          INNER JOIN ca_nivel6 ON ca_nivel6.n6_id=ca_unegocios.une_cla_franquicia  
 LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` 
AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=8
 AND `ide_numreactivo`=0
  AND `ide_numcomponente`=2
  AND `ide_numcaracteristica1`=0
  AND `ide_numcaracteristica2`=0
  AND `ide_numcaracteristica3`=6
  AND `ide_numrenglon`=1 /*AND i_finalizado=1*/
where
i_claveservicio =:servicio";

      

        $sql_ins.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$this->fmes_consulta'


        and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$this->mes_consulta_ant'";

         if(isset($this->fily["cta"])&&$this->fily["cta"]!="")
          $sql_ins.=" and ca_unegocios.cue_clavecuenta=".$this->fily["cta"];
        if(isset($this->filx["edo"])&&$this->filx["edo"]!="")
        {  $sql_ins.=" and ca_unegocios.une_cla_estado=".$this->filx["edo"];
        }

        if(isset($this->filx["ciu"])&&$this->filx["ciu"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_ciudad=".$this->filx["ciu"];
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
                $sql_ins.=" group by une_cla_ciudad";
            }else
            if($nivelusuario==5){
                $campo="n6_nombre";
                $sql_ins.=" group by une_cla_franquicia";
            }else
                $sql_ins.=" group by une_cla_estado";
                 
        }else
            $sql_ins.=" group by une_cla_estado";
        $result = Conexion::ejecutarQuery($sql_ins,$parametros);
       
        if ($result) {
            foreach ($result as $rowt) {
              
               $arre_resultado2[$rowt [$campo]] = array($rowt [$campo],$rowt ["tam_muestra"]);
                $this->chart["dona"][] =array($rowt [$campo],$rowt ["tam_muestra"]); 
            }
          
          
        }
      
//        echo "<pre>";
    //   print_r($this->chart["dona"] );
//        echo "</pre>";
//        var_dump($arre_resultado);
        //armo el arreglo para las barras
        foreach($arre_resultado as $region){
            $val=$arre_resultado2[$region[0]][1]==null?0:$arre_resultado2[$region[0]][1];
            $arre[]=array($region[0],$val,$region[1],$region[2]);
        }
       $this->chart["barras"]=$arre;
//         echo "<pre>";
//        print_r($this->chart["barras"] );
//       echo "</pre>";
}

  public function consultarCoberturaxCuenta($nivelusuario,$grupo){
        
        $sql_val = " SELECT sum(una_unegocioasignados) asignados,sum(una_numeroequipos) as equipos,
             cue_id
             FROM ca_unegociosasignados
            
  WHERE una_anio=:anio group by cue_id";
        
                      
        $resultado = Conexion::ejecutarQuery($sql_val,array("anio"=>$this->soloanio));
            foreach($resultado as $row){
                $arre_resultado[$row["cue_id"]]=array($row["asignados"],$row["equipos"]);
             
            }
        //    var_dump($arre_resultado);
            //consulta para num. de inspecciones
            
         $sql_ins=" SELECT
 sum(IF(ide_numseccion IS NOT NULL,1,0) ) as tam_muestra,cue_id, cue_descripcion
  
 FROM
ins_generales
INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
     INNER JOIN ca_cuentas ON 
          ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
 LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` 
AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=8
 AND `ide_numreactivo`=0
  AND `ide_numcomponente`=2
  AND `ide_numcaracteristica1`=0
  AND `ide_numcaracteristica2`=0
  AND `ide_numcaracteristica3`=6
  AND `ide_numrenglon`=1 /*AND i_finalizado=1*/
where
i_claveservicio =:servicio";

      

        $sql_ins.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$this->fmes_consulta'


        and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$this->mes_consulta_ant'";

       
        if(isset($this->filx["edo"])&&$this->filx["edo"]!="")
        {  $sql_ins.=" and ca_unegocios.une_cla_estado=".$this->filx["edo"];
        }

        if(isset($this->filx["ciu"])&&$this->filx["ciu"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_ciudad=".$this->filx["ciu"];
        }
        if(isset($this->filx["niv6"])&&$this->filx["niv6"]!="")
        {   $sql_ins.=" and ca_unegocios.une_cla_franquicia=".$this->filx["niv6"];
        }
      
        $parametros = array("servicio" =>$this->servicio);
         
        $sql_ins.=" group by cue_id";
       
        $result = Conexion::ejecutarQuery($sql_ins,$parametros);
       
        if ($result) {
            foreach ($result as $rowt) {
              $arre_resultado2[$rowt["cue_id"]]= array($rowt ["cue_descripcion"],$rowt ["tam_muestra"]);
              $this->chart ["dona"][] =array($rowt ["cue_descripcion"],$rowt ["tam_muestra"]); 
            }
          
        }
//          echo "<pre>";
//        print_r($this->chart["dona"] );
//        echo "</pre>";
      // var_dump($arre_resultado2);
        //armo el arreglo para las barras
        foreach($arre_resultado as $key=>$cuenta){
         
          if($arre_resultado2[$key][0]){
            $val=$arre_resultado2[$key][1]==null?0:$arre_resultado2[$key][1];
            $this->chart["barras"][]= array($arre_resultado2[$key][0],$val ,$cuenta[0],$cuenta[1]);
          }
        }
//          echo "<pre>";
//        print_r($this->chart["barras"] );
//        echo "</pre>";
}



    public function mostarGrafica()
    {
           $grupo = $_SESSION["GrupoUs"];
           // die("yo".$_SESSION["fniv"]);
           if(isset($_SESSION["fniv"]))
               $nivel= $_SESSION["fniv"];
         //  echo "++++".$nivel;
        if ($this->tipo == "Cob") {
         $this->consultarCobertura();
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

