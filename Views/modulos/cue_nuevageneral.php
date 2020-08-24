<section class="content-header">
  <h1>NUEVO DATO GENERAL</h1>
   
   </section>
  <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
             <form role="form" method="post">   
                 <div class="form-group col-md-6">

               <?php

              $registro = New GeneralController();
              $registro-> nuevaGeneralController();
             // $registro-> registrarEstandarController();
              ?>
</div>
                <div class="form-group col-md-12">
                 <label >SELECCION DE DATO</label>
               
                    <select class="form-control" name="idcampo" id="idcampo" >
                    <option value="">-- Elija el dato  --</option>
                     <?php
                    $registro = New GeneralController();
                    $registro-> listadatos();
                    ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                 <label >LUGAR EN ARCHIVO</label>
              
                    <input name="lugarsyd" id="lugarsyd" class="form-control" >
                </div>

                <div class="box-footer col-md-12">
                  <div class="pull-right">
                        <button type="submit" class="btn btn-info">Guardar</button>
                      <?php

              $registro = New GeneralController();
              $registro-> botonRegresageneralController();
              ?>
                 </div>
              
              </div>
              </form>

                  <?php
                    $registro = New GeneralController();
                    $registro->registrarDatosGenerales()
                    ?>

              </div>
            </div>
        </div>
        </section>