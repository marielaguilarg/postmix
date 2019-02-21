<?php
class SubnivelController{


	public function vistasubseccionController(){
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];
			//echo $seccion;

		if (isset($_GET["ts"])) {
			switch($_GET["ts"]) {
			case "G" : 	       
			
		      $ingreso = new GeneralController();
		      $ingreso -> borrageneralController();
			  $ingreso -> vistaGeneralController();
			  break;
			case "E" : 	       
		      $ingreso = new EstandarController();
		      $ingreso ->borrarEstandarController();
			  $ingreso -> vistaEstandarController();
			  break;
			case "ED" : 	       
		      $ingreso = new EstandarController();
			  $ingreso -> borrarEstandarDetController();
			  $ingreso -> vistaEstDetController();
			  break;
		    case "P" :
		       $ingreso = new PonderacionController();
			   $ingreso -> borrarPonderaController();
			   $ingreso -> vistaPonderaController();
		       break;
		    case "PN" :
		       $ingreso = new PonderacionController();
			  // $ingreso -> borrarPonderaController();
			   $ingreso -> vistaConsultaPonderaController();
		       break;
		   case "SN" :
		       $ingreso = new seccionController();
			  // $ingreso -> borrarPonderaController();
			   $ingreso -> vistaConsultaPonderaSeccionController();
		       break;
		  
		    case "A" :  
		       $ingreso = new abiertaController();
			   $ingreso ->borrarAbiertaController(); 
			   $ingreso -> vistaAbiertaController();   
		       break;
		    case "AD" :       
		       $ingreso = new abiertaController();
			   $ingreso ->borrarAbiertaDetController();  
			   $ingreso -> vistaAbDetController();
		       break;
		    case "V" :       
		       $ingreso = new ProductoController();
			   $ingreso -> borraProductoController();  
			   $ingreso -> vistaProductoController();
		       break;
		       
		    default:
		    	
		        $i=1;
				$nnivel=0;
				$idsecc='';
				 while ($i <= 10) {
					$datini=SubnivelController::obtienedato($seccion,$i);
					$londat=SubnivelController::obtienelon($seccion,$i);
					if (isset($datini)) {
					 	$nusec=substr($seccion,$datini,$londat);
					 	$idsecc=$idsecc.$nusec;
					 
						if ($nusec) {
							$nnivel++;
						}
					}	
					$i++;
				 }  

				$numsec=$idsecc;
				
				$nivel=$nnivel;

				echo '   <table class="table" table-condensed>
		                <tr>
		                  <th >TIPO DE SECCION</th> 
		                </tr>';

				
				$respuesta = DatosSubnivel::vistaNivelModel($nivel, "cnfg_menutipos");
  				//echo $respuesta;
  				foreach($respuesta as $row => $item){
  					echo '<tr><td><a href="index.php?action=sn&sec='.$numsec.'&sv='.$servicioController.'&ts='.$item["tip_clave"].'">'.$item["tip_descripcion"].'</a>
	              </td></tr>';
				}	
				echo '</table>';
			}
	  			#crea titulo y subtitulo
		    }  // if
		
	}


public function obtienelon($cadreferencia,$numdato){
 /*calculo de numero de servicio que se encuentra en la poscion 2 */
$lonref=strlen($cadreferencia);
   if ($lonref!=0) {
		$datoact=1;
		$ncardato=0;
//		$numdato=2;
		$numpos=0;
		$londato=0;
		$band=0;
		while ($numpos<$lonref) {
		   $caract=substr($cadreferencia,$numpos,1);
		   if ($datoact==$numdato){
		      if ($caract!=".") {
			     if ($band==0){
				    $datoini=$numpos;
					$band=1;
				 }		 
			     $londato=$londato+1;
			  }else{
			  	 $datoact=$datoact+1;
			  }	 
		   }else{ 
		       if ($caract==".") {
			      if ($band==0){
		             $datoact=$datoact+1;
					}else{
					break;
					} 
				}  
			} 
			$numpos=$numpos+1;
			
		}
		return $londato;
   } 
   }





public function obtienedato($cadreferencia,$numdato){
 /*calculo de numero de servicio que se encuentra en la poscion 2 */
$lonref=strlen($cadreferencia);
   if ($lonref!=0) {
		$datoact=1;
		$ncardato=0;
//		$numdato=2;
		$numpos=0;
		$londato=0;
		$band=0;
		while ($numpos<$lonref) {
		   $caract=substr($cadreferencia,$numpos,1);
		   if ($datoact==$numdato){
		      if ($caract!=".") {
			     if ($band==0){
				    $datoini=$numpos;
					$band=1;
				 }		 
			     $londato=$londato+1;
			  }else{
			  	 $datoact=$datoact+1;
			  }	 
		   }else{ 
		       if ($caract==".") {
			      if ($band==0){
		             $datoact=$datoact+1;
					}else{
					break;
					} 
				}  
			} 
			$numpos=$numpos+1;
			
		}
		if (isset($datoini))
		   return $datoini;
		   
		
	}
   

}

 public function cambiaf_a_normal($fecha){
 	$patrones = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/',
                   '/^\s*{(\w+)}\s*=/');

	$sustitución = array ('\4/\3/\1\2', '$\1 =');	
	return preg_replace($patrones, $sustitución, $fecha);

	}



 public function mysql_fecha($fecha)	//pasa la fecha de a/m/d a formato m/d/y
   {
   		
   	
   		$nva_fecha=explode('-',$fecha);
		
		return $nva_fecha[1].'-'.$nva_fecha[2].'-'.$nva_fecha[0];
	
   }

 public function fecha_mysql($fecha)	//pasa la fecha de a/m/d a formato m/d/y
   {
   		
   	
   		$nva_fecha=explode('/',$fecha);
		
		return $nva_fecha[2].'/'.$nva_fecha[0].'/'.$nva_fecha[1];
	
   }





