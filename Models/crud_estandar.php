<?php

require_once "Models/conexion.php";


class DatosEst extends Conexion{

#vistaponderacion

	public function vistaEstModel($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, re_descripcionesp, re_descripcioning, re_tipoevaluacion FROM $tabla WHERE ser_claveservicio=:ids and sec_numseccion =:nsec");
		
		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function vistaEstandarModeln1($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, re_descripcionesp, re_descripcioning FROM $tabla WHERE ser_claveservicio=:ids and concat(sec_numseccion,r_numreactivo,re_numcaracteristica,re_numcomponente2) =:nsec");
		
		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function vistaEstandarModeln2($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, re_descripcionesp, re_descripcioning FROM $tabla WHERE ser_claveservicio=:ids and concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica) =:nsec");


		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function actualizatiporeac($datosModel, $datosservicio, $tiposec, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET sec_tiposeccion=:tiposec WHERE ser_claveservicio=:numser and sec_numseccion=:numsec");
       

			$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
			$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);
			$stmt-> bindParam(":tiposec", $tiposec, PDO::PARAM_STR);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }

	public function actualizatiporeacn2($datosModel, $datosservicio, $tiposec, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET sec_tiposeccion=:tiposec WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo)=:numsec");
       

			$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
			$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);
			$stmt-> bindParam(":tiposec", $tiposec, PDO::PARAM_STR);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }


public function actualizatiporeacn3($datosModel, $datosservicio, $tiposec, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE cue_reactivosabiertosdetalle set rad_tiporeactivo=:tiposec where concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2,rad_numcaracteristica2)=:numsec and ser_claveservicio=:numser");
       
     		$stmt-> bindParam(":numsec", $datosModeL, PDO::PARAM_INT);
			$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);
			$stmt-> bindParam(":tiposec", $tiposec, PDO::PARAM_STR);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }

   public function actualizatiporeacn6a($datosModel, $datosservicio, $tiposec, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET rad_tiporeactivo=:tiposec WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_caracteristica,ra_numcomponente2,rad_numcaracteristica2)=:numsec");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
			$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);
			$stmt-> bindParam(":tiposec", $tiposec, PDO::PARAM_STR);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }

	public function actualizatiporeacn6e($datosModel, $datosservicio, $tiposec, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET rad_tiporeactivo=:tiposec WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,re_numcomponente,re_caracteristica,re_numcomponente2,red_numcaracteristica2)=:numsec");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
			$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);
			$stmt-> bindParam(":tiposec", $tiposec, PDO::PARAM_STR);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }


	public function buscatiposec($datosModel, $datosservicio,  $tabla){
        $stmt=Conexion::conectar()->prepare("SELECT sec_tiposeccion from cue_secciones where ser_claveservicio=:numser and sec_numseccion=:numsec");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }

    public function buscatiporeac($datosModel, $datosservicio, $numreac, $tabla){
        $stmt=Conexion::conectar()->prepare("SELECT r_tiporeactivo from cue_reactivos where sec_numseccion=:numsec and r_numreactivo=:numreac and ser_claveservicio=:numser");

      	$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $numreac, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }


	public function CalculaultimaEstModel($datosservicio, $datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(re_numcomponente) as clavecomp from $tabla where ser_claveservicio=:idser and concat(sec_numseccion,r_numreactivo,re_numcaracteristica,re_numcomponente2)=:idsec");
		
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
			$stm1-> execute();
			return $stm1->fetch();
			$stm1->close();

	}


	public function CalculaultimaEst3Model($datosservicio, $datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(re_numcomponente2) as clavecomp from $tabla where ser_claveservicio=:idser and concat(sec_numseccion,r_numreactivo,re_numcomponente, re_numcaracteristica)=:idsec");
		
			
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
			$stm1-> execute();
			return $stm1->fetch();
			$stm1->close();

	}



	public function Creanivelreactivo($datosservicio, $datosModel, $datosreac, $tabla){
		$stm1=Conexion::conectar()->prepare("INSERT INTO $tabla(ser_claveservicio, sec_numseccion, r_numreactivo ) VALUES (:idser,:numsec,:numreac)");

		
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
			$stm1-> bindParam(":numreac", $datosreac, PDO::PARAM_INT);
			
			IF($stm1-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stm1->close();

	}

	public function insertaestandarn13($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, re_descripcionesp, re_descripcioning, re_tipoevaluacion) VALUES (:idser,:numsec,:numreac,:numcom,:numcar,:numcom2,:descripesp,:descriping,:tipoeval)");


			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
			$stmt-> bindParam(":descripesp", $datosModel["desesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":descriping", $datosModel["desing"], PDO::PARAM_STR);
			$stmt-> bindParam(":tipoeval", $datosModel["tipoeval"], PDO::PARAM_INT);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}

	public function insertaestandarn4($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, re_descripcionesp, re_descripcioning, re_tipoevaluacion) VALUES (:idser,:numsec,:numreac,:numcom,:numcar,:numcom2,:descripesp,:descriping,:tipoeval)");


			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar", $datosModel["numcar2"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
			$stmt-> bindParam(":descripesp", $datosModel["desesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":descriping", $datosModel["desing"], PDO::PARAM_STR);
			$stmt-> bindParam(":tipoeval", $datosModel["tipoeval"], PDO::PARAM_INT);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}


	public function EditaEstModel($datosservicio, $datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, re_descripcionesp, re_descripcioning, re_tipoevaluacion from $tabla where concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2) =:idsec and ser_claveservicio=:idser");
			
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_STR);
			$stm1-> execute();
			return $stm1->fetch();
			$stm1->close();

	}


	public function actualizaestandar($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET re_descripcionesp=:descripesp,re_descripcioning=:descriping,re_tipoevaluacion=:tipoeval WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2)=:numsec");


			$stmt-> bindParam(":numser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":descripesp", $datosModel["desesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":descriping", $datosModel["desing"], PDO::PARAM_STR);
			$stmt-> bindParam(":tipoeval", $datosModel["tipoeval"], PDO::PARAM_INT);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}


	public function borraestandarController($datosModel, $datosservicio, $tabla){
		$stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2) =:idsec and ser_claveservicio=:idser");


			$stmt-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $datosModel, PDO::PARAM_STR);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}

	public function borraEstandarDetModel($datosModel, $datosservicio, $tabla){
		$stmt=Conexion::conectar()->prepare("Delete From $tabla Where concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2,red_numcaracteristica2) =:idsec and ser_claveservicio=:idser");


			$stmt-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $datosModel, PDO::PARAM_STR);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}





	public function buscacompModel($datosModel, $datosservicio, $tabla){
	$stm1=Conexion::conectar()->prepare("SELECT re_numcomponente FROM $tabla WHERE concat(sec_numseccion,r_numreactivo) =:idsec and ser_claveservicio=:idser");
			
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_STR);
			$stm1-> execute();
			return $stm1->fetchall();
			$stm1->close();

	}



