<?php
class CuentaController{


	public function vistaCuentasController(){
				
				$respuesta =DatosCuenta::vistaCuentasModel("ca_cuentas");

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
                      <li><a href="index.php?action=editacuenta&id='.$item["cue_id"].'"><strong>Nombre: '.$item["cue_descripcion"].'</strong></a></li>
                    </ul>
                </div>
              </div>
               <div class="arrow">
              	  <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                      <li><a href="#"><strong>Tipo: '.$nommerc.'</strong></a></li>
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
                 <button type="button" class="btn btn-block btn-info" ><a  href="index.php?action=listacuenta&idb='.$item["cue_id"].'"><i class="fa fa-trash-o"></i></a></button>

                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              </div>
              </div>
              
              </div>';


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
           <input type="text" class="form-control" name="cuedes" value="'.$respuesta["cue_descripcion"].'" >
          </div>
          <div class="form-group col-md-6">
              <label>CLIENTE</label>
              <select class="form-control" name="clicuen">   
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
                  <select class="form-control" name="tipomercuen">';
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
                </div>';

               

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



}

?>