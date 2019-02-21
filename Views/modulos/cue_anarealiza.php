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
<form name="formfiltro" action="#" method="post" > 
  
 
              <h3 class="box-title"><?php echo "BUSCAR PUNTO DE VENTA"?></h3>

             <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="fil_ptoventa" class="form-control pull-right" placeholder="Buscar">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div></form>
            </div>
            <!-- /.box-header -->
            
            
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-striped">
              <thead>
            <tr>

                <th>NO. MUESTRA</th>

              
                <th>SERVICIO</th>

                <th>ID CLIENTE</th>

                <th>PUNTO DE VENTA</th>
                <th>LABORATORIO</th>

                <th colspan="2">FISICOQUIMICO</th>
                <th colspan="2">MICROBIOLOGICO</th>

                
            </tr>
			<tr><th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>FECHA</th>
			<th>ANALISTA</th>
			<th>FECHA</th>
			<th>ANALISTA</th></tr>
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
<td ><?php echo $reporte["une_idpepsi"]?></td>
	
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
