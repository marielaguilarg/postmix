<link href="views/dist/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<link href="views/dist/css/responsive.bootstrap.min.css" rel="stylesheet">



	<script type="text/javascript" language="javascript" src="views/dist/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.responsive.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/responsive.bootstrap.min.js"></script>

<script language="JavaScript" type="text/JavaScript"> 
function imprimirFQ(nsec){
//'var mform = docume'nt.form1;
//var nsec=document.getElementById(numsecc).value;
	 window.open("index2.php?action=repFQPDF&ntoma="+nsec);
	 //window.open('index2.php&ntoma=6579');
	 //window.moveTo(0, 0);
}

function imprimirMB(nsec){
//var mform = document.form1;
//   alert (mform.numsecc.value);
	 window.open("index2.php?action=repMBPDF&ntoma="+nsec);
}

function imprimirPDF(){
	 window.open('MEZprincipal.php?op=pdfFQ');
}

$(document).ready(function() {

$('#tabla1').DataTable( {

language: {

    processing:     "Procesando...",

    search:         "BUSCAR",

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



 <section class="content-header">
  <div class="row" style="margin-top:-40px;" >

   <h1 style="font-size:25px; margin-left: 15px; ">
MUESTRAS ANALIZADAS <small></small></h1>  
  

</div>
<?php $muestrasController=new muestrasController();
$muestrasController->listaMuestrasRealizadas()?>
 <ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
      </ol>
 </section>     

    <section class="content container-fluid">

  <div class="box">
          
            <div class="box-header">
<!-- <form name="formfiltro" action="#" method="post" >  -->
  
 
<!--              <div class="box-tools"> -->
          
<!--                   <input type="text" name="fil_ptoventa" class="form-control pull-right" placeholder="Buscar"> -->

<!--                   <div class="input-group-btn"> -->
<!--                     <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button> -->
<!--                   </div> -->
<!--                 </div> -->
<!--               </div></form> -->
            </div>
            <!-- /.box-header -->
            
            
            <div class="box-body">
              <table id="tabla1" class="table table-striped table-bordered dt-responsive" style="width:100%">
              <thead>
            <tr>

                <th>NO. MUESTRA</th>

              
                <th>SERVICIO</th>

                <th>NUD</th>

                <th>PUNTO DE VENTA</th>
                <th>LABORATORIO</th>

                <th>FISICOQUIMICO FECHA</th>
                    <th>FISICOQUIMICO ANALISTA</th>
                <th>MICROBIOLOGICO FECHA</th>
                 <th>MICROBIOLOGICO ANALISTA</th>

                
            </tr>
			
    </thead>

        <tbody>

        

        <?php foreach($muestrasController->getListamuestras() as $reporte){

            
        	$nvafecfq=Utilerias::formato_fecha($reporte ["mue_fechoranalisisFQ"]);
        	$nvafecmb=Utilerias::formato_fecha($reporte["mue_fechoranalisisMB"]);
        	$direccion="index.php?action=analisisFQ&tipo=FQ&ntoma=".$reporte["mue_idmuestra"];
        	//despliego renglones ?>

            <tr>
<td ><?php echo $reporte["mue_idmuestra"]?></td>
<td ><?php echo $reporte["ser_descripcionesp"]?></td>
<td ><?php echo $reporte["une_num_unico_distintivo"]?></td>
	
                <td> <?php echo $reporte["une_descripcion"]?></td>
                <td ><?php echo $reporte["cad_descripcionesp"]?></td>
                <td> <a href="<?php echo $direccion?>"><?php echo $nvafecfq?></a></td>
                 <td ><a href="<?php echo $direccion?>"><?php echo $reporte["mue_nomanalistaFQ"]?></a></td>
              <?php  	$direccion="index.php?action=analisisFQ&tipo=MB&ntoma=".$reporte["mue_idmuestra"];?>
        
                <td><a href="<?php echo $direccion?>"> <?php echo $nvafecmb?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["mue_nomanalistaMB"]?></a></td>
             
             

            </tr>

                 <?php } //fin foreach?>



        </tbody>

    </table>

            </div>

            <!-- /.box-body -->
   <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                 <?php if($muestrasController->getPages()!=null) echo $muestrasController->getPages()->display_pages() ?>
                </ul>
            </div>


          </div>

</section>

       

    
   <!-- /.content-wrapper -->
