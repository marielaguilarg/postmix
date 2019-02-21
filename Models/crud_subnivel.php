<?php

require_once "Models/conexion.php";


class DatosSubnivel extends Conexion{

#vistaponderacion

	public function vistaNivelModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT tip_clave, tip_descripcion, tip_nivel FROM $tabla where tip_nivel=:numnivel");
		
		$stmt-> bindParam(":numnivel", $datosModel, PDO::PARAM_INT);
				
		$stmt-> execute();

		return $stmt->fetchAll();
	}

}
