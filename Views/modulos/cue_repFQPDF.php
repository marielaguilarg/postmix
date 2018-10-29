<?php
require('fpdf/fpdf.php');//busca reactivos

foreach($_GET as $nombre_campo => $valor){
	$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  	eval($asignacion);
 }

	
//$ntoma=$_GET["ntoma"];
if ($ntoma) {
    if (!isset($_SESSION['ntoma'])) {
        $_SESSION['ntoma']=$ntoma;
    } else {
        $_SESSION['ntoma']=$ntoma;
    }
}else {
    $ntoma=$_SESSION['ntoma'];
}
//$ntoma=1;

 function cambiaf_a_normal($fecha){
 	$patrones = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/',
                   '/^\s*{(\w+)}\s*=/');

	$sustitución = array ('\4/\3/\1\2', '$\1 =');	
	return preg_replace($patrones, $sustitución, $fecha);

	}


$pdf=new FPDF('p','mm','letter');
$pdf->AddPage();
$pdf->Image('views/dist/img/banner_pepsi.jpg' , 15 ,6, 190 , 20,'JPG');

//Recuadros
$pdf->SetLineWidth(0.4);   // ancho de linea
$pdf->SetFillColor(0,0,0);
 
$pdf->Rect(15,30,193,15);
$pdf->Rect(15,47,193,210);
$pdf->SetLineWidth(0.2);   // ancho de linea
$pdf->SetFillColor(0,0,0);
$pdf->Rect(16,52,14,8);
$pdf->Rect(30,52,25,8);
$pdf->Rect(55,52,25,8);
$pdf->Rect(80,52,24,8);
$pdf->Rect(104,52,17,8);
$pdf->Rect(121,52,17,8);
$pdf->Rect(138,52,20,8);
$pdf->Rect(158,52,20,8);
$pdf->Rect(178,52,28,8);
// datos
$pdf->Rect(16,60,14,10);
$pdf->Rect(30,60,25,10);
$pdf->Rect(55,60,25,10);
$pdf->Rect(80,60,24,10);
$pdf->Rect(104,60,17,10);
$pdf->Rect(121,60,17,10);
$pdf->Rect(138,60,20,10);
$pdf->Rect(158,60,20,10);
$pdf->Rect(178,60,28,10);

// cuadros del punto de venta
$pdf->Rect(16,75,64,8);
$pdf->Rect(80,75,20,8);
$pdf->Rect(100,75,18,8);
$pdf->Rect(118,75,40,8);
$pdf->Rect(158,75,48,8);

$pdf->Rect(16,83,64,5);
$pdf->Rect(80,83,20,5);
$pdf->Rect(100,83,18,5);
$pdf->Rect(118,83,40,5);
$pdf->Rect(158,83,48,5);

// cuadros del LABORATORIO
$pdf->Rect(16,95,64,8);
$pdf->Rect(80,95,64,8);
$pdf->Rect(144,95,62,8);

$pdf->Rect(16,103,64,5);
$pdf->Rect(80,103,64,5);
$pdf->Rect(144,103,62,5);

// cuadros del RESULTADO
$pdf->Rect(16,114,6,4);
$pdf->Rect(22,114,35,4);
$pdf->Rect(57,114,35,4);
$pdf->Rect(92,114,18,4);

$pdf->Rect(110,114,6,4);
$pdf->Rect(116,114,35,4);
$pdf->Rect(151,114,35,4);
$pdf->Rect(186,114,20,4);

$pdf->Rect(15,226,193,6);

// cuadros del CAPTURISTA
$pdf->Rect(16,237,47,8);
$pdf->Rect(63,237,47,8);
$pdf->Rect(110,237,47,8);
$pdf->Rect(157,237,49,8);

$pdf->Rect(16,245,47,10);
$pdf->Rect(63,245,47,10);
$pdf->Rect(110,245,47,10);
$pdf->Rect(157,245,49,10);

// cuadros del ANALISTA
$pdf->Rect(16,207,47,8);
$pdf->Rect(63,207,47,8);
$pdf->Rect(110,207,47,8);
$pdf->Rect(157,207,49,8);

$pdf->Rect(16,215,47,10);
$pdf->Rect(63,215,47,10);
$pdf->Rect(110,215,47,10);
$pdf->Rect(157,215,49,10);



$pdf->SetFillColor(200,200,200);
//Cabeceras
$pdf->SetFont('Arial','B',14);
$pdf->SetY(31);
$pdf->SetX(16);
$pdf->Cell( 0 , 8 , "AGUA POST MIX" , 0, 0 , 'C',true );
$pdf->SetY(38);
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,6,'ANALISIS FISICOQUIMICO', 0, 0 ,'C', true);

