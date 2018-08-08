<?php
class abiertaController{

	public function vistaabiertaController(){
		//lee numero de seccion y numero de servicio
	if (isset($_GET["sec"])) {
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];

	echo '<div class="row">
    <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px;"><a href="index.php?action=nuevaabierta&id='.$seccion.'&ids='.$servicioController.'&sec='.$seccion.'&sv='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
     </div>
     </div>';
		
		# calcula numero de nivel
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
    	# crea titulo de la opcion (nombre del servicio)
		# crea opciones
		$tiposec="A";
		//echo $nivel;
  		 switch($nivel) {
		 case 1 :
		 #crea subtitulo
		 # actualiza tipo de reactivo
			 
			 $respuesta =DatosAbierta::actualizatiporeac($numsec, $servicioController,$tiposec, "cue_secciones");
			 /* Genera clave para consulta de reaactivos */
			 $datini=SubnivelController::obtienedato($seccion,1);
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $numsec=substr($seccion,$datini,$londat);
			 $datini=SubnivelController::obtienedato($seccion,2);
			 $londat=SubnivelController::obtienelon($seccion,2);
			 $numreac=substr($seccion,$datini,$londat);
			  if (($numreac)){
			 	
			 }else{
			 	$numreac=0;
			 }
			 $numcom=0;
			 $numcar=0;
			 $numcom2=0;
					
			 $numseccon=$numsec.$numreac.$numcar.$numcom2;
					//echo $numseccon;
			 $nvaseccion=$numsec.".".$numreac;
			 $seccion=$nvaseccion;

			$respuesta =DatosAbierta::vistaAbiertaModeln1($servicioController, $numseccon,"cue_reactivosabiertos");
			//echo $respuesta1;
			//echo $respuesta["ra_descripcionesp"];
			$numeros=$seccion;
			break;
		case 2 :
			# busca subtitulo de nivel
			# actualiza tipo de reactivo
			 $respuesta =DatosAbierta::actualizatiporeacn2($numsec, $servicioController,$tiposec, "cue_reactivos");
			 $datini=SubnivelController::obtienedato($seccion,1);
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $numsec=substr($seccion,$datini,$londat);
			 $datini=SubnivelController::obtienedato($seccion,2);
			 $londat=SubnivelController::obtienelon($seccion,2);
			 $numreac=substr($seccion,$datini,$londat);
			 $numcom=0;
		     $numcar=0;
		     $numcom2=0;

		     $numseccon=$numsec.$numreac.$numcar.$numcom2;

			$respuesta =DatosAbierta::vistaAbiertaModeln1($servicioController, $numseccon,"cue_reactivosabiertos");
			 
			$numeros=$seccion;
			
			break;
		case 3:
		 	 $datini=SubnivelController::obtienedato($seccion,1);
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $numsec=substr($seccion,$datini,$londat);
			 $datini=SubnivelController::obtienedato($seccion,2);
			 $londat=SubnivelController::obtienelon($seccion,2);
			 $numreac=substr($seccion,$datini,$londat);
			 $datini=SubnivelController::obtienedato($seccion,3);
			 $londat=SubnivelController::obtienelon($seccion,3);
			 $numcom=substr($seccion,$datini,$londat);
			 $datini=SubnivelController::obtienedato($seccion,6);
			 $londat=SubnivelController::obtienelon($seccion,6);
			 $numcar=substr($seccion,$datini,$londat);
			
			 $numcom2=0;
			 
			 $numseccon=$idsec.$numreac.$numcom.$numcar;

			 #crea subtitulo


			 $numeros=$seccion;
		 	 $respuesta =DatosAbierta::actualizatiporeacn3($numsec, $servicioController,$tiposec, "cue_reactivos");
		
			 $respuesta =DatosAbierta::vistaAbiertaModeln3($servicioController, $numseccon,"cue_reactivosabiertos");
			
			 # actualiza de acuerdo al tipo
			 if ($tiposec=="A") {
			 	#actualiza titulo
			 	#actualiza tipo de reactivo en nivel 6
			 	 $respuesta =DatosAbierta::actualizatiporeacn6a($numsec, $servicioController,$tiposec, "cue_reactivosabiertosdetalle");
			 	 #actualiza direccionde retorno
		     } else if ($tiposec=="P") {
		     	# actualiza titulo
		     	# actualiza tipo de ractivo a nivel 6
		     	 $respuesta =DatosAbierta::actualizatiporeacn6a($numsec, $servicioController,$tiposec, "cue_reactivosabiertosdetalle");
		     	 #actualiza direccionde retorno
		     } else  if ($tiposec=="E") {
		     	# actualiza titulo
		     	# actualiza tipo de ractivo a nivel 6
		     	 $respuesta =DatosAbierta::actualizatiporeacn6e($numsec, $servicioController,$tiposec, "cue_reactivosestandardetalle");
		     	 #actualiza direccionde retorno	 
			 
			 }	// if

	 		$numsec=$numseccon;
			$seccion=$idsec.".".$numreac.".".$numcom.".".$numcar;
			$numeros=$idsec.".".$numreac.".".$numcom.".".$numcar;
			break;
		case 6:
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $numsec=substr($seccion,$datini,$londat);

			 $datini=SubnivelController::obtienedato($seccion,2);
			 $londat=SubnivelController::obtienelon($seccion,2);
			 $numreac=substr($seccion,$datini,$londat);
			 
			 $datini=SubnivelController::obtienedato($seccion,3);
			 $londat=SubnivelController::obtienelon($seccion,3);
			 $numcom=substr($seccion,$datini,$londat);
			 $numseccon=$numsec;
			  if ($tiposec=="A") {
			  	# crea subtitulo
			 	# actualiza tipo de reactivo nivel 6
				 $respuesta =DatosAbierta::actualizatiporeacn6a($numsec, $servicioController,$tiposec, "cue_reactivosabiertosdetalle");
			  } else if ($tiposec=="P") {
			  		# crea subtitulo
			  		# actualiza tipo de reactivo nivel 3
			  		$respuesta =DatosAbierta::actualizatiporeacn6a($numsec, $servicioController,$tiposec, "cue_reactivosabiertosdetalle");
			  	
			  }	else if ($tiposec=="E") {
			  		# crea subtitulo
			  		# actualiza tipo de reactivo nivel 3
			  		$respuesta =DatosAbierta::actualizatiporeacn6e($numsec, $servicioController,$tiposec, "cue_reactivosestandardetalle");
			  	    # realiza boton de regresar
			  
			  }	// if	
	 		$respuesta =DatosAbierta::vistaAbiertaModeln3($servicioController, $numseccon,"cue_reactivosabiertos");
			 	 #busca el nombre del componente
	 		$numsec=$numseccon;
	 		break;

				} // switch
		 
			//busca la info
			//$respuesta =DatosAbierta::vistaAbiertaModel($servicioController, $seccion,"cue_reactivosabiertos");

			// presenta info
			echo 	'<section class="content container-fluid">
			<div class="box">
		 			<div class="box-body no-padding">
		              <table class="table" table-condensed>
		                <tr>
		                  <th style="width: 5%">No.</th>
		                  <th style="width: 36%">COMPONENTES</th>
		                   	<th style="width: 10%">CARACTERISTICAS</th>
		                	<th style="width: 10%">BORRAR</th>
		                </tr>';

		     $i=1;
		    // echo $respuesta;
			foreach($respuesta as $row => $item){
				// determina numero de componente
				switch($nivel) {
				 case 1 :  $componente =$item["ra_numcomponente"];
				   break;
				 case 2 :  $componente =$item["ra_numcomponente"];
				   break;
				 case 3 :  $componente =$item["ra_numcomponente2"];
				   break;  
				 case 6 :  $componente =$item["ra_numcomponente2"];
				   break;
				  }
				  //echo $componente;
				echo '  <tr>
	              <td>'.$componente.'</td>
	              <td><a href="index.php?action=editaabierta&sec='.$numeros.".".$componente.'&sv='. $item["ser_claveservicio"].'&ts=A">'.$item["ra_descripcionesp"].'</a>
	              </td>
	              <td><a href="index.php?action=sn&sec='.$numeros.".".$componente.'&sv='. $item["ser_claveservicio"].'&ts=AD">Detalle</a>
	              </td>
	                  
	               <td><a href="index.php?action=sn&ids='.$numeros.".".$componente.'&sv='. $item["ser_claveservicio"].'&ts=A&sec='.$item["sec_numseccion"].'">Borrar</a>
	              </td>
	                </tr>';
	            $i++;  
			}
		
            echo  ' </table>
            </div>
           </div>
         
</section>';


	}

	}


