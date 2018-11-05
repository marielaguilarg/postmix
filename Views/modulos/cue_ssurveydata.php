<script>function cargar(form){//alert("W");if (confirm("Esta acción reconfigurará el Survey Data\ny los cambios realizados se perderán.¿Desea continuar?"))	{	//	window.open("MESprincipal.php?op=gensdata&admin=cargar",'self') ;//	document.form1.submit();	return true;	}	else return false;}function validar(valor){	if (confirm("¿Desea eliminar la columna "+ valor+" ?"))	{		return true;	}	else return false;}</script><?php
include 'Controllers/configuracionSDController.php';$confSDController= new ConfiguracionSDController();$confSDController->vistaConfiguracion();
?><section class="content-header">
<h3>CONFIGURACION DEL SURVEY DATA</h3>
<div class="row"><div class="col-md-12"> <button  class="btn btn-default pull-right" style="margin-right: 18px"> <a href="index.php?action=ssurveydata&admin=cargar" >  <i class="fa fa-cog" aria-hidden="true"></i>  Reconfigurar </a></button>    <button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=snuevosd" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>       </div>   </div>  
</section>

<!-- Main content -->
<section class="content container-fluid">  
<!----- Inicia contenido ----->
<?phpecho $confSDController->getMensaje();$i=1;$bac=1;$reg=sizeof($confSDController->getListaColumnas());foreach ($confSDController->getListaColumnas() as $columna){              if(($i-1)%3==0){        echo '<div class="row">';        $bac=0;    }    ?>
  <div class="col-md-4" >
<div class="box box-info" >
<div class="box-header with-border">
<h3 class="box-title">NO. COLUMNA: <?php echo $columna["numerocol"]?></h3><div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button></div>
<!-- /.box-tools -->
</div>
<!-- /.box-header -->
<div class="box-body">
<div class="arrow">
<div class="box-footer no-padding">
<ul class="nav nav-stacked">
<li><a href="#">NOMBRE DEL PERMISO:<strong><?php echo $columna["nombrecol"]?></strong></a></li>
</ul>
</div>
</div>
<div class="row" >
<div class="col-sm-4 ">

</div>
<!-- /.col -->
<div class="col-sm-4">
<div class="description-block"> <a class="btn btn-block btn-info" onclick="return validar(<?php echo $columna['numerocol']?>);" href="index.php?action=ssurveydata&admin=borrar&id=<?php echo $columna['numerocol']?>"><i class="fa fa-trash-o"></i></a> </div>
<!-- /.description-block -->
</div>
<!-- /.col -->
</div></div>
<!-- /.box-body -->
</div><!-- box -->
</div><!-- col -->
<?phpif(($i)%3==0||$reg<3){       echo '</div><!-- /row-->';    $bac=1;}$i++;} //fin foreach?>


</section>