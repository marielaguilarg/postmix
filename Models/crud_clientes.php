<?php



require_once "Models/conexion.php";


class Datos extends Conexion{
	# REGISTRO DE CLIENTES
	#---------------------------------------------
	public function registroUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("INSERT INTO $tabla (cli_nombre) VALUES (:nombrecliente)");
		$stmt->bindParam(":nombrecliente", $datosModel["nombrecliente"], PDO::PARAM_STR);

		if($stmt-> execute()){

			return "success";
		}
		 else{

		 	return "error";
		 }


	}

	#vistaclientes

	public function vistaClientesModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cli_id, cli_nombre FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	#edita cliente
	public function editarClienteModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT cli_id, cli_nombre FROM $tabla WHERE cli_id = :idc");
		$stmt-> bindParam(":idc", $datosModel, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();
	}
	
	#actualizar cliente
	public function actualizarClienteModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cli_id= :id,cli_nombre= :nombre  WHERE cli_id = :id");

		$stmt-> bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
		$stmt-> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		
		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}


# borrar cliente
public function borrarClienteModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE cli_id= :id");

		$stmt-> bindParam(":id", $datosModel, PDO::PARAM_INT);

		
		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}

}

?>