<?php



require_once "Models/conexion.php";


class Estructura extends Conexion{

	public function vistaEstructuraCompleta($idnivel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT mee_numnivel, mee_descripcionnivelesp, mee_descripcionniveling FROM cnfg_estructura WHERE mee_numnivel=:idnivel");
				
		$stmt->bindParam(":idnivel", $idnivel, PDO::PARAM_INT);					
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}

	

}

?>	