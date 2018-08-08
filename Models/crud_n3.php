<?php

require_once "Models/conexion.php";


class Datosntres extends Conexion{
	# CLASE NIVEL 1n1


	public function vistantresModel($datosModel,$tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n3_id, n3_nombre FROM $tabla WHERE n3_idn2=:idn2");
		$stmt-> bindParam(":idn2", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}


	public function vistaN3opcionModel($idn3, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n3_idn2, n3_id, n3_nombre FROM ca_nivel3 WHERE n3_id=:idn3");

		$stmt-> bindParam(":idn3", $idn3, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}

	public function vistatresModel($datosModel,$idn3,$tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n3_id, n3_nombre FROM $tabla WHERE n3_idn2=:idn2 and n3_id=:idn3");
		$stmt-> bindParam(":idn2", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":idn3", $idn3, PDO::PARAM_INT);
		

		$stmt-> execute();

		return $stmt->fetchAll();
	}




}


?>