//presenta la info

public function nuevaAbiertaController(){
    
$datosController = $_GET["id"];
$servicioController = $_GET["ids"];

    
   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
          
}
	
public function registrarAbiertaController(){              
	if(isset($_POST["nombreesp"])){
	      $datosServicio=$_POST["idser"];
	      $seccion=$_POST["idsec"];
	
	# calcula numero de nivel
		$i=1;
		$nnivel=0;
		$idsecc='';
		 while ($i <= 6) {
//		 	 $registro = New SubnivelController();
 //            $registro-> nuevaEstandarController();
			 $datini=SubnivelController::obtienedato($seccion,$i);
			 //echo $datini;
			 $londat=SubnivelController::obtienelon($seccion,$i);
			 //echo $londat;
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
// de acuerdo al nivel es la clave que busca
 		 switch($nivel) {
		 case 1:
		   // genera clave para ingreso de reactivo
			 $datini=SubnivelController::obtienedato($seccion,1);
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $numsec=substr($seccion,$datini,$londat);
			 $numreac=0;
			 $numcar=0;
			 $numcom2=0;
					
			 $numseccon=$numsec.$numreac.$numcar.$numcom2;

			 // busca el ultimo componente
			 $respuesta =DatosAbierta::CalculaultimaabiertaModel($datosServicio, $numseccon, "cue_reactivosabiertos");
				
			 $numcom=$respuesta["clavecomp"]+1;
			 

			 // debemos crear nivel en tabla reactivo
			 if ($numcom==1){
			 	$respuesta =DatosEst::Creanivelreactivo($datosServicio, $seccion, $numreac, "cue_reactivos");
			 }
			 
			 break;
		case 2:
			// genera clave para ingreso de reactivo
			$datini=SubnivelController::obtienedato($seccion,1);
			$londat=SubnivelController::obtienelon($seccion,1);
			$numsec=substr($seccion,$datini,$londat);

			$datini=SubnivelController::obtienedato($seccion,2);
			$londat=SubnivelController::obtienelon($seccion,2);
			$numreac=substr($seccion,$datini,$londat);
			$numcar=0;
			$numcom2=0;				
			$numseccon=$numsec.$numreac.$numcar.$numcom2;
			
			// busca el ultimo componente
			 $respuesta =DatosAbierta::CalculaultimaabiertaModel($datosServicio, $numseccon, "cue_reactivosabiertos");
				
			 $numcom=$respuesta["clavecomp"]+1;
			
			 break;
		case 3:	 
		// genera clave para ingreso de reactivo
			$datini=SubnivelController::obtienedato($seccion,1);
			$londat=SubnivelController::obtienelon($seccion,1);
			$numsec=substr($seccion,$datini,$londat);

			$datini=SubnivelController::obtienedato($seccion,2);
			$londat=SubnivelController::obtienelon($seccion,2);
			$numreac=substr($seccion,$datini,$londat);
			
			$datini=SubnivelController::obtienedato($seccion,3);
			$londat=SubnivelController::obtienelon($seccion,3);
			$numcom=substr($seccion,$datini,$londat);

			$datini=SubnivelController::obtienedato($seccion,6);
			$londat=SubnivelController::obtienelon($seccion,6);
			$numcar=substr($seccion,$datini,$londat);
			
			$numseccon=$idsec.$numreac.$numcom.$numcar;

			// busca el ultimo componente
			 $respuesta =DatosAbierta::CalculaultimaAbierta3Model($datosServicio, $numseccon, "cue_reactivosabiertos");
				
			 $numcom2=$respuesta["clavecomp"]+1;
			 break;
		 case 6:	
		    $datini=SubnivelController::obtienedato($seccion,1);
			$londat=SubnivelController::obtienelon($seccion,1);
			$numsec=substr($seccion,$datini,$londat);

			$datini=SubnivelController::obtienedato($seccion,2);
			$londat=SubnivelController::obtienelon($seccion,2);
			$numreac=substr($seccion,$datini,$londat);
			
			$datini=SubnivelController::obtienedato($seccion,3);
			$londat=SubnivelController::obtienelon($seccion,3);
			$numcom=substr($seccion,$datini,$londat);

			$datini=SubnivelController::obtienedato($seccion,4);
			$londat=SubnivelController::obtienelon($seccion,4);
			$numcar=substr($seccion,$datini,$londat);

			//$datini=SubnivelController::obtienedato($seccion,5);
			//$londat=SubnivelController::obtienelon($seccion,5);
			//$numcom2=substr($seccion,$datini,$londat);

			$datini=SubnivelController::obtienedato($seccion,6);
			$londat=SubnivelController::obtienelon($seccion,6);
			$numcar2=substr($seccion,$datini,$londat);	

			$numseccon=$numsec.$numreac.$numcom.$numcar2;
			$respuesta =DatosAbierta::CalculaultimaAbierta3Model($datosServicio, $numseccon, "cue_reactivosabiertos");
				
			$numcom2=$respuesta["clavecomp"]+1;
			 
		} // switch

			// insertamos en tabla abierta


			$datosController= array("idser"=>$datosServicio,
      						   "idsec"=>$numsec,
                               "numreac"=>$numreac,
                               "numcom"=>$numcom,
                               "numcar"=>$numcar,
                               "numcom2"=>$numcom2,
                               "desesp"=>$_POST["nombreesp"],
                               "desing"=>$_POST["nombreing"],
                               ); 

          #inserta para los tres primeros niveles

          if($nivel==1 or $nivel==2 or $nivel==3){
 			$respuesta =DatosAbierta::insertaabierta13($datosController, "cue_reactivosabiertos");
 		  } else {
 		  	$datosController= array("idser"=>$datosServicio,
	      						   "idsec"=>$numsec,
	                               "numreac"=>$numreac,
	                               "numcom"=>$numcom,
	                               "numcar2"=>$numcar2,
	                               "numcom2"=>$numcom2,
	                               "desesp"=>$_POST["nombreesp"],
	                               "desing"=>$_POST["nombreing"],
	                              ); 

			$respuesta =DatosAbierta::insertaabierta6($datosController, "cue_reactivosabiertos");	
		  
          } // fin del if
          	echo $respuesta;
			if($respuesta== "success"){
          		echo "
	          <script type='text/javascript'>
	              window.location.href='index.php?action=sn&sec=".$seccion."&ts=A&sv=".$datosServicio."'
	              </script>
	                ";
          	//header("location:index.php?action=ok");
        	}	
		}	 

	}	


	public function editarAbiertaController(){
		    
		    $seccion = $_GET["sec"];
		    $idservicio = $_GET["sv"];
	   
	   	   echo '<input type="hidden" name="idsec" value="'.$seccion.'">';
		   echo '<input type="hidden" name="idser" value="'.$idservicio.'">';

		 # calcula numero de nivel
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
			#crea variable segun nivel
			switch($nivel) {
			case 2 :  /*primer nivel */
			     $datini=SubnivelController::obtienedato($seccion,1);
				 $londat=SubnivelController::obtienelon($seccion,1);
				 $numsec=substr($seccion,$datini,$londat);
				 $numreac=0;
				 $datini=SubnivelController::obtienedato($seccion,3);
				 $londat=SubnivelController::obtienelon($seccion,3);
				 $numcom=substr($seccion,$datini,$londat);
				 $numcar=0;
				 $numcom2=0;
					
				 $numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;
				 break;
			case 3 :  /*primer nivel */
			    $numreac=0;
				$numcom=0;
				$numcar=0;
				$numcom2=0;
						
				$numseccon=$numsec.$numcar.$numcom2;
				
				break;
			case 5 :  		
				$numseccon=$numsec;
				break;				
			} // switch
			#lee datos con seccion
			$respuesta =DatosAbierta::EditaAbiertaModel($idservicio,$numseccon, "cue_reactivosabiertos");
			echo '<label >NOMBRE EN ESPAÑOL</label>
               
                   <div class="col-sm-10">
                    <input name="nombreesp" id="nombreesp" class="form-control" value="'.$respuesta["ra_descripcionesp"].'">
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >NOMBRE EN INGLES</label>
               <div class="col-sm-10">
                    <input name="nombreing" id="nombreing" class="form-control" value="'.$respuesta["ra_descripcioning"].'">
                </div>
                </div>';	
	}

	public function actualizaAbiertaController(){
		 if(isset($_POST["nombreesp"])){
	 		$seccion = $_POST["idsec"];
		    $idservicio = $_POST["idser"];

		  # calcula numero de nivel
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
			
			#crea variable segun nivel
			switch($nivel) {
			case 2 :  /*primer nivel */
			     $datini=SubnivelController::obtienedato($seccion,1);
				 $londat=SubnivelController::obtienelon($seccion,1);
				 $numsec=substr($seccion,$datini,$londat);
				 $numreac=0;
				 $datini=SubnivelController::obtienedato($seccion,3);
				 $londat=SubnivelController::obtienelon($seccion,3);
				 $numcom=substr($seccion,$datini,$londat);
				 $numcar=0;
				 $numcom2=0;
					
				 $numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;
				 break;
			case 3 :  /*primer nivel */
			    $numreac=0;
				$numcom=0;
				$numcar=0;
				$numcom2=0;
						
				$numseccon=$numsec.$numcar.$numcom2;
				
				break;
			case 5 :  		
				$numseccon=$numsec;
				break;				
			} // switch

			$datosController= array("idser"=>$idservicio,
      						   "idsec"=>$numseccon,
                               "desesp"=>$_POST["nombreesp"],
                               "desing"=>$_POST["nombreing"],
                              ); 
		$respuesta = DatosAbierta::actualizaabierta($datosController,"cue_reactivosabiertos");
    	if($respuesta== "success"){

          		echo "<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$seccion."&ts=A&sv=".$idservicio."';
				</script>
				";


          	//header("location:index.php?action=ok");
        	} else {
        		echo "error";
        	} 


		 } //if
	} // function

	public function borrarAbiertaDetController(){
		//echo "entre a borrarabdet";
		if(isset($_GET["ids"])){
	      $seccion = $_GET["ids"];
		  $servicioController = $_GET["sv"];

		    $respuesta = DatosAbierta::borraAbiertaDetModel($seccion, $servicioController, "cue_reactivosabiertosdetalle");// echo $respuesta;
		}
	}		



	public function borrarAbiertaController(){
	    if(isset($_GET["ids"])){
	      $seccion = $_GET["ids"];
		  $servicioController = $_GET["sv"];
		# calcula numero de nivel
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
	 

	switch($nivel) {
		case 2 :  /*primer nivel */
		     $numcar=0;
			 $numcom2=0;
			 $numseccon=$numsec.$numcar.$numcom2;

		     $datini=SubnivelController::obtienedato($seccion,1);
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $nsec=substr($seccion,$datini,$londat);
			 $datini=SubnivelController::obtienedato($seccion,2);
        	 $londat=SubnivelController::obtienelon($seccion,2);
        	 $nreac=substr($seccion,$datini,$londat);
			 break;
 		case 3:
			$numcar=0;
			$numcom2=0;
			$datini=SubnivelController::obtienedato($seccion,1);
			$londat=SubnivelController::obtienelon($seccion,1);
			$nsec=substr($seccion,$datini,$londat);
			$datini=SubnivelController::obtienedato($seccion,2);
        	$londat=SubnivelController::obtienelon($seccion,2);
        	$nreac=substr($seccion,$datini,$londat);
				
			$numseccon=$numsec.$numcar.$numcom2;
			break;
 		case 5:
			$numseccon=$numsec;
			break;
	}	// switch	 
	$respuesta = DatosAbierta::borraabiertaModel($numseccon, $servicioController,"cue_reactivosabiertos");
	}  // if	  
	

	} // function

	public function vistaAbDetController(){

		if (isset($_GET["sec"])) {
				$seccion = $_GET["sec"];
				$servicioController = $_GET["sv"];
		# boton de nuevo
			echo '<div class="row">
    <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px;"><a href="index.php?action=nvaabdetalle&id='.$seccion.'&ids='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
     </div>
     </div>';	
     # calcula numero de nivel
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
			  		
			#trabaja con nivel
			switch($nivel) {
            case 2:
             	$numcar=0;
                $numcom2=0;
                $datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);
			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);
			 	$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);
			 	$numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;
			 	//$numsec_orig.=".".$numcar.".".$numcom2;
			 	#crea subititulo
			 	#crea regresar
			 	break;
			 case 3:
				$numcar=0;
				$numcom2=0;	
				$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);
			 	
			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);
			 	
			 	$numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;
			 	//$numseccon=$numsec.$numcar.$numcom2;
				//$numsec_orig=".".$numcar.".".$numcom2;
				#crea subititulo
			 	#crea regresar
			 	break;
			 case 5:	
				$numseccon=$numsec;
				#crea subititulo
			 	#crea regresar
				break;			
        	} // fin del switch 
        	# lee info
        	
        	$respuesta =DatosAbierta::vistaAbDetModel($servicioController, $numseccon, "cue_reactivosabiertosdetalle");

        		echo 	'<section class="content container-fluid">
			<div class="box">
		 			
		              <table class="table" table-condensed>
		                <tr>
		                  <th style="width: 5%">No.</th>
		                  <th style="width: 36%">CARACTERISTICA</th>
		                  	<th style="width: 15%">INCLUYE EN ARCHIVO</th>
		                	<th style="width: 15%">SUBNIVEL</th>
		                	<th style="width: 10%">BORRAR</th>
		                </tr>';
       			foreach($respuesta as $row => $item){
				echo '  <tr>
	              <td>'.$item["rad_numcaracteristica2"].'</td>
	              <td><a href="index.php?action=editaabdetalle&id='.$numseccon.$item["rad_numcaracteristica2"].'&ids='.$item["ser_claveservicio"].'&sa='.$seccion.'">'.$item["rad_descripcionesp"].'</a>
	              </td>
	                  
	                  <td>
	                    <a href="#">';
	                    if ($item["rad_syd"]==0){
	                    	$incluye="NO";
	                    } else {
	                    	$incluye="SI";
	                    }
	                    echo $incluye.'</a>
	                  </td>
	                  <td><a href="index.php?action=sn&sec='.$numseccon.$item["rad_numcaracteristica2"].'&sv='.$item["ser_claveservicio"].'&ts='.$item["rad_tiporeactivo"].'">subnivel</a>
	              </td>
	                <td><a href="index.php?action=sn&ids='.$numseccon.$item["rad_numcaracteristica2"].'&sv='.$item["ser_claveservicio"].'&ts=AD&sec='.$seccion.'">borrar</a>
	              </td>
	                </tr>';
	            $i++;  
			}
		
            echo  ' </table>
            </div>
           </div>
         
