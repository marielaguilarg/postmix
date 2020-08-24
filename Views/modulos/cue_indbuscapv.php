
   <?php $unegocioContoller=new BuscapvController();
    
                        $unegocioContoller->vistaindBuscarpv();
                    ?>

	<link rel="stylesheet" href="js/tablesaw/tablesaw.css">
   <script type="text/javascript" src="js/MENindcomboboxcuenta.js"></script>
   <script src="js/tablesaw/tablesaw.js"></script>
	<script src="js/tablesaw/tablesaw-init.js"></script>
	<script type="text/javascript">
<!--
function buscarAvanzada() {
	if (document.getElementById) { //se obtiene el id
		var el = document.getElementById("dregion"); //se define la variable "el" igual a nuestro div
		el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
			el = document.getElementById('dunidadneg');
			el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
			
	}
}
//-->
</script>
<section class="content-header">
     <h1 class="box-title">&nbsp;</h1>
    <ol class="breadcrumb">
           <?php Navegacion::desplegarNavegacion();?>
       
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
<!--  filtros -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo T_("BUSQUEDA DE PUNTO DE VENTA")?></h3>
        </div>
        <div class="box-body">
        <form name="form1" method="post"	action="index.php?action=indbuscapv">
        <div class="row">
            
              <div class="col-sm-6">
              
            <div class="form-group ">

              
                
                        <label><?php echo T_("PUNTO DE VENTA")?>:  </label>
                        <input type="text" name="fil_ptoventa" id="fil_ptoventa" class="form-control" placeholder="Escribe palabra relacionada con el punto de venta" >
      <input name="busqueda" type="hidden" value="1" />

                    </div>
                <div>
                    <label><?php echo T_("NUD:")?>  </label>    <input name="fil_idpepsi" class="form-control" type="text" size="30" value=""  />
                </div>
                </div>
                 <div class="col-sm-6">
                   <div class="form-group ">
        <label><?php echo T_("CUENTA")?></label>
     
  <?php
            foreach ($unegocioContoller->getListaCuentas() as $cuenta) {
                echo $cuenta;
            }
            ?>
     
    </div>
                   <div class="form-group ">
        <label><?php echo T_("FRANQUICIA")?></label>
    <div>   
  <?php
            foreach ($unegocioContoller->getListaFranquicias() as $franq) {
                echo $franq;
            }
            ?></div>
       </div>
    </div>
   
<div class="col-md-12" style="padding-bottom:10px">  
<a onclick="buscarAvanzada()" href="javascript:void(0);"><?php echo T_("BUSQUEDA AVANZADA")?></a>   
  </div>

  </div>
  <div class="row" style="border-top: solid #f4f4f4; padding: 10px 15px;">
        
  <div class="col-md-6" id="dunidadneg" style="display:none">
             <?php   echo $unegocioContoller->getListanivel1() ?>
            <input	name="varnivel2" type="hidden" id="varnivel2" value="<?php echo $unegocioContoller->getVarnivel() ?>" />
          <?php   echo $unegocioContoller->getListanivel2() ?>
     <?php   echo $unegocioContoller->getListanivel3() ?>
   </div>

                <div class="col-md-6" > 
                 <div id="dregion" style="display:none">    
      <?php   echo $unegocioContoller->getListanivel4() ?>
      <?php   echo $unegocioContoller->getListanivel5() ?>
      <?php   echo $unegocioContoller->getListanivel6() ?>
      </div>
    <div>
    <span class="input-group-btn">
    <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i><?php echo T_("BUSCAR")?></button>
    </span></div>
</div>
          
</div>
  </form>
  </div>
    </div>


        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php T_("RESULTADO DE BUSQUEDA")?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table  class="tablesaw table-striped" data-tablesaw-mode="stack">
                <thead>
                    <tr>
                        <th><?php echo T_("PUNTO DE VENTA")?></th>
                        <th ><?php echo T_("NUD")?></th>
                        <th ><?php echo T_("CIUDAD")?></th>
                        <th ><?php echo T_("DIRECCION") ?></th>
                    </tr>
<thead>
<tbody>
                    <?php
                  foreach($unegocioContoller->getListaunegocios() as $renglon){
                     echo " <tr>";
                      echo $renglon["NomPuntoVenta"];
                       echo $renglon["Nud"];
                       echo $renglon["CiudadN"];
                       echo $renglon["Direccion"];
                       echo  "</tr>";
                      
                  }
                    ?>
</tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                 <?php if($unegocioContoller->getPages()!=null) echo $unegocioContoller->getPages()->display_pages() ?>
                </ul>
            </div>
        </div>
        <!-- /.box -->
 


<!----- Finaliza contenido ----->
</section>
<!-- /.content -->

<!-- /.content-wrapper -->
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
   <script src="js/jquery.cascading-drop-down.js"></script>
    <script>
    $('.cascada').ssdCascadingDropDown({
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
