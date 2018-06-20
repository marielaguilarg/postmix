 <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
     

      <!-- search form (Optional) -->
     
      <!-- /.search form -->

      <!-- Sidebar Menu -->
     <ul class="sidebar-menu" data-widget="tree">
  
                     <!-- Optionally, you can add icons to the links -->
 <li class="treeview"><a href="#"><i class="fa fa-question-circle"></i> Cuestionario
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
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
                    <li><a href="index.php?action=listaunegocio"><i class="fa fa-circle-o"></i> Todos los puntos</a></li>
                    
                    
                    <li class="treeview"><a href="#" ><i class="fa fa-circle-o"></i> Agregar Punto de Venta 
                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span></a>
                         <ul class="treeview-menu">
                    <?php unegocioController::listaClientesCuentas();?>
                         </ul>
                        </li>
                  </ul>
                </li>

                </ul>
            </li>
            <li class="treeview"><a href="#"><i class="fa fa-file"></i> Reporte
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
      </a>

      <ul class="treeview-menu">

          <?php

          $ingreso = new enlacesController();
          $ingreso -> listaserviciosController();
          ?>
        </ul>          

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
            <li><a href="#"><i class="fa fa-circle-o"></i> Rep. Inicio
</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Reg. Facturas
</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Reg. Resultados
</a></li>
          </ul>
        </li>
<li><a href="#"><i class="fa fa-film"></i> <span>Cinemex</span></a></li>
<li><a href="#"><i class="fa fa-bar-chart"></i> <span>Indicadores Postmix</span></a></li>
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
 

</ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>