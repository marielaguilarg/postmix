<?php



require_once "Models/conexion.php";


class UsuarioModel extends Conexion{
	# REGISTRO DE USUARIOS
	#---------------------------------------------
	public function validaUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT cus_usuario, cus_contrasena, cus_email  FROM $tabla WHERE cus_email=:email and cus_contrasena=:pass");

		$stmt->bindParam(":email", $datosModel["logemail"], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $datosModel["logpass"], PDO::PARAM_STR);

		$stmt-> execute();

		return $stmt->rowCount();

		$stmt->close();
	}

	public function actualizaLogEntUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("UPDATE cnfg_usuarios SET cus_estatus=:estatus, cus_timelogin=:horalog WHERE cus_email =:emusuario");

		$stmt->bindParam(":estatus", $datosModel["estatus"], PDO::PARAM_STR);
		$stmt->bindParam(":horalog", $datosModel["horalog"], PDO::PARAM_STR);
		$stmt->bindParam(":emusuario", $datosModel["emusuario"], PDO::PARAM_STR);

		IF($stmt-> execute()){

			return "success";
		}
		
		else {

			return "error";
	
		};
		

		$stmt->close();
	}	

	public function consultaUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT cus_usuario, cus_nombreusuario, cus_email, cus_clavegrupo, cus_idioma, cus_cargo  FROM cnfg_usuarios WHERE cus_email=:email and cus_contrasena=:pass");

		$stmt->bindParam(":email", $datosModel["logemail"], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $datosModel["logpass"], PDO::PARAM_STR);

		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}
        
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

?>	
