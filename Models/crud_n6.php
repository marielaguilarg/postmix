<?php



require_once "Models/conexion.php";





class Datosnsei extends Conexion{

	# CLASE NIVEL 





	public function vistanseiModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n6_id, n6_nombre FROM $tabla WHERE n6_idn5=:ids");

		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetchAll();

		$stmt->close();

	}





	public function vistanseiOpcionModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n6_id, n6_nombre,n6_idn5 FROM $tabla WHERE n6_id=:ids");

		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetch();

		$stmt->close();

	} 



  public function nombreNivel6($id,$tabla) {



            $sql = "SELECT n6_id, n6_nombre FROM $tabla where n6_id=:id ";



           $stmt = Conexion::conectar()-> prepare($sql);

            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            $stmt->execute();

            $res=$stmt->fetchAll();

            foreach ($res as $row) {

              $nombre = $row["n6_nombre"];

            }
            $stmt=null;
            $res=null;
             return $nombre;

        }
        
        function add($n6_idn5,$n6_nombre,$tabla){
        	$stmt = Conexion::conectar()-> prepare("SELECT max(n6_id) FROM $tabla ");
        	
        	
        	$stmt-> execute();
        	$res=$stmt->fetch();
        	if($res)
        		$n6_id=$res[0]+1;
        	else
        		$n6_id=1;
        	$query = "INSERT INTO $tabla  (n6_idn5, n6_id, n6_nombre)
		VALUES (
			:n6_idn5,
			:n6_id,
			:n6_nombre)";
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n6_idn5' => $n6_idn5, ':n6_id' => $n6_id, ':n6_nombre' => $n6_nombre))){
        		return (Conexion::conectar()->lastInsertId());
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Update a row in ca_nivel6
         * @param array data
         */
        function update($n6_idn5,$n6_nombre,$n6_id,$tabla){
        	
        	$query = "UPDATE $tabla SET
		`n6_idn5` = :n6_idn5,
		`n6_nombre` = :n6_nombre
	WHERE n6_id = :n6_id ";
        	
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n6_idn5' => $n6_idn5, ':n6_nombre' => $n6_nombre, ':n6_id' => $n6_id ))){
        	
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Delete a row in ca_nivel6
         * @param Int n6_id
         */
        function del($n6_id,$tabla){
        	
        	$query = "DELETE FROM $tabla WHERE n6_id = :n6_id";
        	$q = Conexion::conectar()->prepare($query);
        	
        	if ($q->execute(array(':n6_id' => $n6_id ))){
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }
        
        

}
