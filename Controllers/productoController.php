<?php
class ProductoController{
    
   

	public function vistaProductoController(){
		if (isset($_GET["sec"])) {
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];

		$tiposec="V";

	$respuesta =DatosAbierta::actualizatiporeac($seccion, $servicioController,$tiposec, "cue_secciones");

	echo '<div class="row">
    <div class="col-md-12" style="
    margin-top: 7px;
"><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevoproducto&id='.$seccion.'&ids='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  NUEVO  </a></button>
     </div>
     </div>';


		echo 	'<section class="content container-fluid">
			<div class="box">
		 			
		              <table class="table" table-condensed>
		                <tr>
		                  <th style="width: 5%">No.</th>
		                  <th style="width: 36%">NOMBRE DEL DATO</th>
		                  <th style="width: 15%">LUGAR</th>
		                  <th style="width: 10%">BORRAR</th>
		                </tr>';

		$respuesta =DatosProducto::vistaProductosModel($servicioController, "cue_valoresfijos");
			$i=1;
			foreach($respuesta as $row => $item){
				echo '  <tr>
	              <td>'.$i.'</td>
	              <td><a href="index.php?action=editaproducto&op='.$item["gen_numdato"].'&id='.$seccion.'&ids='.$servicioController.'">'.$item["gf_nombreesp"].'</a>
	              </td>
	                  <td>'.$item["gen_lugarsyd"].'
	                  </td>
	                  
	                <td><a href="index.php?action=sn&ids='.$seccion.$item["gen_numdato"].'&sv='.$item["gen_claveservicio"].'&ts=V&sec='.$seccion.'">borrar</a>
	                </tr>';
	                $i++;
			}
		
		echo '</table>
		</div>';
		} //if               
	}

	public function nuevoProductoController(){
	    
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
		//$opcion=$_GET["op"];

	    
	   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
	   //echo '<input type="hidden" name="op" value="'.$opcion.'">';       
	}


	public function listadatosproducto(){

		$respuesta = DatosProducto::datosProductosModel("cue_valoresfijos");
		foreach($respuesta as $row => $item){
		  echo '<option value='.$item["gf_numdato"].'>'.$item["gf_nombreesp"].'</option>';
		} 
	}	

   	public function botonRegresaProductoController(){
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
   		echo ' <a  class="btn btn-default" style="margin-left: 10px" href="index.php?action=sn&sec='.$datosController.'&sv='.$servicioController.'&ts=V"> Cancelar </a>';
	}

	public function registrarProductos(){              
		if(isset($_POST["lugarsyd"])){
	      $datosServicio=$_POST["idser"];
	      $seccion=$_POST["idsec"];
		  $respuesta =DatosGenerales::CalculaultimoDatoModel($datosServicio, "cue_generales");
		  $i=0;
		  $numdato=0;

		  if (isset($respuesta["numdato"])) {
				foreach($respuesta as $row => $item){
	     				$i=$i+1;
	    		}
	       } 	

	       if ($i>0) {
				//foreach($respuesta as $row => $item){
				   $numdato=$respuesta["numdato"];
				//}   
			} else {
				$numdato=0;
			}	
				      
	     
	     $numdato = $numdato+1;
	     //echo $datosServicio.' '.$numdato.' '.$_POST["lugarsyd"];
	     $datosController= array("ids"=>$datosServicio,
	      						   "numr"=>$numdato,
	                               "lugarsyd"=>$_POST["lugarsyd"],
	                               "G"=>'V',
	                               "datoref"=>$_POST["idcampo"],
	                               ); 

		$respuesta =DatosGenerales::insertageneralModel($datosController, "cue_generales");
		if ($respuesta=="success"){

			echo "
				<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$seccion."&ts=V&sv=".$datosServicio."';
				</script>
				";
		}
	}

   }


   public function borraProductoController(){
		if (isset($_GET["ids"])) {
			$ids=$_GET["ids"];
			$respuesta = DatosGenerales::borrageneralModel($ids,"cue_generales");
		}
	}


	public function editaProductoController(){
	    $opcion = $_GET["op"];
		$servicio = $_GET["ids"];
		$sec=$servicio.$opcion;
		//echo $sec;

		$respuesta = DatosProducto::editarProductoModel($sec, "cue_generales");
		//echo $respuesta;
		foreach($respuesta as $row => $item){
			$numcam=$item["gen_numdatoref"];
			//echo $numcam;
			$lista = DatosProducto::datosProductoModel("cue_valoresfijos");
				foreach($lista as $row => $iteml){
					if ($iteml["gf_numdato"]==$numcam){
		 				echo '<option value='.$iteml["gf_numdato"].' selected="selected">'.$iteml["gf_nombreesp"].'</option>';
					} else {
						echo '<option value='.$iteml["gf_numdato"].'>'.$iteml["gf_nombreesp"].'</option>';
					} // if
		   		} // foreach
		   	echo '</select>
                </div>
                <div class="form-group col-md-12">
                 <label >LUGAR EN ARCHIVO</label>
               <div class="col-sm-10">
                    <input name="lugarsyd" id="lugarsyd" class="form-control" value="'.$item["gen_lugarsyd"].'">
                </div>';	
		}// foreach
	}

	public function botonRegresarProductoController(){
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
   		echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$datosController.'&sv='.$servicioController.'&ts=V"> Cancelar </a></button>';
	}
	
	public function variablesEdProductoController(){
	    
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
		$opcion=$_GET["op"];

	    
	   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
	   echo '<input type="hidden" name="op" value="'.$opcion.'">';       
	}

	public function actualizaProductoController(){
		if(isset($_POST["lugarsyd"])){
	      $datosServicio=$_POST["idser"];
	      $seccion=$_POST["idsec"];
	      $op=$_POST["op"];
	      $idcampo=$_POST["idcampo"];
	      $nsec=$datosServicio.$op;
	      $datosController= array("nsec"=>$nsec,
	                               "lugarsyd"=>$_POST["lugarsyd"],
	                               "datoref"=>$idcampo,
	                               ); 
	      $respuesta = DatosProducto::actualizaProductosModel($datosController, "cue_generales");
	      if ($respuesta=="success"){

			echo "
				<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=".$seccion."&ts=V&sv=".$datosServicio."';
				</script>
				";
		}
		}
	}
	
	

	public function reporteProductoController(){
       include ("Utilerias/leevar.php");
	
		switch($admin){
			case "insertar":	
			$this->insertarProducto();
			break;
			case "eli":
				$this->eliminarRepProducto();
				break;
			default	:
				
		
			echo '<div class="row">
	<div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; "><a href="index.php?action=rsn&sec='.$sec.'&sv='.$sv.'&ts=VN&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
	 </div>
	 </div>';



		$datosController= array("sec"=>$sec,
	                            "sv"=>$sv,
	                            "nrep"=>$nrep,
	                               ); 
	      
	echo '

    <!-- Main content -->
    <section class="content container-fluid">';



	$respuesta = DatosProducto::vistaRepProductosModel($datosController, "ins_detalleproducto");
	$i=1;
	$bac=1;
		foreach($respuesta as $row => $item){
			
			if(($i-1)%3==0){
				echo '<div class="row">';
				$bac=0;
			}
			
	echo '
      <!----- Inicia contenido ----->
       
        <div class="col-md-4" >
          <div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title"></h3>

              <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->

            <div class="box-body">
             <div class="row" style="border-bottom: #F4F4F4 Solid 1px">
			<div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-text"><strong>No.</strong></h5>
                    <span class="description-text-2">'.$item["ip_numrenglon"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-text"><strong>No. de sistema</strong></h5>
                    <span class="description-text-2">'.$item["ip_numsistema"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
				</div>
              <div class="row" style="border-bottom: #F4F4F4 Solid 1px; padding: 10px 0 10px 0">
              	  <div class="col-sm-12">
                    <ul class="nav nav-stacked">
                      <li><strong>Producto  :    ';
                      	# busca el nombre del producto
                      $datosController= array("idcat"=>2,
	                            "idop"=>$item["ip_descripcionproducto"],
	                               ); 
	    
					   $respProd = DatosProducto::nombreOpProducto($datosController, "ca_catalogosdetalle");
					  	
                        echo $respProd["cad_descripcionesp"];
                       echo '</strong> </li>
                    </ul>
                </div>
              </div>
              <div class="row" style="border-bottom: #F4F4F4 Solid 1px">
			<div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Cajas</strong></h5>
                    <span class="description-text-2">'.$item["ip_numcajas"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Condicion</strong></h5>
                    <span class="description-text-2">';
                    if ($item["ip_condicion"]=="V"){
                    	echo "VIGENTE";
                    } else if ($item["ip_condicion"]=="C"){
                    	echo "CADUCO";
                    }	
                    echo '</span>
                  </div>
                  <!-- /.description-block -->
                </div>
				</div>
              <div class="row" style="border-bottom: #F4F4F4 Solid 1px">';
	//		<div class="col-sm-6 border-right">';
//                   <div class="description-block">
//                     <h5 class="description-text"><strong>Fecha de produccion</strong></h5>
//                     <span class="description-text-2">';

// 					$fecprod=SubnivelController::cambiaf_a_normal($item["ip_fechaproduccion"]);

//                      echo $fecprod.'</span>
//                   </div>
//                   <!-- /.description-block -->
//                 </div>
           echo ' <div class="col-sm-12 border-right">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Fecha de caducidad</strong></h5>
                    <span class="description-text-2">';
                    $feccad=SubnivelController::cambiaf_a_normal($item["ip_fechacaducidad"]);
                    echo $feccad.'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
				</div>
				<div class="row">';
// 			<div class="col-sm-4 border-right">
//                   <div class="description-block">
//                     <h5 class="description-text"><strong>Edad dias</strong></h5>
//                     <span class="description-text-2">'.$item["ip_edaddias"].'</span>
//                   </div>
//                   <!-- /.description-block -->
//                 </div>
           echo ' <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Semanas</strong></h5>
                    <span class="description-text-2">'.$item["ip_semana"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Estatus</strong></h5>
                    <span class="description-text-2">';
					if ($item["ip_estatus"]=="I"){
                    	echo "INSTALADO";
                    } else if ($item["ip_estatus"]=="A"){
                    	echo "ALMACENADO";
                    }	
                    echo '</span>
                  </div>
                  <!-- /.description-block -->
                </div>
				</div>
              
               <div class="row" >
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                   
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                 <a href="index.php?action=rsn&ts=V&sv='.$sv.'&nrep='.$nrep.'&pv='.$pv.'&secc='.$sec.'.'.$item["ip_numrenglon"].'&admin=eli" class="btn btn-block btn-info"><i class="fa fa-trash"></i></a>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
       ';
                    if(($i)%3==0){
                    	
                    	echo '</div>';
                    	$bac=1;
                    }
                    $i++;
	} // foreach
echo '</section>';
		}
}

