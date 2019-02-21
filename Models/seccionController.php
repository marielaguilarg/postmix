<?php
class seccionController{

public function vistanomservController(){
    $datosController = $_GET["idser"];
   $idc=$_GET["idc"];
    echo '<li><a href="index.php?action=listaservicio&idc='.$idc.'"><em class="fa fa-dashboard"></em>SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
  //}
}

public function vistaNomServicioController(){
    if (isset($_GET["idser"])) {
	$numser = $_GET["idser"];
	}
	if (isset($_GET["sv"])) {
	$numser = $_GET["sv"];
	}
    #buscar el nombre del servicio
    $respuesta =DatosServicio::vistaNomServicioModel($numser,"ca_servicios");

    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
  //}
}

public function vistaNomServSeccController(){
    $numser = $_GET["sv"];
    $numsec = $_GET["sec"];
    #buscar el nombre del servicio
    $respuesta =DatosServicio::vistaNomServicioModel($numser,"ca_servicios");
    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
    
	$respuesta =DatosSeccion::vistaNombreSeccionModel($numsec, $numser, "cue_secciones");	
    echo '<li><a href="index.php?action=listaseccion&idser='.$numser.'">SECCION: '.$respuesta["sec_nomsecesp"]. '</a></li>';
}

	public function vistaSeccionController(){
		$numser = $_GET["idser"];

    $respuesta =DatosSeccion::vistaSeccionModel($numser,"cue_secciones");

echo '<button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevaseccion&idser='.$numser.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  NUEVO  </a></button>
     </div>
     </div>

    </section>

    <!-- Main content -->
    <section class="content container-fluid">';


		$respuesta =DatosSeccion::vistaSeccionModel($numser,"cue_secciones");
		$bac=$i=1;
		foreach($respuesta as $row => $item){
			if(($i-1)%3==0){
        		echo '<div class="row">';
        		$bac=0;
        	}
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
              <div class="arrow">
              	  <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                    <input type="hidden" name="idsereditar" value="'.$item["sec_tiposeccion"].'">
                      <li><a href="#"><strong>SECCION:</strong> '. $item["sec_nomsecesp"].'</a></li>
                    </ul>
                </div>
                 <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                      <li><a href="index.php?action=editaseccion&id='.$item["sec_numseccion"].'&sv='.$item["ser_claveservicio"].'"><strong>DESCRIPCION:</strong> '. $item["sec_descripcionesp"].'</a></li>
                    </ul>
                </div>
              </div>
				<div class="row col-sm-12">
			      <div class="box-footer no-padding col-sm-6">
                    <ul class="nav nav-stacked">';

              $respuesta1 =DatosSeccion::vistaPonderaModel($numser,"cue_secciones");
                    $cta=$respuesta1["cue_id"];        

                      echo '<li><a href="index.php?action=sn&sec='.$item["sec_numseccion"].'&sv='.$item["ser_claveservicio"].'&ts=SN"><strong>'.$respuesta1["cue_descripcion"] .':</strong>  ';
                      $datosController= array("numsec"=>$item["sec_numseccion"],
                                    "servicio"=>$numser,
                                    "cuenta"=>$cta,
                                     ); 

              $respuesta2 = DatosSeccion::vistaPonderaDetalleModel($datosController, "ca_cuentas");
                      if (isset($respuesta2["sd_ponderacion"])){
                       echo $respuesta2["sd_ponderacion"].'% </a></li>';	
                      } else {
                        echo '0 % </a></li>';
                      }
                    echo '</ul>
                </div>
				
      <div class="box-footer no-padding col-sm-6">
                    <ul class="nav nav-stacked">
                      <li><a href="index.php?action=ponderaseccion&sec='.$item["sec_numseccion"].'&sv='.$item["ser_claveservicio"].'"><strong> PONDERACION  </strong>    %</a></li>
                    </ul>
                </div>
        </div>      
               <div class="row" >
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                 
                    <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=sn&sec='.$item["sec_numseccion"].'&ts='.$item["sec_tiposeccion"].'&sv='.$item["ser_claveservicio"].'"> <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> </a></span></button>


                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                   <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=listacoment&sec='.$item["sec_numseccion"].'&sv='.$item["ser_claveservicio"].'"><i class="fa fa-comment fa-lg" aria-hidden="true"></i></a></span></button>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                 <button type="button" class="btn btn-block btn-info"><a href="index.php?action=listaseccion&idb='.$item["sec_numseccion"].'&idser='.$item["ser_claveservicio"].'"><i class="fa fa-trash-o fa-lg"></i></a></button>
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
           if(($i)%3==0){
           	
           	echo '</div>';
           	$bac=1;
           }
           $i++;
		  

		}
	}	


public function editarSeccionController(){
    
    $datosController = $_GET["id"];
    $idservicio = $_GET["sv"];
    $respuesta = DatosSeccion::editaSeccionModel($datosController,$idservicio,"cue_secciones");
    
    echo '<div class="form-group col-md-6">
          <input type="hidden" name="idsersec" value="'.$respuesta["ser_claveservicio"].'">
          <input type="hidden" name="idseced" value="'.$respuesta["sec_numseccion"].'">
           <label>NOMBRE DE SECCION EN ESPAÑOL</label>
           <input type="text" class="form-control" name="nomesp" value="'.$respuesta["sec_nomsecesp"].'" required>
           </div>
           <div class="form-group col-md-6">
           <label>NOMBRE DE SECCION EN INGLES</label>
           <input type="text" class="form-control" name="noming" value="'.$respuesta["sec_nomsecing"].'" required>
          </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN ESPAÑOL</label>
           <input type="text" class="form-control" name="desesp" value="'.$respuesta["sec_descripcionesp"].'" required>
           </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN INGLES</label>
           <input type="text" class="form-control" name="desing" value="'.$respuesta["sec_descripcioning"].'" required>
           </div>
           <div class="form-group col-md-6">
          <label>ORDEN MENU INDICADORES</label>
           <input type="text" class="form-control" name="ordensec" value="'.$respuesta["sec_ordsecind"].'" >
           
          </div>
          <div class="form-group col-md-6">
          <label>MANEJA MUESTRAS DE AGUA</label></div>';

          IF ($respuesta["sec_indagua"]) {
            $indagua= 'checked="checked"';
          } else {
            $indagua='';
          }
                   
          echo '
           <div class="form-group col-md-6">
           <input type="checkbox" name="indmues" id="indmues" '. $indagua .' />
            </div> 
           <div class="box-footer col-md-12">
                  <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=listaseccion&idser='.$respuesta["ser_claveservicio"].'"> CANCELAR </a></button>
                  <button type="submit" class="btn btn-info pull-right">GUARDAR</button>  
                 </div>';
               

}   

