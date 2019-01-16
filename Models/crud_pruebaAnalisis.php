<?php



class DatosPruebaAnalisis {
	
	public function getPruebaAnalisis( $servicio, $componente,$prueba, $tabla){
		$sqlc="  SELECT
  `pa_numservicio`,
  `pa_numcomponente`,
  `pa_numprueba`,
  `pa_tipoanalisis`
FROM $tabla
WHERE `pa_numservicio`=:servicio AND `pa_numcomponente`=:componente
AND `pa_numprueba`=:prueba";
		
		$stmt = Conexion::conectar()-> prepare($sqlc);
		
		$stmt-> bindParam(":servicio", $servicio, PDO::PARAM_INT);
		$stmt-> bindParam(":componente", $componente, PDO::PARAM_INT);
		$stmt-> bindParam(":prueba", $prueba, PDO::PARAM_INT);
		$stmt-> execute();
		
		$res=$stmt->fetch();
		return $res;
		
	}
	public function getPruebaAnalisisxComp(  $componente, $tabla){
		$sqlc="  SELECT
  `pa_numservicio`,
  `pa_numcomponente`,
  `pa_numprueba`,
  `pa_tipoanalisis`
FROM $tabla
WHERE  `pa_numcomponente`=:componente";
		
		$stmt = Conexion::conectar()-> prepare($sqlc);
		
		$stmt-> bindParam(":componente", $componente, PDO::PARAM_INT);
		$stmt-> execute();
		
		$res=$stmt->fetch();
		return $res;
		
	}
	public function insertar($servicio, $componente,$prueba,$tipoanalisis,$tabla){
// 		$sql1="SELECT Max(aa_pruebaanalisis.pa_numprueba) as ulprueba
// 		FROM aa_pruebaanalisis WHERE aa_pruebaanalisis.pa_numcomponente =  :numcomp
// 		and aa_pruebaanalisis.pa_numservicio = :idserv";
// 		$stmt1=Conexion::conectar()-> prepare($sql1);
// 		$stmt1-> bindParam(":idserv", $servicio, PDO::PARAM_INT);
// 		$stmt1-> bindParam(":numcomp", $componente, PDO::PARAM_INT);
// 		$stmt1->execute();
// 		$prueba=$stmt1->fetch();
// 		if($prueba["ulprueba"]&&$prueba["ulprueba"]>1)
// 			$prueba=$prueba["ulprueba"]+1;
// 		else {
// 			$prueba=1;
// 		}
		$sqlc="INSERT INTO $tabla
            (`pa_numservicio`,
             `pa_numcomponente`,
             `pa_numprueba`,
             `pa_tipoanalisis`)
VALUES (:servicio,
        :componente,
        :prueba,
        :tipoanalisis);";
		try{
		$stmt = Conexion::conectar()-> prepare($sqlc);
		
		$stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
		$stmt->bindParam(":componente", $componente, PDO::PARAM_INT);
		$stmt->bindParam(":prueba", $prueba, PDO::PARAM_INT);
		$stmt->bindParam(":tipoanalisis", $tipoanalisis, PDO::PARAM_STR);
		$res=$stmt-> execute();
	
		if(!$res)
			throw new Exception("Error al insertar la prueba");
		}catch(PDOException $ex){
			if($ex->getCode()==23000)
				throw new Exception("Esa prueba ya existe");
			throw new Exception("Error al insertar la prueba ".$ex->getMessage());
		}
	}
	
	public function actualizar($servicio, $componente,$prueba,$tipoanalisis,$ncomponente,$nprueba,$tabla){
		$sqlc=" UPDATE $tabla
SET 
  `pa_numcomponente` =:ncomponente',
  `pa_numprueba` =:nprueba,
  `pa_tipoanalisis` =:tipoanalisis
WHERE `pa_numservicio` =:servicio
    AND `pa_numcomponente` =:componente
    AND `pa_numprueba` =:prueba);";
		try{
			$stmt = Conexion::conectar()-> prepare($sqlc);
			
			$stmt-> bindParam(":servicio", $servicio, PDO::PARAM_INT);
			$stmt-> bindParam(":componente", $componente, PDO::PARAM_INT);
			$stmt-> bindParam(":prueba", $prueba, PDO::PARAM_INT);
			$stmt-> bindParam(":tipoanalisis", $tipoanalisis, PDO::PARAM_STR);
			$stmt-> bindParam(":ncomponente", $ncomponente, PDO::PARAM_INT);
			$stmt-> bindParam(":nprueba", $nprueba, PDO::PARAM_INT);
			if(!$stmt-> execute())
				throw new Exception("Error al actualizar la prueba");
		}catch(PDOException $ex){
			throw new Exception("Error al actualizar la prueba");
		}
	}
	
	public function borrarPruebaAnalisis( $servicio, $componente,$prueba, $tabla){
		$sqlc="  DELETE
FROM $tabla
WHERE `pa_numservicio` = :servicio
    AND `pa_numcomponente` = :componente
    AND `pa_numprueba` = :prueba";
		try{
		$stmt = Conexion::conectar()-> prepare($sqlc);
		
		$stmt-> bindParam(":servicio", $servicio, PDO::PARAM_INT);
		$stmt-> bindParam(":componente", $componente, PDO::PARAM_INT);
		$stmt-> bindParam(":prueba", $prueba, PDO::PARAM_INT);
		$res=$stmt-> execute();
		if(!$res)
		 throw new Exception("Error al eliminar la prueba, intente de nuevo");
		}catch(PDOException $ex){
			throw new Exception("Error al eliminar la prueba, intente de nuevo");
			
		}
	}
	
// 	public function getReactivosPruebaA($servicio,$componente,$tipo){
		

// $sqlc=" SELECT cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing,
//  cue_reactivosestandardetalle.red_lugarsyd, cue_reactivosestandardetalle.ser_claveservicio,
//  cue_reactivosestandardetalle.sec_numseccion, cue_reactivosestandardetalle.r_numreactivo, 
// cue_reactivosestandardetalle.re_numcomponente, cue_reactivosestandardetalle.re_numcaracteristica, 
// cue_reactivosestandardetalle.re_numcomponente2, cue_reactivosestandardetalle.red_numcaracteristica2,
//  cue_reactivosestandardetalle.red_estandar, cue_reactivosestandardetalle.red_tiporeactivo
// 		FROM aa_pruebaanalisis
// 		Inner Join cue_reactivosestandardetalle ON aa_pruebaanalisis.pa_numcomponente = cue_reactivosestandardetalle.re_numcomponente 
// AND aa_pruebaanalisis.pa_numprueba = cue_reactivosestandardetalle.red_numcaracteristica2 AND aa_pruebaanalisis.pa_numservicio = cue_reactivosestandardetalle.ser_claveservicio
// 		Inner Join cue_secciones ON cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio 
// AND cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion
// 		WHERE cue_reactivosestandardetalle.ser_claveservicio =  :idserv AND
// 		cue_secciones.sec_indagua =  '1' AND
// 		aa_pruebaanalisis.pa_tipoanalisis =  :tipo AND
// 		cue_reactivosestandardetalle.re_numcomponente =:componente";
		
// 		$stmt = Conexion::conectar()-> prepare($sqlc);
		
// 		$stmt-> bindParam(":idserv", $servicio, PDO::PARAM_INT);
// 		$stmt-> bindParam(":componente", $componente, PDO::PARAM_INT);
// 		$stmt-> bindParam(":tipo", $tipo, PDO::PARAM_STR);
// 		$stmt-> execute();
		
// 		$res=$stmt->fetchAll();
// 		return $res;
// 	}
	
	
}

