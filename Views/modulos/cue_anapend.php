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

   muestras <small></small></h1>  


</div>
     
<ol class="breadcrumb" >

<?php
//$ingreso = new ReporteController();
//$ingreso -> vistaRnomservController();
?>        
        
</ol>
 </section>     

    <section class="content container-fluid">


      <div class="row">
    <div class="col-md-12" >
     
       

<?php

$ingreso = new muestrasController();
$ingreso -> listaMuestrasPendientes();


?>

</div>
</div>
</section>

       

    </section>
    
   <!-- /.content-wrapper -->
