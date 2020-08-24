<?php



require_once "Models/conexion.php";





class Datosncua extends Conexion{

	# CLASE NIVEL 1n1





	public function vistancuaModel($datosModel,$tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n4_id, n4_nombre FROM $tabla WHERE n4_idn3=:idn3");

		$stmt-> bindParam(":idn3", $datosModel, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetchAll();

	}



	public function vistaN4opcionModel($idn4, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT n4_id, n4_nombre,n4_idn3 FROM ca_nivel4 WHERE n4_id=:idn4");



		$stmt-> bindParam(":idn4", $idn4, PDO::PARAM_INT);

		

		$stmt-> execute();



		return $stmt->fetch();

	}



 public function nombreNivel4($id,$tabla) {



            $sql = "SELECT n4_id, n4_nombre FROM $tabla where n4_id=:id ";



            $stmt = Conexion::conectar()-> prepare($sql);

            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            $stmt->execute();

            $res=$stmt->fetchAll();

            foreach ($res as $row) {

              $nombre = $row["n4_nombre"];

            }
            $res=null;
            $stmt->closeCursor();
            $stmt=null;
             return $nombre;

        }
        
        function add($n4_idn3,$n4_nombre,$tabla){
        	
        	$stmt = Conexion::conectar()-> prepare("SELECT max(n4_id) FROM $tabla ");
        	
        
        	$stmt-> execute();
        	
        	
        	
        	$res= $stmt->fetch();
        
        	if($res)
        		$n4_id=$res[0]+1;
        	else
        		$n4_id=1;
        		echo $n4_id;
        	$query = "INSERT INTO $tabla  (n4_idn3, n4_id, n4_nombre)
		VALUES (
			:n4_idn3,
			:n4_id,
			:n4_nombre)";
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n4_idn3' => $n4_idn3, ':n4_id' => $n4_id, ':n4_nombre' => $n4_nombre))){
        		
        		return (Conexion::conectar()->lastInsertId());
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Update a row in ca_nivel4
         * @param array data
         */
        function update($n4_idn3,$n4_nombre,$n4_id, $tabla){
        	
        	$query = "UPDATE $tabla SET
		`n4_idn3` = :n4_idn3,
		`n4_nombre` = :n4_nombre
	WHERE n4_id = :n4_id ";
        	
        	$q = Conexion::conectar()->prepare($query);
        	
        	
        	if ($q->execute(array(':n4_idn3' => $n4_idn3, ':n4_nombre' => $n4_nombre, ':n4_id' => $n4_id ))){
        		
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }
        
        
        
        /**
         * Delete a row in ca_nivel4
         * @param Int n4_id
         */
        function del($n4_id,$tabla){
        	
        	$query = "DELETE FROM $tabla WHERE n4_id = :n4_id";
        	$q = Conexion::conectar()->prepare($query);
        	
        	if ($q->execute(array(':n4_id' => $n4_id ))){
        		return (1);
        	}
        	else{
        		return(0);
        	}
        }
        

}
