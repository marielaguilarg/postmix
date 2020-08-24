<?php



require_once "Models/conexion.php";





class Datosncin extends Conexion{

	# CLASE NIVEL 





	public function vistancinModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n5_id, n5_nombre FROM $tabla WHERE n5_idn4=:idn");

		$stmt-> bindParam(":idn", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();

    

		return $stmt->fetchAll();

		$stmt->close();

	}





	public function vistancinOpcionModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n5_id, n5_nombre,n5_idn4 FROM $tabla WHERE n5_id=:idn");

		$stmt-> bindParam(":idn", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetch();

		$stmt->close();

	}



	public function NivelCincoOpcionModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n5_id, n5_nombre FROM ca_nivel5 WHERE n5_id=:idn");

		$stmt-> bindParam(":idn", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetchAll();

		$stmt->close();

	}	

 public function nombreNivel5($id,$tabla) {



            $sql = "SELECT n5_id, n5_nombre FROM $tabla where n5_id=:id ";



           $stmt = Conexion::conectar()-> prepare($sql);

            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            $stmt->execute();

            $res=$stmt->fetchAll();

            foreach ($res as $row) {

              $nombre = $row["n5_nombre"];

            }

             return $nombre;

        }


        function add($n5_idn4,$n5_nombre,$tabla){
        	$stmt = Conexion::conectar()-> prepare("SELECT max(n5_id) FROM $tabla ");
        		$stmt-> execute();
        	
        	
        	
        	$res= $stmt->fetch();
        	if($res)
        		$n5_id=$res[0]+1;
        	else
        		$n5_id=1;
        		
        	$query = "INSERT INTO $tabla  (n5_idn4, n5_id, n5_nombre)
		VALUES (
			:n5_idn4,
			:n5_id,
			:n5_nombre)";
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n5_idn4' => $n5_idn4, ':n5_id' => $n5_id, ':n5_nombre' => $n5_nombre))){
        		return (Conexion::conectar()->lastInsertId());
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Update a row in ca_nivel5
         * @param array data
         */
        function update($n5_idn4,$n5_nombre,$n5_id,$tabla){
        	
        	$query = "UPDATE $tabla SET
		`n5_idn4` = :n5_idn4,
		`n5_nombre` = :n5_nombre
	WHERE n5_id = :n5_id ";
        	
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n5_idn4' => $n5_idn4, ':n5_nombre' => $n5_nombre, ':n5_id' => $n5_id ))){
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Delete a row in ca_nivel5
         * @param Int n5_id
         */
        function del($n5_id,$tabla){
        	
        	$query = "DELETE FROM $tabla WHERE n5_id = :n5_id";
        	$q = Conexion::conectar()->prepare($query);
        	
        	if ($q->execute(array(':n5_id' => $n5_id ))){
        		
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }






}

