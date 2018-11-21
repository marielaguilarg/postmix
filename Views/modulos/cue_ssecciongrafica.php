<?php
include 'Controllers/rangosGraficaController.php';
$rangoGController= new RangosGraficaController();
$rangoGController->vistaListaSecciones();
?>

<section class="content-header">
<h1>SECCIONES GRAFICADAS</h1><ol class="breadcrumb">        <?php Navegacion::desplegarNavegacion();?>   </ol>

</section>
<!-- Main content -->
<section class="content container-fluid">

<!----- Inicia contenido -----><?php echo $rangoGController->getMensaje()?>
<div class="row">
<?php foreach ($rangoGController->getListaSecciones() as $rangoG){   ?>
  
<div class="col-md-4" >
<div class="box box-info" >
<div class="box-header with-border">
<h3 class="box-title">NO: <?php echo $rangoG["no"]?></h3>

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
<li><?php echo $rangoG["desc"]?></li>
</ul>
</div>
</div>
<div class="row" ><div class="col-sm-4 "></div>
<div class="col-sm-4">
<div class="description-block">
<a class="btn btn-block btn-info" href='<?php echo $rangoG["det"]?>'><span style="font-size: 12px">DETALLE</span></a>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
<!-- /.col -->
</div>

</div>
<!-- /.box-body -->
</div>
</div>
<?php } //fin foreach?>
</div>
<!-- /.box -->
</section>