 public function actualizarSeccionController(){
      // echo "entre a actualizar cuenta controller";
  
       
    if(isset($_POST["nomesp"])){
      if (isset($_POST["indmues"])){
          $indagua=-1;
      }else{
          $indagua=0;
      }
      $datosController= array("idsec"=>$_POST["idseced"],
                              "idser"=>$_POST["idsersec"],
                              "nomesp"=>$_POST["nomesp"],
                              "noming"=>$_POST["noming"],
                              "desesp"=>$_POST["desesp"],
                              "desing"=>$_POST["desing"],
                              "ordensec"=>$_POST["ordensec"],
                              "indagua"=>$indagua,
                              ); 

      
          $respuesta=DatosSeccion::actualizarSeccionModel($datosController, "cue_secciones");
           echo $respuesta; 
       // if($respuesta=="success"){
          echo "
            <script type='text/javascript'>
              window.location='index.php?action=listaseccion&idser=".$_POST["idsersec"]."'
                </script>
                  ";
        //} else {
        //  echo "error";
       // }
      }  
    
    }


public function botonRegresaSeccionController(){
    
$datosController = $_GET["idser"];  
   echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=listaseccion&idser='.$datosController.'"> CANCELAR </a></button>';
}


public function nuevaSeccionController(){
    
$datosController = $_GET["idser"];
    
   echo '<input type="hidden" name="idsersec" value="'.$datosController.'">';
          
}

public function registrarSeccionController(){
      // echo "entre a actualizar cuenta controller";
  
       
    if(isset($_POST["nomesp"])){
      if (isset($_POST["indmues"])){
          $indagua=-1;
      }else{
          $indagua=0;
      }
      $datosServicio=$_POST["idsersec"];

      
      $numsec=DatosSeccion::CalculaultimaSeccionModel($datosServicio, "cue_secciones");
      //echo $numsec;
      $nsec=+$numsec["ulnumsec"]+1;
      //echo $nsec;
      $datosController= array("idser"=>$_POST["idsersec"],
                              "idsec"=>$nsec,
                              "nomesp"=>$_POST["nomesp"],
                              "noming"=>$_POST["noming"],
                              "desesp"=>$_POST["desesp"],
                              "desing"=>$_POST["desing"],
                              "ordensec"=>$_POST["ordensec"],
                              "indagua"=>$indagua,
                              ); 
          
          $respuesta=DatosSeccion::registrarSeccionModel($datosController, "cue_secciones");
           //echo $respuesta; 
        if($respuesta=="success"){
            echo "
            <script type='text/javascript'>
              window.location='index.php?action=listaseccion&idser=".$datosServicio."'
                </script>
                  ";
				    
        } else {
          echo "error";
        }
      }  
    
    }

