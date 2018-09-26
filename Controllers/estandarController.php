
<?php

require_once "Controllers/subnivelController.php";

class EstandarController{

	public function editarEstandarController(){
		
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

		$respuesta = DatosEst::EditaEstModel($idservicio,$numseccon,"cue_reactivosestandar");
		
		echo '<label >NOMBRE EN ESPAÑOL</label>
			   
				   <div class="col-sm-10">
					<input name="nombreesp" id="nombreesp" class="form-control" value="'.$respuesta["re_descripcionesp"].'">
				</div>
				</div>
				<div class="form-group col-md-6">
				 <label >NOMBRE EN INGLES</label>
			   <div class="col-sm-10">
					<input name="nombreing" id="nombreing" class="form-control" value="'.$respuesta["re_descripcioning"].'">
				</div>
				</div>
				<div class="form-group col-md-6">
				 <label >TIPO DE EVALUACION</label>
			   
					<select class="form-control" name="tipoeval" id="tipoeval" >
					<option value="">-- Elija el tipo de evaluacion  --</option>';

					if ($respuesta["re_tipoevaluacion"]==0)	{
						echo '<option value=0 selected>Ninguna</option>';
					} else {
						echo '<option value=0>Ninguna</option>';
					}
					if ($respuesta["re_tipoevaluacion"]==1)	{
						echo '<option value=1 selected>Una linea</option>';
					} else {
						echo '<option value=1>Una linea</option>';
					}
					if ($respuesta["re_tipoevaluacion"]==2)	{
						echo '<option value=2 selected>Multilinea</option>';
					} else {
						echo '<option value=2>Multilinea</option>';
					}	
				  echo '</select>
				</div>';
	}         
   
	public function actualizaEstandarController(){
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

		# DE ACUERDO AL NIVEL ES LA CLAVE QUE BUSCA
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
		case 3:
			$numcar=0;
			$numcom2=0;
					
			$numseccon=$numsec.$numcar.$numcom2;
			break;
		case 5:
			$numseccon=$numsec;
			break;		 
		}	 // switch

		#prepara informacion
		$datosController= array("idser"=>$idservicio,
							   "idsec"=>$numseccon,
							   "desesp"=>$_POST["nombreesp"],
							   "desing"=>$_POST["nombreing"],
							   "tipoeval"=>$_POST["tipoeval"],
							  ); 
		$respuesta = DatosEst::actualizaestandar($datosController,"cue_reactivosestandar");
			if($respuesta== "success"){

				echo "<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$numsec."&ts=E&sv=".$idservicio."';
				</script>
				";


			//header("location:index.php?action=ok");
			} else {
				echo "error";
			} 
	}	
	}

	public function vistaEstandarController(){
		//lee numero de seccion y numero de servicio

		if (isset($_GET["sec"])) {
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];


	 echo '<div class="row">
		<div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px;"><a href="index.php?action=nuevaestandar&id='.$seccion.'&ids='.$servicioController.'&sec='.$seccion.'&sv='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>   Nuevo  </a></button>
		 </div>
		 </div>

		</section>';

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

		$tiposec="E";
		switch($nivel) {
		case 1 :
			# coloca subtitulo de seccion
			# actualiza tipo de reactivo
			 $respuesta =DatosEst::actualizatiporeac($numsec, $servicioController,$tiposec, "cue_secciones");
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
			 //echo $numseccon;
			 $datosController= $seccion;
			 $respuesta =DatosEst::vistaEstandarModeln1($servicioController, $numseccon,"cue_reactivosestandar");
			# configura regresa
			$numeros=$seccion;
			break;
		case 2 :
		   #busca subtitulos
		   #actualiza tiposec

			 $numcom=0;
			 $numcar=0;
			 $numcom2=0;
			 $datini=SubnivelController::obtienedato($seccion,1);
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $numsec=substr($seccion,$datini,$londat);
			 $datini=SubnivelController::obtienedato($seccion,2);
			 $londat=SubnivelController::obtienelon($seccion,2);
			 $numreac=substr($seccion,$datini,$londat);
			 $numseccon=$numsec.$numreac.$numcar.$numcom2;
			 //$numseccon=$numsec.$numcar.$numcom2;
			 //echo $numseccon;
			 $respuesta =DatosEst::actualizatiporeacn2($numseccon,$servicioController,$tiposec,"cue_reactivosestandar");
			 //echo $numseccon;
			 $respuesta =DatosEst::vistaEstandarModeln1($servicioController, $numseccon,"cue_reactivosestandar");
			
			 $numeros=$seccion;
			 break;
		case 3 :
		   #busca subtitulos
		   #actualiza tiposec
			 $datini=SubnivelController::obtienedato($seccion,1);
			 $londat=SubnivelController::obtienelon($seccion,1);
			 $idsec=substr($seccion,$datini,$londat);
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
			 $numcar2=0;

			 $numseccon=$idsec.$numreac.$numcom.$numcar2.$numcom2.$numcar;

				 #crea subtitulo
				  if ($tiposec=="A") {
					 #crea subtitulo
					$respuesta =DatosEst::actualizatiporeacn3($numseccon, $servicioController, $tiposec, "cue_reactivosabiertosdetalle");
					# regresar
				  } else if ($tiposec=="P") {
					# actualiza titulo
					# actualiza tipo de ractivo a nivel 6
					 $respuesta =DatosEst::actualizatiporeacn3($numsec, $servicioController,$tiposec, "cue_reactivosabiertosdetalle");
					 #actualiza direccionde retorno
				 } else  if ($tiposec=="E") {
					# actualiza titulo
					# actualiza tipo de ractivo a nivel 6
					 $respuesta =DatosEst::actualizatiporeacn6e($numsec, $servicioController,$tiposec, "cue_reactivosestandardetalle");
					 #actualiza direccionde retorno	 
				 
				 }	// if
				# crea seleccion de registros
				$respuesta =DatosEst::vistaEstandarModeln2($servicioController, $numseccon,"cue_reactivosestandar");
				
				$numsec=$numseccon;
				$numeros=$idsec.".".$numreac.".".$numcom.".".$numcar;
				break;
			 case 4 :
			 #actualiza tiposec
				 $datini=SubnivelController::obtienedato($seccion,1);
				 $londat=SubnivelController::obtienelon($seccion,1);
				 $idsec=substr($seccion,$datini,$londat);
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
				 $numcar2=0;

				 $numseccon=$idsec.$numreac.$numcom.$numcar2.$numcom2.$numcar;

				 #crea subtitulo
				 #actualiza tipo de reactivo 
				  if ($tiposec=="A") {
					 #crea subtitulo
					$respuesta =DatosEst::actualizatiporeacn3($numseccon, $servicioController, $tiposec, "cue_reactivosabiertosdetalle");
					# regresar
				  } else if ($tiposec=="P") {
					# actualiza titulo
					# actualiza tipo de ractivo a nivel 6
					 $respuesta =DatosEst::actualizatiporeacn3($numsec, $servicioController,$tiposec, "cue_reactivosabiertosdetalle");
					 #actualiza direccionde retorno
				 } else  if ($tiposec=="E") {
					# actualiza titulo
					# actualiza tipo de ractivo a nivel 6
					 $respuesta =DatosEst::actualizatiporeacn6e($numsec, $servicioController,$tiposec, "cue_reactivosestandardetalle");
					 #actualiza direccionde retorno	 
				 
				 }	// if
				 $respuesta =DatosEst::vistaEstandarModeln2($servicioController, $numseccon,"cue_reactivosestandar");
				 $numsec=$numseccon;
				 $numeros=$idsec.".".$numreac.".".$numcom.".".$numcar;
				 break;
			  case 6 :	 
				#
				 $datini=SubnivelController::obtienedato($seccion,1);
				 $londat=SubnivelController::obtienelon($seccion,1);
				 $idsec=substr($seccion,$datini,$londat);
				 $datini=SubnivelController::obtienedato($seccion,2);
				 $londat=SubnivelController::obtienelon($seccion,2);
				 $numreac=substr($seccion,$datini,$londat);
				 $datini=SubnivelController::obtienedato($seccion,3);
				 $londat=SubnivelController::obtienelon($seccion,3);
				 $numcom=substr($seccion,$datini,$londat);
				 $numseccon=$numsec;

				 if ($numreac==0) {
					#busca tipo
					 $respuesta =DatosEst::buscatiposec($servicioController,$idsec,"cue_secciones");
					 if (isset($respuesta["sec_tiposeccion"]))
						$tiposec=$respuesta["sec_tiposeccion"];
					 
				 }else{
					 $respuesta =DatosEst::buscatiporeac($servicioController,$idsec,$numreac,"cue_reactivos");	
				 }	 // if
				#actualiza tipo de reactivo 
				  if ($tiposec=="A") {
					 #crea subtitulo
					$tipoact="E";
					$respuesta =DatosEst::actualizatiporeacn3($numseccon, $servicioController, $tipoact, "cue_reactivosabiertosdetalle");
					# regresar
				  } else if ($tiposec=="P") {
					# actualiza titulo
					# actualiza tipo de ractivo a nivel 6
					$tipoact="E";
					 $respuesta =DatosEst::actualizatiporeacn3($numsec, $servicioController,$tipoact, "cue_reactivosabiertosdetalle");
					 #actualiza direccionde retorno
				 } else  if ($tiposec=="E") {
					# actualiza titulo
					# actualiza tipo de ractivo a nivel 6
					 $respuesta =DatosEst::actualizatiporeacn6e($numsec, $servicioController,$tiposec, "cue_reactivosestandardetalle");
					 #actualiza direccionde retorno	 
				 
				 }	// i
				 $numreac=substr($numsec,1,1);
				 $numcom=substr($numsec,2,1);
				 $numcar=substr($numsec,3,1);
				 $numcom2=substr($numsec,4,1);
				 $numcar2=substr($numsec,5,1);

				 $numseccon=$idsec.$numreac.$numcom.$numcar2;
				 $respuesta =DatosEst::vistaEstandarModeln2($servicioController, $numseccon,"cue_reactivosestandar");
			  }  //switch	
  
			//busca la info
			$respuesta =DatosEst::vistaEstModel($servicioController, $datosController,"cue_reactivosestandar");

			// presenta info
			echo 	'<section class="content container-fluid">
			<div class="box">
					
					  <table class="table" table-condensed>
						<tr>
						  <th style="width: 5%">No.</th>
						  <th style="width: 36%">DESCRIPCION</th>
						  <th style="width: 15%">DETALLE</th>
							<th style="width: 15%">COMENTARIO</th>
							<th style="width: 10%">BORRAR</th>
						</tr>';

			
			foreach($respuesta as $row => $item){
				switch($nivel) {
				case 1 :  $componente =$item["re_numcomponente"];
				  // echo $item["re_numcomponente"];
					break;
				case 2 :  $componente =$item["re_numcomponente"];
					break;
				case 6 :  $componente =$item["re_numcomponente2"];
					break;
				} // switch
				//echo $componente;

				echo '  <tr>
				  <td>'.$componente.'</td>
				  <td><a href="index.php?action=editaestandar&sec='.
					$numeros.".".$componente.'&sv='.$item["ser_claveservicio"].'">'.$item["re_descripcionesp"].'</a>
				  </td>
				  <td><a href="index.php?action=sn&sec='.$numeros.".".$componente.'&sv='.$item["ser_claveservicio"].'&ts=ED">detalle</a>
				  </td>
					  <td><a href="index.php?action=estandarcoment&sec='.$numeros.".".$componente.'&sv='.$item["ser_claveservicio"].'">comentario</a>
				  </td>
				   <td><a href="index.php?action=sn&ids='.$item["sec_numseccion"].'.'.$item["r_numreactivo"].'.'.$item["re_numcomponente"].'&sv='.$item["ser_claveservicio"].'&ts=E&sec='.$item["sec_numseccion"].'">borrar</a>
				  </td>
					</tr>';
				   
			 } // foreach
		
			echo  ' </table>
			</div>
		   </div>
		 
</section>';


	//}  // if inicial
		}
	}



	public function nuevaEstandarController(){
		
	$datosController = $_GET["id"];
	$servicioController = $_GET["ids"];

		
	   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
			  
	}


