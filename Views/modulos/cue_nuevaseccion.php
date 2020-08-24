<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> NUEVA SECCION</h1>
    <ol class="breadcrumb" >

<?php
$ingreso = new seccionController();
$ingreso -> vistaNomServicioController();
?>        
        
</ol>  
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
              <form method="post">
                <!-- Datos alta de cuenta -->
     <div class="form-group col-md-6">
         
         
         <?php

              $registro = New SeccionController();
              $registro-> nuevaSeccionController();
              $registro-> registrarSeccionController();
              ?>

          <label>NOMBRE DE SECCION EN ESPAÑOL</label>
           <input type="text" class="form-control" name="nomesp"  required>
           </div>
           <div class="form-group col-md-6">
           <label>NOMBRE DE SECCION EN INGLES</label>
           <input type="text" class="form-control" name="noming"  required>
          </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN ESPAÑOL</label>
           <input type="text" class="form-control" name="desesp" required>
           </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN INGLES</label>
           <input type="text" class="form-control" name="desing" required>
           </div>
           <div class="form-group col-md-6">
          <label>ORDEN MENU INDICADORES</label>
           <input type="text" class="form-control" name="ordensec">
           
          </div>
          <div class="form-group col-md-6">
          <label>MANEJA MUESTRAS DE AGUA</label></div>

           <div class="form-group col-md-6">
           <input type="checkbox" name="indmues" id="indmues" />
            </div> 
           <div class="box-footer col-md-12">
                    <div class="pull-right">   
                  <button type="submit" class="btn btn-info">GUARDAR</button>  
                 
                  <?php

              $registro = New SeccionController();
              $registro-> botonRegresaSeccionController();
              //$registro->  actualizarSeccionController();
              ?>
              </div>
                  </div>

                 <!-- Pie de formulario -->
                
              </form>
        </div>
	    </div>
	    </div>
	    </div>
	  