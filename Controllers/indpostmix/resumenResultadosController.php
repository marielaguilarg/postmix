<?php



class ResumenResultadosController {

    private $filtros_indi;
  
    private $lista_tablas;
    private $vservicio;
    private $vcliente;
    private $Nivel04;
    private $Nivel05;
    private $Nivel06;
    private $estilo_accrap;
    private $lb_Promedio_resultados;
    private $mes_asig;
      private  $ptv;
        private $tit_secciones;
        private $cuenta;

    private $filtrosNivel;
  
   
    private $periodo;
    private $fecha_cons;
    private $tipomerc;
    private $franquiciacta;
    private $NOMPTO_VTA;
    private $total_res;

  
    public function vistaResumenResultados() {
        
      
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo,FILTER_SANITIZE_STRING) . "';";
            eval($asignacion);
        }
        if ($_GET) {
            $keys_get = array_keys($_GET);
            foreach ($keys_get as $key_get) {
                $$key_get = filter_input(INPUT_GET, $key_get,FILTER_SANITIZE_STRING);
                //error_log("variable $key_get viene desde $ _GET"); 
            }
        }
        $rescon=true;
        if($action=="indhistorialreportes")
        	$rescon=true;
        else
        if($action=="indindicadores")
        {
        	$consutacontrl=new GenerarBusquedaController;
        $rescon=$consutacontrl->generarBusquedaRes();}
        else if($action=="resumenresultados")
        	if($admin==prin){
        	$consutacontrl=new GeneraBusqResController();
        	$rescon=$consutacontrl->generarBusquedaRes();
        }else $rescon=true;
        
        if($rescon==false) die();
        $usuario_act = $_SESSION["UsuarioInd"];

        // genera info gr14fica
        //separamos los componentes de la seccion para hacer las consultas
        $arreglo = explode('.', $seccion);
        $seccion = $arreglo [0] . '.' . $arreglo [1] . '.' . $arreglo [2] . '.' . $arreglo [5];
        $_SESSION["prin"] = "";




        $usuario = $_SESSION["UsuarioInd"];

        $this->vcliente = 1;
        $this->vservicio = 1;

        /*         * ******************************************************************* */
        $i = 0;

        $sec_calbebida = array('8.0.2.6', '8.0.2.9', '8.0.1.9');
      
//$sec_condiciones = array (array('6','V'), array('7','V'),array('8.0.2.5','P'),'3.6', '3.7', '3.9', '3.10', '3.2', '3.3', '3.4' );
//$tit_secciones = array ('CALIDAD DE LA BEBIDA', 'CALIDAD DEL AGUA', 'FRESCURA DE JARABES', 'PRESIONES DE OPERACION', 'CONDICIONES DE OPERACION' );


        $seccion3 = array('8.0.1.1', '8.0.1.2', '8.0.1.3', '8.0.1.4', '8.0.1.5');


