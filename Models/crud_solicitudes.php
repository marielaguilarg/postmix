<?php

require_once "Models/conexion.php";


class DatosSolicitud extends Conexion{

	public function cuentasolicitudModel($numrep, $numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  FROM cer_solicitud WHERE sol_numrep =:numrep AND sol_claveservicio =:numser");
		
		$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);			
		$stmt-> execute();

		return $qty=$stmt->RowCount();;
		$stmt->close();
	}

	public function estatusSolicitudModel($numrep, $numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  FROM cer_solicitud, sol_estatussolicitud WHERE sol_numrep =:numrep AND sol_claveservicio =:numser");
		
		$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);			
		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
	}


}

?>	






