<?php

require_once "Models/conexion.php";

class DatosProducto extends Conexion{

	public function vistaProductosModel($datosServ, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gf_nombreesp, gf_nombreing FROM $tabla Inner Join cue_generales ON gf_numdato = gen_numdatoref WHERE gf_idtabla = 'V' AND gen_claveservicio = :numser ORDER BY gen_numdato");

		$stmt-> bindParam(":numser", $datosServ, PDO::PARAM_INT);
				
		$stmt-> execute();

		return $stmt->fetchAll();
	}

    public function datosProductosModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gf_numdato, gf_nombreesp, gf_nombreing, gf_idtabla FROM $tabla WHERE gf_idtabla='V' order by gf_numdato");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	public function editarProductoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gen_tipodato from cue_generales where concat(gen_claveservicio,gen_numdato)=:ids");
	
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();


	}



	public function datosProductoModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gf_numdato, gf_nombreesp, gf_nombreing, gf_idtabla FROM $tabla WHERE gf_idtabla='V' order by gf_numdato");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

		public function actualizaProductosModel($datosModel, $tabla){
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


	public function vistaRepProductosModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ip_numseccion,ip_numrenglon,ip_numsistema,ip_descripcionproducto,ip_numcajas, ip_fechaproduccion,ip_fechacaducidad,ip_condicion,ip_edaddias,ip_semana,ip_estatus,ip_sinetiqueta FROM $tabla WHERE ip_claveservicio =:sv AND ip_numseccion =:sec and ip_numreporte =:numrep");

			$stmt-> bindParam(":sec", $datosModel["sec"], PDO::PARAM_INT);
			$stmt-> bindParam(":sv", $datosModel["sv"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $datosModel["nrep"], PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetchAll();

			$stmt->close();

	}

    public function nombreOpProducto($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT cad_descripcionesp FROM ca_catalogosdetalle WHERE cad_idcatalogo =:idcat AND cad_idopcion =:idop");

			$stmt-> bindParam(":idcat", $datosModel["idcat"], PDO::PARAM_INT);
			$stmt-> bindParam(":idop", $datosModel["idop"], PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetch();

			$stmt->close();

	}

}

?>