<?php
@session_start();
require_once "../../Controllers/indpostmix/generadorGraficas.php";
include('../../libs/php-gettext-1.0.12/gettext.inc');
include('../../Utilerias/inimultilenguaje.php');
include('../../Models/conexion.php');
$grafica=new GeneradorGraficas;
$seccion= filter_input(INPUT_GET,"numsec",FILTER_SANITIZE_SPECIAL_CHARS);
$tiposec= filter_input(INPUT_GET,"tiposec",FILTER_SANITIZE_SPECIAL_CHARS);
$grafica->graficaAplica($seccion, $tiposec,1);
