<?php


class DatosGraficaIndicadores
{
    public static function vistaReactivos() {
        $sqq= "SELECT `cnfg_graficaindicadores`.`gri_id`,
    `cnfg_graficaindicadores`.`gri_tiporeactivo`,
    `cnfg_graficaindicadores`.`gri_reactivo`,
    `cnfg_graficaindicadores`.`gri_orden`,
    `cnfg_graficaindicadores`.`gri_seccion`
FROM `cnfg_graficaindicadores`;";
        $stmt = Conexion::conectar()->prepare($sqq);
       
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    
    
    public static function getReactivosxSeccion($seccion) {
        $sqq= "SELECT `cnfg_graficaindicadores`.`gri_id`,
    `cnfg_graficaindicadores`.`gri_tiporeactivo`,
    `cnfg_graficaindicadores`.`gri_reactivo`,
    `cnfg_graficaindicadores`.`gri_orden`,
    `cnfg_graficaindicadores`.`gri_seccion`,red_parametroesp
FROM `cnfg_graficaindicadores`
inner join cue_reactivosestandardetalle on concat(cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2) =gri_reactivo and cue_reactivosestandardetalle.ser_claveservicio=1
where gri_seccion=:secc ";
        $stmt = Conexion::conectar()->prepare($sqq);
        $stmt->bindParam(":secc", $seccion,PDO::PARAM_INT);
        $stmt->execute();
     //   $stmt->debugDumpParams();
       // die();
        return $stmt->fetchAll();
    }
    
  
    
    public static function eliminarReactivo($id, $tabla) {
        $sqq= "DELETE
FROM $tabla
WHERE `gri_id` = :id";
        $stmt = Conexion::conectar()->prepare($sqq);
        try{
            $stmt->bindParam(":id", $id);
          
            
          if(!$stmt->execute())
              throw new Exception("Error al eliminar rango");
        }catch(PDOException $es){
            throw new Exception("Error al eliminar rango");
        }
    }
    
     public static function eliminarxSeccion($id, $tabla) {
        $sqq= "DELETE
FROM $tabla
WHERE `gri_seccion` = :id";
        $stmt = Conexion::conectar()->prepare($sqq);
        try{
            $stmt->bindParam(":id", $id);
          
            
          if(!$stmt->execute())
              throw new Exception("Error al eliminar rango");
        }catch(PDOException $es){
            throw new Exception("Error al eliminar rango");
        }
    }
    
    public static function insertarReactivo($sec,$reac,$orden,$tipo) {
      
        $sqq= "INSERT INTO `cnfg_graficaindicadores`
(
`gri_tiporeactivo`,
`gri_reactivo`,
`gri_orden`,
gri_seccion) VALUES (:tiporeactivo,:reactivo,:orden,:seccion)";
        try{
        $stmt = Conexion::conectar()->prepare($sqq);
      
          
            $stmt->bindParam(":seccion",$sec,PDO::PARAM_INT);
            $stmt->bindParam(":reactivo",$reac,PDO::PARAM_STR);
          
            $stmt->bindParam(":orden",$orden,PDO::PARAM_INT);
            $stmt->bindParam(":tiporeactivo",$tipo,PDO::PARAM_STR);
            if(!$stmt->execute())
            {     
                $stmt->debugDumpParams();
                throw new Exception("Error al insertar reactivos");
            
            }
            
        }catch(PDOException $es){
            throw new Exception("Error al insertar reactivos");
        }
    }
    
  
    
}

