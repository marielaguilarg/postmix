<section class="content-header">
  <h1>EDITA DATO GENERAL</h1>
   
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
              $registro-> variablesEdGeneralController();
             // $registro-> registrarEstandarController();
              ?>

                <div class="form-group col-md-12">
                 <label >SELECCION DE DATO</label>
               
                    <select class="form-control" name="idcampo" id="idcampo" >
                    <option value="">-- Elija el dato  --</option>
                     <?php
                    $registro = New GeneralController();
                   $registro-> editaGeneralController();
                   $registro-> actualizagenController();
                    ?>
                  
                <div class="box-footer col-md-12">
                      
                      <?php

              $registro = New GeneralController();
              $registro-> botonRegresageneralController();
              ?>
                 
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              </form>

                  <?php
                    $registro = New GeneralController();
                  //  $registro->registrarDatosGenerales()
                    ?>

              </div>
            </div>
        </div>
        </section>