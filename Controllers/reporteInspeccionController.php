<?php

require('libs/fpdf/fpdf.php');
require "Models/crud_catalogoDetalle.php";
require "Utilerias/utilerias.php";

require_once ('libs/php-gettext-1.0.12/gettext.inc');
define('RAIZ',"fotografias");

error_reporting(E_ALL);


class ReporteInspeccion {
	public $tache;
	public $paloma;
	
	public function vistaReporte(){
		include "Utilerias/leevar.php";
		
		
		$this->tache = 'img/tache.png';
		$this->paloma='img/palomita.png';
		
		$a=html_entity_decode("&aacute;");
		$e=html_entity_decode("&eacute;");
		$i=html_entity_decode("&iacute;");
		$o=utf8_decode("&oacute;");
		$u=html_entity_decode("&uacute;");
		$n=utf8_decode("&ntilde;");
	
	
		$pdf=new PDF('p','mm','letter');
	
		// PAGINA 1
	
		$pdf->AddPage();
	
		// RECUADRO GENERAL
		$pdf->SetFillColor(152,185,235);
		$pdf->Rect(10,56,200,14,F);
		$pdf->Rect(10,75,200,44,F);
		$pdf->Rect(10,125,200,14,F);
		$pdf->Rect(10,145,200,22,F);
		$pdf->Rect(10,190,200,32,F);
		//$pdf->Rect(10,171,200,51,F);
		
	
		// SUBTITULOS
		$pdf->SetY(50);
		$pdf->SetX(18);
		$pdf->ChapterTitle('DATOS DEL PUNTO DE VENTA');
		
		$pdf->SetY(184);
		$pdf->SetX(16);
		$pdf->ChapterTitle('DATOS DE LA VISITA');
		
		//**** ETIQUETAS
		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(184,211,235);
		$pdf->Rect(15,58,35,4,F);
		$pdf->SetY(58);
		$pdf->SetX(23);
		
		$pdf->Cell(25,4,'NO. DE REPORTE', 0, 'R' , TRUE);
		
		$pdf->Rect(15,64,35,4,F);
		$pdf->SetY(64);
		$pdf->SetX(23);
		$pdf->Cell(25,4,'PUNTO DE VENTA', 0, 'R' , TRUE);
		
		$pdf->Rect(112,58,35,4,F);
		$pdf->SetY(58);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'FECHA DE EMISION ', 0 ,'R', TRUE);
		
		$pdf->Rect(112,64,35,4,F);
		$pdf->SetY(64);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'ID CLIENTE ', 0 ,'R', TRUE);
		
		// RECUADRO DOS
		$pdf->Rect(15,77,35,4,F);
		$pdf->SetY(77);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'CALLE', 0, 'R' , TRUE);
		
		$pdf->Rect(15,83,35,4,F);
		$pdf->SetY(83);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'NO. EXTERIOR', 0, 'R' , TRUE);
		
		$pdf->Rect(15,89,35,4,F);
		$pdf->SetY(89);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'NO. INTERIOR', 0, 'R' , TRUE);
		
		$pdf->Rect(15,95,35,4,F);
		$pdf->SetY(95);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'MANZANA', 0, 'R' , TRUE);
		
		$pdf->Rect(15,101,35,4,F);
		$pdf->SetY(101);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'LOTE', 0, 'R' , TRUE);
		
		$pdf->Rect(15,107,35,4,F);
		$pdf->SetY(107);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'COLONIA', 0, 'R' , TRUE);
		
		$pdf->Rect(15,113,35,4,F);
		$pdf->SetY(113);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'REFERENCIA', 0, 'R' , TRUE);
		
		$pdf->Rect(112,77,35,4,F);
		$pdf->SetY(77);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'DELEGACION', 0 ,'R', TRUE);
		
		$pdf->Rect(112,83,35,4,F);
		$pdf->SetY(83);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'C.P.', 0 ,'R', TRUE);
		
		$pdf->Rect(112,89,35,4,F);
		$pdf->SetY(89);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'CIUDAD', 0 ,'R', TRUE);
		
		$pdf->Rect(112,95,35,4,F);
		$pdf->SetY(95);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'ESTADO', 0 ,'R', TRUE);
		
		$pdf->Rect(112,101,35,4,F);
		$pdf->SetY(101);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'TELEFONO', 0 ,'R', TRUE);
		
		$pdf->Rect(112,107,35,4,F);
		$pdf->SetY(107);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'COORDENADAS XY', 0 ,'R', TRUE);
		
		// RECUADRO TRES
		$pdf->Rect(15,130,35,4,F);
		$pdf->SetY(130);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'CUENTA', 0, 'R' , TRUE);
		
		
		$pdf->Rect(112,130,35,4,F);
		$pdf->SetY(130);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'FRANQUICIA', 0 ,'R', TRUE);
		
		
		
		
		// RECUADRO CUATRO
		$pdf->Rect(15,148,35,4,F);
		$pdf->SetY(148);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'COMPANIA', 0, 'R' , TRUE);
		
		$pdf->Rect(15,154,35,4,F);
		$pdf->SetY(154);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'UNIDAD DE NEGOCIO', 0, 'R' , TRUE);
			
		$pdf->Rect(15,160,35,4,F);
		$pdf->SetY(160);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'FRANQUICIA', 0, 'R' , TRUE);
		
		$pdf->Rect(112,148,35,4,F);
		$pdf->SetY(148);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'REGION', 0 ,'R', TRUE);
		
		$pdf->Rect(112,154,35,4,F);
		$pdf->SetY(154);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'ESTADO', 0 ,'R', TRUE);
		
		$pdf->Rect(112,160,35,4,F);
		$pdf->SetY(160);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'CIUDAD', 0 ,'R', TRUE);
		
		// RECUADRO CUATRO
		$pdf->Rect(15,194,35,4,F);
		$pdf->SetY(194);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'FECHA DE VISITA', 0, 'R' , TRUE);
		
		$pdf->Rect(15,200,35,4,F);
		$pdf->SetY(200);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'AUDITOR', 0, 'R' , TRUE);
		
		$pdf->Rect(15,206,35,4,F);
		$pdf->SetY(206);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'CONTACTO', 0, 'R' , TRUE);
		
		$pdf->Rect(15,212,35,4,F);
		$pdf->SetY(212);
		$pdf->SetX(23);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(25,4,'PUESTO', 0, 'R' , TRUE);
		
		
		
		$pdf->Rect(112,194,35,4,F);
		$pdf->SetY(194);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'ENTRADA', 0 ,'R', TRUE);
		
		$pdf->Rect(112,200,35,4,F);
		$pdf->SetY(200);
		$pdf->SetX(121);
		
		$pdf->Cell(25,4,'TOMA MUESTRA', 0 ,'R', TRUE);
		
		$pdf->Rect(112,206,35,4,F);
		$pdf->SetY(206);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'SALIDA', 0 ,'R', TRUE);
		
		$pdf->Rect(112,212,35,4,F);
		$pdf->SetY(212);
		$pdf->SetX(121);
		$pdf->Cell(25,4,'MES ASIGNACION', 0 ,'R', TRUE);
		
		
	
		// datos rectangulo
		$pdf->SetFillColor(216,231,243);
		$pdf->Rect(147,92,60,4,F);
		
		
		$ssql="SELECT  ca_unegocios.cue_clavecuenta, 