public function actpondModel($datosModel, $datosservicio, $valtipo, $tabla){
	$stm1=Conexion::conectar()->prepare("UPDATE cue_reactivos SET r_tiporeactivo=:tiporeac Where concat(cue_reactivos.sec_numseccion,cue_reactivos.r_numreactivo)=:idsec and cue_reactivos.ser_claveservicio=:idser");
			
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_STR);
			$smt1-> bindParam("tiporeac", $valtipo,PDO::PARAM_STR);
			$stm1-> execute();
		
			IF($stm1-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};	
			$stm1->close();

	}


	public function vistaEstDetModel($servicioModel, $seccionModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2,  red_numcaracteristica2, red_estandar, red_parametroesp, red_parametroing, red_valormin, red_valormax, red_signouno, red_signodos, red_ponderacion, red_syd, red_lugarsyd, red_tiporeactivo, red_grafica, red_tipodato, red_clavecatalogo, red_calculoespecial, red_tipocalculo, red_tipooperador, red_posicioncalculo, red_tipografica, red_indicador, red_rangor, red_rangoa, red_rangov, red_metodopepsi, red_refinternacinal, red_lugarindicador FROM cue_reactivosestandardetalle WHERE concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2)=:nsec and ser_claveservicio=:nser");


		$stmt-> bindParam(":nsec", $seccionModel, PDO::PARAM_INT);
		$stmt-> bindParam(":nser", $servicioModel, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetchAll();
		$stmt->close();

	}

	public function buscaultimoreactivoest($numsec,$numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT max(red_numcaracteristica2) as numcar2 FROM cue_reactivosestandardetalle WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2)=:numsec");
	
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $numsec, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	public function catalogosModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ca_idcatalogo, ca_nombrecatalogo FROM $tabla");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	public function catalogoDetalleModel($datocontroller, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cad_idcatalogo, cad_idopcion, cad_descripcionesp, cad_descripcioning FROM ca_catalogosdetalle WHERE cad_idcatalogo=:numcat");
	
		$stmt-> bindParam(":numcat", $datocontroller, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}



	public function insertaestandardetalle($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("insert into cue_reactivosestandardetalle (ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, red_numcaracteristica2, red_parametroesp, red_parametroing, red_estandar, red_valormin, red_valormax, red_signouno, red_signodos, red_ponderacion, red_syd, red_lugarsyd, red_tipodato, red_clavecatalogo, red_grafica, red_calculoespecial,red_tipocalculo,red_tipooperador, red_tipografica,red_indicador, red_lugarindicador, red_rangor, 	red_rangoa, red_rangov,red_metodopepsi,red_refinternacinal) 
            values (:idServicio,:numsec,:numreac,:numcom,:numcar,:numcom2,:numcar2,
                     :desesp,:desing,:estandar,:valmin,:valmax,:siguno,:sigdos,:pondera,:sydata,:lugarsyd,:formato,:numcat,:grafica,:numcalesp,:tipocalesp,:posicionc,:tipo_grafica,:indicador,:lugarindi,:rangor,:rangoa,:rangov,:anapepsi,:refinter)");


		$stmt-> bindParam(":idServicio", $datosModel["idServicio"], PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $datosModel["numsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar2", $datosModel["numcar2"], PDO::PARAM_INT);

		$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":desing", $datosModel["desing"], PDO::PARAM_STR);
		$stmt-> bindParam(":estandar", $datosModel["estandar"], PDO::PARAM_INT);
		$stmt-> bindParam(":valmin", $datosModel["valmin"], PDO::PARAM_INT);
		$stmt-> bindParam(":valmax", $datosModel["valmax"], PDO::PARAM_INT);

		$stmt-> bindParam(":siguno", $datosModel["siguno"], PDO::PARAM_INT);
		$stmt-> bindParam(":sigdos", $datosModel["sigdos"], PDO::PARAM_INT);
		$stmt-> bindParam(":pondera", $datosModel["pondera"], PDO::PARAM_INT);
		$stmt-> bindParam(":sydata", $datosModel["sydata"], PDO::PARAM_INT);
		$stmt-> bindParam(":lugarsyd", $datosModel["lugarsyd"], PDO::PARAM_INT);
		$stmt-> bindParam(":formato", $datosModel["formato"], PDO::PARAM_STR);

		$stmt-> bindParam(":numcat", $datosModel["numcat"], PDO::PARAM_INT);
		$stmt-> bindParam(":grafica", $datosModel["grafica"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcalesp", $datosModel["numcalesp"], PDO::PARAM_INT);
		$stmt-> bindParam(":tipocalesp", $datosModel["tipocalesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":posicionc", $datosModel["posicionc"], PDO::PARAM_INT);
		$stmt-> bindParam(":tipo_grafica", $datosModel["tipo_grafica"], PDO::PARAM_STR);

		$stmt-> bindParam(":indicador", $datosModel["indicador"], PDO::PARAM_INT);
		$stmt-> bindParam(":lugarindi", $datosModel["lugarindi"], PDO::PARAM_INT);
		$stmt-> bindParam(":rangor", $datosModel["rangor"], PDO::PARAM_INT);
		$stmt-> bindParam(":rangoa", $datosModel["rangoa"], PDO::PARAM_INT);
		$stmt-> bindParam(":rangov", $datosModel["rangov"], PDO::PARAM_INT);
		$stmt-> bindParam(":anapepsi", $datosModel["anapepsi"], PDO::PARAM_STR);
		$stmt-> bindParam(":refinter", $datosModel["refinter"], PDO::PARAM_STR);
		IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();


	}
		
	public function editaEstDetalleModel($datosModel, $servicioModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT red_estandar, red_parametroesp, red_parametroing, red_valormin, 
red_valormax, red_signouno, red_signodos, red_ponderacion, red_syd, red_lugarsyd, red_tiporeactivo, red_grafica,
 red_tipodato, red_clavecatalogo, red_calculoespecial, red_tipocalculo, red_tipooperador, red_posicioncalculo, 
red_tipografica, red_indicador, red_rangor, red_rangoa, red_rangov, red_metodopepsi, red_refinternacinal, 
red_lugarindicador FROM cue_reactivosestandardetalle 
where concat(sec_numseccion,r_numreactivo,re_numcomponente,
re_numcaracteristica,re_numcomponente2,red_numcaracteristica2) =:numsec and ser_claveservicio=:numser");
	
		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();
		return $stmt->fetch();
		$stmt->close();

			
	}


	public function actualizaEstandarDetalleModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE cue_reactivosestandardetalle SET red_parametroesp=:desesp,red_parametroing=:desing,red_valormin=:valmin,red_valormax=:valmax,red_signouno=:siguno,red_signodos=:sigdos,red_ponderacion=:pond,red_syd=:sydata,red_lugarsyd=:sydludata,red_tipodato=:formato,red_clavecatalogo=:numcatalogo,red_grafica=:grafica,red_estandar=:estandar,red_calculoespecial=:cesp,red_tipocalculo=:tce,red_tipooperador=:posicionc,
		red_tipografica=:tipo_grafica,red_indicador=:valindi,red_lugarindicador=:lugarindi,red_rangor=:rangor,red_rangoa=:rangoa,red_rangov=:rangov,red_metodopepsi=:anapepsi,red_refinternacinal=:refinter WHERE concat(sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, red_numcaracteristica2) =:nsec and ser_claveservicio=:idser");

		$stmt-> bindParam(":idser", $datosModel["idServicio"], PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $datosModel["numsec"], PDO::PARAM_INT);	
		$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":desing", $datosModel["desing"], PDO::PARAM_STR);
		$stmt-> bindParam(":estandar", $datosModel["estandar"], PDO::PARAM_STR);
		$stmt-> bindParam(":valmin", $datosModel["valmin"], PDO::PARAM_INT);
		$stmt-> bindParam(":valmax", $datosModel["valmax"], PDO::PARAM_INT);
		$stmt-> bindParam(":siguno", $datosModel["siguno"], PDO::PARAM_INT);
		$stmt-> bindParam(":sigdos", $datosModel["sigdos"], PDO::PARAM_INT);
		$stmt-> bindParam(":pond", $datosModel["pondera"], PDO::PARAM_INT);
		$stmt-> bindParam(":sydata", $datosModel["sydata"], PDO::PARAM_INT);
		$stmt-> bindParam(":sydludata", $datosModel["lugarsyd"], PDO::PARAM_INT);
		$stmt-> bindParam(":formato", $datosModel["formato"], PDO::PARAM_STR);		
		$stmt-> bindParam(":grafica", $datosModel["grafica"], PDO::PARAM_INT);
		$stmt-> bindParam(":tipo_grafica", $datosModel["tipo_grafica"], PDO::PARAM_STR);
		$stmt-> bindParam(":numcatalogo", $datosModel["numcat"], PDO::PARAM_INT);
		$stmt-> bindParam(":cesp", $datosModel["numcalesp"], PDO::PARAM_INT);
		$stmt-> bindParam(":tce", $datosModel["tipocalesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":posicionc", $datosModel["posicionc"], PDO::PARAM_INT);		
		$stmt-> bindParam(":valindi", $datosModel["indicador"], PDO::PARAM_INT);
		$stmt-> bindParam(":lugarindi", $datosModel["lugarindi"], PDO::PARAM_INT);
		$stmt-> bindParam(":rangor", $datosModel["rangor"], PDO::PARAM_INT);
		$stmt-> bindParam(":rangoa", $datosModel["rangoa"], PDO::PARAM_INT);
		$stmt-> bindParam(":rangov", $datosModel["rangov"], PDO::PARAM_INT);
		$stmt-> bindParam(":anapepsi", $datosModel["anapepsi"], PDO::PARAM_STR);
		$stmt-> bindParam(":refinter", $datosModel["refinter"], PDO::PARAM_STR);
		
		IF($stmt-> execute()){
				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();


	}
	

	public function vistaestandarComentModel($datosModel, $datoserv, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  rec_descomentarioesp, rec_descomentarioing, rec_numcomentario FROM cue_reactivosestandarcomentarios WHERE concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2)=:numseccon and ser_claveservicio=:idserv");

		$stmt-> bindParam(":numseccon", $datosModel, PDO::PARAM_STR);
		$stmt-> bindParam(":idserv", $datoserv, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchall();
	
		$stmt->close();
	}

	public function CalculaultimoEstComentModel($datosModel, $datoserv, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(rec_numcomentario) as clavecom FROM $tabla WHERE ser_claveservicio =:idser AND concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2)=:idsec");
		
		$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
		$stm1-> bindParam(":idser", $datoserv, PDO::PARAM_INT);
		$stm1-> execute();
		return $stm1->fetch();
		$stm1->close();

	}

    public function registraEstComentModel($datosModel, $tabla){

			$stmt = Conexion::conectar()->prepare("INSERT INTO cue_reactivosestandarcomentarios (ser_claveservicio, sec_numseccion, r_numreactivo, re_numcomponente, re_numcaracteristica, re_numcomponente2, rec_numcomentario, rec_descomentarioesp, rec_descomentarioing) values (:idser, :numsec, :numreac, :numcom, :numcar, :numcom2, :numcar2, :comesp, :coming)");

			$stmt-> bindParam(":comesp", $datosModel["nomesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":coming", $datosModel["noming"], PDO::PARAM_STR);
			$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar2", $datosModel["numcar2"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["idreac"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);


			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};

			$stmt->close();
	}

	public function borrarEstComentModel($datosModel, $servicioModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM cue_reactivosestandarcomentarios WHERE concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2,rec_numcomentario)=:idb and ser_claveservicio=:ids");

		$stmt-> bindParam(":idb", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}

	public function editaEstComentModel($datosModel, $servicioModel, $tabla){
	    $stm1=Conexion::conectar()->prepare("SELECT rec_descomentarioesp, rec_descomentarioing, rec_numcomentario FROM cue_reactivosestandarcomentarios WHERE concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2,rec_numcomentario) =:id and ser_claveservicio=:idser");

	    $stm1-> bindParam(":idser", $servicioModel, PDO::PARAM_INT);
	    $stm1-> bindParam(":id", $datosModel, PDO::PARAM_STR);

	    $stm1-> execute();
	    return$stm1->fetch();
	    $stm1->close();

  }

      public function actualizaEstComentModel($datosModel, $tabla){

			$stmt = Conexion::conectar()->prepare("UPDATE cue_reactivosestandarcomentarios SET rec_descomentarioesp=:comesp, rec_descomentarioing=:coming WHERE ser_claveservicio=:idser and concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2,rec_numcomentario) =:idsec");

			$stmt-> bindParam(":comesp", $datosModel["nomesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":coming", $datosModel["noming"], PDO::PARAM_STR);
			$stmt-> bindParam(":idsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};

			$stmt->close();
	}
        
         function buscaSeccionesIndi($servicio, $vidiomau){
    $sql="SELECT
cue_reactivosestandardetalle.ser_claveservicio,
cue_reactivosestandardetalle.sec_numseccion AS seccion,
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,
cue_secciones.sec_nomsecesp,
cue_secciones.sec_nomsecing
FROM
cue_reactivosestandardetalle
Inner Join cue_secciones ON cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion AND cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio
WHERE
cue_reactivosestandardetalle.red_indicador =  '-1' AND
cue_reactivosestandardetalle.ser_claveservicio =  :servicio
GROUP BY
cue_reactivosestandardetalle.ser_claveservicio,
cue_reactivosestandardetalle.sec_numseccion
order by seccion";
   
   
     $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
     $stmt->execute();
    
       if ($vidiomau == 2) {
     $nomcampo = "sec_nomsecing";
    } else {
        $nomcampo = "sec_nomsecesp";
    }
    $res=$stmt->fetchAll();
    foreach ($res as $row) {

        $nombre = $row[$nomcampo];
        $numero=$row["seccion"];
         $seccion=array($numero,$nombre); //creo arreglo
        $secciones[]=$seccion;
    }
  
 
    return $secciones;
    
}

function buscaSeccionesIndi2($servicio, $vidiomau){
    $sql="SELECT
cue_reactivosestandardetalle.ser_claveservicio,
cue_reactivosestandardetalle.sec_numseccion AS seccion,
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing,
cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning,
cue_secciones.sec_nomsecesp,
cue_secciones.sec_nomsecing
FROM
cue_reactivosestandardetalle
Inner Join cue_secciones ON cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion AND cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio
WHERE
cue_reactivosestandardetalle.sec_numseccion in (5,8,2) and
cue_reactivosestandardetalle.ser_claveservicio =  :servicio
GROUP BY
cue_reactivosestandardetalle.ser_claveservicio,
cue_reactivosestandardetalle.sec_numseccion
order by sec_ordsecind";
    
    
    $stmt = Conexion::conectar()-> prepare($sql);
    $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($vidiomau == 2) {
        $nomcampo = "sec_nomsecing";
    } else {
        $nomcampo = "sec_nomsecesp";
    }
    $res=$stmt->fetchAll();
    foreach ($res as $row) {
        
        $nombre = $row[$nomcampo];
        $numero=$row["seccion"];
        $seccion=array($numero,$nombre); //creo arreglo
        $secciones[]=$seccion;
    }
    
    
    return $secciones;
    
}
    
    function buscaSubSeccionIndi($seccion, $vidiomau,$servicio){
    $sql="SELECT
cue_reactivosestandardetalle.ser_claveservicio,
concat(cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2) AS seccion,
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing
FROM
cue_reactivosestandardetalle
WHERE
cue_reactivosestandardetalle.red_indicador =  '-1' AND
cue_reactivosestandardetalle.ser_claveservicio = :servicio
and cue_reactivosestandardetalle.sec_numseccion=:seccion";
   
   
     $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":seccion", $seccion, PDO::PARAM_INT);
      $stmt->bindParam(":servicio", $seccion, PDO::PARAM_INT);
     $stmt->execute();
       if ($vidiomau == 2) {
        $nomcampo = "red_parametroing";
    } else {
        $nomcampo = "red_parametroesp";
    }
    $res=$stmt->fetchAll();
    foreach ($res as $row) {

        $nombre = $row[$nomcampo];
        $numero=$row["seccion"];
         $seccion=array($numero,$nombre); //creo arreglo
        $secciones[]=$seccion;
    }
  
 
    return $secciones;
    
}

/*funcion que devuelve los indicadores por seccion en un arreglo
 * de la forma |3.8.0.0.1|nomseccion|estandar|
 * 
 */
function buscaIndicadores($seccion, $vidiomau,$servicio)
{
   
    $sql="SELECT
cue_reactivosestandardetalle.ser_claveservicio,concat(
cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2) as referencia,
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing
FROM
cue_reactivosestandardetalle
WHERE
cue_reactivosestandardetalle.red_indicador =  '-1' AND
cue_reactivosestandardetalle.ser_claveservicio = :servicio and  concat(
cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2)=:seccion";
     $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":seccion", $seccion, PDO::PARAM_STR);
      $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
      
     $stmt->execute();
    // $stmt->debugDumpParams();
       $res=$stmt->fetchAll();
     //  die();
      if ($vidiomau == 2) {
        $nomcampo = "red_parametroing";
    } else {
        $nomcampo = "red_parametroesp";
    }
    foreach ($res as $row) {
        $arr =array($row["referencia"], $row[$nomcampo] , $row["red_estandar"]);
        $reactivos[]=$arr;
    }
     
     return $reactivos;

}

function buscaRangosSem($referencia,$servicio)
{
     
    $sql="SELECT
   REPLACE(`red_rangor`,'^','-'),
     REPLACE(`red_rangoa`,'^','-'),
      REPLACE(`red_rangov`,'^','-')
    , `sec_numseccion`
    , `r_numreactivo`
    , `re_numcomponente`
    , `re_numcaracteristica`
    , `re_numcomponente2`
    , `red_numcaracteristica2`
FROM
    `cue_reactivosestandardetalle`
WHERE (`ser_claveservicio` =:servicio
   and concat( `sec_numseccion` ,'.',
     `r_numreactivo`,'.',
     `re_numcomponente`,'.',
     `re_numcaracteristica`,'.',
     `re_numcomponente2` ,'.',
     `red_numcaracteristica2`) =:referencia);";
      $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":referencia", $referencia, PDO::PARAM_STR);
      $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);
       $stmt->execute();
   
       $res=$stmt->fetchAll(); 
     
    foreach ($res as $row) {
        $arr =array("r"=>$row[0],"a"=> $row[1] ,"v"=>$row[2] );
        
    }
  
     return $arr;
}

//devuelve la referencia de los atributos
function ConsultaAtributos($idservicio, $referencia) {
    /* 502 */
    $sql = "SELECT
cue_reactivosestandardetalle.sec_numseccion,
cue_reactivosestandardetalle.r_numreactivo,
cue_reactivosestandardetalle.re_numcomponente,

cue_reactivosestandardetalle.red_numcaracteristica2
from cue_reactivosestandardetalle inner join cue_reactivosestandar on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion
and cue_reactivosestandar.r_numreactivo=cue_reactivosestandardetalle.r_numreactivo and cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente 
and cue_reactivosestandar.re_numcaracteristica=cue_reactivosestandardetalle.re_numcaracteristica and cue_reactivosestandar.re_numcomponente2=cue_reactivosestandardetalle.re_numcomponente2
where red_grafica=-1
 and concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente)=:referencia 
     and cue_reactivosestandar.ser_claveservicio=:servicio ;";
      $stmt = Conexion::conectar()-> prepare($sql);
     $stmt->bindParam(":referencia", $referencia, PDO::PARAM_STR);
      $stmt->bindParam(":servicio", $idservicio, PDO::PARAM_INT);
       $stmt->execute();
   
       $res=$stmt->fetchAll(); 

    $i = 0;
   
    foreach ($res as $row) {
        $secciones [$i++] = $row [0] . '.' . $row [1] . '.' . $row [2] . '.' . $row [3];
    }
    return $secciones;
}

//referencia es la seccion.componente
//lista el numero de reporte
function CumplimientoEstandar($vservicio, $referencia, $reporte) {
  

    $query = "SELECT sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,ide_aceptado,0),ide_aceptado)) as aceptado,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,red_clavecatalogo,ide_valorreal,  ide_numcaracteristica3,
red_tipodato,red_valormin
			    FROM cue_reactivosestandar
		  Inner Join cue_reactivosestandardetalle 
		  		  ON cue_reactivosestandar.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio 
				 AND cue_reactivosestandar.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion 
				 AND cue_reactivosestandar.r_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
				 AND cue_reactivosestandar.re_numcomponente = cue_reactivosestandardetalle.re_numcomponente 
				 AND cue_reactivosestandar.re_numcaracteristica = cue_reactivosestandardetalle.re_numcaracteristica 
				 AND cue_reactivosestandar.re_numcomponente2 = cue_reactivosestandardetalle.re_numcomponente2 
		  Inner Join ins_detalleestandar 
		          ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio 
				 AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion 
				 AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo 
				 AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente 
				 AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 
				 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 
				 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3 
			   WHERE ins_detalleestandar.ide_numreporte = :reporte  and cue_reactivosestandardetalle.ser_claveservicio=:vservicio
			     AND  red_grafica=-1  and concat(ins_detalleestandar.ide_numseccion,'.',ide_numreactivo ,'.',ins_detalleestandar.ide_numcomponente,'.',ins_detalleestandar.ide_numcaracteristica3 )=:referencia";

    $query .= " group by ins_detalleestandar.ide_numseccion,ide_numreactivo ,ins_detalleestandar.ide_numcomponente, ide_numcaracteristica3
			ORDER BY cue_reactivosestandardetalle.re_numcomponente2 ASC, 
			         ins_detalleestandar.ide_numcaracteristica3 ASC,
					 ins_detalleestandar.ide_numrenglon ASC;";
    // echo "<br>".$query;
   $stmt = Conexion::conectar()-> prepare($query);

    $stmt-> bindParam(":referencia", $referencia, PDO::PARAM_STR);
    $stmt-> bindParam(":reporte",$reporte , PDO::PARAM_INT);
    $stmt-> bindParam(":vservicio", $vservicio, PDO::PARAM_INT);
    $stmt-> execute();
//$stmt->debugDumpParams();
        
    $result=$stmt->fetchAll();
    foreach($result as $row) {

        if ($_SESSION["idiomaus"] == 2)
            $res[0] = $row ['red_parametroing'];
        else
            $res[0] = $row ['red_parametroesp'];
// si el estandar es de catalogo lo busco en el catalogo
        if ($row["red_tipodato"] == "C") {
            
                    $res[1] = DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$row["red_clavecatalogo"],$row["red_valormin"]);
            
           
        }
        else
            $res[1] = $row['red_estandar'];
        if ($row ["aceptado"] == -1)
            $res[2] = "paloma";
        else
            $res[2] = "tache";

        $res[3] = $referencia;
    }
  
    return $res;
}

function CumplimientoProporcion($vservicio, $referencia, $reporte,$caract) {

    
    $query = "SELECT sum(if(ide_aceptado<0,100,0))/sum(1) as aceptado,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,red_clavecatalogo,ide_valorreal,  ide_numcaracteristica3
			    FROM cue_reactivosestandar
		  Inner Join cue_reactivosestandardetalle 
		  		  ON cue_reactivosestandar.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio 
				 AND cue_reactivosestandar.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion 
				 AND cue_reactivosestandar.r_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
				 AND cue_reactivosestandar.re_numcomponente = cue_reactivosestandardetalle.re_numcomponente 
				 AND cue_reactivosestandar.re_numcaracteristica = cue_reactivosestandardetalle.re_numcaracteristica 
				 AND cue_reactivosestandar.re_numcomponente2 = cue_reactivosestandardetalle.re_numcomponente2 
		  Inner Join ins_detalleestandar 
		          ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio
				 AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion 
				 AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo 
				 AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente 
				 AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 
				 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 
				 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3 
			   WHERE ins_detalleestandar.ide_numreporte =  :reporte and cue_reactivosestandardetalle.ser_claveservicio=:vservicio
			     AND  red_grafica=-1  and concat(ins_detalleestandar.ide_numseccion,'.',ide_numreactivo ,'.',
                             ins_detalleestandar.ide_numcomponente,'.',ins_detalleestandar.ide_numcaracteristica3 )=:referencia";
    //condicion para una seccion en especifico
    if ($caract != "")
        $query .= " and ins_detalleestandar.ide_numcaracteristica3=".$caract;

    $query .= " group by ins_detalleestandar.ide_numseccion,ide_numreactivo ,ins_detalleestandar.ide_numcomponente, ide_numcaracteristica3
			ORDER BY cue_reactivosestandardetalle.re_numcomponente2 ASC, 
			         ins_detalleestandar.ide_numcaracteristica3 ASC,
					 ins_detalleestandar.ide_numrenglon ASC;";
    //echo "<br>".$query;
    $stmt = Conexion::conectar()-> prepare($query);

    $stmt-> bindParam(":referencia", $referencia, PDO::PARAM_STR);
    $stmt-> bindParam(":reporte",$reporte , PDO::PARAM_INT);
    $stmt-> bindParam(":vservicio", $vservicio, PDO::PARAM_INT);
    $stmt-> execute();

    $result=$stmt->fetchAll();
    foreach($result as $row_cal_b ) {
        if ($_SESSION["idiomaus"] == 2)
            $res[0] = $row_cal_b ['red_parametroing'];
        else
            $res[0] = $row_cal_b ['red_parametroesp'];

        $res[1] = $row_cal_b ['red_estandar'];

        if ($row_cal_b ["aceptado"] >= 80)
            $res[2] = "paloma";
        else
            $res[2] = "tache";
        $res[3] = $referencia;
    }

    return $res;
}
function consultaDetalleEstandarxval($vservicio,  $reporte,$caract3,$seccion,$componente,$reactivo,$opcion) {
    
    
    $query ="SELECT
    `ide_claveservicio`,
  `ide_numreporte`,
  `ide_numseccion`,
  `ide_numreactivo`,
  `ide_numcomponente`,
  `ide_numcaracteristica1`,
  `ide_numcaracteristica2`,
  `ide_numcaracteristica3`,
  `ide_valorreal`,
  `ide_ponderacion`,
  `ide_aceptado`,
  `ide_comentario`,
  `ide_numrenglon`,
  `ide_numcolarc`,
  `ide_idmuestra`
    FROM ins_detalleestandar
    WHERE ins_detalleestandar.ide_numcaracteristica3 = :caract3 AND ins_detalleestandar.ide_numseccion = :seccion
    AND ins_detalleestandar.ide_numcomponente = :componente AND ins_detalleestandar.ide_claveservicio = :servicio
    AND ins_detalleestandar.ide_numreactivo =:reactivo AND ins_detalleestandar.ide_numreporte =:reporte
    AND ins_detalleestandar.ide_valorreal=:opcion";
  
        $stmt = Conexion::conectar()-> prepare($query);
        
        $stmt-> bindParam(":caract3", $caract3, PDO::PARAM_INT);
        $stmt-> bindParam(":reporte",$reporte , PDO::PARAM_INT);
        $stmt-> bindParam(":servicio", $vservicio, PDO::PARAM_INT);
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
        $stmt-> bindParam(":componente",$componente , PDO::PARAM_INT);
        $stmt-> bindParam(":reactivo", $reactivo, PDO::PARAM_INT);
        $stmt-> bindParam(":opcion", $opcion, PDO::PARAM_INT);
        $stmt-> execute();
    //  $stmt->debugDumpParams(); 
        $result=$stmt->fetchAll();
       
        
        return $result;
}
function consultaDetalleEstandar($vservicio,  $reporte,$caract3,$seccion,$componente,$reactivo,$renglon) {
    
    
    $query ="SELECT
    `ide_claveservicio`,
  `ide_numreporte`,
  `ide_numseccion`,
  `ide_numreactivo`,
  `ide_numcomponente`,
  `ide_numcaracteristica1`,
  `ide_numcaracteristica2`,
  `ide_numcaracteristica3`,
  `ide_valorreal`,
  `ide_ponderacion`,
  `ide_aceptado`,
  `ide_comentario`,
  `ide_numrenglon`,
  `ide_numcolarc`,
  `ide_idmuestra`
    FROM ins_detalleestandar
    WHERE ins_detalleestandar.ide_numcaracteristica3 = :caract3 AND ins_detalleestandar.ide_numseccion = :seccion
    AND ins_detalleestandar.ide_numcomponente = :componente AND ins_detalleestandar.ide_claveservicio = :servicio
    AND ins_detalleestandar.ide_numreactivo =:reactivo AND ins_detalleestandar.ide_numreporte =:reporte
    AND ins_detalleestandar.ide_numrenglon=:opcion";
    
    $stmt = Conexion::conectar()-> prepare($query);
    
    $stmt-> bindParam(":caract3", $caract3, PDO::PARAM_INT);
    $stmt-> bindParam(":reporte",$reporte , PDO::PARAM_INT);
    $stmt-> bindParam(":servicio", $vservicio, PDO::PARAM_INT);
    $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
    $stmt-> bindParam(":componente",$componente , PDO::PARAM_INT);
    $stmt-> bindParam(":reactivo", $reactivo, PDO::PARAM_INT);
    $stmt-> bindParam(":opcion", $renglon, PDO::PARAM_INT);
    $stmt-> execute();
    
    $result=$stmt->fetchAll();
  //  $stmt->debugDumpParams();
    
    return $result;
}

public function getReactivoEstandarn1($servicio, $referencia, $tabla){
  
    $sqlcu = "SELECT *
		          FROM ".$tabla."
				 WHERE `cue_reactivosestandar`.`ser_claveservicio` = :idser 
				   AND concat(sec_numseccion,'.', r_numreactivo) =:refer";
    $stmt = Conexion::conectar()-> prepare($sqlcu);
    
    $stmt-> bindParam(":idser", $servicio, PDO::PARAM_INT);
    $stmt-> bindParam(":refer", $referencia, PDO::PARAM_STR);
    
    $stmt-> execute();

    return $stmt->fetchAll();
}

public function getReactivoEstandarn2($servicio, $referencia, $tabla){
    $sqlcu = "SELECT *
		             FROM `cue_reactivosestandar`
					WHERE `cue_reactivosestandar`.`ser_claveservicio` =:idser
					  AND concat(sec_numseccion,'.',r_numreactivo,'.',re_numcaracteristica,'.',re_numcomponente2) =  :secc ";
    
    $stmt = Conexion::conectar()-> prepare($sqlcu);
    
    $stmt-> bindParam(":idser", $servicio, PDO::PARAM_INT);
    $stmt-> bindParam(":secc", $referencia, PDO::PARAM_STR);
    
    $stmt-> execute();

     return $stmt->fetchAll();
  
}

public function getReactivoEstandarn3($servicio, $referencia, $tabla){
    $sqlcu = "SELECT *
		             FROM `cue_reactivosestandar`
					WHERE `cue_reactivosestandar`.`ser_claveservicio` = :idser 
					  AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica) = :secc";
    $stmt = Conexion::conectar()-> prepare($sqlcu);
    
    $stmt-> bindParam(":idser", $servicio, PDO::PARAM_INT);
    $stmt-> bindParam(":secc", $referencia, PDO::PARAM_STR);
    
    $stmt-> execute();
   
    return $stmt->fetchAll();
}


	public function validasubseccionEstandar($idser, $idsec, $idreac, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT red_parametroesp FROM $tabla WHERE ser_claveservicio=:idser and sec_numseccion=:idsec and r_numreactivo=:idreac");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_INT);
			$stmt-> bindParam(":idreac", $idreac, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->rowCount();
		
			$stmt->close();

	}

	public function vistaEstandarRepReactivo($idser, $idsec, $idreac, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla where ser_claveservicio=:idser and sec_numseccion=:idsec and r_numreactivo=:idreac");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_INT);
			$stmt-> bindParam(":idreac", $idreac, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetchall();
		
			$stmt->close();

	}

	public function vistaEstandarRepNumcar($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla where ser_claveservicio=:idser AND concat(sec_numseccion,'.',r_numreactivo,'.',re_numcaracteristica,'.',re_numcomponente2) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->fetchall();
			$stmt->close();

	}

	public function vistaEstandarRepGral($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla  where ser_claveservicio=:idser AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->rowCount();
		
			$stmt->close();

	}

	public function validaComentEstandar($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT rec_descomentarioesp FROM $tabla where ser_claveservicio =:idser AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica,'.', re_numcomponente2) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->rowCount();
		
			$stmt->close();

	}

	public function vistaNomSecEstandar($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT re_descripcionesp FROM $tabla WHERE concat(sec_numseccion,'.',r_numreactivo,'.',re_numcomponente)=:idsec and ser_claveservicio=:idser");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}	

	public function vistaRepEstandarDet($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ser_claveservicio,  red_numcaracteristica2, red_tipodato, red_ponderacion,  red_clavecatalogo, red_estandar, red_valormin, red_parametroesp, red_valormax, red_signouno, red_signodos, red_tiporeactivo, red_calculoespecial, red_tipocalculo, red_tipooperador, red_posicioncalculo 
			FROM $tabla where ser_claveservicio =:idser AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica,'.', re_numcomponente2) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
		
			return $stmt->fetchall();
		
			$stmt->close();

	}	

	public function buscatipoevaluacion($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT re_tipoevaluacion from $tabla where ser_claveservicio=:idser and concat(sec_numseccion,'.',r_numreactivo,'.',re_numcomponente) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}	

	public function vistaRepRealDet($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ide_claveservicio, ide_numreporte, ide_numseccion, ide_numreactivo, ide_numcomponente, ide_numcaracteristica1, ide_numcaracteristica2, ide_numcaracteristica3, ide_valorreal, ide_ponderacion, ide_numrenglon, ide_comentario, ide_aceptado, ide_numcolarc FROM $tabla WHERE  ide_claveservicio =:idser AND concat(ide_numseccion ,'.', ide_numreactivo ,'.', ide_numcomponente ,'.', ide_numcaracteristica1 ,'.', ide_numcaracteristica2 )=:idsec AND ide_numreporte=:idrep AND ide_numrenglon =:numren AND ide_numcaracteristica3=:numcar");

			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":idrep", $datosModel["idrep"], PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $datosModel["numren"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}

	public function buscatotren($idser, $idsec, $nrep, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ide_numrenglon as claveren FROM ins_detalleestandar  WHERE ide_claveservicio = :idser AND ide_numreporte =:nrep AND concat(ide_numseccion,'.',ide_numreactivo,'.',ide_numcomponente,'.',ide_numcaracteristica1,'.',ide_numcaracteristica2) =:idsec  group by ide_numrenglon");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetchall();
		
			$stmt->close();

	}	

	public function buscaOpcionCat($idcat, $idopc, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT cad_descripcionesp FROM $tabla  WHERE cad_idcatalogo =:idcat AND cad_idopcion =:idopc");

			$stmt-> bindParam(":idcat", $idcat, PDO::PARAM_INT);
			$stmt-> bindParam(":idopc", $idopc, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}

	public function nivelCumpEstandarUno($idser, $idsec, $idrep, $numren, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT sum(`ide_ponderacion`) as totalpon FROM ins_detalleestandar WHERE ide_numreporte=:idrep AND ide_claveservicio=:idser and concat(ide_numseccion,".",ide_numreactivo,".",ide_numcomponente,".",ide_numcaracteristica1,".",ide_numcaracteristica2)=:idsec group BY ide_numrenglon having ide_numrenglon=:numren");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}


		public function nivCumpEstandarUno($idser, $idsec, $idrep, $numren, $tabla){
			$stmt=Conexion::conectar()->prepare("SELECT sum(ide_ponderacion) as totalpon FROM ins_detalleestandar WHERE ide_numrenglon=:numren AND ide_numreporte=:idrep AND ide_claveservicio=:idser and concat(ide_numseccion,'.',ide_numreactivo,'.',ide_numcomponente,'.',ide_numcaracteristica1,'.',ide_numcaracteristica2)=:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);

			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

		}	

	public function nivelCumpEstandarDos($idser, $idsec, $idrep, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT sum(ide_ponderacion) as totpond,  count(ide_valorreal) as numreg FROM  $tabla where ide_claveservicio=:idser and ide_numreporte=:idrep and concat(ide_numseccion,'.',ide_numreactivo,'.',ide_numcomponente,'.',ide_numcaracteristica1,'.',ide_numcaracteristica2)=:idsec");

			//$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_INT);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}

	public function vistaNuevoEstandar($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT red_numcaracteristica2,red_parametroesp, red_tipodato, red_clavecatalogo FROM $tabla where ser_claveservicio=:idser and concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica,'.', re_numcomponente2) =:idsec order by red_numcaracteristica2");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetchall();
		
			$stmt->close();
	}		

	public function vistaNumRegEstandar($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT max(ide_numrenglon) as claveren FROM ins_detalleestandar WHERE ide_claveservicio =:idser AND ide_numreporte =:idrep AND concat(ide_numseccion,'.',ide_numreactivo,'.',ide_numcomponente,'.',ide_numcaracteristica1,'.',ide_numcaracteristica2) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}	
	
	public function consultaReactivoEstandar($idser, $idsec, $tabla){
	    $stmt=Conexion::conectar()->prepare("SELECT *
			FROM $tabla where ser_claveservicio =:idser AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica,'.', re_numcomponente2) =:idsec");
	    
	    $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
	    $stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
	    
	    $stmt-> execute();
	 
	    return $stmt->fetchall();
	    
	    $stmt->close();
	    
	}	
	
	function ConsultaAtributosxSec($seccion) {
	    /* 502 */
	    $sql = "select cue_reactivosestandardetalle.sec_numseccion, cue_reactivosestandardetalle.r_numreactivo,
cue_reactivosestandardetalle.re_numcomponente, cue_reactivosestandardetalle.re_numcaracteristica, cue_reactivosestandardetalle.re_numcomponente2, cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing
from cue_reactivosestandardetalle 
inner join cue_reactivosestandar on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion
and cue_reactivosestandar.r_numreactivo=cue_reactivosestandardetalle.r_numreactivo and cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente
and cue_reactivosestandar.re_numcaracteristica=cue_reactivosestandardetalle.re_numcaracteristica and cue_reactivosestandar.re_numcomponente2=cue_reactivosestandardetalle.re_numcomponente2
where red_grafica=-1 and re_tipoevaluacion <>0 and cue_reactivosestandardetalle.sec_numseccion=:numseccion";
	    $stmt = Conexion::conectar()-> prepare($sql);
	   
	    $stmt->bindParam(":numseccion", $seccion, PDO::PARAM_INT);
	    $stmt->execute();
	    
	    $res=$stmt->fetchAll();
	    
	  
	    return $res;
	}
	
	function ConsultaAgua($muestra) {
		
		$sqlfq="SELECT ins_detalleestandar.ide_numrenglon, ins_detalleestandar.ide_numreporte,
ins_detalleestandar.ide_claveservicio FROM
ins_detalleestandar Inner Join cue_secciones ON ins_detalleestandar.ide_claveservicio = cue_secciones.ser_claveservicio
AND ins_detalleestandar.ide_numseccion = cue_secciones.sec_numseccion 
WHERE
cue_secciones.sec_indagua =  '1' AND
ins_detalleestandar.ide_idmuestra =  :ntoma
GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_idmuestra";
		
		$stmt = Conexion::conectar()-> prepare($sqlfq);
		
		$stmt->bindParam(":ntoma", $muestra, PDO::PARAM_INT);
		$stmt->execute();
		
		$res=$stmt->fetchAll();
		
		
		return $res;
	}
	
	function ConsultaDetalleAgua($muestra,$serv,$carac,$reporte) {
		
		$sql="SELECT ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_valorreal FROM ins_detalleestandar
		WHERE ins_detalleestandar.ide_idmuestra =:muestra
		AND ins_detalleestandar.ide_claveservicio = :serv
		AND ins_detalleestandar.ide_numcaracteristica3 = :caracteristica
		AND ins_detalleestandar.ide_numreporte = :reporte";
		$stmt = Conexion::conectar()-> prepare($sql);
		
		$stmt->bindParam(":muestra", $muestra, PDO::PARAM_INT);
		$stmt->bindParam(":serv", $serv, PDO::PARAM_INT);
		$stmt->bindParam(":caracteristica", $carac, PDO::PARAM_INT);
		
		$stmt->bindParam(":reporte", $reporte, PDO::PARAM_INT);
		$stmt->execute();
		
		$res=$stmt->fetchAll();
		
		
		return $res;
	}
	
	
	
	public function borraestandarDetalle($idser, $numrep,$numren, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE ide_claveservicio = :idser AND ide_numrenglon =:numren AND ide_numreporte = :numrep AND concat(ide_numseccion,'.',ide_numreactivo,'.',ide_numcomponente,'.',ide_numcaracteristica1,'.',ide_numcaracteristica2) =:idsec");
		
		
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
		$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
		$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
		
		IF($stmt-> execute()){
			
			return "success";
		}
		
		else {
			
			return "error";
			
		}
		
	}
	public function calculaUltimoRenglon($idser, $nrep, $nsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT max(ide_numrenglon) as claveren FROM $tabla WHERE ide_claveservicio =:idser AND ide_numreporte =:numrep AND concat(ide_numseccion,'.',ide_numreactivo,'.',ide_numcomponente,'.',ide_numcaracteristica1,'.',ide_numcaracteristica2) =:nsec");
		
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $nrep, PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_STR);
		
		$stmt-> execute();
		
		return $stmt->fetch();
		$stmt->close();
	}
	
	public function calculaVolumen($a, $b, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT cav_volumen from $tabla where cav_presion=:A and cav_temperatura=:B");
		
		$stmt-> bindParam(":A", $a, PDO::PARAM_INT);
		$stmt-> bindParam(":B", $b, PDO::PARAM_INT);
		
		$stmt-> execute();
		
		return $stmt->fetch();
		$stmt->close();
	}
	
	public function insertaRepEstandarDetalleToma($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO ins_detalleestandar (ide_claveservicio, ide_numreporte, ide_numseccion, ide_numreactivo, ide_numcomponente, ide_numcaracteristica1, ide_numcaracteristica2, ide_numcaracteristica3, ide_valorreal, ide_numrenglon, ide_ponderacion, ide_aceptado, ide_numcolarc, ide_idmuestra) VALUES (:idser, :numrep, :numsec, :numreac, :numcom, :numcar, :numcom2, :numcar2, :valcom, :numren, :pondreal, :aceptado, :numcolarc,:ntoma)");
		
		$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $datosModel["numsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar2", $datosModel["numcar2"], PDO::PARAM_INT);
		$stmt-> bindParam(":valcom", $datosModel["valcom"], PDO::PARAM_INT);
		$stmt-> bindParam(":numren", $datosModel["numren"], PDO::PARAM_INT);
		$stmt-> bindParam(":pondreal", $datosModel["pondreal"], PDO::PARAM_INT);
		$stmt-> bindParam(":aceptado", $datosModel["aceptado"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcolarc", $datosModel["numcolarc"], PDO::PARAM_INT);
		$stmt-> bindParam(":ntoma", $datosModel["ntoma"], PDO::PARAM_INT);
		
		IF($stmt-> execute()){
			
			return "success";
		}
		
		else {
			
			return "error";
			
		};
		
		$stmt->close();
		
		
	}
	
	
	
	
	public function insertaRepEstandarDetalle($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO ins_detalleestandar (ide_claveservicio, ide_numreporte, ide_numseccion, ide_numreactivo, ide_numcomponente, ide_numcaracteristica1, ide_numcaracteristica2, ide_numcaracteristica3, ide_valorreal, ide_numrenglon, ide_ponderacion, ide_aceptado, ide_numcolarc) VALUES (:idser, :numrep, :numsec, :numreac, :numcom, :numcar, :numcom2, :numcar2, :valcom, :numren, :pondreal, :aceptado, :numcolarc)");
		
		$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_STR);
		$stmt-> bindParam(":numsec", $datosModel["numsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar2", $datosModel["numcar2"], PDO::PARAM_INT);
		$stmt-> bindParam(":valcom", $datosModel["valcom"], PDO::PARAM_INT);
		$stmt-> bindParam(":numren", $datosModel["numren"], PDO::PARAM_INT);
		$stmt-> bindParam(":pondreal", $datosModel["pondreal"], PDO::PARAM_INT);
		$stmt-> bindParam(":aceptado", $datosModel["aceptado"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcolarc", $datosModel["numcolar"], PDO::PARAM_INT);
		
		
		
		
		
		
		IF($stmt-> execute()){
			
			return "success";
		}
		
		else {
			
			return "error";
			
		}
		
		$stmt->close();
	}
	
	

	public function buscarEstandarMuestra($ntoma, $tabla){
		
		$stmt=Conexion::conectar()->prepare("SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numcomponente
 FROM
$tabla
 WHERE ins_detalleestandar.ide_idmuestra =:ntoma 
GROUP BY
ins_detalleestandar.ide_claveservicio");
		
		$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
			
		$stmt-> execute();
	
		return $stmt->fetchAll();
	}
	
}
