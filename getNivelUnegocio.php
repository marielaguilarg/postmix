<?php
include "Controllers/unegocioController.php";
require_once "Models/crud_n1.php";
//require_once "Models/conexion.php";
include "Models/crud_n2.php";
include "Models/crud_n3.php";
include "Models/crud_n4.php";
include "Models/crud_n5.php";
include "Models/crud_n6.php";

$unController=new unegocioController;
$unController->selectNivelJsonController();