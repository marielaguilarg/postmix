<?php


include "Models/crud_temporales.php";
class GenerarBusquedaController {

 
    private $vserviciou;
    private $vclienteu;
 
    private $filtrosSel;
    private $select1;
    private $select2;
    private $select3;
    private $select4;
    private $select5;
    private $select6;
    private $mensaje;
  

   
    public function generarBusquedaRes() {
        $maxte=ini_get('max_execution_time');
ini_set('max_execution_time',400);
        try {
        
            if ($_GET) {
                $keys_post = array_keys($_GET);
                foreach ($keys_post as $key_post) {
                    $$key_post = filter_input(INPUT_GET, $key_post, FILTER_SANITIZE_SPECIAL_CHARS);
                    //error_log("variable $key_post viene desde $ _POST");
                  
                }
            }
            $historico = $_SESSION["historico"];
            if(!isset($mes)){
            	
            	$mes=$_GET["mes"];
            	$filx=$_GET["filx"];
            	$filuni=$_GET["filuni"];
            	$fily=$_GET["fily"];
            }
            $this->filtrosSel = new ConsultaIndicadores;
            $this->vserviciou = $_SESSION["servicioind"];
            $this->vclienteu =$_SESSION["clienteind"];
// crear periodo de acuerdo a mes asig y periodo
	
            $mesasig = $mes;
            $aux = explode('.', $mes);
            $mes = $aux[0];
            $fmes_consulta = $aux[1] . "-" . $aux[0] . "-01";
            $mes_consulta_ant = ($aux[1] - 1) . "-" . $aux[0] . "-01";
            $peraux = explode(".", $per); //llega periodo si es x mes 6 o12 meses

            if (!strpos($per, ".")) {
                if ($per == 1) //mes
                    $peraux[0] = 1;
                else
                if ($per == 2) //6meses
                    $peraux[1] = 1;
                else
                if ($per == 3) //12 meses
                    $peraux[2] = 1;
            }

            if ($peraux[0] == 1) { //mes actual
                $fechaasig_i = $mesasig;
                $fechaasig_fin = $mesasig;
            } else
            if ($peraux[1] == 1) {
                if ($mes - 6 >= 0) { // calculo para los 6m
                    $z = $mes - 6 + 1;

                    $fechaasig_i = $z . "." . $aux[1];
                } else {
                    $z = 7 + $mes;

                    $fechaasig_i = $z . "." . ($aux[1] - 1);
                }
                $fechaasig_fin = $mesasig;
            } else
            if ($peraux[2] == 1) {
                // $fechaasig_i = ($aux[0]+1) . ".". ($aux[1] - 1) ;

                $fecha_cambiada = mktime(0, 0, 0, $aux[0] - 11, '01', $aux[1]);


//die($fecha);//Devuelve: 01/12/2003

                $fechaasig_i = date("m.Y", $fecha_cambiada);
                $fechaasig_fin = $mesasig;
            } else {
                // $fechaasig_i = $mesasig;
                //if($admin!="grafica2")  $peraux[2]=1;
                $fecha_cambiada = mktime(0, 0, 0, $aux[0] - 11, '01', $aux[1]);


//die($fecha);//Devuelve: 01/12/2003

                $fechaasig_i = date("m.Y", $fecha_cambiada);
                $fechaasig_fin = $mesasig;
            }
            if ($action == "indindicadores") {
                // $fechaasig_i = ($aux[0]+1) . ".". ($aux[1] - 1) ;

                $fecha_cambiada = mktime(0, 0, 0, $aux[0] - 11, '01', $aux[1]);


//die($fecha);//Devuelve: 01/12/2003

                $fechaasig_i = date("m.Y", $fecha_cambiada);
               //   die($fechaasig_i);
                $fechaasig_fin = $mesasig;
            }

// filtros de nivel y cta
            $gfilx = $filx;
            $gfiluni = $filuni;
            $gfily = $fily;
            $aux = explode(".", $gfilx);

    

            $this->select4 = $aux[0];

            $this->select5 = $aux[1];

            $this->select6 = $aux[2];
            $auxy = explode(".", $gfily);

            $cuenta = $auxy[0];

            $franquiciacta = $auxy[1];
            $unidadnegocio = $auxy[2];
            $auxuni = explode(".", $gfiluni);
            $this->select1 = $auxuni[0];
            $this->select2 = $auxuni[1];
            $this->select3 = $auxuni[2];
          
//arma la fecha de inicio
//reinicio variables de sesion para filtros
            $_SESSION["ffrancuenta"] = "";
            $_SESSION["fcuenta"] = "";
            $_SESSION["fperiodo"] = "";
            $_SESSION["fpuntov"] = "";
            $_SESSION["fnumrep"] = "";
            $_SESSION["ftipomerc"] = "";
            $_SESSION["funidadneg"] = "";
            $_SESSION["ffranquicia"] = "";
            $_SESSION["fregion"] = "";
            $_SESSION["fzona"] = "";
            $_SESSION["fcedis"] = "";
            $_SESSION["prin"] = "";
            if (isset($ptv) && $ptv != "")
                $unidadnegocio = $ptv;
       //  die($_SESSION["UsuarioInd"]);
            $Usuario = $_SESSION["UsuarioInd"];

            
            $sql_del_us = "delete from tmp_estadistica WHERE tmp_estadistica.usuario =:Usuario";
//	echo "<br>3".$sql_porcuenta;
            $parametros = array("Usuario" => $Usuario);
            $rs_sql_us = DatosTemporales::eliminarEstadistica($Usuario);

            /* creo consulta  generica */
            $sql_porcuenta = "insert into tmp_estadistica (usuario, numreporte,mes_asignacion)
select :Usuario, ins_generales.i_numreporte, str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')
from (ins_generales inner join ca_unegocios on  
 ins_generales.i_unenumpunto=ca_unegocios.une_id)
inner join ca_cuentas on  ca_cuentas.cue_id=ca_unegocios.cue_clavecuenta
where    ins_generales.i_claveservicio=:vserviciou";
            $parametros = array("vserviciou" => $this->vserviciou, "Usuario" => $Usuario);
            if ($cuenta != 0) {
                $sql_porcuenta .= " AND ca_unegocios.cue_clavecuenta=:cuenta  ";
                $parametros["cuenta"] = $cuenta;
            }

            if ($franquiciacta != 0) {
                $sql_porcuenta .= " AND fc_idfranquiciacta=:franquiciacta";
                $parametros["franquiciacta"] = $franquiciacta;
                //busco nombre de la franquicia para guardarlo

                $_SESSION["ffrancuenta"] = DatosFranquicia::nombreFranquicia($cuenta, $franquiciacta, $this->vclienteu, $this->vserviciou);
            }

            if ($unidadnegocio != 0) {
                $sql_porcuenta .= " and ins_generales.i_unenumpunto=:unidadnegocio";
                $parametros["unidadnegocio"] = $unidadnegocio;
            }
// validamos los niveles de la estructura


            if ($this->select1 != 0) {
                $sql_porcuenta .= " AND une_cla_region=:select1 ";
                $parametros["select1"] = $this->select1;
            }
            if ($this->select2 != 0) {
                $sql_porcuenta .= " AND une_cla_pais=:select2  ";
                $parametros["select2"] = $this->select2;
                $_SESSION["funidadneg"] = EstadisticasController::buscaNivel(2, $this->select2);
            }
            if ($this->select3 != 0) {
                $sql_porcuenta .= " AND une_cla_zona=:select3  ";
                $parametros["select3"] = $this->select3;
                $_SESSION["ffranquicia"] = EstadisticasController::buscaNivel(3, $this->select3);
            }
            if ($this->select4 != 0) {
                $sql_porcuenta .= " AND une_cla_estado=:select4";
                $parametros["select4"] = $this->select4;
                $_SESSION["fregion"] = EstadisticasController::buscaNivel(4, $this->select4);
            }
            if ($this->select5 != 0) {
                $sql_porcuenta .= " AND une_cla_ciudad=:select5  ";
                $parametros["select5"] = $this->select5;
                $_SESSION["fzona"] = EstadisticasController::buscaNivel(5, $this->select5);
            }
            if ($this->select6 != 0) {
                $sql_porcuenta .= " AND une_cla_franquicia=:select6  ";
                $parametros["select6"] = $this->select6;
                $_SESSION["fcedis"] = EstadisticasController::buscaNivel(6, $this->select6);
            }

//modificacion del filtro de fecha se usa mes de asignacion
            if ($fechaasig_i != "") {
                //$fechainicioc = mod_fecha($fechainicio);
                $sql_porcuenta .= " AND str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaasig_i),'%d.%m.%Y')";
                $parametros["fechaasig_i"] = $fechaasig_i;
            }
            if ($fechaasig_fin != "") {
                //$fechfinc = mod_fecha($fechafin);
                $sql_porcuenta .= " AND str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechaasig_fin ),'%d.%m.%Y')";
                $parametros["fechaasig_fin"] = $fechaasig_fin;
            }

            $sql_porcuenta .= " ORDER BY i_numreporte";


////inserta reportes en la tabla temporal tmp_estadistica
            try {
//               
//                var_dump($parametros);
               Conexion::ejecutarInsert($sql_porcuenta, $parametros);
            } catch (Exception $ex) {
                echo $ex;
            }

//valido si hay mas de un reporte
//            $sqlt = "select * from tmp_estadistica WHERE tmp_estadistica.usuario = :Usuario";
////echo $sqlt;
//            $parametros2 = array("Usuario" => $Usuario);
//            $rs = Conexion::ejecutarQuery($sqlt, $parametros2);
//            $num_reg = sizeof($rs);
            /*             * ******************************************************************* */

          
if($fechaasig_fin!="")
{ $periodo = Utilerias::fecha_res($fechaasig_i) . ' ' . T_("a") . ' ' . Utilerias::fecha_res($fechaasig_fin);}
 if (isset( $this->select2) &&  $this->select2 != "0" &&  $this->select2 != "") {
            $vuni = ($this->buscaNivel(2,  $this->select2));
        }
        if (isset( $this->select3) &&  $this->select3 != "0" &&  $this->select3 != "") {
            $vzona = "-" . ($this->buscaNivel(3,  $this->select3));
        }
        if (isset( $this->select4) &&  $this->select4 != "0" &&  $this->select4 != "") {
            $vregion = "-" . ($this->buscaNivel(4,  $this->select4));
        }

//$html->asignar('vregion', buscaNivel($select1.".".$select2.".".$select3.".".$select4));
        if ( $this->select5 != "" &&  $this->select5 != "0")
            $vciudad = "- " . ($this->buscaNivel(5,  $this->select5));

        //$html->asignar('vciudad',buscaNivel($select1.".".$select2.".".$select3.".".$select4.".".$select5));
        if ( $this->select6 != "" &&  $this->select6 != "0")
            $v_nivel6 = "- " . ($this->buscaNivel(6,  $this->select6));

        // $html->asignar('v_nivel6', buscaNivel($select1.".".$select2.".".$select3.".".$select4.".".$select5.".".$select6));
        $vcuenta = ($this->buscaCuenta($cuenta));
//$html->asignar('vcuenta', buscaCuenta(100, 1, $cuenta));
        if (isset($franquiciacta) && $franquiciacta != "") {

            $vfranquicia = "- " . (DatosFranquicia::nombreFranquicia($cuenta,$franquiciacta, $this->vclienteu));
            //$html->asignar('vfranquicia', buscaFranquicia($franquiciacta));
        }
     

    
        $this->filtrosSel->setNombre_nivel($vuni . " " . $vzona . " " . $vregion . " " . $vciudad . " " . $v_nivel6);
        $this->filtrosSel->setNombre_franquicia($vcuenta . " " . $vfranquicia);
        //guardo los filtros como var de sesion
        //   $_SESSION["fperiodo"] = $periodo;
        $_SESSION["finfoarea"] = $vuni . " " . $vzona . " " . $vregion . " " . $vciudad . " " . $v_nivel6;
            $this->filtrosSel->setPeriodo($periodo);

            $_SESSION["fperiodo"] = $periodo;
            $_SESSION["fcuenta"] = $cuenta;
            $_SESSION["fpuntov"] = $unidadnegocio;
        
      //     echo "guardando el filtro".$gfiluni;
            $_SESSION["ffilx"] = $gfilx;/** filtros de niveles */
            $_SESSION["ffily"] = $gfily;  /* filtros de cuentas */
            $_SESSION["ffiluni"] = $gfiluni;

//var_dump($_SESSION);
//$_SESSION["fcompania"] =buscaNivel($select1;

            /*             * ******************************************************************** */

            if ($action == "indestadisticares"||$action == "indindicadores"){
//            // include('MENindencabezacons.php');
            	$sqlt = "select * from tmp_estadistica WHERE tmp_estadistica.usuario = :Usuario";
            	//echo $sqlt;
            	
            	$parametros2 = array("Usuario" => $_SESSION["UsuarioInd"]);
            	$rs = Conexion::ejecutarQuery($sqlt, $parametros2);
            	
            	$num_reg = sizeof($rs);
            	$_SESSION["fnumrep"] = $num_reg;
            	if ($num_reg >= 2) {  // pasa al resumen
            		return true;
            	}else return false;
             }
           else { //esta seccion es para hostorial de pv
   $sqlt = "select * from tmp_estadistica WHERE tmp_estadistica.usuario = :Usuario";
//echo $sqlt;
   
            $parametros2 = array("Usuario" => $_SESSION["UsuarioInd"]);
            $rs = Conexion::ejecutarQuery($sqlt, $parametros2);
           
            $num_reg = sizeof($rs);
            $_SESSION["fnumrep"] = $num_reg;
              if ($num_reg >= 2) {  // pasa al resumen
              	return true;
//             include ('MENencabezacons.php');
//        include ("MENresumenresultados.php");
               //     header("index.php?action=indhistorialreportes&ptv=" . $unidadnegocio . "&fily=" . $cuenta . "." . $franquiciacta);
                } else if ($num_reg == 1) {//si es uno envia al punto de venta
                    foreach($rs as $row)
                     header("index.php?action=indresultadosxrep&numrep=" . $row["numreporte"] . "&cser=" . $this->vserviciou . "&ccli=" . $this->vclienteu . "&mes=" . $mesasig);
                }
                else {
                    // envia mensaje de error
                    //echo "hay menos de dos reportes";
                    //include ("MENprincipal.php?op=Acuenta&error=1");

                    $msg = T_("ESTE ESTABLECIMIENTO AUN NO CUENTA CON REPORTES");
                    $this->mensaje = '<table width="100%" border="0"  align="center" bgcolor="#ffffff" >' .
                            '<tr><td height="30px"></td></tr><tr><td class="infocuadro" align="center">' . $msg . '</td></tr><tr><td height="30px"></td></tr>
                    <tr><td align="center"><a href="javascript:history.back();">&lt;&lt;  ' . T_("Regresar") . '  </a> </td></tr></table>';
                    //echo $msg2;
                   // $html->asignar('CONTENIDO', $msg2);
                   return false;
                }
              
            }
        } catch (Exception $ex) {
            echo "Error en estadisticasController " . $ex;
        }
    }
    
       function buscaNivel($nivel, $idnivel) {

      
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

    function getFiltrosSel() {
        return $this->filtrosSel;
    }

    function getSelect1() {
        return $this->select1;
    }

    function getSelect2() {
        return $this->select2;
    }

    function getSelect3() {
        return $this->select3;
    }

    function getSelect4() {
        return $this->select4;
    }

    function getSelect5() {
        return $this->select5;
    }

    function getSelect6() {
        return $this->select6;
    }

    function getMensaje() {
        return $this->mensaje;
    }


    
    


}
