<?php

include 'Controllers/indpostmix/consultaSeccionesController.php';

$seccionesController= new ConsultaSeccionesController();

$seccionesController->vistaListaSecciones();

?>



<link rel="stylesheet" href="libs/fancybox/dist/jquery.fancybox.min.css" />

<script src="libs/fancybox/dist/jquery.fancybox.min.js"></script>

<section class="content-header">

<h1><?php echo $seccionesController->getTitulo1();?></h1>

   <h1><?php echo $seccionesController->getNomunegocio()?></h1>



<h1><?php echo $seccionesController->getTitulo2()?></h1>

<ol class="breadcrumb">

<?php Navegacion::desplegarNavegacion();?>

</ol>

</section>







<!-- Main content -->

<section class="content container-fluid">



<!----- Inicia contenido ----->


<?php

$i=1;
$bac=1;
foreach ($seccionesController->getListaSecciones() as $seccion){

	if(($i-1)%3==0){
		echo '<div class="row">';
		$bac=0;
	}

    

    ?>

    

    



<div class="col-md-4" >

<div class="box box-info" >

<div class="box-header with-border">

<h3 class="box-title">No. <?php echo $seccion["numsec"]?></h3>



<div class="box-tools pull-right">

<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>

</button>



</div>

<!-- /.box-tools -->

</div>

<!-- /.box-header -->

<div class="box-body">

<div class="arrow">

<div class="box-footer no-padding">

<ul class="nav nav-stacked">

<li><a href="#"><strong><?php echo $seccion["nomsec"]?></strong></a></li>

</ul>

</div>

</div>

<div class="row" >

<div class="col-sm-4 border-right">

<div class="description-block"><?php echo $seccion["celdaSumniv"]?>



</div>

<!-- /.description-block -->

</div>

<!-- /.col -->

<div class="col-sm-4 border-right">

<div class="description-block"><?php echo $seccion["celdaComent"]?>



</div>

<!-- /.description-block -->

</div>

<!-- /.col -->

<div class="col-sm-4">

<div class="description-block"><?php echo $seccion["celdaImg"]?>



</div>

<!-- /.description-block -->

</div>

<!-- /.col -->

</div>



</div>

<!-- /.box-body -->

</div>

</div>

<?php
if(($i)%3==0){
	
	echo '</div>';
	$bac=1;
}
$i++;
} //fin foreach?>



<!-- /.box -->

</section>