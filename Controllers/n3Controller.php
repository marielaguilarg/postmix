<?php
class NtresController{


	public function vistantresController(){
		if (isset($_GET["idnd"])) {
			$datosController = $_GET["idnd"];
		}else{
			$datosController = 1;

		}

		$respuesta =Datosntres::vistantresModel($datosController,"ca_nivel3");

		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["n3_id"].'</td>
	                 
	                  <td>
	                    <a href="index.php?action=editan3&idnt='.$item["n3_id"].'">'.$item["n3_nombre"].'</a>
	                  </td>
	                  <td>
	                    <a href="index.php?action=listan4&idnt='.$item["n3_id"].'">detalle</a>
	                  </td>
	                </tr>';
	            
		}
	}

	public function asignavar(){
		
		//busco el idn2
		
		if (isset($_GET["idnd"])) {
			$datosController = $_GET["idnd"];
			$reg=Datosndos::vistaN2opcionModel($datosController,"ca_nivel2");
			$id2=$reg["n2_idn1"];
			echo '<li><a href="index.php?action=listan2&idnuno='.$id2.'"><em class="fa fa-dashboard"></em> Nivel 2</a></li>';
		} else
			echo '<li><a href="index.php?action=listan2&idnuno=1"><em class="fa fa-dashboard"></em> Nivel 2</a></li>';
	}
}	

?>