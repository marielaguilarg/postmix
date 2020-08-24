<?php

// $seccion2 = array("5.0.2.18", "5.0.2.17", "5.0.2.5", "5.0.2.9",
//     "5.0.2.1", "5.0.2.2", "5.0.2.3", "5.0.2.4", "5.0.2.6", "5.0.2.7", "5.0.2.8", "5.0.2.10",
//     "5.0.2.11", "5.0.2.12", "5.0.2.13", "5.0.2.16", "5.0.2.19", "5.0.2.20");
// $_SESSION["UsuarioInd"]="marisol";
// $gj=new Graficajson("AGUA","E","1.1.3","",$seccion2,"06.2020");
// $gj->insertarReportesTemp();
// $gj->consultarBD();
include 'Controllers/indpostmix/tablaDinamicaController.php';
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

    // array con los datos para json
    public function __construct() {
        
    }

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
        $this->filperiodo = filter_input(INPUT_GET, "mes", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->tipo = filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->servicio = 1;
    }

    public function validarPermisoUsusario() {
        
    }

    public function generarJSON() {

        if ($this->tipo == "E") {
            $seccion = array("8", "5");
            $this->consultarBDEstandar($seccion);
        }
        if ($this->tipo == "S") {
            $secciones = array(["2.10"],
                ["2.11"],
                ["2.8"],
             //   ["2.8.1", "E"],
                ["3.11", ""],
                ["3.15", ""],
                ["3.8.1.0.0.1", "A"],
                ["2.15"]
            );
            $this->consultarBDServicio($secciones);
        }
        if ($this->tipo == "O") {
            $secciones = array(["2.9"],
                ["3.8.1.0.0", "A"],
                ["2.7"],
                ["2.6"],
                ["3.23", ""],
                ["3.19", ""]
            );
            $this->consultarBDServicio($secciones);
        }
        if ($this->tipo == "IC") {
            $secciones = array(["2.17"],
                ["2.14"],
                ["3.3"],
                ["3.6", ""],
                ["2.3", ""]
                ["3.4"]
            );
            $this->consultarBDServicio($secciones);
        }
          if ($this->tipo == "IG") {
            $secciones = array(["2.13"],
               
                ["3.3"],
                 ["3.4"],
                  ["3.6"],
                ["6", "V"],
                ["3.9", ""],
                ["4.3"],
                 ["4.4"],
                 ["4.7"],
                 ["4.12"],
            );
            $this->consultarBDServicio($secciones);
        }

         if ($this->tipo == "DetN") {
            $secciones = filter_input(INPUT_GET, "ref", FILTER_SANITIZE_SPECIAL_CHARS);
            $this->compararxNivel($secciones);
        }
         if ($this->tipo == "DetM") {
            $secciones = filter_input(INPUT_GET, "ref", FILTER_SANITIZE_SPECIAL_CHARS);
            $this->compararMesAnterior($secciones);
      //      echo "fin aqui";
        }



        //   $grupo = $_SESSION["GrupoUs"];
        // var_dump($refer);
//        if (isset($this->chart["error"])) {
//            
//        }else
        //  die();
//            for ($z = 0; $z < sizeof( $this->chart); $z ++) {
//                // print //$gf->lineaSemaforo($alto,$x1,$refer[$z]);
//                //                 $arrsemaforo = $gf->buscaRangosSem($refer[$z]);
//                //                 $chart[$z][3] = $arrsemaforo["r1"];
//                //                 $chart[$z][4] = $arrsemaforo["r2"];
//                //                 $chart[$z][5] = $arrsemaforo["a1"];
//                //                 $chart[$z][6] = $arrsemaforo["a2"];
//                //                 $chart[$z][7] = $arrsemaforo["v1"];
//                //                 $chart[$z][8] = $arrsemaforo["v2"];
//                
//             //   $this->chart[$z]["fill"] = $coloresgraf[$z];
//             //   $this->chart[$z]["label"]["enabled"] = " true";
//                if ($grupo == "cue") {
//                    $this->chart[$z][4] = "index.php?action=indindicadoresgrid&admin=cons&mes=" . $this->filperiodo . "&sec=" . $this->seccion . "&filx=" . $this->filnivel. "&fily=" . $this->filcuenta. "&ref=" . $this->chart[$z][3];
//                            //"&niv=" . $this->nivel . "&ren=F&rdata=0.0.1&bg=1&filuni=" . $this->filnivel;
//                } else {
//                    $this->chart[$z][4] = "index.php?action=indindicadoresgrid&admin=cons&mes=" . $this->filperiodo  . "&sec=" . $this->seccion . "&filx=" . $this->filnivel . "&fily=" . $this->filcuenta . "&ref=" . $this->chart[$z][3]. "&niv=" . $this->nivel . "&bg=1&filuni=" . $this->filnivel;
//                }
//            
//        }
        // $sufijo=(strlen($unidades[$subseccion])<4)?$unidades[$subseccion]:"";
        // echo "<pre>";
        // //print_r($chart);
        // echo "</pre>";

        print json_encode($this->chart);
    }

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
        $fmes_consulta = $aux[1] . "-" . $aux[0] . "-01";
        $mes_consulta_ant = ($aux[1] - 1) . "-" . $aux[0] . "-01";
        $listasec = "";
        foreach ($seccion as $opcion) {
            $listasec .= $opcion . " ,";
        }
        //  $result = DatosEst::consultaGraficaIndicador($this->servicio, $this->seccion, $filx, null, $filuni, $fmes_consulta, $mes_consulta_ant);
        $result = DatosEst::consultaGraficaCumplimientotmp($listasec, $this->servicio, $usuario, $fmes_consulta, $mes_consulta_ant, $mes_pivote);


        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            foreach ($result as $row) {

                $periodo = $acept = $acumtot = 0;


                if ($_SESSION["idiomaus"] == 2) {
                    $nomseccion = $row["red_parametroing"];
                } else {
                    $nomseccion = $row["red_parametroesp"];
                }
                $estandar = $row["red_estandar"];
                $matriz[$nomseccion]["datos"] = $estandar . "-" . $row["refer"];
                
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
            $j = 0;
            foreach ($matriz as $key => $rowt) {

                $secc_actual = $key;
                //   print_r($secc_actual."<br>");
                  if($secc_actual!=$secc_ant){
                      
                  }
                $this->chart[$rowt["sec"]][$j] = array($secc_actual, $rowt["datos"]);
                for ($i = 1; $i < 4; $i++) {
                    if (isset($rowt[$i]) && $rowt[$i]["tot"] != 0)
                        $this->chart[$rowt["sec"]][$j][$i + 1] = Utilerias::redondear2($rowt[$i]["acep"] / $rowt[$i]["tot"]*100, 2);
                    else
                        $this->chart[$rowt["sec"]][$j][$i + 1] = 0;
                }
                //}
                $secc_ant = $secc_actual;
                $j++;
            }
            
            
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

    public function consultarBDPonderada() {
        $usuario = $_SESSION["UsuarioInd"];

        $listasec = "";
        foreach ($this->seccion as $opcion) {
            $listasec .= $opcion . " ,";
        }
        $result = DatosPond::graficaCumplimiento($listasec, $this->servicio, $usuario);




        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            if ($_SESSION["idiomaus"] == 2)
                $campo = "r_descripcioning";
            else
                $campo = "r_descripcionesp";
            foreach ($result as $rowt) {

                $this->chart[] = array(
                    $rowt[$campo],
                    "",
                    Utilerias::redondear($rowt["nivaceptren"]),
                    $rowt["ref"]);
            }
        } else { // sino ponemos un valor por omision para que no marque error
            // echo "default";
            // $this->chart [ ]=null;
            $this->chart["error"] = T_("No hay datos suficientes para generar la grafica");
        }
    }

    public function consultarBDInocuidad($seccionprod) {
        $usuario = $_SESSION["UsuarioInd"];

        //empiezo con las ponderadas
        $listasec = "";
        foreach ($this->seccion as $opcion) {
            $listasec .= $opcion . " ,";
        }
        $result = DatosPond::graficaCumplimiento($listasec, $this->servicio, $usuario);

        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            if ($_SESSION["idiomaus"] == 2)
                $campo = "r_descripcioning";
            else
                $campo = "r_descripcionesp";
            foreach ($result as $rowt) {

                $this->chart[] = array(
                    $rowt[$campo],
                    "",
                    Utilerias::redondear($rowt["nivaceptren"]),
                    $rowt["ref"]
                );
            }
        } else { // sino ponemos un valor por omision para que no marque error
            // echo "default";
            // $this->chart [ ]=null;
            $this->chart["error"] = T_("No hay datos suficientes para generar la grafica");
            return;
        }
        //seccion de jarabes
        $result = DatosProducto::consultaGraficaCumplimiento($seccionprod, $this->servicio, $usuario);
        if ($_SESSION["idiomaus"] == 2)
            $campo = "sec_descripcioning";
        else
            $campo = "sec_descripcionesp";
        foreach ($result as $rowt) {

            $this->chart[] = array(
                $rowt[$campo],
                "",
                Utilerias::redondear($rowt["NIVELACEPTACION"]),
                $rowt["sec"]
            );
        }
    }

    public function consultarBDServicio($secciones) {




        $usuario = $_SESSION["UsuarioInd"];

        //empiezo con las ponderadas
        $listasecp = $listaseca =$seccionj= "";
        foreach ($secciones as $opcion) {
            if (!empty($opcion[1])&&$opcion[1]=="A")
                $listaseca .= $opcion[0] . ",";
            else
           if (!empty($opcion[1])&&$opcion[1]=="V")
                $seccionj .= "'".$opcion[0] . "',";
            else
                $listasecp .= "'".$opcion[0] . "',";
        }
        $result = DatosPond::graficaCumplimiento($listasecp, $this->servicio, $usuario);

        if (isset($result) && sizeof($result) > 0) { // si hay datos los despliegan
            if ($_SESSION["idiomaus"] == 2)
                $campo = "r_descripcioning";
            else
                $campo = "r_descripcionesp";
            foreach ($result as $rowt) {

                $this->chart[] = array(
                    $rowt[$campo],
                    "",
                    Utilerias::redondear($rowt["nivaceptren"]),
                    $rowt["ref"]
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
              
        $resultab = DatosAbierta::consultaGraficaCumplimiento($usuario, $this->servicio,substr($listaseca,0,strlen($listaseca)-1) );
        if ($_SESSION["idiomaus"] == 2)
            $campo = "rad_descripcioning";
        else
            $campo = "rad_descripcionesp";
      //  var_dump($resultab);
      
        foreach ($resultab as $rowt) {

            $this->chart[] = array(
                $rowt[$campo],
                ">25",
                Utilerias::redondear($rowt["nivaceptren"]),
                $rowt["refer"]
            );
        }
          }
        if(!empty($seccionj)){
              $resultj = DatosProducto::consultaGraficaCumplimiento($seccionj, $this->servicio, $usuario);
               if ($_SESSION["idiomaus"] == 2)
            $campo = "sec_descripcioning";
        else
            $campo = "sec_descripcionesp";
        foreach ($resultj as $rowt) {

            $this->chart[] = array(
                $rowt[$campo],
                ">25",
                Utilerias::redondear($rowt["NIVELACEPTACION"]),
                6
            );
        }
        }
    }

    public function mostarGrafica() {
        
    }
    
    /*****************
     * Consulta para la graf dec omparación por nivel
     * Llega la fecha de inicio y fecha de fin como mm.yyyy
     * referencia: 1.2.3 seccion y reactivo
     * filx y fily como arreglo para los niveles y cuenta
     */
      function compararxNivel( $referencia) {
        if ($this->filnivel == "") {
            $this->filnivel = "1.1";
        }
        
        $this->servicio = 1; // siempre es 1
        $aux = explode(".", $this->filnivel);
         $nivel=sizeof($aux);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        $auxp = explode('.', $this->filperiodo);
      
        $fecha_consulta_ini=$fecha_consulta_fin = $auxp[1] . "-" . $auxp[0] . "-01";

        // reviso el tipo de evaluacion
        $eval = TablaDinamicaController::consTipoEvaluacion(1, $referencia);
  
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
         
    ca_nivel4.n4_id,
ca_nivel4.n4_nombre,";
          if (isset($filx["reg"]) && $filx["reg"] != "") {
            $sql .= " ca_nivel5.n5_nombre";
          }
             if (isset($filx["ciu"]) && $filx["ciu"] != "") { 
         $sql .= "   ca_nivel6.n6_nombre";
             }
               if (isset($filx["ciu"]) && $filx["ciu"] != "") { 
                    $sql .= "   ca_nivel6.n6_nombre";
             
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
     if (isset($filx["zon"]) && $filx["zon"] != "") {
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
        }
        //$sql .= " and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta
        $sql .= " and ins_generales.i_mesasignacion =:mes_consulta 

AND ide_valorreal<>'' 
    
and
ins_detalleestandar.ide_numseccion=:seccion and
ins_detalleestandar.ide_numreactivo=:reac and
ins_detalleestandar.ide_numcomponente=:com and
ins_detalleestandar.ide_numcaracteristica1=:carac1 and
ins_detalleestandar.ide_numcaracteristica2=:carac2 and
ins_detalleestandar.ide_numcaracteristica3=:carac3 ";
        $parametros["mes_consulta"] = $this->filperiodo;
       // $parametros["fmes_consulta"] = $fecha_consulta_fin;
    
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
      
        $sql .= " GROUP BY";
//if($es_cuenta)
//    
// $sql .=" ca_unegocios.cue_clavecuenta ";
        if (isset($filx["zon"]) && $filx["zon"] != "")
            $sql .= "   ca_unegocios.une_cla_estado";
        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql .= " ,ca_unegocios.fc_idfranquiciacta";
     
        if (isset($filx["reg"]) && $filx["reg"] != "")
            $sql .= " ,ca_unegocios.une_cla_ciudad";
        if (isset($filx["ciu"]) && $filx["ciu"] != "")
            $sql .= " ,ca_unegocios.une_cla_franquicia";
        if ((isset($fily["fra"]) && $fily["fra"] != ""))
            $sql .= " ,une_id";
 
        $sql .= " order by ";
//        if($es_cuenta)
//    
// $sql .=" ca_unegocios.cue_clavecuenta,";

 $sql .=" ca_unegocios.une_cla_estado, anio_asig desc, mes_asig desc";

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
                
                   echo "ss".$region;

                if ( $region) {

                    $matriz[$region]["acep"] = $acept;
                    $matriz[$region]["tot"] = $acumtot;
                    $total["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                    $total["tot"] += $acumtot;
                }
//     
            }
        }
//        echo "<pre>";
//        var_dump($matriz);
//        echo "</pre>";
      
        //paso al erreglo para las gráficas
         $this->chart[]=array("REGION TODAS (".$total["tot"]." AUDIT)",Utilerias::redondear2($total["acep"]/  $total["tot"]*100,2));
        foreach($matriz as $key=>$renglon){
            
            $this->chart[] = array($key."(".$renglon["tot"]." AUDIT)",Utilerias::redondear2($renglon["acep"]/  $renglon["tot"]*100,2));
            
        }
        
     //   var_dump($this->chart);
   
        
        
    }
     /*****************
     * Consulta para la graf dec omparación por cuenta con mes anterior
     * Llega la fecha de inicio y fecha de fin como mm.yyyy
     * referencia: 1.2.3 seccion y reactivo
     * filx y fily como arreglo para los niveles y cuenta
     */
    
     function compararMesAnterior( $referencia) {
        if ($this->filnivel == "") {
            $this->filnivel = "1.1";
        }
        
        $this->servicio = 1; // siempre es 1
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
       
        $auxp = explode('.', $this->filperiodo);
//        $mes = $auxp[0];
//        if ($mes >= 1) { // calculo para los 6m
//        	$z = $mes - 1;
//        	
//        	$fecha_consulta_ini = $auxp[1] . "-" . $z . "-01";
//        } else {
//        	
//        	
//        	$fecha_consulta_ini = $this->filperiodo . "-01";
//        }
//       
//        $fecha_consulta_fin = $auxp[1] . "-" . $auxp[0] . "-01";

           $mes = $auxp[0];
       if ($mes >= 1) { // calculo para los 6m
        	$z = $mes - 1;
        	
        	$fecha_consulta_ini = $z.".". $auxp[1] ;
        } else {
       	
        	
        	$fecha_consulta_ini = $this->filperiodo ;
        }
       
      //  $fecha_consulta_fin = $auxp[1] . "-" . $auxp[0] . "-01";

        // reviso el tipo de evaluacion
        $eval = TablaDinamicaController::consTipoEvaluacion(1, $referencia);
  
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
cue_reactivosestandardetalle.red_estandar,";
      
 
            $sql .= " if(ins_generales.i_mesasignacion=:mes_consulta,'mesant', if(i_mesasignacion =:fmes_consulta,'mes','limbo'
  )) as indica_mes,";
           
       
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
           $sql .= " and ins_generales.i_mesasignacion=:fmes_consulta or ins_generales.i_mesasignacion=:mes_consulta
AND ide_valorreal<>'' 
    
and
ins_detalleestandar.ide_numseccion=:seccion and
ins_detalleestandar.ide_numreactivo=:reac and
ins_detalleestandar.ide_numcomponente=:com and
ins_detalleestandar.ide_numcaracteristica1=:carac1 and
ins_detalleestandar.ide_numcaracteristica2=:carac2 and
ins_detalleestandar.ide_numcaracteristica3=:carac3 ";
        $parametros["mes_consulta"] =$fecha_consulta_ini ;
        $parametros["fmes_consulta"] = $this->filperiodo;
    
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
      
        $sql .= " GROUP BY ca_unegocios.cue_clavecuenta, indica_mes ";
        if (isset($filx["zon"]) && $filx["zon"] != "")
            $sql .= "   ,ca_unegocios.une_cla_estado";
        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql .= " ,ca_unegocios.fc_idfranquiciacta";
     
        if (isset($filx["reg"]) && $filx["reg"] != "")
            $sql .= " ,ca_unegocios.une_cla_ciudad";
        if (isset($filx["ciu"]) && $filx["ciu"] != "")
            $sql .= " ,ca_unegocios.une_cla_franquicia";
        if ((isset($fily["fra"]) && $fily["fra"] != ""))
            $sql .= " ,une_id";
 
        $sql .= " order by  ca_unegocios.cue_clavecuenta,";

 $sql .=" ca_unegocios.une_cla_estado, anio_asig desc";

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
                
                 //  echo "ss".$cuenta;

             

                    $matriz[$cuenta][$row["indica_mes"]]["acep"] = $acept;
                    $matriz[$cuenta][$row["indica_mes"]]["tot"] = $acumtot;
                    $total[$row["indica_mes"]]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                    $total[$row["indica_mes"]]["tot"] += $acumtot;
                
//     
            }
        }
