
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
</script>
include 'Controllers/facturasController.php';
$facturasController=new FacturasController();
$facturasController->vistaListaFacturas();
?>
 
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
                <td><?php echo $factura["nmue"];?></td>
                <td><?php echo $factura["sincob"]?></td>
            </div>
    </section>