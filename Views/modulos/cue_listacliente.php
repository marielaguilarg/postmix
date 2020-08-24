<section class="content-header">
 <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>

 <h1>CLIENTES &nbsp; &nbsp;</h1>

<?php

$ingreso = new MvcController();
$ingreso -> borrarClienteController();
$ingreso -> vistaClientesController();

?>

</section>