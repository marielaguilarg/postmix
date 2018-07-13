<?php

session_start();
include('libs/php-gettext-1.0.11/gettext.inc');
include('Utilerias/inimultilenguaje.php');
include('Utilerias/utilerias.php');

class GraficaIndicadorController {

    private $navegacion;
    private $navegacion2;
    private $numsecc;
    private $mes_indice;
  
    private $opcionuni;
    private $lb_buscar;
    private $lb_indicadores;
    private $filtros;
    private $nombre_indicador;
    private $nombre_nivel;
    private $codigoGrafica;
    private $periodo;
    private $alertanav;
    private $servicio;
    private $cliente;
    private $opciones_anio;
    private $opciones_mes;
    private $listaSecciones;
       private $listanivel3;
    private $listanivel4;
private $listanivel5;
private $listanivel6;
private $varnivel;

    public function vistaGraficaIndicadores() {
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            eval($asignacion);
        }
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";

            eval($asignacion);
        }
        $_SESSION["servicioind"] = 1;
//session_destroy();
      $select3=$clanivel3;
      $select4=$clanivel4;
      $select5=$clanivel5;
      $select6=$clanivel6;
        $grupo = $_SESSION["GrupoUs"];
        $vidiomau = $_SESSION["idiomaus"];
        $_SESSION["fbuscapv"] = null;
        $this->servicio = 1;
        $this->cliente = 100;
 $_SESSION['Usuario']="marisol";
        
        /* busca opciones de usuario */
        if(isset ($_SESSION['Usuario']))
                  $Usuario = $_SESSION['Usuario'];
        else{
       //mandar al login
            $_SESSION['Usuario']="marisol";
        }

        //   include("MENindbarramenu.php");
// genera info grafica

        $this->filtroPeriodo();
      

        /* si es la primera vez que entro no existe esta variable y la creo
         * 1-mostrar alerta
         * 0- no mostrar
         */
//echo "ll".$_SESSION["alertanav"];
        if (isset($_SESSION["alertanav"]) && $_SESSION["alertanav"] != 0) {
            //ya habia entrado
            $this->alertanav = 0; //no muestro alerta
        } else {
            //no he mostrado alerta
            $this->alertanav = 1;
            $_SESSION["alertanav"] = 1;
        }
//var_dump($_SESSION);
//        $secdefault = $secciones[0][0];
//
//        if (isset($sec) && $sec != "") {
//
//            $this->numsecc = $sec;
//        } else {
//            $this->numsecc = $secdefault;
//            $sec = $secdefault;
//        }
//
//        $seccion = $sec;

        $navegacion = '<li><a href="#" style="z-index:9;">' . T_("GRAFICA") . '</a></li>';

        $this->navegacion = $navegacion;
        Navegacion::borrarRutaActual("a");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("a", $rutaact, T_("GRAFICA"));
        $this->navegacion2 = Navegacion::desplegarNavegacion();


    
        if (isset($mes) && $mes != "") {

            $this->mes_indice = $mes_asig = $mes . "." . $anio;
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
            $this->mes_indice = $mes_asig;
        }
        $mes_consulta = $mes_asig;

        $aux = explode(".", $mes_asig);
        $solomes = $aux[0];

        $soloanio = $aux[1];
        $aux = explode('.', $mes_consulta);
        $mes = $aux[0];
        if ($mes - 12 >= 0) { // calculo para los 12m
            $z = $mes - 12 + 1;

            $mes_pivote = $aux[1] . "-" . $z . "-01";
            $mes_pivote = $z . "." . $aux[1];
        } else {
            $z = $mes + 1;

            $mes_pivote = ($aux[1] - 1) . "-" . $z . "-01";
            $mes_pivote = $z . "." . ($aux[1] - 1);
        }
        $fmes_consulta = $aux[1] . "-" . $aux[0] . "-01";
        $mes_consulta_ant = $mes_pivote;
// verifico el tipo de usuario
        $permiso = TablaDinamicaController::validarRegionCuenta($Usuario, $grupo);

