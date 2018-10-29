
<?php
class MvcController{
	#llamada a template
	public function plantilla(){
 		include "views/template.php";
	}
	public function inicio(){
		
		include "views/modulos/cue_login.php";
	}
	
	public function repFQ(){

		$tiporep=$_GET["action"];
		
		include "views/modulos/cue_".$tiporep.".php";

		
	}
    # interaccion del usuario
    public function enlacesPaginasController(){
    	if(isset($_GET["action"])){
		
			$enlacesController = $_GET["action"];
    	}	
    	else {
    	$enlacesController= "index";	
    	}
    	$respuesta = EnlacesPaginas::enlacesPaginasModel($enlacesController);
    	include $respuesta;	
    }
	#registro de usuarios
    #-----------
    public function registroUsuarioController(){
    	if (isset($_POST["nombrecliente"])){	
    	
	    	$datosController=array("nombrecliente"=>$_POST["nombrecliente"]);
	    	
	    	
	    	$respuesta = Datos::registroUsuarioModel($datosController, "ca_clientes");
	    	
	    	       // if($respuesta=="success"){
            echo "
            <script type='text/javascript'>
              window.location.href='index.php?action=listacliente'
                </script>
                  ";
        //} else {
        //  echo "error";
        //}
    	}
    }
    	#vista clientes
		public function vistaClientesController(){
			
			$respuesta =Datos::vistaClientesModel("ca_clientes");
			foreach($respuesta as $row => $item){
			echo '
		        <div class="col-md-4" >
		          <div class="box box-info" >
		            <div class="box-header with-border">
		              <h3 class="box-title">No. '.$item["cli_id"].'</h3>
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
		                      <li><a href="index.php?action=editacliente&id='.$item["cli_id"].'"><strong>'.$item["cli_nombre"].'</strong></a></li>
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
		                   <button type="button" class="btn btn-block btn-info"><a href="index.php?action=listacliente&idb='.$item["cli_id"].'"><i class="fa fa-trash-o"></i></a></button>
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
		      
		   
			 
		    <!-- /.content -->
		';
		}
	}	
	public function editarClienteController(){
		
		$datosController = $_GET["id"];
		$respuesta = Datos::editarClienteModel($datosController, "ca_clientes");
	    	
			echo '<input type="hidden" name="ideditar" value="'.$respuesta["cli_id"].'">
				 <input name="nombreeditar" id="nombreeditar" class="form-control" value="'.$respuesta["cli_nombre"].'">';	
	}	
	public function actualizarClienteController(){
		
		if(isset($_POST["nombreeditar"])){
            $datosController= array("id"=>$_POST["ideditar"],
            			"nombre"=>$_POST["nombreeditar"]); 
         	$respuesta = Datos::actualizarClienteModel($datosController, "ca_clientes");
         //&&	$liga='';
	    	if($respuesta=="success"){
				  echo "
            	<script type='text/javascript'>
                window.location.href='index.php?action=listacliente'
                </script>
                  ";
			
	    	} else {
	    		echo "error";
	    	}
		}
	}	
public function borrarClienteController(){
		
		if(isset($_GET["idb"])){
			$datosController = $_GET["idb"];
			$respuesta = Datos::borrarClienteModel($datosController, "ca_clientes");
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