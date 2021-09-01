<?php

include "Controllers/indpostmix/resumenResultadosController.php";


include 'Controllers/indpostmix/tablaDinamicaController.php';

/***** clase para hacer las consultas de indicadores para las graficas*/
class Graficajson {

    public $titulo;
    public $tipo;
    public $filnivel;
    // llega en la forma 1.2.3.4.5.6
    public $filcuenta;
    // llega en la forma 1.2.3
    public $seccion;
    // llega en la forma [1.2.3,2.3.4]
    public $filperiodo;
    // llega en la forma mes.anio
    public $chart;
    public $nivel;
    public $servicio;
    private $colores;
    private $grupocolores;
    // array con los datos para json
    public function __construct() {
        $this->colores=array("#7FFF00","#9ACD32","#FFA07A","#008080","#00FFFF","#778899",
            "#4169E1","#20B2AA","#DCDCDC","#ADFF2F","#CD5C5C","#FF4500","#1E90FF");
      $this->blue=array("#00CED1","#1E90FF","#B0C4DE","#7B68EE","#7FFFD4","#00BFFF","#20B2AA","#4169E1","#008080","#48D1CC","#00CED1","#1E90FF");
     
      $this->grupocolores=array("#FFC000",'#1382AC',
           "#318B71",
             "#952B51",
             
             "#a6a6a6","#A0522D" ,"#C0C0C0","#87CEEB","#6A5ACD",'#8B4513',
           "#FA8072",
             "#F4A460",
             "#2E8B57",
             "#FFF5EE","#A0522D" );
       
    }
    
  
/****leer los filtros que vienen de la url******/
    public function leerFiltros() {
        //  $seccion = filter_input(INPUT_GET,"sec",FILTER_SANITIZE_NUMBER_INT);
//$nivel = filter_input(INPUT_GET,"niv",FILTER_SANITIZE_NUMBER_INT);

        $gfilx = filter_input(INPUT_GET, "filx", FILTER_SANITIZE_SPECIAL_CHARS);

        $this->filcuenta = filter_input(INPUT_GET, "fily", FILTER_SANITIZE_SPECIAL_CHARS);
        $gfiluni = filter_input(INPUT_GET, "filuni", FILTER_SANITIZE_SPECIAL_CHARS);
        if ($gfiluni == "") {
            $gfiluni = "1.1";
        }
        $this->filnivel = $gfiluni . "." . $gfilx;
      //  echo $this->filnivel."****************";
        $this->filperiodo = filter_input(INPUT_GET, "mes", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->tipo = filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->servicio = 1;
    }

 /**************funcion principal que  selecciona el tipo de consulta
  * y genera el json*********/

    public function generarJSON() {

        if ($this->tipo == "E") {
            $seccion = array("8", "5","6");
            $this->consultarBDEstandar($seccion);
        }
        //las secciones son ponderadas a menos que se indique lo contrario
        //arreglo para agregar las secciones que aparecen en la barras horizontales
        //se ponen de la forma seccion.reactivo, tiposeccion
        if ($this->tipo == "S") {
            $secciones = array(["2.10"],
                ["2.11"],
                ["2.8"],
                ["2.8.1", "EV"],
                ["3.11", ""],
                ["3.13", ""],
                ["3.15", ""],
                ["3.8.1.0.0.1", "A"],
                ["2.15"],
                ["3.12", ""]
            );
            $this->consultarBDServicio($secciones);
        }
        if ($this->tipo == "O") {
            $secciones = array(["2.9"],
            /*    ["3.8.1.0.0.1", "A"],*/
                ["2.7"],
                ["2.6"],
                ["3.20", ""],
                ["3.23", ""],
                ["3.19", ""]
            );
            $this->consultarBDServicio($secciones);
        }
        if ($this->tipo == "IC") {
            $secciones = array(["2.17"],
                ["4.13"],
                ["2.14"],
                ["3.3"],
                ["3.6", ""],
                ["2.3"],
                ["2.4"],
                ["3.4"]
            );
            $this->consultarBDServicio($secciones);
        }
          if ($this->tipo == "IG") {
            $secciones = array(
                ["3.1", ""],
                ["2.13"],
               
               /* ["3.3"],
                 ["3.4"],
                  ["3.6"],*/
                ["6,7", "V"],
                ["3.9", ""],
                ["4.3"],
                 ["4.4"],
                 ["4.7"],
                 ["4.12"],
                ["4.16", ""],
                ["4.10", ""],
            );
            $this->consultarBDServicio($secciones);
        }
       $auxp = explode('.', $this->filperiodo);
       $mes = $auxp[0];
        if ($mes - 6 >= 0) { // calculo para los 6m
            $z = $mes - 6 + 1;

            $mes_pivote = $auxp[1] . "-" . $z . "-01";
        } else {
            $z = 7 + $mes;

            $mes_pivote = ($auxp[1] - 1) . "-" . $z . "-01";
        }
        $fecha_consulta_fin = $auxp[1] . "-" . $auxp[0] . "-01"; //fecha final
        $fecha_consulta_ini = ($auxp[1] - 1) . "-" . $auxp[0] . "-01"; //fecha inicial
        
         if ($this->tipo == "DetN") {
            $secciones = filter_input(INPUT_GET, "ref", FILTER_SANITIZE_SPECIAL_CHARS);
          
            $this->compararxNivel($secciones,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote);
        }
         if ($this->tipo == "DetM") {
            $secciones = filter_input(INPUT_GET, "ref", FILTER_SANITIZE_SPECIAL_CHARS);
             
            $this->compararxCuenta($secciones,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote);
      //      echo "fin aqui";
        }
        if ($this->tipo == "H") {
            $secciones = filter_input(INPUT_GET, "ref", FILTER_SANITIZE_SPECIAL_CHARS);
             //   $this->filperiodo = filter_input(INPUT_GET, "mes_fin", FILTER_SANITIZE_SPECIAL_CHARS);
            $this->historicoxIndicador($secciones);
      //      echo "fin aqui";
        }
          if ($this->tipo == "RR") {
              $seccion = filter_input(INPUT_GET, "ref", FILTER_SANITIZE_SPECIAL_CHARS);
              
            $this->compararR1vsR2($seccion);
          //  echo "fin aqui";
        }

        echo  json_encode($this->chart);
    }

    /*************** para consultas de tipo estandar
     * hace al mismo tiempo la de agua y bebidas y las pone en un mismo arreglo que se dividirá en la vista
     * llegan las secciones en un arreglo
     */
    public function consultarBDEstandar($seccion) {

        $usuario = $_SESSION["UsuarioInd"];

        $aux = explode('.', $this->filperiodo);
        $mes = $aux[0];
        if ($mes - 6 >= 0) { // calculo para los 6m
            $z = $mes - 6 + 1;

            $mes_pivote = $aux[1] . "-" . $z . "-01";
        } else {
            $z = 7 + $mes;

            $mes_pivote = ($aux[1] - 1) . "-" . $z . "-01";
        }
        $fmes_consulta = $aux[1] . "-" . $aux[0] . "-01"; //fecha final
        $mes_consulta_ant = ($aux[1] - 1) . "-" . $aux[0] . "-01"; //fecha inicial
        $listasec = "";
        foreach ($seccion as $opcion) {
            $listasec .= $opcion . " ,";
        }
      
        //  $result = DatosEst::consultaGraficaIndicador($this->servicio, $this->seccion, $filx, null, $filuni, $fmes_consulta, $mes_consulta_ant);
        $result = DatosEst::consultaGraficaCumplimientotmp($listasec, $this->servicio, $usuario, $fmes_consulta, $mes_consulta_ant, $mes_pivote);
  
        $matriz=array();
        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            foreach ($result as $row) {

                $periodo = $acept = $acumtot = 0;


                if ($_SESSION["idiomaus"] == 2) {
                    $nomseccion = $row["red_parametroing"];
                } else {
                    $nomseccion = $row["red_parametroesp"];
                }
                $estandar = $row["red_estandar"];
                $matriz[$nomseccion]["datos"] =$row["refer"];
                
                if ($row["mes"] == 1) {
                    $periodo = 1;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$nomseccion][$periodo]["acep"] +=$acept;

                    $matriz[$nomseccion][$periodo]["tot"] +=$acumtot;
                }


                if ($row["6mes"] == 2) {
                    $periodo = 2;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$nomseccion][$periodo]["acep"] +=$acept;
                    $matriz[$nomseccion][$periodo]["tot"] +=$acumtot;
                }
                if ($row["12mes"] == 3) {
                    $periodo = 3;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$nomseccion][$periodo]["acep"] +=$acept;
                    $matriz[$nomseccion][$periodo]["tot"] +=$acumtot;
                }
                $matriz[$nomseccion]["sec"] = $row["seccion"];
//   echo "<br>*************************<br>";
//                var_dump($matriz);
                //voy formando el arreglo de la forma [idicador][estandar][periodo][aceptados][total]
                //$total_cuen[$cuenta][$periodo]["acep"]+=$acept;
                //$total_cuen[$cuenta][$periodo]["tot"]+=$acumtot;
            }
            //inicializo
            //	$totalreg[$region][$periodo]["tot"] = 0;
            //	$totalreg[$region][$periodo]["acep"] = 0;
//                echo "*************************<br>";
              //  var_dump($matriz);
            $secc_ant = "";
            $j =$l= 0;
            $k=1;
            foreach ($matriz as $key => $rowt) {

                $secc_actual = $key;
                //   print_r($secc_actual."<br>");
                  if($secc_actual!=$secc_ant){
                      
                  }
                $this->chart[$rowt["sec"]][$j] = array($secc_actual, $rowt["datos"]);
                $m=7; //auxiliar para guardar los totales
                for ($i = 1; $i < 4; $i++) {
                    if (isset($rowt[$i]) && $rowt[$i]["tot"] != 0)
                        $this->chart[$rowt["sec"]][$j][$i + 1] = Utilerias::redondear2($rowt[$i]["acep"] / $rowt[$i]["tot"]*100, 1);
                    else
                        $this->chart[$rowt["sec"]][$j][$i + 1] = 0;
                   $this->chart[$rowt["sec"]][$j][$i+$m]=$rowt[$i]["tot"] ;
                   $m++;
                   $this->chart[$rowt["sec"]][$j][$i+$m]=$rowt[$i]["acep"];
                   
                        
                }
                 //    $res[$i]=$this->colores[$k]." 0.4";
//                 $res[5]=$this->colores[$k]." 0.7";
//                 $res[6]=$this->colores[$k++];
              //   echo "--".$rowt["sec"];
                   //pongo colores
                if($rowt["sec"]==5)
                {
                       $this->chart[$rowt["sec"]][$j][$i + 1] = $this->blue[$l];
                        $this->chart[$rowt["sec"]][$j][6] = $this->blue[$l]." 0.7";
                        $this->chart[$rowt["sec"]][$j][7] = $this->blue[$l++]." 0.4";
                    
                }else{
                        $this->chart[$rowt["sec"]][$j][$i + 1] = $this->grupocolores[$k];
                      //  echo "<br>******".$rowt["sec"]."--".$this->grupocolores[$k]."--".$k;
                        $this->chart[$rowt["sec"]][$j][6] = $this->grupocolores[$k]." 0.7";
                        $this->chart[$rowt["sec"]][$j][7] = $this->grupocolores[$k++]." 0.4";
                }    
                  
               
                //}
                $secc_ant = $secc_actual;
                $j++;
            }
            //busco la seccion 6 y 7 para ponerla con la 8
           
            $this->chart[8][$j] = $this->cumplimientoProducto($mes_consulta_ant, $mes_pivote, $fmes_consulta, $usuario);
           
//             echo "*************************<pre>";
//            print_r($this->chart); echo "</pre>";
//            die();
//                $this->chart[] = array(
//                    $rowt[$campo],
//                    $rowt["red_estandar"],
//                    Utilerias::redondear($rowt["nivaceptren"] ),
//                    $rowt["refer"]
//                );
            // echo "*************".htmlentities(str_replace("&deg;","º",$rowt["red_estandar"]), ENT_COMPAT ,"ISO-8859-1") ;
            // echo "--".$refer[];
            // echo "<br>val ".$rowt["i_fechavisita"];
        } else { // sino ponemos un valor por omision para que no marque error
            // echo "default";
            // $this->chart [ ]=null;
            $this->chart["error"] = T_("No hay datos suficientes para generar la grafica");
        }
    }

//     public function consultarBDPonderada() {
//         $usuario = $_SESSION["UsuarioInd"];

//         $listasec = "";
//         foreach ($this->seccion as $opcion) {
//             $listasec .= $opcion . " ,";
//         }
//         $result = DatosPond::graficaCumplimiento($listasec, $this->servicio, $usuario);




//         if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
//             if ($_SESSION["idiomaus"] == 2)
//                 $campo = "r_descripcioning";
//             else
//                 $campo = "r_descripcionesp";
//             foreach ($result as $rowt) {

//                 $this->chart[] = array(
//                     $rowt[$campo],
//                     "",
//                     Utilerias::redondear($rowt["nivaceptren"]),
//                     $rowt["ref"]);
//             }
//         } else { // sino ponemos un valor por omision para que no marque error
//             // echo "default";
//             // $this->chart [ ]=null;
//             $this->chart["error"] = T_("No hay datos suficientes para generar la grafica");
//         }
//     }

//     public function consultarBDInocuidad($seccionprod) {
//         $usuario = $_SESSION["UsuarioInd"];

//         //empiezo con las ponderadas
//         $listasec = "";
//         foreach ($this->seccion as $opcion) {
//             $listasec .= $opcion . " ,";
//         }
//         $result = DatosPond::graficaCumplimiento($listasec, $this->servicio, $usuario);

//         if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
//             if ($_SESSION["idiomaus"] == 2)
//                 $campo = "r_descripcioning";
//             else
//                 $campo = "r_descripcionesp";
//             foreach ($result as $rowt) {

//                 $this->chart[] = array(
//                     $rowt[$campo],
//                     "",
//                     Utilerias::redondear($rowt["nivaceptren"]),
//                     $rowt["ref"]
//                 );
//             }
//         } else { // sino ponemos un valor por omision para que no marque error
//             // echo "default";
//             // $this->chart [ ]=null;
//             $this->chart["error"] = T_("No hay datos suficientes para generar la grafica");
//             return;
//         }
//         //seccion de jarabes
//         $result = DatosProducto::consultaGraficaCumplimiento($seccionprod, $this->servicio, $usuario);
//         if ($_SESSION["idiomaus"] == 2)
//             $campo = "sec_descripcioning";
//         else
//             $campo = "sec_descripcionesp";
//         foreach ($result as $rowt) {

