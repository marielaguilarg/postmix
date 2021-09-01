<?php


class DatosUnegociosAsignados
{
  
    
      public static function insertarMultipleTemporal($rows) {
      $row_length = 6;
      $nb_rows = count($rows);
      Utilerias::guardarError("***Insertando en tmp_unegociosasignados ****".$nb_rows."--".$length);
      
      $length = $nb_rows * $row_length;
     // echo "*********".$nb_rows."--".$length;
      try{
          $args = implode(',', array_map(
                                function($el) { return '('.implode(',', $el).')'; },
                                array_chunk(array_fill(0, $length, '?'), $row_length)
                            ));
                                //limpio la tabla
         $stmt0 = Conexion::conectar()->prepare("call sptruncate_tmp_unegociosasignados"); 
         Utilerias::guardarError("se elimino tabla temporal");
         $stmt0->execute();
        $sqq= "INSERT INTO `tmp_unegociosasignados`
(
`nombreregion`,
`ciudad`,
`nombrecuenta`,
total,
asignados,
numeroequipos) VALUES ".$args;
      
            $params = array();
          //  var_dump( $rows);
        foreach($rows as $row)
        {
            $i=1;
           foreach($row as $value)
           {
               if($i>6)
                   break;
               if($value=="")
                   $value=null;
              $params[] = $value;
              $i++;
           }
        }
        $stmt = Conexion::conectar()->prepare($sqq);
      
         // var_dump($params);
           
        
        if(!$stmt->execute($params))
        {     
           // $stmt->debugDumpParams();
            Utilerias::guardarError("Error al insertar datos >>".$stmt->errorInfo()[2]);
            //Utilerias::guardarError( $stmt->debugDumpParams());
            
   //  var_dump($stmt->errorInfo());
     //       die();
            throw new Exception("Error al insertar datos ");
        
        }
        
        }catch(PDOException $es){
            Utilerias::guardarError("Error al insertar datos >>".$es->getMessage());
            
            throw new Exception("Error al insertar datos >>+".$es->getMessage());
        }
    }
    
      public static function actualizarIds($anio) {
    
        $sqq= "update tmp_unegociosasignados
inner join ca_nivel4 on n4_nombre=nombreregion
and n4_idn3=5
set  tmp_unegociosasignados.n4_id=ca_nivel4.n4_id;


update tmp_unegociosasignados
inner join ca_nivel4 on tmp_unegociosasignados.n4_id=ca_nivel4.n4_id
and n4_idn3=5
inner join ca_nivel5 on ca_nivel5.n5_idn4=ca_nivel4.n4_id
inner join ca_nivel6 on ca_nivel6.n6_nombre=tmp_unegociosasignados.ciudad
and ca_nivel5.n5_id=ca_nivel6.n6_idn5
set tmp_unegociosasignados.n5_id=ca_nivel6.n6_idn5;


update tmp_unegociosasignados as x
inner join ca_cuentas on ca_cuentas.cue_descripcion=nombrecuenta and cue_idcliente=1
set x.cue_id=ca_cuentas.cue_id;
update tmp_unegociosasignados
set anio=".$anio.";

 ";
        try{
          
        $stmt = Conexion::conectar()->prepare($sqq);
        if(!$stmt->execute())
        {     
            Utilerias::guardarError("Error al actualizar la tabla tmp_unegociosasignados ");
            
            throw new Exception("Error al actualizar datos");
            
        }
            
        }catch(PDOException $es){
            throw new Exception("Error al insertar datos");
        }
    }
    
   

  public static function pasaraCatalogo() {
    
        $sqq= " INSERT INTO `ca_unegociosasignados`
(
`n5_id`,
`n4_id`,
`ciudad`,
`cue_id`,
`una_unegociototal`,
`una_unegocioasignados`,
`una_numeroequipos`,
una_anio)

SELECT `tmp_unegociosasignados`.`n5_id`,
    `tmp_unegociosasignados`.`n4_id`,

    `tmp_unegociosasignados`.`ciudad`,
   
    `tmp_unegociosasignados`.`cue_id`,
    `tmp_unegociosasignados`.`total`,
    `tmp_unegociosasignados`.`asignados`,
    `tmp_unegociosasignados`.`numeroequipos`,
    `tmp_unegociosasignados`.`anio`
FROM `tmp_unegociosasignados`;


 ";
        try{
          
        $stmt = Conexion::conectar()->prepare($sqq);
        if(!$stmt->execute())
        {     
            Utilerias::guardarError("Error al actualizar la tabla tmp_unegociosasignados ".$stmt->errorInfo()[2]);
            
            throw new Exception("Error al actualizar datos");
            
        }
            
        }catch(PDOException $es){
            throw new Exception("Error al insertar datos");
        }
    }
    
    	public function buscarIdsNulos(){
		$stmt = Conexion::conectar()-> prepare("select nombreregion, ciudad from tmp_unegociosasignados where 
n5_id is null
group by ciudad");
		

		$stmt-> execute();

		return $stmt->fetchAll();
	}



    
}

