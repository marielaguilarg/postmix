<?php
//include('Utilerias/inimultilenguaje.php');
class consultaResController {
	private $liga_esp;
	private $liga_ing;
	private $titulo;
	private $ins;
	private $OPCLIENTES, $OPSERVICIOS;
	private $listanivel1;
	private $listanivel2;
	private $listanivel3;
	private $listanivel4;
	private $listanivel5;
	private $listanivel6;
	private $nombrenivel1;
	private $nombrenivel2;
	private $nombrenivel3;
	private $nombrenivel4;
	private $nombrenivel5;
	private $nombrenivel6;
    private $listaFranquicias;
	private $listaCuentas;

	private $meses_opt;
	private $lb_Servicio;
	private $lb_Cliente;
	private $lb_Tipo_Mercado;
	private $OPMERCADO;
	private $lb_Cuenta;
	
	private $lb_Franquicia, $lb_Punto_Venta,$OPUNEGOCIO;
 private $varnivel;
 private $avanzada;
	
	
 	public function vistaConsultaRes(){
 		include 'Utilerias/leevar.php';
		
		//-----------------------------------------
		//inicializacion de etiquetas para traduccion
		//-----------------------------------------
		
		$ref="index.php?action=consultaResultados";
		
		$this->liga_esp=$ref."&lan=es";
		$this->liga_ing=$ref."&lan=en";
		
	
		
		$this->titulo=T_("CONSULTAS")."/".T_("RESULTADOS");
		$this->ins=strtoupper(T_("Estimado usuario, para consultar los resultados defina los siguientes criterios"));
		$this->lb_Tipo_Mercado=strtoupper(T_("Tipo de Mercado"));
		$this->lb_Franquicia=T_("FRANQUICIA POR CUENTA");
		$this->lb_Punto_Venta=strtoupper(T_("Punto de Venta"));
		$this->lb_Periodo=strtoupper(T_("Periodo"));
		$this->lb_Cuenta=strtoupper(T_("Cuenta"));
		$this->lb_Indice_de=strtoupper(T_("Indice de"));
		$this->lb_al_Indice_de=strtoupper(T_("al Indice de"));
		$this->lb_BusquedaAvanzada=strtoupper(T_("BUSQUEDA AVANZADA"));
		
		$arr_meses=array(strtoupper(T_("Enero")),strtoupper(T_("Febrero")),strtoupper(T_("Marzo")),strtoupper(T_("Abril")),strtoupper(T_("Mayo")),strtoupper(T_("Junio")),strtoupper(T_("Julio")),strtoupper(T_("Agosto")),strtoupper(T_("Septiembre")),strtoupper(T_("Octubre")),strtoupper(T_("Noviembre")),strtoupper(T_("Diciembre")));
		if ($_GET ['bandera'] == 1) {
			$sql_drop2 = "DROP table tempgeneral";
			$rs_sql_drop2 = Conexion::ejecutarQuerysp($sql_drop);
		}
		
		/*         * ************************************** */
		$usuario = $_SESSION ["NombreUsuario"];
		/*         * ************************************** */
		if(!isset($_SESSION["UsuarioInd"]))
			$_SESSION["UsuarioInd"]=$usuario;
		$_SESSION["clienteind"]=1;
		//reinicio variables de session
		$_SESSION["fperiodo"] = "";
		$_SESSION["fcuenta"] = "";
		
		$_SESSION["fnumrep"]="";
		
		$_SESSION["fpuntov"]="";
		$filtros = array('unidadneg', "franquicia", "region", "zona", "cedis");
		foreach ($filtros as $filtro) {
			if (isset($_SESSION["f".$filtro]))
				$_SESSION["f".$filtro]="";
		}
		
		
		//echo $MiVar;
		
		
		/*         * ****** SECCION DONDE SE GENERAN LOS FILTROS A UTILIZAR *********** */
	
		
		$res = UsuarioModel::getUsuario($usuario,"cnfg_usuarios");
		foreach ($res as $row_usuarios) {
			$GradoNivel = $row_usuarios ["cus_tipoconsulta"];
			$grupo = $row_usuarios ["cus_clavegrupo"];
			$Nivel01 = $row_usuarios ["cus_nivel1"];
			$Nivel02 = $row_usuarios ["cus_nivel2"];
			//                    echo "niv".$Nivel02;
			$Nivel03 = $row_usuarios ["cus_nivel3"];
			$Nivel04 = $row_usuarios ["cus_nivel4"];
			$Nivel05 = $row_usuarios ["cus_nivel5"];
			$Nivel06 = $row_usuarios ["cus_nivel6"];
			$uscliente=$row_usuarios ["cus_cliente"];
			$usservicio=$row_usuarios ["cus_servicio"];
		}
		
		$VarNivel2 = $GradoNivel;
		//busco el nivel de consulta y agrupo
		$filniv=$Nivel01.".".$Nivel02.".".$Nivel03.".".$Nivel04.".".$Nivel05.".".$Nivel06;
		
		// muestra select de cliente y servicio
		$bancli=0;
		$banserv=0;
		$bancuenta=0;
		$banfran=0;
		if($grupo=="adm"||$uscliente==0||$uscliente=='')//puede ver todos
		{
		
			$bancli=1;
			$banserv=1;
			$bancuenta=1;
			$banfran=1;
			$rs_cli=DatosCuenta::listaClientesModel("ca_clientes");
			$this->OPCLIENTES=Utilerias::crearSelectOnChange($rs_cli, "crcliente", "cargaContenidoCliente(this.value)");
		}else
		
			
			$this->OPCLIENTES=$this->buscaCliente($uscliente).'<input type="hidden" value="'.$uscliente.'" name="crcliente" id="crcliente">';
			if($usservicio==0||$usservicio=='')// si es cliente y tiene mas de un servicio
			{
				
				$this->lb_Servicio=T_("SERVICIO");
				// llena servicios
				$sql_serv="SELECT
        `ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp`,
ca_servicios.ser_descripcioning FROM `muestreo`.`ca_servicios`
        where `ca_servicios`.`cli_idcliente`='$uscliente';";
				$sql_serv=DatosServicio::vistaServicioxCliente($uscliente, "ca_servicios");
				$this->OPSERVICIOS=Utilerias::crearSelectOnChange($sql_serv,'crservicio','');
				//      echo "fin";
				$banserv=1;
				$bancuenta=1;
				$banfran=1;
			}
			else {   //busco nombre del servicio
				
				$this->OPSERVICIOS=$this->buscaServicio($uscliente, $usservicio, $_SESSION["idiomaus"]).'<input type="hidden" value="'.$usservicio.'" name="crservicio" id="crservicio">';
			}
			
			
		
		
		
		if($grupo=='cli' || $grupo == 'muf') {
			
			
			
			if($usservicio==0||$usservicio=='')// si es cliente y tiene mas de un servicio
			{
				
				// llena servicios
				$sql_serv="SELECT
        `ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp`,ca_servicios.ser_descripcioning  
FROM `muestreo`.`ca_servicios`
        where `ca_servicios`.`cli_idcliente`='$uscliente';";
				$sql_serv=DatosServicio::vistaServicioxCliente($uscliente, "ca_servicios");
				$selServ=Utilerias::crearSelectOnChange($sql_serv,'crservicio','cargaContenidoCliente(this.id,\''.$filniv.'\')');
				$banserv=1;
				$bancuenta=1;
				$banfran=1;
				if($selServ!="-1") {
					
					$this->lb_Servicio=T_("SERVICIO");
					$this->OPSERVICIOS=$selServ.'<input type="hidden" value="'.$uscliente.'" name="crcliente" id="crcliente">';
				}
			}
			else {   //busco nombre del servicio
			
				$this->lb_Servicio=T_("SERVICIO");
				$this->OPSERVICIOS=$this->buscaServicio($uscliente, $usservicio, $_SESSION["idiomaus"]).'  <input type="hidden" value="'.$usservicio.'" name="crservicio" id="crservicio">'.
				'<input type="hidden" value="'.$uscliente.'" name="crcliente" id="crcliente">';
			}
		
		}
		if($grupo=='cue') { //solo creo hiddens con el valor
			
		
			
			$this->lb_Servicio=T_("SERVICIO");
			$this->OPSERVICIOS=$this->buscaServicio($uscliente, $usservicio, $_SESSION["idiomaus"]).'  <input type="hidden" value="'.$usservicio.'" name="crservicio" id="crservicio">'.
			'<input type="hidden" value="'.$uscliente.'" name="crcliente" id="crcliente">';
		}
		
		if($VarNivel2=="")
			$VarNivel2=1;
			$boton_avan = ' <div><a class="nav-link" href="javascript: muestra_oculta(\'contenido_a_mostrar\',\'' . $grupo . '\');" class="button"><span>'.T_("BUSQUEDA AVANZADA").'</span></a></div>';
			  if ($grupo == 'adm' || $grupo == 'mue' || $grupo == 'cli' || $grupo == 'aud' || $grupo == 'muf') {
			  	$this->avanzada= $boton_avan;
			  	if ($grupo == 'cli' && $GradoNivel == 6)
			  		$this->avanzada= "";
        
             
            $this->varnivel = $VarNivel2;
            if ($VarNivel2 == NULL) { $Nivel01 = 1;} else {
                // die($VarNivel2."--".$grupo);
                $Nivel01 = 1;
                
                if ($VarNivel2 == 1) {
                    
                    $rs = Datosndos::vistandosModel($Nivel01, "ca_nivel2");
                    $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                    
                  //  $this->listanivel1=  Utilerias::crearSelectCascada(Estructura::nombreNivel(1,$_SESSION["idiomaus"]),1, Utilerias::crearOpcionesSelCad( $rs, $select1),"");;
                    $this->listanivel2=  Utilerias::crearSelectCascada(Estructura::nombreNivel(2,$_SESSION["idiomaus"]),2, Utilerias::crearOpcionesSelCad( $rs, $select2),"");
                    
                    $this->listanivel3 = Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3, Utilerias::crearOpcionesNivel(3,  $select2,$select3),"disabled");
                    //   die( $this->listanivel3 )  ;
                    $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"disabled");
                    
                    $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                    $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                    if(isset($select2)&&$select2!=0){
                        $this->listanivel3=Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3,Utilerias::crearOpcionesNivel(3,  $select2,$select3),"");
                    }  
                    if(isset($select3)&&$select3!=0){
                        $this->listanivel3=Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3,Utilerias::crearOpcionesNivel(3,  $select2,$select3),"");
                        
                        $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                        
                    }
                    if(isset($select4)&&$select4!=0){
                        $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                        $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                        
                    }
                    if(isset($select5)&&$select5!=0){
                        $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                        $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                        
                    }
                    