 public function borrarSeccionController(){
    if(isset($_GET["idb"])){
      $datosController = $_GET["idb"];
      $servicioController = $_GET["idser"];

      $respuesta = DatosSeccion::borrarSeccionModel($datosController,$servicioController, "cue_secciones");
    }
  } 

  public function iniciopoderaseccion(){
      $ser = $_GET["sv"];
      $sec = $_GET["sec"];

    echo '<section class="content-header">
      <h1>Ponderacion de Secciones <small></small></h1>
      <ol class="breadcrumb" >';
#buscar el nombre del servicio
    $respuesta =DatosServicio::vistaNomServicioModel($ser,"ca_servicios");

    echo '<li><a href="index.php?action=listaservicio">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
    # busco seccion
    $respuesta=DatosSeccion::vistaNombreSeccion($ser, $sec,"cue_secciones");
    //var_dump($respuesta);
    echo '<li><a href="index.php?action=listaseccion&idser='.$ser.'">SECCION: '.$respuesta["sec_descripcionesp"]. '</a></li>';
    echo '        
</ol>
 </section>';     
  
    


  echo '
  <div class="row">
      <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevaponcuenta&id='.$sec.'&ids='.$ser.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
       </div>
       </div>';

      echo '<input type="hidden" name="idsec" value="'.$sec.'">';
      echo '<input type="hidden" name="idser" value="'.$ser.'">';

  }

  public function vistapoderaseccion(){
   $ser = $_GET["sv"];
      $sec = $_GET["sec"];
  
  $respuesta = DatosSeccion::vistaPonderacionDetalleModel($sec,$ser, "cue_seccionesdetalles");
   // echo $respuesta;    

    foreach($respuesta as $row => $item){
      echo '  <tr>
                <td>'.$item["sd_clavecuenta"].'</td>';

                $respuesta1 = DatosSeccion::vistaCuentasPonderacionModel($item["sd_clavecuenta"], "ca_cuentas");
                echo '
                <td><a href="index.php?action=sn&sec=&sv='.$ser.'&ts=ED">'.$respuesta1["cue_descripcion"].'</a>
                </td>
                <td>'.$item["sd_ponderacion"].'
                </td>';
                
                $fecini=SubnivelController::cambiaf_a_normal($item["sd_fechainicio"]);
                $fecfin=SubnivelController::cambiaf_a_normal($item["sd_fechafinal"]);
                echo '
                <td>' .$fecini.'
                </td>
                <td>'.$fecfin.'
                </td>
                
                 <td><a href="index.php?action=ponderaseccion&idb='.$item["sd_clavecuenta"].'&sv='.$ser.'&sec='.$sec.'">borrar</a>
                </td>
                  </tr>';
                 
       } // foreach
    
            echo  ' </table>
            </div>
           </div>';
                  
  }


public function borrarSeccionPonderaController(){
    if(isset($_GET["idb"])){
      $datosController = $_GET["idb"];
      $servicioController = $_GET["sv"];
      $seccion = $_GET["sec"];

      $respuesta = DatosSeccion::borrarSeccionPonderaModel($datosController,$seccion,$servicioController, "cue_seccionesdetalles"); 
    }
  } 

