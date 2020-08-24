<link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">

	<link href="views/dist/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<link href="views/dist/css/responsive.bootstrap.min.css" rel="stylesheet">



	<script type="text/javascript" language="javascript" src="views/dist/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.responsive.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/responsive.bootstrap.min.js"></script>

<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script language="JavaScript" type="text/JavaScript">



function enviar(direccion)
{
if(direccion!="")
		document.form1.action=direccion;
		
	document.form1.submit();
}



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





</script>



<?php

include 'Controllers/listaReportesController.php';

$listaRepController=new ListaReportesController();

$listaRepController->vistaListaReportes();
$resumenRes=new ResumenResultadosController;


$resumenRes->encabezaConsulta();

?>

 <section class="content-header">

<ol class="breadcrumb">

            <?php Navegacion::desplegarNavegacion();?>

  </ol>


    </section>



    <!-- Main content -->

    <section class="content container-fluid">
    <div>
     <form name="form1" action="index.php?action=resumenresultados" method="post">
 <?php include "encabeza_resultados.php";?>
</form>
</div>
     
  <div class="row">
        <div class="col-md-12">


      <!----- Inicia contenido ----->

     <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a class="nav-link"  href="javascript:enviar('');" ><?php echo T_("RESULTADOS")?></a></li>
              <li  class="active"><a href="#tab_2" data-toggle="tab"> <?php echo T_("REPORTES VISITA")?></a></li>
            </ul>
            <div class="tab-pane" id="tab_2">
                  <div class="box">
          
         
            <div class="box-body ">
              <table  class="table table-striped table-bordered dt-responsive" id="example">
            <thead>
            <tr>

                <th><?php  echo T_("REPORTE NO.")?></th>

              
                <th><?php  echo T_("PUNTO DE VENTA")?></th>

                <th><?php  echo T_("MES")?></th>

                <th><?php  echo T_("ESTADO")?></th>
                <th><?php  echo T_("CIUDAD")?></th>

                <th><?php  echo T_("DIRECCION")?></th>

                
            </tr>
</thead>
    

        <tbody>

        

        <?php foreach($listaRepController->getListaReportes() as $reporte){

            
        	$mes=Utilerias::cambiaMesGIng($reporte ["MesAsignacion"]);
        	$direccion="index.php?action=resultadosxrep&numrep=" . $reporte ["NumReporte"]."&cser=".$listaRepController->getVserviciou()."&ccli=".$listaRepController->getVclienteu();
        	
            //despliego renglones de solicitud

            ?>

            <tr>

                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["NumReporte"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["PuntoVenta"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $mes?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["est_nombre"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["une_dir_municipio"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["direccion"];?></a></td>

             

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
        </div>
        </div>

	  <!----- Finaliza contenido ----->

    </section>

