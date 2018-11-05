<?php


class DatosCnfgSurveyData
{
    public static function vistaCnfgSurveyData() {
        $sqq= "SELECT
  `surv_numerocol`,
  `surv_tiporeactivo`,
  `surv_numeroreac`,
  `surv_descripcion`,
  `surv_nombrecol`,
  `surv_numeroreng`,
  `surv_valorini`
FROM cnfg_surveydata order by surv_numerocol";
        $stmt = Conexion::conectar()->prepare($sqq);
       
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public static function getCnfgSurveyData($col) {
        $sqq= "SELECT
  `surv_numerocol`,
  `surv_tiporeactivo`,
  `surv_numeroreac`,
  `surv_descripcion`,
  `surv_nombrecol`,
  `surv_numeroreng`,
  `surv_valorini`
FROM cnfg_surveydata where surv_numerocol=:col ";
        $stmt = Conexion::conectar()->prepare($sqq);
        $stmt->bindParam(":col", $col,PDO::PARAM_INT);
        $stmt->execute();
        
        
        
        return $stmt->fetch();
    }
    
  
    public static function eliminarCnfgSurveyData($col, $tabla) {
        $sqq= "DELETE
FROM ".$tabla."
WHERE `surv_numerocol` = :col";
        $stmt = Conexion::conectar()->prepare($sqq);
        try{
            $stmt->bindParam(":col", $col);
          
            
          if(!$stmt->execute())
              throw new Exception("Error al eliminar cnfgSurveyData");
        }catch(PDOException $es){
            throw new Exception("Error al eliminar cnfgSurveyData");
        }
    }
    
    public static function eliminarTodo( $tabla) {
        $sqq= "DELETE
FROM ".$tabla;
        $stmt = Conexion::conectar()->prepare($sqq);
        try{
           
            
            if(!$stmt->execute())
                throw new Exception("Error al eliminar cnfgSurveyData");
        }catch(PDOException $es){
            throw new Exception("Error al eliminar cnfgSurveyData");
        }
    }
    
    public static function insertarCnfgSurveyData($col, $tipo,$reac,$descripcion,$nombre,$numreng,$valini, $tabla) {
       
        $sqq= "INSERT INTO ".$tabla."
            (`surv_numerocol`,
             `surv_tiporeactivo`,
             `surv_numeroreac`,
             `surv_descripcion`,
             `surv_nombrecol`,
             `surv_numeroreng`,
             `surv_valorini`)
VALUES (:numerocol,
        :tiporeactivo,
        :numeroreac,
        :descripcion,
        :nombrecol,
        :numeroreng,
        :valorini)";
        try{
        $stmt = Conexion::conectar()->prepare($sqq);
      
            $stmt->bindParam(":numerocol", $col,PDO::PARAM_INT);
          
            $stmt->bindParam(":tiporeactivo",$tipo,PDO::PARAM_STR);
            $stmt->bindParam(":numeroreac",$reac,PDO::PARAM_STR);
          
            $stmt->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
            $stmt->bindParam(":nombrecol",$nombre,PDO::PARAM_STR);
            $stmt->bindParam(":numeroreng",$numreng,PDO::PARAM_INT);
            $stmt->bindParam(":valorini",$valini,PDO::PARAM_STR);
          
        //    echo $res."--". $serv."--".$sec."--".$reac."--".$com."--".$car."--".$com2."--".$car2."--".$valinicial."--".$valfinal;
            if(!$stmt->execute())
            
                throw new Exception("Error al insertar cnfgSurveyData");
        }catch(PDOException $es){
            throw new Exception("Error al insertar cnfgSurveyData");
        }
    }
    
    public static function editarCnfgSurveyData($col,$col2, $reac,$descripcion,$nombre,$numreng,$valini, $tabla){
       
        $sqq= " UPDATE ".$tabla."
SET `surv_numerocol` =:numerocol,
 
 
  `surv_descripcion` =:descripcion,
  `surv_nombrecol` =:nombrecol,
  `surv_numeroreng` =:numeroreng,
  `surv_valorini` =:valorini
WHERE `surv_numerocol` =:numerocol2 and `surv_numeroreac`=:numeroreac ";
            try{
                $stmt = Conexion::conectar()->prepare($sqq);
                $stmt->bindParam(":numerocol", $col,PDO::PARAM_INT);
                $stmt->bindParam(":numerocol2", $col2,PDO::PARAM_INT);
                
             
                $stmt->bindParam(":numeroreac",$reac,PDO::PARAM_STR);
                
                $stmt->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
                $stmt->bindParam(":nombrecol",$nombre,PDO::PARAM_STR);
                $stmt->bindParam(":numeroreng",$numreng,PDO::PARAM_INT);
                $stmt->bindParam(":valorini",$valini,PDO::PARAM_STR);
                //    echo $res."--". $serv."--".$sec."--".$reac."--".$com."--".$car."--".$com2."--".$car2."--".$valinicial."--".$valfinal;
                if(!$stmt->execute())
                   throw new Exception("Error al actualizar cnfgSurveyData");
            }catch(PDOException $es){
                throw new Exception("Error al actualizar cnfgSurveyData");
            }
    }
    
    public static function ejecutarInsert($sql) {
        try {
          $stmt = Conexion::conectar()->prepare($sql);
            
          
            if (!$stmt->execute()) {
               
                throw new Exception("Error al insertar/actualizar");
            }
        } catch (PDOException $e) {
            
            throw new Exception("Error al ejecutar insert en la bd " . $e);
        }
    }
    
}

