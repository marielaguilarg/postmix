<?php
class DatosGrupo
{
    
    public static function vistaGrupos( $tabla) {
        $sql="   SELECT
  `cgr_clavegrupo`,
  `cgr_nombregrupo`
FROM ".$tabla;
        $stmt = Conexion::conectar()->prepare($sql);
     
        $stmt->execute();
        
        
        
        return $stmt->fetchAll();
    }
    public static  function getGrupo($idgrupo,$tabla) {
        $sql=" SELECT
  `cgr_clavegrupo`,
  `cgr_nombregrupo`
FROM $tabla
WHERE cgr_clavegrupo=:idgrupo";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idgrupo", $idgrupo, PDO::PARAM_STR);
        
        $stmt->execute();
        
        
        
        return $stmt->fetch();
    }
    
    public static  function ultimoGrupo($tabla) {
        $sql=" SELECT max(cgr_clavegrupo) as clavegroup
		 FROM ".$tabla.";";
        $stmt = Conexion::conectar()->prepare($sql);
         
        $stmt->execute();
        
        
        
        $res= $stmt->fetch();
     
        if($res[0])return $res[0];
        else return 0;
    }
    
    public static function actualizarGrupo($idgrupo, $nombre, $tabla) {
        $sql=" UPDATE ".$tabla."
SET 
  `cgr_nombregrupo` = :nombregrupo
WHERE `cgr_clavegrupo` = :idgrupo";
        try{
        $stmt = Conexion::conectar()->prepare($sql);
        
        $stmt->bindParam(":idgrupo", $idgrupo, PDO::PARAM_STR);
        
        $stmt->bindParam(":nombregrupo", $nombre, PDO::PARAM_STR);
        
        
        
        $stmt->execute();
        }catch(PDOException $ex){
            throw new Exception("Error al actualizar el grupo");
        }
        
      
    }
    
    public static function insertarGrupo($idgrupo, $nombre, $tabla) {
        $sql=" INSERT INTO ".$tabla."
            (`cgr_clavegrupo`,
             `cgr_nombregrupo`)
VALUES (:clavegrupo,
        :nombregrupo);";
        try{
            $stmt = Conexion::conectar()->prepare($sql);
            
            $stmt->bindParam(":clavegrupo", $idgrupo, PDO::PARAM_STR);
            
            $stmt->bindParam(":nombregrupo", $nombre, PDO::PARAM_STR);
            
            
            
            $stmt->execute();
        
        }catch(PDOException $ex){
            throw new Exception("Error al insertar el grupo");
        }
        
        
    }
    
    public static function eliminarGrupo($idgrupo,  $tabla) {
        $sql=" DELETE
FROM ".$tabla."
WHERE `cgr_clavegrupo` =:clavegrupo";
        try{
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":clavegrupo", $idgrupo, PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $ex){
            throw new Exception("Error al eliminar el grupo");
        }
        
        
    }
    
   
    
}

