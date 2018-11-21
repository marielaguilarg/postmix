<?php
include 'Controllers/rangosGraficaController.php';
$rangoGController= new RangosGraficaController();
$rangoGController->vistaDetalleRango();
?>
<script language="JavaScript" type="text/JavaScript"><!--function act_grafica(id){			document.form1.action="index.php?action=srangosgraffrec&seco='" + document.getElementById('subseccion').value + "'"	document.form1.submit();}function cargalista(a){		document.form1.action="index.php?action=srangosgraffrec&secc="+document.getElementById('seccion').value;	document.form1.submit();}//--></script>
<section class="content-header">
<h1>RANGOS PARA GRAFICA DE FRECUENCIAS</h1><h1>SECCION:<?php echo $rangoGController->getNombreSeccion() ?></h1>
<ol class="breadcrumb">        <?php Navegacion::desplegarNavegacion();?>   </ol><div class="row"><div class="col-md-12">    <button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=snuevorango&numop=<?php echo $rangoGController->getNumop()."&secc=".$rangoGController->getSeccion() ?>" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>       </div>   </div>
</section>
<!-- Main content -->
<section class="content container-fluid">

<!----- Inicia contenido -----><?php echo $rangoGController->getMensaje()?>
<div class="box">
<form id="form1" name="form1" method="post" action=""><div class="box-body">   <div class="row">    <div class="form-group col-md-6">                  <label>COMPONENTE</label>      <select class="form-control" name="componente" onChange="cargalista(this)">      <option value="0">- Seleccione una opci&oacute;n -</option>      <?php echo $rangoGController->getComponentes();?></select>      <input name="seccion" id="seccion" type="hidden" value="<?php echo $rangoGController->getSeccion()?>" /></div></div><div class="col-md-12">      <table class="table table-condensed" >          <tr>		                  <th>NO.</th>        <th>VALOR MINIMO</th>		<th>VALOR MAXIMO</th>		<th>BORRAR</th>      </tr>    <?php foreach ($rangoGController->getListaRangos() as $rango){?>  <tr >    <?php echo "<td>".$rango['numval']."</td>";   echo "<td>".$rango['valmin']."</td>";   echo "<td>".$rango['valmax']."</td>";?>	<td><a href='index.php?action=srangosgraffrec&admin=borrar&id=<?php echo $rango['celdaDelsec']."&numop=".$rangoGController->getNumop()?>' onClick="return validar(this);">	<i class="fa fa-times"></i></a></td>  </tr><?php }?>    </table></div></div></form>
</div>
<!-- /.box -->
</section>