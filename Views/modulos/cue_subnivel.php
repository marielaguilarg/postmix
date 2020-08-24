 <script src="js/eliminar.js"></script>
 <section class="content-header">
 <div class="row" style="margin-top:-40px;" >
   <h1 style="font-size:25px; margin-left: 15px; ">CUESTIONARIO <small></small></h1>
</div>
	<ol class="breadcrumb"  >
	<?php
		
	      $vista = new SubnivelController();
	      $vista ->vistaNombresubseccionController()
	?>       
    </ol>

</section>




<?php
	
      $vista = new SubnivelController();
      $vista -> vistasubseccionController();

?>

       