public function borrarEstandarController(){
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

			 break;
		 case 3:
			$numcar=0;
			$numcom2=0;
				
			$numseccon=$numsec.$numcar.$numcom2;
			break;
		case 5:
			$numseccon=$numsec;
			break;
		}	 // switch
	  
	  $respuesta = DatosEst::borraestandarController($numseccon, $servicioController,"cue_reactivosestandar");
	  //echo $respuesta;
	  # valida si en esa seccion ya no hay otros componentes esta pendiente el numero de seccion
		$secreac=substr($numsec,0,2);
		$respuesta = DatosEst::buscacompModel($secreac, $servicioController,"cue_reactivosestandar");
		if (isset($respuesta)){
			# el registro sigue 
			$i=0;
			foreach ($respuesta as $row => $item) {
			  $i++;	# code...
			}

			if ($i>0)  {
			   
			} else {
				$valcon=null;
				$respuesta = DatosEst::actpondModel($secreac, $servicioController,$valcon,"cue_reactivos");
				//echo $respuesta;
			}
		} else {
			# actualiza seccion en ponderada
			
			$valcon=null;
			$respuesta = DatosEst::actpondModel($secreac, $servicioController,$valcon,"cue_reactivos");
			//echo $respuesta;
		}
		
	}
  } 

	public function borrarEstandarDetController(){
		if(isset($_GET["ids"])){
		  $seccion = $_GET["ids"];
		  $servicioController = $_GET["sv"];

		  $respuesta = DatosEst::borraEstandarDetModel($seccion, $servicioController, "cue_reactivosestandardetalle");
		}
	}


	public function vistaEstDetController(){
		//lee numero de seccion y numero de servicio
		if (isset($_GET["sec"])) {
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];

			echo '<div class="row">
	<div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; "><a href="index.php?action=nuevaestdetalle&id='.$seccion.'&ids='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
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
			//echo $nivel;
			# Estructura de acuerdo a nivel
			switch($nivel) {
			case 2 :
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
			} // switch
				//busca la info
			$respuesta =DatosEst::vistaEstDetModel($servicioController, $numseccon, "cue_reactivosestandardetalle");
			// presenta info

			echo 	'<section class="content container-fluid">
			<div class="box">
					
					  <table class="table" table-condensed>
						<tr>
						  <th style="width: 5%">No.</th>
						  <th style="width: 36%">CARACTERISTICA</th>
						  <th style="width: 15%">PONDERACION</th>
							<th style="width: 15%">INCLUYE EN ARCHIVO</th>
							<th style="width: 15%">SUBNIVEL</th>
							<th style="width: 10%">BORRAR</th>
						</tr>';

			 $i=1;
			foreach($respuesta as $row => $item){
				echo '  <tr>
				  <td>'.$item["red_numcaracteristica2"].'</td>
				  <td><a href="index.php?action=editaestdetalle&sec='.$numseccon.$item["red_numcaracteristica2"].'&sv='.$item["ser_claveservicio"].'&sa='.$seccion.'">'.$item["red_parametroesp"].'</a>
				  </td>
					  <td>
						<a href="#">'.$item["red_ponderacion"].'</a>
					  </td>
					  <td>
						<a href="#">';
						if ($item["red_syd"]==0){
							$incluye="NO";
						} else {
							$incluye="SI";
						}
						echo $incluye.'</a>
					  </td>
					  <td><a href="index.php?action=sn&sec='.$numseccon.$item["red_numcaracteristica2"].'&sv='.$item["ser_claveservicio"].'&ts='.$item["red_tiporeactivo"].'">subnivel</a>
				  </td>
					<td><a href="index.php?action=sn&ids='.$numseccon.$item["red_numcaracteristica2"].'&sv='.$item["ser_claveservicio"].'&ts=ED&sec='.$seccion.'">borrar</a>
					</tr>';
				$i++;  
			}
		
			echo  ' </table>
			</div>
		   </div>
		 
</section>';



		
		}
	}





//guarda estandar 



