<?php $estructController=new EstructuraController();
$estructController->vistaLista();
?>
<section class="content-header">
<h1>Nivel 2: <?php echo Estructura::nombreNivel(2, 1)?></h1>
<h1><?php echo Datosnuno::nombreNivel1(filter_input(INPUT_GET, "idnuno",FILTER_SANITIZE_NUMBER_INT),"ca_nivel1" )?></h1>

 <ol class="breadcrumb" >
 		<li><a href="index.php?action=listan1"><em class="fa fa-dashboard"></em>NIVEL 1</a></li>
        </ol>

</section>

<section class="content container-fluid">
  <div class="row">
	<div class="col-md-12" >
	<button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; ">
	<a href="index.php?action=nuevonivel&niv=2&ref=<?php echo filter_input(INPUT_GET, "idnuno",FILTER_SANITIZE_NUMBER_INT)?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
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

$ingreso = new NdosController();
$ingreso -> vistandosController();

?>

               </table>
            </div>
            <!-- /.box-body -->
           
          </div>
          <!-- /.box -->
        </div>
        </div>


</section>