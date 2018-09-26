<section class="content-header">
      <h1>Comentarios <small></small></h1>
<ol class="breadcrumb" >

        
</ol>
          
<?php

// aqui va el programa de boton nuevo
$ingreso = new seccionController();
$ingreso -> botonnuevocoment();
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
				$ingreso = new seccionController();
				$ingreso -> borrarComentarioController();
				$ingreso -> vistaseccioncoment();
				?> 
	                
	                </table>
	         </div>
		</section>                