  <section class="content-header">
  <h1> AGREGAR FRANQUICIA</h1>
   
   </section>
 
  <section class="content container-fluid">
 <div class="box box-info">
  <div class="box-body">
   <form role="form" method="post">

              <div class="form-group col-md-6">
                <label >DESCRIPCIÓN</label>
               
                    <input name="franombre" id="franombre" class="form-control" >
                </div>
                <div class="form-group col-md-6">
                 <label >Cuenta</label>
                    <select class="form-control" name="fraidcuenta" id="fraidcuenta" >
                    <option value="">-- Elija la cuenta  --</option>
                     <?php

					$opcion = new FranquiciaController();
					$opcion -> listaCuentasController();

					?>
					


                  </select>
                </div>
<?php
$opcion = new FranquiciaController();
$opcion ->registroFranquiciaController();
?>
                   <div class="box-footer" style="padding-top: 50px; border-bottom: hidden">
                   <div class="pull-right">
                     <button type="submit" class="btn btn-info">GUARDAR</button>
                 <a  class="btn btn-default" style="margin-left: 10px" href="index.php?action=listafranquicia"> CANCELAR </a>
              </div>

              </div>
               </form>
              </div>
            </div>