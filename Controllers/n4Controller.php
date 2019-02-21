<?php
class NcuaController{


	public function vistancuaController(){
		if (isset($_GET["idnt"])) {
			$datosController = $_GET["idnt"];
		}else{
			$datosController = 1;

		}
		//$datosController = $_GET["idnt"];
		$respuesta =Datosncua::vistancuaModel($datosController,"ca_nivel4");

		foreach($respuesta as $row => $item){
			echo '  <tr>
	                  <td>'.$item["n4_id"].'</td>
	                 
	                  <td>
	                    <a href="index.php?action=edita4&id='.$item["n4_id"].'">'.$item["n4_nombre"].'</a>
	                  </td>
	                  <td>
	                    <a href="index.php?action=listan5&idncu='.$item["n4_id"].'">detalle</a>
	                  </td>
	                </tr>';
	            
		}
	}

	public function asignavar(){
		//$datosController = $_GET["idnt"];
		if (isset($_GET["idnt"])) {
			$datosController = $_GET["idnt"];
			$reg=Datosntres::vistaN3opcionModel($datosController, "ca_nivel3");
			$id3=$reg["n3_idn2"];
			$reg=Datosndos::vistaN2opcionModel($id3,"ca_nivel2");
			$id2=$reg["n2_idn1"];
		}else{
			$datosController = 1;

		}
		echo '<li><a href="index.php?action=listan2&iduno='.$id2.'"><em class="fa fa-dashboard"></em> Nivel 2</a></li>';
			echo '<li><a href="index.php?action=listan3&idnd='.$id3.'"><em class="fa fa-dashboard"></em> Nivel 3</a></li>';
		
	}
}

?>