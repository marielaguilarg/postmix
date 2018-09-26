<section class="content-header">
      <h1>Franquicias &nbsp; &nbsp; <small></small></h1>
     
    </section>

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