public function nuevoRepProductoController(){
	  $sv = $_GET["sv"];
	  $idc = $_GET["idc"];
	  $sec = $_GET["sec"];
	  $nrep =$_GET["nrep"];


echo '

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> ALTA DE PRODUCTO <small></small></h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">


      <!----- Inicia contenido ----->
        <div class="row">
		<div class="col-md-12">
        <div class="box box-info">
            
            <div class="box-body">
  			<form role="form"  method="post" action="index.php?action=rsn&sec='.$sec.'&sv='.$ser.'&ts=V&admin=insertar&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'">          
              <div class="form-group">
               <div class="form-group col-md-12">
                <label for="Sistemano" class="col-sm-2 control-label">SISTEMA NO.</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="numsistema" name="numsistema" placeholder="">
                </div>
				  </div>
              <div class="form-group col-md-12">
                <label for="Producto" class="col-sm-2 control-label">PRODUCTO</label>
                <div class="col-sm-10">
                    
				<select class="form-control" name="numcatalogo" id="numcatalogo">
					  <option value="">--- Elija el catalogo ---</option>';
				 
			    $respuestac = DatosCatalogoDetalle::listaCatalogoDetalle(2, "ca_catalogosdetalle");
				foreach($respuestac as $row => $itemc){
					echo '<option value='.$itemc["cad_idopcion"].'>'.$itemc["cad_descripcionesp"].'</option>';
					}

					echo '</select>
				  </div>
				 </div> 
              <div class="form-group col-md-12">
                <label for="TotalDeCajas" class="col-sm-2 control-label">TOTAL DE CAJAS</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="registros" name="lugarcajasno" placeholder="">
                </div>
				  </div>
 <div class="form-group col-md-12">
                <label for="feccad1" class="col-sm-2 control-label">FECHA CADUCIDAD</label>
                <div class="col-sm-10">
   <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                <input type="text" name="feccad" id="datepicker" class="form-control" size="10" maxlenght="10">
				</div>
</div>
				  </div>


';

	


                 echo ' <div class="row">
		<div class="col-md-12" >
		<a  class="btn btn-default pull-right" style="margin-right: 18px margin-top:15px; margin-bottom:15px;" 
href="index.php?action=rsn&sec='.$sec.'&sv='.$sv.'&ts=V&idc='.$idc.'&pv='.$_GET["pv"].'&nrep='.$nrep.'" >  CANCELAR  </a>
		<button type="submit" class="btn btn-info pull-right">GUARDAR</button>
		 </div>
		 </div>
              </div>
              </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
			</div>
        </div>
	  <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
 ';
  

}

