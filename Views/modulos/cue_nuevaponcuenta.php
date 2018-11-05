<section class="content container-fluid">

      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
             <form role="form" method="post">
                <div class="form-group col-md-6">
                  <label>CLAVE CUENTA</label>
                  
                  <select class="form-control" name="cuenta" id="cuenta">
                  <?php
                  #busca cuenta
                  $ingreso = new cuentaController();
                  $ingreso -> listaponderaCuentaController();
                  ?>
                   </select>
                </div>

                <div class="form-group col-md-6">
                  <label>PONDERACION</label>
                  <input type="text" class="form-control" placeholder="" id="ponderacion" name="ponderacion">
                </div>

                <div class="form-group col-md-6">
                <label>FECHA DE INICIO :</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="fecini">
                </div>
                </div>
                <!-- /.input group -->
              
                <div class="form-group col-md-6">
                  <label>FECHA DE TERMINO :</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker2" name="fecfin">
                </div>
                </div>
                <!-- /.input group -->
            
              <?php
              #registra reporte
              $ingreso = new CuentaController();
              $ingreso -> registroPonderaCuentaController();
               ?> 
                               
                <!-- Clasificación punto de venta -->
                <br>
                
                <div class="box-footer col-md-12">
                  <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=editarep&sv='.$sv.'&idc='.$idc.'&nrep='.$nrep.'&pv='.$pv.'"> Cancelar </a></button>
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>  
                 </div>
               
              </form>
              </div>
              </div>
            </div>
       
        </div>
	  <!----- Finaliza contenido ----->
    </section>';
 