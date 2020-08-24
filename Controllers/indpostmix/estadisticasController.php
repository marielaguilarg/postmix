<?php
    @session_start();
include "navegacion.php";
include "generarBusquedaController.php";



class EstadisticasController {

    private $nivel;
    private $nombreSeccion;
    private $titulopag;
    private $estadisticas;
    private $ligasi;
    private $ligano;
    private $lb_tamano_muestra;
    private $graficaaplica;
    private $graficanivelcumpl;
    private $graficagen;
    private $graficafrec;
    private $graf_cumplaj;
   
    private $vserviciou;
    private $vclienteu;
    private $tit_frec;
    private $filtrosSel;
    private $titulo2;
    private $listaEstablecimientos;
    private $notaEstabl;
    private $tit_cumplaj;
    private $busqueda;
    private $mostrar;

    public function vistaIndEstadisticaRes() {
        $maxte=ini_get('max_execution_time');
        ini_set('max_execution_time',400);
        if ($_GET) {
            $keys_get = array_keys($_GET);
            foreach ($keys_get as $key_get) {
                $$key_get = filter_input(INPUT_GET, $key_get, FILTER_SANITIZE_SPECIAL_CHARS);
                //error_log("variable $key_get viene desde $ _GET");
            }
        }
     
        if($admin!=1)
        { $this->busqueda=new GenerarBusquedaController;
        $this->busqueda->generarBusquedaRes();
        }
//echo $_SESSION["UsuarioInd"];
     
        $Usuario = $_SESSION["UsuarioInd"];


        $tit_secciones = array(T_('CALIDAD DE LA BEBIDA'), T_('CALIDAD DEL AGUA'), T_('PRESIONES DE OPERACION'), T_('BUENOS HABITOS DE MANUFACTURA'));


        $vidiomau = $_SESSION["idiomaus"];
        $_SESSION["uidioma"] = $vidiomau;
        $this->vserviciou=$_SESSION["servicioind"];
        $this->vclienteu=$_SESSION["clienteind"];
       

// validacion para saber si es desde disposivo movil para mostrara otra pagina
//$html->definirBloque('listaNav', 'wpanel');
//-----------------------------------
//  inicializo etiquetas por idioma
//  -----------------------------------

        $cuenta = $cta;
     
        if (isset($filx)) {
            $auxx = explode(".", $filx);
            $auxy = explode(".", $fily);
            $cuenta = $auxy[0];
        
//             $filx=array();
//         $filx["reg"] = $auxx[0];
//         $filx["ciu"] = $auxx[1];
//         $filx["niv6"] = $auxx[2];
        }
        $gfiluni = $filuni;

        $auxuni = explode(".", $gfiluni);

//         $filx["pais"] = $auxuni[0];
//         $filx["uni"] = $auxuni[1];
//         $filx["zon"] = $auxuni[2];

        if ($admin==1) {// vengo de consulta resultados
//              var_dump($_SESSION);
//              ();
            $gfilx = $_SESSION["ffilx"];
            $gfily = $_SESSION["ffily"];
            $gfiluni = $_SESSION["ffiluni"];
            $aux = explode(".", $gfilx);
            $auxuni = explode(".", $gfiluni);
//die($gfiluni);
            $select1 = $auxuni[0];
             $select2 = $auxuni[1];
             $select3 = $auxuni[2];

             $select4 = $aux[0];

             $select5 = $aux[1];

             $select6 = $aux[2];
            $auxy = explode(".", $gfily);

            $cuenta = $auxy[0];
            if($cuenta==""){
            	$cuenta=$_SESSION["fcuenta"];
            	$fily=$cta.".";
            }
            $franquiciacta = $auxy[1];


            //   $periodo = $_SESSION["fperiodo"];
        }


       

// si es m�s de un establecimiento ver tama�o de muestra

//        if ($ptv == "") {
//            $this->lb_tamanio_muestra='';
//}
        $numseccion = $seco;
//   echo $numseccion;
//echo $subseccion;
        if ($refer) {
            $subseccion = $refer;
            $nuevaop = $subseccion;

            $datini = SubnivelController::obtienedato($subseccion, 1);
            $londat = SubnivelController::obtienelon($subseccion, 1);
            $numseccion = substr($subseccion, $datini, $londat);
        }
//   echo "  la cuenta es  ".$numseccion;

	//	echo "llegue aqui";
		

        $filtros = array('unidadneg', "franquicia", "region", "zona", "cedis");


        $cont = 0;
        foreach ($filtros as $fil) {
//    if($cont==0)
//        creaFiltro($fil,1,0);//creo nuevo renglon
//    elseif ($cont==3) {
//        creaFiltro($fil, 0, 1);
//        $cont=0;
//    }
//    else
            $this->creaFiltro($fil); //todavia no se para que sirve
            $cont++;
        }

        /* ----------------------
         * agrego barra de ubicacion
         */
        $_SESSION["fper"] = $per;



        $this->filtrosSel = new ConsultaIndicadores();

      
        $resseccion = DatosSeccion::editaSeccionModel($numseccion, $this->vserviciou, "cue_secciones");


        if ($vidiomau == 2) {
            $nomseccion = $resseccion ["sec_descripcioning"];
        } else {
            $nomseccion = $resseccion ["sec_descripcionesp"];
        }
        $tiposec = $resseccion ["sec_tiposeccion"];
		//echo "sera aqui"; 
        //  $this->nombreSeccion= $tit_secciones[$tit - 2];
        $this->nombreSeccion = $nomseccion;
// excepcion para cambiar el tipo de seccion de la seccion 2
//en lo que investigo como saber si tiene reactivo
        if ($numseccion == 2)
            $tiposec = 'E';

        if ($vidiomau == 2) {
            $this->titulopag = "<div align='left'>STATISTICS</div>";
        } else {

            $this->titulopag = "<div align='left'>ESTADISTICAS</div>";
        }
        $numop = $subseccion;
//el nombre del componente pasa a genera estadistica
//if ($numop != '') //si hay datos muestra la grafica
//{

  
        $this->generarEstadisticas($tiposec, $numop, $mes, $filx, $fily,$ptv);
        
        
          if (isset($ptv)) {
            $unidadnegocio = $ptv;

            $nomunegocio = DatosUnegocio::nombrePV( $unidadnegocio);
            //  $html->asignar('ptoventa', 'Punto Venta: <span class="NuevoEtiqueta"> ' . $row_neg ["une_descripcion"] . "</span>");
           
            $this->filtrosSel->setNombre_nivel($nomunegocio);

            $_SESSION["finfoarea"] = $nomunegocio;
        }
      
        /*
          } else
          echo "error"; */
//$html->asignar ( 'REGRESAR', "MENprincipal.php?op=Bhistorico2&Opcion=res" );
//var_dump($_SESSION);
//reviso la pagina anterior en el historico

      //    echo "y aca"; die();

        $ult = sizeof($_SESSION["historico"]) - 2;
//veo grupo para saber a donde regresa
//        if ($_SESSION["grupous"] == "cli" || $_SESSION["grupous"] == "cue") {
//            $strRegresar = "MENprincipal.php?op=indi&admin=cons&mes=&sec=" . $_GET["tit"] . "&ref=" . $subseccion;
//        } else
//            $strRegresar = 'MENprincipal.php?op=Bhistorico2&Opcion=consulta&tcons=res';
        $strRegresar = "javascript: history.back();";
//$navegacion='<li><a href="MENindprincipal.php?op=mindi&mes='.$_SESSION["fmes"].'&sec='.$numseccion.'&filx='.$_SESSION["ffilx"].'&niv='.$_SESSION["fniv"].'" style="z-index:9;">'.T_("GRAFICA").'</a></li>';
// $navegacion.='<li><a href="MENindprincipal.php?op=mindi&admin=cons&mes='.$_SESSION["fmes"].'&sec='.$numseccion.'&filx='.$_SESSION["ffilx"].'&fily='.$_SESSION["ffily"].'&ref='.$subseccion.'&niv='.$_SESSION["fniv"].'&ren='.$_SESSION["fren"].'" style="z-index:8;">'.T_("INDICADORES").'</a></li>';
// /* si vengo de resumen de resultados*/
// if($numnegocio!="")
//     $navegacion.='  <li><a href="MENprincipal.php?op=mindi&admin=consulta2&mes='.$_SESSION["fmes"].'&ptv='.$ptv.'&fily='.$_SESSION["ffily"].'&ref='.$subseccion.'" style="z-index:7;">'.$nomunegocio.'</a></li>';
// $navegacion.='  <li><a href="#" style="z-index:6;">'.T_("ESTADISTICAS").'</a></li>';
// 
        Navegacion::borrarRutaActual("c");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("c", $rutaact, T_("ESTADISTICAS"));
        //    $html->asignar('NAVEGACION2', desplegarNavegacion());
    }

