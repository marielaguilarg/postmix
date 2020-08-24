  <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>
<section class="content-header">
<h1>NIVEL 1: <?php echo Estructura::nombreNivel(1, 1)?></h1>
</section>
<section class="content container-fluid">
 

<?php

$ingreso = new NunoController();
$ingreso -> vistanunoController();

?>

</section>