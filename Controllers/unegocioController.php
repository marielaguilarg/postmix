<?php

class unegocioController {

private $listanivel1;
private $listanivel2;
private $listanivel3;
private $listanivel4;
private $listanivel5;
private $listanivel6;
private $nombrenivel1;
private $nombrenivel2;
private $nombrenivel3;
private $nombrenivel4;
private $nombrenivel5;
private $nombrenivel6;
private $listaFranquicias;
private $listaCuentas;
private $listaEstatus;
private $listaEstados;
private $idpv;
private $idref;
private $desuneg;
private $idpepsi;
private $idcta;
private $idnud;
private $calle;
private $numext;
private $numint;
private $mz;
private $lt;
private $col;
private $del;
private $mun;
private $edo;
private $cp;
private $ref;
private $tel;
private $numpunto;
private $cuenta;


public function vistaunegocioController() {
    $idc=$_GET["idc"];
		$page_size=100;
if (isset($_GET["pages"])) {
$pages = $_GET["pages"];
$init = ($pages - 1) * $page_size;
} else {
$init = 0;
$pages = 1;
}
		$totuneg=Datosunegocio::cuentaUnegocioModel($idc, "ca_unegocios");
$totpages = ceil($totuneg / $page_size);

if (isset($_POST["opcionuneg"])) {
$op = "%" . $_POST["opcionuneg"] . "%";
//echo $op;
$respuesta = Datosunegocio::vistaFiltroUnegocioModel($op, "ca_unegocios");
} else {
			$respuesta =Datosunegocio::vistaUnegocioModel($init,$page_size, $idc, "ca_unegocios");
}


//echo $totuneg;
foreach ($respuesta as $row => $item) {
echo '  <tr>
	                  <td>' . $item["une_id"] . '</td>
	                  <td>' . $item["une_idpepsi"] . '</td>
		                  <td>' . $item["une_idcuenta"] . '</td>
	                  <td>
	                     <a href="index.php?action=editaunegocio&referencia='.$item["une_id"].'&idc='.$idc.'">' . $item["une_descripcion"] . '</a>
	                  </td>
	                </tr>';
	            
}

          echo '
               </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">';


if ($totpages > 1) {
if (isset($pages)) {
if ($pages != 1) {
	      			echo '<li><a href="index.php?action=listaunegocio&idc='.$idc.'&pages='.($pages -1 ).'">&laquo;</a></li>';

				}
			}	
		}

		for ($i=1; $i<=$totpages;$i++){
if (isset($page)) {
if ($page == $i) {
echo $page;
} else {
						echo '<li><a href="index.php?action=listaunegocio&idc='.$idc.'&pages='.$i.'">'.$i.'</a></li>';
}
} else {
				 		echo '<li><a href="index.php?action=listaunegocio&idc='.$idc.'&pages='.$i.'">'.$i.'</a></li>';
} //IF 	
} //FOR
echo '</ul>
            </div>
          </div>
          <!-- /.box -->
        </div>
        </div>';
}


public function vistarunegocioController() {
	$page_size=100;
$sv = $_GET["sv"];
  $idcta=$_GET["idc"];
if (isset($_GET["pages"])) {
$pages = $_GET["pages"];
$init = ($pages - 1) * $page_size;
} else {
$init = 0;
$pages = 1;
}
		$totuneg=Datosunegocio::cuentaUnegocioModel($idcta,"ca_unegocios");
$totpages = ceil($totuneg / $page_size);

if (isset($_POST["opcionuneg"])) {
$op = "%" . $_POST["opcionuneg"] . "%";
//echo $op;
			$respuesta =Datosunegocio::vistaFiltroUnegocioModel($idcta, $op, "ca_unegocios");
} else {
			$respuesta =Datosunegocio::vistaUnegocioModel($init,$page_size, $idcta, "ca_unegocios");
}


foreach ($respuesta as $row => $item) {
echo '  <tr>
	                  <td>' . $item["une_id"] . '</td>
	                  <td>' . $item["une_idpepsi"] . '</td>
		                  <td>' . $item["une_idcuenta"] . '</td>
	                  <td>
	                    <a href="index.php?action=runegociodetalle&idc='.$idcta.'&un='.$item["une_id"].'&sv='.$sv.'">'.$item["une_descripcion"].'</a>
	                  </td>
	                </tr>';
	            
}  // foreach
echo '
               </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">';

#trabajemos con la paginacion
if ($totpages > 1) {
if (isset($pages)) {
if ($pages != 1) {
	      			echo '<li><a href="index.php?action=rlistaunegocio&idc='.$idcta.'&sv='.$sv.'&pages='.($pages -1 ).'">&laquo;</a></li>';

				}
			}	
		}	
			for ($i=1; $i<=$totpages;$i++){
if (isset($page)) {
if ($page == $i) {
echo $page;
} else {
						echo '<li><a href="index.php?action=rlistaunegocio&idc='.$idcta.'&sv='.$sv.'&pages='.$i.'">'.$i.'</a></li>';
}
} else {
				 		echo '<li><a href="index.php?action=rlistaunegocio&idc='.$idcta.'&sv='.$sv.'&pages='.$i.'">'.$i.'</a></li>';
} //IF 	
} //FOR
echo '</ul>
            </div>
          </div>
          <!-- /.box -->
        </div>
        </div>';
        		
	} // function


public function vistaunegocioDetalle() {
$uneg = $_GET["un"];
$serv = $_GET["sv"];
    $idc=$_GET["idc"];
$respuesta = Datosunegocio::vistaUnegocioDetalle($uneg, "ca_unegocios");
#presrenta datos de unegocio
echo '<h3 class="box-title">' . $respuesta["une_descripcion"] . '</h3>
              <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
             
               <div class="row" >
                 <div class="row" >
                   <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-text">ID PEPSI</h5>
              		<strong>' . $respuesta["une_idpepsi"] . '</strong><br>
          </div>
          <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4 border-right">
          <div class="description-block">
            <h5 class="description-text">ID CUENTA</h5>
            <strong>' . $respuesta["une_idcuenta"] . '</strong><br>
             </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
  
                 <button type="button" class="btn btn-block btn-primary" style="width: 80%"><a href="index.php?action=runegociocomp&idc='.$idc.'&uneg='.$respuesta["une_id"].'&sv='.$serv.'"> Detalle </a></button>
';
}

public function vistaReportesunegocio() {
$uneg = $_GET["un"];
$serv = $_GET["sv"];
    $idc=$_GET["idc"];
    $gpo = UsuarioController::Obten_grupo();
    //echo $gpo;
   
              
    $respuesta =Datosunegocio::ReportesUnegocio($serv, $uneg, "ins_generales");
  
foreach ($respuesta as $row => $item) {
      $numrep=$item["i_numreporte"];
echo '<div class="col-sm-4 border-right">
                  <div class="description-block">'; 
      if ($gpo=='adm') {
               echo '<strong> <a href="index.php?action=editarep&idc='.$idc.'&sv='.$serv.'&pv='.$uneg.'&nrep='.$item["i_numreporte"].'">'.$item["i_numreporte"].'</a>';
      } else {  // no es administrador
        if ($serv==3){
           
           $totsol =DatosSolicitud::cuentasolicitudModel($numrep, $serv, "sol_estatussolicitud");
            # existe solicitud?
           if ($totsol>0){
              $respuesta =DatosSolicitud::estatusSolicitudModel($numrep, $serv, "sol_estatussolicitud");
              $final=$respuesta["sol_estatussolicitud"];
              if ($final =3){
                  echo '<strong> '.$item["i_numreporte"].'</a>';
               }  else { # estatus diferente a 3
                  echo '<strong> <a href="index.php?action=editarep&sv='.$serv.'&pv='.$uneg.'&nrep='.$item["i_numreporte"].'&idc='.$idc.'">'.$numrep.'</a>';
               }  // FINAL=3 
           } else {
              echo '<strong>'.$numrep.'/SS';
                 
           }  // EXISTE SOLICITUD
        } else {   // no es servicio 3
          $final=$item["i_finalizado"];
          if ($final==1){
              
              echo '<strong>'.$numrep;
              
          }  else {
                   echo '<strong> <a href="index.php?action=editarep&sv='.$serv.'&pv='.$uneg.'&nrep='.$item["i_numreporte"].'&idc='.$idc.'">'.$numrep.'</a>';
          }  
        } // SERVICIO = 3
      }
      echo '
                   </strong><br>
                  </div>
                   </div>';
    
    } // foreach  

 
     
	
}

public function vistaunegocioCompleta() {
$uneg = $_GET["uneg"];
//echo $uneg;

$respuesta = Datosunegocio::UnegocioCompleta($uneg, "ca_unegocios");

$nivel1 = $respuesta["une_cla_region"];
$nivel2 = $respuesta["une_cla_pais"];
$nivel3 = $respuesta["une_cla_zona"];
$nivel4 = $respuesta["une_cla_estado"];
$nivel5 = $respuesta["une_cla_ciudad"];
$nivel6 = $respuesta["une_cla_franquicia"];



echo '<div class="form-group col-md-12">
                  <label>NOMBRE</label>
                  <br>' .
$respuesta["une_descripcion"] . '
                </div>
                <div class="form-group col-md-4">
                  <label>ID PEPSI</label><br>' .
$respuesta["une_idpepsi"] . '
                </div>
                <div class="form-group col-md-4">
                  <label>ID CUENTA</label><br>' .
$respuesta["une_idcuenta"] . '
                </div>
                <div class="form-group col-md-4">
                  <label>NUD</label><br>' .
$respuesta["une_num_unico_distintivo"] . '
                </div>

                <br>
               <div class="col-md-12">
                <h4>DIRECCIÓN</h4>
                </div>
               <div class="form-group col-md-12">
                  <label>CALLE</label><br>' .
$respuesta["une_dir_calle"] . '

                </div>
                
               <div class="form-group col-md-3">
                  <label>NUM. EXTERIOR</label><br>' .
$respuesta["une_dir_numeroext"] . '
                </div>
                
                
                <div class="form-group col-md-3">
                  <label>NUM. INTERIOR</label><br>' .
$respuesta["une_dir_numeroint"] . '
                </div>
				
                <div class="form-group col-md-3">
                  <label>MANZANA</label><br>' .
$respuesta["une_dir_manzana"] . '
                </div>
                <div class="form-group col-md-3">
                  <label>LOTE</label><br>' .
$respuesta["une_dir_lote"] . '
                </div>
                <div class="form-group col-md-6">
                  <label>COLONIA</label><br>' .
$respuesta["une_dir_colonia"] . '
                </div>
                <div class="form-group col-md-6">
                  <label>DELEGACIÓN</label><br>' .
$respuesta["une_dir_delegacion"] . '
                </div>

                <div class="form-group col-md-6">
                  <label>CIUDAD</label><br>' .
$respuesta["une_dir_municipio"] . '
                </div>
                <div class="form-group col-md-6">
                  <label>ESTADO</label><br>' .
$respuesta["une_dir_estado"] . '
                </div>
                <div class="form-group col-md-3">
                  <label>C.P.</label><br>' .
$respuesta["une_dir_cp"] . '
                </div>
                <div class="form-group col-md-9">
                  <label>REFERENCIA</label><br>' .
$respuesta["une_dir_referencia"] . '
                </div>
                 <div class="form-group col-md-6">
                  <label>TELÉFONO</label><br>' .
$respuesta["une_dir_telefono"] . '
                </div>';

# buscamos nombres de las estructuras;





$nomnivel = Estructura::vistaEstructuraCompleta(1, "cnfg_estructura");

echo '<br>
                <div class="col-md-12">
                <h4>CLASIFICACIÓN</h4>
                </div>
                <div class="form-group col-md-6">
                  <label>' . $nomnivel["mee_descripcionnivelesp"] . '</label><br>';

$datnivel = Datosnuno::vistaN1opcionModel($respuesta["une_cla_region"], "ca_nivel1");

echo $datnivel["n1_nombre"] . '
                 
                </div>
                <div class="form-group col-md-6">';
$nomnivel = Estructura::vistaEstructuraCompleta(2, "cnfg_estructura");
echo
'<label>' . $nomnivel["mee_descripcionnivelesp"] . '</label><br>';

$datnivel = Datosndos::vistaN2opcionModel($respuesta["une_cla_pais"], "ca_nivel2");

echo $datnivel["n2_nombre"] . '
                	
                </div>
                <div class="form-group col-md-6">';

$nomnivel = Estructura::vistaEstructuraCompleta(3, "cnfg_estructura");
echo
'<label>' . $nomnivel["mee_descripcionnivelesp"] . '</label><br>';

$datnivel = Datosntres::vistaN3opcionModel($respuesta["une_cla_zona"], "ca_nivel3");

echo $datnivel["n3_nombre"] . '
                </div>
                <div class="form-group col-md-6">';

$nomnivel = Estructura::vistaEstructuraCompleta(4, "cnfg_estructura");
echo
'<label>' . $nomnivel["mee_descripcionnivelesp"] . '</label><br>';
$datnivel4 = Datosncua::vistaN4opcionModel($respuesta["une_cla_estado"], "ca_nivel4");

echo $datnivel4["n4_nombre"] . '
                </div>

                <div class="form-group col-md-6">';
$nomnivel = Estructura::vistaEstructuraCompleta(5, "cnfg_estructura");
echo
'<label>' . $nomnivel["mee_descripcionnivelesp"] . '</label><br>';

$datnivel5 = Datosncin::vistancinOpcionModel($nivel5, "ca_nivel5");
if (isset($datnivel5["n5_nombre"])) {
$opcioncinco = $datnivel5["n5_nombre"];
} else {
$opcioncinco = "";
}
echo $opcioncinco . '
                </div>
                <div class="form-group col-md-6">';


$nomnivel = Estructura::vistaEstructuraCompleta(6, "cnfg_estructura");
echo
'<label>' . $nomnivel["mee_descripcionnivelesp"] . '</label><br>';
$datnivel6 = Datosnsei::vistanseiOpcionModel($nivel6, "ca_nivel6");
if (isset($datnivel6["n6_nombre"])) {
$opcionseis = $datnivel6["n6_nombre"];
} else {
$opcionseis = "";
}
echo $opcionseis . '
				
                </div>';



	}	

public function vistanomRservDet(){
    $datosController = $_GET["sv"];
    $idc = $_GET["idc"];
    $un=$_GET["uneg"];
    $respuesta = DatosSeccion::vistaNombreServModel($datosController,"ca_servicios");
    echo '<li><a href="index.php?action=runegociodetalle&idc='.$idc.'&sv='.$datosController.'&un='.$un.'">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
  //}
}



public function registroUnegocioController() {

if (isset($_POST["desuneg"])) {

foreach ($_POST as $nombre_campo => $valor) {

$datosController[$nombre_campo]= filter_input(INPUT_POST,$nombre_campo, FILTER_SANITIZE_STRING);

}

if(isset($datosController["idpv"]))
    $respuesta= DatosUnegocio::actualizarUnegocio($datosController, "ca_unegocios");
        
else
$respuesta = DatosUnegocio::registrarUnegocio($datosController, "ca_unegocios");

            if ($respuesta == "success") {

                //echo '<script> windows.location= "index.php?action=ok" </script>';
                echo "
          <script type='text/javascript'>
              window.location.href='index.php?action=ok';
              </script>
                ";
                //header("location:index.php?action=ok");
            } else {
                echo '<script> windows.location= "index.php?index.php" </script>';
            }
}
}

public function vistaNuevoUnegocio() {

$this->cuenta= filter_input(INPUT_GET,"refer",FILTER_SANITIZE_NUMBER_INT);
$rs_fran = DatosFranquicia::vistaFranquiciasModel("ca_franquicias");

foreach ($rs_fran as $row_fran) {
//            if ($row_fran[0] == $franqcuenta)
//                $this->listaFranquicias[] = "<option value='" . $row_fran[0] . "' selected='selected' >" . $row_fran[1] . "</option>";
//            else
$this->listaFranquicias[] = "<option value='" . $row_fran[0] . "' >" . $row_fran[1] . "</option>";
}



$rs = Datosnuno::vistan1Model("ca_nivel1");
foreach ($rs as $row) {
//            if ($row["n1_id"] == $clanivel1) {
//                $this->listanivel1[] = "<option value='" . $row["reg_clave"] . "' selected='selected'>" . $row["reg_nombre"] . "</option>";
//            } else {
$this->listanivel1[] = "<option value='" . $row["n1_id"] . "'>" . $row["n1_nombre"] . "</option>";
//  }
}




// Llena lista de estados
$rs = DatosEstado::listaEstadosModel("ca_uneestados");
$this->listaEstados = null;
foreach ($rs as $row) {
$this->listaEstados[] = "<option value='" . $row["est_id"] . "'>" . $row["est_nombre"] . "</option>";
}



$rs = DatosCatalogoDetalle::listaCatalogoDetalle(46, "ca_catalogosdetalle");

$this->listaEstatus = null;
foreach ($rs as $row) {
if (($row["cad_idopcion"]) == 1) {
$this->listaEstatus[] = "<option value='" . $row["cad_idopcion"] . "' selected>" . $row["cad_descripcionesp"] . "</option>";
} else {
$this->listaEstatus[] = "<option value='" . $row["cad_idopcion"] . "'>" . $row["cad_descripcionesp"] . "</option>";
}
}
}

public function vistaEditaUnegocio() {
$idref = filter_input(INPUT_GET, "referencia", FILTER_SANITIZE_SPECIAL_CHARS);
foreach ($_POST as $nombre_campo => $valor) {
$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
eval($asignacion);
}
if ($idref) {

} else {
$idref = $clauneg;
}


$datini = SubnivelController::obtienedato($idref, 1);
$londat = SubnivelController::obtienelon($idref, 1);
$nuctar = substr($idref, $datini, $londat);



// busca estructura para alimentar variables
// busca estructura para alimentar variables

$this->nombrenivel1 = Estructura::getDescripcionNivel(1, "cnfg_estructura");
$this->nombrenivel2 = Estructura::getDescripcionNivel(2, "cnfg_estructura");
$this->nombrenivel3 = Estructura::getDescripcionNivel(3, "cnfg_estructura");
$this->nombrenivel4 = Estructura::getDescripcionNivel(4, "cnfg_estructura");
$this->nombrenivel5 = Estructura::getDescripcionNivel(5, "cnfg_estructura");
$this->nombrenivel6 = Estructura::getDescripcionNivel(6, "cnfg_estructura");


$sqlr = "select * from ca_unegocios where concat(cli_idcliente,ser_claveservicio,cue_clavecuenta,'.',une_claveunegocio)='" . $idref . "';";

$row = DatosUnegocio::UnegocioCompleta($idref, "ca_unegocios");



//$this->numpunto = $row['une_numpunto'];
// $this->estatus = $row['une_fechaestatus'];

$estatus = $row['une_estatus'];
// Llena lista de estatus
$rs = DatosCatalogoDetalle::listaCatalogoDetalle(46, "ca_catalogosdetalle");
$this->listaEstatus = null;
foreach ($rs as $rows) {
if (($rows["cad_idopcion"]) == $estatus) {
$this->listaEstatus[] = "<option value='" . $rows["cad_idopcion"] . "' selected>" . $rows["cad_descripcionesp"] . "</option>";
} else {
$this->listaEstatus[] = "<option value='" . $rows["cad_idopcion"] . "'>" . $rows["cad_descripcionesp"] . "</option>";
}
}
$this->cuenta=$row['cue_clavecuenta'];
$this->desuneg = $row['une_descripcion'];
$this->idpepsi = $row['une_idpepsi'];
$this->idcta = $row['une_idcuenta'];
$this->idnud = $row['une_num_unico_distintivo'];
$this->calle = $row['une_dir_calle'];
$this->numext = $row['une_dir_numeroext'];
$this->numint = $row['une_dir_numeroint'];

$this->mz = $row['une_dir_manzana'];
$this->lt = $row['une_dir_lote'];

$this->col = $row['une_dir_colonia'];
$this->del = $row['une_dir_delegacion'];
$this->mun = $row['une_dir_municipio'];
$this->edo = $row['une_dir_estado'];
$this->idedo = $row["une_dir_idestado"];
if (isset($franqcuenta)) {
$franqcta = $franqcuenta;
} else {
$franqcta = $row["fc_idfranquiciacta"];
}
// llena lista de franquicias
$rs_fran = DatosFranquicia::vistaFranquiciasModel("ca_franquicias");

foreach ($rs_fran as $row_fran) {


if ($row_fran[0] == $franqcta)
$this->listaFranquicias[] = "<option value='" . $row_fran[0] . "' selected='selected' >" . $row_fran[1] . "</option>";
else
$this->listaFranquicias[] = "<option value='" . $row_fran[0] . "' >" . $row_fran[1] . "</option>";
}


// Llena lista de estados
$rs = DatosEstado::listaEstadosModel("ca_uneestados");
$this->listaEstados = null;
foreach ($rs as $row_es) {
if ($this->idedo == $row_es["est_id"])
$this->listaEstados[] = "<option value='" . $row_es["est_id"] . "' selected>" . $row_es["est_nombre"] . "</option>";
else
$this->listaEstados[] = "<option value='" . $row_es["est_id"] . "' >" . $row_es["est_nombre"] . "</option>";
}
$this->cp = $row['une_dir_cp'];
$this->ref = $row['une_dir_referencia'];
$this->tel = $row['une_dir_telefono'];

// lee variables de clasificacion

$ni = 5;
$this->clanivel1 = $row['une_cla_region'];
$this->clanivel2 = $row["une_cla_pais"];
$this->clanivel3 = $row["une_cla_zona"];
$this->clanivel4 = $row['une_cla_estado'];
$this->clanivel5 = $row["une_cla_ciudad"];
$this->clanivel6 = $row["une_cla_franquicia"];
$rs = Datosnuno::vistaN1Model("ca_nivel1");
foreach ($rs as $rown) {
if ($rown["n1_id"] == $this->clanivel1) {
$this->listanivel1[] = "<option value='" . $rown["n1_id"] . "' selected='selected'>" . $rown["n1_nombre"] . "</option>";
} else {
$this->listanivel1[] = "<option value='" . $rown["n1_id"] . "'>" . $rown["n1_nombre"] . "</option>";
//  }
}
}
$this->listanivel2=$this->selectNivelController(2,$this->clanivel1,$this->clanivel2);
$this->listanivel3=$this->selectNivelController(3,$this->clanivel2,$this->clanivel3);
$this->listanivel4=$this->selectNivelController(4,$this->clanivel3,$this->clanivel4);
$this->listanivel5=$this->selectNivelController(5,$this->clanivel4,$this->clanivel5);
$this->listanivel6=$this->selectNivelController(6,$this->clanivel5,$this->clanivel6);
}

public function selectNivelJsonController() {
foreach ($_GET as $nombre_campo => $valor) {
$asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo,FILTER_SANITIZE_STRING) . "';";
eval($asignacion);
}
//$nivel = filter_input(INPUT_GET, "ni", FILTER_SANITIZE_SPECIAL_CHARS);
$res = Datosnuno::vistan1Model("ca_nivel1");
$nivel = 1;
if (isset($clanivel1)) {
$res = Datosndos::vistandosModel($clanivel1, "ca_nivel2");
$nivel = 2;
} if (isset($clanivel2)) {
$res = Datosntres::vistantresModel($clanivel2, "ca_nivel3");
$nivel = 3;
} if (isset($clanivel3)) {
$res = Datosncua::vistancuaModel($clanivel3, "ca_nivel4");
$nivel = 4;
} if (isset($clanivel4)) {
$res = Datosncin::vistancinModel($clanivel4, "ca_nivel5");
$nivel = 5;
} if (isset($clanivel5)) {
$res = Datosnsei::vistanseiModel($clanivel5, "ca_nivel6");
$nivel = 6;
}

foreach ($res as $item) {

$menu[] = array("name" => $item["n" . $nivel . "_nombre"], "value" => $item["n" . $nivel . "_id"]);
}

echo json_encode(['success' => 'true', "replacement" => "", 'menu' => $menu]);
}

