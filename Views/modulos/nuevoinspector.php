   <div class="row">
    <div class="form-group col-md-6">
       <label >NOMBRE </label> 
    
      <input name="nomins" class="form-control" type="text" id="nomciu" required value="<?php echo $catalogo["ins_nombre"]?>" size="70">
      <input name="claveins" type="hidden" value="<?php echo  $catalogo["ins_clave"]?>">
 </div>
   <div class="form-group col-md-6">
       <label >USUARIO </label> 
    
      <input name="usuario" class="form-control" type="text" id="usuario"  value="<?php echo $catalogo["ins_usuario"]?>" size="70">
     
 </div>
 </div>
  <div class="row">
    <div class="form-group col-md-6">
       <label >SERVICIOS </label> 
    <?php 
    foreach($catalogosControl->serviciosinspector as $servicio){
    
    	?>
    <div class="checkbox">
    <label>
      <input name="servicio_<?= $servicio["ser_id"]?>"  type="checkbox"  <?= $servicio["checked"]?>>
     <?= $servicio["ser_descripcionesp"]?>
      </label>
      </div>
      
   <?php
   }?>
   
 </div>
 </div>