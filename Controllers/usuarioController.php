<?php
class UsuarioController{

	public function validarUsuarioController(){
		//echo "entre a validar";
		//var_dump(($_POST["g-recaptcha-response"]));

		if(isset($_POST["g-recaptcha-response"]) && ($_POST["g-recaptcha-response"])){
			//echo "entre a validacion de captcha";
						// validar el captcha
			$secret = 	"6Le3cF4UAAAAADqpg_8ZMleTeY35KqegkiR-Gqlb";
			$ip= $_SERVER["REMOTE_ADDR"];

			$captcha=$_POST["g-recaptcha-response"];
		//	echo "captcha".$captcha;
	          
	        //$result = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
	        
			$ch = curl_init();

			curl_setopt_array($ch, [
			    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
			    CURLOPT_POST => true,
			    CURLOPT_POSTFIELDS => [
			        'secret' => $secretKey,
			        'response' => $captcha,
			        'remoteip' => $_SERVER['REMOTE_ADDR']
			    ],
			    CURLOPT_RETURNTRANSFER => true
			]);

			$output = curl_exec($ch);
			curl_close($ch);

			$json = json_decode($output, TRUE);
	       
	       if ($json ["success"]==TRUE)
	       //IF ($json)
	       {
		      // 	echo "si eres humano";
		       		# vamos a validar el mail y el password
	       		$logemail=$_POST["logemail"];
		       	$datoslogController= array("logemail"=>$logemail,
	            			"logpass"=>$_POST["logpass"]); 
		       	//echo $datosController["logemail"];
		       	//echo $datosController["logpass"];
				$respuesta =UsuarioModel::validaUsuarioModel($datoslogController, "cnfg_usuarios");	var_dump($respuesta);		
				if ($respuesta>0) {
				 	 	#actualiza Estatus del usuario
					date_default_timezone_set('America/Mexico_City');
					$ultimacon= date('Y-M-d G:i:s');
					
					$datosController= array("estatus"=>'Conectado',
	            			"horalog"=>$ultimacon,
	            			"emusuario"=>$logemail); 
					
					//$respuesta =UsuarioModel::actualizaLogEntUsuarioModel($datosController, "cnfg_usuarios");


					//echo $respuesta;
					$respuesta =UsuarioModel::consultaUsuarioModel($datoslogController, "cnfg_usuarios");

					$gpo = $respuesta["cus_clavegrupo"];
                	$idioma = $respuesta["cus_idioma"];
                	$cargo=$respuesta["cus_cargo"];
                	$NombreUsuario=$respuesta["cus_usuario"];

				 	 #creamos variables de session
                	 session_start();
   				     $_SESSION['Usuario'] = $logemail;
   				     $_SESSION['GrupoUs'] = $gpo;
   				     $_SESSION['Cargo'] = $cargo;
   						
                	//$ini=UsuarioController::Inicia_Sesion($logemail);
					//$ini=UsuarioController::Guarda_Grupo($gpo);
            		$_SESSION['autentificado'] = 'SI';
            		$_SESSION['NombreUsuario'] = $NombreUsuario;
            		$_SESSION["idiomaus"] = $idioma;
					
					header("location:index.php");
					
				} else {
						echo "El usuario o la contrasena son incorrectos";
				} 	    
	       	 	
	       }  else {
	       		       }
	     } else {

		}  // captcha
	}	

	

	Public Function Obten_Usuario() {
	    @session_start();
	    $Usuario = $_SESSION['Usuario'];
	    //@session_write_close(); 
	    return $Usuario;
	}

	Public Function Obten_NomUsuario() {
	    @session_start();
	    $Usuario = $_SESSION['NombreUsuario'];
	    //@session_write_close(); 
	    return $Usuario;
	}

	Public Function Obten_Grupo() {
    //session_start(); 
    $Grupo = $_SESSION['GrupoUs'];
    // session_unset; 
    return $Grupo;
	}

	Public Function Obten_Cargo() {
    //session_start(); 
    $Cargo = $_SESSION['Cargo'];
    // session_unset; 
    return $Cargo;
	}

	Public Function Destruye_Sesion() {
    @session_start();
    // Destruye todas las variables de la sesi&oacute;n 
    @session_unset();
    // Finalmente, destruye la sesi&oacute;n 
    @session_destroy();
}



}
?>