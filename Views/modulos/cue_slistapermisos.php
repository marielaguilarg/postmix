<script>function confirmar(){	if(confirm("¿Realmente desea eliminar?")){		return true;	}else{		//Si el codigo llega hasta aqu�, todo estar� bien  y realizamos el Submit		return false;	}	}</script><?php
include 'Controllers/permisosController.php';$permisoController= new PermisosController();$permisoController->vistaListaPermisos();
?><section class="content-header">
<h3>PERMISOS</h3><h3><?php echo $permisoController->getGrupo()?></h3>
<ol class="breadcrumb">        <?php Navegacion::desplegarNavegacion();?>   </ol>   <div class="row"><div class="col-md-12">    <button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=snuevopermiso&id=<?php echo $permisoController->getIdGrup() ?>" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>       </div>      </div>   
</section>

<!-- Main content -->
<section class="content container-fluid"> 
<!----- Inicia contenido ----->
<?phpecho $permisoController->getMensaje();$i=1;$bac=1;$reg=sizeof($permisoController->getListaPermisos());foreach ($permisoController->getListaPermisos() as $permiso){              if(($i-1)%3==0){        echo '<div class="row">';        $bac=0;    }    ?>
  <div class="col-md-4" >
<div class="box box-info" >
<div class="box-header with-border">
<h3 class="box-title">OPCION MENU PRINCIPAL: <?php echo $permiso["claveopcion"]?></h3><div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button></div>
<!-- /.box-tools -->
</div>
<!-- /.box-header -->
<div class="box-body">
<div class="arrow">
<div class="box-footer no-padding">
<ul class="nav nav-stacked">
<li>NOMBRE DEL PERMISO:<strong><?php echo $permiso["editapermiso"]?></strong></li>
</ul>
</div>
</div>
<div class="row" >
<div class="col-sm-4 ">

</div>
<!-- /.col -->
<div class="col-sm-4">
<div class="description-block"> <a class="btn btn-block btn-info" onclick="return confirmar();" href="index.php?action=slistapermisos&admin=borrar&id2=<?php echo $permiso["borraid"]."&id=".$permisoController->getIdGrup() ?>"><i class="fa fa-trash-o"></i></a> </div>
<!-- /.description-block -->
</div>
<!-- /.col -->
</div></div>
<!-- /.box-body -->
</div><!-- box -->
</div><!-- col -->
<?phpif(($i)%3==0||$reg<3){       echo '</div><!-- /row-->';    $bac=1;}$i++;} //fin foreach?>


</section>