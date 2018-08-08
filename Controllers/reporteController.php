<?php
class ReporteController{

	public function vistaRnomservController(){
	    $datosController = $_GET["sv"];
	    $nrep=$_GET["nrep"];
	    $un=$_GET["pv"];
	    $idc=$_GET["idc"];
	    $respuesta = DatosSeccion::vistaNombreServModel($datosController,"ca_servicios");
	   	#busca el cliente

	    echo '<li>CLIENTE: '.$respuesta["cli_nombre"]. '</a></li>
	    <li><a href="index.php?action=rlistaunegocio&sv='.$datosController.'&idc='.$idc.'">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>
	    	<li><a href="index.php?action=editarep&idc='.$idc.'&sv='.$datosController.'&pv='.$un.'&nrep='.$nrep.'">REPORTE: '.$nrep. '</a></li>';
	    #busca nombre de punto de venta
	    $unegocio = DatosUnegocio::vistaUnegocioDetalle($un,"ca_unegocios");
	    echo '<li><a href="index.php?action=runegociodetalle&sv='.$datosController.'&un='.$un.'&idc='.$idc.'">PUNTO DE VENTA: '.$unegocio["une_descripcion"]. '</a></li>';
	    $repgen = DatosReporte::ReporteGenerales($datosController, $nrep, "ins_generales");
	    //echo $repgen;
		$fecvis=SubnivelController::cambiaf_a_normal($repgen["i_fechavisita"]);
		//$fecvis=$repgen["i_fechavisita"];
	    echo '<li><a href="index.php?action=runegociodetalle&idc='.$idc.'&sv='.$datosController.'&un='.$un.'&idc='.$idc.'">FECHA VISITA: '.$fecvis. '</a></li>';
	    
	}

	public function vistaSeccionReporteController(){
	    $numser = $_GET["sv"];
	    $nrep=$_GET["nrep"]; 
	    $pv=$_GET["pv"];
	    $idc=$_GET["idc"];

	    $respuesta =DatosSeccion::vistaSeccionModel($numser,"cue_secciones");

	    foreach($respuesta as $row => $item){
	      echo '
	        <div class="col-md-4" >
	          <div class="box box-info" >
	            <div class="box-header with-border">
	            <h3 class="box-title">No.'. $item["sec_numseccion"].'</h3>

	              <div class="box-tools pull-right">
	               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	              <!-- /.box-tools -->
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              
	        <div class="row col-sm-12">
	             <div class="arrow">
	                  <div class="box-footer no-padding">
	                    <ul class="nav nav-stacked">
	                      <li><a><strong>'. $item["sec_descripcionesp"].'</strong></a></li>
	                    </ul>
	                </div>
	              </div>
	        </div>      
	               <div class="row" >
	                <div class="col-sm-4 border-right">
	                  <div class="description-block">
	                 
	                    <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=rsn&sec='.$item["sec_numseccion"].'&ts='.$item["sec_tiposeccion"].'&sv='.$item["ser_claveservicio"].'&nrep='.$nrep.'&pv='.$pv.'&idc='.$idc.'"> Detalle </a></span></button>


	                  </div>
	                  <!-- /.description-block -->
	                </div>
	                <!-- /.col -->
	                <div class="col-sm-4 border-right">
	                  <div class="description-block">
	                   <button type="button" class="btn btn-block btn-info"><span style="font-size: 14px"><a href="index.php?action=repcoment&sec='.$item["sec_numseccion"].'&sv='.$item["ser_claveservicio"].'&nrep='.$nrep.'&pv='.$pv.'">! </a></span></button>
	                  </div>
	                  <!-- /.description-block -->
	                </div>
	                <!-- /.col -->
	                <div class="col-sm-4">
	                  <div class="description-block">
	                 <button type="button" class="btn btn-block btn-info"><a href="index.php?action=repimg&idb='.$item["sec_numseccion"].'&idser='.$item["ser_claveservicio"].'"><i class="fa fa-image"></i></a></button>
	                  </div>
	                  <!-- /.description-block -->
	                </div>
	                <!-- /.col -->
	              </div> 
	                   </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	       
	        
	    </div>';
	             

	    }
	  } 

