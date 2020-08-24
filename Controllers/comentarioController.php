<?php

include "Models/crud_comentDetalle.php";

class ComentarioController {

	private $TITULO5;
	private $listaComentarios;
	private $IdSecc;
	private $IdReport;
	public  $regresar;
	public $mensaje;
	public $sv;
	public $pv;
	public $liga;
	
	public function vistaComentarioRep(){
		
		include "Utilerias/leevar.php";
	
		switch($admin) {
			
			case "insertar":
				$this->insertar();
				break;
			
			default:
		$refer=$_SESSION["referencia"];
		
		$numrep=$nrep;
		$idsec=$sec;
		
	
// 		$datinic=SubnivelController::obtienedato($refer,1);
// 		$londatc=SubnivelController::obtienelon($refer,1);
// 		$idclien=substr($refer,$datinic,$londatc);
		
// 		$datini=SubnivelController::obtienedato($refer,2);
// 		$londat=SubnivelController::obtienelon($refer,2);
		$idser=$sv;
		$this->sv=$sv;
		$this->pv=$pv;
// 		$datiniu=SubnivelController::obtienedato($refer,3);
// 		$londatu=SubnivelController::obtienelon($refer,3);
// 		$idcuen=substr($refer,$datiniu,$londatu);
		
// 		$datiniu=SubnivelController::obtienedato($refer,4);
// 		$londatu=SubnivelController::obtienelon($refer,4);
// 		$iduneg=pv;
		
		
		/*Crea nombre de seccion*/
	
		$rs=DatosSeccion::editaSeccionModel($idsec, $idser, "cue_secciones");
		foreach ($rs as $row)
		{
			$this->TITULO5=$row["sec_descripcionesp"];
		}
	
		// crea detalle
		$datini=SubnivelController::obtienedato($refer,2);
		$londat=SubnivelController::obtienelon($refer,2);
		// busca los valores ya seleccionados
		$ssql_r= "select * from ins_comentseccion  WHERE concat(is_claveservicio,'.',is_numseccion)='".$idsec."' and is_numreporte = '".$numrep."'";
		$rs_r=DatosComentDetalle::consultaComentario($idser,$numrep,$idsec);

		foreach ($rs_r as $row_r)
		{
			$com = $row_r["is_comentario"];
			$valcom[$com-1]=$row_r["is_comentario"];
		}
		$ssql_c = "SELECT *
			   FROM cue_seccioncomentario
			  WHERE concat(ser_claveservicio,'.',sec_numseccion) = '".$idsec."' order by sec_numcoment";
		
		$rs_c=DatosSeccion::vistaSeccionComentModel($idsec, $idser, "cue_seccioncomentario");
		$cont = 0;
		$this->listaComentarios=array();
		
		foreach ($rs_c as $row_c)
		{
			$resultado=array();
			$resultado['numcomen']= $row_c["sec_numcoment"];
			$resultado['CeldaComent1']=$row_c["sec_comentesp"];
			if ($row_c["sec_numcoment"]==$valcom[$cont]){
				$valant="checked";
			}
			else
			{
				$valant="";
			}
			$resultado['checkcomen']=" <input type='checkbox' name='chk".$row_c["sec_numcoment"]."' ".$valant." value=".$row_c["sec_numcoment"].">";
		
			if($valant!="")
				$resultado['valcom']= "<input type='hidden' name='cmt".$valcom[$cont]."' value=".$valcom[$cont].">";
				else
					$resultado['valcom']="";
					
					
			$this->listaComentarios[]=$resultado;
			$cont++;
		}
		$une=DatosUnegocio::UnegocioCompleta($pv, "ca_unegocios");
		$idc=$une["cue_clavecuenta"];
		$this->regresar='index.php?action=editarep&sv='.$idser.'&nrep='.$numrep.'&pv='.$pv."&idc=".$idc;
		$this->IdReport= $numrep;
		$this->IdSecc= $idsec;
		$this->liga="index.php?action=rsn&ts=coment&admin=insertar";
		}
	}
	
