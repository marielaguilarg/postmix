<?php

class NuevaSolicitudController{
	private $formulario;
	private $camposOcultos;
	private $camposObligatorios;
	private $unegocio;
	private $mensaje;
	private $listaCuentas;
	private $listaEstados;
	private $enc_autor;

	private $autor_ex;
	public $btnGuardar;
	
	function vistaFormulario(){
		include ('Utilerias/leevar.php');
		// el servico varia	
	
		$cliente=1;
		if($admin=="validadato"){ //buscar el pv y llenar los datos
			
			if($idserv==3)
				$this->buscarPVxIdCuenta($cta);
			if($idserv==5)
				$res=$this->buscarPVxNUD($nud,$cta);
			
			if($res==2||$res==1){
				echo Utilerias::mensajeError($this->mensaje);
				$this->btnGuardar='disabled="disabled"';
			}else
				$nvonum=DatosSolicitud::getUltimaSolicitud($idserv,"cer_solicitud");
			$nvonum++;
			$nsol=$nvonum;
			$this->unegocio['CLAVEUNINEG']=$nvonum;
			$this->unegocio['reporte']= $nvonum;
			$this->unegocio['servicio']= $idserv;
			$this->unegocio['npunto']= $idc;
			// LLENAS LISTA DE CUENTAS
					
		   $this->cargarCuentas($cliente, $cta);
					// while de punto de venta
		
				
			$this->unegocio['IDC']= $idcta;
			
				
		}else
			if ($admin=="ingsol") {
				
				$this->insertarsolicitud();
				$admin="edisol";
			}else
				//ya no van a usarse tiende a desaparecer
// 				if ($admin=="ingcom") {
// 					$this->insertarComentario();
// 					$nsol=$nrepc;
// 					$admin="edisol";
// 				}else
// 					if($admin=="ingarc"){
// 						$this->insertarDetalle();
// 						$nsol=$reporte;
						
// 						$admin="edisol";
// 				}else
					
					if($admin=="autsol"){
						$this->autorizarSolicitud("si");
						$nsol=$reporte;
						$admin="edisol";
				}else
					if($admin=="noautsol"){
						$this->autorizarSolicitud("no");
						$nsol=$reporte;
						$admin="edisol";
				}else
					if($admin=="cancel"){
						$this->autorizarSolicitud("cancelar");
						$nsol=$reporte;
						$admin="edisol";
				}else{
					//formulario nuevo
					$this->cargarCuentas($cliente,'');
					// Llena lista de estados
					$rs=DatosEstado::listaEstadosModel("ca_uneestados");
					$this->listaEstados="";
					foreach($rs as $row){
						$this->listaEstados.="<option value='".$row["est_id"]."'>".$row["est_nombre"]."</option>";
						
						
					}
				}
			if($admin=="edisol")	{
			// busca datos del establecimiento elegido nsol
			
			$rowe=DatosSolicitud::getSolicitud($nsol,$idserv,"cer_solicitud");
			
			$rowp=DatosUnegocio::UnegocioCompletaxnumpunto($rowe["sol_numpunto"],"ca_unegocios");
			$this->unegocio['CLAVEUNINEG']=$nsol;
			$this->unegocio['reporte']= $nsol;
			$this->unegocio['servicio']= $idserv;
			
			$this->unegocio['NUD']= $rowp["une_num_unico_distintivo"];
			$this->unegocio['NOMUNEG']= $rowe["sol_descripcion"];
			$this->unegocio['IDC']= $rowe["sol_idcuenta"];
			$this->unegocio['NPUN']= $rowe["sol_numpunto"];
			$npto=$rowe["sol_numpunto"];
			$idc=$rowe["sol_idcuenta"];
			$date=Utilerias::cambiaf_a_normal($rowe["sol_fechaapertura"]);
			$this->unegocio['FECESTATUS']=$date;
		//		 $this->unegocio['FECESTATUS']= $rowe["sol_fechaapertura"]);
		$this->unegocio['ICON']= $rowe["sol_contacto"];
		$this->unegocio['TELUNEG']= $rowe["sol_dir_telefono"];
		$this->unegocio['TELCEL']= $rowe["sol_dir_telmovil"];
		$this->unegocio['MAIL']= $rowe["sol_correoelec"];
		$this->unegocio['CALLEUNEG']= $rowe["sol_dir_calle"];
		$this->unegocio['NUMEXUNEG']= $rowe["sol_dir_numeroext"];
		$this->unegocio['NUMINUNEG']= $rowe["sol_dir_numeroint"];
		$this->unegocio['MZUNEG']= $rowe["sol_dir_manzana"];
		$this->unegocio['LTUNEG']= $rowe["sol_dir_lote"];
		$this->unegocio['COLUNEG']= $rowe["sol_dir_colonia"];
		$this->unegocio['DELEGUNEG']= $rowe["sol_dir_delegacion"];
		$this->unegocio['MUNUNEG']= $rowe["sol_dir_municipio"];
		$this->unegocio['CPUNEG']= $rowe["sol_dir_cp"];
		$this->unegocio['REFUNEG']= $rowe["sol_dir_referencia"];
		$idedo=$rowe["sol_dir_estado"];
		$estsol=$rowe["sol_estatussolicitud"];
		$cta=$rowe["sol_cuenta"];
		
		// Llena lista de estados
		$rs=DatosEstado::listaEstadosModel("ca_uneestados");
		$this->listaEstados="";
		foreach($rs as $row_es) {
			if($idedo==$row_es["est_id"])
				$this->listaEstados.="<option value='".$row_es["est_id"]."' selected>".$row_es["est_nombre"]."</option>";
				else
					$this->listaEstados.="<option value='".$row_es["est_id"]."' >".$row_es["est_nombre"]."</option>";
					
		}  // while edo
		
		$this->cargarCuentas($cliente, $cta);
	/***************************************
	 * ya no se utilizará sep2019
	 */
// 		if($_SESSION["GrupoUs"]=="adm"||$_SESSION["GrupoUs"]=="cli"||$_SESSION["GrupoUs"]=="muf"){
// 			//  $this->msg=$msg;
// 			// actualiza archivos existentes
// 			$this->subtitulo='
// <div class="row">
// <div class="col-md-12">
// <form  name="bform" action="index.php?action=editasolicitud&admin=ingarc" method="post" enctype="multipart/form-data">
								
// 	 <div class="form-group">
//     <input type="hidden" name="servicio" size="20" maxlength="100" value="'.$idserv.'">
//  	 <input type="hidden" name="reporte" size="20" maxlength="100" value="'.$nsol.'">
//     <input type="hidden" name="MAX_FILE_SIZE" value="600000">
 	 		
 	 		
 	 		
//    <input class="form-control-file"  type="file" name="pictures1[]" id="pictures1" />
// </div> <div class="form-group">
//    <button type="submit" name="submit"  class="btn btn-info pull-right"> Guardar   </button>
 	 		
// </div>
//   </form> </div></div>
//       <div class="row">
//           <div class="col-md-12 table-responsive">
//        <table class="table">
// <tr>
// <th>No.</th><th>NOMBRE</th></tr>';
// 						$rsar=DatosSolicitud::listaSolicitudDetalle($nsol,$idserv,"cer_solicituddetalle");
						
// 						//$band=1;
// 						foreach($rsar as $rowa){
// 							$detalle=array();
// 							$detalle['id_arc_exist']='<tr><td >'.$rowa["sde_idarchivo"].'</td>';
// 							$detalle['arc_exist']="<td >".
// 									"<a href='imprimirReporte.php?admin=descarc&nserv=".$idserv."&nsol=".$nsol."&narc=".
// 									$rowa["sde_idarchivo"] ."'>".$rowa["sde_ruta"]."</a></td></tr>";
// 									$this->listaSolDet[]=$detalle;
// 									// $html->expandir ( 'ARCHIVOS_EX', '+PanelbusquedaA' );
// 						}
// 						$this->listaSolDet[]=array('id_arc_exist'=>"</table></div></div>");
						
// 						// comentarios
						
// 						// encabezado de titulo
// 						$this->enc_comen='
// <div class="row">
// <div class="col-md-12">
//        <div class="form-goup" >
//           <textarea class="form-control" name="coment" cols="120"></textarea>
//           <input type="hidden" name="nrepc" id="nrepc" value= "'.$nsol.'" />
// 		  <input type="hidden" name="nserc" id="nserc" value= "'.$idserv.'"/>
		  		
		  		
// 		<p class="margin">
//          <button name="" type="submit" class="btn btn-info pull-right">Guardar   </button>
		  		
//       </p>
//   </div></div></div>
// <div class="row">
//    <div class="col-md-12 table-responsive">           <table class="table table-sm">
		  		
//   <tr>
//        <th >FECHA</th>
//          <th>HORA</th>
//         <th >USUARIO</th>
//         <th>COMENTARIOS</th>
//       </tr>';
						
						
// 						$rsco=DatosSolicitud::listaSolicitudComentario($nsol,$idserv,"cer_solicitudcomentario");
						
// 						//$msg=$sqlcom;
// 						//$html->asignar('msg',$msg);
// 						//$rsar=mysql_query($sqlar);
// 						foreach($rsco as $rowb){
// 							$comentario=array();
// 							$comentario['fec']='<tr>
//       <td >'.$rowb["sol_fechacom"].'</td>';
// 							$comentario['hor']='<td>'.$rowb["sol_horcom"].'</td>';
// 							$comentario['user']='<td >'.$rowb["sol_user"].'</td>';
// 							$comentario['comen']='<td>'.$rowb["sol_comentario"].'</tr>';
// 							$this->listaComentarios[]=$comentario;
// 						}
// 						$this->listaComentarios[]=array("fec"=>"</table></div></div>");
// 						//                     $html->asignar ( 'fec', '');
// 						//                     $html->asignar ( 'hor', '');
// 						//                     $html->asignar ( 'comen', '');
// 						//                     $html->asignar ( 'user', '');
						
// 					} //if grupo
					
					// autorizacion
		if($_SESSION["GrupoUs"]=="adm"||$_SESSION["GrupoUs"]=="mui"){
						//                     $this->enc_autor='
						//    <table class="table">';
						// AUTORIZACIONES
						//$rsau=DatosInspector::listainspectores("ca_inspectores");
						
						//busca estatus
						switch ($estsol) {
							case 1:
								$nomest ="SOLICITADO";
								break;
							case 2:
								$nomest ="EN PROCESO";
								break;
							case 4:
								$nomest ="NO ACEPTADO";
								break;
							case 5:
								$nomest ="CANCELADO";
								break;
						}
						$autoriza='';
						
						if ($estsol==1 || $estsol==4) {
						//	LISTA DE INSPECTORES
						//	$rsca=DatosInspector::listainspectores("ca_inspectores");
							$rsca=DatosInspector::listaInspectoresxServicio($idserv,"ca_inspectores");
							
							
							$this->listaInspectores="";
							if ($rsca) {
								foreach($rsca as $rowca){
									$this->listaInspectores= $this->listaInspectores."<option value='".$rowca['ins_usuario']."'>".$rowca['ins_nombre']."</option>";
								}
							}
							//$this->listaInspectores="";
							//	foreach($rsau as $rowa){
// 							if($idserv==3)
// 								$this->listaInspectores.= "<option value=\"AUDITOR MUESMERC\">AUDITOR MUESMERC</option>";
								
// 							if($idserv==5)
// 								$this->listaInspectores.= "<option value=\"TECNICO GEPP\">TECNICO GEPP</option>";
							
							$autoriza=$autoriza.'<div class="form-group"><label>AUDITOR :</label>
        <select class="form-control" name="INSPECTOR" id="INSPECTOR">'.$this->listaInspectores.'
         </select>
        		
		 </div>
        		
        		
        <div class="form-group">
		<input type="hidden" name="servicio" size="20" maxlength="100" value='.$idserv.'>
 	    <input type="hidden" name="reporte" size="20" maxlength="100" value='.$nsol.'>
		<input type="hidden" name="cuenta" size="20" maxlength="100" value='.$cta.'>
		<input type="hidden" name="npunto" size="20" maxlength="100" value='.$npto.'>
		<label><h2>'.$nomest.'</h2></label></div>
				
       <div class"col-sm-4">
				
		<button name="PUNVTA" type="submit" class="btn btn-info ">   Aceptar  </button>
				
          <button type="button" name="PUNVTA" id="PUNVTA"  onClick="oCargar(\'index.php?action=editasolicitud&admin=noautsol\');" class="btn btn-info">No aceptar</button>
				
		<button type="button" name="PUNVTA" id="PUNVTA"  onClick="oCargar(\'index.php?action=editasolicitud&admin=cancel\');" class="btn btn-info">Cancelar</button>
    </div>
    ';
						}
						$this->autor_ex=$autoriza;
						
					} // if administrador
					
					Navegacion::iniciar();
					$rutaact = $_SERVER['REQUEST_URI'];
					// echo $rutaact;
					Navegacion::agregarRuta("a", $rutaact, "NO. SOLICITUD ".$nsol);
				} // if edit
				Navegacion::borrarRutaActual("a");
				$rutaact = $_SERVER['REQUEST_URI'];
				// echo $rutaact;
				Navegacion::agregarRuta("a", $rutaact, "NO. SOLICITUD ".$nsol);
				
				//             $html->asignar('arc_exist','');
				//             $html->asignar('id_arc_exist','');
		}
	public function cargarCuentas($cliente,$cta){
		$rsc=DatosCuenta::vistaCuentasxcliente($cliente,"ca_cuentas");
		$this->listaCuentas="";
		
		foreach($rsc as $rowc){
			
			if($cta==$rowc["cue_id"])
				$this->listaCuentas.="<option value='".$rowc["cue_id"]."' selected>".$rowc["cue_descripcion"]."</option>";
				else
					$this->listaCuentas.="<option value='".$rowc["cue_id"]."' >".$rowc["cue_descripcion"]."</option>";
					
		}  // while cuenta
	
	}
	
