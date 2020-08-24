  <?php 
  
  $estructuraController=new EstructuraController();
  $estructuraController->vistaNuevo();
  $nivel=$estructuraController->resultado;

  ?>
  <section class="content-header">
  <h1>  <?php echo $estructuraController->titulo2." ".$estructuraController->titulo1?></h1>
  <h1><?php echo $estructuraController->titulo?></h1>
   
  </section>
 
  <section class="content container-fluid">
 <div class="box box-info">
  
   <form role="form" method="post" action="<?php echo $estructuraController->action?>">
<div class="box-body">
        <div class="form-group col-md-6">
       <label >NOMBRE</label>
     
    
      <input name="nombre" class="form-control" type="text" id="nomzona" size="70" value="<?php echo $nivel["descripcion"]?>">
        <input name="referencia" type="hidden" id="referencia" size="70" value="<?php if(isset($nivel)) echo $nivel["referencia"]; else echo filter_input(INPUT_GET, "ref",FILTER_SANITIZE_NUMBER_INT)?>"></div>
    <input name="id" type="hidden" value="<?php echo $nivel["id"]?>">
  <?php echo $estructuraController->listacliente ?>
                   <div class="box-footer" style="border-bottom: hidden">
                 <a  class="btn btn-default pull-right" style="margin-left: 10px" href="<?= $estructuraController->regresar ?>"> Cancelar </a>
                <button type="submit" class="btn btn-info pull-right">Guardar</button>

              </div>
             
               </form>
             
            </div>
            </section> 
 
 