public function insertarProducto(){
	include ('Utilerias/leevar.php');
	
	$numseccom = $sec;
	
	$numrep=$nrep;


	$idser=$_SESSION["rservicio"];
	
	//obtiene el numero de cuenta
	
	$numcuenta=$idc;
	
	$datinisec=SubnivelController::obtienedato($numseccom,1);
	$londatsec=SubnivelController::obtienelon($numseccom,1);
	$numsec=substr($numseccom,$datinisec,$londatsec);
	$datinireac=SubnivelController::obtienedato($numseccom,2);
	$londatreac=SubnivelController::obtienelon($numseccom,2);
	$numreac=substr($numseccom,$datinireac,$londatreac);
	$datinicom=SubnivelController::obtienedato($numseccom,3);
	$londatcom=SubnivelController::obtienelon($numseccom,3);
	$numcom=substr($numseccom,$datinicom,$londatcom);
	$datinicar=SubnivelController::obtienedato($numseccom,4);
	$londatcar=SubnivelController::obtienelon($numseccom,4);
	$numcar=substr($numseccom,$datinicar,$londatcar);
	$datinicom2=SubnivelController::obtienedato($numseccom,5);
	$londatcom2=SubnivelController::obtienelon($numseccom,5);
	$numcom2=substr($numseccom,$datinicom2,$londatcom2);
	
	//validar si la seccion del reporte ya existe, si no, lo das de alta, si si, lo editas
	if ($numren){
		$ssqle=("SELECT * FROM `ins_detallerproducto` WHERE `ins_detallerpoducto`.`ip_claveservicio` = ".$idser." 
AND `ins_detalleproducto`.`ip_numreporte` = ".$numrep."  
AND concat(ip_numseccion,'.',ip_numreactivo,'.',ip_numcomponente,'.',ip_numcaracteristica1,'.',
ip_numcaracteristica2) = '".$numseccom."' and ip_numrenglon=".$numren);
		
		$numRows = DatosProducto::buscarRenglon($idser, $numrep, $numseccom, $numren, "ins_detallerproducto");
		
	}else{
		$numRows=0;
	}
	
	if ($numRows != 0){	//no existe en la base, lo doy de alta
		$operac="actualiza";
		
	}else{
		$operac="nueva";
	}
	
	try{
		
// 	for($i=1;$i<=$registros;$i++)
// 	{
		//busca numero de renglon
		if ($operac=="nueva"){
			// todo esto se repetirá n veces
			$sqlnr="select max(ip_numrenglon) as claveren 
FROM `ins_detalleproducto` WHERE `ins_detalleproducto`.`ip_claveservicio` = ".$idser." 
AND `ins_detalleproducto`.`ip_numreporte` = ".$numrep." AND ip_numseccion = '".$numseccom."';";
			$numren=DatosProducto::buscarRenglon2($idser, $numrep, $numseccom,  "ins_detalleproducto");
			$numren++;
		}
		//echo "xx".eval("$lugarcajasno".$i);
		//die();
	//	$sinetiq="sinetiq".$i;
	//	$lugarcajasno="lugarcajasno".$i;
	//	$feccad="feccad".$i;
		
		if($feccad!="")
			$feccad=SubnivelController::fecha_mysqlbs($feccad);
			
			if($numsec==6)
				$estatus="I";
			if($numsec==7)
				$estatus="A";
			if ($sinetiq ){
				$valsinet=-1;
			}else{
				$valsinet=0;
			}
			//calcula fecha de producccion
			
			//  2.- guarda o actualiza la seccion
			if ($operac=="nueva") {
				$sSQL= "insert into ins_detalleproducto (ip_claveservicio, ip_numreporte,
 ip_numseccion, ip_numrenglon, ip_numsistema, ip_descripcionproducto, ip_numcajas, 
ip_fechaproduccion, ip_fechacaducidad, ip_estatus, ip_sinetiqueta) values ('".$idser."',
 ".$numrep.", ".$numsec.", ".$numren.", ".$lugarsisno.", '".$lugarprod."', ".$lugarcajasno.",
 '".$fecprod."', '".$$feccad."', '".$$estatus."', ".$valsinet.");";
				
				//			echo $sSQL;
				// actualiza calculos
				//$sqlcal="SELECT datediff(now(),ip_fechaproduccion) as edad, if((datediff(now(),ip_fechaproduccion))<60,'Vigente','Caduco') as Condicion, ceil(if((datediff(now(),ip_fechaproduccion))>0,(datediff(now(),ip_fechaproduccion))/7,1)) as semana FROM ins_detalleproducto where ip_claveservicio='".$idser."' and ip_numreporte=".$numrep." and ip_numseccion=".$numsec." and ip_numrenglon=".$numren;
				$sqlfecprod="update ins_detalleproducto set ip_fechaproduccion=(ip_fechacaducidad+ interval -70 day) where ip_claveservicio='".$idser."' and ip_numreporte=".$numrep." and ip_numseccion=".$numsec." and ip_numrenglon=".$numren;
				//busca fecha de inspeccion
				$sqlfecins="SELECT `ins_generales`.`i_fechavisita` FROM `ins_generales` WHERE `ins_generales`.`i_claveservicio` =  '".$idser."' AND `ins_generales`.`i_numreporte` =  '".$numrep."'";
				
				$rsin=DatosGenerales::vistaReporteGenerales($idser, $numrep, "ins_generales");
			
				$fecins=$rsin['i_fechavisita'];
				
			
				// $sqlcal="Update ins_detalleproducto set ip_edaddias=datediff('".$fecins."',ip_fechaproduccion), ip_condicion= if((datediff('".$fecins."',ip_fechaproduccion))<=70,'V','C'), ip_semana=ceil(if((datediff('".$fecins."',ip_fechaproduccion))>0,(datediff('".$fecins."',ip_fechaproduccion))/7,1)) where ip_claveservicio='".$idser."' and ip_numreporte=".$numrep." and ip_numseccion=".$numsec." and ip_numrenglon=".$numren;
				
				if( $valsinet==0) //para los que tienen etiqueta
					$sqlcal="update ins_detalleproducto set ip_edaddias=datediff('".$fecins."',ip_fechaproduccion) , ip_condicion=if((datediff('".$fecins."',ip_fechaproduccion))<=70,'V','C'),  ip_semana=if((datediff('".$fecins."',ip_fechaproduccion))>0,if(((datediff('".$fecins."',ip_fechaproduccion))/7)>0 and ((datediff('".$fecins."',ip_fechaproduccion))/7)<=1,0,ceil((datediff('".$fecins."',ip_fechaproduccion)/7))-1),0)  where ip_claveservicio='".$idser."' and ip_numreporte=".$numrep." and ip_numseccion=".$numsec." and ip_numrenglon=".$numren.";";
			} else {    // ya existe el registro
				$sSQL=("Update ins_detalleabierta Set ida_descripcionreal='".$descom."', ida_aceptado=".$valacepta ." where ida_claveservicio = '".$idser."' and ida_numreporte =".$numrep." and ida_numseccion=".$numsecc." and ida_numreactivo=".$numreac." and ida_numcomponente=".$numcom." and ida_numcaracteristica1=".$numcar." and ida_numcaracteristica2=".$numcom2." and ida_numcaracteristica3=".$numcar2.";");
			}  // termina if de guardado de info
			$rsi=DatosProducto::insertarProducto($idser, $numrep, $numsec, $numren, $numsistema, $numcatalogo, $lugarcajasno,null, $feccad, $estatus, null);
			$rsp=DatosProducto::actualizarFechaProduccion($idser, $numrep, $numsec, $numren,"ins_detalleproducto" );
			$rse=DatosProducto::actualizarEdad($idser, $numrep, $numsec, $numren, $fecins, "ins_detalleproducto");
//	} //fin for para todos los renglones
// 	if ($comengen) { // guarda comentario de seccion
// 		//valida si el comentario ya existe.
// 		$ssqlco=("SELECT * FROM `ins_secciones` WHERE `ins_secciones`.`is_claveservicio` =  ".$idser." AND `ins_secciones`.`is_numreporte` =  '".$numrep."' AND `ins_secciones`.`is_numseccion` =  '".$numsecc."'");
// 		$rsco = mysql_query($ssqlco);
// // 		$numRowsc = mysql_num_rows($rsco);
// // 		if ($numRowsc == 0){	//no existe en la base, lo doy de alta
// // 			$sSQL= "insert into ins_secciones (is_claveservicio, is_numreporte, is_numseccion, is_comentario) values (".$idser.", ".$numrep.", ".$numsecc.", '".$comengen."');";
			
			
// // 		} else {    // ya existe el registro
// // 			$sSQL=("Update ins_secciones Set is_comentario='".$comengen."' where  is_claveservicio = '".$idser."' and is_numreporte ='".$numrep."' and is_numseccion=".$numsecc.";");
// // 		}
// 	}
	
	$local="Location: MEIprincipal.php?op=V&secc=".$numseccom;
	echo "
		<script type='text/javascript'>
	     window.location.href='index.php?action=rsn&sec=".$numseccom."&ts=V&sv=".$idser."&nrep=".$numrep."&pv=".$_SESSION["runeg"]."';
		</script>";
	}catch(Exception $ex){
		echo Utilerias::mensajeError($ex->getMessage());
		
		
	}
}