  /*  public function vistaIndEstadistica() {


        $cuenta = filter_input(INPUT_GET, 'cta', FILTER_SANITIZE_SPECIAL_CHARS);
        // $ptv=filter_input(INPUT_GET, 'ptv', FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($filx)) {
            $auxx = explode(".", $filx);
            $auxy = explode(".", $fily);
            $cuenta = $auxy[0];
        }
        if (filter_input(INPUT_GET, 'admin', FILTER_SANITIZE_SPECIAL_CHARS) == "graficares") {// vengo de consulta resultados
            // var_dump($_SESSION);
            $gfilx = $_SESSION["ffilx"];
            $gfily = $_SESSION["ffily"];
            $gfiluni = $_SESSION["ffiluni"];
            $aux = explode(".", $gfilx);
            $auxuni = explode(".", $gfiluni);

            $select1 = $auxuni[0];
            $select2 = $auxuni[1];
            $select3 = $auxuni[2];

            $select4 = $aux[0];

            $select5 = $aux[1];

            $select6 = $aux[2];
            $auxy = explode(".", $gfily);

            $cuenta = $auxy[0];

            $franquiciacta = $auxy[1];

            $periodo = $_SESSION["fperiodo"];
        }
        if (isset($select2) && $select2 != "0" && $select2 != "")
            $vuni = (buscaNivel($select1 . "." . $select2));
        if (isset($select3) && $select3 != "0" && $select3 != "")
            $vzona = "-" . (buscaNivel($select1 . "." . $select2 . "." . $select3));
        if (isset($select4) && $select4 != "0" && $select4 != "")
            $vregion = "-" . (buscaNivel($select1 . "." . $select2 . "." . $select3 . "." . $select4));


        if ($select5 != "" && $select5 != "0")
            $vciudad = "- " . (buscaNivel($select1 . "." . $select2 . "." . $select3 . "." . $select4 . "." . $select5));

        //$html->asignar('vciudad',buscaNivel($select1.".".$select2.".".$select3.".".$select4.".".$select5));
        if ($select6 != "" && $select6 != "0")
            $v_nivel6 = "- " . (buscaNivel($select1 . "." . $select2 . "." . $select3 . "." . $select4 . "." . $select5 . "." . $select6));

        // $html->asignar('v_nivel6', buscaNivel($select1.".".$select2.".".$select3.".".$select4.".".$select5.".".$select6));
        $vcuenta = (buscaCuenta(100, 1, $cuenta));
        //$html->asignar('vcuenta', buscaCuenta(100, 1, $cuenta));
        if ($franquiciacta != "") {
            $vfranquicia = "- " . (buscaFranquicia($franquiciacta, 100, 1, $cuenta));
            //$html->asignar('vfranquicia', buscaFranquicia($franquiciacta));
        }
        if ($unidadnegocio != "")
            $ptv = $unidadnegocio;


        $_SESSION["fperiodo"] = $periodo;

        $estadisticas = new ResumenResultado();
        $estadisticas->setIndicador($indicador);
        $estadisticas->setPeriodo($periodo);
        $estadisticas->setNivel($vuni . " " . $vzona . " " . $vregion . " " . $vciudad . " " . $v_nivel6);
        $estadisticas->setFranquicia($vcuenta . " " . $vfranquicia);


        $numseccion = filter_input(INPUT_GET, 'seco', FILTER_SANITIZE_SPECIAL_CHARS);
//   echo $numseccion;
//echo $subseccion;
        $subseccion = filter_input(INPUT_GET, 'refer', FILTER_SANITIZE_SPECIAL_CHARS);
        if ($subseccion) {

            $nuevaop = $subseccion;

            $datini = obtienedato($subseccion, 1);
            $londat = obtienelon($subseccion, 1);
            $numseccion = substr($subseccion, $datini, $londat);
        }
//   echo "  la cuenta es  ".$numseccion;



        $filtros = array('unidadneg', "franquicia", "region", "zona", "cedis");


        $cont = 0;
        foreach ($filtros as $fil) {
//    if($cont==0)
//        creaFiltro($fil,1,0);//creo nuevo renglon
//    elseif ($cont==3) {
//        creaFiltro($fil, 0, 1);
//        $cont=0;
//    }
//    else
            creaFiltro($fil);
            $cont++;
        }

        /* ----------------------
         * agrego barra de ubicacion
         */
    /*    $_SESSION["fper"] = $per;


        if ($cuenta != 0) {



            $rs_cu = DatosCuenta::editarCuentaModel($cuenta, "ca_cuentas");
            if (sizeof($rs_cu) > 0) {
                $row_neg = $rs_cu[0];
                $nombre = $row_neg ["nom"];
            }
        } else
            $nombre = T_("TODAS");




        $unidadnegocio = $ptv;


        $rs_neg = DatosUnegocio::getUnegocio($unidadnegocio, "ca_unegocios");
        if (sizeof($rs_neg) > 0) {
            $row_neg = $rs_neg[0];
            $nomunegocio = $row_neg ["une_descripcion"];
            //  $html->asignar('ptoventa', 'Punto Venta: <span class="NuevoEtiqueta"> ' . $row_neg ["une_descripcion"] . "</span>");
            $this->nombreunegocio = $nomunegocio;
            $estadisticas->setFranquicia($nomunegocio);
            $_SESSION["finfoarea"] = $nomunegocio;
        }



//construir el indice de busqueda por cuenta
//consulta para incluir graficar todas las secciones y no solo las estandar

        $rs = DatosSeccion::vistaNombreSeccionModel($numseccion, $this->vserviciou, "cue_secciones");

        foreach ($rs as $row) {

            if ($vidiomau == 1) {
                $nomseccion = $row ["sec_descripcionesp"];
            } else {
                $nomseccion = $row ["sec_descripcioning"];
            }
            $tiposec = $row ["sec_tiposeccion"];
        }
        $nomseccion = $tit_secciones[$_GET["tit"] - 2];
        // $html->asignar('nomseccion', $nomseccion);
        $estadisticas->setIndicador($nomseccion);
// excepcion para cambiar el tipo de seccion de la seccion 2
//en lo que investigo como saber si tiene reactivo
        if ($numseccion == 2)
            $tiposec = 'E';


        $numop = $subseccion;

        //  include ('MENindgeneraestadistica.php');



        $ult = sizeof($historico) - 2;
//veo grupo para saber a donde regresa
        if ($_SESSION["grupous"] == "cli" || $_SESSION["grupous"] == "cue") {
            $strRegresar = "MENprincipal.php?op=indi&admin=cons&mes=&sec=" . $_GET["tit"] . "&ref=" . $subseccion;
        } else
            $strRegresar = 'MENprincipal.php?op=Bhistorico2&Opcion=consulta&tcons=res';
        $strRegresar = "javascript: history.back();";

        borrarRutaActual("c");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        agregarRuta("c", $rutaact, T_("ESTADISTICAS"));
    }
    */
    public function vistaCumplimientoEstabl($cump, $subseccion1, $tiposec) {
        $this->vserviciou = $_SESSION["servicioind"];
        $this->vclienteu = $_SESSION["clienteind"];
//guardofiltro
        $_SESSION["frefer"] = $subseccion1;


        $usuario_act = $_SESSION["UsuarioInd"];
//obtengo numero de seccion
        $aux_sec = explode(".", $subseccion1);
        $numseccion = $aux_sec[0];
//incluyo encabezado

        $vidiomau = $_SESSION["idiomaus"];
        $tit_secciones = array(T_('CALIDAD DE LA BEBIDA'), T_('CALIDAD DEL AGUA'), T_('PRESIONES DE OPERACION'), T_('BUENOS HABITOS DE MANUFACTURA'));
        $mes = $_SESSION["fmes"];

//-----------------------------------
//  inicializo etiquetas por idioma
//  -----------------------------------


        $cuenta = $_SESSION["fcuenta"];
//echo $cuenta;
        $periodo = $_SESSION["fperiodo"];
//

      
        //   $nomseccion = $tit_secciones[$_GET["tit"] - 2];
//$html->asignar ( 'nomseccion', $nomseccion );
// excepcion para cambiar el tipo de seccion de la seccion 2
//en lo que investigo como saber si tiene reactivo
        if ($numseccion == 2)
            $tiposec = 'E';




//////////////****************************************************************************////////////////
//defino el bloque
        $leyenda_estsi = T_('ESTABLECIMIENTOS QUE CUMPLEN CON EL ESTANDAR');
        $leyenda_estno = T_('ESTABLECIMIENTOS QUE NO CUMPLEN CON EL ESTANDAR');
        switch ($tiposec) {
            case 'E':
                if ($subseccion1 == '8.0.1.0.0.9') {// query para proporcion agua jarabe
                    $query_si = $this->cumplimientoProporcion( "si");
                    $query_no = $this->cumplimientoProporcion( "no");
                    $this->notaEstabl = "(" . T_("Se muestra el porcentaje de pruebas") . ")";
                    $parametros = array("usuario_act" => $usuario_act, "subseccion1" => $subseccion1);
                    $leyenda_estsi = T_('ESTABLECIMIENTOS CON MAS DEL 80% DE PRUEBAS DENTRO DEL ESTANDAR');
                    $leyenda_estno = T_('ESTABLECIMIENTOS CON MENOS DEL 80% DE PRUEBAS DENTRO DEL ESTANDAR');
                } else {
                    $query_si = "SELECT
cue_reactivosestandardetalle.red_parametroesp AS descesp,
cue_reactivosestandardetalle.red_parametroing AS descing,
ca_unegocios.une_descripcion,
ins_generales.i_numreporte rep,ca_unegocios.cue_clavecuenta,i_unenumpunto,
ins_detalleestandar.ide_valorreal AS valor,
ins_detalleestandar.ide_valorreal*1000.0/1000.0 AS valor2,
cue_reactivosestandardetalle.red_tipodato,
cue_reactivosestandardetalle.red_clavecatalogo,
ca_unegocios.une_dir_municipio as ciudad,
`cf_descripcion` AS franquicia, red_estandar as estandar,red_tipodato,red_clavecatalogo, red_valormin 
FROM
ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 
AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join ins_generales ON ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte and ins_detalleestandar.ide_claveservicio=ins_generales.i_claveservicio
Inner Join tmp_estadistica ON ins_generales.i_numreporte = tmp_estadistica.numreporte
Inner Join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id

INNER JOIN `ca_franquiciascuenta` ON `ca_franquiciascuenta`.`fc_idfranquiciacta`=`ca_unegocios`.`fc_idfranquiciacta`

            where cue_reactivosestandardetalle.red_grafica=-1 and  concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) = :subseccion1
            and ins_generales.i_claveservicio=:vserviciou  AND ide_valorreal<>''
and tmp_estadistica.usuario=:usuario_act
  and ide_aceptado=-1 ";


                    $query_no = "SELECT
cue_reactivosestandardetalle.red_parametroesp AS descesp,
cue_reactivosestandardetalle.red_parametroing AS descing,
ca_unegocios.une_descripcion,
ins_generales.i_numreporte rep,ca_unegocios.cue_clavecuenta,i_unenumpunto,
ins_detalleestandar.ide_valorreal AS valor,
        ins_detalleestandar.ide_valorreal*1000.0/1000.0 AS valor2,
cue_reactivosestandardetalle.red_tipodato,
cue_reactivosestandardetalle.red_clavecatalogo,
ca_unegocios.une_dir_municipio as ciudad,
`cf_descripcion` AS franquicia, red_estandar as estandar,red_tipodato,red_clavecatalogo, red_valormin
FROM
ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 
AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join ins_generales ON ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte and ins_detalleestandar.ide_claveservicio=ins_generales.i_claveservicio
Inner Join tmp_estadistica ON ins_generales.i_numreporte = tmp_estadistica.numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id

 INNER JOIN `ca_franquiciascuenta` ON `ca_franquiciascuenta`.`fc_idfranquiciacta`=`ca_unegocios`.`fc_idfranquiciacta`

            where cue_reactivosestandardetalle.red_grafica=-1 and  
            ins_generales.i_claveservicio=:vserviciou  AND ide_valorreal<>'' and
            concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) = :subseccion1 
and tmp_estadistica.usuario=:usuario_act
  and ide_aceptado=0";
//            echo $query_no;
                    //verifico el tipo de evalucion para saber si ser� un renglon o varios
                    $sqlte = "select re_tipoevaluacion from cue_reactivosestandar 
                where concat(sec_numseccion,'.',r_numreactivo,'.',re_numcomponente) =:subseccion1 and ser_claveservicio=:vserviciou;";
                    $parametros = array("subseccion1" => substr($subseccion1, 0, 5), "vserviciou" => $this->vserviciou);
                    $result = Conexion::ejecutarQuery($sqlte, $parametros);

                    foreach ($result as $rowg) {
                        $tipoeva = $rowg['re_tipoevaluacion'];
                    }
                    if ($tipoeva != 2) { //no agrupo
                        $query_si .= " and  ide_numrenglon=1
group by  ins_generales.i_numreporte";

                        $query_no .= "      and  ide_numrenglon=1
group by  ins_generales.i_numreporte";
                    }
                }
                //echo $query_no;
                break;

