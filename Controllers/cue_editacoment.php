<section class="content-header">
  <h1> EDITA COMENTARIO</h1>
   
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
              $opcion = new seccionController();
              $opcion ->editarComentController();
              $opcion ->actualizarComentController();
              ?>
              <?php
              $opcion = new seccionController();
              $opcion ->botonRegresaEditComentario();
              ?>
                   
                <button type="submit" class="btn btn-info pull-right">GUARDAR</button>
             
              
              
             </div>
               </form>
              </div>
            </div>