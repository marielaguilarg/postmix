<?php



class CatalogosController {
	public $titulo;
	public $action;
	public $titulo2;
	public $lista;
	public $op;
	public $resultado;
	public $nombrecat;
	public $serviciosinspector;
	
	public function vistaNuevo(){
		include "Utilerias/leevar.php";
		
			
		if($admin=="insertar"){
			$this->insertarOpcion();
			
		}else if($admin=="edi"){
			$this->actualizarOpcion();
		}else{
		switch($op){
		
			case "cc":
				$archivo="catalogo";
				$this->titulo="CATALOGO";
				
				break;
			case "cat":
				$archivo="catalogo";
				$this->titulo="OPCION";
				
				break;
			case "ins":
				$archivo="inspector";
				$this->titulo="INSPECTORES";
				//busco los servicios
				$this->serviciosinspector=DatosServicio::vistaServiciosModel("ca_servicios");
				
				break;
			case "vol":
				$archivo="volumen";
				$this->titulo="VOLUMEN DE CO2";
				break;
			case "mes":
				$archivo="mesasig";
				$this->titulo="MES ASIGNACION";
				break;
			case "tm":
				$archivo="TipoMercado";
				$this->titulo="TIPO DE MERCADO";
				break;
		}
		if(isset($id)&&$id!="") //es edicion
		{	$this->titulo2="EDITAR";
		$this->action="index.php?action=nuevocatalogo&admin=edi&op=".$op;
		$this->vistaEditar();
		}
		else {
			$this->titulo2="NUEVO";
			$this->action="index.php?action=nuevocatalogo&admin=insertar&op=".$op;
		}
		}
		
	}
	
	public function insertarOpcion(){
		
	include "Utilerias/leevar.php";
	try{
		$regresar="index.php?action=listacatalogosgen&op=".$op;
		switch($op){
			case "cc":
				
				DatosCatalogo::insertarCatalogo($nomcat, "ca_catalogos");
				$regresar="index.php?action=listacatalogos";
				
				break;
			case "cat":
				DatosCatalogoDetalle::insertarCatalogoDetalle($clavecat, $nomopesp, $nomoping, $nomotro);
				$regresar="index.php?action=listacatalogosgen&op=cat&cat=".$clavecat;
				break;
			case "ins":
				//armo cadena de servicios
				$cadservicios="";
				
				
				$servicios=DatosServicio::vistaServiciosModel("ca_servicios");
				foreach($servicios as $servicio){
					$var="servicio_".$servicio["ser_id"];
					
					if(isset($$var)){
						$cadservicios.=$servicio["ser_id"].",";
					
					}
				}
					if($cadservicios!=""){ //quito ultima coma
						$cadservicios=substr($cadservicios, 0,strrpos($cadservicios,","));
					}
				
				
			DatosInspector::insertarInspector($nomins,$cadservicios, $usuario,"ca_inspectores");
				break;
			case "vol":
				DatosCatalogoDetalle::insertarVolumen($clapresion, $clatemp, $volco, "ca_volumenes");
				$regresar="index.php?action=listacatalogosgen2&op=".$op;
				break;
			case "mes":
				DatosMesasignacion::insertarMesAsignacion($clames, $claper, "ca_mesasignacion");
				$regresar="index.php?action=listamesas&op=".$op;
				break;
			case "tm":
			DatosCatalogoDetalle::insertarTipoMercado($cvetm, $nomtm, "ca_tipomercado");
				break;
		}
		
		
		echo "
            <script type='text/javascript'>
              window.location='$regresar'
                </script>
                  ";
	}catch(Exception $ex){
		echo Utilerias::mensajeError($ex->getMessage());
	}
		
	}
	
