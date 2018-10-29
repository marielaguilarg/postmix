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


        public function consultaReporteUnegocioInspector($numrep,$vservicio)  {
            $sql_titulo = "SELECT * , left(i_horaentradavis,5) as horent,   left(i_horasalidavis,5) as horsal,  left(i_horaanalisissensorial,5) as horana
FROM ins_generales Inner Join ca_unegocios ON 
 ins_generales.i_unenumpunto = ca_unegocios.une_id
 Inner Join ca_inspectores ON ins_generales.i_claveinspector = ca_inspectores.ins_clave
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
		
		
	}

	public function insertaRepGeneral($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla (i_claveservicio, i_numreporte, i_unenumpunto, i_claveinspector, i_fechavisita, i_mesasignacion, i_horaentradavis, i_horasalidavis, i_responsablevis, i_puestoresponsablevis,  i_horaanalisissensorial, i_reportecic, i_sincobro, i_numreportecic, i_fechafinalizado, i_reasigna)
		VALUES
 			(:idser, :numrep, :numunineg, :cinspec, :fecvis, :mesasig, :horent, :horsal, :resp, :cargo, :horanasen, :repcic1, :sincob1, :numrepcic, :fecemis, :reasig)");

			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
			$stmt-> bindParam(":numunineg", $datosModel["numunineg"], PDO::PARAM_INT);
			$stmt-> bindParam(":cinspec", $datosModel["cinspec"], PDO::PARAM_INT);
			$stmt-> bindParam(":fecvis", $datosModel["fecvis"], PDO::PARAM_STR);
			$stmt-> bindParam(":mesasig", $datosModel["mesasig"], PDO::PARAM_STR);
			$stmt-> bindParam(":horent", $datosModel["horent"], PDO::PARAM_STR);
			$stmt-> bindParam(":horsal", $datosModel["horsal"], PDO::PARAM_STR);
			$stmt-> bindParam(":resp", $datosModel["resp"], PDO::PARAM_INT);
			$stmt-> bindParam(":cargo", $datosModel["cargo"], PDO::PARAM_STR);
			$stmt-> bindParam(":horanasen", $datosModel["horanasen"], PDO::PARAM_STR);
			$stmt-> bindParam(":repcic1", $datosModel["repcic1"], PDO::PARAM_INT);
			$stmt-> bindParam(":sincob1", $datosModel["sincob1"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrepcic", $datosModel["numrepcic"], PDO::PARAM_INT);
			$stmt-> bindParam(":fecemis", $datosModel["fecemis"], PDO::PARAM_STR);
			$stmt-> bindParam(":reasig", $datosModel["reasig"], PDO::PARAM_INT);
			

			IF($stmt-> execute()){

				return "success";
	}
	
			else {
        
				return "error";
        
			}
                                
                                
	}
          
        
	public function actualizaRepGeneral($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE ins_generales Set i_claveinspector=:cinspec, i_mesasignacion=:mesasig, i_horaentradavis=:horent, i_horasalidavis=:horsal, i_responsablevis=:resp, i_puestoresponsablevis=:cargo,  i_horaanalisissensorial=:horanasen, i_fechavisita=:fecvis, i_reportecic=:repcic1,  i_sincobro=:sincob1, i_numreportecic=:numrepcic, i_coordenadasxy=:coorxy, i_fechafinalizado=:fecemis, i_finalizado=:finaliza, i_reasigna=:reasig where  i_claveservicio =:idser and i_numreporte =:numrep and i_unenumpunto = :numunineg");

			$stmt-> bindParam(":idser", $datosModel["idser"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
		   $stmt-> bindParam(":numunineg", $datosModel["numunineg"], PDO::PARAM_INT);
			$stmt-> bindParam(":cinspec", $datosModel["cinspec"], PDO::PARAM_INT);
			$stmt-> bindParam(":fecvis", $datosModel["fecvis"], PDO::PARAM_STR);
			$stmt-> bindParam(":mesasig", $datosModel["mesasig"], PDO::PARAM_STR);
			$stmt-> bindParam(":horent", $datosModel["horent"], PDO::PARAM_STR);
       		$stmt-> bindParam(":resp", $datosModel["resp"], PDO::PARAM_INT);
			$stmt-> bindParam(":cargo", $datosModel["cargo"], PDO::PARAM_STR);
		   $stmt-> bindParam(":horanasen", $datosModel["horanasen"], PDO::PARAM_STR);
			$stmt-> bindParam(":repcic1", $datosModel["repcic1"], PDO::PARAM_INT);
			$stmt-> bindParam(":sincob1", $datosModel["sincob1"], PDO::PARAM_INT);
		   $stmt-> bindParam(":numrepcic", $datosModel["numrepcic"], PDO::PARAM_INT);
			$stmt-> bindParam(":fecemis", $datosModel["fecemis"], PDO::PARAM_STR);
			$stmt-> bindParam(":reasig", $datosModel["reasig"], PDO::PARAM_INT);
			$stmt-> bindParam(":coorxy", $datosModel["coorxy"], PDO::PARAM_STR);
			$stmt-> bindParam(":finaliza", $datosModel["finaliza"], PDO::PARAM_INT);
						

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			}
		
			$stmt->close();

	}



 public function consultaReportexServicioUneg($idser, $idune, $tabla){
	    $sqltr="SELECT ins_generales.i_numreporte FROM
ins_generales WHERE ins_generales.i_unenumpunto =:cveuneg AND

ins_generales.i_claveservicio =:cveser ";
	    $stmt=Conexion::conectar()->prepare($sqltr);
	    
	    $stmt-> bindParam(":cveser", $idser, PDO::PARAM_INT);
	    $stmt-> bindParam(":cveuneg", $idune, PDO::PARAM_INT);
	    
	    $stmt-> execute();
	    return $stmt->fetchAll();
	   
	    
	}
	

       


	   
public function actualizafinalizado($idser, $numrep, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE ins_generales SET i_finalizado=1 WHERE i_claveservicio =:idser AND i_numreporte =:numrep");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}

	public function reactivaReporte($idser, $numrep, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE ins_generales SET i_finalizado=0 WHERE i_claveservicio =:idser AND i_numreporte =:numrep");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}

	
	public function validaDiagnostico($idser, $idrep, $idsec, $idreac, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT id_aceptado FROM ins_detalle WHERE id_claveservicio =:idser AND id_numreporte =:idrep AND id_numseccion =:nsec AND id_numreactivo =: nreac");

			$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":idrep", $idrep, PDO::PARAM_INT);
			$stmt-> bindParam(":nsec", $idsec, PDO::PARAM_INT);
			$stmt-> bindParam(":nreac", $idreac, PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->rowCount();
		
			$stmt->close();
	}

public function finalizaSolicitud($idser, $numrep, $estsol, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET sol_estatussolicitud=:stsol, sol_fechaterminacion=now() WHERE sol_claveservicio=:nser AND sol_numrep=:nrep");

			$stmt-> bindParam(":nser", $idser, PDO::PARAM_INT);
			$stmt-> bindParam(":nrep", $numrep, PDO::PARAM_INT);
			$stmt-> bindParam(":stsol", $estsol, PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}



public function getReportexPeriodo($idser, $mini, $mesfin, $mfin, $tabla){
    $sql="SELECT  i_numreporte
FROM ".$tabla." 
WHERE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')) >= str_to_date(concat('01.',:mini),'%d.%m.%Y') 
AND (str_to_date(concat(:mesfin,'.',ins_generales.i_mesasignacion),'%d.%m.%Y')) <= str_to_date(concat(:mesfin,'.',:mfin),'%d.%m.%Y') 
and  i_claveservicio=:cserv ORDER BY i_numreporte";
    
    
    $stmt=Conexion::conectar()->prepare($sql);
    
    $stmt-> bindParam(":cserv", $idser, PDO::PARAM_INT);
    $stmt-> bindParam(":mini", $mini, PDO::PARAM_STR);
    $stmt-> bindParam(":mesfin", $mesfin, PDO::PARAM_STR);
    $stmt-> bindParam(":mfin", $mfin, PDO::PARAM_STR);
    
    $stmt-> execute();
    $stmt->debugDumpParams();
    return $stmt->fetchAll();
    
   
}
public function actualizarDatosFactura($datosModel, $tabla){
    $sqlv="UPDATE `ins_generales` SET `i_sincobro` = :cobro, `i_numfactura` = :factura,`i_finalizado` = :fin
WHERE i_claveservicio=:cserv and i_numreporte=:nrep";
    try{
        $stmt=Conexion::conectar()->prepare($sqlv);
        $stmt->bindParam(":cserv", $datosModel["idser"], PDO::PARAM_INT);
        $stmt->bindParam(":nrep", $datosModel["numrep"], PDO::PARAM_INT);
       
        $stmt->bindParam(":cobro", $datosModel["cobro"], PDO::PARAM_STR);
        $stmt->bindParam(":factura", $datosModel["factura"], PDO::PARAM_STR);
        $stmt->bindParam(":fin", $datosModel["fin"], PDO::PARAM_STR);
        
        $stmt->execute();
    }catch(PDOException $ex){
        throw new Exception("Error al actualizar");
    }
    
    
}

}

?>