public function registrarEstandarController(){
		 
	if(isset($_POST["nombreesp"])){
	  $datosServicio=$_POST["idser"];
	  $seccion=$_POST["idsec"];

	  # calcula numero de nivel
		$i=1;
		$nnivel=0;
		$idsecc='';
		 while ($i <= 10) {
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
			 $respuesta =DatosEst::CalculaultimaEstModel($datosServicio, $numseccon, "cue_reactivosestandar");
				
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
			 $respuesta =DatosEst::CalculaultimaEstModel($datosServicio, $numseccon, "cue_reactivosestandar");
				
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

			$respuesta =DatosEst::CalculaultimaEst3Model($datosServicio, $numseccon, "cue_reactivosestandar");
			
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

			$datini=SubnivelController::obtienedato($seccion,5);
			$londat=SubnivelController::obtienelon($seccion,5);
			$numcom2=substr($seccion,$datini,$londat);

			$datini=SubnivelController::obtienedato($seccion,6);
			$londat=SubnivelController::obtienelon($seccion,6);
			$numcar2=substr($seccion,$datini,$londat);

			$numseccon=$numsec.$numreac.$numcom.$numcar2;

			$respuesta =DatosEst::CalculaultimaEst3Model($datosServicio, $numseccon, "cue_reactivosestandar");
			
			$numcom2=$respuesta["clavecomp"]+1;
			
		 } // termina switch

		 #configura insert
		
		  #inserta para los tres primeros niveles

	
		  if($nivel==1 or $nivel==2 or $nivel==3){
			$datosController= array("idser"=>$datosServicio,
								   "idsec"=>$numsec,
								   "numreac"=>$numreac,
								   "numcom"=>$numcom,
								   "numcar"=>$numcar,
								   "numcom2"=>$numcom2,
								   "desesp"=>$_POST["nombreesp"],
								   "desing"=>$_POST["nombreing"],
								   "tipoeval"=>$_POST["tipoeval"],
								  ); 


			$respuesta =DatosEst::insertaestandarn13($datosController, "cue_reactivosestandar");
		



		  } else {
			$datosController= array("idser"=>$datosServicio,
								   "idsec"=>$numsec,
								   "numreac"=>$numreac,
								   "numcom"=>$numcom,
								   "numcar2"=>$numcar2,
								   "numcom2"=>$numcom2,
								   "desesp"=>$_POST["nombreesp"],
								   "desing"=>$_POST["nombreing"],
								   "tipoeval"=>$_POST["tipoeval"],
								  ); 


			$respuesta =DatosEst::insertaestandarn4($datosController, "cue_reactivosestandar");
			

		  }
		 // echo $respuesta;
			if($respuesta== "success"){

				echo "<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$seccion."&ts=E&sv=".$datosServicio."';
				</script>
				";


			//header("location:index.php?action=ok");
			} else {
				echo "error";
			}      }  
	
	}
	
	public function botonRegresaEstDetController(){
		
		$sec = $_GET["id"];
		$ser = $_GET["ids"];

	   echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$sec.'&ts=ED&sv='.$ser.'"> Cancelar </a></button>
	';

	}

	public function botonRegresaEdEstDetController(){
		
		$sec = $_GET["sa"];
		$ser = $_GET["sv"];

	   echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$sec.'&ts=ED&sv='.$ser.'"> Cancelar </a></button>
	';

	}



	public function nuevaEstandarDetController(){
		
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
		//$secant = $_GET["sa"];
		
	   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
	   //echo '<input type="text" name="secant" value="'.$ecant.'">';
				
	}

	public function registraestdetController(){

	  if(isset($_POST["descesp"])){
		   $idServicio=$_POST["idser"];
		   $seccion=$_POST["idsec"];
		   //$secant=$_POST["secant"];
		
		foreach ($_POST as $nombre_campo => $valor) {
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
			eval($asignacion);
		}
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
			$numsecpar = $idsecc;
			$nivel=$nnivel;
			//echo $numsecpar;
			switch($nivel) {
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

				$respuesta = DatosEst::buscaultimoreactivoest($numseccon,$idServicio,"cue_reactivosestandardetalle");
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
				$numcar = 0;
				$numcom2 = 0;
				$numseccom = $numsecpar . $numcar . $numcom2;
				//$numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;
				//echo $numseccom;
				$respuesta = DatosEst::buscaultimoreactivoest($numseccom,$idServicio,"cue_reactivosestandardetalle");
				if (isset($respuesta["numcar2"])) {
					$i==0;
					foreach($respuesta as $row => $item){
						$i=$i+1;
					}
				}	   
				//echo $i;
				$numcar2=0;
				if ($i>0) {
					foreach($respuesta as $row => $item){
					   $numcar2=$item["numcar2"];
						}   
				} else {
					$numcar2=0;
				}
			//	echo $numcar2;
				$numcar2 = $numcar2+1;
			//	echo $numcar2;
				$datini=SubnivelController::obtienedato($seccion,1);
				$londat=SubnivelController::obtienelon($seccion,1);
				$numsec=substr($seccion,$datini,$londat);
				
				$datini=SubnivelController::obtienedato($seccion,2);
				$londat=SubnivelController::obtienelon($seccion,2);
				$numreac=substr($seccion,$datini,$londat);

				$datini=SubnivelController::obtienedato($seccion,3);
				$londat=SubnivelController::obtienelon($seccion,3);
				$numcom=substr($seccion,$datini,$londat);
				break;
			}  // fin del switch	
			$descesp=$_POST["descesp"];
			$descing=$_POST["descing"];
			$formato=$_POST["formareac"];
			$estandar=$_POST["estandar"];
			$tgrafica=$_POST["tipo_grafica"];
			
			if (isset($_POST["valopcatalogo"])){
				$valopcatalogo=$_POST["valopcatalogo"];
			}else{
				$valopcatalogo=0;
			}


			if (isset($_POST["pondera"])){
				$pondera=$_POST["pondera"];
			}else{
				$pondera=0;
			}	


			if (isset($_POST["indsyd"])){
				$sydata = -1;
			} else {
				$sydata = 0;
			}

			if (isset($_POST["lugarsyd"])){
				$lugsurdat = $_POST["lugarsyd"];
			} else {
				$lugsurdat = 0;
			}

			if (isset($_POST["graf"])){
				$grafica = -1;
			} else {
				$grafica = 0;
			}	
			if (isset($_POST["numcatalogo"])){
				$numcat = $_POST["numcatalogo"];
			} else {
				$numcat = 0;
			}

			#if (isset($_POST["valopcatalogo"])) {
		#		if ($_POST["valopcatalogo"] == '0'){
		#		   $siguno = "=";
		#		   $valmin = $valopcatalogo;	
		#		}
		#	}

			if (isset($valopcatalogo) or $valopcatalogo == '0') {
				$siguno = "=";
				$valmin = $valopcatalogo;
			}


			//$tiporeac=$_POST["tiporeac"];
			
			if (isset($_POST["indicador"])){
				$indicador=-1;
			} else {
				$indicador=0;
			}

			
			if (isset($_POST["calesp"])) {
			   $numcalesp = $_POST["tipocalesp"];
			} else {
				$numcalesp = 0;
			}

			if (isset($_POST["poscal"])){ 
				$posicionc = $_POST["poscal"];
			} else {
				$posicionc = 0;
			}

			if (isset($_POST["indicador"])){
				$indicador=-1;
			}
			else {
				$indicador=0;
			}


			if(isset($rango_rojoi)&&$rango_rojoi!=""){
			   $rangor=$rango_rojoi."^".$rango_rojof;
			} else {
			   $rangor="";	
			}
			if(isset($rango_amarilloi)&&$rango_amarilloi!=""){
				$rangoa=$rango_amarilloi."^".$rango_amarillof;
			} else {
				$rangoa="";
			}
			if(isset($rango_verdei)&&$rango_verdei!=""){
				$rangov=$rango_verdei."^".$rango_verdef;
			} else {
				$rangov="";
			}

			if (isset($cesp)){

			}else {
				$cesp=0;
			}
		   // echo $descesp. " ".$descing.' '.$formato.' '.$pondera.' '.$estandar.' ';
			//echo $sydata.' '.$lugarsyd.' '.$grafica.' '.$tiporeac.' '.$indicador.' '.$lugarindi;	
			//echo $rangor.' '.$rangoa.' '.$rangov.''.$anapepsi.''.$refinter;
			$datosController= array("idServicio"=>$idServicio,
							   "numsec"=>$numsec,
							   "numreac"=>$numreac,
							   "numcom"=>$numcom,
							   "numcar"=>$numcar,
							   "numcom2"=>$numcom2,
							   "numcar2"=>$numcar2,
							 
							   "desesp"=>$descesp,
							   "desing"=>$descing,
							   "estandar"=>$estandar,
							   "valmin"=>$valmin,
							   "valmax"=>$valmax,
							   "siguno"=>$siguno,
							   "sigdos"=>$sigdos,
							   "pondera"=>$pondera,
							   "sydata"=>$sydata,
							   "lugarsyd"=>$lugarsyd,
							   "formato"=>$formato,
							   "numcat"=>$numcat,
							   "grafica"=>$grafica,
							   "numcalesp"=>$cesp,
							   "tipocalesp"=>$tipocalesp,
							   "posicionc"=>$posicionc,
							   "tipo_grafica"=>$tipo_grafica,
							   "indicador"=>$indicador,
							   "lugarindi"=>$lugarindi,
							   "rangor"=>$rangor,
							   "rangoa"=>$rangoa,
							   "rangov"=>$rangov,
							   "anapepsi"=>$anapepsi,
							   "refinter"=>$refinter,  
							  );

			$respuesta = DatosEst::insertaestandardetalle($datosController,"cue_reactivosestandardetalle");
			//echo $respuesta;
			if($respuesta== "success"){

				echo "<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$seccion."&ts=ED&sv=$idser';
				</script>
				";


			//header("location:index.php?action=ok");
			} else {
				echo "error";
			}


		} 	// fin del if

	}  // fin de la funcion

	public function listacatalogos(){

		$respuesta = DatosEst::catalogosModel("ca_catalogos");
		foreach($respuesta as $row => $item){
			echo '<option value='.$item["ca_idcatalogo"].'>'.$item["ca_nombrecatalogo"].'</option>';
		}   
		
	}  // fin functio			

	public function editaEstandarDetController(){
		
		$datosController = $_GET["sec"];
		$servicioController = $_GET["sv"];
		$secori=$_GET["sa"];
		
	   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
	   echo '<input type="hidden" name="idsa" value="'.$secori.'">';       
	
		#BUSCA REGISTRO SELECCIONADO
	   $rowr = DatosEst::editaEstDetalleModel($datosController,$servicioController,"cue_reactivosestandardetalle");

		$formato = $rowr["red_tipodato"];
		$desesp = $rowr["red_parametroesp"];
		$desing = $rowr["red_parametroing"];
		$numcatalogo = $rowr["red_clavecatalogo"];
		$estandar = $rowr["red_estandar"];
		$calesp = $rowr["red_calculoespecial"];
		$valsiguno = $rowr["red_signouno"];
		$tipocal = $rowr["red_tipocalculo"];
		$poscal = $rowr["red_tipooperador"];

		$valsigdos = $rowr["red_signodos"];
		$valuno = $rowr["red_valormin"];
		$valdos = $rowr["red_valormax"];
		$std = $rowr["red_estandar"];
		$pon = $rowr["red_ponderacion"];
		$lugar = $rowr["red_lugarsyd"];
		$syd = $rowr['red_syd'];
		$graf = $rowr['red_grafica'];
		$tipo_reactivo = $rowr["red_tipografica"];
		$indicador = $rowr["red_indicador"];
		$lugarindi=$rowr["red_lugarindicador"];
		$rangoverde= $rowr["red_rangov"];
		$rangoamarillo= $rowr["red_rangoa"];
		$rangorojo= $rowr["red_rangor"];
		$anapep= $rowr["red_metodopepsi"];
		$refinter= $rowr["red_refinternacinal"];
		if($rangoverde!="")
		{    //separo el rango
			$auxv=explode("^",$rangoverde);
			$val_rangovi= $auxv[0]; 
			$val_rangovf= $auxv[1]; 
		} else{
			$val_rangovi= ""; 
			$val_rangovf= ""; 
		}

		if($rangoamarillo!="")
		{    //separo el rango
			$auxa=explode("^",$rangoamarillo);
			$val_rangoai= $auxa[0]; 
			$val_rangoaf= $auxa[1]; 
		} else {
			$val_rangoai=""; 
			$val_rangoaf="";
		}


		if($rangorojo!="")
		{    //separo el rango
			$auxv=array();
			$auxv=explode("^",$rangorojo);
			$val_rangori= $auxv[0]; 
			$val_rangorf= $auxv[1]; 
		} else {
			$val_rangori=""; 
			$val_rangorf="";
		}




		echo '<div class="row">
				<div class="form-group col-md-6">
				  <label>DESCRIPCION EN ESPAÑOL</label>
				  <input type="text" class="form-control" name="descesp" value="'.$desesp.'">

				</div>
				<div class="form-group col-md-6">
				  <label>DESCRIPCION EN INGLES</label>
				  <input type="text" class="form-control" name="descing" value="'.$desing.'">
				</div>

				<div class="form-group col-md-6">
				  <label>FORMATO DE REACTIVO</label>
				  <select class="form-control" name="formato">
					  <option value="">--- Elija el formato ---</option>';
					  if ($formato=="C"){
						  echo '<option value="C" selected="selected">CATALOGO</option>';	
					  } else {
						  echo '<option value="C">CATALOGO</option>';
					  }
					  if ($formato=="N"){
						  echo '<option value="N" selected="selected">NUMERICO </option>';	
					  } else {
						  echo '<option value="N">NUMERICO </option>';
					  }
				 echo '     
					  
				  </select>
				</div>
				<div class="form-group col-md-6">
				  <label>PONDERACION</label>
				  <input type="text" class="form-control" name="pondera" value="'.$pon.'">
				</div>
			   
				<div class="form-group col-md-6">
				  <label>ESTANDAR</label>
				  <input name="estandar" id="estandar" class="form-control" value="'.$estandar.'">
				</div>
			</div>  
				<div class="row">
				<div class="form-group col-md-6">
				  <label>CATALOGO</label>
					<select class="form-control" name="numcatalogo">
					  <option value="">--- Elija el catalogo ---</option>';
				 
			  $respuestac = DatosEst::catalogosModel("ca_catalogos");
				foreach($respuestac as $row => $itemc){
					if ($itemc["ca_idcatalogo"]==$numcatalogo){
						if ($formato=="C"){
							echo '<option value='.$itemc["ca_idcatalogo"].' selected="selected">'.$itemc["ca_nombrecatalogo"].'</option>';
						}
					}else{
						echo '<option value='.$itemc["ca_idcatalogo"].'>'.$itemc["ca_nombrecatalogo"].'</option>';
					}
				}   
				
		  echo '
				  </select>
				</div>
				<div class="form-group col-md-6">
				  <label>OPCION CORRECTA</label>
				   <select class="form-control" name="valopcatalogo">
					  <option value="">--- Elija el opcion ---</option>';

				 $respuestac = DatosEst::catalogoDetalleModel($itemc["ca_idcatalogo"],"ca_catalogos");
				 if ($formato=="C"){
					 foreach($respuestac as $row => $rowcd){
						if ($valuno == $rowcd["cad_idopcion"]) {
							echo "<option value='" . $rowcd["cad_idopcion"] . "' selected>" . $rowcd["cad_descripcionesp"] . "</option>";
						} else {
							echo "<option value='" . $rowcd["cad_idopcion"] . "'>" . $rowcd["cad_descripcionesp"] . "</option>";
						}
					}   
				#} else {
				#	 foreach($respuestac as $row => $rowcd){
				# 	    echo "<option value='" . $rowcd["cad_idopcion"] . "'>" . $rowcd["cad_descripcionesp"] . "</option>";
				 #	}   
				}

				 
				 echo ' </select>
				</div>
				</div>
				<div class="row">
				<div class="form-group col-md-6">
				   <label >CALCULO ESPECIAL</label>';
				   if ($calesp == -1) {
					  echo '<input type="checkbox" name="calesp" checked/>';
				   }else{
					  echo '<input type="checkbox" name="calesp"/>';
				   }   
				echo '
				</div>
				<div class="form-group col-md-6">
				  <label>TIPO DE CALCULO</label>
				  <select class="form-control" name="tipocalesp">
					  <option value="">--- Elija el tipo ---</option>';
					  if ($tipocal=="1"){
						  echo '<option value="1" selected="selected">PROPORCION AGUA-JARABE</option>';	
					  } else {
						  echo '<option value="1">PROPORCION AGUA-JARABE</option>';
					  }
					  if ($tipocal=="2"){
						  echo '<option value="2" selected="selected">CALCULO DE CO2</option>';	
					  } else {
						  echo '<option value="2">CALCULO DE CO2</option>';
					  }
					echo '
				  </select>

				</div>
				<div class="form-group col-md-6">
				  <label>POSICION EN EL CALCULO</label>
				  <select class="form-control" name="poscal">
					  <option value="">--- Elija el formato ---</option>';
					  if ($poscal=="A"){
						  echo '<option value="A" selected="selected">A</option>';	
					  } else {
						  echo '<option value="A">A</option>';
					  }
					  if ($poscal=="B"){
						  echo '<option value="B" selected="selected">B</option>';	
					  } else {
						  echo '<option value="B">B</option>';
					  }
					  if ($poscal=="C"){
						  echo '<option value="C" selected="selected">C</option>';	
					  } else {
						  echo '<option value="C">C</option>';
					  }
				  echo '   
				  </select>

				</div>
				</div>  
				<div class="form-group col-md-6">
				   <label >SIGNO UNO</label>';
			 if ($formato=="N"){
				echo '<input name="siguno" id="siguno" class="form-control" value="'.$valsiguno.'">
				</div>
				<div class="form-group col-md-6">
				  <label>VALOR MINIMO</label>
				  <input name="valmin" id="valmin" class="form-control" value="'.$valuno.'">
				</div>
				<div class="form-group col-md-6">
				   <label >SIGNO DOS</label>
					<input name="sigdos" id="sigdos" class="form-control" value="'.$valsigdos.'">
				</div>
				<div class="form-group col-md-6">
				  <label>VALOR MAXIMO</label>
				  <input name="valmax" id="valmax" class="form-control" value="'.$valdos.'">
				</div>';
			 } else {
				echo '<input name="siguno" id="siguno" class="form-control">
				</div>
				<div class="form-group col-md-6">
				  <label>VALOR MINIMO</label>
				  <input name="valmin" id="valmin" class="form-control" >
				</div>
				<div class="form-group col-md-6">
				   <label >SIGNO DOS</label>
					<input name="sigdos" id="sigdos" class="form-control" >
				</div>
				<div class="form-group col-md-6">
				  <label>VALOR MAXIMO</label>
				  <input name="valmax" id="valmax" class="form-control" >
				</div>';
			 }  
				echo '
				<div class="form-group col-md-6">
				   <label >INCLUYE EN ARCHIVO</label>';
				   if ($syd == -1) {
					   echo '<input type="checkbox" name="indsyd" checked />';
					} else {
						echo '<input type="checkbox" name="indsyd"/>';
					}
					
				echo '</div>
				<div class="form-group col-md-6">
					<label >LUGAR EN ARCHIVO</label>
					<input name="lugarsyd" id="lugarsyd" class="form-control" value="'.$lugar.'">
				</div>

				<div class="form-group col-md-6">
				   <label >GENERA GRAFICA</label>';
				   if ($graf == -1) {
					   echo '<input type="checkbox" name="graf" checked />';
					} else {
						echo '<input type="checkbox" name="graf"  />';
					}
				echo '    
				</div>
				<div class="form-group col-md-6">
					<label >TIPO DE REACTIVO</label>
					<select class="form-control" name="tipo_grafica">
					  <option value="">--- Elija el formato ---</option>';
					  if ($tipo_reactivo=="C"){
						  echo '<option value="C" selected="selected">CUALITATIVO</option>';	
					  } else {
						  echo '<option value="C" >CUALITATIVO</option>';
					  }
					if ($tipo_reactivo=="N"){
						  echo '<option value="N" selected="selected">CUANTITATIVO</option>';	
					  } else {
						  echo '<option value="N" >CUANTITATIVO</option>';
					  }
					  
				   echo '   
				  </select>
				</div>
			   

				<div class="form-group col-md-6">
				   <label >INDICADOR</label>';
				   if ($indicador == -1) {
					   echo '<input type="checkbox" name="indicador" checked />';
					} else {
						echo '<input type="checkbox" name="indicador"  />';
					}
				   echo '
					</div>
				<div class="form-group col-md-6">
				   <label >LUGAR EN GRAFICA DE INDICADORES</label>
				   <input name="lugarindi" id="lugarindi" class="form-control" value="'.$lugarindi.'">
				</div>

				<div class="form-group col-md-4">
					<label >RANGO VERDE</label>
					<input  name="rango_verdei" id="rango_verdei" class="form-control" value="'.$val_rangovi.'">
					<label > - </label>
					<input  name="rango_verdef" id="rango_verdef" class="form-control" value="'.$val_rangovf.'">
				</div>
				<div class="form-group col-md-4">
					<label >RANGO AMARILLO</label>
					<input name="rango_amarilloi" id="rango_amarilloi" class="form-control" value="'.$val_rangoai.'">
					<label > - </label>
					<input name="rango_amarillof" id="rango_amarillof" class="form-control" value="'.$val_rangoaf.'">
				</div>
				<div class="form-group col-md-4">
					<label >RANGO ROJO</label>
					<input name="rango_rojoi" id="rango_rojoi" class="form-control" value="'.$val_rangori.'">
					<label > - </label>  
					<input name="rango_rojof" id="rango_rojof" class="form-control" value="'.$val_rangorf.'">
				</div>
							 
			  

				<div class="form-group col-md-6">
				<label >METODO DE ANALISIS PEPSICO</label>
				<input type="text" class="form-control" name="anapepsi" value="'.$anapep.'">
				</div>
				<div class="form-group col-md-6">
				<label >REFERENCIA INTERNACIONAL</label>
				<input type="text" class="form-control" name="refinter" value="'.$refinter.'">
				</div>
				</div>
				';

	   
	}

	public function actualizaEstandarDetalleController(){
		if (isset($_POST["descesp"])) {
			foreach($_POST as $nombre_campo => $valor){
				$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
				eval($asignacion);
			 //       echo $asignacion."<br>";
			 }
			if (isset($indsyd)) {
			   $sydata=-1;
			 }else{
			   $sydata=0;
			   }
			   
		   if (isset($lugarsyd)){
			 $sydludata=$lugarsyd;
		   }else{	 
			$sydludata=0;
			}
				
			if (isset($pondera)) {
			   $pond=$pondera;
			 }else{
			   $pond=0;
			 }    

			if (isset($graf)) {
			   $grafica=-1;
			 }else{
			   $grafica=0;
			 }    	

			if (isset($valopcatalogo)){
				$siguno="=";
				$valmin=$valopcatalogo;
			}	


			if (isset($calesp)) {
			   $cesp=-1;
			 }else{
			   $cesp=0;
			 }    	

			if (isset($tipocalesp)) {
			   $tce=$tipocalesp;
			}else{
			   $tce=0;
			}

			if (isset($poscal)) {
			   $posicionc=$poscal;
			}else{
			   $posicionc=0;
			}

			if (isset($indicador)) {
			   $valindi=-1;
			 }else{
			   $valindi=0;
			   }
			  
			if(isset($rango_rojoi)&&$rango_rojoi!="")
					$rangor=$rango_rojoi."^".$rango_rojof;
			if(isset($rango_amarilloi)&&$rango_amarilloi!="")
				$rangoa=$rango_amarilloi."^".$rango_amarillof;
			if(isset($rango_verdei)&&$rango_verdei!="")
				$rangov=$rango_verdei."^".$rango_verdef;

			$datosController= array("idServicio"=>$idser,
							   "numsec"=>$idsec,				 
							   "desesp"=>$descesp,
							   "desing"=>$descing,                               
							   "valmin"=>$valmin,
							   "valmax"=>$valmax,
							   "siguno"=>$siguno,
							   "sigdos"=>$sigdos,
							   "pondera"=>$pondera,
							   "sydata"=>$sydata,
							   "lugarsyd"=>$lugarsyd,                         
							   "formato"=>$formato,
							   "numcat"=>$numcatalogo,
							   "grafica"=>$grafica,
							   "estandar"=>$estandar,
							   "numcalesp"=>$cesp,
							   "tipocalesp"=>$tce,
							   "posicionc"=>$posicionc,
							   "tipo_grafica"=>$tipo_grafica,
							   "indicador"=>$valindi,
							   "lugarindi"=>$lugarindi,
							   "rangor"=>$rangor,
							   "rangoa"=>$rangoa,
							   "rangov"=>$rangov,
							   "anapepsi"=>$anapepsi,
							   "refinter"=>$refinter,  
							  );


			$respuesta = DatosEst::actualizaEstandarDetalleModel($datosController, "cue_reactivosestandardetalle");
			
				if ($respuesta=="success"){

			echo "
				<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$idsa."&ts=ED&sv=$idser';
				</script>
				";
			}


		} //if	 
	}    // fin de function

	public function botonnuevoestandarcoment(){
		$ser = $_GET["sv"];
		$sec = $_GET["sec"];
	
	  echo '
	  <div class="row">
		<div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px margin-top:15px; margin-bottom:15px;""><a href="index.php?action=nuevoestcoment&id='.$sec.'&ids='.$ser.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
		 </div>
		 </div>';

	}

  public function vistaestandarcoment(){
	 $ser = $_GET["sv"];
	 $seccion = $_GET["sec"];

#calculo el nivel
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
			 
			 $datini=SubnivelController::obtienedato($seccion,2);
			 $londat=SubnivelController::obtienelon($seccion,2);
			 $numreac=substr($seccion,$datini,$londat);
			 
			 $datini=SubnivelController::obtienedato($seccion,3);
			 $londat=SubnivelController::obtienelon($seccion,3);
			 $numcom=substr($seccion,$datini,$londat);
			 
			 $numcar=0;
			 $numcom2=0;
				
			 $numseccon=$numsec.$numreac.$numcom.$numcar.$numcom2;
			 break;
		case 3 :  /*primer nivel */
			 $numcar=0;
			 $numcom2=0;
			 $numseccon=$numsec.$numcar.$numcom2;
			 break;
		case 5 :      
			 $numseccon=$numsec;
		}
