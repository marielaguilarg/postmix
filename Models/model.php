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
			$enlacesModel == "nuevaponcuenta" ||

		    $enlacesModel == "editaunegocio" ||


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

			$enlacesModel == "nvorep" ||
			
			#AQUI INICIA SECCION muestras	
			$enlacesModel == "anapend" ||
			$enlacesModel == "anarealiza" ||
			$enlacesModel == "estanalisis" ||
			$enlacesModel == "nuevoanalisis" ||
			$enlacesModel == "recepcion" ||
			$enlacesModel == "prueba" ||
			$enlacesModel == "listapruebasdet" ||
			$enlacesModel == "analisisFQ" ||
			$enlacesModel == "listarecepcion" ||
			$enlacesModel == "recepciondetalle" ||
			$enlacesModel == "nuevarecepcion" ||
			$enlacesModel == "nuevaprueba" ||
			$enlacesModel == "nuevarecepciondet" ||

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
			$enlacesModel == "nuevacuenta" || 
			$enlacesModel == "nuevoReporteProducto"||  

			#AQUI INICIA SECCION INDICADORES   
			$enlacesModel == "indgraficaindicadorgrv2" ||
            $enlacesModel == "indgraficaindicadorgr" ||
            $enlacesModel == "indestadisticares"  ||
            $enlacesModel == "indindicadoresgrid"  ||
            $enlacesModel == "indcumplimientoestabl" ||
            $enlacesModel == "indindicadores" ||
            $enlacesModel == "indbuscapv" ||
            $enlacesModel == "indhistorialreportes"  ||
            $enlacesModel == "indresultadosxrep"|| 
            $enlacesModel == "indrepdiario" ||
            $enlacesModel == "indrepxperiodo"  ||
            $enlacesModel == "indhistoricoxpv"  ||
			$enlacesModel == "indcumplimientoestabl" ||
			$enlacesModel == "indestadisticares"  ||
			$enlacesModel == "indgraficares" ||
			$enlacesModel == "indgraficaindicadorgr" ||
			$enlacesModel == "indhistorialreportes" ||
			$enlacesModel == "indhistoricoxpv" ||
			$enlacesModel == "indindicadoresgrid" ||
			$enlacesModel == "indrepdiario" ||
			$enlacesModel == "indrepxperiodo" ||
			$enlacesModel == "indresultadosxrep" ||
			$enlacesModel == "indresumenresultados" ||
		    
            $enlacesModel == "indconsultaponderada" ||
            $enlacesModel == "indconsultaabiertadetalle" ||
            $enlacesModel == "indconsultaestandar" ||
            $enlacesModel == "indconsultasecciones" ||
            $enlacesModel == "indlistasecciones" ||
		   
		    $enlacesModel == "indconsultageneral" ||
			$enlacesModel == "indgraficaaplica" ||
			$enlacesModel == "indgraficacomportamiento" ||
			$enlacesModel == "indgraficacumplimiento" ||
			$enlacesModel == "indgraficacumplimientoaj" ||
            $enlacesModel == "indgraficafrecuencia"  ||
		    $enlacesModel == "indgraficapromediojarabe"  ||
		    //ligas a certificacion
		    $enlacesModel == "editasolicitud" ||
		    $enlacesModel == "listasolicitudes" ||
		    $enlacesModel == "listacertificados"||
		    $enlacesModel == "listaestatussolicitud"||
		    
		    //seccion de consultas
		    $enlacesModel=="inicio_excel"||
            $enlacesModel=="repfacturacion" ||
		    $enlacesModel=="listafacturas"||
			$enlacesModel=="consultaResultados"||
			$enlacesModel=="resultadosxrep"||
			$enlacesModel=="listaconsultaRep"||
			$enlacesModel=="resumenresultados"||
		    //seccion de configuracion
		    $enlacesModel=="slistagrupos"||
		    $enlacesModel=="slistapermisos" ||
		    $enlacesModel=="slistausuarios"||
		    $enlacesModel=="snuevogrupo"||
		    $enlacesModel=="snuevopermiso" ||
		    $enlacesModel=="snuevousuario"||
		    $enlacesModel=="srangosgraffrec"||
		    $enlacesModel=="ssecciongrafica" ||
		    $enlacesModel=="snuevorango"||
		    $enlacesModel=="ssurveydata"||
		    $enlacesModel=="snuevosd"||
		    $enlacesModel=="seditasd"||
		    $enlacesModel=="srespaldoimagenes"||
		    $enlacesModel=="srestaurarimagen"||
		    $enlacesModel=="seditasd"
		    
			 
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
