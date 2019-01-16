<?php





class DatosRecepcionMuestra

{



    

    function listaRecepcionMuestraDet($muestra) {

        

        $sqllab="SELECT aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestradetalle.mue_idmuestra

FROM aa_recepcionmuestradetalle

Inner Join aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra".

" WHERE aa_recepcionmuestradetalle.mue_idmuestra =:nmue

GROUP BY

aa_recepcionmuestradetalle.mue_idmuestra";

        

        $stmt = Conexion::conectar()-> prepare($sqllab);

        

        $stmt-> bindParam(":nmue", $muestra, PDO::PARAM_INT);

        $stmt-> execute();

        

        return $stmt->fetchall();

        

    }
    
    function editaRecepcion($muestra) {
    	
    	$sqllab="SELECT aa_recepcionmuestra.rm_idrecepcionmuestra, aa_recepcionmuestra.rm_personarecibe,
 aa_recepcionmuestra.rm_personaentrega, aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestra.rm_fechahora 
FROM
aa_recepcionmuestra WHERE aa_recepcionmuestra.rm_idrecepcionmuestra =  :idref";
    	
    	$stmt = Conexion::conectar()-> prepare($sqllab);
    	$stmt-> bindParam(":idref", $muestra, PDO::PARAM_INT);
    	$stmt-> execute();
    	
    	return $stmt->fetch();
    	
    }
    
    public function insertarRecepcion($recmues,$entmues,$desclab, $fecvis,$tabla){
    	$ssql="SELECT max(aa_recepcionmuestra.rm_idrecepcionmuestra) as idmues 
FROM aa_recepcionmuestra;";
    	
    	$stmt1=Conexion::conectar()-> prepare($ssql);
      $stmt1->execute();
    	$prueba=$stmt1->fetch();
    	if($prueba["idmues"]&&$prueba["idmues"]>1)
    					$prueba=$prueba["idmues"]+1;
    				else {
    					$prueba=1;
    				}
    	$sqlc="insert into $tabla
 (aa_recepcionmuestra.rm_idrecepcionmuestra,aa_recepcionmuestra.rm_personarecibe, 
aa_recepcionmuestra.rm_personaentrega, aa_recepcionmuestra.rm_embotelladora, 
aa_recepcionmuestra.rm_fechahora,
aa_recepcionmuestra.rm_estatus)
 values (:claca, :recmues,:entmues,:desclab, :fecvis,1)";

    	try{
    		$stmt = Conexion::conectar()-> prepare($sqlc);
    		
    		$stmt-> bindParam(":claca", $prueba, PDO::PARAM_INT);
    		$stmt-> bindParam(":recmues", $recmues, PDO::PARAM_STR);
    		$stmt-> bindParam(":entmues", $entmues, PDO::PARAM_STR);
    		$stmt-> bindParam(":desclab", $desclab, PDO::PARAM_INT);
    		$stmt-> bindParam(":fecvis", $fecvis, PDO::PARAM_STR);
    		$res=$stmt-> execute();
    		
    		if(!$res)
    			throw new Exception("Error al insertar en la base de datos");
    	}catch(PDOException $ex){
    		throw new Exception("Error al insertar en la base de datos");
    	}
    }

    public function actualizarRecepcion($recmues,$numrecep,$desclab, $tabla){
    	$sSQL="update $tabla 
set rm_personarecibe=:recmues, rm_embotelladora=:desclab
where rm_idrecepcionmuestra=:numrecep";
    	
    		
    		try{
    			$stmt = Conexion::conectar()-> prepare($sSQL);
    			
    		
    			$stmt-> bindParam(":recmues", $recmues, PDO::PARAM_STR);
    			$stmt-> bindParam(":numrecep", $numrecep, PDO::PARAM_STR);
    			$stmt-> bindParam(":desclab", $desclab, PDO::PARAM_INT);
    			
    			$res=$stmt-> execute();
    			
    			if(!$res)
    				throw new Exception("Error al actualizar en la base de datos");
    		}catch(PDOException $ex){
    			throw new Exception("Error al actualizar en la base de datos");
    		}
    }
    
