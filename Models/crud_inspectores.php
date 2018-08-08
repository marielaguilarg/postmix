<?php

require_once "Models/conexion.php";


class DatosInspector extends Conexion{


    public function listainspectores($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ins_clave, ins_nombre from ca_inspectores");
			
			$stmt-> execute();
			return $stmt->fetchall();
		
			$stmt->close();
	}

}

?>		