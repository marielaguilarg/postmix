<?php
class CuentaController{


	public function vistaCuentasController(){
				
		$respuesta =DatosCuenta::vistaCuentas("ca_cuentas");
		$i=$bac=1;
		foreach($respuesta as $row => $item){

        if ($item["cue_tipomercado"]==1){
          $nommerc="ON PREMISE";
        }  else if ($item["cue_tipomercado"]==2){
          $nommerc="TRADICIONAL";
        }  else if ($item["cue_tipomercado"]==3){
          $nommerc="MODELO";
        }  else if ($item["cue_tipomercado"]==4){
          $nommerc="EXPERIMENTAL";
        }
        
        if(($i-1)%3==0){
        	echo '<div class="row">';
        	$bac=0;
        }
        
		echo '
        <div class="col-md-4" >
          <div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">'.$item["cue_id"].'</h3>

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
                      <li><a href="index.php?action=editacuenta&id='.$item["cue_id"].'"><strong>NOMBRE : '.$item["cue_descripcion"].'</strong></a></li>
                    </ul>
                </div>
              </div>
               <div class="arrow">
              	  <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                      <li><a href="#"><strong>TIPO : '.$nommerc.'</strong></a></li>
                    </ul>
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
                 <a class="btn btn-block btn-info"  onclick="return dialogoEliminar()"  href="index.php?action=listacuenta&idb='.$item["cue_id"].'"><i class="fa fa-trash-o"></i></a>

                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              </div>
              </div>
              
              </div>';
				if(($i)%3==0){
					
					echo '</div>';
					$bac=1;
				}
				$i++;

				}


	}

#lista clientes para clasificar cuentas
  public function listaClientesController(){
      
  $respuesta =DatosCuenta::listaClientesModel("ca_clientes");

  foreach($respuesta as $row => $item){

      echo '<option value='.$item["cli_id"].'>'.$item["cli_nombre"].'</option>';

    }                  

   }
 

  public function registroCuentaController(){

      if (isset($_POST["nomcuen"])){  
      
        $datosController=array("nomcuen"=>$_POST["nomcuen"],
                               "cliencuen"=>$_POST["cliencuen"],
                               "tipomercuen"=>$_POST["tipomercuen"],
                               "siglascuen"=>$_POST["siglascuen"],
                               "lugarcuen"=>$_POST["lugarcuen"]
                                    );        
        
        $respuesta = DatosCuenta::registroCuentaModel($datosController, "ca_cuentas");
        
        if($respuesta== "success"){

          //echo '<script> windows.location= "index.php?action=ok" </script>';
        echo "
            <script type='text/javascript'>
                window.location.href='index.php?action=listacuenta'
                </script>
                  ";
                  
        }

        else {
          echo '<script> windows.location= "index.php?index.php" </script>';  

        }
      }

}


public function editarCuentaController(){
    
    $datosController = $_GET["id"];
    $respuesta = DatosCuenta::editarCuentaModel($datosController, "ca_cuentas");
    $listaclien =DatosCuenta::listaClientesModel("ca_clientes");

    echo '<div class="form-group col-md-6">
    <input type="hidden" name="idcueeditar" value="'.$respuesta["cue_id"].'">
           <label>NOMBRE</label>
           <input type="text" class="form-control" name="cuedes" value="'.$respuesta["cue_descripcion"].'" required>
          </div>
          <div class="form-group col-md-6">
              <label>CLIENTE</label>
              <select class="form-control" name="clicuen" required>   
                 <option value="">-- Elija el cliente  --</option>';

              foreach($listaclien as $row => $itemc){                 
                  if($itemc["cli_id"] == $respuesta['cue_idcliente']){
                    echo '<option value="'.$itemc["cli_id"].'" selected="selected">'.$itemc["cli_nombre"].'</option>';
                  }else{  
                    echo '<option value="'.$itemc["cli_id"].'">'.$itemc["cli_nombre"].'</option>';
                  }  
              }

                  echo '
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>TIPO DE MERCADO</label>
                  <select class="form-control" name="tipomercuen" required>';
                    if($respuesta["cue_tipomercado"] == 1 ){
                       echo '<option value=1  selected="selected">ON PREMISE</option>';
                    }else{
                       echo '<option value=1 >ON PREMISE</option>';
                    }
                    if($respuesta["cue_tipomercado"] == 2 ){
                       echo '<option value=2  selected="selected">TRADICIONAL</option>';
                    }else{
                       echo '<option value= 2 >TRADICIONAL</option>';
                    }if($respuesta["cue_tipomercado"] == 3 ){
                       echo '<option value=3  selected="selected">MODELO</option>';
                    }else{
                       echo '<option value=3 >MODELO</option>';
                    }if($respuesta["cue_tipomercado"] == 4 ){
                       echo '<option value=4  selected="selected">EXPERIMENTAL</option>';
                    }else{
                       echo '<option value=4 >EXPERIMENTAL</option>';
                    }
                   echo '</select>
                </div>
                <div class="form-group col-md-6">
                  <label>SIGLAS</label>
                  <input type="text" class="form-control" name="siglascuen" value="'.$respuesta["cue_siglas"].'">
                </div>
                <div class="form-group col-md-6">
                  <label>LUGAR</label>
                <input type="text" class="form-control" name="lugarcuen" value="'.$respuesta["cue_lugar"].'">
                </div>
                <div class="form-group col-md-6">
                <label >ESTATUS</label>
               <select class="form-control" name="estatus" id="estatus" required>
                ';
                             
                  if($respuesta['cue_estatus']==1){
                    echo '<option value="'.$respuesta["cue_estatus"].'" selected="selected">Activado</option>';
                    echo '<option value="2">Desactivado</option>';
                  }else{
                    echo '<option value="1">Activado</option>';   
                    echo '<option value="'.$respuesta["cue_estatus"].'" selected="selected">Desactivado</option>';
                  }  
                
                echo '</select>
                </div>
              
                ';

               

             }   