  public function vistaseccioncoment(){
   $ser = $_GET["sv"];
   $sec = $_GET["sec"];

  $respuesta = DatosSeccion::vistaSeccionComentModel($sec, $ser, "cue_seccioncomentario");

    foreach($respuesta as $row => $item){
      echo '  <tr>
                <td>'.$item["sec_numcoment"].'</td>

                <td><a href="index.php?action=editacoment&id='.$sec.'.'.$item["sec_numcoment"].'&ids='.$ser.'&sec='.$sec.'">'.$item["sec_comentesp"].'</a>
                </td>
                
                 <td><a href="index.php?action=listacoment&idb='.$item["sec_numcoment"].'&sv='.$ser.'&sec='.$sec.'"><i class="fa fa-trash-o fa-lg"></i></a>
                </td>
              </tr>';
                 
       } // foreach
            echo  ' </table>
            </div>
           </div>';

  }

  public function botonnuevocoment(){
      $ser = $_GET["sv"];
      $sec = $_GET["sec"];
  
    echo '
    <div class="row">
      <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px"><a href="index.php?action=nuevocoment&id='.$sec.'&ids='.$ser.'" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  NUEVO  </a></button>
       </div>
       </div>';

  }

  public function botonRegresaComentarioController(){
      
  $ids = $_GET["ids"];
  $id = $_GET["id"];

     echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=listacoment&sec='.$id.'&sv='.$ids.'"> CANCELAR </a></button>
  ';
  }

  public function botonRegresaEditComentario(){
      
  $ids = $_GET["ids"];
  $id = $_GET["sec"];

     echo ' <button  class="btn btn-default pull-right" style="margin-left: 10px"><a href="index.php?action=listacoment&sec='.$id.'&sv='.$ids.'"> CANCELAR </a></button>
  ';
  }



  public function nuevaComentController(){
      
  $datosController = $_GET["id"];
  $servicioController = $_GET["ids"];

      
     echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
     echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
            
  }

  public function inicioEditComentController(){
      
  $datosController = $_GET["id"];
  $servicioController = $_GET["ids"];
  $sec = $_GET["sec"];
     
     echo '<input type="hidden" name="idsec" value="'.$datosController.'">';
     echo '<input type="hidden" name="idser" value="'.$servicioController.'">';
     echo '<input type="hidden" name="sec" value="'.$sec.'">';
            
  }



  public function registrarComentController(){
      // echo "entre a actualizar el comentario     
    if(isset($_POST["descesp"])){
      $servicio=$_POST["idser"];
      $seccion=$_POST["idsec"];
      $descesp=$_POST["descesp"];
      $descing=$_POST["descing"];
      
      $datosModel=$servicio.'.'.$seccion;
      $respuesta=DatosSeccion::CalculaultimoComentModel($datosModel, "cue_seccioncomentario");
      //echo $numsec;
      if (isset($respuesta["clave"])) {
          $i=0;
            foreach($respuesta as $row => $item){
              $i=$i+1;
            }
          }    
        //echo $i;

        //if ($i>0) {
        //  foreach($respuesta as $row => $item){
             $numcom=$respuesta["clave"];
          //  }   
        //} else {
        //  $numcom=0;
        //}
        $numcom=$numcom+1;
        //echo $numcom;
       $datosController= array("idser"=>$servicio,
                              "idsec"=>$seccion,
                              'numcom'=>$numcom,
                              "nomesp"=>$descesp,
                              "noming"=>$descing,
                              ); 
          
       $respuesta=DatosSeccion::registrarComentSeccionModel($datosController, "cue_seccioncomentario");
       
        if($respuesta=="success"){
            echo "
            <script type='text/javascript'>
              window.location='index.php?action=listacoment&sv=".$servicio."&sec=".$seccion."'
                </script>
                  ";
				  
        } else {
          echo "error";
        }
		
		
		
      }  
    
    }


