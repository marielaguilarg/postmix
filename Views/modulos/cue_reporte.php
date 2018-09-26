 <section class="content-header">
 <!-- generar nombre de seccion -->
 <div class="row" style="margin-top:-40px;" >

   <h1 >
	<?php
	$ingreso = new ReporteController();
	$ingreso -> vistaNombreSeccion();
	?>     
    
    

   <small></small></h1>  
	<h1>

	<?php
	if ($_GET["ts"]=="P"){
		$ingreso = new PonderacionController();
		$ingreso -> vistanivelcumplimiento();
	} else {
		if ($_GET["ts"]=="ED"){
		  $ingreso = new EstandarController();
		  $ingreso -> nivelCumplimientoEstandar();
		  
		}else{

			echo '<small>     </small></h1>';
		}
	}	
	?>
     

</div>

	<ol class="breadcrumb"  >
	<?php
	$ingreso = new ReporteController();
	$ingreso -> vistaRnomservController();
	?>     
    </ol>

</section>



<?php
	
      $vista = new ReporteController();
      $vista -> SeleccionaseccionReporteController();

?>
	


     