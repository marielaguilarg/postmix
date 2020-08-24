<?php

require_once "Models/conexion.php";


class DatosSolicitud extends Conexion{

	public function cuentasolicitudModel($numrep, $numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  * FROM cer_solicitud WHERE sol_numrep =:numrep AND sol_claveservicio =:numser");
		
		$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);			
		$stmt-> execute();

		return $qty=$stmt->RowCount();;
		$stmt->close();
	}

	public function estatusSolicitudModel($numrep, $numser, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  FROM cer_solicitud, sol_estatussolicitud WHERE sol_numrep =:numrep AND sol_claveservicio =:numser");
		
		$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
		$stmt-> bindParam(":numser", $numser, PDO::PARAM_INT);			
		$stmt-> execute();

		return $stmt->fetch();
		$stmt->close();
	}
	
	public function getUltimaSolicitud( $numser, $tabla){
	    $sqlc="SELECT max(cer_solicitud.sol_idsolicitud) as ulsol FROM $tabla".
                " WHERE cer_solicitud.sol_claveservicio =  :idserv";
	    
	    $stmt = Conexion::conectar()-> prepare($sqlc);	    
	  
	    $stmt-> bindParam(":idserv", $numser, PDO::PARAM_INT);
	    $stmt-> execute();
	    
	    $res=$stmt->fetch();
	    return $res[0];
	 
	}
	
	public function getSolicitud($idsol, $idserv, $tabla){
	    $stmt = Conexion::conectar()-> prepare("SELECT * FROM $tabla 
WHERE cer_solicitud.sol_claveservicio =:idserv AND cer_solicitud.sol_idsolicitud =:nsol;");
	    
	    $stmt-> bindParam(":idserv", $idserv, PDO::PARAM_INT);
	    $stmt-> bindParam(":nsol", $idsol, PDO::PARAM_INT);
	    $stmt-> execute();
     
	    return $stmt->fetch();
	   
	}
	
	public function listaSolicitudDetalle($idsol, $idserv, $tabla){
	    $sql="SELECT cer_solicituddetalle.sde_claveservicio, cer_solicituddetalle.sde_idsolicitud, 
cer_solicituddetalle.sde_idarchivo, cer_solicituddetalle.sde_ruta, cer_solicituddetalle.sde_descripcion 
FROM cer_solicituddetalle WHERE cer_solicituddetalle.sde_claveservicio =:idserv 
AND cer_solicituddetalle.sde_idsolicitud =:nsol";
	    
	    $stmt = Conexion::conectar()-> prepare($sql);
	    
	    $stmt-> bindParam(":idserv", $idserv, PDO::PARAM_INT);
	    $stmt-> bindParam(":nsol", $idsol, PDO::PARAM_INT);
	    $stmt-> execute();
	  
	    return $stmt->fetchAll();
	    
	}
	
	public function getSolicitudDetalle( $idserv,$idsol,$archivo, $tabla){
	    $sql="SELECT cer_solicituddetalle.sde_claveservicio, cer_solicituddetalle.sde_idsolicitud,
cer_solicituddetalle.sde_idarchivo, cer_solicituddetalle.sde_ruta, cer_solicituddetalle.sde_descripcion
FROM cer_solicituddetalle WHERE cer_solicituddetalle.sde_claveservicio =:idserv
AND cer_solicituddetalle.sde_idsolicitud =:nsol and cer_solicituddetalle.sde_idarchivo=:narc";
	    
	    $stmt = Conexion::conectar()-> prepare($sql);
	    
	    $stmt-> bindParam(":idserv", $idserv, PDO::PARAM_INT);
	    $stmt-> bindParam(":nsol", $idsol, PDO::PARAM_INT);
	    $stmt-> bindParam(":narc", $archivo, PDO::PARAM_STR);
	    $stmt-> execute();
	//    $stmt->debugDumpParams();
	    return $stmt->fetchAll();
	    
	}
	
	public function listaSolicitudComentario($idsol, $idserv, $tabla){
	    $sqlcom="SELECT cer_solicitudcomentario.sol_claveservicio, cer_solicitudcomentario.sol_idsolicitud, cer_solicitudcomentario.sol_idcom, cer_solicitudcomentario.sol_fechacom, cer_solicitudcomentario.sol_horcom,
cer_solicitudcomentario.sol_comentario, cer_solicitudcomentario.sol_user 
FROM $tabla
WHERE cer_solicitudcomentario.sol_claveservicio =:idserv AND cer_solicitudcomentario.sol_idsolicitud =:nsol";
	    
	    $stmt = Conexion::conectar()-> prepare($sqlcom);
	    
	    $stmt-> bindParam(":idserv", $idserv, PDO::PARAM_INT);
	    $stmt-> bindParam(":nsol", $idsol, PDO::PARAM_INT);
	    $stmt-> execute();
	    
	    return $stmt->fetchAll();
	    
	}
	
	public function getUltimoSolicitudComentario($idsol, $idserv, $tabla){
	    $ssql="SELECT max(cer_solicitudcomentario.sol_idcom) as idcom
 FROM $tabla WHERE cer_solicitudcomentario.sol_claveservicio =:nserc AND cer_solicitudcomentario.sol_idsolicitud =:nsol";
	    
	    $stmt = Conexion::conectar()-> prepare($ssql);
	    
	    $stmt-> bindParam(":nserc", $idserv, PDO::PARAM_INT);
	    $stmt-> bindParam(":nsol", $idsol, PDO::PARAM_INT);
	    $stmt-> execute();
	    
	    $res=$stmt->fetch();
	    return $res[0];
	}
	
	public function getUltimoSolicitudDetalle($idsol, $idserv, $tabla){
	    $sql="SELECT Max(cer_solicituddetalle.sde_idarchivo) AS id
				  FROM $tabla
				  WHERE cer_solicituddetalle.sde_claveservicio =:servicio AND
				  cer_solicituddetalle.sde_idsolicitud =:reporte;";
	    
	    
	    $stmt = Conexion::conectar()-> prepare($sql);
	    
	    $stmt-> bindParam(":servicio", $idserv, PDO::PARAM_INT);
	    $stmt-> bindParam(":reporte", $idsol, PDO::PARAM_INT);
	    $stmt-> execute();
	    
	    $res=$stmt->fetch();
	    return $res[0];
	}
	
	public function insertarSolicitudComentario($nserc,$nrepc, $numr,$coment,$user, $tabla){
	    $sSQL= "insert into $tabla (cer_solicitudcomentario.sol_claveservicio,
 cer_solicitudcomentario.sol_idsolicitud, cer_solicitudcomentario.sol_idcom, cer_solicitudcomentario.sol_fechacom, 
cer_solicitudcomentario.sol_horcom, cer_solicitudcomentario.sol_comentario, cer_solicitudcomentario.sol_user) 
values (:nserc, :nrepc, :numr ,curdate(),localtime(), :coment,:user);";
	    try{
	        $stmt = Conexion::conectar()-> prepare($sSQL);
	    
	    $stmt-> bindParam(":nserc", $nserc, PDO::PARAM_INT);
	    $stmt-> bindParam(":nrepc", $nrepc, PDO::PARAM_INT);
	    $stmt-> bindParam(":numr", $numr, PDO::PARAM_INT);
	    $stmt-> bindParam(":coment", $coment, PDO::PARAM_STR);
	    $stmt-> bindParam(":user", $user, PDO::PARAM_STR);
	    if( ! $stmt-> execute())
	        throw new Exception("Error al insertar el comentario");
	    }catch(Exception $ex){
	        throw new Exception("Error al insertar el comentario");
	    }
	   
	}
	
	public function insertarSolicitudDetalle($servicio,$reporte, $idarch,$ruta, $tabla){
	    $sSQL= "INSERT INTO $tabla
(sde_claveservicio, sde_idsolicitud, sde_idarchivo, sde_ruta) 
VALUES (:servicio,:reporte,:sigId,:ruta);";
                     
	    try{
	        $stmt = Conexion::conectar()-> prepare($sSQL);
	        
	        $stmt-> bindParam(":servicio", $servicio, PDO::PARAM_INT);
	        $stmt-> bindParam(":reporte", $reporte, PDO::PARAM_INT);
	        $stmt-> bindParam(":sigId", $idarch, PDO::PARAM_INT);
	        $stmt-> bindParam(":ruta", $ruta, PDO::PARAM_STR);
	      
	       if(! $stmt-> execute())
	          throw new Exception("Error al insertar el detalle");
	    }catch(Exception $ex){
	        throw new Exception("Error al insertar el detalle");
	    }
	    
	}
	
	
	public function actualizarSolicitud($refer,  $desuneg, 	 $status, 	$idcuenta, 	 $cta, 	 $fecape,	 $conuneg, 	 $email,  $calle, 	 $numext, 	 $numint, 
 $mz,  $lt,  $col, 	 $del, 	$mun,  $edo, $cp, 	 $ref,	 $tel,  $cel, 	 $user, 	$numpun, 	 $clauneg){
	    $sSQL=("update cer_solicitud set 
 sol_descripcion=:desuneg, 
sol_estatussolicitud=:status, 
sol_idcuenta=:idcta, 
sol_cuenta=:cta, 
sol_fechaapertura=:fecape,
 sol_contacto=:conuneg, 
sol_correoelec= :email, 
sol_dir_calle=:calle,
 sol_dir_numeroext=:numext,
 sol_dir_numeroint=:numint, 
sol_dir_manzana=:mz,
 sol_dir_lote=:lt, 
sol_dir_colonia=:col, 
sol_dir_delegacion=:del,
 sol_dir_municipio=:mun,
 sol_dir_estado=:edo,
 sol_dir_cp=:cp, 
sol_dir_referencia=:ref,
 sol_dir_telefono=:tel, 
sol_dir_telmovil=:cel,
sol_solicitante=:user,
 sol_numpunto =:numpun where sol_idsolicitud=:clauneg and sol_claveservicio=:refer;");
	    try{
	        $stmt = Conexion::conectar()-> prepare($sSQL);
	    
	    $stmt-> bindParam(":refer", $refer, PDO::PARAM_INT);
	    $stmt-> bindParam(":desuneg", $desuneg, PDO::PARAM_STR);
	    $stmt-> bindParam(":status", $status, PDO::PARAM_INT);
	    $stmt-> bindParam(":idcta", $idcuenta, PDO::PARAM_INT);
	    $stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);
	    $stmt-> bindParam(":fecape", $fecape, PDO::PARAM_STR);
	    $stmt-> bindParam(":conuneg", $conuneg, PDO::PARAM_STR);
	    $stmt-> bindParam(":email", $email, PDO::PARAM_STR);
	    $stmt-> bindParam(":calle", $calle, PDO::PARAM_STR);
	    $stmt-> bindParam(":numext", $numext, PDO::PARAM_STR);
	    $stmt-> bindParam(":numint", $numint, PDO::PARAM_STR);
	    $stmt-> bindParam(":mz", $mz, PDO::PARAM_STR);
	    $stmt-> bindParam(":lt", $lt, PDO::PARAM_STR);
	    $stmt-> bindParam(":col", $col, PDO::PARAM_STR);
	    $stmt-> bindParam(":del", $del, PDO::PARAM_STR);
	    $stmt-> bindParam(":mun", $mun, PDO::PARAM_STR);
	    $stmt-> bindParam(":edo", $edo, PDO::PARAM_STR);
	    $stmt-> bindParam(":cp", $cp, PDO::PARAM_STR);
	    $stmt-> bindParam(":ref", $ref, PDO::PARAM_STR);
	    $stmt-> bindParam(":tel", $tel, PDO::PARAM_STR);
	    $stmt-> bindParam(":cel", $cel, PDO::PARAM_STR);
	    $stmt-> bindParam(":user", $user, PDO::PARAM_STR);
	    $stmt-> bindParam(":numpun", $numpun, PDO::PARAM_INT);
	    $stmt-> bindParam(":clauneg", $clauneg, PDO::PARAM_INT);
	  
	    if(!$stmt-> execute())
 	    {  // $stmt->debugDumpParams();
	    	throw new Exception("Error al actualizar la solicitud");
	    }
	  // 
	    }catch(Exception $ex){
	        throw new Exception("Error al actualizar la solicitud");
	    }
	  
	}
	
	public function insertarSolicitud($refer,  $desuneg, 	 $status, 	$idcuenta, 	 $cta, 	 $fecape,	 $conuneg, 	 $email,  $calle, 	 $numext, 	 $numint,
	    $mz,  $lt,  $col, 	 $del, 	$mun,  $edo, $cp, 	 $ref,	 $tel,  $cel, 	 $user, 	$numpun, 	 $clauneg){
	    $sSQL= "insert into cer_solicitud (sol_idsolicitud, sol_claveservicio, sol_descripcion, sol_estatussolicitud, sol_idcuenta, 
 sol_cuenta, sol_fechaapertura, sol_contacto, sol_correoelec, sol_dir_calle, sol_dir_numeroext, sol_dir_numeroint, sol_dir_manzana,
 sol_dir_lote, sol_dir_colonia, sol_dir_delegacion, sol_dir_municipio, sol_dir_estado, sol_dir_cp, sol_dir_referencia, sol_dir_telefono,
 sol_dir_telmovil, sol_solicitante, sol_numpunto)
    values (:clauneg, :refer, :desuneg, :status, :idcta, :cta, :fecape, :conuneg, :email,:calle, :numext,
	    :numint, :mz, :lt, :col, :del, :mun, :edo, :cp, :ref, :tel, :cel,:user,:numpun)";
	    
	    try{
	        $stmt = Conexion::conectar()-> prepare($sSQL);
	        
	        $stmt-> bindParam(":refer", $refer, PDO::PARAM_INT);
	        $stmt-> bindParam(":desuneg", $desuneg, PDO::PARAM_STR);
	        $stmt-> bindParam(":status", $status, PDO::PARAM_INT);
	        $stmt-> bindParam(":idcta", $idcuenta, PDO::PARAM_INT);
	        $stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);
	        $stmt-> bindParam(":fecape", $fecape, PDO::PARAM_STR);
	        $stmt-> bindParam(":conuneg", $conuneg, PDO::PARAM_STR);
	        $stmt-> bindParam(":email", $email, PDO::PARAM_STR);
	        $stmt-> bindParam(":calle", $calle, PDO::PARAM_STR);
	        $stmt-> bindParam(":numext", $numext, PDO::PARAM_STR);
	        $stmt-> bindParam(":numint", $numint, PDO::PARAM_STR);
	        $stmt-> bindParam(":mz", $mz, PDO::PARAM_STR);
	        $stmt-> bindParam(":lt", $lt, PDO::PARAM_STR);
	        $stmt-> bindParam(":col", $col, PDO::PARAM_STR);
	        $stmt-> bindParam(":del", $del, PDO::PARAM_STR);
	        $stmt-> bindParam(":mun", $mun, PDO::PARAM_STR);
	        $stmt-> bindParam(":edo", $edo, PDO::PARAM_STR);
	        $stmt-> bindParam(":cp", $cp, PDO::PARAM_STR);
	        $stmt-> bindParam(":ref", $ref, PDO::PARAM_STR);
	        $stmt-> bindParam(":tel", $tel, PDO::PARAM_STR);
	        $stmt-> bindParam(":cel", $cel, PDO::PARAM_STR);
	        $stmt-> bindParam(":user", $user, PDO::PARAM_STR);
	        $stmt-> bindParam(":numpun", $numpun, PDO::PARAM_INT);
	        $stmt-> bindParam(":clauneg", $clauneg, PDO::PARAM_INT);
	        
	       if(!$stmt-> execute())
	       {
	       	//$stmt->debugDumpParams();
	       	throw new Exception("Error al insertar la solicitud");
	       
	       }
	    }catch(Exception $ex){
	        throw new Exception("Error al insertar solicitud");
	    }
	    
	}
	
	
	public function getSolicitudxEstatus1($numpunto, $tabla){
	    $sqls1="SELECT * FROM `cer_solicitud` where sol_numpunto=:npunto 
and (sol_estatussolicitud=1 or sol_estatussolicitud=2);";
	    $stmt=Conexion::conectar()->prepare($sqls1);
	    $stmt-> bindParam(":npunto", $numpunto, PDO::PARAM_INT);
	     $stmt-> execute();
	    
	    return $stmt->fetchAll();
	    
	}
	public function registrarNumReporte($numpun, $numrep){
				$sqls="UPDATE cer_solicitud SET cer_solicitud.sol_numrep=:numrep
WHERE cer_solicitud.sol_numpunto = :npunto 
 AND isnull(cer_solicitud.sol_numrep) AND sol_estatussolicitud <> 5";
				
				try{
					$stmt = Conexion::conectar()-> prepare($sqls);
					
					$stmt-> bindParam(":npunto", $numpun, PDO::PARAM_INT);
					$stmt-> bindParam(":numrep", $numrep, PDO::PARAM_INT);
					date_default_timezone_set('America/Mexico_City');
					$fecvis=date("Y-m-d H:i:s");
					error_log($fecvis.": El punto de venta que se registro: ".$sqls." variables: numpun=".$numpun." numrep=".$numrep,3,"errorespostmix.log");
					
					
					if(!$stmt-> execute()){
						
						throw new Exception("Error al actualizar la solicitud");
						
					}
						//  $stmt->debugDumpParams();
							}catch(Exception $ex){
					
					throw new Exception("Error al actualizar la solicitud");
				}
			
				
	}
	
	public function actualizarEstatus($estatus, $numrep,$servicio){
		$sqls="UPDATE `cer_solicitud`
	SET
	`sol_estatussolicitud` =:estatus
		WHERE `sol_claveservicio` =:servicio
			AND `sol_numrep`=:reporte and sol_estatussolicitud<>5 ;";
		
		try{
			$stmt = Conexion::conectar()-> prepare($sqls);
			
			$stmt-> bindParam(":servicio", $servicio, PDO::PARAM_INT);
			$stmt-> bindParam(":reporte", $numrep, PDO::PARAM_INT);
			$stmt-> bindParam(":estatus", $estatus, PDO::PARAM_INT);
				
			
			$stmt-> execute();
							
			 
		}catch(Exception $ex){
			Utilerias::guardarError("crud_solicitudes::actualizarEstatus ".$ex->getMessage());
			throw new Exception("Error al actualizar estatus de la solicitud");
		}
		
		
	}
	
	


}








