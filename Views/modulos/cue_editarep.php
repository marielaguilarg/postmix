 <section class="content-header">
 <div style="margin-top:10px">
 </div>
<?php
	$ingreso = new ReporteController();
	echo $ingreso->vistaEncabezado();
	?>
	
   <h1>

   SECCIONES DEL REPORTE <small></small></h1>  



     
<ol class="breadcrumb" >

<?php

$ingreso -> vistaRnomservController();
echo $ingreso->ligaRegresar;
?>        
        
</ol>
 </section>     

    <section class="content container-fluid">


      <div class="row">
    <div class="col-md-12" >
     
       

<?php


$ingreso -> vistaseccionReporteController();


?>

</div>
</div>
</section>

       

    </section>
    
   <!-- /.content-wrapper -->
