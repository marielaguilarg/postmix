<?php


class DatosResultadoAnalisis {
	
	public function getListaResultados($numtoma,$tabla){
		$sqld="SELECT aa_resultadoanalisis.pa_numprueba, aa_resultadoanalisis.mue_idmuestra
FROM $tabla WHERE
aa_resultadoanalisis.mue_idmuestra =:numtoma";
		$stmt = Conexion::conectar()-> prepare($sqld);
		
		$stmt-> bindParam(":numtoma", $numtoma, PDO::PARAM_INT);
		
		$stmt-> execute();
		
		return $stmt->fetchAll();
	}
	
	public function insertResultados($numtoma,$numcomp,$numprueba,$tabla){
		$sqld="insert into aa_resultadoanalisis (aa_resultadoanalisis.mue_idmuestra, aa_resultadoanalisis.pa_numcomponente,
aa_resultadoanalisis.pa_numprueba) values (:numtoma, :numcomp, :numprueba)";
		$stmt = Conexion::conectar()-> prepare($sqld);
		
		$stmt-> bindParam(":numtoma", $numtoma, PDO::PARAM_INT);
		$stmt-> bindParam(":numcomp", $numcomp, PDO::PARAM_INT);
		
		$stmt-> bindParam(":numprueba", $numprueba, PDO::PARAM_INT);
		
		$stmt-> execute();
		
		return $stmt->fetchAll();
	}
}