//        echo "<pre>";
//        print_r($matriz);
//        echo "</pre>";
        //paso al erreglo para las gráficas
        $this->chart[]=array("TOTAL",Utilerias::redondear2($total["mesant"]["acep"]/  $total["mesant"]["tot"]*100,2),
            $total["mesant"]["tot"],
            Utilerias::redondear2($total["mes"]["acep"]/  $total["mes"]["tot"]*100,2),
              $total["mes"]["tot"]);
        foreach($matriz as $key=>$renglon){
            if($renglon["mes"]["tot"]==0)
                $val2="0";
            else
                $val2= Utilerias::redondear2($renglon["mes"]["acep"]/  $renglon["mes"]["tot"]*100,2);
            if($renglon["mesant"]["tot"]==0)
                $val1=0;
            else $val1=  Utilerias::redondear2($renglon["mesant"]["acep"]/  $renglon["mesant"]["tot"]*100,2);
            $this->chart[] = array($key,
             $val1 ,
                $renglon["mesant"]["tot"],
               $val2 ,
                $renglon["mes"]["tot"]
                );
            
        }
        
//         var_dump($this->chart);
//        
//          echo "<pre>";
//       print_r($this->chart);
//         echo "</pre>";
//         echo json_encode($this->chart);
    }
    

}
