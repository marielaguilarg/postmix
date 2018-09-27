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

function imprimirCER(nsec){
//'var mform = document.form1;
//var nsec=document.getElementById(numsecc).value;
	// window.open('MEZprincipal.php?op=anaFQ&admin=imp&ntoma='+mform.numsecc.value);
	 window.open('imprimirReporte.php?admin=impcert&nrep='+nsec);
}

function imprimirANA(nsec){
//'var mform = document.form1;
//var nsec=document.getElementById(numsecc).value;
	// window.open('MEZprincipal.php?op=anaFQ&admin=imp&ntoma='+mform.numsecc.value);
	 window.open('imprimirReporte.php?admin=impanag&nrep='+nsec);
}

<!--
function Cargar()
{
	document.form1.action="MENindprincipal.php?op=mindi&admin=lispv";		
	document.form1.submit();	
}


//-->
</script>

<?php
include 'Controllers/certificacionController.php';
$certificacionController=new CertificacionController();
$certificacionController->vistaListaCertificados();
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
              <h3 class="box-title">CERTIFICADOS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No. solicitud</th>
                <th>ID cuenta</th>
                <th>Punto de venta</th>
                <th>Inicio proceso</th>
                <th>Fecha Emisión</th>
                <th>Dias transcurridos</th>
                <th>No. certificado</th>
                <th>Resultado</th>
                <th>Certificado Muesmerc</th>
				<th>Certificado GEPP</th>
            </tr>
        </thead>
        <tbody>
        
        <?php foreach($certificacionController->getListaSolicitudes() as $solicitud){
            
            //despliego renglones de solicitud
            ?>
            <tr>
                <td><?php echo $solicitud["Numcert"]?></td>
                <td><?php echo $solicitud["idcuen"]?></td>
                <td><?php echo $solicitud["Punto"]?></td>
                <td><?php echo $solicitud["fechaini"]?></td>
                <td><?php echo $solicitud["fechater"];?></td>
                <td><?php echo $solicitud["diastrans"]?></td>
                <td><?php echo $solicitud["Nrep"]?></td>
                <td><?php echo $solicitud["resul"]?></td>
                <td><a href="<?php echo $solicitud["impres"]?>"> <span class="pull-right" style="color: #367fa9"><i class="fa fa-print fa-2x" aria-hidden="true"></i></span></a></td>
				<td><a href="<?php echo $solicitud["impanag"]?>"> <span class="pull-right" style="color: #367fa9"><i class="fa fa-print fa-2x" aria-hidden="true"></i></span></a></td>
   
          
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
