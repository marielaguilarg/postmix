<?php
include "Models/crud_recepcionmuestra.php";
class RecepcionDetalleController {
	private $listaRecepciones;
	
	private $mensaje;
	private $numrec;
	
	public function vistaDetalle(){
		include "Utilerias/leevar.php";
		switch($admin) {
			case "insertar" :
				$this->insertar();
				break;
			case	"borrar" :
				$this->borrar();
				break;
			case "actualizar" :
				
				break;
		}
		
		$numcat = $cat;
		
		
		if ($numcat){
			if (!isset($_SESSION['catalogo'])) {
				$_SESSION['catalogo']=$numcat;
			} else {
				$_SESSION['catalogo']=$numcat;
			}
		}else {
			$numcat=$_SESSION['catalogo'];
		}
		
		$classsub="subtitulopeq";
		$cont=0;
		$partida=1;
		
		
		$ssql=("SELECT mue_idmuestra, SUM(MUESFQ) AS TOTFQ, SUM(MUESMB) AS TOTMB,
mue_tipomuestra, mue_capacidadFQ, mue_capacidadMB from
(SELECT aa_recepcionmuestradetalle.mue_idmuestra, IF(rmd_tipoanalisis='FQ',rmd_unidades,0) AS MUESFQ,
 IF(rmd_tipoanalisis='MB',rmd_unidades,0) AS MUESMB, aa_muestras.mue_tipomuestra,
 aa_muestras.mue_capacidadFQ, aa_muestras.mue_capacidadMB
 FROM aa_recepcionmuestradetalle
Inner Join aa_muestras ON aa_recepcionmuestradetalle.mue_idmuestra = aa_muestras.mue_idmuestra
 WHERE aa_recepcionmuestradetalle.rm_idrecepcionmuestra = :numcat) as a
group by  mue_idmuestra;");
		$rst=Conexion::ejecutarQuery($ssql,array("numcat"=>$numcat));
		$treg=sizeof($rst);
		
		if ($treg>0) {
			$this->numrec='index.php?action=listarecepcion';
		}else{
			$this->numrec='index.php?action=nuevarecepciondet&nuevo=S&refer='.$numcat;
		}
		foreach ($rst as $rowt){
			$renglon=array();
			$idrec =$numcat;
			$idmuestra =$rowt["mue_idmuestra"];
			$unidadesFQ =$rowt["TOTFQ"];
			$unidadesMB =$rowt["TOTMB"];
			$tipomuestra =$rowt["mue_tipomuestra"];
			$capacidadFQ =$rowt["mue_capacidadFQ"];
			$capacidadMB =$rowt["mue_capacidadMB"];
			
			$renglon["nummues"]=$partida;
			
			
			// busca tipo muestra
			
			$destipomue=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",41,$tipomuestra);
			
			$renglon["idmue"]=$idmuestra;
			$renglon["tipomue"]=$destipomue;
			$renglon["uFQ"]=$unidadesFQ;
			$renglon["capacidadFQ"]=$capacidadFQ;
			$renglon["uMB"]=$unidadesMB;
			$renglon["capacidadMB"]=$capacidadMB;
			//$renglon["delcat"]=$row["cad_idcatalogo"].'.'.$row["cad_idopcion"];
			
			
			//Despues de la asignación se cambia el color de background del siguiente registro
			
			$cont++;
			$partida++;
			$this->listaRecepciones[]=$renglon;
			
			
		}
		
		Navegacion:: borrarRutaActual("b");
		$rutaact = $_SERVER['REQUEST_URI'];
		// echo $rutaact;
		Navegacion::agregarRuta("b", $rutaact, "RECEPCION NO.".$numcat);
		
	}
	public function vistaNuevo(){
		include "Utilerias/leevar.php";
		//$secc = $_SESSION['secc'];
		//$refer=$_SESSION["referencia"];
		//$numrep=$_SESSION["numreporte"];
		$nvarec=$refer;
	
		$this->nsec=$nsec;
		
		$this->numrec=$nvarec;
	
	
		$this->CCAMPO="";
	}
	
	
	public function insertar(){
		include "Utilerias/leevar.php";
		
		$cambio=0;
		// genera numero de partida, la consulta debe estar agrupada y debera presentar el numero maximo para obtenerlo
		
		$ssql="SELECT Max(aa_recepcionmuestradetalle.rmd_partida) AS ulpartida
 FROM aa_recepcionmuestradetalle
 WHERE
aa_recepcionmuestradetalle.rm_idrecepcionmuestra =:numrecibo
 GROUP BY aa_recepcionmuestradetalle.rm_idrecepcionmuestra;";
		try{
			
		$ulpar=DatosRecepcionMuestra::ultimaRecepcionDet($numrecibo);
		
		if ($ulpar !=0){
		
		$ulpar++;
		}
		else $ulpar=1;
	
		if(isset($_SESSION["Usuario"]))
		
			$recmues= $_SESSION["Usuario"];
			
			// inicia tabla temporal
			//$ssqle=("DELETE FROM tmp_recepcion;");
			DatosRecepcionMuestra::eliminartmp();
			
			// inserta los registros seleccionados
			
			for($i=1;$i<=$registros;$i++)
			{
				// lee codigo de barras
				$codigoact="codigo".$i;
				// determina si es fisicoquimico o microbiologico
				
				if (ctype_space(${$codigoact})) {
					$codigoana="";
				} else {
					$codigoana=${$codigoact};
				}
				
				$primerpunto=strlen($codigoana)-2;
				$segundopunto=strlen($codigoana)-7;
				$tipomues=substr($codigoana,0,2);
				$idmues=substr($codigoana,2,$primerpunto);
				
				//    $varinarray=$idmues.$tipomues;
				//	echo $varinarray;
				
				$sSQLI= "insert into tmp_recepcion (idmuestra) values ('".$codigoana."');";
				$rs=DatosRecepcionMuestra::insertartmp($codigoana);
			}
			
			// LEE TOTAL DE REGISTROS RECIBIDOS
			
			$SQLL="select nummuestra, sum(TOTMUESTRAFQ) as totfq, sum(TOTMUESTRAMB) as totmb 
from
(SELECT RIGHT(tmp_recepcion.idmuestra,LENGTH(tmp_recepcion.idmuestra)-2) AS NUMMUESTRA, 
if(LEFT(tmp_recepcion.idmuestra,2)='FQ',Count(tmp_recepcion.idmuestra),0) AS `TOTMUESTRAFQ`,  
if(LEFT(tmp_recepcion.idmuestra,2)='MB',Count(tmp_recepcion.idmuestra),0) AS `TOTMUESTRAMB` FROM
tmp_recepcion GROUP BY tmp_recepcion.idmuestra) as a
group by nummuestra";
			
			//tmp_recepcion GROUP BY tmp_recepcion.idmuestra";
			//echo $SQLL;
			$rsnr=Conexion::ejecutarQuerysp($SQLL);
		
			$num_reg = sizeof($rsnr);
				
			foreach ($rsnr as $rownr) {
				$nmues= $rownr["nummuestra"];
				$totmb=$rownr["totmb"];
			
				$totfq=$rownr["totfq"];
				//echo $totfq;
				
				//BUSCO TOTAL TOMA DE MUESTRA
				$sqltt="SELECT aa_muestras.mue_idmuestra, aa_muestras.mue_numunidadesFQ, aa_muestras.mue_numunidadesMB,
aa_muestras.mue_estatusmuestra FROM
aa_muestras WHERE aa_muestras.mue_idmuestra =  :nmues'";
				
				$rsntt=DatosMuestra::olistaMuestrasxIdMuestra($nmues,"aa_muestras");
				$num_regt = sizeof($rsntt);
			
				foreach ($rsntt as $rowtt) {
					if($rowtt["mue_claveservicio"]==3||$rowtt["mue_claveservicio"]==5){
						//primero valido que se pueda recibir
						$respuesta =DatosGenerales::validaDiagnostico($rowtt["mue_claveservicio"], $rowtt["mue_numreporte"], "5", "4", "ins_detalle");
						if($respuesta<=0)
						{
							throw new Exception("Falta capturar información de la sección 5 del reporte, verifique");
						}
					}
					if  ($rowtt["mue_estatusmuestra"]==2) {  // listo para recibirse
//  						echo $rowtt["mue_numunidadesMB"];
//  						echo "--".$totmb;
//  						echo "....".$rowtt["mue_numunidadesFQ"];
//  						echo "---".$totfq; die();
						if ($totmb==$rowtt["mue_numunidadesMB"] and $totfq==$rowtt["mue_numunidadesFQ"]) {  // listo para recibirse
							//procedimiento de insercion del recibo
							// insert FQ
							$sSQL= "insert into aa_recepcionmuestradetalle
(aa_recepcionmuestradetalle.rmd_partida, aa_recepcionmuestradetalle.rm_idrecepcionmuestra, aa_recepcionmuestradetalle.mue_idmuestra, aa_recepcionmuestradetalle.rmd_tipoanalisis,
aa_recepcionmuestradetalle.rmd_unidades, aa_recepcionmuestradetalle.rmd_estatus) VALUES ($ulpar, '$numrecibo','$nmues','FQ', $totfq,1)";
							
							DatosRecepcionMuestra::insertarRecepcionDet(0,$ulpar, $numrecibo, $nmues, $totfq,"FQ");
							
							$i++;
							$ulpar++;
							// insert MB
							$sSQLM= "insert into aa_recepcionmuestradetalle
(aa_recepcionmuestradetalle.rmd_partida, aa_recepcionmuestradetalle.rm_idrecepcionmuestra, aa_recepcionmuestradetalle.mue_idmuestra, aa_recepcionmuestradetalle.rmd_tipoanalisis,
aa_recepcionmuestradetalle.rmd_unidades, aa_recepcionmuestradetalle.rmd_estatus) VALUES ($ulpar, '$numrecibo','$nmues','MB', '$totmb',1)";
							//echo $sSQLM;
							DatosRecepcionMuestra::insertarRecepcionDet(0,$ulpar, $numrecibo, $nmues, $totmb,"MB");
							
							$i++;
							$ulpar++;
							$cambio++;
							// actualiza estatus de la muestra
							$sSQLu1="update aa_muestras set mue_estatusmuestra=3, mue_fecharecepcion=now() where mue_idmuestra=$nmues";
							$rs1=DatosMuestra::actualizarFechaRecepcion($nmues);
							//echo "todo ok";
						} else {   // LAS MUESTRAS NO COINCIDEN
							// SI NO, PRESENTA MENSAJE
							throw new Exception('No es posible recibir. El numero de unidades que intenta entregar, no coincide con las recolectadas');
						//	print("<script>window.location.replace('MEZprincipal.php?op=Trec&admin=detalle&cat=$numrecibo');</script>");
						}
					} else if ($rowtt["mue_estatusmuestra"]==6) {
						throw new Exception('No es posible recibir. La muestra '. $nmues.' esta cancelada');
						//print("<script>window.location.replace('MEZprincipal.php?op=Trec&admin=detalle&cat=$numrecibo';
					} else if  ($rowtt["mue_estatusmuestra"]==1) {
						throw new Exception('No es posible recibir. No se ha impreso la etiqueta para la muestra No. '.$nmues);
						//print("<script>window.location.replace('MEZprincipal.php?op=Trec&admin=detalle&cat=$numrecibo');</script>");
					} else if  ($rowtt["mue_estatusmuestra"]>=3 && $rowtt["mue_estatusmuestra"]<=5) {
						throw new Exception('No es posible recibir. la muestra No. '.$nmues.' ya fue recibida');
						//print("<script>window.location.replace('MEZprincipal.php?op=Trec&admin=detalle&cat=$numrecibo');</script>");
					}
				}
				//		 }
				//	}
			}// cambia estatus
			
			if ($cambio>0) {
				date_default_timezone_set('America/Mexico_City');
				//$fecvis=date("Y-m-d H:i:s")
				$fecvis=date("Y-m-d H:i:s");
			
				
				$sSQLu="update aa_recepcionmuestra set aa_recepcionmuestra.rm_fechahora='$fecvis', aa_recepcionmuestra.rm_estatus=2 WHERE aa_recepcionmuestra.rm_idrecepcionmuestra=".$numrecibo;
				$rs=DatosRecepcionMuestra::actualizarFechaRecepcion($fecvis,$numrecibo);
			
			} else {
				// elimina registro de recibo
				if ($num_regt==0) {
					throw new Exception('No es posible recibir. La muestra No. '.$nmues.' no existe');
					//print("<script>window.location.replace('MEZprincipal.php?op=Trec&admin=detalle&cat=$numrecibo');</script>");
				}
				//$SQLD="DELETE FROM aa_recepcionmuestra WHERE aa_recepcionmuestra.rm_idrecepcionmuestra='$nmues'";
				$rsd=DatosRecepcionMuestra::eliminarRecepcion($nmues);
			}
			echo Utilerias::enviarPagina("index.php?action=recepciondetalle&cat=".$numrecibo);
		}catch(Exception $ex){
			$this->mensaje=Utilerias::mensajeError($ex->getMessage());
		}
			
	}
	
	public function borrar(){
		include "Utilerias/leevar.php";

		try{
		//$sSQL="Delete From ca_catalogosdetalle Where concat(cad_idcatalogo,'.',cad_idopcion)='". $id."';";
		$arr=explode(".", $id);
		DatosCatalogoDetalle::borrarCatalogoDetalle($arr[0], $arr[1], "ca_catalogosdetalle");
		echo Utilerias::enviarPagina("index.php?action=listarecepcion");
		}catch(Exception $ex){
			$this->mensaje=Utilerias::mensajeError($ex->getMessage());
		}
	}
	/**
	 * @return multitype:number unknown 
	 */
	public function getListaRecepciones() {
		return $this->listaRecepciones;
	}

	/**
	 * @return string
	 */
	public function getMensaje() {
		return $this->mensaje;
	}
	/**
	 * @return Ambigous <string, unknown>
	 */
	public function getNumrec() {
		return $this->numrec;
	}


	
	
	
	
}