// recupero variables de sesion
        $this->cuenta = $_SESSION["fcuenta"];
        $periodo = $_SESSION["fperiodo"];
    
        $ancho1 = "58%";
        $ancho2 = "22%";
        $ancho3 = "20%";


        $num_reg = $_SESSION["fnumrep"];
        $this->total_res= T_("TOTAL DE REPORTES").": ".$num_reg;
        if ($ptv != "") {
            $sql_titulo = "SELECT * 
    FROM ins_generales
    Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
    Inner Join ca_cuentas ON  ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
    WHERE ins_generales.i_unenumpunto = :ptv    and ins_generales.i_claveservicio=:vserviciou 
        and concat(ca_unegocios.cue_clavecuenta,'.',`fc_idfranquiciacta`)=:fily";
            $parametros = array("ptv" => $ptv, "vserviciou" => $this->vservicio, "fily" => $fily);
            $rs_sql_titulo = Conexion::ejecutarQuery($sql_titulo, $parametros);
            foreach ($rs_sql_titulo as $row_rs_sql_titulo) {
                $pto_vta = $row_rs_sql_titulo ["une_id"];

                $nomunegocio = $row_rs_sql_titulo ["une_descripcion"];
                /*                 * *** FUNCION QUE CONVIERTE FECHA ******** */

                $idcuen = $row_rs_sql_titulo ["i_clavecuenta"];

                $nomcuenta = $row_rs_sql_titulo ["cue_descripcion"];


                /*                 * ************************************************************************ */
            }
        }
   
           $this->filtros_indi = new ConsultaIndicadores;
    $this->filtros_indi->setNombre_franquicia($nomunegocio);
     $this->ptv=$ptv;
   
     //  $html->asignar("INFOAREA2", $nomunegocio);
        if ($action== "indindicadores") {

            $gfilx = $filx;
            $gfiluni = $filuni;
            $gfily = $fily;
            $aux = explode(".", $gfilx);
            $auxuni = explode(".", $gfiluni);

            $filx = array();
            $filx["reg"] = $aux[0];

            $filx["ciu"] = $aux[1];
            $filx["niv6"] = $aux[2];
            $filx["pais"] = $auxuni[0];

            $filx["uni"] = $auxuni[1];
            $filx["zon"] = $auxuni[2];
            $zona = $auxuni[2];
         
            $this->filtros_indi->setNivel($gfilx);
            $this->filtros_indi->setMes_indice($fechaasig_fin);

            $auxy = explode(".", $gfily);

            $fily = array();

            $fily["cta"] = $auxy[0];

            $fily["fra"] = $auxy[1];
            $fily["pv"] = $auxy[2];
            // var_dump($filx);
            if ($filx["pais"] != "" && $filx["pais"] != 0) {

                $nompais = Datosnuno::nombreNivel1($filx["pais"],"ca_nivel1");
            }

          
            if ($filx["uni"] != "" && $filx["uni"] != 0) {

                $nomuni = Datosndos::nombreNivel2( $filx["uni"],"ca_nivel2");
            }
            if ($filx["zon"] != "" && $filx["zon"] != 0) {

                $nomzon = "-" . Datosntres::nombreNivel3($filx["zon"],"ca_nivel3");
            }
            if ($filx["reg"] != "" && $filx["reg"] != 0) {

                $nomreg = "-" . Datosncua::nombreNivel4($filx["reg"],"ca_nivel4");
                  $tituloliga = $nomreg;
            }
            if ($filx["ciu"] != "" && $filx["ciu"] != 0) {

                $nomciu = "-" . Datosncin::nombreNivel5( $filx["ciu"],"ca_nivel5");
                   $tituloliga = $nomciu;
            }
            if ($filx["niv6"] != "" && $filx["niv6"] != 0) {
                $nomniv6 = "-" . Datos::nombreNivel6( $filx["niv6"], "ca_nivel6");
                  $tituloliga = $nomniv6;
            }
          


            if ($fily["cta"] != "")
                $nomcta = DatosCuenta::nombreCuenta($fily["cta"],$this->vcliente);
            if ($fily["fra"] != "")
                $nomfra = "-" . DatosFranquicia::nombreFranquicia($fily["cta"], $fily["fra"]);

            if ($fily["pv"]) {

                $this->ptv = $fily["pv"];
                $sql_titulo = "SELECT * 
    FROM ins_generales
    Inner Join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
    Inner Join ca_cuentas ON  ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
    WHERE ins_generales.i_unenumpunto = :ptv    and ins_generales`.i_claveservicio=:vserviciou
        and concat(ca_unegocios.cue_clavecuenta,'.',`fc_idfranquiciacta`)=:referencia";
                $parametros = array("ptv" => $this->ptv, "referencia" => $fily["cta"] . "." . $fily["fra"]);
                $rs_sql_titulo = Conexion::ejecutarQuery($sql_titulo, $parametros);
                foreach ($rs_sql_titulo as $row_rs_sql_titulo) {
                    $pto_vta = $row_rs_sql_titulo ["une_id"];

                    $nomunegocio = "-" . $row_rs_sql_titulo ["une_descripcion"];
                    /*                     * *** FUNCION QUE CONVIERTE FECHA ******** */




                    /*                     * ************************************************************************ */
                }
            }
        
             $mesasig = $mes;
        $aux = explode('.', $mes);
        $this->mes_asig = $mes;
        $fmes_consulta = $aux[1] . "-" . $aux[0] . "-01";
        $mes_consulta_ant = ($aux[1] - 1) . "-" . $aux[0] . "-01";
            $this->filtros_indi->setNombre_nivel($nomreg . " " . $nomciu . " " . $nomniv6 . " " . $nomcta . " " . $nomfra);

            $lugar = $nomuni . " " . $nomzon . " " . $nomreg . " " . $nomciu . " " . $nomniv6 . "<br>" . $nomcta . " " . $nomfra . " " . $nomunegocio;
            $this->filtros_indi->setNombre_seccion(T_("INDICADORES"));
          //  $mesletra = Utilerias::cambiaMesGIng($fechaasig_i) . "-" . Utilerias::cambiaMesGIng($fechaasig_fin);
            $this->filtros_indi->setNombre_nivel($lugar);
            if($consutacontrl!=null)
                $this->filtros_indi->setPeriodo( $consutacontrl->getFiltrosSel()->getPeriodo());
        }
        /* * ****** calidad de la bebida***************** */
        $tabla =$this->ConsultaSeccion($usuario_act, $sec_calbebida, '');
        $this->lista_tablas[]=$this->creaTabla(1, $tabla);;

        /*         * *********** calidad del agua ********************** */
//$seccion2 = ConsultaAtributos('5.0.2');
        $seccion2 = array("5.0.2.18", "5.0.2.17", "5.0.2.5", "5.0.2.9",
            "5.0.2.1", "5.0.2.2", "5.0.2.3", "5.0.2.4", "5.0.2.6", "5.0.2.7", "5.0.2.8", "5.0.2.10",
            "5.0.2.11", "5.0.2.12", "5.0.2.13", "5.0.2.16", "5.0.2.19", "5.0.2.20");
        $tabla =$this->ConsultaSeccion($usuario_act, $seccion2, '');
        $this->lista_tablas[]= $this->creaTabla(2, $tabla);
        /*         * ************** frescura de jarabes ******************* */
        /*
          $tabla = ConsultaSeccion ( $usuario_act, array(6,7), 'V' );
          $html->asignar ( 'tablaseccion', $tabla );
          $html->expandir ( 'SECCIONES', '+listasec' ); */
        /*         * ************************* presiones ********************** */
        $seccion2 = $this->ConsultaAtributos('2.8.1');
        $tiempo_fin = microtime(true);
        
        //echo "a la mitad 2 " . ($tiempo_fin - $tiempo_inicio); 
        $tabla = $this->ConsultaSeccion($usuario_act, $seccion2, '');
        $this->lista_tablas[]=$this->creaTabla(3, $tabla);;
        /*         * ************************buenos habitos *********************************** */
        $sec_condiciones = array('6', '7');
        $tabla="";
        $tabla = $this->ConsultaSeccion($usuario_act, $sec_condiciones, 'Pro');
        $tabla.= $this->ConsultaSeccion($usuario_act, array('3.3'), 'P');
        $sec_condiciones = array(  '3.6', '3.7', '3.9', '3.10', '3.2', '3.4');
        $tabla.= $this->ConsultaSeccion($usuario_act,array( '8.0.2.5'), '');
        $tabla.= $this->ConsultaSeccion($usuario_act, $sec_condiciones, 'P');
        $this->lista_tablas[]=$this->creaTabla(4, $tabla);;
        
       
        if ($_GET["action"] == "indindicadores") {
            Navegacion::borrarRutaActual("b");
            $rutaact = $_SERVER['REQUEST_URI'];
            // echo $rutaact;
             Navegacion::agregarRuta("b", $rutaact, T_("INDICADORES"));
        } else {
             Navegacion::borrarRutaActual("b");
            $rutaact = $_SERVER['REQUEST_URI'];
            // echo $rutaact;
             Navegacion::agregarRuta("b", $rutaact, T_("RESULTADOS"));
        }
      
    }

    function creaTabla($num, $resultados) {
    //include('class.NokTemplate.php');
    /*
      $html->cargar ( 'spanel', 'MENresultadoseccion.htm' );
      $html->definirBloque ( 'Panelsec', 'spanel' );
      $html->definirBloque ( 'tlista', 'spanel' ); */

    $tit_secciones = array(T_('CALIDAD DE LA BEBIDA'), T_('CALIDAD DEL AGUA'), T_('PRESIONES DE OPERACION'), T_('BUENOS HABITOS DE MANUFACTURA'));

    $tabla=' <div class="box-header">
              <h3 class="box-title">' . $tit_secciones [$num - 1] . '</h3>
            </div>
            <!-- /.box-header -->
  <div class="box-body table-responsive no-padding">
<table class="table table-striped table-hover" >
	
	  <tr>
        <th   >' . T_("ATRIBUTO") . '</th>
       
        <th >' . T_("ESTANDAR") . '</th>
     
        <th style="valign:center"  >' . T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR") . '<br> (%)</th>
		
      </tr>';
    $tabla .= $resultados . " </table></div>";
    return $tabla;
}
    /*     * ***************** crea la tabla para cada seccion ********************************** */

    function ConsultaSeccion($usuario, $secciones, $tipo) {
      
      
        $cont = 0;
      
       
           if($tipo=="Pro")
           	$lista = $this->CumplimientoProducto($secciones, $usuario);
            else if ($tipo == 'P') {
                //condicion para altura del hielo
            	
            	$lista = $this->CumplimientoPonderada($secciones, $usuario);
            }
            else if ($tipo == 'V')
            	$lista = $this->CumplimientoProducto($secciones, $usuario);
            else
            	$lista = $this->CumplimientoEstandar($secciones, $usuario);
      
            	foreach ($lista as $res) {
            if ($cont % 2 == 0) {
                $color = "subtitulo3";
            } else { //class="subtitulo31"
                $color = "subtitulo31";
            }
            $cont++;
            if ($tipo == 'P')
                $color1 = $color . "p";
            else
                $color1 = $color;
            // clase para ocultar filas
            if ($cont > 4) {
                $fila_oculta = 'class="los_demas"  id="fila_inv' . $num . '" name="fila_inv' . $num . '"';
                $liga = '<tr ><td align="right" colspan="3">
                <a style="text-decoration:underline; font-size:9px; color:#0066FF" href="javascript: MostrarFilas(\'fila_inv' . $num . '\',\'ln_desp' . $num . '\') " id="ln_desp' . $num . '">' . T_("desplegar lista completa") . '</a></td></tr>';
            } else {
                $fila_oculta = '';
                $liga = "";
            }
            $resultados.= ' <tr ' . $fila_oculta . '>
        <td >
              <a href="index.php?action=indestadisticares&mes=' .  $this->mes_asig . '&refer=' . $res[3] . '&ptv=' . $this->ptv . '&cta=' . $this->cuenta . '&tit=' . $num . '" title="' . strtoupper(T_("Consultar estadisticas")) . '">' . $res [0] . '</a></td>
      
        <td >  <a href="index.php?action=indestadisticares&mes=' .  $this->mes_asig . '&refer=' . $res[3] . '&ptv=' . $this->ptv . '&cta=' . $this->cuenta . '&tit=' . $num . '" title="' . strtoupper(T_("Consultar estadisticas")) . '">' . $res [1] . '</a></td>
  
        <td style="font-weight: bold;">
        <a href="index.php?action=indestadisticares&admin=1&mes=' .  $this->mes_asig . '&refer=' . $res[3] . '&ptv=' . $this->ptv . '&cta=' . $this->cuenta . '&tit=' . $num . '" title="' . strtoupper(T_("Consultar estadisticas")) . '"><span class="liga_esp">' . $res [2] . '</span></a></td> </tr>';
          
        }
       
         
        return $resultados.$liga;
    }

    function CumplimientoEstandar($referencia, $usuario) {
    	foreach($referencia as $sec){
    		$listasec.="'".$sec."' ,";
    	}
   
        $sql_reporte_e = "SELECT
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,100,0),0),if(ide_aceptado<0,100,0)))/sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as nivaceptren,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,
tmp_estadistica.usuario,concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) as refer,
red_tipodato,red_valormin,red_clavecatalogo
FROM
ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join tmp_estadistica ON ins_detalleestandar.ide_numreporte = tmp_estadistica.numreporte
WHERE cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
ins_detalleestandar.ide_claveservicio=:vserviciou AND
concat(cue_reactivosestandar.sec_numseccion,'.', ins_detalleestandar.ide_numreactivo,'.' ,ins_detalleestandar.ide_numcomponente,'.',ins_detalleestandar.ide_numcaracteristica3 ) in (".substr($listasec,0,strlen($listasec)-1).")
 and cue_reactivosestandardetalle.red_grafica=-1 and tmp_estadistica.usuario=:usuario
  GROUP BY

ins_detalleestandar.ide_numseccion,
cue_reactivosestandar.re_tipoevaluacion,
ins_detalleestandar.ide_numreactivo,
ins_detalleestandar.ide_numcomponente,
ins_detalleestandar.ide_numcaracteristica3,
tmp_estadistica.usuario";
     $parametros = array("vserviciou" => $this->vservicio, "usuario" => $usuario);
       // echo "<br>***********************************************<br>";
        $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e, $parametros);
       
        //$res = 0;
        foreach ($rs_sql_reporte_e as $row_rs_sql_reporte_e) {
            //$chart [ 'chart_data' ][ 2][ 0 ] = "aqui";
            if ($_SESSION["idiomaus"] == 2)
                $res [0] = $row_rs_sql_reporte_e ['red_parametroing'];
            else
                $res [0] = $row_rs_sql_reporte_e ['red_parametroesp'];
            // si el estandar es de catalogo lo busco en el catalogo
            if ($row_rs_sql_reporte_e["red_tipodato"] == "C") {
                $sql_cat = "SELECT
ca_catalogosdetalle.cad_descripcionesp,
ca_catalogosdetalle.cad_descripcioning
FROM
ca_catalogosdetalle
WHERE
ca_catalogosdetalle.cad_idcatalogo =  '" . $row_rs_sql_reporte_e ["red_clavecatalogo"] . "' AND
ca_catalogosdetalle.cad_idopcion =  '" . $row_rs_sql_reporte_e ["red_valormin"] . "'";
// echo "<br>".$sql_cat;
                $result_cat = Conexion::ejecutarQuerysp($sql_cat);
                foreach ($result_cat as $row_cat ) {
                    if ($_SESSION["idiomaus"] == 2)
                        $res[1] = $row_cat["cad_descripcioning"];
                    else
                        $res[1] = $row_cat["cad_descripcionesp"];
                }
               
            } else
                $res [1] = $row_rs_sql_reporte_e ['red_estandar'];
                
            $res [2] = Utilerias::redondear2($row_rs_sql_reporte_e ['nivaceptren'],1);
            $res[3] = $row_rs_sql_reporte_e ['refer'];
            $resultados[]=$res;
        }
    
        return $resultados;
    }

    function cumplimientoPonderada($sec, $usuario) {
    	foreach($sec as $opcion){
    		$listasec.=$opcion." ,";
    	}
        $sql_reporte_e = "SELECT
Sum(if(ins_detalle.id_aceptado=-1,1,0)) /(count(ins_detalle.id_noaplica))*100 AS nivaceptren,
cue_reactivos.r_descripcionesp,
cue_reactivos.r_descripcioning,concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo) as ref
FROM
ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
Inner Join tmp_estadistica ON ins_detalle.id_numreporte = tmp_estadistica.numreporte
where 
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo) in (".substr($listasec,0,strlen($listasec)-1).")
and id_noaplica>-1 and tmp_estadistica.usuario=:usuario 
    and ins_detalle.id_claveservicio=:vserviciou
group by ins_detalle.id_numseccion,
ins_detalle.id_numreactivo;";
        $parametros = array("vserviciou" => $this->vservicio, "usuario" => $usuario);
        $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e, $parametros);

        //$res = 0;
        foreach ($rs_sql_reporte_e as $row_rs_sql_reporte_e) {
            //$chart [ 'chart_data' ][ 2][ 0 ] = "aqui";
            if ($_SESSION["idiomaus"] == 2)
                $res [0] = $row_rs_sql_reporte_e ['r_descripcioning'];
            else {
                $res [0] = $row_rs_sql_reporte_e ['r_descripcionesp'];
            }
            $res [1] = "";
            $res [2] = Utilerias::redondear2($row_rs_sql_reporte_e ['nivaceptren'],1);
            $res[3] = $row_rs_sql_reporte_e ['ref'];
            $resultados[]=$res;
        }
        
        return $resultados;
    }

    /*     * ***********************para jarabes ***************************** */

    function cumplimientoProducto($sec, $usuario) {
    	foreach($sec as $opcion){
    		$listasec.=$opcion." ,";
    	}
        $sql_reporte_e = "SELECT
(((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))) AS NIVELACEPTACION,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,ins_detalleproducto.ip_numseccion as secc
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE
	 ins_detalleproducto.ip_numseccion in (".substr($listasec,0,strlen($listasec)-1).")
AND ins_detalleproducto.ip_sinetiqueta=0  and tmp_estadistica.usuario=:usuario 
    and ins_detalleproducto.ip_claveservicio=:vserviciou
GROUP BY
ins_detalleproducto.ip_numseccion
ORDER BY `ins_detalleproducto`.`ip_numseccion` ASC, `ins_detalleproducto`.`ip_numreporte` ASC";
        $parametros = array("vserviciou" => $this->vservicio,  "usuario" => $usuario);
        $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e, $parametros);
        //$res = 0;
        foreach ($rs_sql_reporte_e as $row_rs_sql_reporte_e) {
            //$chart [ 'chart_data' ][ 2][ 0 ] = "aqui";
            if ($_SESSION["idiomaus"] == 2)
                $res [0] = $row_rs_sql_reporte_e ['sec_descripcioning'];
            else
                $res [0] = $row_rs_sql_reporte_e ['sec_descripcionesp'];
            $res [1] = "<10 " . strtoupper(T_("semanas"));
            $res [2] = Utilerias::redondear2($row_rs_sql_reporte_e ['NIVELACEPTACION'],1);
            $res[3] = $row_rs_sql_reporte_e ['secc'];
            $resultados[]=$res;
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
from cue_reactivosestandardetalle inner join cue_reactivosestandar on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion
and cue_reactivosestandar.r_numreactivo=cue_reactivosestandardetalle.r_numreactivo and cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente 
and cue_reactivosestandar.re_numcaracteristica=cue_reactivosestandardetalle.re_numcaracteristica and cue_reactivosestandar.re_numcomponente2=cue_reactivosestandardetalle.re_numcomponente2
where red_grafica=-1
and cue_reactivosestandar.ser_claveservicio=:vserviciou
 and concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente)=:referencia;";

        //
        //and cue_reactivosestandardetalle.r_numreactivo=0 and
        //cue_reactivosestandardetalle.re_numcomponente=2;";
$parametros=array("vserviciou"=>$this->vservicio,"referencia"=>$referencia);
        $i = 0;
        $result = Conexion::ejecutarQuery($sql,$parametros);
        foreach ($result as $row) {
            $secciones [$i++] = $row [0] . '.' . $row [1] . '.' . $row [2] . '.' . $row [3];
        }
        return $secciones;
    }
    public function encabezaConsulta(){
    	
    	
    	
    	$vclienteu=1;
    	$vserviciou=1;
    	$cuenta=$_SESSION["fcuenta"];
    	
    	if ($cuenta != 0) {
    		$this->cuenta=DatosCuenta::nombreCuenta(intval($cuenta), intval($vclienteu));
    		
    		
    	} else
    		$this->cuenta=T_('TODAS') ;
   
    		$periodo=$_SESSION["fperiodo"];
    		$this->periodo=$periodo ;
    		$this->fecha_cons=strtoupper(date ( 'd-M-Y', time () ) );
    		$unidadnegocio=$_SESSION["fpuntov"];
    		$filtros = array('unidadneg', "franquicia", "region", "zona", "cedis");
    		
    		if ($_SESSION["ftipomerc"])
    			$this->tipomerc= T_('TIPO MERCADO').': ' . $_SESSION["ftipomerc"];
    			if ($_SESSION["ffrancuenta"])
    				$this->franquiciacta= T_('FRANQUICIA CUENTA').': ' . $_SESSION["ffrancuenta"];
    			$this->filtrosNivel="";
    			$i=1;
    			foreach ($filtros as $fil) {
    				if(($i-1)%2==0){
    					$this->filtrosNivel.='<div class="row">';
    					$bac=0;
    				}
    				
    					$this->filtrosNivel.=Utilerias::creaFiltro($fil);
    				
    				if(($i)%2==0){
    					
    					$this->filtrosNivel.= '</div>';
    					$bac=1;
    				}
    				$i++;
    			}
    	
    				if($unidadnegocio!=""&&$unidadnegocio>0)
    				{
    					$query_une="SELECT ca_unegocios.une_descripcion FROM ca_unegocios
	 where ca_unegocios.cli_idcliente='" . $vclienteu . "' and
ca_unegocios.ser_claveservicio='" . $vserviciou . "' and
ca_unegocios.cue_clavecuenta= '" . $cuenta . "' and
ca_unegocios.une_claveunegocio=".$unidadnegocio.";";
    					
    					
    					
    					$this->NOMPTO_VTA='<div>PUNTO DE VENTA: '.DatosUnegocio::nombrePV($unidadnegocio).'</div>';
    				}
    }
    function getFiltros_indi() {
        return $this->filtros_indi;
    }

    function getLista_tablas() {
        return $this->lista_tablas;
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

    function getEstilo_accrap() {
        return $this->estilo_accrap;
    }

    function getLb_Promedio_resultados() {
        //<div class="box box-header" >
        return $this->lb_Promedio_resultados;
    }

  
	/**
	 * @return string
	 */
	public function getTotal_res() {
		return $this->total_res;
	}

	
	
	/**
	 * @return string
	 */
	public function getFiltrosNivel() {
		return $this->filtrosNivel;
	}

	/**
	 * @return mixed
	 */
	public function getPeriodo() {
		return $this->periodo;
	}
	
	/**
	 * @return string
	 */
	public function getFecha_cons() {
		return $this->fecha_cons;
	}
	
	/**
	 * @return string
	 */
	public function getTipomerc() {
		return $this->tipomerc;
	}
	
	/**
	 * @return string
	 */
	public function getFranquiciacta() {
		return $this->franquiciacta;
	}
	
	/**
	 * @return string
	 */
	public function getNOMPTO_VTA() {
		return $this->NOMPTO_VTA;
	}
	/**
	 * @return Ambigous <number, unknown>
	 */
	public function getVservicio() {
		return $this->vservicio;
	}

	/**
	 * @return Ambigous <number, unknown>
	 */
	public function getVcliente() {
		return $this->vcliente;
	}

	/**
	 * @return mixed
	 */
	public function getMes_asig() {
		return $this->mes_asig;
	}

	/**
	 * @return Ambigous <unknown, mixed>
	 */
	public function getPtv() {
		return $this->ptv;
	}

	/**
	 * @return mixed
	 */
	public function getTit_secciones() {
		return $this->tit_secciones;
	}

	/**
	 * @return Ambigous <string, PDOStatement>
	 */
	public function getCuenta() {
		return $this->cuenta;
	}

	
	




}