  public function editarComentController(){
    
    $datosController = $_GET["id"];
    $idservicio = $_GET["ids"];

    //echo $datosController;
    //echo $idservicio;
    $respuesta = DatosSeccion::editaComentModel($datosController,$idservicio,"cue_seccioncomentario");
       
	   
    echo ' 
                <input type="text" class="form-control" name="descesp" value="'.$respuesta["sec_comentesp"].'" required>
           </div>
           <div class="form-group col-md-6">
           <label>DESCRIPCION EN INGLES</label>
           <input type="text" class="form-control" name="descing" value="'.$respuesta["sec_comenting"].'" required>
           </div>';
    }       

public function actualizarComentController(){
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
          
       $respuesta=DatosSeccion::actualizarComentSeccionModel($datosController, "cue_seccioncomentario");
     
        if($respuesta=="success"){
            echo "
            <script type='text/javascript'>
              window.location='index.php?action=listacoment&sv=".$servicio."&sec=".$sec."'
                </script>
                  ";
        } else {
          echo "error";
        }
      }  
    
    }

  public function borrarComentarioController(){
    if(isset($_GET["idb"])){
      $idb = $_GET["idb"];
      $servicioController = $_GET["sv"];
      $sec=$_GET["sec"];
      $datosController=$sec.'.'.$idb;

      $respuesta = DatosSeccion::borrarComentModel($datosController, $servicioController, "cue_seccioncomentario");
    }
  } 

  public function vistaConsultaPonderaSeccionController(){
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
  $respuesta =DatosSeccion::vistaSeccionModel($servicioController,"cue_secciones");

         $i=1;
      foreach($respuesta as $row => $item){
        echo '  <tr>
                <td>'.$item["sec_numseccion"].'</td>
                <td>'.
                $item["sec_nomsecesp"].'</td>
                <td>';

          $respuesta2 =DatosSeccion::buscaponderacionseccion($seccion, $servicioController, $cta, "cue_seccionesdetalles");
         # si hay ponderacion
           if (isset($respuesta2["sd_ponderacion"])){
               $pondcta=$respuesta2["sd_ponderacion"];
           } else {
              $pondcta=0;
           }
              echo '<a href="index.php?action=ponderareactivo&sec='.$seccion.'&sv='.$servicioController.'"><strong>&nbsp;  %   &nbsp;&nbsp;</strong></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;';

              echo $pondcta.'</td>
                    
                </tr>';
      }
    
            echo  ' </table>
            </div>
           </div>
         
</section>';

    }



public function vistanomRservController(){
    $datosController = $_GET["sv"];
    $idc = $_GET["idc"];
    $respuesta = DatosSeccion::vistaNombreServModel($datosController,"ca_servicios");
    echo '<li><a href="index.php?action=rlistaunegocio&idc='.$idc.'&sv='.$datosController.'">SERVICIO: '.$respuesta["ser_descripcionesp"]. '</a></li>';
  //}
}

