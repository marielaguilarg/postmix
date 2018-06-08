<?php
class unegocioController{


	public function vistaunegocioController(){
		$page_size=10;
		if(isset($_GET["pages"])){
			$pages=$_GET["pages"];
			$init =($pages - 1) * $page_size;
		} else {
			$init=0;
			$pages=1;
		}
		$totuneg=Datosunegocio::cuentaUnegocioModel("ca_unegocios");
		$totpages= ceil($totuneg/$page_size);

		if(isset($_POST["opcionuneg"])){
			$op="%".$_POST["opcionuneg"]."%";
			//echo $op;
			$respuesta =Datosunegocio::vistaFiltroUnegocioModel($op, "ca_unegocios");
		} else {	
			$respuesta =Datosunegocio::vistaUnegocioModel($init,$page_size, "ca_unegocios");
		}


		//echo $totuneg;
		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["une_id"].'</td>
	                  <td>'.$item["une_idpepsi"].'</td>
		                  <td>'.$item["une_idcuenta"].'</td>
	                  <td>
	                    <a href="#">'.$item["une_descripcion"].'</a>
	                  </td>
	                </tr>';
	            
		}

		if ($totpages>1) {
			if (isset($pages)) {
				if ($pages != 1){
	      			echo '<li><a href="index.php?action=listaunegocio&pages='.($pages -1 ).'">&laquo;</a></li>';

				}
			}	
		}

		for ($i=1; $i<=$totpages;$i++){
				if (isset($page)) {
					if($page==$i){
						echo $page;
					} else {
						echo '<li><a href="index.php?action=rlistaunegocio&pages='.$i.'">'.$i.'</a></li>';
					}
				}else{
				 		echo '<li><a href="index.php?action=rlistaunegocio&pages='.$i.'">'.$i.'</a></li>';
				} //IF 	
			}	//FOR
		echo '</ul>
            </div>
          </div>
          <!-- /.box -->
        </div>
        </div>';
	}