public function nuevoRepDetProductoController(){

	
	$ncajas=$_POST["registros"];	

//	if (isset($_POST["registros"]) {
//   		echo "<script>alert('Usuario insertado exitosamente');</script>";   
//    }

	

   	foreach($_POST as $nombre_campo => $valor){
				$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
				eval($asignacion);
		 	echo ($asignacion);
			} 

echo '
    <div class="row">
           <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">Sistema No.</h4>
            </div>
            <div class="box-header">
              <h4 class="box-title">Producto</h4>
            </div>
            <div class="box-header">
              <h4 class="box-title">No. de Cajas</h4>
            </div>
          
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 5%">No.</th>
                  <th style="width: 20%">FECHA CADUCI</th>
                  <th style="width: 20%">NUM CAJAS</th>
                  <th style="width: 20%">ESTATUS</th>
                  <th style="width: 20%">SIN ETIQUETA</th>
                </tr>
               </table>
            </div>
           
          <!-- /.box -->
        </div>
        </div>


	  <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->';




}

	public function eliminarRepProducto(){
		include "Utilerias/leevar.php";
		$idsec = $secc;
		$idser=$_SESSION["rservicio"];
		
		$numrep=$nrep;
		
		
		
		// calcula el id del servicio
		$datini=SubnivelController::obtienedato($secc,1);
		$londat=SubnivelController::obtienelon($secc,1);
		$seccion=substr($secc,$datini,$londat);
		
		$ssqle=("DELETE FROM ins_detalleproducto 
WHERE ip_claveservicio = ".$idser." AND ip_numreporte = ".$numrep."  
AND concat(ip_numseccion,'.',ip_numrenglon) = '".$idsec."'");
		//echo $ssqle;
		try{
		DatosProducto::eliminarProducto($idser, $numrep, $idsec,  "ins_detalleproducto");	
		
		echo "
		<script type='text/javascript'>
	     window.location.href='index.php?action=rsn&sec=".$seccion."&ts=V&sv=".$idser."&nrep=".$numrep."&pv=".$_SESSION["runeg"]."';
		</script>";
	}catch(Exception $ex){
		echo Utilerias::mensajeError($ex->getMessage());
		
		
	}
	}

}
?>	
