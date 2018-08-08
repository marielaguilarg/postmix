<?php
class GeneralController{

	public function vistaGeneralController(){
		if (isset($_GET["sec"])) {
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];

	echo '<div class="row">
    <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevageneral&id='.$seccion.'&ids='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
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

		$respuesta =DatosGenerales::vistaGeneralModel($servicioController, "cue_valoresfijos");
			$i=1;
			foreach($respuesta as $row => $item){
				echo '  <tr>
	              <td>'.$i.'</td>
	              <td><a href="index.php?action=editageneral&op='.$item["gen_numdato"].'&id='.$seccion.'&ids='.$servicioController.'">'.$item["gf_nombreesp"].'</a>
	              </td>
	                  <td>'.$item["gen_lugarsyd"].'
	                  </td>
	                  
	                <td><a href="index.php?action=sn&ids='.$seccion.$item["gen_numdato"].'&sv='.$item["gen_claveservicio"].'&ts=G&sec='.$seccion.'">borrar</a>
	                </tr>';
	             $i++;   
			}
		
		echo '</table>
		</div>';
		} //if               
	}

	public function nuevaGeneralController(){
	    
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
//		$opcion=$_GET["op"];

	    
	   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
//	   echo '<input type="hidden" name="op" value="'.$opcion.'">';       
	}

	public function variablesEdGeneralController(){
	    
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
		$opcion=$_GET["op"];

	    
	   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
	   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
	   echo '<input type="hidden" name="op" value="'.$opcion.'">';       
	}


	public function editaGeneralController(){
	    $opcion = $_GET["op"];
		$servicio = $_GET["ids"];
		$datosController = $_GET["id"];


		$sec=$servicio.$opcion;
		//echo $sec;

		$respuesta = DatosGenerales::editarGeneralModel($sec, "cue_generales");
		//echo $respuesta;
		foreach($respuesta as $row => $item){
			$numcam=$item["gen_numdatoref"];
			//echo $numcam;
			$lista = DatosGenerales::datosModel("cue_valoresfijos");
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
	
	public function actualizagenController(){
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
	      $respuesta = DatosGenerales::actualizageneralModel($datosController, "cue_generales");
	      echo $respuesta;
		}
	}




	public function listadatos(){

		$respuesta = DatosGenerales::datosModel("cue_valoresfijos");
		foreach($respuesta as $row => $item){
		  echo '<option value='.$item["gf_numdato"].'>'.$item["gf_nombreesp"].'</option>';
		} 
	}	

		
		


	public function registrarDatosGenerales(){              
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
	                               "G"=>'G',
	                               "datoref"=>$_POST["idcampo"],
	                               ); 

		$respuesta =DatosGenerales::insertageneralModel($datosController, "cue_generales");
		if ($respuesta=="success"){

			echo "
				<script type='text/javascript'>
				window.location.href='index.php?action=sn&sec=1&ts=G&sv=1';
				</script>
				";
		}
	 }
 }     

	public function borrageneralController(){
		if (isset($_GET["ids"])) {
			$ids=$_GET["ids"];
			$respuesta = DatosGenerales::borrageneralModel($ids,"cue_generales");
		}
	}

	public function botonRegresageneralController(){
		$datosController = $_GET["id"];
		$servicioController = $_GET["ids"];
   		echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$datosController.'&sv='.$servicioController.'&ts=G"> Cancelar </a></button>';
	}
	
	public function reporteGeneralController(){
         $sv=$_GET["sv"];
         $nrep=$_GET["nrep"];
         $sec=$_GET["sec"];
         $pv=$_GET["pv"];
         $idc=$_GET["idc"];

		echo '<section class="content container-fluid">

      <!----- Inicia contenido ----->
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
              <form role="form">';
                # valida si existen datos
             $existe = DatosGenerales::validaExisteReporte($sv, $nrep, "ins_generales");
             if ($existe){
                
                $registro = DatosGenerales::vistaReporteGenerales($sv, $nrep, "ins_generales");
                #LEE VARIABLES
                  $cinsp=$registro["i_claveinspector"];
                  $fecvis=$registro["i_fechavisita"];
                  $mesas=$registro["i_mesasignacion"];
                  $hrent=$registro["i_horaentradavis"];
                  $horaEn=$registro["HoraEn"];
                  $horaEn2=$registro["HoraEn2"];
                  $hrsal=$registro["i_horasalidavis"];
                  $horaEn5=$registro["HoraEn5"];
                  $horaEn6=$registro["HoraEn6"];
                  $horaEn3=$registro["HoraEn3"];
                  $horaEn4=$registro["HoraEn4"];

                  $respvis=$registro["i_responsablevis"];
                  $puesresp=$registro["i_puestoresponsablevis"];
                  $sincobro=$registro["i_sincobro"];
                  
                  $repcic=$registro["i_reportecic"];
                  $numrepcic=$registro["i_numreportecic"];
                  $finaliza=$registro["i_finalizado"];

                  $corxy=$registro["une_coordenadasxy"];
                  $fecfin=$registro["i_fechafinalizado"];
                  $reasigna=$registro["i_reasigna"];
                  $gpo=$_SESSION["GrupoUs"];
                  echo '
                  <div class="form-group col-md-12">
                  <label>INSPECTOR</label>';
                  
                  echo '<select class="form-control" name="insp" id=insp>';
                  #busca inspector
                  $catalogo = DatosInspector::listainspectores("ca_inspectores");
                   foreach ($catalogo as $key => $item) {
                      if ($item["ins_clave"]==$cinsp) {
                        echo '<option value='.$item["ins_clave"].' selected>'.$item["ins_nombre"].'</option>';
                      } else {
                        echo '<option '.$item["ins_clave"].'>'.$item["ins_nombre"].'</option>';
                      }                   
                  }  

                   echo ' </select>
                  </div>
                  <div class="form-group col-md-12">
                  <label>MES ASIGNACION</label>';
                   echo '<select class="form-control" name=mesas id="mesas">';
                   $catalogo = DatosMesasignacion::listaMesAsignacion("ca_mesasignacion");
                   //$sele="";
                   foreach ($catalogo as $key => $rowc) {
                      switch ($rowc["num_mes_asig"]) {
                     case 1:
                        $mesnom="ENERO";
                      break;
                     case 2:
                        $mesnom="FEBRERO";
                      break;
                     case 3:
                        $mesnom="MARZO";
                      break;   
                     case 4:
                        $mesnom="ABRIL";
                      break;   
                     case 5:
                        $mesnom="MAYO";
                      break;   
                     case 6:
                        $mesnom="JUNIO";
                      break;   
                     case 7:
                        $mesnom="JULIO";
                      break;   
                     case 8:
                        $mesnom="AGOSTO";
                      break;   
                     case 9:
                        $mesnom="SEPTIEMBRE";
                      break;   
                     case 10:
                        $mesnom="OCTUBRE";
                      break;   
                     case 11:
                        $mesnom="NOVIEMBRE";
                      break;   
                     case 12:
                        $mesnom="DICIEMBRE";
                      break;
                     }
                      if ($mesas==$rowc["num_mes_asig"].".".$rowc["num_per_asig"]){
                          $sele= "selected='selected'";
                      }else{
                        $sele="";
                      }
                      echo "<option value=".$rowc["num_mes_asig"].".".$rowc["num_per_asig"]." ".$sele.">".$mesnom."-".$rowc["num_per_asig"]."</option>";                  
                  } 
                   echo ' </select>
                </div>
                <div class="form-group col-md-12">
                  <label>RESPONSABLE DEL PUNTO DE VENTA</label>
                  <input type="text" class="form-control" placeholder="" id="resp" name="resp" value="'.$respvis.'">
                </div>
                <div class="form-group col-md-12">
                  <label>CARGO</label>
                  <input type="text" class="form-control" placeholder="" id="cargo" name="cargo" value="'.$puesresp.'">
                </div>
                <div class="form-group col-md-6">
                  <label>HORA DE ENTRADA</label>
                   <label>Hrs</label>
                  <select class="form-control"  name="HoraEn">';
                  
                  for($j=1;$j<=24;$j++)
                  {
                     if ($j==$horaEn){
                       echo "<option value='".$j."' selected>".$j."</option>";
                     }else{
                       echo "<option value='".$j."'>".$j."</option>";
                     }     
                  }
                 echo '</select>
                </div>

                 <div class="form-group col-md-6">
                 <label>Min</label>
                  <select class="form-control"  name="HoraEn2">';
                  
                  for($j=0;$j<=60;$j++)
                  {
                      if ($j<10)    {
                        $j1="0".$j;
                      }else{
                        $j1=$j;
                      }
                      if ($j==$horaEn2){
                         echo "<option value='".$j."' selected>".$j1."</option>";
                       }else{
                          echo "<option value='".$j."'>".$j1."</option>";
                       }     
                  }
                    
                  
                  echo '</select>
                </div>
                <div class="form-group col-md-6">
                  <label>HORA DE ANALISIS SENSORIAL</label>
                   <label>Hrs</label>
                  <select class="form-control"  name="HoraEn3">';
                  
                  for($j=1;$j<=24;$j++)
                  {
                     if ($j==$horaEn3){
                       echo "<option value='".$j."' selected>".$j."</option>";
                     }else{
                       echo "<option value='".$j."'>".$j."</option>";
                     }     
                    
                  }
                 echo '</select>
                </div>

                 <div class="form-group col-md-6">
                 <label>Min</label>
                  <select class="form-control"  name="HoraEn4">';
                  
                  for($j=0;$j<=60;$j++)
                  {
                      if ($j<10)    {
                        $j1="0".$j;
                      }else{
                        $j1=$j;
                      }
                     if ($j==$horaEn4){
                        echo "<option value='".$j."' selected>".$j1."</option>";
                     }else{
                         echo "<option value='".$j."'>".$j1."</option>";
                     }  
                    
                  }
                  echo '</select>
                </div>
                <div class="form-group col-md-6">
                  <label>HORA DE SALIDA</label>
                   <label>Hrs</label>
                  <select class="form-control"  name="HoraEn5">';
                  
                  for($j=1;$j<=24;$j++)
                  {
                    if ($j==$horaEn5){
                      echo "<option value='".$j."' selected>".$j."</option>";
                     }else{
                      echo "<option value='".$j."'>".$j."</option>";
                     }
                   
                  }
                 echo '</select>
                </div>

                 <div class="form-group col-md-6">
                 <label>Min</label>
                  <select class="form-control"  name="HoraEn5">';
                  
                  for($j=0;$j<=60;$j++)
                  {
                      if ($j<10)    {
                        $j1="0".$j;
                      }else{
                        $j1=$j;
                      }
                     if ($j==$horaEn6){
                        echo "<option value='".$j."' selected>".$j1."</option>";
                       }else{
                        echo "<option value='".$j."'>".$j."</option>";
                       }     
      
                    
                  }
                  echo '</select>
                </div>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="fechavisita" id="reservation">
                </div>';  
                  if ($gpo=='adm'){
                    echo '<div class="form-group col-md-4">';
                    if ($reasigna) {
                        $valreas="checked";
                    }
                      else {
                         $valreas="";
                    }
                
                    echo ' <label >REASIGNACION</label>
                    <input type="checkbox" name="indsyd" '.$valreas.'/>
                    </div>
                    <div class="form-group col-md-4">';
                    if ($sincobro) {
                        $valsinc="checked";
                    }
                      else {
                         $valsinc="";
                    }
                     echo ' <label >SIN COBRO</label>
                        <input type="checkbox" name="indsyd" '.$valsinc.'/>
                    </div>';
                  }  

                echo '<div class="form-group col-md-4">';

                if ($repcic) {
                    $valant="checked";
                }
                  else {
                     $valant="";
                }
                 
                echo ' <label >REPORTE CIC</label>
                    <input type="checkbox" name="REPCIC"  '.$valant.' />
                </div>
                <div class="form-group col-md-12">
                  <label>NO DE REPORTE CIC</label>
                  <input type="text" class="form-control" placeholder="" id="numrepcic" name="numrepcic" value='.$numrepcic.'>
                </div>
                <div class="form-group col-md-12">
                  <label>COORDENAADAS XY</label>
                  <input type="text" class="form-control" placeholder="" id="coorxy" name="coorxy" value="'.$corxy.'">
                </div>
                <div class="form-group col-md-12">
                  <label>FECHA EMISION</label>
                  <input type="text" class="form-control" placeholder="" id="fecemis" name="fecemis" value="'.$fecfin.'">
                </div>
                
                
                ';                

                if ($finaliza==1) {
                  echo '
                         <div class="form-group col-md-12">
                          <label>FINALIZAR REPORTE  :  FINALIZADO</label>
                         <input type="button" name="FIN" id="FIN" value="Reactivar" onClick=oCargarre("index.php?op=reac&nrep=1");>
                         </div>';


                }else{
                  echo '  <div class="form-group col-md-12">
                          <label>FINALIZAR REPORTE  :  </label>
                    <button   style="margin-left: 10px"><a href="index.php?action=rsn&sec='.$sec.'&ts=FG&sv='.$sv.'&pv='.$pv.'&idc='.$idc.'&nrep='.$nrep.'"> Finalizar </a></button>';
                }

          
             } else {
              // nuevo
              echo '
                <div class="form-group col-md-12">
                  <label>INSPECTOR</label>';
                  
                  echo '<select class="form-control">';
                  #busca inspector
                  $catalogo = DatosInspector::listainspectores("ca_inspectores");
                  echo '<option "">--- Seleccione opcion ---</option>';
                  foreach ($catalogo as $key => $item) {
                    echo '<option '.$item["ins_clave"].'>'.$item["ins_nombre"].'</option>';                        
                  }  

                   echo ' </select>
                </div>     
                  <div class="form-group col-md-12">
                  <label>MES ASIGNACION</label>';
                   echo '<select class="form-control" name=mesas id="mesas">';
                   echo '<option "">--- Seleccione opcion ---</option>';
                   $catalogo = DatosMesasignacion::listaMesAsignacion("ca_mesasignacion");
                   //$sele="";
                   foreach ($catalogo as $key => $rowc) {
                      switch ($rowc["num_mes_asig"]) {
                     case 1:
                        $mesnom="ENERO";
                      break;
                     case 2:
                        $mesnom="FEBRERO";
                      break;
                     case 3:
                        $mesnom="MARZO";
                      break;   
                     case 4:
                        $mesnom="ABRIL";
                      break;   
                     case 5:
                        $mesnom="MAYO";
                      break;   
                     case 6:
                        $mesnom="JUNIO";
                      break;   
                     case 7:
                        $mesnom="JULIO";
                      break;   
                     case 8:
                        $mesnom="AGOSTO";
                      break;   
                     case 9:
                        $mesnom="SEPTIEMBRE";
                      break;   
                     case 10:
                        $mesnom="OCTUBRE";
                      break;   
                     case 11:
                        $mesnom="NOVIEMBRE";
                      break;   
                     case 12:
                        $mesnom="DICIEMBRE";
                      break;
                     }
                      if ($mesas==$rowc["num_mes_asig"].".".$rowc["num_per_asig"]){
                          $sele= "selected='selected'";
                      }else{
                        $sele="";
                      }
                      echo "<option value=".$rowc["num_mes_asig"].".".$rowc["num_per_asig"]." ".$sele.">".$mesnom."-".$rowc["num_per_asig"]."</option>";                  
                  } 
                   echo ' </select>
                </div>
                <div class="form-group col-md-12">
                  <label>RESPONSABLE DEL PUNTO DE VENTA</label>
                  <input type="text" class="form-control" placeholder="" id="resp" name="resp" value="'.$respvis.'">
                </div>
                <div class="form-group col-md-12">
                  <label>CARGO</label>
                  <input type="text" class="form-control" placeholder="" id="cargo" name="cargo" value="'.$puesresp.'">
                </div>
                <div class="form-group col-md-6">
                  <label>HORA DE ENTRADA</label>
                   <label>Hrs</label>
                  <select class="form-control"  name="HoraEn">';
                  
                  for($j=1;$j<=24;$j++)
                  {
                    echo "<option value='".$j."'>".$j."</option>";
                   
                  }
                 echo '</select>
                </div>

                 <div class="form-group col-md-6">
                 <label>Min</label>
                  <select class="form-control"  name="HoraEn2">';
                  
                  for($j=0;$j<=60;$j++)
                  {
                      if ($j<10)    {
                        $j1="0".$j;
                      }else{
                        $j1=$j;
                      }
                    echo "<option value='".$j."'>".$j1."</option>";
                    
                  }
                  echo '</select>
                </div>
                <div class="form-group col-md-6">
                  <label>HORA DE ANALISIS SENSORIAL</label>
                   <label>Hrs</label>
                  <select class="form-control"  name="HoraEn3">';
                  
                  for($j=1;$j<=24;$j++)
                  {
                    echo "<option value='".$j."'>".$j."</option>";
                   
                  }
                 echo '</select>
                </div>

                 <div class="form-group col-md-6">
                 <label>Min</label>
                  <select class="form-control"  name="HoraEn4">';
                  
                  for($j=0;$j<=60;$j++)
                  {
                      if ($j<10)    {
                        $j1="0".$j;
                      }else{
                        $j1=$j;
                      }
                    echo "<option value='".$j."'>".$j1."</option>";
                    
                  }
                  echo '</select>
                </div>
                <div class="form-group col-md-6">
                  <label>HORA DE SALIDA</label>
                   <label>Hrs</label>
                  <select class="form-control"  name="HoraEn4">';
                  
                  for($j=1;$j<=24;$j++)
                  {
                    echo "<option value='".$j."'>".$j."</option>";
                   
                  }
                 echo '</select>
                </div>

                 <div class="form-group col-md-6">
                 <label>Min</label>
                  <select class="form-control"  name="HoraEn5">';
                  
                  for($j=0;$j<=60;$j++)
                  {
                      if ($j<10)    {
                        $j1="0".$j;
                      }else{
                        $j1=$j;
                      }
                    echo "<option value='".$j."'>".$j1."</option>";
                    
                  }
                  echo '</select>
                </div>
                <div class="form-group col-md-12">
                  <label>FECHA VISITA</label>
                  <input type="text" class="form-control" placeholder="" id="">
                  </div>
                <div class="form-group col-md-4">
                   <label >REASIGNACION</label>
                    <input type="checkbox" name="indsyd" />
                </div>
                <div class="form-group col-md-4">
                   <label >SIN COBRO</label>
                    <input type="checkbox" name="indsyd" />
                </div><div class="form-group col-md-4">
                   <label >REPORTE CIC</label>
                    <input type="checkbox" name="indsyd" />
                </div>
                <div class="form-group col-md-12">
                  <label>NO DE REPORTE CIC</label>
                  <input type="text" class="form-control" placeholder="" id=resp name=resp>
                </div>
                <div class="form-group col-md-12">
                  <label>COORDENAADAS XY</label>
                  <input type="text" class="form-control" placeholder="" id=resp name=resp>
                </div>
                <div class="form-group  col-md-12">
                <label>FECHA EMISION:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                               
               <div class="form-group col-md-12">
                  <label>FINALIZAR REPORTE</label>
                  <input type="text" class="form-control" placeholder="" id="">
                </div>
                
                  ';

             }

                echo '<!-- Datos iniciales alta de punto de venta -->
                
                <!-- Clasificación punto de venta -->
                <br>
                
                
                                <!-- Pie de formulario -->
                 <div class="box-footer col-md-12">
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              </form>
              </div>
              </div>
            </div>
       
        </div>
	  <!----- Finaliza contenido ----->
    </section>';
 


	}


}
?>