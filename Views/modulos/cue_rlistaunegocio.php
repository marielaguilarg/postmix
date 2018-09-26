<section class="content-header">
  <h1>Reporte <small></small></h1>
<ol class="breadcrumb" >

<?php
$ingreso = new seccionController();
$ingreso -> vistanomRservController();
?>        
        
</ol>
 </section>     


    <!-- Main content -->
    <section class="content container-fluid">

      
        <div class="row">
		<div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Búsqueda de punto de venta</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
              <form role="form" method="post">
                 <div class="col-sm-12">
                 <div class="input-group input-group-sm">
                 <input type="text" name="opcionuneg" id="opcionuneg" class="form-control" placeholder="Escribe palabra relacionada con el punto de venta" >

                 <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i>Buscar</button>
                    </span>
                </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
			</div>
        </div>
        
        <div class="row">
           <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Resultado de búsqueda</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 20%">No.</th>
                  <th style="width: 20%">ID PEPSI</th>
                  <th style="width: 24%">ID CUENTA</th>
                  <th style="width: 56%">NOMBRE</th>
                </tr>
              
<?php

$ingreso = new unegocioController();
$ingreso -> vistarunegocioController();

?>

               </table>
            </div>
           
          <!-- /.box -->
        </div>
        </div>


	  <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">&nbsp; &nbsp; &nbsp;</div>
    <!-- Default to the left --><strong>Copyright &copy; 2018 Muesmerc S.A. de C.V.</strong> Todos los derechos reservados. </footer>

  <!-- Control Sidebar -->
