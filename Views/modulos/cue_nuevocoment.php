<section class="content-header">
  <h1> AGREGAR COMENTARIO</h1>
   
   </section>
  <section class="content container-fluid">
 <div class="box box-info">
  <div class="box-body">
   <form role="form" method="post">


              <?php
              $opcion = new seccionController();
              $opcion ->nuevaComentController();
              $opcion ->registrarComentController();
              ?>

              <div class="form-group col-md-6">
                <label >DESCRIPCIÓN EN ESPAÑOL</label>
               
                    <input name="descesp" id="descesp" class="form-control" >
                </div>
                <div class="form-group col-md-6">
                    <label >DESCRIPCION EN INGLES</label>
                    <input name="descing" id="descing" class="form-control" >
                  </div>
                  <div class="pull-right">
                   <button type="submit" class="btn btn-info">GUARDAR</button>
                   
              <?php
              $opcion = new seccionController();
              $opcion ->botonRegresaComentarioController();
              ?>
                   </div>
               
              </div>
               </form>
              </div>
            </div>