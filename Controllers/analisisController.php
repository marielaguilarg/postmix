<?php

include "Models/crud_resultadoanalisis.php";
include "Models/crud_pruebaAnalisis.php";
class AnalisisController{
	
	private $listaEstandar;
	private $TITULO;
	private $TITULO2;
	private $TITULO4;
	private $TITULO5;
	private $ntoma;
	private $numcom;
	private $NUMREP;
	private $FechaVisita;
	private $listaAtributos;
	private $botnvo;
	private $Nmues;
	
	
	public function listaAnalisis($tipoAna){
		include "Utilerias/leevar.php";
		
		switch($admin) {
			case "insertar" :
				$this->insertarAnalisisMB();
				break;
			case "insdatFQ" :
				$this->insertarAnalisisFQ();
				break;
			case "eliminar" :
				include('./MEZborraanalisisFQ.php');
				break;
			case 'imp':
				//        include('MEZreporteanalisisFQ.php');// tabla de indicadores
				include('MEZrepFQPDF.php');// tabla de indicadores
				break;	
		}
		/*Crea titulo*/
		$titulo["FQ"]="ANALISIS FISICOQUIMICO";
		$titulo["MB"]="ANALISIS MICROBIOLOGICO";
		if($tipoAna!="FQ"&&$tipoAna!="MB")
		return;
		$sql_1 = "SELECT 
  aa_recepcionmuestradetalle.mue_idmuestra,
  aa_recepcionmuestradetalle.rmd_estatus,
  ca_unegocios.une_descripcion,
  aa_muestras.mue_numreporte,
  ins_generales.i_fechavisita,
  ca_clientes.cli_nombre,
  ca_servicios.ser_descripcionesp,
  aa_muestras.mue_tipomuestra,
  ins_detalleestandar.ide_claveservicio 
FROM
  aa_recepcionmuestradetalle 
  INNER JOIN aa_muestras 
    ON aa_recepcionmuestradetalle.mue_idmuestra = aa_muestras.mue_idmuestra 
  INNER JOIN ins_generales 
    ON aa_muestras.mue_numreporte = ins_generales.i_numreporte 
  INNER JOIN ca_unegocios 
    ON ins_generales.i_unenumpunto = ca_unegocios.une_id 
  
  INNER JOIN ca_servicios 
    ON ins_generales.i_claveservicio = ca_servicios.ser_id 
  INNER JOIN ca_clientes 
    ON ca_clientes.cli_id = ca_servicios.`ser_idcliente`
  INNER JOIN ins_detalleestandar 
    ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio 
    AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte 
    AND aa_muestras.mue_idmuestra = ins_detalleestandar.ide_idmuestra 
WHERE aa_recepcionmuestradetalle.mue_idmuestra =:ntoma ";
		if($admin=="cons"){
			$sql_1.=" and aa_muestras.mue_estatusmuestra =  '5' ";
		}
$sql_1.=" GROUP BY aa_recepcionmuestradetalle.mue_idmuestra, aa_recepcionmuestradetalle.rmd_estatus";
		
		$rs_1 = Conexion::ejecutarQuery($sql_1,array("ntoma"=>$ntoma));

		foreach($rs_1 as $row_1) {
			$this->TITULO=$row_1['cli_nombrecliente'];
			$this->TITULO2=$row_1["ser_descripcionesp"];
			$this->TITULO4=$row_1["une_descripcion"];
		    $nomsec="No. DE MUESTRA : ". $ntoma."  ".$titulo[$tipoAna];
			$numrep=$row_1["mue_numreporte"];
			$idserv=$row_1["ide_claveservicio"];
			$tipomue=$row_1["mue_tipomuestra"];
			$this->TITULO5=$nomsec;
			$this->ntoma=$ntoma;
			$this->numcom=$tipomue;
			$this->NUMREP ="Reporte No. : ".$row_1["mue_numreporte"];
			$this->FechaVisita=  "Fecha de Visita : " .Utilerias::formato_fecha($row_1["i_fechavisita"]);
		}
	
		// crea encabezados
		
		/*$sqld="SELECT cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing, cue_reactivosestandardetalle.red_lugarsyd, cue_reactivosestandardetalle.ser_claveservicio, cue_reactivosestandardetalle.sec_numseccion, cue_reactivosestandardetalle.r_numreactivo, cue_reactivosestandardetalle.re_numcomponente, cue_reactivosestandardetalle.re_numcaracteristica, cue_reactivosestandardetalle.re_numcomponente2, cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_estandar, cue_reactivosestandardetalle.red_tiporeactivo FROM aa_pruebaanalisis Inner Join cue_reactivosestandardetalle ON aa_pruebaanalisis.pa_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND aa_pruebaanalisis.pa_numprueba = cue_reactivosestandardetalle.red_numcaracteristica2 WHERE cue_reactivosestandardetalle.ser_claveservicio =  '1' AND cue_reactivosestandardetalle.sec_numseccion =  '5' AND aa_pruebaanalisis.pa_tipoanalisis =  'FQ' AND cue_reactivosestandardetalle.re_numcomponente =:tipomue'";*/
		
	
	
		$sumapond=0;
		$totren=0;
		
		$subsecc="5.0.".$tipomue.".0";
		//$subsecc="5.0.2.0";
		$sqlnr="SELECT ins_detalleestandar.ide_numrenglon AS claveren, aa_pruebaanalisis.pa_tipoanalisis
 FROM ins_detalleestandar
Inner Join aa_pruebaanalisis ON ins_detalleestandar.ide_numcomponente = aa_pruebaanalisis.pa_numcomponente 
AND ins_detalleestandar.ide_numcaracteristica3 = aa_pruebaanalisis.pa_numprueba 
WHERE ins_detalleestandar.ide_claveservicio =:idserv AND ins_detalleestandar.ide_numreporte =:numrep AND
aa_pruebaanalisis.pa_tipoanalisis =  :tipoana  AND
ins_detalleestandar.ide_idmuestra =:ntoma group by ide_numrenglon";
		//echo $sqlnr;
		$rsnr=Conexion::ejecutarQuery($sqlnr,array("idserv"=>$idserv,"numrep"=>$numrep,"tipoana"=>$tipoAna,"ntoma"=>$ntoma));
		$cont = 0;
		
		$nreg=sizeof($rsnr);
		
		if ($nreg<=0) {
			$bnvo='<a class="btn btn-default pull-right" style="margin-right: 18px" href="index.php?action=nuevoanalisis&ncomp='.$tipomue.'&ntoma='.$ntoma.'&tipo='.$tipoAna.'"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
';
			$this->botnvo=$bnvo;
		}
		$bnvo='<a class="btn btn-default pull-right" style="margin-right: 18px" href="index.php?action=nuevoanalisis&ncomp='.$tipomue.'&ntoma='.$ntoma.'&tipo='.$tipoAna.'"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
';
	//	$this->botnvo=$bnvo;
		foreach ($rsnr as $rownr) {
			$resultado=array();
				
				$caduco="label-danger";
			
			$numren=$rownr["claveren"];
			
			$numdes="RESULTADO".$numren;
			
			$resultado[]= $numdes;
			
		
		
			$rscue=DatosMuestra::vistaResultados($idserv,1,$tipoAna,$tipomue,"aa_pruebaanalisis");
		
			
			
			$cont_rea=0;
			foreach ($rscue as $rowcue) {
				
				$tipoeva=$rowcue['re_tipoevaluacion'];
				$ssqldet="SELECT `ins_detalleestandar`.`ide_claveservicio`, `ins_detalleestandar`.`ide_numreporte`, 
`ins_detalleestandar`.`ide_numseccion`, `ins_detalleestandar`.`ide_numreactivo`, `ins_detalleestandar`.`ide_numcomponente`, 
`ins_detalleestandar`.`ide_numcaracteristica1`,
 `ins_detalleestandar`.`ide_numcaracteristica2`, `ins_detalleestandar`.`ide_numcaracteristica3`, `ins_detalleestandar`.`ide_valorreal`,
 `ins_detalleestandar`.`ide_ponderacion`, 
`ins_detalleestandar`.`ide_numrenglon`, `ins_detalleestandar`.`ide_comentario`, `ins_detalleestandar`.`ide_aceptado`, 
`ins_detalleestandar`.`ide_numcolarc`, `ins_detalleestandar`.`ide_idmuestra`
FROM ins_detalleestandar 
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo
 AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente
Inner Join cue_secciones ON cue_reactivosestandar.ser_claveservicio = cue_secciones.ser_claveservicio AND cue_reactivosestandar.sec_numseccion = cue_secciones.sec_numseccion 
WHERE
ins_detalleestandar.ide_claveservicio =  :idserv AND
cue_secciones.sec_indagua =  '1' AND
ins_detalleestandar.ide_numreporte =:numrep AND
ins_detalleestandar.ide_numrenglon =  1 AND
ins_detalleestandar.ide_numcaracteristica3 =:carac AND
ins_detalleestandar.ide_idmuestra =  :ntoma AND
ins_detalleestandar.ide_numcomponente =:componente";
				
				$parametros=array("idserv"=>$idserv,
						"numrep"=>$numrep,
						"carac"=>$rowcue["red_numcaracteristica2"],
				"ntoma"=>$ntoma,
				"componente"=> $rowcue["re_numcomponente"]
				);
				$rsc=Conexion::ejecutarQuery($ssqldet,$parametros);
				
				if(sizeof($rsc))
					foreach ($rsc as $rowdet) {
						$resultado=array();
						$resultado["atributo"]=$rowcue["red_parametroesp"];
						
						$estandar=$rowcue["red_estandar"];
						$resultado["estandar"]=$estandar;
						$tipocat=$rowcue["red_tipodato"];
						$resacep=$rowdet["ide_aceptado"];
					
						$pondori=$rowcue["red_ponderacion"];
						switch ($tipocat) {
							case "C" :
								$siguno=$rowcue["red_signouno"];
								$valmin=$rowdet["red_valormin"];
								$valop=round($rowdet["ide_valorreal"],1);
								$numcat=$rowcue["red_clavecatalogo"];
								$valpond = $rowdet["ide_ponderacion"];
								
								$valreal=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valop);
								
								
								break;
							case "N" :
								$siguno=$rowcue["red_signouno"];
								$valmin=$rowcue["red_valormin"];
								$valreal=round($rowdet["ide_valorreal"],3);
								$valmax=$rowcue["red_valormax"];
								$sigdos=$rowcue["red_signodos"];
								$valpond = $rowdet["ide_ponderacion"];
						}
					
						if(isset($estandar)&&$estandar!="") {
							
							if ($resacep!=0) {
								$resultado["resultado"]="<div class='label label-primary'>".$valreal."</div>";
							}else {
								$resultado["resultado"]="<div class='label $caduco'> ".$valreal."</div>";
							}
						}
						else
							$resultado["resultado"]="<div class='label label-primary'>".$valreal."</div>";
							
							// calcula ponderacion
							switch($tipoeva) {
								case 0 :   // ninguna linea
									$sumapond=0;
									break;
								case 1 :   // una linea
									if ($rowdet["ide_numrenglon"]==1) {
										$sumapond=$sumapond+$valpond;
									}
									break;
								case 2 :   // todas las lineas
									$sumapond=$sumapond+$valpond;
									if ($pondori>0) {
										$totren=$totren+1;
									}
							}
							$this->listaEstandar[]=$resultado;
							
					}
				
				else {
					
					$resultado["resultado"]="";
					$this->listaEstandar[]=$resultado;
					
				}
				
				// $html->expandir($area,$seccion);
				
						$cont_rea++;
						
			}
			
			
			$cont++;
			
		}
		
		
		if ($numren==0) {
			$numren=1;
		}
	
