<?php

require_once "Models/conexion.php";


class DatosMesasignacion extends Conexion{


    public function listaMesAsignacion($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT num_mes_asig, num_per_asig from $tabla order by num_per_asig desc, num_mes_asig ASC ");
			
			$stmt-> execute();
			return $stmt->fetchall();
		
		
	}
	public function listaMesAsignacionCat($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT num_mes_asig, num_per_asig from $tabla");
		
		$stmt-> execute();
		return $stmt->fetchall();
		
		
	}
	public static function insertarMesAsignacion($clames,$claper,$tabla){
		try{
			//procedimiento de insercion del servicio
			$ssql="select * from $tabla
 where num_mes_asig=:clames and num_per_asig=:claper";
			$stmt=Conexion::conectar()->prepare($ssql);
			$stmt->bindParam(":clames", $clames, PDO::PARAM_STR);
			$stmt->bindParam(":claper", $claper, PDO::PARAM_STR);
			$stmt->execute();
		$res=$stmt->fetch();
			
			if ($res !=0){
				throw new Exception("El registro ya existe");
			}else{	  //solo q no exista lo incluimos
				//procedimiento de insercion del servicio
				$sSQL= "insert into $tabla (num_mes_asig, num_per_asig)
 values (:clames, :claper)";
			}
			
			$stmt=Conexion::conectar()->prepare($sSQL);
			$stmt->bindParam(":clames", $clames, PDO::PARAM_STR);
			$stmt->bindParam(":claper", $claper, PDO::PARAM_STR);
			
			$stmt-> execute();
		}catch(PDOException $ex){
			throw new Exception("Hubo un error al insertar");
		}
		
	}
	public static function borrarMesAsignacion($id,$tabla){
		try{
			//procedimiento de insercion del servicio
			$sSQL="Delete From $tabla Where concat(num_mes_asig,'.',num_per_asig) like :id";
			
			$stmt=Conexion::conectar()->prepare($sSQL);
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			$stmt-> execute();
		}catch(PDOException $ex){
			throw new Exception("Hubo un error al borrar");
		}
		
	}
	

	
}

?>		