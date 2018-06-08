<?php
class enlacesController{

	public function listaserviciosController(){
        $respuesta = DatosEnlaces::vistaEnlacesModel("ca_servicios");
      	
		foreach($respuesta as $row => $item){

      	echo '<li>
                  <a href="index.php?action=rlistaunegocio&sv='.$item["ser_id"].'"><i class="fa fa-circle-o"></i> '.$item["ser_descripcionesp"].'
                    
                  </a>
              </li>';

      	}
    } 



}
?>