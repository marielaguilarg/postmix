<?php


$maxte=ini_get('max_execution_time');
ini_set('max_execution_time',400);
//error_reporting(0);

// Notificar solamente errores de ejecución

error_reporting(E_ERROR | E_PARSE);
class TablaDinamicaController {

    private $usuarioSes;
    private $ligaInicio;
    private $ligaIMPRIMIREXP;
    private $ligaResgresar;
    private $mes_asig;
    private $ligaDescargar;
    private $nombreSeccion;
    private $estandar;
    private $listaResultados;
    private $servicio;
    private $cliente;
    private $ren;
    private $vrangov;
    private $vrangoa;
    private $vrangor;
    private $periodos;
    private $lb_rangosel;
    private $filtroSel;
    private $filtrosTD;
    private $url_imagen;
    private $mensaje_error;
  

    public function vistaTablaDinamica() {
       include "Utilerias/leevar.php";
        $mes = filter_input(INPUT_GET, "mes", FILTER_SANITIZE_STRING);
        if (isset($mes)) {
            $mes_asig = filter_input(INPUT_GET, "mes", FILTER_SANITIZE_STRING);
        } else { // si no hay mes x defecto es el anterior
            $mes_asig = date("m.Y");
            $aux = explode(".", $mes_asig);

            $solomes = $aux[0] - 1;
            $soloanio = $aux[1];
            if ($solomes == 0) {
                $solomes = 12;
                $soloanio = $aux[1] - 1;
            }

            $mes_asig = $solomes . "." . $soloanio;
        }

           
        $aux = explode(".", $mes_asig);
        $solomes = $aux[0];

        $soloanio = $aux[1];

        if ($solomes - 12 >= 0) { // calculo para los 12m
            $z = $solomes - 12 + 1;

            $mes_pivote = $aux[1] . "-" . $z . "-01";
            $mes_pivote = $z . "." . $aux[1];
        } else {
            $z = $solomes + 1;

            $mes_pivote = ($aux[1] - 1) . "-" . $z . "-01";
            $mes_pivote = $z . "." . ($aux[1] - 1);
        }

//valido si es de alguna region o cuenta
        $grupo = $_SESSION["GrupoUs"];
        $vidiomau = $_SESSION["idiomaus"];
        $Usuario = $_SESSION["UsuarioInd"];

        $filtros = new ConsultaIndicadores;
        $this->filtroSel = $filtros;

//
        $this->servicio = 1;
        $this->cliente = 1;


        if ($_SESSION["GrupoUs"] == "adm" || $_SESSION["GrupoUs"] == "aud" || $_SESSION["GrupoUs"] == "mue") {
            $this->ligaInicio = '<li class="first">
        <a href="MEinicio.php" style="z-index:10;">' . T_("INICIO") . '</a></li>';
        }
        $imprimir = '<a href="#"><img src="../img/imprimir.png" alt="Imprimir" height="23"></a> 
    <a href="#"><img src="../img/descargar.png" alt="Descargar archivo" height="23"></a>';
        $this->ligaIMPRIMIREXP = $imprimir;
         
        $this->ligaResgresar = "MENindprincipal.php?op=indi";

// titulos de pesta�as
//busco secciones seleccionadas
        $seccion = filter_input(INPUT_GET, "sec", FILTER_SANITIZE_SPECIAL_CHARS);


        $gref = explode(".", $ref);

        $secciones = DatosEst::buscaSubSeccionIndi($seccion, $vidiomau,$this->servicio);

        $secdefault = $secciones[0][0];


//cambio mes a letra


        $mesletra = Utilerias::cambiaMesGIng($mes_pivote) . "-" . Utilerias::cambiaMesGIng($mes_asig);
//$base=getcwd();
//$url_img=substr($base,0,strrpos($base,'\\'))."\\img\\banner_pepsi.jpg";
//echo $url_img;



        $gfilx = $filx;

        $gfily = $fily;

        $gnivel = $niv; //es el nivel de consulta+1
        $nivel = $gnivel;
        $reng = $ren;

// verifico el tipo de usuario
        $permiso = UsuarioModel::validarRegionCuenta();
//echo $permiso;
// si permiso=-1 no ver� nada
        if ($permiso == -1) {
//             $html->asignar('veo_res', "none");
//             $html->asignar('noveo_res', "table-row");
            $this->mensaje_error= T_("LO SENTIMOS, NO CUENTA CON PERMISO PARA VER ESTA INFORMACION");
            $this->mes_asig= $mes_asig;
            $this->filtrosTD->setSec( $seccion);
            $this->filtrosTD->setNivel(7);
        } else {


            if ($grupo == "cue") {
                if (!isset($gnivel) || $gnivel == "")
                    $nivel = 4;
                if (!isset($ren) || $ren == "")
                    $reng = $permiso;
                if (!isset($fily)) //filtro inicial
                    $gfily = GraficaIndicadorController::buscaReferenciaNivelUni($Usuario, $grupo);
            }
            else {

                if (!isset($ren) || $ren == "")
                    $reng = "C";

                if ($permiso == 0 && (!isset($gnivel) || $gnivel == ""))
                //comienzo en el nivel 4
                    $nivel = 4;
                else {

                    if (isset($gnivel) && ($gnivel == $permiso + 1))
                        $nivel = $gnivel;
                    else {
                        if ((!isset($gnivel) || $gnivel == ""))
                            $nivel = ($permiso + 1);
                    }
                }
                if ($grupo == "cli" && $permiso > 3 && !isset($filx)) {// si no tengo filtro
                    $nivel++;
                    $gfilx = UsuarioModel::buscaReferenciaNivel();
                }

                if ($nivel < 4) {
                    $nivel = $gnivel;
                }
            }


            $aux = explode(".", $gfilx);

            $filx = array();
            $gfiluni = filter_input(INPUT_GET, "filuni", FILTER_SANITIZE_SPECIAL_CHARS);
            $auxuni = explode(".", $gfiluni);
            $filx["pais"] = $auxuni[0];
            $filx["uni"] = $auxuni[1];
            $filx["zon"] = $auxuni[2];
//$zona =$filx["zon"] ;
            $filx["reg"] = $aux[0];

            $filx["ciu"] = $aux[1];
            $filx["niv6"] = $aux[2];
            
            $auxy = explode(".", $gfily);

            $fily = array();
            //busco los indicadores de la seccion
            $referencia = DatosEst::buscaIndicadores($ref, $vidiomau, $this->servicio);

            $this->nombreSeccion = $referencia[0][1];
            $this->estandar = $referencia[0][2];
            $fily["cta"] = $auxy[0];

            $fily["fra"] = $auxy[1];
            $fily["pv"] = $auxy[2];

            $tituloliga = "INDICADORES";
            if ($filx["pais"] != "" && $filx["pais"] != 0) {

                $nompais = Datosnuno::nombreNivel1($filx["pais"], "ca_nivel1");
            }
            if ($filx["uni"] != "" && $filx["uni"] != 0) {

                $nomuni = Datosndos::nombreNivel2($filx["uni"], "ca_nivel2");
            }
            if ($filx["zon"] != "" && $filx["zon"] != 0) {

                $nomzon = "-" . Datosntres::nombreNivel3($filx["zon"], "ca_nivel3");
            }
            if ($filx["reg"] != "") {
                $nomreg = "- " . Datosncua::nombreNivel4($filx["reg"], "ca_nivel4");
                $tituloliga = $nomreg;
            }
            if ($filx["ciu"] != "") {
                $nomciu = "- " . Datosncin::nombreNivel5($filx["ciu"], "ca_nivel5");
                $tituloliga = $nomciu;
            }
            if ($filx["niv6"] != "") {
                $nomniv6 = "- " . Datosnsei::nombreNivel6($filx["niv6"], "ca_nivel6");
                $tituloliga = $nomniv6;
            }


//busco para barra de navegacion
//$usuario=$_SESSION["UsuarioInd"];


            $this->filtrosTD = new FiltrosTablaDinamica;

            if ($reng != "P" && $reng != "PP") {
                
            } else {
                $nivel = 7;
            }
            $this->filtrosTD->setMes($mes_asig);
            $this->filtrosTD->setFilx($gfilx);
            $this->filtrosTD->setFiluni($gfiluni);
            $this->filtrosTD->setNivel($nivel);
            $this->filtrosTD->setFily($gfily);
            $this->filtrosTD->setRef($ref);


            $this->filtrosTD->setRen($reng);
            $this->filtrosTD->setSec($seccion);

            if ($fily["cta"] != "") {
                $nomcta = DatosCuenta::nombreCuenta($fily["cta"],$this->cliente);
            }
            if ($fily["fra"] != "") {
                $nomfra = "- " . DatosFranquicia::nombreFranquicia($fily["cta"], $fily["fra"], $this->cliente, $this->servicio);
            }
            if ($fily["pv"] != "") {
                $nompv = "-" . DatosUnegocio::nombrePV($fily["pv"]);
            }
            $filtros->setNombre_nivel($nomuni . " " . $nomzon . " " . $nomreg . " " . $nomciu . " " . $nomniv6);
            $filtros->setNombre_franquicia($nomcta . " " . $nomfra . " " . $nompv);

            $filtros->setNombre_seccion(DatosSeccion::nombreSeccionIdioma($seccion, 1, $vidiomau));
            $filtros->setPeriodo($mesletra);
            //reviso los filtros de datos que se muestras
            $frdata = "";

            if (isset($visdatos1)) {
                $frdata .= "1.";
            } else {
                $frdata .= "0.";
            }
            if (isset($visdatos2)) {
                $frdata .= "1.";
            } else {
                $frdata .= "0.";
            }
            if (isset($visdatos3)) {
                $frdata .= "1.";
            } else {
                $frdata .= "0.";
            }

            if ($frdata == "0.0.0.")
                $frdata = "0.0.1"; //todos los filtros
            if (!isset($rdata))
                $rdata = "0.0.1"; //todos los filtros
            $auxpar = explode(".", $rdata);
            if ($auxpar[0])
                $this->filtrosTD->setRes_tamaniomuestra("checked");
            if ($auxpar[1])
                $this->filtrosTD->setRes_numpruebas("checked");


// reviso filtros de periodicidad
            if (!isset($per))
                $per = "0.0.1";
            // die($per);
            $this->filtrosTD->setFperiodo($per);
            $auxper = explode(".", $per);
            if ($auxper[0])
                $this->filtrosTD->setPer_measactual("checked");
            if ($auxper[1])
                $this->filtrosTD->setPer_seismeses("checked");
            if ($auxper[2])
                $this->filtrosTD->setPer_docemeses("checked");


//busco nombre de la seccion seleccionada


            $campNivel[4] = "une_cla_estado";
            $campNivel[5] = "une_cla_ciudad";
            $campNivel[6] = "une_cla_franquicia";
            $campGrup["C"] = "cue_clavecuenta";
            $campGrup["F"] = "fc_idfranquiciacta";
            $campGrup["P"] = "une_id";

            $edo = $filx["reg"];
            $cuenta = filter_input(INPUT_GET, "cta", FILTER_SANITIZE_SPECIAL_CHARS);
            $cd = $filx["ciu"];
            $niv6 = $filx["niv6"];
            $periodo = "";
            $periodos = array();
            if ($auxper[0])
                array_push($periodos, "M");
            if ($auxper[1])
                array_push($periodos, "6M");
            if ($auxper[2])
                array_push($periodos, "12M");
            for ($j = 0; $j < sizeof($periodos); $j++) {
                $periodo .= '  <th>' . $periodos[$j] . '</th>';
//         
            }

            $this->periodos = $periodo;
            $arrsemaforo = DatosEst::buscaRangosSem($ref, $this->servicio);
            $this->vrangov = $arrsemaforo["v"];
            $this->vrangoa = $arrsemaforo["a"];
            $this->vrangor = $arrsemaforo["r"];



            $coloresletrero = array("v" => "#0C0", "a" => "#FC0", "r" => "#F00");
            if ($sem == "r")
                $this->filtrosTD->setColorsemr('checked="checked"');
            else if ($sem == "a")
                $this->filtrosTD->setColorsema('checked="checked"');
            else if ($sem == "v")
                $this->filtrosTD->setColorsemv('checked="checked"');
            else
                $this->filtrosTD->setColorsemd('checked="checked"');
            $this->filtrosTD->setRango_sel($sem);
            if ($sem != "")
                $this->lb_rangosel = ' <span style="padding:2px; background-color:' . $coloresletrero[$sem] . ';   ">' . T_("RANGO DE CUMPLIMIENTO: ") . $arrsemaforo[$sem] . '</span>';
        }



        /** variables de sesi�n para los filtros */
        $_SESSION["fper"] = $per; /*         * variable para el periodo 6M, 12M */
        $_SESSION["fmes"] = $mes_asig; /* indice de aignacion */
        $_SESSION["fsec"] = $seccion; /* seccion */
        $_SESSION["fniv"] = $nivel;  /* nivel de consulta */
        $_SESSION["ffilx"] = $gfilx;/** filtros de niveles */
//var_dump($_SESSION);
        $_SESSION["ffily"] = $gfily;  /* filtros de cuentas */
        $_SESSION["fref"] = $ref; /* referencia de seccion */
        $_SESSION["fren"] = $ren; /* nivel consulta x cuenta */
        $this->ligaDescargar='mes='.$mes_asig.'&sec='.$seccion.
                  '&niv='.$nivel.'&filx='.$gfilx.'&ren='.$reng.'&fily='.$gfily.'&ref='.$ref.'&rdata='.$rdata.'&sem='.$sem.
                 '&per='.$per.'&filuni='.$gfiluni; 
//***********$html->asignar('urlregresar',$hrefreg);
        Navegacion::borrarRutaActual("tabladin");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("tabladin", $rutaact, T_("TABLA DINAMICA"));
// $html->asignar('NAVEGACION2',desplegarNavegacion());
        
        $this->mostrarGrid($mes_asig, $seccion, $nivel, $gfilx, $reng, $gfily, $ref, $rdata, $sem, $per, $gfiluni);
    }

    /*     * ************************************************************************ 
     * seccion de funciones
     * 
     * ************************************************************************ */

