<?php
foreach($_GET as $nombre_campo=>$valor) {
    $asignacion = "\$" . $nombre_campo . "='" .filter_input(INPUT_GET,$nombre_campo, FILTER_SANITIZE_STRING). "';";
    
    eval($asignacion);
}