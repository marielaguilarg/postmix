<?php
class NdosController{


	public function vistandosController(){
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
	                    <a href="index.php?action=editan2&idnd='.$item["n2_id"].'">'.$item["n2_nombre"].'</a>
	                  </td>
	                  <td>
	                    <a href="index.php?action=listan3&idnd='.$item["n2_id"].'">detalle</a>
	                  </td>
	                </tr>';
	            
		}
	}
}

?>