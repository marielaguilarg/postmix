	<?php

require_once "Models/conexion.php";


class Datosnuno extends Conexion{
	# CLASE NIVEL 1n1


	public function vistaN1Model($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n1_id, n1_nombre FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}


	public function vistaN1opcionModel($idn1, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n1_id, n1_nombre, n1_idcliente FROM ca_nivel1 WHERE n1_id=:idn1");

		$stmt-> bindParam(":idn1", $idn1, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}
}


?>