    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> MODIFICAR CUENTA</h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
              <form method="post">
                <!-- Datos alta de cuenta -->
                
<?php

              $registro = New CuentaController();
              $registro-> editarCuentaController();
              $registro->  actualizarCuentaController();
              ?>


                 <!-- Pie de formulario -->
                 <div class="box-footer col-md-12">
                  <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=listacuenta"> CANCELAR </a></button>
                  <button type="submit" class="btn btn-info pull-right">GUARDAR</button>  
                 </div>
              </form>
        </div>
	    </div>
	    </div>
	    </div>
	  