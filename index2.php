<?php
session_start();
error_reporting(E_ERROR|E_NOTICE|E_WARNING);
//error_reporting(E_ALL);
//ini_set("display_errors", 1); 



if (isset($_SESSION['Usuario'])) {
	$tiporep=$_GET["action"];
	include "Models/crud_muestras.php";
	include "Models/crud_catalogoDetalle.php";
//	include "views/modulos/cue_".$tiporep.".php";
	include "views/modulos/cue_repFQPDF.php";
//$mvc -> repFQ();

	//echo "con usuario";
} else {
	require_once "Controllers/controller.php";
	$mvc =new MvcController();
	//echo "inicio";
	$mvc -> inicio();
}


?>