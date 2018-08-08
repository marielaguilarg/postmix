<?php
class ServicioController{


public function listaClientesController(){
      
  $respuesta =DatosServicio::listaClientesModel("ca_clientes");

  foreach($respuesta as $row => $item){

      echo '<option value='.$item["cli_id"].'>'.$item["cli_nombre"].'</option>';

    }                  

   }
 


public function vistaServiciosController(){
			
	$respuesta =DatosServicio::vistaServiciosModel("ca_servicios");

	foreach($respuesta as $row => $item){


			echo ' 
        <div class="col-md-4" >
          <div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">'.$item["ser_id"].'</h3>

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
                      <li><a href="index.php?action=editaservicio&ids='.$item["ser_id"].'"<strong>'.$item["ser_descripcionesp"].'</strong></a></li>
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
                   <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=listaseccion&idser='.$item["ser_id"].'"> Cuestionario </a></span></button>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                 
                  <button type="button" class="btn btn-block btn-info"><a href="index.php?action=listaservicio&idb='.$item["ser_id"].'"><i class="fa fa-trash-o"></i></a></button>
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
		}

	}	


  public function editarServicioController(){
    
    $datosController = $_GET["ids"];
    $respuesta = DatosServicio::editarServicioModel($datosController, "ca_servicios");
    $listaclien =DatosServicio::listaClientesModel("ca_clientes");

echo '<div class="form-group col-md-6">
<input type="hidden" name="idsereditar" value="'.$respuesta["ser_id"].'">
                <label >NOMBRE EN ESPAÑOL</label>
               
                   <div class="col-sm-10">
                    <input name="sernombreesp" id="sernombreesp" class="form-control" value="'.$respuesta["ser_descripcionesp"].'">
                </div>
                </div>
                <div class="form-group col-md-6">
                 <label >NOMBRE EN INGLES</label>
               <div class="col-sm-10">
                    <input name="sernombreing" id="sernombreing" class="form-control" value="'.$respuesta["ser_descripcioning"].'">
                </div>
                </div>
                <div class="form-group col-md-6">
                <label >CLIENTE</label>
                <select class="form-control" name="seridcliente" id="seridcliente" >
';
                foreach($listaclien as $row => $itemc){                 
                  if($itemc[0] == $respuesta['ser_idcliente']){
                    echo '<option value="'.$itemc["cli_id"].'" selected="selected">'.$itemc["cli_nombre"].'</option>';
                  }else{  
                    echo '<option value="'.$itemc["cli_id"].'">'.$itemc["cli_nombre"].'</option>';
                  }  
                }
                echo '</select>
                </div>'
                  ;

                
}

  public function actualizarServicioController(){
    
    if(isset($_POST["sernombreesp"])){

            $datosController= array("id"=>$_POST["idsereditar"],
                                    "nomesp"=>$_POST["sernombreesp"],
                                    "noming"=>$_POST["sernombreing"],
                                    "idclien"=>$_POST["seridcliente"]
                                    ); 

          $respuesta = DatosServicio::actualizarServicioModel($datosController, "ca_servicios");

        if($respuesta=="success"){
          echo "
            <script type='text/javascript'>
                window.location.href='index.php?action=listaservicio'
                </script>
                  ";} else {
          echo "error";
        }
    }



  }


#registro de usuarios
    #-----------

    public function registroServicioController(){

      if (isset($_POST["sernombreesp"])){  
      
        $datosController=array("nomesp"=>$_POST["sernombreesp"],
                               "noming"=>$_POST["sernombreing"],
                               "idclien"=>$_POST["seridcliente"]
                                    );        
        
        $respuesta = DatosServicio::registroServicioModel($datosController, "ca_servicios");
        
        if($respuesta=="success"){
            echo "
            <script type='text/javascript'>
              window.location.href='index.php?action=listaservicio'
                </script>
                  ";
        } else {
          echo "error";
        }
      }
    }

public function borrarServicioController(){
    if(isset($_GET["idb"])){
      $datosController = $_GET["idb"];
      $respuesta = DatosServicio::borrarServicioModel($datosController, "ca_servicios");
        if($respuesta=="success"){
           echo '<script> windows.location= "index.php?action=listacliente" </script>';
          //header('location:index.php?action=listacliente');
            // echo "cambio efectuado";
          
        
          } else {
            echo "error";
          } 
    }
  } 




}


?>