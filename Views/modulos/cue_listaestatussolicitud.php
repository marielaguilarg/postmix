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
include 'Controllers/certificacionController.php';
$certificacionController=new CertificacionController();
$certificacionController->vistaEstatusSolicitud();
?>
 <section class="content-header">
      <h1>CERTIFICACION AGUA POSTMIX NUEVO PUNTO DE VENTA</h1>
     
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!----- Inicia contenido ----->
       
        <div class="row">
        	 <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ESTATUS SOLICITUD</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>NO. SOLICITUD</th>
                <th>ID CUENTA</th>
                <th>PUNTO DE VENTA</th>
                <th>INICIO PROCESO</th>
                <th>VISITA PUNTO DE VENTA</th>
                <th>TIEMPO RESPUESTA (DIAS)</th>
                <th>ENTREGA MUESTRAS</th>
                <th>LABORATORIO</th>
                <th>CAPTURA FISICOQUIMICOS</th>
                <th>CAPTURA MICROBIOLOGICOS</th>
                <th>TIEMPO RESPUESTA LABORATORIO (DIAS)</th>
            </tr>
        </thead>
        <tbody>
        
        <?php foreach($certificacionController->getListaSolicitudes() as $solicitud){
            
            //despliego renglones de solicitud
            ?>
            <tr>
                <td><?php echo $solicitud["Nsol1"]?></td>
                <td><?php echo $solicitud["idcuen"]?></td>
                <td><?php echo $solicitud["Punto1"]?></td>
                <td><?php echo $solicitud["inip"]?></td>
                <td><?php echo $solicitud["fvis"];?></td>
                
                <td><?php echo $solicitud["tres"]?></td>
                <td><?php echo $solicitud["entmu"]?></td>
                
                   <td><?php echo $solicitud["lab"]?></td>
                <td><?php echo $solicitud["capfis"]?></td>
                <td><?php echo $solicitud["capmic"]?></td>
                <td><?php echo $solicitud["tresl"];?></td>
                
              
          
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
	  <!----- Finaliza contenido ----->
    </section>