    function unidadesNeg($mes_consulta, $referencia, $filx, $fily) {
        $grupo = $_SESSION["GrupoUs"];
        $aux = explode('.', $mes_consulta);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        $permiso = $filx["zon"];
        $sql = "
SELECT 
n2_id,n2_nombre
FROM ins_detalleestandar 
INNER JOIN cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
 AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
 AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
  AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
   AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 
   AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2 
   INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio 
   AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    INNER JOIN ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id 
   
   INNER JOIN `ca_nivel2` ON `n2_id`=`une_cla_pais`
       WHERE ins_generales.i_claveservicio=1 
 
       and  str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta
    and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant";
        $parametros = array("fmes_consulta" => $fmes_consulta, "mes_consulta_ant" => $mes_consulta_ant);
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= " AND `une_cla_region`=:pais";
            $parametros["pais"] = $filx["pais"];
        }

        $sql .= " AND ins_detalleestandar.ide_numseccion=:seccion AND ins_detalleestandar.ide_numreactivo=:reac
            AND ins_detalleestandar.ide_numcomponente=:com
        AND ins_detalleestandar.ide_numcaracteristica1=:carac1 AND ins_detalleestandar.ide_numcaracteristica2=:carac2 AND ins_detalleestandar.ide_numcaracteristica3=:carac3
      ";
        $parametros["seccion"] = $seccion;
        $parametros["reac"] = $reac;
        $parametros["com"] = $com;
        $parametros["carac1"] = $carac1;
        $parametros["carac2"] = $carac2;
        $parametros["carac3"] = $carac3;

        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
            $parametros["cta"] = $fily["cta"];
        }

        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
            $parametros["fra"] = $fily["fra"];
        }
        $sql .= "  GROUP BY ca_unegocios.`une_cla_pais` ORDER BY ca_unegocios.`une_cla_pais`  ";



        $res = Conexion::ejecutarQuery($sql, $parametros);
        $i = 0;
        $array = array();
        foreach ($res as $row) {
            $clave = $row["n2_id"];
            $nombre = $row["n2_nombre"];
            $array[$i][0] = $clave;
            $array[$i++][1] = $nombre;
        }


        return $array;
    }

    function zonas($mes_consulta, $referencia, $filx, $fily) {
        $grupo = $_SESSION["GrupoUs"];
        $aux = explode('.', $mes_consulta);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        $permiso = $filx["zon"];
        $sql = "
SELECT 
`n3_id`,`n3_nombre`

FROM ins_detalleestandar 
INNER JOIN cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
 AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
 AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
  AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
   AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 
   AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2 
   INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio 
   AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    INNER JOIN ca_unegocios on  ins_generales.i_unenumpunto = ca_unegocios.une_id 
   
   INNER JOIN `ca_nivel3` ON  `une_cla_zona`=`n3_id` 
       WHERE ins_generales.i_claveservicio=1 
 
   
    
    and  str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta 
    and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant";
        $parametros = array("fmes_consulta" => $fmes_consulta, "mes_consulta_ant" => $mes_consulta_ant);
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= " AND `une_cla_region`=:pais";
            $parametros["pais"] = $filx["pais"];
        }
        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= " AND `une_cla_pais`=:uni";
            $parametros["uni"] = $filx["uni"];
        }

        $sql .= " AND ins_detalleestandar.ide_numseccion=:seccion AND ins_detalleestandar.ide_numreactivo=:reac
            AND ins_detalleestandar.ide_numcomponente=:com
        AND ins_detalleestandar.ide_numcaracteristica1=:carac1 AND ins_detalleestandar.ide_numcaracteristica2=:carac2 AND ins_detalleestandar.ide_numcaracteristica3=:carac3";
        $parametros["seccion"] = $seccion;
        $parametros["reac"] = $reac;
        $parametros["com"] = $com;
        $parametros["carac1"] = $carac1;
        $parametros["carac2"] = $carac2;
        $parametros["carac3"] = $carac3;

        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=" . $fily["cta"];
            $parametros["cta"] = $fily["cta"];
        }


        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=" . $fily["fra"];
            $parametros["fra"] = $fily["fra"];
        }
        $sql .= "  GROUP BY ca_unegocios.une_cla_zona ORDER BY ca_unegocios.`une_cla_zona`;  ";