//echo $permiso;
// si permiso=-1 no ver� nada
        

        if ($permiso == -1) {
            $html->asignar('veo_res', "none");
            $html->asignar('noveo_res', "table-row");
            $html->asignar('lb_Notiene', T_("LO SENTIMOS, NO CUENTA CON PERMISO PARA VER ESTA INFORMACION"));
        } else {
            $filuni="1.1".".".$select3;
            $filx=$select4.".".$select5.".".$select6;
            if (isset($niv) && $niv != "") {
                $gnivel = $niv;
            } else if ($permiso == 0) {
                $gnivel = 4;
            } else
                $gnivel = $permiso + 1;


            if ($grupo == "cue") {
                if ($gnivel == "")
                    $nivel = 2;


                $reng = $permiso;
                $gfily = $this->buscaReferenciaNivel();
            }
            else {



                if (isset($filx) && $filx != "") { //escogio filtro
                    $gfilx = $filx;
                    // echo $gfilx;
                    // echo "eligio nivel";
                    //  $html->asignar("refer",$gfilx);
                } else {  //muestra de acuerdo al nivel
                    if (($grupo == "cli" || $grupo == "muf") && $permiso > 3) {// si no tengo filtro
                        $gfilx = $this->buscaReferenciaNivel();
                    } else if ($grupo == "cue") {// si no tengo filtro
                        $gfilx = $this->buscaReferenciaNivel();
                    }
                }


                if (isset($filuni) && $filuni != "") {
                    $gfiluni = $filuni;

//echo $filuni;
                } else
                if ($grupo != "cue") {// si no tengo filtro
                    $gfiluni = $this->buscaReferenciaNivelUni($Usuario, $grupo);
                    // echo $gfiluni;   
                }

                if ($gfiluni == "")
                    $gfiluni = "1.1";
            }


            // echo $gfilx;
            $aux = explode(".", $gfilx);

            $this->opcionuni = $gfiluni;

            $filx = array();

            $filx["reg"] = $aux[0];

            $filx["ciu"] = $aux[1];
            $filx["niv6"] = $aux[2];


            $this->Nivel03 = $aux[0];
            $this->Nivel04 = $aux[1];
            $this->Nivel05 = $aux[2];
            $this->Nivel06 = $aux[3];

            $auxy = explode(".", $gfily);

            $fily = array();

            $fily["cta"] = $auxy[0];

            $fily["fra"] = $auxy[1];
            $fily["pv"] = $auxy[2];

            $auxuni = explode(".", $gfiluni);

            $filx["pais"] = $auxuni[0];
            $filx["uni"] = $auxuni[1];
            $filx["zon"] = $auxuni[2];
            if ($filx["pais"] != "" && $filx["pais"] != 0) {

                $nompais = Datosnuno::nombreNivel1($filx["pais"], "ca_nivel1");
            }

//var_dump($filx);
            if ($filx["uni"] != "" && $filx["uni"] != 0) {

                $nomuni = Datosndos::nombreNivel2($filx["uni"], "ca_nivel2");
            }
            if ($filx["zon"] != "" && $filx["zon"] != 0) {

                $nomzon = "-" . Datosntres::nombreNivel3($filx["zon"], "ca_nivel3");
            }
            if ($filx["reg"] != "" && $filx["reg"] != 0) {

                $nomreg = "-" . Datosncua::nombreNivel4($filx["reg"], "ca_nivel4");
            }
            if ($filx["ciu"] != "" && $filx["ciu"] != 0) {

                $nomciu = "-" . Datosncin::nombreNivel5($filx["ciu"], "ca_nivel5");
            }

//echo $filx["niv6"]; 
            if ($filx["niv6"] != "" && $filx["niv6"] != 0) {
                $nomniv6 = "-" . Datos::nombreNivel6($filx["niv6"], "ca_nivel6");
            }


            if ($fily["cta"] != "")
                $nomcta = DatosCuenta::nombreCuenta($fily["cta"]);
            if ($fily["fra"] != "")
                $nomfra = "-" . DatosFranquicia::nombreFranquicia($fily["cta"], $fily["fra"]);
            if ($fily["pv"] != "")
                $nompv = "-" . DatosUnegocio::nombrePV($fily["cta"], $fily["fra"], $fily["pv"]);



            $lugar = $nomuni . " " . $nomzon . " " . $nomreg . " " . $nomciu . " " . $nomniv6 . " " . $nomcta . " " . $nomfra . " " . $nompv;

//filtro de niveles
            $rs_usuarios = UsuarioModel::getUsuario($Usuario,"cnfg_usuarios");
           
foreach ($rs_usuarios as $row_usuarios ) {
//            $html->asignar('USUARIO', "<span class='TitPost'>" . $row_usuarios ["cus_nombreusuario"] . "</span>");
    $GradoNivel = $row_usuarios ["cus_tipoconsulta"];
    $grupo = $row_usuarios ["cus_clavegrupo"];
    $Nivel01 = $row_usuarios ["cus_nivel1"];
    $Nivel02 = $row_usuarios ["cus_nivel2"];
//                    echo "niv".$Nivel02;
    $Nivel03 = $row_usuarios ["cus_nivel3"];
    $Nivel04 = $row_usuarios ["cus_nivel4"];
    $Nivel05 = $row_usuarios ["cus_nivel5"];
    $Nivel06 = $row_usuarios ["cus_nivel6"];
   
}

$VarNivel2 = $GradoNivel;
     //busco el nivel de consulta y agrupo



if($VarNivel2=="")
   $VarNivel2=1;

  $this->varnivel=$VarNivel2;

if ($grupo == 'adm' || $grupo == 'mue' || $grupo == 'cli'|| $grupo == 'aud' || $grupo == 'muf') {
    
   
    if ($grupo == 'adm' || $grupo == 'mue'|| $grupo == 'aud' || $grupo == 'muf')
    //nivel uno por default
        $GradoNivel = $VarNivel2 ;
    $this->varnivel=$VarNivel2;
    if ($VarNivel2 == NULL) {

    } else {
      //    die($VarNivel2."--".$grupo);
        $Nivel01=1;
        $Nivel02=1;
        if ($VarNivel2 == 1||$VarNivel2 == 2) {
            
            
            $RS_SQM_TE = Datosntres::vistantresModel($Nivel02,"ca_nivel3");
           
            $this->listanivel3 = Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select2);
          //   die( $this->listanivel3 )  ; 
            
         
          

            $this->nombrenivel3= Estructura::nombreNivel(3,$_SESSION["idiomaus"]);
           
            $this->nombrenivel4=Estructura::nombreNivel(4,$_SESSION["idiomaus"]);

             $this->nombrenivel5= Estructura::nombreNivel(5,$_SESSION["idiomaus"]);
            $this->nombrenivel6= Estructura::nombreNivel(6,$_SESSION["idiomaus"]);
          
            if(isset($select3)&&$select3!=0){
                $this->listanivel4=Utilerias::crearOpcionesNivel($Nivel01,  $select3,$select4);
            }
             if(isset($select4)&&$select4!=0){
                   $this->listanivel5=Utilerias::crearOpcionesNivel($Nivel01, $select4,$select5);
            }
             
            if(isset($select5)&&$select5!=0){
                 $this->listanivel6= Utilerias::crearOpcionesNivel($Nivel01,  $select5,$select6);
            }
        }
        if ($VarNivel2 == 3) {
            $RS_SQM_TE = Datosntres::vistantresModel("ca_nivel4",$Nivel03);
            $this->listanivel4 = Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select4);
         
            /*                     * **************************************************** */
          
            
           
              $this->nombrenivel4=Estructura::nombreNivel(4,$_SESSION["idiomaus"]);

             $this->nombrenivel5= Estructura::nombreNivel(5,$_SESSION["idiomaus"]);
            $this->nombrenivel6= Estructura::nombreNivel(6,$_SESSION["idiomaus"]);
             if(isset($select4)&&$select4!=0){
                 $this->listanivel5 = Utilerias::crearOpcionesNivel($Nivel01,  $select4,$select4);
            }
              
            if(isset($select5)&&$select5!=0){
                 $this->listanivel6 =Utilerias::crearOpcionesNivel($Nivel01, $select5, $select6);
            }
        }

        if ($VarNivel2 == 4) {
            /*                     * **NUEVO MODULO PHP** */
        
             $RS_SQM_TE = Datosncin::vistancinModel("ca_nivel5",$Nivel04);
            $this->listanivel5 = Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select5);
         
              $this->nombrenivel5=Estructura::nombreNivel($VarNivel2 + 1,$_SESSION["idiomaus"]);

              $this->nombrenivel6=Estructura::nombreNivel($VarNivel2 + 2,$_SESSION["idiomaus"]);
                  
          
            if(isset($select5)&&$select5!=0){
                 $this->listanivel6 =Utilerias::crearOpcionesNivel($Nivel01, $select5,$select6);
            }
        }

        if ($VarNivel2 == 5) {
          

               $RS_SQM_TE = Datosnsei::vistanseisModel("ca_nivel6",$Nivel05);
            $this->listanivel5 = Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select6);
         
        
           $this->nombrenivel5=Estructura::nombreNivel($VarNivel2 + 1,$_SESSION["idiomaus"]);
        }
        if ($VarNivel2 == 6) {
            /*                     * **NUEVO MODULO PHP** */
               $RS_SQM_TE = Datosnsei::vistanseiOpcionModel("ca_nivel6",$Nivel06);
           $this->listanivel6 =Utilerias::crearOpcionesSel( $Nivel06,$Nivel06);
            /*                     * ******************************************************************* */


        }
  
    }
}


