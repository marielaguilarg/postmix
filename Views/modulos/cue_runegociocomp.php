<section class="content-header">
      <h1> INFORMACION DEL ESTABLECIMIENTO &nbsp; </h1>
      <ol class="breadcrumb">
      <?php
                $ingreso = new unegocioController();
                $ingreso -> vistanomRservDet();
                ?> 

      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
                <!-- Datos iniciales alta de punto de venta -->
                <?php
                $ingreso = new unegocioController();
                $ingreso -> vistaunegocioCompleta();
                ?> 

                <!-- Clasificación punto de venta -->
                
                
                <!-- Dirección punto de venta -->
               
                 <!-- Pie de formulario -->
                 
              </div>
              </div>
            </div>
       
        </div>
	 </section>
    <!-- /.content -->
  </div>