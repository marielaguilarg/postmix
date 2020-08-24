<?php


class EstructuraController {
	
	public $titulo;
	public $titulo1;
	public $titulo2;
	public $listacliente;
	
	public $resultado;
	
	public function vistaNuevo(){
		include "Utilerias/leevar.php";
		
		$this->titulo1= Estructura::nombreNivel($niv, 1);
		if($admin=="insertar"){
			$this->insertar();
			
		}else if($admin=="edi"){
			$this->actualizar();
		}else{
		//	$this->titulo1=Estructura::getDescripcionNivel($niv, "cnfg_estructura");
			switch($niv){
				
				case "1":
					
					//busco clientes
					$sql_cli="SELECT
`ca_clientes`.`cli_idcliente`,
`ca_clientes`.`cli_nombrecliente`
FROM `muestreo`.`ca_clientes`;";
					$op="";
					
					$RS_SQM_TE = Datos::vistaClientesModel("ca_clientes");
					foreach ($RS_SQM_TE as $registro) {
						
						$op.= "<option value='" . $registro [0] . "'>" . $registro [1] . "</option>";
					}
					$this->listacliente='<label>CLIENTE</label>
					 <div class="form-group col-md-6"><select class="form-control" name="cliente">
					'.$op.'</select></div>';
					break;
				case "2":
					$this->titulo=Datosnuno::nombreNivel1($ref, "ca_nivel1");
					
					
					break;
				case "3":
					$this->titulo=Datosndos::nombreNivel2($ref, "ca_nivel2");
					
					break;
				case "4":
					$this->titulo=Datosntres::nombreNivel3($ref, "ca_nivel3");
						break;
				case "5":
					
					$this->titulo=Datosncua::nombreNivel4($ref, "ca_nivel4");
					
					break;
				case "6":
					$this->titulo=Datosncin::nombreNivel5($ref, "ca_nivel5");
					
					break;
			}
			$arr_nomids=array("","idnuno","idnd","idnt","idncu","idnci");
			
			$this->regresar="index.php?action=listan".$niv."&".$arr_nomids[$niv-1]."=".$ref;
			if(isset($id)&&$id!="") //es edicion
			{	$this->titulo2="EDITAR";
			$this->action="index.php?action=nuevonivel&admin=edi&niv=".$niv;
			$this->vistaEditar();
			}
			else {
				$this->titulo2="NUEVA";
				$this->action="index.php?action=nuevonivel&admin=insertar&niv=".$niv;
			}
		}
	}
	