            case 'P':$query_si = "SELECT
(id_aceptado) AS totaceptado,

cue_reactivos.r_descripcionesp as descesp,
cue_reactivos.r_descripcioning as descing,
ins_detalle.id_numreporte rep, ca_unegocios.cue_clavecuenta,
ins_generales.i_unenumpunto,
ca_unegocios.une_id,
ca_unegocios.une_descripcion, '" . T_("SI") . "' as valor,
ca_unegocios.une_dir_municipio as ciudad,
`cf_descripcion` AS franquicia
FROM
ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
Inner Join tmp_estadistica ON ins_detalle.id_numreporte = tmp_estadistica.numreporte
Inner Join ins_generales ON ins_detalle.id_numreporte = ins_generales.i_numreporte AND ins_detalle.id_claveservicio = ins_generales.i_claveservicio
Inner Join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id 

INNER JOIN `ca_franquiciascuenta` ON `ca_franquiciascuenta`.`fc_idfranquiciacta`=`ca_unegocios`.`fc_idfranquiciacta`

where 
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo)=:subseccion1
    and ins_detalle.id_claveservicio=:vserviciou
and id_noaplica>-1 and tmp_estadistica.usuario=:usuario_act 
and id_aceptado=-1";
                $query_no = "SELECT
(id_aceptado) AS totaceptado,

cue_reactivos.r_descripcionesp as descesp,
cue_reactivos.r_descripcioning as descing,
ins_detalle.id_numreporte rep, ca_unegocios.cue_clavecuenta,
ins_generales.i_unenumpunto,
ca_unegocios.une_id,
ca_unegocios.une_descripcion, 'NO' as valor,
ca_unegocios.une_dir_municipio as ciudad,
`cf_descripcion` AS franquicia
FROM
ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
Inner Join tmp_estadistica ON ins_detalle.id_numreporte = tmp_estadistica.numreporte
Inner Join ins_generales ON ins_detalle.id_numreporte = ins_generales.i_numreporte AND ins_detalle.id_claveservicio = ins_generales.i_claveservicio
Inner Join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id  

INNER JOIN `ca_franquiciascuenta` ON `ca_franquiciascuenta`.`fc_idfranquiciacta`=`ca_unegocios`.`fc_idfranquiciacta`

where 
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo)=:subseccion1 
    and ins_detalle.id_claveservicio=:vserviciou
and id_noaplica>-1 and tmp_estadistica.usuario=:usuario_act 
and id_aceptado=0";
                break;
            case 'V':

                $query_si = "SELECT
sum(ins_detalleproducto.ip_numcajas) AS totaceptado,
ins_detalleproducto.ip_condicion,
ins_detalleproducto.ip_numreporte rep, ca_unegocios.cue_clavecuenta, i_unenumpunto,
ca_unegocios.une_descripcion,round((((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))),2) as valor,
ca_unegocios.une_dir_municipio as ciudad,
`cf_descripcion` AS franquicia,'< 10 " . T_("SEMANAS") . "' as estandar
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join ins_generales ON ins_detalleproducto.ip_claveservicio = ins_generales.i_claveservicio AND ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id

INNER JOIN `ca_franquiciascuenta` ON `ca_franquiciascuenta`.`fc_idfranquiciacta`=`ca_unegocios`.`fc_idfranquiciacta`
WHERE
	 ins_detalleproducto.ip_numseccion = :subseccion1 
             and ins_generales.i_claveservicio=:vserviciou
