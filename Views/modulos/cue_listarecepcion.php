

<link href="views/dist/css/dataTables.bootstrap.min.css"
	rel="stylesheet">

<link href="views/dist/css/responsive.bootstrap.min.css"
	rel="stylesheet">



<script type="text/javascript" language="javascript"
	src="views/dist/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript"
	src="views/dist/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" language="javascript"
	src="views/dist/js/dataTables.responsive.min.js"></script>

<script type="text/javascript" language="javascript"
	src="views/dist/js/responsive.bootstrap.min.js"></script>


<script language="JavaScript" type="text/JavaScript">



$(document).ready(function() {

$('#example').DataTable( {

language: {

    processing:     "Procesando...",

    search:         "Buscar:",

    lengthMenu:    "Mostrar _MENU_ registros",

    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",

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

function validar(form){
	if(confirm("¿Realmente desea eliminar?")){
		return true;
	}else{
		//Si el codigo llega hasta aquí, todo estará bien  y realizamos el Submit
		return false;
	}
}
function ajax_print(url){
    $.ajax(url).
        done(function(data){
        	var S = "#Intent;scheme=rawbt;";
            var P =  "package=ru.a402d.rawbtprinter;end;";
            window.location.href="intent:base64,"+data+S+P;
          console.log("intent:base64,"+data+S+P);
        });
    return false;
}
function ajax_printz(url){
    $.ajax(url).
    done(function(data){
      
        window.location.href="arrowhead://x-callback-url/cpclcode?code="+data;
      
    });
return false;
}
//-->

</script>



<?php
include 'Controllers/recepcionController.php';

$recepcionController = new RecepcionController ();

$recepcionController->vistaListaRecepcion ();

?>



<!-- Main content -->

<section class="content container-fluid">
<?php  echo $recepcionController->getMensaje()?>
	<!----- Inicia contenido ----->

	<div class="row">

		<div class="col-md-12">

			<div class="box">

				<div class="box-header">

					<h3 class="box-title">RECEPCION DE MUESTRAS</h3>

				</div>

				<!-- /.box-header -->

				<div class="box-body">

					<table id="example"
						class="table table-striped table-bordered dt-responsive nowrap"
						style="width: 100%">

						<thead>

							<tr>

							  <th >NO.</th>
	 <th >LABORATORIO</th>
	 <th >ENTREGA</th>
   	 <th >RECIBE</th>
     <th >FECHA</th>
     <th >HORA</th>
   	 <th >DETALLE</th>
     <th >IMPRIMIR</th>
     <th >ELIMINAR</th>

							</tr>

						</thead>

						<tbody>

        

        <?php

foreach ( $recepcionController->getListaRecepciones() as $recepcion ) {
		// despliego renglones de solicitud
									?>
            <tr>

								<td><?php echo $recepcion["numcat"]?></td>

								<td><?php echo $recepcion["laborat"]?></td>

								<td><?php echo $recepcion["celdaeditcat"]?></td>

								<td><?php echo $recepcion["recibe"]?></td>

								<td><?php echo $recepcion["fecrecibo"]?></td>

								<td><?php echo $recepcion["horrecibo"]?></td>

								<td><?php echo $recepcion["celdaSumniv"]?></td>

								<td><?php echo $recepcion["imprec"] ?></td>

								<td><?php echo $recepcion["delcat"]?></td>





							</tr>

                 <?php } //fin foreach?>



        </tbody>

					</table>

				</div>

				<!-- /.box-body -->



			</div>

			<!-- /.box -->

		</div>

	</div>

<div class="row">
   <div class="col-md-4" style="margin-top:3px">&nbsp;</div>
<div class="col-md-4" style="text-align:center">
    
<a class="btn  btn-primary " href="index.php?action=nuevarecepcion"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
       </div>
       <div class="col-md-4" style="margin-top:3px">&nbsp;</div>
   </div>

	<!----- Finaliza contenido ----->

</section>

