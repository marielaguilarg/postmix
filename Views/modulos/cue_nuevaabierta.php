<section class="content-header">
  <h1> AGREGAR COMPONENTE ABIERTO</h1>
   
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
              $registro-> nuevaAbiertaController();
              $registro-> registrarAbiertaController();
              ?>

                <label >DESCRIPCION EN ESPAÑOL</label>
               
                   <div class="col-sm-10">
                    <input name="nombreesp" id="sernombreesp" class="form-control" value required>
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >DESCRIPCION EN INGLES</label>
               <div class="col-sm-10">
                    <input name="nombreing" id="sernombreing" class="form-control" required>
                </div>
                </div>
                
                <div class="box-footer col-md-12">
                      
                  <?php     
                  $registro = New AbiertaController();
                  $registro-> botonRegresaAbController();
                 ?>
                <button type="submit" class="btn btn-info pull-right">GUARDAR</button>
              </div>
              </form>
              </div>
            </div>
        </div>
        </section>
    <!-- /.content -->
 
