
<?php

include 'Controllers/configuracionSDController.php';
$confSDController= new ConfiguracionSDController();
$confSDController->vistaEditaColumna();
?>
 <section class="content-header">
	<h3>CONFIGURACION DEL SURVEY DATA</h3>
</section>
   <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">EDITA COLUMNA</h3>
            </div>
            <div class="box-body">
             <form role="form" name="form1" method="post" action="index.php?action=ssurveydata&admin=actualizarC">
               <div class="form-group col-md-6"><label>NOMBRE DE COLUMNA :</label>
    
      <input name="nomcol" type="text" class="form-control" id="descriesp" value="<?php echo $confSDController->getColumna()['NOMBRECOL']?>" size="70" required/>
      <input name="numcol2" type="hidden" class="form-control" id="numcol" value="<?php echo $confSDController->getColumna()['NUMCOL']?>" size="70" />
      <input name="reactivo" type="hidden" class="form-control" id="numcol2" value="<?php echo $confSDController->getColumna()['REACTIVO']?>" size="70" />
    </div>
     <div class="form-group col-md-6"><label>NUMERO DE COLUMNA :</label>
   
     <input name="numcol" type="text" class="form-control" id="descriesp" value="<?php echo $confSDController->getColumna()['NUMCOL']?>" size="70" required/>
      </div>
       <div class="form-group col-md-6"><label>DESCRIPCION :</label>
    
    <input name="descripcion" type="text" class="form-control" id="descriesp" value="<?php echo $confSDController->getColumna()['DESCRIP']?>"  size="70" required/>
     
    </div>
    
    <div class="form-group col-md-6"><label>NUMERO DE RENGLON :</label>
    
     <input name="numren" type="text" class="form-control" id="descriesp" value="<?php echo $confSDController->getColumna()['NUMREN']?>" size="70" />
     
    </div>
     <div class="form-group col-md-6"><label>VALOR POR OMISION :</label>
    
        <input name="valini" type="text" class="form-control" id="descriesp" value="<?php echo $confSDController->getColumna()['VALORINI']?>" size="70" />
     
    </div>
    <div class="box-footer">
                <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                 <a  class="btn btn-default pull-right" style="margin-left: 10px"  href="index.php?action=ssurveydata">Cancelar</a>
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>


       