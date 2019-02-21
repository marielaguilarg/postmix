<?php

include 'Models/crud_recepcionmuestra.php';

class RecepcionController {
	
	private $listaRecepciones;
	private $entregomues;
	private $datocardet;
	private $mensaje;
	private $recepcion;
	private $norec;
	public function vistaListaRecepcion(){
		include "Utilerias/leevar.php";
		
		switch($admin) {
			case "insertar" :
			$this->insertarRecepcion();
				break;
			case	"borrar" :
				$this->borrar();
				break;
			case "actualizar" :
			$this->actualizar();
				break;
			
		}
// 		$gpous=$_SESSION["GrupoUs"];
		
 		if(isset($_SESSION["NombreUsuario"]))
 			$recmues= $_SESSION["NombreUsuario"];
				
				
// 				// valida el usuario
	
// 				$rs1=UsuarioModel::getUsuario($recmues,"cnfg_usuarios");
// 				foreach ($rs1 as $row){
// 					$grupo=$row["cus_clavegrupo"];
// 					$tipolab=$row["cus_tipoconsulta"];
// 				}
				
				
				$ssql=("select rm_idrecepcionmuestra, rm_personarecibe, rm_personaentrega, rm_embotelladora,
 rm_fechahora, rm_estatus, horarec, idrecdet from (SELECT aa_recepcionmuestra.rm_idrecepcionmuestra,
 aa_recepcionmuestra.rm_personarecibe,
aa_recepcionmuestra.rm_personaentrega, aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestra.rm_fechahora,
aa_recepcionmuestra.rm_estatus, time(aa_recepcionmuestra.rm_fechahora) AS horarec FROM aa_recepcionmuestra 
WHERE
aa_recepcionmuestra.rm_estatus <='2' and aa_recepcionmuestra.rm_personaentrega =:recmues) as a left join
(SELECT aa_recepcionmuestradetalle.rm_idrecepcionmuestra as idrecdet FROM aa_recepcionmuestradetalle
GROUP BY aa_recepcionmuestradetalle.rm_idrecepcionmuestra) as b on a.rm_idrecepcionmuestra=b.idrecdet");
				//echo $ssql;
				$rs=Conexion::ejecutarQuery($ssql, array("recmues"=>$recmues));
				$cont=0;
				foreach ($rs as $row){
					
					$fechacad=$row["rm_fechahora"];
					$nvafec=Utilerias::formato_fecha($fechacad);
					
					$status=$row["rm_estatus"];
					$horarec=$row["horarec"];
					// busca el catalogo
					$numcat=43;
					$opcionc=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle", $numcat,$row["rm_embotelladora"]);
					
					$registro['numcat']=$row["rm_idrecepcionmuestra"];
					$registro['laborat']=$opcionc;
					$registro['celdaeditcat']=
							"<a href='index.php?action=nuevarecepcion&nuevo=E&referencia=".
										$row["rm_idrecepcionmuestra"]."'>".$row["rm_personaentrega"]."</a>";
					$registro['recibe']=$row["rm_personarecibe"];
					$registro['fecrecibo']=$nvafec;
					$registro['horrecibo']=$horarec;
					$registro['celdaSumniv']="<a href='index.php?action=recepciondetalle&cat=".$row["rm_idrecepcionmuestra"]."'>".
								"<i class='fa fa-plus'></i></a>";
					
					$imprimir= "<a href='imprimirReporte.php?admin=recibomue&ntoma=".$row["rm_idrecepcionmuestra"]."'>".
								"<i class='fa fa-print fa-2x' aria-hidden='true'></i></a>";
					if ($status==2) {
						$registro['imprec']=$imprimir;
					} else {
						$registro['imprec']="";
					}
					
					
					if ($gpous=="adm") {
						if ($row["idrecdet"]==$row["rm_idrecepcionmuestra"]) {
							$eliminar="";
						} else {
							$eliminar="<a href='index.php?action=listarecepcion&id=".$row['rm_idrecepcionmuestra']."&op=Trec&admin=borrar' onClick='return validar(this);'><i class='fa fa-remove fa-2x'></i></a></div></td>";
						}
					} else {
						$eliminar="";
					}
					$registro['delcat']=$eliminar;
					$this->listaRecepciones[]=$registro;
				}
				Navegacion::iniciar();
				Navegacion:: borrarRutaActual("a");
				$rutaact = $_SERVER['REQUEST_URI'];
				// echo $rutaact;
				Navegacion::agregarRuta("a", $rutaact, "RECEPCION DE MUESTRAS");
		
	}
	
	
	public function vistaNuevo(){
		
		$this->entregomues=$_SESSION["NombreUsuario"];
		
		// busca el catalogo
		$numcat=43;
		$rsca=DatosCatalogoDetalle::listaCatalogoDetalle($numcat,"ca_catalogosdetalle");
		$opcionc="";
		if ($rsca) {
			foreach ($rsca as $rowca){
				$opcionc=$opcionc."<option value=".$rowca[cad_idopcion].">".$rowca[cad_descripcionesp]."</option>";
			}
		}
		$this->datocardet="<div><select class='form-control' name='desclab' id='desclab'>".$opcionc."</select></div>";
		
	
		
	}
	
	public function vistaEdita(){
		include "Utilerias/leevar.php";
		
		$this->norec=$idref = $referencia;
		
		
		$rowrec=DatosRecepcionMuestra::editaRecepcion($idref);
	
		$this->entregomues=$rowrec["rm_personaentrega"];
		$this->recepcion= $rowrec["rm_personarecibe"];
		$opcemb=$rowrec["rm_embotelladora"];
		
		
		
		// busca el catalogo
		$numcat=43;
		$rsca=DatosCatalogoDetalle::listaCatalogoDetalle($numcat,"ca_catalogosdetalle");
	
		$opcionc="";
		if ($rsca) {
			foreach ($rsca as $rowca){
				if ($rowca[cad_idopcion]==$opcemb) {
					$opcionc=$opcionc."<option value=".$rowca[cad_idopcion]." selected>".$rowca[cad_descripcionesp]."</option>";
				} else {
					$opcionc=$opcionc."<option value=".$rowca[cad_idopcion].">".$rowca[cad_descripcionesp]."</option>";
				}	
			}
		}
		$tipocampo="<select class='form-control' name='desclab' id='desclab'>".$opcionc."</select>";
		
		$this->datocardet=$tipocampo;
		
	}
	
	public function insertarRecepcion(){
		include "Utilerias/leevar.php";
		
		// genera clave de servicio, la consulta debe estar agrupada y debera presentar el numero maximo para obtenerlo
	
		date_default_timezone_set('America/Mexico_City');
		$fecvis=date("Y-m-d H:i:s");
		
		
		if(isset($_SESSION["NombreUsuario"]))
			$entmues= $_SESSION["NombreUsuario"];
			
			//procedimiento de insercion del servicio
			
			try{
			if ($desclab) {
				DatosRecepcionMuestra::insertarRecepcion($recmues, $entmues, $desclab, $fecvis, "aa_recepcionmuestra");
			} else {
				$this->mensaje=Utilerias::mensajeError('No es posible recibir. No existe laboratorio seleccionado');
			}	
			}catch(Exception $ex){
				$this->mensaje=Utilerias::mensajeError("Error al insertar");
			}
	}
	
	public function actualizar(){
		include "Utilerias/leevar.php";

		try{
		DatosRecepcionMuestra::actualizarRecepcion($recmues, $numrecep, $desclab, "aa_recepcionmuestra");
		}catch(Exception $ex){
			$this->mensaje=Utilerias::mensajeError($ex->getMessage());
		}
	}
	
	public function borrar(){
		include "Utilerias/leevar.php";
		try{
		DatosRecepcionMuestra::borrarRecepcion($id, "aa_recepcionmuestra");
		}catch(Exception $ex){
			$this->mensaje=Utilerias::mensajeError($ex->getMessage());
		}
	
	}
	
	public function imprimir(){
		include "Utilerias/leevar.php";
		
		
		$sqleti1="SELECT aa_recepcionmuestra.rm_personarecibe, aa_recepcionmuestra.rm_personaentrega, 
aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestra.rm_fechahora,
 time(aa_recepcionmuestra.rm_fechahora) as horec FROM aa_recepcionmuestra 
WHERE aa_recepcionmuestra.rm_idrecepcionmuestra =  '".$ntoma."'";
		
		$valor=DatosRecepcionMuestra::editaRecepcion($ntoma);
		
			$numemboX=$valor["rm_embotelladora"];
			$horrecX=$valor["horec"];
			$fecharecX=Utilerias::formato_fecha($valor["rm_fechahora"])."  ".$horrecX;
			$recibeX=$valor["rm_personarecibe"];
			$entregaX=$valor["rm_personaentrega"];
		
		
		// obtengo embotellador
		$numcat=43;
		$sqlca="select * from ca_catalogosdetalle where cad_idcatalogo=".$numcat." and cad_idopcion=".$numemboX.";";
		$opcionc=DatosCatalogoDetalle::getCatalogoDetalle($ca_catalogosdetalle,43,$numemboX);
		
		// LEE DETALLE
		$sqleti="SELECT aa_recepcionmuestradetalle.mue_idmuestra,
aa_recepcionmuestradetalle.rm_idrecepcionmuestra, aa_recepcionmuestradetalle.rmd_tipoanalisis,
Sum(aa_recepcionmuestradetalle.rmd_unidades) AS totmuestras, aa_recepcionmuestra.rm_personarecibe,
aa_recepcionmuestra.rm_personaentrega, aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestra.rm_fechahora
FROM aa_recepcionmuestradetalle Inner Join aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra 
WHERE aa_recepcionmuestradetalle.rm_idrecepcionmuestra =  :ntoma
GROUP BY aa_recepcionmuestradetalle.rm_idrecepcionmuestra, aa_recepcionmuestradetalle.mue_idmuestra,
aa_recepcionmuestradetalle.rmd_tipoanalisis";
		$rseti=Conexion::ejecutarQuery($sqleti, array("ntoma"=>$ntoma));
		$treg=sizeof($rseti);
		$alto = ($treg*35) + 500;
		
		$textoENC="! 0 200 200 $alto 2
IN-MILIMETERS
LABEL
CONTRAST 0
TONE 0
SPEED 5
PAGE-WIDTH 380
GAP-SENSE 3
;// PAGE 0000000003800400
T 7 0 15 8 $fecharecX
T 7 0 15 30 $opcionc
T 7 0 8 80 MUESTRA
T 7 0 120 80 ANALISIS
T 7 0 260 80 UNIDADES
";
		
		
		
		
		$y=120;
		$numunids=0;
		foreach ($rseti as $valor) {
			$idrec=$valor["rm_idrecepcionmuestra"];
			$nmuesX=$valor["mue_idmuestra"];
			$tipoanaX=$valor["rmd_tipoanalisis"];
			$totmues=$valor["totmuestras"];
			
			IF ($tipoanaX=="FQ") {
				$tipoan="FISICOQUIMICO";
			} else {
				$tipoan="MICROBIOLOGICO";
			}
			
			$textoDET="
T 7 0 15 $y $nmuesX
T 7 0 85 $y $tipoan
T 7 0 306 $y $totmues
";
			$txtcuer=$txtcuer.$textoDET;
			$y+=35;
			$numunids+=$totmues;
		}
		
		$txtpie="LINE 245 $y 359 $y 1";
		$y+=35;
		$txtpie=$txtpie."
T 7 0 63 $y Total
T 7 0 306 $y $numunids";
		$y+=100;
		$txtpie=$txtpie."
T 7 0 15 $y ENTREGA:";
		//$y+=40;
		$txtpie=$txtpie."
T 7 0 120 $y $entregaX";
		$y+=100;
		$txtpie=$txtpie."
T 7 0 15 $y RECIBE:";
		//$y+=40;
		$txtpie=$txtpie."
T 7 0 120 $y $recibeX
PRINT
";
		
		$textofin=$textoENC.$txtcuer.$txtpie;
		
		//$nomarchivo="..\Archivos\recibo".$nmuesX.".fmt";
		
		$nomarchivo="Archivos/recibo".$nmuesX.".fmt";
		
		//echo $nomarchivo;
		//$textofin=$textofin.$texto;
		$archivo = fopen($nomarchivo,"w+");
		fwrite($archivo, $textofin);
		
		fclose($archivo);
		
		/* cambia estatus a 4 */
		/* buscar todas las muestras por recibo */
		$sqlr="SELECT aa_recepcionmuestradetalle.mue_idmuestra 
FROM aa_recepcionmuestradetalle WHERE
aa_recepcionmuestradetalle.rm_idrecepcionmuestra =  :ntoma
GROUP BY aa_recepcionmuestradetalle.mue_idmuestra";
		$rsr=Conexion::ejecutarQuery($sqlr,array("ntoma"=>$ntoma));
		foreach ($rsr as $valor) {
			$nmuesX=$valor["mue_idmuestra"];
			$sqlu="UPDATE aa_muestras SET aa_muestras.mue_estatusmuestra=4
 WHERE aa_muestras.mue_idmuestra='".$nmuesX."'";
			$rsu=DatosMuestra::actualizarEstatus(4, $nmuesX);
		}
		
		// actualiza recibo
		
		$sqlup="UPDATE aa_recepcionmuestra 
SET aa_recepcionmuestra.rm_estatus=3 
WHERE aa_recepcionmuestra.rm_idrecepcionmuestra='".$idrec."'";
		$rsu=DatosRecepcionMuestra::actualizarEstatus(3, $idrec, "aa_recepcionmuestra");
		
		header("Content-type: application/octet-stream");
		//header("Content-type: application/force-download");
		// $f="calendario.ZIP";
		header("Content-Disposition: attachment; filename=\"recibo".$nmuesX.".fmt\"");
		readfile($nomarchivo);
	}
	/**
	 * @return mixed
	 */
	public function getListaRecepciones() {
		return $this->listaRecepciones;
	}

	/**
	 * @return mixed
	 */
	public function getEntregomues() {
		return $this->entregomues;
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
	public function getDatocardet() {
		return $this->datocardet;
	}
	/**
	 * @return mixed
	 */
	public function getRecepcion() {
		return $this->recepcion;
	}
	/**
	 * @return mixed
	 */
	public function getNorec() {
		return $this->norec;
	}




	
	
	
}

