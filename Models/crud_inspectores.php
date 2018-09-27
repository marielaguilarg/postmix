<?php

require_once "Models/conexion.php";


class DatosInspector extends Conexion{


    public function listainspectores($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ins_clave, ins_nombre from ca_inspectores");
			
			$stmt-> execute();
			return $stmt->fetchall();
		
			$stmt->close();
	}
	
	public function getInspector($usuario,$tabla){
	    $sqlins="SELECT ca_inspectores.ins_usuario, ca_inspectores.ins_nombre FROM $tabla
 WHERE ca_inspectores.ins_usuario =:nins";
	    
	    $stmt=Conexion::conectar()->prepare($sqlins);
	    $stmt->bindParam(":nins", $usuario, PDO::PARAM_INT);
	    $stmt-> execute();
	   
	    return $stmt->fetch();
	    
	}

}

?>		