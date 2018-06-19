<?php

class EnlacesPaginas{
	
	public function enlacesPaginasModel ($enlacesModel){

		If($enlacesModel == "listacliente"  ||
			$enlacesModel == "nuevocliente"  || 
			$enlacesModel == "editacliente" || 
			$enlacesModel == "listaservicio" ||
			$enlacesModel == "nuevoservicio" ||
			$enlacesModel == "editaservicio" || 
			$enlacesModel == "listafranquicia" ||
			$enlacesModel == "nuevafranquicia" ||
			$enlacesModel == "editafranquicia" ||
			$enlacesModel == "listaunegocio" ||
			$enlacesModel == "nuevaunegocio" ||
			$enlacesModel == "nuevaseccion" ||
			$enlacesModel == "listaseccion" ||
			$enlacesModel == "editaseccion" ||
			$enlacesModel == "editapondera" ||
			$enlacesModel == "nuevapondera" ||
			$enlacesModel == "nuevaestandar" ||
			$enlacesModel == "editaestandar" ||
			$enlacesModel == "nuevaabierta" ||
			$enlacesModel == "editaabierta" ||
			$enlacesModel == "nvaabdetalle" ||
			$enlacesModel == "editaabdetalle" ||
			$enlacesModel == "nuevaestdetalle" ||
			$enlacesModel == "editaestdetalle" ||
			$enlacesModel == "nuevageneral" ||
			$enlacesModel == "editageneral" ||
			$enlacesModel == "nuevoproducto" ||
			$enlacesModel == "editaproducto" ||
			$enlacesModel == "ponderaseccion" ||
			$enlacesModel == "listacoment" ||
			$enlacesModel == "nuevocoment" ||
			$enlacesModel == "editacoment" ||
			$enlacesModel == "reactivocoment" ||
			$enlacesModel == "nuevorcoment" ||
			$enlacesModel == "estandarcoment" ||
			$enlacesModel == "nuevoestcoment" ||
			$enlacesModel == "editaestcoment" ||
			$enlacesModel == "ponderareactivo" ||

			#AQUI INICIA SECCION REPORTE	
			$enlacesModel == "rlistaunegocio" ||
			$enlacesModel == "runegociodetalle" ||
			$enlacesModel == "runegociocomp" ||
			$enlacesModel == "editarep" ||

			#AQUI INICIA LA SECCION DE SEGURIDAD
			$enlacesModel == "login" ||			

			#AQUI INICIA SECCION CATALOGOS
			$enlacesModel == "listan1" ||
			$enlacesModel == "listan2" ||
			$enlacesModel == "listan3" ||
			$enlacesModel == "listan4" ||
			$enlacesModel == "listan5" ||
			$enlacesModel == "listan6" ||
			$enlacesModel == "listacuenta" || 
			$enlacesModel == "editacuenta" ||   
			$enlacesModel == "nuevacuenta" 
			){

			$module ="views/modulos/cue_". $enlacesModel.".php";
		}
		else if($enlacesModel == 'sn'){
			// aqui meteremos todas las secciones del cuestionario
			$module ="views/modulos/cue_subnivel.php";	
		}

		else if($enlacesModel == 'rsn'){
			// aqui meteremos todas las secciones del cuestionario
			$module ="views/modulos/cue_reporte.php";	
		}

		else if($enlacesModel == "index"){

			$module = "views/modulos/enlaces.php";
		}

		else if($enlacesModel == "ok"){

			$module = "views/modulos/enlaces.php";
		}

		else if($enlacesModel == "cambio"){

			$module = "views/modulos/cue_listafranquicia.php";
		}
		else{

			$module = "views/modulos/enlaces.php";
		}

		return $module;
	}

}

?>