<?php

require_once "Models/conexion.php";


class DatosInspector extends Conexion{


    public function listainspectores($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ins_clave, ins_nombre,ins_usuario from ca_inspectores");
			
			$stmt-> execute();
			return $stmt->fetchall();
		
	}
	
	
	public function getInspectorxId($cveins1){
	    $sqltrep="SELECT
ca_inspectores.ins_nombre
FROM
ca_inspectores
where
ca_inspectores.ins_clave=:cveins1";
	    $stmt=Conexion::conectar()->prepare($sqltrep);
	    $stmt->bindParam(":cveins1", $cveins1,PDO::PARAM_INT);
	    $stmt-> execute();
	    return $stmt->fetch();
	    
	
	}
	
	public function getInspector($usuario,$tabla){
	    $sqlins="SELECT ca_inspectores.ins_usuario, ca_inspectores.ins_nombre FROM $tabla
 WHERE ca_inspectores.ins_usuario =:nins";
	    
	    $stmt=Conexion::conectar()->prepare($sqlins);
	    $stmt->bindParam(":nins", $usuario, PDO::PARAM_INT);
	    $stmt-> execute();
	   
	    return $stmt->fetch();
	    
	}

	public static function editarInspector($usuario,$ntec,$tabla){
	    $sqlins = "UPDATE ".$tabla."
SET `ins_usuario` = :login
WHERE `ins_clave` = :ntec";
	    try{
	    $stmt=Conexion::conectar()->prepare($sqlins);
	    $stmt->bindParam(":login", $usuario, PDO::PARAM_STR);
	    $stmt->bindParam(":ntec", $ntec, PDO::PARAM_STR);
	    $stmt-> execute();
	    }catch(PDOException $ex){
	        new Exception("Hubo un error al actualizar el inspector");
	    }
	 
	    
	}
	
	public static function borrarInspector($usuario,$tabla){
	    $sql3 = "UPDATE `ca_inspectores`
SET `ins_usuario` = ''
WHERE `ins_usuario` = :login";
	    try{
	        $stmt=Conexion::conectar()->prepare($sql3);
	        $stmt->bindParam(":login", $usuario, PDO::PARAM_STR);
	      
	        $stmt-> execute();
	    }catch(PDOException $ex){
	        new Exception("Hubo un error al eliminar el inspector");
	    }
	    
	    
	}
	
}

