<section class="content-header">
  <h1> EDITA COMENTARIO estandar</h1>
   
   </section>
  <section class="content container-fluid">
 <div class="box box-info">
  <div class="box-body">
   <form role="form" method="post">


              <?php
              $opcion = new seccionController();
              $opcion ->inicioEditComentController();
            //  $opcion ->registrarComentController();
              ?>

             <div class="form-group col-md-6">
                <label >DESCRIPCIÓN EN ESPAÑOL</label>
                


              <?php
              $opcion = new PonderacionController();
              $opcion ->editarPonderaComentController();
              $opcion ->actualizarPondComentController();
              ?>
                   
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
             
              <?php
              $opcion = new seccionController();
              $opcion ->botonRegresaEditComentario();
              ?>
              
             </div>
               </form>
              </div>
            </div>