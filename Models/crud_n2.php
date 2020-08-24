<?php



require_once "Models/conexion.php";





class Datosndos extends Conexion{

	# CLASE NIVEL 1n1





	public function vistandosModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n2_id, n2_nombre FROM $tabla WHERE n2_idn1=:idn1");

		$stmt-> bindParam(":idn1", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetchAll();

	}



	public function vistaN2opcionModel($idn2, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n2_idn1, n2_id, n2_nombre FROM ca_nivel2 WHERE n2_id=:idn2");



		$stmt-> bindParam(":idn2", $idn2, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetch();

	}  
	public function vistaN2opcionModelMod($idn2, $tabla){
		
		$stmt = Conexion::conectar()-> prepare("SELECT  n2_id, n2_nombre,n2_idn1 FROM ca_nivel2 WHERE n2_id=:idn2");
		
		
		
		$stmt-> bindParam(":idn2", $idn2, PDO::PARAM_INT);
		
		
		
		$stmt-> execute();
		
		
		
		return $stmt->fetch();
		
	}
	

public function vistadosModel($idn1, $idn2, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n2_idn1, n2_id, n2_nombre FROM ca_nivel2 WHERE n2_idn1=:idn1 and n2_id=:idn2");



		$stmt-> bindParam(":idn1", $idn1, PDO::PARAM_INT);

		$stmt-> bindParam(":idn2", $idn2, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetch();

	}

   public function nombreNivel2($id,$tabla) {



            $sql = "SELECT n2_id, n2_nombre FROM $tabla where n2_id=:id ";



            $stmt = Conexion::conectar()-> prepare($sql);

            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            $stmt->execute();

            $res=$stmt->fetchAll();

            foreach ($res as $row) {

              $nombre = $row["n2_nombre"];

            }

             return $nombre;

            }

            
            /**
             * Add a row in ca_nivel2
             * @param array data
             */
            function add($data,$tabla){
            	
            	$query = "INSERT INTO $tabla  (n2_idn1,  n2_nombre)
		VALUES (
			:n2_idn1,
			
			:n2_nombre)";
            	$q = Conexion::conectar()->prepare($query);
            	
            	
            	if ($q->execute(array(':n2_idn1' => $data['n2_idn1'],  ':n2_nombre' => $data['n2_nombre']))){
            		return (Conexion::conectar()->lastInsertId());
            	}
            	else{
            		return(0);
            	}
            }
            
            
            
            /**
             * Update a row in ca_nivel2
             * @param array data
             */
            function update($data,$tabla){
            	
            	$query = "UPDATE $tabla SET
		`n2_idn1` = :n2_idn1,
	
		`n2_nombre` = :n2_nombre
	WHERE n2_id = :id ";
            	
            	$q = Conexion::conectar()->prepare($query);
            	
            	
            	if ($q->execute(array(':n2_idn1' => $data['n2_idn1'],  ':n2_nombre' => $data['n2_nombre'], ':id' => $data['n2_id'] ))){
            		return (1);
            	}
            	else{
            		return(0);
            	}
            }
            
            
            
            /**
             * Delete a row in ca_nivel2
             * @param Int id
             */
            function del($id,$tabla){
            	
            	$query = "DELETE FROM $tabla WHERE n2_id = :id";
            	$q = Conexion::conectar()->prepare($query);
            	
            	if ($q->execute(array(':id' => $id ))){
            	
            		return (1);
            	}
            	else{
            		return(0);
            	}
            }
            
            
            

}

