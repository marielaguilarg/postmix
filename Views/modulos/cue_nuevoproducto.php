<section class="content-header">
  <h1>NUEVO DATO PRODUCTO</h1>
   
   </section>
  <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
             <form role="form" method="post">   
                 <div class="form-group col-md-6">

               <?php

              $registro = New ProductoController();
              $registro-> nuevoProductoController();
             // $registro-> registrarEstandarController();
              ?>

                <div class="form-group col-md-12">
                 <label >SELECCION DE DATO</label>
               
                    <select class="form-control" name="idcampo" id="idcampo" >
                    <option value="">-- Elija el dato  --</option>
                     <?php
                    $registro = New ProductoController();
                    $registro-> listadatosproducto();
                    ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                 <label >LUGAR EN ARCHIVO</label>
               <div class="col-sm-10">
                    <input name="lugarsyd" id="lugarsyd" class="form-control" >
                </div>

                <div class="box-footer col-md-12">
                      
                      <?php

              $registro = New ProductoController();
              $registro-> botonRegresaProductoController();
              ?>
                 
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              </form>

                  <?php
                    $registro = New ProductoController();
                    $registro->registrarProductos();
                    ?>

              </div>
            </div>
        </div>
        </section>