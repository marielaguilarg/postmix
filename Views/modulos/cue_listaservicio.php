 <section class="content-header">
 <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>
      <h1>SERVICIOS &nbsp; &nbsp;</h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">


<?php

$ingreso = new servicioController();
$ingreso -> borrarServicioController();
$ingreso -> vistaServiciosController();

?>

</section>