	public function vistaEditar(){
		include "Utilerias/leevar.php";
		$this->titulo1= Estructura::nombreNivel($niv, 1);
		switch($niv){
			
			case "1":
				//busco clientes
				$sql_cli="SELECT
`ca_clientes`.`cli_idcliente`,
`ca_clientes`.`cli_nombrecliente`
FROM `muestreo`.`ca_clientes`;";
				$op="";
				
				$RS_SQM_TE = Datos::vistaClientesModel("ca_clientes");
				
				
				$resultado=Datosnuno::vistaN1opcionModel($id, "ca_nivel1");
				foreach ($RS_SQM_TE as $registro) {
					if($registro [0]==$resultado["n1_idcliente"])
						$op.= "<option value='" . $registro [0] . "' selected='selected'>" . $registro [1] . "</option>";
					else
						$op.= "<option value='" . $registro [0] . "' >" . $registro [1] . "</option>";
				}
				$this->listacliente='<label>CLIENTE</label>
					 <div class="form-group col-md-6"><select class="form-control" name="cliente">
					'.$op.'</select></div>';
				break;
			case "2":
					
				
				$resultado=Datosndos::vistaN2opcionModel($id, "ca_nivel2");
				$this->titulo=Datosnuno::nombreNivel1($resultado["n2_idn1"], "ca_nivel1");
				
				
				break;
			case "3":
				$resultado=Datosntres::vistaN3opcionModel($id, "ca_nivel3");
				$this->titulo=Datosndos::nombreNivel2($resultado["n3_idn2"], "ca_nivel2");
				
				
				break;
			case "4":
				$resultado=Datosncua::vistaN4opcionModel($id, "ca_nivel4");
				$this->titulo=Datosntres::nombreNivel3($resultado["n4_idn3"], "ca_nivel3");
				
				break;
			case "5":
				$resultado=Datosncin::vistancinOpcionModel($id, "ca_nivel5");
				
				$this->titulo=Datosncua::nombreNivel4($resultado["n5_idn4"], "ca_nivel4");
				
				break;
			case "6":
				$resultado=Datosnsei::vistanseiOpcionModel($id, "ca_nivel6");
				$this->titulo=Datosncin::nombreNivel5($resultado["n6_idn5"], "ca_nivel5");
				
				break;
		}
		$ref="n".$niv."_idn".($niv-1);
		$this->resultado=array("descripcion"=>$resultado["n".$niv."_nombre"],"referencia"=>$resultado[$ref],"id"=>$resultado["n".$niv."_id"]);
		$arr_nomids=array("","idnuno","idnd","idnt","idncu","idnci");
		
		$this->regresar="index.php?action=listan".$niv."&".$arr_nomids[$niv-1]."=".$resultado[$ref];
		
	}
	
	
// 	$dataCa_nivel3 = new Datosntres();
	
	
	
// 	$postData['n3_idn2'] = intval($_POST['n3_idn2']);
// 	$postData['n3_id'] = intval($_POST['n3_id']);
// 	$postData['n3_nombre'] = $_POST['n3_nombre'];
	
	
// 	$fieldsNames= array('n3_idn2','n3_id','n3_nombre');
	
// 	$orderBy='';
// 	if(in_array($_GET['orderBy'], $fieldsNames)){
// 		$orderBy = $_GET['orderBy'];
// 	}
	
// 	$order='asc';
// 	if($_GET['order']){
// 		$order = $_GET['order'];
// 	}
	
// 	$task = addslashes($_GET['task']);
// 	if($task == 'edit' && $_POST){
// 		$n3_id = intval($_POST['n3_id']);
// 	}
// 	else{
// 		$n3_id = intval($_GET['n3_id']);
// 	}
	
// 	$HTMLCa_nivel3->menu();
	
// 	switch ($task) {
		
		
// 		//-----------------------------------------------------------------------------------------
// 		// Edit
// 		//-----------------------------------------------------------------------------------------
// 		case 'edit':
// 			// get calendar date for this training
// 			// Get training infos
// 			if($_POST){
// 				$dataCa_nivel3->update($postData);
// 			}
			
// 			$dataCa_nivel3->get($n3_id);
// 			$HTMLCa_nivel3->form($dataCa_nivel3->element);
			
// 			break;
			
// 			//-----------------------------------------------------------------------------------------
// 			// Add
// 			//-----------------------------------------------------------------------------------------
// 		case 'add':
// 			if($_POST){
// 				if($dataCa_nivel3->add($postData)){
// 					echo 'Done!';
// 				}
// 				else{
// 					echo 'Error!';
// 				}
// 			}
// 			else{
// 				$HTMLCa_nivel3->form($dataCa_nivel3->element);
// 			}
			
// 			break;
			
			
// 			//-----------------------------------------------------------------------------------------
// 			// Delete
// 			//-----------------------------------------------------------------------------------------
// 		case 'del':
// 			if($n3_id){
// 				if($dataCa_nivel3->del($n3_id)){
// 					echo 'Done!';
// 				}
// 				else{
// 					echo 'Error!';
// 				}
// 			}
// 			else{
// 				echo 'Error!';
// 			}
			
			
// 			//-----------------------------------------------------------------------------------------
// 			// List
// 			//-----------------------------------------------------------------------------------------
// 		default:
			
