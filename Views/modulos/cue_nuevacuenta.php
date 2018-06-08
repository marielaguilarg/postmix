    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> AGREGAR CUENTA</h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
              <form role="form" method="post">
                <!-- Datos alta de cuenta -->
                <div class="form-group col-md-6">
                  <label>NOMBRE</label>
                  <input type="text" class="form-control" name="nomcuen" >
                </div>
                <div class="form-group col-md-6">
                  <label>CLIENTE</label>
                  <select class="form-control" name="cliencuen">
                    
                    <option value="">-- Elija el cliente  --</option>

              <?php

              $registro = New CuentaController();
              $registro-> listaClientesController();
              $registro-> registroCuentaController();
              ?>


                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>TIPO DE MERCADO</label>
                  <select class="form-control" name="tipomercuen">
                    <option value=1>ON PREMISE</option>
                    <option value=2>TRADICIONAL</option>
                    <option value=3>MODELO</option>
                  <option value=4>EXPERIMENTAL</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>SIGLAS</label>
                  <input type="text" class="form-control" name="siglascuen">
                </div>
                <div class="form-group col-md-6">
                  <label>LUGAR</label>
                  <input type="text" class="form-control" name="lugarcuen">
                </div>

                 <!-- Pie de formulario -->
                 <div class="box-footer col-md-12">
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>  
                 </div>
              </form>
        </div>
	    </div>
	    </div>
	    </div>
	  