//             $this->chart[] = array(
//                 $rowt[$campo],
//                 "",
//                 Utilerias::redondear($rowt["NIVELACEPTACION"]),
//                 $rowt["sec"]
//             );
//         }
//     }

    public function consultarBDServicio($secciones) {
        $usuario = $_SESSION["UsuarioInd"];
       
       // var_dump($secciones);
        //empiezo con las ponderadas
        $listasecp = $listaseca =$seccionj= "";
        foreach ($secciones as $opcion) {
            if (!empty($opcion[1])&&$opcion[1]=="A")
                $listaseca .= $opcion[0] . ",";
            else
           if (!empty($opcion[1])&&$opcion[1]=="V")
                $seccionj .= "".$opcion[0] . ",";
           else   if (!empty($opcion[1])&&$opcion[1]=="EV")
                $seccionev=$opcion[0];
           
            else
                $listasecp .= "'".$opcion[0] . "',";
        }
      //  var_dump($listasecp);
     //   die();
        $aux = explode('.', $this->filperiodo);
        $mes = $aux[0];
        if ($mes - 6 >= 0) { // calculo para los 6m
            $z = $mes - 6 + 1;
            
            $mes_pivote = $aux[1] . "-" . $z . "-01";
        } else {
            $z = 7 + $mes;
            
            $mes_pivote = ($aux[1] - 1) . "-" . $z . "-01";
        }
        $fmes_consulta = $aux[1] . "-" . $aux[0] . "-01"; //fecha final
        $mes_consulta_ant = ($aux[1] - 1) . "-" . $aux[0] . "-01"; //fecha inicial
        $result = DatosPond::graficaCumplimientoMensual($listasecp, $this->servicio, $usuario,$fmes_consulta);
        $resultadosp=$resultadosa=$resultadosj=array();
        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            if ($_SESSION["idiomaus"] == 2)
                $campo = "r_descripcioning";
            else
                $campo = "r_descripcionesp";
            foreach ($result as $rowt) {
                $resultadosp[$rowt["ref"]]= array($rowt[$campo],
                    "",
                    Utilerias::redondear2($rowt["nivaceptren"],1),
                    $rowt["total"] ,$rowt["pasa"]
                    
                    
                );
               
            }
        } else { // sino ponemos un valor por omision para que no marque error
            // echo "default";
            // $this->chart [ ]=null;
            $this->chart["error"] = T_("No hay datos suficientes para generar la grafica");
            return;
        }
        
        //seccion abierta
        if(!empty($listaseca)){
           //  echo "**********************";
            // die($listaseca);
            $resultab = DatosAbierta::consultaGraficaCumplimientoCatalgoMensual($usuario, $this->servicio,substr($listaseca,0,strlen($listaseca)-1),">25" ,$fmes_consulta);
            if ($_SESSION["idiomaus"] == 2)
                $campo = "rad_descripcioning";
            else
                $campo = "rad_descripcionesp";

            foreach ($resultab as $rowt) {

                $resultadosa[ $rowt["refer"]] = array(
                    $rowt[$campo],
                    ">25",
                    Utilerias::redondear2($rowt["nivaceptren"],1),
                    $rowt["total"],$rowt["pasa"]
                    
                );
            }
          }
          
        if(!empty($seccionj)){
            $resultj = DatosProducto::consultaGraficaCumplimientoMensual($seccionj, $this->servicio, $usuario,$fmes_consulta);
           // var_dump($resultj);
           
               if ($_SESSION["idiomaus"] == 2)
            $campo = "sec_descripcioning";
        else
            $campo = "sec_descripcionesp";
        foreach ($resultj as $rowt) {

            $resultadosj["6,7"] = array(
                $rowt[$campo],
                ">25",
                Utilerias::redondear2($rowt["NIVELACEPTACION"],1),
                $rowt["total"], $rowt["pasa"]
                
            );
        }
        }
        //para la seccion de manometros
          if(!empty($seccionev)){
            

              $resultadosev[$seccionev] =$this->consultarEstandarVariasSecc($seccionev, $usuario,$fmes_consulta);
        
        }
       //s var_dump( $resultadosev[$seccionev]);
//        var_dump($resultadosp);
//        die();
             //  var_dump($resultadosj);
       
        //acomodo arreglo
         foreach ($secciones as $opcion) {
            
             if (!empty($opcion[1])&&$opcion[1]=="A"&& !empty( $resultadosa[$opcion[0]]))
                //busco en los abiertos 
                $this->chart[] = $resultadosa[$opcion[0]];
             
            else
                if (!empty($opcion[1])&&$opcion[1]=="V"&& !empty( $resultadosj[$opcion[0]]))
                  $this->chart[] = $resultadosj[$opcion[0]];
             
                  else  if (!empty($opcion[1])&&$opcion[1]=="EV"&& !empty( $resultadoev[$opcion[0]]))
                  $this->chart[] = $resultadosev[$opcion[0]];
             
                  else if(!empty( $resultadosp[$opcion[0]]))
                   $this->chart[] = $resultadosp[$opcion[0]];
             
          
         }
//         echo "<pre>";
//         print_r($this->chart);
//         echo "</pre>";
    }

    function consultarEstandarVariasSecc($seccion,$usuario,$mesfinal){
       $reactivos = $this->ConsultaAtributos($seccion);
       //falta buscar el nombre
      $row= DatosEst::vistaNomSecEstandar($this->servicio,$seccion,"cue_reactivosestandar");
     
      $nombre=$row["re_descripcionesp"];
      
       //busca el cumplimiento de todos los reactivos  y los trae en un arreglo del tipo 
       //parametro, descripcion, estandar cumplimiento%, referencia de reactivo
      $resultados= $this->cumplimientoEstandarVariosReactivos($reactivos, $usuario,$mesfinal);
    
       //reviso cada
       //regreso el arreglo con la info
       return array($nombre,"",$resultados[0],$resultados[1],$resultados[2]);
    }
  
    /*****************
     * Consulta para la graf de comparación por nivel
     * Llega la fecha de inicio y fecha de fin como mm.yyyy
     * referencia: 1.2.3 seccion y reactivo
     * filx y fily como arreglo para los niveles y cuenta
     */
      function compararxNivel( $referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote) {
          //para los usuarios que no tienen definido un nivel
        if ($this->filnivel == ""||$this->filnivel == "1.1."||$this->filnivel == "1.1....") {
            $this->filnivel = "1.1.5";
        }
       
        $this->servicio = 1; // siempre es 1
        $aux = explode(".", $this->filnivel);
         $nivel=3;
        
        $filx = array();
      
        $filx["zon"] = $aux[2];
     
        
       
        $filx["edo"] = $aux[3];
        
        $filx["ciu"] = $aux[4];
        $filx["niv6"] = $aux[5];
      //  var_dump($aux);
        $auxy = explode(".", $this->filcuenta);
        
        $fily = array();
        
        $fily["cta"] = $auxy[0];
        $fily["fra"] = $auxy[1];
        $fily["pv"] = $auxy[2];
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
      
        // reviso el tipo de evaluacion
        $eval = TablaDinamicaController::consTipoEvaluacion(1, $referencia);
        if($seccion==5||$seccion==8){
        $sql = "SELECT
 
   ca_unegocios.cue_clavecuenta,
    ca_unegocios.une_cla_region,
ca_unegocios.une_cla_pais,
ca_unegocios.une_cla_zona,
ca_unegocios.une_cla_estado,
ca_unegocios.une_cla_ciudad,
ca_unegocios.une_cla_franquicia,
ca_unegocios.une_dir_idestado,
ca_unegocios.fc_idfranquiciacta,
ca_unegocios.une_id,

sum(if(ins_detalleestandar.ide_aceptado=-1,1,0)) AS pasa,
sum(1) as tot,
cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing,
cue_reactivosestandardetalle.red_estandar,
          if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')=:fmes_consulta,1,0) as mes,
       if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote 
 and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,
       if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta
       and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes,
    ca_nivel4.n4_id,
ca_nivel4.n4_nombre,";
          if (isset($filx["edo"]) && $filx["edo"] != "") {
            $sql .= " ca_nivel5.n5_nombre,";
         
          }
             if (isset($filx["ciu"]) && $filx["ciu"] != "") { 
         $sql .= "   ca_nivel6.n6_nombre,";
    
             }
               if (isset($filx["ciu"]) && $filx["ciu"] != "") { 
                    $sql .= "   ca_nivel6.n6_nombre,";
                  
             
               }
        $sql .= " str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') as fecha
, convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,  substring_index(i_mesasignacion,'.',-1) as anio_asig
FROM
ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
   AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica 
   AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2

Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id


   INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`";
     if (isset($filx["edo"]) && $filx["edo"] != "") {
            $sql .= " 
   INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad ";
     }
    if (isset($filx["ciu"]) && $filx["ciu"] != "") {
    $sql .= " INNER JOIN ca_nivel6 ON ca_nivel6.n6_id=ca_unegocios.une_cla_franquicia  ";
    }
        
  $sql .= " where ins_generales.i_claveservicio=:servicio ";
        $parametros["servicio"] = $this->servicio;
      //  $parametros["cliente"] = $this->cliente;
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= "  and     ca_unegocios.une_cla_zona=:zon";
            $parametros["zon"] = $filx["zon"];
               $nivel++;
        }
        //$sql .= " and ins_generales.i_mesasignacion =:mes_consulta 

        $sql .= " and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta
        
AND ide_valorreal<>'' 
    
and
ins_detalleestandar.ide_numseccion=:seccion and
ins_detalleestandar.ide_numreactivo=:reac and
ins_detalleestandar.ide_numcomponente=:com and
ins_detalleestandar.ide_numcaracteristica1=:carac1 and
ins_detalleestandar.ide_numcaracteristica2=:carac2 and
ins_detalleestandar.ide_numcaracteristica3=:carac3 ";
        $parametros["mes_consulta"] = $fecha_consulta_ini;
        $parametros["fmes_consulta"] = $fecha_consulta_fin;
        $parametros["mes_pivote"] = $mes_pivote;
        $parametros["seccion"] = $seccion;
        $parametros["reac"] = $reac;
        $parametros["com"] = $com;
        $parametros["carac1"] = $carac1;
        $parametros["carac2"] = $carac2;
        $parametros["carac3"] = $carac3;
        //validacion renglon
        if ($eval == 1) {
            $sql .= " and ide_numrenglon=1 ";
        }

        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
            $parametros["cta"] = $fily["cta"];
        }
        if (isset($filx["edo"]) && $filx["edo"] != "") {
            $sql .= " and ca_unegocios.une_cla_estado=:reg";
            $parametros["reg"] = $filx["edo"];
               $nivel++;
        }
        if (isset($filx["ciu"]) && $filx["ciu"] != "") {
            $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
            $parametros["ciu"] = $filx["ciu"];
               $nivel++;
        }
        if (isset($filx["niv6"]) && $filx["niv6"] != "") {
            $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
            $parametros["niv6"] = $filx["niv6"];
        }
        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
            $parametros["fra"] = $fily["fra"];
        }
      
        $sql .= " GROUP BY";
//if($es_cuenta)
//    
// $sql .=" ca_unegocios.cue_clavecuenta ";
     
            $sql .= "   ca_unegocios.une_cla_estado";
        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql .= " ,ca_unegocios.fc_idfranquiciacta";
     
        if (isset($filx["edo"]) && $filx["edo"] != "")
            $sql .= " ,ca_unegocios.une_cla_ciudad";
        if (isset($filx["ciu"]) && $filx["ciu"] != "")
            $sql .= " ,ca_unegocios.une_cla_franquicia";
        if ((isset($fily["fra"]) && $fily["fra"] != ""))
            $sql .= " ,une_id";
 
        $sql .= ",mes, 6mes,12mes order by ";
//        if($es_cuenta)
//    
// $sql .=" ca_unegocios.cue_clavecuenta,";

 $sql .=" ca_unegocios.une_cla_estado, anio_asig desc, mes_asig desc";
 
        }
        if($seccion==6){
 //para jarabes seccion 6 
 
 $sql_reporte_e = "SELECT
 ca_unegocios.cue_clavecuenta,
    ca_unegocios.une_cla_region,
ca_unegocios.une_cla_pais,
ca_unegocios.une_cla_zona,
ca_unegocios.une_cla_estado,
ca_unegocios.une_cla_ciudad,
ca_unegocios.une_cla_franquicia,
ca_unegocios.une_dir_idestado,
ca_unegocios.fc_idfranquiciacta,
ca_unegocios.une_id,
SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,
     
(SUM(`ins_detalleproducto`.`ip_numcajas`)) AS tot,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc,
  if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')=:fmes_consulta,1,0) as mes,
       if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote 
 and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,
       if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
       and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes,
    ca_nivel4.n4_id,
ca_nivel4.n4_nombre ";
          if (isset($filx["edo"]) && $filx["edo"] != "") {
              $sql_reporte_e .= " ,ca_nivel5.n5_nombre ";
         
          }
             if (isset($filx["ciu"]) && $filx["ciu"] != "") { 
                 $sql_reporte_e .= "   ,ca_nivel6.n6_nombre ";
    
             }
               if (isset($filx["ciu"]) && $filx["ciu"] != "") { 
                   $sql_reporte_e .= "   ,ca_nivel6.n6_nombre";
                  
             
               }
               $sql_reporte_e.=" FROM
ins_detalleproducto

Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
   Inner Join ins_generales ON ins_detalleproducto.ip_claveservicio = ins_generales.i_claveservicio 
AND ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id


   INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`";
     if (isset($filx["edo"]) && $filx["edo"] != "") {
           $sql_reporte_e .= " 
   INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad ";
     }
    if (isset($filx["ciu"]) && $filx["ciu"] != "") {
        $sql_reporte_e .= " INNER JOIN ca_nivel6 ON ca_nivel6.n6_id=ca_unegocios.une_cla_franquicia  ";
    }
        
    $sql_reporte_e .= " where ins_generales.i_claveservicio=:servicio ";
        $parametros["servicio"] = $this->servicio;
      //  $parametros["cliente"] = $this->cliente;
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql_reporte_e .= "  and     ca_unegocios.une_cla_zona=:zon";
            $parametros["zon"] = $filx["zon"];
               $nivel++;
        }  
        $sql_reporte_e.=" and
	 ins_detalleproducto.ip_numseccion in (6,7)
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null) 

    and ins_detalleproducto.ip_claveservicio=:servicio
