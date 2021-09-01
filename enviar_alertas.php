<?php

$base=getcwd();

require_once "Controllers/correoAlertaController.php";




$ac= new CorreoAlertaController(1);

$ac->enviarCorreo();