#calculo la seccion     
		
	$respuesta = DatosEst::vistaestandarComentModel($numseccon, $ser, "cue_reactivosestandarcomentarios"); 
		foreach($respuesta as $row => $item){
		echo '  <tr>
				  <td>'.$item["rec_numcomentario"].'</td>

				  <td><a href="index.php?action=editaestcoment&id='.$numseccon.$item["rec_numcomentario"].'&ids='.$ser.'&sec='.$seccion.'">'.$item["rec_descomentarioesp"].'</a>
				  </td>
				  
				   <td><a href="index.php?action=estandarcoment&idb='.$numseccon.$item["rec_numcomentario"].'&sv='.$ser.'&sec='.$seccion.'">borrar</a>
				  </td>
				</tr>';
				   
		 } // foreach
			  echo  ' </table>
			  </div>
			 </div>';

	}

	public function nuevoestComentController(){
	  
	$datosController = $_GET["id"];
	$servicioController = $_GET["ids"];

	  
	 echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	 echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
			
	}

	public function botonRegresaEstComentController(){
		  
	  $ids = $_GET["ids"];
	  $id = $_GET["id"];

		 echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=estandarcoment&sec='.$id.'&sv='.$ids.'"> Cancelar </a></button>
	  ';
	  }





	public function registraEstandarComentController(){
		  // echo "entre a actualizar el comentario     
		if(isset($_POST["descesp"])){
		  $servicio=$_POST["idser"];
		  $seccion=$_POST["idsec"];
		  $descesp=$_POST["descesp"];
		  $descing=$_POST["descing"];

		  #calcula nivel
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
		 case 2:
			/* Genera clave para ingreso de reaactivo */
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
				break;
		   case 3:	
				$numcar=0;
				$numcom2=0;
				$numseccom =$numsec.$numcar.$numcom2;
				
				$datini=SubnivelController::obtienedato($seccion,1);
				$londat=SubnivelController::obtienelon($seccion,1);
				$numsec=substr($seccion,$datini,$londat);
			 
				$datini=SubnivelController::obtienedato($seccion,2);
				$londat=SubnivelController::obtienelon($seccion,2);
				$numreac=substr($seccion,$datini,$londat);
			 
				$datini=SubnivelController::obtienedato($seccion,3);
				$londat=SubnivelController::obtienelon($seccion,3);
				$numcom=substr($seccion,$datini,$londat);

				break;
		   case 5:	
				$numseccom =$numsec;
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
				break;		
		   }
		   #calcula numero de caracteristica
		   $respuesta=DatosEst::CalculaultimoEstComentModel($numseccom, $servicio, "cue_reactivosestandarcomentarios");
		   if (isset($respuesta["clavecom"])) {
			  $i=0;
				foreach($respuesta as $row => $item){
				  $i=$i+1;
				}
		   }    
		   $numcar2=$respuesta["clavecom"];
		   $numcar2=$numcar2+1;
		  
		   $datosController= array("idser"=>$servicio,
								  "idsec"=>$numsec,
								  "idreac"=>$numreac,
								  'numcom'=>$numcom,
								  'numcar'=>$numcar,
								  'numcom2'=>$numcom2,
								  'numcar2'=>$numcar2,
								  "nomesp"=>$descesp,
								  "noming"=>$descing,
								  ); 

			  
		   $respuesta=DatosEst::registraEstComentModel($datosController, "cue_reactivosestandarcomentarios");
		  //echo $respuesta;
			if($respuesta=="success"){
				echo "
			   <script type='text/javascript'>
				 window.location.href='index.php?action=estandarcoment&sv=".$servicio."&sec=".$seccion."
					</script>
					  ";
			} else {
				echo "error";
			}
		}  
		
	}

   public function borrarEstComentarioController(){
	  if(isset($_GET["idb"])){
	  $datosController = $_GET["idb"];
	  $servicioController = $_GET["sv"];
	  $sec=$_GET["sec"];

	  $respuesta = DatosEst::borrarEstComentModel($datosController, $servicioController, "borrarEstComentarioController");
	}
  } 

