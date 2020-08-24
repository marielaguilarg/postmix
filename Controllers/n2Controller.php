<?php
class NdosController{


	public function vistandosController(){
		
		if($_GET["admin"]=="eli"){
			$ec=new EstructuraController();
			$ec->eli();
		}else{
		if (isset($_GET["idnuno"])) {
			$datosController = $_GET["idnuno"];	
		} else {
			$datosController =1;
		}
		
		$respuesta =Datosndos::vistandosModel($datosController,"ca_nivel2");

		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["n2_id"].'</td>
	                 
	                  <td>
	                    <a href="index.php?action=nuevonivel&niv=2&id='.$item["n2_id"].'">'.$item["n2_nombre"].'</a>
	                  </td>
	                  <td>
	                    <a href="index.php?action=listan3&idnd='.$item["n2_id"].'">detalle</a>
	                  </td>
<td> <a type="button" href="index.php?action=listan2&admin=eli&niv=2&id='.$item["n2_id"].'" onclick="return dialogoEliminar();"><i class="fa fa-times"></i></a>
		                </td>
	                </tr>';
	            
		}
		}
	}
	
	
}

?>