</section>';

		} // if isset

	} // function


	public function nuevaAbdetController(){
    
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];

    
   		echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
   		echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
          
	}

	public function listacatalogosController(){
    
		$respuesta =DatosAbierta::listacatalogosModel("ca_catalogos");

  		foreach($respuesta as $row => $item){

      		echo '<option value='.$item["ca_idcatalogo"].'>'.$item["ca_nombrecatalogo"].'</option>';

    	}   
          
	}


	public function registraabdetController(){
	  if(isset($_POST["descesp"])){
		      $idServicio=$_POST["idser"];
		      $seccion=$_POST["idsec"];
		
		# calcula numero de nivel
			$i=1;
			$nnivel=0;
			$idsecc='';
			 while ($i <= 6) {
	//		 	 $registro = New SubnivelController();
	 //            $registro-> nuevaEstandarController();
				 $datini=SubnivelController::obtienedato($seccion,$i);
				 //echo $datini;
				 $londat=SubnivelController::obtienelon($seccion,$i);
				 //echo $londat;
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
	// de acuerdo al nivel es la clave que busca
	 		 switch($nivel) {
			 case 1:
				$numreac=0;
	 	   		$numcar=0;
		   		$numcom2=0;
		   		$idcom=0;
				$numcar=0;
				$idcom2=0;
					
				 $numseccon=$numsec.$numreac.$numcar.$numcom2;

				$datosController= array("idser"=>$idServicio,
      						   "idsec"=>$seccion,
                               "numreac"=>$numreac,
                              ); 
				$respuesta = DatosAbierta::insertareac1($datosController,"cue_reactivos");
    			
				$idseccomp=$idsecc.$idreac.$idcom.$numcar.$idcom2;
				$datosController= array("idser"=>$idservicio,
      						    "idsec"=>$seccion,
                                "numreac"=>$numreac,
                                "numcom"=>$idcom,
								"numcar"=>$numcar,
								"idcom2"=>$idcom2,
								 ); 
				 
				$respuesta = DatosAbierta::insertareacab1($datosController, "cue_reactivosabiertos");
				$respuesta = DatosAbierta::buscaultimoreacabdet($idServicio, $idseccomp, "cue_reactivosabiertosdetalle");
				if (isset($respuesta["clavecomp"])) {
					 $numcar2=$respuesta["clavecomp"];
				} else {
					$numcar2=0;
				}
				$numcar=$numcar+1;
				break;
			case 2:
				$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);
			 	
			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);

			 	$numcar=0;
				$numcom2=0;

				$numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;

			$respuesta = DatosAbierta::buscaultimoreactivo($numseccon,$idServicio,"cue_reactivosabiertosdetalle");
			  // $respuesta = DatosAbierta::buscaultimoreacabdet($idServicio, $numseccon, "cue_reactivosabiertosdetalle");
				if (isset($respuesta["numcar2"])) {
					$i==0;
			  		foreach($respuesta as $row => $item){
	     				$i=$i+1;

	    			}
	    		}	   
				//echo $i;

				if ($i>0) {
					foreach($respuesta as $row => $item){
					   $numcar2=$item["numcar2"];
					 	}   
				} else {
					$numcar2=0;
				}
				
				$numcar2=$numcar2+1;
				        		//echo "el valor de i es".$i
				//$numcar2++;
				//echo $numcar2;
				if ($numcar2==1){ // si es el primer registro
					$datosController= array("idser"=>$idServicio,
      						   "idsec"=>$seccion,
                               "numreac"=>$numreac,
                              ); 
					$respuesta = DatosAbierta::insertareac1($datosController,"cue_reactivos");
    			}
    			break;
  			case 3:	
			   $numcar=0;
			  // $idcom2=0;
				$datini=SubnivelController::obtienedato($seccion,1);
			 	$londat=SubnivelController::obtienelon($seccion,1);
			 	$numsec=substr($seccion,$datini,$londat);
			 	
			 	$datini=SubnivelController::obtienedato($seccion,2);
			 	$londat=SubnivelController::obtienelon($seccion,2);
			 	$numreac=substr($seccion,$datini,$londat);

			 	$datini=SubnivelController::obtienedato($seccion,3);
			 	$londat=SubnivelController::obtienelon($seccion,3);
			 	$numcom=substr($seccion,$datini,$londat);

			 	$numcom2=0;
            
			   //$numseccom =$numsec.$numcar.$idcom2;

				$numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;

				$respuesta = DatosAbierta::buscaultimoreactivo($numseccon,$idServicio,"cue_reactivosabiertosdetalle");
			  // $respuesta = DatosAbierta::buscaultimoreacabdet($idServicio, $numseccon, "cue_reactivosabiertosdetalle");
				if (isset($respuesta["clavecomp"])) {
					$i==0;
			  		foreach($respuesta as $row => $item){
	     				$i=$i+1;

	    			}
	    		}	   
				//echo $i;

				if ($i>0) {
					foreach($respuesta as $row => $item){
					   $numcar2=$item["numcar2"];
					 	}   
				} else {
					$numcar2=0;
				}
				
				$numcar2=$numcar2+1;
				//echo $numcar2;
			
			 	$numcom2=0;
            	break;
            case 5:
		    	$idseccomp=$numsec;
		    	$respuesta = DatosAbierta::buscaultimoreacabdet($idServicio, $numseccon, "cue_reactivosabiertosdetalle");

				if (isset($respuesta["clavecomp"])) {
					 $numcar2=$respuesta["clavecomp"];
				} else {
					$numcar2=0;
				}
				$numcar2=$numcar2+1;
				$numsec=substr($idseccomp,0,1);
				$numreac=substr($idseccomp,1,1);
				$numcom=substr($idseccomp,2,1);
				$numcar=substr($idseccomp,3,1);
				$numcom2=substr($idseccomp,4,1);			
				break;		
			} //switch
			/*crea valores para syd */
			
			$descesp=$_POST["descesp"];
			$descing=$_POST["descing"];
			$formato=$_POST["tiporeac"];
			$numcatalogo=$_POST["nomcat"];
			$valmin=$_POST["valmin"];
			$valmax=$_POST["valmax"];
			if (isset($_POST["indsyd"])) {
				$sydata=-1;
			} else {
				$sydata=0;
			}				
			$lugsurdat=$_POST["lugarsyd"];

			if ($lugsurdat){
		       $sydludata=$lugsurdat;
		    }else{	 
		    	$sydludata=0;
		    }
			

		 	/*crea valores de formato */
		 	
			switch($formato) {
			case "C":
			    $ncat=$numcatalogo;
				$vmin=0;
				$vmax=0;
				break;	
			case 'N':
			    $ncat=0;
				if ($valmin) {
				   $vmin=$valmin;
				}else{
	 		       $vmin=0;
				}   
				if ($valmax) {
				   $vmax=$valmax;
				}else{
				   $vmax=0;
				}   
				break;
			default:
			    $ncat=0;
				$vmin=0;
				$vmax=0;		
			}	
			  
			$datosController= array("idser"=>$idServicio,
      						   "idsec"=>$numsec,
                               "numreac"=>$numreac,
                               "numcom"=>$numcom,
      						   "numcar"=>$numcar,
                               "idcom2"=>$numcom2,
                               "numcar2"=>$numcar2,
      						 
      						   "desesp"=>$descesp,
                               "desesp2"=>$descing,
                               "sydata"=>$sydata,
      						   "sydludata"=>$sydludata,
                               "formato"=>$formato,

                               "ncat"=>$ncat,
      						   "vmin"=>$vmin,
                               "vmax"=>$vmax,
                              );
            $respuesta = DatosAbierta::insertaabiertadetalle($datosController,"cue_reactivosabiertosdetalle");
            if ($respuesta=="success"){

			echo "
				<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$seccion."&ts=AD&sv=".$idServicio."';
				</script>
				";
		}  else {
			echo "error";
		}                 
		} // if general	
	}	

	public function botonRegresaabdetController(){
	    
		$sec = $_GET["id"];
		$ser = $_GET["ids"];

	   echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$sec.'&ts=AD&sv='.$ser.'"> Cancelar </a></button>
	';

	}

	public function botonRegresaabdetEController(){
	    
		$sec = $_GET["sa"];
		$ser = $_GET["ids"];

	   echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$sec.'&ts=AD&sv='.$ser.'"> Cancelar </a></button>
	';

	}

	public function EditaAbiertaDetController(){
	    $secori = $_GET["sa"];
		$seccion = $_GET["id"];
		$idservicio = $_GET["ids"];

	   	   echo '<input type="hidden" name="idsec" value="'.$seccion.'">';
		   echo '<input type="hidden" name="idser" value="'.$idservicio.'">';
		   echo '<input type="hidden" name="secori" value="'.$secori.'">';

		$respuesta =DatosAbierta::EditaAbiertaDetModel($seccion,$idservicio, "cue_reactivosabiertosdetalle");
		
		//foreach($respuesta as $row => $item){
		echo  '<div class="form-group col-md-6">
          <label>DESCRIPCION EN ESPAÑOL</label>
          <input type="text" class="form-control" name="descesp" value="'.$respuesta["rad_descripcionesp"].'">
        </div>
        <div class="form-group col-md-6">
          <label>DESCRIPCION EN INGLES</label>
          <input type="text" class="form-control" name="descing" value="'.$respuesta["rad_descripcioning"].'" >
        </div>

         <div class="form-group col-md-6">
          <label>FORMATO DE REACTIVO</label>
          <select class="form-control" name="tiporeac">
          <option value="">--- Elija el formato ---</option>';
          /*asignas catalogo */
		  $TFORM=$respuesta["rad_formatoreactivo"];
		  if ($TFORM=="F"){
		     $op1="<option value='F' selected='selected'>Fecha</option>";
		  } else {
		     $op1="<option value='F'>Fecha</option>";
		  }
		  if ($TFORM=="H"){
		     $op2="<option value='H' selected='selected'>Hora</option>";
		  } else {
		     $op2="<option value='H'>Hora</option>";
		  }
		  if ($TFORM=="C"){
		     $op3="<option value='C' selected='selected'>Catalogo</option>";
		  } else {
		     $op3="<option value='C'>Catalogo</option>";
		  }
		  if ($TFORM=="N"){
		     $op4="<option value='N' selected='selected'>Numerico</option>";
		  } else {
		     $op4="<option value='N'>Numerico</option>";
		  }
		  if ($TFORM=="T"){
		     $op5="<option value='T' selected='selected'>Texto</option>";
		  } else {
		     $op5="<option value='F'>Texto</option>";
		  }
		  if ($TFORM=="E"){
		     $op6="<option value='E' selected='selected'>Check List</option>";
		  } else {   
		     $op6="<option vale='E'>Check List</option>";
		    
		  }

		  echo $op1.$op2.$op3.$op4.$op5.$op6;
		  echo '
          </select>
                       </div>
                       <div class="form-group col-md-6">
          <label>CATALOGO (SOLO EN CASO DE FORMATO CATALOGO)</label>';
          $TCAT=$respuesta['rad_clavecatalogo'];
          
          echo '<select class="form-control" name=nomcat>
          <option value="">--- Elija el catalogo ---</option>';
          
          $respuesta1 =DatosAbierta::listacatalogosModel("ca_catalogos");

  		foreach($respuesta1 as $row => $iteml){
  			if ($TCAT==$iteml['ca_idcatalogo']){
  				echo '<option value='.$iteml["ca_idcatalogo"].' selected="selected">'.$iteml["ca_nombrecatalogo"].'</option>';
  			} else {	
      			echo '<option value='.$iteml["ca_idcatalogo"].'>'.$iteml["ca_nombrecatalogo"].'</option>';
      		}
    	}   
    	echo '	   </select>
                </div>

                <div class="form-group col-md-6">
                  <label>VALOR MINIMO (SOLO EN CASO DE FORMATO NUMERICO)</label>
                  <input type="text" class="form-control" name="valmin" value="'.$respuesta['rad_valorminimo'].'">
                </div>
                <div class="form-group col-md-6">
                  <label>VALOR MAXIMO (SOLO EN CASO DE FORMATO NUMERICO)</label>
                  <input type="text" class="form-control" name="valmax" value="'.$respuesta['rad_valormaximo'].'">
                </div>

                <div class="form-group col-md-6">
                <label >INCLUYE EN ARCHIVO</label>';

				if ($respuesta['rad_syd']!=0) {
					   echo "<input name='syd' type='checkbox' checked>";
				}else{
				   		echo "<input name='syd' type='checkbox'>";
				} 
                echo '</div>
                <div class="form-group col-md-6">
                <label >LUGAR</label>
                    <input name="lugarsyd" id="lugarsyd" class="form-control" value="'.$respuesta['rad_lugarsyd'].'">
                </div>
               ';

        //}

	}


	public function actualizaAbiertaDetalleController(){
		if (isset($_POST["descesp"])) {
		  $secori=$_POST["secori"];
	      $datosServicio=$_POST["idser"];
	      $seccion=$_POST["idsec"];
	      $descesp=$_POST["descesp"];
	      $descing=$_POST["descing"];
	      $formato=$_POST["tiporeac"];
	      $nomcat=$_POST["nomcat"];
	      $valmin=$_POST["valmin"];
	      $valmax=$_POST["valmax"];
	      $syd=$_POST["syd"];
	      $lugsurdat=$_POST["lugarsyd"];
	      
		//valida syd
		if ($syd) {
		   $sydata=-1;
		 }else{
		   $sydata=0;
		 }
		   
	     if ($lugsurdat){
	        $sydludata=$lugsurdat;
	     }else{	 
	        $sydludata=0;
	     }
		
		
		/*crea valores de formato */
  	    switch($formato) {
		case "C":
		    $ncat=$nomcat;
			$vmin=0;
			$vmax=0;
			break;	
		case 'N':
		    $ncat=0;
			$vmin=$valmin;
			$vmax=$valmax;
			break;
		default:
		    $ncat=0;
			$vmin=0;
			$vmax=0;		
					
		} //switch		

	      $datosController= array("desesp"=>$descesp,
	      						  "desesp2"=>$descing,
	      						  "sydata"=>$sydata,
	                              "sydludata"=>$sydludata,
	                              "formato"=>$formato,
	                              "ncat"=>$ncat,
	                              "vmin"=>$vmin,
	                              "vmax"=>$vmax,
	                              "seccion"=>$seccion,
	                              "idser"=>$datosServicio,
	                               ); 
	      $respuesta = DatosAbierta::actualizaAbiertaDetalleModel($datosController, "cue_reactivosabiertosdetalle");
	      		if ($respuesta=="success"){

			echo "
				<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$secori."&ts=AD&sv=".$datosServicio."';
				</script>
				";
		}

		} // if
	} // function

	public function reporteAbiertaDetalleController(){
		#lee varia{bles
		$idser=$_GET["sv"];
		$seccion=$_GET["sec"];
		$nrep=$_GET["nrep"];
		$pv=$_GET["pv"];
		$idc=$_GET["idc"];

		$datini=SubnivelController::obtienedato($seccion,1);
	 	$londat=SubnivelController::obtienelon($seccion,1);
	 	$numsec=substr($seccion,$datini,$londat);
	 
	 	$datini=SubnivelController::obtienedato($seccion,2);
	 	$londat=SubnivelController::obtienelon($seccion,2);
	 	$numreac=substr($seccion,$datini,$londat);
			 
  	    $datini=SubnivelController::obtienedato($seccion,3);
	 	$londat=SubnivelController::obtienelon($seccion,3);
	 	$numcom=substr($seccion,$datini,$londat);
	 
	 	$datini=SubnivelController::obtienedato($seccion,4);
	 	$londat=SubnivelController::obtienelon($seccion,4);
	 	$numcar=substr($seccion,$datini,$londat);
	 
	 	$datini=SubnivelController::obtienedato($seccion,5);
	 	$londat=SubnivelController::obtienelon($seccion,5);
	 	$numcom2=substr($seccion,$datini,$londat);

	 	if (($numreac)){

	 	} else {
	 		$numreac=0;
	 	}

		if (($numcar)){

	 	} else {
	 		$numcar=0;
	 	}

		if (($numcom2)){

	 	} else {
	 		$numcom2=0;
	 	}

	 	#despliega contenido

	 	$respuesta =DatosAbierta::calculaNumRen($idser, $seccion, $nrep, "ins_detalleabierta");
	 	
	 	foreach ($respuesta as $key => $item) {
	 		$nren=$item["claveren"];
	 		# busca detalle
	 		
	 		echo '
		<div class="col-md-6" >
          <div class="box box-info" >
            <div class="box-header with-border">
            <h3 class="box-title">No.'. $nren.'</h3>

              <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>


                <div class="box-body no-padding">';

			$respDet =DatosAbierta::vistaReporteAbiertoDetalle($idser, $seccion, $nrep, $nren, "ins_detalleabierta");
	 		#presenta info
	 		foreach ($respDet as $key => $itemDet) {

                echo ' <div class="form-group col-md-12">
            <div class="row">
            <ul class="nav nav-stacked">
           <li><a href="#"><strong>'.$itemDet["rad_descripcionesp"].'</strong>';

				$tipocat=$itemDet["rad_formatoreactivo"];
		        $numcat=$itemDet["rad_clavecatalogo"];
		        $valop=$itemDet["ida_descripcionreal"];
		        switch ($tipocat) {
		            case "C" :
		                $rowca=DatosCatalogo::opcionSelCatalogo($numcat, $valop, "ca_catalogosdetalle");
		                	//var_dump($rowca);
		                    $valreal=$rowca["cad_descripcionesp"];
		               
		                break;
		            default:
		                $valreal=$valop;
		        }



           echo ' :  '.$valreal. '</a></li>
           </ul>
                  </div>
                </div>';
            }
             echo ' </div>
              </div>
            </div>
  </section>';
	 	}


	}


	public function botonRegresaAbController(){		
	    
		$seccion = $_GET["sec"];
		$ser = $_GET["sv"];
		# calcula nivel
		$idsecc='';
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
		 $nivel=$nnivel;
		 switch($nivel) {
		 case 2 :
			$datini=SubnivelController::obtienedato($seccion,1);
	 		$londat=SubnivelController::obtienelon($seccion,1);
	 		$numsec=substr($seccion,$datini,$londat);
	 		 $nsec=$numsec;
	 	 case 3 :
			$datini=SubnivelController::obtienedato($seccion,1);
	 		$londat=SubnivelController::obtienelon($seccion,1);
	 		$numsec=substr($seccion,$datini,$londat);

	 		$datini=SubnivelController::obtienedato($seccion,2);
	 		$londat=SubnivelController::obtienelon($seccion,2);
	 		$numreac=substr($seccion,$datini,$londat);
	 		$nsec=$numsec.".".$numreac;	
	 	 }	


	   echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$nsec.'&ts=A&sv='.$ser.'"> Cancelar </a></button>
	';

	}