			public function insertar(){
				include "Utilerias/leevar.php";
				try{
				switch($niv){
					
					case "1":
						
						$resultado=Datosnuno::insertar($nombre, $cliente, $tabla);
						$this->regresar="index.php?action=listan1";
						break;
					case "2":
						$data['n2_idn1']=$referencia;
						$data['n2_nombre']=$nombre;
						$resultado=Datosndos::add($data, "ca_nivel2");
						$this->regresar="index.php?action=listan2&idnuno=".$referencia;
						break;
					case "3":
						
						$resultado=Datosntres::add($referencia,$nombre, "ca_nivel3");
						$this->regresar="index.php?action=listan3&idnd=".$referencia;
						break;
					case "4":
						
						$resultado=Datosncua::add($referencia,$nombre, "ca_nivel4");
						$this->regresar="index.php?action=listan4&idnt=".$referencia;
						break;
					case "5":
						
						$resultado=Datosncin::add($referencia,$nombre,"ca_nivel5");
						$this->regresar="index.php?action=listan5&idncu=".$referencia;
						break;
					case "6":
						
						$resultado=Datosnsei::add($referencia,$nombre, "ca_nivel6");
						$this->regresar="index.php?action=listan6&idnci=".$referencia;
						break;
				}
				
 				echo "
             <script type='text/javascript'>
               window.location='$this->regresar'
                 </script>
                   ";
			}catch(Exception $ex){
				echo Utilerias::mensajeError($ex->getMessage());
			}
			}
			
			
			public function actualizar(){
				include "Utilerias/leevar.php";
				try{
					switch($niv){
						
						case "1":
							$data['n1_idcliente']=$cliente;
							$data['n1_nombre']=$nombre;
							$data["n1_id"]=$id;
							$resultado=Datosnuno::update($data, "ca_nivel1");
							$this->regresar="index.php?action=listan1";
							break;
						case "2":
							$data['n2_idn1']=$referencia;
							$data['n2_nombre']=$nombre;
							$data["n2_id"]=$id;
							$resultado=Datosndos::update($data, "ca_nivel2");
							$this->regresar="index.php?action=listan2&idnuno=".$referencia;
							break;
						case "3":
							
							$resultado=Datosntres::update($id,$referencia,$nombre, "ca_nivel3");
							$this->regresar="index.php?action=listan3&idnd=".$referencia;
							break;
						case "4":
							
							$resultado=Datosncua::update($referencia,$nombre,$id, "ca_nivel4");
							$this->regresar="index.php?action=listan4&idnt=".$referencia;
							break;
						case "5":
							
							$resultado=Datosncin::update($referencia,$nombre,$id,"ca_nivel5");
							$this->regresar="index.php?action=listan5&idncu=".$referencia;
							break;
						case "6":
							
							$resultado=Datosnsei::update($referencia,$nombre,$id ,"ca_nivel6");
							$this->regresar="index.php?action=listan6&idnci=".$referencia;
						
							break;
					}
					if($resultado)
					echo "
             <script type='text/javascript'>
               window.location='$this->regresar'
                 </script>
                   ";
					else {
						echo Utilerias::mensajeError("No se pudo editar");
					}
				}catch(Exception $ex){
					echo Utilerias::mensajeError($ex->getMessage());
				}
			}
			
			public function eli(){
				include "Utilerias/leevar.php";
				try{
					$ref="n".$niv."_idn".($niv-1);
					switch($niv){
						
						case "1":
						
							$resultado=Datosnuno::del( $id, "ca_nivel1");
							$this->regresar="index.php?action=listan1";
							break;
						case "2":
							$resultado=Datosndos::vistaN2opcionModel($id, "ca_nivel2");
							$referencia=$resultado[$ref];
							$resultado=Datosndos::del($id, "ca_nivel2");
							$this->regresar="index.php?action=listan2&idnuno=".$referencia;
							break;
						case "3":
							$resultado=Datosntres::vistaN3opcionModel($id, "ca_nivel3");
							$referencia=$resultado[$ref];
							$resultado=Datosntres::del($id, "ca_nivel3");
							$this->regresar="index.php?action=listan3&idnd=".$referencia;
							break;
						case "4":
							$resultado=Datosncua::vistaN4opcionModel($id, "ca_nivel4");
							$referencia=$resultado[$ref];
							$resultado=Datosncua::del($id, "ca_nivel4");
							$this->regresar="index.php?action=listan4&idnt=".$referencia;
							break;
						case "5":
							$resultado=Datosncin::vistancinopcionModel($id, "ca_nivel5");
							$referencia=$resultado[$ref];
							$resultado=Datosncin::del($id,"ca_nivel5");
							$this->regresar="index.php?action=listan5&idncu=".$referencia;
							break;
						case "6":
							$resultado=Datosnsei::vistanseiOpcionModel($id, "ca_nivel6");
							$referencia=$resultado[$ref];
							$resultado=Datosnsei::del($id,"ca_nivel6");
							$this->regresar="index.php?action=listan6&idnci=".$referencia;
							break;
					}
					
					echo "
             <script type='text/javascript'>
               window.location='$this->regresar'
                 </script>
                   ";
				}catch(Exception $ex){
					echo Utilerias::mensajeError($ex->getMessage());
				}
			}
}

