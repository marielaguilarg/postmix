<?php 


include  "Controllers/indpostmix/consultaProductoController.php";
    $productoController=new ConsultaProductoController();
    $productoController->vistaListaProducto();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
<h1><?php echo $productoController->getUnegocio();?></h1>
<h1><?php echo $productoController->getTitulo1()?></h1>
<h1><?php echo $productoController->getNombreSeccion()?></h1>
<ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion();?>
</ol>
</section>

 <section class="content container-fluid">

      <!----- Inicia contenido ----->
    
           <?php foreach( $productoController->getListaProductos() as $resultado ) {?>
           <div class="row">

<div class="col-md-12">
<div class="box box-info">
<div class="box-body">

<!-- REPETIR -->
<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong> NO. </strong> <?php echo  $resultado["num"]; ?> </li>
</ul>
</div>
</div>
<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong> <?php echo T_("NO. DE SISTEMA")?></strong><?php echo $resultado["numsis"]?></li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
  <li><strong><?php echo T_("PRODUCTO")?>:</strong> <?php echo $resultado["prod"]?></li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong> <?php echo T_("CAJAS")?>: </strong>
           <?php echo $resultado["cajas"]?> </li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong> <?php echo T_("ESTADO")?>: </strong><?php echo $resultado["condic"]?></li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong><?php echo T_("FECHA DE PRODUCTO")?>: </strong>
                    <?php echo $resultado["fecprod"]?> </li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong><?php echo T_("FECHA DE CADUCIDAD")?>: </strong>
                    <?php echo $resultado["feccad"]?></li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong><?php echo T_("EDAD DIAS")?>: </strong>
                    <?php echo $resultado["edadd"]?></li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong> <?php echo T_("SEMANAS")?>: </strong>
                    <?php echo $resultado["sem"]?></li>
</ul>
</div>
</div>

<div class="form-group col-md-6">
<div class="row">
<ul class="nav nav-stacked">
<li><strong><?php echo T_("ESTATUS")?>: </strong>
                    <?php echo $resultado["estatus"]?></li>
</ul>
</div>
</div>


<!-- Pie de formulario -->

</div>
</div>
</div>
    </div>       
           
     <?php }?>
     
     <div class="box box-info">
     <strong><?php echo T_("NIVEL DE CUMPLIMIENTO").": ".$productoController->getTotpond()."%"?></strong>
     </div>

</section>
<!-- /.content-wrapper -->