public function reporteAbiertaController(){
		#lee varia{bles
		$idser=$_GET["sv"];
		$seccion=$_GET["sec"];
		$nrep=$_GET["nrep"];
		$pv=$_GET["pv"];
		$idc=$_GET["idc"];

		$datini=SubnivelController::obtienedato($seccion,1);
	 	$londat=SubnivelController::obtienelon($seccion,1);
	 	$numsec=substr($seccion,$datini,$londat);
	 
	 	$datini=SubnivelController::obtienedato($seccion,2);
	 	$londat=SubnivelController::obtienelon($seccion,2);
	 	$numreac=substr($seccion,$datini,$londat);
			 
  	    $datini=SubnivelController::obtienedato($seccion,3);
	 	$londat=SubnivelController::obtienelon($seccion,3);
	 	$numcom=substr($seccion,$datini,$londat);
	 
	 	$datini=SubnivelController::obtienedato($seccion,4);
	 	$londat=SubnivelController::obtienelon($seccion,4);
	 	$numcar=substr($seccion,$datini,$londat);
	 
	 	$datini=SubnivelController::obtienedato($seccion,5);
	 	$londat=SubnivelController::obtienelon($seccion,5);
	 	$numcom2=substr($seccion,$datini,$londat);

	 	if (($numreac)){

	 	} else {
	 		$numreac=0;
	 	}

		if (($numcar)){

	 	} else {
	 		$numcar=0;
	 	}

		if (($numcom2)){

		// foreach
	 	} else {
	 		$numcom2=0;
	 	}


	 	#presenta encabezado
	 		echo '<section class="content container-fluid">

		      <!----- Inicia contenido ----->
		      
		        <div class="row">
		        	 <div class="col-md-12">
		          <div class="box">
		            <div class="box-header">
		              <h3 class="box-title"></h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body no-padding">
		              <table class="table">
		                <tr>
		                  <th style="width: 26%">SUBSECCIONES</th>
                    	</tr>';
	
	 	#presenta reactivos
	 	if ($numreac!=0) {
	 		#obtiene reactivos a segundo nivel
  			$respuesta=DatosAbierta::vistaAbiertareactivo($idser, $seccion, "cue_reactivosabiertos");
  			
  			foreach ($respuesta as $key => $item) {

			echo "<tr><td>
                <a href='index.php?action=rsn&sec=".$seccion.".".$item["ra_numcomponente"].".".$numcar.".".$numcom2."&ts=AD&sv=".$idser.".&nrep=".$nrep."&pv=".$pv."&idc=".$idc."'>".$item["ra_descripcionesp"]."</a></td></tr>";
            }    	
	 	}else{
	   		if ($numcar==0) {
	   			//echo "entre a numcar 0";
	   			//$secc=$seccion.".".$numreac.".".$numcar.".".$numcom2;
				
	   			$respuesta=DatosAbierta::vistaAbiertaNumcar($idser, $seccion, "cue_reactivosabiertos");
			} else{
				//echo "entre a else numcar";
	       		$secc=$seccion.".".$numcom.".".$numcar;

	   			$respuesta=DatosAbierta::vistaAbiertaRepGral($idser, $secc, "cue_reactivosabiertos");
	   		}

	   		foreach ($respuesta as $key => $item) {
	  			if (($numcom)) { 
	  				//echo "estoy en numcom";
				echo "<tr><td>
	                <a href='index.php?action=rsn&sec=".$seccion.".".$item["ra_numcomponente2"].".".$numcar.".".$numcom2."&ts=AD&sv=".$idser."&nrep=".$nrep."&pv=".$pv."&idc=".$idc."'>".$item["ra_descripcionesp"]."</a></td></tr>";
	         
	            } else {
	            	//echo "no hay numcom";
	            	echo "<tr><td>
	                <a href='index.php?action=rsn&sec=".$seccion.".".$numreac.".".$item["ra_numcomponente"].".".$numcar.".".$numcom2."&ts=AD&sv=".$idser."&nrep=".$nrep."&pv=".$pv."&idc=".$idc."'>".$item["ra_descripcionesp"]."</a></td></tr>";
	        
	            }	// if numcom
            } // foreach otro
		}	// if numreac
		                  	
		                
				echo '</table>	

		            </div>
		          </div>
		          <!-- /.box -->
		        </div>
		        			  <!----- Finaliza contenido ----->
		    </section>
		    <!-- /.content -->';

//	}

}







}

?>