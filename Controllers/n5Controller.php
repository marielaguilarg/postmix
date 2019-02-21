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
			$reg=Datosncua::vistaN4opcionModel($datosController, "ca_nivel4");
			$id4=$reg["n4_idn3"];
			$reg=Datosntres::vistaN3opcionModel($id4, "ca_nivel3");
			$id3=$reg["n3_idn2"];
			$reg=Datosndos::vistaN2opcionModel($id3,"ca_nivel2");
			$id2=$reg["n2_idn1"];
		} else {
			$datosController =6;
		}

		//$datosController = $_GET["idncu"];

		echo '<li><a href="index.php?action=listan2&idnuno='.$id2.'"><em class="fa fa-dashboard"></em> Nivel 2</a></li>';
		echo '<li><a href="index.php?action=listan3&idnd='.$id3.'"><em class="fa fa-dashboard"></em> Nivel 3</a></li>';

		echo '<li><a href="index.php?action=listan4&idnt='.$id4.'"><em class="fa fa-dashboard"></em> Nivel 4</a></li>';
		
	}
}

?>