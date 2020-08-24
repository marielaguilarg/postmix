<section class="content-header">
      <h1>Franquicias &nbsp; &nbsp; <small></small></h1>
     
    </section>
   <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>
    <!-- Main content -->
    <section class="content container-fluid">

<?php

$ingreso = new franquiciaController();
$ingreso -> borrarFranquiciaController();
$ingreso -> vistafranquiciaController();


?>

    </section>

<?php

if(isset($_GET["action"])){

	if($_GET["action"] == "cambio"){
		echo "Cambio Exitoso";
	}
}

?>