AND ins_detalleproducto.ip_sinetiqueta<>-1  and tmp_estadistica.usuario=:usuario_act
 group by ip_numreporte having valor>=80";
                $query_no = "SELECT
sum(ins_detalleproducto.ip_numcajas) AS totaceptado,
ins_detalleproducto.ip_condicion,
ins_detalleproducto.ip_numreporte rep, ca_unegocios.cue_clavecuenta, i_unenumpunto,
ca_unegocios.une_descripcion,round((((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))),2) as valor,
ca_unegocios.une_dir_municipio as ciudad,
`cf_descripcion` AS franquicia, '< 10 " . T_("SEMANAS") . "' as estandar
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join ins_generales ON ins_detalleproducto.ip_claveservicio = ins_generales.i_claveservicio AND ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id

INNER JOIN `ca_franquiciascuenta` ON `ca_franquiciascuenta`.`fc_idfranquiciacta`=`ca_unegocios`.`fc_idfranquiciacta`
WHERE
	 ins_detalleproducto.ip_numseccion = :subseccion1 
             and ins_generales.i_claveservicio=:vserviciou
AND (ins_detalleproducto.ip_sinetiqueta<>-1 or ins_detalleproducto.ip_sinetiqueta is null) and tmp_estadistica.usuario=:usuario_act
 group by ip_numreporte having valor<80";
//echo $query_no;

                $leyenda_estsi = T_('ESTABLECIMIENTOS CON MAS DEL 80% DE PRUEBAS DENTRO DEL ESTANDAR');
                $leyenda_estno = T_('ESTABLECIMIENTOS CON MENOS DEL 80% DE PRUEBAS DENTRO DEL ESTANDAR');
                break;
        }
        $ord = filter_input(INPUT_GET, "ord", FILTER_SANITIZE_STRING);
        if (isset($ord)) {
            //   echo $_GET["ord"];
            $aux = explode('.', $ord);
            $orden = $aux[0];
            $forma = $aux[1];
        }
        $parametros2 = array("subseccion1" => $subseccion1, "vserviciou" => $this->vserviciou, "usuario_act" => $usuario_act);

//echo $query_si;
        if ($cump == "si") { //devuelve los que cumplen
        
            $query_si = $this->ordenar($query_si, $orden, $forma, $tiposec);
          
            $result = Conexion::ejecutarQuery($query_si, $parametros2);
           

            $lb_ESTABLECIMIENTOS_QUEC = $leyenda_estsi;
        } else {        //devuelve los que no cumplen
            $query_no = $this->ordenar($query_no, $orden, $forma, $tiposec);
            $result = Conexion::ejecutarQuery($query_no, $parametros2);

            $lb_ESTABLECIMIENTOS_QUEC = $leyenda_estno;
//  echo $query_no;
        }

        $contl = 1;
        $subsubseccion = substr($subseccion1, 0, strrpos($subseccion1, "."));
        //   echo $subsubseccion;
        $this->listaEstablecimientos = array();
        $k = 0;
        foreach ($result as $rowu) {


            if ($rowu["red_tipodato"] == "C") {
                $sql_cat = "SELECT
                        ca_catalogosdetalle.cad_descripcionesp,
                        ca_catalogosdetalle.cad_descripcioning
                        FROM
                        ca_catalogosdetalle
                        WHERE
                        ca_catalogosdetalle.cad_idcatalogo =  '" . $rowu["red_clavecatalogo"] . "' AND
                        ca_catalogosdetalle.cad_idopcion =  '" . $rowu ["red_valormin"] . "'";

                $result_cat = Conexion::ejecutarQuerysp($sql_cat);
                foreach ($result_cat as $row_cat) {
                    if ($_SESSION["idiomaus"] == 2)
                        $estandar = $row_cat["cad_descripcioning"];
                    else
                        $estandar = $row_cat["cad_descripcionesp"];
                }

                $this->titulo2 = $lb_ESTABLECIMIENTOS_QUEC . ": <span style=\"color:#FF6600\" >" . $estandar . "</span>";
            } else
                $this->titulo2 = $lb_ESTABLECIMIENTOS_QUEC . ":  <span style=\"color:#FF6600\" >" . $rowu["estandar"] . "</span>";
            if ($vidiomau == 2) {
                //  $html->asignar ( 'nomcomp', $rowu ["descesp"] );
                $nomcomp = $rowu ["descing"];
            } else {
                //$html->asignar ( 'nomcomp', $rowu ["descing"] );
                $nomcomp = $rowu ["descesp"];
            } // fin de idioma
            $establecimiento = new EstablecimientoCumple;
            if ($contl % 2 == 0) {
                $establecimiento->setEstilo("subtitulo3");
            } else {  //class="subtitulo31"
                $establecimiento->setEstilo("subtitulo31");
            }
            // echo $contl. $rowu["une_descripcion"]."<br>";
            $unegocio = new Unegocio;

            $unegocio->setCiudad($rowu["ciudad"]);
            $unegocio->setFranquicia($rowu["franquicia"]);
            $unegocio->setPuntoVenta($rowu["une_descripcion"]);
            //busco en catalogo para las estandar
            if ($tiposec == "E" && $rowu["red_tipodato"] == 'C')
                $valreal = DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$rowu["valor"], $rowu["red_clavecatalogo"]);
            else
            if ($rowu["valor"] != "") {
                
                if ($tiposec == "E")
                {   
                    If (($subseccion1=="5.0.2.0.0.17") ||  ($subseccion1=="5.0.2.0.0.18")) {
                        
                        //echo "entre a valor 17 o 18";
                        
                        //echo round($rowdet["ide_valorreal"], 3);
                        
                        if ((round($rowu["valor"], 3))>=100){
                            
                            //echo "es mayor de 100";
                            
                            $valreal="Incontables";
                            
                        } else {
                            
                            $valreal = round($rowu["valor"], 3);
                            
                        }
                        
                    }else
                    
                    $valreal = round($rowu["valor"], 2);
                
                
                
                }
                else
                    
                    $valreal = $rowu["valor"];
                
            } else
                $valreal = "-";

            $establecimiento->setPuntoVenta($unegocio);
            $establecimiento->setResultado($valreal);
            //http://localhost/muesmerc/MEmodulos/MENindprincipal.php?op=Cconsec&tiposec=P&Op=100.1.409.1.3.37 y V


            if ($tiposec == "E") {
                $refer = $this->vclienteu . "." . $this->vserviciou . "." . $rowu["rep"] . "." . $rowu["cue_clavecuenta"] . "." . $numseccion . "." . $rowu["i_unenumpunto"];
                $liga_sec = "index.php?action=indlistasecciones&tiposec=ED&subsecc=" . $subsubseccion . "&ruta=b&cump=" . $cump . "&num=" . $refer;
            }
            //http://localhost/muesmerc/MEmodulos/MENindprincipal.php?op=Cconsec&tiposec=E&opadmin=detalle_consulta&subsecc=8.0.2.0.0.6&num=100.1.449.1.8.
            else {
                $refer = $this->vclienteu . "." . $this->vserviciou . "." . $rowu["rep"] . "." . $rowu["cue_clavecuenta"] . "." . $numseccion . "." . $rowu["i_unenumpunto"];
                $liga_sec = "index.php?action=indlistasecciones&tiposec=" . $tiposec . "&ruta=b&cump=" . $cump . "&Op=" . $refer;
            }
            $establecimiento->setLiga($liga_sec);

            $this->listaEstablecimientos[$k++] = $establecimiento;

            $contl++;
        }
      $this->filtrosSel=new ConsultaIndicadores();
        if ($tiposec == 'V')

        //  $html->asignar ( 'nomcomp', nombreSeccion($subseccion1, $vidiomau) );
        	$nomcomp = DatosSeccion::nombreSeccionIdioma($subseccion1, $this->vserviciou,$vidiomau);
       
        $this->filtrosSel->setNombre_seccion($nomcomp);
      
        $this->filtrosSel->setPeriodo($periodo);
        $this->filtrosSel->setNombre_nivel($_SESSION["finfoarea"]);
//busco nombre de la seccion
         Navegacion::borrarRutaActual("cumpl");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("cumpl", $rutaact, $lb_ESTABLECIMIENTOS_QUEC);
    }