	public function insertar(){
		include ('Utilerias/leevar.php');
		$i=0;
		$j=0;
		
		foreach($_POST as $nombre_campo => $valor){
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
		
			if(substr($nombre_campo,0,3)=='chk')
			{
				$arr[$i]=$nombre_campo;
				$i++;
			}
			//guarda los comentarios ya existentes
			if(substr($nombre_campo,0,3)=='cmt')
			{
				$coments[$j]=$valor;
				$j++;
			}
			eval($asignacion);
		}
	
		
		
		$nser=$sv;
		
		
		$nsec=$idseccion;
		
	
		$bandera=0;
		try{
		//elimina comentarios que no han sido seleccionados y que se encuentran almacenados en la tabla
		if(sizeof($coments)>0)
			for($cont=0; $cont<=$i; $cont++)
		{
			for($cont2=0; $cont2<=$j; $cont2++)
			{
				if($coments[$cont]==$arr[$cont2])
				{
					$bandera = 1;
				}
			}
			if($bandera!=1)
			{
				$sqldel = "DELETE FROM ins_comentseccion WHERE
						is_claveservicio=".$nser." AND
						is_numreporte=".$IdR." AND
						is_numseccion=".$nsec." AND
						is_comentario=".$coments[$cont];
			 DatosComentDetalle::eliminaComentario($nser, $IdR, $nsec, $coments[$cont]);
			}
			
			
			$bandera=0;
		}
		
		for($numc=0; $numc<$i; $numc++)
		{	$sSQL = "INSERT INTO ins_comentseccion (is_claveservicio,is_numreporte,is_numseccion,is_comentario)
			values ('".$nser."','".$IdR."','".$nsec."','".$_POST[$arr[$numc]]."')";
		DatosComentDetalle::insertarComentario($nser, $IdR, $nsec, filter_input(INPUT_POST, $arr[$numc],FILTER_SANITIZE_NUMBER_INT));
		}
		$une=DatosUnegocio::UnegocioCompleta($pv, "ca_unegocios");
		$idc=$une["cue_clavecuenta"];
		echo "
<script language='JavaScript'>
location.href = 'index.php?action=rsn&ts=coment&sec=".$nsec."&sv=".$nser."&nrep=".$IdR."&pv=".$pv."&id=".$idc."'
</script>";
		}catch(Exception $ex){
			$this->mensaje=Utilerias::mensajeError("Hubo un error al guardar, intente de nuevo");
		}
	}
	
	public function ponderadaComentario(){
		include "Utilerias/leevar.php";
		//$refer=$_GET["referencia"];
		switch($admin=="insertar"){
			case "insertar":
				$this->insertarComentarioPond();
				break;
			default:
				
				$refer=$_SESSION['referencia'];
		//echo $refer;
		
		$idsec=$sec;
		
	
		
		$datini=SubnivelController::obtienedato($refer,2);
		$londat=SubnivelController::obtienelon($refer,2);
		$idser=$sv;
		
		$datiniu=SubnivelController::obtienedato($refer,3);
		$londatu=SubnivelController::obtienelon($refer,3);
		//buscar la cuenta
		$idcuen=substr($refer,$datiniu,$londatu);
		
		$datiniu=SubnivelController::obtienedato($refer,4);
		$londatu=SubnivelController::obtienelon($refer,4);
		$iduneg=$pv;
		
		
		$datini2=SubnivelController::obtienedato($idsec,1);
		$londat2=SubnivelController::obtienelon($idsec,1);
		$idsecc=substr($idsec,$datini2,$londat2);
		
		$datini2=SubnivelController::obtienedato($idsec,2);
		$londat2=SubnivelController::obtienelon($idsec,2);
		$numsec=substr($idsec,$datini2,$londat2);
		
		$numrep=$nrep;
		// buca los valores ya seleccionados
		$sqlcs="SELECT ins_comentdetalle.id_comentario 
FROM ins_comentdetalle WHERE concat(id_comnumseccion,'.',id_comreactivo)='".$idsec."' 
AND id_comclaveservicio='".$idser."' and id_comnumreporte='".$numrep."'";
		$rs_cs=DatosComentDetalle::consultaComentDetalle($idser, $numrep, $idsec,"ins_comentdetalle" );
		foreach ($rs_cs as $row_cs)
		{
			$com = $row_cs["id_comentario"];
			$numcomsel[$com-1]=$row_cs["id_comentario"];
		}
		
		$ssql = "SELECT *
			   FROM cue_reactivoscomentarios
			  WHERE concat(sec_numseccion,'.',r_numreactivo)='".$idsec."'
			    AND ser_claveservicio='".$idser."'";
		$rs=DatosPond::vistaReactivoComentModel($idsec, $idser, "cue_reactivoscomentarios");
		$cont = 0;
		foreach ($rs as $row){
			if($cont%2==0)
			{
				$color="subtitulo3";
			}
			else  //class="subtitulo31"
			{
				$color="subtitulo31";
			}
			
			$comentario['numcomen']=$row["rc_numcomentario"];
			
			if ($row["rc_numcomentario"]==$numcomsel[$cont]){
				$valant="checked";
			}
			else
			{
				$valant="";
			}
			$comentario['CeldaComent1']=$row["rc_descomentarioesp"];
			
			$comentario['checkcomen']= "<input type='checkbox' name='chk".$row["rc_numcomentario"]."' ".$valant." value='".$row["rc_numcomentario"]."'>";
			
			if($valant!="")
				$comentario['valcom']= "<input type='hidden' name='cmt".$numcomsel[$cont]."' value=".$numcomsel[$cont].">";
				else
					$comentario['valcom']="";
					
				
					$this->listaComentarios[]=$comentario;
					$cont++;
		}
		
		$this->IdReport=$numrep;
		$this->refer= $refer;
		$this->IdSecc=$idsec;
		$this->IdSeccion=$idsecc;
		$this->sv=$sv;
		$this->pv=$pv;
		$une=DatosUnegocio::UnegocioCompleta($pv, "ca_unegocios");
		$idc=$une["cue_clavecuenta"];
		$this->regresar='index.php?action=rsn&sec='.$idsecc.'&ts=P&sv='.$idser.'&nrep='.$numrep.'&pv='.$pv.'&idc='.$idc;
		$this->liga="index.php?action=rsn&ts=Pcoment&admin=insertar";
		}
	}
	
