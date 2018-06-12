<?php


class DatosCatalogoDetalle {
     public function listaCatalogoDetalle($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT
  `cad_idcatalogo`,
  `cad_idopcion`,
  `cad_descripcionesp`,
  `cad_descripcioning`,
  `cad_otro`
FROM $tabla where ca_catalogosdetalle.cad_idcatalogo= :id");
         
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}
}
