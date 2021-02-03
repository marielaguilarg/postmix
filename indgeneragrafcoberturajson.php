<?php
error_reporting(E_ERROR | E_PARSE );

require_once('libs/php-gettext-1.0.12/gettext.inc');
require 'Utilerias/inimultilenguaje.php';
require 'Utilerias/utilerias.php';
 require 'Models/crud_estandar.php';
 require 'Models/crud_ponderacion.php';
 require 'Models/crud_productos.php';
 require 'Models/crud_temporales.php';

require_once "Controllers/indpostmix/graficaCoberturajson.php";
@session_start();
set_time_limit(400);

$grafica=new GraficaCoberturaJson();
$grafica->leerFiltros();



$coloresgraf=array("#5cd65c","#ff1a1a","#6600ff","#ffff66","#ff4d4d"," #00e6e6"," #ff9900");
$grafica->mostarGrafica();


  