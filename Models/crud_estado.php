<?php

class DatosEstado {
    public function listaEstadosModel($tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT  `est_id`,  `est_nombre` FROM  $tabla ");
		
		$stmt-> execute();


		return $stmt->fetchAll();
	}
        
        public function editarEstadoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT  `est_id`,  `est_nombre` FROM FROM $tabla WHERE est_id= :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetch();
	}
}
