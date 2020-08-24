<?php



require_once "Models/conexion.php";





class Datosntres extends Conexion{

	# CLASE NIVEL 1n1





	public function vistantresModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n3_id, n3_nombre FROM $tabla WHERE n3_idn2=:idn2");

		$stmt-> bindParam(":idn2", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();

                

		return $stmt->fetchAll();

	}





	public function vistaN3opcionModel($idn3, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n3_idn2, n3_id, n3_nombre FROM ca_nivel3 WHERE n3_id=:idn3");



		$stmt-> bindParam(":idn3", $idn3, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetch();

	}	  

	public function vistatresModel($datosModel,$idn3,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n3_id, n3_nombre FROM $tabla WHERE n3_idn2=:idn2 and n3_id=:idn3");

		$stmt-> bindParam(":idn2", $datosModel, PDO::PARAM_INT);

		$stmt-> bindParam(":idn3", $idn3, PDO::PARAM_INT);

		



		$stmt-> execute();



		return $stmt->fetchAll();

	}



	 public function nombreNivel3($id,$tabla) {



            $sql = "SELECT n3_id, n3_nombre FROM $tabla where n3_id=:id ";



            $stmt = Conexion::conectar()-> prepare($sql);

            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            $stmt->execute();

            $res=$stmt->fetchAll();

            foreach ($res as $row) {

              $nombre = $row["n3_nombre"];

            }
			$res=null;
			$stmt->closeCursor();
			$stmt=null;
        	return $nombre;

        }
        
        
        /**
         * Add a row in ca_nivel3
         * @param array data
         */
        function add($n3_idn2,$n3_nombre,$tabla){
        	
        	$query = "INSERT INTO $tabla  (n3_idn2,  n3_nombre)
		VALUES (
			:n3_idn2,
			
			:n3_nombre)";
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n3_idn2' => $n3_idn2, ':n3_nombre' => $n3_nombre))){
        		return (Conexion::conectar()->lastInsertId());
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Update a row in ca_nivel3
         * @param array data
         */
        function update($n3_id,$n3_idn2,$n3_nombre,$tabla){
        	
        	$query = "UPDATE $tabla SET
		`n3_idn2` = :n3_idn2,
		`n3_nombre` = :n3_nombre
	WHERE n3_id = :n3_id ";
        	
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n3_idn2' => $n3_idn2, ':n3_nombre' => $n3_nombre, ':n3_id' => $n3_id ))){
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Delete a row in ca_nivel3
         * @param Int n3_id
         */
        function del($n3_id,$tabla){
        	
        	$query = "DELETE FROM $tabla WHERE n3_id = :n3_id";
        	$q = Conexion::conectar()->prepare($query);
        	
        	if ($q->execute(array(':n3_id' => $n3_id ))){
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        

}
