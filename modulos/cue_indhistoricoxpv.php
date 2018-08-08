
<?php  $basepController=new BasePostmixController();
$basepController->vistaHistoricoPV();
?>
<section class="content container-fluid">
<!--  filtros -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Histórico por punto de venta</h3>
        </div>
        <div class="box-body">
        <div>ESTIMADO USUARIO, PARA EXPORTAR EL REPORTE, SELECCIONE EL PUNTO DE VENTA </div>
        <div class="row"><form action="#" method="post">
        <div class="col-md-6">
        
<label><?php echo T_("BUSCAR PUNTO DE VENTA");?></label>

<input class="form-control" name="fil_ptoventa" type="text" size="30" value="" /> 
<input name="busqueda" type="hidden" value="1" />


<label><?php echo T_("ID PEPSI")?></label>

<input class="form-control" name="fil_idpepsi" type="text" size="30" value=""  />
</div>
<div class="col-md-6">

<?php echo $basepController->getListanivel1();
echo $basepController->getListanivel2();
echo $basepController->getListanivel3();
echo $basepController->getListanivel4();
echo $basepController->getListanivel5();
echo $basepController->getListanivel6();
?>


<button  type="submit" class="btn btn-primary">BUSCAR</button>

</div>
</form>
</div>
</div>
</div>
  <div class="box">
       
<div id="genera"  class="box-body no-padding">
                <table class="table table-striped">
                    <tr>
                        <th><?php echo T_("PUNTO DE VENTA")?></th>
                        <th ><?php echo T_("ID PEPSI")?></th>
                        <th ><?php echo T_("CIUDAD")?></th>
                        <th ><?php echo T_("DIRECCION") ?></th>
                    </tr>

                    <?php
                  foreach($basepController->getListaUnegocios() as $renglon){
                     echo " <tr>";
                      echo $renglon["NomPuntoVenta"];
                       echo $renglon["Pepsi"];
                       echo $renglon["CiudadN"];
                       echo $renglon["Direccion"];
                       echo  "</tr>";
                      
                  }
                    ?>

                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            <nav >
                <ul class="pagination pagination-sm no-margin pull-right">
                 <?php if($basepController->getPages()!=null) echo $basepController->getPages()->display_pages() ?>
                </ul>
                </nav>
            </div>
            </div></section>
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

