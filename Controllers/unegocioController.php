<?php
class unegocioController{
private $listanivel1;
private $listanivel2;
private $listanivel3;
private $listanivel4;
private $listanivel5;
private $listanivel6;
private $nombrenivel1;
private $nombrenivel2;
private $nombrenivel3;
private $nombrenivel4;
private $nombrenivel5;
private $nombrenivel6;
private $listaFranquicias;
private $listaCuentas;
private $listaEstatus;
private $listaEstados;
private $idpv;
private $idref;
private $desuneg;
private $idpepsi;
private $idcta;
private $idnud;
private $calle;
private $numext;
private $numint;
private $mz;
private $lt;
private $col;
private $del;
private $mun;
private $edo;
private $cp;
private $ref;
private $tel;
private $numpunto;
private $cuenta;


	public function vistaunegocioController(){
    $idc=$_GET["idc"];
		$page_size=100;
		if(isset($_GET["pages"])){
			$pages=$_GET["pages"];
			$init =($pages - 1) * $page_size;
		} else {
			$init=0;
			$pages=1;
		}
		$totuneg=Datosunegocio::cuentaUnegocioModel($idc, "ca_unegocios");
		$totpages= ceil($totuneg/$page_size);

		if(isset($_POST["opcionuneg"])){
			$op="%".$_POST["opcionuneg"]."%";
			//echo $op;
			$respuesta =Datosunegocio::vistaFiltroUnegocioModel($op, "ca_unegocios");
		} else {	
			$respuesta =Datosunegocio::vistaUnegocioModel($init,$page_size, $idc, "ca_unegocios");
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

          echo '
               </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">';


		if ($totpages>1) {
			if (isset($pages)) {
				if ($pages != 1){
	      			echo '<li><a href="index.php?action=listaunegocio&idc='.$idc.'&pages='.($pages -1 ).'">&laquo;</a></li>';

				}
			}	
		}

		for ($i=1; $i<=$totpages;$i++){
				if (isset($page)) {
					if($page==$i){
						echo $page;
					} else {
						echo '<li><a href="index.php?action=listaunegocio&idc='.$idc.'&pages='.$i.'">'.$i.'</a></li>';
					}
				}else{
				 		echo '<li><a href="index.php?action=listaunegocio&idc='.$idc.'&pages='.$i.'">'.$i.'</a></li>';
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
	$page_size=100;
	$sv=$_GET["sv"];
  $idcta=$_GET["idc"];
		if(isset($_GET["pages"])){
			$pages=$_GET["pages"];
			$init =($pages - 1) * $page_size;
		} else {
			$init=0;
			$pages=1;
		}
		$totuneg=Datosunegocio::cuentaUnegocioModel($idcta,"ca_unegocios");
		$totpages= ceil($totuneg/$page_size);

		if(isset($_POST["opcionuneg"])){
			$op="%".$_POST["opcionuneg"]."%";
			//echo $op;
			$respuesta =Datosunegocio::vistaFiltroUnegocioModel($idcta, $op, "ca_unegocios");
		} else {	
			$respuesta =Datosunegocio::vistaUnegocioModel($init,$page_size, $idcta, "ca_unegocios");
		}

		
		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["une_id"].'</td>
	                  <td>'.$item["une_idpepsi"].'</td>
		                  <td>'.$item["une_idcuenta"].'</td>
	                  <td>
	                    <a href="index.php?action=runegociodetalle&idc='.$idcta.'&un='.$item["une_id"].'&sv='.$sv.'">'.$item["une_descripcion"].'</a>
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
	      			echo '<li><a href="index.php?action=rlistaunegocio&idc='.$idcta.'&sv='.$sv.'&pages='.($pages -1 ).'">&laquo;</a></li>';

				}
			}	
		}	
			for ($i=1; $i<=$totpages;$i++){
				if (isset($page)) {
					if($page==$i){
						echo $page;
					} else {
						echo '<li><a href="index.php?action=rlistaunegocio&idc='.$idcta.'&sv='.$sv.'&pages='.$i.'">'.$i.'</a></li>';
					}
				}else{
				 		echo '<li><a href="index.php?action=rlistaunegocio&idc='.$idcta.'&sv='.$sv.'&pages='.$i.'">'.$i.'</a></li>';
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
    $idc=$_GET["idc"];
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
  
                 <button type="button" class="btn btn-block btn-primary" style="width: 80%"><a href="index.php?action=runegociocomp&idc='.$idc.'&uneg='.$respuesta["une_id"].'&sv='.$serv.'"> Detalle </a></button>
';
	}

	public function vistaReportesunegocio(){
		$uneg=$_GET["un"];
		$serv=$_GET["sv"];
    $idc=$_GET["idc"];
    $gpo = UsuarioController::Obten_grupo();
    //echo $gpo;
   
              
    $respuesta =Datosunegocio::ReportesUnegocio($serv, $uneg, "ins_generales");
  
		foreach($respuesta as $row => $item){
      $numrep=$item["i_numreporte"];
       echo '<div class="col-sm-4 border-right">
                  <div class="description-block">';
      if ($gpo=='adm') {
               echo '<strong> <a href="index.php?action=editarep&idc='.$idc.'&sv='.$serv.'&pv='.$uneg.'&nrep='.$item["i_numreporte"].'">'.$item["i_numreporte"].'</a>';
      } else {  // no es administrador
        if ($serv==3){
           
           $totsol =DatosSolicitud::cuentasolicitudModel($numrep, $serv, "sol_estatussolicitud");
            # existe solicitud?
           if ($totsol>0){
              $respuesta =DatosSolicitud::estatusSolicitudModel($numrep, $serv, "sol_estatussolicitud");
              $final=$respuesta["sol_estatussolicitud"];
              if ($final =3){
                  echo '<strong> '.$item["i_numreporte"].'</a>';
               }  else { # estatus diferente a 3
                  echo '<strong> <a href="index.php?action=editarep&sv='.$serv.'&pv='.$uneg.'&nrep='.$item["i_numreporte"].'">'.$numrep.'</a>';
               }  // FINAL=3 
           } else {
              echo '<strong>'.$numrep.'/SS';
                 
           }  // EXISTE SOLICITUD
        } else {   // no es servicio 3
          $final=$item["i_finalizado"];
          if ($final==1){
              
              echo '<strong>'.$numrep;
              
          }  else {
                   echo '<strong> <a href="index.php?action=editarep&sv='.$serv.'&pv='.$uneg.'&nrep='.$item["i_numreporte"].'">'.$numrep.'</a>';
          }  
        } // SERVICIO = 3
      }
      echo '
                   </strong><br>
                  </div>
                   </div>';
    
    } // foreach  

 
     
	
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

public function vistanomRservDet(){
    $datosController = $_GET["sv"];
    $idc = $_GET["idc"];
    $un=$_GET["uneg"];
    $respuesta = DatosSeccion::vistaNombreServModel($datosController,"ca_servicios");
    echo '<li><a href="index.php?action=runegociodetalle&idc='.$idc.'&sv='.$datosController.'&un='.$un.'">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
  //}
}




  
  
}
?>