
  <section class="content-header">
  <h1> AGREGAR SERVICIO</h1>
   
   </section>
  <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
             <form role="form" method="post">   
                 <div class="form-group col-md-6">

                <label >NOMBRE EN ESPAÑOL</label>
               
                   <div class="col-sm-10">
                    <input name="sernombreesp" id="sernombreesp" class="form-control" value>
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >NOMBRE EN INGLES</label>
               <div class="col-sm-10">
                    <input name="sernombreing" id="sernombreing" class="form-control" >
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >CLIENTE</label>
               
                    <select class="form-control" name="seridcliente" id="seridcliente" >
                    <option value="">-- Elija el cliente  --</option>

              <?php

              $registro = New ServicioController();
              $registro-> listaClientesController();
              $registro-> registroServicioController();
              ?>
                     
					
                  </select>
                </div>
                <div class="box-footer col-md-12">
                      
                 
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              </form>
              </div>
            </div>
        </div>
        </section>
    <!-- /.content -->
 
