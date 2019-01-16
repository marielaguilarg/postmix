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

        

         function buscarReferenciaNivel($usuario) {

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

where cus_usuario=:usuario ";

        $parametros = array("usuario" => $usuario);



        $res = Conexion::ejecutarQuery($query, $parametros);

        foreach ($res as $row) {

            $nivCons = $row["cus_tipoconsulta"];

            $grupo=$row["cus_clavegrupo"];

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









  function validarRegionCuenta() {

        $result = 0;

        $usuario = $_SESSION["UsuarioInd"];



       

        // verifico el tipo de usuario

      

            $query = "SELECT

cnfg_usuarios.cus_usuario,

cnfg_usuarios.cus_clavegrupo,

cnfg_usuarios.cus_tipoconsulta,

cnfg_usuarios.cus_nivel1,

cnfg_usuarios.cus_nivel2,

cnfg_usuarios.cus_nivel3,

cnfg_usuarios.cus_nivel4,

cnfg_usuarios.cus_cliente,

cnfg_usuarios.cus_servicio,

cnfg_usuarios.cus_nombreusuario

FROM

cnfg_usuarios

where cus_usuario=:usuario ";

//      echo $query;

            $parametros = array("usuario" => $usuario);

            $res = Conexion::ejecutarQuery($query, $parametros);



            foreach ($res as $row) {

                $grupo=$row["cus_clavegrupo"];

                $nivCons = $row["cus_tipoconsulta"];

                $niv4 = $row["cus_nivel4"];

                $niv1 = $row["cus_nivel1"];

                $niv2 = $row["cus_nivel2"];

                $niv3 = $row["cus_nivel3"];

            }

            if ($grupo == "cli") {

                if ($nivCons >= 4)

                    $result = $nivCons; //devuelvo nivel de consulta

                else if ($nivCons < 4)

                    $result = 0; //puede ver todos

            } else

            if ($grupo == "cue") {



                if ($niv2 > 0) { //es usuario de franquicia

                    $result = "P"; //devuelvo cuenta y franquicia

                    if ($niv3 > 0) //es usuario por p.v.

                        $result = "PP";

                } else    //puede ver toda la cuenta

                    $result = "F";

            }

        

        return $result;

    }


public function getUsuarioId($id,$tabla){
		$stmt = Conexion::conectar()->prepare("select `cus_usuario`,
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
  `cus_solcer` from $tabla where cus_email=:idusuario");
		$stmt->bindParam("idusuario", $id,PDO::PARAM_STR);		
		$stmt->execute();

		return $stmt->fetch();
		
	}
	
	public static function getUsuariosxGpo($grupo,$tabla){
	    $stmt = Conexion::conectar()->prepare("select `cus_usuario`,
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
  `cus_solcer` from $tabla  WHERE cus_clavegrupo = :op2 ");
	    $stmt->bindParam(":op2", $grupo,PDO::PARAM_STR);
	    $stmt-> execute();
	    
	    return $stmt->fetchAll();
	    
	}

	public static function insertarUsuario($login,$contras, $nomusu, $empresa, $cargo, $tel,$email,$op2,
                $SelectNivel,$select1,$select2,$select3,$select4,$select5,$select6,$idioma,$uscliente,$usservicio, $solcer,$tabla){
                  
                    

                    
                    
	    $sql2 = "INSERT INTO ".$tabla."(cus_usuario,cus_contrasena,cus_nombreusuario,cus_empresa,cus_cargo,cus_telefono,cus_email,cus_clavegrupo,
            cus_tipoconsulta,cus_nivel1,cus_nivel2,cus_nivel3,cus_nivel4,cus_nivel5,cus_nivel6,cus_idioma,
cus_cliente, cus_servicio, cus_solcer)
            VALUES(:login,:contras, :nomusu, :empresa, :cargo, :tel,:email,:op2,
                :SelectNivel,:select1,:select2,:select3,:select4,:select5,:select6,:idioma,:uscliente,:usservicio, 
:solcer)";
	    try{
	    $stmt = Conexion::conectar()->prepare($sql2);
	    $stmt->bindParam(":login", $login,PDO::PARAM_STR);
	    $stmt->bindParam(":contras", $contras,PDO::PARAM_STR);
	    $stmt->bindParam(":nomusu", $nomusu,PDO::PARAM_STR);
	    $stmt->bindParam(":empresa", $empresa,PDO::PARAM_STR);
	    $stmt->bindParam(":cargo", $cargo,PDO::PARAM_STR);
	    $stmt->bindParam(":tel", $tel,PDO::PARAM_STR);
	    $stmt->bindParam(":email", $email,PDO::PARAM_STR);
	    $stmt->bindParam(":op2", $op2,PDO::PARAM_STR);
	    $stmt->bindParam(":SelectNivel", $SelectNivel,PDO::PARAM_INT);
	    $stmt->bindParam(":select1", $select1,PDO::PARAM_INT);
	    $stmt->bindParam(":select2", $select2,PDO::PARAM_INT);
	    $stmt->bindParam(":select3", $select3,PDO::PARAM_INT);
	    $stmt->bindParam(":select4", $select4,PDO::PARAM_INT);
	    $stmt->bindParam(":select5", $select5,PDO::PARAM_INT);
	    $stmt->bindParam(":select6", $select6,PDO::PARAM_INT);
	    $stmt->bindParam(":idioma", $idioma,PDO::PARAM_INT);
	    $stmt->bindParam(":uscliente", $uscliente,PDO::PARAM_STR);
	    $stmt->bindParam(":usservicio", $usservicio,PDO::PARAM_STR);
	    $stmt->bindParam(":solcer", $solcer,PDO::PARAM_STR);
	    
	  if( !$stmt->execute())
	  { 
	      $stmt->debugDumpParams();
	    throw new Exception("Error al crear el usuario");
	  }
	  $stmt->debugDumpParams();
	    }catch(PDOException $ex){
	        throw new Exception("Error al crear el usuario");
	    }
	   
	    
	}

	
	public static function editarUsuario($login,$login_nvo,$contras, $nomusu, $empresa, $cargo, $tel,$email,$op2,
	    $SelectNivel,$select1,$select2,$select3,$select4,$select5,$select6,$idioma,$uscliente,$usservicio, $solcer,$estatus){
	        
	        $sql2 = "UPDATE `cnfg_usuarios`
SET `cus_usuario` = :usuarionvo,
  `cus_contrasena` = :contrasena,
  `cus_nombreusuario` = :nombreusuario,
  `cus_empresa` = :empresa,
  `cus_cargo` = :cargo,
  `cus_telefono` = :telefono,
  `cus_email` = :email,
  `cus_clavegrupo` = :clavegrupo,
  `cus_tipoconsulta` = :tipoconsulta,
  `cus_nivel1` = :nivel1,
  `cus_nivel2` = :nivel2,
  `cus_nivel3` = :nivel3,
  `cus_nivel4` = :nivel4,
  `cus_nivel5` = :nivel5,
  `cus_nivel6` = :nivel6,
  `cus_idioma` = :idioma,
  `cus_cliente` = :cliente,
  `cus_servicio` = :servicio,
  `cus_solcer` = :solcer,
  `cus_estatus` = :estatus 
WHERE `cus_usuario` = :usuario;";
	        try{
	            $stmt = Conexion::conectar()->prepare($sql2);
	            $stmt->bindParam(":usuario", $login);
	            $stmt->bindParam(":usuarionvo", $login_nvo);
	            $stmt->bindParam(":contrasena", $contras);
	            $stmt->bindParam(":nombreusuario", $nomusu);
	            $stmt->bindParam(":empresa", $empresa);
	            $stmt->bindParam(":cargo", $cargo);
	            $stmt->bindParam(":telefono", $tel);
	            $stmt->bindParam(":email", $email);
	            $stmt->bindParam(":clavegrupo", $op2);
	            $stmt->bindParam(":tipoconsulta", $SelectNivel);
	            $stmt->bindParam(":nivel1", $select1);
	            $stmt->bindParam(":nivel2", $select2);
	            $stmt->bindParam(":nivel3", $select3);
	            $stmt->bindParam(":nivel4", $select4);
	            $stmt->bindParam(":nivel5", $select5);
	            $stmt->bindParam(":nivel6", $select6);
	            $stmt->bindParam(":idioma", $idioma);
	            $stmt->bindParam(":cliente", $uscliente);
	            $stmt->bindParam(":servicio", $usservicio);
	            $stmt->bindParam(":solcer", $solcer);
	            $stmt->bindParam(":estatus", $estatus);
	            
	           if(! $stmt->execute())
	               throw new Exception("Error al editar usuario");
	          //  $stmt->debugDumpParams();
	        }catch(PDOException $ex){
	            throw new Exception("Error al editar usuario");
	        }
	        
	        
	}
	
	public static function eliminarUsuario($login,$tabla){
	    $sql2 = "DELETE
FROM ".$tabla."
WHERE `cus_usuario` = :usuario";
	    try{
	        $stmt = Conexion::conectar()-> prepare($sql2);
	        $stmt->bindParam(":usuario", $login);
	    	        
	       if(!$stmt-> execute())
	       throw new Exception("Error al borrar usuario");
	    }catch(PDOException $ex){
	        throw new Exception("Error al borrar usuario");
	    }
	    
	    
	}
	

}



