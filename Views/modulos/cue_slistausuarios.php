<?php
include 'Controllers/usuarioPermisosController.php';
$usuarioController= new UsuarioPermisosController();
$usuarioController->vistaListausuarios();
?>

<section class="content-header">
<h1>USUARIOS</h1><h1><?php echo $usuarioController->getTITULO5()?></h1>

</section>
<!-- Main content -->
<section class="content container-fluid"><div class="row"><div class="col-md-12">    <button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=snuevousuario&admin=nuevo&id=<?php echo $usuarioController->getIdnum()?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>       </div></div>

<!----- Inicia contenido -----><?php echo $usuarioController->getMensaje()?>
<div class="row">
<?php $i=1;foreach ($usuarioController->getListaUsuarios() as $usuario){    if(($i-1)%3==0){        echo '<div class="row">';          }   ?>
  
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
<div class="row" ><div class="col-sm-4"></div>
<div class="col-sm-4">
<div class="description-block">  <a class="btn btn-block btn-info" href="index.php?action=slistausuarios&admin=borrar&usu=<?php echo $usuario['borrarusurario']."&id=".$usuarioController->getIdnum()?>"><i class="fa fa-trash-o"></i></a></button>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
</div>

</div>
<!-- /.box-body -->
</div>
</div>
<?php if(($i)%3==0){    echo '</div>';    }$i++;} //fin foreach?>
</div>
<!-- /.box -->
</section>