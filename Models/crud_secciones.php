<?php



require_once "Models/conexion.php";


class DatosSeccion extends Conexion{

#vistasecciones

	public function vistaSeccionModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, sec_descripcionesp, sec_descripcioning, sec_nomsecesp, sec_nomsecing, sec_tiposeccion, sec_ponderacion, sec_nomsecind, sec_ordsecind, sec_indagua FROM $tabla where ser_claveservicio=:ids ");
		
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}


public function vistaNombreServModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_descripcionesp, cli_nombre FROM ca_servicios inner join ca_clientes ON ser_idcliente= cli_id WHERE ser_id=:ids");
		
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}



public function editaSeccionModel($datosModel, $servicioModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, sec_descripcionesp, sec_descripcioning, sec_nomsecesp, sec_nomsecing, sec_tiposeccion, sec_ponderacion, sec_nomsecind, sec_ordsecind, sec_indagua FROM $tabla where ser_claveservicio=:ids and sec_numseccion=:nsec");
		
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}

public function actualizarSeccionModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET sec_descripcionesp=:desesp,sec_descripcioning=:desing, sec_nomsecesp= :nomesp, sec_nomsecing=:noming, sec_ordsecind=:ordensec,sec_indagua=:indmues WHERE ser_claveservicio=:idser and sec_numseccion=:idsec");

		
		$stmt-> bindParam(":nomesp", $datosModel["nomesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":noming", $datosModel["noming"], PDO::PARAM_INT);
		$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_INT);
		$stmt-> bindParam(":desing", $datosModel["desing"], PDO::PARAM_STR);
		$stmt-> bindParam(":ordensec", $datosModel["ordensec"], PDO::PARAM_STR);
		$stmt-> bindParam(":idsec", $datosModel["idsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
		$stmt-> bindParam(":indmues", $datosModel["indagua"], PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
	}


public function CalculaultimaSeccionModel($datosModel, $tabla){
	$stm1=Conexion::conectar()->prepare("SELECT max(sec_numseccion) as ulnumsec FROM $tabla WHERE ser_claveservicio=:idser");
		$stm1-> bindParam(":idser", $datosModel, PDO::PARAM_INT);
		$stm1-> execute();
		return $stm1->fetch();
		$stm1->close();

}


public function registrarSeccionModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (ser_claveservicio, sec_numseccion, sec_descripcionesp, sec_descripcioning, sec_nomsecesp, sec_nomsecing, sec_ordsecind, sec_indagua) VALUES (:idser,:idsec,:desesp,:desing,:nomesp,:noming,:ordensec,:indmues)");

		
		$stmt-> bindParam(":nomesp", $datosModel["nomesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":noming", $datosModel["noming"], PDO::PARAM_STR);
		$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_STR);
		$stmt-> bindParam(":desing", $datosModel["desing"], PDO::PARAM_STR);
		$stmt-> bindParam(":ordensec", $datosModel["ordensec"], PDO::PARAM_INT);
		$stmt-> bindParam(":idsec", $datosModel["idsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
		$stmt-> bindParam(":indmues", $datosModel["indagua"], PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};

		$stmt->close();
}

#borra seccion
	public function borrarSeccionModel($datosModel, $servicioModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE ser_claveservicio= :ids and sec_numseccion= :idb");

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

	public function vistaPonderaModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_id, cue_descripcion, cue_tipomercado, cue_siglas, cue_lugar, cue_idcliente FROM ca_cuentas limit 1");
		
		$stmt-> execute();

		return $stmt->fetch();
	}

	public function vistaPonderaDetalleModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, sd_clavecuenta, sd_ponderacion, sd_fechainicio, sd_fechafinal FROM $tabla where sec_numseccion = :nusec and ser_claveservicio=:servicio and sd_clavecuenta=:cta  and sd_fechainicio<=now() and  sd_fechafinal>=now()");

		$stmt-> bindParam(":nusec", $datosModel["numsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":servicio", $datosModel["servicio"], PDO::PARAM_INT);
		$stmt-> bindParam(":cta", $datosModel["cuenta"], PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
	}

	public function vistaPonderacionDetalleModel($datosModel, $datoserv, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, sd_clavecuenta, sd_ponderacion, sd_fechainicio, sd_fechafinal FROM $tabla WHERE sec_numseccion=:numsec and ser_claveservicio=:servicio");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":servicio", $datoserv, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchall();

		$stmt->close();
	}

public function vistaCuentasPonderacionModel($numcta,  $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_descripcion FROM $tabla WHERE  cue_id=:idcuenta");

		$stmt-> bindParam(":idcuenta", $numcta, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}


	public function borrarSeccionPonderaModel($cuentaModel, $datosModel, $servicioModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM  cue_seccionesdetalles Where sec_numseccion=:numsec and sd_clavecuenta=:numcta and ser_claveservicio=:numser");

		
		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $servicioModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numcta", $cuentaModel, PDO::PARAM_INT);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		}

		$stmt->close();	
	}

	public function vistaSeccionComentModel($datosModel, $datoserv, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  sec_numcoment, sec_comentesp, sec_comenting FROM cue_seccioncomentario WHERE ser_claveservicio=:numser and sec_numseccion=:numsec");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datoserv, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchall();
	
		$stmt->close();
	}

	public function CalculaultimoComentModel($datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(sec_numcoment) as clave FROM $tabla WHERE concat(ser_claveservicio,'.',sec_numseccion) =:idsec");
		
		$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
		$stm1-> execute();
		return $stm1->fetch();
		$stm1->close();

	}

	public function registrarComentSeccionModel($datosModel, $tabla){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (ser_claveservicio, sec_numseccion, sec_numcoment, sec_comentesp, sec_comenting) VALUES (:idser, :idsec, :numcom, :comesp, :coming)");

			$stmt-> bindParam(":comesp", $datosModel["nomesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":coming", $datosModel["noming"], PDO::PARAM_STR);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_STR);
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

	public function editaComentModel($datosModel, $servicioModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT sec_comentesp, sec_comenting FROM cue_seccioncomentario WHERE concat(sec_numseccion,'.',sec_numcoment)=:id AND ser_claveservicio =:idser");
		
		$stm1-> bindParam(":idser", $servicioModel, PDO::PARAM_INT);
		$stm1-> bindParam(":id", $datosModel, PDO::PARAM_STR);

		$stm1-> execute();
		return $stm1->fetch();
		$stm1->close();

	}

   public function actualizarComentSeccionModel($datosModel, $tabla){

			$stmt = Conexion::conectar()->prepare("UPDATE cue_seccioncomentario
			SET sec_comentesp=:comesp, sec_comenting=:coming  WHERE ser_claveservicio=:idser
		    AND concat(sec_numseccion,'.',sec_numcoment)=:idsec");

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

	public function borrarComentModel($datosModel, $servicioModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM cue_seccioncomentario 
			WHERE concat(sec_numseccion,'.',sec_numcoment)=:idb 
			  AND ser_claveservicio=:ids");

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

	public function vistaNombreSeccionModel($datosModel, $datoserv, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT sec_descripcionesp, sec_descripcioning, sec_nomsecesp, sec_nomsecing, sec_tiposeccion, sec_ponderacion, sec_nomsecind, sec_ordsecind, sec_indagua FROM $tabla WHERE ser_claveservicio=:numser and sec_numseccion=:numsec");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datoserv, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
	
		$stmt->close();
	}


	public function vistaNombreSeccionPondModel($datosModel, $datoserv, $datosreac, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT r_descripcionesp  FROM $tabla WHERE ser_claveservicio=:numser and sec_numseccion=:numsec and r_numreactivo=:numreac");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datoserv, PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosreac, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetch();
	
		$stmt->close();
	}

	public function vistaNombreSeccionAbModel($datosModel, $datoserv, $datosreac, $datoscom, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  ra_descripcionesp FROM $tabla WHERE ser_claveservicio=:numser and sec_numseccion=:numsec and r_numreactivo=:numreac and ra_numcomponente=:numcom");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datoserv, PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosreac, PDO::PARAM_INT);
		$stmt-> bindParam(":numcom", $datoscom, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();
	
		$stmt->close();
	}

	public function vistaNombreSeccionEstModel($datosModel, $datoserv, $datosreac, $datoscom, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  re_descripcionesp FROM $tabla WHERE ser_claveservicio=:numser and sec_numseccion=:numsec and r_numreactivo=:numreac and re_numcomponente=:numcom");

		$stmt-> bindParam(":numsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datoserv, PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosreac, PDO::PARAM_INT);
		$stmt-> bindParam(":numcom", $datoscom, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetch();
	
		$stmt->close();
	}

	public function buscaponderacionseccion($datossec,  $datosser, $datoscuen, $tabla){
		
        $stmt=Conexion::conectar()->prepare("SELECT  sd_clavecuenta, sd_ponderacion, sd_fechainicio, sd_fechafinal FROM cue_seccionesdetalles where sec_numseccion =:numsec and ser_claveservicio=:numser and sd_clavecuenta=:numcuen  and sd_fechainicio<=now() and  sd_fechafinal>=now()");

       	$stmt-> bindParam(":numsec", $datossec, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $datosser, PDO::PARAM_INT);
		$stmt-> bindParam(":numcuen", $datoscuen, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchall();
		$stmt->close();
    }

	public function RegistrosEnSeccion($sv, $nsec, $nrep, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT is_numreporte 
         FROM $tabla
        WHERE is_claveservicio=:idser
          AND is_numreporte=:numrep
          AND is_numseccion=:numsec");

		$stmt-> bindParam(":idser", $sv, PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $nsec, PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $nrep, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->rowCount();

		$stmt->close();
	}
 
  public function actualizaPondSeccion($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE ins_seccion set is_nivelcum=:nivelacep, is_pondreal=:valreal where is_claveservicio=:idser AND is_numreporte=:numrep AND is_numseccion=:numsec");

			$stmt-> bindParam(":nivelacep", $datosModel["nivacep"], PDO::PARAM_INT);
			$stmt-> bindParam(":valreal", $datosModel["valreal"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["numsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};

			$stmt->close();
	}

	public function registraPonderaSeccion($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO ins_seccion (is_claveservicio, is_numreporte, is_numseccion, is_nivelcum,is_pondreal) values (:idser, :numrep, :numsec, :nivelacep, :valreal");

		
		$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
		$stmt-> bindParam(":nivelacep", $datosModel["nivacep"], PDO::PARAM_INT);
		$stmt-> bindParam(":valreal", $datosModel["valreal"], PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $datosModel["numsec"], PDO::PARAM_INT);
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