";
        
        $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
        $parametros["fmes_consulta"] = $fecha_consulta_fin;
        $parametros["mes_pivote"] = $mes_pivote;
       
        //validacion renglon
        
        
        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql_reporte_e .= " and ca_unegocios.cue_clavecuenta=:cta";
            $parametros["cta"] = $fily["cta"];
        }
        if (isset($filx["edo"]) && $filx["edo"] != "") {
            $sql_reporte_e .= " and ca_unegocios.une_cla_estado=:reg";
            $parametros["reg"] = $filx["edo"];
            $nivel++;
        }
        if (isset($filx["ciu"]) && $filx["ciu"] != "") {
            $sql_reporte_e .= " and ca_unegocios.une_cla_ciudad=:ciu";
            $parametros["ciu"] = $filx["ciu"];
            $nivel++;
        }
        if (isset($filx["niv6"]) && $filx["niv6"] != "") {
            $sql_reporte_e .= " and ca_unegocios.une_cla_franquicia=:niv6";
            $parametros["niv6"] = $filx["niv6"];
        }
        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql_reporte_e .= " and ca_unegocios.fc_idfranquiciacta=:fra";
            $parametros["fra"] = $fily["fra"];
        }
        
        $sql_reporte_e .= " GROUP BY";
        //if($es_cuenta)
            //
            // $sql .=" ca_unegocios.cue_clavecuenta ";
        
        $sql_reporte_e .= "   ca_unegocios.une_cla_estado";
        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql_reporte_e .= " ,ca_unegocios.fc_idfranquiciacta";
            
            if (isset($filx["edo"]) && $filx["edo"] != "")
                $sql_reporte_e .= " ,ca_unegocios.une_cla_ciudad";
                if (isset($filx["ciu"]) && $filx["ciu"] != "")
                    $sql_reporte_e .= " ,ca_unegocios.une_cla_franquicia";
                    if ((isset($fily["fra"]) && $fily["fra"] != ""))
                        $sql_reporte_e .= " ,une_id";
                        
                        $sql_reporte_e .= ",mes, 6mes,12mes order by ";
                        //        if($es_cuenta)
                            //
                            // $sql .=" ca_unegocios.cue_clavecuenta,";
                        
                        $sql_reporte_e .=" ca_unegocios.une_cla_estado ";
        $sql=$sql_reporte_e;
        }

        $rs = Conexion::ejecutarQuery($sql, $parametros);
      
        $campNivel[2] = "une_cla_pais";
        $campNivel[3] = "une_cla_zona";
        $campNivel[4] = "n4_nombre";
        $campNivel[5] = "n5_nombre";
        $campNivel[6] = "n6_nombre";
        $campGrup["C"] = "cue_clavecuenta";
        $campGrup["F"] = "fc_idfranquiciacta";
        $campGrup["P"] = "une_id";
        $campGrup["PP"] = "une_id";
       
        $acumtot = 0;
      
        $total = array();
      

        $matriz=array();
        if (sizeof($rs) > 0) {
            foreach ($rs as $row) {
             
                $region = $row[$campNivel[$nivel]]; //ser� eje x
//                if($es_cuenta){
//                   $region = $row[$campGrup[$nivel]];
//                }
                $acept = $row["pasa"];
                $acumtot = $row["tot"];
                
                  // echo "ss".$region;
                   if ($row["mes"] == 1) {
                    $periodo = 1;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$region][$periodo]["acep"] +=$acept;

                    $matriz[$region][$periodo]["tot"] +=$acumtot;
                    $matriz["total"][$periodo]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                     $matriz["total"][$periodo]["tot"] += $acumtot;
                }


                if ($row["6mes"] == 2) {
                    $periodo = 2;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$region][$periodo]["acep"] +=$acept;
                    $matriz[$region][$periodo]["tot"] +=$acumtot;
                      $matriz["total"][$periodo]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                     $matriz["total"][$periodo]["tot"] += $acumtot;
                }
                if ($row["12mes"] == 3) {
                    $periodo = 3;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$region][$periodo]["acep"] +=$acept;
                    $matriz[$region][$periodo]["tot"] +=$acumtot;
                      $matriz["total"][$periodo]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                     $matriz["total"][$periodo]["tot"] += $acumtot;
                }
              
//     
            }//termino de llenar la matriz, lo paso al arreglo del json
//             echo "<pre>";
//      var_dump($matriz);
//       echo "</pre>";
              $val1=$val2=$val3=0;
        //paso al erreglo para las gráficas
        if (isset($matriz["total"][1]["tot"]) && $matriz["total"][1]["tot"]!= 0)
              $val1=Utilerias::redondear2($matriz["total"][1]["acep"]/  $matriz["total"][1]["tot"]*100,1);
        if (isset($matriz["total"][2]["tot"]) && $matriz["total"][2]["tot"]!= 0)
              $val2=Utilerias::redondear2($matriz["total"][2]["acep"]/  $matriz["total"][2]["tot"]*100,1);
       
        if (isset($matriz["total"][3]["tot"]) && $matriz["total"][3]["tot"]!= 0)
              $val3=Utilerias::redondear2($matriz["total"][3]["acep"]/  $matriz["total"][3]["tot"]*100,1);
       
              $j =$k= 0;
        $this->chart[]=array("TOTAL","",$val1,
     
        $val2,
        $val3
                ,  $this->colores[$k],$this->colores[$k]." 0.7",$this->colores[$k++]." 0.4",
            $matriz["total"][1]["tot"],$matriz["total"][1]["acep"],
            $matriz["total"][2]["tot"],$matriz["total"][2]["acep"],
           $matriz["total"][3]["tot"],$matriz["total"][3]["acep"],
            
            
        );
           
            foreach ($matriz as $key => $rowt) {
                if($key=="total") continue;
               $res= array($key,"");
             $m=7; //auxiliar para totales
                for ($i =1; $i < 4; $i++) {
                    
                    if (isset($rowt[$i]) && $rowt[$i]["tot"] != 0)
                    {    $res[$i+1]= Utilerias::redondear2($rowt[$i]["acep"] / $rowt[$i]["tot"]*100, 2);
                        
                    }
                    else
                        $res[$i+1] = 0;
                    //para num de pruebas y resultados aprobados
                        $res[$i+$m]= $rowt[$i]["tot"];
                        $m++;
                        $res[$i+$m]= $rowt[$i]["acep"];
                        
                   
                }
                 
                 $res[$i+1]=$this->colores[$k];
                 $res[6]=$this->colores[$k]." 0.7";
                 $res[7]=$this->colores[$k++]." 0.4";
              //   echo "<br>******".$rowt["sec"]."--".$this->colores[$k]."--".$k;
                //    $this->chart[$rowt["sec"]][$j][$i + 1] = ;
                    
                 $this->chart[] =$res;
                
                //}
//                $secc_ant = $secc_actual;
//                $j++;
            }
        }
       //  var_dump($this->chart);
       // $edition = array_column(  $this->chart, 0);
        //uso otro arreglo para ordenar de mayor a menor
      $volumen  = array_column(  $this->chart, 2);
      //var_dump($volumen);
        //echo "<br>***********";
        // Ordenar los datos con % descendente
        array_multisort($volumen, SORT_DESC,$this->chart);  
        //agrego el total
//        array_unshift($this->chart,["TOTAL",$val1,
//     
//        $val2,
//        $val3,$this->colores[3],$this->colores[3]." 0.7",$this->colores[3]." 0.4"]
//                //,  $this->colores[5]." 0.4",$this->colores[5]." 0.7",$this->colores[5]
//     );
    //   array_multisort($this->chart[1] );
     //  echo "<pre>";
    //  var_dump($this->chart);
        //  var_dump($matriz);
     //   echo "</pre>";
      //die();
       // 
   
        
        
    }
     /*****************
     * Consulta para la graf dec omparación por cuenta
     * Llega la fecha de inicio y fecha de fin y pivote como yyyy-mm-dd
     * referencia: 1.2.3 seccion y reactivo
     * filx y fily como arreglo para los niveles y cuenta
     */
    
     function compararxCuenta ($referencia,$fecha_consulta_ini,$fecha_consulta_fin, $mes_pivote) {
        if ($this->filnivel == "") {
            $this->filnivel = "1.1";
        }
       // die($this->filnivel);
        $this->servicio = 1; // siempre es 1
        $aux = explode(".", $this->filnivel);
      
        $filx = array();
      
        $filx["zon"] = $aux[2];
     
        
       
        $filx["reg"] = $aux[3];
        
        $filx["ciu"] = $aux[4];
        $filx["niv6"] = $aux[5];
        $auxy = explode(".", $this->filcuenta);
        $nivel=0;
        if($auxy[0])
            $nivel=sizeof($auxy);
       
        $fily = array();
        
        $fily["cta"] = $auxy[0];
        $fily["fra"] = $auxy[1];
        $fily["pv"] = $auxy[2];
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        
      //  die(var_dump($filx));
      //  $fecha_consulta_fin = $auxp[1] . "-" . $auxp[0] . "-01";

        // reviso el tipo de evaluacion
        $eval = TablaDinamicaController::consTipoEvaluacion(1, $referencia);
        if($seccion==5||$seccion==8){
            $sql = "SELECT
     
       ca_unegocios.cue_clavecuenta,
        ca_unegocios.une_cla_region,
    ca_unegocios.une_cla_pais,
    ca_unegocios.une_cla_zona,
    ca_unegocios.une_cla_estado,
    ca_unegocios.une_cla_ciudad,
    ca_unegocios.une_cla_franquicia,
    ca_unegocios.une_dir_idestado,
    ca_unegocios.fc_idfranquiciacta,
     `ca_cuentas`.`cue_descripcion`,
    
    sum(if(ins_detalleestandar.ide_aceptado=-1,1,0)) AS pasa,
    sum(1) as tot,
    cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing,
    cue_reactivosestandardetalle.red_estandar,
        if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')=:fmes_consulta,1,0) as mes,
           if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote 
     and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,
           if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta
           and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes,
    ";
         
            $sql .= " str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') as fecha
    , convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,  substring_index(i_mesasignacion,'.',-1) as anio_asig
    FROM
    ins_detalleestandar
    Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
       AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica 
       AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
    
    Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
     INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id` 
    
    where ins_generales.i_claveservicio=:servicio ";
            $parametros["servicio"] = $this->servicio;
          //  $parametros["cliente"] = $this->cliente;
            if (isset($filx["zon"]) && $filx["zon"] != "") {
                $sql .= "  and     ca_unegocios.une_cla_zona=:zon";
                $parametros["zon"] = $filx["zon"];
            }
                 $sql .= " and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta
        
    AND ide_valorreal<>'' 
        
    and
    ins_detalleestandar.ide_numseccion=:seccion and
    ins_detalleestandar.ide_numreactivo=:reac and
    ins_detalleestandar.ide_numcomponente=:com and
    ins_detalleestandar.ide_numcaracteristica1=:carac1 and
    ins_detalleestandar.ide_numcaracteristica2=:carac2 and
    ins_detalleestandar.ide_numcaracteristica3=:carac3 ";
            $parametros["mes_consulta"] =$fecha_consulta_ini ;
            $parametros["fmes_consulta"] = $fecha_consulta_fin;
              $parametros["mes_pivote"] = $mes_pivote;
        
            $parametros["seccion"] = $seccion;
            $parametros["reac"] = $reac;
            $parametros["com"] = $com;
            $parametros["carac1"] = $carac1;
            $parametros["carac2"] = $carac2;
            $parametros["carac3"] = $carac3;
            //validacion renglon
            if ($eval == 1) {
                $sql .= " and ide_numrenglon=1 ";
            }
    
            if (isset($fily["cta"]) && $fily["cta"] != "") {
                $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
                $parametros["cta"] = $fily["cta"];
            }
            if (isset($filx["reg"]) && $filx["reg"] != "") {
                $sql .= " and ca_unegocios.une_cla_estado=:reg";
                $parametros["reg"] = $filx["reg"];
            }
            if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
                $parametros["ciu"] = $filx["ciu"];
            }
            if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
                $parametros["niv6"] = $filx["niv6"];
            }
            if (isset($fily["fra"]) && $fily["fra"] != "") {
                $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                $parametros["fra"] = $fily["fra"];
            }
          
            $sql .= " GROUP BY ca_unegocios.cue_clavecuenta ";
            
            if (isset($fily["cta"]) && $fily["cta"] != "")
                $sql .= " ,ca_unegocios.fc_idfranquiciacta";
         
          
    
            if ((isset($fily["fra"]) && $fily["fra"] != ""))
                $sql .= " ,une_id";
     
            $sql .= ",mes, 6mes,12mes order by  ca_unegocios.cue_clavecuenta";

        }
        if($seccion==6){
            //para jarabes seccion 6
            
            $sql_reporte_e = "SELECT
 ca_unegocios.cue_clavecuenta,
    ca_unegocios.une_cla_region,
ca_unegocios.une_cla_pais,
ca_unegocios.une_cla_zona,
ca_unegocios.une_cla_estado,
ca_unegocios.une_cla_ciudad,
ca_unegocios.une_cla_franquicia,
ca_unegocios.une_dir_idestado,
ca_unegocios.fc_idfranquiciacta,    `ca_cuentas`.`cue_descripcion`,
ca_unegocios.une_id,
SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,
                
(SUM(`ins_detalleproducto`.`ip_numcajas`)) AS tot,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc,
  if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')=:fmes_consulta,1,0) as mes,
       if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote
 and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,
       if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
       and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes
   ";
            if (isset($filx["reg"]) && $filx["reg"] != "") {
                $sql_reporte_e .= " ,ca_nivel5.n5_nombre ";
                
            }
            if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                $sql_reporte_e .= "   ,ca_nivel6.n6_nombre ";
                
            }
            if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                $sql_reporte_e .= "   ,ca_nivel6.n6_nombre";
                
                
            }
            $sql_reporte_e.=" FROM
ins_detalleproducto
                
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
   Inner Join ins_generales ON ins_detalleproducto.ip_claveservicio = ins_generales.i_claveservicio
AND ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
                
                
 INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id` 
    ";
          
            
            $sql_reporte_e .= " where ins_generales.i_claveservicio=:servicio ";
            $parametros["servicio"] = $this->servicio;
            //  $parametros["cliente"] = $this->cliente;
            if (isset($filx["zon"]) && $filx["zon"] != "") {
                $sql_reporte_e .= "  and     ca_unegocios.une_cla_zona=:zon";
                $parametros["zon"] = $filx["zon"];
                
            }
            $sql_reporte_e.=" and
	 ins_detalleproducto.ip_numseccion in (6,7)
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null)
                
    and ins_detalleproducto.ip_claveservicio=:servicio
";
            
            $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
            $parametros["fmes_consulta"] = $fecha_consulta_fin;
            $parametros["mes_pivote"] = $mes_pivote;
            
            //validacion renglon
            
            
            if (isset($fily["cta"]) && $fily["cta"] != "") {
                $sql_reporte_e .= " and ca_unegocios.cue_clavecuenta=:cta";
                $parametros["cta"] = $fily["cta"];
            }
            if (isset($filx["reg"]) && $filx["reg"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_estado=:reg";
                $parametros["reg"] = $filx["reg"];
               
            }
            
            if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_ciudad=:ciu";
                $parametros["ciu"] = $filx["ciu"];
               
            }
            if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_franquicia=:niv6";
                $parametros["niv6"] = $filx["niv6"];
            }
            if (isset($fily["fra"]) && $fily["fra"] != "") {
                $sql_reporte_e .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                $parametros["fra"] = $fily["fra"];
            }
            
            $sql_reporte_e .= " GROUP BY ca_unegocios.cue_clavecuenta ";
            
            if (isset($fily["cta"]) && $fily["cta"] != "")
                $sql_reporte_e .= " ,ca_unegocios.fc_idfranquiciacta";
                
                
                
                if ((isset($fily["fra"]) && $fily["fra"] != ""))
                    $sql_reporte_e .= " ,une_id";
                    
                    $sql_reporte_e .= ",mes, 6mes,12mes order by  ca_unegocios.cue_clavecuenta";
                            $sql=$sql_reporte_e;
        }
        

        $rs = Conexion::ejecutarQuery($sql, $parametros);
      
        $campGrup[0] = "cue_descripcion";
        $campGrup[1] = "fc_idfranquiciacta";
        $campGrup[2] = "une_id";
      
        $acumtot = 0;
      
        $total=$matriz=array();
        if (sizeof($rs) > 0) {
            foreach ($rs as $row) {
             
              
               $cuenta = $row[$campGrup[$nivel]];
                
                $acept = $row["pasa"];
                $acumtot = $row["tot"];
               
//                $matriz[$cuenta][$row["indica_mes"]]["acep"] = $acept;
//                $matriz[$cuenta][$row["indica_mes"]]["tot"] = $acumtot;
//                $total[$row["indica_mes"]]["acep"] += $acept;
//                         $total[$row["indica_mes"]]["tot"] += $acumtot;
//                         
                if ($row["mes"] == 1) {
                    $periodo = 1;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$cuenta][$periodo]["acep"] +=$acept;

                  $matriz[$cuenta][$periodo]["tot"] +=$acumtot;
                    $matriz["total"][$periodo]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                     $matriz["total"][$periodo]["tot"] += $acumtot;
                }


                if ($row["6mes"] == 2) {
                    $periodo = 2;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$cuenta][$periodo]["acep"] +=$acept;
                    $matriz[$cuenta][$periodo]["tot"] +=$acumtot;
                      $matriz["total"][$periodo]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                     $matriz["total"][$periodo]["tot"] += $acumtot;
                }
                if ($row["12mes"] == 3) {
                    $periodo = 3;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                    $matriz[$cuenta][$periodo]["acep"] +=$acept;
                    $matriz[$cuenta][$periodo]["tot"] +=$acumtot;
                      $matriz["total"][$periodo]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                     $matriz["total"][$periodo]["tot"] += $acumtot;
                }            

       //  echo   "<br>".$cuenta."..".$row["indica_mes"]."--". $total[$row["indica_mes"]]["tot"]."--".$acumtot;
           
            }
        }