$respuesta = DatosMuestra::vistaItem($ntoma, "FQ", "aa_muestras");
     
foreach ($respuesta as $key => $row) {	# code...
	$fecharec=$row["rm_fechahora"];
	$frec=cambiaf_a_normal($fecharec)." ". $row['horarec'];
	//$frec=$fecharec." ".$row['horarec'];
	$numtoma=$row['mue_numtoma'];   
	$origen=$row['mue_origenmuestra'];
	$tipomue=$row['mue_tipomuestra'];
	$numlab=$row['rm_embotelladora'];
	$nomrec=$row['rm_personarecibe'];	     
	$estatusmues=$row['mue_estatusmuestra'];      
	$numrep=$row['mue_numreporte'];   
	$numcap=$row['mue_capacidadFQ'];   
	//$fecvis=$fechavis." ".$row['horarec'];
	$tipo=$row['re_descripcionesp'];   
	$numunid=$row['mue_numunidadesFQ'];
	$fechamue=$row['mue_fechahora'];
	$idserv=$row['ide_claveservicio'];
	$fecmue=cambiaf_a_normal($fechamue)." ". $row['horamues'];
	//$fecmue=$fechamue." ".$row['horamues'];

// busca datos del punto de venta

	$puntovta = DatosMuestra::vistaDatosPunto($idserv, $ntoma, "ca_unegocios");
     
     $idclien=$puntovta['une_idpepsi'];
	 $respvis=$puntovta['i_responsablevis'];	 
     $audit=$puntovta['ins_nombre'];
     $nomuneg=$puntovta['une_descripcion']; 
	 $fechavis=$puntovta['i_fechavisita'];
  	 $fecvis=cambiaf_a_normal($fechavis)." ". $row['horarec'];    

	//origen
	$origenrow = DatosCatalogoDetalle::listaCatalogoDetalleOpc(21, $origen, "ca_catalogosdetalle");

    $origendes= $origenrow['cad_descripcionesp'];
	
	//numero de toma
    $tomarow = DatosCatalogoDetalle::listaCatalogoDetalleOpc(42, $numtoma, "ca_catalogosdetalle");

    $toma= $tomarow['cad_descripcionesp'];

	//laboratorio
	$labrow = DatosCatalogoDetalle::listaCatalogoDetalleOpc(43, $numlab, "ca_catalogosdetalle");

    $nomlab= $labrow['cad_descripcionesp'];
	
}   // FOREACH


$pdf->SetY(48);
$pdf->SetX(16);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,4,'DATOS DE LA MUESTRA', 0, 0 ,'C', TRUE);

$pdf->SetY(52);
$pdf->SetX(16);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'NO. DE MUESTRA', 0, '' , FALSE);

$pdf->SetFont('Arial','B',12);
//    $pdf->Text(10,64,$ntoma);
	$pdf->SetY(61);
    $pdf->SetX(16);
	$pdf->Cell(13,8,$ntoma, 0, 0 ,'C', FALSE);

$pdf->SetFont('Arial','',6);
$pdf->SetY(54);
$pdf->SetX(35);