	public function eliminarOpcion($op,$id){
		
		
		try{
			$regresar="index.php?action=listacatalogosgen&op=".$op;
			switch($op){
				case "cc":
					
					
					DatosCatalogo::borrarCatalogo($id, "ca_catalogosdetalle");
					$regresar="index.php?action=listacatalogos";
					break;
				case "cat":
					$cad=explode(".", $id);
				
					DatosCatalogoDetalle::borrarCatalogoDetalle($cad[0], $cad[1], "ca_catalogosdetalle");
					
					break;
				case "ins":
					
					DatosInspector::eliminarInspector($id, "ca_inspectores");
					
					break;
					
				case "vol":
					$cad=explode(".", $id);
					Conexion::ejecutarInsert("DELETE
FROM `ca_volumenes`
WHERE `cav_presion` = :cav_presion
    AND `cav_temperatura` = :cav_temperatura;", array("cav_presion"=>$cad[0],"cav_temperatura"=>$cad[1]));
					$regresar="index.php?action=listacatalogosgen2&op=".$op;
					break;
				case "mes":
					
					DatosMesasignacion::borrarMesAsignacion($id, "ca_mesasignacion");
					$regresar="index.php?action=listamesas&op=".$op;
					break;
				case "tm":
					DatosCatalogoDetalle::borrarTipoMercado($id, "ca_tipomercado");
					break;
			}
			echo Utilerias::enviarPagina($regresar);
			
		}catch(Exception $ex){
			echo Utilerias::mensajeError($ex->getMessage());
		}
		}
		public function vistaEditar(){
		
		include "Utilerias/leevar.php";
		
		switch($op){
			case "cc":
				
				
				$this->resultado=DatosCatalogo::getCatalogo($id,"ca_catalogos");
				
				break;
			case "cat":
				$cad=explode(".", $id);
				
				$this->resultado=DatosCatalogoDetalle::listaCatalogoDetalleOpc($cad[0],$cad[1],"ca_catalogosdetalle");
				
				break;
			case "ins":
				
				$this->resultado=DatosInspector::getInspectorxId($id);
				//lleno los servicios
				$this->serviciosinspector=DatosServicio::vistaServiciosModel("ca_servicios");
				
				$serviciosseleccionados=explode(",", $this->resultado["ins_servicios"]);
				
				if(sizeof($serviciosseleccionados)>0){
					//si hay servicios
					foreach($this->serviciosinspector as $clave=>$servicio){
						
						if(in_array("".$servicio["ser_id"], $serviciosseleccionados)){
							
							$servicio["checked"]="checked='checked'";
						}
						else{
							$servicio["checked"]="";
						}
						$this->serviciosinspector[$clave]=$servicio;
						
					}
				}
				
				break;
			case "vol":
				$cad=explode(".", $id);
				$res=Conexion::ejecutarQuery("SELECT
  `cav_presion`,
  `cav_temperatura`,
  `cav_volumen`
FROM `ca_volumenes` where cav_presion=:cav_presion and cav_temperatura=:cav_temperatura", array("cav_presion"=>$cad[0],"cav_temperatura"=>$cad[1]));
				$this->resultado=$res[0];
				$regresar="index.php?action=listacatalogosgen2&op=".$op;
				break;
			case "mes":
				$cad=explode(".", $id);
				$this->resultado=array("num_mes_asig"=>$cad[0],"num_per_asig"=>$cad[1]);
				$regresar="index.php?action=listamesas&op=".$op;
				break;
			case "tm":
				
				$this->resultado=DatosCatalogoDetalle::getTipoMercado($id,"ca_tipomercado");
				break;
		
		}
		
	}
	
	public function actualizarOpcion(){
		
		include "Utilerias/leevar.php";
		$regresar="index.php?action=listacatalogosgen&op=".$op;
		try{
			switch($op){
				case "cc":
				
					DatosCatalogo::actualizarCatalogo($clavecat, $nomcat, "ca_catalogos");
					$regresar="index.php?action=listacatalogos";
						break;
				case "cat":
					if(!isset($nomotro))
						$nomotro=0;
					DatosCatalogoDetalle::actualizarCatalogoDetalle($clavecat, $idopcion, $nomopesp, $nomoping, $nomotro, "ca_catalogosdetalle");
					$regresar="index.php?action=listacatalogosgen&op=".$op."&cat=".$clavecat;
					break;
				case "ins":
					$cadservicios="";
					
					
					$servicios=DatosServicio::vistaServiciosModel("ca_servicios");
					foreach($servicios as $servicio){
						$var="servicio_".$servicio["ser_id"];
						
						if(isset($$var)){
							$cadservicios.=$servicio["ser_id"].",";
							
						}
					}
					if($cadservicios!=""){ //quito ultima coma
						$cadservicios=substr($cadservicios, 0,strrpos($cadservicios,","));
					}
					
					
					DatosInspector::actualizarInspector($claveins, $nomins,$cadservicios,$usuario, "ca_inspectores");
					break;
				case "vol":
					DatosCatalogoDetalle::actualizarVolumen($clapresion.".".$clatemp, $volco, "ca_volumenes");
					$regresar="index.php?action=listacatalogosgen2&op=".$op;
				
					break;
				case "tm":
					DatosCatalogoDetalle::actualizarTipoMercado($cvetm, $nomtm, "ca_tipomercado");
					;
					break;
					
			}
			echo "
            <script type='text/javascript'>
              window.location='$regresar'
                </script>
                  ";
		}catch(Exception $ex){
			echo Utilerias::mensajeError($ex->getMessage());
		}
	}
	
	public function vistaLista(){
		include "Utilerias/leevar.php";
		$this->op=$op;
		if($admin=="eli"){
			$this->eliminarOpcion($op,$id);
		}
		switch($op){
				case "cat":
					$this->titulo="CATALOGOS";
					$res=DatosCatalogo::getCatalogo($cat, "ca_catalogos");
					$this->nombrecat=$res["ca_nombrecatalogo"];
					$sql="SELECT

  `cad_idopcion`,
  `cad_descripcionesp`,
  `cad_descripcioning`,
  `cad_otro`,
cad_idcatalogo
FROM ca_catalogosdetalle where ca_catalogosdetalle.cad_idcatalogo= :id";
					$this->lista=Conexion::ejecutarQuery($sql, array("id"=>$cat));
					
					break;
				case "ins":
					$this->titulo="INSPECTORES";
					$this->lista=DatosInspector::listainspectores("ca_inspectores");
					break;
				case "vol":
					$this->titulo="VOLUMEN DE CO2";
					$this->lista=DatosCatalogoDetalle::listaVolumenes("ca_volumenes");
					break;
				case "mes":
					$this->titulo="MES ASIGNACION";
					$this->lista=Conexion::ejecutarQuerysp("SELECT * from ca_mesasignacion order by num_per_asig, num_mes_asig");
				
					break;
				case "tm":
					$this->titulo="TIPO DE MERCADO";
					$this->lista=Conexion::ejecutarQuerysp("SELECT
  `tm_clavetipo`,
  `tm_nombretipo`
FROM ca_tipomercado");
					break;
			}
			
			
	}
	public function vistaListaCat(){
		include "Utilerias/leevar.php";
		if($admin=="eli"){
			$this->eliminarOpcion("cc",$cat);
		}
				$this->lista=Conexion::ejecutarQuerysp("SELECT
  `ca_idcatalogo`,
  `ca_nombrecatalogo`
FROM `ca_catalogos`");
		
		
	}
	
}

