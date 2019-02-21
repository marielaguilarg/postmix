<section class="content-header">
      <h1>COMENTARIOS ESTANDAR<small></small></h1>
<ol class="breadcrumb" >
<?php
				$ingreso = new EstandarController();
				$ingreso -> titestcom();
				?>
        
</ol>
				<?php
				$ingreso = new EstandarController();
				$ingreso -> botonnuevoestandarcoment();
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
				$ingreso = new EstandarController();
				$ingreso -> borrarEstComentarioController();
				$ingreso -> vistaestandarcoment();
				?> 
	                
	                </table>
	         </div>
		</section>                