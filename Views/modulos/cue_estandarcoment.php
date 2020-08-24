 <script src="js/eliminar.js"></script>
<section class="content-header">
<div class="row" style="margin-top:-40px;" >
   <h1 style="font-size:25px; margin-left: 15px; ">
      COMENTARIOS ESTANDAR</h1>
     </div>
      <ol class="breadcrumb" >
<?php
				$ingreso = new EstandarController();
				$ingreso -> titestcom();
				?>
        
</ol> 
 </section>
			
          
     
	<section class="content container-fluid">
		<?php
				$ingreso = new EstandarController();
				$ingreso -> botonnuevoestandarcoment();
				?>
		<div class="box">			
	              <table class="table table-condensed">
	                <tr>
	                  <th style="width: 5%">No.</th>
	                  <th style="width: 36%">COMENTARIOS</th>
	                  <th style="width: 15%">BORRAR</th>
	                </tr>
				<?php
				$ingreso = new EstandarController();
				$ingreso -> borrarEstComentarioController();
				$ingreso -> vistaestandarcoment();
				?> 
	                
	               
	        
		</section>                