    public function actualizarEstatus($estatus,$idrec, $tabla){
    	$sSQL="UPDATE $tabla 
SET aa_recepcionmuestra.rm_estatus=:estatus 
WHERE aa_recepcionmuestra.rm_idrecepcionmuestra=:idrec";
    	
    	
    	try{
    		$stmt = Conexion::conectar()-> prepare($sSQL);
    		
    		
    		$stmt-> bindParam(":estatus", $estatus, PDO::PARAM_STR);
    		$stmt-> bindParam(":idrec", $idrec, PDO::PARAM_STR);
    			
    		$res=$stmt-> execute();
    	
    		if(!$res)
    			throw new Exception("Error al actualizar en la base de datos");
    	}catch(PDOException $ex){
    		throw new Exception("Error al actualizar en la base de datos");
    	}
    }
    
    
    public function borrarRecepcion($id,$tabla){
    
    	$sSQL="Update $tabla 
set rm_estatus=6 Where rm_idrecepcionmuestra =:id";
    	
    		try{
    			$stmt = Conexion::conectar()-> prepare($sSQL);
    			
    			$stmt-> bindParam(":id", $id, PDO::PARAM_INT);
    			
    			$res=$stmt-> execute();
    			
    			if(!$res)
    				throw new Exception("Error al borrar en la base de datos");
    		}catch(PDOException $ex){
    			throw new Exception("Error al borrar en la base de datos");
    		}
    }
    
    
    function ultimaRecepcionDet($numrecibo) {
    	
    	$sqllab="SELECT Max(aa_recepcionmuestradetalle.rmd_partida) AS ulpartida
 FROM aa_recepcionmuestradetalle
 WHERE
aa_recepcionmuestradetalle.rm_idrecepcionmuestra =:numrecibo
 GROUP BY aa_recepcionmuestradetalle.rm_idrecepcionmuestra;";
    	
    	$stmt = Conexion::conectar()-> prepare($sqllab);
    	$stmt-> bindParam(":numrecibo", $numrecibo, PDO::PARAM_INT);
    	$stmt-> execute();
    	
    	$res=$stmt->fetch();
    	return $res["ulpartida"];
    	
    }
    
    function insertarRecepcionDet($ulpar,$numrecibo,$nmues,$totmb,$tipo){
    	$sql="insert into aa_recepcionmuestradetalle
(aa_recepcionmuestradetalle.rmd_partida, aa_recepcionmuestradetalle.rm_idrecepcionmuestra, aa_recepcionmuestradetalle.mue_idmuestra, aa_recepcionmuestradetalle.rmd_tipoanalisis,
aa_recepcionmuestradetalle.rmd_unidades, aa_recepcionmuestradetalle.rmd_estatus) 
VALUES (:ulpar, :numrecibo,:nmues,:tipo, :totmb,1)";
    	try{

    	$stmt = Conexion::conectar()-> prepare($sql);
    	$stmt-> bindParam(":ulpar", $ulpar, PDO::PARAM_INT);
    	
    	$stmt-> bindParam(":numrecibo", $numrecibo, PDO::PARAM_INT);
    	$stmt-> bindParam(":nmues", $nmues, PDO::PARAM_INT);
    	$stmt-> bindParam(":totmb", $totmb, PDO::PARAM_INT);
    	$stmt-> bindParam(":tipo", $tipo, PDO::PARAM_STR);
    	
    		if(!$stmt-> execute())
    			throw new Exception("Error al insertar");
    	}catch(Exception $ex){
    		throw new Exception("Error al insertar recepción detalle");
    	}
    	
	
    }
    
    function eliminartmp(){
    	$sql="DELETE FROM tmp_recepcion";
    	try{
    		
    		$stmt = Conexion::conectar()-> prepare($sql);
    		
    		
    		if(!$stmt-> execute())
    			throw new Exception("Error al borrar");
    	}catch(Exception $ex){
    		throw new Exception("Error al borrar recepción detalle");
    	}
    	
    }
    
    function eliminarRecepcion($nmues){
    	$sql="DELETE FROM aa_recepcionmuestra WHERE aa_recepcionmuestra.rm_idrecepcionmuestra=:nmues";
    	try{
    		
    		$stmt = Conexion::conectar()-> prepare($sql);
    		$stmt-> bindParam(":nmues", $nmues, PDO::PARAM_INT);
    		
    		
    		if(!$stmt-> execute())
    		{
    			
    			throw new Exception("Error al borrar");
    		}
    	}catch(Exception $ex){
    		throw new Exception("Error al borrar recepción detalle");
    	}
    	
    }
    
    function insertartmp($codigoana){
    	$sql="insert into tmp_recepcion (idmuestra) values (:codigoana);";
    	try{
    		
    		$stmt = Conexion::conectar()-> prepare($sql);
    		$stmt-> bindParam(":codigoana", $codigoana, PDO::PARAM_STR);
    		
    		if(!$stmt-> execute())
    			throw new Exception("Error al insertar");
    	}catch(Exception $ex){
    		throw new Exception("Error al insertar recepción detalle");
    	}
    	
    }
    
    public function actualizarFechaRecepcion($fecvis,$numrecibo){
    	$sSQLu1="update aa_recepcionmuestra set aa_recepcionmuestra.rm_fechahora=:fecvis, 
aa_recepcionmuestra.rm_estatus=2 
WHERE aa_recepcionmuestra.rm_idrecepcionmuestra=:numrecibo";
    	$stmt-> bindParam(":fecvis", $fecvis, PDO::PARAM_INT);
    	$stmt-> bindParam(":numrecibo", $numrecibo, PDO::PARAM_INT);
    	
    	if(!$stmt-> execute()){
    		throw new Exception("Error al actualizar la fecha");
    	}
    }
    

}



