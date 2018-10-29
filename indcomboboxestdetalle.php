<?php
//error_reporting(E_WARNING|E_ERROR);
@session_start();


require_once "Models/conexion.php";
require_once "Models/crud_catalogoDetalle.php";


foreach ($_GET as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo ,FILTER_SANITIZE_STRING). "';";
  
    eval($asignacion);

}

$res=DatosCatalogoDetalle::listaCatalogoDetalle($numcatalogo,"ca_catalogosdetalle");
foreach ($res as $item) {
    
    $menu[] = array("name" => $item["cad_descripcionesp"], "value" => $item["cad_idopcion"]);
}

echo json_encode(['success' => 'true', "replacement" => "", 'menu' => $menu]);



?>
