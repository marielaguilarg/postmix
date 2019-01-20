<?php

require_once "Models/conexion.php";


class DatosMuestra extends Conexion{ 

			  public function listaMuestrasxRep($servicio, $reporte,$tabla){

        $sql_rep="SELECT aa_muestras.mue_fechahora, aa_muestras.mue_fecharecepcion, aa_muestras.mue_fechoranalisisFQ, aa_muestras.mue_fechoranalisisMB, aa_muestras.mue_numreporte, aa_muestras.mue_claveservicio, aa_muestras.mue_idmuestra, if(aa_muestras.mue_fechoranalisisFQ>aa_muestras.mue_fechoranalisisMB,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_fechoranalisisMB) as ulfeclab,  if((aa_muestras.mue_fechoranalisisFQ ='0000-00-00 00:00:00') or (aa_muestras.mue_fechoranalisisMB ='0000-00-00 00:00:00'),null,datediff(if(aa_muestras.mue_fechoranalisisFQ>aa_muestras.mue_fechoranalisisMB,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_fechoranalisisMB),mue_fecharecepcion) ) AS dias_trans_lab

FROM

$tabla WHERE aa_muestras.mue_claveservicio =:nserv AND aa_muestras.mue_numreporte =:nrep";

        $stmt=Conexion::conectar()->prepare($sql_rep);

        $stmt->bindParam("nserv", $servicio,PDO::PARAM_INT);

        $stmt->bindParam("nserv", $reporte,PDO::PARAM_INT);

        

        $stmt-> execute();

        return $stmt->fetchall();

        

   

    }


#vistaponderacion

	public function vistaMuestras($estatusmues, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  aa_muestras.mue_idmuestra, aa_muestras.mue_estatusmuestra, aa_muestras.mue_numreporte, aa_muestras.mue_estatusmuestra, aa_muestras.mue_estatusFQ, aa_muestras.mue_estatusMB, aa_recepcionmuestra.rm_embotelladora, une_descripcion, ser_descripcionesp
			FROM aa_muestras 
			inner join aa_recepcionmuestradetalle ON aa_muestras.mue_idmuestra = aa_recepcionmuestradetalle.mue_idmuestra
			inner join aa_recepcionmuestra ON aa_recepcionmuestra.rm_idrecepcionmuestra = aa_recepcionmuestradetalle.rm_idrecepcionmuestra
			inner join ins_generales ON aa_muestras.mue_numreporte = ins_generales.i_numreporte 
			AND aa_muestras.mue_claveservicio = ins_generales.i_claveservicio
			inner join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
			inner join ca_servicios ON ins_generales.i_claveservicio = ca_servicios.ser_id
 			WHERE aa_muestras.mue_estatusmuestra =:stmues GROUP BY aa_recepcionmuestradetalle.mue_idmuestra");
		
		$stmt-> bindParam(":stmues", $estatusmues, PDO::PARAM_INT);
				
		$stmt-> execute();
	
		return $stmt->fetchAll();

	}


