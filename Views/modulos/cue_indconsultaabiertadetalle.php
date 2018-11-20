<?php 
 include 'Controllers/indpostmix/consultaAbiertaController.php';
    $abiertaController=new ConsultaAbiertaController();
    $abiertaController->vistaAbiertaDetalle();
?>
<!-- Content Header (Page header) -->
<section class="content-header">
<h1><?php echo $abiertaController->getUnegocio();?></h1>
<h1><?php echo $abiertaController->getTitulo1();?></h1>
<h1><?php echo $abiertaController->getNombreseccion();?></h1>
<ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion();?>
</ol>
</section>
<!-- Main content -->
<section class="content container-fluid">
<!----- Inicia contenido ----->
<?php 
 foreach($abiertaController->getListaresultados() as $linea){?>
<div class="row">
<div class="col-md-12">
<div class="box box-info">
<div class="box-body">
<!-- Datos iniciales alta de punto de venta -->
<?php $i=0;
    for ($i=0;$i<sizeof($linea);$i++){
        $resultado=  $linea[$i];?>
<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong>  <?php echo $abiertaController->getListaTitulos()[$i].":</strong>  ".$resultado; ?> </li>
</ul>
</div>
</div>
<?php }?>
</div>
<!-- Pie de formulario -->
</div>
</div>
</div>
<?php }?>
</section>
<!-- /.content-wrapper -->
