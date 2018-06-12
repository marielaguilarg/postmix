<?php


class DatosUsuario  {
    
     public function getUsuario($id,$tabla){
		$stmt = Conexion::conectar()-> prepare("select `cus_usuario`,
  `cus_contrasena`,
  `cus_nombreusuario`,
  `cus_empresa`,
  `cus_cargo`,
  `cus_telefono`,
  `cus_email`,
  `cus_clavegrupo`,
  `cus_tipoconsulta`,
  `cus_nivel1`,
  `cus_nivel2`,
  `cus_nivel3`,
  `cus_nivel4`,
  `cus_nivel5`,
  `cus_nivel6`,
  `cus_idioma`,
  `cus_cliente`,
  `cus_servicio`,
  `cus_solcer` from $tabla where cus_usuario=:idusuario");
		$stmt->bindParam("idusuario", $id);		
		$stmt-> execute();

		return $stmt->fetchAll();
		
	}
}
