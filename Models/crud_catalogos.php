<?php

require_once "Models/conexion.php";


class DatosCatalogo extends Conexion{


    public function listaCatalogo($numcat, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT cad_idopcion, cad_descripcionesp FROM ca_catalogosdetalle where cad_idcatalogo=:numcat order by cad_idopcion");

			$stmt-> bindParam(":numcat", $numcat, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetchall();
		
			$stmt->close();
	}

	public function opcionSelCatalogo($numcat, $numop, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT cad_descripcionesp FROM $tabla  WHERE cad_idcatalogo =:numcat AND cad_idopcion =:numop");

			$stmt-> bindParam(":numcat", $numcat, PDO::PARAM_INT);
			$stmt-> bindParam(":numop", $numop, PDO::PARAM_INT);
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();
	}		


}

?>	