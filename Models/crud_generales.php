<?php

require_once "Models/conexion.php";


class DatosGenerales extends Conexion{

	public function vistaGeneralModel($datosServ, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gf_nombreesp, gf_nombreing FROM $tabla Inner Join cue_generales ON gf_numdato = gen_numdatoref WHERE gf_idtabla = 'G' AND gen_claveservicio = :numser ORDER BY gen_numdato");

		$stmt-> bindParam(":numser", $datosServ, PDO::PARAM_INT);
				
		$stmt-> execute();

		return $stmt->fetchAll();
	}

	public function datosModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gf_numdato, gf_nombreesp, gf_nombreing, gf_idtabla FROM $tabla WHERE gf_idtabla='G' order by gf_numdato");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}


	public function CalculaultimoDatoModel($datosservicio, $tabla){
		$stm1=Conexion::conectar()->prepare("SELECT max(gen_numdato) as numdato from $tabla  where gen_claveservicio=:idser");
		
			$stm1-> bindParam(":idser", $datosservicio, PDO::PARAM_INT);
			$stm1-> execute();
			return $stm1->fetch();
			$stm1->close();

	}


	public function insertageneralModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla (gen_claveservicio, gen_numdato, gen_lugarsyd, gen_tipodato, gen_numdatoref) values (:ids, :numr,:lugarsyd,:G, :datoref)");


			$stmt-> bindParam(":ids", $datosModel["ids"], PDO::PARAM_INT);
			$stmt-> bindParam(":numr", $datosModel["numr"], PDO::PARAM_INT);
			$stmt-> bindParam(":lugarsyd", $datosModel["lugarsyd"], PDO::PARAM_INT);
			$stmt-> bindParam(":G", $datosModel["G"], PDO::PARAM_STR);
			$stmt-> bindParam(":datoref", $datosModel["datoref"], PDO::PARAM_STR);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}

	public function borrageneralModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("DELETE From $tabla Where concat(gen_claveservicio,gen_numdato)=:ids");

			$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);
		
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}

	
	public function editarGeneralModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gen_tipodato from cue_generales where concat(gen_claveservicio,gen_numdato)=:ids");
	
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();


	}

	

	public function actualizageneralModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE cue_generales Set gen_lugarsyd=:lugarsyd, gen_numdatoref=:datoref where concat(gen_claveservicio,gen_numdato)=:nsec");

			$stmt-> bindParam(":nsec", $datosModel["nsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":lugarsyd", $datosModel["lugarsyd"], PDO::PARAM_INT);
			$stmt-> bindParam(":datoref", $datosModel["datoref"], PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}




}

?>