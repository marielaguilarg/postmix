<?php

require_once "Models/conexion.php";


class Datosnsei extends Conexion{
	# CLASE NIVEL 


	public function vistanseiModel($datosModel,$tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n6_id, n6_nombre FROM $tabla WHERE n6_idn5=:ids");
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
		$stmt->close();
	}


	public function vistanseiOpcionModel($datosModel,$tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n6_id, n6_nombre FROM $tabla WHERE n6_id=:ids");
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
	} 

  public function nombreNivel3($id,$tabla) {

            $sql = "SELECT n6_id, n6_nombre FROM $tabla where n6_id:id ";

            $res = Conexion::conectar()-> prepare($sql);
            $res->bindParam("id",$id,PDO::PARAM_INT);
            $res->fetchAll();
            foreach ($res as $row) {
              $nombre = $row["n6_nombre"];
            }
             return $nombre;
        }
}


?>