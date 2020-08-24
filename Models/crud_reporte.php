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

		
	}


	public function CalculaNumReporte($numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT max(i_numreporte) AS numrep 
				 FROM $tabla WHERE i_claveservicio=:numser");
			
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();

		
	}
	
	public function apartarNumReporte($numser,$usuario){
		$stmt = Conexion::conectar()-> prepare("SELECT max(numreporte) AS numrep
				 FROM temp_insgenerales WHERE claveservicio=:numser");
		
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
		$stmt-> execute();
		
		$ulrep=$stmt->fetch();
	
		if ($ulrep&&$ulrep["numrep"]) {
			
			$numrep=$ulrep["numrep"];
		} else {
			//busco en insgenerales
			$general=DatosReporte::CalculaNumReporte($numser, "ins_generales");
			
			if ($general) {
				$numrep=$general["numrep"];
			} else {
			$numrep=0;
			}
		}
		$numrep+=1;
		$stmt->closeCursor();
		//ahora si lo aparto en la tabla temporal
		try{
		$stmt = Conexion::conectar()-> prepare("INSERT INTO `temp_insgenerales`
            (`claveservicio`,
             `numreporte`,
             `usuario`)
VALUES (:claveservicio,
        :numreporte,
        :usuario);");
		
		$stmt-> bindParam(":claveservicio", $numser, PDO::PARAM_INT);
		$stmt-> bindParam(":numreporte", $numrep, PDO::PARAM_INT);
		$stmt-> bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt-> execute();
		}catch(Exception $ex){
			throw new Exception ("Hubo un error al generar el número de reporte");
		}
		return $numrep;
		
		
	}

	
	public function eliminarReporteTemporal($numser,$numrep,$usuario){
		try{
			//elimino todos sus reportes para que no queden reportes perdidos
			$stmt = Conexion::conectar()-> prepare("delete 
					 FROM temp_insgenerales WHERE  usuario=:usuario");
			
// 			$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
// 			$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
			$stmt-> bindParam(":usuario", $usuario, PDO::PARAM_STR);
			$res=$stmt-> execute();
		//	$stmt->debugDumpParams();
		//	die();
		
		}catch(Exception $ex){
			Utilerias::guardarError("Hubo un error al eliminar el número de reporte".$ex->getMessage());
		}
	
		
		
	}
	


}

?>		