// echo $sql;


        $res = Conexion::ejecutarQuery($sql, $parametros);
        $i = 0;
        $array = array();
        foreach ($res as $row) {
            $clave = $row["n3_id"];
            $nombre = $row["n3_nombre"];
            $array[$i][0] = $clave;
            $array[$i++][1] = $nombre;
        }

        return $array;
    }

    function regiones($mes_consulta, $referencia, $filx, $fily) {

        $grupo = $_SESSION["GrupoUs"];
        $aux = explode('.', $mes_consulta);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        $permiso = $filx["zon"];
        $sql = "
SELECT 
ca_nivel4.n4_id,
ca_nivel4.n4_nombre

FROM ins_detalleestandar 
INNER JOIN cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
 AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
 AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
  AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
   AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 
   AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2 
   INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio 
   AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    INNER JOIN ca_unegocios ON   ins_generales.i_unenumpunto = ca_unegocios.une_id 
   
       INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`
       WHERE ins_generales.i_claveservicio=1 and  str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta
    and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant";
        $parametros = array("fmes_consulta" => $fmes_consulta, "mes_consulta_ant" => $mes_consulta_ant);
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= " AND `une_cla_region`=:pais";
            $parametros["pais"] = $filx["pais"];
        }
        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= " AND `une_cla_pais`=:uni";
            $parametros["uni"] = $filx["uni"];
        }
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= " AND `une_cla_zona`=:permiso";
            $parametros["permiso"] = $permiso;
        }
        $sql .= " AND ins_detalleestandar.ide_numseccion=:seccion AND ins_detalleestandar.ide_numreactivo=:reac
            AND ins_detalleestandar.ide_numcomponente=:com
        AND ins_detalleestandar.ide_numcaracteristica1=:carac1 AND ins_detalleestandar.ide_numcaracteristica2=:carac2 AND ins_detalleestandar.ide_numcaracteristica3=:carac3";
        $parametros["seccion"] = $seccion;
        $parametros["reac"] = $reac;
        $parametros["com"] = $com;
        $parametros["carac1"] = $carac1;
        $parametros["carac2"] = $carac2;
        $parametros["carac3"] = $carac3;
        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=" . $fily["cta"];
            $parametros["cta"] = $fily["cta"];
        }


        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=" . $fily["fra"];
            $parametros["fra"] = $fily["fra"];
        }
        $sql .= "          GROUP BY ca_unegocios.une_cla_estado ORDER BY ca_unegocios.une_cla_estado;  ";



        $res = Conexion::ejecutarQuery($sql, $parametros);

        $i = 0;
        $array = array();
        foreach ($res as $row) {
            $clave = $row["n4_id"];
            $nombre = $row["n4_nombre"];
            $array[$i][0] = $clave;
            $array[$i++][1] = $nombre;
        }


        return $array;
    }

//devuelve un arreglo con las ciudades y sus claves
//por estado
    function ciudades($mes_consulta, $referencia, $permiso, $filx, $fily) {
        $aux = explode('.', $mes_consulta);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        $grupo = $_SESSION["GrupoUs"];
        $sql = "SELECT 
ca_nivel5.n5_id,
ca_nivel5.n5_nombre
FROM ins_detalleestandar 
INNER JOIN cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
 AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
 AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
  AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
   AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 
   AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2 
   INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio 
   AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    INNER JOIN ca_unegocios on  ins_generales.i_unenumpunto = ca_unegocios.une_id 
   
       INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad 
       WHERE ins_generales.i_claveservicio=1 
      and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta 
    and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant";

        $parametros = array("fmes_consulta" => $fmes_consulta, "mes_consulta_ant" => $mes_consulta_ant);
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= "  AND `une_cla_region`=:pais";
            $parametros["pais"] = $filx["pais"];
        }
        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= "  AND `une_cla_pais`=:uni ";
            $parametros["uni"] = $filx["uni"];
        }
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= " AND `une_cla_zona`=:zon";
            $parametros["zon"] = $filx["zon"];
        }
        $sql .= "     AND ins_detalleestandar.ide_numseccion=:seccion AND ins_detalleestandar.ide_numreactivo=:reac
            AND ins_detalleestandar.ide_numcomponente=:com
        AND ins_detalleestandar.ide_numcaracteristica1=:carac1 AND ins_detalleestandar.ide_numcaracteristica2=:carac2 AND ins_detalleestandar.ide_numcaracteristica3=:carac3
        AND ca_unegocios.une_cla_estado=:edo";
        $parametros["seccion"] = $seccion;
        $parametros["reac"] = $reac;
        $parametros["com"] = $com;
        $parametros["carac1"] = $carac1;
        $parametros["carac2"] = $carac2;
        $parametros["carac3"] = $carac3;
        $parametros["edo"] = $filx["reg"];


        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=" . $fily["cta"];
            $parametros["cta"] = $fily["cta"];
        }


        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=" . $fily["fra"];
            $parametros["fra"] = $fily["fra"];
        }
        $sql .= "          GROUP BY ca_unegocios.une_cla_estado, ca_unegocios.une_cla_ciudad  ORDER BY ca_unegocios.une_cla_estado, ca_unegocios.une_cla_ciudad  ";


        $res = Conexion::ejecutarQuery($sql, $parametros);
        $i = 0;

        foreach ($res as $row) {
            $clave = $row["n5_id"];
            $nombre = $row["n5_nombre"];
            $ciudades[$i][0] = $clave;
            $ciudades[$i++][1] = $nombre;
        }

        return $ciudades;
    }

    function niv6($mes_consulta, $referencia, $permiso, $filx, $fily) {

        $aux = explode('.', $mes_consulta);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        $grupo = $_SESSION["GrupoUs"];


        $sql = "SELECT 
 ca_nivel6.n6_id,
ca_nivel6.n6_nombre
 FROM ins_detalleestandar 
    INNER JOIN cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio 
    AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
    AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
     AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente 
     AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
      AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
       AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2 
       INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio 
       AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte 
       INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id 
        INNER JOIN ca_nivel4 ON  ca_unegocios.une_cla_estado = ca_nivel4.n4_id
         INNER JOIN ca_cuentas ON 
          ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
         INNER JOIN ca_nivel6 ON ca_nivel6.n6_id=ca_unegocios.une_cla_franquicia  
         
    where ins_generales.i_claveservicio=".$this->servicio;



        if (isset($filx["ciu"]) && $filx["ciu"] != "") {
            $sql .= "  and    ca_nivel6.n6_idn5=:ciu";
            $parametros["ciu"] = $filx["ciu"];
        }
        $sql .= " and
  str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant

and
ins_detalleestandar.ide_numseccion=:seccion and
ins_detalleestandar.ide_numreactivo=:reac and
ins_detalleestandar.ide_numcomponente=:com and
ins_detalleestandar.ide_numcaracteristica1=:carac1 and
ins_detalleestandar.ide_numcaracteristica2=:carac2 and
ins_detalleestandar.ide_numcaracteristica3=:carac3 ";
        $parametros["fmes_consulta"] = $fmes_consulta;
        $parametros["mes_consulta_ant"] = $mes_consulta_ant;
        $parametros["seccion"] = $seccion;
        $parametros["reac"] = $reac;
        $parametros["com"] = $com;
        $parametros["carac1"] = $carac1;
        $parametros["carac2"] = $carac2;
        $parametros["carac3"] = $carac3;
//    if ($grupo == "cli") {
//        if ($permiso > 0) {
//            $sql.=" and une_cla_estado='$permiso'";
//        }
//    }
//    if ($grupo == "cue") {
//        // Veo si es de cuenta o de frenquicia
//        $aux2 = explode("�", $permiso);
////        echo $aux2;
//        if (sizeof($aux2) > 1)
//            $sql.=" and ca_unegocios.cue_clavecuenta='$aux2[0]' and fc_idfranquiciacta='$aux2[1]' ";
//        else
//            $sql.=" and ca_unegocios.cue_clavecuenta='$permiso' ";
//    }
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
        $sql .= "  GROUP BY 
              ca_unegocios.une_cla_estado,
              ca_unegocios.une_cla_ciudad ,ca_unegocios.une_cla_franquicia 
              ORDER BY  ca_unegocios.une_cla_estado,
              ca_unegocios.une_cla_ciudad ,ca_unegocios.une_cla_franquicia ";

        $res = Conexion::ejecutarQuery($sql, $parametros);

        $i = 0;
//echo $sql;
        foreach ($res as $row) {
            $clave = $row["n6_id"];
            $nombre = $row["n6_nombre"];
            $ciudades[$i][0] = $clave;
            $ciudades[$i++][1] = $nombre;
        }

        return $ciudades;
    }

   

    function Consulta($mes_consulta, $referencia, $permiso, $filx, $fily, $fperiodo) {



        $auxper = explode(".", $fperiodo);
        $aux = explode('.', $mes_consulta);
        if ($mes - 6 >= 0) { // calculo para los 6m
        $mes = $aux[0];
            $z = $mes - 6 + 1;

            $mes_pivote = $aux[1] . "-" . $z . "-01";
        } else {
            $z = 7 + $mes;

            $mes_pivote = ($aux[1] - 1) . "-" . $z . "-01";
        }
        $fmes_consulta = $aux[1] . "-" . $aux[0] . "-01";
        $mes_consulta_ant = ($aux[1] - 1) . "-" . $aux[0] . "-01";

        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];

        // reviso el tipo de evaluacion
        $eval = $this->consTipoEvaluacion(1, $referencia);

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
cue_reactivosestandardetalle.red_estandar,";
        if ($auxper[0] && $auxper[0] != 0) {
            $sql .= " if(ins_generales.i_mesasignacion=:fmes_consulta,1,0) as mes,";
        }
        if ($auxper[1] && $auxper[1] != 0) {
            $sql .= " if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,";
            $parametros["mes_pivote"] = $mes_pivote;
        }
        if ($auxper[2] && $auxper[2] != 0) {
            $sql .= " if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes,";
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
where ins_generales.i_claveservicio=:servicio ";
        $parametros["servicio"] = $this->servicio;
      //  $parametros["cliente"] = $this->cliente;
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= "    and ca_unegocios.une_cla_region=:pais";
            $parametros["pais"] = $filx["pais"];
        }

        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= " and  ca_unegocios.une_cla_pais=:uni";
            $parametros["uni"] = $filx["uni"];
        }

        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= "  and     ca_unegocios.une_cla_zona=:zon";
            $parametros["zon"] = $filx["zon"];
        }
        $sql .= " and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
AND ide_valorreal<>'' 
    
and
ins_detalleestandar.ide_numseccion=:seccion and
ins_detalleestandar.ide_numreactivo=:reac and
ins_detalleestandar.ide_numcomponente=:com and
ins_detalleestandar.ide_numcaracteristica1=:carac1 and
ins_detalleestandar.ide_numcaracteristica2=:carac2 and
ins_detalleestandar.ide_numcaracteristica3=:carac3 ";
        $parametros["fmes_consulta"] = $fmes_consulta;
        $parametros["mes_consulta_ant"] = $mes_consulta_ant;
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
        if (isset($fily["pv"]) && $fily["pv"] != "") {
            $sql .= "  AND ca_unegocios.une_id =:pv";
            $parametros["pv"] = $fily["pv"];
        }

        $sql .= " GROUP BY

 ca_unegocios.cue_clavecuenta, ";
        if ($auxper[0] && $auxper[0] != 0)
            $sql .= " mes,";
        if ($auxper[1] && $auxper[1] != 0)
            $sql .= "  6mes,";
        if ($auxper[2] && $auxper[2] != 0)
            $sql .= " 12mes,";
        $sql .= " 1";
        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql .= " ,ca_unegocios.fc_idfranquiciacta";
        if (isset($filx["pais"]) && $filx["pais"] != "")
            $sql .= "   ,ca_unegocios.une_cla_pais";

        if (isset($filx["uni"]) && $filx["uni"] != "")
            $sql .= " , ca_unegocios.une_cla_zona";

        if (isset($filx["zon"]) && $filx["zon"] != "")
            $sql .= "  , ca_unegocios.une_cla_estado";
        if (isset($filx["reg"]) && $filx["reg"] != "")
            $sql .= " ,ca_unegocios.une_cla_ciudad";
        if (isset($filx["ciu"]) && $filx["ciu"] != "")
            $sql .= " ,ca_unegocios.une_cla_franquicia";
        if ((isset($fily["fra"]) && $fily["fra"] != ""))
            $sql .= " ,une_id";

        $sql .= " order by 
ca_unegocios.cue_clavecuenta,

ca_unegocios.une_cla_estado";

        $res = Conexion::ejecutarQuery($sql, $parametros);

        return $res;
    }

    /*     * *************************************************************************
     * Consulta con rangos de semaforo
     * ************************************************************************* */

    function ConsultaSemaforo($mes_consulta, $referencia, $permiso, $filx, $fily, $color, $fperiodo) {

        $auxper = explode(".", $fperiodo);
        $aux = explode('.', $mes_consulta);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];

        // reviso el tipo de evaluacion
        $eval = $this->consTipoEvaluacion(1, $referencia);

        $grupo = $_SESSION["GrupoUs"];
        $vidiomau = $_SESSION["idiomaus"];


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

ca_cuentas.cue_descripcion,
red_rangor, red_rangoa, red_rangov,
 
cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing,
cue_reactivosestandardetalle.red_estandar,";
       if ($auxper[0]==1)
        $sql.="SUM(
    IF( ins_generales.i_mesasignacion = '$mes_consulta',
      IF(        ins_detalleestandar.ide_aceptado = - 1,        1,      0      ),
        0
    )
  ) AS pasa,
  SUM(
    IF( ins_generales.i_mesasignacion = '$mes_consulta',
      IF(   ins_detalleestandar.ide_aceptado = - 1,        1 * 100,        0      ),
      0)
  ) / SUM(
    IF( ins_generales.i_mesasignacion = '$mes_consulta',      1,      0 )
  ) AS porc,
       
        SUM(    IF(      ins_generales.i_mesasignacion = '$mes_consulta',      1,      0    )
  ) AS tot,";
    if ($auxper[1]==1)
        $sql.=" SUM(
    IF( STR_TO_DATE( CONCAT( '01.',   ins_generales.i_mesasignacion   ),  '%d.%m.%Y'  ) >= '$mes_pivote'
      AND STR_TO_DATE(CONCAT(  '01.', ins_generales.i_mesasignacion ),  '%d.%m.%Y'  ) <= '$fmes_consulta',
      IF( ins_detalleestandar.ide_aceptado = - 1, 1, 0),
      0)
  ) AS pasa,
  SUM(
    IF(
      STR_TO_DATE( CONCAT(  '01.', ins_generales.i_mesasignacion ),    '%d.%m.%Y' ) >= '$mes_pivote'
      AND STR_TO_DATE(CONCAT(  '01.', ins_generales.i_mesasignacion ), '%d.%m.%Y'  ) <= '$fmes_consulta',
      IF(  ins_detalleestandar.ide_aceptado = - 1,  100, 0),
      0
    )
  ) / SUM(
    IF(STR_TO_DATE( CONCAT( '01.',  ins_generales.i_mesasignacion ),  '%d.%m.%Y'  ) >= '$mes_pivote'
      AND STR_TO_DATE( CONCAT(  '01.', ins_generales.i_mesasignacion ), '%d.%m.%Y') <= '$fmes_consulta',
      1,
      0
    )
  ) AS porc,
        SUM(
    IF(STR_TO_DATE( CONCAT( '01.',  ins_generales.i_mesasignacion ),  '%d.%m.%Y'  ) >= '$mes_pivote'
      AND STR_TO_DATE( CONCAT(  '01.', ins_generales.i_mesasignacion ), '%d.%m.%Y') <= '$fmes_consulta',
      1,
      0
    )
  ) as tot,";
        
     if ($auxper[2]==1){
        $sql.=" SUM(
    IF(STR_TO_DATE( CONCAT( '01.',ins_generales.i_mesasignacion),  '%d.%m.%Y' ) > '$mes_consulta_ant' 
      AND STR_TO_DATE( CONCAT( '01.', ins_generales.i_mesasignacion ), '%d.%m.%Y'  ) <= '$fmes_consulta',
      IF( ins_detalleestandar.ide_aceptado = - 1,    1,  0 ),
      0
    )
  ) AS pasa,
  SUM(  IF(  STR_TO_DATE(  CONCAT(  '01.', ins_generales.i_mesasignacion ), '%d.%m.%Y') > '$mes_consulta_ant' 
      AND STR_TO_DATE( CONCAT( '01.', ins_generales.i_mesasignacion ),    '%d.%m.%Y' ) <= '$fmes_consulta',
      IF(  ins_detalleestandar.ide_aceptado = - 1, 100, 0  ),
      0)
  ) / SUM( IF(  STR_TO_DATE( CONCAT(  '01.',  ins_generales.i_mesasignacion ),  '%d.%m.%Y' ) > '$mes_consulta_ant' 
      AND STR_TO_DATE( CONCAT('01.', ins_generales.i_mesasignacion ),   '%d.%m.%Y' ) <= '$fmes_consulta',
      1,
      0 )
  ) AS porc,
         SUM( IF(  STR_TO_DATE( CONCAT(  '01.',  ins_generales.i_mesasignacion ),  '%d.%m.%Y' ) > '$mes_consulta_ant' 
      AND STR_TO_DATE( CONCAT('01.', ins_generales.i_mesasignacion ),   '%d.%m.%Y' ) <= '$fmes_consulta',
      1,
      0 )
  ) as tot,";         
        }
        if ($auxper[0] && $auxper[0] != 0) {
            $sql .= " if(ins_generales.i_mesasignacion=:fmes_consulta,1,0) as mes,";
        }
        if ($auxper[1] && $auxper[1] != 0) {
            $sql .= " if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >=:mes_pivote and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,2,0 ) as 6mes,";
            $parametros["mes_pivote"] = $mes_pivote;
        }
        if ($auxper[2] && $auxper[2] != 0) {
            $sql .= " if(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta,3,0)  as 12mes,";
        }
        $sql .= " str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') as fecha
, convert(substring_index(i_mesasignacion,'.',1),unsigned) as mes_asig,  substring_index(i_mesasignacion,'.',-1) as anio_asig
FROM
ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
   AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica 
   AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON   ins_generales.i_unenumpunto = ca_unegocios.une_id

Inner Join ca_cuentas ON   ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
where ins_generales.i_claveservicio=:servicio and ca_cuentas.cue_idcliente=:cliente ";
        $parametros = array("servicio" => $this->servicio, "cliente" => $this->cliente);
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= "    and ca_unegocios.une_cla_region=:pais";
            $parametros["pais"] = $filx["pais"];
        }

        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= " and  ca_unegocios.une_cla_pais=:uni";
            $parametros["uni"] = $filx["uni"];
        }

        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= "  and     ca_unegocios.une_cla_zona=:zon";
            $parametros["zon"] = $filx["zon"];
        }
        $sql .= "  and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
AND ide_valorreal<>'' 
    
and
ins_detalleestandar.ide_numseccion=$seccion and
ins_detalleestandar.ide_numreactivo=$reac and
ins_detalleestandar.ide_numcomponente=$com and
ins_detalleestandar.ide_numcaracteristica1=$carac1 and
ins_detalleestandar.ide_numcaracteristica2=$carac2 and
ins_detalleestandar.ide_numcaracteristica3=$carac3 ";
        $parametros["fmes_consulta"] = $fmes_consulta;
        $parametros["mes_consulta_ant"] = $mes_consulta_ant;
        //validacion renglon
        if ($eval == 1) {
            $sql .= " and ide_numrenglon=1 ";
        }
//    if ($grupo == "cli") {
//        if ($permiso > 0) {
//            $sql.=" and une_cla_estado='$permiso'";
//        }
//    }
//    if ($grupo == "cue") {
//        // Veo si es de cuenta o de frenquicia
//        $aux2 = explode("�", $permiso);
////        echo $aux2;
//        if (sizeof($aux2) > 1)
//            $sql.=" and ca_unegocios.cue_clavecuenta='$aux2[0]' and fc_idfranquiciacta='$aux2[1]' ";
//        else
//            $sql.=" and ca_unegocios.cue_clavecuenta='$permiso' ";
//    }
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
        if (isset($fily["pv"]) && $fily["pv"] != "") {
            $sql .= " and ca_unegocios.une_id=:pv";
            $parametros["pv"] = $fily["pv"];
        }

        $sql .= " GROUP BY

 ca_unegocios.cue_clavecuenta,1 ";

        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql .= " ,ca_unegocios.fc_idfranquiciacta";
        if (isset($filx["pais"]) && $filx["pais"] != "")
            $sql .= "   ,ca_unegocios.une_cla_pais";

        if (isset($filx["uni"]) && $filx["uni"] != "")
            $sql .= " , ca_unegocios.une_cla_zona";

        if (isset($filx["zon"]) && $filx["zon"] != "")
            $sql .= "  , ca_unegocios.une_cla_estado";
        if (isset($filx["reg"]) && $filx["reg"] != "")
            $sql .= " ,ca_unegocios.une_cla_ciudad";
        if (isset($filx["ciu"]) && $filx["ciu"] != "")
            $sql .= " ,ca_unegocios.une_cla_franquicia";
        if ((isset($fily["fra"]) && $fily["fra"] != ""))
            $sql .= " ,une_id";
        $sql .= " having ";
        if ($color == "r")
            $sql .= "  porc<SUBSTRING_INDEX(red_rangor, '^', -1)";
        if ($color == "a")
            $sql .= "  porc>=SUBSTRING_INDEX(red_rangoa, '^', 1) and  porc<=SUBSTRING_INDEX(red_rangoa, '^', -1)";
        if ($color == "v")
            $sql .= "  porc>=SUBSTRING_INDEX(red_rangov, '^', 1)";

        $sql .= " order by 
ca_unegocios.cue_clavecuenta,

ca_unegocios.une_cla_estado";

        $res = Conexion::ejecutarQuery($sql, $parametros);
      
        return $res;
    }

    /* funcion que calcula el tama�o de la muestra por los filtros seleccionados
     * devuelve una arreglo con la tabla y los resultados
     */

    function tamanioMuestra($mes_consulta, $referencia, $permiso, $filx, $fily, $tx, $ty) {
        $campGrup["C"] = "cue_clavecuenta";
        $campGrup["F"] = "fc_idfranquiciacta";
        $campGrup["P"] = "une_id";
        $campNivel[2] = "une_cla_pais";
        $campNivel[3] = "une_cla_zona";
        $campNivel[4] = "une_cla_estado";
        $campNivel[5] = "une_cla_ciudad";
        $campNivel[6] = "une_cla_franquicia";
        $campNivel[7] = "une_id";
        $aux = explode('.', $mes_consulta);
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
        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];

        // reviso el tipo de evaluacion

        $eval = $this->consTipoEvaluacion(1, $referencia);

        $grupo = $_SESSION["GrupoUs"];
        $vidiomau = $_SESSION["idiomaus"];


        $sql = "SELECT


ca_unegocios.cue_clavecuenta,
ca_unegocios.une_cla_region,
ca_unegocios.une_cla_pais,
ca_unegocios.une_cla_zona,
ca_unegocios.une_cla_estado,
ca_unegocios.une_cla_ciudad,
ca_unegocios.une_cla_franquicia,
ca_unegocios.fc_idfranquiciacta,
ins_generales.i_unenumpunto,
    une_id,
    COUNT(ca_unegocios.une_cla_estado) AS tot,
sum(IF(ins_generales.i_mesasignacion='$mes_consulta', IF(ide_numseccion IS NOT NULL,1,0),0)) AS mes,
 sum(IF(STR_TO_DATE(CONCAT('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$mes_pivote' 
  AND STR_TO_DATE(CONCAT('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$fmes_consulta', IF(ide_numseccion IS NOT NULL,1,0),0 )) AS 6mes,
   sum(IF(STR_TO_DATE(CONCAT('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant
    AND STR_TO_DATE(CONCAT('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta, IF(ide_numseccion IS NOT NULL,1,0),0)) AS 12mes,
    i_mesasignacion
FROM
ca_unegocios
LEFT JOIN ins_generales ON   ca_unegocios.une_id = ins_generales.i_unenumpunto 
   AND ((STR_TO_DATE(CONCAT('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <=:fmes_consulta
 AND STR_TO_DATE(CONCAT('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >:mes_consulta_ant)  or ca_unegocios. une_estatus=1)
     LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=:seccion
 AND `ide_numreactivo`=:reac
  AND `ide_numcomponente`=:com
  AND `ide_numcaracteristica1`=:carac1
  AND `ide_numcaracteristica2`=:carac2
  AND `ide_numcaracteristica3`=:carac3
  AND `ide_numrenglon`=1
 WHERE

ins_generales.i_claveservicio =  :servicio";
        $parametros = array("cliente" => $this->cliente, "servicio" => $this->servicio, "fmes_consulta" => $fmes_consulta, "mes_consulta_ant" => $mes_consulta_ant);
        $parametros["seccion"] = $aux_sec[0];
        $parametros["reac"] = $aux_sec[1];
        $parametros["com"] = $aux_sec[2];
        $parametros["carac1"] = $aux_sec[3];
        $parametros["carac2"] = $aux_sec[4];
        $parametros["carac3"] = $aux_sec[5];
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= "    and ca_unegocios.une_cla_region=:pais";
            $parametros["pais"] = $filx["pais"];
        }

        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= " and  ca_unegocios.une_cla_pais=:uni";
            $parametros["uni"] = $filx["uni"];
        }

        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= "  and     ca_unegocios.une_cla_zona=:zon";
            $parametros["zon"] = $filx["zon"];
        }
        // $sql.="  and une_estatus=1";
        //validacion renglon
//    if($grupo=="cli") {
//        if($permiso>0) {
//            $sql.=" and une_cla_estado='$permiso'";
//        }
//    }
//
//    if($grupo=="cue")
//    {
//        // Veo si es de cuenta o de frenquicia
//        $aux2=explode("�", $permiso);
////        echo $aux2;
//        if(sizeof($aux2)>1)
//            $sql.=" and ca_unegocios.cue_clavecuenta='$aux2[0]' and fc_idfranquiciacta='$aux2[1]' ";
//        else
//            $sql.=" and ca_unegocios.cue_clavecuenta='$permiso' ";
//    }
        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=" . $fily["cta"];
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
            $sql .= " and ca_unegocios.fc_idfranquiciacta=" . $fily["fra"];
            $parametros["fra"] = $fily["fra"];
        }

        $sql .= " GROUP BY 

ins_generales.i_claveservicio,
ca_unegocios.une_cla_region";
        if (isset($filx["pais"]) && $filx["pais"] != "")
            $sql .= " ,ca_unegocios.une_cla_pais";
        if (isset($filx["uni"]) && $filx["uni"] != "")
            $sql .= " ,ca_unegocios.une_cla_zona";
        if (isset($filx["zon"]) && $filx["zon"] != "")
            $sql .= " ,ca_unegocios.une_cla_estado ";
        $sql .= " ,ca_unegocios.cue_clavecuenta  ";
        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql .= " ,ca_unegocios.fc_idfranquiciacta";
        if (isset($filx["reg"]) && $filx["reg"] != "")
            $sql .= " ,ca_unegocios.une_cla_ciudad";
        if (isset($filx["ciu"]) && $filx["ciu"] != "")
            $sql .= " ,ca_unegocios.une_cla_franquicia";
        if ((isset($filx["niv6"]) && $filx["niv6"] != "") || (isset($fily["fra"]) && $fily["fra"] != ""))
            $sql .= " ,une_id";

        $sql .= " order by 
ca_unegocios.cue_clavecuenta,
ca_unegocios.une_cla_estado";
//echo "<br>".$sql;
        $matriz = array();
        $total_cuen = array();
        $res = Conexion::ejecutarQuery($sql, $parametros);
        //echo $sql;
        //lleno la matriz
        foreach ($res as $row) {

            $cuenta = $row[$campGrup[$ty]]; //sera eje y
            $region = $row[$campNivel[$tx]]; //ser� eje x

            $matriz[$cuenta][$region][1]["muestra"] = $row["mes"];
            $matriz[$cuenta][$region][2]["muestra"] = $row["6mes"];
            $matriz[$cuenta][$region][3]["muestra"] = $row["12mes"];
            
            $matriz[$cuenta][$region]["muestratot"] = $row["tot"];
            $total_cuen[$cuenta][1]["muestra"] += $matriz[$cuenta][$region][1]["muestra"];
            $total_cuen[$cuenta][2]["muestra"] += $matriz[$cuenta][$region][2]["muestra"];
            $total_cuen[$cuenta][3]["muestra"] += $matriz[$cuenta][$region][3]["muestra"];
            $total_cuen[$cuenta]["muestratot"] += $matriz[$cuenta][$region]["muestratot"];
        }


        return array($matriz, $total_cuen);
    }

    function pintaTabla($mes_asig, $referencia, $permiso, $filx, $fily, $tx, $ty, $tiposec, $rdata, $colorsem, $fperiodo, $gfily) {


        global $vidiomau;
        global $ureg;
      
        if ($colorsem)
            $rs = $this->ConsultaSemaforo($mes_asig, $referencia, $permiso, $filx, $fily, $colorsem, $fperiodo);
        else
            $rs = $this->Consulta($mes_asig, $referencia, $permiso, $filx, $fily, $fperiodo);

        $auxper = explode(".", $fperiodo);

        $campNivel[2] = "une_cla_pais";
        $campNivel[3] = "une_cla_zona";
        $campNivel[4] = "une_cla_estado";
        $campNivel[5] = "une_cla_ciudad";
        $campNivel[6] = "une_cla_franquicia";
        $campNivel[7] = "une_id";
        $campGrup["C"] = "cue_clavecuenta";
        $campGrup["F"] = "fc_idfranquiciacta";
        $campGrup["P"] = "une_id";
        $campGrup["PP"] = "une_id";
        $nivel = $tx;
      
        $edo = $filx["reg"];

        $cd = $filx["ciu"];
        $niv6 = $filx["niv6"];
        $zona = $filx["zon"];

        $clave_cue = 1;
        $acumtot = 0;
        $acumacep = 0;
        $totalreg = array();
        $auxdatamos = explode(".", $rdata); //guarda los datos que se muestran si num pruebas tam muestra o %
        $total_cuen = array();

        //verifico que haya resultados si no consulto el nombre de la seccion
        $nomAux = null;
        $matriz = array();
        if (sizeof($rs) > 0) {
            foreach ($rs as $row) {
                $periodo = $acept = $acumtot = 0;
                $cuenta = $row[$campGrup[$ty]]; //sera eje y
                $region = $row[$campNivel[$tx]]; //ser� eje x

//                 if ($vidiomau == 2) {
//                     $nomseccion = $row["red_parametroing"];
//                 } else {
//                     $nomseccion = $row["red_parametroesp"];
//                 }



                if ($row["mes"] == 1) {
                    $periodo = 1;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                } else
                if ($row["6mes"] == 2) {
                    $periodo = 2;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                } else
                if ($row["12mes"] == 3) {
                    $periodo = 3;
                    $acept = $row["pasa"];
                    $acumtot = $row["tot"];
                }
                //   echo "ss".$region;

                if ($cuenta > 0 && $region > 0) {

                    $matriz[$cuenta][$region][$periodo]["acep"] = $acept;
                    $matriz[$cuenta][$region][$periodo]["tot"] = $acumtot;
                    $total_cuen[$cuenta][$periodo]["acep"] += $acept;
                    //     echo   "<br>".$cuenta."..".$region."..".$periodo."..".$total_cuen[$cuenta][$periodo]["tot"]."--".$acumtot;
                    $total_cuen[$cuenta][$periodo]["tot"] += $acumtot;
                }
//     
            }
        }
// echo "<pre>";
// print_r($matriz);
// echo "</pre>";
        $columnas = array();
     
        switch ($nivel) {
            case 2: //busco estados
                $columnas = $this->unidadesNeg($mes_asig, $referencia, $filx, $fily);
                $nivf = "uni";

                break;
            case 3: //busco estados
                $columnas = $this->zonas($mes_asig, $referencia, $filx, $fily);
                $nivf = "zon";

                break;
            case 4: //busco estados
                $columnas = $this->regiones($mes_asig, $referencia, $filx, $fily);
                $nivf = "reg";
                break;
            case 5:

                $columnas = $this->ciudades($mes_asig, $referencia, $permiso, $filx, $fily);
                $nivf = "ciu";

                break;
            case 6:

                //$columnas = niv6($zona, $edo, $cd);
                $columnas = $this->niv6($mes_asig, $referencia, $permiso, $filx, $fily);
                $nivf = "niv6";
                break;
        }



        $columna = "";
        $aux = explode(".", $referencia);
        $seccion = $aux[0];



        $num_regs = count($columnas);


        if ($ty == "C") {
            $renglones = $this->cuentas($permiso, $filx);
            $nty = "F";
            $indy = "cta";
            $gupcta = T_("CUENTA");
        }
      
        if ($ty == "F") {

            $renglones = $this->franquicias($fily["cta"], $filx);
            $aty = "C";
            $nty = "P";
            $indy = "fra";
            $gupcta = T_("FRANQUICIA");
        }
        if ($ty == "P") {
            $aty = "F";
            $renglones = $this->puntosVenta($zona, $filx, $fily);
            $gupcta = T_("PUNTO VENTA");
        }
        if ($ty == "PP") {
            $aty = "P";
            $renglones = $this->puntoVenta($zona, $filx, $fily);
            $columnas = null;
            $gupcta = T_("PUNTO VENTA");
        }


        if ($num_regs > 1)// si son todas empiezo en 0
            $ini = 1;
        else
            $ini = $permiso;

        $rowdata = array();
        $output = array();

        $permiso = 0;
        //  $rs=cuentas($permiso); 
        //busco tama�o de muestra
        if ($auxdatamos[0] == 1) {

            $arrmuestra = $this->tamanioMuestra($mes_asig, $referencia, $permiso, $filx, $fily, $tx, $ty);
            $matrizmuestra = $arrmuestra[0];
          //  var_dump($matrizmuestra);
            $totalmuestra = $arrmuestra[1];
        }
        $totalfin = array();
        $nombrenivel = Estructura::getDescripcionNivel($nivel, "cnfg_estructura");


        //si es a nivel punto venta no muestra estas columnas
        if ($ty != "P") {
            for ($k = 0; $k < sizeof($columnas); $k++) {
                // $nombre=nombreRegion($region);

                $filx[$nivf] = $columnas[$k][0];
                $liga = $filx["reg"] . "." . $filx["ciu"] . "." . $filx["niv6"];
                $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];

                if ($nivel != 7) { //para el nivel 6 ya no muestro liga
                    $href = 'index.php?action=indindicadoresgrid&mes=' . $mes_asig . "&sec=" . $seccion . "&filx=" . $liga . "&fily=" . $gfily . "&ren=" . $ty . "&niv=" . ($nivel + 1)
                            . "&rdata=" . $rdata . "&per=" . $fperiodo . "&ref=" . $referencia . "&filuni=" . $ligauni;
                } else {
                    $href = "";
                    $func_onclick = "";
                }

                $columna = '<a href="' . $href . '" >' . $columnas[$k][1] . '</a>';
                //   $oresultado=new ResumenResultado;
                //  $oresultado->setNombrenivel($nombrenivel);
                // $oresultado->setNivel($columnas[$i][1]);



                $reg = $columnas[$k][0];
                $rowdata[] = $columnas[$k];

                //crear otro objeto  
                $tablitaxnivel = new TablitaDinamica;
                $tablitaxnivel->setNivel($columna);
                $tablitaxnivel->setNombreNivel($nombrenivel);
                $listacuentas = array();
             
                for ($r = 0; $r < count($renglones); $r++) {
                    $rowdata = array();
                    $cuen = $renglones[$r][0];
                    $tablacuenta = new ResumenResultadoxPeriodo;
                    $tablacuenta->setIdfranquicia($cuen);
                  
                    $fily[$indy] = $cuen;
                    $ligax = $filx["reg"] . "." . $filx["ciu"] . "." . $filx["niv6"];
                    $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];

                    $ligay = $fily["cta"] . "." . $fily["fra"];
                    $href = 'index.php?action=indindicadoresgrid&&mes=' . $mes_asig . "&sec=" . $tiposec . "&filx=" . $ligax . "&fily=" . $ligay . "&ren=" . $nty .
                            "&niv=" . $tx . "&rdata=" . $rdata . "&ref=" . $referencia . "&filuni=" . $ligauni;
                    if ($ty != "P" && $ty != "PP")
                        $tab_cuenta = '<a href="' . $href . '" onclick="return guardarLiga(this,\'' . $renglones[$r][1] . '\');">' . $renglones[$r][1] . '</a>';
                    else
                        $tab_cuenta = '<a href="MENindprincipal.php?op=mindi&admin=consulta2&mes=' . $mes_asig . "&filx=" . $ligax . '&ptv=' . $renglones[$r][0] . '&fily=' . $ligay . "&ref=" . $referencia . "&filuni=" . $ligauni . '" onclick="return guardarLiga(this,\'' . $renglones[$r][1] . '\');">' . $renglones[$r][1] . '</a>';

                    $rowdata[] = "&nbsp;&nbsp;" . $tab_cuenta;
                    $tablacuenta->setNombrefranquicia($gupcta.":".$renglones[$r][1]);

                    for ($per = 1; $per < 4; $per++) { //despliego cada periodo
                        $porcm = 0;
                        $porc = 0;
                        $ligax = "";
                        $ligay = "";
                        $reng3 = "";
                        $reng2 = "";
                        $reng1 = "";
//         
                        //   echo "<br>".$cuen."][".$reg."][".$per."--".$matriz[$cuen][$reg][$per]["tot"];
                        //     echo "--".$auxper[$per - 1]."-- ".$per;
                        if ($auxper[$per - 1] == 1) {
                            $matriz[$cuen][$reg][$per]["tot"] = $matriz[$cuen][$reg][$per]["tot"] + $matriz[$cuen][$reg][$per - 1]["tot"];
                            $matriz[$cuen][$reg][$per]["acep"] = $matriz[$cuen][$reg][$per]["acep"] + $matriz[$cuen][$reg][$per - 1]["acep"];
//                            echo "<br>acep " . $cuen . "][" . $reg . "][" . $per . "]" . $matriz[$cuen][$reg][$per]["acep"];

                            $acept = $matriz[$cuen][$reg][$per]["acep"];
                            $total = $matriz[$cuen][$reg][$per]["tot"];

                            $reng1 = $reng2 = $reng3 = "";
                            //calculo % tamaño muestra
                            //   echo "<br>".$matrizmuestra[$cuen][$reg][$per]["muestra"]." /". $matrizmuestra[$cuen][$reg]["muestratot"];
                            if ($auxdatamos[0] == 1) {

                                if ($matrizmuestra[$cuen][$reg]["muestratot"] != 0 && $total > 0) {
                                    $porcm = $matrizmuestra[$cuen][$reg][$per]["muestra"] / $matrizmuestra[$cuen][$reg]["muestratot"];
                                    $porcm = round($porcm * 100, 1);
                                } else
                                    $porcm = T_("sin datos");


                                $reng1 = TablitaDinamica::getDivResultado('%' . T_("tam. muestra"), $porcm);
                            }
                            if ($auxdatamos[1] == 1) {
                                if ($total == 0) {
                                    $total = T_("-");
                                }
                                $reng2 = TablitaDinamica::getDivResultado(T_("no. pruebas"), $total);
                            }
//                    if ($auxdatamos[2] == 1) {
                            
                            //   echo "<br>cuenta".$cuen."--".$reg."--".$per."--".$porc;
                            $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];
                            if ($tx == 2)
                                $ligauni = $filx["pais"] . "." . $reg;
                            if ($tx == 3)
                                $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $reg;
                            if ($tx == 4) {
                                $ligax = $reg . ".";
                            }
                            if ($tx == 5) {
                                $ligax = $filx["reg"] . "." . $reg;
                            }
                            if ($tx == 6 || $tx == 7) {
                                $ligax = $filx["reg"] . "." . $filx["ciu"] . "." . $reg;
                            }
                            $ligay = $fily["cta"] . "." . $fily["fra"];
                            if ($total > 0) {
                                $porc = $acept / $total * 100;
                                $porc = round($porc, 1);
                                //   echo $cuen."--".$reg."--".$per."--".$porc."<br>";
                            } else
                                $porc = "-";
                            if ($ty == "P"||$total == 0||$total == "")
                                $reng3 = TablitaDinamica::getDivResultado('%' . T_("cumple"), $porc);
                            else
                            { 
                                $reng3 = TablitaDinamica::getDivResultado('% ' . T_("cumple"), '<a href="index.php?action=indestadisticares&mes=' . $mes_asig . '&refer=' . $referencia . '&tcons=gr&fily=' . $ligay . '&filx=' . $ligax . '&per=' . $per . "&filuni=" . $ligauni . '" >' . $porc . '</a>');
                                
                            }
                            //  }
                            $rowdata[] = $reng2 . $reng1 . $reng3;
                            //   echo $reg."][".$per."--".$total."--". $totalreg[$reg][$per]["tot"]."<br>";
                            //acumulo por mes
                            if ($per == 1)
                                $tablacuenta->setResultados1(TablitaDinamica::getDivPeriodo(T_("MENSUAL"), $reng2 . " " . $reng1 . " " . $reng3));
                            if ($per == 2)
                                $tablacuenta->setResultados2(TablitaDinamica::getDivPeriodo(T_("6 MESES"), $reng2 . " " . $reng1 . " " . $reng3));
                            if ($per == 3)
                                $tablacuenta->setResultados3(TablitaDinamica::getDivPeriodo(T_("12 MESES"), $reng2 . " " . $reng1 . " " . $reng3));
                            //  var_dump($totalreg);
                            $totalreg[$reg][$per]["tot"] += $total;
                            $totalreg[$reg][$per]["acep"] += $acept;
                       
                        }
                      
                        $totalreg[$reg][$per]["muestra"] += $matrizmuestra[$cuen][$reg][$per]["muestra"];
                    } //fin periodos
                    $totalreg[$reg]["muestratot"]+=$matrizmuestra[$cuen][$reg]["muestratot"];
                       $listacuentas[] = $tablacuenta;
                }
             


                //despliego totales por region
                //   $rowdata = array();
                $rowdata[] = T_("TOTAL");
                // var_dump($columnas);
                $tablacuenta = new ResumenResultadoxPeriodo;
                $tablacuenta->setIdfranquicia($cuen);
                $tablacuenta->setNombrefranquicia(T_("TOTAL"));
                $tablacuenta->setEstotal(true);


                $ligax = "";
                $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];
                if ($tx == 2)
                    $ligauni = $filx["pais"] . "." . $filx["uni"];
                if ($tx == 3) {
                    $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];
                    $ligax = "";
                }
                if ($tx == 4)
                    $ligax = $reg . ".";
                if ($tx == 5)
                    $ligax = $filx["reg"] . "." . $reg;
                if ($tx == 6 || $tx == 7)
                    $ligax = $filx["reg"] . "." . $filx["ciu"] . "." . $reg;
                if ($ty != "C")
                    $ligay = $fily["cta"];
                else
                    $ligay = "";
                for ($per = 1; $per < 4; $per++) {
                    if ($auxper[$per - 1] == 1) {
                        $reng1 = $reng2 = $reng3 = "";
                        if ($auxdatamos[0] == 1) {
                        
                            if ($totalreg[$reg]["muestratot"] != 0 && $totalreg[$reg][$per]["tot"] > 0) {
                                $porcm = $totalreg[$reg][$per]["muestra"] / $totalreg[$reg]["muestratot"];
                                $porcm = round($porcm * 100, 1);
                            } else
                                $porcm =T_("-");

                            //  $rowdata[] =$totalreg[$reg][$per]["tot"].'-'.round($porc,1);
                            $reng1 = TablitaDinamica::getDivResultado('%' . T_("tam. muestra"), $porcm);
                        }
                        //  echo $reg."--".$per."--".$totalreg[$reg][$per]["tot"]."<br>";
                        if ($auxdatamos[1] == 1) {
                            if ($totalreg[$reg][$per]["tot"] > 0) {


                                $reng2 = TablitaDinamica::getDivResultado(T_("no. pruebas"), $totalreg[$reg][$per]["tot"]);
                            } else {
                                $reng2 = TablitaDinamica::getDivResultado(T_("no. pruebas"),T_("-"));
                            }
                        }
                        if ($auxdatamos[2] == 1) {
                            if ($totalreg[$reg][$per]["tot"] != 0) {
                                $porc = $totalreg[$reg][$per]["acep"] / $totalreg[$reg][$per]["tot"] * 100;
                                $porc = round($porc, 1);
                            } else {
                                $porc =T_("-");
                            }
                            if ($ty == "P"||$totalreg[$reg][$per]["tot"] == 0||$totalreg[$reg][$per]["tot"] =="")
                                $reng3 = TablitaDinamica::getDivResultado('% ' . T_("cumple"), $porc);
                            else
                                $reng3 = TablitaDinamica::getDivResultado("% " . T_("cumple"), ' <a href="index.php?action=indestadisticares&mes=' . $mes_asig . '&refer=' . $referencia . '&tcons=gr&fily=' . $ligay . '&filx=' . $ligax . '&per=' . $per . "&filuni=" . $ligauni . '" ><strong>' . $porc . "</strong></a>");
                        }
                        if ($per == 1)
                            $tablacuenta->setResultados1(TablitaDinamica::getDivPeriodo(T_("MENSUAL"), $reng2 . " " . $reng1 . " " . $reng3));
                        if ($per == 2)
                            $tablacuenta->setResultados2(TablitaDinamica::getDivPeriodo(T_("6 MESES"), $reng2 . " " . $reng1 . " " . $reng3));
                        if ($per == 3)
                            $tablacuenta->setResultados3(TablitaDinamica::getDivPeriodo(T_("12 MESES"), $reng2 . " " . $reng1 . " " . $reng3));
                    }
                }

                $listacuentas[] = $tablacuenta;
                $tablitaxnivel->setListaResultadosxcuenta($listacuentas);
                $output[] = $tablitaxnivel;
            } //fin por regiones
        }
        //
        //columna totales x cuenta

        $tablitaxnivel = new TablitaDinamica;
        $tablitaxnivel->setNombreNivel(T_("TOTALES"));
        $listacuentas = array();
        for ($r = 0; $r < count($renglones); $r++) {
            $rowdata = array();
            $cuen = $renglones[$r][0];
            $tablacuenta = new ResumenResultadoxPeriodo;
            
            $tablacuenta->setNombrefranquicia($gupcta.":".$renglones[$r][1]);
            $ligax = "";
            $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];
            if ($tx == 3)
                $ligauni = $filx["pais"] . "." . $filx["uni"];
            if ($tx == 4) {
                $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];
                $ligax = "";
            }

            if ($tx == 5)
                $ligax = $filx["reg"] . ".";
            if ($tx == 6)
                $ligax = $filx["reg"] . "." . $filx["ciu"];
            if ($tx == 7)
                $ligax = $filx["reg"] . "." . $filx["ciu"] . "." . $filx["niv6"];

            for ($per = 1; $per < 4; $per++) {
                $porc = 0;
                $porcm = 0;
                $reng3 = "";
                $reng2 = "";
                $reng1 = "";
                $total_cuen[$cuen][$per]["acep"] = $total_cuen[$cuen][$per]["acep"] + $total_cuen[$cuen][$per - 1]["acep"];
                $total_cuen[$cuen][$per]["tot"] = $total_cuen[$cuen][$per]["tot"] + $total_cuen[$cuen][$per - 1]["tot"];
                
                if ($auxper[$per - 1] == 1) {

                    if ($total_cuen[$cuen][$per]["tot"] > 0) {
                        $porc = $total_cuen[$cuen][$per]["acep"] / $total_cuen[$cuen][$per]["tot"] * 100;
                        $porc = round($porc, 1);
                        $totaltemp = $total_cuen[$cuen][$per]["tot"];
                    } else {
                        $porc = T_("-");
                        $totaltemp = T_("-");
                    }
                    $reng1 = $reng2 = $reng3 = "";
                    //calculo % tamaño muestra
                    if ($auxdatamos[0] == 1) {
                        if ($totalmuestra[$cuen]["muestratot"] != 0 && $total_cuen[$cuen][$per]["tot"] > 0) {
                            $porcm = $totalmuestra[$cuen][$per]["muestra"] / $totalmuestra[$cuen]["muestratot"];
                            $porcm = round($porcm * 100, 1);
                        } else
                            $porcm =T_("-");


                        $reng1 = TablitaDinamica::getDivResultado('% ' . T_("tam. muestra"), $porcm);
                    }
                    if ($auxdatamos[1] == 1) {
                        $reng2 = TablitaDinamica::getDivResultado(T_("no. pruebas"), $totaltemp);
                    }
                    if ($auxdatamos[2] == 1) {
                      
                        if ($ty == "P" || $ty == "PP")
                            $reng3 =TablitaDinamica::getDivResultado('% ' . T_("cumple"), $porc);
//                        else if($totalmuestra[$cuen]["muestratot"] == 0)
//                            echo "hola";
//                            else if($total_cuen[$cuen][$per]["tot"] == "")
//                        {   $reng3 ="aqui".TablitaDinamica::getDivResultado('% ' . T_("cumple"), $porc);
//                        echo "<br>".$ty."--". $totalmuestra[$cuen]["muestratot"] .
//                        $total_cuen[$cuen][$per]["tot"] ; }
                        else
                            $reng3 =TablitaDinamica::getDivResultado('% ' . T_("cumple"), '<a href="index.php?action=indestadisticares&mes=' . $mes_asig . '&refer=' . $referencia . '&tcons=gr&fily=' . $ligay . '&filx=' . $ligax . '&per=' . $per . "&filuni=" . $ligauni . '" onclick="return guardarLiga(this, \'ESTADISTICAS\');">  ' . $porc . "</a>");
                    }
                    $rowdata[] = array("ren2" => $reng2, "ren1" => $reng1, "ren3" => $reng3);
                    if ($per == 1)
                        $tablacuenta->setResultados1(TablitaDinamica::getDivPeriodo(T_("MENSUAL"), $reng2 . " " . $reng1 . " " . $reng3));
                    if ($per == 2)
                        $tablacuenta->setResultados2(TablitaDinamica::getDivPeriodo(T_("6 MESES"), $reng2 . " " . $reng1 . " " . $reng3));
                    if ($per == 3)
                        $tablacuenta->setResultados3(TablitaDinamica::getDivPeriodo(T_("12 MESES"), $reng2 . " " . $reng1 . " " . $reng3));

                    $totalfin[$per]["acep"] += $total_cuen[$cuen][$per]["acep"];
                    $totalfin[$per]["tot"] += $total_cuen[$cuen][$per]["tot"];
                    $totalfin[$per]["muestra"] += $totalmuestra[$cuen][$per]["muestra"];
                }
            }
            $totalfin["muestratot"] += $totalmuestra[$cuen]["muestratot"];

            $listacuentas[] = $tablacuenta;
            //$output['aaData'][] = array_map(utf8_encode, $rowdata);
        }




        //  var_dump($rowdata);
        //despliego totales finales
        $tablacuenta = new ResumenResultadoxPeriodo;
        $tablacuenta->setNombrefranquicia(T_("GRAN TOTAL"));
        $tablacuenta->setEstotal(true);

        $ligax = "";
        $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];
        if ($tx == 2)
            $ligauni = $filx["pais"] . "." . $filx["uni"];
        if ($tx == 3) {
            $ligauni = $filx["pais"] . "." . $filx["uni"] . "." . $filx["zon"];
        }
        if ($tx == 4)
            $ligax = $filx["reg"];

        if ($tx == 5)
            $ligax = $filx["reg"] . ".";
        if ($tx == 6)
            $ligax = $filx["reg"] . "." . $filx["ciu"];
        if ($tx == 7)
            $ligax = $filx["reg"] . "." . $filx["ciu"] . "." . $filx["niv6"];
        if ($ty == "F")
            $ligay = $fily["cta"];
        else if ($ty == "P")
            $ligay = $fily["cta"] . "." . $fily["fra"];
        else if ($ty == "PP")
            $ligay = $fily["cta"] . "." . $fily["fra"] . "." . $fily["pv"];
        else
            $ligay = "";
        for ($per = 1; $per < 4; $per++) {
            $reng1 = $reng2 = $reng3 = "";
            if ($auxper[$per - 1] == 1) {
                if ($auxdatamos[0] == 1) {
                    if ($totalfin["muestratot"] != 0 && $totalfin[$per]["tot"] > 0) {
                        $porcm = $totalfin[$per]["muestra"] / $totalfin["muestratot"];
                        $porcm = round($porcm * 100, 1);
                    } else
                        $porcm = T_("-");
                    $reng1 = TablitaDinamica::getDivResultado('%' . T_("tam. muestra"), $porcm);
                }
                if ($auxdatamos[1] == 1) {
                    if ($totalfin[$per]["tot"] > 0)
                        $reng2 = TablitaDinamica::getDivResultado(T_("no. pruebas"), $totalfin[$per]["tot"]);
                    else
                        $reng2 = TablitaDinamica::getDivResultado(T_("no. pruebas"),T_("sin datos"));
                }
                if ($auxdatamos[2] == 1) {
                    if ($totalfin[$per]["tot"] > 0) {
                        $porc = $totalfin[$per]["acep"] / $totalfin[$per]["tot"] * 100;
                        $porc = round($porc, 1);
                         $reng3 = TablitaDinamica::getDivResultado('% ' . T_("cumple"), ' <a href="index.php?action=indestadisticares&mes=' . $mes_asig . '&refer=' . $referencia . '&tcons=gr&fily=' . $ligay . '&filx=' . $ligax . '&per=' . $per . "&filuni=" . $ligauni . '" ><strong>' . $porc . "</strong></a>");
            
                    } else
                    {   $porc = T_("-");
                        $reng3 = TablitaDinamica::getDivResultado('% ' . T_("cumple"), ' <strong>' . $porc . "</strong>");
            
                    }
//                if ($ty == "P")
//                    $reng3 = '<span title="% ' . T_("cumple") . '"> <strong>' . $porc . "</strong></span>";
//                else
                       }
                $rowdata[] = array("ren2" => $reng2, "ren1" => $reng1, "ren3" => $reng3);
                if ($per == 1)
                    $tablacuenta->setResultados1(TablitaDinamica::getDivPeriodo(T_("MENSUAL"), $reng2 . " " . $reng1 . " " . $reng3));
                if ($per == 2)
                    $tablacuenta->setResultados2(TablitaDinamica::getDivPeriodo(T_("6 MESES"), $reng2 . " " . $reng1 . " " . $reng3));
                if ($per == 3)
                    $tablacuenta->setResultados3(TablitaDinamica::getDivPeriodo(T_("12 MESES"), $reng2 . " " . $reng1 . " " . $reng3));
            }
        }
        $listacuentas[] = $tablacuenta;
        $tablitaxnivel->setListaResultadosxcuenta($listacuentas);

        $output[] = $tablitaxnivel;

//    $output['aaData'][] = $rowdata;
        //     var_dump($output);
        return $output;
    }

  

    function cuentas($cuenta, $filx) {
        $grupo = $_SESSION["GrupoUs"];
        $sql = "SELECT ca_unegocios.une_id, ca_unegocios.une_descripcion,
 ca_unegocios.`cue_clavecuenta`, `ca_cuentas`.`cue_descripcion`
 FROM ca_unegocios 
 INNER JOIN `ca_cuentas` ON ca_unegocios.`cue_clavecuenta`=`ca_cuentas`.`cue_id` 
 WHERE  ca_cuentas.cue_idcliente=:cliente
AND ca_unegocios.une_cla_pais=1 AND ca_unegocios.une_cla_region=1 ";

        $parametros["cliente"] = $this->cliente;
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql.=" AND ca_unegocios.une_cla_zona=:zona";
           $parametros["zona"]=$filx["zon"];
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

        $sql .= " GROUP BY `ca_unegocios`.`cue_clavecuenta`";


        $sql .= " order by ca_cuentas.cue_id";

        $res = Conexion::ejecutarQuery($sql, $parametros);

        $arreglo = array();
        $i = 0;
        foreach ($res as $row) {
            $clave = $row["cue_clavecuenta"];
            $nombre = $row["cue_descripcion"];
            $arreglo[$i][0] = $clave;
            $arreglo[$i++][1] = $nombre;
        }

        return $arreglo;
    }

    function franquicias($cuenta, $filx) {

        $sql = "SELECT 
`ca_franquiciascuenta`.`fc_idfranquiciacta`,`ca_franquiciascuenta`.`cf_descripcion`
 FROM ca_unegocios 
 INNER JOIN `ca_franquiciascuenta` ON ca_unegocios.`cue_clavecuenta`=`ca_franquiciascuenta`.`cue_clavecuenta` 
 AND `ca_franquiciascuenta`.`fc_idfranquiciacta`=`ca_unegocios`.`fc_idfranquiciacta`
 WHERE  ca_franquiciascuenta.cue_clavecuenta=:cuenta " .
                " AND ca_unegocios.une_cla_pais=1 AND ca_unegocios.une_cla_region=1 ";
        $parametros["cuenta"] = $cuenta;
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql.=" AND ca_unegocios.une_cla_zona=:zona ";
        $parametros["zona"]=$filx["zon"];
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

        $sql .= " GROUP BY `ca_unegocios`.`fc_idfranquiciacta`
ORDER BY `ca_unegocios`.`fc_idfranquiciacta`";


        $res = Conexion::ejecutarQuery($sql, $parametros);
        $i = 0;
        foreach ($res as $row) {
            $clave = $row["fc_idfranquiciacta"];
            $nombre = $row["cf_descripcion"];
            $arreglo[$i][0] = $clave;
            $arreglo[$i++][1] = $nombre;
        }

        return $arreglo;
    }

    function puntosVenta($zona, $filx, $fily) {

        $sql = "SELECT
ca_unegocios.une_id,
ca_unegocios.une_descripcion
FROM
ca_unegocios
where 1=1 ";
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= " AND `une_cla_region`=:pais";
            $parametros["pais"] = $filx["pais"];
        }
        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= " AND `une_cla_pais`=:uni";
            $parametros["uni"] = $filx["uni"];
        }
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= "  and     ca_unegocios.une_cla_zona=:zon";
            $parametros["zon"] = $filx["zon"];
        }
        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=" . $fily["cta"];
            $parametros["cta"] = $fily["cta"];
        }
        if (isset($filx["reg"]) && $filx["reg"] != "") {
            $sql .= " and ca_unegocios.une_cla_estado=" . $filx["reg"];
            $parametros["reg"] = $filx["reg"];
        }
        if (isset($filx["ciu"]) && $filx["ciu"] != "") {
            $sql .= " and ca_unegocios.une_cla_ciudad=" . $filx["ciu"];
            $parametros["ciu"] = $filx["ciu"];
        }
        if (isset($filx["niv6"]) && $filx["niv6"] != "") {
            $sql .= " and ca_unegocios.une_cla_franquicia=" . $filx["niv6"];
            $parametros["niv6"] = $filx["niv6"];
        }
        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=" . $fily["fra"];
            $parametros["fra"] = $fily["fra"];
        }


        $sql .= " order by une_id";

        $i = 0;

        $res = Conexion::ejecutarQuery($sql);
        foreach ($res as $row) {
            $clave = $row["une_id"];
            $nombre = $row["une_descripcion"];
            $arreglo[$i][0] = $clave;
            $arreglo[$i++][1] = $nombre;
        }

        return $arreglo;
    }

    function consTipoEvaluacion($servicio, $referencia) {

        $aux_sec = explode(".", $referencia);
        $seccion = $aux_sec[0];
        $reac = $aux_sec[1];
        $com = $aux_sec[2];
        $carac1 = $aux_sec[3];
        $carac2 = $aux_sec[4];
        $carac3 = $aux_sec[5];
        $sql = " SELECT  re_tipoevaluacion
	 FROM 
	cue_reactivosestandar 
	WHERE ser_claveservicio=:servicio AND 
	sec_numseccion=:seccion AND
	r_numreactivo=:reac AND re_numcomponente=:com AND 
	re_numcaracteristica=:carac1 AND re_numcomponente2=:carac2";
        $parametros = array("servicio" => $servicio, "seccion" => $seccion, "reac" => $reac, "com" => $com, "carac1" => $carac1, "carac2" => $carac2);

        $result = Conexion::ejecutarQuery($sql, $parametros);

        foreach ($result as $row) {
            $eval = $row[0];
        }

        return $eval;
    }

    function validaRegionCuenta() {
        $result = 0;
        $usuario = $_SESSION["UsuarioInd"];

        $grupo = $_SESSION["GrupoUs"];
        // verifico el tipo de usuario
        if ($grupo == "cli" || $grupo == "cue") {
            
//      echo $query;
            $res = UsuarioModel::getUsuario($usuario,"cnfg_usuarios");
            foreach ($res as $row) {
                $nivCons = $row["cus_tipoconsulta"];
                $niv4 = $row["cus_nivel4"];
                $niv1 = $row["cus_nivel1"];
                $niv2 = $row["cus_nivel2"];
                $niv3 = $row["cus_nivel3"];
            }
            if ($grupo == "cli")
                if ($nivCons == 4)
                    $result = $niv4; //devuelvo la region
                else if ($nivCons < 4)
                    $result = 0; //puede ver todos
                else
                    $result = -1; //sin permiso
            else
            if ($grupo == "cue") {

                if ($niv2 > 0) { //es usuario de franquicia
                    $result = $niv1 . "¬" . $niv2; //devuelvo cuenta y franquicia
                    if ($niv3 > 0) //es usuario por p.v.
                        $result = $niv1 . "¬" . $niv2 . "¬" . $niv3;
                } else    //puede ver toda la cuenta
                    $result = $niv1;  //sin permiso
            }
        }
        return $result;
    }

  
    
    public function exportarExcel($worksheet){
        

$nomarch = "Indicadores" . date("dmyHi");
 $this->servicio = $_SESSION["servicioind"];
 $this->cliente=1;
//$this->servicio=1;


define("VACIO", "");
if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $$key_post = filter_input(INPUT_POST, $key_post,FILTER_SANITIZE_STRING);
    }
}

if ($_GET) {
    $keys_post = array_keys($_GET);
    foreach ($keys_post as $key_post) {
        $$key_post = filter_input(INPUT_GET,$key_post,FILTER_SANITIZE_STRING);
    }
}

if (isset($_POST["mes"])) {
    $mes_asig = $_POST["mes"];
}
else
    $mes_asig = $_GET["mes"];

//$mes_asig="4.2012";
//cambio mes a letra

$this->mes_asig = Utilerias::cambiaMesGIng($mes_asig);



//$url_img = "http://muesmerc.com.mx/muesmerc/img/banner_pepsi.jpg";
$url_img = "img/banner_pepsi.jpg";
//$url_img="http://localhost/muesmerc/img/banner_pepsi.jpg";
//$url_img=str_replace("\\", '/', $url_img);


$this->url_imagen= $url_img;

//valido si es de alguna region o cuenta
$grupo = $_SESSION["GrupoUs"];
$vidiomau = $_SESSION["idiomaus"];
// verifico el tipo de usuario
$permiso = $this->validaRegionCuenta();
// si permiso=-1 no verá nada
if ($permiso == -1) {
  
  //  $html->asignar('veo_res', "none");
    //$html->asignar('noveo_res', "table-row");
    $this->mensaje_error= T_("LO SENTIMOS, NO CUENTA CON PERMISO PARA VER ESTA INFORMACION");
    echo $this->mensaje_error;
} else {
    $nivel = $niv;
    $gnivel = $niv;
    if ($grupo == "cue") {
        if (!isset($nivel) || $nivel == "")
            $nivel = 4;
        if (!isset($ren) || $ren == "")
            $reng = $permiso;
        if (!isset($fily)) //filtro inicial
            $gfily = UsuarioModel::buscarReferenciaNivel($this->usuarioSes);
    }
    else {
        if ($permiso == 0 && (!isset($nivel) || $gnivel == ""))
        //comienzo en el nivel 
            $nivel = 4;
        else {

            if (isset($nivel) && ($nivel == $permiso + 1))
                $nivel = $gnivel;
            else {
                if ((!isset($gnivel) || $gnivel == ""))
                    $nivel = ($permiso + 1);
            }
        }
        if (!isset($ren) || $ren == "")
            $reng = "C";



        if ($grupo == "cli" && $permiso > 3 && !isset($filx)) {// si no tengo filtro
            $nivel++;
            $gfilx = UsuarioModel::buscaReferenciaNivel();
        }
    }


  
  if(isset($sec))
        $seccion = $sec;
//     else
//         $seccion = $secdefault;

    $gref = $ref;
    $referencia = $ref;


    $this->referencia=$ref[0];
//        if($_GET["numsem"]==$numsec)// seccion a la que se le aplica seleccion de semaforo
//             $html->asignar('colorsem', $colorsem);
//        else
//             $html->asignar('colorsem',"");

    //$this->numsec=$numsec++;

    $this->nomseccion= $ref[1];
    $this->estandar= $ref[2];
    $columna = "";
    $periodo = '<th>' . $gupcta . '</th>';

    $reng = $ren;
   // $gfiluni = filter_input(INPUT_GET, "filuni", FILTER_SANITIZE_SPECIAL_CHARS);
   

    $tiposec = $sec;
    $gfilx = $filx;
    $gfily = $fily;
    $auxuni = explode(".", $filuni);
    $filx = array();
    $filx["pais"] = $auxuni[0];
    $filx["uni"] = $auxuni[1];
    $filx["zon"] = $auxuni[2];
  
    $aux = explode(".", $gfilx);



    $filx["reg"] = $aux[0];

    $filx["ciu"] = $aux[1];
    $filx["niv6"] = $aux[2];
    $auxy = explode(".", $gfily);
    $fily = array();
    $fily["cta"] = $auxy[0];
    $fily["fra"] = $auxy[1];
     $fily["pv"] = $auxy[2];
//busco si eligio una opcion del semaforo
     $indiTit1=array(
     		'alignment' => array(
     				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
     		),
     		
     		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
     				'startcolor' => array('argb'   =>"ff6B9EDC")),
     		'font' => array("size"    => 16,
     				"name"    => 'Arial Unicode MS'
     		));
   
    $colorsem = $sem;
    $fperiodo = $per;
    $worksheet->setCellValue("A2",T_("INDICADORES POST MIX")." ".$this->mes_asig);
    $worksheet->getStyle("A2")->applyFromArray($indiTit1);
     
   // die($referencia);
    $letra =$this->pintaTablaExcel($worksheet,$mes_asig, $referencia, $permiso, $filx, $fily, $nivel, $reng, $tiposec, $rdata, $colorsem, $fperiodo);
    $worksheet->mergeCells("A3:".Utilerias::michr($letra-1)."3");
    $worksheet->mergeCells("A2:".Utilerias::michr($letra-1)."2");
    $worksheet->mergeCells("A4:".Utilerias::michr($letra-1)."4");
    $worksheet->getRowDimension('1')->setRowHeight(70);
  //  $this->listaResultados=$tabla;
   
}

        
    }

function pintaTablaExcel($worksheet,$mes_asig, $referencia, $permiso, $filx, $fily, $tx, $ty, $tiposec, $rdata, $colorsem, $fperiodo) {
   
     $vidiomau = $_SESSION["idiomaus"];
   
  
    $rs = $this->Consulta($mes_asig, $referencia, $permiso, $filx, $fily, $fperiodo);

  //  $tab_cuenta = new Tablahtml("tablabord");
    $clave_cue = 1;
    $acumtot = 0;
    $acumacep = 0;
    $campNivel[3] = "une_cla_zona";
    $campNivel[4] = "une_cla_estado";
    $campNivel[5] = "une_cla_ciudad";
    $campNivel[6] = "une_cla_franquicia";
    $campNivel[7] = "une_id";
    $campGrup["C"] = "cue_clavecuenta";
    $campGrup["F"] = "fc_idfranquiciacta";
    $campGrup["P"] = "une_id";
    $campGrup["PP"] = "une_id";
    $nivel = $tx; 
    $edo = $filx["reg"];
    $cuenta = filter_input(INPUT_GET,"cta",FILTER_SANITIZE_NUMBER_INT);
    $cd = $filx["ciu"];
    $niv6 = $filx["niv6"];
    $zona = 3;

    $clave_cue = 1;
    $acumtot = 0;
    $acumacep = 0;
    $totalreg = array();
    $auxdatamos = explode(".", $rdata); //guarda los datos que se muestran si num pruebas tam muestra o %
    $total_cuen = array();

    //verifico que haya resultados si no consulto el nombre de la seccion
    $nomAux = null;
    if (sizeof($rs) <= 0) {
        $nomAux = DatosEst::buscaIndicadores($referencia, $vidiomau,$this->servicio);

        foreach($nomAux as $indicador){
        $nomseccion = $indicador[1];
        $estandar = $indicador[2];
        }
    }else
    { 
    	
    	foreach ($rs as $row) {

            $periodo = $acept = $acumtot = 0;
            $cuenta = $row[$campGrup[$ty]]; //sera eje y
            $region = $row[$campNivel[$tx]]; //será eje x
           
            if ($vidiomau == 2) {
                $nomseccion = $row["red_parametroing"];
            } else {
                $nomseccion = $row["red_parametroesp"];
            }
            $estandar = $row["red_estandar"];
            if ($row["mes"] == 1) {
                $periodo = 1;
                $acept = $row["pasa"];
                $acumtot = $row["tot"];
            }
            else

            if ($row["6mes"] == 2) {
                $periodo = 2;
                $acept = $row["pasa"];
                $acumtot = $row["tot"];
            } else
            if ($row["12mes"] == 3) {
                $periodo = 3;
                $acept = $row["pasa"];
                $acumtot = $row["tot"];
            }

            if ($cuenta > 0 && $region > 0) {
                $matriz[$cuenta][$region][$periodo]["acep"] = $acept;
                $matriz[$cuenta][$region][$periodo]["tot"] = $acumtot;
                $total_cuen[$cuenta][$periodo]["acep"]+=$acept;
                $total_cuen[$cuenta][$periodo]["tot"]+=$acumtot;
            }
            //inicializo
            $totalreg[$region][$periodo]["tot"] = 0;
            $totalreg[$region][$periodo]["acep"] = 0;
        }
}
$indiTit2=array(
		'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		),
		
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array('argb'   =>"ff6B9EDC")),
		'font' => array("size"    => 14,
				"name"    => 'Arial Unicode MS'
		));

$worksheet->setCellValue("A3",$nomseccion);
$worksheet->setCellValue("A4",$estandar);
$worksheet->getStyle("A3:A4")->applyFromArray($indiTit2);

 
   
    if ($ty == "C") {
        $gupcta = T_("CUENTA");
        $renglones =$this->cuentas($permiso, $filx);

        $indy = "cta";
    }
    if ($ty == "F") {
        $gupcta = T_("FRANQUICIA");
        $renglones =$this->franquicias($fily["cta"], $filx);
        $indy = "fra";
    }
    if ($ty == "P") {
        $gupcta = T_("PUNTO VENTA");
        $renglones = $this->puntosVenta($zona, $filx, $fily);
    }
     if ($ty == "PP") {
        $gupcta = T_("PUNTO VENTA");
        $renglones = $this->puntoVenta($zona, $filx, $fily);
    }
    $cabcols=array(
    		"bold"=>true,
    		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('argb'   => "ffC5D9F1")),
    		'font' => array("size"    => 12,
    				'name'    => 'Arial Unicode MS',
    				"color"=>array('argb'   => "ff000000")
    		));
    
    $cabcol=array(
    		
    		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('argb'   => "ffC5D9F1")),
    		'font' => array("size"    => 12,
    				'name'    => 'Arial Unicode MS',
    				"color"=>array('argb'   => "ff000000")
    		));
    		
    		
    
    

  //  $tab_cuenta->nuevoren();
    $renglon=5;
    //$tab_cuenta->nuevacol($nomseccion."<br>".$estandar, "", "");
	$letra=65;
   // $tab_cuenta->nuevacolestanch(Estructura::nombreNivel($nivel, $vidiomau), "cabcols", "", "16%");
    $worksheet->setCellValue(Utilerias::michr($letra).$renglon,Estructura::nombreNivel($nivel, $vidiomau));
    $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($cabcols);
  
    //busco nombre de regiones
    $num_regs = 0;
    switch ($nivel) {
        case 2: //busco estados
            $columnas = $this->unidadesNeg($mes_asig, $referencia, $filx, $fily);
            $nivf = "uni";
            
            break;
        case 3: //busco estados
            $columnas = $this->zonas($mes_asig, $referencia, $filx, $fily);
            $nivf = "zon";
            
            break;
        case 4: //busco estados
            $columnas = $this->regiones( $mes_asig, $referencia, $filx, $fily);
            $nivf = "reg";
            break;
        case 5:
            $columnas = $this->ciudades( $mes_asig, $referencia, $permiso, $filx, $fily);

            $nivf = "ciu";

            break;
        case 6:

            //$columnas = niv6($zona, $edo, $cd);
//             echo $zona."--". $mes_asig."--".  $referencia."--". $permiso."--";
//             var_dump($filx);
//             var_dump($fily);
//             echo $this->servicio;
            $columnas = $this->niv6( $mes_asig, $referencia, $permiso, $filx, $fily);
            $nivf = "niv6";
            break;
    }

    for ($i = 0; $i < count($columnas); $i++) {

       // $tab_cuenta->nuevacolestanch($columnas[$i][1], "cabcol", "3", "12%");
        $worksheet->setCellValue(Utilerias::michr($letra).$renglon,$columnas[$i][1]);
         $worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra+2).$renglon);
        $worksheet->getStyle(Utilerias::michr($letra).$renglon)->applyFromArray($cabcol);
        $letra=$letra+3;
        $num_regs++; //cuento el num. de regiones
    }
   
//    while($row_reg=mysql_fetch_array($rs_reg)) {
//        $tab_cuenta->nuevacolestanch($row_reg["est_nombre"], "cabcol", "3","12%");
//
//    }
   // $tab_cuenta->nuevacolestanch(T_("TOTALES"), "cabcols", "3", "12%");
    $worksheet->setCellValue(Utilerias::michr($letra).$renglon,T_("TOTALES"));
    $worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra+2).$renglon);
    $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($cabcols);
 $letra=65;
    $renglon++;
    // despliego tit de meses
   
//    $num_regs=mysql_num_rows($rs_reg);
   // $tab_cuenta->nuevacolest($gupcta, "cabcol", "");
    $worksheet->setCellValue(Utilerias::michr($letra).$renglon,$gupcta);
  
    $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($cabcol);
      $auxper=explode(".", $fperiodo);
     $periodos = array();
   // if($auxper[0])
             array_push($periodos, "M");
    //if($auxper[1])
               array_push($periodos, "6M");
    //if($auxper[2])
              array_push($periodos, "12M");
    for ($reg = 0; $reg < $num_regs + 1; $reg++) {
        for ($per = 0; $per < 3; $per++) {
           // $tab_cuenta->nuevacolestanch($periodos[$per], "cabcol", "", "4%");
            $worksheet->setCellValue(Utilerias::michr($letra).$renglon,$periodos[$per]);
            
            $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($cabcol);
            
        }
    }
    //despliego la matriz

    $totales_cue = 0;
    $totace_cue = 0;
    $contest = 0;
    $estilo1 =array(
    		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
    				'startcolor' => array('argb'   =>"ffFFFFDD")),
    		'font' => array("size"    => 10,
    				"name"    => 'Arial Unicode MS'
    		));
    $estilo2 =array(
    		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
    				'startcolor' => array('argb'   =>"ffC4DAF2")),
    		'font' => array("size"    => 10,
    				"name"    => 'Arial Unicode MS',
    				"color"=>array('argb'   =>"00000000")
    		));
    $gris =array(
    		
    				"color"=>array('argb'   =>"00999999")
    		);
  
    $r = 0;
    //busco tamaño de muestra
    if ($auxdatamos[0] == 1) {

        $arrmuestra = $this->tamanioMuestra($mes_asig, $referencia, $permiso, $filx, $fily, $tx, $ty);
        $matrizmuestra = $arrmuestra[0];
        $totalmuestra = $arrmuestra[1];
    }
    $totalfin = array();
    for ($r = 0; $r < count($renglones); $r++) {
        if ($contest % 2 == 0) {
            $clase = $estilo1;
        }
        else
            $clase = $estilo2;
        $cuen = $renglones[$r][0];
        $letra=65;
        $renglon++;
      //  $tab_cuenta->nuevacolest($renglones[$r][1], $clase, "");
        $worksheet->setCellValue(Utilerias::michr($letra).$renglon,$renglones[$r][1]);
        //   $worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra+3).$renglon);
        $worksheet->getStyle(Utilerias::michr($letra).$renglon)->applyFromArray($clase);
        if ($auxdatamos[0] == 1) {
        	
        	$col=Utilerias::michr($letra);
        
         
           if ($auxdatamos[1] == 1) {
           	$worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra).($renglon+2));
           	
           }
           else  $worksheet->mergeCells($col.$renglon.":".$col.($renglon+1));
        }else
        	if ($auxdatamos[1] == 1) {
        		$worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra).($renglon+1));
        		
        	}
        $letra++;
        if ($num_regs > 1)// si son todas empiezo en 0
            $ini = 1;
        else
            $ini = $permiso;
            $renglonini=$renglon;
        for ($k = 0; $k < sizeof($columnas); $k++) {
               $reng1 = $reng2 = $reng3 = "";
            $reg = $columnas[$k][0];
            $renglon=$renglonini;
            for ($per = 1; $per < 4; $per++) {
            	$renglon=$renglonini;
            	//despliego cada periodo
//                if($matriz[$cuen][$reg][$per]["acep"]!=""){
                $matriz[$cuen][$reg][$per]["tot"] = $matriz[$cuen][$reg][$per]["tot"] + $matriz[$cuen][$reg][$per - 1]["tot"];
                $matriz[$cuen][$reg][$per]["acep"] = $matriz[$cuen][$reg][$per]["acep"] + $matriz[$cuen][$reg][$per - 1]["acep"];
                $acept = $matriz[$cuen][$reg][$per]["acep"];
                $total = $matriz[$cuen][$reg][$per]["tot"];
                 if ($auxdatamos[0] == 1) {

                        if ($matrizmuestra[$cuen][$reg]["muestratot"] != 0 && $total > 0) {
					//	$msg="muestratot =".$matrizmuestra[$cuen][$reg]["muestratot"]." total=".$total;
					//	$SQLGEN= 'insert into INSTRUCTIONS (textosql) values ("'.$msg.'");';
					//	$rs1=@mysql_query($SQLGEN);

						
                            $porcm = $matriz[$cuen][$reg][$per]["tot"] / $matrizmuestra[$cuen][$reg]["muestratot"];
                            $porcm = round($porcm * 100, 1);
                        }
                        else
                            $porcm = "";


                      
                        $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $porcm);
                        $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                        
                 }
                  if ($auxdatamos[1] == 1) {
                        if ($total == 0) {
                            $total = "";
                        }
                        $reng2 =  $total;
                        $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $total);
                        $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                        
                    }
                if ($total != 0)
                {    $porc = $acept / $total * 100;
                    $porc=round($porc, 1);
                }
                else
                    $porc = "";
                
              //  $tab_cuenta->nuevacolest($reng2.$reng1.' <span >' .$porc  . '</span>', $clase, "");
                $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $porc );
                $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($clase);
                //acumulo por mes
                $totalreg[$reg][$per]["tot"]+=$total;
                $totalreg[$reg][$per]["acep"]+=$acept;


//                }
//                else
//                     $tab_cuenta->nuevacolest(VACIO,$clase,"");
            }
              $totalreg[$reg]["muestratot"]+=$matrizmuestra[$cuen][$reg]["muestratot"];
        }
       
        //despliego totales por cuenta
        for ($per = 1; $per < 4; $per++) {
        	$renglon=$renglonini;
               $reng1 = $reng2 = $reng3 = "";
            $total_cuen[$cuen][$per]["acep"] = $total_cuen[$cuen][$per]["acep"] + $total_cuen[$cuen][$per - 1]["acep"];
            $total_cuen[$cuen][$per]["tot"] = $total_cuen[$cuen][$per]["tot"] + $total_cuen[$cuen][$per - 1]["tot"];
            if ($total_cuen[$cuen][$per]["tot"] != 0)
                $porc = $total_cuen[$cuen][$per]["acep"] / $total_cuen[$cuen][$per]["tot"] * 100;
            else
                $porc = " ";
              if ($total_cuen[$cuen][$per]["tot"] > 0) {
                    $porc = $total_cuen[$cuen][$per]["acep"] / $total_cuen[$cuen][$per]["tot"] * 100;
                    $porc = round($porc, 1);
                    $totaltemp = $total_cuen[$cuen][$per]["tot"];
                } else {
                    $porc = " ";
                    $totaltemp = "";
                }
            if ($auxdatamos[0] == 1) {
                    if ($totalmuestra[$cuen]["muestratot"] != 0 && $total_cuen[$cuen][$per]["tot"] > 0) {
                        $porcm = $total_cuen[$cuen][$per]["tot"] / $totalmuestra[$cuen]["muestratot"];
                        $porcm = round($porcm * 100, 1);
                    }
                    else
                        $porcm = "";


                  //  $reng1 = '<strong><span style="color:#999999" >' . $porcm . '</span></strong><br>';
                    $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $porcm );
                    $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                    
                }
                if ($auxdatamos[1] == 1) {
                 //   $reng2 = '<strong><span style="color:#999999"  >' . $totaltemp . '</span></strong><br>';
                    $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $totaltemp );
                    $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                    
                }
            //$tab_cuenta->nuevacolest($reng2.$reng1.'<strong> <span >  ' . $porc. "</span></strong>", $clase, "");
            $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $porc);
            $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($clase);
            
            $totalfin[$per]["acep"]+=$total_cuen[$cuen][$per]["acep"];
            $totalfin[$per]["tot"]+=$total_cuen[$cuen][$per]["tot"];
        }
        $contest++;
          $totalfin["muestratot"]+=$totalmuestra[$cuen]["muestratot"];
    }
      
    //despliego totales por region
    
   $renglon++;
   $letra=65;
   // $tab_cuenta->nuevacolest(T_("TOTALES"), "cabcols", "");
    $worksheet->setCellValue(Utilerias::michr($letra).$renglon, T_("TOTALES"));
    $worksheet->getStyle(Utilerias::michr($letra).$renglon)->applyFromArray($cabcols);
     if ($auxdatamos[0] == 1) {
    	if ($auxdatamos[1] == 1) {
    		$worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra).($renglon+2));
    		
    	}else 
    		$worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra).($renglon+1));
    	
    	
    }else
    	if ($auxdatamos[1] == 1) {
    		$worksheet->mergeCells(Utilerias::michr($letra).$renglon.":".Utilerias::michr($letra).($renglon+1));
    		
    	}
    $letra++;
    $renglonini=$renglon;
    for ($k = 0; $k < sizeof($columnas); $k++) {
           $reng1 = $reng2 = $reng3 = "";
        $reg = $columnas[$k][0];
     $renglon=$renglonini;
        for ($per = 1; $per < 4; $per++) {
        	$renglon=$renglonini;
            if ($totalreg[$reg][$per]["tot"] != 0)
            {     $porc = $totalreg[$reg][$per]["acep"] / $totalreg[$reg][$per]["tot"] * 100;
                  $porc=round($porc, 1);
            }
            else {
                $porc = "";
            }
             if ($auxdatamos[0] == 1) {

                    if ($totalreg[$reg]["muestratot"] != 0 && $totalreg[$reg][$per]["tot"] > 0) {
                        $porcm = $totalreg[$reg][$per]["tot"] / $totalreg[$reg]["muestratot"];
                        $porcm = round($porcm * 100, 1);
                    }
                    else
                        $porcm = "";

                    //  $rowdata[] =$totalreg[$reg][$per]["tot"].'-'.round($porc,1);
                 //   $reng1 = '<span style="color:#999999;  font-weight:bold" title="%' . T_("tam. muestra") . '">' . $porcm . '</span><br>';
                    $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $porcm );
                    $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                    
             }
                //  echo $reg."--".$per."--".$totalreg[$reg][$per]["tot"]."<br>";
                if ($auxdatamos[1] == 1) {
                    if ($totalreg[$reg][$per]["tot"] > 0) {


                        $reng2 = $totalreg[$reg][$per]["tot"] ;
                    } else {
                        $reng2 = '';
                    }
                    $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $reng2 );
                    $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                    
                }
         //   $tab_cuenta->nuevacolest($reng2.$reng1.' <span >  ' . $porc . "</span>", "cabcols", "");
            $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $porc);
            $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($cabcols);
            
        }
    }
    
    //despliego totales finales
   // $renglonini=$renglon
    for ($per = 1; $per < 4; $per++) {
    	$porcm = $porc = 0;
           $renglon=$renglonini;
          if ($auxdatamos[0] == 1) {
                if ($totalfin["muestratot"] != 0 && $totalfin[$per]["tot"] > 0)
                    $porcm = $totalfin[$per]["tot"] / $totalfin["muestratot"];

               // $reng1 =  round($porcm * 100, 1) . '</span><br>';
                $worksheet->setCellValue(Utilerias::michr($letra).$renglon, round($porcm * 100, 1)  );
                $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                
          }
            if ($auxdatamos[1] == 1) {
               // $reng2 = '<span style="color:#999999;  font-weight:bold" title="' . T_("no. pruebas") . '">' . $totalfin[$per]["tot"] . '</span><br>';
                $worksheet->setCellValue(Utilerias::michr($letra).$renglon, $totalfin[$per]["tot"]   );
                $worksheet->getStyle(Utilerias::michr($letra).($renglon++))->applyFromArray($clase);
                
            
            }

        if ($totalfin[$per]["tot"]) {
            $porc = $totalfin[$per]["acep"] / $totalfin[$per]["tot"] * 100;
            
         //   $tab_cuenta->nuevacolest($reng2.$reng1 . round($porc, 1), "cabcols", "");
            $worksheet->setCellValue(Utilerias::michr($letra).$renglon, round($porc, 1));
            $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($cabcols);
            
        } else {
         //   $tab_cuenta->nuevacolest(VACIO, "cabcols", "");
            $worksheet->setCellValue(Utilerias::michr($letra).$renglon,VACIO);
            $worksheet->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($cabcols);
            
        }
    }

    
    
    return $letra;
}
    function getNombreSeccion() {
        return $this->nombreSeccion;
    }

    function getEstandar() {
        return $this->estandar;
    }

    function getVrangov() {
        return $this->vrangov;
    }

    function getVrangoa() {
        return $this->vrangoa;
    }

    function getVrangor() {
        return $this->vrangor;
    }

    function getPeriodos() {
        return $this->periodos;
    }

    function getColorsemv() {
        return $this->colorsemv;
    }

    function getColorsemd() {
        return $this->colorsemd;
    }

    function getColorsema() {
        return $this->colorsema;
    }

    function getColorsemr() {
        return $this->colorsemr;
    }

    function getListaResultados() {
        return $this->listaResultados;
    }

    function getFiltroSel() {
        return $this->filtroSel;
    }
    function getLigaDescargar() {
        return $this->ligaDescargar;
    }

    function setLigaDescargar($ligaDescargar) {
        $this->ligaDescargar = $ligaDescargar;
    }

        
    function getMes_asig() {
        return $this->mes_asig;
    }

    
    function mostrarGrid($mes_asig, $tiposec, $nivel, $gfilx, $reng, $gfily, $referencia, $rdata, $colorsem, $vperiodo, $gfiluni) {


        $aux = explode(".", $mes_asig);



// verifico el tipo de usuario
        $permiso = $this->validaRegionCuenta();

        $aux = explode(".", $gfilx);


        $filx = array();

        $auxuni = explode(".", $gfiluni);
        $filx["pais"] = $auxuni[0];
        $filx["uni"] = $auxuni[1];
        $filx["zon"] = $auxuni[2];
        $filx["reg"] = $aux[0];
        $filx["ciu"] = $aux[1];
        $filx["niv6"] = $aux[2];
        $auxy = explode(".", $gfily);
        $fily = array();
        $fily["cta"] = $auxy[0];
        $fily["fra"] = $auxy[1];
        $fily["pv"] = $auxy[2];
//busco si eligio una opcion del semaforo
// si permiso=-1 no verá nada
        if ($permiso == -1) {
            
        } else {
         //die($vperiodo);
//            if ($colorsem != "") {
//
//                $this->listaResultados = $this->pintaTablaSem($mes_asig, $referencia, $permiso, $filx, $fily, $nivel, $reng, $tiposec, $rdata, $colorsem, $vperiodo);
//            } else {
         //                                          ($mes_asig, $referencia, $permiso, $filx, $fily, $tx, $ty, $tiposec, $rdata, $colorsem, $fperiodo, $gfily) 
   
            $this->listaResultados = $this->pintaTabla($mes_asig, $referencia, $permiso, $filx, $fily, $nivel, $reng, $tiposec, $rdata, $colorsem, $vperiodo, $gfily);
//            }
        }
    }

    function getIndicador_sel() {
        return $this->indicador_sel;
    }

    function getPeriodo_sel() {
        return $this->periodo_sel;
    }

    function getEstructura() {
        return $this->estructura;
    }

    function getFiltrosTD() {
        return $this->filtrosTD;
    }
    
    function getUrl_imagen() {
        return $this->url_imagen;
    }



}

class FiltrosTablaDinamica {

    private $res_numpruebas;
    private $res_tamaniomuestra;
    private $per_measactual;
    private $per_seismeses;
    private $per_docemeses;
    private $rango_sel;
    private $filx;
    private $fily;
    private $filuni;
    private $ref;
    private $sec;
    private $mes;
    private $nivel;
    private $fperiodo;
    private $ren;
    private $colorsemv;
    private $colorsemd;
    private $colorsema;
    private $colorsemr;

    function getFperiodo() {
        return $this->fperiodo;
    }

    function setFperiodo($fperiodo) {
        $this->fperiodo = $fperiodo;
    }

    function getRes_numpruebas() {
        return $this->res_numpruebas;
    }

    function getPer_measactual() {
        return $this->per_measactual;
    }

    function getRes_tamaniomuestra() {
        return $this->res_tamaniomuestra;
    }

    function setRes_tamaniomuestra($res_tamaniomuestra) {
        $this->res_tamaniomuestra = $res_tamaniomuestra;
    }

    function getPer_seismeses() {
        return $this->per_seismeses;
    }

    function getPer_docemeses() {
        return $this->per_docemeses;
    }

    function getRango_sel() {
        return $this->rango_sel;
    }

    function setRango_sel($rango_sel) {
        $this->rango_sel = $rango_sel;
    }

    function setRes_numpruebas($res_numpruebas) {
        $this->res_numpruebas = $res_numpruebas;
    }

    function setPer_measactual($per_measactual) {
        $this->per_measactual = $per_measactual;
    }

    function setPer_seismeses($per_seismeses) {
        $this->per_seismeses = $per_seismeses;
    }

    function setPer_docemeses($per_docemeses) {
        $this->per_docemeses = $per_docemeses;
    }

    function setRan_todos($ran_todos) {
        $this->ran_todos = $ran_todos;
    }

    function setRan_noventa($ran_noventa) {
        $this->ran_noventa = $ran_noventa;
    }

    function setRan_ochenta($ran_ochenta) {
        $this->ran_ochenta = $ran_ochenta;
    }

    function setRan_cero($ran_cero) {
        $this->ran_cero = $ran_cero;
    }

    function getFilx() {
        return $this->filx;
    }

    function getFily() {
        return $this->fily;
    }

    function getFiluni() {
        return $this->filuni;
    }

    function getRef() {
        return $this->ref;
    }

    function getSec() {
        return $this->sec;
    }

    function getMes() {
        return $this->mes;
    }

    function setFilx($filx) {
        $this->filx = $filx;
    }

    function setFily($fily) {
        $this->fily = $fily;
    }

    function setFiluni($filuni) {
        $this->filuni = $filuni;
    }

    function setRef($ref) {
        $this->ref = $ref;
    }

    function setSec($sec) {
        $this->sec = $sec;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function getNivel() {
        return $this->nivel;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setRen($ren) {
        $this->ren = $ren;
    }

    function getRen() {
        return $this->ren;
    }

    function getColorsemv() {
        return $this->colorsemv;
    }

    function getColorsemd() {
        return $this->colorsemd;
    }

    function getColorsema() {
        return $this->colorsema;
    }

    function getColorsemr() {
        return $this->colorsemr;
    }

    function setColorsemv($colorsemv) {
        $this->colorsemv = $colorsemv;
    }

    function setColorsemd($colorsemd) {
        $this->colorsemd = $colorsemd;
    }

    function setColorsema($colorsema) {
        $this->colorsema = $colorsema;
    }

    function setColorsemr($colorsemr) {
        $this->colorsemr = $colorsemr;
    }

  

}

class TablitaDinamica {

    private $nombreNivel;
    private $nivel;
    private $listaResultadosxcuenta;

    function getNombreNivel() {
        return  $this->nombreNivel ;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getListaResultadosxcuenta() {
        return $this->listaResultadosxcuenta;
    }

    function setNombreNivel($nombreNivel) {
        $this->nombreNivel = $nombreNivel;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setListaResultadosxcuenta($listaResultadosxcuenta) {
        $this->listaResultadosxcuenta = $listaResultadosxcuenta;
    }

    function getDivResultado($titulo, $resultado) {
        return '<div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-text">' . $titulo . '</h5>
                    <span class="description-text-2">' . $resultado . '</span>
                  </div>
                  <!-- /.description-block -->
                </div>';
    }

    function getDivPeriodo($periodo, $resultado) {
        return '<div class="row" >
                 <ul class="nav nav-stacked" style="border-top: solid #f4f4f4; padding: 10px 15px;">
                
             <li><strong>' . $periodo . '</strong></li>
                 </ul>
                 <div class="row" >
               
              ' . $resultado . '
              
            </div>
              </div>';
    }

}
