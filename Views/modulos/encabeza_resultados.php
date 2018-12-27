
<!-- inicioBloque: Encabezado -->

<div>
  <div class="row">
    <div class="col-md-6"><?php  echo T_("PEPSICO DE MEXICO")?></div>
  
  
  </div>
  <div class="row">
    <div class="col-md-6"><?php echo T_("AUDITORIA POSTMIX")?></div>
 
  <div class="col-md-6"><?php echo $resumenRes->getTipomerc()?></div>
  </div>
  <div class="row">
    <div class="col-md-6"><?php echo T_("CUENTA").": ". $resumenRes->getCuenta()?>
    <input name="cuenta" type="hidden" value="<?php echo $resumenRes->getCuenta()?>" />
	<input name="periodo" type="hidden" value="<?php echo $resumenRes->getPeriodo()?>" />
	<input name="unidadnegocio" type="hidden" value="<?php /*echo $resumenRes->getID_PTO_VTA()*/?>" />
	<input name="num_rep" type="hidden" value="<?php echo $resumenRes->getTotal_res()?>" /></div>
    
    <div class="col-md-6"><?php echo $resumenRes->getFranquiciacta()?></div>
	
  </div >
  <?php echo $resumenRes->getNOMPTO_VTA()?>
  <?php echo $resumenRes->getFiltrosNivel()?>
 
    <div class="col-md-6"><?php echo T_("PERIODO CONSULTA").": " .$resumenRes->getperiodo()?></div>
	<div class="col-md-6"><?php echo T_("FECHA DE CONSULTA")." : ".$resumenRes->getfecha_cons()?></div>


</div>

<!-- finBloque: Encabezado -->
