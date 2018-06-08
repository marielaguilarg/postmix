  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> AGREGAR CARACTERISTICA ABIERTA</h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
              <form role="form" method="post">
                  <?php
                      $registro = New abiertaController();     
                      $registro->nuevaAbdetController();
                    ?>

                <!-- Datos alta de cuenta -->
                <div class="form-group col-md-6">
                  <label>DESCRIPCION EN ESPAÑOL</label>
                  <input type="text" class="form-control" name="descesp" >
                </div>
                <div class="form-group col-md-6">
                  <label>DESCRIPCION EN INGLES</label>
                  <input type="text" class="form-control" name="descing" >
                </div>

                <div class="form-group col-md-6">
                  <label>FORMATO DE REACTIVO</label>
                  <select class="form-control" name="tiporeac">
                      <option value="">--- Elija el formato ---</option>
                      <option value="F">Fecha</option>
                      <option value="H">Hora</option>
                      <option value="C">Catalogo</option>
                      <option value="N">Numerico</option>
                      <option value="T">Texto</option>
                      <option value="E">Check List</option>
                  </select>
                               </div>

                <div class="form-group col-md-6">
                  <label>CATALOGO (SOLO EN CASO DE FORMATO CATALOGO)</label>
                  <select class="form-control" name=nomcat>
                  <option value="">--- Elija el catalogo ---</option>
                   
                    <?php
                      $registro = New abiertaController();     
                      $registro->listacatalogosController();
                //      $registro-> registraabdetController();   
                    ?>

                   </select>
                </div>

                
                <div class="form-group col-md-6">
                  <label>VALOR MINIMO (SOLO EN CASO DE FORMATO NUMERICO)</label>
                  <input type="text" class="form-control" name="valmin">
                </div>
                <div class="form-group col-md-6">
                  <label>VALOR MAXIMO (SOLO EN CASO DE FORMATO NUMERICO)</label>
                  <input type="text" class="form-control" name="valmax">
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
               
                 <!-- Pie de formulario -->
                                  <div class="box-footer col-md-12">
                   <?php
                 $registro = New abiertaController();
                  $registro->botonRegresaabdetController() ?>
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>  
                  <?php
                 $registro = New abiertaController();     
                 $registro-> registraabdetController();  
                // $registro->botonRegresaabdetController() ?>

                 </div>

              </form>
        </div>
	    </div>
	    </div>
	    </div>
	  