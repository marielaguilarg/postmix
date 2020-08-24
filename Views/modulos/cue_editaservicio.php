 <section class="content-header">
  <h1> EDITA SERVICIO</h1>
   
   </section>
  <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
           <form role="form" method="post">      

  <?php

              $registro = New ServicioController();
              $registro-> editarServicioController();
              ?>

                <div class="box-footer col-md-12">
                <div class="pull-right">
                 <button type="submit" class="btn btn-info">Guardar</button> 
                 <a  class="btn btn-default" style="margin-left: 10px" href="index.php?action=listaservicio"> Cancelar </a>
              </div>
               
                </div>
                  <?php

              $registro = New ServicioController();
              $registro-> actualizarServicioController();
              ?>
              </form>
              </div>

          </div>
    </div>
  </div>
        </section>
      
    <!-- /.content -->
 