                    if(isset($select6)&&$select6!=0){
                        $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                    }
//                 
                }
                if ($VarNivel2 == 2) {
                    
                    $RS_SQM_TE = Datosntres::vistantresModel($Nivel02,"ca_nivel3" );
                    
                    $this->listanivel3 = Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3,  Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select3),"");
                    //   die( $this->listanivel3 )  ;
                    $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"disabled");
                    
                    $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                    $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                    $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                     $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $Nivel02 . "'>";
                     
                    /* * ******************************************************************* */
                     if(isset($select3)){
                         $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                     }
                     if(isset($select4)&&$select4!=0){
                         $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                         $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                         
                     }
                     if(isset($select5)&&$select5!=0){
                         $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                         $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                         
                     }
                     
                     if(isset($select6)&&$select6!=0){
                         $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                     }
                }
                if ($VarNivel2 == 3) {
                    $RS_SQM_TE = Datosncua::vistancuaModel( $Nivel03,"ca_nivel4");
                    $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4, Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select4),"");
                    
                    $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                    $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                    
                    //  $this->listanivel2[] = Utilerias::crearSelect("select3", $RS_SQM_TE, $select2);
                    
                    /* * **************************************************** */
                    //   $this->listanivel4[] = "<select style='width:300px' name='select4' id='select4' >
                    //                                                                  <option value=''>- " . strtoupper(T_("Todos")) . " -</option></select>";
                    $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                    $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $Nivel02 . "'>";
                    $this->listanivel3 = "<input type='hidden' name='clanivel3' id='select3' value='" . $Nivel03 . "'>";
                    if(isset($select4)&&$select4!=0){
                        $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                    }
                    if(isset($select5)&&$select5!=0){
                        $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                        $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                        
                    }
                    
                    if(isset($select6)&&$select6!=0){
                        $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                    }
                }
                
                if ($VarNivel2 == 4) {
                    /* * **NUEVO MODULO PHP** */
                 
                    $RS_SQM_TE = Datosncin::vistancinModel( $Nivel04, "ca_nivel5");
                    $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5, Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select5),"");
                    $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                    
                    //  $this->listanivel2[] = Utilerias::crearSelect("select3", $RS_SQM_TE, $select2);
                    
                    /* * **************************************************** */
                    //   $this->listanivel4[] = "<select style='width:300px' name='select4' id='select4' >
                    //                                                                  <option value=''>- " . strtoupper(T_("Todos")) . " -</option></select>";
                    $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                    $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $Nivel02 . "'>";
                    $this->listanivel3 = "<input type='hidden' name='clanivel3' id='select3' value='" . $Nivel03 . "'>";
                    $this->listanivel4 = "<input type='hidden' name='clanivel4' id='select4' value='" . $Nivel04 . "'>";
                    if(isset($select5)&&$select5!=0){
                        $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                    }
                    if(isset($select6)&&$select6!=0){
                        $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                    }
                }
                
                if ($VarNivel2 == 5) {
                    
                    $RS_SQM_TE = Datosnsei::vistanseiModel( $Nivel05,"ca_nivel6");
                   
                    $this->listanivel6 = Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6, Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select6),"");
                    //$this->listanivel1 = "<input type='hidden' name='select1' id='select1' value='" . $Nivel01 . "'>";
                    
                    $this->listanivel2 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                    $this->listanivel3 = "<input type='hidden' name='clanivel2'  id='select2' value='" . $Nivel02 . "'>";
                    $this->listanivel4 = "<input type='hidden' name='clanivel3' id='select3' value='" . $Nivel03 . "'>";
                    $this->listanivel5 = "<input type='hidden' name='clanivel4' id='select4' value='" . $Nivel04 . "'>";
                    $this->listanivel1 = "<input type='hidden' name='clanivel5' id='select5' value='" . $Nivel05 . "'>";
                    /* * ******************************************************************* */
                    
                  
                }
                if ($VarNivel2 == 6) {
                    /* * **NUEVO MODULO PHP** */
                    
                    $this->listanivel1 = "<input type='hidden' name='clanivel1' value='" . $Nivel01 . "'>";
                    $this->listanivel2= "<input type='hidden' name='clanivel2' value='" . $Nivel02 . "'>";
                    $this->listanivel3= "<input type='hidden' name='clanivel3' value='" . $Nivel03 . "'>";
                    $this->listanivel4 = "<input type='hidden' name='clanivel4' value='" . $Nivel04 . "'>";
                    $this->listanivel5 = "<input type='hidden' name='clanivel5' value='" . $Nivel05 . "'>";
                    $this->listanivel6= "<input type='hidden' name='clanivel6' value='" . $Nivel06 . "'>";
                    /* * ******************************************************************* */
                }
            }
        }
        
			
			/*         * *********************Nuevo Tipo de Consulta************************* */
			
			$sql_TMercado = "SELECT tm_clavetipo, tm_nombretipo FROM ca_tipomercado";
			$rs_sql_TMercado=Conexion::ejecutarQuerysp($sql_TMercado);
		//	$sql_TMercado=Datos
			$this->OPMERCADO="<select class='form-control' name='mercado' id='mercado' onChange='cargaContenidoCuenta(this.id,\"crcliente\",\"crservicio\" )'><option value='0'>- ".strtoupper(T_("TODOS"))." -</option>";
			
			foreach ($rs_sql_TMercado as $row_rs_sql_TMercado) {
				$this->OPMERCADO.= "<option value='" . $row_rs_sql_TMercado ["tm_clavetipo"] . "'>" . $row_rs_sql_TMercado ["tm_nombretipo"] . "</option>";
				
			}
			$this->OPMERCADO.= "</select>";
			
			/*********** para select cuentas *******************/
			
			$sql_cuentas = "SELECT * FROM ca_cuentas";
			
			if ($grupo == "cue") { // si es un usuario por cuenta busca su cuenta
				
				$sql_cuentas .= " where cue_id=:Nivel01  and `ca_cuentas`.`cue_idcliente`=:uscliente;";
				// echo "--".$sql_cuentas;
				// $html->asignar ( 'CUENTAS', "<select name='cuenta' id='cuenta' onChange='cargaContenidoCuenta(this.id)'> <option value='0'>- Seleccione Una Opcion -</option>" );
				
				$parametros = array(
						"Nivel01" => $Nivel01,
						"uscliente" => $uscliente
				);
				$rs_cuentas = Conexion::ejecutarQuery($sql_cuentas, $parametros);
				if (sizeof($rs_cuentas) > 0) {
					
					$this->listaCuentas[] = $row_cuentas["cue_descripcion"] . "<input type='hidden' name='cuenta' id='cuenta' value='" . $row_cuentas["cue_id"] . "'>";
					$bancuenta = 0;
					// $html->expandir ( 'CUENTA', '+buscacuenta' );
				}
			} else {
				
				//if ($banserv == 0) {
					if ($grupo == 'cli' || $grupo == 'muf') {
						
						//
					}
					$referencia=array("",$Nivel01,$Nivel02,$Nivel03,$Nivel04,$Nivel05,$Nivel06);
					$rs_cuentas = DatosCuenta::cuentasxNivel($VarNivel2,$referencia,$uscliente);
					//  die();
					$this->listaCuentas[] = '<select class="form-control"  name="cuenta" id="cuenta" onChange="cargaContenidoCuenta(this.id,\'crcliente\',\'crservicio\');">';
					$i = 0;
				
					
					if (sizeof($rs_cuentas) > 1) // si tiene mas de una cuenta aparece la opcion todas
					{
						
						$this->listaCuentas[] = '<option value="">- ' . strtoupper(T_("Todas")) . ' -</option>';
						
						$bancuenta = 1;
						
						$banfran = 1;
					} else {
						$bancuenta = 0;
					}
					
					// var_dump($rs_cuentas);
					foreach ($rs_cuentas as $row_cuentas) {
						if ($cuenta == $row_cuentas["cue_id"])
							$this->listaCuentas[] = "<option value='" . $row_cuentas["cue_id"] . "' selected>" . $row_cuentas["cue_descripcion"] . "</option>";
							else
								$this->listaCuentas[] = "<option value='" . $row_cuentas["cue_id"] . "'>" . $row_cuentas["cue_descripcion"] . "</option>";
								
								$bancuenta = 1;
					}
					$this->listaCuentas[] = '</select>';
				//} // despliega opciones de cuentas
// 				else { //siempre se muestran las cuentas
// 					// solo creo el select
// 					$this->listaCuentas[] = '<select style="width:300px" name="cuenta" id="cuenta" onChange="cargaContenidoCuenta(this.id,\'crcliente\',\'crservicio\');">';
// 					$this->listaCuentas[] ='<option value="0">- '.strtoupper(T_("Todas")).' -</option></select>';
					
// 					$bancuenta=0;
					
					
					
// 				}
			}
			
			//--------------------------
			// para franquicias
			// -------------------------
			if (isset($cuenta) && $cuenta != 0) {
				$banserv = 0;
				$bancuenta = 0;
			}
			
			// --------------------------
			// para franquicias
			// -------------------------
			
			if ($banserv == 0 && $bancuenta == 0) { // empieza la eleccion desde franquicias
				
				$sql_fran = "SELECT ca_franquiciascuenta.fc_idfranquiciacta, ca_franquiciascuenta.cf_descripcion
FROM
ca_unegocios
Inner Join ca_franquiciascuenta ON ca_unegocios.fc_idfranquiciacta = ca_franquiciascuenta.fc_idfranquiciacta";
				// consulta para clientes
				if ($grupo == 'cli' || $grupo == 'muf') {
					$sql_fran .= " where
ca_franquiciascuenta.cli_idcliente= :uscliente";
					$parametros = array(
							"uscliente"=>$uscliente
					);
					
					$filtro = "";
					// busco por nivel
					switch ($VarNivel2) {
						case 6:
							$filtro = "
ca_unegocios.une_cla_franquicia=:Nivel ";
							$parametros = array(
									"Nivel" => $Nivel06
							);
							break;
						case 5:
							$filtro = "
ca_unegocios.une_cla_ciudad=:Nivel ";
							$parametros = array(
									"Nivel" => $Nivel05
							);
							break;
						case 4:
							$filtro = "
ca_unegocios.une_cla_estado=:Nivel ";
							$parametros = array(
									"Nivel" => $Nivel04
							);
							break;
						case 3:
							$filtro = "
ca_unegocios.une_cla_zona=:Nivel  ";
							$parametros = array(
									"Nivel" => $Nivel03
							);
							break;
						case 2:
							$filtro = "
ca_unegocios.une_cla_pais=:Nivel";
							$parametros = array(
									"Nivel" => $Nivel02
							);
							break;
						case 1:
							$filtro = "ca_unegocios.une_cla_region=:Nivel";
							$parametros = array(
									"Nivel" => $Nivel01
							);
							break;
					}
					if (isset($cuenta) && $cuenta != 0) {
						$filtro .= " and ca_franquiciascuenta.cue_clavecuenta=:cuenta";
						$parametros["cuenta"] = $cuenta;
					}
					$sql_fran .= $filtro . " group by ca_franquiciascuenta.fc_idfranquiciacta;";
					// echo $sql_fran;
					$res_fran = Conexion::ejecutarQuery($sql_fran, $parametros);
					$this->listaFranquicias[] = Utilerias::crearSelectOnChange($res_fran, 'franquiciacta', "");
					$banfran = 1;
				} else if ($grupo == 'cue') { // consulta para cclientes cuenta
					
					// veo si es de franquicia
					if ($Nivel02 != 0 && $Nivel02 != "") {
						
						$this->listaFranquicias[] = $this->buscaFranquicia($Nivel02) . '<input name="franquiciacta" id="franquiciacta" type="hidden" value="' . $Nivel02 . '">';
					}
					else {
						$sql_fran .= " where
ca_franquiciascuenta.cli_idcliente=:uscliente
								
    and ca_franquiciascuenta.cue_clavecuenta=:Nivel01";
						$parametros["uscliente"] = $uscliente;
						$parametros["Nivel01"] = $Nivel01;
						$sql_fran .= " group by ca_franquiciascuenta.fc_idfranquiciacta;";
						$res_fran = Conexion::ejecutarQuery($sql_fran, $parametros);
						$this->listaFranquicias[] =Utilerias::crearSelectOnChange($res_fran, 'franquiciacta', "");
						$banfran = 1;
					}
				} else // todos los demas
				{
					// veo si tiene cliente
					if ($uscliente != 0 && $uscliente != "")
						$sql_fran .= " where
ca_franquiciascuenta.cli_idcliente= '$uscliente'";
						
						if (isset($cuenta) && $cuenta != 0) {
							$sql_fran .= " and ca_franquiciascuenta.cue_clavecuenta='" . $cuenta . "'";
							$parametros["cuenta"] = $cuenta;
						}
						
						$sql_fran .= " group by ca_franquiciascuenta.fc_idfranquiciacta;";
						$RS_SQM_TE = Conexion::ejecutarQuery($sql_fran, $parametros);
						$this->listaFranquicias[] = Utilerias::crearSelectOnChange($RS_SQM_TE, 'franquiciacta', "");
						$banfran = 1;
				}
			} else // select vacio
			{
				$this->listaFranquicias[] = Utilerias::crearSelectOnChange(null, 'franquiciacta', "");
				// var_dump($this->listaFranquicias);
				$banfran = 1;
			}
			
			//----------------------------------
			// para puntos de venta
			//-----------------------------------
			if($banfran==0) {    // empieza seleccion desde u. de negocio
				if ($grupo == 'cue') {
					if ($Nivel03 != null && $Nivel03 != 0) { //si es un usuario por cuenta busca su punto de venta
						
						$rowf=DatosUnegocio::vistaUnegocioDetalle($Nivel03,"ca_unegocios");
						//echo "<br>fan".$slq_franquicia;
						
					    $this->OPUNEGOCIO= $rowf ["une_descripcion"] . "<input type='hidden' name='unidadnegocio' id='unidadnegocio' value='" . $rowf ["une_claveunegocio"] . "'>";
						
					}  else // si es usuario de franquicia
						if ($Nivel02 != null && $Nivel02 != 0) { //si es un usuario por cuenta busca su punto de venta
							$rs_franquicia = DatosUnegocio::unegocioxCuentaFranq($Nivel01, $Nivel02);
							
							$this->OPUNEGOCIO= "<select  class='form-control' name='unidadnegocio' id='unidadnegocio'>";
							//                if(mysql_num_rows($rs_franquicia)>1) {
							$this->OPUNEGOCIO.= "<option value='0'>- ".strtoupper(T_("TODOS"))." -</option>";
						
						
							foreach($rs_franquicia as $rowf) {
								$this->OPUNEGOCIO.= "<option value='" . $rowf ["une_claveunegocio"] . "' >" . $rowf ["une_descripcion"] . "</option>";
								
							}
					}  else {
						
						$slq_franquicia = "SELECT * FROM ca_unegocios 
where ca_unegocios.cue_clavecuenta=" . $Nivel01 . " and" . " ca_unegocios.cli_idcliente='$uscliente' 
and ca_unegocios.ser_claveservicio='$usservicio' order by une_descripcion";
						//echo $slq_franquicia;
						$rs_franquicia = DatosUnegocio::cuentaUnegocioModel($Nivel01,"ca_unegocios" );
						
						$this->OPUNEGOCIO= "<select class='form-control' name='unidadnegocio' id='unidadnegocio'>";
						//                if(mysql_num_rows($rs_franquicia)>1) {
						$this->OPUNEGOCIO.= "<option value='0'>- ".strtoupper(T_("TODOS"))." -</option>";
						
						foreach ($rs_franquicia as $rowf) {
							$this->OPUNEGOCIO.= "<option value='" . $rowf ["une_claveunegocio"] . "' >" . $rowf ["une_descripcion"] . "</option>";
							
						}
						$this->OPUNEGOCIO.="</select>";
					}
				} else {
// 					if ($grupo == 'cli' || $grupo == 'muf') {
// 						$slq_franquicia = "SELECT
// ca_unegocios.une_claveunegocio,
// ca_unegocios.une_descripcion
// FROM
// ca_unegocios
// Inner Join ca_cuentas ON ca_unegocios.cue_clavecuenta = ca_cuentas.cue_clavecuenta AND ca_unegocios.ser_claveservicio = ca_cuentas.ser_claveservicio AND ca_unegocios.cli_idcliente = ca_cuentas.cli_idcliente";
						
// 						switch ($VarNivel2) {
// 							case 6: $filtro = " ca_unegocios.une_cla_region=$Nivel01 and
// ca_unegocios.une_cla_pais=$Nivel02 and
// ca_unegocios.une_cla_zona=$Nivel03 and
// ca_unegocios.une_cla_estado=$Nivel04 and
// ca_unegocios.une_cla_ciudad=$Nivel05 and
// ca_unegocios.une_cla_franquicia=$Nivel06 ";
// 							break;
// 							case 5: $filtro = " ca_unegocios.une_cla_region=$Nivel01 and
// ca_unegocios.une_cla_pais=$Nivel02 and
// ca_unegocios.une_cla_zona=$Nivel03 and
// ca_unegocios.une_cla_estado=$Nivel04 and
// ca_unegocios.une_cla_ciudad=$Nivel05";
// 							break;
// 							case 4: $filtro = " ca_unegocios.une_cla_region=$Nivel01 and
// ca_unegocios.une_cla_pais=$Nivel02 and
// ca_unegocios.une_cla_zona=$Nivel03 and
// ca_unegocios.une_cla_estado=$Nivel04 ";
// 							break;
// 							case 3: $filtro = "ca_unegocios.une_cla_region=$Nivel01 and
// ca_unegocios.une_cla_pais=$Nivel02 and
// ca_unegocios.une_cla_zona=$Nivel03  ";
// 							break;
// 							case 2: $filtro = "ca_unegocios.une_cla_region=$Nivel01 and
// ca_unegocios.une_cla_pais=$Nivel02";
// 							break;
// 							case 1: $filtro = "ca_unegocios.une_cla_region=$Nivel01";
// 							break;
// 						}//fin switch
// 						$slq_franquicia.=" where " . $filtro .  " and ca_unegocios.cli_idcliente='$uscliente'";
// 						// si tiene servicio lo pongo si no todos
// 						if($usservicio!=0&&$usservicio!="")
// 							$slq_franquicia.=" and ca_unegocios.ser_claveservicio='$usservicio';";
							
// 					}
// 					else {
						
// 						// valido si tengo cliente o servicio
// 						if($uscliente==0||$uscliente=="" ) //puedo ver todos
// 							$slq_franquicia = "SELECT * FROM ca_unegocios order by une_descripcion";
// 							else {
// 								if($usservicio!=0&&$usservicio!="") //tengo servicio
// 								{
// 									$slq_franquicia = "SELECT * FROM ca_unegocios where `ca_unegocios`.`cli_idcliente`='$uscliente' and `ca_unegocios`.`ser_claveservicio`='$usservicio' order by une_descripcion";
// 								}else
// 									$slq_franquicia = "SELECT * FROM ca_unegocios where `ca_unegocios`.`cli_idcliente`='$uscliente' order by une_descripcion";
// 							}
							
// 					}
					
// 					$rs_franquicia = mysql_query($slq_franquicia);
// 					$this->UNEGOCIO', "<select style='width:300px' name='unidadnegocio' id='unidadnegocio'>");
// 					if(mysql_num_rows($rs_franquicia)>1) {
// 						$this->OPUNEGOCIO', "<option value='0'>- ".strtoupper(T_("Todos"))." -</option>");
						
// 						$html->expandir('NEGOCIO', '+bucanegocio');
// 					}
// 					else {
// 						$this->OPUNEGOCIO', "<option value='0'>- ".T_("SELECCIONE PUNTO DE VENTA")." -</option>");
						
// 						$html->expandir('NEGOCIO', '+bucanegocio');
// 					}
// 					while ($rowf = @mysql_fetch_array($rs_franquicia)) {
// 						$this->OPUNEGOCIO', "<option value='" . $rowf ["une_claveunegocio"] . "' >" . $rowf ["une_descripcion"] . "</option>");
						
// 						$html->expandir('NEGOCIO', '+bucanegocio');
// 					}
					
					
				}
			}
			else {
				$this->OPUNEGOCIO= "<select class='form-control' name='unidadnegocio' id='unidadnegocio'><option value='0'>- ".strtoupper(T_("TODOS"))." -</option></select>";
				
			}
		
			$opciones_mes="";
			foreach ($arr_meses as $key => $value) {
				$opciones_mes.='<option value="'.($key+1).'">'.$value.'</option>';
			}
			$this->meses_opt=$opciones_mes;
		
		