ca_unegocios.une_id, ca_unegocios.une_descripcion, ca_unegocios.une_idpepsi,
 ca_unegocios.une_idcuenta, ca_unegocios.une_dir_calle, ca_unegocios.une_dir_numeroext,
 ca_unegocios.une_dir_numeroint, ca_unegocios.une_dir_manzana, ca_unegocios.une_dir_lote,
 ca_unegocios.une_dir_colonia, ca_unegocios.une_dir_delegacion, ca_unegocios.une_dir_municipio,
 ca_unegocios.une_dir_estado, ca_unegocios.une_dir_cp, ca_unegocios.une_dir_referencia, 
ca_unegocios.une_dir_telefono, ca_unegocios.une_cla_region, ca_unegocios.une_cla_pais, 
ca_unegocios.une_cla_zona, ca_unegocios.une_coordenadasxy, ins_generales.i_fechavisita,
ins_generales.i_mesasignacion, ins_generales.i_horaentradavis, ins_generales.i_horasalidavis,
 ins_generales.i_responsablevis, ins_generales.i_puestoresponsablevis, ins_generales.i_numreporte,
 ca_nivel6.n6_nombre, ca_nivel5.n5_nombre, ca_nivel4.n4_nombre, ca_nivel3.n3_nombre,
 ca_nivel2.n2_nombre, ca_nivel1.n1_nombre, ins_generales.i_horaanalisissensorial,
 ins_generales.i_reportecic, ins_generales.i_numreportecic,    ins_generales.i_fechafinalizado, 