    public function vistaMuestrasLab($estatusmues, $tipocons, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  aa_muestras.mue_idmuestra, aa_muestras.mue_estatusmuestra, aa_muestras.mue_numreporte, aa_muestras.mue_estatusmuestra, aa_muestras.mue_estatusFQ, aa_muestras.mue_estatusMB , aa_recepcionmuestra.rm_embotelladora, une_descripcion, ser_descripcionesp
			FROM aa_muestras inner join aa_recepcionmuestradetalle ON aa_muestras.mue_idmuestra = aa_recepcionmuestradetalle.mue_idmuestra inner join aa_recepcionmuestra ON aa_recepcionmuestra.rm_idrecepcionmuestra = aa_recepcionmuestradetalle.rm_idrecepcionmuestra inner join ins_generales ON aa_muestras.mue_numreporte = ins_generales.i_numreporte AND aa_muestras.mue_claveservicio = ins_generales.i_claveservicio inner join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id inner join ca_servicios ON ins_generales.i_claveservicio = ca_servicios.ser_id  WHERE aa_muestras.mue_estatusmuestra =:stmues AND aa_recepcionmuestra.rm_embotelladora =:tipocons GROUP BY aa_recepcionmuestradetalle.mue_idmuestra");
		
		$stmt-> bindParam(":stmues", $estatusmues, PDO::PARAM_INT);
		$stmt-> bindParam(":tipocons", $tipocons, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();

	}

	public function vistaItem($ntoma, $tipoana, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT mue_idmuestra, mue_estatusmuestra,
mue_origenmuestra,mue_tipomuestra,mue_numtoma,mue_numunidadesFQ,
mue_capacidadFQ,mue_fechahora,horamues,mue_numreporte,ide_claveservicio,rm_personarecibe,rm_embotelladora,rm_fechahora, 
ide_idmuestra,ide_numreporte,ide_numseccion,re_numcomponente,re_descripcionesp, horarec FROM 
(SELECT aa_muestras.mue_idmuestra, aa_muestras.mue_estatusmuestra,
aa_muestras.mue_origenmuestra,aa_muestras.mue_tipomuestra,aa_muestras.mue_numtoma, aa_muestras.mue_numunidadesFQ,
aa_muestras.mue_capacidadFQ, aa_muestras.mue_numunidadesMB,aa_muestras.mue_capacidadMB,
aa_muestras.mue_fechahora,time(aa_muestras.mue_fechahora) AS horamues,aa_muestras.mue_numreporte,
 aa_recepcionmuestra.rm_personarecibe,aa_recepcionmuestra.rm_embotelladora,
aa_recepcionmuestra.rm_fechahora,time(aa_recepcionmuestra.rm_fechahora) as horarec 
FROM $tabla Inner Join aa_recepcionmuestradetalle ON aa_muestras.mue_idmuestra = aa_recepcionmuestradetalle.mue_idmuestra
 Inner Join aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
 WHERE aa_recepcionmuestradetalle.rmd_tipoanalisis =:tipoana AND aa_muestras.mue_idmuestra=:ntoma
) AS A INNER JOIN (SELECT ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_numreporte,
ins_detalleestandar.ide_claveservicio,ins_detalleestandar.ide_numseccion,cue_reactivosestandar.re_numcomponente,
cue_reactivosestandar.re_descripcionesp FROM ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion
 AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente
Inner Join cue_secciones ON cue_reactivosestandar.ser_claveservicio = cue_secciones.ser_claveservicio 
AND cue_reactivosestandar.sec_numseccion = cue_secciones.sec_numseccion WHERE cue_secciones.sec_indagua =  1 GROUP BY 
ins_detalleestandar.ide_claveservicio,ins_detalleestandar.ide_numreporte,ins_detalleestandar.ide_idmuestra,
ins_detalleestandar.ide_numseccion ) AS B ON  A.mue_idmuestra = B.ide_idmuestra");
		
		$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
		$stmt-> bindParam(":tipoana", $tipoana, PDO::PARAM_INT);
		$stmt-> execute();


		return $stmt->fetchAll();

	}


    public function vistaDatosPunto($idser, $idmues, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT ca_unegocios.une_descripcion, ca_unegocios.une_idpepsi, ca_unegocios.une_idcuenta, ca_unegocios.cue_clavecuenta, ca_inspectores.ins_nombre, ins_generales.i_responsablevis, ins_generales.i_fechavisita,ins_generales.i_numreporte 
			FROM $tabla Inner Join ins_generales ON  ca_unegocios.une_id = ins_generales.i_unenumpunto Inner Join ca_inspectores ON ins_generales.i_claveinspector = ca_inspectores.ins_clave Inner Join ins_detalleestandar ON ins_generales.i_claveservicio = ins_detalleestandar.ide_claveservicio AND ins_generales.i_numreporte = ins_detalleestandar.ide_numreporte 
WHERE ins_detalleestandar.ide_claveservicio = :idser AND ins_detalleestandar.ide_idmuestra =:idmues GROUP BY ins_detalleestandar.ide_claveservicio, ca_unegocios.une_id ORDER BY ca_unegocios.une_id");
		
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
		$stmt-> bindParam(":idmues", $idmues, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();

	}


    public function vistaResultados($idser, $indagua, $tipoana, $tipomue, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_reactivosestandardetalle.red_parametroesp,
 cue_reactivosestandardetalle.red_parametroing, cue_reactivosestandardetalle.red_lugarsyd, 
cue_reactivosestandardetalle.ser_claveservicio, cue_reactivosestandardetalle.sec_numseccion, 
cue_reactivosestandardetalle.r_numreactivo, cue_reactivosestandardetalle.re_numcomponente, 
cue_reactivosestandardetalle.re_numcaracteristica, cue_reactivosestandardetalle.re_numcomponente2, 
cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_estandar, 
cue_reactivosestandardetalle.red_tiporeactivo, red_tipodato
 FROM $tabla Inner Join cue_reactivosestandardetalle ON aa_pruebaanalisis.pa_numcomponente = cue_reactivosestandardetalle.re_numcomponente
 AND aa_pruebaanalisis.pa_numprueba = cue_reactivosestandardetalle.red_numcaracteristica2 AND aa_pruebaanalisis.pa_numservicio = cue_reactivosestandardetalle.ser_claveservicio
Inner Join cue_secciones ON cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio 
AND cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion 
WHERE cue_reactivosestandardetalle.ser_claveservicio =:idser AND cue_secciones.sec_indagua = :indagua 
AND aa_pruebaanalisis.pa_tipoanalisis = :tipoana AND cue_reactivosestandardetalle.re_numcomponente = :tipomue
");
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
		$stmt-> bindParam(":indagua", $indagua, PDO::PARAM_INT);
		$stmt-> bindParam(":tipoana", $tipoana, PDO::PARAM_STR);
		$stmt-> bindParam(":tipomue", $tipomue, PDO::PARAM_INT);
		
		$stmt-> execute();
//$stmt->debugDumpParams();
		return $stmt->fetchall();

	}

	public function actualizaestatusrepFQ($estatus, $ntoma, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE aa_muestras SET aa_muestras.mue_estatusFQ=2 WHERE aa_muestras.mue_idmuestra=:ntoma");
       
			//$stmt-> bindParam(":esatatus", $estatus, PDO::PARAM_INT);
			$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }

    public function actualizaestatusrepMB($estatus, $ntoma, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE aa_muestras SET aa_muestras.mue_estatusMB=2 WHERE aa_muestras.mue_idmuestra=:ntoma");
       
			//$stmt-> bindParam(":esatatus", $estatus, PDO::PARAM_INT);
			$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }


	public function vistaMuestrasRep($tipomues, $nrep, $idser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT aa_muestras.mue_idmuestra,aa_muestras.mue_estatusmuestra,aa_muestras.mue_tipomuestra, aa_muestras.mue_numunidadesFQ,aa_muestras.mue_capacidadFQ,aa_muestras.mue_origenmuestra,aa_muestras.mue_numtoma, date(aa_muestras.mue_fechahora) AS fectom,time(aa_muestras.mue_fechahora) AS hortom,aa_muestras.mue_numreporte, aa_muestras.mue_numunidadesMB,aa_muestras.mue_capacidadMB,aa_muestras.mue_fuenteabas,aa_muestras.mue_claveservicio FROM aa_muestras WHERE aa_muestras.mue_numreporte =:nrep AND aa_muestras.mue_tipomuestra =:tipomues AND aa_muestras.mue_claveservicio = :idser ORDER BY aa_muestras.mue_idmuestra DESC");
		
		$stmt-> bindParam(":tipomues", $tipomues, PDO::PARAM_INT);
		$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_INT);
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);		
		$stmt-> execute();

		return $stmt->fetchAll();

	}


