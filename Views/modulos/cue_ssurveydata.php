<script src="views/dist/js/jquery-3.0.0.min.js"></script>

	<link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">

	<link href="views/dist/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<link href="views/dist/css/responsive.bootstrap.min.css" rel="stylesheet">



	<script type="text/javascript" language="javascript" src="views/dist/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.responsive.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/responsive.bootstrap.min.js"></script>

<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>



<script language="JavaScript" type="text/JavaScript">



$(document).ready(function() {

$('#sd').DataTable( {

language: {

    processing:     "Procesando...",

    search:         "Buscar:",

    lengthMenu:    "Mostrar _MENU_ registros",

    info:           "Mostrando del _START_ al _END_ de _TOTAL_ registros",

    infoEmpty:      "Mostrando del 0 al 0 de un total de 0 registros",

    infoFiltered:   "(filtrado de un total de _MAX_ registros)",

    infoPostFix:    "",

    loadingRecords: "Cargando...",

    zeroRecords:    "No se encontraron resultados",

    emptyTable:     "Ningún dato disponible en esta tabla",

    paginate: {

        first:      "Primero",

        previous:   "Anterior",

        next:       "Siguiente",

        last:       "Último"

    },

    aria: {

        sortAscending:  ": Activar para ordenar la columna de manera ascendente",

        sortDescending: ": Activar para ordenar la columna de manera descendente"

    }

}

} );

} );


function cargar(form)
{
//alert("W");
if (confirm("Esta acción reconfigurará el Survey Data\ny los cambios realizados se perderán.¿Desea continuar?"))
	{
	//	window.open("MESprincipal.php?op=gensdata&admin=cargar",'self') ;
//	document.form1.submit();
	return true;
	}
	else return false;
}
function validar(valor)
{
	if (confirm("¿Desea eliminar la columna "+ valor+" ?"))
	{
		return true;
	}
	else return false;
}
</script>

<?php

include 'Controllers/configuracionSDController.php';
$confSDController= new ConfiguracionSDController();
$confSDController->vistaConfiguracion();
?>
<section class="content-header">

<div class="row">
<div class="col-md-12">
 <a class="btn btn-default pull-right"  href="index.php?action=ssurveydata&admin=cargar" > 
 <i class="fa fa-cog" aria-hidden="true"></i>  Reconfigurar </a>
    
<a  class="btn btn-default pull-right" style="margin-right: 18px" href="index.php?action=snuevosd" > 
<i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
       </div>
   </div>  
</section>


<!-- Main content -->

<section class="content container-fluid">
  
<!----- Inicia contenido ----->


<?php
echo $confSDController->getMensaje();

?>
    <div class="row">

        	 <div class="col-md-12">

          <div class="box">

            <div class="box-header">

              <h3 class="box-title">CONFIGURACION DEL SURVEY DATA</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">
  <table  id="sd" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">

        <thead>

            <tr>
          <th >NO. COLUMNA</th> 
          <th >TIPO REACTIVO</th>
          <th >NO. REACTIVO </th>
          <th >DESCRIPCION</th>
          <th >NOMBRE DE  COLUMNA</th>
          <th >NO. RENGLON</th> 
          <th >VAL. POR OMISION </th>
		  <th >BORRAR</th>
        </tr>
       </thead>
       <tbody>
       <?php  
       foreach ($confSDController->getListaColumnas() as $columna){
       	echo "<tr><td>". $columna["numerocol"]."</td>
       	<td>".	$columna["tiporeac"]."</td>
       	<td>" .$columna["numeroreac"]."</td>
         <td>" .$columna["descripcion"]."</td>
         <td>".$columna["nombrecol"]."</td>
		 <td>".$columna["numerorenglon"] ."</td>
		 <td>".$columna["valor"];
          
          echo '</td><td><a href="index.php?action=ssurveydata&admin=borrar&id=';
          echo $columna['numerocol'].'" onclick="return validar('.$columna['numerocol'].');">
<i class="fa fa-trash-o"></i></a></td>';

		echo '  <input name="idseccion" type="hidden" value="{IdSecc}">
          <input name="IdR" type="hidden" value="{IdReport}">
        </tr>';}
      ?>
      </tbody>
      </table>

</div></div></div></div>





</section>