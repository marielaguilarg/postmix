<section class="content-header">
  <h1> EDITAR COMENTARIO ESTANDAR</h1>
   
   </section>
  <section class="content container-fluid">
 <div class="box box-info">
  <div class="box-body">
   <form role="form" method="post">
		<?php
              $opcion = new EstandarController();            
              $opcion ->inicioEditComentController();
        ?>      
   <div class="form-group col-md-6">
           <label>DESCRIPCION EN ESPAÑOL</label>


              <?php
              $opcion = new EstandarController();            
              $opcion ->editarEstandarComentController();
              $opcion ->actualizaEstComentController();
              ?>

            
               <?php
              $opcion = new EstandarController();
              $opcion ->botonRegEditEstComentController();
              ?>
                   
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
               </form>
              </div>
            </div>
    </section>        