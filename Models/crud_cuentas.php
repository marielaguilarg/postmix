<?php



require_once "Models/conexion.php";


class DatosCuenta extends Conexion{


#vistaclientes

	public function vistaCuentasModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_id, cue_descripcion, cue_tipomercado FROM $tabla;");
		
		$stmt-> execute();

		return $stmt->fetchAll();
		$stmt->close();
	}
	

	public function listaClientesModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cli_id, cli_nombre FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
		$stmt->close();
	}

	public function registroCuentaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("INSERT INTO $tabla (cue_descripcion, cue_tipomercado, cue_siglas, cue_lugar, cue_idcliente) VALUES (:cue_descripcion, :cue_tipomercado, :cue_siglas, :cue_lugar, :cue_idcliente)");

		$stmt->bindParam(":cue_descripcion", $datosModel["nomcuen"], PDO::PARAM_STR);
		$stmt->bindParam(":cue_tipomercado", $datosModel["tipomercuen"], PDO::PARAM_INT);
		$stmt->bindParam(":cue_siglas", $datosModel["siglascuen"], PDO::PARAM_STR);
		$stmt->bindParam(":cue_lugar", $datosModel["lugarcuen"], PDO::PARAM_INT);
		$stmt->bindParam(":cue_idcliente", $datosModel["cliencuen"], PDO::PARAM_INT);
		
		if($stmt-> execute()){

			return "success";
		}
		 else{

		 	return "error";
		 }
		 $stmt->close();

	}


	#edita servicio
	public function editarCuentaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT cue_id, cue_descripcion, cue_tipomercado, cue_siglas, cue_lugar, cue_idcliente FROM $tabla  WHERE  cue_id = :idc");

		$stmt-> bindParam(":idc", $datosModel, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
	}
	
	public function actualizarCuentaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("	UPDATE $tabla SET  cue_descripcion= :cuedes, cue_tipomercado= :cuetipo, cue_siglas= :cuesiglas, cue_lugar= :cuelugar, cue_idcliente= :cuecli WHERE cue_id= :cue_id");
		
		$stmt-> bindParam(":cuedes", $datosModel["cuedes"], PDO::PARAM_STR);
		$stmt-> bindParam(":cuetipo", $datosModel["cuetipo"], PDO::PARAM_INT);
		$stmt-> bindParam(":cuecli", $datosModel["cuecli"], PDO::PARAM_INT);
		$stmt-> bindParam(":cuesiglas", $datosModel["cuesiglas"], PDO::PARAM_STR);
		$stmt-> bindParam(":cuelugar", $datosModel["cuelugar"], PDO::PARAM_STR);
		$stmt-> bindParam(":cue_id", $datosModel["id"], PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}

#borra servicio
	public function borrarCuentaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE cue_id = :ids");

		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}


	 public function vistaCuentasxcliente($idcliente,$tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_id, cue_descripcion, cue_tipomercado FROM $tabla where cue_idcliente=:id_cliente ;");
		$stmt->bindParam("id_cliente", $idcliente,PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetchAll();
	}



}
?>	