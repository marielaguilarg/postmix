<?php

?>

    <!-- Content Header (Page header) -->
    
      <section class="content-header">
<h1><?php echo $comentController->getNombreuni()?></h1>
<h1><?php echo $comentController->getTitulo()?></h1>
<h1><?php echo $comentController->getNombreseccion();?></h1>
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
    <h3 class="box-title"><?php echo T_("COMENTARIOS");?></h3></div>
<div class="box-body">

<?php 
$i=0;

foreach ($comentController->getListaComentarios() as $comentario){
    
?>
<div class="form-group col-md-12">
<div class="row">
<ul class="nav nav-stacked">
<li>  <?php echo $comentario["numcomen"].". ".$comentario["selcomen"]; ?> </li>
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