public function vistarunegocioController(){
	$page_size=10;
	$sv=$_GET["sv"];
		if(isset($_GET["pages"])){
			$pages=$_GET["pages"];
			$init =($pages - 1) * $page_size;
		} else {
			$init=0;
			$pages=1;
		}
		$totuneg=Datosunegocio::cuentaUnegocioModel("ca_unegocios");
		$totpages= ceil($totuneg/$page_size);
		if(isset($_POST["opcionuneg"])){
			$op="%".$_POST["opcionuneg"]."%";
			//echo $op;
			$respuesta =Datosunegocio::vistaFiltroUnegocioModel($op, "ca_unegocios");
		} else {	
			$respuesta =Datosunegocio::vistaUnegocioModel($init,$page_size, "ca_unegocios");
		}

		
		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["une_id"].'</td>
	                  <td>'.$item["une_idpepsi"].'</td>
		                  <td>'.$item["une_idcuenta"].'</td>
	                  <td>
	                    <a href="index.php?action=runegociodetalle&un='.$item["une_id"].'&sv='.$sv.'">'.$item["une_descripcion"].'</a>
	                  </td>
	                </tr>';
	            
		}  // foreach
			echo '
               </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">';
			
			#trabajemos con la paginacion
		if ($totpages>1) {
			if (isset($pages)) {
				if ($pages != 1){
	      			echo '<li><a href="index.php?action=rlistaunegocio&pages='.($pages -1 ).'">&laquo;</a></li>';

				}
			}	
		}	
			for ($i=1; $i<=$totpages;$i++){
				if (isset($page)) {
					if($page==$i){
						echo $page;
					} else {
						echo '<li><a href="index.php?action=rlistaunegocio&pages='.$i.'">'.$i.'</a></li>';
					}
				}else{
				 		echo '<li><a href="index.php?action=rlistaunegocio&pages='.$i.'">'.$i.'</a></li>';
				} //IF 	
			}	//FOR
		echo '</ul>
            </div>
          </div>
          <!-- /.box -->
        </div>
        </div>';
        		
	} // function


	public function vistaunegocioDetalle(){
		$uneg=$_GET["un"];
		$serv=$_GET["sv"];
		$respuesta =Datosunegocio::vistaUnegocioDetalle($uneg, "ca_unegocios");
		#presrenta datos de unegocio
		echo '<h3 class="box-title">'.$respuesta["une_descripcion"].'</h3>
              <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
             
               <div class="row" >
                 <div class="row" >
                   <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-text">ID PEPSI</h5>
              		<strong>'.$respuesta["une_idpepsi"].'</strong><br>
          </div>
          <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4 border-right">
          <div class="description-block">
            <h5 class="description-text">ID CUENTA</h5>
            <strong>'.$respuesta["une_idcuenta"].'</strong><br>
             </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
  
                 <button type="button" class="btn btn-block btn-primary" style="width: 80%"><a href="index.php?action=runegociocomp&uneg='.$respuesta["une_id"].'"> Detalle </a></button>
';
	}

	public function vistaReportesunegocio(){
		$uneg=$_GET["un"];
		$serv=$_GET["sv"];
		$respuesta =Datosunegocio::ReportesUnegocio($serv, $uneg, "ca_unegocios");
		foreach($respuesta as $row => $item){
			echo '<div class="col-sm-4 border-right">
                  <div class="description-block">
                  <strong> <a href="index.php?action=editarep&sv='.$serv.'&pv='.$uneg.'&nrep='.$item["i_numreporte"].'">'.$item["i_numreporte"].'</a>
                   </strong><br>
                  </div>
                   </div>';
		}	
	}			

	public function vistaunegocioCompleta(){
		$uneg=$_GET["uneg"];
		//echo $uneg;

		$respuesta =Datosunegocio::UnegocioCompleta($uneg, "ca_unegocios");
		
				$nivel1=$respuesta["une_cla_region"];
                $nivel2=$respuesta["une_cla_pais"];
                $nivel3=$respuesta["une_cla_zona"];
                $nivel4=$respuesta["une_cla_estado"];
                $nivel5=$respuesta["une_cla_ciudad"];
                $nivel6=$respuesta["une_cla_franquicia"];
                
          

		echo '<div class="form-group col-md-12">
                  <label>NOMBRE</label>
                  <br>'.
                  $respuesta["une_descripcion"].'
                </div>
                <div class="form-group col-md-4">
                  <label>ID PEPSI</label><br>'.
                  $respuesta["une_idpepsi"].'
                </div>
                <div class="form-group col-md-4">
                  <label>ID CUENTA</label><br>'.
                  $respuesta["une_idcuenta"].'
                </div>
                <div class="form-group col-md-4">
                  <label>NUD</label><br>'.
                  $respuesta["une_num_unico_distintivo"].'
                </div>

                <br>
               <div class="col-md-12">
                <h4>DIRECCIÓN</h4>
                </div>
               <div class="form-group col-md-12">
                  <label>CALLE</label><br>'.
                  $respuesta["une_dir_calle"].'

                </div>
                
               <div class="form-group col-md-3">
                  <label>NUM. EXTERIOR</label><br>'.
                  $respuesta["une_dir_numeroext"].'
                </div>
                
                
                <div class="form-group col-md-3">
                  <label>NUM. INTERIOR</label><br>'.
                  $respuesta["une_dir_numeroint"].'
                </div>
				
                <div class="form-group col-md-3">
                  <label>MANZANA</label><br>'.
                  $respuesta["une_dir_manzana"].'
                </div>
                <div class="form-group col-md-3">
                  <label>LOTE</label><br>'.
                  $respuesta["une_dir_lote"].'
                </div>
                <div class="form-group col-md-6">
                  <label>COLONIA</label><br>'.
                  $respuesta["une_dir_colonia"].'
                </div>
                <div class="form-group col-md-6">
                  <label>DELEGACIÓN</label><br>'.
                  $respuesta["une_dir_delegacion"].'
                </div>

                <div class="form-group col-md-6">
                  <label>CIUDAD</label><br>'.
                  $respuesta["une_dir_municipio"].'
                </div>
                <div class="form-group col-md-6">
                  <label>ESTADO</label><br>'.
                  $respuesta["une_dir_estado"].'
                </div>
                <div class="form-group col-md-3">
                  <label>C.P.</label><br>'.
                  $respuesta["une_dir_cp"].'
                </div>
                <div class="form-group col-md-9">
                  <label>REFERENCIA</label><br>'.
                  $respuesta["une_dir_referencia"].'
                </div>
                 <div class="form-group col-md-6">
                  <label>TELÉFONO</label><br>'.
                  $respuesta["une_dir_telefono"].'
                </div>';

                # buscamos nombres de las estructuras;
                




				$nomnivel =Estructura::vistaEstructuraCompleta(1,"cnfg_estructura");

                echo '<br>
                <div class="col-md-12">
                <h4>CLASIFICACIÓN</h4>
                </div>
                <div class="form-group col-md-6">
                  <label>'.$nomnivel["mee_descripcionnivelesp"].'</label><br>';
			
				$datnivel =	Datosnuno::vistaN1opcionModel($respuesta["une_cla_region"], "ca_nivel1");
				
				echo $datnivel["n1_nombre"].'
                 
                </div>
                <div class="form-group col-md-6">';
                $nomnivel =Estructura::vistaEstructuraCompleta(2,"cnfg_estructura");
                echo
                  '<label>'.$nomnivel["mee_descripcionnivelesp"].'</label><br>';
				
				$datnivel =	Datosndos::vistaN2opcionModel($respuesta["une_cla_pais"], "ca_nivel2");
				
				echo $datnivel["n2_nombre"].'
                	
                </div>
                <div class="form-group col-md-6">';

                $nomnivel =Estructura::vistaEstructuraCompleta(3,"cnfg_estructura");
                echo
                  '<label>'.$nomnivel["mee_descripcionnivelesp"].'</label><br>';

                $datnivel =	Datosntres::vistaN3opcionModel($respuesta["une_cla_zona"], "ca_nivel3");
				
				echo $datnivel["n3_nombre"].'
                </div>
                <div class="form-group col-md-6">';

                $nomnivel =Estructura::vistaEstructuraCompleta(4,"cnfg_estructura");
                echo
                  '<label>'.$nomnivel["mee_descripcionnivelesp"].'</label><br>';
                 $datnivel4 =Datosncua::vistaN4opcionModel($respuesta["une_cla_estado"], "ca_nivel4");
				
				echo $datnivel4["n4_nombre"].'
                </div>

                <div class="form-group col-md-6">';
                $nomnivel =Estructura::vistaEstructuraCompleta(5,"cnfg_estructura");
                echo
                  '<label>'.$nomnivel["mee_descripcionnivelesp"].'</label><br>';

                 $datnivel5 =Datosncin::vistancinOpcionModel($nivel5, "ca_nivel5");
                 if (isset($datnivel5["n5_nombre"])){
				     $opcioncinco=$datnivel5["n5_nombre"];
				} else {
					 $opcioncinco="";
				}	
				echo $opcioncinco.'
                </div>
                <div class="form-group col-md-6">';

                
                $nomnivel =Estructura::vistaEstructuraCompleta(6,"cnfg_estructura");
                echo
                  '<label>'.$nomnivel["mee_descripcionnivelesp"].'</label><br>';
                  $datnivel6 =Datosnsei::vistanseiOpcionModel($nivel6, "ca_nivel6");
					if (isset($datnivel6["n6_nombre"])){
				    	 $opcionseis=$datnivel6["n6_nombre"];
					} else {
						 $opcionseis="";
					}	
					echo $opcionseis.'
				
                </div>';



	}	

}
?>