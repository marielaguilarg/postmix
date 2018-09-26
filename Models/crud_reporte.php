<?php

require_once "Models/conexion.php";


class DatosReporte extends Conexion{

#vistareporte
	public function ReporteGenerales( $numser, $numrep, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT i_claveservicio, i_numreporte,  i_unenumpunto, i_claveinspector, i_fechavisita, i_mesasignacion, i_horaentradavis, i_horasalidavis, i_responsablevis, i_puestoresponsablevis, i_comentario, i_horaanalisissensorial, i_reportecic, i_numreportecic, i_coordenadasxy, i_finalizado, i_fechafinalizado, i_sincobro, i_numfactura, i_fechafactura, i_estatusfactura, i_observaciones, i_reasigna FROM $tabla WHERE i_claveservicio=:numser and i_numreporte = :numrep");
			
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);			
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}


	public function CalculaNumReporte($numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT max(i_numreporte) AS numrep 
				 FROM $tabla WHERE i_claveservicio=:numser");
			
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}



}

?>		