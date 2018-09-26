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
              <div class="row" style="border-bottom: #F4F4F4 Solid 1px">
			<div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Fecha de produccion</strong></h5>
                    <span class="description-text-2">';

					$fecprod=SubnivelController::cambiaf_a_normal($item["ip_fechaproduccion"]);

                     echo $fecprod.'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Fecha de caducidad</strong></h5>
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
                    <h5 class="description-text"><strong>Edad dias</strong></h5>
                    <span class="description-text-2">'.$item["ip_edaddias"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Semanas</strong></h5>
                    <span class="description-text-2">'.$item["ip_semana"].'</span>
                  </div>
                  <!-- /.description-block -->
                </div>
            <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-text"><strong>Estatus</strong></h5>
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
  			<form role="form"  method="post">          
              <div class="form-group">
               <div class="form-group col-md-12">
                <label for="Sistemano" class="col-sm-2 control-label">Sistema No.</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="numsistema" placeholder="">
                </div>
				  </div>
              <div class="form-group col-md-12">
                <label for="Producto" class="col-sm-2 control-label">Producto</label>
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
                <label for="TotalDeCajas" class="col-sm-2 control-label">Total de cajas</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="registros" placeholder="">
                </div>
				  </div>';

		$ingreso = new ProductoController();
		$ingreso ->nuevoRepDetProductoController();


                 echo ' <div class="row">
		<div class="col-md-12" >
		<button  class="btn btn-default pull-right" style="margin-right: 18px margin-top:15px; margin-bottom:15px;" onclick><a href="index.php?action=rsn&sec='.$sec.'&sv='.$ser.'&ts=GV&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'" >  Aceptar  </a></button>
		<button type="submit" class="btn btn-info pull-right">Guardar</button>
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

public function nuevoRepDetProductoController(){

	echo "entre a producto controller";
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

}
?>	