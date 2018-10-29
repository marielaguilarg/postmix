<?php
include 'Controllers/gruposController.php';
$grupoController= new GruposController();
$grupoController->control();
?>

<section class="content-header">
<h1>GRUPOS</h1>

</section>
<!-- Main content -->
<section class="content container-fluid">

<!----- Inicia contenido ----->
<div class="row">
<?php foreach ($grupoController->getListaGrupos() as $grupo){
  
<div class="col-md-4" >
<div class="box box-info" >
<div class="box-header with-border">
<h3 class="box-title">CLAVE: <?php echo $grupo["clavegrupo"]?></h3>

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
<li><a href="#"><strong><?php echo $grupo["editagrupo"]?></strong></a></li>
</ul>
</div>
</div>
<div class="row" >
<div class="col-sm-6 border-right">
<div class="description-block">
<a class="btn btn-block btn-info" href='index.php?action=slistapermisos&id=<?php echo $grupo["clavep"]?>'>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
<div class="col-sm-6 border-right">
<div class="description-block">

</div>
<!-- /.description-block -->
</div>
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