//        $auxm=explode(".",$fecha_consulta_ini);
//        
//        //busco meses
//        $mesini=$auxm[0];
//          $auxm=explode(".",$fecha_consulta_fin);
//      
//        $mesfin=$auxm[0];
//       $this->chart["meses"]=array(Utilerias::cambiaMesG($mesini),Utilerias::cambiaMesG($mesfin));
//         echo "<pre>";
//         print_r($matriz);
//         echo "</pre>";
         $val1=$val2=$val3=0;
        //paso al erreglo para las gráficas
        if (isset($matriz["total"][1]["tot"]) && $matriz["total"][1]["tot"]!= 0)
              $val1=Utilerias::redondear2($matriz["total"][1]["acep"]/  $matriz["total"][1]["tot"]*100,1);
        if (isset($matriz["total"][2]["tot"]) && $matriz["total"][2]["tot"]!= 0)
              $val2=Utilerias::redondear2($matriz["total"][2]["acep"]/  $matriz["total"][2]["tot"]*100,1);
       
        if (isset($matriz["total"][3]["tot"]) && $matriz["total"][3]["tot"]!= 0)
              $val3=Utilerias::redondear2($matriz["total"][3]["acep"]/  $matriz["total"][3]["tot"]*100,1);
       
      
        $k=0;
        foreach($matriz as $key=>$renglon){
            if($key=="total") continue;
            $res= array($key,"");
            $l=7; //auxiliar para totales
                for ($i = 1; $i < 4; $i++) {
                    if (isset($renglon[$i]) && $renglon[$i]["tot"] != 0)
                       $res[$i+1]= Utilerias::redondear2($renglon[$i]["acep"] / $renglon[$i]["tot"]*100, 2);
                    else
                        $res[$i+1] = 0;
                    //para num de pruebas y resultados aprobados
                    $res[$i+$l]= $renglon[$i]["tot"];
                    $l++;
                    $res[$i+$l]= $renglon[$i]["acep"];
                        
                }
                 $res[$i+1]=$this->colores[$k];
                  
                 $res[6]=$this->colores[$k]." 0.7";
                 $res[7]=$this->colores[$k++]." 0.4";
                    
                 $this->chart[] =$res;
                
            
        }
        $this->chart[]=["TOTAL","",$val1,
     
        $val2,
        $val3,  $this->grupocolores[5],$this->grupocolores[5]." 0.7",$this->grupocolores[5]." 0.4",
           $matriz["total"][1]["tot"],$matriz["total"][1]["acep"],
           $matriz["total"][2]["tot"],$matriz["total"][2]["acep"],
           $matriz["total"][3]["tot"],$matriz["total"][3]["acep"],
            
            
            
    ]
                //,  $this->colores[5]." 0.4",$this->colores[5]." 0.7",$this->colores[5]
     ;
    //    var_dump($this->chart);
        //paso a otro arreglo para ordenar
        $volumen  = array_column(  $this->chart, 2);
      //var_dump($volumen);1
        //echo "<br>***********";
        // Ordenar los datos con % descendente
        array_multisort($volumen, SORT_DESC,$this->chart);  
        //agrego el total
       
    }
    
      function cumplimientoProducto($mes_consulta_ini,$mes_pivote, $mes_consulta_fin,$usuario) {
    	
        $sql_reporte_e = "SELECT
SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,

(SUM(`ins_detalleproducto`.`ip_numcajas`)) AS total,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc,
if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d')=:fmes_consulta,1,0) as mes,
       if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d') >=:mes_pivote
 and STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:fmes_consulta,2,0 ) as 6mes,
       if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d') >:mes_consulta_ant 
       and STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:fmes_consulta,3,0)  as 12mes
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion

WHERE
	 ins_detalleproducto.ip_numseccion in (6,7)
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null)  and tmp_estadistica.usuario=:usuario 
    and ins_detalleproducto.ip_claveservicio=:vserviciou
GROUP BY
mes, 6mes,12mes
ORDER BY `ins_detalleproducto`.`ip_numseccion` ASC, `ins_detalleproducto`.`ip_numreporte` ASC";
        $parametros = array("vserviciou" => $this->servicio,  "usuario" => $usuario);
     
        $parametros["mes_pivote"] = $mes_pivote;
                $parametros["fmes_consulta"] = $mes_consulta_fin;
        $parametros["mes_consulta_ant"] = $mes_consulta_ini;
        $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e, $parametros);
        $matriz=array();
          if (isset($rs_sql_reporte_e) && sizeof($rs_sql_reporte_e) > 0) { // si hay datos los despliegan
            foreach ($rs_sql_reporte_e as $row) {

                $periodo = $acept = $acumtot = 0;
                $nomseccion="jarabes";

               /* if ($_SESSION["idiomaus"] == 2) {
                    $nomseccion = $row["sec_descripcioning"];
                } else {
                    $nomseccion = $row["sec_descripcionesp"];
                }*/
                $estandar = $row["red_estandar"];
                $matriz[$nomseccion]["datos"] =$row["secc"];
                
                if ($row["mes"] == 1) {
                    $periodo = 1;
                    $acept = $row["pasa"];
                    $acumtot = $row["total"];
                    $matriz[$nomseccion][$periodo]["acep"] +=$acept;

                    $matriz[$nomseccion][$periodo]["tot"] +=$acumtot;
                }


                if ($row["6mes"] == 2) {
                    $periodo = 2;
                    $acept = $row["pasa"];
                    $acumtot = $row["total"];
                    $matriz[$nomseccion][$periodo]["acep"] +=$acept;
                    $matriz[$nomseccion][$periodo]["tot"] +=$acumtot;
                }
                if ($row["12mes"] == 3) {
                    $periodo = 3;
                    $acept = $row["pasa"];
                    $acumtot = $row["total"];
                    $matriz[$nomseccion][$periodo]["acep"] +=$acept;
                    $matriz[$nomseccion][$periodo]["tot"] +=$acumtot;
                }
        //        $matriz[$nomseccion]["sec"] = $row["seccion"];
//  echo "<br>*************************<br>";
//                var_dump($matriz);
                //voy formando el arreglo de la forma [idicador][estandar][periodo][aceptados][total]
                //$total_cuen[$cuenta][$periodo]["acep"]+=$acept;
                //$total_cuen[$cuenta][$periodo]["tot"]+=$acumtot;
            }
          }
      
            
           foreach ($matriz as $key => $rowt) {
                $k=7;//auxiliar para guardar los totales
              
                $resultados= array("FRESCURA DE JARABES", $rowt["datos"]);
                for ($i = 1; $i < 4; $i++) {
                    if (isset($rowt[$i]) && $rowt[$i]["tot"] != 0)
                        $resultados[$i + 1] = Utilerias::redondear2($rowt[$i]["acep"] / $rowt[$i]["tot"]*100, 1);
                    else
                        $resultados[$i + 1] = 0;
                    
                    $resultados[$i+$k]=$rowt[$i]["tot"];
                    $k++;
                    $resultados[$i+$k]= $rowt[$i]["acep"];
                        
                }
                 $resultados[$i + 1] = $this->grupocolores[0];
              
                       $resultados[6] = $this->grupocolores[0]." 0.7";
                       $resultados[7] = $this->grupocolores[0]." 0.4";
//                        echo "<br>*************************<br>";
//                        var_dump($resultados);
              
            }
     
       
        return $resultados;
    }
    
    function cumplimientoEstandarVariosReactivos($referencia, $usuario, $mesfinal) {
    	foreach($referencia as $sec){
    		$listasec.="'".$sec."' ,";
    	}
   
        $sql_reporte_e = "SELECT
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,100,0),0),if(ide_aceptado<0,100,0)))/sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as nivaceptren,
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,1,0),0),if(ide_aceptado<0,1,0))) as pasa,
sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as total,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,
tmp_estadistica.usuario,
concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) as refer,
red_tipodato,red_valormin,red_clavecatalogo
FROM
ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion
AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo 
AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente 
AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion
AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente 
AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
 AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join tmp_estadistica ON ins_detalleestandar.ide_numreporte = tmp_estadistica.numreporte
WHERE cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
ins_detalleestandar.ide_claveservicio=:vserviciou AND
STR_TO_DATE(mes_asignacion,'%Y-%m-%d') =:mes_final and
concat(cue_reactivosestandar.sec_numseccion,'.', ins_detalleestandar.ide_numreactivo,'.' ,ins_detalleestandar.ide_numcomponente,'.',ins_detalleestandar.ide_numcaracteristica3 ) 
in (".substr($listasec,0,strlen($listasec)-1).")
  and tmp_estadistica.usuario=:usuario
  GROUP BY

ins_detalleestandar.ide_numseccion,
cue_reactivosestandar.re_tipoevaluacion,
ins_detalleestandar.ide_numreactivo,
ins_detalleestandar.ide_numcomponente,
tmp_estadistica.usuario";
        $parametros = array("vserviciou" => $this->servicio, "usuario" => $usuario, "mes_final"=> $mesfinal);
    //    echo "<br>***********************************************<br>";
        $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e, $parametros);

        //$res = 0;
        foreach ($rs_sql_reporte_e as $row_rs_sql_reporte_e) {
            //$chart [ 'chart_data' ][ 2][ 0 ] = "aqui";
                
            $resultados  = array(Utilerias::redondear2($row_rs_sql_reporte_e ['nivaceptren'],1),
               $row_rs_sql_reporte_e["total"] , $row_rs_sql_reporte_e["pasa"])
                ;
          
           
        }
    
        return $resultados;
    }

     function consultaAtributos($referencia) {
     
        /* 502 */
        $sql = "SELECT
cue_reactivosestandardetalle.sec_numseccion,
cue_reactivosestandardetalle.r_numreactivo,
cue_reactivosestandardetalle.re_numcomponente,

cue_reactivosestandardetalle.red_numcaracteristica2
from cue_reactivosestandardetalle
 inner join cue_reactivosestandar on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion
and cue_reactivosestandar.r_numreactivo=cue_reactivosestandardetalle.r_numreactivo and cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente 
and cue_reactivosestandar.re_numcaracteristica=cue_reactivosestandardetalle.re_numcaracteristica and cue_reactivosestandar.re_numcomponente2=cue_reactivosestandardetalle.re_numcomponente2
where red_grafica=-1
and cue_reactivosestandar.ser_claveservicio=:vserviciou
 and concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente)=:referencia;";

        //
        //and cue_reactivosestandardetalle.r_numreactivo=0 and
        //cue_reactivosestandardetalle.re_numcomponente=2;";
