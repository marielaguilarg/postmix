<?php

require_once "Models/conexion.php";

class DatosEnlaces extends Conexion{

	public function vistaEnlacesModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_id,  ser_descripcionesp FROM ca_servicios");

		$stmt-> execute();

		return $stmt->fetchall();

		$stmt->close();
	}

}

?>