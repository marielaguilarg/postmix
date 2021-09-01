<?php




include 'Controllers/rangosGraficaController.php';

$listaGController= new ConfigGraficaIndiController;

$listaGController->vistaListaSecciones();

?>



<section class="content-header">

<h1>
RANGOS PARA GRAFICA DE FRECUENCIAS</h1>
<ol class="breadcrumb">

        <?php Navegacion::desplegarNavegacion();?>
   </ol>

<div class="row">
<div class="col-md-12">
    
<a  class="btn btn-default pull-right" style="margin-right: 18px" href="index.php?action=sconfiguragrafica"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
       </div>
   </div>
</section>

<!-- Main content -->

<section class="content container-fluid">


<!----- Inicia contenido ----->
<?php echo $rangoGController->getMensaje()?>
<div class="box">



<form id="form1" name="form1" method="post" action="">

<div class="box-body">
   <div class="col-md-12">
      <table class="table table-condensed" >
     
     <tr>
		                  <th>NO.</th>
        <th>SECCION</th>
		<th>REACTIVO</th>
		<th>COMPONENTE</th>
      </tr>
    <?php foreach ($rangoGController->getListaRangos() as $rango){?>
  <tr > 
   <?php echo "<td>".$rango['numval']."</td>";
   echo "<td>".$rango['valmin']."</td>";
   echo "<td>".$rango['valmax']."</td>";?>
	<td><a href='index.php?action=srangosgraffrec&admin=borrar&id=<?php echo $rango['celdaDelsec']."&numop=".$rangoGController->getNumop()."&secc=".$rangoGController->getSeccion()?>' onClick="return validar(this);">
	<i class="fa fa-times"></i></a></td>
  </tr>
<?php }?>
    </table>
</div></div>
</form>
</div>

<!-- /.box -->

</section>