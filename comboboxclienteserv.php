<?php
error_reporting(E_WARNING);
@session_start();


require_once "Models/conexion.php";
require_once "Models/crud_servicios.php";
require_once "Models/crud_cuentas.php";


foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo ,FILTER_SANITIZE_STRING). "';";
  
    eval($asignacion);

}

$rss=DatosServicio::vistaServicioxCliente($claclien,"ca_servicios");
foreach ($rss as $rows) {
    
    echo "<option value='".$rows['ser_id']."'>".$rows['ser_descripcionesp']."</option>";
    //$i++;
    
}
if($cta==1){
	echo "¬¬";
	
	$rs=DatosCuenta::cuentasxCliente2("ca_cuentas", $claclien);

	foreach ($rs as $rows) {
		
		echo "<option value='".$rows['cue_id']."'>".$rows['cue_descripcion']."</option>";
		//$i++;
		
	}
}





?>
