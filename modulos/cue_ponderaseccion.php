<?php
$ingreso = new seccionController();
$ingreso -> iniciopoderaseccion();
?> 



<section class="content container-fluid">
	<div class="box">
		 			
        <table class="table" table-condensed>
            <tr>
              <th style="width: 5%">No.</th>
              <th style="width: 36%">CUENTA</th>
              <th style="width: 15%">PONDERACION</th>
              <th style="width: 10%">FECHA INICIO</th>
              <th style="width: 10%">FECHA FINAL</th>
            </tr>
		<?php
		$ingreso = new seccionController();
		$ingreso -> borrarSeccionPonderaController();
		$ingreso -> vistapoderaseccion();
		?> 

		</table>
</div>
</section>                