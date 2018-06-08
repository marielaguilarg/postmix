<?php
class PonderacionController{


#vista ponderacion
	public function vistaPonderaController(){
		//lee numero de seccion y numero de servicio
		if (isset($_GET["sec"])) {
			$seccion = $_GET["sec"];
			$servicioController = $_GET["sv"];
      $tiposeccion=$_GET["ts"];
      
     # actualiza tipo seccion
     $respuesta =DatosPond::actualizatiporeac( $seccion, $servicioController,$tiposeccion, "cue_secciones"); 
     $respuesta = DatosPond::buscacliente($servicioController, "ca_servicios");
     $idcliente=$respuesta["ser_idcliente"];

     $respuesta =DatosPond::consultacuentaModel($idcliente, "ca_cuentas");

  echo '<div class="row">
  <div class="form-group col-md-4" >
     </div>

    <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px;"><a href="index.php?action=nuevapondera&id='.$seccion.'&ids='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
    <button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px;"><a href="index.php?action=sn&sec='.$seccion.'&ts=PN&sv='.$servicioController.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Pondera  </a></button>
     </div>
     </div>

    </section>';

      # crea titulo de columna ponderada
      # verifica si se ha seleccionado cuenta
      
		
			// presenta info
			echo 	'<section class="content container-fluid">
			<div class="box">
		 			<div class="box-body no-padding">
		              <table class="table" table-condensed>
		                <tr>
		                  <th style="width: 5%">No.</th>
		                  <th style="width: 25%">DESCRIPCION</th>
                      <th style="width: 15%">DETALLE</th>
		                	<th style="width: 15%">COMENT</th>
		                	<th style="width: 10%">BORRAR</th>
		                </tr>';

          
//busca la info
  $respuesta =DatosPond::vistaPonderaModel($servicioController, $seccion,"cue_reactivos");

		     $i=1;
			foreach($respuesta as $row => $item){
				echo '  <tr>
	              <td>'.$item["r_numreactivo"].'</td>
	              <td><a href="index.php?action=editapondera&ids='.$item["ser_claveservicio"].'&id='.$item["sec_numseccion"].'&idr='.$item["r_numreactivo"].'&ts=P">'.$item["r_descripcionesp"].'</a>
	              </td>
                
                
	                  <td>
	                    <a href="index.php?action=sn&sec='.$item["sec_numseccion"].'.'.$item["r_numreactivo"].'&ts='.$item["r_tiporeactivo"].'&sv='.$item["ser_claveservicio"].'"><span ><i class="fa fa-level-down fa-lg pull-center" aria-hidden="true"></i></span></a>
	                  </td>
	                  <td>
	                    <a href="index.php?action=reactivocoment&sec='.$item["sec_numseccion"].'.'.$item["r_numreactivo"].'&sv='.$item["ser_claveservicio"].'">Coment</a>
	                  </td>
	               <td>
	                    

	                    <a href="index.php?action=sn&sec='.$item["sec_numseccion"].'&ts=P&sv='.$item["ser_claveservicio"].'&idb='.$item["ser_claveservicio"].'.'.$item["sec_numseccion"].'.'.$item["r_numreactivo"].'">Borrar</a>
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

public function nuevaPonderaController(){
    
$datosController = $_GET["id"];
$servicioController = $_GET["ids"];

    
   echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
   echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
          
}

public function registrarPonderaController(){
      // echo "entre a actualizar cuenta controller";
  
       
    if(isset($_POST["descripesp"])){
      if (isset($_POST["indsyd"])){
          $indsyd=-1;
      }else{
          $indsyd=0;
      }
      $datosServicio=$_POST["idser"];
      $datosSeccion=$_POST["idsec"];

      # calcula numero de reactivo
      $numreac=DatosPond::CalculaultimaPonderaModel( $datosServicio, $datosSeccion,  "cue_reactivos");
     //echo $numreac;
      $nreac=$numreac["ulreactivo"]+1;
      //echo $nreac;
      $datosController= array("idser"=>$_POST["idser"],
      						   "idsec"=>$_POST["idsec"],
                              "numreac"=>$nreac,
                              "desesp"=>$_POST["descripesp"],
                              "desing"=>$_POST["descriping"],
                              "lugarsyd"=>$_POST["lugarsyd"],
                              "indsyd"=>$indsyd,
                              ); 
          
          $respuesta=DatosPond::registrarPonderaModel($datosController, "cue_reactivos");
           echo $respuesta; 
        if($respuesta=="success"){
           echo '<script> windows.location= "index.php?action=listacuenta" </script>';
          
       //   header("location:index.php?action=listacuenta");

        } else {
          echo "error";
        }
      }  
    
    }

public function editarPonderaController(){
    
    $datosController = $_GET["id"];
    $idservicio = $_GET["ids"];
    $idreactivo = $_GET["idr"];

    $respuesta = DatosPond::editaPonderaModel($datosController,$idservicio,$idreactivo,"cue_reactivos");
    
    echo '<div class="form-group col-md-6">
          <input type="hidden" name="idser" value="'.$respuesta["ser_claveservicio"].'">
          <input type="hidden" name="idsec" value="'.$respuesta["sec_numseccion"].'">
          <input type="hidden" name="idreac" value="'.$respuesta["r_numreactivo"].'">
         
           <label>DESCRIPCION EN ESPAÑOL</label>
           <input type="text" class="form-control" name="desesp" value="'.$respuesta["r_descripcionesp"].'" >
           </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN INGLES</label>
           <input type="text" class="form-control" name="desing" value="'.$respuesta["r_descripcioning"].'" >
          </div>

		 <div class="form-group col-md-6">
          <label>INCLUIR EN ARCHIVO </label></div>
<div class="form-group col-md-6">
          <label>LUGAR</label></div>
          ';

          IF ($respuesta["r_syd"]) {
            $indsyd= 'checked="checked"';
          } else {
            $indsyd='';
          }
                   
          echo '
           <div class="form-group col-md-6">
           <input type="checkbox" name="indsyd" id="indsyd" '. $indsyd .' />
            </div> 
          
           <div class="form-group col-md-6">
           <input type="text" class="form-control" name="lugarsyd" value="'.$respuesta["r_lugarsyd"].'" >
           
          </div>
           <div class="box-footer col-md-12">
                  <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$respuesta["sec_numseccion"].'&ts=P&sv='.$respuesta["ser_claveservicio"].'"> Cancelar </a></button>
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>  
                 </div>';
               

}   

public function actualizarPonderaController(){
       
    if(isset($_POST["desesp"])){
      if (isset($_POST["indsyd"])){
          $indsyd=-1;
      }else{
          $indsyd=0;
      }
      $datosController= array("idsec"=>$_POST["idsec"],
                              "idser"=>$_POST["idser"],
                              "idreac"=>$_POST["idreac"],
                              "desesp"=>$_POST["desesp"],
                              "desing"=>$_POST["desing"],
                              "lugarsyd"=>$_POST["lugarsyd"],
                              "indsyd"=>$indsyd,
                              ); 

      
          $respuesta=DatosPond::actualizarPonderaModel($datosController, "cue_reactivos");
           echo $respuesta; 
        if($respuesta=="success"){
           echo '<script> windows.location= "index.php?action=listacuenta" </script>';
          
       //   header("location:index.php?action=listacuenta");

        } else {
          echo "error";
        }
      }  
    
    }

  public function borrarPonderaController(){
    if(isset($_GET["idb"])){
      $datosController = $_GET["idb"];
      
      $respuesta = DatosPond::borrarPonderaModel($datosController, "cue_reactivos");
      echo $respuesta;
        if($respuesta=="success"){
           echo '<script> windows.location= "index.php?action=listacliente" </script>';
          //header('location:index.php?action=listacliente');
            // echo "cambio efectuado";
          
        
          } else {
            echo "error";
          } 
    }
  } 

  public function botonRegresaSeccionController(){
      
  $ids = $_GET["ids"];
  $id = $_GET["id"];

     echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=sn&sec='.$id.'&ts=P&sv='.$ids.'"> Cancelar </a></button>
  ';
  }


  public function vistareactivocoment(){
     $ser = $_GET["sv"];
     $sec = $_GET["sec"];


    $respuesta = DatosPond::vistaReactivoComentModel($sec, $ser, "cue_reactivoscomentarios"); 
        foreach($respuesta as $row => $item){
        echo '  <tr>
                  <td>'.$item["rc_numcomentario"].'</td>

                  <td><a href="index.php?action=editacoment&id='.$sec.'.'.$item["rc_numcomentario"].'&ids='.$ser.'&sec='.$sec.'">'.$item["rc_descomentarioesp"].'</a>
                  </td>
                  
                   <td><a href="index.php?action=reactivocoment&idb='.$item["rc_numcomentario"].'&sv='.$ser.'&sec='.$sec.'">borrar</a>
                  </td>
                </tr>';
                   
         } // foreach
              echo  ' </table>
              </div>
             </div>';

    }

    public function botonnuevorcoment(){
        $ser = $_GET["sv"];
        $sec = $_GET["sec"];
    
      echo '
      <div class="row">
        <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevorcoment&id='.$sec.'&ids='.$ser.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
         </div>
         </div>';

    }

  public function nuevorComentController(){
      
    $datosController = $_GET["id"];
    $servicioController = $_GET["ids"];

      
     echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
     echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
            
  }

  public function botonRegresarComentController(){
      
  $ids = $_GET["ids"];
  $id = $_GET["id"];

     echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=reactivocoment&sec='.$id.'&sv='.$ids.'"> Cancelar </a></button>
  ';
  }

public function registraReacComentController(){
      // echo "entre a actualizar el comentario     
    if(isset($_POST["descesp"])){
      $servicio=$_POST["idser"];
      $seccion=$_POST["idsec"];
      $descesp=$_POST["descesp"];
      $descing=$_POST["descing"];
      
      $datosModel=$servicio.'.'.$seccion;
      $respuesta=DatosPond::CalculaultimoReacComentModel($seccion, $servicio, "cue_reactivoscomentarios");
      if (isset($respuesta["clavecom"])) {
          $i=0;
            foreach($respuesta as $row => $item){
              $i=$i+1;
            }
          }    
             $numcom=$respuesta["clavecom"];
        $numcom=$numcom+1;
        
       $datini=SubnivelController::obtienedato($seccion,1);
       $londat=SubnivelController::obtienelon($seccion,1);
       $numsec=substr($seccion,$datini,$londat);
       
       $datini=SubnivelController::obtienedato($seccion,2);
       $londat=SubnivelController::obtienelon($seccion,2);
       $numreac=substr($seccion,$datini,$londat);

       $datosController= array("idser"=>$servicio,
                              "idsec"=>$numsec,
                              "idreac"=>$numreac,
                              'numcom'=>$numcom,
                              "nomesp"=>$descesp,
                              "noming"=>$descing,
                              ); 

          
       $respuesta=DatosPond::registraReacComentModel($datosController, "cue_reactivoscomentarios");
      
        if($respuesta=="success"){
            echo "
           <script type='text/javascript'>
             window.location.href='index.php?action=reactivocoment&sv=".$servicio."&sec=".$seccion."
                </script>
                  ";
        } else {
          echo "error";
        }
      }  
    
    }

public function editarPonderaComentController(){
    
    $datosController = $_GET["id"];
    $idservicio = $_GET["ids"];

    //echo $datosController;
    //echo $idservicio;
    $respuesta = DatosPond::editaPonderaComentModel($datosController,$idservicio,"cue_reactivoscomentarios");
       
    echo ' 
                <input type="text" class="form-control" name="descesp" value="'.$respuesta["rc_descomentarioesp"].'" >
           </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN INGLES</label>
           <input type="text" class="form-control" name="descing" value="'.$respuesta["rc_descomentarioing"].'" >
           </div>';
    }       

  public function actualizarPondComentController(){
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
          
       $respuesta=DatosPond::actualizarPonderaComentModel($datosController, "cue_seccioncomentario");
      
        if($respuesta=="success"){
            echo "
            <script type='text/javascript'>
              window.location.href='index.php?action=listacoment&sv=".$servicio."&sec=".$sec."
                </script>
                  ";
        } else {
          echo "error";
        }
      }  
    
    }

  public function borrarPondComentarioController(){
    if(isset($_GET["idb"])){
      $idb = $_GET["idb"];
      $servicioController = $_GET["sv"];
      $sec=$_GET["sec"];
      $datosController=$sec.'.'.$idb;

      $respuesta = DatosPond::borrarPondComentModel($datosController, $servicioController, "cue_reactivoscomentarios");
    }
  } 


  public function vistaConsultaPonderaController(){
    //lee numero de seccion y numero de servicio
    if (isset($_POST["idcuen"])){
          $cta=$_POST["idcuen"];
          $seccion=$_POST["idsec"];
          $servicioController=$_POST["idser"];
      }else{
          $seccion = $_GET["sec"];
          $servicioController = $_GET["sv"];
      }


     $respuesta = DatosPond::buscacliente($servicioController, "ca_servicios");
     $idcliente=$respuesta["ser_idcliente"];

     $respuesta =DatosPond::consultacuentaModel($idcliente, "ca_cuentas");

      echo '<div class="row">
    <div class="form-group col-md-4" >
    <form role="form" method="post">
    <div class="col-sm-12">
    <div class="input-group input-group-sm">';
       echo '<input type="hidden" name="idsec" value="'.$seccion.'">';
       echo '<input type="hidden" name="idser" value="'.$servicioController.'">';     
       echo '<select class="form-control" name="idcuen" style="margin-left:15px; style="margin-right: 18px; margin-top:15px; margin-bottom:15px;">;
        <option value="">-- Elija la cuenta  --</option>';

        foreach($respuesta as $row => $item){
          if (isset($cta)) {  
              if ($item["cue_id"]==$cta){
                 echo '<option value='.$item["cue_id"].'" selected="selected">'.$item["cue_descripcion"].'</option>';      
              }else{
                  echo '<option value='.$item["cue_id"].'>'.$item["cue_descripcion"].'</option>';       
              }
          } else {
             echo '<option value='.$item["cue_id"].'>'.$item["cue_descripcion"].'</option>';
          }
        }  //foreach

        # aqui va la funcion para releer los puntos de venta con el porcentaje de la cuenta seleccionada

    echo ' </select>

     </div>
     </div>
     <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i>Buscar</button>
                    </span>
   
             
     </div>
     </form>
    </section>';

      # crea titulo de columna ponderada
      # verifica si se ha seleccionado cuenta
      if (isset($cta)){
         #lee descripcion de cuenta
         $respuesta =DatosPond::consultanomcuenta1($cta, $idcliente, "ca_cuentas");
      } else { #busca la primera cuenta
         $respuesta =DatosPond::consultanomcuenta2($idcliente, "ca_cuentas");
         $cta=$respuesta["cue_id"];
      } 
      
    
      // presenta info
      echo  '<section class="content container-fluid">
      <div class="box">
          <div class="box-body no-padding">
                  <table class="table" table-condensed>
                    <tr>
                      <th style="width: 5%">No.</th>
                      <th style="width: 25%">DESCRIPCION</th>
                      <th style="width: 5%">%</th>
                     <th style="width: 10%">'.$respuesta["cue_descripcion"].'</th>
                    </tr>';

          
//busca la info
  $respuesta =DatosPond::vistaPonderaModel($servicioController, $seccion,"cue_reactivos");

         $i=1;
      foreach($respuesta as $row => $item){
        echo '  <tr>
                <td>'.$item["r_numreactivo"].'</td>
                <td>'.
                $item["r_descripcionesp"].'</td>
                
                <td>';
          $respuesta2 =DatosPond::buscaponderacion($seccion, $cta, $servicioController, $item["r_numreactivo"], "cue_reactivosdetalle");
         # si hay ponderacion
           if (isset($respuesta2["rd_ponderacion"])){
               $pondcta=$respuesta2["rd_ponderacion"];
           } else {
              $pondcta=0;
           }
              echo '<a href="index.php?action=ponderareactivo&sec='.$seccion.'&sv='.$servicioController.'&reac='.$item["r_numreactivo"].'"><strong>&nbsp;  %   &nbsp;&nbsp;</strong></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;';

              echo $pondcta.'</td>
                    
                </tr>';
      }
    
            echo  ' </table>
            </div>
           </div>
         
</section>';

    }
  //}

 public function vistaponderareactivo(){
      $ser = $_GET["sv"];
      $sec = $_GET["sec"];
      $reac= $_GET["reac"];
      $numsec =$sec.'.'.$reac;
  
  $respuesta = DatosPond::vistaPonderacionReactivoModel($numsec,$ser, "cue_reactivosdetalle");
   // echo $respuesta;    

    foreach($respuesta as $row => $item){
      echo '  <tr>
                <td>'.$item["rd_clavecuenta"].'</td>';

                $respuesta1 = DatosSeccion::vistaCuentasPonderacionModel($item["rd_clavecuenta"], "ca_cuentas");
                echo '
                <td>'.$respuesta1["cue_descripcion"].'
                </td>
                <td>'.$item["rd_ponderacion"].'
                </td>';
                
                $fecini=SubnivelController::cambiaf_a_normal($item["rd_fechainicio"]);
                $fecfin=SubnivelController::cambiaf_a_normal($item["rd_fechafinal"]);
                echo '
                <td>' .$fecini.'
                </td>
                <td>'.$fecfin.'
                </td>
                
                 <td><a href="index.php?action=ponderaseccion&idb='.$item["rd_clavecuenta"].'&sv='.$ser.'&sec='.$sec.'">borrar</a>
                </td>
                  </tr>';
                 
       } // foreach
    
            echo  ' </table>
            </div>
           </div>';
                  
  }


}

?>