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
		$stmt = Conexion::conectar()-> prepare("SELECT fra_id, fra_descripcion FROM $tabla ");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	#registo franquicia

public function registroFranquiciaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("INSERT INTO $tabla (fra_idcuenta, fra_descripcion) VALUES (:idcuen,:descripcuen)");


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
		$stmt = Conexion::conectar()-> prepare("SELECT  fra_id, fra_idcuenta, fra_descripcion FROM $tabla WHERE fra_id= :fra_id");
		$stmt->bindParam(":fra_id", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}

#actualizar franquicia
	public function actualizarFranquiciaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fra_idcuenta= :fraidcuen, fra_descripcion = :fradescrip WHERE fra_id = :fraid");
		
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

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE fra_id = :ids");

		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}



    public function nombreFranquicia($cuenta, $franq,$cliente,$servicio) {

    $sql = "SELECT
ca_franquiciascuenta.fc_idfranquiciacta,
ca_franquiciascuenta.cli_idcliente,
ca_franquiciascuenta.ser_claveservicio,
ca_franquiciascuenta.cue_clavecuenta,
ca_franquiciascuenta.cue_tipomercado,
ca_franquiciascuenta.cf_descripcion
FROM
ca_franquiciascuenta
where ca_franquiciascuenta.fc_idfranquiciacta=:franq and
ca_franquiciascuenta.cli_idcliente=:cliente and
ca_franquiciascuenta.ser_claveservicio=:servicio and
ca_franquiciascuenta.cue_clavecuenta=:cuenta";

    $res = Conexion::conectar()->prepare($sql);
    $res-> bindParam(":cuenta", $cuenta, PDO::PARAM_INT);
    $res-> bindParam(":franq", $franq, PDO::PARAM_INT);
    $res-> bindParam(":cliente", $cliente, PDO::PARAM_INT);
    $res-> bindParam(":servicio", $servicio, PDO::PARAM_INT);
    foreach ($res as $row) {
        $nombre = $row["cf_descripcion"];
    }
   

    return $nombre;
}



}

?>	