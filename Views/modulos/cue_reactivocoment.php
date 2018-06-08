<section class="content-header">
      <h1>Comentarios Ponderado <small></small></h1>
<ol class="breadcrumb" >

        
</ol>
				<?php
				$ingreso = new PonderacionController();
				$ingreso -> botonnuevorcoment();
				?>
          
       
	<section class="content container-fluid">
		<div class="box">
	 			
	              <table class="table" table-condensed>
	                <tr>
	                  <th style="width: 5%">No.</th>
	                  <th style="width: 36%">COMENTARIOS</th>
	                  <th style="width: 15%">BORRAR</th>
	                </tr>
				<?php
				$ingreso = new PonderacionController();
				$ingreso -> borrarPondComentarioController();
				$ingreso -> vistareactivocoment();
				?> 
	                
	                </table>
	         </div>
		</section>                