public function editarEstandarComentController(){
	
	$datosController = $_GET["id"];
	$idservicio = $_GET["ids"];

	//echo $datosController;
	//echo $idservicio;
	$respuesta = DatosEst::editaEstComentModel($datosController,$idservicio,"cue_reactivosestandarcomentarios");
	   
	echo ' <input type="text" class="form-control" name="descesp" value="'.$respuesta["rec_descomentarioesp"].'" >
		   </div>
		   <div class="form-group col-md-6">
		   <label>DESCRIPCION EN INGLES</label>
		   <input type="text" class="form-control" name="descing" value="'.$respuesta["rec_descomentarioing"].'" >
		   </div>';
	}       

  public function actualizaEstComentController(){
	  // echo "entre a actualizar el comentario     
	if(isset($_POST["descesp"])){
	  $servicio=$_POST["idser"];
	  $seccion=$_POST["idsec"];
	  $sec=$_POST["sec"];
	  $descesp=$_POST["descesp"];
	  $descing=$_POST["descing"];
	  
		//echo $numcom;
	   $datosController= array("idser"=>$servicio,
							  "idsec"=>$seccion,
							  "nomesp"=>$descesp,
							  "noming"=>$descing,
							  ); 
		  
	   $respuesta=DatosEst::actualizaEstComentModel($datosController, "cue_reactivosestandarcomentarios");
	//  echo $respuesta;
	   // if($respuesta=="success"){
			echo "
			<script type='text/javascript'>
			  window.location.href='index.php?action=estandarcoment&sv=".$servicio."&sec=".$sec."
				</script>
				  ";
		//} else {
		//  echo "error";
		//}
	  }  
	
	}

