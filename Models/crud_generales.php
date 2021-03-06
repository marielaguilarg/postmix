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


        public function getDatosReporteUnegocio($numrep,$vservicio)  {
            $sql_titulo = "SELECT * 
FROM ins_generales
Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
WHERE ins_generales.i_numreporte =:numrep   and ins_generales.i_claveservicio=:vservicio";
        //echo $sql_titulo;
          
            $stmt=DatosGenerales::conectar()->prepare($sql_titulo);
           $stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
	     $stmt-> bindParam(":vservicio", $vservicio, PDO::PARAM_INT);
              $stmt-> execute();
//$stmt->debugDumpParams();
            $result=$stmt->fetch();
            return $result;
        }
	public function validaExisteReporte($idser, $idrep, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT i_numreporte FROM ca_unegocios inner join $tabla on une_id=i_unenumpunto WHERE i_claveservicio =:idser AND i_numreporte =:idrep");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->rowCount();
		
			$stmt->close();

	}


	public function vistaReporteGenerales($idser, $idrep, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT i_claveinspector, i_fechavisita, i_mesasignacion, i_horaentradavis, hour(i_horaentradavis) AS HoraEn, minute(i_horaentradavis) AS HoraEn2, i_horasalidavis, hour(i_horasalidavis) AS HoraEn5, minute(i_horasalidavis) AS HoraEn6, hour(i_horaanalisissensorial) AS HoraEn3, minute(i_horaanalisissensorial) AS HoraEn4, i_responsablevis, i_puestoresponsablevis, i_sincobro, i_reportecic, i_numreportecic, i_finalizado, une_coordenadasxy, i_fechafinalizado, i_reasigna FROM ca_unegocios inner join $tabla on une_id=i_unenumpunto
			WHERE i_claveservicio =:idser AND i_numreporte =:idrep");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			
			$stmt-> execute();
			return $stmt->fetch();
		
			$stmt->close();

	}



       


}

?>
