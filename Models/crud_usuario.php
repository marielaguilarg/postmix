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
        
         function buscarReferenciaNivel($usuario,$grupo,$servicio, $cliente) {
        $result = 0;
      
        // verifico el tipo de usuario

        $query = "SELECT
cnfg_usuarios.cus_usuario,
cnfg_usuarios.cus_clavegrupo,
cnfg_usuarios.cus_tipoconsulta,
cnfg_usuarios.cus_nivel1,
cnfg_usuarios.cus_nivel2,
cnfg_usuarios.cus_nivel3,
cnfg_usuarios.cus_nivel4,
cnfg_usuarios.cus_nivel5,
cnfg_usuarios.cus_nivel6,
cnfg_usuarios.cus_cliente,
cnfg_usuarios.cus_servicio,
cnfg_usuarios.cus_nombreusuario
FROM
cnfg_usuarios
where cus_usuario=:usuario and cnfg_usuarios.cus_cliente=:cliente and
cnfg_usuarios.cus_servicio=:servicio";
        $parametros = array("usuario" => $usuario,"servicio"=>$servicio,":cliente"=>$cliente);

        $res = Conexion::ejecutarQuery($query, $parametros);
        foreach ($res as $row) {
            $nivCons = $row["cus_tipoconsulta"];
            if ($grupo == "cli" || $grupo == "muf") {
                $refer = $row["cus_nivel4"] . "." . $row["cus_nivel5"] . "." . $row["cus_nivel6"];
            }
            if ($grupo == "cue") {
                if ($row["cus_nivel3"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"];
                else if ($row["cus_nivel2"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"];
                else
                    $refer = $row["cus_nivel1"];
            }
        }

        return $refer;
    }
}
