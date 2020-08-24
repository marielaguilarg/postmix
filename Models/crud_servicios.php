<?php

require_once "Models/conexion.php";


class DatosServicio extends Conexion{

#vistaservicios

	public function vistaServiciosModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_id, ser_descripcionesp FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function vistaServiciosModelMenu($tabla, $grupous,$user){
		//var_dump($grupous);
		if ($grupous=="muh") {
			$stmt = Conexion::conectar()-> prepare("SELECT ser_id, ser_descripcionesp FROM ca_servicios inner join cnfg_usuarios on ser_id=cus_servicio where cus_email = :user and ser_estatus=1");

				$stmt-> bindParam(":user", $user, PDO::PARAM_STR);
		} else {
			$stmt = Conexion::conectar()-> prepare("SELECT ser_id, ser_descripcionesp FROM $tabla where ser_estatus=1 and ser_acargo=1");
		}

		$stmt-> execute();
	//	$stmt->debugDumpParams();
		return $stmt->fetchAll();
	}

	public function listaClientesModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cli_id, cli_nombre FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}


	#edita servicio
	public function editarServicioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT ser_id, ser_idcliente, ser_descripcionesp, ser_descripcioning, ser_estatus, ser_acargo  FROM $tabla WHERE ser_id = :ids");
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		$stmt-> execute();
	
		return $stmt->fetch();
	}
	
	#actualizar usuario
	public function actualizarServicioModel($datosModel, $tabla){
        
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ser_idcliente = :ser_idcliente, ser_descripcionesp = :ser_descripcionesp, ser_descripcioning = :ser_descripcioning, ser_estatus = :id_est, ser_acargo = :id_cargo WHERE ser_id = :ser_id");
		
		$stmt-> bindParam(":ser_id", $datosModel["id"], PDO::PARAM_INT);
		$stmt-> bindParam(":ser_idcliente", $datosModel["idclien"], PDO::PARAM_INT);
		$stmt-> bindParam(":ser_descripcionesp", $datosModel["nomesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":ser_descripcioning", $datosModel["noming"], PDO::PARAM_STR);
		$stmt-> bindParam(":id_est", $datosModel["idest"], PDO::PARAM_INT);
		$stmt-> bindParam(":id_cargo", $datosModel["idcargo"], PDO::PARAM_INT);
		
		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}

	public function registroServicioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("INSERT INTO $tabla (ser_idcliente, ser_descripcionesp,ser_descripcioning, ser_estatus, ser_acargo) VALUES (:ser_idcliente, :ser_descripcionesp, :ser_descripcioning , :id_est, :id_cargo)");

		$stmt->bindParam(":ser_idcliente", $datosModel["idclien"], PDO::PARAM_INT);
		$stmt->bindParam(":ser_descripcionesp", $datosModel["nomesp"], PDO::PARAM_INT);
		$stmt->bindParam(":ser_descripcioning", $datosModel["noming"], PDO::PARAM_INT);
		$stmt-> bindParam(":id_est", $datosModel["idest"], PDO::PARAM_INT);
		$stmt-> bindParam(":id_cargo", $datosModel["idacargo"], PDO::PARAM_INT);
		if($stmt-> execute()){

			return "success";
		}
		 else{

		 	return "error";
		 }


	}

#borra servicio
	public function borrarServicioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE ser_id = :ids");

		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}

	public function vistaNomServicioModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_id, ser_descripcionesp FROM $tabla WHERE ser_id=:ids");

		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}

	public function vistaServicioxCliente($cliente, $tabla) {
	    
	    $stmt = Conexion::conectar()-> prepare("SELECT ser_id, ser_descripcionesp FROM ca_servicios WHERE ser_idcliente=:cliente AND ser_estatus=1");
	    $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
	    
	    $stmt->execute();
	    
	    
	    
	    return $stmt->fetchAll();
	}

}

