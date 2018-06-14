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


}

?>	