		Navegacion:: borrarRutaActual("b");
		$rutaact = $_SERVER['REQUEST_URI'];
		// echo $rutaact;
	Navegacion::agregarRuta("b", $rutaact, "MUESTRA NO. ".$ntoma);
	}
	
	public function nuevoAnalisisMB(){
		include "Utilerias/leevar.php";
		
		if ($ncomp) {
			if (!isset($_SESSION['ncomp'])) {
				$_SESSION['ncomp']=$ncomp;
			} else {
				$_SESSION['ncomp']=$ncomp;
			}
		}else {
			$ncomp=$_SESSION['ncomp'];
		}
		
		
		if ($ntoma) {
			if (!isset($_SESSION['ntoma'])) {
				$_SESSION['ntoma']=$ntoma;
			} else {
				$_SESSION['ntoma']=$ntoma;
			}
		}else {
			$ntoma=$_SESSION['ntoma'];
		}
		
		$this->Nmues=$ntoma;
		
		$rss=DatosMuestra::buscarComponenteMuestra($ntoma,"ins_detalleestandar");
		//var_dump($rss);
		foreach ($rss as $rows){
			$idserv=$rows["ide_claveservicio"];
			$idcomp=$rows["ide_numcomponente"];
		}
			
		//echo "***";
		
		$rsd=DatosMuestra::vistaResultados($idserv, 1, "MB", $idcomp, "aa_pruebaanalisis");
		$i=1;
		foreach ($rsd as $rowd){
			
				$tipocampo="<td height='30' class='subtitulo3p'>".$i."</td>";
		
			//verifico para no poner el campo de volumenes de CO2
			if($idserv==1&&$secc=="8.0.2.0.0"&& $rowd["red_numcaracteristica2"]==9)
				continue;
				if($idserv==1&&$secc=="8.0.1.0.0"&& $rowd["red_numcaracteristica2"]==9)
					continue;
					$cadena= $tipocampo."<td  >".$rowd["red_parametroesp"]." :   "."</td>";
					switch ($rowd['red_tipodato']){
						case "C" :
							// busca el catalogo
							$numcat=$rowd['red_clavecatalogo'];
							//$sqlca="select * from ca_catalogosdetalle where cad_idcatalogo=".$numcat." order by cad_idopcion;";
							$rsca=DatosCatalogoDetalle::listaCatalogoDetalle($numcat,"ca_catalogosdetalle");
							$opcionc="";
							if ($rsca) {
								foreach ($rsca as $rowca){
									$opcionc=$opcionc."<option value=".$rowca[cad_idopcion].">".$rowca[cad_descripcionesp]."</option>";
								}
							}
							$tipocampo="<td  height='30' title='".$rowd["red_refinternacinal"]."'><select name='desc".$rowd['red_numcaracteristica2']."' id='desc".$rowd['red_numcaracteristica2']."'>".$opcionc."</select></div></td>";
							break;
						case "E" :
							$tipocampo="<td height='30'  title='".$rowd["red_refinternacinal"]."'><input type='checkbox' name='desc".$rowd['rad_numcaracteristica2']."'></div></td>";
							break;
						default:
							$tipocampo="<td  height='40'  title='".$rowd["red_refinternacinal"]."'><input name='desc".$rowd['red_numcaracteristica2']."' type='text' size='15'></div></td>";
					}
					$estandar="<td  height='40'  title='".$rowd["red_metodopepsi"]."'>".$rowd["red_estandar"]."</td>";
					
				//	$documentoay= "<a href='MEZprincipal.php?op=Tana&admin=impayMB&n=:=".$row["mue_idmuestra"]."' tabindex='-1'><img src='../img/agregar.gif' width='27' height='21' border='0'></a>";
					
				//	$celdadoc="<td class='subtitulo3p'>".$documentoay."</div></td>";
					
					
						$tipocampo=$estandar.$tipocampo."</tr>";
					
					
					
					$this->listaEstandar[]= $cadena.$tipocampo;
					
					$i++;
		}

		
		$this->Nmues=$ntoma;
		
	}
	
 	public function nuevoAnalisisFQ(){
		include "Utilerias/leevar.php";
	
		if ($ncomp) {
			if (!isset($_SESSION['ncomp'])) {
				$_SESSION['ncomp']=$ncomp;
			} else {
				$_SESSION['ncomp']=$ncomp;
			}
		}else {
			$ncomp=$_SESSION['ncomp'];
		}
		
		if ($ntoma) {
			if (!isset($_SESSION['ntoma'])) {
				$_SESSION['ntoma']=$ntoma;
			} else {
				$_SESSION['ntoma']=$ntoma;
			}
		}else {
			$ntoma=$_SESSION['ntoma'];
		}
		
		$this->Nmues=$ntoma;
		
		
		$rss=DatosEst::buscarEstandarMuestra($ntoma,"ins_detalleestandar");
		foreach ($rss as $rows){
			$idserv=$rows["ide_claveservicio"];
			$idcomp=$rows["ide_numcomponente"];
		}
		// busco caracteristicas en abierto detalle
		/*	$sqld="SELECT cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing, cue_reactivosestandardetalle.red_valormin, cue_reactivosestandardetalle.red_valormax, cue_reactivosestandardetalle.red_signouno, cue_reactivosestandardetalle.red_signodos, cue_reactivosestandardetalle.red_ponderacion, cue_reactivosestandardetalle.red_syd, cue_reactivosestandardetalle.red_lugarsyd, cue_reactivosestandardetalle.ser_claveservicio, cue_reactivosestandardetalle.sec_numseccion, cue_reactivosestandardetalle.r_numreactivo, cue_reactivosestandardetalle.re_numcomponente, cue_reactivosestandardetalle.re_numcaracteristica, cue_reactivosestandardetalle.re_numcomponente2, cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_estandar, cue_reactivosestandardetalle.red_tiporeactivo, cue_reactivosestandardetalle.red_grafica, cue_reactivosestandardetalle.red_tipodato, cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_calculoespecial, cue_reactivosestandardetalle.red_tipocalculo, cue_reactivosestandardetalle.red_tipooperador, cue_reactivosestandardetalle.red_posicioncalculo, cue_reactivosestandardetalle.red_tipografica,
		 cue_reactivosestandardetalle.red_metodopepsi,
		 cue_reactivosestandardetalle.red_refinternacinal FROM aa_pruebaanalisis
		 Inner Join cue_reactivosestandardetalle ON aa_pruebaanalisis.pa_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND aa_pruebaanalisis.pa_numprueba = cue_reactivosestandardetalle.red_numcaracteristica2 WHERE cue_reactivosestandardetalle.ser_claveservicio =  '1' AND
		 cue_reactivosestandardetalle.sec_numseccion =  '5' AND aa_pruebaanalisis.pa_tipoanalisis =  'FQ' and cue_reactivosestandardetalle.re_numcomponente=$ncomp";*/
		
		$sqld="SELECT cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing,
 cue_reactivosestandardetalle.red_valormin, cue_reactivosestandardetalle.red_valormax, cue_reactivosestandardetalle.red_signouno,
 cue_reactivosestandardetalle.red_signodos, cue_reactivosestandardetalle.red_ponderacion, cue_reactivosestandardetalle.red_syd, 
cue_reactivosestandardetalle.red_lugarsyd, cue_reactivosestandardetalle.ser_claveservicio, cue_reactivosestandardetalle.sec_numseccion,
 cue_reactivosestandardetalle.r_numreactivo, cue_reactivosestandardetalle.re_numcomponente, cue_reactivosestandardetalle.re_numcaracteristica,
 cue_reactivosestandardetalle.re_numcomponente2, cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_estandar,
 cue_reactivosestandardetalle.red_tiporeactivo, cue_reactivosestandardetalle.red_grafica, cue_reactivosestandardetalle.red_tipodato, 
cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_calculoespecial, cue_reactivosestandardetalle.red_tipocalculo,
 cue_reactivosestandardetalle.red_tipooperador, cue_reactivosestandardetalle.red_posicioncalculo, cue_reactivosestandardetalle.red_tipografica,
 cue_reactivosestandardetalle.red_metodopepsi, cue_reactivosestandardetalle.red_refinternacinal FROM
aa_pruebaanalisis Inner Join cue_reactivosestandardetalle ON aa_pruebaanalisis.pa_numcomponente = cue_reactivosestandardetalle.re_numcomponente 
AND aa_pruebaanalisis.pa_numprueba = cue_reactivosestandardetalle.red_numcaracteristica2 AND aa_pruebaanalisis.pa_numservicio = cue_reactivosestandardetalle.ser_claveservicio
Inner Join cue_secciones ON cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio
 AND cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion
WHERE
cue_reactivosestandardetalle.ser_claveservicio =  :idserv AND
cue_secciones.sec_indagua =  '1' AND
aa_pruebaanalisis.pa_tipoanalisis =  'FQ' AND
cue_reactivosestandardetalle.re_numcomponente =  :idcomp";
		
		$rsd=Conexion::ejecutarQuery($sqld,array("idserv"=>$idserv,"idcomp"=>$idcomp));
		$i=1;
		foreach( $rsd as $rowd){
			if (($i % 2)>0) {
				$tipocampo="<tr><td height='30' class='subtitulo3p'>".$i."</td>";
			} else {
				$tipocampo="<td height='30' class='subtitulo3p'>".$i."</td>";
			}
			//verifico para no poner el campo de volumenes de CO2
			if($idser==1&&$secc=="8.0.2.0.0"&& $rowd["red_numcaracteristica2"]==9)
				continue;
				if($idser==1&&$secc=="8.0.1.0.0"&& $rowd["red_numcaracteristica2"]==9)
					continue;
					$this->listaEstandar[]= $tipocampo."<td  height='30' width='15%' class='subtitulo3p'>
<div align='right'><span class='EtiAreatxt'>".$rowd["red_parametroesp"]." :   "."</div></td>";
					switch ($rowd['red_tipodato']){
						case "C" :
							// busca el catalogo
							$numcat=$rowd['red_clavecatalogo'];
							if ($numcat==12) {
								$sqlca="select * from ca_catalogosdetalle where cad_idcatalogo=:numcat order by IF(cad_idopcion=9,1,cad_idopcion+1);";
							} else if ($numcat==14) {
								$sqlca="select * from ca_catalogosdetalle where cad_idcatalogo=:numcat order by IF(cad_idopcion=6,1,cad_idopcion+1);";
							} else {
								$sqlca="select * from ca_catalogosdetalle where cad_idcatalogo=:numcat order by cad_idopcion;";
							}
							$rsca=Conexion::ejecutarQuery($sqlca,array("numcat"=>$numcat));
							$opcionc="";
							if ($rsca) {
								foreach ($rsca as $rowca){
									$opcionc=$opcionc."<option value=".$rowca[cad_idopcion].">".$rowca[cad_descripcionesp]."</option>";
								}
							}
							$tipocampo="<td  height='30' class='subtitulo3p' title='".$rowd["red_refinternacinal"]."'><div align='center'><select name='desc".$rowd['red_numcaracteristica2']."' id='desc".$rowd['red_numcaracteristica2']."'>".$opcionc."</select></div></td>";
							break;
						case "E" :
							$tipocampo="<td height='30' width='10%' class='subtitulo3p' title='".$rowd["red_refinternacinal"]."'><div align='center'><input type='checkbox' name='desc".$rowd['rad_numcaracteristica2']."'></div></td>";
							break;
						default:
							$tipocampo="<td  height='40' width='10%' class='subtitulo3p' title='".$rowd["red_refinternacinal"]."'><div align='center'><input name='desc".$rowd['red_numcaracteristica2']."' type='text' size='15'></div></td>";
					}
					$estandar="<td  height='40' width='20%' class='subtitulo3p' title='".$rowd["red_metodopepsi"]."'><div align='center'><span class='subtitulo3p'>".$rowd["red_estandar"]."</div></td>";
					
					$documentoay= "<a href='MEZprincipal.php?op=Tana&admin=impayFQ&ntoma=".$rowd["mue_idmuestra"]."' tabindex='-1'><img src='../img/agregar.gif' width='27' height='21' border='0'></a>";
					
					$celdadoc="<td class='subtitulo3p'><div align='center'>".$documentoay."</div></td>";
					
					if (($i % 2)>0) {
						$tipocampo=$estandar.$tipocampo;
					}else{
						$tipocampo=$estandar.$tipocampo."</tr>";
					}
					
					
					$this->listaEstandar[] =$tipocampo;
					
					$i++;
		}
		
		
	
// 		$numtoma = $ntoma;
		
// 		try{
// 		//verifica si no hay registros de resultados para esa pueba
		
// 		$rsca=DatosResultadoAnalisis::getListaResultados($numtoma,"aa_resultadoanalisis");
// 		//var_dump($rsca);
// 		$num_reg = sizeof($rsca);
// 		//echo "+++++++".sizeof($rsca);
// 		// en caso de que no exista, se copia todas las opciones
// 		if ($num_reg ==0){  // inserta nuevos registros
// 			// lee base de reactivos
// 			//	echo "*****";
// 			$rsr=DatosPruebaAnalisis::getPruebaAnalisisxComp($numtoma, "aa_pruebaanalisis");
		
// 			foreach ($rsr as $row){
// 				$numprueba=$row["pa_numprueba"];
// 				$numcomp=$row["pa_numcomponente"];
				
				
// 				DatosResultadoAnalisis::insertResultados($numtoma, $numcomp, $numprueba, "aa_resultadoanalisis");
// 			}
			
// 		}
		
// 		$SQLL="SELECT aa_pruebaanalisis.pa_numprueba, aa_pruebaanalisis.pa_numcomponente, aa_pruebaanalisis.pa_nomprueba,
// aa_resultadoanalisis.mue_idmuestra
//  FROM aa_pruebaanalisis 
// Inner Join aa_resultadoanalisis  ON aa_pruebaanalisis.pa_numprueba = aa_resultadoanalisis.pa_numprueba 
// AND aa_resultadoanalisis.pa_numcomponente = aa_pruebaanalisis.pa_numcomponente
//  WHERE
// aa_resultadoanalisis.mue_idmuestra =  :numtoma AND aa_pruebaanalisis.pa_tipoanalisis =  'FQ' 
// ORDER BY aa_pruebaanalisis.pa_numprueba ASC";
		
// 		$rsdl=Conexion::ejecutarQuery($SQLL, array("numtoma"=>$numtoma));
// 		//var_dump($rsdl);
// 		foreach ($rsdl as $rowd){
			
// 			$this->listaEstandar[]= "<td  height='30' width='50%'class='EtiAreatxt'><span class='EtiAreatxt'>".$rowd["pa_nomprueba"]." :   "."</td>";
			
// 			$tipocampo="<td  height='30' width='60%'><div align='left'><input name='desc".$rowd['pa_numprueba']."' type='text'></div></td>";
// 			$this->listaEstandar[]=  $tipocampo;
		
// 		}
		
//  		}catch(Exception $ex){
//  			Utilerias::mensajeError($ex->mensaje);
//  		}
		
 	}
	
	public function insertarAnalisisMB(){
		include "Utilerias/leevar.php";
	//	$ntoma=$nmuestra;
			
		// busca datos de reporte
		$sqlfq="SELECT ins_detalleestandar.ide_numrenglon, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_claveservicio FROM
ins_detalleestandar Inner Join cue_secciones ON ins_detalleestandar.ide_claveservicio = cue_secciones.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_secciones.sec_numseccion 
WHERE cue_secciones.sec_indagua =  '1' AND
ins_detalleestandar.ide_idmuestra =:ntoma
GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_idmuestra";
				
		$rsfq=Conexion::ejecutarQuery($sqlfq,array("ntoma"=>$ntoma));
		
		if(sizeof($rsfq)!=0) {   // existen resultados de analisis
			foreach ($rsfq as $rownr){
				$numren=$rownr['ide_numrenglon'];
				$numrep=$rownr['ide_numreporte'];
				$idserv=$rownr['ide_claveservicio'];
			}
		}
		$ncomp=$_SESSION['ncomp'];
		$band=0;
		// 1.- Obtengo reactivos
			
		$sqltr=("SELECT cue_reactivosestandardetalle.ser_claveservicio, cue_reactivosestandardetalle.sec_numseccion, cue_reactivosestandardetalle.r_numreactivo, cue_reactivosestandardetalle.re_numcomponente, cue_reactivosestandardetalle.re_numcaracteristica, cue_reactivosestandardetalle.re_numcomponente2, cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_estandar, cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing, cue_reactivosestandardetalle.red_valormin, cue_reactivosestandardetalle.red_valormax, cue_reactivosestandardetalle.red_signouno, cue_reactivosestandardetalle.red_signodos, cue_reactivosestandardetalle.red_ponderacion, cue_reactivosestandardetalle.red_syd, cue_reactivosestandardetalle.red_lugarsyd, cue_reactivosestandardetalle.red_tiporeactivo, cue_reactivosestandardetalle.red_grafica, cue_reactivosestandardetalle.red_tipodato, cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_calculoespecial, cue_reactivosestandardetalle.red_tipocalculo, cue_reactivosestandardetalle.red_tipooperador, cue_reactivosestandardetalle.red_posicioncalculo, cue_reactivosestandardetalle.red_tipografica
FROM cue_reactivosestandardetalle Inner Join aa_pruebaanalisis ON cue_reactivosestandardetalle.re_numcomponente = aa_pruebaanalisis.pa_numcomponente AND cue_reactivosestandardetalle.red_numcaracteristica2 = aa_pruebaanalisis.pa_numprueba AND aa_pruebaanalisis.pa_numservicio = cue_reactivosestandardetalle.ser_claveservicio
Inner Join cue_secciones ON cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio AND cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion
WHERE
cue_reactivosestandardetalle.ser_claveservicio =:idserv AND
cue_secciones.sec_indagua =  '1' AND
cue_reactivosestandardetalle.re_numcomponente =:ncomp AND
aa_pruebaanalisis.pa_tipoanalisis =  'MB'");
		
		//echo $sqltr;
		
		$rsc=Conexion::ejecutarQuery($sqltr,array("idserv"=>$idserv,"ncomp"=>$ncomp));
		
		try{
		foreach ($rsc as $rowc){
			$pondreal=0;
			$aceptado=0;
			$nomcam="desc".$rowc['red_numcaracteristica2'];
			
			if (ctype_space(${$nomcam})) {
				$valcom="";
			} else {
				$valcom=${$nomcam};
				
			}
			
			if($valcom!=""){
				$band=1;
				if (is_numeric($valcom)) {
					
					$siguno=$rowc['red_signouno'];
					if (ctype_space(${$siguno})) {
						$sigunon=0;
					}else{
						$sigunon=${$siguno};
					}
					$idser=$rowc['ser_claveservicio'];
					$idsec=$rowc['sec_numseccion'];
					$numreac=$rowc['r_numreactivo'];
					$numcom=$rowc['re_numcomponente'];
					$numcar=$rowc['re_numcaracteristica'];
					$numcom2=$rowc['re_numcomponente2'];
					$numcar2=$rowc['re_numcaracteristica2'];
					$sigdos=$rowc['red_signodos'];
					$valmin=$rowc['red_valormin'];
					$valmax=$rowc['red_valormax'];
					$valpond=$rowc['red_ponderacion'];
					$numcat=$rowc['red_clavecatalogo'];
					$tipodato=$rowc['red_tipodato'];
					$calesp=$rowc['red_calculoespecial'];
					$tipcalesp=$rowc['red_tipocalculo'];
					$tipoper=$rowc['red_tipooperador'];
					
					
					if ($calesp) {
						switch($tipoper) {
							case "A" :
								$A=$valcom;
								if ($A) {
								}else{
									$A=1;
								}
								break;
							case "B" :
								$B=$valcom;
								if ($B) {
								}else{
									$B=1;
								}
								break;
							case "C" :   //calculo de resultado
								if ($tipcalesp==1) {
									$C=$A/$B;
									
								} else { // busqueda en tabla
									
									$sqlv="select cav_volumen from ca_volumenes where cav_presion=:A and cav_temperatura=:B";
									$rsv=Conexion::ejecutarQuery($sqlv,array("A"=>$A,"B"=>$B));
									$numvol = sizeof($rsv);
									if ($numvol>0){
										foreach ($rsv as $rowv){
											$C=$rowv['cav_volumen'];
										}
									}else{
										$C=0;
									}
								}
								
								$valcom=$C;
								// $descom=$C;
						}
					}
					
					
					// valido si se evalua o no la seccion
					
					$sqlte="select re_tipoevaluacion, `re_numcomponente` 
from cue_reactivosestandar where `re_numcomponente`=:ncomp and `ser_claveservicio`=1 and `sec_numseccion`=5;";
					
					$rsg=Conexion::ejecutarQuery($sqlte,array("ncomp"=>$ncomp));
					$num_reg = sizeof($rsg);
					
					foreach ($rsg as $rowg){
						$tipoeva=$rowg['re_tipoevaluacion'];
					}
					
					switch($tipoeva) {
						case "0" :   // ninguna linea
							switch ($tipodato){
								case "N" :
									if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
										$lvalmin=strlen ($siguno);
										$lvalmax=strlen ($sigdos);
										if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
											if (($valcom > $valmin)  and ($valcom < $valmax)) {
												$pondreal=0;
												$aceptado=-1;
											} else {
												$pondreal=0;
												$aceptado=0;
											}
										} else {
											if (($lvalmin==1) and ($lvalmax==2)) {    // es menorque y mayoro igual que
												if (($valcom > $valmin)  and ($valcom <= $valmax)) {
													$pondreal=0;
													$aceptado=-1;
												} else {
													$pondreal=0;
													$aceptado=0;
												}
											} else {
												if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
													if (($valcom >= $valmin)  and ($valcom < $valmax)) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
												} else {
													if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
														if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
													}   // fin de if 2 y 2
												}  // fin de if 2 y 1
											}   // fin de if 1 y 2
										}
									}else // no existe valor maximo
										//vemos si existe valor minimo
										if ($valmin!=""){
											$lvalmin=strlen ($siguno);
											if ($lvalmin==1) {    // es solo menorque o mayorque
												switch ($siguno) {
													case "=" :
														if ($valcom==$valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
													case "<" :
														if ($valcom < $valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
													case ">" :
														if ($valcom > $valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
												}
											}else{
												switch ($siguno) {
													case "<=" :
														if ($valcom <= $valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
													case ">=" :
														if ($valcom>=$valmin ) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
												}  // fin del switch
											}	// fin de longitud =1
									}
									
									else
									//no tiene estandar
									{
										// $pondreal=0;
										$aceptado=-1;
									}
									break;
								case "C" :
									// busco valor de opcion en catalogo
								
// 									$rscat=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valcom);
// 									foreach ($rowca=mysql_fetch_array($rscat)){
// 										$valop=$rowca[cad_idopcion];
// 									}
									if ($valmin!=""){
										if ($valcom == $valmin) {
											$pondreal=0;
											$aceptado=-1;
										} else {
											$pondreal=0;
											$aceptado=0;
										}
									} else {
										$aceptado=-1;
									}
							}
							break;
						case "1" :   // una linea
							//7echo $tipodato;
							//echo $valcom;
							
							if ($numren==1){ //realiza calculo para uno
								switch ($tipodato){
									case "N" :
										if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
											$lvalmin=strlen ($siguno);
											$lvalmax=strlen ($sigdos);
											//7	 echo $lvalmin;
											//		 echo $lvalmax;
											if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
												if (($valcom > $valmin)  and ($valcom < $valmax)) {
													$pondreal=$valpond;
													$aceptado=-1;
												} else {
													$pondreal=0;
													$aceptado=0;
												}
											} else {
												if (($lvalmin==1) and ($lvalmax==2)) {    // es menorque y mayoro igual que
													if (($valcom > $valmin)  and ($valcom <= $valmax)) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
												} else {
													if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
														if (($valcom >= $valmin)  and ($valcom < $valmax)) {
															$pondreal=$valpond;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
													} else {
														if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
															if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
														}   // fin de if 2 y 2
													}  // fin de if 2 y 1
												}   // fin de if 1 y 2
											}
										}else{  // no existe valor maximo
											//verifico q haya valor minimo
											if($valmin!=""){
												$lvalmin=strlen ($siguno);
												if ($lvalmin==1) {    // es solo menorque o mayorque
													switch ($siguno) {
														case "=" :
															if ($valcom==$valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
														case "<" :
															if ($valcom < $valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
														case ">" :
															if ($valcom > $valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
													}
												}else{
													switch ($siguno) {
														case "<=" :
															//                                            echo $valcom ."<=" .$valmin;
															if ($valcom <= $valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
														case ">=" :
															if ($valcom>=$valmin ) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
													}  // fin del switch
												}	// fin de longitud =1
											}
											else
												$aceptado=-1;
										}
										break;
									case "C" :
										// busco valor de opcion en catalogo
									
										if ($valmin!=""){
											if ($valcom == $valmin) {
												$pondreal=$valpond;
												$aceptado=-1;
											} else {
												$pondreal=0;
												$aceptado=0;
											}
										} else {
											$aceptado=-1;
										}
										break;
								}
							} else {
								$pondreal=0;
								$aceptado=0;
							}   // termina calculo una linea
							
						case "2";  // multilineas
						switch ($tipodato){
							case "N" :
								if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
									$lvalmin=strlen ($siguno);
									$lvalmax=strlen ($sigdos);
									if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
										if (($valcom > $valmin)  and ($valcom < $valmax)) {
											$pondreal=$valpond;
											$aceptado=-1;
										} else {
											$pondreal=0;
											$aceptado=0;
										}
									} else {
										if (($lvalmin==1) and ($lvalmax==2)) {    // es menorque y mayoro igual que
											if (($valcom > $valmin)  and ($valcom <= $valmax)) {
												$pondreal=$valpond;
												$aceptado=-1;
											} else {
												$pondreal=0;
												$aceptado=0;
											}
										} else {
											if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
												if (($valcom >= $valmin)  and ($valcom < $valmax)) {
													$pondreal=$valpond;
													$aceptado=-1;
												} else {
													$pondreal=0;
													$aceptado=0;
												}
											} else {
												if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
													if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
												}   // fin de if 2 y 2
											}  // fin de if 2 y 1
										}   // fin de if 1 y 2
									}
								}else{  // no existe valor maximo
									//verifico valormin
									if($valmin!="")
									{
										$lvalmin=strlen ($siguno);
										if ($lvalmin==1) {    // es solo menorque o mayorque
											switch ($siguno) {
												case "=" :
													if ($valcom==$valmin) {
														$pondreal==$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
												case "<" :
													if ($valcom < $valmin) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
												case ">" :
													if ($valcom > $valmin) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
											}
										}else{
											switch ($siguno) {
												case "<=" :
													//                                            echo $valcom ."<=". $valmin."<br>";
													if ($valcom <= $valmin) {
														//                                               echo "  sip";
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
												case ">=" :
													if ($valcom>=$valmin ) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
											}  // fin del switch
										}	// fin de longitud =1
									}else
										$aceptado=-1;
										
								}
								break;
							case "C" :
								// busco valor de opcion en catalogo
// 								$sqlcat="SELECT * FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '".$numcat."' AND
// ca_catalogosdetalle.cad_idopcion =  '".$valcom."';";
// 								$rscat=mysql_query($sqlcat);
// 								foreach ($rowca=mysql_fetch_array($rscat)){
// 									$valop=$rowca[cad_idopcion];
// 								}
								if ($valmin!=""){
									if ($valcom == $valmin) {
										$pondreal=$valpond;
										$aceptado=-1;
									} else {
										$pondreal=0;
										$aceptado=0;
									}
								} else {
									$aceptado=-1;
								}
								break;
						}
						
					} // termina switch
					
					//		echo $pondreal;
					//  2.- guarda o actualiza la seccion
					// if ($operac=="nueva") {
					$numcar2=$rowc['red_numcaracteristica2'];
					  echo "otra ".$valcom."  --";
					
					if(strlen($valcom)>0){
						   //    echo "otra2 ".$valcom."  --";
// 						$sSQL= "insert into ins_detalleestandar (ide_claveservicio, ide_numreporte, ide_numseccion, ide_numreactivo, ide_numcomponente, ide_numcaracteristica1,
//                             ide_numcaracteristica2, ide_numcaracteristica3, ide_valorreal, ide_numrenglon,ide_ponderacion,ide_aceptado,ide_numcolarc, ide_idmuestra)
//                             values ('".$idser."', ".$numrep.", ".$idsec.", ".$numreac.", ". .", ".$numcar.",
//  ".$numcom2.", ".$numcar2.", '".$valcom."', ".$numren.", ".$pondreal.", ".$aceptado.", 1, $ntoma);";
						$datosController= array("nserv"=>$idser,
								"numrep"=>$numrep,
								"nsec"=>$idsec,
								"nreac"=>$numreac,
								"numcom"=>$numcom,
								"ncar1"=>$numcar,
								"ncom2"=>$numcom2,
								"numcar2"=>$numcar2,
								"valreal"=>$valcom,
								"numren"=>$numren,
								"pond"=>$pondreal,
								"aceptado"=>$aceptado,
								"colarc"=>1,
								"nummues"=>$ntoma
						);
						DatosEst::insertaRepEstandarDetalleToma($datosController, "ins_detalleestandar");
					}
				} //fin del if que valida si es numerico
			} // fin del if que valida si valcom tiene dato
		}  // fin del foreach
		
		//echo $sSQL;
		if ($comengen) { // guarda comentario de seccion
			//valida si el comentario ya existe.
// 			$ssqlco=("SELECT * FROM `ins_secciones` 
// WHERE `ins_secciones`.`is_claveservicio` =  ".$idser.$idser" AND `ins_secciones`.`is_numreporte` =  '".$numrep."' AND `ins_secciones`.`is_numseccion` =  '".$numsecc."'");
			$rsco = DatosSeccion::RegistrosEnSeccion($idserv,$numrep,$numsecc,$ins_secciones);
			$numRowsc = sizeof($rsco);
			$datosController= array("numsec"=>$numsecc,
					"idser"=>$idser,
					"numrep"=>$numrep,
					"valreal"=>null,
					"nivacep"=>null,
					"comentario"=>$comengen
			);
			if ($numRowsc == 0){	//no existe en la base, lo doy de alta
// 				$sSQL= "insert into ins_secciones (is_claveservicio, is_numreporte, is_numseccion, is_comentario)
//  values (".$idser.", ".$numrep.", ".$numsecc.", '".$comengen."');";
			
				DatosSeccion::insertarSeccion($datosController, "ins_secciones");
			} else {    // ya existe el registro
// 				$sSQL=("Update ins_secciones Set is_comentario='".$comengen."' 
// where  is_claveservicio = '".$idser."' and is_numreporte ='".$numrep."' and is_numseccion=:numsecc.";");
			
				DatosSeccion::actualizarSeccion($datosController, "ins_secciones");
			}
		}
		
		if(isset($_SESSION["Usuario"]))
			$recmues= $_SESSION["Usuario"];
			
			$fecvis=date("Y-m-d H:i:s");
			if ($band==1){
				$sqlu="UPDATE aa_muestras SET aa_muestras.mue_nomanalistaMB='$recmues',aa_muestras.mue_fechoranalisisMB='$fecvis', aa_muestras.mue_estatusMB=3 WHERE aa_muestras.mue_idmuestra='$ntoma'";
			
			$rsu=DatosMuestra::actualizarAnalisis($recmues, $fecvis, $ntoma);
			}
			//actualiza estatus de la muestra
			// revisa estatus
		
			$rsp=DatosMuestra::listaMuestrasxIdMuestra($ntoma,"aa_muestras");
			foreach ($rsp as $rowca){
				$valFQ=$rowca["mue_estatusFQ"];
				$valMB=$rowca["mue_estatusMB"];
			}
			//echo $valFQ;
			//echo $valMB;
			
			if ($valFQ==3 && $valMB==3) {
				//echo "si son iguales";
				DatosMuestra::actualizarEstatus(5,$ntoma);
			}
		
		}catch(Exception $ex){
			Utilerias::mensajeError($ex->mensaje);
		}
	}
	
	public function insertarAnalisisFQ(){
		include "Utilerias/leevar.php";
		$ntoma=$nmuestra;
		
	
		
			$sqlfq="SELECT ins_detalleestandar.ide_numrenglon, ins_detalleestandar.ide_numreporte, 
ins_detalleestandar.ide_claveservicio FROM
ins_detalleestandar Inner Join cue_secciones ON ins_detalleestandar.ide_claveservicio = cue_secciones.ser_claveservicio 
AND ins_detalleestandar.ide_numseccion = cue_secciones.sec_numseccion WHERE
cue_secciones.sec_indagua =  '1' AND
ins_detalleestandar.ide_idmuestra =  :ntoma
GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_idmuestra";
		
		
		$rsfq=DatosEst::ConsultaAgua($ntoma);
		if(sizeof($rsfq)!=0) {   // existen resultados de analisis
			foreach ( $rsfq as  $rownr){
				$numren=$rownr['ide_numrenglon'];
				$numrep=$rownr['ide_numreporte'];
				$idserv=$rownr['ide_claveservicio'];
			}
		}
		$ncomp=$_SESSION['ncomp'];
		$band=0;
		// 1.- Obtengo reactivos
		
		$sqltr=("SELECT cue_reactivosestandardetalle.ser_claveservicio, cue_reactivosestandardetalle.sec_numseccion, 
cue_reactivosestandardetalle.r_numreactivo, cue_reactivosestandardetalle.re_numcomponente, 
cue_reactivosestandardetalle.re_numcaracteristica, cue_reactivosestandardetalle.re_numcomponente2, 
cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_estandar,
 cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing,
 cue_reactivosestandardetalle.red_valormin, cue_reactivosestandardetalle.red_valormax, cue_reactivosestandardetalle.red_signouno,
 cue_reactivosestandardetalle.red_signodos, cue_reactivosestandardetalle.red_ponderacion, cue_reactivosestandardetalle.red_syd,
 cue_reactivosestandardetalle.red_lugarsyd, cue_reactivosestandardetalle.red_tiporeactivo, cue_reactivosestandardetalle.red_grafica, 
cue_reactivosestandardetalle.red_tipodato, cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_calculoespecial, 
cue_reactivosestandardetalle.red_tipocalculo, cue_reactivosestandardetalle.red_tipooperador, cue_reactivosestandardetalle.red_posicioncalculo,
 cue_reactivosestandardetalle.red_tipografica
FROM cue_reactivosestandardetalle 
Inner Join aa_pruebaanalisis ON cue_reactivosestandardetalle.re_numcomponente = aa_pruebaanalisis.pa_numcomponente 
AND cue_reactivosestandardetalle.red_numcaracteristica2 = aa_pruebaanalisis.pa_numprueba AND aa_pruebaanalisis.pa_numservicio = cue_reactivosestandardetalle.ser_claveservicio
Inner Join cue_secciones ON cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio AND cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion
WHERE
cue_reactivosestandardetalle.ser_claveservicio =:idserv AND
cue_secciones.sec_indagua =  '1' AND
cue_reactivosestandardetalle.re_numcomponente =:ncomp AND
aa_pruebaanalisis.pa_tipoanalisis =  'FQ'");
		
		//echo $sqltr;
		try{
		$rsc=Conexion::ejecutarQuery($sqltr, array("idserv"=>$idserv,"ncomp"=>$ncomp));
		foreach ($rsc as $rowc){
			$pondreal=0;
			$aceptado=0;
			$nomcam="desc".$rowc['red_numcaracteristica2'];
			
			if (ctype_space(${$nomcam})) {
				$valcom="";
			} else {
				$valcom=${$nomcam};
				
			}
			
			if($valcom!=""){
				$band=1;
				if (is_numeric($valcom)) {
					
					$siguno=$rowc['red_signouno'];
					if (ctype_space(${$siguno})) {
						$sigunon=0;
					}else{
						$sigunon=${$siguno};
					}
					$idser=$rowc['ser_claveservicio'];
					$idsec=$rowc['sec_numseccion'];
					$numreac=$rowc['r_numreactivo'];
					$numcom=$rowc['re_numcomponente'];
					$numcar=$rowc['re_numcaracteristica'];
					$numcom2=$rowc['re_numcomponente2'];
					$numcar2=$rowc['re_numcaracteristica2'];
					$sigdos=$rowc['red_signodos'];
					$valmin=$rowc['red_valormin'];
					$valmax=$rowc['red_valormax'];
					$valpond=$rowc['red_ponderacion'];
					$numcat=$rowc['red_clavecatalogo'];
					$tipodato=$rowc['red_tipodato'];
					$calesp=$rowc['red_calculoespecial'];
					$tipcalesp=$rowc['red_tipocalculo'];
					$tipoper=$rowc['red_tipooperador'];
					
					
					if ($calesp) {
						switch($tipoper) {
							case "A" :
								$A=$valcom;
								if ($A) {
								}else{
									$A=1;
								}
								break;
							case "B" :
								$B=$valcom;
								if ($B) {
								}else{
									$B=1;
								}
								break;
							case "C" :   //calculo de resultado
								if ($tipcalesp==1) {
									$C=$A/$B;
									
								} else { // busqueda en tabla
									
									$sqlv="select cav_volumen 
from ca_volumenes where cav_presion=".$A." and cav_temperatura=".$B.";";
									$rsv=Conexion::ejecutarQuery($sqlv,array("A"=>$A,"B"=>$B));
									
									$numvol = sizeof($rsv);
									if ($numvol>0){
										foreach ($rsv as $rowv){
											$C=$rowv['cav_volumen'];
										}
									}else{
										$C=0;
									}
								}
								
								$valcom=$C;
								// $descom=$C;
						}
					}
					
					
					// valido si se evalua o no la seccion
					
					$sqlte="select re_tipoevaluacion, `re_numcomponente`
 from cue_reactivosestandar where `re_numcomponente`=:ncomp and `ser_claveservicio`=1 
and `sec_numseccion`=5;";
					
					$rsg=Conexion::ejecutarQuery($sqlte,array("ncomp"=>$ncomp));
					$num_reg = sizeof($rsg);
					
					foreach ($rsg as $rowg){
						$tipoeva=$rowg['re_tipoevaluacion'];
					}
					
					switch($tipoeva) {
						case "0" :   // ninguna linea
							switch ($tipodato){
								case "N" :
									if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
										$lvalmin=strlen ($siguno);
										$lvalmax=strlen ($sigdos);
										if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
											if (($valcom > $valmin)  and ($valcom < $valmax)) {
												$pondreal=0;
												$aceptado=-1;
											} else {
												$pondreal=0;
												$aceptado=0;
											}
										} else {
											if (($lvalmin==1) and ($lvalmax==2)) {    // es menorque y mayoro igual que
												if (($valcom > $valmin)  and ($valcom <= $valmax)) {
													$pondreal=0;
													$aceptado=-1;
												} else {
													$pondreal=0;
													$aceptado=0;
												}
											} else {
												if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
													if (($valcom >= $valmin)  and ($valcom < $valmax)) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
												} else {
													if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
														if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
													}   // fin de if 2 y 2
												}  // fin de if 2 y 1
											}   // fin de if 1 y 2
										}
									}else // no existe valor maximo
										//vemos si existe valor minimo
										if ($valmin!=""){
											$lvalmin=strlen ($siguno);
											if ($lvalmin==1) {    // es solo menorque o mayorque
												switch ($siguno) {
													case "=" :
														if ($valcom==$valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
													case "<" :
														if ($valcom < $valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
													case ">" :
														if ($valcom > $valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
												}
											}else{
												switch ($siguno) {
													case "<=" :
														if ($valcom <= $valmin) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
													case ">=" :
														if ($valcom>=$valmin ) {
															$pondreal=0;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
														break;
												}  // fin del switch
											}	// fin de longitud =1
									}
									
									else
									//no tiene estandar
									{
										// $pondreal=0;
										$aceptado=-1;
									}
									break;
								case "C" :
									// busco valor de opcion en catalogo
	
									$valop=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valcom);
									
									if ($valmin!=""){
										if ($valop == $valmin) {
											$pondreal=0;
											$aceptado=-1;
										} else {
											$pondreal=0;
											$aceptado=0;
										}
									} else {
										$aceptado=-1;
									}
							}
							break;
						case "1" :   // una linea
							//7echo $tipodato;
							//echo $valcom;
							
							if ($numren==1){ //realiza calculo para uno
								switch ($tipodato){
									case "N" :
										if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
											$lvalmin=strlen ($siguno);
											$lvalmax=strlen ($sigdos);
											//7	 echo $lvalmin;
											//		 echo $lvalmax;
											if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
												if (($valcom > $valmin)  and ($valcom < $valmax)) {
													$pondreal=$valpond;
													$aceptado=-1;
												} else {
													$pondreal=0;
													$aceptado=0;
												}
											} else {
												if (($lvalmin==1) and ($lvalmax==2)) {    // es menorque y mayoro igual que
													if (($valcom > $valmin)  and ($valcom <= $valmax)) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
												} else {
													if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
														if (($valcom >= $valmin)  and ($valcom < $valmax)) {
															$pondreal=$valpond;
															$aceptado=-1;
														} else {
															$pondreal=0;
															$aceptado=0;
														}
													} else {
														if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
															if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
														}   // fin de if 2 y 2
													}  // fin de if 2 y 1
												}   // fin de if 1 y 2
											}
										}else{  // no existe valor maximo
											//verifico q haya valor minimo
											if($valmin!=""){
												$lvalmin=strlen ($siguno);
												if ($lvalmin==1) {    // es solo menorque o mayorque
													switch ($siguno) {
														case "=" :
															if ($valcom==$valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
														case "<" :
															if ($valcom < $valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
														case ">" :
															if ($valcom > $valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
													}
												}else{
													switch ($siguno) {
														case "<=" :
															//                                            echo $valcom ."<=" .$valmin;
															if ($valcom <= $valmin) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
														case ">=" :
															if ($valcom>=$valmin ) {
																$pondreal=$valpond;
																$aceptado=-1;
															} else {
																$pondreal=0;
																$aceptado=0;
															}
															break;
													}  // fin del switch
												}	// fin de longitud =1
											}
											else
												$aceptado=-1;
										}
										break;
									case "C" :
										// busco valor de opcion en catalogo
										
										$valop=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valcom);
										
										
										if ($valmin!=""){
											if ($valop == $valmin) {
												$pondreal=$valpond;
												$aceptado=-1;
											} else {
												$pondreal=0;
												$aceptado=0;
											}
										} else {
											$aceptado=-1;
										}
										break;
								}
							} else {
								$pondreal=0;
								$aceptado=0;
							}   // termina calculo una linea
							
						case "2";  // multilineas
						switch ($tipodato){
							case "N" :
								if ($valmax!="") {  // valido en un rango de dos valores  signo uno debe ser <= y signo dos debe ser >=
									$lvalmin=strlen ($siguno);
									$lvalmax=strlen ($sigdos);
									if (($lvalmin==1) and ($lvalmax==1)) {    // es solo menorque y mayorque
										if (($valcom > $valmin)  and ($valcom < $valmax)) {
											$pondreal=$valpond;
											$aceptado=-1;
										} else {
											$pondreal=0;
											$aceptado=0;
										}
									} else {
										if (($lvalmin==1) and ($lvalmax==2)) {    // es menorque y mayoro igual que
											if (($valcom > $valmin)  and ($valcom <= $valmax)) {
												$pondreal=$valpond;
												$aceptado=-1;
											} else {
												$pondreal=0;
												$aceptado=0;
											}
										} else {
											if (($lvalmin==2) and ($lvalmax==1)) {    // es menorque y mayoro igual que
												if (($valcom >= $valmin)  and ($valcom < $valmax)) {
													$pondreal=$valpond;
													$aceptado=-1;
												} else {
													$pondreal=0;
													$aceptado=0;
												}
											} else {
												if (($lvalmin==2) and ($lvalmax==2)) {    // es menorque y mayoro igual que
													if (($valcom >= $valmin)  and ($valcom <= $valmax)) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
												}   // fin de if 2 y 2
											}  // fin de if 2 y 1
										}   // fin de if 1 y 2
									}
								}else{  // no existe valor maximo
									//verifico valormin
									if($valmin!="")
									{
										$lvalmin=strlen ($siguno);
										if ($lvalmin==1) {    // es solo menorque o mayorque
											switch ($siguno) {
												case "=" :
													if ($valcom==$valmin) {
														$pondreal==$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
												case "<" :
													if ($valcom < $valmin) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
												case ">" :
													if ($valcom > $valmin) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
											}
										}else{
											switch ($siguno) {
												case "<=" :
													//                                            echo $valcom ."<=". $valmin."<br>";
													if ($valcom <= $valmin) {
														//                                               echo "  sip";
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
												case ">=" :
													if ($valcom>=$valmin ) {
														$pondreal=$valpond;
														$aceptado=-1;
													} else {
														$pondreal=0;
														$aceptado=0;
													}
													break;
											}  // fin del switch
										}	// fin de longitud =1
									}else
										$aceptado=-1;
										
								}
								break;
							case "C" :
								// busco valor de opcion en catalogo
								
								$valop=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valcom);
								
								
								if ($valmin!=""){
									if ($valop == $valmin) {
										$pondreal=$valpond;
										$aceptado=-1;
									} else {
										$pondreal=0;
										$aceptado=0;
									}
								} else {
									$aceptado=-1;
								}
								break;
						}
						
					} // termina switch
					
					//		echo $pondreal;
					//  2.- guarda o actualiza la seccion
					// if ($operac=="nueva") {
					$numcar2=$rowc['red_numcaracteristica2'];
					//  echo "otra ".$valcom."  --";
					
					if(strlen($valcom)>0){
						//       echo "otra2 ".$valcom."  --";
					
						
						$datosModel["idser"]=$idser;
						$datosModel["numrep"]=$numrep;
						$datosModel["numsec"]=$idsec;
						$datosModel["numreac"]=$numreac;
						$datosModel["numcom"]=$numcom;
						$datosModel["numcar"]=$numcar;
						$datosModel["numcom2"]=$numcom2;
						$datosModel["numcar2"]=$numcar2;
						$datosModel["valcom"]=$valcom;
						 $datosModel["numren"]=$numren;
						 $datosModel["pondreal"]=$pondreal;
						 $datosModel["aceptado"]=$aceptado;
					 $datosModel["numcolar"]=1;
					 $datosModel["ntoma"]=$ntoma;
						
					 DatosEst::insertaRepEstandarDetalleToma($datosModel, "ins_detalleestandar");
					}
				} //fin del if que valida si es numerico
			} // fin del if que valida si valcom tiene dato
		}  // fin del foreach
		
		//echo $sSQL;
		if ($comengen) { // guarda comentario de seccion
			//valida si el comentario ya existe.
			
			$rsco = DatosSeccion::RegistrosEnSeccion($idser, $numsecc, $numrep, "ins_secciones");
			$numRowsc = sizeof($rsco);
			
		}
		
		if(isset($_SESSION["Usuario"]))
			$recmues= $_SESSION["Usuario"];
			
			$fecvis=date("Y-m-d H:i:s");
			if ($band==1){
				$rsu=DatosMuestra::actualizarAnalisisFQ($recmues, $fecvis, $ntoma);
				
			}
			
			//actualiza estatus de la muestra
			// revisa estatus
			$sqlp="SELECT aa_muestras.mue_estatusFQ, aa_muestras.mue_estatusMB 
FROM aa_muestras WHERE aa_muestras.mue_idmuestra =:ntoma'";
			$rsp=DatosMuestra::listaMuestrasxIdMuestra($ntoma, "aa_muestras");
			foreach ($rsp as $rowca){
				$valFQ=$rowca["mue_estatusFQ"];
				$valMB=$rowca["mue_estatusMB"];
			}
			//echo $valFQ;
			//echo $valMB;
			
			if ($valFQ==3 && $valMB==3) {
				//echo "si son iguales";
				$sqla="UPDATE aa_muestras SET aa_muestras.mue_estatusmuestra=5 WHERE aa_muestras.mue_idmuestra='$ntoma'";
				$rsu=DatosMuestra::actualizarEstatus(5,$ntoma);
			}
		}catch (Exception $ex){
			Utilerias::mensajeError($ex->getMessage());
		}
			
	}
	/**
	 * @return mixed
	 */
	public function getListaEstandar() {
		return $this->listaEstandar;
	}

	/**
	 * @return mixed
	 */
	public function getTITULO() {
		return $this->TITULO;
	}

	/**
	 * @return mixed
	 */
	public function getTITULO2() {
		return $this->TITULO2;
	}

	/**
	 * @return mixed
	 */
	public function getTITULO4() {
		return $this->TITULO4;
	}

	/**
	 * @return string
	 */
	public function getTITULO5() {
		return $this->TITULO5;
	}

	/**
	 * @return mixed
	 */
	public function getNtoma() {
		return $this->ntoma;
	}

	/**
	 * @return mixed
	 */
	public function getNumcom() {
		return $this->numcom;
	}

	/**
	 * @return string
	 */
	public function getNUMREP() {
		return $this->NUMREP;
	}

	/**
	 * @return string
	 */
	public function getFechaVisita() {
		return $this->FechaVisita;
	}

	/**
	 * @return mixed
	 */
	public function getListaAtributos() {
		return $this->listaAtributos;
	}
	/**
	 * @return string
	 */
	public function getBotnvo() {
		return $this->botnvo;
	}
	/**
	 * @return mixed
	 */
	public function getNmues() {
		return $this->Nmues;
	}

	
	


	
	
	
}