 public function actualizarCuentaController(){
      // echo "entre a actualizar cuenta controller";
    if(isset($_POST["cuedes"])){

            $datosController= array("id"=>$_POST["idcueeditar"],
                                    "cuedes"=>$_POST["cuedes"],
                                    "cuetipo"=>$_POST["tipomercuen"],
                                    "cuecli"=>$_POST["clicuen"],
                                    "cuesiglas"=>$_POST["siglascuen"],
                                    "cuelugar"=>$_POST["lugarcuen"]
                                    ); 

          $respuesta = DatosCuenta::actualizarCuentaModel($datosController, "ca_cuentas");
           //echo $respuesta; 
        if($respuesta=="success"){
            echo "
            <script type='text/javascript'>
                window.location.href='index.php?action=listacuenta'
                </script>
                  ";
              } else {
          echo "error";
        }
    }



  }

public function borrarCuentaController(){
    if(isset($_GET["idb"])){
      $datosController = $_GET["idb"];
      $respuesta = DatosCuenta::borrarCuentaModel($datosController, "ca_cuentas");
    //  echo $respuesta;
        if($respuesta=="success"){
           echo '<script> windows.location= "index.php?action=listacuenta" </script>';
          //header('location:index.php?action=listacliente');
            // echo "cambio efectuado";
          
        
          } else {
            echo "error";
          } 
    }
  } 

  public function listaponderaCuentaController(){
        $respuesta = DatosCuenta::vistaCuentasModel("ca_cuentas");
        foreach ($respuesta as $key => $item) {
           echo '<option value='.$item["cue_id"].'>'.$item["cue_descripcion"].'</option>';
        }  
    }

public function registroPonderaCuentaController(){


      if (isset($_POST["cuenta"])){  
        $fecini=SubnivelController::fecha_mysql($_POST["fecini"]);
        $fecfin=SubnivelController::fecha_mysql($_POST["fecfin"]);
        $nser=$_GET["ids"];
        $nsec=$_GET["id"];
        #valida existencia
        $datosController=array("nser"=>$nser,
                               "nsec"=>$nsec,
                               "ncta"=>$_POST["cuenta"],
                               "fecini"=>$fecini,                            
                                    );        

        $respuesta = DatosCuenta::validaperiodocuenta($datosController, "cue_seccionesdetalles");

        if ($respuesta) {
           #mensaje de ya existe
        } else {
          $datosController=array("nser"=>$nser,
                               "nsec"=>$nsec,
                               "ncta"=>$_POST["cuenta"],
                               "fecini"=>$fecfin ,                            
                                    );        

          $respuesta1 = DatosCuenta::validaperiodocuenta($datosController, "cue_seccionesdetalles");

          if ($respuesta1){

           #mensaje de ya existe
          } else {
             #ingresamos
            $datosController=array("nser"=>$nser,
                               "nsec"=>$nsec,
                               "ncta"=>$_POST["cuenta"],
                               "fecini"=>$fecini, 
                               "npond"=>$_POST["ponderacion"], 
                               "fecfin"=>$fecfin, 
                                    ); 
            $respuestai = DatosCuenta::registroPonderaCuenta($datosController, "cue_seccionesdetalles");
            if($respuestai== "success"){
              echo "
              <script type='text/javascript'>
               window.location.href='index.php?action=ponderaseccion&sec=".$nsec."&sv=".$nser."'
                </script>
                ";   
            }  // if de respuestai                 
          } // else respuesta1  
        } // else de respuesta
      }
      
  }         
  


}

?>