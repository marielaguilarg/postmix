<section class="content-header">
  <h1> AGREGAR COMENTARIO</h1>
   
   </section>
  <section class="content container-fluid">
 <div class="box box-info">
  <div class="box-body">
   <form role="form" method="post">


              <?php
              $opcion = new EstandarController();
              $opcion ->nuevoestComentController();
              $opcion ->registraEstandarComentController();
              ?>

              <div class="form-group col-md-6">
                <label >DESCRIPCIÓN EN ESPAÑOL</label>
               
                    <input name="descesp" id="descesp" class="form-control" >
                </div>
                <div class="form-group col-md-6">
                    <label >DESCRIPCION EN INGLES</label>
                    <input name="descing" id="descing" class="form-control" >
                  </div>
              <?php
              $opcion = new EstandarController();
              $opcion ->botonRegresaEstComentController();
              ?>
                   
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
               </form>
              </div>
            </div>