<?php
class NcinController{


	public function vistancinController(){
		if (isset($_GET["idncu"])){
			$datosController = $_GET["idncu"];
		} else {
			$datosController =1;
		}	
		$respuesta =Datosncin::vistancinModel($datosController,"ca_nivel5");
	
		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["n5_id"].'</td>
	                 
	                  <td>
	                    <a href="index.php?action=editan5&idnci='.$item["n5_id"].'">'.$item["n5_nombre"].'</a>
	                  </td>
	                  <td>
	                    <a href="index.php?action=listan6&idnci='.$item["n5_id"].'">detalle</a>
	                  </td>
	                </tr>';
	            
		}
	}

	public function asignavar(){
		if (isset($_GET["idncu"])){
			$datosController = $_GET["idncu"];
		} else {
			$datosController =6;
		}

		//$datosController = $_GET["idncu"];

		echo '<li><a href="index.php?action=listan2&idnd=1"><em class="fa fa-dashboard"></em> Nivel 2</a></li>';
		echo '<li><a href="index.php?action=listan3&idnt=1"><em class="fa fa-dashboard"></em> Nivel 3</a></li>';

		echo '<li><a href="index.php?action=listan4&idnt='.$datosController.'"><em class="fa fa-dashboard"></em> Nivel 4</a></li>';
		
	}
}

?>