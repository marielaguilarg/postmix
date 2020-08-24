<?php
class NtresController{


	public function vistantresController(){
		
		if($_GET["admin"]=="eli"){
			$ec=new EstructuraController();
			$ec->eli();
		}else{
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
	                    <a href="index.php?action=nuevonivel&niv=3&id='.$item["n3_id"].'">'.$item["n3_nombre"].'</a>
	                  </td>
	                  <td>
	                    <a href="index.php?action=listan4&idnt='.$item["n3_id"].'">detalle</a>
	                  </td>
<td> <a type="button" href="index.php?action=listan3&admin=eli&niv=3&id='.$item["n3_id"].'" onclick="return dialogoEliminar();"><i class="fa fa-times"></i></a>
		                </td>
	                </tr>';
	            
		}
		}
	}

	public function asignavar(){
		
		//busco el idn2
		
		if (isset($_GET["idnd"])) {
			$datosController = $_GET["idnd"];
			$reg=Datosndos::vistaN2opcionModel($datosController,"ca_nivel2");
			$id2=$reg["n2_idn1"];
			echo '<li><a href="index.php?action=listan2&idnuno='.$id2.'"> NIVEL 2</a></li>';
		} else
				
			echo '<li><a href="index.php?action=listan1"><em class="fa fa-dashboard"></em>NIVEL 1</a></li>';
			}
}	

?>