//-----------------------------------
//  inicializo etiquetas por idioma
//  -----------------------------------


            $cad_buscapv = '
     <a href="MENindprincipal.php?admin=buspv" >' . T_("PUNTO DE VENTA") . '</a>';
            if ($fily["pv"] == "") //no muestro para usr cuenta con nivel 3
                $this->lb_buscar = $cad_buscapv;
            else
                $this->lb_buscar = '<div class="seleccionidioma" >';
            /* 		echo '<script>alert("'.$gfilx.'")</script>';   */
            $cad_buscapv = ' <div class="seleccionidioma" >
     <a href="index.php?action=indindicadores&mes=' . $mes_asig . '&filx=' . $gfilx . '&fily=' . $gfily . '&filuni=' . $gfiluni . '" >' . T_("INDICADORES") . '</a><span > | </span>';
            //s $cad_buscapv=''
            $this->lb_indicadores = $cad_buscapv;





            $mesletra = Utilerias::cambiaMesGIng($mes_pivote) . "-" . Utilerias::cambiaMesGIng($mes_asig);

            /** variables de sesi�n para los filtros */
            /* 		echo '<script>alert("'.$gfilx.'")</script>';   */
            $_SESSION["fper"] = null; /*             * variable para el periodo 6M, 12M */
            $_SESSION["fmes"] = $mes; /* indice de aignacion */
            $_SESSION["fsec"] = $sec; /* seccion */
            $_SESSION["fniv"] = $niv;  /* nivel de consulta */
            $_SESSION["ffilx"] = $gfilx;
            $_SESSION["ffily"] = $gfily;
            $_SESSION["fref"] = null;


            $this->mes_asig = $mesletra;
                
        $secciones = DatosEst::buscaSeccionesIndi($this->servicio, $vidiomau);
      
        foreach ($secciones as $key) {
            $seccion=new SeccionIndi;
            $seccion->setTitulo($key[1]);
          //    echo $key[0];
            $seccion->setUrlDatos("Controllers/indpostmix/indgeneragrafindicjson.php?sec=" . $key[0] . "&mes=" . $mes_asig . "&filx=" . $gfilx . "&fily=" . $gfily . "&niv=" . $gnivel . "&filuni=" . $gfiluni);
          
           // $seccion->generaTabla($key[0]);
            $this->listaSecciones[] = $seccion;
        }


       

            $this->nombre_nivel = $lugar;
            $this->periodo = $mesletra;