$pdf->MultiCell(15,4,'ANALISIS', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(61);
    $pdf->SetX(33);
	$pdf->Cell(20,4,'FISICOQUIMICO', 0, 0 ,'C', FALSE);

$pdf->SetFont('Arial','',6);
$pdf->SetY(54);
$pdf->SetX(55);

$pdf->MultiCell(25,4,'TIPO', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(61);
    $pdf->SetX(56);
	$pdf->MultiCell(25,4,$tipo, 0, '', FALSE);

$pdf->SetFont('Arial','',6);
$pdf->SetY(54);
$pdf->SetX(84);

$pdf->MultiCell(25,4,'ORIGEN', 0, '' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(61);
    $pdf->SetX(80);
	$pdf->MultiCell(23,4,$origendes, 0, '', FALSE);

$pdf->SetFont('Arial','',6);
$pdf->SetY(54);
$pdf->SetX(107);
$pdf->MultiCell(25,4,'TOMA', 0, '' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(61);
    $pdf->SetX(104);
	$pdf->MultiCell(17,4,$toma, 0,'', FALSE);

$pdf->SetFont('Arial','',6);
$pdf->SetY(52);
$pdf->SetX(122);

$pdf->MultiCell(25,4,'UNIDADES ENTREGADAS', 0, '' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(62);
    $pdf->SetX(114);
	$pdf->Cell(30,4,$numunid, 0, 0 ,'C', FALSE);
$pdf->SetFont('Arial','',6);
$pdf->SetY(54);
$pdf->SetX(138);

$pdf->MultiCell(20,4,'CAPACIDAD (ml)', 0, '' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(62);
    $pdf->SetX(134);
	$pdf->Cell(30,4,$numcap, 0, 0 ,'C', FALSE);
	
$pdf->SetFont('Arial','',6);	
$pdf->SetY(52);
$pdf->SetX(158);

$pdf->MultiCell(20,4,'FECHA Y HORA DE TOMA', 0, '' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(61);
    $pdf->SetX(160);
//	$pdf->Cell(30,4,$fecmue, 0, 0 ,'C', FALSE);
    $pdf->MultiCell(18,4,$fecmue, 0, '' , FALSE);
    $pdf->SetFont('Arial','',6);
    $pdf->SetY(54);
    $pdf->SetX(180);

    $pdf->MultiCell(25,4,'AUDITOR MUESMERC', 0, '' , FALSE);
    $pdf->SetFont('Arial','B',7);
	$pdf->SetY(61);
    $pdf->SetX(178);
	$pdf->MultiCell(30,4,$audit, 0, '', FALSE);


$pdf->SetY(71);
$pdf->SetX(16);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,4,'DATOS DEL PUNTO DE VENTA', 0, 0 ,'C', TRUE);


// siguiente linea
$pdf->SetY(77);
$pdf->SetX(16);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(65,4,'NOMBRE', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(84);
    $pdf->SetX(25);
	$pdf->Cell(50,4,$nomuneg, 0, 0 ,'C', FALSE);

$pdf->SetY(77);
$pdf->SetX(48);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(85,4,'ID CLIENTE', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(84);
    $pdf->SetX(65);
	$pdf->Cell(48,4,$idclien, 0, 0 ,'C', FALSE);

$pdf->SetY(77);
$pdf->SetX(97);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(25,4,'REPORTE', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(84);
    $pdf->SetX(85);
	$pdf->Cell(50,4,$numrep, 0, 0 ,'C', FALSE);

$pdf->SetY(75);
$pdf->SetX(120);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(40,4,'RESPONSABLE EN EL PUNTO DE VENTA', 0, '' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(84);
    $pdf->SetX(100);
	$pdf->Cell(75,4,$respvis, 0, 0 ,'C', FALSE);

$pdf->SetY(77);
$pdf->SetX(170);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(35,4,'FECHA DE VISITA', 0, '' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(84);
    $pdf->SetX(165);
	$pdf->Cell(35,4,$fecvis, 0, 0 ,'C', FALSE);

$pdf->SetY(90);
$pdf->SetX(16);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,4,'DATOS DEL LABORATORIO', 0, 0 ,'C', TRUE);

//$nomrec,, 
$pdf->SetY(97);
$pdf->SetX(16);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(65,4,'NOMBRE', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(104);
    $pdf->SetX(16);
	$pdf->Cell(65,4,$nomlab, 0, 0 ,'C', FALSE);

$pdf->SetY(97);
$pdf->SetX(80);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(65,4,'RECIBIO', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(104);
    $pdf->SetX(90);
	$pdf->Cell(45,4,$nomrec, 0, 0 ,'C', FALSE);

$pdf->SetY(97);
$pdf->SetX(143);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(65,4,'FECHA Y HORA DE RECEPCION', 0, 'C' , FALSE);
$pdf->SetFont('Arial','B',7);
	$pdf->SetY(104);
    $pdf->SetX(150);
	$pdf->Cell(45,4,$frec, 0, 0 ,'C', FALSE);

$pdf->SetY(110);
$pdf->SetX(16);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,4,'RESULTADOS', 0, 0 ,'C', TRUE);

$resul = DatosMuestra::vistaResultados($idserv, 1, 'FQ', $tipomue, "aa_pruebaanalisis");

	$i=1; 
	$Y=120;
	$YC=119;
	$Y1=120;
	$YC1=119;
	
	foreach ($resul as $key => $rowd) {
		# code...
	
	//while ($rowd=mysql_fetch_array($rsd)){
	   if (($i % 2)>0) {
	   

	      $pdf->Rect(16,$YC,6,12);
		  $pdf->Rect(22,$YC,35,12);
		  $pdf->Rect(57,$YC,35,12);
		  $pdf->Rect(92,$YC,18,12);

	      $pdf->SetY($Y);
		  $pdf->SetX(17);
		  $pdf->SetFont('Arial','B',7);
		  $pdf->MultiCell(20,4,$i, 0, '' , FALSE);

	      $pdf->SetY($Y);
		  $pdf->SetX(22);
		  $pdf->SetFont('Arial','B',7);
		  $pdf->MultiCell(35,4,$rowd["red_parametroesp"], 0, '' , FALSE);

	      $pdf->SetY($Y);
		  $pdf->SetX(57);
		  $pdf->SetFont('Arial','B',7);
		  $pdf->MultiCell(35,4,$rowd["red_estandar"], 0, '' , FALSE);



          $Y+=12;
		  $YC+=12;
	   } else {

	   
		$pdf->Rect(110,$YC1,6,12);
		$pdf->Rect(116,$YC1,35,12);
		$pdf->Rect(151,$YC1,35,12);
		$pdf->Rect(186,$YC1,20,12);

	   $pdf->SetY($Y1);
		  $pdf->SetX(111);
		  $pdf->SetFont('Arial','B',7);
		  $pdf->MultiCell(15,4,$i, 0, '' , FALSE);

	      $pdf->SetY($Y1);
		  $pdf->SetX(116);
		  $pdf->SetFont('Arial','B',7);
		  $pdf->MultiCell(35,4,$rowd["red_parametroesp"], 0, '' , FALSE);

	      $pdf->SetY($Y1);
		  $pdf->SetX(151);
		  $pdf->SetFont('Arial','B',7);
		  $pdf->MultiCell(35,4,$rowd["red_estandar"], 0, '' , FALSE);
			$Y1+=12;
			$YC1+=12;
	   }
	   $i+=1;
	}	 // foreach



$pdf->SetY(114);
$pdf->SetX(16);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(10,4,'No.', 0, '' , FALSE);

$pdf->SetY(114);
$pdf->SetX(33);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'PRUEBA', 0, '' , FALSE);

$pdf->SetY(114);
$pdf->SetX(67);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(30,4,'ESTANDAR', 0, '' , FALSE);

$pdf->SetY(114);
$pdf->SetX(94);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(30,4,'RESULTADO', 0, '' , FALSE);

$pdf->SetY(114);
$pdf->SetX(110);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'No.', 0, '' , FALSE);

$pdf->SetY(114);
$pdf->SetX(128);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'PRUEBA', 0, '' , FALSE);

$pdf->SetY(114);
$pdf->SetX(160);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(30,4,'ESTANDAR', 0, '' , FALSE);

$pdf->SetY(114);
$pdf->SetX(187);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(30,4,'RESULTADO', 0, '' , FALSE);






$pdf->SetY(227);
$pdf->SetX(16);
$pdf->SetFont('Arial','',6);
$pdf->Cell(0,4,'IMPORTANTE: PARA CONCLUIR EL PROCESO ES NECESAIRO CAPTURAR ESTOS RESULTADOS EN LA BASE DE DATOS OFICIAL CUYA DIRECCION ES', 0, 0,'C', FALSE);
$pdf->SetY(229);
$pdf->SetX(16);
$pdf->SetFont('Arial','',6);
$pdf->Cell(0,4,' www.muesmerc.mx con su login y password asignado', 0, 0, 'C', FALSE);

$pdf->SetY(233);
$pdf->SetX(16);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,4,'DATOS DEL CAPTURISTA', 0, 0 ,'C', TRUE);

$pdf->SetY(203);
$pdf->SetX(16);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,4,'DATOS DEL ANALISTA', 0, 0 ,'C', TRUE);

$pdf->SetY(208);
$pdf->SetX(35);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'NOMBRE', 0, '' , FALSE);

$pdf->SetY(208);
$pdf->SetX(80);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'PUESTO', 0, '' , FALSE);

$pdf->SetY(208);
$pdf->SetX(128);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'FIRMA', 0, '' , FALSE);

$pdf->SetY(208);
$pdf->SetX(163);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(45,4,'FECHA Y HORA DE ANALISIS', 0, '' , FALSE);

$pdf->SetY(238);
$pdf->SetX(35);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'NOMBRE', 0, '' , FALSE);

$pdf->SetY(238);
$pdf->SetX(80);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'PUESTO', 0, '' , FALSE);

$pdf->SetY(238);
$pdf->SetX(128);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(15,4,'FIRMA', 0, '' , FALSE);

$pdf->SetY(238);
$pdf->SetX(163);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(45,4,'FECHA Y HORA DE CAPTURA', 0, '' , FALSE);

$resul = DatosMuestra::actualizaestatusrepFQ(2, $ntoma, "aa_muestras");
$pdf->Output();
?>