public function ingresaimagen(){
      $servicio = $_GET["sv"];
      $seccion = $_GET["sec"];
	  $reporte = $_GET["nrep"];
      $punvta = $_GET["pv"];
	  $idc=$_GET["idc"];
	  
  
    echo '
<div class="row">
   <div class="col-md-12">
    <div class="box box-info">
    <div class="box-header with-border">ARCHIVOS</div>
    <div class="box-body">  
    <div class="row">
<div class="col-md-12">
<form  name="bform"  method="post" enctype="multipart/form-data"> 

   <div class="form-group">
    <input type="hidden" name="servicio" size="20" maxlength="100" value="'.$idserv.'">
   <input type="hidden" name="reporte" size="20" maxlength="100" value="'.$nsol.'">
    <input type="hidden" name="MAX_FILE_SIZE" value="600000">                     
   
   <input class="form-control-file"  type="file" name="pictures1" id="pictures1" accept="image/gif,image/jpeg,image/x-png" />
   <br /> 
   Descripci&oacute;n 1 : 
   <input type="text" name="descripcion1" id="descripcion1" class="campoTxt" size="100" maxlength="500"   />

   <br />
   Incluir en Certificado:   <input name="incluir1" type="checkbox"/><br />
<br />
<input class="form-control-file"  type="file" name="pictures2" id="pictures2" accept="image/gif,image/jpeg,image/x-png" />
   <br /> 
   Descripci&oacute;n 2 : 
   <input type="text" name="descripcion2" id="descripcion2" class="campoTxt" size="100" maxlength="500"   />

   <br />
   Incluir en Certificado:   <input name="incluir2" type="checkbox"/><br />
    <br />
   <input class="form-control-file"  type="file" name="pictures3" id="pictures3" accept="image/gif,image/jpeg,image/x-png" />
   <br /> 
   Descripci&oacute;n 3 : 
   <input type="text" name="descripcion3" id="descripcion3" class="campoTxt" size="100" maxlength="500"   />

   <br />
   Incluir en Certificado:   <input name="incluir3" type="checkbox"/><br />
';

// aqui llamamos el programa para guardar 
      $archivo=$this->subeimagen();


echo '
</div> <div class="form-group">
   <button type="submit" name="submit"  class="btn btn-info pull-right"> Guardar   </button>
        
</div>

  </form> </div></div>       
         <div class="row">     
          <div class="col-md-12 table-responsive">         
       <table class="table">    
<tr>             
<th>No.</th><th>NOMBRE</th></tr>';

      $servicio = $_GET["sv"];
      $seccion = $_GET["sec"];
	  $reporte = $_GET["nrep"];
      $punvta = $_GET["pv"];
	  $idc=$_GET["idc"];
	  

// busca imagenes subidas
		$datosController= array("servicio"=>$servicio,
                              "numrep"=>$reporte,
                              "seccion"=>$seccion,
                              "reactivo"=>$reactivo,
                              ); 
							  
			echo $datosController["servicio"];
			echo $datosController["numrep"];
			echo $datosController["seccion"];
			echo $datosController["reactivo"];				  
							  
		$respuesta = DatosSeccion::getListaImagenes($datosController,"ins_imagendetalle");
 	    foreach($respuesta as $infoimg){
			$rutaimg=$infoimg["id_ruta"];
			$display=$infoimg["id_idimagen"];
			
        	echo '  <a data-fancybox="gallery" href="'.$rutaimg.'" '.$display.'><img src="'.$rutaimg.'" width="350" height="234"></a>';
			if($cont==3)
				$display="style='display:none;'";
				$cont++;
				// echo "</div></div>";
		}    
		echo '
                    </table></div></div>
    </div>
</div>           
</div>
</div>
';

  }


 public function subeimagen(){
        define('RAIZ',"../fotografias");

              //echo $ncuenta;
             include ('Utilerias/leevar.php');
              $refer=3;
              $status=1;
               // valida si hay archivo para ingresar
          
               if ($_FILES ["pictures1"]&&$reporte){
                  $carpeta=$this->verificaCarpeta($servicio,$reporte);
                 
                  if($carpeta!=-1)
                  {
                      $ban=0;
                      foreach ( $_FILES ["pictures1"] ["error"] as $key => $error ) {
                          $name = $_FILES ["pictures1"] ["name"] [$key];
                          
                          if ($error == UPLOAD_ERR_OK) {
                              $tmp_name = $_FILES ["pictures1"] ["tmp_name"] [$key];
                              //reviso tamaña
                              if( $_FILES ["pictures1"] ["size"] [$key]>1048576)
                              {	$this->msg="<div class='alert alert-danger' role='alert'><br>El tamaño de los archivos no puede ser mayor a 1Mb</div>";
                             	return false;
                              }
                              $uploadfile =RAIZ."/".$carpeta . '/'.basename ( $name );
                              if(!is_file($uploadfile))
                              {
                                  if (@move_uploaded_file ( $tmp_name, $uploadfile )) {
                                      try{
                                      $this->InsertaImagenDetalle($servicio, $reporte, $carpeta . '/'.basename ( $name ),$des,$pres);
                                      
                                      
                                      $this->msg="<div  class='alert alert-success' role='alert'><br>El archivo '" . $name . "' fue cargado exitosamente.</div>";
                                      }catch(Exception $ex){
                                          $this->msg="<div  class='alert alert-danger' role='alert'><br>".$ex->getMessage()."</div>";
                                          
                                      }
                                      //	$html->asignar('msg',$msg);
                                  } else {
                                      $this->msg="<div  class='alert alert-danger' role='alert'><br>Error al cargar el archivo, intenta de nuevo</div>";
                                      //	   $html->asignar('msg',$msg);
                                      $ban=1;
                                  }
                              }
                              else
                              {
                                  $this->msg="<div class='alert alert-danger' role='alert'><br>El archivo '" . $name . "' ya existe</div>";
                                  //  $html->asignar('msg',$msg);
                                  $ban=1;
                              }
                          }
                          else if ($error == UPLOAD_ERR_FORM_SIZE) {
                              $this->msg='<div class="alert alert-danger" role="alert"><br>El archivo "' . $name . '" excede el tamaño máximo</div>';
                              //$html->asignar('msg',$msg);
                              $ban=1;
                          }else
                              if ($error == UPLOAD_ERR_CANT_WRITE) {
                                  $this->msg='<div class="alert alert-danger" role="alert"><br>No se encontró el directorio especificado</div>';
                                  //$html->asignar('msg',$msg);
                                  
                                  $ban=1;
                              }
                          $contdes++;
                      } //termina foreach
                  }
              }
             
          }

 function verificaCarpeta($servicio,$reporte)
            {
                
                
                $ruta=$servicio."/".$reporte;
                
                if(!is_dir(RAIZ."/".$servicio))
                {
                    try{
                        mkdir(RAIZ."/".$ruta,0777,true);
                    }
                    catch(Exception $ex){
                        throw  $ex;
                        
                    }
                }
                
                if(!is_dir(RAIZ."/".$servicio."/".$reporte))
                {
                    // creo la carpeta
                    try{
                        mkdir(RAIZ."/".$ruta,0777,true);
                    }
                    catch(Exception $ex){
                        throw  $ex;
                        
                    }
                }
                
                return $ruta; //si existe
          }
          
}


function InsertaImagenDetalle($servicio, $reporte,$seccion,$reactivo,$ruta,$descripcion,$presentar) {
            //primero busco el siguiente id
		$datosController= array("servicio"=>$servicio,
                              "numrep"=>$reporte,
                              "seccion"=>$seccion,
                              "reactivo"=>$reactivo,
                              ); 
							  
		$respuesta = DatosSeccion::getNumImagen($datosController,"ins_imagendetalle");
		$sigId=$respuesta["id"]+1;		
		
		$datosController= array("servicio"=>$servicio,
                              "numrep"=>$reporte,
                              "seccion"=>$seccion,
                              "reactivo"=>$reactivo,
							  "sigId"=>$sigId,
							  "ruta"=>$ruta,
							  "descripcion"=>$descripcion,
							  "presentar"=>$presentar,
                              ); 
							  
		$respuesta = DatosSeccion::InsertaImagen($datosController,"ins_imagendetalle");
}
?>