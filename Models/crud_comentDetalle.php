<?php

require_once  "Models/conexion.php";

class DatosComentDetalle
{
    public function consultaComentDetalle($idser,$idreporte,$seccion, $tabla){
        $ssqlcom = "SELECT ins_comentdetalle.id_comentario FROM ".$tabla."
            WHERE concat(id_comnumseccion,'.',id_comreactivo)=:seccion  AND id_comclaveservicio=:idser  and id_comnumreporte=:idreporte";
        
        $stmt = Conexion::conectar()-> prepare($ssqlcom);
        
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_STR);
        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
      
        $stmt-> execute();
    
        return $stmt->fetchall();
        
        
    }
    
     public function consultaComentPond($idser,$idreporte,$seccion){
         $sqlcs = "SELECT ins_comentdetalle.id_comentario, rc_numcomentario, rc_descomentarioing, rc_descomentarioesp
    FROM ins_comentdetalle inner join cue_reactivoscomentarios on sec_numseccion=id_comnumseccion
    and r_numreactivo=id_comreactivo and ser_claveservicio=id_comclaveservicio and id_comentario=rc_numcomentario
    WHERE concat(id_comnumseccion,'.',id_comreactivo)=:seccion  AND id_comclaveservicio=:idser and id_comnumreporte=:idreporte;";
         
         $stmt = Conexion::conectar()-> prepare($sqlcs);
        
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_STR);
        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
        
        $stmt-> execute();
        
        return $stmt->fetchall();
        
       
    }
    
    public function consultaComentSeccion($idser,$idreporte,$seccion){
        $ssql_r = "select * from ins_comentseccion
            Inner Join cue_seccioncomentario 
ON ins_comentseccion.is_claveservicio = cue_seccioncomentario.ser_claveservicio
 AND ins_comentseccion.is_numseccion = cue_seccioncomentario.sec_numseccion AND ins_comentseccion.is_comentario = cue_seccioncomentario.sec_numcoment
WHERE is_numseccion=:seccion and is_numreporte = :idreporte and ins_comentseccion.is_claveservicio=:idser";
        
        $stmt = Conexion::conectar()-> prepare($ssql_r);
        
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
        
        $stmt-> execute();
        
        return $stmt->fetchall();
        
        
    }
    
    public function consultaComentario($idser,$idreporte,$seccion){
    	$ssql_r = "select * from ins_comentseccion
           WHERE is_numseccion=:seccion and is_numreporte = :idreporte and ins_comentseccion.is_claveservicio=:idser";
    	
    	$stmt = Conexion::conectar()-> prepare($ssql_r);
    	
    	$stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
    	$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
    	$stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
    	
    	$stmt-> execute();
    	
    	return $stmt->fetchall();
    	
    	
    }
    
    public function eliminaComentario($idser,$idreporte,$seccion,$comentario){
    	try{
    	$sqldel = "DELETE FROM ins_comentseccion WHERE
						is_claveservicio=:nser AND
						is_numreporte=:IdR AND
						is_numseccion=:nsec AND
						is_comentario=:coment";
    	$stmt = Conexion::conectar()-> prepare($sqldel);
    	
    	$stmt-> bindParam(":nsec", $seccion, PDO::PARAM_INT);
    	$stmt-> bindParam(":nser", $idser, PDO::PARAM_INT);
    	$stmt-> bindParam(":IdR", $idreporte, PDO::PARAM_INT);
    	$stmt-> bindParam(":coment", $comentario, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute())
    	{	
    		
    		throw new Exception("Hubo un error al eliminar el comentario");
    	}
    	
    	}catch(Exception $ex){
    		
    		throw new Exception("Hubo un error al eliminar el comentario");
    	}
    	
    	
    	
    }
    
    public function insertarComentario($idser,$idreporte,$seccion,$comentario){
    	$ssql_r = "INSERT INTO ins_comentseccion
(is_claveservicio,is_numreporte,is_numseccion,is_comentario)
			values (:nser,:IdR,:nsec,:numc)";
    	try{
    	$stmt = Conexion::conectar()-> prepare($ssql_r);
    	
    	$stmt-> bindParam(":nsec", $seccion, PDO::PARAM_INT);
    	$stmt-> bindParam(":nser", $idser, PDO::PARAM_INT);
    	$stmt-> bindParam(":IdR", $idreporte, PDO::PARAM_INT);
    	$stmt-> bindParam(":numc", $comentario, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute())
    	{	
    		
    		throw new Exception("Hubo un error al insertar el comentario");
    	
    	}
    		
    		
    	}catch(Exception $ex){
    		throw new Exception("Hubo un error al insertar el comentario");
    	}
    		
    		
    }
    
    public function eliminaComentarioDet($idser,$idreporte,$seccion,$reactivo,$idcomentario){
    	try{
    		$sqldel = "DELETE FROM ins_comentdetalle WHERE
						id_comclaveservicio=:idser AND
						id_comnumreporte=:IdR AND
						id_comnumseccion=:nsec AND
						id_comreactivo=:nreac AND
						id_comentario=:coment";
    		$stmt = Conexion::conectar()-> prepare($sqldel);
    		
    		$stmt-> bindParam(":nsec", $seccion, PDO::PARAM_INT);
    		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
    		$stmt-> bindParam(":IdR", $idreporte, PDO::PARAM_INT);
    		$stmt-> bindParam(":nreac", $reactivo, PDO::PARAM_INT);
    		$stmt-> bindParam(":coment", $idcomentario, PDO::PARAM_INT);
    		
    		if(!$stmt-> execute())
    		{
    			
    			throw new Exception("Hubo un error al eliminar el comentario");
    		}
    		
    	}catch(Exception $ex){
    		
    		throw new Exception("Hubo un error al eliminar el comentario");
    	}
    	
    	
    	
    }
    
    public function insertarComentarioDet($idser,$idreporte,$seccion,$reactivo,$idcomentario){
    	$sSQL = "INSERT INTO ins_comentdetalle (id_comclaveservicio,id_comnumreporte,id_comnumseccion,id_comentario,id_comreactivo)
										VALUES (:nser ,:IdR ,:nsec ,:numc ,:nreac )";
    	try{
    		$stmt = Conexion::conectar()-> prepare($sSQL);
    		
    		$stmt-> bindParam(":nsec", $seccion, PDO::PARAM_INT);
    		$stmt-> bindParam(":nser", $idser, PDO::PARAM_INT);
    		$stmt-> bindParam(":IdR", $idreporte, PDO::PARAM_INT);
    		$stmt-> bindParam(":nreac", $reactivo, PDO::PARAM_INT);
    		$stmt-> bindParam(":numc", $idcomentario, PDO::PARAM_INT);
    		
    		if(!$stmt-> execute())
    		{
    			
    			throw new Exception("Hubo un error al insertar el comentario");
    			
    		}
    	
    		
    	}catch(Exception $ex){
    		
    		throw new Exception("Hubo un error al insertar el comentario");
    	}
    	
    	
    }
}

