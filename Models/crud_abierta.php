<?php

require_once "Models/conexion.php";


class DatosAbierta extends Conexion{

#vistaponderacion

	public function vistaAbiertaModel($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, ra_descripcioning FROM $tabla WHERE ser_claveservicio=:ids and sec_numseccion =:nsec");
		
		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function vistaAbiertaModeln1($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente,
 ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, ra_descripcioning 
FROM $tabla WHERE ser_claveservicio=:ids and concat(sec_numseccion,r_numreactivo,ra_numcaracteristica,ra_numcomponente2) =:nsec");
		

		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}


public function vistaAbiertaModeln3($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, ra_descripcioning FROM $tabla WHERE ser_claveservicio=:ids and concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica) =:nsec");




		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}
	
	
	public function getAbiertaModeln3($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, 
r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, 
ra_descripcioning FROM $tabla
 WHERE ser_claveservicio=:ids and concat(sec_numseccion,'.',r_numreactivo,'.',ra_numcomponente) =:nsec");
		
		
		
		
		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_STR);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_STR);
		
		$stmt-> execute();
		
		return $stmt->fetch();
	}



	public function CalculaultimaabiertaModel($datosservicio, $datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(ra_numcomponente) as clavecomp from $tabla where ser_claveservicio=:idser and concat(sec_numseccion,r_numreactivo,ra_numcaracteristica,ra_numcomponente2)=:idsec");
		

			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
			$stm1-> execute();
			return $stm1->fetch();
			$stm1->close();

	}


	public function CalculaultimaAbierta3Model($datosservicio, $datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(ra_numcomponente2) as clavecomp from $tabla where ser_claveservicio=:idser and concat(sec_numseccion,r_numreactivo,ra_numcomponente, ra_numcaracteristica)=:idsec");
					
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_INT);
			$stm1-> execute();
			return $stm1->fetch();
			$stm1->close();

	}



	public function insertaabierta13($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla (ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, ra_descripcioning) VALUES (:idser,:numsec,:numreac,:numcom,:numcar,:numcom2,:descripesp,:descriping)");

			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
			$stmt-> bindParam(":descripesp", $datosModel["desesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":descriping", $datosModel["desing"], PDO::PARAM_STR);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}


	public function insertaabierta6($datosModel, $tabla){
			$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla (ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, ra_descripcioning) VALUES (:idser,:numsec,:numreac,:numcom,:numcar,:numcom2,:descripesp,:descriping)");

				$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
				$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
				$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
				$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
				$stmt-> bindParam(":numcar", $datosModel["numcar2"], PDO::PARAM_INT);
				$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
				$stmt-> bindParam(":descripesp", $datosModel["desesp"], PDO::PARAM_STR);
				$stmt-> bindParam(":descriping", $datosModel["desing"], PDO::PARAM_STR);

				IF($stmt-> execute()){

					return "success";
				}
				
				else {

					return "error";
			
				};
			
			$stmt->close();

	}

	public function EditaAbiertaModel($datosservicio, $datosModel, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, ra_descripcioning from $tabla where concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2) =:idsec and ser_claveservicio=:idser");
			
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_STR);
			$stm1-> execute();
			//$stm1->debugDumpParams();
			return $stm1->fetch();
			$stm1->close();

	}


	public function borraabiertaModel($datosModel, $datosservicio, $tabla){
		$stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2) =:idsec and ser_claveservicio=:idser");


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
       


			$stmt-> bindParam(":numser", $datosMode, PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosservicio, PDO::PARAM_INT);
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
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET sec_tiposeccion=:tiposec WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_caracteristica,ra_numcomponente2,rad_numcaracteristica2)=:numsec");
       
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
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET rad_tiporeactivo=:tiposec WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,re_numcomponente,re_numcaracteristica,re_numcomponente2,red_numcaracteristica2)=:numsec");

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







	public function actualizaabierta($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET ra_descripcionesp=:descripesp,ra_descripcioning=:descriping WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2)=:numsec");


			$stmt-> bindParam(":numser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":descripesp", $datosModel["desesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":descriping", $datosModel["desing"], PDO::PARAM_STR);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}