if( ins_generales.i_fechafinalizado<='2015/06/30',1,2) as estatusfin, ca_inspectores.ins_nombre,
 ca_unegocios.fc_idfranquiciacta, ca_cuentas.cue_descripcion, ca_franquiciascuenta.cf_descripcion
 FROM
   `ins_generales`
    INNER JOIN `ca_unegocios` 
        ON (`ins_generales`.`i_unenumpunto` = `ca_unegocios`.`une_id`)
    INNER JOIN `ca_inspectores` 
        ON (`ins_generales`.`i_claveinspector` = `ca_inspectores`.`ins_clave`)
    INNER JOIN `ca_cuentas` 
        ON (`ca_unegocios`.`cue_clavecuenta` = `ca_cuentas`.`cue_id`)
    INNER JOIN `ca_franquiciascuenta` 
        ON (`ca_unegocios`.`cue_clavecuenta` = `ca_franquiciascuenta`.`cue_clavecuenta`) AND (`ca_unegocios`.`fc_idfranquiciacta` = `ca_franquiciascuenta`.`fc_idfranquiciacta`)
    INNER JOIN `ca_nivel1` ON `n1_id`=`une_cla_region` 
    INNER JOIN `ca_nivel2` 
        ON (`ca_nivel1`.`n1_id` = `ca_nivel2`.`n2_idn1`)
    INNER JOIN  `ca_nivel3` 
        ON (`ca_nivel2`.`n2_id` = `ca_nivel3`.`n3_idn2`)
    INNER JOIN  `ca_nivel4` 
        ON (`ca_nivel3`.`n3_id` = `ca_nivel4`.`n4_idn3`)
    INNER JOIN  `ca_nivel5` 
        ON (`ca_nivel4`.`n4_id` = `ca_nivel5`.`n5_idn4`)
    INNER JOIN  `ca_nivel6` 
        ON (`ca_nivel5`.`n5_id` = `ca_nivel6`.`n6_idn5`) 
        AND (`ca_cuentas`.`cue_idcliente` = `ca_franquiciascuenta`.`cli_idcliente`) AND `une_cla_franquicia`=`n6_id`
        WHERE `i_claveservicio`=:vservicio AND `i_numreporte`=:numrep";
		$vservicio=$sv;
		$resp= Conexion::ejecutarQuery($ssql,array("vservicio"=>$vservicio,"numrep"=>$numrep));
	
		//echo $treg;
		foreach($resp as $row) {
			$estatusfin= $row["estatusfin"];
			
			$pdf->SetFont('Arial','',8);
			
		$pdf->SetY(58);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["i_numreporte"], 0, 'L' , TRUE);
		
		$pdf->SetY(64);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["une_descripcion"], 0, 'L' , TRUE);
		
		$pdf->SetY(58);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,Utilerias::formato_fecha($row["i_fechavisita"]), 0, 'L' , TRUE);
		
		$pdf->SetY(64);
		$pdf->SetX(147);
		$pdf->multicell(60,4,$row["une_idpepsi"], 0, 'L' , TRUE);
		
		
		$pdf->SetY(77);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,utf8_decode($row["une_dir_calle"]), 0, 'L' , TRUE);
		
		$pdf->SetY(83);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["une_dir_numeroext"], 0, 'L' , TRUE);
		
		$pdf->SetY(89);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["une_dir_numeroint"], 0, 'L' , TRUE);
		
		$pdf->SetY(95);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["une_dir_manzana"], 0, 'L' , TRUE);
		
		$pdf->SetY(101);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["une_dir_lote"], 0, 'L' , TRUE);
		
		$pdf->SetY(107);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["une_dir_colonia"], 0, 'L' , TRUE);
		
		$pdf->SetY(113);
		$pdf->SetX(50);
		$pdf->multiCell(157,4,$row["une_dir_referencia"], 0, 'L' , TRUE);
		
		$pdf->SetY(77);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["une_dir_delegacion"], 0, 'L' , TRUE);
		
		$pdf->SetY(83);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["une_dir_cp"], 0, 'L' , TRUE);
		
		$pdf->SetY(89);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["une_dir_municipio"], 0, 'L' , TRUE);
		
		$pdf->SetY(95);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["une_dir_estado"], 0, 'L' , TRUE);
		
		$pdf->SetY(101);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["une_dir_telefono"], 0, 'L' , TRUE);
		
		$pdf->SetY(107);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["une_coordenadasxy"], 0, 'L' , TRUE);
		
		//DATOS DE LA FRANQUICIA
		$pdf->SetY(130);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["cue_descripcion"], 0, 'L' , TRUE);
		
		
		$pdf->SetY(130);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["cf_descripcion"], 0, 'L' , TRUE);
		
		$pdf->SetY(148);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["n1_nombre"], 0, 'L' , TRUE);
		
		$pdf->SetY(154);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["n2_nombre"], 0, 'L' , TRUE);
		
		$pdf->SetY(160);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["n3_nombre"], 0, 'L' , TRUE);
		
		$pdf->SetY(148);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["n4_nombre"], 0, 'L' , TRUE);
		
		$pdf->SetY(154);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["n5_nombre"], 0, 'L' , TRUE);
		
		$pdf->SetY(160);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["n6_nombre"], 0, 'L' , TRUE);
		
		
		$pdf->SetY(194);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,Utilerias::formato_fecha($row["i_fechavisita"]), 0, 'L' , TRUE);
		$pdf->SetY(200);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["ins_nombre"], 0, 'L' , TRUE);
		$pdf->SetY(206);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["i_responsablevis"], 0, 'L' , TRUE);
		$pdf->SetY(212);
		$pdf->SetX(50);
		$pdf->multiCell(60,4,$row["i_puestoresponsablevis"], 0, 'L' , TRUE);
		
		$pdf->SetY(194);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["i_horaentradavis"], 0, 'L' , TRUE);
		
		$pdf->SetY(200);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["i_horaanalisissensorial"], 0, 'L' , TRUE);
		
		$pdf->SetY(206);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["i_horasalidavis"], 0, 'L' , TRUE);
		
		$pdf->SetY(212);
		$pdf->SetX(147);
		$pdf->multiCell(60,4,$row["i_mesasignacion"], 0, 'L' , TRUE);
		
	}
	
	
	// pagina 2
	$pdf->AddPage();
	// SUBTITULOS
	$seccion=1;
	$i=70;
	
	for ($seccion=1; $seccion<3; $seccion++) {
		
		$tit_secciones = array(T_('CALIDAD DE LA BEBIDA'), T_('PRESIONES DE OPERACION'), T_('BUENOS HABITOS DE MANUFACTURA'));
		
		$pdf->SetY($i);
		$pdf->SetX(16);
		$pdf->ChapterTitle($tit_secciones [$seccion-1]);
		
		$pdf->SetFillColor(152,185,235);
		$pdf->Rect(10,$i+7,200,10,F);
		
		if ($seccion>=2) {
			$pdf->Rect(10,$i+20,200,51,F);
		} else {
			$pdf->Rect(10,$i+20,200,39,F);
		}
		
		//**** ETIQUETAS
		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(184,211,235);
		
		$pdf->Rect(15,$i+9,80,6,F);
		$pdf->SetY($i+10);
		$pdf->SetX(23);
		$pdf->Cell(40,4,'ATRIBUTO', 0, 'R' , TRUE);
		
		$pdf->Rect(97,$i+9,46,6,F);
		$pdf->SetY($i+10);
		$pdf->SetX(82);
		$pdf->Cell(45,4,'ESTANDAR', 0, 'R' , TRUE);
		
		$pdf->Rect(145,$i+9,60,6,F);
		$pdf->SetY($i+10);
		$pdf->SetX(157);
		$pdf->Cell(40,4,'CUMPLIMIENTO DEL ESTANDAR', 0, 'R' , TRUE);
		if ($seccion>=2) {
			$i=$i+75;
		} else {
			$i=$i+90;
		}
	}
	
	
	
	// DESPLIEGA DATOS
	//calidad de la bebida
	$pdf->SetFont('Arial','',8);
	$sec_calbebida = array('8.0.2.6', '8.0.2.9');
	$i=93;
	$pdf->SetFillColor(184,211,235);
	foreach ($sec_calbebida as $sec) {
		$rs_cal_b = $this->cumplimientoEstandar($vservicio, $sec, $numrep);
		$pdf->Rect(15,$i,80,10,F);
		$pdf->SetY($i+3);
		$pdf->SetX(17);
		$pdf->multiCell(78,4,$rs_cal_b [0], 0, 'C' , TRUE);
		
		$pdf->Rect(97,$i,46,10,F);
		$pdf->SetY($i+3);
		$pdf->SetX(99);
		$pdf->multiCell(44,4,$rs_cal_b [1], 0, 'C' , TRUE);
		
		$pdf->Rect(145,$i,60,10,F);
		if ($rs_cal_b [2]==""){
		} else{
			$pdf->Image($rs_cal_b [2],173,$i+3,5,5);
		}
		$i=$i+12;
	} //end //for each
	
	// agrega proporcion
	
	$resultado = $this->cumplimientoProporcion($vservicio, '8.0.1.9', $numrep);
	$pdf->Rect(15,$i,80,10,F);
	$pdf->SetY($i+3);
	$pdf->SetX(17);
	$pdf->multiCell(78,4,$resultado [0], 0, 'C' , TRUE);
	
	$pdf->Rect(97,$i,46,10,F);
	$pdf->SetY($i+3);
	$pdf->SetX(99);
	$pdf->multiCell(44,4,$resultado [1], 0, 'C' , TRUE);
	
	$pdf->Rect(145,$i,60,10,F);
	if ($resultado [2]==""){
	}else{
		$pdf->Image($resultado [2],173,$i+3,5,5);
	}
	$i=$i+66;
	
	//PRESIONES DE OPERACION
	$sec_presiones = $this->consultaAtributos($vservicio, '2.8.1');
	foreach ($sec_presiones as $sec) {
		$RS_PRESION_O = $this->cumplimientoEstandar($vservicio, $sec, $numrep);
		$pdf->Rect(15,$i,80,10,F);
		$pdf->SetY($i+3);
		$pdf->SetX(17);
		$pdf->multiCell(78,4,$RS_PRESION_O [0], 0, 'C' , TRUE);
		
		$pdf->Rect(97,$i,46,10,F);
		$pdf->SetY($i+3);
		$pdf->SetX(99);
		$pdf->multiCell(44,4,$RS_PRESION_O [1], 0, 'C' , TRUE);
		
		$pdf->Rect(145,$i,60,10,F);
		if ($RS_PRESION_O [2]==""){
		}else{
			$pdf->Image($RS_PRESION_O [2],173,$i+3,5,5);
			
		}
		$i=$i+12;
	}
	$i=$i+48;
	
	
	// pagina 3
	$pdf->AddPage();
	// SUBTITULOS
	$seccion=3;
	$i=48;
	
	//for ($seccion=1; $seccion<3; $seccion++) {
	
	$tit_secciones = array(T_('CALIDAD DE LA BEBIDA'), T_('PRESIONES DE OPERACION'), T_('BUENOS HABITOS DE MANUFACTURA'));
	
	$pdf->SetY($i);
	$pdf->SetX(16);
	$pdf->ChapterTitle($tit_secciones [$seccion-1]);
	
	$pdf->SetFillColor(152,185,235);
	$pdf->Rect(10,$i+7,200,10,F);
	
	//if ($seccion>=2) {
	//$pdf->Rect(10,$i+28,200,51,F);
	//} else {
	$pdf->Rect(10,$i+20,200,170,F);
	//}
	
	//**** ETIQUETAS
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(184,211,235);
	
	$pdf->Rect(15,$i+9,80,6,F);
	$pdf->SetY($i+10);
	$pdf->SetX(23);
	$pdf->Cell(40,4,'ATRIBUTO', 0, 'R' , TRUE);
	
	$pdf->Rect(97,$i+9,46,6,F);
	$pdf->SetY($i+10);
	$pdf->SetX(82);
	$pdf->Cell(45,4,'ESTANDAR', 0, 'R' , TRUE);
	
	$pdf->Rect(145,$i+9,60,6,F);
	$pdf->SetY($i+10);
	$pdf->SetX(157);
	$pdf->Cell(40,4,'CUMPLIMIENTO DEL ESTANDAR', 0, 'R' , TRUE);
	if ($seccion>=2) {
		$i=$i+22;
	} else {
		$i=$i+22;
	}
	//}
	
	
	// tercera seccion de la pagina
	//BUE4NOS HABITOS DE MANUFACTURA
	$pdf->SetFont('Arial','',8);
	$sec_condiciones = array('6', '7', '3.3', '8.0.2.5', '3.6', '3.7', '3.9', '3.10', '3.2', '3.4');
	
	foreach ($sec_condiciones as $sec) {
		
		if ($sec == '6' || $sec == '7') {
			$res = $this->cumplimientoProducto($vservicio, $sec, $numrep);
			
		} else
			if ($sec == '8.0.2.5') {
				$res = $this->cumplimientoEstandar($vservicio, $sec, $numrep);
				
			} else {
				$res = $this->cumplimientoPonderada($vservicio, $sec, $numrep);
			}
			
			$pdf->SetY($i);
			$pdf->Rect(15,$i,80,12,F);
			
			$pdf->SetX(15);
			$pdf->multiCell(80,4,$res [0], 0, 'C' , TRUE);
			
			$pdf->Rect(97,$i,46,12,F);
			$pdf->SetY($i+3);
			$pdf->SetX(99);
			$pdf->multiCell(44,6,$res [1], 0, 'C' , TRUE);
			
			$pdf->Rect(145,$i,60,12,F);
			if ($res [2]==""){
			}else if ($res [2]=="NA"){
				$pdf->SetY($i+4);
				$pdf->SetX(172);
				$pdf->multiCell(8,5,$res [2], 0, 'C' , TRUE);
			}else {
				$pdf->Image($res [2],173,$i+3,5,5);
			}
			$i=$i+15;
	}
	
	
	// pagina 4
	
	$pdf->AddPage();
	// SUBTITULOS
	$pdf->SetY(58);
	$pdf->SetX(16);
	$pdf->ChapterTitle('RESULTADOS DEL ANALISIS DE LA MUESTRA DE AGUA TRATADA');
	
	// RECUADRO GENERAL
	$pdf->SetFillColor(152,185,235);
	$pdf->Rect(10,66,200,10,F);
	$pdf->Rect(10,77,200,170,F);
	
	//**** ETIQUETAS
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(184,211,235);
	$pdf->Rect(15,68,30,6,F);
	$pdf->SetY(69);
	$pdf->SetX(18);
	$pdf->Cell(25,4,'NO. DE MUESTRA', 0, 'R' , TRUE);
	
	$pdf->Rect(65,68,27,6,F);
	$pdf->SetY(69);
	$pdf->SetX(65);
	$pdf->Cell(25,4,'LABORATORIO', 0, 'R' , TRUE);
	
	$pdf->Rect(155,68,24,6,F);
	$pdf->SetY(69);
	$pdf->SetX(150);
	$pdf->Cell(25,4,'RECEPCION', 0, 'R' , TRUE);
	
	$pdf->SetFont('Arial','',10);
	$pdf->Rect(13,78,14,6,F);
	$pdf->SetY(79);
	$pdf->SetX(13);
	$pdf->multiCell(12,4,'No.', 0, 'C' , TRUE);
	
	$pdf->Rect(29,78,58,6,F);
	$pdf->SetY(79);
	$pdf->SetX(29);
	$pdf->multiCell(58,4,'PRUEBA', 0, 'C' , TRUE);
	
	$pdf->Rect(89,78,58,6,F);
	$pdf->SetY(79);
	$pdf->SetX(89);
	$pdf->multiCell(58,4,'ESTANDAR', 0, 'C' , TRUE);
	
	$pdf->Rect(149,78,58,6,F);
	$pdf->SetY(79);
	$pdf->SetX(149);
	$pdf->multiCell(58,4,'RESULTADO', 0, 'C' , TRUE);
	
	$paramgen=array("vservicio"=>$vservicio,"numrep"=>$numrep);
	//*** DATOS
	$pdf->SetFillColor(216,231,243);
	$pdf->SetFont('Arial','',10);
	$ssql="SELECT ide_idmuestra, cad_descripcionesp, rm_fechahora  
