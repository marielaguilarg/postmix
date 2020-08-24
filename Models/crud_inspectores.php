<?php

require_once "Models/conexion.php";


class DatosInspector extends Conexion{


    public function listainspectores($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ins_clave, ins_nombre,ins_usuario,ins_servicios from ca_inspectores order by CAST(ins_clave AS UNSIGNED)");
			
			$stmt-> execute();
			return $stmt->fetchall();
		
	}
	
	
	public function getInspectorxId($cveins1){
	    $sqltrep="SELECT
ca_inspectores.ins_nombre,ins_clave, ins_servicios,ins_usuario
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
	    $sqlins="SELECT ca_inspectores.ins_usuario, ca_inspectores.ins_nombre,ins_clave FROM $tabla
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
	    	throw new Exception("Hubo un error al actualizar el inspector");
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
	    	throw new Exception("Hubo un error al eliminar el inspector");
	    }
	    
	    
	}
	
	public static function insertarInspector($nomins,$servicios,$usuario,$tabla){
		$ssql="select max(CAST(ins_clave AS UNSIGNED)) as claveins from $tabla;";
		try{
		
			$stmt=Conexion::conectar()->prepare($ssql);
				
			$stmt-> execute();
			$res=$stmt->fetch();
			
			if($res)
			{	$clains=$res["claveins"]+1;
			
		}else{
			$clains=1;
		}
		
		//procedimiento de insercion del servicio
		$sSQL= "insert into $tabla (ins_clave, ins_nombre,ins_usuario, ins_servicios) 
values (:clains, :nomins,:ins_usuario,:ins_servicios)";
		
		$stmt=Conexion::conectar()->prepare($sSQL);
		$stmt->bindParam(":clains", $clains, PDO::PARAM_STR);
		$stmt->bindParam(":nomins", $nomins, PDO::PARAM_STR);
		$stmt->bindParam(":ins_servicios", $servicios, PDO::PARAM_STR);
		$stmt->bindParam(":ins_usuario", $usuario, PDO::PARAM_STR);
			$stmt-> execute();
		
		}catch(PDOException $ex){
			throw new Exception("Hubo un error al insertar el inspector");
		}
		
	}
	
	public static function actualizarInspector($clains,$nomins,$servicios,$usuario,$tabla){
		try{
			//procedimiento de insercion del servicio
			$sSQL=("update $tabla set ins_nombre=:nomins,
ins_servicios=:ins_servicios,ins_usuario=:ins_usuario
 where ins_clave=:claveins");
			
			
			$stmt=Conexion::conectar()->prepare($sSQL);
			$stmt->bindParam(":claveins", $clains, PDO::PARAM_STR);
			$stmt->bindParam(":nomins", $nomins, PDO::PARAM_STR);
			$stmt->bindParam(":ins_usuario", $usuario, PDO::PARAM_STR);
			$stmt->bindParam(":ins_servicios", $servicios, PDO::PARAM_STR);
			
			$stmt-> execute();
		}catch(PDOException $ex){
			throw new Exception("Hubo un error al actualizar el inspector");
		}
		
	}
	
	public static function eliminarInspector($clains,$tabla){
		try{
			//procedimiento de insercion del servicio
			$sSQL=("Delete From ca_inspectores Where ins_clave like :id");
			
			
			$stmt=Conexion::conectar()->prepare($sSQL);
			$stmt->bindParam(":id", $clains, PDO::PARAM_STR);
			
			$stmt-> execute();
		}catch(PDOException $ex){
			throw new Exception("Hubo un error al actualizar el inspector");
		}
		
	}
	
	public function listaInspectoresxServicio($servicio, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ins_clave,
 ins_nombre,ins_usuario,ins_servicios
 from ca_inspectores
WHERE  `ins_servicios` LIKE '%,".$servicio.",%' OR `ins_servicios` LIKE '".$servicio."' 
OR `ins_servicios` LIKE '".$servicio.",%'
OR `ins_servicios` LIKE '%,".$servicio."'
 order by CAST(ins_clave AS UNSIGNED)");
	
		$stmt-> execute();
		return $stmt->fetchall();
		
		
	}
	
	
}