//agregamos ordenacion

    function ordenar($sql, $orden, $forma, $tiposec) {
        if ($tiposec == "E") {
            switch ($orden) {
                case 'valor': $sql .= " order by valor2 ";
                    break;
                default: $sql .= " order by valor2 desc";
            }
        } else
        if ($tiposec == "V") {
            switch ($orden) {
                case 'valor': $sql .= " order by valor ";
                    break;
                default: $sql .= " order by valor desc";
            }
        } else
            $forma = "";

        return $sql . " " . $forma;
    }

    function cumplimientoProporcion($opcion) {
    	
        if ($opcion == "si")
            $query = "SELECT
cue_reactivosestandardetalle.red_parametroesp AS descesp,
cue_reactivosestandardetalle.red_parametroing AS descing,
ca_unegocios.une_descripcion,
ins_generales.i_numreporte rep,ca_unegocios.cue_clavecuenta,i_unenumpunto,

cue_reactivosestandardetalle.red_tipodato,
cue_reactivosestandardetalle.red_clavecatalogo,
ca_unegocios.une_dir_municipio as ciudad,
ca_nivel3.n3_nombre as franquicia, red_estandar as estandar,
sum(if(ide_aceptado<0,100,0))/sum(1) as valor, sum(if(ide_aceptado<0,100,0))/sum(1) as valor2
FROM
ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join ins_generales ON ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte and ins_detalleestandar.ide_claveservicio=ins_generales.i_claveservicio
Inner Join tmp_estadistica ON ins_generales.i_numreporte = tmp_estadistica.numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
Inner Join ca_nivel3 on ca_unegocios.une_cla_zona = ca_nivel3.n3_id
where cue_reactivosestandardetalle.red_grafica=-1 and
        ins_generales.i_claveservicio=:vserviciou  AND ide_valorreal<>'' and
        concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) = :subseccion1
and tmp_estadistica.usuario=:usuario_act
group by  i_numreporte having valor>=80";
        else
            $query = "SELECT
cue_reactivosestandardetalle.red_parametroesp AS descesp,
cue_reactivosestandardetalle.red_parametroing AS descing,
ca_unegocios.une_descripcion,
ins_generales.i_numreporte rep,
ca_unegocios.cue_clavecuenta,i_unenumpunto,
cue_reactivosestandardetalle.red_tipodato,
cue_reactivosestandardetalle.red_clavecatalogo,
ca_unegocios.une_dir_municipio as ciudad,
ca_nivel3.n3_nombre as franquicia, red_estandar as estandar,
sum(if(ide_aceptado<0,100,0))/sum(1) as valor, sum(if(ide_aceptado<0,100,0))/sum(1) as valor2
FROM
ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join ins_generales ON ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte and ins_detalleestandar.ide_claveservicio=ins_generales.i_claveservicio
Inner Join tmp_estadistica ON ins_generales.i_numreporte = tmp_estadistica.numreporte
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
Inner Join ca_nivel3 ON ca_unegocios.une_cla_zona = ca_nivel3.n3_id
where cue_reactivosestandardetalle.red_grafica=-1 and  concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) = :subseccion1
and tmp_estadistica.usuario=:usuario_act  and ins_generales.i_claveservicio=:vserviciou  AND ide_valorreal<>''

group by  i_numreporte having valor<80";
//echo $query;
        return $query;
    }

    function buscaNivel($nivel, $idnivel) {

        $region = 1;
        switch ($nivel) {
            case 2: $respuesta = Datosndos::vistaN2opcionModel($idnivel, "ca_nivel2");

                break;
            case 3: $respuesta = Datosntres::vistaN3opcionModel($idnivel, "ca_nivel3");
                break;
            case 4:


                $respuesta = Datosncua::vistaN4opcionModel($idnivel, "ca_nivel4");
                break;
            case 5:
                $respuesta = Datosncin::vistancinOpcionModel($idnivel, "ca_nivel5");
                break;
            case 6:

                $respuesta = Datosnsei::vistanseiOpcionModel($idnivel, "ca_nivel6");
                break;

            default:$respuesta = Datosnuno::vistaN1opcionModel($idnivel, "ca_nivel1");
                break;
        }
        $onivel = $respuesta["n" . $nivel . "_nombre"];


        return $onivel;
    }

    function buscaCuenta($idclavecuenta) {

        $rscuenta = DatosCuenta::editarCuentaModel($idclavecuenta, "ca_cuentas");

        $cuenta = $rscuenta["cue_descripcion"];

        return $cuenta;
    }

    function buscaEstandarCatalogo($clavecatalogo, $red_valormin) {
        // si el estandar es de catalogo lo busco en el catalogo

        $sql_cat = "SELECT
 ca_catalogosdetalle.cad_descripcionesp,
ca_catalogosdetalle.cad_descripcioning
FROM
ca_catalogosdetalle
WHERE
ca_catalogosdetalle.cad_idcatalogo =  :clavecatalogo  AND
ca_catalogosdetalle.cad_idopcion =  :red_valormin";
//echo "<br>".$sql_cat;
        $parametros = array("clavecatalogo" => $clavecatalogo, "red_valormin" => $red_valormin);
        $result_cat = Conexion::ejecutarQuery($sql_cat, $parametros);
        foreach ($result_cat as $row_cat) {
            if ($_SESSION["idiomaus"] == 2)
                $res = $row_cat["cad_descripcioning"];
            else
                $res = $row_cat["cad_descripcionesp"];
        }

        return $res;
    }