public function selectNivelController($nivel,$id,$idselect) {
switch($nivel){
    case 2:

$res = Datosndos::vistandosModel($id, "ca_nivel2");
        break;
    case 3:
$res = Datosntres::vistantresModel($id, "ca_nivel3");
        break;
    case 4:
$res = Datosncua::vistancuaModel($id, "ca_nivel4");


        break;
    case 5:
$res = Datosncin::vistancinModel($id, "ca_nivel5");
        break;
case 6:
$res = Datosnsei::vistanseiModel($id, "ca_nivel6");
    break;
    default:
        $res = Datosnuno::vistaN1Model( "ca_nivel1");

}

$lista=null;

foreach ($res as $item) {
if ($idselect == $item["n" . $nivel . "_id"]) {
$lista[] = "<option value='" . $item["n" . $nivel . "_id"]. "' selected='selected'>" .  $item["n" . $nivel . "_nombre"] . "</option>";
} else {
$lista[] = "<option value='" . $item["n" . $nivel . "_id"] . "'>" .  $item["n" . $nivel . "_nombre"] . "</option>";
//  }
}}

return $lista;
}

public function listaClientesCuentas(){
    $respuesta =DatosCuenta::listaClientesModel("ca_clientes");

  foreach($respuesta as $row => $item){
       echo '<li class="treeview"><a><i class="fa fa-circle-o"></i>'.substr($item["cli_nombre"],0,15).' <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span></a>';
       echo "  <ul class=\"treeview-menu\">";
       $respcuentas= DatosCuenta::vistaCuentasxCliente($item["cli_id"],"ca_cuentas");
       foreach($respcuentas as $row2 => $item2){
            echo '<li><a href="index.php?action=nuevaunegocio&refer='.$item2["cue_id"].'"><i class="fa fa-circle-o"></i>'.substr($item2["cue_descripcion"],0,15).'</a></li>';
           
       }
       echo "</ul></li>";
       
     

    }   
     

                      
}



