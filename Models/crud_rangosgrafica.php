<?php


class DatosRangosgrafica
{
    public static function vistaRangos() {
        $sqq= "SELECT
  `rg_id`,
  `red_servicio`,
  `red_numseccion`,
  `red_numreactivo`,
  `red_numcomponente`,
  `red_numcaracteristica`,
  `red_numcomponente2`,
  `red_numcaracteristica2`,
  `rg_valinicial`,
  `rg_valfinal`
FROM `cnfg_rangosgrafica`";
        $stmt = Conexion::conectar()->prepare($sqq);
       
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public static function getRango($id) {
        $sqq= "SELECT
  `rg_id`,
  `red_servicio`,
  `red_numseccion`,
  `red_numreactivo`,
  `red_numcomponente`,
  `red_numcaracteristica`,
  `red_numcomponente2`,
  `red_numcaracteristica2`,
  `rg_valinicial`,
  `rg_valfinal`
FROM `cnfg_rangosgrafica` where rg_id=:id ";
        $stmt = Conexion::conectar()->prepare($sqq);
        $stmt->bindParam(":id", $id,PDO::PARAM_INT);
        $stmt->execute();
        
        
        
        return $stmt->fetch();
    }
    
    public static function getRangoxSeccion($servicio,$seccion,$reac,$comp,$car) {
        $sqq= "SELECT
  `rg_id`,
  `red_servicio`,
  `red_numseccion`,
  `red_numreactivo`,
  `red_numcomponente`,
  `red_numcaracteristica`,
  `red_numcomponente2`,
  `red_numcaracteristica2`,
  `rg_valinicial`,
  `rg_valfinal`
FROM `cnfg_rangosgrafica` where red_servicio=:serv and red_numseccion:=secc and ";
        $stmt = Conexion::conectar()->prepare($sqq);
        $stmt->bindParam(":id", $id,PDO::PARAM_INT);
        $stmt->execute();
        
        
        
        return $stmt->fetchAll();
    }
    
    public static function getRangoxReferencia($servicio,$referencia) {
        $sqq= "SELECT
  `rg_id`,
  `red_servicio`,
  `red_numseccion`,
  `red_numreactivo`,
  `red_numcomponente`,
  `red_numcaracteristica`,
  `red_numcomponente2`,
  `red_numcaracteristica2`,
  `rg_valinicial`,
  `rg_valfinal`
FROM `cnfg_rangosgrafica` where red_servicio=:serv
 and concat(red_numseccion,'.',red_numreactivo,'.',red_numcomponente,'.',red_numcaracteristica,'.',red_numcomponente2,'.',red_numcaracteristica2)=:subseccion ";
        $stmt = Conexion::conectar()->prepare($sqq);
        $stmt->bindParam(":subseccion", $referencia,PDO::PARAM_STR);
        $stmt->bindParam(":serv", $servicio,PDO::PARAM_INT);
        $stmt->execute();
        
        
        
        return $stmt->fetchAll();
    }
    
    public static function eliminarRango($id, $tabla) {
        $sqq= "DELETE
FROM $tabla
WHERE `rg_id` = :rg_id";
        $stmt = Conexion::conectar()->prepare($sqq);
        try{
            $stmt->bindParam(":rg_id", $id);
          
            
          if(!$stmt->execute())
              throw new Exception("Error al eliminar rango");
        }catch(PDOException $es){
            throw new Exception("Error al eliminar rango");
        }
    }
    
    public static function insertarRango($serv,$sec,$reac,$com,$car,$com2,$car2,$valinicial,$valfinal, $tabla) {
        $sql="select max(rg_id) from ".$tabla;
        
        $stmt1 = Conexion::conectar()->prepare($sql);
        $stmt1->execute();
        $res=$stmt1->fetch();
      
        $res=$res[0];
        if ($res>0)
            $res++;
        else $res=1;
        $sqq= "INSERT INTO ".$tabla."
            (`rg_id`,
             `red_servicio`,
             `red_numseccion`,
             `red_numreactivo`,
             `red_numcomponente`,
             `red_numcaracteristica`,
             `red_numcomponente2`,
             `red_numcaracteristica2`,
             `rg_valinicial`,
             `rg_valfinal`)
VALUES (:id,
        :servicio,
        :numseccion,
        :numreactivo,
        :numcomponente,
        :numcaracteristica,
        :numcomponente2,
        :numcaracteristica2,
        :valinicial,
        :valfinal)";
        try{
        $stmt = Conexion::conectar()->prepare($sqq);
      
            $stmt->bindParam(":id", $res,PDO::PARAM_INT);
          
            $stmt->bindParam(":servicio",$serv,PDO::PARAM_INT);
            $stmt->bindParam(":numseccion",$sec,PDO::PARAM_INT);
            $stmt->bindParam(":numreactivo",$reac,PDO::PARAM_INT);
            $stmt->bindParam(":numcomponente",$com,PDO::PARAM_INT);
            $stmt->bindParam(":numcaracteristica",$car,PDO::PARAM_INT);
            $stmt->bindParam(":numcomponente2",$com2,PDO::PARAM_INT);
            $stmt->bindParam(":numcaracteristica2",$car2,PDO::PARAM_INT);
            $stmt->bindParam(":valinicial",$valinicial,PDO::PARAM_STR);
            $stmt->bindParam(":valfinal",$valfinal,PDO::PARAM_STR);
        //    echo $res."--". $serv."--".$sec."--".$reac."--".$com."--".$car."--".$com2."--".$car2."--".$valinicial."--".$valfinal;
            if(!$stmt->execute())
                throw new Exception("Error al insertar rango");
        }catch(PDOException $es){
            throw new Exception("Error al insertar rango");
        }
    }
    
}

