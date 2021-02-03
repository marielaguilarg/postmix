<?php
error_reporting(E_ERROR | E_PARSE );

require_once('libs/php-gettext-1.0.12/gettext.inc');
require 'Utilerias/inimultilenguaje.php';
require 'Utilerias/utilerias.php';
 require 'Models/crud_estandar.php';

 require 'Models/crud_ponderacion.php';
 require 'Models/crud_productos.php';

// require 'Models/crud_temporales.php';
 require 'Models/crud_abierta.php';
//include "Controllers/indpostmix/graficaIndicadorv2Controller.php";

//include "Controllers/indpostmix/navegacion.php";
require_once "Controllers/indpostmix/graficajson.php";
// require 'Models/crud_usuario.php';
//
//require_once "Models/crud_estructura.php";
//
//  
//require_once "Models/crud_n1.php";
//require_once "Models/crud_n2.php";
//require_once "Models/crud_n3.php";
//require_once "Models/crud_n4.php";
//require_once "Models/crud_n5.php";
//require_once "Models/crud_n6.php";

@session_start();
set_time_limit(400);

$grafica=new Graficajson();
$grafica->leerFiltros();

$grafica->generarJSON();


  