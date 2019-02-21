
 <?php $unegocioContoller=new unegocioController();
                        $unegocioContoller->vistaNuevoUnegocio();
						$idc=$_GET["idc"];
						
                    ?>﻿
<section class="content-header">
      <h1> EDITAR PUNTO DE VENTA</h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     <?php $unegocioContoller=new unegocioController();
     $id=filter_input(INPUT_GET,"referencia",FILTER_SANITIZE_NUMBER_INT);
     if($id!="")
          $unegocioContoller->vistaEditaUnegocio();
     else
                        $unegocioContoller->vistaNuevoUnegocio();
                    ?>
      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
                 <form role="form" method="post" >
                <!-- Datos iniciales alta de punto de venta -->
                 
                <div class="form-group col-md-12">
                  <label>NOMBRE</label>
                    <input type="hidden" class="form-control" name="ncuenta" id="ncuenta" value="<?php echo $unegocioContoller->getCuenta();?>" >
              
                  <input type="hidden" class="form-control" name="idpv" id="idpv" value="<?php echo $id?>">
               
                  <input type="text" class="form-control" name="desuneg" id="desuneg" value="<?php echo $unegocioContoller->getDesuneg(); ?>" required>
                  
                </div>
                <div class="form-group col-md-4">
                  <label>ID PEPSI</label>
                  <input type="text" class="form-control" name="idpepsi" id="idpepsi" value="<?php echo $unegocioContoller->getIdpepsi();?>">
                </div>
                <div class="form-group col-md-4">
                  <label>ID CUENTA</label>
                  <input type="text" class="form-control" name="idcta" id="idcta" value="<?php echo $unegocioContoller->getIdcta();?>">
                </div>
                <div class="form-group col-md-4">
                  <label>NUD</label>
                  <input type="text" class="form-control" name="idnud" id="idnud" value="<?php echo $unegocioContoller->getIdnud();?>">
                </div>
                <div class="form-group col-md-6">
               
                  <label>FRANQUICIA</label>
                  <select class="form-control" name="franqcuenta">
                    <option value="">Seleccione una opción</option>
                  <?php foreach($unegocioContoller->getListaFranquicias() as $franqui){
                     echo $franqui ;
                  }?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>ESTATUS</label>
                  <select class="form-control" name="estatus">
                       <option value="">Seleccione una opción</option>
                   <?php foreach($unegocioContoller->getListaEstatus() as $estatus){
                     echo $estatus ;
                  }?>
                  </select>
                </div>

                <!-- Clasificación punto de venta -->
                <br>
                <div class="col-md-12">
                <h4>CLASIFICACIÓN</h4>
                </div>
                <div class="form-group col-md-6">
                  <label>COMPAÑÍA</label>
                  <select class="form-control" name="clanivel1"    data-id="category"
                        data-group="niv-1"
                        data-target="niv-2"
                        data-url="getNivelUnegocio.php?"
                        data-replacement="container1">
                       <option value="">Seleccione una opción</option>
                     <?php foreach($unegocioContoller->getListanivel1() as $nivel1){
                     echo $nivel1 ;
                  }?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>UNIDAD DE NEGOCIO</label>
                  <select class="form-control" name="clanivel2"       data-group="niv-1"
                        data-id="niv-2"
                        data-target="niv-3"
                        data-url="getNivelUnegocio.php?"
                        data-replacement="container1"
                        data-default-label="Seleccione una opción" >
                  <?php foreach($unegocioContoller->getListanivel2() as $nivel2){
                     echo $nivel2 ;
                  }?>
                   
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>EMBOTELLADOR</label>
                  <select class="form-control" name="clanivel3" 
                        data-group="niv-1"
                        data-id="niv-3"
                        data-target="niv-4"
                        data-url="getNivelUnegocio.php?"
                        data-replacement="container1"
                        data-default-label="Seleccione una opción" >
                      <?php foreach($unegocioContoller->getListanivel3() as $nivel3){
                     echo $nivel3 ;
                  }?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>REGIÓN</label>
                  <select class="form-control" name="clanivel4" 
                        data-group="niv-1"
                        data-id="niv-4"
                        data-target="niv-5"
                        data-url="getNivelUnegocio.php?"
                        data-replacement="container1"
                        data-default-label="Seleccione una opción">
                     <?php foreach($unegocioContoller->getListanivel4() as $nivel4){
                     echo $nivel4 ;
                  }?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>ESTADO</label>
                  <select class="form-control" name="clanivel5" 
                        data-group="niv-1"
                        data-id="niv-5"
                        data-target="niv-6"
                        data-url="getNivelUnegocio.php?"
                        data-replacement="container1"
                        data-default-label="Seleccione una opción">
                    <?php foreach($unegocioContoller->getListanivel5() as $nivel5){
                     echo $nivel5 ;
                  }?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>CIUDAD</label>
                  <select class="form-control" name="clanivel6" 
                        data-group="niv-1"
                        data-id="niv-6"
                         data-final
                      
                        data-replacement="container1"
                        data-default-label="Seleccione una opción">
                      <?php foreach($unegocioContoller->getListanivel6() as $nivel6){
                     echo $nivel6 ;
                  }?>
                  </select>
                </div>
                
                <!-- Dirección punto de venta -->
               <br>
               <div class="col-md-12">
                <h4>DIRECCIÓN</h4>
                </div>
               <div class="form-group col-md-12">
                  <label>CALLE</label>
                  <input type="text" class="form-control" name="calle" id="calle" value="<?php echo $unegocioContoller->getCalle();?>">
                </div>
                
               <div class="form-group col-md-3">
                  <label>NUM. EXTERIOR</label>
                  <input type="text" class="form-control" name="numext" id="numext" value="<?php echo $unegocioContoller->getNumext()?>">
                </div>
                
                
                <div class="form-group col-md-3">
                  <label>NUM. INTERIOR</label>
                  <input type="text" class="form-control" name="numint" id="numint" value="<?php echo $unegocioContoller->getNumint();?>">
                </div>
				
                <div class="form-group col-md-3">
                  <label>MANZANA</label>
                  <input type="text" class="form-control" name="mz" id="mz" value="<?php echo $unegocioContoller->getMz();?>">
                </div>
                <div class="form-group col-md-3">
                  <label>LOTE</label>
                  <input type="text" class="form-control" name="lt" id="lt" value="<?php echo $unegocioContoller->getLt()?>">
                </div>
                <div class="form-group col-md-6">
                  <label>COLONIA</label>
                  <input type="text" class="form-control" name="col" id="col" value="<?php echo $unegocioContoller->getCol()?>">
                </div>
                <div class="form-group col-md-6">
                  <label>DELEGACIÓN</label>
                  <input type="text" class="form-control" name="del" id="del" value="<?php echo $unegocioContoller->getDel()?>">
                </div>
                <div class="form-group col-md-6">
                  <label>CIUDAD</label>
                  <input type="text" class="form-control" name="une_dir_municipio" id="une_dir_municipio" value="<?php echo $unegocioContoller->getMun()?>">
                </div>
                <div class="form-group col-md-6">
                  <label>ESTADO</label>
                  <select class="form-control" name="une_dir_estado" id="une_dir_estado">
                      <option>Seleccione una opción</option>
                      <?php foreach($unegocioContoller->getListaEstados() as $estado){
                          echo $estado;
                      }?>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label>C.P.</label>
                  <input type="text" class="form-control" name="une_dir_cp" id="une_dir_cp" value="<?php echo $unegocioContoller->getCp()?>">
                </div>
                <div class="form-group col-md-9">
                  <label>REFERENCIA</label>
                  <input type="text" class="form-control" name="une_dir_referencia" id="une_dir_referencia" value="<?php echo $unegocioContoller->getRef()?>">
                </div>
                 <div class="form-group col-md-6">
                  <label>TELÉFONO</label>
                  <input type="text" class="form-control" name="une_dir_telefono" id="une_dir_telefono" value="<?php echo $unegocioContoller->getTel()?>">
                </div>
                 <!-- Pie de formulario -->
                 <div class="box-footer col-md-12">
                  <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=listaunegocio&idc=<?php echo $idc; ?>"> CANCELAR </a></button>
                  <button type="submit" class="btn btn-info pull-right">GUARDAR</button>
              </div>
              </form>
              </div>
              </div>
            </div>
       <?php

$unegocioContoller ->registroUnegocioController();
?>
        </div>
	 </section>
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/jquery.cascading-drop-down.js"></script>
    <script>
    $('.form-control').ssdCascadingDropDown({
        nonFinalCallback: function(trigger, props, data, self) {

            trigger.closest('form')
                    .find('input[type="submit"]')
                    .attr('disabled', true);

        },
        finalCallback: function(trigger, props, data) {

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
    <!-- /.content -->

  </div>
