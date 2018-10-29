<?php
include 'Controllers/permisosController.php';$permisoController= new PermisosController();$permisoController->vistaListaPermisos();
?><section class="content-header">
<h3>PERMISOS</h3><h3><?php echo $permisoController->getGrupo()?></h3>

</section>

<!-- Main content -->
<section class="content container-fluid"><div class="row"><div class="col-md-12">    <button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=snuevopermiso&id=<?php echo $permisoController->getIdGrup() ?>" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>       </div>   </div>    
<!----- Inicia contenido ----->
<?phpecho $permisoController->getMensaje();$i=1;$bac=1;$reg=sizeof($permisoController->getListaPermisos());foreach ($permisoController->getListaPermisos() as $permiso){              if(($i-1)%3==0){        echo '<div class="row">';        $bac=0;    }    ?>
  <div class="col-md-4" >
<div class="box box-info" >
<div class="box-header with-border">
<h3 class="box-title">OPCION MENU PRINCIPAL: <?php echo $permiso["claveopcion"]?></h3><div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button></div>
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
<div class="description-block"> <button type="button" class="btn btn-block btn-info"> <a href="index.php?action=slistapermisos&admin=borrar&id2=<?php echo $permiso["borraid"]."&id=".$permisoController->getIdGrup() ?>"><i class="fa fa-trash-o"></i></a></button> </div>
<!-- /.description-block -->
</div>
<!-- /.col -->
</div></div>
<!-- /.box-body -->
</div><!-- box -->
</div><!-- col -->
<?phpif(($i)%3==0||$reg<3){       echo '</div><!-- /row-->';    $bac=1;}$i++;} //fin foreach?>


</section>