// llega la referencia de la seccion
    function tamanioMuestraOrig($mes_consulta, $filx, $gfily, $usuario, $referencia, $tiposec) {
        $aux_sec = explode(".", $referencia);






        $auxy = explode(".", $gfily);
        $fily = array();
        $fily["cta"] = $auxy[0];
        $fily["fra"] = $auxy[1];

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

        $grupo = $_SESSION["grupous"];
        $vidiomau = $_SESSION["idiomaus"];
      
   
        					
        if ($tiposec == "E") {
            $sql = "SELECT
  round(sum(IF(ide_numseccion IS NOT NULL,1,0) )*100/COUNT(DISTINCT `une_id`),2) as tam_muestra

FROM
ca_unegocios
Left Join (ins_generales 
 inner join tmp_estadistica on tmp_estadistica.numreporte=ins_generales.i_numreporte
 and tmp_estadistica.usuario=:usuario
)ON  ca_unegocios.une_id = ins_generales.i_unenumpunto 
LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=:aux_sec0 
 AND `ide_numreactivo`=:aux_sec1
  AND `ide_numcomponente`=:aux_sec2
  AND `ide_numcaracteristica1`=:aux_sec3 
  AND `ide_numcaracteristica2`=:aux_sec4
  AND `ide_numcaracteristica3`=:aux_sec5
  AND `ide_numrenglon`=1
where 

ins_generales.i_claveservicio = :servicio  and une_estatus=1";
            $parametros = array("servicio" => $this->vserviciou, "usuario" => $usuario, "aux_sec0" => $aux_sec[0], "aux_sec1" => $aux_sec[1], "aux_sec2" => $aux_sec[2], "aux_sec3" => $aux_sec[3], "aux_sec4" => $aux_sec[4], "aux_sec5" => $aux_sec[5]);
        } else
        if ($tiposec == "P") {
            $sql = "SELECT
round(SUM(IF(ins_detalle.id_aceptado=-1,1,0))*100/COUNT(DISTINCT `une_id`),2) AS tam_muestra
FROM
ca_unegocios
LEFT JOIN (ins_generales 
 INNER JOIN tmp_estadistica ON tmp_estadistica.numreporte=ins_generales.i_numreporte
 AND tmp_estadistica.usuario=:usuario
)ON  ca_unegocios.une_id = ins_generales.i_unenumpunto 
LEFT JOIN ins_detalle ON ins_detalle.id_claveservicio = ins_generales.i_claveservicio 
AND `id_numreporte`=i_numreporte
AND `id_numseccion`=:aux_sec0 AND `id_numreactivo`=:aux_sec1
where 

ins_generales.i_claveservicio =  :servicio  and une_estatus=1";
            $parametros = array("servicio" => $this->vserviciou, "usuario" => $usuario, "aux_sec0" => $aux_sec[0], "aux_sec1" => $aux_sec[1]);
        } else {
            $sql = "SELECT
round(SUM(IF(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0))*100/COUNT(DISTINCT `une_id`),2) AS tam_muestra


FROM
ca_unegocios
LEFT JOIN (ins_generales 
 INNER JOIN tmp_estadistica ON tmp_estadistica.numreporte=ins_generales.i_numreporte
 AND tmp_estadistica.usuario=:usuario
)ON  ca_unegocios.une_id = ins_generales.i_unenumpunto 
LEFT JOIN ins_detalleproducto
ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte AND ins_detalleproducto.ip_claveservicio = `i_claveservicio`
AND  ins_detalleproducto.ip_numseccion = :referencia  
AND ins_detalleproducto.ip_sinetiqueta<>-1 and une_estatus=1";

            $parametros = array("usuario" => $usuario, "referencia" => $referencia);
        }
	$sql.=" and
ca_unegocios.une_cla_region=1 and
ca_unegocios.une_cla_pais=1 and
ca_unegocios.une_cla_zona=5  ";
        if (isset($fily["cta"]) && $fily["cta"] != "")
            $sql .= " and ca_unegocios.cue_clavecuenta=" . $fily["cta"];
        if (isset($filx["reg"]) && $filx["reg"] != "")
            $sql .= " and ca_unegocios.une_cla_estado=" . $filx["reg"];
        if (isset($filx["ciu"]) && $filx["ciu"] != "")
            $sql .= " and ca_unegocios.une_cla_ciudad=" . $filx["ciu"];
        if (isset($filx["niv6"]) && $filx["niv6"] != "")
            $sql .= " and ca_unegocios.une_cla_franquicia=" . $filx["niv6"];
        if (isset($fily["fra"]) && $fily["fra"] != "")
            $sql .= " and ca_unegocios.fc_idfranquiciacta=" . $fily["fra"];

   
      
        $result_cat = Conexion::ejecutarQuery($sql, $parametros);
        
        foreach ($result_cat as $row) {



            $total = $row["tam_muestra"];
        }

        return $total;
    }

    
    function validaRegionCuenta() {
        $result = 0;
        $usuario = $_SESSION["UsuarioInd"];

        $grupo = $_SESSION["grupous"];
        // verifico el tipo de usuario
        if ($grupo == "cli" || $grupo == "cue") {
            $query = "SELECT
cnfg_usuarios.cus_usuario,
cnfg_usuarios.cus_clavegrupo,
cnfg_usuarios.cus_tipoconsulta,
cnfg_usuarios.cus_nivel1,
cnfg_usuarios.cus_nivel2,
cnfg_usuarios.cus_nivel3,
cnfg_usuarios.cus_nivel4,
cnfg_usuarios.cus_cliente,
cnfg_usuarios.cus_servicio,
cnfg_usuarios.cus_nombreusuario
FROM
cnfg_usuarios
where cus_usuario='$usuario' and cnfg_usuarios.cus_cliente=100 and
cnfg_usuarios.cus_servicio=1";

            $res = mysql_query($query);
            while ($row = mysql_fetch_array($res)) {
                $nivCons = $row["cus_tipoconsulta"];
                $niv4 = $row["cus_nivel4"];
                $niv5 = $row["cus_nivel5"];
                $niv6 = $row["cus_nivel6"];
                $niv1 = $row["cus_nivel1"];
                $niv2 = $row["cus_nivel2"];
                $niv3 = $row["cus_nivel3"];
            }
            $result = $nivCons . "¬" . $niv1 . "¬" . $niv2 . "¬" . $niv3 . "¬" . $niv4 . "¬" . $niv5 . "¬" . $niv6;
        }
        return $result;
    }
    function tamanioMuestra($mes_consulta,$filx,$fily, $usuario, $referencia,$tiposec) {
    
    	$aux_sec = explode(".", $referencia);
    	$seccion = $aux_sec[0];
    	$gfilx = $filx;
    	$gfily = $fily;
    	$gnivel = $niv;
    	$reng = $ren;
    	
    	$aux = explode(".", $gfilx);
    	
    	$filx = array();
    	$filx["reg"] = $aux[0];
    	
    	$filx["ciu"] = $aux[1];
    	$filx["niv6"] = $aux[2];
    
    	$auxy = explode(".", $gfily);
    	
    	$fily = array();
    	$fily["cta"] = $auxy[0];
    	$fily["fra"] = $auxy[1];
    	$aux=explode('.', $mes_consulta);
    	$mes=$aux[0];
    	if($mes-6>=0) { // calculo para los 6m
    		$z=$mes-6+1;
    		
    		$mes_pivote=$aux[1]."-".$z."-01";
    	}
    	else {
    		$z=7+$mes;
    		
    		$mes_pivote=($aux[1]-1)."-".$z."-01";
    	}
    	$fmes_consulta=$aux[1]."-".$aux[0]."-01";
    	$mes_consulta_ant=($aux[1]-1)."-".$aux[0]."-01";
    	    	
    	
    	$grupo=$_SESSION["GrupoUs"];
    	$vidiomau=$_SESSION["idiomaus"];
    	//saco total de pvs
    
    	$sql1="SELECT
COUNT(une_id) AS tot
    			
FROM
ca_unegocios
    			
WHERE

ca_unegocios.une_cla_region=1 AND
ca_unegocios.une_cla_pais=1 AND
ca_unegocios.une_cla_zona=5 AND une_estatus=1";
    	
    	if (isset($fily["cta"]) && $fily["cta"] != "") {
    		$sql1 .= " and ca_unegocios.cue_clavecuenta=:cta";
    		$parametros1["cta"] = $fily["cta"];
    	}
    	if (isset($filx["reg"]) && $filx["reg"] != "") {
    		$sql1.= " and ca_unegocios.une_cla_estado=:reg";
    		$parametros1["reg"] = $filx["reg"];
    	}
    	if (isset($filx["ciu"]) && $filx["ciu"] != "") {
    		$sql1 .= " and ca_unegocios.une_cla_ciudad=:ciu";
    		$parametros1["ciu"] = $filx["ciu"];
    	}
    	if (isset($filx["niv6"]) && $filx["niv6"] != "") {
    		$sql1 .= " and ca_unegocios.une_cla_franquicia=:niv6";
    		$parametros1["niv6"] = $filx["niv6"];
    	}
    	if (isset($fily["fra"]) && $fily["fra"] != "") {
    		$sql1 .= " and ca_unegocios.fc_idfranquiciacta=:fra";
    		$parametros1["fra"] = $fily["fra"];
    	}
    	$res1=Conexion::ejecutarQuery($sql1,$parametros1);
    	$totalpv=0;
    	foreach($res1 as $row) {
    							
    							
    							
    			$totalpv= $row["tot"];
    							
    	}
    
    	if($tiposec=="E")
    	{	$sql="SELECT
 round(sum(IF(ide_numseccion IS NOT NULL,1,0) )*100/$totalpv,2) as tam_muestra
 
FROM
ins_generales
 inner join tmp_estadistica on tmp_estadistica.numreporte=ins_generales.i_numreporte
 and tmp_estadistica.usuario=:usuario

LEFT JOIN `ins_detalleestandar` ON  `i_claveservicio`=`ide_claveservicio` 
AND `ide_numreporte`=`i_numreporte`
AND `ide_numseccion`=:aux_sec0
 AND `ide_numreactivo`=:aux_sec1
  AND `ide_numcomponente`=:aux_sec2
  AND `ide_numcaracteristica1`=:aux_sec3
  AND `ide_numcaracteristica2`=:aux_sec4
  AND `ide_numcaracteristica3`=:aux_sec5
  AND `ide_numrenglon`=1
where

i_claveservicio = :servicio ";
    	$parametros=array("aux_sec0"=>$aux_sec[0],
    			"aux_sec1"=>$aux_sec[1],
    			"aux_sec2"=>$aux_sec[2],
    			"aux_sec3"=>$aux_sec[3],
    			"aux_sec4"=>$aux_sec[4],
    			"aux_sec5"=>$aux_sec[5],
    	);
    	}else
    		if($tiposec=="P")
    		{	$sql="SELECT
round(SUM(IF(ins_detalle.id_aceptado=-1,1,0))*100/$totlapv,2) AS tam_muestra
FROM
ins_generales
 INNER JOIN tmp_estadistica ON tmp_estadistica.numreporte=ins_generales.i_numreporte
 AND tmp_estadistica.usuario=:usuario

LEFT JOIN ins_detalle ON ins_detalle.id_claveservicio = i_claveservicio
AND `id_numreporte`=i_numreporte
AND `id_numseccion`=:aux_sec0
 AND `id_numreactivo`=:aux_sec1
where

i_claveservicio =  :servicio ";
    		$parametros=array("aux_sec0"=>$aux_sec0,
    				"aux_sec1"=>$aux_sec1,
    				"aux_sec2"=>$aux_sec2,
    				"aux_sec3"=>$aux_sec3,
    				"aux_sec4"=>$aux_sec4,
    				"aux_sec5"=>$aux_sec5,
    		);
    	}
    		else
    		{$sql="SELECT
round(SUM(IF(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0))*100/$totalpv,2) AS tam_muestra

FROM
ins_generales
 INNER JOIN tmp_estadistica ON tmp_estadistica.numreporte=ins_generales.i_numreporte
 AND tmp_estadistica.usuario=:usuario

LEFT JOIN ins_detalleproducto
ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
 AND ins_detalleproducto.ip_claveservicio = `i_claveservicio`
AND  ins_detalleproducto.ip_numseccion = :referencia
AND (ins_detalleproducto.ip_sinetiqueta<>-1 or ins_detalleproducto.ip_sinetiqueta is null) 
and ip_claveservicio=:servicio";
    		$parametros=array("referencia"=>$referencia);
    		
    		}
    		$parametros["usuario"]=$usuario;
    		$parametros["servicio"]= $this->vserviciou;
//     			if (isset($fily["cta"]) && $fily["cta"] != "") {
//     				$sql .= " and ca_unegocios.cue_clavecuenta=:cta";
//     				$parametros["cta"] = $fily["cta"];
//     			}
//        if (isset($filx["reg"]) && $filx["reg"] != "") {
//         	$sql .= " and ca_unegocios.une_cla_estado=:reg";
//         	$parametros["reg"] = $filx["reg"];
//         }
//         if (isset($filx["ciu"]) && $filx["ciu"] != "") {
//         	$sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
//         	$parametros["ciu"] = $filx["ciu"];
//         }
//         if (isset($filx["niv6"]) && $filx["niv6"] != "") {
//         	$sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
//         	$parametros["niv6"] = $filx["niv6"];
//         }
//         if (isset($fily["fra"]) && $fily["fra"] != "") {
//         	$sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
//         	$parametros["fra"] = $fily["fra"];
//         }
        
     //   echo "<br>o el tamanio"; echo $sql; 
$res=Conexion::ejecutarQuery($sql,$parametros);

foreach($res as $row) {
	
	
	
	$total= $row["tam_muestra"];
	
}

return $total;
    															
    }

    public function generarEstadisticas($tiposec, $numop, $mes_asig, $filx, $fily,$ptv) {
        set_time_limit(360);
        $usuario_act = $_SESSION["UsuarioInd"];

        $ancho = 600;
        $alto = 300;
       
//llena la tabla de resultados
        switch ($tiposec) {
            case 'E' :
                $sqlt = "select 
sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as total,
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ins_detalleestandar.ide_aceptado<0,1,0),0),if(ins_detalleestandar.ide_aceptado<0,1,0))) as cumple2,
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ins_detalleestandar.ide_aceptado=0,1,0),0),if(ins_detalleestandar.ide_aceptado=0,1,0))) as nocumple2,
 red_estandar estandar, max(red_valormin) as estandar2,sum(If(re_tipoevaluacion=1,
If(ide_numrenglon=1,ide_valorreal,0),ide_valorreal )) /sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1))  as promedio, std(If(re_tipoevaluacion=1,
If(ide_numrenglon=1,ide_valorreal,0),ide_valorreal )) as desviacion, 
 red_tipografica as tipografica, cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_parametroesp as descesp, cue_reactivosestandardetalle.red_parametroing as descing ,
 red_clavecatalogo, red_valormin, red_tipodato
