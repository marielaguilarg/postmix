 <?php $unegocioContoller=new unegocioController();
                        $unegocioContoller->vistaNuevoUnegocio();
                    ?>﻿
<section class="content-header">
      <h1> Punto de venta &nbsp; </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Nuevo punto de venta</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     <?php $unegocioContoller=new unegocioController();
    
                        $unegocioContoller->vistaNuevoUnegocio();
                    ?>
      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
                 <form role="form" method="post">
                <!-- Datos iniciales alta de punto de venta -->
                <div class="form-group col-md-12">
                  <label>NOMBRE</label>
                  <input type="hidden" class="form-control" name="ncuenta" id="ncuenta" >
                  <input type="text" class="form-control" name="desuneg" id="desuneg" required>
                
                </div>
                <div class="form-group col-md-4">
                  <label>ID PEPSI</label>
                  <input type="text" class="form-control" name="idpepsi" id="idpepsi" >
                </div>
                <div class="form-group col-md-4">
                  <label>ID CUENTA</label>
                  <input type="text" class="form-control" name="idcta" id="idcta" >
                </div>
                <div class="form-group col-md-4">
                  <label>NUD</label>
                  <input type="text" class="form-control" name="idnud" id="idnud" >
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
                        data-default-label="Seleccione una compañía" disabled>
                    <option value="">Seleccione una opción</option>
                   
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
                        data-default-label="Seleccione una unidad de negocio" disabled>
                    <option value="">Seleccione una opción</option>
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
                        data-default-label="Seleccione un embotellador" disabled>
                 
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
                        data-default-label="Seleccione una región" disabled>
                
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>CIUDAD</label>
                  <select class="form-control" name="clanivel6" 
                        data-group="niv-1"
                        data-id="niv-6"
                         data-final
                        data-url=""
                        data-replacement="container1"
                        data-default-label="Seleccione una opción" disabled >
                  
                  </select>
                </div>
                
                <!-- Dirección punto de venta -->
               <br>
               <div class="col-md-12">
                <h4>DIRECCIÓN</h4>
                </div>
               <div class="form-group col-md-12">
                  <label>CALLE</label>
                  <input type="text" class="form-control" name="calle" id="calle" >
                </div>
                
               <div class="form-group col-md-3">
                  <label>NUM. EXTERIOR</label>
                  <input type="text" class="form-control" name="numext" id="numext" >
                </div>
                
                
                <div class="form-group col-md-3">
                  <label>NUM. INTERIOR</label>
                  <input type="text" class="form-control" name="numint" id="numint" >
                </div>
				
                <div class="form-group col-md-3">
                  <label>MANZANA</label>
                  <input type="text" class="form-control" name="mz" id="mz" >
                </div>
                <div class="form-group col-md-3">
                  <label>LOTE</label>
                  <input type="text" class="form-control" name="lt" id="lt">
                </div>
                <div class="form-group col-md-6">
                  <label>COLONIA</label>
                  <input type="text" class="form-control" name="col" id="col" >
                </div>
                <div class="form-group col-md-6">
                  <label>DELEGACIÓN</label>
                  <input type="text" class="form-control" name="del" id="del" >
                </div>
                <div class="form-group col-md-6">
                  <label>CIUDAD</label>
                  <input type="text" class="form-control" name="une_dir_municipio" id="une_dir_municipio" >
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
                  <input type="text" class="form-control" name="une_dir_cp" id="une_dir_cp" >
                </div>
                <div class="form-group col-md-9">
                  <label>REFERENCIA</label>
                  <input type="text" class="form-control" name="une_dir_referencia" id="une_dir_referencia" >
                </div>
                 <div class="form-group col-md-6">
                  <label>TELÉFONO</label>
                  <input type="text" class="form-control" name="une_dir_telefono" id="une_dir_telefono" >
                </div>
                 <!-- Pie de formulario -->
                 <div class="box-footer col-md-12">
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>
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