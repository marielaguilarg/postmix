
  <section class="content-header">
  <h1> AGREGAR REACTIVO PONDERADO</h1>
   
   </section>
  <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
             <form role="form" method="post">   
                 <div class="form-group col-md-6">

                 
                 <?php

              $registro = New PonderacionController();
              $registro-> nuevaPonderaController();
              $registro-> registrarPonderaController();
              ?>


                <label >DESCRIPCION ESPAÑOL</label>
               
                   <div class="col-sm-10">
                    <input name="descripesp" id="descripesp" class="form-control" value>
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >DESCRIPCION INGLES</label>
               <div class="col-sm-10">
                    <input name="descriping" id="descriping" class="form-control" >
                </div>
                </div>
                <div class="form-group col-md-6">
                <label >INCLUYE EN ARCHIVO</label>
                </div>
                <div class="form-group col-md-6">
                <label >LUGAR</label>
                </div>
                <div class="form-group col-md-6">
                <input type="checkbox" name="indsyd" id="indsyd" />
                 </div>
               
                <div class="col-sm-6">
                    <input name="lugarsyd" id="lugarsyd" class="form-control" >
                </div>
                <div class="box-footer col-md-12">
                <div class="pull-right">
                      <button type="submit" class="btn btn-info pull-right">Guardar</button>   
                 <?php
                 $registro = New PonderacionController();     
                 $registro->botonRegresaSeccionController();
                  ?>
             </div>
              </div>
              </form>
              </div>
            </div>
        </div>
        </section>
    <!-- /.content -->
 
