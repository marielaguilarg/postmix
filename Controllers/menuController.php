<?php
class MenuController {
	public function desplegarMenu() {
		//include "Utilerias/leevar.php";
		$user = $_SESSION ['Usuario'];

		$grupous = $_SESSION ['GrupoUs'];
		$op = "menugen";

			$sql_per = "select * from cnfg_menu
        inner join cnfg_permisos on cnfg_menu.men_claveopcion=cnfg_permisos.cpe_claveopcion where cnfg_permisos.cpe_grupo='" . $grupous . "'

order by cnfg_menu.men_claveopcion;";

			$cont = 0;
			$rs2 = DatosPermisos::getPermisosxgrupo ( $grupous );
		//	var_dump($rs2);
			$td = "";
			foreach ( $rs2 as $row2 ) {
				// nivel 1

				echo '  <li class="treeview"><a href="#"><em class="fa ' . $row2 ["men_imagenopcion"] . '"></em>' . $row2 ["men_nombreopcion"] . '<span class="pull-right-container">
						<em class="fa fa-angle-left pull-right"></em>
						</span>
						</a>';
				$cont ++;

				// comprueba que no este la opcion
				$sql_com = "SELECT
cnfg_permisos.cpe_grupo
FROM
cnfg_permisos
Inner Join cnfg_menu ON cnfg_permisos.cpe_claveopcion = cnfg_menu.men_claveopcion
where
cnfg_permisos.cpe_grupo='" . $grupous . "' and cnfg_permisos.cpe_claveopcion='" . $row2 ["men_superopcion"] . "';";
				// echo $sql_com;
				$rs_com = DatosPermisos::getSubmenusxgrupo ( $grupous, $row2 ["men_claveopcion"] );
			
				if ($row2 ["men_claveopcion"] == "Brepor") {
					$ingreso = new enlacesController ();
					echo ' <ul class="treeview-menu">';
					$ingreso->listaserviciosController ($grupous, $user) ;
					echo "</ul>";
				}
				if (sizeof ( $rs_com )) {

					echo ' <ul class="treeview-menu">';
					foreach ( $rs_com as $rowsub ) { // nivel 2
						$sql2 = "SELECT * FROM cnfg_menu where men_claveopcion='" . $row2 ["men_superopcion"] . "';";
						//$rs3 = DatosPermisos::getSubmenusxgrupo ( $grupous, $rowsub ["men_claveopcion"] );
					
						if ($rowsub ["men_nivelopcion"] ==1) {
							echo '
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i>' . $rowsub ["men_nombreopcion"] . '
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>';
							echo '<ul class="treeview-menu">';
							if ($rowsub ["men_claveopcion"] == "sol") {
								echo '
					<li ><a href="index.php?action=editasolicitud&sv=3"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
						<li ><a href="index.php?action=listasolicitudes&sv=3"><i class="fa fa-circle-o"></i> Todas las Solicitudes</a></li>
										
						


						<li><a href="index.php?action=listaestatussolicitud&sv=3"><i class="fa fa-circle-o"></i> Estatus Solicitud</a></li>
					';
							}

					if ($rowsub ["men_claveopcion"] == "solg") {
						if($grupous=="muh")
							echo '
					<li ><a href="index.php?action=listasolicitudes&sv=5"><i class="fa fa-circle-o"></i> Todas las Solicitudes</a></li>
					';
						else
								echo '
					<li ><a href="index.php?action=nuevasolicitudgepp"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>

						<li ><a href="index.php?action=listasolicitudes&sv=5"><i class="fa fa-circle-o"></i> Todas las Solicitudes</a></li>
										
						
						
						<li><a href="index.php?action=listaestatussolicitud&sv=5"><i class="fa fa-circle-o"></i> Estatus Solicitud</a></li>
					';
							}


						if ($rowsub ["men_claveopcion"] == "cli") {
							echo ' <li>
                  <a href="index.php?action=listacliente"><i class="fa fa-circle-o"></i> Todos los clientes
                  </a>
                </li>
<li>
                  <a href="index.php?action=nuevocliente"><i class="fa fa-circle-o"></i>Agregar Cliente
                  </a>
                </li>';
								
					}
								if ($rowsub ["men_claveopcion"] == "ser") {
									echo ' <li>
                  <a href="index.php?action=listaservicio"><i class="fa fa-circle-o"></i> Todos los servicios
                  </a>
                </li>
<li>
                  <a href="index.php?action=nuevoservicio"><i class="fa fa-circle-o"></i>Agregar Servicio
                  </a>
                </li>';}
									if ($rowsub ["men_claveopcion"] == "cue") {
										echo ' <li>
                  <a href="index.php?action=listacuenta"><i class="fa fa-circle-o"></i> Todos las cuentas
                  </a>
                </li>
<li>
                  <a href="index.php?action=nuevacuenta"><i class="fa fa-circle-o"></i>Agregar Cuenta
                  </a>
                </li>';
									}
									if ($rowsub ["men_claveopcion"] == "fra") {
										echo '   <li><a href="index.php?action=listafranquicia"><i class="fa fa-circle-o"></i> Todas las franquicias</a></li>
                            <li><a href="index.php?action=nuevafranquicia"><i class="fa fa-circle-o"></i> Agregar franquicia</a></li>';}
									
							
										if ($rowsub ["men_claveopcion"] == "ptv") {
											$ingreso = new enlacesController();
									
								echo '
                
                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Todos los Puntos
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>

                    <ul class="treeview-menu">  
                     ';
                     
                      $ingreso -> listaserviciosCues();
                      echo '   <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Agregar Punto de Venta <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                      </span></a>
                      <ul class="treeview-menu">';
                      unegocioController::listaClientesCuentas();
                      echo ' </ul>
                    </li>';
								}
							
					
					if ($rowsub ["men_claveopcion"] == "igra") {
						$ingreso = new enlacesController ();
									
						$ingreso->listanivelesController () ;
                     // echo '</ul>';
					}
					if ($rowsub ["men_claveopcion"] == "iind") {
						$ingreso = new enlacesController ();
						
						$ingreso->listanivelesIndicadores() ;
						// echo '</ul>';
					}
					if ($rowsub ["men_claveopcion"] == "ConsBase") {
					echo '
					<li><a href="index.php?action=indrepdiario"><i class="fa fa-circle-o"></i> Reporte Diario</a></li>
					<li><a href="index.php?action=indrepxperiodo&op=bp"><i class="fa fa-circle-o"></i> Reporte por Periodo</a></li>
					<li><a href="index.php?action=indhistoricoxpv"><i class="fa fa-circle-o"></i> Historico por punto de Venta</a></li>
					';
					}
			
					if ($rowsub ["men_claveopcion"] == "Aest") {
					echo '
					<li><a href="index.php?action=listan1"><i class="fa fa-circle-o"></i> Nivel 1</a></li>
					<li><a href="index.php?action=nuevonivel&niv=1"><i class="fa fa-circle-o"></i> Agregar Nivel 1</a>
					
					</li>
					';
					}
							
							echo '</ul>';
							echo '</li>';
						} else {
							echo ' <li>
                  <a href="index.php?action=' . $rowsub ["men_liga"] . '"><i class="fa fa-circle-o"></i> ' . $rowsub ["men_nombreopcion"] . '
                  </a>  
                </li>';
						}
					} // termina for nivel2
					echo "</ul>";
				}

				echo "</li>";
			}

			
		}
		
}