	public function buscarPVxNUD($nud,$cta){
		$rowp=DatosUnegocio::unegocioxNudCuenta($nud,$cta,"ca_unegocios");
		
		
		if ($rowp){  // ya existe
			//   $rst=mysql_4rowtquery($sqlt);
			
			$npunto=$rowp["une_id"];
				// valida si existe una soicitud con el mismo idcta
				$rs2=DatosSolicitud::getsolicitudxEstatus1($npunto,"cer_solicitud");
				$num_reg2 = sizeof($rs2);
				if ($num_reg2 !=0){  // ya existe
					//mensaje de que y526
					
					$this->mensaje="Ya existe una solicitud abierta para este punto de venta. Por favor, revise')";
					return 1;
				}
				$this->unegocio['NPUN'] =$rowp["une_numpunto"];
				
				$this->unegocio['NUD'] =$rowp["une_num_unico_distintivo"];
				$this->unegocio['NOMUNEG']= $rowp["une_descripcion"];
				$this->unegocio['IDC'] =$rowp["une_idcuenta"];
				$idc=$rowp["une_idcuenta"];
				$this->unegocio['TELUNEG']= $rowp["une_dir_telefono"];
				$this->unegocio['CALLEUNEG'] =$rowp["une_dir_calle"];
				$this->unegocio['NUMEXUNEG']= $rowp["une_dir_numeroext"];
				$this->unegocio['NUMINUNEG'] =$rowp["une_dir_numeroint"];
				$this->unegocio['MZUNEG']= $rowp["une_dir_manzana"];
				$this->unegocio['LTUNEG']= $rowp["une_dir_lote"];
				$this->unegocio['COLUNEG']= $rowp["une_dir_colonia"];
				$this->unegocio['DELEGUNEG']= $rowp["une_dir_delegacion"];
				$this->unegocio['MUNUNEG']=$rowp["une_dir_municipio"];
				$this->unegocio['CPUNEG']= $rowp["une_dir_cp"];
				$this->unegocio['REFUNEG'] =$rowp["une_dir_referencia"];
				$idedo=$rowp["une_dir_idestado"];
				$cta=$rowp["cue_clavecuenta"];
				
				// LLENA DATOS ADICIONALES
				$sqls="SELECT  MAX(cer_solicitud.sol_fechaapertura) AS FECAPER, cer_solicitud.sol_contacto, cer_solicitud.sol_correoelec, cer_solicitud.sol_dir_telefono, cer_solicitud.sol_dir_telmovil
 FROM cer_solicitud WHERE cer_solicitud.sol_idcuenta =:idc GROUP BY cer_solicitud.sol_idcuenta";
				$rss=Conexion::ejecutarQuery($sqls,array("idc"=>$idc));
				foreach($rss as $rows){
					$date=Utilerias::cambiaf_a_normal($rows["FECAPER"]);
					$this->unegocio['FECESTATUS']=$date;
					$this->unegocio['ICON']= $rows["sol_contacto"];
					$this->unegocio['TELUNEG']= $rows["sol_dir_telefono"];
					$this->unegocio['TELCEL']= $rows["sol_dir_telmovil"];
					$this->unegocio['MAIL']= $rows["sol_correoelec"];
				}
				// Llena lista de estados
				$rs=DatosEstado::listaEstadosModel("ca_uneestados");
				$this->listaEstados="";
				foreach($rs as $row_es) {
					if($idedo==$row_es["est_id"])
						$this->listaEstados.="<option value='".$row_es["est_id"]."' selected>".$row_es["est_nombre"]."</option>";
						else
							$this->listaEstados.="<option value='".$row_es["est_id"]."' >".$row_es["est_nombre"]."</option>";
							
				}  // while edo
				
				
			
		}else{
			$this->mensaje="No existe un punto de venta con el NUD ".$nud.", verifique o contacte al administrador";
			return 2;
			//  header("Location: index.php?action=editasolicitud&admin=nvasol&npun=$npunto&idcta=$idcta&cta=$cta");
		}	// if
		
	
		// var_dump($rowp);
	
	
		
		
	}
	
