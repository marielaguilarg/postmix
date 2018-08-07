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
        
        
function CumplimientoPonderada($vservicio, $referencia, $reporte) {
  
    $SQL_PRESION_O = "SELECT  id_aceptado as nivaceptren, cue_reactivos.r_descripcionesp, cue_reactivos.r_descripcioning, id_noaplica
FROM ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
WHERE
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo) =  :referencia  and ins_detalle.id_numreporte=:rep and cue_reactivos.ser_claveservicio=:vservicio";
    //echo $SQL_PRESION_O;

    $stmt = Conexion::conectar()-> prepare($SQL_PRESION_O);

    $stmt-> bindParam(":referencia", $referencia, PDO::PARAM_STR);
    $stmt-> bindParam(":rep",$reporte , PDO::PARAM_INT);
    $stmt-> bindParam(":vservicio", $vservicio, PDO::PARAM_INT);
    $stmt-> execute();

    $RS_PRESION_O=$stmt->fetchall();
    $res=array();
    foreach ($RS_PRESION_O as $ROW_PRESION_O) {
        if ($ROW_PRESION_O ['id_noaplica'] == - 1)
        {    $res[2] = "<strong>NA</strong>";}
        else
        if ($ROW_PRESION_O ['nivaceptren'] == - 1)
        {   $res[2] = "paloma";}
        else
        {    $res[2] = "tache";}
        if ($_SESSION["idiomaus"] == 2)
        {   $res[0] = $ROW_PRESION_O ['r_descripcioning'];}
        else
        {    $res[0] = $ROW_PRESION_O ['r_descripcionesp'];}
        $res[1] = "";
        $res[3] = $referencia;
    }
    return $res;
}


}