<?php

include 'Controllers/gruposController.php';

$grupoController= new GruposController();

$grupoController->control();

?>
  
   <section class="content-header">
  <h1> <?php echo $grupoController->getTitulo1()?></h1>
   
   </section>
   <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $grupoController->getTitulo2()?></h3>
            </div>
            <div class="box-body">
             <form role="form" method="post" action="index.php?action=slistagrupos&admin=<?php echo $grupoController->getAdmin()?>">
              
                <label for="nomesp" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
              	<input name="idper" type="hidden" value="<?php echo $grupoController->getIDS()?>">
                    <input name="nomesp"  id="nomesp" class="form-control" value="<?php echo $grupoController->getNOMESP()?>" required >
                </div>
                <div class="box-footer" style="padding-top: 50px; border-bottom: hidden">
                 <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=slistagrupos">Cancelar</a></button>
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>


       