	public function buscarPVxIdCuenta($cuenta){
		$rowp=DatosUnegocio::UnegocioCompleta($npun,"ca_unegocios");
		// var_dump($rowp);
		$this->unegocio['NPUN'] =$rowp["une_numpunto"];
		$this->unegocio['NOMUNEG']= $rowp["une_descripcion"];
		$this->unegocio['IDC'] =$rowp["une_idcuenta"];
		$idc=$rowp["une_idcuenta"];
		$this->unegocio['TELUNEG']= $rowp["une_dir_telefono"];
		$this->unegocio['CALLEUNEG'] =$rowp["une_dir_calle"];
		$this->unegocio['NUMEXUNEG']= $rowp["une_dir_numeroext"];
		$this->unegocio['NUMINUNEG'] =$rowp["une_dir_numeroint"];
		$this->unegocio['MZUNEG']= $rowp["une_dir_manzana"];
		$this->unegocio['LTUNEG']= $rowp["une_dir_lote"];
		$this->unegocio['COLUNEG']= $rowp["une_dir_colonia"];
		$this->unegocio['DELEGUNEG']= $rowp["une_dir_delegacion"];
		$this->unegocio['MUNUNEG']=$rowp["une_dir_municipio"];
		$this->unegocio['CPUNEG']= $rowp["une_dir_cp"];
		$this->unegocio['REFUNEG'] =$rowp["une_dir_referencia"];
		$idedo=$rowp["une_dir_idestado"];
		$cta=$rowp["cue_clavecuenta"];
		
		// LLENA DATOS ADICIONALES
		$sqls="SELECT  MAX(cer_solicitud.sol_fechaapertura) AS FECAPER, cer_solicitud.sol_contacto, cer_solicitud.sol_correoelec, cer_solicitud.sol_dir_telefono, cer_solicitud.sol_dir_telmovil
 FROM cer_solicitud WHERE cer_solicitud.sol_idcuenta =:idc GROUP BY cer_solicitud.sol_idcuenta";
		$rss=Conexion::ejecutarQuery($sqls,array("idc"=>$idc));
		foreach($rss as $rows){
			$date=Utilerias::cambiaf_a_normal($rows["FECAPER"]);
			$this->unegocio['FECESTATUS']=$date;
			$this->unegocio['ICON']= $rows["sol_contacto"];
			$this->unegocio['TELUNEG']= $rows["sol_dir_telefono"];
			$this->unegocio['TELCEL']= $rows["sol_dir_telmovil"];
			$this->unegocio['MAIL']= $rows["sol_correoelec"];
		}
		// Llena lista de estados
		$rs=DatosEstado::listaEstadosModel("ca_uneestados");
		$this->listaEstados="";
		foreach($rs as $row_es) {
			if($idedo==$row_es["est_id"])
				$this->listaEstados.="<option value='".$row_es["est_id"]."' selected>".$row_es["est_nombre"]."</option>";
				else
					$this->listaEstados.="<option value='".$row_es["est_id"]."' >".$row_es["est_nombre"]."</option>";
					
		}  // while edo
		return $puntoVenta;
	}
	public function insertarSolicitud(){
		define('RAIZ',"solicitudes");
		$user = $_SESSION["NombreUsuario"];
		include 'Utilerias/leevar.php';
		
		
		$status=1;
		
		//formato a la fecha de visita para bd
		// $fecape= Utilerias::mysql_fecha($fecaper);
	//	$idserv=3;
		// IDENTIFICA SI ES INSERT O UPDATE
		
		$rs=DatosSolicitud::getSolicitud($clauneg,$idserv,"cer_solicitud");
		
		
		try{
			
			if ($rs&&sizeof($rs)>0){
				// edita
				$sSQL=("update cer_solicitud set sol_claveservicio='$idserv',
 sol_descripcion='$desuneg', sol_estatussolicitud='$status', sol_idcuenta='$idcta',
 sol_cuenta=$cta, sol_fechaapertura='".$fecape."', sol_contacto='".$conuneg."',
 sol_correoelec= '".$email."', sol_dir_calle='".$calle."', sol_dir_numeroext='".$numext."',
 sol_dir_numeroint='".$numint."', sol_dir_manzana='".$mz."', sol_dir_lote='".$lt."',
 sol_dir_colonia='".$col."', sol_dir_delegacion='".$del."', sol_dir_municipio='".$mun."',
sol_dir_estado='".$edo."', sol_dir_cp='".$cp."', sol_dir_referencia='".$ref."',
sol_dir_telefono='".$tel."', sol_dir_telmovil='".$cel."',sol_solicitante='".$user."',
 sol_numpunto =".$numpun." where sol_idsolicitud=".$clauneg.";");
				
				DatosSolicitud::actualizarSolicitud($idserv,  $desuneg, 	 $status, 	$idcta, 	 $cta, 	 $fecape,	 $conuneg, 	 $email,  $calle, 	 $numext, 	 $numint,
						$mz,  $lt,  $col, 	 $del, 	$mun,  $edo, $cp, 	 $ref,	 $tel,  $cel,
						$user, 	$numpun, 	 $clauneg);
				
				
			} else{  // nuevo
				//procedimiento de insercion de  la cuenta
				
				if ($numpun) {
				} else {
					$numpun=0;
				}
				$sSQL= "insert into cer_solicitud (sol_idsolicitud, sol_claveservicio, sol_descripcion, sol_estatussolicitud, sol_idcuenta,  sol_cuenta, sol_fechaapertura, sol_contacto, sol_correoelec, sol_dir_calle, sol_dir_numeroext, sol_dir_numeroint, sol_dir_manzana, sol_dir_lote, sol_dir_colonia, sol_dir_delegacion, sol_dir_municipio, sol_dir_estado, sol_dir_cp, sol_dir_referencia, sol_dir_telefono, sol_dir_telmovil, sol_solicitante, sol_numpunto)
    values (".$clauneg.", ".$idserv.", '".$desuneg."', ".$status.", '".$idcta."', ".$cta.", '".$fecape."', '".$conuneg."', '".$email."','".$calle."', '".$numext."', '".$numint."', '".$mz."', '".$lt."', '".$col."', '".$del."', '".$mun."', '".$edo."', '".$cp."', '".$ref."', '".$tel."', '".$cel."','".$user."',".$numpun.")";
				//$msg=$sSQL;
				DatosSolicitud::insertarSolicitud($idserv,  $desuneg, 	 $status, 	$idcta, 	 $cta, 	 $fecape,	 $conuneg, 	 $email,  $calle, 	 $numext, 	 $numint,
						$mz,  $lt,  $col, 	 $del, 	$mun,  $edo, $cp, 	 $ref,	 $tel,  $cel, 	 $user, 	$numpun, 	 $clauneg);
				
				
			}
			$this->mensaje='La solicitud se guardó correctamente';
			echo Utilerias::mensajeExito($this->mensaje);
// 			print("<script>
// window.location.replace('index.php?action=nuevasolicitudgepp&nsol=$clauneg');</script>");
			
		}catch(Exception $ex){
			
			echo' <div class="alert alert-success" role="alert">'.
					$ex->getMessage()."</div>";
			Utilerias::guardarError("nuevaSolicitudController.insertarSolicitud: ".$ex->getTraceAsString());
		}
		
	
		
		
	}
	public function  autorizarSolicitud($opcion){
		include "Utilerias/leevar.php";
		
		$idclien=1;
	
		
		$cuen=$idclien.$idserv.$cuenta;
		
		if($opcion=="no"){
			
			$estatus=4;
			$fecha="null";
			$npunto=null;
		}
		if($opcion=="si"){
			$estatus=2;
			$fecha="curdate()";
			
		}
		if($opcion=="cancelar"){
			$estatus=5;
			$fecha="null";
			$npunto=null;
		}
// 		if($opcion=="si"){
// 			if($npunto){
// 				$msg=$npunto;
// 			}else{
// 				// genera punto de venta
// 				// asigna nuevo numero de punto de venta
				
// 				// inserta punto de venta
// 				try{
					
// 					$npunto=DatosUnegocio::insertarUnegociodesdeSolicitud($idserv,$reporte);
// 				}catch(Exception $ex){
// 					$this->mensaje=Utilerias::mensajeError("Error al insertar, intente de nuevo");
// 				}
// 				// actualiza punto de venta;
				
// 			}
// 		}
		
		// guarda inspector, lee punto de venta y  cambia el estatus, manda mensaje de "aceptado"
		$sSQLabis=("update cer_solicitud set cer_solicitud.sol_claveinspector=:INSPECTOR,
cer_solicitud.sol_estatussolicitud = :estatus, cer_solicitud.sol_fechainicio=".$fecha.",cer_solicitud.sol_numpunto=:npunto".
				" WHERE cer_solicitud.sol_claveservicio =:servicio AND cer_solicitud.sol_idsolicitud =:reporte");
		//$msg=$sSQLa;
		try{
			
			Conexion::ejecutarInsert($sSQLabis,array("estatus"=>$estatus,"INSPECTOR"=>$INSPECTOR,"servicio"=>$idserv,"npunto"=>$npunto,"reporte"=>$reporte));
			$this->mensaje=Utilerias::mensajeExito("Se modificó el estatus correctamente");
			print("<script>
alert('Se modificó el estatus correctamente');
window.location.replace('index.php?action=listasolicitudes&sv=".$idserv."');</script>");
			
		}catch(Exception $ex){
		
			echo Utilerias::mensajeError($ex->getMessage());
		}
	}


	/**
	 * @return mixed
	 */
	public function getUnegocio() {
		return $this->unegocio;
	}

	/**
	 * @return string
	 */
	public function getMensaje() {
		return $this->mensaje;
	}

	/**
	 * @return string
	 */
	public function getListaCuentas() {
		return $this->listaCuentas;
	}
	/**
	 * @return mixed
	 */
	public function getListaestados() {
		return $this->listaEstados;
	}
	/**
	 * @return mixed
	 */
	public function getEnc_autor() {
		return $this->enc_autor;
	}

	/**
	 * @return string
	 */
	public function getAutor_ex() {
		return $this->autor_ex;
	}



	
	
	
	
}