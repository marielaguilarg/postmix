  <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>
<section class="content-header">
<h1>Nivel 5: <?php echo Estructura::nombreNivel(5, 1)?></h1>
<h1><?php echo Datosncua::nombreNivel4(filter_input(INPUT_GET, "idncu",FILTER_SANITIZE_NUMBER_INT),"ca_nivel4" )?></h1>

<ol class="breadcrumb" >
	<li><a href="index.php?action=listan1"><em class="fa fa-dashboard"></em>NIVEL 1</a></li>
     
       <?php

      $vista = new NcinController();
      $vista -> asignavar();

?>
</ol>
</section>

<section class="content container-fluid">
 <div class="row">
	<div class="col-md-12" >
	<button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; "><a href="index.php?action=nuevonivel&niv=5&ref=<?php echo filter_input(INPUT_GET, "idncu",FILTER_SANITIZE_NUMBER_INT)?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
	 </div>
	 </div>
 <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 20%">No.</th>
                 
                  <th style="width: 56%">NOMBRE</th>
                  <th style="width: 56%">DETALLE</th>
                </tr>
              
<?php

$ingreso = new NcinController();
$ingreso -> vistancinController();

?>

               </table>
            </div>
            <!-- /.box-body -->
           
    

</section>
