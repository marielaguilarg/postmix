<section class="content-header">
  <h1> AGREGAR SECCION ESTANDAR</h1>
   
   </section>
  <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
             <form role="form" method="post">   
                 <div class="form-group col-md-6">

               <?php

              $registro = New EstandarController();
              $registro-> nuevaEstandarController();
              $registro-> registrarEstandarController();
              ?>

                <label >NOMBRE EN ESPAÑOL</label>
               
                   <div class="col-sm-10">
                    <input name="nombreesp" id="sernombreesp" class="form-control" value required>
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >NOMBRE EN INGLES</label>
                  <div class="col-sm-10">
                    <input name="nombreing" id="sernombreing" class="form-control" required>
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >TIPO DE EVALUACION</label>
               
                    <select class="form-control" name="tipoeval" id="tipoeval" required>
                    <option value="">-- Elija el tipo de evaluacion  --</option>
                    <option value=0>Ninguna</option>
                    <option value=1>Una linea</option>
                    <option value=2>Multilinea</option>
                     
                  </select>
                </div>
                <div class="box-footer col-md-12">
                      
                 <?php     
                 $registro = New EstandarController();
              $registro-> botonRegresaEstController();
                 ?>
                <button type="submit" class="btn btn-info pull-right">GUARDAR</button>
              </div>
              </form>
              </div>
            </div>
        </div>
        </section>
    <!-- /.content -->
 
