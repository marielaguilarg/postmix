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
		$stmt = Conexion::conectar()-> prepare("SELECT red_estandar, red_parametroesp, red_parametroing, red_valormin, red_valormax, red_signouno, red_signodos, red_ponderacion, red_syd, red_lugarsyd, red_tiporeactivo, red_grafica, red_tipodato, red_clavecatalogo, red_calculoespecial, red_tipocalculo, red_tipooperador, red_posicioncalculo, red_tipografica, red_indicador, red_rangor, red_rangoa, red_rangov, red_metodopepsi, red_refinternacinal, red_lugarindicador FROM cue_reactivosestandardetalle where concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2,red_numcaracteristica2) =:numsec and ser_claveservicio=:numser");
	
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


}