public function botonRegEditEstComentController(){
		  
	  $ids = $_GET["ids"];
	  $id = $_GET["id"];
	  $sec = $_GET["sec"];

		 echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=estandarcoment&sec='.$sec.'&sv='.$ids.'"> Cancelar </a></button>
	  ';
	  }

   public function inicioEditComentController(){
	  
	  $datosController = $_GET["id"];
	  $servicioController = $_GET["ids"];
	  $sec = $_GET["sec"];
		 
	 echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	 echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
	 echo '<input type="hidden" name="sec" value="'.$sec.'">';
			
  }

	public function reporteEstandarController(){
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

		if ($numreac){

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
		#presenta reactivos
		if ($numreac!=0) {
			//echo $idser;
			//echo $seccion;
			$respuesta=DatosEst::vistaEstandarRepReactivo($idser, $numsec, $numreac, "cue_reactivosestandar");

		}else{
			if ($numcar==0) {
				$secc=$seccion.".".$numreac.".".$numcar.".".$numcom2;

				$respuesta=DatosEst::vistaEstandarRepNumcar($idser, $secc, "cue_reactivosestandar");
			} else{
				$secc=$numsec.".".$numreac.".".$numcom.".".$numcar;   
				$respuesta=DatosEst::vistaEstandarRepGral($idser, $secc, "cue_reactivosestandar");
			}	
		}	
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
						  <th style="width: 26%">COMPONENTES</th>
						  <th style="width: 24%">COMENTARIO</th>';

						  $respsec=DatosSeccion::vistaNombreSeccionModel($numsec, $idser, "cue_secciones");
						  $indagua=$respsec["sec_indagua"];
						  if ($indagua==1){
								 echo '
								 <th style="width: 56%">MUESTRAS</th>
								</tr>';
						  }else{
							 echo '
								 </tr>';
						  }		

						#crea seccion
						#busca si la seccion tiene indicador de agua

						
						foreach ($respuesta as $key => $item) {

						   if ($numcom){	
							  $seccom=$secc.'.'.$item["re_numcomponente2"];
							  echo '<tr>
							  <td> <a href="index.php?action=rsn&nrep='.$nrep.'&ts=ED&sec='.$seccom.'">'.$item["re_descripcionesp"].'</a></td>';

							  #presenta comentarios
							  
							  $respcoment=DatosEst::validaComentEstandar($idser, $seccom, "cue_reactivosestandarcomentarios");
							} else {
								$seccom=$numsec.'.'.$numreac.'.'.$item["re_numcomponente"].".".$numcar.".".$numcom2;
								echo '<tr>
							  <td> <a href="index.php?action=rsn&nrep='.$nrep.'&ts=ED&idc='.$idc.'&pv='.$pv.'&sv='.$idser.'&sec='.$seccom.'">'.$item["re_descripcionesp"].'</a></td>';
							  //echo $seccom;
							  $respcoment=DatosEst::validaComentEstandar($idser, $seccom, "cue_reactivosestandarcomentarios");
							}  
							if ($respcoment>0) {
								#presenta caracter de comentario
								 echo '
								<td><button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=rsn&CED=&sec='.$seccom.'&sv='.$idser.'">Comentario</a></span></button></td>';
							} else {
								echo '<td> </td>';
							} 

							// presenta indicador de agua
							if ($indagua==1){
								 echo '
								<td width 30px><button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=rsn&sec='.$seccom.'&ts=TM&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'&sv='.$idser.'">Muestra</a></span></button></td>';
							}
						   
						}
echo '					</table>	

					</div>
				  </div>
				  <!-- /.box -->
				</div>
							  <!----- Finaliza contenido ----->
			</section>
			<!-- /.content -->';

	}

	public function reporteEstandarDetalle(){
		#lee varia{ble
		$sv=$_GET["sv"];
		$sec=$_GET["sec"];
		$nrep=$_GET["nrep"];
		$pv=$_GET["pv"];
		$idc=$_GET["idc"];

		$datini=SubnivelController::obtienedato($sec,1);
		$londat=SubnivelController::obtienelon($sec,1);
		$numsec=substr($sec,$datini,$londat);

		$datini=SubnivelController::obtienedato($sec,2);
		$londat=SubnivelController::obtienelon($sec,2);
		$numreac=substr($sec,$datini,$londat);
			 
		$datini=SubnivelController::obtienedato($sec,3);
		$londat=SubnivelController::obtienelon($sec,3);
		$numcom=substr($sec,$datini,$londat);
	 

		if ($numsec!=5){
			echo '<div class="row">
	<div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; "><a href="index.php?action=rsn&sec='.$sec.'&sv='.$sv.'&ts=EN&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
	 </div>
	 </div>';
		}  // fin del if boton		

		#determina el tipo de evaluacion
	echo '<section class="content container-fluid">';

	 $totren=DatosEst::buscatotren($sv, $sec, $nrep, "ins_detalleestandar");
	  foreach ($totren as $key => $tren) {
		   $numren=$tren["claveren"];
		   #presenta encabezado
			echo '

			  <!----- Inicia contenido ----->
			  
				 <div class="col-md-6" >
		  <div class="box box-info" >
			<div class="box-header with-border">
			<h3 class="box-title">No.'. $numren.'</h3>

			  <div class="box-tools pull-right">
			   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				</button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			  </div>
			  <!-- /.box-tools -->
			</div>
				<!-- /.box-header -->
					<div class="box-body no-padding">
					  <table class="table">
						<tr>
						  <th style="width: 26%">REACTIVO</th>
						  <th style="width: 24%">ESTANDAR</th>
						  <th style="width: 24%">RESULTADO</th>';

				#busca reactivos en cuestionario
				$respestandar=DatosEst::vistaRepEstandarDet($sv, $sec, "cue_reactivosestandardetalle");
		   
				foreach ($respestandar as $key => $item) {
					$estandar=$item["red_estandar"];
					echo '<tr> <td> '.$item["red_parametroesp"].'</td>
							<td> '.$estandar.'</td>';

							#busca info real
						$numcar=$item["red_numcaracteristica2"];
						$tipodato=$item["red_tipodato"];

						$datosController= array("idser"=>$sv,
								  "idsec"=>$sec,
								  "idrep"=>$nrep,
								  'numren'=>$numren,
								  'numcar'=>$numcar,
								  ); 
						$respreal=DatosEst::vistaRepRealDet($datosController, "ins_detalleestandar");

						$resacep=$respreal["ide_aceptado"];
						#valida tipo de dato
						if (isset($resacep)){
						switch ($tipodato) {
						case "C" :
							$siguno=$item["red_signouno"];
							$valmin=$item["red_valormin"];
							$valop=round($respreal["ide_valorreal"],1);
							$numcat=$item["red_clavecatalogo"];
							$valpond = $respreal["ide_ponderacion"];
							#busca valor del catalogo
							$respcat=DatosEst::buscaOpcionCat($numcat, $valop, "ca_catalogosdetalle");
							$valreal=$respcat["cad_descripcionesp"];
							break;
						case "N" :
							$siguno=$item["red_signouno"];
							$valmin=$item["red_valormin"];

							if (($respreal["ide_numcaracteristica3"]==17) || ($respreal["ide_numcaracteristica3"]==18)) {
							 if  ($valreal=round($respreal["ide_valorreal"],3)>=100) {
								 $valreal="Incontables";
							 } else {
								$valreal=round($respreal["ide_valorreal"],3);
							 }
							} else {
									$valreal=round($respreal["ide_valorreal"],3);
							}
							$valmax=$item["red_valormax"];
							$sigdos=$item["red_signodos"];
							$valpond = $respreal["ide_ponderacion"];
							break;
						} // switch

						if(isset($estandar)&&$estandar!="") {
							if ($resacep!=0) {
								 echo '	<td > '. $valreal. '</td>';         
							}else {
									echo '<td  style="color: red;"> '.$valreal. '</td>';
							}
						}else{
							 echo '	<td > '.	$valreal. '</td>';
						}

					} else {
						$valreal="";
						echo '	<td > &nbsp;</td>';
					} // if isset
						$ingreso = new EstandarController();
						$ingreso ->borraRepEstandarDetalle();

					}  // foreach

						

					echo '<tr>	<td > &nbsp;</td> <td > &nbsp;</td>
<td><button type="button" class="btn btn-block btn-info"><a href="index.php?action=rsn&idb='. $numren.'&sv='.$sv.'&nrep='. $nrep.'&ts=ED&idc='. $idc.'&sec='. $sec.'"><i class="fa fa-trash-o"></i></a></button> </td></tr>';
				 
					echo '	</table>	
					
				  

					</div>
				  </div>
				  <!-- /.box -->
				</div>
							  <!----- Finaliza contenido ----->
			
			<!-- /.content -->';

		} // for each de numren

	} // fin de la funcion

	public function nivelCumplimientoEstandar(){
	#lee varia{ble
		$sv=$_GET["sv"];
		$sec=$_GET["sec"];
		$nrep=$_GET["nrep"];
		$pv=$_GET["pv"];
		$idc=$_GET["idc"];

		$datini=SubnivelController::obtienedato($sec,1);
		$londat=SubnivelController::obtienelon($sec,1);
		$numsec=substr($sec,$datini,$londat);

		$datini=SubnivelController::obtienedato($sec,2);
		$londat=SubnivelController::obtienelon($sec,2);
		$numreac=substr($sec,$datini,$londat);
			 
		$datini=SubnivelController::obtienedato($sec,3);
		$londat=SubnivelController::obtienelon($sec,3);
		$numcom=substr($sec,$datini,$londat);
	 
		$idsec=$numsec.'.'.$numreac.'.'.$numcom;
		$tipoeva=DatosEst::buscatipoevaluacion($sv, $idsec, "cue_reactivosestandar");
		
		$tipoev=$tipoeva["re_tipoevaluacion"];
		//echo $tipoev;
		switch($tipoev) {
		case 0 :   // ninguna linea
			$sumapond=0;
			break;
		case 1 :   // una linea
			# calculo cumplimiento de un renglon

		   $nivelcump=DatosEst::nivCumpEstandarUno($sv, $sec, $nrep, 1, "ins_detalleestandar");
		
			$sumapond=$nivelcump["totalpon"];
			//echo $sumapond;   
			//var_dump($sumapond);
			break;
		case 2 :   // todas las lineas
			//echo $sec;
			$nivelcump=DatosEst::nivelCumpEstandarDos($sv, $sec, $nrep, "ins_detalleestandar");
			//var_dump($nivelcump);
			if (isset($nivelcump["numreg"])) {
				if (($nivelcump["numreg"])>0){
					$sumapond=round(($nivelcump["totpond"]/$nivelcump["numreg"]),0);
				} else {
					$sumapond=round(($nivelcump["totpond"]));
				} 
			}
		break;	
		} //fin del switch   

		  echo '<small>    NIVEL DE CUMPLIMIENTO '.$sumapond.'%</small></h1>'; 
	} // fin de fucntion


	public function nuevoReporteEstandar(){
	#lee varia{ble
		$sv=$_GET["sv"];
		$sec=$_GET["sec"];
		$nrep=$_GET["nrep"];
		$pv=$_GET["pv"];
		$idc=$_GET["idc"];

		echo ' <section class="content container-fluid">

		<div class="row">
		
		<div class="col-md-12">
		<div class="box box-info">
		<div class="box-body">
		<form role="form"  method="post">';
   
		echo '<input type="hidden" name="sec" value="'.$sec.'">';
		echo '<input type="hidden" name="sv" value="'.$sv.'">';
		echo '<input type="hidden" name="nrep" value="'.$nrep.'">';
		echo '<input type="hidden" name="pv" value="'.$pv.'">';
		echo '<input type="hidden" name="idc" value="'.$idc.'">';

		$respuesta=DatosEst::vistaNuevoEstandar($sv, $sec, "cue_reactivosestandardetalle");
		foreach ($respuesta as $key => $item) {
			//echo $item["red_parametroesp"];
			 if($sv==1&&$sec=="8.0.2.0.0"&& $item["red_numcaracteristica2"]==9)
       continue;
   if($sv==1&&$sec=="8.0.1.0.0"&& $item["red_numcaracteristica2"]==9)
       continue;
			//echo $item["red_tipodato"];
			switch ($item['red_tipodato']){
			case "C" :
			   // busca el catalogo
			   $numcat=$item['red_clavecatalogo'];
			   //echo $numcat;
			   echo '<div class="form-group col-md-6">
				  <label>'.$item["red_parametroesp"].'</label>
				  <select class="form-control" name="desc'.$item["red_numcaracteristica2"].'" id="desc'.$item['red_numcaracteristica2'].'"></div>';
			   #busca catalogo
				  $respcat=DatosCatalogo::listaCatalogo($numcat, "ca_catalogosdetalle");
			echo '<option value="">--- Seleccione opcion ---</option>';

			   foreach ($respcat as $key => $itemc) {
				 echo '<option value="'.$itemc["cad_idopcion"].'">'.$itemc["cad_descripcionesp"].'</option>';
			   }
				echo '   </select>
			   </div>';
			   break;
			   
			default:   
				echo '<div class="form-group col-md-12">
				  <label>'.$item["red_parametroesp"].'</label>
				  <input type="text" class="form-control" name="desc'.$item["red_numcaracteristica2"].'" id="desc'.$item['red_numcaracteristica2'].'>
				</div>
				</div>';
			 break;   
			}  //switch      
		} // foreach

		$ingreso = new EstandarController();
		//$ingreso ->insertaReporteEstandar();

		echo ' 
		</br>
		<div class="row">
		
		<div class="col-md-12">
		
				 <button class="btn btn-default pull-right" style="margin-right: 10px"><a href="index.php?action=rsn&nrep='.$nrep.'&ts=ED&idc='.$idc.'&pv='.$pv.'&sv='.$sv.'&sec='.$sec.'"> Cancelar </a></button>
				 <button type="submit" class="btn btn-info pull-right">Guardar</button>  
			  </div>

		</form>
			  </div>
			  </div>
			</div>
		</div>



	 </section>';
	}	

	public function insertaReporteEstandar(){
		//echo "entre a inserta";
		//echo $_POST["sec"];
	#lee varia{ble
		if (isset($_POST["sv"]) && $_POST["sv"]=!"") {
			//echo "si lo encontre";
			foreach($_POST as $nombre_campo => $valor){
				$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
				eval($asignacion);
		 	//echo ($asignacion);
			}      

			#calculo numero de nuevo renglon
			$respuesta=DatosEst::calculaUltimoRenglon($sv, $nrep, $sec, "ins_detalleestandar");
			$numren= $respuesta["claveren"];
			$numren++;   
			//echo $sec;
			#VALIDO SI SE EVALUA O NO LAS SECCION
			$datini=SubnivelController::obtienedato($sec,1);
			$londat=SubnivelController::obtienelon($sec,1);
			$numsec=substr($sec,$datini,$londat);

			$datini=SubnivelController::obtienedato($sec,2);
			$londat=SubnivelController::obtienelon($sec,2);
			$numreac=substr($sec,$datini,$londat);
				 
			$datini=SubnivelController::obtienedato($sec,3);
			$londat=SubnivelController::obtienelon($sec,3);
			$numcom=substr($sec,$datini,$londat);

			$datini=SubnivelController::obtienedato($sec,4);
			$londat=SubnivelController::obtienelon($sec,4);
			$numcar=substr($sec,$datini,$londat);

			$datini=SubnivelController::obtienedato($sec,5);
			$londat=SubnivelController::obtienelon($sec,5);
			$numcom2=substr($sec,$datini,$londat);

			$secpondera= $numsec.'.'.$numreac.'.'.$numcom;
			//echo $secpondera;
			$tipoev=DatosEst:: buscatipoevaluacion($sv, $secpondera, "cue_reactivosestandar");
			$tipoeva=$tipoev["re_tipoevaluacion"];
			#1.- obtengo reactivos
			//echo $sv;
			//echo $sec;
			$respuesta=DatosEst::vistaRepEstandarDet($sv, $sec, "cue_reactivosestandardetalle");
		  //	var_dump($respuesta);
			foreach ($respuesta as $key => $item) {
				$pondreal=0;
				$aceptado=0;
				$nomcam="desc".$item['red_numcaracteristica2'];
				//echo $nomcam;
				if (ctype_space(${$nomcam})) {
				  $valcom="";
				} else {
				  $valcom=${$nomcam};
				}  //termina if de abierto
			   //echo $valcom;
				$siguno=$item['red_signouno'];
				if (ctype_space(${$siguno})) {
					$sigunon=0;
				}else{
					$sigunon=${$siguno};
				}
				//echo $siguno;
				//echo $sigunon;
				$sigdos=$item['red_signodos'];
				$valmin=$item['red_valormin'];
				$valmax=$item['red_valormax'];
				$valpond=$item['red_ponderacion'];
				$numcat=$item['red_clavecatalogo'];
				$tipodato=$item['red_tipodato'];
				$calesp=$item['red_calculoespecial'];
				$tipcalesp=$item['red_tipocalculo'];
				$tipoper=$item['red_tipooperador'];
				$numcar2=$item['red_numcaracteristica2'];
				//echo $numcar2;
				
				if ($calesp) {
				   switch($tipoper) {
				   case "A" :
					   $A=$valcom;
					   if ($A) {
					   }else{
						  $A=1;
					   }
					   break;
				   case "B" :
					   $B=$valcom;
					   if ($B) {
					   }else{
						  $B=1;
					   }
					   break;
				   case "C" :   //calculo de resultado
					  if ($tipcalesp==1) {
						 $C=$A/$B;

					   } else { // busqueda en tabla
						 $rowv=DatosEst::calculaVolumen($A, $B, "ca_volumenes");
						 if ($rowv){
							 $C=$rowv['cav_volumen'];	
						 }else{
							$C=0;
						 }
					   }
					   $valcom=$C;
					 // $descom=$C;
				   }  // cierre del switch
				} // cierre del if calesp
				//echo $valcom;
				//echo "tipoeva".$tipoeva;
				switch($tipoeva) {
				case "0" :
								switch ($tipodato){
		      case "N" :
			     				if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
										     $lvalmin=strlen ($siguno);
										     $lvalmax=strlen ($sigdos);
						     				if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
			               if (($valcom > $valmin)  and ($valcom < $valmax)) {
								     								$pondreal=0;
									 											$aceptado=-1;
								 									} else {
																			  $pondreal=0;
																			  $aceptado=0;
																		}
							 							} else {
				    										if (($lvalmin==1) and ($lvalmax==2)) {  // es menorque y mayoro igual que
                     if (($valcom > $valmin)  and ($valcom <= $valmax)) {
																			     $pondreal=0;
																				    $aceptado=-1;
																			   } else {
																				    $pondreal=0;
																				    $aceptado=0;
																			   }
                  } else {
				       											if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
                          if (($valcom >= $valmin)  and ($valcom < $valmax)) {
																					         $pondreal=$valpond;
																  				 		     $aceptado=-1;
																	  					  } else {
																			   			     $pondreal=0;
																						        $aceptado=0;
																					     }
					   														} else {
					     																if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
                          		  if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
																						           $pondreal=0;
																							          $aceptado=-1;
																		 					       } else {
																							          $pondreal=0;
																							          $aceptado=0;
																						        }
																						    }   // fin de if 2 y 2
																						}  // fin de if 2 y 1
				     								 }   // fin de if 1 y 2
				           }
											 }else // no existe valor maximo
               //vemos si existe valor minimo
               if ($valmin!=""){
												   			$lvalmin=strlen ($siguno);
												      if ($lvalmin==1) {    // es solo menorque o mayorque
													         switch ($siguno) {
																						case "=" :
																						   if ($valcom==$valmin) {
																						      $pondreal=0;
																							  $aceptado=-1;
																		 					} else {
																							   $pondreal=0;
																							    $aceptado=0;
																						    }
																						   break;
																					 case "<" :
																					   if ($valcom < $valmin) {
																					      $pondreal=0;
																						  $aceptado=-1;
																	 					} else {
																						   $pondreal=0;
																						    $aceptado=0;
																					    }
																					   break;
																					 case ">" :
																						   if ($valcom > $valmin) {
																						      $pondreal=0;
																							  $aceptado=-1;
																		 					} else {
																							   $pondreal=0;
																							    $aceptado=0;
																						    }
																						   break;
																						}
				 													}else{
																					 switch ($siguno) {
																						case "<=" :
																						   if ($valcom <= $valmin) {
																						      $pondreal=0;
																							  $aceptado=-1;
																		 					} else {
																							   $pondreal=0;
																							   $aceptado=0;
																						    }
																						   break;
																						case ">=" :
																						   if ($valcom>=$valmin ) {
																						      $pondreal=0;
																							  $aceptado=-1;
																		 					} else {
																							   $pondreal=0;
																							   $aceptado=0;
																						    }
																						   break;
																						}  // fin del switch
				 													}	// fin de longitud =1
											}
            else
           {
                     // $pondreal=0;
		 								 $aceptado=-1;   
            }
											break;
								case "C" :
		    // busco valor de opcion en catalogo
											$rowca=DatosCatalogoDetalle::listaCatalogoDetalleOpc($datosModel, $op, "ca_catalogosdetalle");
		         if ($rowca){
		        	   $valop=$rowca["cad_idopcion"];
		         }
											if ($valmin!=""){
														if ($valop == $valmin) {
														   $pondreal=0;
														   $aceptado=-1;
														} else {
														   $pondreal=0;
															$aceptado=0;
														}
											} else {
			    							$aceptado=-1;
											}
								}
			 				break;
				case "1" :   // una linea            
      if ($numren==1){ //realiza calculo para uno
 			    switch ($tipodato){
		      case "N" :
			     if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
			     //	echo "hay un valor maximo";
					     $lvalmin=strlen ($siguno);
					     $lvalmax=strlen ($sigdos);
					     if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
		           if (($valcom > $valmin)  and ($valcom < $valmax)) {
							         $pondreal=$valpond;
								 							$aceptado=-1;
							      } else {
								 							$pondreal=0;
								 							$aceptado=0;
							 					}
						 			} else {
						    			if (($lvalmin==1) and ($lvalmax==2)) {    // es menorque y mayoro igual que
		              if (($valcom > $valmin)  and ($valcom <= $valmax)) {
							     							$pondreal=$valpond;
								 										$aceptado=-1;
							   						} else {
																	 $pondreal=0;
																	 $aceptado=0;
													   }
											  } else {
						       			if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
		                 if (($valcom >= $valmin)  and ($valcom < $valmax)) {
							         						$pondreal=$valpond;
								     									$aceptado=-1;
											 					  } else {
																     $pondreal=0;
																     $aceptado=0;
															    }
							   						} else {
							     							if (($lvalmin==2) and ($lvalmax==2)) { // es menorque y mayoro igual que
		                    if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
							           							$pondreal=$valpond;
								       										$aceptado=-1;
			 					    									} else {
								       									$pondreal=0;
								       									$aceptado=0;
							        							}
							     				   }   // fin de if 2 y 2
							   			   }  // fin de if 2 y 1
						       }   // fin de if 1 y 2
				      }
			     }else{  // no existe valor maximo
         //verifico q haya valor minimo
         //echo "solo hay valor minimo";
         //echo $valcom;
         //echo $valmin;
         //echo $siguno;
			        if($valmin!=""){
						   					$lvalmin=strlen ($siguno);
						     			if ($lvalmin==1) {    // es solo menorque o mayorque
							    						switch ($siguno) {
																	case "=" :
															   	if ($valcom==$valmin) {
															      $pondreal=$valpond;
																  			$aceptado=-1;
											 					  } else {
																     $pondreal=0;
																     $aceptado=0;
															    }
															     break;
																	case "<" :
														   			if ($valcom < $valmin) {
														      		$pondreal=$valpond;
															  					$aceptado=-1;
										 									} else {
															   				$pondreal=0;
															    			$aceptado=0;
														    		}
														   			break;
																	case ">" :
														   			if ($valcom > $valmin) {
														      			$pondreal=$valpond;
															  						$aceptado=-1;
										 									} else {
															   					$pondreal=0;
															    				$aceptado=0;
														    		}
														   			break;
																	}
							 						}else{
							    						switch ($siguno) {
																	case "<=" :
																	   if ($valcom <= $valmin) {
																	      $pondreal=$valpond;
																		     $aceptado=-1;
													 					 } else {
																		     $pondreal=0;
																		     $aceptado=0;
																	   }
																	   break;
																	case ">=" :
																	  //echo "entre a mayor o igual";
																	   if ($valcom>=$valmin ) {
																	      $pondreal=$valpond;
																		     $aceptado=-1;
													 					 } else {
																		     $pondreal=0;
																		     $aceptado=0;
																	   }
																	   break;
																	}  // fin del switch
														}	// fin de longitud =1
											} else
			          $aceptado=-1;
			        }
			        break;
		      case "C" :
		    // busco valor de opcion en catalogo
		         $rowca=DatosCatalogoDetalle::listaCatalogoDetalleOpc($datosModel, $op, "ca_catalogosdetalle");
		         if ($rowca){
		        	   $valop=$rowca["cad_idopcion"];
		         }
											if ($valmin!=""){
												  if ($valop == $valmin) {
												     $pondreal=$valpond;
												     $aceptado=-1;
												  } else {
												     $pondreal=0;
													    $aceptado=0;
												  }
											} else {
											    $aceptado=-1;
											}
											break;
		      } // fin de switch tipo de dato
						} else {
		   			$pondreal=0;
		   			$aceptado=0;
						}   // termina calculo una linea
				case "2";  // multilineas
		     switch ($tipodato){
		     case "N" :
		        if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
		        	//echo "entre a valor maximo en dos";
								     $lvalmin=strlen ($siguno);
								     $lvalmax=strlen ($sigdos);
								     if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
					           if (($valcom > $valmin)  and ($valcom < $valmax)) {
										         $pondreal=$valpond;
											        $aceptado=-1;
										      } else {
											        $pondreal=0;
											        $aceptado=0;
										      }
									    } else {
									        if (($lvalmin==1) and ($lvalmax==2)) {  // es menorque y mayoro igual que
					               if (($valcom > $valmin)  and ($valcom <= $valmax)) {
																		     $pondreal=$valpond;
																			    $aceptado=-1;
																		   } else {
																			    $pondreal=0;
																			    $aceptado=0;
																		   }
					            } else {
				       										if (($lvalmin==2) and ($lvalmax==1)) { // es menorque y mayoro igual que
                        if (($valcom >= $valmin)  and ($valcom < $valmax)) {
																			         $pondreal=$valpond;
																				        $aceptado=-1;
															 					   } else {
																				        $pondreal=0;
																				        $aceptado=0;
																			     }
					                } else {
					     														if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
                            if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
																			       	    $pondreal=$valpond;
																				           $aceptado=-1;
															 					       } else {
																				       				$pondreal=0;
																				           $aceptado=0;
																			         }
																			     }   // fin de if 2 y 2
																			  }  // fin de if 2 y 1
																	}   // fin de if 1 y 2
													}
										}else{  // no existe valor maximo
                            //verifico valormin
             if($valmin!="") {
										      $lvalmin=strlen ($siguno);
										      if ($lvalmin==1) {    // es solo menorque o mayorque
											        switch ($siguno) {
																			case "=" :
																			   if ($valcom==$valmin) {
																			      $pondreal==$valpond;
																				     $aceptado=-1;
															 					 } else {
																				     $pondreal=0;
																				     $aceptado=0;
																			   }
																			   break;
																			case "<" :
																			   if ($valcom < $valmin) {
																			      $pondreal=$valpond;
																				     $aceptado=-1;
															 					 } else {
																				     $pondreal=0;
																				     $aceptado=0;
																			   }
																			   break;
																			case ">" :
																				   if ($valcom > $valmin) {
																				      $pondreal=$valpond;
																			   		  $aceptado=-1;
																 					 } else {
																					     $pondreal=0;
																					     $aceptado=0;
																				   }
																				   break;
																			}
				 										 }else{
															    switch ($siguno) {
																			case "<=" :	//  
																		   if ($valcom <= $valmin) {
																		      $pondreal=$valpond;
													   						  $aceptado=-1;
														 					 } else {
																			     $pondreal=0;
																			     $aceptado=0;
																		   }
																		   break;
																			case ">=" :
																			   if ($valcom>=$valmin ) {
																			      $pondreal=$valpond;
																			  	   $aceptado=-1;
															 					} else {
																				     $pondreal=0;
																				     $aceptado=0;
																			  }
																			  break;
																			}  // fin del switch
				 											}	// fin de longitud =1
													}else
                 $aceptado=-1;
          }
										break;
		     case "C" : 
		        $rowca=DatosCatalogoDetalle::listaCatalogoDetalleOpc($datosModel, $op, "ca_catalogosdetalle");
		        if ($rowca){
		        	   $valop=$rowca["cad_idopcion"];
		        }
		        if ($valmin!=""){
													if ($valop == $valmin) {
													   $pondreal=$valpond;
													   $aceptado=-1;
													} else {
													   $pondreal=0;
														  $aceptado=0;
													}
										} else {
												  $aceptado=-1;
										}
										break;
						 } // fin switch tipodato	
				}  // fin switch tipoeva
				if(strlen($valcom)>0){
								if ($ntoma) {
									//echo "entre a ntoma";
											$datosController= array("idser"=>$sv,
																					"numrep"=>$nrep,
																		   "numsec"=>$numsec,
																		   "numreac"=>$numreac,
																		   "numcom"=>$numcom,
																		   "numcar"=>$numcar,
																		   "numcom2"=>$numcom2,
																		   "numcar2"=>$numcar2,
																		   "valcom"=>$valcom,
																		   "numren"=>$numren,
																		   "pondreal"=>$pondreal,
																		   "aceptado"=>$aceptado,
																		   "numcolar"=>1,
																		   "ntoma"=>$ntoma,
																		  );
															$respuesta=DatosEst::insertaRepEstandarDetalleToma($datosController, "ins_detalleestandar");
								} else {
									//echo "inserte sin ntoma";
															$datosController= array("idser"=>$sv,
																					"numrep"=>$nrep,
																		   "numsec"=>$numsec,
																		   "numreac"=>$numreac,
																		   "numcom"=>$numcom,
																		   "numcar"=>$numcar,
																		   "numcom2"=>$numcom2,
																		   "numcar2"=>$numcar2,
																		   "valcom"=>$valcom,
																		   "numren"=>$numren,
																		   "pondreal"=>$pondreal,
																		   "aceptado"=>$aceptado,
																		   "numcolar"=>1,

																		 ); 

														 $respuesta=DatosEst::insertaRepEstandarDetalle($datosController, "ins_detalleestandar");
														 

								}	 // cierre de if ntoma	   
							//	$rsi=mysql_query($sSQL);

				}	// cierre de if valcom
			} // cierre del foreach general
		} else {
		  //echo "no la encontre";	
		}  // fin de if
	}  // cierre de funcion	


	public function botonRegresaEstController(){		
		
		$sec = $_GET["sec"];
		$ser = $_GET["sv"];

		$datini=SubnivelController::obtienedato($sec,1);
		$londat=SubnivelController::obtienelon($sec,1);
		$numsec=substr($sec,$datini,$londat);



	   echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$numsec.'&ts=E&sv='.$ser.'"> Cancelar </a></button>
	';

	}

public function borraRepEstandarDetalle(){
		if(isset($_GET["idb"])){
		  $idb = $_GET["idb"];
		  $sv = $_GET["sv"];
		  $numrep=$_GET["nrep"];
		  $idsec=$_GET["sec"];

		  $respuesta = DatosEst::borraestandarDetalle($sv, $numrep, $idb,  $idsec, "ins_detalleestandar");
		  //echo $respuesta;
		}
	}

}  // fin de la clase
 
?>