public function vistaAbDetModel($servicioModel, $datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, rad_numcaracteristica2, rad_descripcionesp, rad_descripcioning, rad_syd, rad_lugarsyd, rad_tiporeactivo, rad_formatoreactivo, rad_clavecatalogo, rad_valorminimo, rad_valormaximo FROM $tabla WHERE concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2)=:nsec and ser_claveservicio= :ids");
		
		$stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_INT);
		$stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}
      //  die($ssql);


	public function listacatalogosModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ca_idcatalogo, ca_nombrecatalogo FROM $tabla");
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}


	public function insertareac1($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla (ser_claveservicio, sec_numseccion, r_numreactivo) values (:numser, :numsec, :numreac) ");

			$stmt-> bindParam(":numser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_STR);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}

	public function insertareacab1($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla (ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2) values (:numser,:numsec,:numreac,:numcom,:numcar,:idcom2)");

			$stmt-> bindParam(":numser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_STR);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
			$stmt-> bindParam(":idcom2", $datosModel["numcom2"], PDO::PARAM_STR);
			

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}

	

	public function buscaultimoreactivo($numsec,$numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT max(rad_numcaracteristica2) as numcar2 FROM cue_reactivosabiertosdetalle WHERE ser_claveservicio=:numser and concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2)=:numsec");
	

		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $numsec, PDO::PARAM_STR);
		
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	public function insertaabiertadetalle($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla (ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, rad_numcaracteristica2, rad_descripcionesp, rad_descripcioning, rad_syd, rad_lugarsyd, rad_formatoreactivo, rad_clavecatalogo, rad_valorminimo, rad_valormaximo) values (:numser,:numsec,:numreac,:numcom,:numcar,:idcom2, :numcar2,:desesp,:desesp2,:sydata,:sydludata, :formato, :ncat, :vmin, :vmax)");

			$stmt-> bindParam(":numser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numsec", $datosModel["idsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_STR);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
			$stmt-> bindParam(":idcom2", $datosModel["idcom2"], PDO::PARAM_STR);

			$stmt-> bindParam(":numcar2", $datosModel["numcar2"], PDO::PARAM_INT);
			$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_INT);
			$stmt-> bindParam(":desesp2", $datosModel["desesp2"], PDO::PARAM_STR);
			$stmt-> bindParam(":sydata", $datosModel["sydata"], PDO::PARAM_INT);
			$stmt-> bindParam(":sydludata", $datosModel["sydludata"], PDO::PARAM_INT);
			$stmt-> bindParam(":formato", $datosModel["formato"], PDO::PARAM_STR);
			
			$stmt-> bindParam(":ncat", $datosModel["ncat"], PDO::PARAM_INT);
			$stmt-> bindParam(":vmin", $datosModel["vmin"], PDO::PARAM_INT);
			$stmt-> bindParam(":vmax", $datosModel["vmax"], PDO::PARAM_STR);
						
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();

	}

	public function borraAbiertaDetModel($datosModel, $datosservicio, $tabla){
		$stmt=Conexion::conectar()->prepare("Delete From $tabla Where concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2,rad_numcaracteristica2) =:idsec and ser_claveservicio=:idser");


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

	public function EditaAbiertaDetModel($numsec,$numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, rad_numcaracteristica2, rad_descripcionesp, rad_descripcioning, rad_syd, rad_lugarsyd, rad_tiporeactivo, rad_formatoreactivo, rad_clavecatalogo, rad_valorminimo, rad_valormaximo from cue_reactivosabiertosdetalle  where concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2,rad_numcaracteristica2) =:numsec and ser_claveservicio=:numser");
	

		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $numsec, PDO::PARAM_STR);
		
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();

	}

	public function actualizaAbiertaDetalleModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("Update $tabla Set rad_descripcionesp=:desesp, rad_descripcioning=:desesp2, rad_syd=:sydata, rad_lugarsyd=:sydludata, rad_formatoreactivo=:formato, rad_clavecatalogo=:ncat, rad_valorminimo=:vmin, rad_valormaximo=:vmax where concat(sec_numseccion,r_numreactivo,ra_numcomponente,ra_numcaracteristica,ra_numcomponente2,rad_numcaracteristica2) =:seccion and ser_claveservicio=:idser");

			$stmt-> bindParam(":desesp", $datosModel["desesp"], PDO::PARAM_STR);
			$stmt-> bindParam(":desesp2", $datosModel["desesp2"], PDO::PARAM_STR);
			$stmt-> bindParam(":sydata", $datosModel["sydata"], PDO::PARAM_INT);
			
			$stmt-> bindParam(":sydludata", $datosModel["sydludata"], PDO::PARAM_INT);
			$stmt-> bindParam(":formato", $datosModel["formato"], PDO::PARAM_STR);
			$stmt-> bindParam(":ncat", $datosModel["ncat"], PDO::PARAM_INT);
			
			$stmt-> bindParam(":vmin", $datosModel["vmin"], PDO::PARAM_INT);
			$stmt-> bindParam(":vmax", $datosModel["vmax"], PDO::PARAM_INT);
			$stmt-> bindParam(":seccion", $datosModel["seccion"], PDO::PARAM_INT);
			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}
	
	public function getReactivoAbiertoxReactivo($servicioModel, $datosModel, $tabla){
	    $stmt = Conexion::conectar()-> prepare("SELECT ser_claveservicio, sec_numseccion,
 r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp,
 ra_descripcioning FROM $tabla WHERE ser_claveservicio=:ids and concat(sec_numseccion,'.', r_numreactivo)=:nsec");
	    
	    $stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_STR);
	    $stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
	    
	    $stmt-> execute();
	   
	    return $stmt->fetchAll();
	}
	
	public function consultaInsDetalleAbierta($reporte,$numser,$seccion,$reactivo,$componente,$caract1,$caract2,$caract3,$renglon, $tabla){
	    $query_na="SELECT ida_descripcionreal, ida_numreporte FROM $tabla
where ida_claveservicio=:servicio and ida_numseccion=:seccion and ida_numreactivo=:reactivo and ida_numcomponente=:componente
and ida_numcaracteristica1=:caract1 and ida_numcaracteristica2=:caract2 and ida_numcaracteristica3=:caract3
 and ida_numreporte=:reporte and ida_numrenglon=:renglon";
	    
	    $stmt = Conexion::conectar()-> prepare($query_na);
	    
	  
	    $stmt-> bindParam(":servicio", $numser, PDO::PARAM_INT);
	    $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
	    $stmt-> bindParam(":reactivo", $reactivo, PDO::PARAM_INT);
	    $stmt-> bindParam(":componente", $componente, PDO::PARAM_INT);
	    $stmt-> bindParam(":caract1", $caract1, PDO::PARAM_INT);
	    $stmt-> bindParam(":caract2", $caract2, PDO::PARAM_INT);
	    $stmt-> bindParam(":caract3", $caract3, PDO::PARAM_INT);
	    $stmt-> bindParam(":renglon", $renglon, PDO::PARAM_INT);
	    $stmt-> bindParam(":reporte", $reporte, PDO::PARAM_INT);
	    
	    
	    $stmt-> execute();
	
	    return $stmt->fetchAll();
	
	    
	}

	public function validasubseccionAbierta($idser, $idsec, $idreac, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT rad_descripcionesp FROM $tabla  where ser_claveservicio=:idser and sec_numseccion=:idsec and r_numreactivo=:idreac");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_INT);
			$stmt-> bindParam(":idreac", $idreac, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->rowCount();
		
			$stmt->close();

	}


    public function vistaAbiertareactivo($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp
		  FROM $tabla WHERE ser_claveservicio =:idser  AND concat(sec_numseccion,'.', r_numreactivo) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->fetchall();
			$stmt->close();

	}


	public function vistaAbiertaNumcar($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp
		  FROM $tabla WHERE ser_claveservicio =:idser  AND sec_numseccion=:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetchall();
			$stmt->close();

	}

	public function vistaAbiertaRepGral($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT sec_numseccion, r_numreactivo, ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp FROM $tabla WHERE ser_claveservicio =:idser AND concat(sec_numseccion,'.', r_numreactivo,'.', ra_numcomponente,'.', ra_numcaracteristica) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->fetchall();
			$stmt->close();

	}


	public function vistaNomSecAbierta($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ra_descripcionesp AS descomp FROM  $tabla WHERE ser_claveservicio =:idser AND concat(sec_numseccion,'.', r_numreactivo,'.', ra_numcomponente,'.', ra_numcaracteristica,'.', ra_numcomponente2) = :idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}	

	public function calculaNumRen($idser, $idsec, $idrep, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ida_numrenglon AS claveren 
		  FROM $tabla WHERE ida_claveservicio = :idser 
		   AND ida_numreporte =:idrep 
		   AND concat(ida_numseccion,'.',ida_numreactivo,'.',ida_numcomponente,'.',ida_numcaracteristica1,'.',ida_numcaracteristica2) = :idsec group by ida_numrenglon");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetchall();
		
			$stmt->close();

	}	

	public function vistaReporteAbiertoDetalle($idser, $idsec, $idrep, $numren, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ida_claveservicio, ida_numreporte, 
ida_numseccion, ida_numreactivo, ida_numcomponente,  ida_numcaracteristica1,  
ida_numcaracteristica2,  ida_numcaracteristica3,  ida_descripcionreal, ida_comentario,
  ida_aceptado,  ida_numrenglon, rad_formatoreactivo, rad_clavecatalogo, rad_descripcionesp 
	FROM  $tabla 
	Inner Join cue_reactivosabiertosdetalle
		          ON ida_claveservicio = ser_claveservicio 
				 AND ida_numseccion = sec_numseccion 
				 AND ida_numreactivo = r_numreactivo 
				 AND ida_numcomponente = ra_numcomponente 
				 AND ida_numcaracteristica1 = ra_numcaracteristica 
				 AND ida_numcaracteristica2 = ra_numcomponente2 
				 AND ida_numcaracteristica3 = rad_numcaracteristica2
			   WHERE ida_numrenglon =  :numren 
			     AND ida_numreporte =  :idrep
				 AND ida_claveservicio=:idser
				 AND concat(ida_numseccion,'.',ida_numreactivo,'.',ida_numcomponente,'.',ida_numcaracteristica1,'.',ida_numcaracteristica2) =:idsec");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
			
			$stmt-> execute();
			//$stmt->debugDumpParams();
			return $stmt->fetchall();
		
			$stmt->close();

	}

	
	public function consultaAbiertoDetalle($idser, $idsec, $idrep,  $tabla){
	    $sqlnr = "SELECT  `ida_claveservicio`,
  `ida_numreporte`,
  `ida_numseccion`,
  `ida_numreactivo`,
  `ida_numcomponente`,
  `ida_numcaracteristica1`,
  `ida_numcaracteristica2`,
  `ida_numcaracteristica3`,
  `ida_descripcionreal`,
  `ida_comentario`,
  `ida_aceptado`,
  `ida_numrenglon`
		  FROM ".$tabla."
		 WHERE `ins_detalleabierta`.`ida_claveservicio` =:idser
		   AND `ins_detalleabierta`.`ida_numreporte` =:numrep 
		   AND concat(ida_numseccion,'.',ida_numreactivo,'.',ida_numcomponente,'.',ida_numcaracteristica1,'.',ida_numcaracteristica2) =:secc group by ida_numrenglon;";
	    
	    $stmt=Conexion::conectar()->prepare($sqlnr);
	    
	    $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
	    $stmt-> bindParam(":secc", $idsec, PDO::PARAM_STR);
	    $stmt-> bindParam(":numrep", $idrep, PDO::PARAM_INT);
	    
	    $stmt-> execute();
	   
	    return $stmt->fetchall();
	    
	  
	   
	    
	}
	
	public function consultaAbiertoDetallexSeccion($idser, $idsec, $idrep,  $tabla){
	    $sqlnr = "SELECT  `ida_claveservicio`,
  `ida_numreporte`,
  `ida_numseccion`,
  `ida_numreactivo`,
  `ida_numcomponente`,
  `ida_numcaracteristica1`,
  `ida_numcaracteristica2`,
  `ida_numcaracteristica3`,
  `ida_descripcionreal`,
  `ida_comentario`,
  `ida_aceptado`,
  `ida_numrenglon`
		  FROM ".$tabla."
		 WHERE `ins_detalleabierta`.`ida_claveservicio` =:idser
		   AND `ins_detalleabierta`.`ida_numreporte` =:numrep
		   AND ida_numseccion =:secc ;";
	    
	    $stmt=Conexion::conectar()->prepare($sqlnr);
	    
	    $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
	    $stmt-> bindParam(":secc", $idsec, PDO::PARAM_STR);
	    $stmt-> bindParam(":numrep", $idrep, PDO::PARAM_INT);
	    
	    $stmt-> execute();
	 
	    return $stmt->fetchall();
	    
	    
	    
	    
	}
	
	public function getAbierta($datosservicio, $datosModel, $tabla){
	    $stm1=Conexion::conectar()->prepare("SELECT ser_claveservicio, sec_numseccion, r_numreactivo,
 ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, ra_descripcionesp, ra_descripcioning 
from $tabla where concat(sec_numseccion,'.',r_numreactivo,'.',ra_numcomponente,'.',ra_numcaracteristica,'.',ra_numcomponente2) =:idsec and ser_claveservicio=:idser");
	    
	    $stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
	    $stm1-> bindParam(":idsec", $datosModel, PDO::PARAM_STR);
	    $stm1-> execute();
	  
	    return $stm1->fetch();
	    $stm1->close();
	    
	}
	
	public function getAbDetModel($servicioModel, $datosModel, $tabla){
	    $stmt = Conexion::conectar()-> prepare("SELECT  ser_claveservicio, sec_numseccion, r_numreactivo, 
ra_numcomponente, ra_numcaracteristica, ra_numcomponente2, rad_numcaracteristica2, rad_descripcionesp,
 rad_descripcioning, rad_syd, rad_lugarsyd, rad_tiporeactivo, rad_formatoreactivo, rad_clavecatalogo,
 rad_valorminimo, rad_valormaximo FROM $tabla 
WHERE concat(sec_numseccion,'.',r_numreactivo,'.',ra_numcomponente,'.',
ra_numcaracteristica,'.',ra_numcomponente2)=:nsec and ser_claveservicio= :ids");
	    
	    $stmt-> bindParam(":nsec", $datosModel, PDO::PARAM_STR);
	    $stmt-> bindParam(":ids", $servicioModel, PDO::PARAM_INT);
	    
	    $stmt-> execute();
	 
	    return $stmt->fetchAll();
	}
	
	
public function vistanuevoAbiertoDetalle($idser, $idsec, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM `cue_reactivosabiertosdetalle`
 WHERE `cue_reactivosabiertosdetalle`.`ser_claveservicio` = :idser 
AND concat(sec_numseccion,'.', r_numreactivo,'.', ra_numcomponente,'.', ra_numcaracteristica,'.', ra_numcomponente2) =:idsec order by rad_numcaracteristica2");


			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idsec", $idsec, PDO::PARAM_STR);
			
			$stmt-> execute();
			return $stmt->fetchall();
		
		

	}
	
	

    public function calculaUltimoRenglonAb ($idser, $nrep, $nsec, $tabla){
        $stmt=Conexion::conectar()->prepare("select max(ida_numrenglon) as claveren FROM `ins_detalleabierta` WHERE `ins_detalleabierta`.`ida_claveservicio` =:idser AND `ins_detalleabierta`.`ida_numreporte` =:numrep AND concat(ida_numseccion,'.',ida_numreactivo,'.',ida_numcomponente,'.',ida_numcaracteristica1,'.',ida_numcaracteristica2) =:numseccom");

		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $nrep, PDO::PARAM_INT);
		$stmt-> bindParam(":numseccom", $nsec, PDO::PARAM_STR);

		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
    }

    public function insertaAbiertaDetalle1 ($datosModel, $tabla){
        $stmt=Conexion::conectar()->prepare("INSERT INTO ins_detalleabierta (ida_claveservicio, ida_numreporte, ida_numseccion, ida_numreactivo, ida_numcomponente, ida_numcaracteristica1, ida_numcaracteristica2, ida_numcaracteristica3, ida_descripcionreal, ida_aceptado, ida_numrenglon) values (:idser, :numrep, :numsec, :numreac, :numcom, :numcar, :numcom2, :numcar2, :valcom, :valacepta, :numren)");

		$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
		$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
		$stmt-> bindParam(":numsec", $datosModel["numsec"], PDO::PARAM_INT);
		$stmt-> bindParam(":numreac", $datosModel["numreac"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar", $datosModel["numcar"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcom2", $datosModel["numcom2"], PDO::PARAM_INT);
		$stmt-> bindParam(":numcar2", $datosModel["numcar2"], PDO::PARAM_INT);
		$stmt-> bindParam(":valcom", $datosModel["valcom"], PDO::PARAM_STR);
		$stmt-> bindParam(":valacepta", $datosModel["valacepta"], PDO::PARAM_INT);
		$stmt-> bindParam(":numren", $datosModel["numren"], PDO::PARAM_INT);
	
		IF($stmt-> execute()){
		
				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();
    }

    public function borrarRepAbiertaDet ($idser,$numrep,$idsec, $tabla){
    	$ssqle=("DELETE FROM $tabla WHERE ida_claveservicio = :idser
AND ida_numreporte = :numrep  AND concat(ida_numseccion,'.',ida_numreactivo,'.',
ida_numcomponente,'.',ida_numcaracteristica1,'.',ida_numcaracteristica2,'.',
ida_numrenglon) = :idsec");
    	
    	try{
    	$stmt=Conexion::conectar()->prepare($ssqle);
    	$stmt->bindParam(":idser", $idser, PDO::PARAM_INT);
    	$stmt->bindParam(":numrep", $numrep, PDO::PARAM_INT);
    	$stmt->bindParam(":idsec", $idsec, PDO::PARAM_STR);
    	
    	
    	if(!$stmt->execute()){
    		
    		throw new Exception("Error al eliminiar de la base de datos");
    	}
    	
    	}catch(Exception $ex){
    		throw new Exception("Error al eliminiar de la base de datos");
    	
    	}
    
    }
    
    
    public function consultaGraficaCumplimiento($usuario,$servicio,$nsec){
        $stmt=Conexion::conectar()->prepare("  SELECT
  SUM(IF(`ida_descripcionreal`>25,1,0))/COUNT(`numreporte`)*100 AS nivaceptren
 , `cue_reactivosabiertosdetalle`.`rad_descripcionesp`
    , `cue_reactivosabiertosdetalle`.`rad_descripcioning`
    ,concat(`cue_reactivosabiertosdetalle`.`sec_numseccion`,'.'
    ,r_numreactivo,'.'
    , `cue_reactivosabiertosdetalle`.`ra_numcomponente`,'.'
    , `cue_reactivosabiertosdetalle`.`ra_numcaracteristica`,'.'
    , `cue_reactivosabiertosdetalle`.`ra_numcomponente2`,'.'
    , `cue_reactivosabiertosdetalle`.`rad_numcaracteristica2`) as refer
FROM
    `ins_detalleabierta`
    INNER JOIN `tmp_estadistica` 
        ON (`ins_detalleabierta`.`ida_numreporte` = `tmp_estadistica`.`numreporte`)
   INNER JOIN `cue_reactivosabiertosdetalle` 
        ON (`ins_detalleabierta`.`ida_claveservicio` = `cue_reactivosabiertosdetalle`.`ser_claveservicio`) AND (`ins_detalleabierta`.`ida_numseccion` = `cue_reactivosabiertosdetalle`.`sec_numseccion`) AND (`ins_detalleabierta`.`ida_numreactivo` = `cue_reactivosabiertosdetalle`.`r_numreactivo`) AND (`ins_detalleabierta`.`ida_numcomponente` = `cue_reactivosabiertosdetalle`.`ra_numcomponente`) AND (`ins_detalleabierta`.`ida_numcaracteristica1` = `cue_reactivosabiertosdetalle`.`ra_numcaracteristica`) AND (`ins_detalleabierta`.`ida_numcaracteristica2` = `cue_reactivosabiertosdetalle`.`ra_numcomponente2`) AND (`ins_detalleabierta`.`ida_numcaracteristica3` = `cue_reactivosabiertosdetalle`.`rad_numcaracteristica2`)
        
        WHERE CONCAT(`ida_numseccion`,'.',`ida_numreactivo`,'.',`ida_numcomponente`,'.',
`ida_numcaracteristica1`,'.',`ida_numcaracteristica2`,'.',`ida_numcaracteristica3`)=:seccion 
        AND `ida_claveservicio`=:servicio
        AND `usuario`=:usuario 
       GROUP BY ida_numcaracteristica3");
        
        $stmt-> bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt-> bindParam(":servicio", $servicio, PDO::PARAM_INT);
        $stmt-> bindParam(":seccion", $nsec, PDO::PARAM_STR);
        
        $stmt-> execute();
       // $stmt->debugDumpParams();
        return $stmt->fetchAll();
       
        
    }
    
}