$parametros=array("vserviciou"=>$this->servicio,"referencia"=>$referencia);
        $i = 0;
        $result = Conexion::ejecutarQuery($sql,$parametros);
        foreach ($result as $row) {
            $secciones [$i++] = $row [0] . '.' . $row [1] . '.' . $row [2] . '.' . $row [3];
        }
        return $secciones;
    }

    

    function historicoSemestralxIndicador($fecha_ini,$fecha_fin,$reactivo,$filx,$fily){
          $parametros=array("servicio"=>$this->servicio,"referencia"=>$reactivo);
          $aux = explode("-", $fecha_ini);
        //  var_dump($filx);
        //  die();
          $mes = $aux[1] ;
          $soloanio = $aux[0];
          
          $fecha_aux_ini=$fecha_ini; 
          $aux_sec = explode(".", $reactivo);
          $seccion = $aux_sec[0];
          if($seccion==5||$seccion==8){
        $sql="SELECT 
       sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,1,0),0),if(ide_aceptado<0,1,0))) as pasa,

       sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as tot,
         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') AS fecha,
        convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,
        substring_index(i_mesasignacion,'.',-1) as anio_asig,
        ins_generales.i_mesasignacion";
       
        
        
        for($i=1;$i<13;$i++)
        {
          
            if ($mes - 5 >0) { // calculo para los 6m
                   $z = $mes -5;

                   $mes_pivote = $soloanio. "-" . $z . "-01";
           } else {
                   $z = $mes+7;

                   $mes_pivote = ($soloanio- 1) . "-" . $z . "-01";
                    
           }
      
            
        //calculo fechas
     
        
           $sql_case.=" , if (  STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>='".$mes_pivote."'
 and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <='". $fecha_aux_ini."',1,0 ) as sem".($i);
             if ($mes + 1 <=12) { // calculo para los 6m
                $mes++;
        	
        	
        	$fecha_aux_ini = $soloanio. "-" . $mes . "-01";
            } else {
                   $mes = 1;
                    $soloanio++;
                    $fecha_aux_ini = ($soloanio) . "-" . $mes . "-01";
            }
          
        }
      //  die("*******".$sql_case);
        $sql.=$sql_case."
  
FROM
    ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica

        INNER JOIN
    cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
        AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion
        AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
        AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
        AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
        AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
        AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
        INNER JOIN
    ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio
        AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
        INNER JOIN
    ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
        INNER JOIN
    ca_nivel4 ON ca_nivel4.n4_id = `une_cla_estado`
WHERE
    ins_generales.i_claveservicio =:servicio
        AND ca_unegocios.une_cla_zona = ".$filx["zon"];
           if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
            $parametros["cta"] = $fily["cta"];
        }
        if (isset($filx["edo"]) && $filx["edo"] != "") {
            $sql .= " and ca_unegocios.une_cla_estado=:reg";
            $parametros["reg"] = $filx["edo"];
        }
        if (isset($filx["ciu"]) && $filx["ciu"] != "") {
            $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
            $parametros["ciu"] = $filx["ciu"];
        }
        if (isset($filx["niv6"]) && $filx["niv6"] != "") {
            $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
            $parametros["niv6"] = $filx["niv6"];
        }
        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
            $parametros["fra"] = $fily["fra"];
        }
      
        $sql.=" and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>=:fechaini
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fechafin
        AND ide_valorreal <> ''
        AND concat(ins_detalleestandar.ide_numseccion,'.',
         ins_detalleestandar.ide_numreactivo ,'.',
         ins_detalleestandar.ide_numcomponente ,'.',
         ins_detalleestandar.ide_numcaracteristica1,'.',
         ins_detalleestandar.ide_numcaracteristica2 ,'.',
         ins_detalleestandar.ide_numcaracteristica3 )=:referencia
       
GROUP BY i_mesasignacion


ORDER BY  anio_asig asc,  mes_asig asc";
          }
        if($seccion==6){
            //para jarabes seccion 6
            
            $sql_reporte_e = "SELECT
 
SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,
                
(SUM(`ins_detalleproducto`.`ip_numcajas`)) AS tot,
 convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,
 substring_index(i_mesasignacion,'.',-1) as anio_asig,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc, ins_generales.i_mesasignacion
   ";
            
            
            for($i=1;$i<13;$i++)
            {
                
                if ($mes - 5 >0) { // calculo para los 6m
                    $z = $mes -5;
                    
                    $mes_pivote = $soloanio. "-" . $z . "-01";
                } else {
                    $z = $mes+7;
                    
                    $mes_pivote = ($soloanio- 1) . "-" . $z . "-01";
                    
                }
                //calculo fechas
               
                $sql_case.=" , if (  STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>='". $mes_pivote."'
 and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <='".$fecha_aux_ini."',1,0 ) as sem".($i);
                if ($mes + 1 <=12) { // calculo para los 6m
                    $mes++;
                    
                    
                    $fecha_aux_ini = $soloanio. "-" . $mes . "-01";
                } else {
                    $mes = 1;
                    $soloanio++;
                    $fecha_aux_ini = ($soloanio) . "-" . $mes . "-01";
                }
                
            }
            $sql_reporte_e.=$sql_case." FROM
ins_detalleproducto
                
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
   Inner Join ins_generales ON ins_detalleproducto.ip_claveservicio = ins_generales.i_claveservicio
AND ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
                
                
   INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`";
            
            
            $sql_reporte_e .= " where ins_generales.i_claveservicio=:servicio ";
            $parametros["servicio"] = $this->servicio;
            //  $parametros["cliente"] = $this->cliente;
            if (isset($filx["zon"]) && $filx["zon"] != "") {
                $sql_reporte_e .= "  and     ca_unegocios.une_cla_zona=:zon";
                $parametros["zon"] = $filx["zon"];
                $nivel++;
            }
            $sql_reporte_e.=" and
	 ins_detalleproducto.ip_numseccion in (6,7)
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null)
                
    and ins_detalleproducto.ip_claveservicio=:servicio
 and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>=:fechaini
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fechafin

";
        
            //validacion renglon
            
            
            if (isset($fily["cta"]) && $fily["cta"] != "") {
                $sql_reporte_e .= " and ca_unegocios.cue_clavecuenta=:cta";
                $parametros["cta"] = $fily["cta"];
            }
            if (isset($filx["edo"]) && $filx["edo"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_estado=:reg";
                $parametros["reg"] = $filx["edo"];
                $nivel++;
            }
            if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_ciudad=:ciu";
                $parametros["ciu"] = $filx["ciu"];
                $nivel++;
            }
            if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_franquicia=:niv6";
                $parametros["niv6"] = $filx["niv6"];
            }
            if (isset($fily["fra"]) && $fily["fra"] != "") {
                $sql_reporte_e .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                $parametros["fra"] = $fily["fra"];
            }
            
            $sql_reporte_e .= " GROUP BY i_mesasignacion
            
            
            ORDER BY  anio_asig asc,  mes_asig asc";
                            $sql=$sql_reporte_e;
        }
        
        $aux = explode("-", $fecha_ini);
        
        $mes = $aux[1] ;
        $soloanio = $aux[0];
        if ($mes - 5 >0) { // calculo para los 6m
            $z = $mes -5;
            
            $mes_pivote = $soloanio. "-" . $z . "-01";
        } else {
            $z = $mes+7;
            
            $mes_pivote = ($soloanio- 1) . "-" . $z . "-01";
            
        }
        $parametros["fechaini"] = $mes_pivote;
        $parametros["fechafin"] = $fecha_fin;
      
        $resultado=Conexion::ejecutarQuery($sql, $parametros);
   //    die();
        $matriz=array();
          if (sizeof($resultado) > 0) {
              //inicializo el arreglo en 0's
              for($i=1;$i<13;$i++){
                 $matriz["sem".$i]["acep"] = 0;
                $matriz["sem".$i]["tot"] = 0;
                     
                }
            foreach ($resultado as $row) {
                $periodo = $acept = $acumtot = 0;
                
                   //solo para no escribirlo 12 veces
                for($i=1;$i<13;$i++){
                    if ($row["sem".$i] == 1) {

                        $matriz["sem".$i]["acep"] += $row["pasa"];
                        $matriz["sem".$i]["tot"]+= $row["tot"];
                    } 
                }
//     
            }
        }
        return $matriz;
        //
    }
    
     function historicoMensualxIndicador($fecha_ini,$fecha_fin,$reactivo,$filx,$fily){
       // echo $fecha_ini."---".$fecha_fin;
       //var_dump($filx);
        // die();
         $parametros=array("servicio"=>$this->servicio,"referencia"=>$reactivo);
         $aux_sec = explode(".", $reactivo);
         $seccion = $aux_sec[0];
         if($seccion==5||$seccion==8){
        $sql="SELECT 
       sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,1,0),0),if(ide_aceptado<0,1,0))) as pasa,

        sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as tot,
         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') AS fecha,
        convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,
        substring_index(i_mesasignacion,'.',-1) as anio_asig,
        ins_generales.i_mesasignacion
     
FROM
    ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion
AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo 
AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente 
AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica

        INNER JOIN
    cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
        AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion
        AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
        AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
        AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
        AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
        AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
        INNER JOIN
    ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio
        AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
        INNER JOIN
    ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
        INNER JOIN
    ca_nivel4 ON ca_nivel4.n4_id = `une_cla_estado`
WHERE
    ins_generales.i_claveservicio =:servicio
        AND ca_unegocios.une_cla_zona = ".$filx["zon"];
           if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
            $parametros["cta"] = $fily["cta"];
        }
        if (isset($filx["edo"]) && $filx["edo"] != "") {
            $sql .= " and ca_unegocios.une_cla_estado=:reg";
            $parametros["reg"] = $filx["edo"];
        }
        if (isset($filx["ciu"]) && $filx["ciu"] != "") {
            $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
            $parametros["ciu"] = $filx["ciu"];
        }
        if (isset($filx["niv6"]) && $filx["niv6"] != "") {
            $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
            $parametros["niv6"] = $filx["niv6"];
        }
        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
            $parametros["fra"] = $fily["fra"];
        }
      
        $sql.=" and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>:fechaini
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fechafin
        AND ide_valorreal <> ''
        AND concat(ins_detalleestandar.ide_numseccion,'.',
         ins_detalleestandar.ide_numreactivo ,'.',
         ins_detalleestandar.ide_numcomponente ,'.',
         ins_detalleestandar.ide_numcaracteristica1,'.',
         ins_detalleestandar.ide_numcaracteristica2 ,'.',
         ins_detalleestandar.ide_numcaracteristica3 )=:referencia
      
GROUP BY i_mesasignacion


ORDER BY  anio_asig asc,  mes_asig asc";
         }
         if($seccion==6){
             
             $sql_reporte_e = "SELECT
 convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,
        substring_index(i_mesasignacion,'.',-1) as anio_asig,
SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,
                 
(SUM(`ins_detalleproducto`.`ip_numcajas`)) AS tot,
cue_secciones.sec_descripcionesp,ins_generales.i_mesasignacion,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc   ";
         
             $sql_reporte_e.=" FROM
ins_detalleproducto
                 
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
   Inner Join ins_generales ON ins_detalleproducto.ip_claveservicio = ins_generales.i_claveservicio
AND ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
                 
                 
 INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id`
    ";
             
             
             $sql_reporte_e .= " where ins_generales.i_claveservicio=:servicio ";
             $parametros["servicio"] = $this->servicio;
             //  $parametros["cliente"] = $this->cliente;
             if (isset($filx["zon"]) && $filx["zon"] != "") {
                 $sql_reporte_e .= "  and     ca_unegocios.une_cla_zona=:zon";
                 $parametros["zon"] = $filx["zon"];
                 
             }
             $sql_reporte_e.="  and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>:fechaini
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fechafin
     and
	 ins_detalleproducto.ip_numseccion in (6,7)
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null)
                 
    and ins_detalleproducto.ip_claveservicio=:servicio
";
            //validacion renglon
             
             
             if (isset($fily["cta"]) && $fily["cta"] != "") {
                 $sql_reporte_e .= " and ca_unegocios.cue_clavecuenta=:cta";
                 $parametros["cta"] = $fily["cta"];
             }
             if (isset($filx["edo"]) && $filx["edo"] != "") {
                 $sql_reporte_e .= " and ca_unegocios.une_cla_estado=:reg";
                 $parametros["reg"] = $filx["edo"];
                 
             }
             if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                 $sql_reporte_e .= " and ca_unegocios.une_cla_ciudad=:ciu";
                 $parametros["ciu"] = $filx["ciu"];
                 
             }
             if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                 $sql_reporte_e .= " and ca_unegocios.une_cla_franquicia=:niv6";
                 $parametros["niv6"] = $filx["niv6"];
             }
             if (isset($fily["fra"]) && $fily["fra"] != "") {
                 $sql_reporte_e .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                 $parametros["fra"] = $fily["fra"];
             }
             
             $sql_reporte_e .= " GROUP BY i_mesasignacion