//echo "Views/modulos/indgeneragrafindic.php?sec=" . $seccion . "&mes=" . $mes_asig . "&filx=" . $gfilx . "&fily=" . $gfily . "&niv=" . $gnivel . "&filuni=" . $gfiluni;
            //  "Controllers/indpostmix/indgeneragrafindicjson.php?sec=5&mes=5.2018&filx=&fily=&niv=4&filuni=1.1"
           
        }
    }

/***********hay que quitar**************/
    function nombreSeccion($seccion, $vidiomau) {

//echo $sql;
        if ($vidiomau == 1) {
            $nomcampo = "sec_nomsecind";
            $nomcampo = "sec_nomsecesp";
        } else {
            $nomcampo = "sec_nomsecing";
        }
        $rs = DatosSeccion::editaSeccionModel($seccion, 1, "cue_secciones");
        //  $rs = DatosSeccion::vistaSeccionModel(1, "cue_secciones");

        foreach ($rs as $row) {

            $arr = $rs[$nomcampo];
        }

        return $arr;
    }

    function buscaReferenciaNivelUni($usuario, $grupo) {
        $result = 0;

        // verifico el tipo de usuario

        $query = "SELECT
cnfg_usuarios.cus_usuario,
cnfg_usuarios.cus_clavegrupo,
cnfg_usuarios.cus_tipoconsulta,
cnfg_usuarios.cus_nivel1,
cnfg_usuarios.cus_nivel2,
cnfg_usuarios.cus_nivel3,
cnfg_usuarios.cus_nivel4,
cnfg_usuarios.cus_nivel5,
cnfg_usuarios.cus_nivel6,
cnfg_usuarios.cus_cliente,
cnfg_usuarios.cus_servicio,
cnfg_usuarios.cus_nombreusuario
FROM
cnfg_usuarios
where cus_usuario=:usuario and cnfg_usuarios.cus_cliente=:cliente and
cnfg_usuarios.cus_servicio=:servicio";
        $parametros = array("cliente" => $this->cliente, "servicio" => $this->servicio, "usuario" => $usuario);

        $res = Conexion::ejecutarQuery($query, $parametros);
        foreach ($res as $row) {
            $nivCons = $row["cus_tipoconsulta"];
            if ($grupo == "cli") {
                if ($row["cus_nivel3"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"];
                else if ($row["cus_nivel2"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"];
                else
                    $refer = $row["cus_nivel1"];
            } else if ($grupo == "cue") {
                if ($row["cus_nivel3"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"];
                else if ($row["cus_nivel2"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"];
                else
                    $refer = $row["cus_nivel1"];
            } else if ($grupo == "muf") {
                if ($row["cus_nivel4"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"] . "." . $row["cus_nivel4"];
                else if ($row["cus_nivel3"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"];
                else if ($row["cus_nivel2"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"];
                else
                    $refer = $row["cus_nivel1"];
            }
        }

        return $refer;
    }

    public function filtroPeriodo() {
        $arr_meses = array(strtoupper(T_("Enero")), strtoupper(T_("Febrero")), strtoupper(T_("Marzo")), strtoupper(T_("Abril")), strtoupper(T_("Mayo")), strtoupper(T_("Junio")), strtoupper(T_("Julio")), strtoupper(T_("Agosto")), strtoupper(T_("Septiembre")), strtoupper(T_("Octubre")), strtoupper(T_("Noviembre")), strtoupper(T_("Diciembre")));

        $sql_anio = "SELECT 	 
	num_per_asig	 
	FROM 
	ca_mesasignacion 
	GROUP BY num_per_asig
	ORDER BY num_per_asig";
        $rsanio = Conexion::ejecutarquerysp($sql_anio);
        $this->opciones_anio = "";
        foreach ($rsanio as $rowanio) {

            $this->opciones_anio .= ' <option value="' . $rowanio[0] . '">' . $rowanio[0] . '</option>';

            $this->opciones_mes = "";
            foreach ($arr_meses as $key => $value) {
                $this->opciones_mes .= ' <option value="' . ($key + 1) . '">' . $value . '</option>';
            }
        }
    }
/***************hay que uitar*********/
    public function filtroSecciones() {
// genera secciones

        $secciones = DatosEst::buscaSeccionesIndi($this->servicio, $_SESSION["idiomaus"]);


        foreach ($secciones as $key) {

            $this->listaSecciones .= '  <option value="' . $key[0] . '">' . $key[1] . '</option>';
        }
    }

    function getListaPeriodo() {
        return $this->listaPeriodo;
    }

    function getListaNivel() {
        return $this->listaNivel;
    }

    function getNavegacion() {
        return $this->navegacion;
    }

    function getNavegacion2() {
        return $this->navegacion2;
    }

    function getNumsecc() {
        return $this->numsecc;
    }

    function getMes_indice() {
        return $this->mes_indice;
    }

    function getNivel03() {
        return $this->Nivel03;
    }

    function getNivel04() {
        return $this->Nivel04;
    }

    function getNivel05() {
        return $this->Nivel05;
    }

    function getNivel06() {
        return $this->Nivel06;
    }

    function getOpcionuni() {
        return $this->opcionuni;
    }

    function getLb_buscar() {
        return $this->lb_buscar;
    }

    function getLb_indicadores() {
        return $this->lb_indicadores;
    }

    function getFiltros() {
        return $this->filtros;
    }

    function getNombre_indicador() {
        return $this->nombre_indicador;
    }

    function getNombre_nivel() {
        return $this->nombre_nivel;
    }

    function getCodigoGrafica() {
        return $this->codigoGrafica;
    }

    function setListaSeccion($listaSeccion) {
        $this->listaSeccion = $listaSeccion;
    }

    function setListaPeriodo($listaPeriodo) {
        $this->listaPeriodo = $listaPeriodo;
    }

    function setListaNivel($listaNivel) {
        $this->listaNivel = $listaNivel;
    }

    function setNavegacion($navegacion) {
        $this->navegacion = $navegacion;
    }

    function setNavegacion2($navegacion2) {
        $this->navegacion2 = $navegacion2;
    }

    function setNumsecc($numsecc) {
        $this->numsecc = $numsecc;
    }

    function setMes_indice($mes_indice) {
        $this->mes_indice = $mes_indice;
    }

    function setNivel03($Nivel03) {
        $this->Nivel03 = $Nivel03;
    }

    function setNivel04($Nivel04) {
        $this->Nivel04 = $Nivel04;
    }

    function setNivel05($Nivel05) {
        $this->Nivel05 = $Nivel05;
    }

    function setNivel06($Nivel06) {
        $this->Nivel06 = $Nivel06;
    }

    function setOpcionuni($opcionuni) {
        $this->opcionuni = $opcionuni;
    }

    function setLb_buscar($lb_buscar) {
        $this->lb_buscar = $lb_buscar;
    }

    function setLb_indicadores($lb_indicadores) {
        $this->lb_indicadores = $lb_indicadores;
    }

    function setFiltros($filtros) {
        $this->filtros = $filtros;
    }

    function setNombre_indicador($nombre_indicador) {
        $this->nombre_indicador = $nombre_indicador;
    }

    function setNombre_nivel($nombre_nivel) {
        $this->nombre_nivel = $nombre_nivel;
    }

    function setCodigoGrafica($codigoGrafica) {
        $this->codigoGrafica = $codigoGrafica;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getAlertanav() {
        return $this->alertanav;
    }

    function getOpciones_anio() {
        return $this->opciones_anio;
    }

    function getOpciones_mes() {
        return $this->opciones_mes;
    }

    function getListaSecciones() {
        return $this->listaSecciones;
    }
    
    function getListanivel4() {
        return $this->listanivel4;
    }

    function getListanivel5() {
        return $this->listanivel5;
    }

    function getListanivel6() {
        return $this->listanivel6;
    }
    function getListanivel3() {
        return $this->listanivel3;
    }




}

class SeccionIndi{
    private $titulo;
    private $urlDatos;
    private $tabla;
    
    function generaTabla($seccion){
         $usuario_act = $_SESSION["Usuario"];
         $resres=new ResumenResultadosController();
    $resres->setVcliente($_SESSION["clienteind"]);
     $resres->setVservicio($_SESSION["servicioind"]);
     $resres->inicializar();
    
         
          /*         * *********** calidad del agua ********************** */
//$seccion2 = ConsultaAtributos('5.0.2');
         switch($seccion){
             case 8:
                 /* * ****** calidad de la bebida***************** */
                 $sec_calbebida = array('8.0.2.6', '8.0.2.9' ,'8.0.1.9');
               
                $this->tabla = $resres->ConsultaSeccion($usuario_act, $sec_calbebida, '');
                break;
         case 5:
        $seccion2 = array("5.0.2.18", "5.0.2.17", "5.0.2.5", "5.0.2.9",
            "5.0.2.1", "5.0.2.2", "5.0.2.3", "5.0.2.4", "5.0.2.6", "5.0.2.7", "5.0.2.8", "5.0.2.10",
            "5.0.2.11", "5.0.2.12", "5.0.2.13", "5.0.2.16", "5.0.2.19", "5.0.2.20");
        $this->tabla = $resres->ConsultaSeccion($usuario_act, $seccion2, '');
       break;
         case 2:
        /*         * ************** frescura de jarabes ******************* */
        /*
          $tabla = ConsultaSeccion ( $usuario_act, array(6,7), 'V' );
          $html->asignar ( 'tablaseccion', $tabla );
          $html->expandir ( 'SECCIONES', '+listasec' ); */
        /*         * ************************* presiones ********************** */
        $seccion2 = $resres->ConsultaAtributos('2.8.1');

        $this->tabla = $resres->ConsultaSeccion($usuario_act, $seccion2, '');
       break; 
             default:
        /*         * ************************buenos habitos *********************************** */
          $sec_condiciones = array('6', '7', '3.3', '8.0.2.5', '3.6', '3.7', '3.9', '3.10', '3.2', '3.4');
        $this->tabla = $resres->ConsultaSeccion($usuario_act, $sec_condiciones, 'P');
     
         break;
    }
    }
    
    function getTitulo() {
        return $this->titulo;
    }

    function getUrlDatos() {
        return $this->urlDatos;
    }

    function getTabla() {
        return $this->tabla;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setUrlDatos($urlDatos) {
        $this->urlDatos = $urlDatos;
    }

    function setTabla($tabla) {
        $this->tabla = $tabla;
    }


}