<?php

require_once "Models/conexion.php";


class DatosPond extends Conexion{

#vistaponderacion

	public function vistaPonderaModel($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, r_descripcionesp, r_descripcioning, r_syd, r_lugarsyd, r_tiporeactivo, r_grafica, r_tipografica FROM cue_reactivos WHERE sec_numseccion =:nsec and ser_claveservicio=:ids");
		

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

	
	public function buscacliente($datosservicio, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ser_idcliente FROM ca_servicios WHERE ser_id =:numser");
       
			$stmt-> bindParam(":numser", $datosservicio, PDO::PARAM_INT);
			$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }



	public function consultacuentaModel($datoscliente, $tabla){
		
        $stmt=Conexion::conectar()->prepare("SELECT cue_id, cue_descripcion  FROM $tabla WHERE cue_idcliente=:numclien");

       	$stmt-> bindParam(":numclien", $datoscliente, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchAll();
		$stmt->close();
    }

	public function consultanomcuenta1($datoscuenta, $datoscli, $tabla){
		
        $stmt=Conexion::conectar()->prepare("SELECT cue_descripcion FROM ca_cuentas WHERE cue_idcliente =:nomcli and cue_id=:nomcta");

       	$stmt-> bindParam(":nomcli", $datoscli, PDO::PARAM_INT);
		$stmt-> bindParam(":nomcta", $datoscuenta, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }

	public function consultanomcuenta2( $datoscli, $tabla){
		
        $stmt=Conexion::conectar()->prepare("SELECT cue_id, cue_descripcion FROM $tabla WHERE cue_idcliente =:nomcli  order by cue_idcliente limit 1");

       	$stmt-> bindParam(":nomcli", $datoscli, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }

	public function buscareactivo($datossec, $datosser, $tabla){
		
        $stmt=Conexion::conectar()->prepare("SELECT r_numreactivo FROM $tabla WHERE sec_numseccion =:numsec and ser_claveservicio=:numser");

       	$stmt-> bindParam(":numsec", $datossec, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datosser, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }

public function buscaponderacion($datossec, $datoscta, $datosser, $datosreac, $tabla){
		
        $stmt=Conexion::conectar()->prepare("SELECT rd_ponderacion from $tabla where sec_numseccion =:numsec and ser_claveservicio=:numser and rd_clavecuenta=:numcta and r_numreactivo=:nreac and rd_fechainicio<=now() and  rd_fechafinal>=now()");

       	$stmt-> bindParam(":numsec", $datossec, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datosser, PDO::PARAM_INT);
		$stmt-> bindParam(":numcta", $datoscta, PDO::PARAM_INT);
		$stmt-> bindParam(":nreac", $datosreac, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }

    


	public function CalculaultimaPonderaModel($datosservicio, $datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(r_numreactivo) as ulreactivo FROM $tabla WHERE ser_claveservicio=:idser and sec_numseccion=:idsec");

			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
			$stm1-> execute();
			return $stm1->fetch();
			$stm1->close();

	}


	public function registrarPonderaModel($datosModel, $tabla){

			$stmt = Conexion::conectar()->prepare("INSERT INTO cue_reactivos(ser_claveservicio, sec_numseccion, r_numreactivo, r_descripcionesp, r_descripcioning, r_syd, r_lugarsyd) VALUES (:idser,:idsec,:numreac,:desesp,:desing,:indsyd,:lugarsys)");
			
		$stmt-> bindParam(":idsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":desing", $datosModel["desing"], PDO::PARAM_STR);
			$stmt-> bindParam(":lugarsys", $datosModel["lugarsyd"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
			$stmt-> bindParam(":indsyd", $datosModel["indsyd"], PDO::PARAM_INT);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};

			$stmt->close();
	}

	public function editaPonderaModel($datosModel, $servicioModel, $reactivoModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, r_descripcionesp, r_descripcioning, r_syd, r_lugarsyd FROM $tabla WHERE ser_claveservicio=:ids and sec_numseccion=:nsec and r_numreactivo=:nreac");

		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":nreac", $reactivoModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}

	public function actualizarPonderaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET r_descripcionesp=:desesp,r_descripcioning=:desing,`r_syd`=:indsyd,r_lugarsyd=:lugarsyd WHERE ser_claveservicio=:idser and sec_numseccion=:idsec and r_numreactivo=:idreac");
		
		$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":desing", $datosModel["desing"], PDO::PARAM_STR);
		$stmt-> bindParam(":lugarsyd", $datosModel["lugarsyd"], PDO::PARAM_INT);
		$stmt-> bindParam(":idsec", $datosModel["idsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
		$stmt-> bindParam(":idreac", $datosModel["idreac"], PDO::PARAM_INT);
		$stmt-> bindParam(":indsyd", $datosModel["indsyd"], PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}


#borra seccion
	public function borrarPonderaModel($datosModel,  $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE concat(ser_claveservicio,'.',sec_numseccion,'.',r_numreactivo)=:idb");
		

		$stmt-> bindParam(":idb", $datosModel, PDO::PARAM_STR);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}

   public function vistaReactivoComentModel($datosModel, $datoserv, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT rc_numcomentario, rc_descomentarioesp, rc_descomentarioing FROM cue_reactivoscomentarios WHERE concat(sec_numseccion,'.',r_numreactivo) =:idreac and ser_claveservicio=:idserv");

		$stmt-> bindParam(":idreac", $datosModel, PDO::PARAM_STR);
		$stmt-> bindParam(":idserv", $datoserv, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchall();
	
		$stmt->close();
	}

public function CalculaultimoReacComentModel($datosModel, $datoserv, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(rc_numcomentario) as clavecom FROM $tabla WHERE ser_claveservicio =:idser AND concat(sec_numseccion,'.',r_numreactivo) =:idsec");
		
		$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
		$stm1-> bindParam(":idser", $datoserv, PDO::PARAM_INT);
		$stm1-> execute();
		return $stm1->fetch();
		$stm1->close();

	}

    public function registraReacComentModel($datosModel, $tabla){

			$stmt = Conexion::conectar()->prepare("INSERT INTO cue_reactivoscomentarios (ser_claveservicio, sec_numseccion, r_numreactivo, rc_numcomentario, rc_descomentarioesp, rc_descomentarioing) values (:idser, :idsec, :idreac, :numcom, :comesp, :coming)");

			


			$stmt-> bindParam(":comesp", $datosModel["nomesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":coming", $datosModel["noming"], PDO::PARAM_STR);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":idreac", $datosModel["idreac"], PDO::PARAM_INT);
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

	public function editaPonderaComentModel($datosModel, $servicioModel, $tabla){
	    $stm1=Conexion::conectar()->prepare("select rc_numcomentario, rc_descomentarioesp, rc_descomentarioing from cue_reactivoscomentarios where concat(sec_numseccion,'.',r_numreactivo,'.',rc_numcomentario) =:id and ser_claveservicio =:idser");
	    
	    $stm1-> bindParam(":idser", $servicioModel, PDO::PARAM_INT);
	    $stm1-> bindParam(":id", $datosModel, PDO::PARAM_STR);

	    $stm1-> execute();
	    return$stm1->fetch();
	    $stm1->close();

  }

   public function actualizarPonderaComentModel($datosModel, $tabla){

			$stmt = Conexion::conectar()->prepare("UPDATE cue_reactivoscomentarios SET rc_descomentarioesp=:comesp, rc_descomentarioing=:coming  WHERE ser_claveservicio=:idser and concat(sec_numseccion,'.',r_numreactivo,'.',rc_numcomentario) =:idsec");

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

	public function borrarPondComentModel($datosModel, $servicioModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM cue_reactivoscomentarios WHERE concat(sec_numseccion,'.',r_numreactivo,'.',rc_numcomentario)=:idb and ser_claveservicio=:ids");

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

	public function vistaPonderacionReactivoModel($datosModel, $datoserv, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT rd_clavecuenta, rd_ponderacion, rd_fechainicio, rd_fechafinal FROM cue_reactivosdetalle WHERE concat(sec_numseccion,'.',r_numreactivo)=:numsec and ser_claveservicio=:servicio");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":servicio", $datoserv, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchall();

		$stmt->close();
	}


	public function vistareportePonderaModel($datosModel, $datoserv, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, r_descripcionesp, r_descripcioning, r_tiporeactivo FROM cue_reactivos WHERE sec_numseccion =:numsec AND ser_claveservicio=:servicio AND r_numreactivo<>0");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":servicio", $datoserv, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchall();

		$stmt->close();
	}

	public function leeDatosPonderaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT id_ponderacionreal, id_comentario, id_aceptado, id_noaplica FROM ins_detalle WHERE id_claveservicio =:serv AND id_numreporte =:numrep AND id_numseccion =:numsec AND id_numreactivo =:numreac");

		$stmt-> bindParam(":numsec", $datosModel["sec"], PDO::PARAM_INT);
		$stmt-> bindParam(":serv", $datosModel["ser"], PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $datosModel["nrep"], PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosModel["nreac"], PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}

	public function verificaComentPonderaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT rc_numcomentario FROM $tabla WHERE concat(sec_numseccion,'.',r_numreactivo) =:nsecreac AND ser_claveservicio=:serv");

		$stmt-> bindParam(":nsecreac", $datosModel["secreac"], PDO::PARAM_STR);
		$stmt-> bindParam(":serv", $datosModel["ser"], PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->rowCount();

		$stmt->close();
	}

public function calculasumapond($sv, $nrep, $nsec, $noap, $acep, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT SUM(id_ponderacionreal) AS SUMAPONDERACION FROM ins_detalle WHERE id_claveservicio=:sv AND id_numreporte=:nrep AND id_numseccion=:numsec AND id_aceptado=-1 AND id_noaplica=0");

		$stmt-> bindParam(":sv", $sv, PDO::PARAM_INT);
		$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $nsec, PDO::PARAM_INT);
		
		$stmt-> execute();
		
		return $stmt->fetch();
		$stmt->close();
	}


	


   public function calculasumanoap($sv, $nrep, $nsec,  $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT sum(id_ponderacionreal) as sumanoap FROM $tabla WHERE  id_claveservicio=:sv and id_numreporte =:nrep and id_numseccion=:nsec and id_noaplica=-1");

		$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_STR);
		$stmt-> bindParam(":sv", $sv, PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}

	public function ponderaseccion($sv, $nsec,  $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT sec_ponderacion FROM $tabla WHERE sec_numseccion=:nsec AND ser_claveservicio =:sv");

		$stmt-> bindParam(":sv", $sv, PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}

	public function vistanombrepondera($sv, $nsec,  $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT r_descripcionesp FROM cue_reactivos where ser_claveservicio=:sv and concat(sec_numseccion,'.',r_numreactivo)=:nsec");

		$stmt-> bindParam(":sv", $sv, PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}
	
	public function verificaSeccionPondera($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT id_numreactivo FROM $tabla WHERE id_claveservicio =:nser AND id_numreporte =:nrep AND id_numseccion =:nsec");

		$stmt-> bindParam(":nser", $datosModel["nser"], PDO::PARAM_INT);
		$stmt-> bindParam(":nrep", $datosModel["nrep"], PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $datosModel["nsec"], PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->rowCount();

		$stmt->close();
	}

	public function validaDatosPonderada($nsec, $nser, $nreac, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT r_numreactivo,r_descripcionesp
				   FROM $tabla WHERE ser_claveservicio =:nser 
				    AND sec_numseccion =:nsec
					AND r_numreactivo <>:nreac");

		$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);
		$stmt-> bindParam(":nser", $nser, PDO::PARAM_INT);
		$stmt-> bindParam(":nreac", $nreac, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetchall();

		$stmt->close();
	}




	public function leePonderacionReactivo($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT rd_ponderacion FROM cue_reactivosdetalle WHERE ser_claveservicio =:sv AND sec_numseccion =:nsec AND r_numreactivo =:nreac AND rd_clavecuenta =:ncuen");

		$stmt-> bindParam(":sv", $datosModel["nser"], PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $datosModel["nsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":nreac", $datosModel["nreac"], PDO::PARAM_INT);
		$stmt-> bindParam(":ncuen", $datosModel["ncuen"], PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}

    public function insertaregistroPonderado($datosModel, $tabla){

	$stmt = Conexion::conectar()->prepare("INSERT into $tabla  (id_claveservicio, id_numreporte, id_numseccion, id_numreactivo, id_ponderacionreal, id_comentario, id_aceptado, id_noaplica) values (:idser, :numrep, :numsec, :numreac, :valpond, :descom, :opcsel, :opcnoap)");
			
		$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $datosModel["numsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
		$stmt-> bindParam(":valpond", $datosModel["valpond"], PDO::PARAM_INT);
		$stmt-> bindParam(":descom", $datosModel["descom"], PDO::PARAM_INT);
		$stmt-> bindParam(":opcsel", $datosModel["opcsel"], PDO::PARAM_INT);
		$stmt-> bindParam(":opcnoap", $datosModel["opcnoap"], PDO::PARAM_INT);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};

			$stmt->close();
	}

    public function borrarPonderacionAnterior($nser, $nrep, $nsec, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_claveservicio =:nser  AND id_numreporte =:nrep AND id_numseccion =:nsec");
		

		$stmt-> bindParam(":nser", $nser, PDO::PARAM_INT);
		$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}

 

}