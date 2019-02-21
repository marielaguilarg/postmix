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
			$reg=Datosncin::vistancinOpcionModel($datosController, "ca_nivel5");
			$id5=$reg["n5_idn4"];
			$reg=Datosncua::vistaN4opcionModel($id5, "ca_nivel4");
			$id4=$reg["n4_idn3"];
			$reg=Datosntres::vistaN3opcionModel($id4, "ca_nivel3");
			$id3=$reg["n3_idn2"];
			$reg=Datosndos::vistaN2opcionModel($id3,"ca_nivel2");
			$id2=$reg["n2_idn1"];
		} else {
			$datosController =1;
		}

		//$datosController = $_GET["idncu"];

		echo '<li><a href="index.php?action=listan2&idnuno='.$id2.'"><em class="fa fa-dashboard"></em> Nivel 2</a></li>';
		echo '<li><a href="index.php?action=listan3&idnd='.$id3.'"><em class="fa fa-dashboard"></em> Nivel 3</a></li>';

		echo '<li><a href="index.php?action=listan4&idnt='.$id4.'"><em class="fa fa-dashboard"></em> Nivel 4</a></li>';

		echo '<li><a href="index.php?action=listan5&idncu='.$id5.'"><em class="fa fa-dashboard"></em> Nivel 5</a></li>';
		
	}


}

?>