from ins_detalleestandar 
inner join cue_reactivosestandardetalle 
on  ins_detalleestandar.ide_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and  ins_detalleestandar.ide_numseccion=cue_reactivosestandardetalle.sec_numseccion  and ins_detalleestandar.ide_numreactivo=cue_reactivosestandardetalle.r_numreactivo  
and ins_detalleestandar.ide_numcomponente=cue_reactivosestandardetalle.re_numcomponente  and ins_detalleestandar.ide_numcaracteristica1=cue_reactivosestandardetalle.re_numcaracteristica
 and ins_detalleestandar.ide_numcaracteristica2=cue_reactivosestandardetalle.re_numcomponente2  and ins_detalleestandar.ide_numcaracteristica3=cue_reactivosestandardetalle.red_numcaracteristica2
  inner join cue_reactivosestandar 
 on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and  cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion and cue_reactivosestandar.r_numreactivo=cue_reactivosestandardetalle.r_numreactivo
and cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente and cue_reactivosestandar.re_numcaracteristica=cue_reactivosestandardetalle.re_numcaracteristica 
 and cue_reactivosestandar.re_numcomponente2=cue_reactivosestandardetalle.re_numcomponente2 
 inner join ins_generales on ins_detalleestandar.ide_numreporte=ins_generales.i_numreporte and ins_generales.i_claveservicio=cue_reactivosestandardetalle.ser_claveservicio
  inner join tmp_estadistica 
on ins_generales.i_numreporte=tmp_estadistica.numreporte
where cue_reactivosestandardetalle.red_grafica=-1 and cue_reactivosestandardetalle.ser_claveservicio=:vserviciou AND ide_valorreal<>''  and
concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) = :numop  
and tmp_estadistica.usuario=:usuario_act 
GROUP BY concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) ";
                //echo $sqlt;
                break;

            case 'P' :
                $sqlt = "SELECT
Sum(if(ins_detalle.id_aceptado=-1,1,0)) as cumple2 ,
Sum(if(ins_detalle.id_aceptado=0,1,0)) as nocumple2 ,
(count(ins_detalle.id_aceptado)) AS total,
cue_reactivos.r_tipografica as tipografica ,'N/A' as estandar , cue_reactivos.r_descripcionesp as descesp, r_descripcioning as descing
from
ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
Inner Join tmp_estadistica ON ins_detalle.id_numreporte = tmp_estadistica.numreporte
where 
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo)=:numop 
and id_noaplica>-1 and tmp_estadistica.usuario=:usuario_act  and r_grafica=-1
    and ins_detalle.id_claveservicio=:vserviciou
group by ins_detalle.id_numseccion,
ins_detalle.id_numreactivo;";
                break;
            case 'V' :
                $sqlt = "SELECT (SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0))) as cumple2,
(SUM(if(`ins_detalleproducto`.`ip_condicion`='C',`ins_detalleproducto`.`ip_numcajas`,0))) as nocumple2,
(SUM(`ins_detalleproducto`.`ip_numcajas`)) AS total, 'N' as tipografica, '<10 " . T_("SEMANAS") . "' as estandar , sum(ip_semana)/SUM(`ins_detalleproducto`.`ip_numcajas`) as promedio, cue_secciones.sec_descripcionesp as descesp, sec_descripcioning as descing
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE
	 ins_detalleproducto.ip_numseccion = :numop   and ins_detalleproducto.ip_claveservicio=:vserviciou
AND (ins_detalleproducto.ip_sinetiqueta<>-1 or ins_detalleproducto.ip_sinetiqueta is null)  and tmp_estadistica.usuario=:usuario_act 
GROUP BY
ins_detalleproducto.ip_numseccion