public function vistaNombresubseccionController(){

			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];
			$tiposeccion=$_GET["ts"];

		switch($_GET["ts"]) {
		case "G" : 	       
	# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_descripcionesp"]. '</a></li>';
		    break;
		case "E" : 	       
			# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
			#determina el nivel
		    $i=1;
			$nnivel=0;
			$idsecc='';
			 while ($i <= 10) {
				 $datini=SubnivelController::obtienedato($seccion,$i);
				 $londat=SubnivelController::obtienelon($seccion,$i);
				 if (isset($datini)) {
				 $nusec=substr($seccion,$datini,$londat);
				 $idsecc=$idsecc.$nusec;
				 
				 if ($nusec) {
					$nnivel++;
				}
				}	
				 $i++;
			 }  

			$numsec=$idsecc;
			
			$nivel=$nnivel;
			echo $nivel;
			switch($nivel) {
			case 1 :
				$respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

			    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
			    break;
			case 2 :
        	# coloca subtitulo de seccion
        	 	$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);
			 	

		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($numsec, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    break;
		    #busca ultimo nivel en ponderada
			//$respuesta2 = DatosSeccion::vistaNombreSeccionEstModel($numsec,$servicioController, $numreac, "cue_reactivos");
			//echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=P"><em class="fa fa-dashboard"></em>REACTIVO: '.$respuesta2["r_descripcionesp"]. '</a></li>';
			case 3 :
        	# coloca subtitulo de seccion
        	 	$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);
 	
 				$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);
						 	

		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($numsec, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    
		    #busca ultimo nivel en ponderada
			$respuesta2 = DatosSeccion::vistaNombreSeccionEstModel($numsec,$servicioController, $numreac, $numcom, "cue_reactivosestandar");
			echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=P">REACTIVO: '.$respuesta2["r_descripcionesp"]. '</a></li>';
		    }
			  break;
		case "P" : 	       
		# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
		    
		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    break;
		case "PN" : 	       
		# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
		    
		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=sn&sec='.$seccion.'&ts=P&sv='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    break;
		case "SN" : 	       
		# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
		    
		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=sn&sec='.$seccion.'&ts=P&sv='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    break;
		
		case "V" : 	       
		# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
			  break;
		case "A" : 	       
		# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
			#determina el nivel
		    $i=1;
			$nnivel=0;
			$idsecc='';
			 while ($i <= 10) {
				 $datini=SubnivelController::obtienedato($seccion,$i);
				 $londat=SubnivelController::obtienelon($seccion,$i);
				 if (isset($datini)) {
				 $nusec=substr($seccion,$datini,$londat);
				 $idsecc=$idsecc.$nusec;
				 
				 if ($nusec) {
					$nnivel++;
				}
				}	
				 $i++;
			 }  

			$numsec=$idsecc;
			
			$nivel=$nnivel;
			//echo $nivel;
			switch($nivel) {
			case 1 :
				$respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

			    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
				break;	
			case 2 :
        	# coloca subtitulo de seccion
        	 	$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);	

		    	$respuesta1 = DatosSeccion::vistaNombreSeccionModel($numsec, $servicioController,"cue_secciones");

		    	echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		   		 #busca ultimo nivel en ponderada
		   		$respuesta2 = DatosSeccion::vistaNombreSeccionPondModel($numsec,$servicioController, $numreac, "cue_reactivos");
				echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=P">REACTIVO: '.$respuesta2["r_descripcionesp"]. '</a></li>';
			  	break;
			 }  // fin de switch nivel 
			 break;	
		case "AD" : 	       
			# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
			#determina el nivel
		    $i=1;
			$nnivel=0;
			$idsecc='';
			 while ($i <= 10) {
				 $datini=SubnivelController::obtienedato($seccion,$i);
				 $londat=SubnivelController::obtienelon($seccion,$i);
				 if (isset($datini)) {
				 $nusec=substr($seccion,$datini,$londat);
				 $idsecc=$idsecc.$nusec;
				 
				 if ($nusec) {
					$nnivel++;
				}
				}	
				 $i++;
			 }  

			$numsec=$idsecc;
			
			$nivel=$nnivel;
			echo $nivel;
			switch($nivel) {
			case 1 :
				$respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

			    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
				break;	
			case 2 :
        	# coloca subtitulo de seccion
        	 	$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);	

                $datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);	

		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($numsec, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    #busca ultimo nivel en ponderada
		    $respuesta2 = DatosSeccion::vistaNombreSeccionPondModel($numsec,$servicioController, $numreac, "cue_reactivos");
			//echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=P"><em class="fa fa-dashboard"></em>REACTIVO: '.$respuesta2["r_descripcionesp"]. '</a></li>';
					    	#nivel tres
			$respuesta3 = DatosSeccion::vistaNombreSeccionAbModel($numsec,$servicioController, $numreac, $numcom, "cue_reactivosabiertos");
			echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'.'.$numreac.'&ts=A">COMPONENTE: '.$respuesta3["ra_descripcionesp"]. '</a></li>';
			    
			  break;
			case 3 :
        	# coloca subtitulo de seccion
        	 	$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);	

			 	$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);	

		    	$respuesta1 = DatosSeccion::vistaNombreSeccionModel($numsec, $servicioController,"cue_secciones");

		    	echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    #busca ultimo nivel en ponderada
		    	$respuesta2 = DatosSeccion::vistaNombreSeccionPondModel($numsec,$servicioController, $numreac, "cue_reactivos");
				echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=P">REACTIVO: '.$respuesta2["r_descripcionesp"]. '</a></li>';
		    
		    	#nivel tres
				$respuesta3 = DatosSeccion::vistaNombreSeccionAbModel($numsec,$servicioController, $numreac, $numcom, "cue_reactivosabiertos");
				echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'.'.$numreac.'&ts=A">COMPONENTE: '.$respuesta3["ra_descripcionesp"]. '</a></li>';
		    

			  break;  
			} // fin del switch de nivel
			break;
		case "ED" : 	       
			# busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio"><em class="fa fa-dashboard"></em>SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
			#determina el nivel
		    $i=1;
			$nnivel=0;
			$idsecc='';
			 while ($i <= 10) {
				 $datini=SubnivelController::obtienedato($seccion,$i);
				 $londat=SubnivelController::obtienelon($seccion,$i);
				 if (isset($datini)) {
				 $nusec=substr($seccion,$datini,$londat);
				 $idsecc=$idsecc.$nusec;
				 
				 if ($nusec) {
					$nnivel++;
				}
				}	
				 $i++;
			 }  

			$numsec=$idsecc;
			
			$nivel=$nnivel;
			//echo 'nivel '. $nivel;
			switch($nivel) {
			case 1 :
				$respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

			    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
				break;	
			case 2 :
        	# coloca subtitulo de seccion
        	 	$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);	

				$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);	

		    	$respuesta1 = DatosSeccion::vistaNombreSeccionModel($numsec, $servicioController,"cue_secciones");

		    	echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    	#busca ultimo nivel en estandar
		   		$respuesta2 = DatosSeccion::vistaNombreSeccionEstModel($numsec, $servicioController, $numreac, $numcom, "cue_reactivosestandar");
				//echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=P">REACTIVO: '.$respuesta2["re_descripcionesp"]. '</a></li>';
		        echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=E">REACTIVO: '.$respuesta2["re_descripcionesp"]. '</a></li>';
		    
			  	break;
			case 3 :
        		# coloca subtitulo de seccion
        	 	$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);	

			 	$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);	

		    	$respuesta1 = DatosSeccion::vistaNombreSeccionModel($numsec, $servicioController,"cue_secciones");

		    	echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    #busca ultimo nivel en ponderada
		    	$respuesta2 = DatosSeccion::vistaNombreSeccionPondModel($numsec,$servicioController, $numreac, "cue_reactivos");
				echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'&ts=E">REACTIVO: '.$respuesta2["r_descripcionesp"]. '</a></li>';
		    
		    	#nivel tres
				$respuesta3 = DatosSeccion::vistaNombreSeccionEstModel($numsec,$servicioController, $numreac, $numcom, "cue_reactivosestandar");
				echo '<li><a href="index.php?action=sn&sv='.$servicioController.'&sec='.$numsec.'.'.$numreac.'&ts=A">COMPONENTE: '.$respuesta3["re_descripcionesp"]. '</a></li>';
		    

			  break;
			  
				} // fin de switch nivel
				break;

 default:
			  # busca nombre del servicio
		    $respuesta = DatosSeccion::vistaNombreServModel($servicioController,"ca_servicios");
		    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
			# busca nombre de seccion
		    
		    $respuesta1 = DatosSeccion::vistaNombreSeccionModel($seccion, $servicioController,"cue_secciones");

		    echo '<li><a href="index.php?action=listaseccion&idser='.$servicioController.'">SECCION: '.$respuesta1["sec_nomsecesp"]. '</a></li>';
		    break;
			 
		}// fin de switch  tipo 
	}
}
