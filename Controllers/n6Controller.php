<?php
class NseisController{


	public function vistanseisController(){
		$datosController = $_GET["idnci"];
		$respuesta =Datosnsei::vistanseiModel($datosController,"ca_nivel6");
	    
		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["n6_id"].'</td>
	                 
	                  <td>
	                    <a href="index.php?action=editan6&idnci='.$item["n6_id"].'">'.$item["n6_nombre"].'</a>
	                  </td>
	                  
	                </tr>';
	            
		}
	}


	public function asignavar(){
		if (isset($_GET["idnci"])){
			$datosController = $_GET["idnci"];
		} else {
			$datosController =1;
		}

		//$datosController = $_GET["idncu"];

		echo '<li><a href="index.php?action=listan2&idnd=1"><em class="fa fa-dashboard"></em> Nivel 2</a></li>';
		echo '<li><a href="index.php?action=listan3&idnt=1"><em class="fa fa-dashboard"></em> Nivel 3</a></li>';

		echo '<li><a href="index.php?action=listan4&idnt=1"><em class="fa fa-dashboard"></em> Nivel 4</a></li>';

		echo '<li><a href="index.php?action=listan5&idnci='.$datosController.'"><em class="fa fa-dashboard"></em> Nivel 5</a></li>';
		
	}


}

?>