FROM (SELECT ins_detalleestandar.ide_idmuestra FROM
ins_detalleestandar 
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = ins_detalleestandar.ide_claveservicio 
AND cue_secciones.sec_numseccion = ins_detalleestandar.ide_numseccion
 WHERE ins_detalleestandar.ide_claveservicio =  :vservicio 
AND ins_detalleestandar.ide_numreporte =  :numrep
 AND cue_secciones.sec_indagua =  '1' 
GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte) AS A 
INNER JOIN (SELECT aa_recepcionmuestradetalle.mue_idmuestra,
 aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestra.rm_fechahora,
 ca_catalogosdetalle.cad_descripcionesp FROM aa_recepcionmuestradetalle 
Inner Join aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
Inner Join ca_catalogosdetalle ON aa_recepcionmuestra.rm_embotelladora = ca_catalogosdetalle.cad_idopcion
Inner Join ca_catalogos ON ca_catalogosdetalle.cad_idcatalogo = ca_catalogos.ca_idcatalogo 
WHERE ca_catalogos.ca_idcatalogo =  '43' 
GROUP BY aa_recepcionmuestradetalle.mue_idmuestra ) AS b ON  ide_idmuestra=mue_idmuestra";
	$rs=Conexion::ejecutarQuery($ssql,$paramgen);
	
	foreach ($rs as $row) {
		$pdf->SetY(68);
		$pdf->SetX(45);
		$pdf->multiCell(16,6,$row["ide_idmuestra"], 0, 'L' , TRUE);
		
		$pdf->SetY(68);
		$pdf->SetX(92);
		$pdf->multiCell(60,6,$row["cad_descripcionesp"], 0, 'C' , TRUE);
		
		$pdf->SetY(68);
		$pdf->SetX(178);
		$pdf->multiCell(26,6,Utilerias::formato_fecha($row["rm_fechahora"]), 0, 'L' , TRUE);
	}
	
	// detalle de muestra de agua
	$pdf->SetFont('Arial','',8);
	
	
	if ($estatusfin==2) {
		// nuevo formato
		$ssql="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion,ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado,
if(ins_detalleestandar.ide_numcaracteristica3=21,1, if(ins_detalleestandar.ide_numcaracteristica3=14,2,if(ins_detalleestandar.ide_numcaracteristica3=2,3,if(ins_detalleestandar.ide_numcaracteristica3=3,4,if(ins_detalleestandar.ide_numcaracteristica3=1,5, if(ins_detalleestandar.ide_numcaracteristica3=19,6,if(ins_detalleestandar.ide_numcaracteristica3=4,7,if(ins_detalleestandar.ide_numcaracteristica3=9,8, if(ins_detalleestandar.ide_numcaracteristica3=5,9,if(ins_detalleestandar.ide_numcaracteristica3=6,10, if(ins_detalleestandar.ide_numcaracteristica3=8,11,if(ins_detalleestandar.ide_numcaracteristica3=20,14, if(ins_detalleestandar.ide_numcaracteristica3=17,15, if(ins_detalleestandar.ide_numcaracteristica3=18,16, ins_detalleestandar.ide_numcaracteristica3 ) ) ) ) ) ) ) ) ) ) ) ))) as numercacion
FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion WHERE
ins_detalleestandar.ide_claveservicio =  :vservicio AND ins_detalleestandar.ide_numreporte =  :numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1' AND
ins_detalleestandar.ide_numcomponente =  '2'
ORDER BY if(ins_detalleestandar.ide_numcaracteristica3=21,1, if(ins_detalleestandar.ide_numcaracteristica3=14,2,if(ins_detalleestandar.ide_numcaracteristica3=2,3,if(ins_detalleestandar.ide_numcaracteristica3=3,4,if(ins_detalleestandar.ide_numcaracteristica3=1,5, if(ins_detalleestandar.ide_numcaracteristica3=19,6,if(ins_detalleestandar.ide_numcaracteristica3=4,7,if(ins_detalleestandar.ide_numcaracteristica3=9,8, if(ins_detalleestandar.ide_numcaracteristica3=5,9,if(ins_detalleestandar.ide_numcaracteristica3=6,10, if(ins_detalleestandar.ide_numcaracteristica3=8,11,if(ins_detalleestandar.ide_numcaracteristica3=20,14, if(ins_detalleestandar.ide_numcaracteristica3=17,15, if(ins_detalleestandar.ide_numcaracteristica3=18,16, ins_detalleestandar.ide_numcaracteristica3 ) ) ) ) ) ) ) ) ) ) ) ))) ASC";
		
		$rs=Conexion::ejecutarQuery($ssql,$paramgen);
		
		$i=86;
		$j=87;
		$np=1;
		foreach ($rs as $row) {
			$pdf->SetFillColor(184,211,235);
			$pdf->Rect(13,$i,14,6,F);
			$pdf->SetY($j);
			$pdf->SetX(13);
			//$pdf->multiCell(12,4,$row["ide_numcaracteristica3"], 0, 'C' , TRUE);
			$pdf->multiCell(12,4,$np, 0, 'C' , TRUE);
			
			$pdf->Rect(29,$i,58,6,F);
			$pdf->SetY($j);
			$pdf->SetX(29);
			$pdf->multiCell(58,4,$row["red_parametroesp"], 0, 'C' , TRUE);
			
			$pdf->Rect(89,$i,58,6,F);
			$pdf->SetY($j);
			$pdf->SetX(89);
			$pdf->multiCell(58,4,utf8_decode($row["red_estandar"]), 0, 'C' , TRUE);
			
			$tipocat=$row["red_tipodato"];
			switch ($tipocat) {
				case "C" :
					$valop=round($row["ide_valorreal"],1);
					$numcat=$row["red_clavecatalogo"];
					// busca el valor en el catalogo
					$sqlcat="SELECT * FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '".$numcat."' AND
ca_catalogosdetalle.cad_idopcion =  '".$valop."';";
					
						$valreal=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valop);
						$valreal=utf8_decode($valreal);
				
					break;
				case "N" :
					$valreal=round($row["ide_valorreal"],3);
					break;
			}
			$pdf->SetFillColor(216,231,243);
			$pdf->Rect(149,$i,58,6,F);
			if ($row["ide_aceptado"]) {
				//	   $pdf->SetTextColor(0, 0,0);
			}else{
				$pdf->SetTextColor(255, 0,0);
			}
			if (($row["ide_numcaracteristica3"]==14) || ($row["ide_numcaracteristica3"]==21)) {
				$pdf->SetFont('Arial','',7);
			} else {
				$pdf->SetFont('Arial','',8);
			}
			
			$pdf->SetY($j);
			$pdf->SetX(149);
			$pdf->multiCell(58,4,$valreal, 0, 'C' , TRUE);
			$i=$i+8;
			$j=$j+8;
			$pdf->SetTextColor(0, 0,0);
			$pdf->SetFont('Arial','',8);
			$np++;
		}
		
	} else { //formato anterior
		$ssql="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion,ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, cue_reactivosestandardetalle.red_estandar, cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion WHERE
ins_detalleestandar.ide_claveservicio =  :vservicio
 AND ins_detalleestandar.ide_numreporte =  :numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
ORDER BY ins_detalleestandar.ide_numcaracteristica3 ASC";
		
		$rs=Conexion::ejecutarQuery($ssql,$paramgen);
		
		$i=86;
		$j=87;
		$np=1;
		foreach ($rs as $row) {
			$nomparametro="";
			$nomestandar="";
			switch ($row["ide_numcaracteristica3"])
			{
				case '1':
					$nomparametro="SABOR";
					$nomestandar="CARACTERISTICO";
					break;
				case '2':
					$nomparametro="OLOR";
					$nomestandar="SIN OLOR";
					break;
				case '3':
					$nomparametro="COLOR";
					$nomestandar="<= 20 UCV platino / cobalto";
					break;
				case '4':
					$nomparametro="PH";
					$nomestandar="6.5 - 8.5";
					break;
				case '5':
					$nomparametro="ALCALINIDAD";
					$nomestandar="<= 175 ppm (CaCO3)";
					break;
				case '6':
					$nomparametro="DUREZA";
					$nomestandar="<= 250 ppm (CaCO3)";
					break;
				case '7':
					$nomparametro="CLORO LIBRE";
					$nomestandar="<= 1 ppm";
					break;
				case '8':
					$nomparametro="CLORO TOTAL";
					$nomestandar="<= 1 ppm";
					break;
				case '9':
					$nomparametro="SOLIDOS TOTALES D";
					$nomestandar="<= 750 ppm";
					break;
				case '11':
					$nomparametro="CONDUCTIVIDAD";
					$nomestandar="<= 1200 micro-ohms/cm";
					break;
				case '12':
					$nomparametro="HIERRO";
					$nomestandar="<= 0.3 ppm";
					break;
				case '13':
					$nomparametro="MANGANESO";
					$nomestandar="<= 0.15 ppm";
					break;
				case '14':
					$nomparametro="ORIGEN DE LA MUESTRA";
					//	   	   $nomestandar="<= 0.15 ppm";
					break;
					
				case '16':
					$nomparametro="CUENTA TOTAL";
					$nomestandar="<= 100 UFC / ml";
					break;
				case '17':
					$nomparametro="COLIFORMES TOTALES";
					$nomestandar="<= 2 UFC / 100 ml";
					break;
				case '18':
					$nomparametro="E COLI";
					$nomestandar="= 0 UFC / 100 ml";
					break;
				case '19':
					$nomparametro="TURBIEDAD";
					$nomestandar="<= 5 UTN";
					break;
				case '20':
					$nomparametro="FLORUROS";
					$nomestandar="<= 1.5 ppm";
					break;
				case '21':
					$nomparametro="FUENTE DE ABASTECIMIENTO";
					$nomestandar="RED MUNICIPAL";
					break;
			}
			$pdf->SetFillColor(184,211,235);
			$pdf->Rect(13,$i,14,6,F);
			$pdf->SetY($j);
			$pdf->SetX(13);
			$pdf->multiCell(12,4,$np, 0, 'C' , TRUE);
			
			$pdf->Rect(29,$i,58,6,F);
			$pdf->SetY($j);
			$pdf->SetX(29);
			$pdf->multiCell(58,4,$nomparametro, 0, 'C' , TRUE);
			
			$pdf->Rect(89,$i,58,6,F);
			$pdf->SetY($j);
			$pdf->SetX(89);
			$pdf->multiCell(58,4,$nomestandar, 0, 'C' , TRUE);
			
			$tipocat=$row["red_tipodato"];
			switch ($tipocat) {
				case "C" :
					//            $valop=round($row["ide_valorreal"],1);
					$valop="";
					$valreal="";
					$valop=$row["ide_valorreal"];
					$numcat=$row["red_clavecatalogo"];
					// busca el valor en el catalogo
					$sqlcat="SELECT * FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '".$numcat."' AND
ca_catalogosdetalle.cad_idopcion =  '".$valop."';";
					
					
						$valreal=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valop);
						
					
					break;
				case "N" :
					$valreal=round($row["ide_valorreal"],3);
					break;
			}
			$pdf->SetFillColor(216,231,243);
			$pdf->Rect(149,$i,58,6,F);
			if ($row["ide_aceptado"]) {
				//	   $pdf->SetTextColor(0, 0,0);
			}else{
				$pdf->SetTextColor(255, 0,0);
			}
			if (($row["ide_numcaracteristica3"]==14) || ($row["ide_numcaracteristica3"]==21)) {
				$pdf->SetFont('Arial','',7);
			} else {
				$pdf->SetFont('Arial','',8);
			}
			$pdf->SetY($j);
			$pdf->SetX(149);
			$pdf->multiCell(58,4,$valreal, 0, 'C' , TRUE);
			$i=$i+8;
			$j=$j+8;
			$pdf->SetTextColor(0, 0,0);
			$pdf->SetFont('Arial','',8);
			$np++;
		}
	}
	
	
	
	// pagina 4
	// RECUADRO GENERAL
	$pdf->AddPage();
	$pdf->SetY(48);
	$pdf->SetX(16);
	$pdf->ChapterTitle('FOTOGRAFIAS');
	
	$pdf->SetFillColor(152,185,235);
	$pdf->Rect(10,54,200,200,F);
	
	
	$pdf->SetFont('Arial','',8);
	$ssql="SELECT ins_imagendetalle.id_ruta, ins_imagendetalle.id_descripcion 
