<section class="content-header">
  <h1> EDITA COMENTARIO PONDERADO</h1>
   
   </section>
  <section class="content container-fluid">
 <div class="box box-info">
  <div class="box-body">
   <form role="form" method="post">


              <?php
              $opcion = new PonderacionController();
              $opcion ->EncComentPondController();
            //  $opcion ->registrarComentController();
              ?>

             <div class="form-group col-md-6">
                <label >DESCRIPCIÓN EN ESPAÑOL</label>
                


              <?php
              $opcion = new PonderacionController();
              $opcion ->editarPonderaComentController();
              $opcion ->actualizarPondComentController();
              ?>
              <?php
              $opcion = new PonderacionController();
              $opcion ->botonRegresaComPondController();
              ?>
                   
                <button type="submit" class="btn btn-info pull-right">GUARDAR</button>
             
              
              
             </div>
               </form>
              </div>
            </div>