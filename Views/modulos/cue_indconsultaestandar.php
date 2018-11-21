<?php
include  "Controllers/indpostmix/consultaEstandarController.php";
$estandarController=new ConsultaEstandarController();
$estandarController->vistaListaEstandar();
?>

    <!-- Content Header (Page header) -->
    
      <section class="content-header">
<h1><?php echo $estandarController->getNombreUnegocio()?></h1>
<h1><?php echo $estandarController->getTitulo()?></h1>
<h1><?php echo $estandarController->getNombreseccion();?></h1>
<ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion();?>
</ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

<!----- Inicia contenido ----->
<div class="row">

<div class="col-md-12">
<div class="box box-info">
<div class="box-header  with-border">
    <h3 class="box-title"><?php echo T_("COMPONENTES");?></h3></div>
<div class="box-body">

<?php 
$i=0;

foreach ($estandarController->getListaEstandar() as $resultado){
    
?>
<div class="form-group col-md-12">
<div class="row">
<ul class="nav nav-stacked">
<li>  <?php echo $resultado; ?> </li>
</ul>
</div>
</div>
<?php }?>


</div>
<!-- Pie de formulario -->


</div>
</div>
</div>


</section>
<!-- /.content-wrapper -->
