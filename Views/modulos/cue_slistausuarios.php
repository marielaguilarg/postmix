<?php
include 'Controllers/usuarioPermisosController.php';
$usuarioController= new UsuarioPermisosController();
$usuarioController->vistaListausuarios();
?>

<section class="content-header">
<h1>USUARIOS</h1>

</section>
<!-- Main content -->
<section class="content container-fluid">

<!----- Inicia contenido ----->
<div class="row">
<?php 
  
<div class="col-md-4" >
<div class="box box-info" >
<div class="box-header with-border">
<h3 class="box-title">CLAVE: <?php echo $usuario["claveusuario"]?></h3>

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
<li><a href="#"><strong><?php echo $usuario["editausuario"]?></strong></a></li>
</ul>
</div>
</div>
<div class="row" >
<div class="col-sm-4">
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
<?php 
</div>
<!-- /.box -->
</section>