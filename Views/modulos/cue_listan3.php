  <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>
<section class="content-header">
<h1>Nivel 3: <?php echo Estructura::nombreNivel(3, 1)?></h1>
<h1><?php echo Datosndos::nombreNivel2(filter_input(INPUT_GET, "idnd",FILTER_SANITIZE_NUMBER_INT),"ca_nivel2" )?></h1>

<ol class="breadcrumb" >
	<li><a href="index.php?action=listan1"><em class="fa fa-dashboard"></em>NIVEL 1</a></li>
     
          <?php

      $vista = new NtresController();
      $vista -> asignavar();

?>

       
</ol>


</section>

<section class="content container-fluid">
 <div class="row">
	<div class="col-md-12" >
	<button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; ">
	<a href="index.php?action=nuevonivel&niv=3&ref=<?php echo filter_input(INPUT_GET, "idnd",FILTER_SANITIZE_NUMBER_INT)?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
	 </div>
	 </div>
 <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 20%">No.</th>
                 
                  <th style="width: 56%">NOMBRE</th>
                  <th style="width: 20%">DETALLE</th>
                </tr>
              
<?php

$ingreso = new NtresController();
$ingreso -> vistantresController();

?>

               </table>
            </div>
            <!-- /.box-body -->
      
</section>