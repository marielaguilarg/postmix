<?php


class DatosCatalogoDetalle {
     public function listaCatalogoDetalle($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT
  `cad_idcatalogo`,
  `cad_idopcion`,
  `cad_descripcionesp`,
  `cad_descripcioning`,
  `cad_otro`
FROM $tabla where ca_catalogosdetalle.cad_idcatalogo= :id");
         
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}
        
        
        public function getCatalogoDetalle($tabla,$catalogo,$opcion){
          
         $sql_cat = "SELECT
ca_catalogosdetalle.cad_descripcionesp,
ca_catalogosdetalle.cad_descripcioning FROM ".
$tabla."
WHERE
ca_catalogosdetalle.cad_idcatalogo =  :clavecatalogo AND
ca_catalogosdetalle.cad_idopcion =  :opcion";

        $stmt = Conexion::conectar()-> prepare($sql_cat);

    $stmt-> bindParam(":clavecatalogo", $catalogo, PDO::PARAM_INT);
    $stmt-> bindParam(":opcion",$opcion , PDO::PARAM_INT);
     $stmt-> execute();

    $result_cat=$stmt->fetchall();
     foreach($result_cat as $row_cat) {
        if ($_SESSION["idiomaus"] == 2)
            $res= $row_cat["cad_descripcioning"];
        else
            $res = $row_cat["cad_descripcionesp"];
    }
     $stmt->closeCursor();     
     $result_cat=$stmt=null;
      return $res;
        }

public function listaCatalogoDetalleOpc($datosModel, $op, $tabla){
    $stmt = Conexion::conectar()-> prepare("SELECT
  `cad_idcatalogo`,
  `cad_idopcion`,
  `cad_descripcionesp`,
  `cad_descripcioning`,
  `cad_otro`
     FROM $tabla where ca_catalogosdetalle.cad_idcatalogo= :id and cad_idopcion=:op");
         
    $stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
    $stmt->bindParam(":op", $op, PDO::PARAM_INT);
    
    $stmt-> execute();

    return $stmt->fetch();
  }
  
  public function listaVolumenes( $tabla){
  	$stmt = Conexion::conectar()-> prepare("SELECT
  `cav_presion`,
  `cav_temperatura`,
  `cav_volumen`
FROM `ca_volumenes`");
  	

  	$stmt-> execute();
  	
  	return $stmt->fetchAll();
  }
  
  public function borrarCatalogoDetalle($idcatalogo,$idopcion,$tabla){
  	$stmt = Conexion::conectar()-> prepare("DELETE
FROM $tabla
WHERE `cad_idcatalogo` = :idcatalogo
    AND `cad_idopcion` =:idopcion");
  	
  	$stmt->bindParam(":idcatalogo", $idcatalogo, PDO::PARAM_INT);
  	$stmt->bindParam(":idopcion", $idopcion, PDO::PARAM_INT);
 
  	
  	if(!$stmt-> execute()){
  		throw new Exception("Error al eliminar opcion");
  	}
  	
  	
  }

  
  public function actualizarCatalogoDetalle($idcatalogo,$idopcion,$descripcionesp,$descripcioning,$otro,$tabla){
  	
  	$stmt = Conexion::conectar()-> prepare("UPDATE $tabla SET 
  `cad_descripcionesp` =:descripcionesp,
  `cad_descripcioning` =:descripcioning,
  `cad_otro` =:otro
WHERE `cad_idcatalogo` =:idcatalogo
    AND `cad_idopcion` =:idopcion");
  	
  	$stmt->bindParam(":idcatalogo", $idcatalogo, PDO::PARAM_INT);
  	$stmt->bindParam(":idopcion", $idopcion, PDO::PARAM_INT);
  	$stmt->bindParam(":descripcionesp", $descripcionesp, PDO::PARAM_STR);
  	$stmt->bindParam(":descripcioning", $descripcioning, PDO::PARAM_STR);
  	$stmt->bindParam(":otro", $otro, PDO::PARAM_STR);
  	
  	if(!$stmt-> execute()){
  		$stmt->debugDumpParams();
  		throw new Exception("Error al actualizar opcion");
  	}
  	
  }
  
  public function insertarCatalogoDetalle($idcatalogo,$nombreesp,$nombreing,$nomotro){
  	$ssql="select max(cad_idopcion) as claveop from ca_catalogosdetalle where cad_idcatalogo=:cat";
  	try{
  	$stmt = Conexion::conectar()->prepare($ssql);
  	$stmt->bindParam(":cat", $idcatalogo,PDO::PARAM_INT);
  	$stmt->execute();
  	$res=$stmt->fetch();
  	if($res){
  			$claop=$res[0]+1;
  		
  	}else{
  		$claop=1;
  	}
  	$stmt=null;
  
  	if ($nomotro) {
  		$sSQL= "insert into ca_catalogosdetalle (cad_idcatalogo, cad_idopcion, 
cad_descripcionesp, cad_descripcioning, cad_otro)
 values (:cat,:claop,:nomopesp,:nomoping, :nomotro)";
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		$stmt->bindParam(":cat", $idcatalogo, PDO::PARAM_INT);
  		$stmt->bindParam(":claop", $claop, PDO::PARAM_INT);
  		$stmt->bindParam(":nomopesp", $nombreesp, PDO::PARAM_STR);
  		$stmt->bindParam(":nomoping", $nombreing, PDO::PARAM_STR);
  		$stmt->bindParam(":nomotro", $nomotro, PDO::PARAM_STR);
  	}else{
  		//procedimiento de insercion del servicio
  		$sSQL= "insert into ca_catalogosdetalle (cad_idcatalogo,
 cad_idopcion, cad_descripcionesp, cad_descripcioning)
 values (:cat,:claop,:nomopesp,:nomoping)";
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		$stmt->bindParam(":cat", $idcatalogo, PDO::PARAM_INT);
  		$stmt->bindParam(":claop", $claop, PDO::PARAM_INT);
  		$stmt->bindParam(":nomopesp", $nombreesp, PDO::PARAM_STR);
  		$stmt->bindParam(":nomoping", $nombreing, PDO::PARAM_STR);
  		
  	}
  	$res=$stmt->execute();
  
  	if(!$res){
  	
  		throw new Exception("Error al insertar opcion");
  	}
  	}catch(Exception $ex){
  		throw new Exception("Error al insertar opcion");
  	}
  	
  	
  }
  
  public function editarCatalogoDetalle($idcatalogo,$idopcion,$nombreesp,$nombreing,$nomotro){
  	try{
  		
  		$sSQL=("update ca_catalogosdetalle set cad_descripcionesp=:nomcatesp,
 cad_descripcioning=:nomcating,
 cad_otro=:nomotro
 where concat(cad_idcatalogo,'.', cad_idopcion)=:clavecat");
  		
  			$stmt = Conexion::conectar()->prepare($sSQL);
  		
  			$stmt->bindParam(":clavecat", $idopcion, PDO::PARAM_STR);
  			$stmt->bindParam(":nomcatesp", $nombreesp, PDO::PARAM_STR);
  			$stmt->bindParam(":nomcating", $nombreing, PDO::PARAM_STR);
  			$stmt->bindParam(":nomotro", $nomotro, PDO::PARAM_STR);
  		
  		
  		
  		if(!$stmt-> execute()){
  			throw new Exception("Error al actualizar opcion");
  		}
  	}catch(Exception $ex){
  		throw new Exception("Error al actualizar opcion");
  	}
  	
  	
  }
  
  public function insertarVolumen($clapresion,$clatemp,$volco,$tabla){
  	try{
  		
  		$sSQL= "insert into $tabla (cav_presion, cav_temperatura,cav_volumen)
 values (:clapresion, :clatemp, :volco)";
  		
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		
  		$stmt->bindParam(":clapresion", $clapresion, PDO::PARAM_STR);
  		$stmt->bindParam(":clatemp", $clatemp, PDO::PARAM_STR);
  		$stmt->bindParam(":volco", $volco, PDO::PARAM_STR);
  		
  		
  		
  		if(!$stmt-> execute()){
  			throw new Exception("Error al insertar opcion");
  		}
  	}catch(Exception $ex){
  		throw new Exception("Error al insertar opcion");
  	}
  	
  	
  }
  
  public function actualizarVolumen($clatemp,$volco,$tabla){
  	try{
  		
  		$sSQL=("update $tabla set cav_volumen=:volco
 where concat(cav_presion,'.',cav_temperatura)=:id");
  		
  		
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		
  		$stmt->bindParam(":id", $clatemp, PDO::PARAM_STR);
  		$stmt->bindParam(":volco", $volco, PDO::PARAM_STR);
  		
  		
  		
  		if(!$stmt-> execute()){
  		
  			throw new Exception("Error al actualizar opcion");
  		}
  	}catch(Exception $ex){
  		throw new Exception("Error al actualizar opcion");
  	}
  	
  	
  }
  
  public function insertarTipoMercado($cvetm,$nomtm,$tabla){
  	try{
  		
  		$sSQL= "insert into $tabla (tm_clavetipo, tm_nombretipo)
 values (:cvetm, :nomtm)";
  		
  		
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		
  		$stmt->bindParam(":cvetm", $cvetm, PDO::PARAM_STR);
  		$stmt->bindParam(":nomtm", $nomtm, PDO::PARAM_STR);
  			
  		
  		
  		if(!$stmt-> execute()){
  			throw new Exception("Error al insertar opcion");
  		}
  	}catch(PDOException $ex){
  		throw new Exception("Error al insertar opcion");
  	}
  	
  	
  }
  public function borrarTipoMercado($id,$tabla){
  	try{
  		
  		$sSQL="Delete From $tabla Where tm_clavetipo like :id";
  		
  		
  		
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		
  		$stmt->bindParam(":id", $id, PDO::PARAM_STR);
  			
  		
  		if(!$stmt-> execute()){
  			throw new Exception("Error al borrar opcion");
  		}
  	}catch(PDOException $ex){
  		throw new Exception("Error al borrar opcion");
  	}
  	
  }
  public function actualizarTipoMercado($id,$nombre,$tabla){
  	try{
  		
  		$sSQL="UPDATE `ca_tipomercado`
SET 
  `tm_nombretipo` =:nombretipo
WHERE `tm_clavetipo` = :clavetipo";
  		
  		
  		
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		
  		$stmt->bindParam(":clavetipo", $id, PDO::PARAM_STR);
  		$stmt->bindParam(":nombretipo", $nombre, PDO::PARAM_STR);
  		
  		
  		if(!$stmt-> execute()){
  			throw new Exception("Error al actualizar opcion");
  		}
  	}catch(PDOException $ex){
  		throw new Exception("Error al actualizar opcion");
  	}
  	
  }
  
  public function getTipoMercado($id,$tabla){
  
  		
  		$sSQL="SELECT
  `tm_clavetipo`,
  `tm_nombretipo`
FROM `ca_tipomercado` where  tm_clavetipo=:id";
  		
  		$stmt = Conexion::conectar()->prepare($sSQL);
  		
  		$stmt->bindParam(":id", $id, PDO::PARAM_STR);
  		$stmt-> execute();
  		$res=$stmt->fetch();
  		
  		return $res;
  	
  }
 
}