Navegacion::iniciar();
//Navegacion::borrarRutaActual("a");
//$rutaact = $_SERVER['REQUEST_URI'];
// echo $rutaact;
//Navegacion::agregarRuta("a", $rutaact, T_("RESULTADOS"));
 	}

	
	
	function buscaCliente($idcliente) {
		// busco la descripcion
		$sql_cli="SELECT
`ca_clientes`.`cli_nombrecliente`
FROM `ca_clientes` where cli_idcliente='$idcliente'; ";
		
		$RS = Datos::editarClienteModel($idcliente,"ca_clientes");
		
			
			$des= $RS["cli_nombre"];
		
		
		return $des;
	}
	
	function buscaServicio($cliente,$idservicio,$idioma) {
		
		$sql_serv="SELECT
        `ca_servicios`.`ser_descripcionesp`, `ca_servicios`.`ser_descripcioning` FROM `ca_servicios`
        where `ca_servicios`.`cli_idcliente`='$cliente' and `ser_claveservicio`='$idservicio' ;";
		
		
		
		if($idioma=="")
			$idioma=1;
		$registro = DatosServicio::editarServicioModel($idservicio, "ca_servicios");
		$des= $registro["ser_descripcionesp"];
		if($idioma==2)
			$des= $registro["ser_descripcioning"];
		
	     return $des;
	}
	/**
	 * @return string
	 */
	public function getLiga_esp() {
		return $this->liga_esp;
	}

	/**
	 * @return string
	 */
	public function getLiga_ing() {
		return $this->liga_ing;
	}

	/**
	 * @return string
	 */
	public function getTitulo() {
		return $this->titulo;
	}

	/**
	 * @return string
	 */
	public function getIns() {
		return $this->ins;
	}

	/**
	 * @return string
	 */
	public function getOPCLIENTES() {
		return $this->OPCLIENTES;
	}

	/**
	 * @return string
	 */
	public function getOPSERVICIOS() {
		return $this->OPSERVICIOS;
	}

	/**
	 * @return string
	 */
	public function getListanivel1() {
		return $this->listanivel1;
	}

	/**
	 * @return string
	 */
	public function getListanivel2() {
		return $this->listanivel2;
	}

	/**
	 * @return string
	 */
	public function getListanivel3() {
		return $this->listanivel3;
	}

	/**
	 * @return string
	 */
	public function getListanivel4() {
		return $this->listanivel4;
	}

	/**
	 * @return string
	 */
	public function getListanivel5() {
		return $this->listanivel5;
	}

	/**
	 * @return string
	 */
	public function getListanivel6() {
		return $this->listanivel6;
	}

	/**
	 * @return mixed
	 */
	public function getNombrenivel1() {
		return $this->nombrenivel1;
	}

	/**
	 * @return mixed
	 */
	public function getNombrenivel2() {
		return $this->nombrenivel2;
	}

	/**
	 * @return mixed
	 */
	public function getNombrenivel3() {
		return $this->nombrenivel3;
	}

	/**
	 * @return mixed
	 */
	public function getNombrenivel4() {
		return $this->nombrenivel4;
	}

	/**
	 * @return mixed
	 */
	public function getNombrenivel5() {
		return $this->nombrenivel5;
	}

	/**
	 * @return mixed
	 */
	public function getNombrenivel6() {
		return $this->nombrenivel6;
	}

	/**
	 * @return mixed
	 */
	public function getListaFranquicias() {
		return $this->listaFranquicias;
	}

	/**
	 * @return mixed
	 */
	public function getListaCuentas() {
		return $this->listaCuentas;
	}

	
	/**
	 * @return string
	 */
	public function getMeses_opt() {
		return $this->meses_opt;
	}
	/**
	 * @return string
	 */
	public function getLb_Servicio() {
		return $this->lb_Servicio;
	}

	/**
	 * @return mixed
	 */
	public function getLb_Cliente() {
		return $this->lb_Cliente;
	}

	/**
	 * @return string
	 */
	public function getLb_Tipo_Mercado() {
		return $this->lb_Tipo_Mercado;
	}

	/**
	 * @return string
	 */
	public function getOPMERCADO() {
		return $this->OPMERCADO;
	}

	/**
	 * @return string
	 */
	public function getLb_Cuenta() {
		return $this->lb_Cuenta;
	}

	/**
	 * @return string
	 */
	public function getLb_Franquicia() {
		return $this->lb_Franquicia;
	}

	/**
	 * @return string
	 */
	public function getLb_Punto_Venta() {
		return $this->lb_Punto_Venta;
	}

	/**
	 * @return string
	 */
	public function getOPUNEGOCIO() {
		return $this->OPUNEGOCIO;
	}
	/**
	 * @return number
	 */
	public function getVarnivel() {
		return $this->varnivel;
	}
	/**
	 * @return string
	 */
	public function getAvanzada() {
		return $this->avanzada;
	}




	
	

}

