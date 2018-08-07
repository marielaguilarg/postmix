<?php

class ResumenResxRepController
{

    private $titulo1;

    private $nombre_une;

    private $numreporte;

    private $FechaVisita;

    private $listaTablas;

    private $ligaconsultarRep;

    private $listaImagenes;

    public function vistaResumenResxRep()
    {
        // -----------------------------------
        // inicializo etiquetas por idioma
        // -----------------------------------
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
        
        $vservicio = $_SESSION["servicioind"];
        $vcliente = 100;
        
        $this->titulo1 = T_("RESUMEN DE RESULTADOS POR REPORTE");
        $this->numreporte = T_("NO. DE REPORTE") . ":" . $numrep;
        // creo xml para imagenes
        include "MENindcrearimagesxml.php";
        $ancho1 = "58%";
        $ancho2 = "22%";
        $ancho3 = "20%";
        
        $tache = "<img src='img/tache.png' width='20' height='20' border='0' alt='Ver resultados' title='" . T_('Ver resultados') . "'>";
        $paloma = "<img src='img/palomita.png' width='20' height='20' border='0' alt='Ver resultados' title='" . T_('Ver resultados') . "'>";
        
        $row_rs_sql_titulo = DatosGenerales::getDatosReporteUnegocio($numrep, $vservicio);
        if (sizeof($row_rs_sql_titulo)) {
            $pto_vta = $row_rs_sql_titulo["une_claveunegocio"];
            $this->nombre_une = $row_rs_sql_titulo["une_descripcion"];
            $nomunegocio = $row_rs_sql_titulo["une_descripcion"];
            /* * *** FUNCION QUE CONVIERTE FECHA ******** */
            $mes = $row_rs_sql_titulo["i_mesasignacion"];
            $this->FechaVisita = Utilerias::formato_fecha($row_rs_sql_titulo["i_fechavisita"]);
            /* * ** FIN DE CONVERSION DE FECHA ********* */
            $idclien = $row_rs_sql_titulo["i_idcliente"];
            $vcliente = $idclien;
            $idser = $row_rs_sql_titulo["i_claveservicio"];
            $idcuen = $row_rs_sql_titulo["i_clavecuenta"];
            $franquiciacta = $row_rs_sql_titulo["fc_idfranquiciacta"];
            
            /* * ************************************************************************ */
        }
        // $html->asignar('TITULO', T_("PEPSICO DE MEXICO"));
        
        /* * ******************************* consulta para saber si el reporte tiene imagenes ********************************** */
        
        // echo $query_isec;
        $rs_isec = DatosImagenDetalle::getImagenDetalle($idser, $numrep, "ins_imagendetalle");
        foreach ($rs_isec as $row_isec) {
            $this->listaImagenes[] = $row_isec["id_ruta"];
            // if ($row_isec[0] > 0)//si hay imagenes
            // {
            // $objimagenes="<script language=\"javascript\">
            //
            // if (AC_FL_RunContent == 0) {
            // alert(\"This page requires AC_RunActiveContent.js.\");
            // } else {
            // AC_FL_RunContent(
            // 'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
            // 'width', '800',
            // 'height', '500',
            // 'src', 'imageViewer',
            // 'quality', 'high',
            // 'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
            // 'align', 'middle',
            // 'play', 'true',
            // 'loop', 'true',
            // 'scale', 'showall',
            // 'wmode', 'window',
            // 'devicefont', 'false',
            // 'id', 'imageViewer',
            // 'bgcolor', '#ffffff',
            // 'name', 'imageViewer',
            // 'menu', 'true',
            // 'flashVars', 'xmlURL=../Archivos/images".$numrep.".xml',
            // 'allowFullScreen', 'false',
            // 'allowScriptAccess','sameDomain',
            // 'movie', 'imageViewer',
            // 'salign', ''
            // ); //end AC code
            // }
            // </script>".
            //
            // '<noscript>
            // <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="800" height="500" id="imageViewer" align="middle">
            // <param name="allowScriptAccess" value="sameDomain" />
            // <param name="allowFullScreen" value="false" />
            // <param name="movie" value="../libs/imageViewer/imageViewer.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
            // <embed src="../libs/imageViewer/imageViewer.swf" quality="high" bgcolor="#ffffff" width="800" height="500" name="imageViewer" align="center" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            // </object>
            // </noscript>';
            //
            //
            // }
        }
        
        /* * ******************************************************* */
        
        $direccE = "MENindprincipal.php?op=mindi&admin=Cconsec&tiposec=E&opadmin=detalle_consulta&ruta=a";
        $direccV = "MENindprincipal.php?op=mindi&admin=Cconsec&tiposec=V&ruta=a&Op=";
        $direccP = "MENindprincipal.php?op=mindi&admin=Cconsec&tiposec=P&ruta=a&Op=";
        
        $OPD = $idclien . "." . $idser . "." . $idcuen . "." . $pto_vta;
        // $html->asignar('refer', $OPD);
        
        $this->ligaconsultarRep = 'MENindprincipal.php?op=mindi&admin=seccion&numrep=' . $numrep . '&referencia=' . $OPD;
        //
        // $html->asignar('INFOAREA', $infoarea.'</td><td>
        // <a href="MENindprincipal.php?op=mindi&admin=res&mes=' . $mes . '&ptv=' . $pto_vta . '&fily=' . $idcuen . '.' . $franquiciacta.'" >'.T_("CONSULTAR HISTORIAL DEL PUNTO DE VENTA").' </a></td>');
        // $html->asignar('CONSULTAREP','<a href="MENindprincipal.php?op=mindi&admin=seccion&numrep='.$lista.'&referencia='.$OPD.'" onClick="guardarLiga(this, \'REPORTE\');">'.T_("CONSULTAR TODO EL REPORTE").' </a></td>
        // ');
        
        /* * ************ calidad de la bebida************ */
        
        $cols = "";
        $resultados = "";
        $resResultadoscont = new ResumenResultadosController();
        $sec_calbebida = array(
            '8.0.2.6',
            '8.0.2.9'
        );
        $sec_condiciones = array(
            '6',
            '7',
            '3.3',
            '8.0.2.5',
            '3.6',
            '3.7',
            '3.9',
            '3.10',
            '3.2',
            '3.4'
        );
        
        // agrego la proporcion agua-jarabe
        
        $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . "8." . $pto_vta;
        $cols = "";
        foreach ($sec_calbebida as $sec) {
            $rs_cal_b = DatosEst::CumplimientoEstandar($vservicio, $sec, $numrep);
            if ($rs_cal_b != null) {
                $simbolo1 = $rs_cal_b[2];
                
                $dir = $direccE . "&subsecc=8.0.2.0.0&num=" . $OPD;
                $direcc2 = "<a href='" . $dir . "'>" . $$simbolo1 . "</a>";
                $cols = "<td >" . $rs_cal_b[0] . "</td>";
                $cols .= "<td  >" . $rs_cal_b[1] . "</td>";
                
                $cols .= "<td >" . $direcc2 . "</td>";
                $resultados .= $this->creaRenglon($cols);
            }
            $cont = $cont + 1;
        }
        $resultado = DatosEst::CumplimientoProporcion($vservicio, '8.0.1.9', $numrep, "");
       
        $color = "subtitulo3";
        if ($resultado != null) {
            $simbolo2 = $resultado[2];
            $dir = $direccE . "&subsecc=8.0.1.0.0&num=" . $OPD;
            $direcc2 = "<a href='" . $dir . "'>" . $$simbolo2 . "</a>";
            $cols = "<td>" . $resultado[0] . "</td>";
            $cols .= "<td>" . $resultado[1] . "</td>";
            
            $cols .= "<td >" . $direcc2 . "</td>";
            $resultados .= $this->creaRenglon($cols);
            
            $this->listaTablas[] = $resResultadoscont->creaTabla(1, $resultados);
        }
        /* * ******RESULTADOS DE PRUEBAS DE ANALISIS calidad del agua ************************ */
        
        $ren = "";
        $td = "";
        // $sec_calagua = ConsultaAtributos($vservicio ,'5.0.2');
        $sec_calagua = array(
            "5.0.2.18",
            "5.0.2.17",
            "5.0.2.5",
            "5.0.2.9",
            "5.0.2.1",
            "5.0.2.2",
            "5.0.2.3",
            "5.0.2.4",
            "5.0.2.6",
            "5.0.2.7",
            "5.0.2.8",
            "5.0.2.10",
            "5.0.2.11",
            "5.0.2.12",
            "5.0.2.13",
            "5.0.2.16"
        );
        $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . "5." . $pto_vta;
        $cont = 0;
        $dir = $direccE . "&subsecc=5.0.2.0.0" . "&num=" . $OPD;
        foreach ($sec_calagua as $sec) {
            $cols = "";
            if ($cont % 2 == 0) {
                $color = "subtitulo3";
            } else { // class="subtitulo31"
                $color = "subtitulo31";
            }
            if ($cont > 3) {
                $fila_oculta = 'class="los_demas" id="fila_inv5" name="fila_inv5"';
                $liga = '<tr bgcolor="#FFFFFF"><td align="right" colspan="3"><a style="text-decoration:underline; font-size:9px; color:#0066FF" href="javascript: MostrarFilas(\'fila_inv5\',\'ln_desp5\')" id="ln_desp5">' . T_("desplegar") . '</a></td></tr>';
            } else {
                $fila_oculta = '';
                $liga = "";
            }
            $RS_AGUAT = DatosEst::CumplimientoEstandar($vservicio, $sec, $numrep);
            $simbolo3 = $RS_AGUAT[2];
            $direcc2 = "<td ><a href='" . $dir . "'>" . $$simbolo3 . "</a></td>";
            $td = "<td >" . $RS_AGUAT[0] . "</td>";
            $td .= "<td  >" . $RS_AGUAT[1] . "</td>";
            $td .= $direcc2;
            // $html->asignar('resultado',"<td align='center'>".$var."</td>");
            $ren .= "<tr " . $fila_oculta . ">" . $td . "</tr>";
            // $ren .= creaRenglon($td);
            
            $cont ++;
        }
        // /****FIN DE RESULTADOS DE PRUEBAS DE ANALISIS**********************/
        $this->listaTablas[] = $resResultadoscont->creaTabla(2, $ren . $liga);
        
        /* * ****************Presiones **************************** */
        $cols = "";
        $resultados = "";
        $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . "2." . $pto_vta;
        $cont = 0;
        $sec_presiones = DatosEst::ConsultaAtributos($vservicio, '2.8.1');
        
        foreach ($sec_presiones as $sec) {
            $cols = "";
            
            $RS_PRESION_O = DatosEst::CumplimientoEstandar($vservicio, $sec, $numrep);
            if ($cont % 2 == 0) {
                $color = "subtitulo3";
            } else { // class="subtitulo31"
                $color = "subtitulo31";
            }
            
            $simbolo = $RS_PRESION_O[2];
            
            $direccpre = "MENindprincipal.php?op=mindi&admin=Cconsec&tiposec=E&opadmin=detalle_consulta&subsecc=2.8.1.0.0&ruta=a&num=" . $OPD;
            $direcc2 = "<a href='" . $direccpre . "'>" . $$simbolo . "</a>";
            $cols = "<td >" . $RS_PRESION_O[0] . "</td>";
            $cols .= "<td >" . $RS_PRESION_O[1] . "</td>";
            $cols .= "<td  >" . $direcc2 . "</td>";
            $resultados .= $this->creaRenglon($cols);
            $cont ++;
        }
        $this->listaTablas[] = $resResultadoscont->creaTabla(3, $resultados);
        
        /* * ************************************************* */
        /* * ********************** condiciones de operacion ************************** */
        
        $cols = "";
        $resultados = "";
        $cont = 0;
        
        foreach ($sec_condiciones as $sec) {
            $cols = "";
            if ($cont % 2 == 0) {
                $color = "subtitulo3";
            } else { // class="subtitulo31"
                $color = "subtitulo31";
            }
            if ($sec == '6' || $sec == '7') {
                $res = DatosProducto::CumplimientoProducto($vservicio, $sec, $numrep);
                // echo "<br>";
                // var_dump($res);
                $simbolox = $res[2];
                $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . $sec . "." . $pto_vta;
                $direcc2 = "<a href='" . $direccV . $OPD . "'>" . $$simbolox . "</a>";
                $color .= "p";
            } else if ($sec == '8.0.2.5') {
                $res = DatosEst::CumplimientoEstandar($vservicio, $sec, $numrep);
                $simbolox = $res[2];
                $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . "8." . $pto_vta;
                $dir = $direccE . "&subsecc=8.0.2.0.0" . "&num=" . $OPD;
                $direcc2 = "<a href='" . $dir . "'>" . $$simbolox . "</a>";
                $color .= "p";
            } else {
                $res = DatosPond::CumplimientoPonderada($vservicio, $sec, $numrep);
                $simbolox = $res[2];
                $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . "3." . $pto_vta;
                $direcc2 = "<a href='" . $direccP . $OPD . "'>" . $$simbolox . "</a>";
                $color .= "p";
            }
            if ($cont > 3) {
                $fila_oculta = 'class="los_demas" id="fila_inv3" name="fila_inv3"';
                $liga = '<tr bgcolor="#FFFFFF"><td align="right" colspan="3"><a style="text-decoration:underline; font-size:9px; color:#0066FF" href="javascript: MostrarFilas(\'fila_inv3\',\'ln_desp3\') " id="ln_desp3">' . T_("desplegar") . '</a></td></tr>';
            } else {
                $fila_oculta = '';
                $liga = "";
            }
            
            $cols = "<td >" . $res[0] . "</td>";
            $cols .= "<td >" . $res[1] . "</td>";
            $cols .= "<td >" . $direcc2 . "</td>";
            // $resultados .= creaRenglon($cols);
            $resultados .= "<tr " . $fila_oculta . ">" . $cols . "</tr>";
            $cont = $cont + 1;
        }
        // }
        
        $this->listaTablas[] = $resResultadoscont->creaTabla(4, $resultados . $liga);
        
        if (isset($refer)) {
            $subseccion = $refer;
            $nuevaop = $subseccion;
            
            $datini = SubnivelController::obtienedato($subseccion, 1);
            $londat = SubnivelController::obtienelon($subseccion, 1);
            $numseccion = substr($subseccion, $datini, $londat);
        }
        //
        // $navegacion='<li><a href="MENindprincipal.php?op=mindi&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&niv=" style="z-index:9;">'.T_("GRAFICA").'</a></li>';
        // If($_SESSION["fbuscapv"]==1)
        // $navegacion.='<li><a href="MENindprincipal.php?admin=buspv" style="z-index:8;">'.T_("BUSCAR PUNTO DE VENTA").'</a></li>';
        // else
        // if($_SESSION["ffilx"]!="")
        // $navegacion.='<li><a href="MENindprincipal.php?op=mindi&admin=cons&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&ref='.$_SESSION["fref"].'&niv='.$_SESSION["fniv"].'" style="z-index:8;">'.T_("INDICADORES").'</a></li>';
        // /*<li><a href="MENindprincipal.php?op=mindi&admin=cons&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&fily='.$_SESSION["ffily"].'&ref='.$_SESSION["fref"].'&niv='.$_SESSION["fniv"].'&ren='.$_SESSION["fren"].'" style="z-index:7;">'.$nomcuenta.'</a></li>*/
        // $navegacion.='<li><a href="#" style="z-index:6;">'.$nomunegocio.'</a></li>';
        
        Navegacion::borrarRutaActual("c");
        $rutaact = $_SERVER['REQUEST_URI'];
        // // echo $rutaact;
        Navegacion::agregarRuta("c", $rutaact, "NO. REP. " . $numrep);
    }

    /* * ********************************************************* */
    
    // seccion de funciones //
    /* * ******************************************************** */
    
    /**
     *
     * @return the $listaImagenes
     */
    public function getListaImagenes()
    {
        return $this->listaImagenes;
    }

    function creaRenglon($cols)
    {
        return "<tr>" . $cols . "</tr>";
    }

    function getTitulo1()
    {
        return $this->titulo1;
    }

    function getNombre_une()
    {
        return $this->nombre_une;
    }

    function getNumreporte()
    {
        return $this->numreporte;
    }

    function getFechaVisita()
    {
        return $this->FechaVisita;
    }

    function getListaTablas()
    {
        return $this->listaTablas;
    }

    function getLigaconsultarRep()
    {
        return $this->ligaconsultarRep;
    }
}
