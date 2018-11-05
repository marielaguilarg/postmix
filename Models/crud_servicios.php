<?php

require_once "Models/conexion.php";


class DatosServicio extends Conexion{

#vistaservicios

	public function vistaServiciosModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_id, ser_descripcionesp FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function listaClientesModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cli_id, cli_nombre FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}


	#edita servicio
	public function editarServicioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT ser_id, ser_idcliente, ser_descripcionesp, ser_descripcioning FROM $tabla WHERE ser_id = :ids");
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();
	}
	
	#actualizar usuario
	public function actualizarServicioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ser_idcliente = :ser_idcliente, ser_descripcionesp = :ser_descripcionesp, ser_descripcioning = :ser_descripcioning WHERE ser_id = :ser_id");
		
		$stmt-> bindParam(":ser_id", $datosModel["id"], PDO::PARAM_INT);
		$stmt-> bindParam(":ser_idcliente", $datosModel["idclien"], PDO::PARAM_INT);
		$stmt-> bindParam(":ser_descripcionesp", $datosModel["nomesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":ser_descripcioning", $datosModel["noming"], PDO::PARAM_STR);
		
		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}

	public function registroServicioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("INSERT INTO $tabla (ser_idcliente, ser_descripcionesp,ser_descripcioning) VALUES (:ser_idcliente, :ser_descripcionesp, :ser_descripcioning)");

		$stmt->bindParam(":ser_idcliente", $datosModel["idclien"], PDO::PARAM_INT);
		$stmt->bindParam(":ser_descripcionesp", $datosModel["nomesp"], PDO::PARAM_INT);
		$stmt->bindParam(":ser_descripcioning", $datosModel["noming"], PDO::PARAM_INT);
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
	    
	    $stmt = Conexion::conectar()-> prepare("SELECT ser_id, ser_descripcionesp FROM ca_servicios WHERE ser_idcliente=:cliente");
	    $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
	    
	   
	    $stmt->execute();
	    
	    
	    
	    return $stmt->fetchAll();
	}

}

?>	