	public function SeleccionaseccionReporteController(){
			$seccion = $_GET["sec"];
			$tiposec = $_GET["ts"];
			$servicio = $_GET["sv"];
			$nrep = $_GET["nrep"];
			//echo $seccion;

		if (isset($_GET["ts"])) {
			switch($_GET["ts"]) {
			case "G" : 	       
		      $ingreso = new GeneralController();
			  $ingreso -> reporteGeneralController();
			  break;
			case "E" : 	       
		      $ingreso = new EstandarController();
		      $ingreso -> reporteEstandarController();
			  break;
			case "ED" : 	       
		      $ingreso = new EstandarController();
			  $ingreso -> reporteEstandarDetalle();
			  break;
			case "EN" : 	       
		      $ingreso = new EstandarController();
		      // registra estandar
			  $ingreso -> nuevoRepEstandar();
			  $ingreso -> insertaReporteEstandar();
			  break;
			case "TM" : 	       
		      $ingreso = new EstandarController();
			  //$ingreso -> vistaEstDetController();
			  break;  
		    case "P" :
		       $ingreso = new PonderacionController();
			   $ingreso -> reportePonderaController();
		       break;
		    case "PN" :
		       $ingreso = new PonderacionController();
			  // $ingreso -> borrarPonderaController();
			  // $ingreso -> vistaConsultaPonderaController();
		       break;
		   case "SN" :
		       $ingreso = new seccionController();
			  // $ingreso -> borrarPonderaController();
			  // $ingreso -> vistaConsultaPonderaSeccionController();
		       break;
		  
		    case "A" :  
		       $ingreso = new abiertaController();		    
			   $ingreso -> reporteAbiertaController();   
		       break;
		    case "AD" :       
		       $ingreso = new abiertaController();
			   $ingreso ->reporteAbiertaDetalleController();  
			   //$ingreso -> vistaAbDetController();
		       break;
		    case "V" :       
		       $ingreso = new ProductoController();
			   $ingreso -> reporteProductoController();
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

	public function vistaNombreSeccion(){

		$seccion = $_GET["sec"];
		$ts = $_GET["ts"];
		$servicio = $_GET["sv"];
		$nrep=$_GET["nrep"];
		$pv=$_GET["pv"];
		$idc=$_GET["idc"];
		///echo $seccion;

		#lee seccion
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
	 	

	 	if ($numreac!=0) {
	 		if ($numcom==0) { // segundo nivel
	 			$respuesta =DatosPond::vistanombrepondera($servicio, $seccion,  "cue_reactivos");
				echo ' SECCION '.$seccion.' : '.$respuesta["r_descripcionesp"];
	 		} else {
	 			if (isset($_GET["ts"])) {
					$nsec=$numsec.'.'.$numreac.'.'.$numcom;
						switch($_GET["ts"]) {
						case "AD" : 
							$respuesta =DatosAbierta::vistaNomSecAbierta($servicio, $seccion, "cue_reactivosabiertos");
						       
					     	echo ' SECCION '.$nsec.' : '.$respuesta["descomp"];
						  break;
						case "ED" : 	   
						$respuesta =DatosEst::vistaNomSecEstandar($servicio, $nsec, "cue_reactivosestandar");    
					     echo ' SECCION '.$nsec.' : '.$respuesta["re_descripcionesp"]; break;
					     case "EN" : 	   
						//$respuesta =DatosEst::vistaNomSecEstandar($servicio, $nsec, "cue_reactivosestandar");    
					     echo ' SECCION '.$nsec.' NUEVO REGISTRO '; break;
						 } // fin de switch 

					}
	 		}	

	 	} else {
	 		if ($numcom==0){  //primer nivel, es de seccion
			$respuesta =DatosSeccion::vistaNombreSeccionModel($seccion, $servicio, "cue_secciones");
		echo ' SECCION '.$seccion.' : '.$respuesta["sec_descripcionesp"];
			} else { 
					if (isset($_GET["ts"])) {
						$nsec=$numsec.'.'.$numreac.'.'.$numcom;
						switch($_GET["ts"]) {
						case "AD" : 	       
					      $respuesta =DatosAbierta::vistaNomSecAbierta($servicio, $seccion, "cue_reactivosabiertos");
						       
					     	echo ' SECCION '.$nsec.' : '.$respuesta["descomp"];
						  break;
						case "ED" : 	   
						$respuesta =DatosEst::vistaNomSecEstandar($servicio, $nsec, "cue_reactivosestandar");    
					     echo ' SECCION '.$nsec.' : '.$respuesta["re_descripcionesp"]; break;
					    case "EN" : 	   
						//$respuesta =DatosEst::vistaNomSecEstandar($servicio, $nsec, "cue_reactivosestandar");    
					     echo ' SECCION '.$seccion.' NUEVO REGISTRO '; break;
					
						 } // fin de switch 

					}	// fin del if 
			}


	 	}

	}  // fin de funcion




public function botonNuevoRep(){
	$idc=$_GET["idc"];
	$sv=$_GET["sv"];
	$pv=$_GET["un"];
   echo '<button type="button" class="btn btn-block btn-primary" style="width: 80%"><a href="index.php?action=nvorep&idc='.$idc.'&pv='.$pv.'&sv='.$sv.'"> Nuevo </a></button>';

}


	public function vistaSeccionNuevoReporte(){
		#lee variables
		$numser = $_GET["sv"];
	    $pv=$_GET["pv"];
	    $idc=$_GET["idc"];

	    #valida estatus del punto de venta
	    $punvta =DatosUnegocio::UnegocioCompleta($pv, "ca_unegocios");
	    $estatus=$punvta["une_estatus"];
	    $fecest=$punvta["une_fechaestatus"];

	    if ($estatus == 1) {
	    	#crea numero de reporte
	    	$ulrep =DatosReporte::CalculaNumReporte($numser, "ins_generales");
	    	if ($ulrep) {
	    		$numrep=$ulrep["numrep"];
	    	} else {
	    		$numrep=0;
	    	}
	    	$numrep+=1;
	    	echo "<script type='text/javascript'>
				window.location.href='index.php?action=editarep&idc=".$idc."&pv=".$pv."&sv=".$numser."&nrep=".$numrep."';
				</script>
				";
	    	# lo redirijo a edita reporte
	    }	else {
			print("<script language='javascript'>alert('No es posible registrar el reporte. El punto de venta No se encuentra activo'); </script>");
			echo "<script type='text/javascript'>
				window.location.href='index.php?action=runegociodetalle&idc=".$idc."&un=".$pv."&sv=".$numser."';
				</script>
				";
	    }
	  }  // function


} // fin de clase

?>