FROM ins_imagendetalle WHERE
ins_imagendetalle.id_imgclaveservicio =  :vservicio
 AND ins_imagendetalle.id_imgnumreporte =  :numrep";
	$rs=Conexion::ejecutarQuery($ssql,$paramgen);
	
	$x=14;
	$y=60;
	$cont=0;
	$Band=0;
	foreach ($rs as $row) {
		$ee = RAIZ."/".$row[0];
		if ($cont<6) {
			
			if (($cont==0) || ($cont==3)){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
				}
			}
			else if (($cont==1) || ($cont==4) ){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x+66,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x+66);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
				}
			}
			else if (($cont==2) || ($cont==5) ){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x+132,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x+132);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
					$y=$y+90;
				}
			}
			// $cont++;
		} else if ($cont>=6 && $cont<12) {
			// pagina 6
			if ($Band==0) {
				$pdf->AddPage();
				$pdf->SetFillColor(152,185,235);
				$pdf->Rect(10,54,200,200,F);
				$x=14;
				$y=60;
				$Band++;
			}
			if (($cont==6) || ($cont==9)){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
				}
				
			} else if (($cont==7) || ($cont==10) ){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x+66,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x+66);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
				}
			} else if (($cont==8) || ($cont==11) ){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x+132,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x+132);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
					
					$y=$y+90;
				}
				if ($cont==11) {
					$Band=0;
				}
			}
			
			
			// $cont++;
		} else if ($cont>=12 && $cont<17) {
			if ($Band==0) {
				$pdf->AddPage();
				$pdf->SetFillColor(152,185,235);
				$pdf->Rect(10,54,200,200,F);
				//	$pdf->multiCell(60,4,$Band, 0, 'C' , FALSE);
				$x=14;
				$y=60;
				$Band++;
			}
			
			if (($cont==12) || ($cont==15)){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
				}
				
			} else if (($cont==13) || ($cont==16) ){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x+66,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x+66);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
				}
			} else if (($cont==14) || ($cont==17) ){
				if ($ee==""){
				}else{
					$pdf->Image($ee,$x+132,$y,60,70);
					$pdf->SetY($y+71);
					$pdf->SetX($x+132);
					$pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
					$y=$y+90;
				}
			}
			
		}
		$cont++;
	}
	$pdf->Output();
	
	}
	
	// area de funciones
	//lista el numero de reporte
	function CumplimientoEstandar($vservicio, $referencia, $lista) {
	
		
		$query = "SELECT sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,ide_aceptado,0),ide_aceptado)) as aceptado,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,red_clavecatalogo,ide_valorreal,  ide_numcaracteristica3,
red_tipodato,red_valormin
			    FROM cue_reactivosestandar
		  Inner Join cue_reactivosestandardetalle
		  		  ON cue_reactivosestandar.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
				 AND cue_reactivosestandar.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
				 AND cue_reactivosestandar.r_numreactivo = cue_reactivosestandardetalle.r_numreactivo
				 AND cue_reactivosestandar.re_numcomponente = cue_reactivosestandardetalle.re_numcomponente
				 AND cue_reactivosestandar.re_numcaracteristica = cue_reactivosestandardetalle.re_numcaracteristica
				 AND cue_reactivosestandar.re_numcomponente2 = cue_reactivosestandardetalle.re_numcomponente2
		  Inner Join ins_detalleestandar
		          ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio
				 AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion
				 AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo
				 AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente
				 AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1
				 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2
				 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
			   WHERE ins_detalleestandar.ide_numreporte =  :lista   and cue_reactivosestandardetalle.ser_claveservicio=:vservicio 
			     AND  red_grafica=-1  and concat(ins_detalleestandar.ide_numseccion,'.',ide_numreactivo ,'.',ins_detalleestandar.ide_numcomponente,'.',ins_detalleestandar.ide_numcaracteristica3 )=  :referencia ";
		
		$query .= " group by ins_detalleestandar.ide_numseccion,ide_numreactivo ,ins_detalleestandar.ide_numcomponente, ide_numcaracteristica3
			ORDER BY cue_reactivosestandardetalle.re_numcomponente2 ASC,
			         ins_detalleestandar.ide_numcaracteristica3 ASC,
					 ins_detalleestandar.ide_numrenglon ASC;";
		//    echo $query;
		$result = Conexion::ejecutarQuery($query,array("lista"=>$lista,"vservicio"=>$vservicio,"referencia"=>$referencia));
		foreach ($result as $row) {
			
			if ($_SESSION["idiomaus"] == 2)
				$res[0] = $row ['red_parametroing'];
				else
					$res[0] = $row ['red_parametroesp'];
					// si el estandar es de catalogo lo busco en el catalogo
					if ($row["red_tipodato"] == "C") {
						$sql_cat = "SELECT
ca_catalogosdetalle.cad_descripcionesp,
ca_catalogosdetalle.cad_descripcioning
FROM
ca_catalogosdetalle
WHERE
ca_catalogosdetalle.cad_idcatalogo =  '" . $row["red_clavecatalogo"] . "' AND
ca_catalogosdetalle.cad_idopcion =  '" . $row["red_valormin"] . "'";
						//  echo "<br> oo ".$sql_cat;
						
						$res[1] =DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",  $row["red_clavecatalogo"],  $row["red_valormin"] );
						
						
					}
					else
						$res[1] = utf8_decode($row['red_estandar']);
						if ($row ["aceptado"] == -1)
							$res[2] = $this->paloma;
							else
								$res[2] = $this->tache;
								
								$res[3] = $referencia;
		}
		
		return $res;
	}
	
	function ConsultaAtributos($idservicio, $referencia) {
		/* 502 */
		$sql = "SELECT
cue_reactivosestandardetalle.sec_numseccion,
cue_reactivosestandardetalle.r_numreactivo,
cue_reactivosestandardetalle.re_numcomponente,
				
cue_reactivosestandardetalle.red_numcaracteristica2
from cue_reactivosestandardetalle inner join cue_reactivosestandar on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion
and cue_reactivosestandar.r_numreactivo=cue_reactivosestandardetalle.r_numreactivo and cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente
and cue_reactivosestandar.re_numcaracteristica=cue_reactivosestandardetalle.re_numcaracteristica and cue_reactivosestandar.re_numcomponente2=cue_reactivosestandardetalle.re_numcomponente2
where red_grafica=-1
				
 and concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente)=:referencia 
     and cue_reactivosestandar.ser_claveservicio=:idservicio ;";
		//
		//and cue_reactivosestandardetalle.r_numreactivo=0 and
		//cue_reactivosestandardetalle.re_numcomponente=2;";
		
		$i = 0;
		$result = Conexion::ejecutarQuery($sql,array("idservicio"=>$idservicio,"referencia"=>$referencia));
		foreach ($result as $row) {
			$secciones [$i++] = $row [0] . '.' . $row [1] . '.' . $row [2] . '.' . $row [3];
		}
		return $secciones;
	}
	
	
	function CumplimientoProporcion($vservicio, $referencia, $lista) {
		
		
		$query = "SELECT sum(if(ide_aceptado<0,100,0))/sum(1) as aceptado,
cue_reactivosestandardetalle.red_estandar, red_parametroesp, red_parametroing,red_clavecatalogo,ide_valorreal,  ide_numcaracteristica3
			    FROM cue_reactivosestandar
		  Inner Join cue_reactivosestandardetalle
		  		  ON cue_reactivosestandar.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
				 AND cue_reactivosestandar.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
				 AND cue_reactivosestandar.r_numreactivo = cue_reactivosestandardetalle.r_numreactivo
				 AND cue_reactivosestandar.re_numcomponente = cue_reactivosestandardetalle.re_numcomponente
				 AND cue_reactivosestandar.re_numcaracteristica = cue_reactivosestandardetalle.re_numcaracteristica
				 AND cue_reactivosestandar.re_numcomponente2 = cue_reactivosestandardetalle.re_numcomponente2
		  Inner Join ins_detalleestandar
		          ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio
				 AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion
				 AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo
				 AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente
				 AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1
				 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2
				 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
			   WHERE ins_detalleestandar.ide_numreporte =  :lista  and cue_reactivosestandardetalle.ser_claveservicio=:vservicio 
			     AND  red_grafica=-1  and concat(ins_detalleestandar.ide_numseccion,'.',ide_numreactivo ,'.',
                             ins_detalleestandar.ide_numcomponente,'.',ins_detalleestandar.ide_numcaracteristica3 )=  :referencia ";
		$parametros=array("vservicio"=>$vservicio,"referencia"=>$referencia,"lista"=>$lista);
		//condicion para una seccion en especifico
		if ($caract != "")
		{	$query .= " and ins_detalleestandar.ide_numcaracteristica3=:caract ";
		$parametros["caract"]=$caract;
		}
			
			$query .= " group by ins_detalleestandar.ide_numseccion,ide_numreactivo ,ins_detalleestandar.ide_numcomponente, ide_numcaracteristica3
			ORDER BY cue_reactivosestandardetalle.re_numcomponente2 ASC,
			         ins_detalleestandar.ide_numcaracteristica3 ASC,
					 ins_detalleestandar.ide_numrenglon ASC;";
			//echo "<br>".$query;
			$result = Conexion::ejecutarQuery($query,$parametros);
			
			foreach ($result as $row_cal_b) {
				$res=array();
				if ($_SESSION["idiomaus"] == 2)
					$res[0] = $row_cal_b ['red_parametroing'];
					else
						$res[0] = utf8_decode($row_cal_b ['red_parametroesp']);
						
						$res[1] = $row_cal_b ['red_estandar'];
						
						if ($row_cal_b ["aceptado"] >= 80)
							$res[2] = $this->paloma;
							else
								$res[2] = $this->tache;
								$res[3] = $referencia;
			}
			
			return $res;
	}
	
	function CumplimientoProducto($vservicio, $sec, $lista) {
		
		$SQL_FJARABER = "SELECT
(((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))) as NIVELACEPTACION,
				    cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning
FROM
ins_generales
Inner Join ins_detalleproducto ON ins_generales.i_claveservicio = ins_detalleproducto.ip_claveservicio AND ins_generales.i_numreporte = ins_detalleproducto.ip_numreporte
Inner Join ca_unegocios ON  ca_unegocios.une_id = ins_generales.i_unenumpunto
Inner Join cue_secciones ON ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE `ins_generales`.`i_numreporte` =  :lista  and ins_generales.i_claveservicio=:vservicio 
				     AND  ins_detalleproducto.ip_numseccion = :sec 
					 AND ins_detalleproducto.ip_sinetiqueta<>-1
GROUP BY `ca_unegocios`.`cue_clavecuenta`, `ins_detalleproducto`.`ip_numreporte`, `ins_detalleproducto`.`ip_numseccion`";
		//echo $SQL_FJARABER;
		$result = Conexion::ejecutarQuery($SQL_FJARABER,array("vservicio"=>$vservicio,"sec"=>$sec,"lista"=>$lista));
		foreach ($result as $ROW_FJARABE) {
			
			if ($_SESSION["idiomaus"] == 2)
				$res[0] = $ROW_FJARABE ["sec_descripcioning"];
				else
					$res[0] = utf8_decode($ROW_FJARABE ["sec_descripcionesp"]);
					$res[1] = "< 10 " . T_("semanas");
					if ($ROW_FJARABE ['NIVELACEPTACION'] >= 80)
						$res[2] = $this->paloma;
						else
							$res[2] = $this->tache;
							$res[3] = $sec;
		}
		return $res;
	}
	
	function CumplimientoPonderada($vservicio, $sec, $lista) {
		
		$SQL_PRESION_O = "SELECT  id_aceptado as nivaceptren, cue_reactivos.r_descripcionesp, cue_reactivos.r_descripcioning, id_noaplica
FROM ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
WHERE
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo) =  :sec   and ins_detalle.id_numreporte=:lista  and cue_reactivos.ser_claveservicio=:vservicio ;";
		//echo $SQL_PRESION_O;
		$RS_PRESION_O = Conexion::ejecutarQuery($SQL_PRESION_O,array("vservicio"=>$vservicio,"sec"=>$sec,"lista"=>$lista));
		
		foreach ($RS_PRESION_O as $ROW_PRESION_O) {
			if ($ROW_PRESION_O ['id_noaplica'] == - 1)
				$res[2] = "NA";
				else
					if ($ROW_PRESION_O ['nivaceptren'] == - 1)
						$res[2] = $this->paloma;
						else
							$res[2] = $this->tache;
							if ($_SESSION["idiomaus"] == 2)
								$res[0] = $ROW_PRESION_O ['r_descripcioning'];
								else
									$res[0] = utf8_decode($ROW_PRESION_O ['r_descripcionesp']);
									$res[1] = "";
									$res[3] = $sec;
		}
		return $res;
	}
	
	
}

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		// Logo
		$this->Image('img/logo_mues.jpg' , 63 ,6, 80 , 20,'JPG');
		$this->SetFont('Arial','B',14);
		// Movernos a la posicion
		$this->SetY(30);
		$this->SetX(13);    // Título
		$this->Cell( 0 , 8 , "RESUMEN AUDITORIA POST MIX", 0,  0, 'C',false);
		/*    $this->SetY(34);
		 $this->SetX(13);    // Título
		 $this->Cell( 0 , 8 , "RESUMEN", 0,  0, 'C',false);*/
		
		$this->SetLineWidth(0.4);   // ancho de linea
		$this->SetFillColor(0,0,0);
		$this->Rect(10,42,200,1);
	}
	
	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-22);
		// Arial italic 8
		$this->SetFont('Arial','',8);
		// Número de página
		$this->Rect(10,256,200,1);
		$this->Cell( 0 , 8 , "Republicas 241-C * Col. Santa Cruz Atoyac * Delegacion Benito Juarez * Mexico D.F. * C.P. 03310", 0,  0, 'C');
		$this->SetY(-18);
		$this->Cell( 0 , 8 , "Tel (55) 5688-0408  5601-8688  01-800-830-5195  * muesmerc@muesmerc.com.mx", 0,  0, 'C',false);
	}
	
	function ChapterTitle($label)
	{
		// Arial 12
		$this->SetFont('Arial','B',10);
		// Color de fondo
		//$this->SetFillColor(200,220,255);
		// Título
		$this->Cell(0,6,"$label",0,0,'C',FALSE);
		//	$pdf->SetFont('Arial','B',10);
		//$pdf->Cell(0,4,'DATOS DEL PUNTO DE VENTA', 0, 0 ,'C', FALSE);
		
		
		// Salto de línea
		$this->Ln(4);
	}
	
	
	
}


