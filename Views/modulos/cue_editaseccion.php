 <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> MODIFICAR SECCION</h1>
      
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

              $registro = New SeccionController();
              $registro-> editarSeccionController();
              $registro->  actualizarSeccionController();
              ?>


                 <!-- Pie de formulario -->
                
              </form>
        </div>
	    </div>
	    </div>
	    </div>
	  