
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
$('#example').DataTable( {
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
</script><?php
include 'Controllers/facturasController.php';
$facturasController=new FacturasController();
$facturasController->vistaListaFacturas();
?>  <!-- Main content -->   <section class="content container-fluid">     <!----- Inicia contenido ----->     <?php echo $facturasController->getMensaje()?>      <div class="row">    	 <div class="col-md-12">     <div class="box">    <div class="box-header">    <h3 class="box-title">REGISTRO FACTURAS</h3>   </div>   <!-- /.box-header -->   <?php $facturasController->getMensaje()?>   <div class="box-body">    <form id="form1" name="form1" method="post" action="index.php?action=listafacturas&admin=crear">  <input name="mini" type="hidden" value="<?php echo $facturasController->getMesini()?>">                   <input name="mfin" type="hidden" value="<?php echo $facturasController->getMfin()?>">                   <input name="mesfin" type="hidden" value="<?php  echo $facturasController->getMesfin()?>">                   <input name="cclien" type="hidden" value="<?php echo $facturasController->getCclien()?>">                   <input name="cserv" type="hidden" value="<?php echo $facturasController->getCserv()?>">         <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> <thead>  <tr>     <th>NO. </th>                <th>NO. REPORTE</th>                <th>PUNTO DE VENTA</th>                <th>MES ASIGNACION</th>                 <th>NO. MUESTRA</th>                  <th>EMBOTELLADORA</th>                   <th>NO.FACTURA</th>                       <th>SIN COBRO</th>                   <th>FINALIZADO </th>                     </tr>
        </thead>
        <tbody>
        
        <?php foreach($facturasController->getListaFacturas() as $factura){
            
            //despliego renglones de solicitud
            ?>
            <tr>
                <td><?php echo $factura["num"]?></td>
                <td><?php echo $factura["nrep"]?></td>
                <td><?php echo $factura["punvta"]?></td>
                <td><?php echo $factura["mesas"]?></td>
                <td><?php echo $factura["nmue"];?></td>      <td><?php echo $factura["idemb"]?></td> <td><?php echo $factura["numfac"]?></td>
                <td><?php echo $factura["sincob"]?></td> <td><?php echo $factura["final"]?></td>         </tr>      <?php } //fin foreach?>        </tbody>    </table>    <div><button  type="submit" class="btn btn-info pull-right">Guardar</button></div></form>
            </div>            <!-- /.box-body -->      </div>          <!-- /.box -->        </div>        </div>	  <!----- Finaliza contenido ----->
    </section>
