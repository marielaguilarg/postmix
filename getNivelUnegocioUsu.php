<?php
include "Controllers/unegocioController.php";
require_once "Models/crud_n1.php";
//require_once "Models/conexion.php";
include "Models/crud_n2.php";
include "Models/crud_n3.php";
include "Models/crud_n4.php";
include "Models/crud_n5.php";
include "Models/crud_n6.php";
foreach ($_GET as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo,FILTER_SANITIZE_STRING) . "';";
    eval($asignacion);
}

$res = Datosnuno::vistan1Model("ca_nivel1");
$nivel = 1;
if (isset($select1)) {
    $res = Datosndos::vistandosModel($select1, "ca_nivel2");
    $nivel = 2;
} if (isset($select2)) {
    $res = Datosntres::vistantresModel($select2, "ca_nivel3");
    $nivel = 3;
} if (isset($select3)) {
    $res = Datosncua::vistancuaModel($select3, "ca_nivel4");
    $nivel = 4;
} if (isset($select4)) {
    $res = Datosncin::vistancinModel($select4, "ca_nivel5");
    $nivel = 5;
} if (isset($select5)) {
    $res = Datosnsei::vistanseiModel($select5, "ca_nivel6");
    $nivel = 6;
}

foreach ($res as $item) {
    
    $menu[] = array("name" => $item["n" . $nivel . "_nombre"], "value" => $item["n" . $nivel . "_id"]);
}

echo json_encode(['success' => 'true', "replacement" => "", 'menu' => $menu]);