ORDER BY
tmp_estadistica.mes_asignacion ASC;	";
                //$html->asignar ( 'tit_cumplaj', "<br>Edad promedio por producto");
                //    $tit_cumplaj= "<br>Edad promedio por producto";

                $this->graf_cumplaj = "views/modulos/indgraficapromediojarabe.php?numsec=" . $numop . "&tiposec=" . $tiposec . "&cgserv=" . $this->vserviciou;

                break;
        }

        $parametros = array("vserviciou" => $this->vserviciou, "numop" => $numop, "usuario_act" => $usuario_act);
      
        $result = Conexion::ejecutarQuery($sqlt, $parametros);
  // var_dump($result); die();
      
        $this->estadisticas = new ResumenResultado;
        foreach ($result as $rowt) {
            $this->estadisticas->setTotalresultados($rowt ["total"]);
            if ($tiposec == 'E' && $rowt["red_tipodato"] == "C") {
            	$this->estadisticas->setEstandar(DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$rowt["red_clavecatalogo"], $rowt["red_valormin"]));
            } else
                $this->estadisticas->setEstandar($rowt ["estandar"]);

            // aqui va la validacion de ecoli y coliformes 17 y 18
            //red_numcaracteristica2 
            if ($tiposec == "E") {
                if ($rowt ["red_numcaracteristica2"] == 16 || $rowt ["red_numcaracteristica2"] == 17 || $rowt ["red_numcaracteristica2"] == 18) {
                    $this->estadisticas->setPromedio("&nbsp; ");
                    $this->estadisticas->setDesviacion_estandar("&nbsp; ");
                } else {
                    $this->estadisticas->setPromedio(round($rowt ["promedio"], 3));
                    //calcula la desvicion estandar para los reactivos de producto
                    $this->estadisticas->setDesviacion_estandar(round($rowt ["desviacion"], 3));
                }
            } else {
                $this->estadisticas->setPromedio(round($rowt ["promedio"], 3));
                //calcula la desvicion estandar para los reactivos de producto
                $this->estadisticas->setDesviacion_estandar(round($rowt ["desviacion"], 3));
            }  // termina validcion de E para coliformes, cuenta total y ecoli
           
       
            if ($tiposec == 'V') {
                $queryd = "SELECT sqrt(sum(pow((ip_semana-" . $rowt ["promedio"] . "),2)*`ins_detalleproducto`.`ip_numcajas`)/sum(`ip_numcajas`)) as desviacion
FROM ins_detalleproducto Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
 Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
 WHERE	 ins_detalleproducto.ip_numseccion = :numop 
AND (ins_detalleproducto.ip_sinetiqueta<>-1 or ins_detalleproducto.ip_sinetiqueta is null)  and tmp_estadistica.usuario=:usuario_act  and cue_secciones.ser_claveservicio=:vserviciou
GROUP BY
ins_detalleproducto.ip_numseccion
ORDER BY
tmp_estadistica.mes_asignacion ASC;";
                $parametros2 = array("vserviciou" => $this->vserviciou, "numop" => $numop, "usuario_act" => $usuario_act);
                $resultd = Conexion::ejecutarQuery($queryd, $parametros2);
               
                foreach ($resultd as $rowd) {
                    $this->estadisticas->setDesviacion_estandar(round($rowd ["desviacion"], 2));
                }
            }
            /**  para dispositivos moviles ** */
            if (isset($_GET["mb"]) && $_GET["mb"] == "si")
                $ligaest = "index.php?action=indcumplimientoestabl&cgserv=" . $this->vserviciou . "&refer=" . $_GET["refer"] . "&tit=" . $_GET["tit"] . "&tiposec=" . $tiposec . "&mb=si&cump=";
            else
                $ligaest = "index.php?action=indcumplimientoestabl&cgserv=" . $this->vserviciou . "&refer=" . $_GET["refer"] . "&tit=" . $_GET["tit"] . "&tiposec=" . $tiposec . "&cump=";
            $this->estadisticas->setCumplen($rowt ["cumple2"]);
            $this->ligasi = $ligaest . "si";
            $this->estadisticas->setNocumplen($rowt ["nocumple2"]);
            if ($rowt ["nocumple2"] > 0)
                $this->ligano = $ligaest . "no";
            else
                $this->ligano = "#";
            $this->estadisticas->setTipo_seccion($rowt ["tipografica"]);
            $this->mostrar='<script type="text/javascript">
            		
        	MuestraOculta("'.$rowt ["tipografica"].'");
        			
        	</script>';
            $tipografica = $rowt ["tipografica"];
            // echo $rowt["tipografica"]; 
            if($this->busqueda){
             $this->filtrosSel=$this->busqueda->getFiltrosSel();
            }
            else $this->filtrosSel=new ConsultaIndicadores;;
            if ($_SESSION["idiomaus"] == 2) {
                $this->estadisticas->setAtributo($rowt ["descing"]);
                
                $this->filtrosSel->setNombre_seccion($rowt ["descing"]);
                $nom_componente = $rowt ["descing"];
              
            } else {
               
                $this->estadisticas->setAtributo($rowt ["descesp"]);
                $this->filtrosSel->setNombre_seccion($rowt ["descesp"]);
                $nom_componente = $rowt ["descesp"];
            } // fin de idioma
          
             }

        $tamanio = $this->tamanioMuestra($mes_asig, $filx, $fily, $usuario_act, $numop, $tiposec);
        if ($tiposec == "V")
        { 	$this->tit_cumplaj= '<span class="SubtituloGraf">' . $nom_componente . "</span><br>" . T_("EDAD PROMEDIO POR PRODUCTO");
//       echo "****".$tamanio;
//       echo $this->estadisticas->getTotalresultados();
      //  $tamanio=$tamanio/$this->estadisticas->getTotalresultados();
        }
//busco tama�o de la muestra
      //  echo "o el tamanio"; die();
        if ( $ptv == "") {
            $cad='<div class="table-responsive">
                <table class="table no-margin">
                   <tbody>
                  <tr>
                    <td style="font-weight: bold">'.T_("TAMAÑO DE LA MUESTRA").'</td>                  
                    <td>
                      <div class="sparkbar pull-right" data-height="20">'. $tamanio .'</div>
                    </td>
                  </tr>
			</tbody>
                </table>
				</div>';
           $this->estadisticas->setTamano_muestra($cad);

        }
//echo $usuario_act;
//echo "xx  ".$numop;
//hace el area de depliegue de la grafica de 270*170 pixeles y de color blanco
        $this->graficaaplica = "views/modulos/indgraficaaplica.php?numsec=" . $numop . "&tiposec=" . $tiposec . "&cgserv=" . $this->vserviciou;

        $this->graficanivelcumpl = "views/modulos/indgraficacumplimiento.php?numsec=" . $numop . "&tiposec=" . $tiposec . "&cgserv=" . $this->vserviciou;


        if ($tipografica != 'C') { //despliega las otras graf
            $this->graficagen = "views/modulos/indgraficacomportamiento.php?numsec=" . $numop . "&tiposec=" . $tiposec . "&cgserv=" . $this->vserviciou;

            if ($tiposec == "E") {
                if ($numop == '8.0.1.0.0.9') { //grafica para proporcion agua jarabe
                    $this->tit_frec = T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR POR PRODUCTO");
                    $this->graficafrec = "views/modulos/indgraficacumplimientoaj.php?numsec=" . $numop . "&usu=$usuario_act" . "&tiposec=" . $tiposec . "&cgserv=" . $this->vserviciou;
                } else {
                    $this->tit_frec = T_("HISTOGRAMA DE FRECUENCIAS");
                    $this->graficafrec = "views/modulos/indgraficafrecuencia.php?numsec=" . $numop . "&usu=$usuario_act" . "&tiposec=" . $tiposec . "&cgserv=" . $this->vserviciou;
                }
            }
        }
    }

    function creaFiltro($filtro) {
        global $html;
        $titulo_fil = array('unidadneg' => "UNIDAD DE NEGOCIO: ", "franquicia" => "FRANQUICIA: ", "region" => "REGION/GRUPO: ", "zona" => "ZONA/ESTADO: ", "cedis" => "CEDIS/CIUDAD: ");
        $clase = "Titulo2";
        if (isset($_SESSION["f" . $filtro]) && $_SESSION["f" . $filtro] != "") {
            if ($filtro == "region" || $filtro == "cedis")
                $clase = "Tit2der";
            //falta esto
            //  $html->asignar($filtro, '<td class="'.$clase.'" width="50%">' . $titulo_fil[$filtro] . $_SESSION["f" . $filtro] . "</td>");
        }
    }

    function getNivel() {
        return $this->nivel;
    }
    

    /**
	 * @return string
	 */
	public function getTit_frec() {
		return $this->tit_frec;
	}

	function getNombreSeccion() {
        return $this->nombreSeccion;
    }

    function getTitulopag() {
        return $this->titulopag;
    }

    function getEstadisticas() {
        return $this->estadisticas;
    }

    function getLigasi() {
        return $this->ligasi;
    }

    function getLigano() {
        return $this->ligano;
    }

    function getLb_tamanio_muestra() {
        return $this->lb_tamanio_muestra;
    }

    function getGraficaaplica() {
        return $this->graficaaplica;
    }

    function getGraficanivelcumpl() {
        return $this->graficanivelcumpl;
    }

    function getGraficagen() {
        return $this->graficagen;
    }

    function getGraficafrec() {
        return $this->graficafrec;
    }

    function getGraf_cumplaj() {
        return $this->graf_cumplaj;
    }

    function getFiltrosSel() {
        return $this->filtrosSel;
    }

    function getTitulo2() {
        return $this->titulo2;
    }

    function getListaEstablecimientos() {
        return $this->listaEstablecimientos;
    }

    function getNotaEstabl() {
        return $this->notaEstabl;
    }
    
    function getTit_cumplaj() {
        return $this->tit_cumplaj;
    }
	/**
	 * @return mixed
	 */
	public function getMostrar() {
		return $this->mostrar;
	}




}