	public function insertarComentarioPond(){
		$i=0;
		$j=0;
		
		foreach($_POST as $nombre_campo => $valor){
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
			if(substr($nombre_campo,0,3)=='chk')
			{
				$arr[$i]=$nombre_campo;
				$i++;
			}
			//guarda los comentarios ya existentes
			if(substr($nombre_campo,0,3)=='cmt')
			{
				$coments[$j]=$valor;
				$j++;
			}
			eval($asignacion);
		}
		
		include "Utilerias/leevar.php";
		$refer=$referencia;
		
		$numrep = $IdR;
		
		
		$dato = $idseccion;
		$datini=SubnivelController::obtienedato($dato,1);
		$londat=SubnivelController::obtienelon($dato,1);
		$nsec=substr($dato,$datini,$londat);
		
		$dato2 = $idseccion;
		$datini=SubnivelController::obtienedato($dato2,2);
		$londat=SubnivelController::obtienelon($dato2,2);
		$nreac=substr($dato2,$datini,$londat);
		
		//include ('MEutilerias.php');
		$datini1=SubnivelController::obtienedato($refer,2);
		$londat1=SubnivelController::obtienelon($refer,2);
		$idser=$sv;
		
		$datini4=SubnivelController::obtienedato($refer,3);
		$londat4=SubnivelController::obtienelon($refer,3);
		$idseccion=substr($refer,$datini4,$londat4);
		
		$bandera=0;
		
		//elimina comentarios que no han sido seleccionados y que se encuentran almacenados en la tabla
		if(sizeof($coments)>0)
		for($cont=0; $cont<=$i; $cont++)
		{
			for($cont2=0; $cont2<=$j; $cont2++)
			{
				if($coments[$cont]==$arr[$cont2])
				{
					$bandera = 1;
				}
			}
			if($bandera!=1)
			{
				$sqldel = "DELETE FROM ins_comentdetalle WHERE
						id_comclaveservicio=".$idser." AND
						id_comnumreporte=".$IdR." AND
						id_comnumseccion=".$nsec." AND
						id_comreactivo=".$nreac." AND
						id_comentario=".$coments[$cont];
				$rsd = DatosComentDetalle::eliminaComentarioDet($idser, $numrep, $nsec, $nreac, $coments[$cont]);
			}
			
			$bandera=0;
		}
		
		for($numc=0; $numc<$i; $numc++)
		{
			$sSQL = "INSERT INTO ins_comentdetalle (id_comclaveservicio,id_comnumreporte,
id_comnumseccion,id_comentario,id_comreactivo)
										VALUES (".$idser.",".$IdR.",".$nsec.",".$_POST[$arr[$numc]].",".$nreac.")";
			$rs=DatosComentDetalle::insertarComentarioDet($idser, $numrep, $nsec, $nreac, filter_input(INPUT_POST, $arr[$numc],FILTER_SANITIZE_NUMBER_INT));
		}
		$header="Location: MEIprincipal.php?op=subnivel&admin=coment&secc=$dato&tiposec=P&numrep=$numrep";
		//	echo $header;
		$une=DatosUnegocio::UnegocioCompleta($pv, "ca_unegocios");
		$idc=$une["cue_clavecuenta"];
		echo "
<script language='JavaScript'>
location.href = 'index.php?action=rsn&sec=$nsec&ts=P&sv=$sv&nrep=$IdR&pv=$pv&idc=$idc'
</script>";
		
	}
	/**
	 * @return mixed
	 */
	public function getTITULO5() {
		return $this->TITULO5;
	}

	/**
	 * @return multitype:
	 */
	public function getListaComentarios() {
		return $this->listaComentarios;
	}
	/**
	 * @return mixed
	 */
	public function getIdSecc() {
		return $this->IdSecc;
	}

	/**
	 * @return mixed
	 */
	public function getIdReport() {
		return $this->IdReport;
	}


	
	

}


