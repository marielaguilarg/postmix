<?php
class ProductoController{
    
   

	public function vistaProductoController(){
		if (isset($_GET["sec"])) {
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];

	echo '<div class="row">
    <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevoproducto&id='.$seccion.'&ids='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
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
   		echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$datosController.'&sv='.$servicioController.'&ts=V"> Cancelar </a></button>';
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

		$nrep = $_GET["nrep"];
		$sec = $_GET["sec"];
		$sv=$_GET["sv"];

		$datosController= array("sec"=>$sec,
	                            "sv"=>$sv,
	                            "nrep"=>$nrep,
	                               ); 
	      
	echo '

    <!-- Main content -->
    <section class="content container-fluid">';



	$respuesta = DatosProducto::vistaRepProductosModel($datosController, "ins_detalleproducto");

		foreach($respuesta as $row => $item){
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
                    <h5 class="description-text">No.</h5>
                    <span class="description-text-2">'.$item["ip_numrenglon"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-text">No. de sistema</h5>
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
                    <h5 class="description-text">Cajas</h5>
                    <span class="description-text-2">'.$item["ip_numcajas"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-text">Condicion</h5>
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
              <div class="row" style="border-bottom: #F4F4F4 Solid 1px">
			<div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-text">Fecha de produccion</h5>
                    <span class="description-text-2">';

					$fecprod=SubnivelController::cambiaf_a_normal($item["ip_fechaproduccion"]);

                     echo $fecprod.'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-text">Fecha de caducidad</h5>
                    <span class="description-text-2">';
                    $feccad=SubnivelController::cambiaf_a_normal($item["ip_fechacaducidad"]);
                    echo $feccad.'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
				</div>
				<div class="row">
			<div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-text">Edad dias</h5>
                    <span class="description-text-2">'.$item["ip_edaddias"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-text">Semanas</h5>
                    <span class="description-text-2">'.$item["ip_semana"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-text">Estatus</h5>
                    <span class="description-text-2">';
					if ($item["ip_estatus"]=="I"){
                    	echo "INSTALADO";
                    } else if ($item["ip_condicion"]=="A"){
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
                 <button type="button" class="btn btn-block btn-info"><i class="fa fa-trash"></i></button>
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

	} // foreach
echo '</section>';
}


}
?>	
