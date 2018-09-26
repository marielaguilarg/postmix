<?php

require_once "Models/conexion.php";


class DatosFranquicia extends Conexion{


public function listaCuentasModel($tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT cue_id, cue_descripcion FROM $tabla ");
		
		$stmt-> execute();


		return $stmt->fetchAll();
	}



#lista de franquicias

	public function vistaFranquiciasModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT fc_idfranquiciacta, cf_descripcion FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	#registo franquicia

public function registroFranquiciaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("INSERT INTO $tabla (cue_clavecuenta, cf_descripcion) VALUES (:idcuen,:descripcuen)");


		$stmt->bindParam(":idcuen", $datosModel["fracuen"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcuen", $datosModel["franom"], PDO::PARAM_STR);
		if($stmt-> execute()){

			return "success";
		}
		 else{

		 	return "error";
		 }


	}

  
#edita franquicia

	public function editarFranquiciaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  fc_idfranquiciacta, cue_clavecuenta, cf_descripcion FROM $tabla WHERE fc_idfranquiciacta= :fra_id");
		$stmt->bindParam(":fra_id", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}

#actualizar franquicia
	public function actualizarFranquiciaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cue_clavecuenta= :fraidcuen, cf_descripcion = :fradescrip WHERE fc_idfranquiciacta = :fraid");
		
		$stmt-> bindParam(":fraid", $datosModel["fraid"], PDO::PARAM_INT);
		$stmt-> bindParam(":fradescrip", $datosModel["franom"], PDO::PARAM_STR);
		$stmt-> bindParam(":fraidcuen", $datosModel["fraidcuen"], PDO::PARAM_INT);
		
		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}

#borra franquicia
	public function borrarFranquiciaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE fc_idfranquiciacta = :ids");

		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}




}

?>	