ORDER BY  anio_asig asc,  mes_asig asc";
                     $sql=$sql_reporte_e;
         }
      
     
         $parametros["fechaini"] = $fecha_ini;
        $parametros["fechafin"] = $fecha_fin;
      
        $resultado=Conexion::ejecutarQuery($sql, $parametros);
        //die();
        $matriz=array();
          if (sizeof($resultado) > 0) {
              //inicializo el arreglo en 0's
            
            foreach ($resultado as $row) {
            
              
                $matriz[ $row["i_mesasignacion"]]["pasa"]=$row["pasa"];
                
                $matriz[ $row["i_mesasignacion"]]["tot"]=$row["tot"];
                
//     
            }
        }
        return $matriz;
        //
    }
    
    function historicoAnualxIndicador($fecha_ini,$fecha_fin,$reactivo,$filx,$fily){
       $parametros=array("servicio"=>$this->servicio,"referencia"=>$reactivo);
       $aux = explode("-", $fecha_ini);
     //  var_dump($filx);
     //   die();
       $mes = $aux[1] ;
       $soloanio = $aux[0];
       
       $fecha_aux_ini=$fecha_ini;
       $mes_pivote = ($soloanio+ 1) . "-" . $mes . "-01";
       $aux_sec = explode(".", $reactivo);
       $seccion = $aux_sec[0];
        if($seccion==5||$seccion==8){
                $sql="SELECT 
               sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,1,0),0),if(ide_aceptado<0,1,0))) as pasa,

                sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as tot,
                 STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') AS fecha,
                convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,
                substring_index(i_mesasignacion,'.',-1) as anio_asig,
                ins_generales.i_mesasignacion";
             
        //           $sql_if=" ,if(  STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>'$fecha_aux_ini'
        // and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <='$mes_pivote',1,0 ) as 'anio1'";
        //     
                for($i=1;$i<13;$i++)
                {
                   
                      if ($mes + 1 <=12) { //aumento el mes
                	$z = $mes +1;
                	$mes++;
                	$fecha_aux_ini = $soloanio. "-" . $z . "-01";
                } else {
                	$z =$mes= 1;
                	$soloanio++;
                	$fecha_aux_ini = ($soloanio) . "-" . $z . "-01";
                }
                    
                     $mes_pivote = ($soloanio+ 1) . "-" . $mes . "-01";
                
                    
                //calculo fechas
                  //  echo "<br>".$fecha_aux_ini."--".$mes_pivote;
                
                $sql_if.=" ,if(  STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>'$fecha_aux_ini'
         and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <='$mes_pivote',1,0 ) as 'anio".($i)."'";
                
                }
              //  die("<br>".$sql_if);
                $sql.=$sql_if."
         
        FROM
            ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica

                INNER JOIN
            cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
                AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion
                AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
                AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
                AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
                AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
                AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
                INNER JOIN
            ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio
                AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
                INNER JOIN
            ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
                INNER JOIN
            ca_nivel4 ON ca_nivel4.n4_id = `une_cla_estado`
        WHERE
            ins_generales.i_claveservicio =:servicio
                AND ca_unegocios.une_cla_zona = ".$filx["zon"];
                   if (isset($fily["cta"]) && $fily["cta"] != "") {
                    $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
                    $parametros["cta"] = $fily["cta"];
                }
                if (isset($filx["edo"]) && $filx["edo"] != "") {
                    $sql .= " and ca_unegocios.une_cla_estado=:reg";
                    $parametros["reg"] = $filx["edo"];
                }
                if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                    $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
                    $parametros["ciu"] = $filx["ciu"];
                }
                if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                    $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
                    $parametros["niv6"] = $filx["niv6"];
                }
                if (isset($fily["fra"]) && $fily["fra"] != "") {
                    $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                    $parametros["fra"] = $fily["fra"];
                }
              
                $sql.=" and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>:fechaini
          and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fechafin
                AND ide_valorreal <> ''
                AND concat(ins_detalleestandar.ide_numseccion,'.',
                 ins_detalleestandar.ide_numreactivo ,'.',
                 ins_detalleestandar.ide_numcomponente ,'.',
                 ins_detalleestandar.ide_numcaracteristica1,'.',
                 ins_detalleestandar.ide_numcaracteristica2 ,'.',
                 ins_detalleestandar.ide_numcaracteristica3 )=:referencia
              
        GROUP BY i_mesasignacion
        
        
        ORDER BY  anio_asig asc,  mes_asig asc";
        }
        if($seccion==6){
            $sql_reporte_e = "SELECT
  convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,
        substring_index(i_mesasignacion,'.',-1) as anio_asig,
SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)) as pasa,
                
(SUM(`ins_detalleproducto`.`ip_numcajas`)) AS tot,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc, ins_generales.i_mesasignacion  ";
            for($i=1;$i<13;$i++)
            {
                
                if ($mes + 1 <=12) { //aumento el mes
                    $z = $mes +1;
                    $mes++;
                    $fecha_aux_ini = $soloanio. "-" . $z . "-01";
                } else {
                    $z =$mes= 1;
                    $soloanio++;
                    $fecha_aux_ini = ($soloanio) . "-" . $z . "-01";
                }
                
                $mes_pivote = ($soloanio+ 1) . "-" . $mes . "-01";
                
                
                //calculo fechas
                //  echo "<br>".$fecha_aux_ini."--".$mes_pivote;
                
                $sql_if.=" ,if(  STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>'$fecha_aux_ini'
         and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <='$mes_pivote',1,0 ) as 'anio".($i)."'";
                
            }
            //  die("<br>".$sql_if);
            $sql_reporte_e.=$sql_if." FROM
ins_detalleproducto
                
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
   Inner Join ins_generales ON ins_detalleproducto.ip_claveservicio = ins_generales.i_claveservicio
AND ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
                
                
 INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id`
    ";
            
            
            $sql_reporte_e .= " where ins_generales.i_claveservicio=:servicio ";
            $parametros["servicio"] = $this->servicio;
            //  $parametros["cliente"] = $this->cliente;
            if (isset($filx["zon"]) && $filx["zon"] != "") {
                $sql_reporte_e .= "  and     ca_unegocios.une_cla_zona=:zon";
                $parametros["zon"] = $filx["zon"];
                
            }
            $sql_reporte_e.="  and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>:fechaini
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fechafin
     and
	 ins_detalleproducto.ip_numseccion in (6,7)
AND (ins_detalleproducto.ip_sinetiqueta=0 or ip_sinetiqueta is null)
                
    and ins_detalleproducto.ip_claveservicio=:servicio
";
            //validacion renglon
            
            
            if (isset($fily["cta"]) && $fily["cta"] != "") {
                $sql_reporte_e .= " and ca_unegocios.cue_clavecuenta=:cta";
                $parametros["cta"] = $fily["cta"];
            }
            if (isset($filx["edo"]) && $filx["edo"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_estado=:reg";
                $parametros["reg"] = $filx["edo"];
                
            }
            if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_ciudad=:ciu";
                $parametros["ciu"] = $filx["ciu"];
                
            }
            if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                $sql_reporte_e .= " and ca_unegocios.une_cla_franquicia=:niv6";
                $parametros["niv6"] = $filx["niv6"];
            }
            if (isset($fily["fra"]) && $fily["fra"] != "") {
                $sql_reporte_e .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                $parametros["fra"] = $fily["fra"];
            }
            
            $sql_reporte_e .= "   GROUP BY i_mesasignacion
                     ORDER BY  anio_asig asc,  mes_asig asc";
            $sql=$sql_reporte_e;
        }
        
        $parametros["fechaini"] = $fecha_ini;
        $parametros["fechafin"] = $fecha_fin;
      
        $resultado=Conexion::ejecutarQuery($sql, $parametros);
    //    die();
        $matriz=array();
        if (sizeof($resultado) > 0) {
              //inicializo el arreglo en 0's
              for($i=1;$i<13;$i++){
                 $matriz["anio".$i]["acep"] = 0;
                $matriz["anio".$i]["tot"] = 0;
                     
                }
            foreach ($resultado as $row) {
             
                
                   //solo para no escribirlo 12 veces
                for($i=1;$i<13;$i++){
                    if ($row["anio".$i] == 1) {

                        $matriz["anio".$i]["acep"] +=$row["pasa"];
                        $matriz["anio".$i]["tot"] +=$row["tot"];
                    } 
                    $matriz["anio".$i]["mes"]=$row["i_mesasignacion"];
                }
                
                  
            }
        }
        return $matriz;
        //
    }
    
    private function historicoxIndicador($seccion){
         $aux = explode(".", $this->filnivel);
      
        $filx = array();
      
        $filx["zon"] = $aux[2];
     
        
       
        $filx["edo"] = $aux[3];
        
        $filx["ciu"] = $aux[4];
        $filx["niv6"] = $aux[5];
        $auxy = explode(".", $this->filcuenta);
        $nivel=0;
        if($auxy[0])
            $nivel=sizeof($auxy);
       
        $fily = array();
        
        $fily["cta"] = $auxy[0];
        $fily["fra"] = $auxy[1];
        $fily["pv"] = $auxy[2];
        //fecha fin sí llega, tengo que calcular la de inicio para
        //los 12 meses y la 6 meses
        $aux = explode('.', $this->filperiodo);
      
        $mes = $aux[0];
        // para anual
         $fecha_inicial = ($aux[1] - 1) . "-" . $aux[0] . "-01"; //fecha inicial //para el mensual
         $fecha_incialan=($aux[1] - 2) . "-" . $aux[0] . "-01";
       //  die($fecha_inicial);
        if ($mes +1 > 12) { // calculo para la de 6m
            $z = 1;

            $mes_pivote =  ($aux[1] ) . "-" . $z . "-01";
        } else {
            $z = 1+$mes;

            $mes_pivote = ($aux[1]-1) . "-" . $z . "-01";
        }
        $fecha_final = $aux[1] . "-" . $aux[0] . "-01"; //fecha final
        
        
        $arremes=$this->historicoMensualxIndicador($fecha_inicial, $fecha_final, $seccion,$filx,$fily);
      //die();
        $arreanio=$this->historicoAnualxIndicador($fecha_incialan , $fecha_final,  $seccion,$filx,$fily);
        $arresemestral=$this->historicoSemestralxIndicador($mes_pivote, $fecha_final,  $seccion,$filx,$fily);
      //    echo "****************";
        // var_dump($arremes);
// //      
// //      
//           echo "*************************<pre>";
//             print_r($arresemestral);
//             echo "</pre>";
//          echo "*****************";
//                     var_dump($arreanio);
//           //armo el json
          
        $aux = explode('-',$fecha_inicial);
      
        $mes = $aux[1];
        $soloanio=$aux[0];
          for($i=1;$i<13;$i++){
              $valmes=$valsem=$valanio=null;
              if ($mes + 1 <=12) { 
            	$z = $mes +1;
            	
            	$mes_asig = $z."." .$soloanio;
                 $mes++;
            } else {
                $mes=$z = 1;
                $soloanio++;
                $mes_asig =  $z."." .($soloanio) ;
            }
         //   echo "<br>".$mes_asig;
            if($arremes[$mes_asig]["tot"]!=0)
                $valmes=Utilerias::redondear2($arremes[$mes_asig]["pasa"]/$arremes[$mes_asig]["tot"]*100,2);
                
         
            if($arresemestral["sem".$i]["tot"]!=0)
                 $valsem=Utilerias::redondear2($arresemestral["sem".$i]["acep"]/$arresemestral["sem".$i]["tot"]*100,2);
            if($arreanio["anio".$i]["tot"]!=0)
                $valanio=Utilerias::redondear2($arreanio["anio".$i]["acep"]/$arreanio["anio".$i]["tot"]*100,2);
            //paso el mes a letras y lo corto
              
            $fechaaux=explode(" ",Utilerias::cambiaMesG($mes_asig));
              $this->chart[]=array(substr($fechaaux[0],0,3)."-".substr($fechaaux[1],2,2),'',$valmes,$valsem,$valanio,
                  '','','',$arremes[$mes_asig]["tot"],  $arremes[$mes_asig]["pasa"],
                  $arresemestral["sem".$i]["tot"],   $arresemestral["sem".$i]["acep"],
                  $arreanio["anio".$i]["tot"],
                 
               
                  $arreanio["anio".$i]["acep"]
              );
              
           
           //   echo "www".$mes;
          }
//            echo "*************************<pre>";
//            print_r($this->chart);
//            echo "</pre>";
                
    }
    
    public function compararR1vsR2($referencia_rec){
        $referencia=[['8.0.2',4,[2,3],6],['8.0.2',4,[2,3],9],['8.0.1',4,[1,2,3],9]];
        //de un solo reactivo 
       // $referencia=[['8.0.1',4,[1,2,3],9]];
       $ind="";
        foreach ($referencia as $key=>$ref){
           // echo "---".$ref[0].'.0.0.'.$ref[3]."ppp".$referencia_rec;
            if(strcmp($ref[0].'.0.0.'.$ref[3],$referencia_rec)==0)
            {   $refbuscada=$ref;
            break;
            
            }
                
        }
        if($refbuscada=="")
        {
            $this->chart["error"]="No hay datos de ese reactivo";
            return;
            
        }
        //$refbuscada=$referencia[$ind];
            $aux = explode('.', $this->filperiodo);
        $mes = $aux[0];
        if ($mes - 6 >= 0) { // calculo para los 6m
            $z = $mes - 6 + 1;

            $mes_pivote = $aux[1] . "-" . $z . "-01";
        } else {
            $z = 7 + $mes;

            $mes_pivote = ($aux[1] - 1) . "-" . $z . "-01";
        }
        $fecha_consulta_fin = $aux[1] . "-" . $aux[0] . "-01"; //fecha final
        $fecha_consulta_ini = ($aux[1] - 1) . "-" . $aux[0] . "-01"; //fecha inicial
        //foreach ($referencia as $ref){
             $tiempo_ini = microtime(true);
          //   echo "+++++++++++".$tiempo_ini;
             $carproducto=$refbuscada[1];
             $concatenado=$refbuscada[0].".".$refbuscada[3];
            //echo "<br>+++++++++++++++++".$concatenado;
           
             $aux = explode(".", $this->filnivel);
             
             $filx = array();
             
             $filx["zon"] = $aux[2];
             
             
             
             $filx["edo"] = $aux[3];
             
             $filx["ciu"] = $aux[4];
             $filx["niv6"] = $aux[5];
             $auxy = explode(".", $this->filcuenta);
            
             
                 $fily = array();
                 
                 $fily["cta"] = $auxy[0];
                 $fily["fra"] = $auxy[1];
                 $fily["pv"] = $auxy[2];
             $this->comparacion($refbuscada[0], $concatenado, $fecha_consulta_ini, $fecha_consulta_fin, $mes_pivote, $carproducto,$filx,$fily);
           $tiempofin= microtime(true);
         //  echo "---------".($tiempofin-$tiempo_ini);
        //   die();
        //}
    }
    
    public function comparacion($seccion,$referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote,$carproducto,$filx,$fily){
        //busco reportes y renglones con 2 resultados
         $usuario = $_SESSION["UsuarioInd"];
        $sql1="select ins_detalleestandar.ide_numreporte,ins_detalleestandar.ide_numcaracteristica3,
ins_detalleestandar.ide_valorreal,ins_detalleestandar.ide_numrenglon,mes_asignacion
from ins_detalleestandar
inner join (
SELECT ide_numreporte,ide_numcaracteristica3,
ide_valorreal,ide_numrenglon, ide_claveservicio,i_mesasignacion, STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') as mes_asignacion,
red_parametroesp, count(ide_numcaracteristica3), if(ide_numcaracteristica3=4 ,ide_valorreal,null) as prod 
FROM cue_reactivosestandardetalle

Inner Join ins_detalleestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
 AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
 Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
     INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id` 
    
    where ins_generales.i_claveservicio=:vserviciou ";
        $parametros=array("vserviciou"=>1,"seccion"=>$seccion,"carproducto"=>$carproducto);
            $sql1.=" AND ca_unegocios.une_cla_zona = ".$filx["zon"];
                   if (isset($fily["cta"]) && $fily["cta"] != "") {
                       $sql1 .= " and ca_unegocios.cue_clavecuenta=:cta";
                    $parametros["cta"] = $fily["cta"];
                }
            //    var_dump($filx);
             //   die();
                if (isset($filx["edo"]) && $filx["edo"] != "") {
                    $sql1 .= " and ca_unegocios.une_cla_estado=:reg";
                    $parametros["reg"] = $filx["edo"];
                }
                if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                    $sql1 .= " and ca_unegocios.une_cla_ciudad=:ciu";
                    $parametros["ciu"] = $filx["ciu"];
                }
                if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                    $sql1 .= " and ca_unegocios.une_cla_franquicia=:niv6";
                    $parametros["niv6"] = $filx["niv6"];
                }
                if (isset($fily["fra"]) && $fily["fra"] != "") {
                    $sql1 .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                    $parametros["fra"] = $fily["fra"];
                }
            $sql1.=" and  concat(cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente)= :seccion
