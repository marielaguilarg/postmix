<?php



require_once "Models/conexion.php";





class Datosncua extends Conexion{

	# CLASE NIVEL 1n1





	public function vistancuaModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n4_id, n4_nombre FROM $tabla WHERE n4_idn3=:idn3");

		$stmt-> bindParam(":idn3", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetchAll();

	}



	public function vistaN4opcionModel($idn4, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n4_id, n4_nombre FROM ca_nivel4 WHERE n4_id=:idn4");



		$stmt-> bindParam(":idn4", $idn4, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetch();

	}



 public function nombreNivel4($id,$tabla) {



            $sql = "SELECT n4_id, n4_nombre FROM $tabla where n4_id=:id ";



            $stmt = Conexion::conectar()-> prepare($sql);

            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            $stmt->execute();

            $res=$stmt->fetchAll();

            foreach ($res as $row) {

              $nombre = $row["n4_nombre"];

            }

             return $nombre;

        }

}





?>