	public function buscaUltimaMuestra($tabla){
			$stmt = Conexion::conectar()-> prepare("SELECT max(aa_muestras.mue_idmuestra) as ulnummues FROM $tabla");
				
			$stmt-> execute();

			return $stmt->fetch();

	}



	public function muestraEnProceso($nser, $nrep, $tipomues, $estmues, $origen, $tabla){
			$stmt = Conexion::conectar()-> prepare("SELECT Count(mue_idmuestra) AS totmuestras FROM aa_muestras WHERE mue_claveservicio=:nser AND mue_numreporte = :nrep AND mue_tipomuestra =:tipomues AND mue_origenmuestra =:origen and mue_estatusmuestra<=estmues GROUP BY mue_numreporte, mue_origenmuestra");
				
			$stmt-> bindParam(":nser", $nser, PDO::PARAM_INT);
			$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_INT);
			$stmt-> bindParam(":tipomues", $tipomues, PDO::PARAM_INT);		
			$stmt-> bindParam(":estmues", $estmues, PDO::PARAM_INT);
			$stmt-> bindParam(":origen", $origen, PDO::PARAM_INT);

			$stmt-> execute();

			return $stmt->fetch();

	}

	public function determinaNumToma($nser, $nrep, $tipomues, $estmues, $origen, $tabla){
			$stmt = Conexion::conectar()-> prepare("SELECT Count(mue_idmuestra) AS totmuestras FROM aa_muestras WHERE mue_claveservicio=:nser AND mue_numreporte = :nrep AND mue_tipomuestra =:tipomues AND mue_origenmuestra =:origen and mue_estatusmuestra<estmues GROUP BY mue_numreporte, mue_origenmuestra");
				
			$stmt-> bindParam(":nser", $nser, PDO::PARAM_INT);
			$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_INT);
			$stmt-> bindParam(":tipomues", $tipomues, PDO::PARAM_INT);		
			$stmt-> bindParam(":estmues", $estmues, PDO::PARAM_INT);
			$stmt-> bindParam(":origen", $origen, PDO::PARAM_INT);

			$stmt-> execute();

			return $stmt->fetch();

	}


	public function insertaToma($datosModel, $tabla){
			$stmt = Conexion::conectar()-> prepare("INSERT INTO aa_muestras (mue_claveservicio, mue_idmuestra, mue_estatusmuestra, mue_tipomuestra, mue_numunidadesFQ, mue_capacidadFQ, mue_origenmuestra, mue_numtoma, mue_fechahora, mue_numreporte, mue_numunidadesMB, mue_capacidadMB, mue_fuenteabas) values (:nser, :nummues, :estatus, :numcom,:unidadFQ,
				:capacidadFQ,:origenmues,:numtoma,:fecvis,:numrep,:unidadMB,:capacidadMB,
				:fuenteab)");
				
			$stmt-> bindParam(":nser", $datosModel["nser"], PDO::PARAM_INT);
			$stmt-> bindParam(":nummues", $datosModel["nummues"], PDO::PARAM_INT);
			$stmt-> bindParam(":estatus", $datosModel["estatus"], PDO::PARAM_INT);		
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":unidadFQ", $datosModel["unidadFQ"], PDO::PARAM_INT);

			$stmt-> bindParam(":capacidadFQ", $datosModel["capacidadFQ"], PDO::PARAM_INT);
			$stmt-> bindParam(":origenmues", $datosModel["origen"], PDO::PARAM_INT);
			$stmt-> bindParam(":numtoma", $datosModel["numtoma"], PDO::PARAM_INT);		
			$stmt-> bindParam(":fecvis", $datosModel["fecvis"], PDO::PARAM_STR);
			$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);

			$stmt-> bindParam(":unidadMB", $datosModel["unidadMB"], PDO::PARAM_INT);
			$stmt-> bindParam(":capacidadMB", $datosModel["capacidadMB"], PDO::PARAM_INT);
			$stmt-> bindParam(":fuenteab", $datosModel["fuenteab"], PDO::PARAM_INT);		
		
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

	}


    public function buscaResAntMuestra($nser, $nsec, $nmues, $tabla){
			$stmt = Conexion::conectar()-> prepare("SELECT ide_numrenglon AS claveren, aa_pruebaanalisis.pa_tipoanalisis 
FROM ins_detalleestandar Inner Join aa_pruebaanalisis ON aa_pruebaanalisis.pa_numcomponente = ins_detalleestandar.ide_numcomponente 
AND aa_pruebaanalisis.pa_numprueba = ins_detalleestandar.ide_numcaracteristica3
 WHERE ins_detalleestandar.ide_idmuestra = :nmues AND ins_detalleestandar.ide_claveservicio =:nser 
AND ins_detalleestandar.ide_numseccion = :nsec GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_idmuestra");
				
			$stmt-> bindParam(":nser", $nser, PDO::PARAM_INT);
			$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);
			$stmt-> bindParam(":nmues", $nmues, PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetch();

	}

    public function calculaRenglon($nser, $nsec, $nrep, $tabla){
			$stmt = Conexion::conectar()-> prepare("SELECT max(ins_detalleestandar.ide_numrenglon) as claveren FROM $tabla WHERE ins_detalleestandar.ide_claveservicio = :nser AND ins_detalleestandar.ide_numreporte = :nrep AND ins_detalleestandar.ide_numseccion = :nsec GROUP BY ins_detalleestandar.ide_numrenglon ORDER BY ins_detalleestandar.ide_numrenglon asc");
				
			$stmt-> bindParam(":nser", $nser, PDO::PARAM_INT);
			$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);
			$stmt-> bindParam(":nrep", $nrep, PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetch();

	}

	public function actualizarenglones($datosModel, $tabla){
        $stmt=Conexion::conectar()->prepare("UPDATE ins_detalleestandar set  ide_numrenglon = :numren WHERE ins_detalleestandar.ide_numreporte =:numrep AND ins_detalleestandar.ide_claveservicio =:nserv AND ins_detalleestandar.ide_numseccion =:nsec AND ins_detalleestandar.ide_numcomponente =:numcom and ins_detalleestandar. ide_numrenglon=:numrenant");
       
			$stmt-> bindParam(":nserv", $nserv, PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $numren, PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
			$stmt-> bindParam(":nsec", $nsec, PDO::PARAM_INT);
			$stmt-> bindParam(":numcom", $numcom, PDO::PARAM_INT);
			$stmt-> bindParam(":numrenant", $numrenant, PDO::PARAM_INT);

			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }

public function insertaReactivoMuestra($datosModel, $tabla){
        $stmt=Conexion::conectar()->prepare("insert into $tabla (ide_claveservicio, ide_numreporte, ide_numseccion, ide_numreactivo, ide_numcomponente, ide_numcaracteristica1, ide_numcaracteristica2, ide_numcaracteristica3, ide_valorreal, ide_numrenglon, ide_ponderacion, ide_aceptado, ide_numcolarc, ide_idmuestra)
            values (:idser, :numrep, :nsec, :nreac, :numcom, :ncar1,:ncom2, :numcar2, :valreal, :numren, :pond, :aceptado, 1,:nummues)");
       
        $stmt-> bindParam(":idser", $datosModel["nserv"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $datosModel["numrep"], PDO::PARAM_INT);
			$stmt-> bindParam(":nsec", $datosModel["nsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":nreac", $datosModel["nreac"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcom", $datosModel["numcom"], PDO::PARAM_INT);
			$stmt-> bindParam(":ncar1", $datosModel["ncar1"], PDO::PARAM_INT);
			$stmt-> bindParam(":ncom2", $datosModel["ncom2"], PDO::PARAM_INT);
			$stmt-> bindParam(":numcar2", $datosModel["numcar2"], PDO::PARAM_INT);
			$stmt-> bindParam(":valreal", $datosModel["valreal"], PDO::PARAM_INT);
			$stmt-> bindParam(":numren", $datosModel["numren"], PDO::PARAM_INT);
			$stmt-> bindParam(":pond", $datosModel["pond"], PDO::PARAM_INT);
			$stmt-> bindParam(":aceptado", $datosModel["aceptado"], PDO::PARAM_INT);
			$stmt-> bindParam(":colarc", $datosModel["colarc"], PDO::PARAM_INT);
			$stmt-> bindParam(":nummues", $datosModel["nummues"], PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
		$stmt->close();
    }
    
    public function buscarComponenteMuestra($ntoma,$tabla){
    	$sql="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numcomponente FROM
$tabla WHERE ins_detalleestandar.ide_idmuestra =  :ntoma GROUP BY
ins_detalleestandar.ide_claveservicio";
    	$stmt = Conexion::conectar()-> prepare($sql);
    	
    	$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
    
    	$stmt-> execute();
    	
    	return $stmt->fetchAll();
    }
    
    public function actualizarAnalisis($recmues,$fecvis,$ntoma){
    	$stmt=Conexion::conectar()->prepare("UPDATE aa_muestras 
SET aa_muestras.mue_nomanalistaMB=:recmues,
aa_muestras.mue_fechoranalisisMB=:fecvis,
 aa_muestras.mue_estatusMB=3 
WHERE aa_muestras.mue_idmuestra=:ntoma");
			
    	//$stmt-> bindParam(":esatatus", $estatus, PDO::PARAM_INT);
    	$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
    	$stmt-> bindParam(":recmues", $recmues, PDO::PARAM_INT);
    	
    	$stmt-> bindParam(":fecvis", $fecvis, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute()){
    		throw new Exception("Error al actualizar la muestra");
    	}
    }
    
    public function actualizarAnalisisMB($recmues,$fecvis,$ntoma){
    	$stmt=Conexion::conectar()->prepare("UPDATE aa_muestras
SET aa_muestras.mue_nomanalistaMB=:recmues,
aa_muestras.mue_fechoranalisisMB=:fecvis,
 aa_muestras.mue_estatusMB=3
WHERE aa_muestras.mue_idmuestra=:ntoma");
    	
    	//$stmt-> bindParam(":esatatus", $estatus, PDO::PARAM_INT);
    	$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
    	$stmt-> bindParam(":recmues", $recmues, PDO::PARAM_INT);
    	
    	$stmt-> bindParam(":fecvis", $fecvis, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute()){
    		throw new Exception("Error al actualizar la muestra");
    	}
    }
    
    public function actualizarAnalisisFQ($recmues,$fecvis,$ntoma){
    	$stmt=Conexion::conectar()->prepare("UPDATE aa_muestras
SET aa_muestras.mue_nomanalistaFQ=:recmues,
aa_muestras.mue_fechoranalisisFQ=:fecvis,
 aa_muestras.mue_estatusFQ=3
WHERE aa_muestras.mue_idmuestra=:ntoma");
    	
    	//$stmt-> bindParam(":esatatus", $estatus, PDO::PARAM_INT);
    	$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
    	$stmt-> bindParam(":recmues", $recmues, PDO::PARAM_INT);
    	
    	$stmt-> bindParam(":fecvis", $fecvis, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute()){
    		throw new Exception("Error al actualizar la muestra");
    	}
    }
    
    public function listaMuestrasxIdMuestra($ntoma,$tabla){
    	
    	$sql_rep="SELECT aa_muestras.mue_fechahora, aa_muestras.mue_fecharecepcion, aa_muestras.mue_fechoranalisisFQ, aa_muestras.mue_fechoranalisisMB, aa_muestras.mue_numreporte, aa_muestras.mue_claveservicio, aa_muestras.mue_idmuestra, if(aa_muestras.mue_fechoranalisisFQ>aa_muestras.mue_fechoranalisisMB,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_fechoranalisisMB) as ulfeclab,  if((aa_muestras.mue_fechoranalisisFQ ='0000-00-00 00:00:00') or (aa_muestras.mue_fechoranalisisMB ='0000-00-00 00:00:00'),null,datediff(if(aa_muestras.mue_fechoranalisisFQ>aa_muestras.mue_fechoranalisisMB,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_fechoranalisisMB),mue_fecharecepcion) ) AS dias_trans_lab
    	
FROM

$tabla WHERE  aa_muestras.mue_idmuestra =:ntoma";

$stmt=Conexion::conectar()->prepare($sql_rep);

$stmt->bindParam("ntoma", $ntoma,PDO::PARAM_INT);





$stmt-> execute();

return $stmt->fetchall();





    }
    
    public function actualizarEstatus($estatus,$ntoma){
    	$stmt=Conexion::conectar()->prepare("UPDATE aa_muestras 
SET aa_muestras.mue_estatusmuestra=:estatus
WHERE aa_muestras.mue_idmuestra=:ntoma");
    	
    	//$stmt-> bindParam(":esatatus", $estatus, PDO::PARAM_INT);
    	$stmt-> bindParam(":ntoma", $ntoma, PDO::PARAM_INT);
    	$stmt-> bindParam(":estatus", $estatus, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute()){
    		throw new Exception("Error al actualizar la muestra");
    	}
    }
    
    public function actualizarFechaRecepcion(){
    	$sSQLu1="update aa_muestras set mue_estatusmuestra=3, 
mue_fecharecepcion=now() where mue_idmuestra=:nmues";
    	$stmt-> bindParam(":nmues", $nmues, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute()){
    		throw new Exception("Error al actualizar la muestra");
    	}
    }

    
   

}
