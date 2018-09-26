 <?php
class FranquiciaController{


public function listaCuentasController(){
      
  $respuesta =DatosFranquicia::listaCuentasModel("ca_cuentas");

  foreach($respuesta as $row => $item){

      echo '<option value='.$item["cue_id"].'>'.$item["cue_descripcion"].'</option>';

    }                  

   }


  public function vistaFranquiciaController(){
        
        $respuesta =DatosFranquicia::vistaFranquiciasModel("ca_franquiciascuenta");

        foreach($respuesta as $row => $item){

     
           echo ' 
            <div class="col-md-4" >
              <div class="box box-info" >
                <div class="box-header with-border">
                  <h3 class="box-title">No. '.$item["fc_idfranquiciacta"].'</h3>
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
                          <li><a href="index.php?action=editafranquicia&id='.$item["fc_idfranquiciacta"].'"><strong>'.$item["cf_descripcion"].'</strong></a></li>
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
                     
                      <button type="button" class="btn btn-block btn-info" ><a  href="index.php?action=listafranquicia&idb='.$item["fc_idfranquiciacta"].'"><i class="fa fa-trash-o"></i></a></button>
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
      }
   }   


#registro de franquicias
    #-----------

    public function registroFranquiciaController(){

      if (isset($_POST["franombre"])){  
      
        $datosController=array("franom"=>$_POST["franombre"],
                               "fracuen"=>$_POST["fraidcuenta"]
                                    );        
        
        $respuesta = DatosFranquicia::registroFranquiciaModel($datosController, "ca_franquiciascuenta");
        if($respuesta== "success"){
         echo "
            <script type='text/javascript'>
              window.location.href='index.php?action=listafranquicia'
                </script>
                  ";
        }

        else {
          echo '<script> windows.location= "index.php" </script>';
         // header("location:index.php");
        }
      }
    }

  public function editarFranquiciaController(){
    
    $datosController = $_GET["id"];
    $respuesta = DatosFranquicia::editarFranquiciaModel($datosController, "ca_franquiciascuenta");
    $listacuen =DatosFranquicia::listaCuentasModel("ca_cuentas");
    echo '              
    <input type="hidden" name="idfraeditar" value="'.$respuesta["fc_idfranquiciacta"].'">
     <input name="franombre" id="franombre" class="form-control" value="'.$respuesta["cf_descripcion"].'">
          </div>
          <div class="form-group col-md-6">
           <label >Cuenta</label>
              <select class="form-control" name="fraidcuenta" id="fraidcuenta" >
              <option value="">-- Elija la cuenta  --</option>';

          foreach($listacuen as $row => $itemf){                 
            if($itemf["cue_id"] == $respuesta["cue_clavecuenta"]){
              echo '<option value="'.$itemf["cue_id"].'" selected="selected">'.$itemf["cue_descripcion"].'</option>';
            }else{  
              echo '<option value="'.$itemf["cue_id"].'">'.$itemf["cue_descripcion"].'</option>';
            }  
          }
          echo '</select>
          </div>';


  }  

 public function actualizarFranquiciaController(){
    
    if(isset($_POST["franombre"])){

            $datosController= array("fraid"=>$_POST["idfraeditar"],
                                    "franom"=>$_POST["franombre"],
                                    "fraidcuen"=>$_POST["fraidcuenta"]
                                    ); 

          $respuesta = DatosFranquicia::actualizarFranquiciaModel($datosController, "ca_franquiciascuenta");

        if($respuesta=="success"){
     
         echo "
            <script type='text/javascript'>
              window.location.href='index.php?action=listafranquicia'
                </script>
                  ";
        } else {
          echo "error";
        }
    }
  }

public function borrarFranquiciaController(){
    if(isset($_GET["idb"])){
      $datosController = $_GET["idb"];

      $respuesta = DatosFranquicia::borrarFranquiciaModel($datosController, "ca_franquiciascuenta");
    //  echo $respuesta;
        if($respuesta=="success"){
                  echo "
            <script type='text/javascript'>
                window.location.href='index.php?action=listafranquicia'
                </script>
                  ";
                  

        
          } else {
            echo "error";
          } 
    }
  } 




}



?>