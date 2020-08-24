<?php
define ( 'RAIZ', "fotografias" );
class seccionController {
	public function vistanomservController() {
		$datosController = $_GET ["idser"];
		$idc = $_GET ["idc"];
		echo '<li><a href="index.php?action=listaservicio&idc=' . $idc . '"><em class="fa fa-dashboard"></em>SERVICIO: ' . $respuesta ["ser_descripcionesp"] . '</a></li>';
		// }
	}
	public function vistaNomServicioController() {
		if (isset ( $_GET ["idser"] )) {
			$numser = $_GET ["idser"];
		}
		if (isset ( $_GET ["sv"] )) {
			$numser = $_GET ["sv"];
		}
		// buscar el nombre del servicio
		$respuesta = DatosServicio::vistaNomServicioModel ( $numser, "ca_servicios" );
		echo '<li><a href="index.php?action=listaservicio">SERVICIOS</a></li>';
		
		echo '<li>SERVICIO: ' . $respuesta ["ser_descripcionesp"] . '</li>';
		// }
	}
	public function vistaNomServSeccController() {
		$numser = $_GET ["sv"];
		$numsec = $_GET ["sec"];
		// buscar el nombre del servicio
		echo '<li><a href="index.php?action=listaservicio">SERVICIOS</a></li>';
		
		$respuesta = DatosServicio::vistaNomServicioModel ( $numser, "ca_servicios" );
		echo '<li><a href="index.php?action=listaseccion&idser=' . $numser . '">SERVICIO: ' . $respuesta ["ser_descripcionesp"] . '</a></li>';
		$respuesta = DatosSeccion::vistaNombreSeccionModel ( $numsec, $numser, "cue_secciones" );
		echo '<li>SECCION: ' . $respuesta ["sec_nomsecesp"] . '</li>';
	}
	public function vistaSeccionController() {
		$numser = $_GET ["idser"];

		$respuesta = DatosSeccion::vistaSeccionModel ( $numser, "cue_secciones" );

		echo '<button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevaseccion&idser=' . $numser . '" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  NUEVO  </a></button>
     </div>
     </div>

    </section>

    <!-- Main content -->
    <section class="content container-fluid">';

		$respuesta = DatosSeccion::vistaSeccionModel ( $numser, "cue_secciones" );
$i=$bac=1;
		foreach ( $respuesta as $row => $item ) {
			if(($i-1)%3==0){
				echo '<div class="row">';
				$bac=0;
			}
			
			echo '
        <div class="col-md-4" >
          <div class="box box-info" >
            <div class="box-header with-border">
            <h3 class="box-title">No.' . $item ["sec_numseccion"] . '</h3>

              <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="arrow">
              	  <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                    <input type="hidden" name="idsereditar" value="' . $item ["sec_tiposeccion"] . '">
                      <li><a href="#"><strong>SECCION:</strong> ' . $item ["sec_nomsecesp"] . '</a></li>
                    </ul>
                </div>
                 <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                      <li><a href="index.php?action=editaseccion&id=' . $item ["sec_numseccion"] . '&sv=' . $item ["ser_claveservicio"] . '"><strong>DESCRIPCION:</strong> ' . $item ["sec_descripcionesp"] . '</a></li>
                    </ul>
                </div>
              </div>
				<div class="row col-sm-12">
			      <div class="box-footer no-padding col-sm-6">
                    <ul class="nav nav-stacked">';

			$respuesta1 = DatosSeccion::vistaPonderaModel ( $numser, "cue_secciones" );
			$cta = $respuesta1 ["cue_id"];

			echo '<li><a href="index.php?action=sn&sec=' . $item ["sec_numseccion"] . '&sv=' . $item ["ser_claveservicio"] . '&ts=SN"><strong>' . $respuesta1 ["cue_descripcion"] . ':</strong>  ';
			$datosController = array (
					"numsec" => $item ["sec_numseccion"],
					"servicio" => $numser,
					"cuenta" => $cta
			);

			$respuesta2 = DatosSeccion::vistaPonderaDetalleModel ( $datosController, "ca_cuentas" );
			if (isset ( $respuesta2 ["sd_ponderacion"] )) {
				echo $respuesta2 ["sd_ponderacion"] . '% </a></li>';
			} else {
				echo '0 % </a></li>';
			}
			echo '</ul>
                </div>
				
      <div class="box-footer no-padding col-sm-6">
                    <ul class="nav nav-stacked">
                      <li><a href="index.php?action=ponderaseccion&sec=' . $item ["sec_numseccion"] . '&sv=' . $item ["ser_claveservicio"] . '"><strong> PONDERACION  </strong>    %</a></li>
                    </ul>
                </div>
        </div>      
               <div class="row" >
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                 
                    <a class="btn btn-block btn-info" style="font-size: 12px" href="index.php?action=sn&sec=' . $item ["sec_numseccion"] . '&ts=' . $item ["sec_tiposeccion"] . '&sv=' . $item ["ser_claveservicio"] . '"> DETALLE </a>


                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                   <a class="btn btn-block btn-info" style="font-size: 12px" href="index.php?action=listacoment&sec=' . $item ["sec_numseccion"] . '&sv=' . $item ["ser_claveservicio"] . '"><i class="fa fa-comment fa-lg"></i></a>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                 <a class="btn btn-block btn-info" href="index.php?action=listaseccion&idb=' . $item ["sec_numseccion"] . '&idser=' . $item ["ser_claveservicio"] . '"
onclick="return dialogoEliminar()"><i class="fa fa-trash-o"></i></a>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div> 
                   </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
       
        
    </div>';
			if(($i)%3==0){
				
				echo '</div>';
				$bac=1;
			}
			$i++;
		} //fin foreach
		if($bac==0)
			echo '</div>';
	}
	public function editarSeccionController() {
		$datosController = $_GET ["id"];
		$idservicio = $_GET ["sv"];
		$respuesta = DatosSeccion::editaSeccionModel ( $datosController, $idservicio, "cue_secciones" );

		echo '<div class="form-group col-md-6">
          <input type="hidden" name="idsersec" value="' . $respuesta ["ser_claveservicio"] . '">
          <input type="hidden" name="idseced" value="' . $respuesta ["sec_numseccion"] . '">
           <label>NOMBRE DE SECCION EN ESPAÑOL</label>
           <input type="text" class="form-control" name="nomesp" value="' . $respuesta ["sec_nomsecesp"] . '" required>
           </div>
           <div class="form-group col-md-6">
           <label>NOMBRE DE SECCION EN INGLES</label>
           <input type="text" class="form-control" name="noming" value="' . $respuesta ["sec_nomsecing"] . '" required>
          </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN ESPAÑOL</label>
           <input type="text" class="form-control" name="desesp" value="' . $respuesta ["sec_descripcionesp"] . '" required>
           </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN INGLES</label>
           <input type="text" class="form-control" name="desing" value="' . $respuesta ["sec_descripcioning"] . '" required>
           </div>
           <div class="form-group col-md-6">
          <label>ORDEN MENU INDICADORES</label>
           <input type="text" class="form-control" name="ordensec" value="' . $respuesta ["sec_ordsecind"] . '" >
           
          </div>
          <div class="form-group col-md-6">
          <label>MANEJA MUESTRAS DE AGUA</label></div>';

		IF ($respuesta ["sec_indagua"]) {
			$indagua = 'checked="checked"';
		} else {
			$indagua = '';
		}

		echo '
           <div class="form-group col-md-6">
           <input type="checkbox" name="indmues" id="indmues" ' . $indagua . ' />
            </div> 
           <div class="box-footer col-md-12">
   <div class="pull-right">   
 <button type="submit" class="btn btn-info">GUARDAR</button>  
                
                  <a  class="btn btn-default" style="margin-left: 10px" href="index.php?action=listaseccion&idser=' . $respuesta ["ser_claveservicio"] . '"> CANCELAR </a>
              </div>  
  </div>';
	}
	public function actualizarSeccionController() {
		// echo "entre a actualizar cuenta controller";
		if (isset ( $_POST ["nomesp"] )) {
			if (isset ( $_POST ["indmues"] )) {
				$indagua =  1;
			} else {
				$indagua = 0;
			}
			$datosController = array (
					"idsec" => $_POST ["idseced"],
					"idser" => $_POST ["idsersec"],
					"nomesp" => $_POST ["nomesp"],
					"noming" => $_POST ["noming"],
					"desesp" => $_POST ["desesp"],
					"desing" => $_POST ["desing"],
					"ordensec" => $_POST ["ordensec"],
					"indagua" => $indagua
			);

			$respuesta = DatosSeccion::actualizarSeccionModel ( $datosController, "cue_secciones" );
			echo $respuesta;
			// if($respuesta=="success"){
			echo "
            <script type='text/javascript'>
              window.location='index.php?action=listaseccion&idser=" . $_POST ["idsersec"] . "'
                </script>
                  ";
			// } else {
			// echo "error";
			// }
		}
	}
	public function botonRegresaSeccionController() {
		$datosController = $_GET ["idser"];
		echo ' <a  class="btn btn-default" style="margin-left: 10px" href="index.php?action=listaseccion&idser=' . $datosController . '"> CANCELAR </a>';
	}
	public function nuevaSeccionController() {
		$datosController = $_GET ["idser"];

		echo '<input type="hidden" name="idsersec" value="' . $datosController . '">';
	}
	public function registrarSeccionController() {
		// echo "entre a actualizar cuenta controller";
		if (isset ( $_POST ["nomesp"] )) {
			if (isset ( $_POST ["indmues"] )) {
				$indagua =  1;
			} else {
				$indagua = 0;
			}
			$datosServicio = $_POST ["idsersec"];

			$numsec = DatosSeccion::CalculaultimaSeccionModel ( $datosServicio, "cue_secciones" );
			// echo $numsec;
			$nsec = + $numsec ["ulnumsec"] + 1;
			// echo $nsec;
			$datosController = array (
					"idser" => $_POST ["idsersec"],
					"idsec" => $nsec,
					"nomesp" => $_POST ["nomesp"],
					"noming" => $_POST ["noming"],
					"desesp" => $_POST ["desesp"],
					"desing" => $_POST ["desing"],
					"ordensec" => $_POST ["ordensec"],
					"indagua" => $indagua
			);

			$respuesta = DatosSeccion::registrarSeccionModel ( $datosController, "cue_secciones" );
			// echo $respuesta;
			if ($respuesta == "success") {
				echo "
            <script type='text/javascript'>
              window.location='index.php?action=listaseccion&idser=" . $datosServicio . "'
                </script>
                  ";
			} else {
				echo "error";
			}
		}
	}
	public function borrarSeccionController() {
		if (isset ( $_GET ["idb"] )) {
			$datosController = $_GET ["idb"];
			$servicioController = $_GET ["idser"];

			$respuesta = DatosSeccion::borrarSeccionModel ( $datosController, $servicioController, "cue_secciones" );
		}
	}
	public function iniciopoderaseccion() {
		$ser = $_GET ["sv"];
		$sec = $_GET ["sec"];

		echo '<section class="content-header">
      <h1>Ponderacion de Secciones <small></small></h1>
      <ol class="breadcrumb" >';
		// buscar el nombre del servicio
		$respuesta = DatosServicio::vistaNomServicioModel ( $ser, "ca_servicios" );

		echo '<li><a href="index.php?action=listaservicio">SERVICIO: ' . $respuesta ["ser_descripcionesp"] . '</a></li>';
		// busco seccion
		$respuesta = DatosSeccion::vistaNombreSeccion ( $ser, $sec, "cue_secciones" );
		// var_dump($respuesta);
		echo '<li><a href="index.php?action=listaseccion&idser=' . $ser . '">SECCION: ' . $respuesta ["sec_descripcionesp"] . '</a></li>';
		echo '        
</ol>
 </section>';

		echo '
  <div class="row">
      <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevaponcuenta&id=' . $sec . '&ids=' . $ser . '" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
       </div>
       </div>';

		echo '<input type="hidden" name="idsec" value="' . $sec . '">';
		echo '<input type="hidden" name="idser" value="' . $ser . '">';
	}
	public function vistapoderaseccion() {
		$ser = $_GET ["sv"];
		$sec = $_GET ["sec"];

		$respuesta = DatosSeccion::vistaPonderacionDetalleModel ( $sec, $ser, "cue_seccionesdetalles" );
		// echo $respuesta;

		foreach ( $respuesta as $row => $item ) {
			echo '  <tr>
                <td>' . $item ["sd_clavecuenta"] . '</td>';

			$respuesta1 = DatosSeccion::vistaCuentasPonderacionModel ( $item ["sd_clavecuenta"], "ca_cuentas" );
			echo '
                <td><a href="index.php?action=sn&sec=&sv=' . $ser . '&ts=ED">' . $respuesta1 ["cue_descripcion"] . '</a>
                </td>
                <td>' . $item ["sd_ponderacion"] . '
                </td>';

			$fecini = SubnivelController::cambiaf_a_normal ( $item ["sd_fechainicio"] );
			$fecfin = SubnivelController::cambiaf_a_normal ( $item ["sd_fechafinal"] );
			echo '
                <td>' . $fecini . '
                </td>
                <td>' . $fecfin . '
                </td>
                
                 <td><a href="index.php?action=ponderaseccion&idb=' . $item ["sd_clavecuenta"] . '&sv=' . $ser . '&sec=' . $sec . '">borrar</a>
                </td>
                  </tr>';
		} // foreach

		echo ' </table>
            </div>
           </div>';
	}
	public function borrarSeccionPonderaController() {
		if (isset ( $_GET ["idb"] )) {
			$datosController = $_GET ["idb"];
			$servicioController = $_GET ["sv"];
			$seccion = $_GET ["sec"];

			$respuesta = DatosSeccion::borrarSeccionPonderaModel ( $datosController, $seccion, $servicioController, "cue_seccionesdetalles" );
		}
	}
	public function vistaseccioncoment() {
		$ser = $_GET ["sv"];
		$sec = $_GET ["sec"];

		$respuesta = DatosSeccion::vistaSeccionComentModel ( $sec, $ser, "cue_seccioncomentario" );

		foreach ( $respuesta as $row => $item ) {
			echo '  <tr>
                <td>' . $item ["sec_numcoment"] . '</td>

                <td><a href="index.php?action=editacoment&id=' . $sec . '.' . $item ["sec_numcoment"] . '&ids=' . $ser . '&sec=' . $sec . '">' . $item ["sec_comentesp"] . '</a>
                </td>
                
                 <td><a href="index.php?action=listacoment&idb=' . $item ["sec_numcoment"] . '&sv=' . $ser . '&sec=' . $sec . '">borrar</a>
                </td>
              </tr>';
		} // foreach
		echo ' </table>
            </div>
           </div>';
	}
	public function botonnuevocoment() {
		$ser = $_GET ["sv"];
		$sec = $_GET ["sec"];

		echo '
    <div class="row">
      <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevocoment&id=' . $sec . '&ids=' . $ser . '" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
       </div>
       </div>';
	}
	public function botonRegresaComentarioController() {
		$ids = $_GET ["ids"];
		$id = $_GET ["id"];

		echo ' <a  class="btn btn-default" style="margin-left: 10px" href="index.php?action=listacoment&sec=' . $id . '&sv=' . $ids . '"> CANCELAR </a>
  ';
	}
	public function botonRegresaEditComentario() {
		$ids = $_GET ["ids"];
		$id = $_GET ["sec"];

		echo ' <a  class="btn btn-default" style="margin-left: 10px" href="index.php?action=reactivocoment&sec=' . $id . '&sv=' . $ids . '"> CANCELAR </a>
  ';
	}
	public function nuevaComentController() {
		$datosController = $_GET ["id"];
		$servicioController = $_GET ["ids"];

		echo '<input type="hidden" name="idsec" value="' . $datosController . '">';
		echo '<input type="hidden" name="idser" value="' . $servicioController . '">';
	}
	public function inicioEditComentController() {
		$datosController = $_GET ["id"];
		$servicioController = $_GET ["ids"];
		$sec = $_GET ["sec"];

		echo '<input type="hidden" name="idsec" value="' . $datosController . '">';
		echo '<input type="hidden" name="idser" value="' . $servicioController . '">';
		echo '<input type="hidden" name="sec" value="' . $sec . '">';
	}
	public function registrarComentController() {
		// echo "entre a actualizar el comentario
		if (isset ( $_POST ["descesp"] )) {
			$servicio = $_POST ["idser"];
			$seccion = $_POST ["idsec"];
			$descesp = $_POST ["descesp"];
			$descing = $_POST ["descing"];

			$datosModel = $servicio . '.' . $seccion;
			$respuesta = DatosSeccion::CalculaultimoComentModel ( $datosModel, "cue_seccioncomentario" );
			// echo $numsec;
			if (isset ( $respuesta ["clave"] )) {
				$i = 0;
				foreach ( $respuesta as $row => $item ) {
					$i = $i + 1;
				}
			}
			// echo $i;

			// if ($i>0) {
			// foreach($respuesta as $row => $item){
			$numcom = $respuesta ["clave"];
			// }
			// } else {
			// $numcom=0;
			// }
			$numcom = $numcom + 1;
			// echo $numcom;
			$datosController = array (
					"idser" => $servicio,
					"idsec" => $seccion,
					'numcom' => $numcom,
					"nomesp" => $descesp,
					"noming" => $descing
			);

			$respuesta = DatosSeccion::registrarComentSeccionModel ( $datosController, "cue_seccioncomentario" );

			if ($respuesta == "success") {
				echo "
            <script type='text/javascript'>
              window.location.href='index.php?action=listacoment&sv=" . $servicio . "&sec=" . $seccion . "
                </script>
                  ";
			} else {
				echo "error";
			}
		}
	}
	public function editarComentController() {
		$datosController = $_GET ["id"];
		$idservicio = $_GET ["ids"];

		// echo $datosController;
		// echo $idservicio;
		$respuesta = DatosSeccion::editaComentModel ( $datosController, $idservicio, "cue_seccioncomentario" );

		echo ' 
                <input type="text" class="form-control" name="descesp" value="' . $respuesta ["sec_comentesp"] . '" >
           </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN INGLES</label>
           <input type="text" class="form-control" name="descing" value="' . $respuesta ["sec_comenting"] . '" >
           </div>';
	}
	public function actualizarComentController() {
		// echo "entre a actualizar el comentario
		if (isset ( $_POST ["descesp"] )) {
			$servicio = $_POST ["idser"];
			$seccion = $_POST ["idsec"];
			$sec = $_POST ["sec"];
			$descesp = $_POST ["descesp"];
			$descing = $_POST ["descing"];

			// echo $numcom;
			$datosController = array (
					"idser" => $servicio,
					"idsec" => $seccion,
					"nomesp" => $descesp,
					"noming" => $descing
			);

			$respuesta = DatosSeccion::actualizarComentSeccionModel ( $datosController, "cue_seccioncomentario" );

			if ($respuesta == "success") {
				echo "
            <script type='text/javascript'>
              window.location.href='index.php?action=listacoment&sv=" . $servicio . "&sec=" . $sec . "
                </script>
                  ";
			} else {
				echo "error";
			}
		}
	}
	public function borrarComentarioController() {
		if (isset ( $_GET ["idb"] )) {
			$idb = $_GET ["idb"];
			$servicioController = $_GET ["sv"];
			$sec = $_GET ["sec"];
			$datosController = $sec . '.' . $idb;

			$respuesta = DatosSeccion::borrarComentModel ( $datosController, $servicioController, "cue_seccioncomentario" );
		}
	}
	public function vistaConsultaPonderaSeccionController() {
		// lee numero de seccion y numero de servicio
		if (isset ( $_POST ["idcuen"] )) {
			$cta = $_POST ["idcuen"];
			$seccion = $_POST ["idsec"];
			$servicioController = $_POST ["idser"];
		} else {
			$seccion = $_GET ["sec"];
			$servicioController = $_GET ["sv"];
		}

		$respuesta = DatosPond::buscacliente ( $servicioController, "ca_servicios" );
		$idcliente = $respuesta ["ser_idcliente"];

		$respuesta = DatosPond::consultacuentaModel ( $idcliente, "ca_cuentas" );

		echo '
</section>
<section class="content container-fluid">
			<div class="box box-body">

    <div class="col-md-6" >
    <form role="form" method="post">
  
    <div class="input-group">';
		echo '<input type="hidden" name="idsec" value="' . $seccion . '">';
		echo '<input type="hidden" name="idser" value="' . $servicioController . '">';
		echo '<select class="form-control" name="idcuen" >;
        <option value="">-- Elija la cuenta  --</option>';

		foreach ( $respuesta as $row => $item ) {
			if (isset ( $cta )) {
				if ($item ["cue_id"] == $cta) {
					echo '<option value=' . $item ["cue_id"] . '" selected="selected">' . $item ["cue_descripcion"] . '</option>';
				} else {
					echo '<option value=' . $item ["cue_id"] . '>' . $item ["cue_descripcion"] . '</option>';
				}
			} else {
				echo '<option value=' . $item ["cue_id"] . '>' . $item ["cue_descripcion"] . '</option>';
			}
		} // foreach

		// aqui va la funcion para releer los puntos de venta con el porcentaje de la cuenta seleccionada

		echo ' </select>

    
     
     <span class="input-group-btn">
                      <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>Buscar</button>
                    </span>
   
             
     </div>
     </form>';

		// crea titulo de columna ponderada
		// verifica si se ha seleccionado cuenta
		if (isset ( $cta )) {
			// lee descripcion de cuenta
			$respuesta = DatosPond::consultanomcuenta1 ( $cta, $idcliente, "ca_cuentas" );
		} else { // busca la primera cuenta
			$respuesta = DatosPond::consultanomcuenta2 ( $idcliente, "ca_cuentas" );
			$cta = $respuesta ["cue_id"];
		}

		// presenta info
		echo '
</div></div>
      <div class="box">
          <div class="box-body no-padding">
                  <table class="table" table-condensed>
                    <tr>
                      <th style="width: 5%">No.</th>
                      <th style="width: 25%">DESCRIPCION</th>
                      <th style="width: 5%">%</th>
                     <th style="width: 10%">' . $respuesta ["cue_descripcion"] . '</th>
                    </tr>';
		// busca la info
		$respuesta = DatosSeccion::vistaSeccionModel ( $servicioController, "cue_secciones" );

		$i = 1;
		foreach ( $respuesta as $row => $item ) {
			echo '  <tr>
                <td>' . $item ["sec_numseccion"] . '</td>
                <td>' . $item ["sec_nomsecesp"] . '</td>
                <td>';

			$respuesta2 = DatosSeccion::buscaponderacionseccion ( $seccion, $servicioController, $cta, "cue_seccionesdetalles" );
			// si hay ponderacion
			if (isset ( $respuesta2 ["sd_ponderacion"] )) {
				$pondcta = $respuesta2 ["sd_ponderacion"];
			} else {
				$pondcta = 0;
			}
			echo '<a href="index.php?action=ponderareactivo&sec=' . $seccion . '&sv=' . $servicioController . '"><strong>&nbsp;  %   &nbsp;&nbsp;</strong></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;';

			echo $pondcta . '</td>
                    
                </tr>';
		}

		echo ' </table>
            </div>
           </div></div>
         
</section>';
	}
	public function vistanomRservController() {
		include "Utilerias/leevar.php";
		$_SESSION ["rservicio"] = $_SESSION ["runeg"] = $_SESSION ["rcuenta"] = "";
		$datosController = $sv;
		$_SESSION ["rservicio"] = $datosController;
		$_SESSION ["runeg"] = $un;

		$idc = $idc;
		$_SESSION ["rcuenta"] = $idc;
		$respuesta = DatosSeccion::vistaNombreServModel ( $datosController, "ca_servicios" );
		echo '<li><a href="index.php?action=rlistaunegocio&idc=' . $idc . '&sv=' . $datosController . '">SERVICIO: ' . $respuesta ["ser_descripcionesp"] . '</a></li>';
		// }
	}
	public function ingresaimagen() {
		// $ser = $_GET["sv"];
		// $sec = $_GET["sec"];
		include "Utilerias/leevar.php";
		switch ($admin) {

			case "insertar" :
				$this->subeimagen ();
				break;
			case "eli" :

				$this->borrarImagen ();
				break;
			default :

				$nsol = $nrep;

				$idserv = $sv;

				$idseccion = $sec;
				$refer = $sec;
				$idreactivo = "";

				if (strpos ( $refer, "." ) > 0) {
					$datini = SubnivelController::obtienedato ( $refer, 1 );
					$londat = SubnivelController::obtienelon ( $refer, 1 );
					$idseccion = substr ( $refer, $datini, $londat );

					$datiniu = SubnivelController::obtienedato ( $refer, 2 );
					$londatu = SubnivelController::obtienelon ( $refer, 2 );
					$idreactivo = substr ( $refer, $datiniu, $londatu );
				}

				echo '
<script type="text/javascript">
//<![CDATA[
  var nW,nH,oH,oW;
  function zoomToggle(iWideSmall,iHighSmall,iWideLarge,iHighLarge,whichImage){
    oW=whichImage.style.width;oH=whichImage.style.height;
    if((oW==iWideLarge)||(oH==iHighLarge)){
      nW=iWideSmall;nH=iHighSmall;
    }else{
      nW=iWideLarge;nH=iHighLarge;
    }
    whichImage.style.width=nW;whichImage.style.height=nH;
  }
//]]>
</script>
<section class="content container-fluid">
<div class="row">
   <div class="col-md-12">
    <div class="box box-info">
    <div class="box-header with-border">ARCHIVOS</div>
    <div class="box-body">  
    <div class="row">
<div class="col-md-12">
<form  name="bform"  method="post" enctype="multipart/form-data" action="index.php?action=rsn&admin=insertar&ts=IM&nrep=' . $nsol . '"> 

   <div class="form-group">
    <input type="hidden" name="servicio" maxlength="100" value="' . $idserv . '">
   <input type="hidden" name="reporte"  maxlength="100" value="' . $nsol . '">
  <input type="hidden" name="seccion" maxlength="100" value="' . $idseccion . '"> 
 <input type="hidden" name="pv" maxlength="100" value="' . $pv . '"> 
	   <input type="hidden" name="reactivo"  maxlength="100" value="' . $idreactivo . '"> 
                     
   
   <input class="form-control-file"  type="file" name="pictures1" id="pictures1" accept="image/gif,image/jpeg,image/x-png" />
   <br /> 
   Descripci&oacute;n 1 : 
   <input type="text" name="descripcion1" id="descripcion1" class="campoTxt" size="100" maxlength="500"   />

   <br />
   No incluir en Certificado:   <input name="incluir1" type="checkbox"/><br />
<br />
<input class="form-control-file"  type="file" name="pictures2" id="pictures2" accept="image/gif,image/jpeg,image/x-png" />
   <br /> 
   Descripci&oacute;n 2 : 
   <input type="text" name="descripcion2" id="descripcion2" class="campoTxt" size="100" maxlength="500"   />

   <br />
   No incluir en Certificado:   <input name="incluir2" type="checkbox"/><br />
    <br />
   <input class="form-control-file"  type="file" name="pictures3" id="pictures3" accept="image/gif,image/jpeg,image/x-png" />
   <br /> 
   Descripci&oacute;n 3 : 
   <input type="text" name="descripcion3" id="descripcion3" class="campoTxt" size="100" maxlength="500"   />

   <br />
   No incluir en Certificado:   <input name="incluir3" type="checkbox"/><br />



</div> <div class="form-group">';
				$une = DatosUnegocio::UnegocioCompleta ( $pv, "ca_unegocios" );
				$idc = $une ["cue_clavecuenta"];

				if (isset ( $idreactivo ) && ($idreactivo != '' || $idreactivo != 0))
					$ligaReg = "index.php?action=rsn&sec=" . $idseccion . "&ts=P&sv=$sv&nrep=$nrep&pv=$pv&idc=" . $idc;
				else
					$ligaReg = 'index.php?action=editarep&sv=' . $sv . '&nrep=' . $nrep . '&pv=' . $pv . '&idc=' . $idc;
				echo '
  <button type="button" class="btn btn-default pull-right" style="margin-right: 18px"  onclick="document.location=\'' . $ligaReg . '\'" >  Cancelar  </a>
   
   <button type="submit" name="submit"  class="btn btn-info pull-right"> Guardar   </button>
        
</div> 
  </form> </div></div>       
         <div class="row">     
 
          <div class="col-md-12"> 
  <div class="box-header with-border">IMAGENES CARGADAS</div>        
      ';
				$sql = "SELECT
                   id_ruta,id_idimagen, id_descripcion
                    FROM
                    ins_imagendetalle
                    where ins_imagendetalle.id_imgclaveservicio='" . $idservicio . "' and
                    ins_imagendetalle.id_imgnumreporte='" . $idreporte . "' and
                    ins_imagendetalle.id_imgnumseccion='" . $idseccion . "' and
                    ins_imagendetalle.id_imgnumreactivo='" . $idreactivo . "';";
				// echo $sql;
				$rs1 = DatosImagenDetalle::consultaImagenDetalle ( $idserv, $nsol, $idseccion, $idreactivo, "ins_imagendetalle" );

				// if (mysql_num_rows($rs1) > 0) {

				foreach ( $rs1 as $row_max ) {
					$rutaFoto = $row_max ["id_ruta"];
					$idimagen = $row_max ["id_idimagen"];

					$href_elimina = 'index.php?action=rsn&ts=IM&admin=eli&pv=' . $pv . '&refer=' . $idserv . '.' . $nsol . '.' . $idseccion . '.' . $idreactivo . '.' . $idimagen . '&ruta=' . "fotografias/" . $rutaFoto;
					$href_elimina = '<a href="' . $href_elimina . '"><i class="fa fa-close"></i></a>';

					echo ' <div class="col-md-12 text-center">
   <img  src="fotografias/' . $rutaFoto . '" width="120" height="120" alt="" 
onclick="zoomToggle(\'120px\',\'120px\',\'350px\',\'335px\',this);" title="imagen" />

' . $href_elimina . '
   
    
   <br> ' . $row_max ["id_descripcion"] . '</div>
    ';
				}

				echo '
                   
    </div>
</div>           
     
</div><!-- body -->
</div><!-- box info -->
	</div>
	</div>
	</div></section>
';
		}
	}
	public function subeimagen() {
		include ('Utilerias/leevar.php');
	
		$carpeta = $this->verificaCarpeta ( $servicio, $reporte );
		if (isset ( $reactivo ) && ($reactivo != '' || $reactivo != 0))
			$ligaReg = "index.php?action=rsn&sec=" . $seccion . "." . $reactivo . "&ts=IM&sv=" . $servicio . "&nrep=$nrep&pv=$pv&idc=" . $idc;
		else
			$ligaReg = "index.php?action=rsn&sec=" . $seccion . "&ts=IM&sv=" . $servicio . "&nrep=" . $reporte . "&pv=" . $pv . "&idc=" . $idc;

		if ($carpeta != - 1) {
			$ban = 0;
			$contdes = 1; /* para los campos de descripcion */ // valida si hay archivo para ingresar

			foreach ( $_FILES as $imagen ) {
				if ($imagen ["size"] > 0) {
					// foreach ( $imagen["error"] as $key => $error ) {

					$name = $imagen ["name"];
					
					if ($imagen ["error"] == UPLOAD_ERR_OK) {

						$tmp_name = $imagen ["tmp_name"];

						$uploadfile = RAIZ . "/" . $carpeta . '/' . basename ( $name );
						if (! is_file ( $uploadfile )) {
							$tipo = $imagen ["type"];
							if ($tipo == 'image/gif' || $tipo == 'image/jpeg' || $tipo == 'image/png' || $tipo == 'image/x-png' || $tipo == 'image/pjpeg' || $tipo == 'application/octet-stream') {
								//reviso el tamaño 
								$medidasimagen= getimagesize($imagen['tmp_name']);
								
								
								//Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
								if($medidasimagen[0] < 1280 && $imagen['size'] < 110000){
									try{
									
								if (move_uploaded_file ( $tmp_name, $uploadfile )) {
									$des = "descripcion" . $contdes;
									$nopresen = "incluir" . $contdes;
								
									if ($$nopresen) {
										$pres = 0;
									} else {
										$pres = -1;
									}
									
									$this->InsertaImagenDetalle ( $servicio, $reporte, $seccion, $reactivo, $carpeta . '/' . basename ( $name ), $$des, $pres );
									// me regreso

									echo "<br>El archivo '" . $name . "' fue cargado exitosamente.\n";
									// guardar en la bd
								} else {
									echo '<div align="center">';
									echo "<br><h2>Error al cargar el archivo, intenta de nuevo</h2>";
									$ban = 1;
								}
									}catch(Exception $ex){
										guardarError("seccionController: error al subir imagen".$ex->getMessage());
									}
								}
								else{ //comprimimos
								//	echo $tmp_name."voy a comprimir";
								
									Utilerias::comprimirImagen($name, $tmp_name, $tipo, RAIZ . "/" . $carpeta );
									$des = "descripcion" . $contdes;
									$presen = "incluir" . $contdes;
									if ($$presen) {
										$pres = 0;
									} else {
										$pres = -1;
									}
									$this->InsertaImagenDetalle ( $servicio, $reporte, $seccion, $reactivo, $carpeta . '/' . basename ( $name ), $$des, $pres );
								
									
									echo "<br>El archivo '" . $name . "' fue cargado exitosamente.\n";
									// guardar en la bd
								
								
								}
							} else {
								echo '<div align="center">';
								echo "<br><h2>El archivo '" . $name . "' no es válido.\n</h2>";
								$ban = 1;
							}
						} else {
							echo '<div align="center">';
							echo "<br><h2>La imagen '" . $name . "' ya existe</h2>";
							$ban = 1;
						}
					} else if ($imagen ["error"] == UPLOAD_ERR_FORM_SIZE) {
						echo '<div align="center">';
						echo '<br><h2>El archivo "' . $name . '" excede el tamaño maximo</h2>';
						$ban = 1;
					} else if ($imagen ["error"] == UPLOAD_ERR_CANT_WRITE) {
						echo '<div align="center">';
						echo '<br><h2>No se encontró el directorio especificado</h2>';
						$ban = 1;
					}
					$contdes ++;
				} // termin
			}
		}

		if ($ban == 0) {
			//

			$une = DatosUnegocio::UnegocioCompleta ( $pv, "ca_unegocios" );
			$idc = $une ["cue_clavecuenta"];
			// die($pv."--".$ban);
			echo "
<script language='JavaScript'>
location.href = '" . $ligaReg . "'
</script>";
		}
		if ($ban == 1) {
			echo "<<<a href='" . $ligaReg . "'>REGRESAR</a></div>";
		}
		
	}
	function verificaCarpeta($servicio, $reporte) {
		$sql = "SELECT
       `ca_unegocios`.`cue_clavecuenta`
    , `ins_generales`.`i_mesasignacion`
FROM
   `ins_generales`
    INNER JOIN `ca_unegocios` 
        ON (`ins_generales`.`i_unenumpunto` = `ca_unegocios`.`une_id`)
                    WHERE
                    ins_generales.i_claveservicio =  :servicio AND
                                ins_generales.i_numreporte = :reporte";

		$rs1 = Conexion::ejecutarQuery ( $sql, array (
				"servicio" => $servicio,
				"reporte" => $reporte
		) );
		if (sizeof ( $rs1 ) > 0) {
			$row = $rs1 [0];
			$cuenta = $row [0];
			$mesAsignacion = $row [1];

			$aux = explode ( '.', $mesAsignacion );

			$mesAsignacion = $aux [0] . '-' . $aux [1];
			$ruta = $servicio . "/" . $cuenta . "/" . $mesAsignacion;
			if (! is_dir ( RAIZ . "/" . $ruta )) {
				// veo si existe el servicio
				if (! is_dir ( RAIZ . "/" . $servicio )) {
					// creo la carpeta
					try {
						mkdir ( RAIZ . "/" . $ruta, 0777, true );
					} catch ( Exception $ex ) {
						throw $ex;
					}
				} else  // veo si existe la cuenta

				if (! is_dir ( RAIZ . "/" . $servicio . "/" . $cuenta )) {
					// creo la carpeta
					try {
						mkdir ( RAIZ . "/" . $ruta, 0777, true );
					} catch ( Exception $ex ) {
						throw $ex;
					}
				} 
				else // no existe la del mes de asignacion
				{
					// echo RAIZ."/".$servicio."/".$cuenta;
					try {
						mkdir ( RAIZ . "/" . $ruta );
					} catch ( Exception $ex ) {
						throw $ex;
					}
				}
			}
		} else {
			return - 1;
		}
		return $ruta; // si existe
	}
	function InsertaImagenDetalle($servicio, $reporte, $seccion, $reactivo, $ruta, $descripcion, $presentar) {
		// primero busco el siguiente id
		try {

			$sqlcu = "INSERT INTO `ins_imagendetalle` (`id_imgclaveservicio`,`id_imgnumreporte`,`id_imgnumseccion`,`id_imgnumreactivo`,`id_idimagen`,`id_ruta`,  `id_descripcion`,`id_presentar`)
         VALUES ('" . $servicio . "','" . $reporte . "','" . $seccion . "','" . $reactivo . "','" . $sigId . "','" . $ruta . "','" . $descripcion . "', '" . $presentar . "');";

			$rs1 = DatosImagenDetalle::insertarImagenDetalle ( $servicio, $reporte, $seccion, $reactivo, $ruta, $descripcion, $presentar, ins_imagendetalle );
		} catch ( Exception $ex ) {
			echo Utilerias::mensajeError ( $ex->getMessage () );
		}
	}
	public function borrarImagen() {
		include ("Utilerias/leevar.php");

		// $refer_aux=explode('.', $refer);

		$datinic = SubnivelController::obtienedato ( $refer, 1 );
		$londatc = SubnivelController::obtienelon ( $refer, 1 );
		$idservicio = substr ( $refer, $datinic, $londatc );

		$datini = SubnivelController::obtienedato ( $refer, 2 );
		$londat = SubnivelController::obtienelon ( $refer, 2 );
		$idreporte = substr ( $refer, $datini, $londat );

		$datiniu = SubnivelController::obtienedato ( $refer, 3 );
		$londatu = SubnivelController::obtienelon ( $refer, 3 );
		$idseccion = substr ( $refer, $datiniu, $londatu );

		$datiniu = SubnivelController::obtienedato ( $refer, 4 );
		$londatu = SubnivelController::obtienelon ( $refer, 4 );
		$idreactivo = substr ( $refer, $datiniu, $londatu );
		$datiniu = SubnivelController::obtienedato ( $refer, 5 );
		$londatu = SubnivelController::obtienelon ( $refer, 5 );
		$idimagen = substr ( $refer, $datiniu, $londatu );
		// borro en tabla
		$this->BorraImagenDetalle ( $idservicio, $idreporte, $idseccion, $idreactivo, $idimagen );
		// borro del servidor
		$res = unlink ( $ruta );
		// echo "*******".$res;

		// if($res)
		// header('Location:MEIprincipal.php?op=img&admin=nva&secc='.$idservicio.'.'.$idseccion.'.'.$idreactivo.'&numrep='.$idreporte);
		echo "

          		<script language='JavaScript'>
          		location.href = 'index.php?action=rsn&sec=" . $idseccion . "." . $idreactivo . "&ts=IM&sv=" . $idservicio . "&nrep=" . $idreporte . "&pv=" . $pv . "&idc=" . $idc . "'
          		</script>";
	}
	function BorraImagenDetalle($servicio, $reporte, $seccion, $reactivo, $idimagen) {
		// primero busco el siguiente id
		$sql = "DELETE FROM `ins_imagendetalle`
WHERE id_imgclaveservicio='" . $servicio . "'
and id_imgnumreporte='" . $reporte . "'
and id_imgnumseccion='" . $seccion . "'
and id_imgnumreactivo='" . $reactivo . "'
and id_idimagen='" . $idimagen . "';";
		// echo $sql;
		include ("Utilerias/leevar.php");
		try {
			$rs1 = DatosImagenDetalle::eliminarImagenDetalle ( $servicio, $reporte, $seccion, $reactivo, $idimagen, "ins_imagendetalle" );
		} catch ( Exception $ex ) {
			echo Utilerias::mensajeError ( $ex->getMessage () );
		}
	}
}

?>