function getListanivel1() {
return $this->listanivel1;
}

function getListanivel2() {
return $this->listanivel2;
}

function getListanivel3() {
return $this->listanivel3;
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

function getNombrenivel1() {
return $this->nombrenivel1;
}

function getNombrenivel2() {
return $this->nombrenivel2;
}

function getNombrenivel3() {
return $this->nombrenivel3;
}

function getNombrenivel4() {
return $this->nombrenivel4;
}

function getNombrenivel5() {
return $this->nombrenivel5;
}

function getNombrenivel6() {
return $this->nombrenivel6;
}

function getListaFranquicias() {
return $this->listaFranquicias;
}

function getListaEstatus() {
return $this->listaEstatus;
}

function getListaEstados() {
return $this->listaEstados;
}

function getIdref() {
return $this->idref;
}

function getDesuneg() {
return $this->desuneg;
}

function getIdpepsi() {
return $this->idpepsi;
}

function getIdcta() {
return $this->idcta;
}

function getIdnud() {
return $this->idnud;
}

function getCalle() {
return $this->calle;
}

function getNumext() {
return $this->numext;
}

function getNumint() {
return $this->numint;
}

function getMz() {
return $this->mz;
}

function getLt() {
return $this->lt;
}

function getCol() {
return $this->col;
}

function getDel() {
return $this->del;
}

function getMun() {
return $this->mun;
}

function getEdo() {
return $this->edo;
}

function getCp() {
return $this->cp;
}

function getRef() {
return $this->ref;
}

function getTel() {
return $this->tel;
}

function getNumpunto() {
return $this->numpunto;
}

function setListanivel1($listanivel1) {
$this->listanivel1 = $listanivel1;
}

function setListanivel2($listanivel2) {
$this->listanivel2 = $listanivel2;
}

function setListanivel3($listanivel3) {
$this->listanivel3 = $listanivel3;
}

function setListanivel4($listanivel4) {
$this->listanivel4 = $listanivel4;
}

function setListanivel5($listanivel5) {
$this->listanivel5 = $listanivel5;
}

function setListanivel6($listanivel6) {
$this->listanivel6 = $listanivel6;
}

function setNombrenivel1($nombrenivel1) {
$this->nombrenivel1 = $nombrenivel1;
}

function setNombrenivel2($nombrenivel2) {
$this->nombrenivel2 = $nombrenivel2;
}

function setNombrenivel3($nombrenivel3) {
$this->nombrenivel3 = $nombrenivel3;
}

function setNombrenivel4($nombrenivel4) {
$this->nombrenivel4 = $nombrenivel4;
}

function setNombrenivel5($nombrenivel5) {
$this->nombrenivel5 = $nombrenivel5;
}

function setNombrenivel6($nombrenivel6) {
$this->nombrenivel6 = $nombrenivel6;
}

function setListaFranquicias($listaFranquicias) {
$this->listaFranquicias = $listaFranquicias;
}

function setListaEstatus($listaEstatus) {
$this->listaEstatus = $listaEstatus;
}

function setListaEstados($listaEstados) {
$this->listaEstados = $listaEstados;
}

function setIdref($idref) {
$this->idref = $idref;
}

function setDesuneg($desuneg) {
$this->desuneg = $desuneg;
}

function setIdpepsi($idpepsi) {
$this->idpepsi = $idpepsi;
}

function setIdcta($idcta) {
$this->idcta = $idcta;
}

function setIdnud($idnud) {
$this->idnud = $idnud;
}

function setCalle($calle) {
$this->calle = $calle;
}

function setNumext($numext) {
$this->numext = $numext;
}

function setNumint($numint) {
$this->numint = $numint;
}

function setMz($mz) {
$this->mz = $mz;
}

function setLt($lt) {
$this->lt = $lt;
}

function setCol($col) {
$this->col = $col;
}

function setDel($del) {
$this->del = $del;
}

function setMun($mun) {
$this->mun = $mun;
}

function setEdo($edo) {
$this->edo = $edo;
}

function setCp($cp) {
$this->cp = $cp;
}

function setRef($ref) {
$this->ref = $ref;
}

function setTel($tel) {
$this->tel = $tel;
}

function setNumpunto($numpunto) {
$this->numpunto = $numpunto;
}

function getIdpv() {
    return $this->idpv;
}
function getCuenta() {
    return $this->cuenta;
}


function getNombreSeccion() {
    return $this->nombreSeccion;
}

function getTitulopagina() {
    return $this->titulopagina;
}

function getListaCuentas() {
    return $this->listaCuentas;
}

function setListaCuentas($listaCuentas) {
    $this->listaCuentas = $listaCuentas;
}



}
?>