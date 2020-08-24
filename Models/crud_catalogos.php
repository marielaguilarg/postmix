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
	
	public function getCatalogo($numcat, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT
  `ca_idcatalogo`,
  `ca_nombrecatalogo`
FROM `ca_catalogos` where ca_idcatalogo=:id");
		
		$stmt-> bindParam(":id", $numcat, PDO::PARAM_INT);
		
		$stmt-> execute();
		return $stmt->fetch();
		
		
	}
	public function insertarCatalogo($nombre, $tabla){
		$ssql="select max(ca_idcatalogo) as clavecat from ca_catalogos";
		try{
			
			$stmt=Conexion::conectar()->prepare($ssql);
			
			$stmt-> execute();
			$res=$stmt->fetch();
			
			if($res)
			{	$clains=$res["clavecat"]+1;
			
			}else{
				$clains=1;
			}
		
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla
            (`ca_idcatalogo`,
             `ca_nombrecatalogo`)
VALUES (:idcatalogo,
        :nombrecatalogo);");
		
		$stmt-> bindParam(":idcatalogo", $clains, PDO::PARAM_INT);
		$stmt-> bindParam(":nombrecatalogo", $nombre, PDO::PARAM_STR);
		
		$stmt-> execute();
	
		}catch(PDOException $ex){
			new Exception("Error al insertar");
		}
		
	}
	
	public function actualizarCatalogo($numcat,$nombre, $tabla){
		try{
		$stmt=Conexion::conectar()->prepare("UPDATE $tabla
SET   `ca_nombrecatalogo` = :nombrecatalogo
WHERE `ca_idcatalogo` = :idcatalogo");
		
		$stmt-> bindParam(":idcatalogo", $numcat, PDO::PARAM_INT);
		$stmt-> bindParam(":nombrecatalogo", $nombre, PDO::PARAM_STR);
		
		$stmt-> execute();
		
		}catch(PDOException $ex){
			new Exception("Error al actualizar");
		}
		
	}
	
	public function borrarCatalogo($numcat, $tabla){
		try{
			$stmt=Conexion::conectar()->prepare("Delete From ca_catalogos Where ca_idcatalogo=:id");
			
			$stmt-> bindParam(":id", $numcat, PDO::PARAM_INT);
			
			$stmt-> execute();
			
		}catch(PDOException $ex){
			new Exception("Error al borrar");
		}
		
	}
	

}

?>	