<?php
$resumenRes=new ResumenResultadosController;

$resumenRes->vistaResumenResultados();

?>


  <section class="content-header">
                <h1><?php echo $resumenRes->getFiltros_indi()->getNombre_seccion();
              echo "<br>".$resumenRes->getFiltros_indi()->getPeriodo();
              echo "<br>".$resumenRes->getFiltros_indi()->getNombre_nivel();
              echo "<br>".$resumenRes->getFiltros_indi()->getNombre_franquicia();?></h1>
      <ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
      </ol>
    </section>
     <section class="content container-fluid">
	<!----- Filtros ----->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info collapsed-box">
 				<div class="box-header with-border"> 
					<h3 class="box-title"><?php echo T_("FILTROS")?></h3>
 					<div class="box-tools pull-right"> 
 						<button type="button" class="btn btn-box-tool" 
 							data-widget="collapse"> 
 							<i class="fa fa-plus"></i> 
 						</button> 
 					</div> 
 				</div> 
 				<div class="box-body"> 
 					<form name="form1" action="index.php?action=indindicadores" 
 						method="get"> 
 						<div class="row"> 
 							<div class="col-sm-4 border-right filtros"> 
 								<input name="action" type="hidden" id="action" 
									value="indindicadores">
 								<input name="alertanav" type="hidden" id="alertanav" 
									value="<?php echo $resumenRes->getAlertanav(); ?>"> <input
 									name="opcionuni" type="hidden" id="opcionuni" 
									value="<?php echo $resumenRes->getOpcionuni(); ?>">
								
                        
                                <?php

 				echo $resumenRes->getListanivel2 ();

 			 echo $resumenRes->getListanivel3 ();

 			?>
                        
 <?php

 echo $resumenRes->getListanivel4 ();

 ?>
                   
                      
 <?php

 echo $resumenRes->getListanivel5 ();

 ?>
                     </div> 
 							<div class="col-sm-4 border-right">                  
 <?php

 echo $resumenRes->getListanivel6 ();

 ?>
                        
                         <div class="form-group"> 
 									 <label><?php echo T_("PERIODO")?></label>
 									<select name="anio" class="form-control" id="anio_asig" 
 										required>
										<option value=""><?php echo T_("Seleccione el periodo")?></option>       
 <?php echo $resumenRes->getOpciones_anio(); ?>
                             </select> 
 								</div> 
 							</div> 
 							<div class="col-sm-4 border-right"> 
 								<div class="form-group"> 
									<label><?php echo T_("MES");?></label> <select
 										class="form-control" name="mes_solo" id="mes" required>
										<option value="" selected><?php echo T_("Seleccione el mes")?></option>
 <?php echo $resumenRes->getOpciones_mes(); ?>
                             </select> 
 								</div> 
 								<div class="form-group"> 
 									<label>&nbsp;</label> 
									<button type="submit" class="btn btn-info pull-right"><?php echo T_("Filtrar")?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php include "cue_indresumenresultados.php"?>
</section>
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="js/jquery.cascading-drop-down.js"></script>
<script>

    $('.form-control').ssdCascadingDropDown({
        nonFinalCallback: function (trigger, props, data, self) {

            trigger.closest('form')
                    .find('input[type="submit"]')
                    .attr('disabled', true);

        },
        finalCallback: function (trigger, props, data) {

            if (props.isValueEmpty()) {
                trigger.closest('form')
                        .find('input[type="submit"]')
                        .attr('disabled', true);
            } else {
                trigger.closest('form')
                        .find('input[type="submit"]')
                        .attr('disabled', false);
            }

        }
    });
</script>