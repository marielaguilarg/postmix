<?php

require_once "Models/conexion.php";


class DatosMesasignacion extends Conexion{


    public function listaMesAsignacion($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT num_mes_asig, num_per_asig from $tabla order by num_per_asig desc, num_mes_asig ASC ");
			
			$stmt-> execute();
			return $stmt->fetchall();
		
		
	}
	

}

?>		