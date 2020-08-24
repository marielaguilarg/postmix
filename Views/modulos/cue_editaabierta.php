<section class="content-header">
  <h1> ACTUALIZAR COMPONENTE ABIERTO</h1>
   
   </section>
  <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
             <form role="form" method="post">   
                 <div class="form-group col-md-6">

               <?php

              $registro = New abiertaController();
              $registro-> editarAbiertaController();
              $registro-> actualizaAbiertaController();
              ?>

                
                <div class="box-footer col-md-12">
                <div class="pull-right">
                 <button type="submit" class="btn btn-info">GUARDAR</button>
                 <?php

              $registro = New abiertaController();
              $registro-> botonRegresaAbController();
              ?>     
                 </div>
                
              </div>
              </form>
              </div>
            </div>
        </div>
        </section>
    <!-- /.content -->
 
