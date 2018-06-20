<?php

require_once "Models/conexion.php";


class Datosndos extends Conexion{
	# CLASE NIVEL 1n1


	public function vistandosModel($datosModel,$tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n2_id, n2_nombre FROM $tabla WHERE n2_idn1=:idn1");
		$stmt-> bindParam(":idn1", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function vistaN2opcionModel($idn2, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT n2_idn1, n2_id, n2_nombre FROM ca_nivel2 WHERE n2_id=:idn2");

		$stmt-> bindParam(":idn2", $idn2, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}  

   public function nombreNivel2($id,$tabla) {

            $sql = "SELECT n2_id, n2_nombre FROM $tabla where n2_id=:id ";

            $stmt = Conexion::conectar()-> prepare($sql);
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);
            $stmt->execute();
            $res=$stmt->fetchAll();
            foreach ($res as $row) {
              $nombre = $row["n2_nombre"];
            }
             return $nombre;
            }

}


?>