<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <ul class="sidebar-menu" data-widget="tree">

            <!-- Optionally, you can add icons to the links -->
            <li class="treeview"><a href="#"><em class="fa fa-question-circle"></em> Cuestionario
                    <span class="pull-right-container">
                        <em class="fa fa-angle-left pull-right"></em>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li class="treeview">
                        <a href="index.php?action=clientes"><i class="fa fa-circle-o"></i> Clientes
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="index.php?action=listacliente"><i class="fa fa-circle-o"></i> Todos los clientes</a></li>
                            <li><a href="index.php?action=nuevocliente"><i class="fa fa-circle-o"></i> Agregar Cliente</a></li>

                        </ul>
                    </li>               
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Servicios
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="index.php?action=listaservicio"><i class="fa fa-circle-o"></i> Todos los servicios</a></li>
                            <li><a href="index.php?action=nuevoservicio"><i class="fa fa-circle-o"></i> Agregar Servicio</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Cuentas
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="index.php?action=listacuenta"><i class="fa fa-circle-o"></i> Todas las cuentas</a></li>
                            <li><a href="index.php?action=nuevacuenta"><i class="fa fa-circle-o"></i> Agregar Cuenta</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Franquicias
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="index.php?action=listafranquicia"><i class="fa fa-circle-o"></i> Todas las franquicias</a></li>
                            <li><a href="index.php?action=nuevafranquicia"><i class="fa fa-circle-o"></i> Agregar franquicia</a></li>
                        </ul>
                    </li>

            <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Punto de Venta
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
              <ul class="treeview-menu">
                    <li class="treeview"><a href="#""><i class="fa fa-circle-o"></i> Agregar Punto de Venta <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                      </span></a>
                      <ul class="treeview-menu">
                          <?php unegocioController::listaClientesCuentas(); ?>
                      </ul>
                    </li>
                
                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Todos los Puntos
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>

                    <ul class="treeview-menu">  
                      <?php
                      $ingreso = new enlacesController();
                      $ingreso -> listaserviciosCues();
                      ?>
                    </ul>
                  </li>                   
              </ul>
            </li>
            <li class="treeview"><a href="#"><em class="fa fa-file"></em> Reporte
                    <span class="pull-right-container">
                        <em class="fa fa-angle-left pull-right"></em>
                    </span>
                </a>

                <ul class="treeview-menu">

                    <?php
                    $ingreso = new enlacesController();
                    $ingreso->listaserviciosController();
                    ?>
                </ul>          
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-print"></i>
                    <span>Consultas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Rep. de Resultados
                        </a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Rep. de Facturación
                        </a></li>
                    <li><a href="index.php?action=inicio_excel"><i class="fa fa-circle-o"></i> Rep. Inicio
                        </a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Reg. Facturas
                        </a></li>
                    <li><a href="index.php?action=indrepxperiodo&op=repres"><i class="fa fa-circle-o"></i> Res. Resultados
                        </a></li>
                         <li><a href="index.php?action=indrepxperiodo&op=CSD"><i class="fa fa-circle-o"></i> Survey Data
                        </a></li>
                </ul>
            </li> 




            <li class="treeview">
                <a href="#"><em class="fa fa-bar-chart"></em> Indicadores Postmix
                    <span class="pull-right-container">
                        <em class="fa fa-angle-left pull-right"></em>
                    </span>
                </a>

                <ul class="treeview-menu">	
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Gráfica
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                          <ul class="treeview-menu">
                            <?php
              $ingreso = new enlacesController();
             $ingreso -> listanivelesController();
            ?>
                      
                        
                        </ul>
                    </li>
<!--                     <li class="treeview"> -->
<!--                         <a href="#"><i class="fa fa-circle-o"></i> Tabla Dinamica -->
<!--                             <span class="pull-right-container"> -->
<!--                                 <i class="fa fa-angle-left pull-right"></i> -->
<!--                             </span> -->
<!--                         </a> -->
<!--                         <ul class="treeview-menu"> -->
<!--                             <li><a href="#"><i class="fa fa-circle-o"></i> Mexico</a></li> -->
<!--                             <li><a href="#"><i class="fa fa-circle-o"></i> Costa Rica</a></li> -->
<!--                         </ul> -->
<!--                     </li> -->




                    <li><a href="index.php?action=indbuscapv"><i class="fa fa-circle-o"></i> Punto de Venta</a></li>


                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Base de Datos
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="index.php?action=indrepdiario"><i class="fa fa-circle-o"></i> Reporte Diario</a></li>
                            <li><a href="index.php?action=indrepxperiodo&op=bp"><i class="fa fa-circle-o"></i> Reporte por Periodo</a></li>
                            <li><a href="index.php?action=indhistoricoxpv"><i class="fa fa-circle-o"></i> Historico por punto de Venta</a></li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Certificacion <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span></a>

                        <ul class="treeview-menu">
                            <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Solicitudes<span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span></a>
                                <ul class="treeview-menu">
                                    <li ><a href="index.php?action=listasolicitudes"><i class="fa fa-circle-o"></i> Todas las Solicitudes</a></li>

                                    <li ><a href="index.php?action=editasolicitud"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                                    <li><a href="index.php?action=listaestatussolicitud"><i class="fa fa-circle-o"></i> Estatus Solicitud</a></li>
                                </ul>  
                            </li>

                 
                    <li><a href="index.php?action=listacertificados"><i class="fa fa-circle-o"></i> Certificados</a></li>
	</ul>
            </li>
       
</ul>
</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-book"></i>
                <span>Catálogos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Estructura
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="index.php?action=listan1"><i class="fa fa-circle-o"></i> Nivel 1</a></li>
                        <li><a href="index.php?action=nuevan1"><i class="fa fa-circle-o"></i> Agregar Nivel 1</a>

                        </li>
                    </ul>

                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Inspectores</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Volúmen de CO2</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Mes asignación</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Tipo de mercado</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Catálogos específicos</a></li>
            </ul>
        </li>
  <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Muestras de Agua</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
       <ul class="treeview-menu">
                <li>
                  <a href="index.php?action=anapend"><i class="fa fa-circle-o"></i> Análisis Pendientes
                  </a>  
                </li>
                <li>
                  <a href="index.php?action=anarealiza"><i class="fa fa-circle-o"></i> Análisis Realizados
                  </a>  
                </li>
                <li>
                  <a  href="index.php?action=estanalisis"><i class="fa fa-circle-o"></i> Estadística de Análisis
                  </a>  
                </li>
                <li>
                  <a  href="index.php?action=recepcion"><i class="fa fa-circle-o"></i> Recepción
                  </a>  
                </li>
                <li>
                  <a  href="index.php?action=prueba"><i class="fa fa-circle-o"></i> Prueba
                  </a>  
                </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
