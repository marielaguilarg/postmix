<?php
include 'Controllers/permisosController.php';
?>
<h3>PERMISOS</h3>

</section>

<!-- Main content -->
<section class="content container-fluid">
<!----- Inicia contenido ----->
<?php
  <div class="col-md-4" >
<div class="box box-info" >
<div class="box-header with-border">
<h3 class="box-title">OPCION MENU PRINCIPAL: <?php echo $permiso["claveopcion"]?></h3>
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
<!-- /.box-tools -->
</div>
<!-- /.box-header -->
<div class="box-body">
<div class="arrow">
<div class="box-footer no-padding">
<ul class="nav nav-stacked">
<li><a href="#">NOMBRE DEL PERMISO:<strong><?php echo $permiso["editapermiso"]?></strong></a></li>
</ul>
</div>
</div>
<div class="row" >
<div class="col-sm-4 ">

</div>
<!-- /.col -->
<div class="col-sm-4">
<div class="description-block">
<!-- /.description-block -->
</div>
<!-- /.col -->
</div>
<!-- /.box-body -->
</div>
</div>
<?php


</section>