and ide_numcaracteristica3 in (:carproducto) and
cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
ins_detalleestandar.ide_claveservicio=:vserviciou 
 /*and  `red_indicador`=-1*/ 
and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>=:mes_consulta_ant
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fmes_consulta
     
group by red_numcaracteristica2,cue_reactivosestandardetalle.ser_claveservicio,ide_numreporte,ide_valorreal
 having count(ide_numcaracteristica3)>1 ) as produc
 on ins_detalleestandar.ide_claveservicio=produc.ide_claveservicio 
 and ins_detalleestandar.ide_claveservicio=1
 and ins_detalleestandar.ide_numreporte=produc.ide_numreporte 
 and ins_detalleestandar.ide_numcaracteristica3=produc.ide_numcaracteristica3
 and ins_detalleestandar.ide_valorreal=produc.ide_valorreal
 and concat(ins_detalleestandar.ide_numseccion,'.',
  ins_detalleestandar.ide_numreactivo,'.',
  ins_detalleestandar.ide_numcomponente)=:seccion";
         $tiempo_ini = microtime(true);
         $parametros["fmes_consulta"] = $fecha_consulta_fin;
         $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
          $rs_sql_reporte_e = Conexion::ejecutarQuery($sql1, $parametros);
           
          $tiempo_fin = microtime(true);
           //    echo "++++++++++cons1".($tiempo_fin-$tiempo_ini);
  $tiempo_ini = microtime(true);
//borro la tabla temporal
          $sql_Del="delete from tmp_dosresultados where usuario=:usuario";
          Conexion::ejecutarInsert($sql_Del,["usuario"=>$usuario]);
          $ren="R1";
          $rep_ant=0;
          $otroarre=array();
          foreach($rs_sql_reporte_e as $res){
            
           //   echo "<br>".$res["ide_numreporte"]."--".$res["ide_numrenglon"]."<br>";
              //para ese renglon busco que tenga 2 resultados del 1, 2 y 3
             
                  $otroarre[$res["ide_numreporte"]][$res["ide_numcaracteristica3"]][]=$res["ide_numrenglon"];
                  $otroarre[$res["ide_numreporte"]]["mes"]=$res["mes_asignacion"];
            
          }
          
//            echo "<br>++++++++++++++++++++++++++++en lista";
//          var_dump($lista); //lista con los reportes y renglones que se repiten
           // echo "<br>++++++++++++++++++++++++++++en lista";
       // var_dump($otroarre); //lista con los reportes y renglones que se repiten
          $lista=array();
          foreach($otroarre as $key=>$sabor)
              foreach($sabor as $res ){
              $mes=$sabor["mes"];
            //  die("******".$carproducto);
               if(!empty($res[0])&&!empty($res[1]))
            //   echo "<br>".$key."--".$carproducto;
                   if(($carproducto==4&&$this->verificaReactivos($key,1,$res[0],$res[1],'1,2,3',$usuario,$seccion,$carproducto,$filx,$fily,$fecha_consulta_ini,$fecha_consulta_fin))||
                       ($carproducto==3&&$this->verificaReactivos($key,1,$res[0],$res[1],'1,2',$usuario,$seccion,$carproducto,$filx,$fily,$fecha_consulta_ini,$fecha_consulta_fin)))
                      
              {
                 //   echo "<br>--- ".$key;
                      $sql="INSERT INTO tmp_dosresultados
                (`numreporte`,
                `usuario`,
                `mes_asignacion`,
                `renglon`,resultado)
                VALUES
                (:numreporte,
                :usuario,
                :mes_asignacion,
                :renglon1,'R1'),(:numreporte,
                :usuario,
                :mes_asignacion,
                :renglon2,'R2');";
              try{
                Conexion::ejecutarInsert($sql,array("numreporte"=>$key,"usuario"=>$usuario,"mes_asignacion"=>$mes,"renglon1"=>$res[0],"renglon2"=>$res[1]));
               
              }catch (Exception $ex){
                  Utilerias::guardarError("Error al insertar en tmp_dosresultados ".$ex->getMessage());
              }
              $lista[]=$sabor;
               }
              // die();
          }
            $tiempo_fin = microtime(true);
         //   echo "++++++++++".($tiempo_fin-$tiempo_ini);
                $tiempo_ini = microtime(true);
       //   die();
      //  var_dump($lista);
       // die();
      //   die($fecha_consulta_fin);
          //para esa lista ahora si busco los resultados del reactivo
                $result=$this->cumplimientoDetalleEstandarRes1($referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote,$filx,$fily);
           $matriz=array();
        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            foreach ($result as $row) {

                $periodo = $acept = $acumtot = 0;

               // $resul=$row["resultado"];
                if ($_SESSION["idiomaus"] == 2) {
                    $nomseccion = $row["red_parametroing"];
                } else {
                    $nomseccion = $row["red_parametroesp"];
                }
                $estandar = $row["red_estandar"];
              //  $matriz[$nomseccion]["datos"] =$row["refer"];
                
                if ($row["mes"] == 1) {
                    $periodo = 1;
                
                    $matriz[$nomseccion][$periodo]["R1"]["acep"] +=$row["pasa"];
                    $matriz[$nomseccion][$periodo]["R1"]["tot"] +=$row["tot"];
                 
                }


                if ($row["6mes"] == 2) {
                    $periodo = 2;
                   
                    $matriz[$nomseccion][$periodo]["R1"]["acep"] +=$row["pasa"];
                    $matriz[$nomseccion][$periodo]["R1"]["tot"] +=$row["tot"];
                 }
                if ($row["12mes"] == 3) {
                    $periodo = 3;
                 
                    $matriz[$nomseccion][$periodo]["R1"]["acep"] +=$row["pasa"];
                    $matriz[$nomseccion][$periodo]["R1"]["tot"] +=$row["tot"];
                 }
              //  $matriz[$nomseccion]["sec"] = $row["seccion"];
//   echo "<br>*************************<br>";
             
                //voy formando el arreglo de la forma [idicador][estandar][periodo][aceptados][total]
                //$total_cuen[$cuenta][$periodo]["acep"]+=$acept;
                //$total_cuen[$cuenta][$periodo]["tot"]+=$acumtot;
            }
        } 
             //para esa lista ahora si busco los resultados del reactivo
        $result=$this->cumplimientoDetalleEstandarRes2($referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote,$filx,$fily);
//         echo "<br>********************";
//           var_dump($result);
//          die();
        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            foreach ($result as $row) {

                $periodo = $acept = $acumtot = 0;

               // $resul=$row["resultado"];
                if ($_SESSION["idiomaus"] == 2) {
                    $nomseccion = $row["red_parametroing"];
                } else {
                    $nomseccion = $row["red_parametroesp"];
                }
                $estandar = $row["red_estandar"];
              //  $matriz[$nomseccion]["datos"] =$row["refer"];
                
                if ($row["12mes"] == 3) {
                    $periodo = 3;
                    
                    $matriz[$nomseccion][$periodo]["R2"]["acep"] +=$row["pasa"];
                  //  $matriz[$nomseccion][$periodo]["R2"]["tot"] +=$row["tot"];
                }

                if ($row["6mes"] == 2) {
                    $periodo = 2;
                  
                    $matriz[$nomseccion][$periodo]["R2"]["acep"] +=$row["pasa"];
                  //  $matriz[$nomseccion][$periodo]["R2"]["tot"] +=$row["tot"];
                }
               
                if ($row["mes"] == 1) {
                    $periodo = 1;
                    
                    
                    $matriz[$nomseccion][$periodo]["R2"]["acep"] +=$row["pasa"];
                    
                   // $matriz[$nomseccion][$periodo]["R2"]["tot"] +=$row["tot"];
                }
                
              //  $matriz[$nomseccion]["sec"] = $row["seccion"];
//   echo "<br>*************************<br>";
             
                //voy formando el arreglo de la forma [idicador][estandar][periodo][aceptados][total]
                //$total_cuen[$cuenta][$periodo]["acep"]+=$acept;
                //$total_cuen[$cuenta][$periodo]["tot"]+=$acumtot;
            }
        }
//             print_r("<pre>");
//             var_dump($matriz);
//             print_r("</pre>");
            $secc_ant = "";
            $j =$k=$l= 0;
            $titperiodo=["","mensual","6 meses","12 meses"];
            foreach ($matriz as $key => $rowt) {
              //  var_dump($rowt);
                $secc_actual = $key;
                //   print_r($secc_actual."<br>");
                 
                for ($i = 3; $i >0; $i--) {
                   //echo "<br>******";
                  // echo $rowt[$i]["R1"]["acep"]."=". $rowt[$i]["R2"]["acep"];
                  // echo "/". $rowt[$i]["R1"]["tot"];
//                    var_dump($rowt[$i]);
//                    echo "--";
                    $r1=$r2=0;
                    if (isset($rowt[$i]["R1"]["tot"]) && $rowt[$i]["R1"]["tot"] != 0)
                        $r1=  Utilerias::redondear2($rowt[$i]["R1"]["acep"] / $rowt[$i]["R1"]["tot"]*100, 1);
                    if (isset($rowt[$i]["R1"]["tot"]) && $rowt[$i]["R1"]["tot"] != 0)
                        $r2=Utilerias::redondear2($rowt[$i]["R2"]["acep"]/ $rowt[$i]["R1"]["tot"]*100, 1);
                 
                        $this->chart[]=array($titperiodo[$i] ,
                            $r1,
                            $r2,
                            $this->blue[$l],
                            $this->blue[$l]." 0.4",
                            $this->blue[$l++]." 0.4",
                            $rowt[$i]["R1"]["tot"],
                            $rowt[$i]["R1"]["tot"],
                            $rowt[$i]["R1"]["acep"],
                            $rowt[$i]["R2"]["acep"]
                            
                        );
                    
                    
                }
                 //    $res[$i]=$this->colores[$k]." 0.4";
//                 $res[5]=$this->colores[$k]." 0.7";
//                 $res[6]=$this->colores[$k++];
              //   echo "--".$rowt["sec"];
                   //pongo colores
                 
                //}
                $secc_ant = $secc_actual;
                $j++;
            }
                $tiempo_fin = microtime(true);
             //      echo "++++++++++mat ".($tiempo_fin-$tiempo_ini);
           
        
       // var_dump($this->chart);
          
      }
//      public function cumplimientoDetalleEstandar( $referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote){
//          $sql="SELECT
//sum(if(ide_aceptado<0,1,0)) as pasa,
//sum(1) as tot,ide_numrenglon,
//cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,
//red_tipodato,red_valormin,red_clavecatalogo ,cue_reactivosestandardetalle.sec_numseccion seccion,
//  if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d')=:fmes_consulta,1,0) as mes,
//       if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d') >=:mes_pivote 
// and STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:fmes_consulta ,2,0 ) as 6mes,
//       if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d') >:mes_consulta_ant 
//       and STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:fmes_consulta,3,0)  as 12mes, tmp_dosresultados.resultado
//        FROM
//ins_detalleestandar
//Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
//Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
//
//Inner Join tmp_dosresultados ON ins_detalleestandar.ide_numreporte = tmp_dosresultados.numreporte
// and renglon=ide_numrenglon
//WHERE cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
//ins_detalleestandar.ide_claveservicio=:vserviciou 
// /*and  `red_indicador`=-1*/ and tmp_dosresultados.usuario=:usuario and 
// concat(cue_reactivosestandardetalle.sec_numseccion,'.',
//cue_reactivosestandardetalle.r_numreactivo,'.',
//cue_reactivosestandardetalle.re_numcomponente,'.', ide_numcaracteristica3)=:referencia
//  GROUP BY
//	cue_reactivosestandardetalle.sec_numseccion,cue_reactivosestandardetalle.r_numreactivo,
//  cue_reactivosestandardetalle.re_numcomponente,cue_reactivosestandardetalle.re_numcaracteristica,
//  cue_reactivosestandardetalle.re_numcomponente2,cue_reactivosestandardetalle.red_numcaracteristica2, 
//mes, 6mes,12mes,tmp_dosresultados.resultado ";
//            
//	    $parametros = array("vserviciou" => $this->servicio, "usuario" => $_SESSION["UsuarioInd"]);
//               $parametros["mes_pivote"] = $mes_pivote;
//                $parametros["fmes_consulta"] = $fecha_consulta_fin;
//        $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
//        $parametros["referencia"]=$referencia;
//	    // echo "<br>***********************************************<br>";
//	    $rs_sql_reporte_e = Conexion::ejecutarQuery($sql, $parametros);
//            return $rs_sql_reporte_e;
//      }
      
      
      public function cumplimientoDetalleEstandarRes1( $referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote,$filx,$fily){
          $sql="SELECT
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,1,0),0),if(ide_aceptado<0,1,0))) as pasa,
sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as tot,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,

concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) as refer,
red_tipodato,red_valormin,red_clavecatalogo ,cue_reactivosestandardetalle.sec_numseccion seccion,
  if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')=:fmes_consulta,1,0) as mes,
           if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote 
     and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,
           if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
           and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes
         
 FROM
ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio
 AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion 
 AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo 
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente 
 AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
 AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica 
 AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
     INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id` 
    
    where ins_generales.i_claveservicio=:vserviciou ";
          $parametros = array("vserviciou" => $this->servicio, "usuario" => $_SESSION["UsuarioInd"]);
          $sql.=" AND ca_unegocios.une_cla_zona = ".$filx["zon"];
                   if (isset($fily["cta"]) && $fily["cta"] != "") {
                       $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
                    $parametros["cta"] = $fily["cta"];
                }
             
                if (isset($filx["edo"]) && $filx["edo"] != "") {
                    $sql .= " and ca_unegocios.une_cla_estado=:reg";
                    $parametros["reg"] = $filx["edo"];
                }
                if (isset($filx["ciu"]) && $filx["ciu"] != "") {
                    $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
                    $parametros["ciu"] = $filx["ciu"];
                }
                if (isset($filx["niv6"]) && $filx["niv6"] != "") {
                    $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
                    $parametros["niv6"] = $filx["niv6"];
                }
                if (isset($fily["fra"]) && $fily["fra"] != "") {
                    $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
                    $parametros["fra"] = $fily["fra"];
                }
                $sql.="
and cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
ins_detalleestandar.ide_claveservicio=:vserviciou
 and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>=:mes_consulta_ant
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fmes_consulta
     
  AND CONCAT(cue_reactivosestandardetalle.sec_numseccion, '.', cue_reactivosestandardetalle.r_numreactivo, '.',
            cue_reactivosestandardetalle.re_numcomponente, '.', ide_numcaracteristica3) = :referencia
       and concat(ins_detalleestandar.ide_numreporte,'.', 
ins_detalleestandar.ide_numrenglon) not in (select concat(tmp_dosresultados.numreporte ,'.',
tmp_dosresultados.renglon) from tmp_dosresultados where usuario=:usuario and resultado='R2')
  GROUP BY
	cue_reactivosestandardetalle.sec_numseccion,cue_reactivosestandardetalle.r_numreactivo,
  cue_reactivosestandardetalle.re_numcomponente,cue_reactivosestandardetalle.re_numcaracteristica,
  cue_reactivosestandardetalle.re_numcomponente2,cue_reactivosestandardetalle.red_numcaracteristica2, 
mes, 6mes,12mes ";
            
	           $parametros["mes_pivote"] = $mes_pivote;
                $parametros["fmes_consulta"] = $fecha_consulta_fin;
        $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
        $parametros["referencia"]=$referencia;
	    // echo "<br>***********************************************<br>";
	    $rs_sql_reporte_e = Conexion::ejecutarQuery($sql, $parametros);
            return $rs_sql_reporte_e;
      }
          
       public function cumplimientoDetalleEstandarRes2( $referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote,$filx,$fily){
          
           $sql="SELECT
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,1,0),0),if(ide_aceptado<0,1,0))) as pasa,
sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as tot,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, 
red_parametroing,
               
concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) as refer,
cue_reactivosestandardetalle.sec_numseccion seccion,
  if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')=:fmes_consulta,1,0) as mes,
           if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote
     and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,
           if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
           and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes
               
 FROM
ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio
 AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion
 AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente
 AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion
AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
 AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
 AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
     INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id`
               
    where ins_generales.i_claveservicio=:vserviciou ";
           $parametros = array("vserviciou" => $this->servicio, "usuario" => $_SESSION["UsuarioInd"]);
           $sql.=" AND ca_unegocios.une_cla_zona = ".$filx["zon"];
           if (isset($fily["cta"]) && $fily["cta"] != "") {
               $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
               $parametros["cta"] = $fily["cta"];
           }
        
           if (isset($filx["edo"]) && $filx["edo"] != "") {
               $sql .= " and ca_unegocios.une_cla_estado=:reg";
               $parametros["reg"] = $filx["edo"];
           }
           if (isset($filx["ciu"]) && $filx["ciu"] != "") {
               $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
               $parametros["ciu"] = $filx["ciu"];
           }
           if (isset($filx["niv6"]) && $filx["niv6"] != "") {
               $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
               $parametros["niv6"] = $filx["niv6"];
           }
           if (isset($fily["fra"]) && $fily["fra"] != "") {
               $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
               $parametros["fra"] = $fily["fra"];
           }
           $sql.="
 and cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
ins_detalleestandar.ide_claveservicio=:vserviciou
 and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>=:mes_consulta_ant
  and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fmes_consulta
               
  AND CONCAT(cue_reactivosestandardetalle.sec_numseccion, '.', cue_reactivosestandardetalle.r_numreactivo, '.',
            cue_reactivosestandardetalle.re_numcomponente, '.', ide_numcaracteristica3) = :referencia
       and concat(ins_detalleestandar.ide_numreporte,'.',
ins_detalleestandar.ide_numrenglon) not in (select concat(tmp_dosresultados.numreporte ,'.',
tmp_dosresultados.renglon) from tmp_dosresultados where usuario=:usuario)
  GROUP BY
	cue_reactivosestandardetalle.sec_numseccion,cue_reactivosestandardetalle.r_numreactivo,
  cue_reactivosestandardetalle.re_numcomponente,cue_reactivosestandardetalle.re_numcaracteristica,
  cue_reactivosestandardetalle.re_numcomponente2,cue_reactivosestandardetalle.red_numcaracteristica2,
mes, 6mes,12mes 
union SELECT 
SUM( IF(resultado = 'R2', IF(ide_aceptado < 0, 1, 0), 0 )) AS pasa,
    SUM(IF(resultado = 'R2', 1, 0)) AS tot,
   red_estandar,
    red_parametroesp,
    red_parametroing,
 CONCAT(cue_reactivosestandardetalle.sec_numseccion, '.', cue_reactivosestandardetalle.r_numreactivo, '.', 
            cue_reactivosestandardetalle.re_numcomponente, '.', cue_reactivosestandardetalle.re_numcaracteristica, '.', 
            cue_reactivosestandardetalle.re_numcomponente2, '.', cue_reactivosestandardetalle.red_numcaracteristica2) AS referencia,
 cue_reactivosestandardetalle.sec_numseccion,
  if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d')=:fmes_consulta,1,0) as mes,
       if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d') >=:mes_pivote
 and STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:fmes_consulta ,2,0 ) as 6mes,
       if(STR_TO_DATE(mes_asignacion,'%Y-%m-%d') >:mes_consulta_ant 
       and STR_TO_DATE(mes_asignacion,'%Y-%m-%d') <=:fmes_consulta ,3,0)  as 12mes
    FROM
        ins_detalleestandar
    INNER JOIN cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio
        AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion
        AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo
        AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente
        AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
    INNER JOIN cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
        AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion
        AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
        AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
        AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
        AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
        AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
    INNER JOIN tmp_dosresultados ON ins_detalleestandar.ide_numreporte = tmp_dosresultados.numreporte
        AND renglon = ide_numrenglon
    WHERE
        cue_reactivosestandar.re_tipoevaluacion > 0
            AND ide_valorreal <> ''
            AND ins_detalleestandar.ide_claveservicio = :vserviciou
            AND tmp_dosresultados.usuario = :usuario
            AND CONCAT(cue_reactivosestandardetalle.sec_numseccion, '.', cue_reactivosestandardetalle.r_numreactivo, '.',
            cue_reactivosestandardetalle.re_numcomponente, '.', ide_numcaracteristica3) = :referencia
            GROUP BY referencia , mes , 6mes , 12mes ";
            
	   // $parametros = array("vserviciou" => $this->servicio, "usuario" => $_SESSION["UsuarioInd"]);
               $parametros["mes_pivote"] = $mes_pivote;
                $parametros["fmes_consulta"] = $fecha_consulta_fin;
        $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
        $parametros["referencia"]=$referencia;
	    // echo "<br>***********************************************<br>";
	    $rs_sql_reporte_e = Conexion::ejecutarQuery($sql, $parametros);
            return $rs_sql_reporte_e;
      }
          
//       public function cumplimientoDetalleEstandarRes2( $referencia,$fecha_consulta_ini,$fecha_consulta_fin,$mes_pivote,$filx,$fily){
//           $sql="SELECT
// sum(if(ide_aceptado<0,1,0)) as pasa,

// cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,
              
// concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) as refer,
// red_tipodato,red_valormin,red_clavecatalogo ,cue_reactivosestandardetalle.sec_numseccion seccion,
//   if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')=:fmes_consulta,1,0) as mes,
//            if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote
//      and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,
//            if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
//            and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes
              
//  FROM
// ins_detalleestandar
// Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio
//  AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion
//  AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo
//  AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente
//  AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
// Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
// AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion
// AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
//  AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
//  AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
//  AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
//  AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
// Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
//     Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
//      INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id`
              
//     where ins_generales.i_claveservicio=:vserviciou ";
//           $parametros = array("vserviciou" => $this->servicio, "usuario" => $_SESSION["UsuarioInd"]);
//           $sql.=" AND ca_unegocios.une_cla_zona = ".$filx["zon"];
//           if (isset($fily["cta"]) && $fily["cta"] != "") {
//               $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
//               $parametros["cta"] = $fily["cta"];
//           }
//           if (isset($filx["reg"]) && $filx["reg"] != "") {
//               $sql .= " and ca_unegocios.une_cla_estado=:reg";
//               $parametros["reg"] = $filx["reg"];
//           }
//           if (isset($filx["ciu"]) && $filx["ciu"] != "") {
//               $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
//               $parametros["ciu"] = $filx["ciu"];
//           }
//           if (isset($filx["niv6"]) && $filx["niv6"] != "") {
//               $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
//               $parametros["niv6"] = $filx["niv6"];
//           }
//           if (isset($fily["fra"]) && $fily["fra"] != "") {
//               $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
//               $parametros["fra"] = $fily["fra"];
//           }
//           $sql.="
// and cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
// ins_detalleestandar.ide_claveservicio=:vserviciou
//  and   STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y')>=:mes_consulta_ant
//   and         STR_TO_DATE(CONCAT('01.', ins_generales.i_mesasignacion),'%d.%m.%Y') <=:fmes_consulta
//        AND CONCAT(cue_reactivosestandardetalle.sec_numseccion, '.', cue_reactivosestandardetalle.r_numreactivo, '.',
//             cue_reactivosestandardetalle.re_numcomponente, '.', ide_numcaracteristica3) = :referencia
          
//    GROUP BY
// 	cue_reactivosestandardetalle.sec_numseccion,cue_reactivosestandardetalle.r_numreactivo,
//   cue_reactivosestandardetalle.re_numcomponente,cue_reactivosestandardetalle.re_numcaracteristica,
//   cue_reactivosestandardetalle.re_numcomponente2,cue_reactivosestandardetalle.red_numcaracteristica2,
// mes, 6mes,12mes ";
          
//           $parametros["mes_pivote"] = $mes_pivote;
//           $parametros["fmes_consulta"] = $fecha_consulta_fin;
//           $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
//           $parametros["referencia"]=$referencia;
//           // echo "<br>***********************************************<br>";
//           $rs_sql_reporte_e = Conexion::ejecutarQuery($sql, $parametros);
//           return $rs_sql_reporte_e;
//       }
      
      public function consutaDetalleEstandar($reporte,$servicio,$renglon1,$renglon2,$caracteristicas,$usuario,$seccion,$carproducto,$filx,$fily,$fecha_consulta_ini,$fecha_consulta_fin){
                $sql3="SELECT ide_numreporte,ide_numcaracteristica3,
ide_valorreal,ide_numrenglon, ide_claveservicio,
red_parametroesp,";
                if($seccion=='8.0.1'){
$sql3.=" sum(if(ide_numcaracteristica3=1 and ide_numrenglon=:ren1,ide_valorreal,null)) as numsis1,
        sum(if(ide_numcaracteristica3=1 and ide_numrenglon=:ren2,ide_valorreal,null)) as numsis2,
        sum(if(ide_numcaracteristica3=2 and ide_numrenglon=:ren1,ide_valorreal,null)) as fuente1,
        sum(if(ide_numcaracteristica3=2 and ide_numrenglon=:ren2,ide_valorreal,null)) as fuente2,
        sum(if(ide_numcaracteristica3=3 and ide_numrenglon=:ren1,ide_valorreal,null)) as valvula1,
        sum(if(ide_numcaracteristica3=3 and ide_numrenglon=:ren2,ide_valorreal,null)) as valvula2";

       }
       if($seccion=='8.0.2'){
$sql3.=" sum(if(ide_numcaracteristica3=3 and ide_numrenglon=:ren1,ide_valorreal,null)) as numsis1,
        sum(if(ide_numcaracteristica3=3 and ide_numrenglon=:ren2,ide_valorreal,null)) as numsis2,
        sum(if(ide_numcaracteristica3=2 and ide_numrenglon=:ren1,ide_valorreal,null)) as fuente1,
        sum(if(ide_numcaracteristica3=2 and ide_numrenglon=:ren2,ide_valorreal,null)) as fuente2,
        1 as valvula1,
        1 as valvula2";

       }
$sql3.=" FROM cue_reactivosestandardetalle

Inner Join ins_detalleestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
 ";
    $parametros=array("servicio"=>$servicio,"reporte"=>$reporte,"ren1"=>$renglon1,"ren2"=>$renglon2,"seccion"=>$seccion);
      
                $sql3.=" where concat(cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente)= :seccion
and ide_numcaracteristica3 in (".$caracteristicas.") and
cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
ins_detalleestandar.ide_claveservicio=:servicio
  

 and ins_detalleestandar.ide_numreporte=:reporte and
 ins_detalleestandar.ide_numrenglon in (".$renglon1.",".$renglon2.")
 group by cue_reactivosestandardetalle.ser_claveservicio,ide_numreporte

";
//                 $parametros["fmes_consulta"] = $fecha_consulta_fin;
//                 $parametros["mes_consulta_ant"] = $fecha_consulta_ini;
         $result = Conexion::ejecutarQuery($sql3,$parametros);
         return $result;
          }
          public function verificaReactivos($reporte,$servicio,$renglon1,$renglon2,$reactivo,$usuario,$seccion,$carproducto,$filx,$fily,$fecha_consulta_ini,$fecha_consulta_fin){
       
            //para ese renglon busco que tenga 2 resultados del 1, 2 y 3
              $result=$this->consutaDetalleEstandar($reporte, $servicio, $renglon1,$renglon2, $reactivo, $usuario,$seccion,$carproducto,$filx,$fily,$fecha_consulta_ini,$fecha_consulta_fin);
        if(!empty($result))
        {
            
        foreach($result as $row)
          //  echo "<br>--".$row["ide_numreporte"];
        //echo "  ".$row["numsis1"]."--".$row["numsis2"]."--".$row["fuente1"]."--".$row["fuente2"]."--".$row["valvula1"]."--".$row["valvula2"];
            if($row["numsis1"]==$row["numsis2"]&&$row["fuente1"]==$row["fuente2"]&&$row["valvula1"]==$row["valvula2"])
            { //echo "si";
                return true;}
         return false; 
        }
    }
}
