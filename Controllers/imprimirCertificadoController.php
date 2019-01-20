<?php
require('libs/fpdf/fpdf.php');
require("Utilerias/utilerias.php");
require_once "Models/crud_solicitudes.php";
class ImprimirCertificadoController
{
    
   
    public function reporteCERTAgua(){
        define('RAIZ',"fotografias");
        $numrep=filter_input(INPUT_GET, "nrep",FILTER_SANITIZE_NUMBER_INT);
       
        $pdf=new PDFcert('p','mm','letter');
        $pdf->AddPage();
        
        // RECUADRO GENERAL
        $pdf->SetFillColor(152,185,235);
        $pdf->Rect(10,44,200,14,F);
        $pdf->Rect(10,60,200,44,F);
        $pdf->Rect(10,106,200,20,F);
        $pdf->Rect(10,132,200,32,F);
        $pdf->Rect(10,171,200,51,F);
        $pdf->Rect(10,230,200,22,F);
        
        // SUBTITULOS
        $pdf->SetY(38);
        $pdf->SetX(16);
        $pdf->ChapterTitle('DATOS DEL PUNTO DE VENTA');
        
        $pdf->SetY(126);
        $pdf->SetX(16);
        $pdf->ChapterTitle('DATOS DE LA VISITA');
        
        $pdf->SetY(165);
        $pdf->SetX(16);
        $pdf->ChapterTitle('OBSERVACIONES');
        
        $pdf->SetY(223);
        $pdf->SetX(16);
        $pdf->ChapterTitle('CONCLUSION');
        
        //**** ETIQUETAS
        $pdf->SetFont('Arial','',8);
        $pdf->SetFillColor(184,211,235);
        $pdf->Rect(15,46,35,4,F);
        $pdf->SetY(46);
        $pdf->SetX(23);
        
        $pdf->Cell(25,4,'NO. DE REPORTE', 0, 'R' , TRUE);
        
        $pdf->Rect(15,52,35,4,F);
        $pdf->SetY(52);
        $pdf->SetX(23);
        $pdf->Cell(25,4,'PUNTO DE VENTA', 0, 'R' , TRUE);
        
        $pdf->Rect(112,46,35,4,F);
        $pdf->SetY(46);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'FECHA DE EMISION ', 0 ,'R', TRUE);
        
        $pdf->Rect(112,52,35,4,F);
        $pdf->SetY(52);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'ID CUENTA ', 0 ,'R', TRUE);
        
        // RECUADRO DOS
        $pdf->Rect(15,62,35,4,F);
        $pdf->SetY(62);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'CALLE', 0, 'R' , TRUE);
        
        $pdf->Rect(15,68,35,4,F);
        $pdf->SetY(68);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'NO. EXTERIOR', 0, 'R' , TRUE);
        
        $pdf->Rect(15,74,35,4,F);
        $pdf->SetY(74);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'NO. INTERIOR', 0, 'R' , TRUE);
        
        $pdf->Rect(15,80,35,4,F);
        $pdf->SetY(80);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'MANZANA', 0, 'R' , TRUE);
        
        $pdf->Rect(15,86,35,4,F);
        $pdf->SetY(86);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'LOTE', 0, 'R' , TRUE);
        
        $pdf->Rect(15,92,35,4,F);
        $pdf->SetY(92);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'COLONIA', 0, 'R' , TRUE);
        
        $pdf->Rect(15,98,35,4,F);
        $pdf->SetY(98);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'REFERENCIA', 0, 'R' , TRUE);
        
        $pdf->Rect(112,62,35,4,F);
        $pdf->SetY(62);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'DELEGACION', 0 ,'R', TRUE);
        
        $pdf->Rect(112,68,35,4,F);
        $pdf->SetY(68);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'C.P.', 0 ,'R', TRUE);
        
        $pdf->Rect(112,74,35,4,F);
        $pdf->SetY(74);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'CIUDAD', 0 ,'R', TRUE);
        
        $pdf->Rect(112,80,35,4,F);
        $pdf->SetY(80);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'ESTADO', 0 ,'R', TRUE);
        
        $pdf->Rect(112,86,35,4,F);
        $pdf->SetY(86);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'TELEFONO', 0 ,'R', TRUE);
        
        $pdf->Rect(112,92,35,4,F);
        $pdf->SetY(92);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'COORDENADAS XY', 0 ,'R', TRUE);
        
        // RECUADRO TRES
        $pdf->Rect(15,108,35,4,F);
        $pdf->SetY(108);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'COMPAÑIA', 0, 'R' , TRUE);
        
        $pdf->Rect(15,114,35,4,F);
        $pdf->SetY(114);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'UNIDAD DE NEGOCIO', 0, 'R' , TRUE);
        
        $pdf->Rect(15,120,35,4,F);
        $pdf->SetY(120);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'FRANQUICIA', 0, 'R' , TRUE);
        
        $pdf->Rect(112,108,35,4,F);
        $pdf->SetY(108);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'REGION', 0 ,'R', TRUE);
        
        $pdf->Rect(112,114,35,4,F);
        $pdf->SetY(114);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'ESTADO', 0 ,'R', TRUE);
        
        $pdf->Rect(112,120,35,4,F);
        $pdf->SetY(120);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'CIUDAD', 0 ,'R', TRUE);
        
        // RECUADRO CUATRO
        $pdf->Rect(15,134,35,4,F);
        $pdf->SetY(134);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'FECHA DE VISITA', 0, 'R' , TRUE);
        
        $pdf->Rect(15,140,35,4,F);
        $pdf->SetY(140);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'AUDITOR', 0, 'R' , TRUE);
        
        $pdf->Rect(15,146,35,4,F);
        $pdf->SetY(146);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'CONTACTO', 0, 'R' , TRUE);
        
        $pdf->Rect(15,152,35,4,F);
        $pdf->SetY(152);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'PUESTO', 0, 'R' , TRUE);
        
        $pdf->Rect(15,158,35,4,F);
        $pdf->SetY(158);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,4,'FECHA APERTURA', 0, 'R' , TRUE);
        
        $pdf->Rect(112,134,35,4,F);
        $pdf->SetY(134);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'ENTRADA', 0 ,'R', TRUE);
        
        $pdf->Rect(112,140,35,4,F);
        $pdf->SetY(140);
        $pdf->SetX(121);
        
        $pdf->Cell(25,4,'TOMA MUESTRA', 0 ,'R', TRUE);
        
        $pdf->Rect(112,146,35,4,F);
        $pdf->SetY(146);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'SALIDA', 0 ,'R', TRUE);
        
        $pdf->Rect(112,152,35,4,F);
        $pdf->SetY(152);
        $pdf->SetX(121);
        $pdf->Cell(25,4,'MES ASIGNACION', 0 ,'R', TRUE);
        
        
        //$pdf->Rect(15,237,160,15,F);
        /*$pdf->SetY(237);
         $pdf->SetX(15);
         $pdf->MultiCell(157,6,'SE RECOMIENDA LA INSTALACION DEL SISTEMA POST MIX EN LAS CONDICIONES ACTUALES DEL ESTABLECIMIENTO', 0 ,'C', TRUE);*/
        
        // datos rectangulo
        $pdf->SetFillColor(216,231,243);
        $pdf->Rect(147,92,60,4,F);
        $pdf->Rect(50,158,157,4,F);
        
        //**** DATOS
        // busca fecha emision
        //$sqlt="SELECT cer_solicitud.sol_fechaterminacion FROM cer_solicitud WHERE cer_solicitud.sol_claveservicio =  '3' AND
        //cer_solicitud.sol_numrep =  '$numrep'";.
      $servicio=3;
        $sqlt="SELECT cer_solicitud.sol_fechaterminacion, IF(cer_solicitud.sol_fechaterminacion>=DATE('2015-7-1'),1,0) 
AS VERSION FROM cer_solicitud WHERE cer_solicitud.sol_claveservicio =  ".$servicio." AND
cer_solicitud.sol_numrep =:numrep";
        $rst=Conexion::ejecutarQuery($sqlt,array("numrep"=>$numrep));
        foreach($rst as $rowt) {
            $fecterm=$rowt["sol_fechaterminacion"];
            $nversion=$rowt["VERSION"];
        }
        
        $ssql="SELECT  ca_unegocios.cue_clavecuenta, ca_unegocios.une_id, ca_unegocios.une_descripcion, ca_unegocios.une_idpepsi,
 ca_unegocios.une_idcuenta, ca_unegocios.une_dir_calle, ca_unegocios.une_dir_numeroext, ca_unegocios.une_dir_numeroint,
 ca_unegocios.une_dir_manzana, ca_unegocios.une_dir_lote, ca_unegocios.une_dir_colonia, ca_unegocios.une_dir_delegacion,
 ca_unegocios.une_dir_municipio, ca_unegocios.une_dir_estado, ca_unegocios.une_dir_cp, ca_unegocios.une_dir_referencia, 
ca_unegocios.une_dir_telefono, ca_unegocios.une_cla_region, ca_unegocios.une_cla_pais, ca_unegocios.une_cla_zona,
 ca_unegocios.une_coordenadasxy, ins_generales.i_fechavisita, ins_generales.i_mesasignacion, ins_generales.i_horaentradavis,
 ins_generales.i_horasalidavis, ins_generales.i_responsablevis, 
ins_generales.i_puestoresponsablevis, ins_generales.i_numreporte,  ca_nivel6.n6_nombre, ca_nivel5.n5_nombre,
 ca_nivel4.n4_nombre, ca_nivel3.n3_nombre, ca_nivel2.n2_nombre, ca_nivel1.n1_nombre, 
ins_generales.i_horaanalisissensorial, ins_generales.i_reportecic, ins_generales.i_numreportecic, ca_inspectores.ins_nombre 
FROM ca_unegocios
Inner Join ins_generales ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
INNER JOIN ca_nivel6 ON ca_unegocios.une_cla_franquicia = ca_nivel6.n6_id 
         INNER JOIN ca_nivel5 ON `une_cla_ciudad`= ca_nivel5.`n5_id` 
         INNER JOIN ca_nivel4 ON `une_cla_estado`= ca_nivel4.n4_id 
         INNER JOIN ca_nivel3 ON `une_cla_zona`= ca_nivel3.n3_id
         INNER JOIN ca_nivel2 ON  `une_cla_pais`= ca_nivel2.n2_id 
         INNER JOIN ca_nivel1 ON `une_cla_region`= ca_nivel1.n1_id 
Inner Join ca_inspectores ON ins_generales.i_claveinspector = ca_inspectores.ins_clave
WHERE
ins_generales.i_claveservicio =".$servicio." AND
ins_generales.i_numreporte = :numrep";

        $rs=Conexion::ejecutarQuery($ssql,array("numrep"=>$numrep));
       //die();
        foreach($rs as $row) {
            $pdf->SetFont('Arial','',8);
            
            $pdf->SetY(46);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["i_numreporte"], 0, 'L' , TRUE);
            
            $pdf->SetY(52);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["une_descripcion"], 0, 'L' , TRUE);
            
            $pdf->SetY(46);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,Utilerias::formato_fecha($fecterm), 0, 'L' , TRUE);
            
            $pdf->SetY(52);
            $pdf->SetX(147);
            $pdf->multicell(60,4,$row["une_idcuenta"], 0, 'L' , TRUE);
            
            
            $pdf->SetY(62);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["une_dir_calle"], 0, 'L' , TRUE);
            
            $pdf->SetY(68);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["une_dir_numeroext"], 0, 'L' , TRUE);
            
            $pdf->SetY(74);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["une_dir_numeroint"], 0, 'L' , TRUE);
            
            $pdf->SetY(80);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["une_dir_manzana"], 0, 'L' , TRUE);
            
            $pdf->SetY(86);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["une_dir_lote"], 0, 'L' , TRUE);
            
            $pdf->SetY(92);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["une_dir_colonia"], 0, 'L' , TRUE);
            
            $pdf->SetY(98);
            $pdf->SetX(50);
            $pdf->multiCell(157,4,$row["une_dir_referencia"], 0, 'L' , TRUE);
            
            $pdf->SetY(62);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["une_dir_delegacion"], 0, 'L' , TRUE);
            
            $pdf->SetY(68);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["une_dir_cp"], 0, 'L' , TRUE);
            
            $pdf->SetY(74);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["une_dir_municipio"], 0, 'L' , TRUE);
            
            $pdf->SetY(80);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["une_dir_estado"], 0, 'L' , TRUE);
            
            $pdf->SetY(86);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["une_dir_telefono"], 0, 'L' , TRUE);
            
            $pdf->SetY(92);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["une_coordenadasxy"], 0, 'L' , TRUE);
            
            
            
            
            $pdf->SetY(108);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["n1_nombre"], 0, 'L' , TRUE);
            
            $pdf->SetY(114);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["n2_nombre"], 0, 'L' , TRUE);
            
            $pdf->SetY(120);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["n3_nombre"], 0, 'L' , TRUE);
            
            $pdf->SetY(108);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["n4_nombre"], 0, 'L' , TRUE);
            
            $pdf->SetY(114);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["n5_nombre"], 0, 'L' , TRUE);
            
            $pdf->SetY(120);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["n6_nombre"], 0, 'L' , TRUE);
            
            
            $pdf->SetY(134);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,Utilerias::formato_fecha($row["i_fechavisita"]), 0, 'L' , TRUE);
            $pdf->SetY(140);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["ins_nombre"], 0, 'L' , TRUE);
            $pdf->SetY(146);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["i_responsablevis"], 0, 'L' , TRUE);
            $pdf->SetY(152);
            $pdf->SetX(50);
            $pdf->multiCell(60,4,$row["i_puestoresponsablevis"], 0, 'L' , TRUE);
            
            $pdf->SetY(134);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["i_horaentradavis"], 0, 'L' , TRUE);
            
            $pdf->SetY(140);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["i_horaanalisissensorial"], 0, 'L' , TRUE);
            
            $pdf->SetY(146);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["i_horasalidavis"], 0, 'L' , TRUE);
            
            $pdf->SetY(152);
            $pdf->SetX(147);
            $pdf->multiCell(60,4,$row["i_mesasignacion"], 0, 'L' , TRUE);
            
        }
        
        // fecha de apertura
        $ssql="SELECT cer_solicitud.sol_fechaapertura FROM cer_solicitud WHERE cer_solicitud.sol_claveservicio =  '3' AND
cer_solicitud.sol_numrep =  '$numrep'";
        $rs=DatosSolicitud::cuentasolicitudModel($numrep, $servicio,"cer_solicitud");
        foreach($rs as $row) {
            $pdf->SetY(158);
            $pdf->SetX(50);
            $pdf->multiCell(157,4,Utilerias::formato_fecha($row["sol_fechaapertura"]), 0, 'L' , TRUE);
            
        }
        
        // observaciones
        $pdf->SetFillColor(184,211,235);
        $ssql="SELECT ins_detalle.id_claveservicio, ins_detalle.id_numreporte, ins_detalle.id_numseccion, ins_detalle.id_numreactivo, ins_detalle.id_aceptado, ins_detalle.id_noaplica, cue_reactivos.r_descripcionesp FROM
ins_detalle Inner Join cue_reactivos ON  ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
WHERE ins_detalle.id_claveservicio =  :servicio AND ins_detalle.id_numseccion = :seccion AND
ins_detalle.id_numreporte = :numrep";
        $rs=Conexion::ejecutarQuery($ssql,array("servicio"=>$servicio,"seccion"=>5,"numrep"=>$numrep));
   
       $i=173;
        $j=174;
        $x=1;
        foreach($rs as $row) {
            // RECUADRO CINCO
           
            if ($x<=3) {
                $pdf->Rect(15,$i,175,10,F);
                $pdf->Rect(195,$i+2,12,6,F);
                $pdf->SetY($j);
                $pdf->SetX(15);
                $pdf->MultiCell(172,4,$row["r_descripcionesp"], 0 ,'L', TRUE);
                if ($row["id_noaplica"]) {
                    $resas="N/A";
                } else if ($row["id_aceptado"]) {
                    $resas="SI";
                } else {
                    $pdf->SetTextColor(255, 0,0);
                    $resas="NO";
                }
              
                $pdf->SetY($j+3);
                $pdf->SetX(199);
                $pdf->MultiCell(8,2,$resas, 0 ,'L', TRUE);
                $i=$i+12;
                $j=$j+12;
                $x++;
                $pdf->SetTextColor(0, 0,0);
            } else {
                
                $i=$i+27;
                $j=$j+27;
                $pdf->Rect(15,$i,175,10,F);
                $pdf->Rect(195,$i+2,12,6,F);
                
                
                $pdf->SetY($j);
                $pdf->SetX(15);
                $pdf->MultiCell(172,4,$row["r_descripcionesp"], 0 ,'L', TRUE);
                if ($row["id_aceptado"]) {
                    $resas="SI";
                } else {
                    $pdf->SetTextColor(255, 0,0);
                    $resas="NO";
                }
                $pdf->SetY($j+3);
                $pdf->SetX(199);
                $pdf->MultiCell(8,2,$resas, 0 ,'L', TRUE);
                $pdf->SetTextColor(0, 0,0);
            }
            if($x==4)break;
        }
       
        
        // pagina 2
        
        $pdf->AddPage();
        
        
        $pdf->SetY(38);
        $pdf->SetX(16);
        $pdf->ChapterTitle('RECOMENDACIONES');
        
        $pdf->SetFillColor(184,211,235);
        $pdf->SetFont('Arial','',8);
        
        $ssql="SELECT ins_detalleabierta.ida_descripcionreal 
FROM ins_detalleabierta WHERE ins_detalleabierta.ida_claveservicio =  '3' 
AND ins_detalleabierta.ida_numseccion =  '6' AND ins_detalleabierta.ida_numreporte =  '$numrep'";
        
        $rs=DatosAbierta::consultaAbiertoDetallexSeccion($servicio,6,$numrep,"ins_detalleabierta");
        $x=14;
        $y=50;
        $cont=0;
       
        foreach($rs as $row) {
          
            $pdf->Rect(10,$y-6,200,30,F);
            $pdf->SetY($y);
            $pdf->SetX($x);
            $pdf->multiCell(180,4,$row["ida_descripcionreal"], 0, 'C' , FALSE);
            $y=$y+55;
        }
        
        
        // pagina 3
        
        $pdf->AddPage();
        // SUBTITULOS
        $pdf->SetY(58);
        $pdf->SetX(16);
        $pdf->ChapterTitle('RESULTADOS DEL ANALISIS DE LA MUESTRA DE AGUA');
        
        
        
        
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
        
        
        //*** DATOS
        $pdf->SetFillColor(216,231,243);
        $pdf->SetFont('Arial','',10);
        $ssql="SELECT ide_idmuestra, cad_descripcionesp, rm_fechahora  FROM (SELECT ins_detalleestandar.ide_idmuestra
 FROM
ins_detalleestandar Inner Join cue_secciones ON cue_secciones.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND cue_secciones.sec_numseccion = ins_detalleestandar.ide_numseccion 
WHERE ins_detalleestandar.ide_claveservicio =  ".$servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND cue_secciones.sec_indagua =  '1' 
GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte) AS A 
INNER JOIN (SELECT aa_recepcionmuestradetalle.mue_idmuestra, aa_recepcionmuestra.rm_embotelladora, 
aa_recepcionmuestra.rm_fechahora, ca_catalogosdetalle.cad_descripcionesp FROM aa_recepcionmuestradetalle 
Inner Join aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
Inner Join ca_catalogosdetalle ON aa_recepcionmuestra.rm_embotelladora = ca_catalogosdetalle.cad_idopcion
Inner Join ca_catalogos ON ca_catalogosdetalle.cad_idcatalogo = ca_catalogos.ca_idcatalogo 
WHERE ca_catalogos.ca_idcatalogo =  '43' GROUP BY aa_recepcionmuestradetalle.mue_idmuestra ) AS b 
ON  ide_idmuestra=mue_idmuestra";
        $rs=Conexion::ejecutarQuery($ssql,array("numrep"=>$numrep));
      
       foreach($rs as $row) {
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
        

        if ($nversion==1) {
            // nuevo formato
            /*$ssql="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion,ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, cue_reactivosestandardetalle.red_estandar, cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
             Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion WHERE
             ins_detalleestandar.ide_claveservicio =  '3' AND ins_detalleestandar.ide_numreporte =  '$numrep' AND
             cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
             ORDER BY if(ins_detalleestandar.ide_numcaracteristica3=21,1, if(ins_detalleestandar.ide_numcaracteristica3=14,2,  if(ins_detalleestandar.ide_numcaracteristica3=19,6,  if(ins_detalleestandar.ide_numcaracteristica3=4,7,  if(ins_detalleestandar.ide_numcaracteristica3=5,9,  if(ins_detalleestandar.ide_numcaracteristica3=9,8,  if(ins_detalleestandar.ide_numcaracteristica3=6,10, ins_detalleestandar.ide_numcaracteristica3+2))))))) ASC";*/
            
            $ssql="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion,
ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, 
cue_reactivosestandardetalle.red_estandar,
cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo, 
cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado,
if(ins_detalleestandar.ide_numcaracteristica3=21,1, if(ins_detalleestandar.ide_numcaracteristica3=14,2,if(ins_detalleestandar.ide_numcaracteristica3=2,3,
if(ins_detalleestandar.ide_numcaracteristica3=3,4,if(ins_detalleestandar.ide_numcaracteristica3=1,5, 
if(ins_detalleestandar.ide_numcaracteristica3=19,6,if(ins_detalleestandar.ide_numcaracteristica3=4,7,
if(ins_detalleestandar.ide_numcaracteristica3=9,8, if(ins_detalleestandar.ide_numcaracteristica3=5,9,if(ins_detalleestandar.ide_numcaracteristica3=6,10, 
if(ins_detalleestandar.ide_numcaracteristica3=8,11,if(ins_detalleestandar.ide_numcaracteristica3=20,14, if(ins_detalleestandar.ide_numcaracteristica3=17,15,
 if(ins_detalleestandar.ide_numcaracteristica3=18,16, ins_detalleestandar.ide_numcaracteristica3 ) ) ) ) ) ) ) ) ) ) ) ))) as numercacion
FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio 
AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo 
AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 
AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion 
WHERE
ins_detalleestandar.ide_claveservicio =  ".$servicio." AND ins_detalleestandar.ide_numreporte =:numrep' AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
ORDER BY if(ins_detalleestandar.ide_numcaracteristica3=21,1, if(ins_detalleestandar.ide_numcaracteristica3=14,2,if(ins_detalleestandar.ide_numcaracteristica3=2,3,if(ins_detalleestandar.ide_numcaracteristica3=3,4,
if(ins_detalleestandar.ide_numcaracteristica3=1,5, if(ins_detalleestandar.ide_numcaracteristica3=19,6,if(ins_detalleestandar.ide_numcaracteristica3=4,7,if(ins_detalleestandar.ide_numcaracteristica3=9,8, 
if(ins_detalleestandar.ide_numcaracteristica3=5,9,if(ins_detalleestandar.ide_numcaracteristica3=6,10, if(ins_detalleestandar.ide_numcaracteristica3=8,11,if(ins_detalleestandar.ide_numcaracteristica3=20,14,
 if(ins_detalleestandar.ide_numcaracteristica3=17,15, if(ins_detalleestandar.ide_numcaracteristica3=18,16, ins_detalleestandar.ide_numcaracteristica3 ) ) ) ) ) ) ) ) ) ) ) ))) ASC";
            
            $rs=Conexion::ejecutarQuery($ssql,array("numrep"=>$numrep));
            $i=86;
            $j=87;
            $np=1;
            foreach($rs as $row) {
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
                $pdf->multiCell(58,4,$row["red_estandar"], 0, 'C' , TRUE);
                
                $tipocat=$row["red_tipodato"];
                switch ($tipocat) {
                    case "C" :
                        $valop=round($row["ide_valorreal"],1);
                        $numcat=$row["red_clavecatalogo"];
                        // busca el valor en el catalogo
                       
                        $valreal=DatosCatalogoDetalle::getCatalogoDetalle($numcat,$valop,"ca_catalogosdetalle");
                        
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
                if (($row["ide_numcaracteristica3"]==17) || ($row["ide_numcaracteristica3"]==18)) {
                    if ($valreal>=100)
                        $valreal="Incontables";
                }
                $pdf->multiCell(58,4,$valreal, 0, 'C' , TRUE);
                $i=$i+8;
                $j=$j+8;
                $pdf->SetTextColor(0, 0,0);
                $pdf->SetFont('Arial','',8);
                $np++;
            }
        } else { //formato anterior
            $ssql="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion,
ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, cue_reactivosestandardetalle.red_estandar, 
cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo, 
cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado 
FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle 
ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND 
cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo
 AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente 
AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 
AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 
AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio 
AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion WHERE
ins_detalleestandar.ide_claveservicio =  ".$servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
ORDER BY ins_detalleestandar.ide_numcaracteristica3 ASC";
            $rs=Conexion::ejecutarQuery($ssql,array("numrep"=>$numrep));
          
            $i=86;
            $j=87;
            $np=1;
            foreach($rs as $row) {
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
                     
                        $valreal=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valop);
                     
                        break;
                    case "N" :
                        $numreac=$row["ide_numcaracteristica3"];
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
                if (($numreac==17) || ($numreac==18))
                {
                    $pdf->multiCell(58,4,"Incontables", 0, 'C' , TRUE);
                }else{
                    $pdf->multiCell(58,4,$valreal, 0, 'C' , TRUE);
                }
               
                $i=$i+8;
                $j=$j+8;
                $pdf->SetTextColor(0, 0,0);
                $pdf->SetFont('Arial','',8);
                $np++;
            }
          
        }
        // pagina 4
        
        
        $pdf->AddPage();
        // RECUADRO GENERAL
        $pdf->SetFillColor(152,185,235);
        $pdf->Rect(10,66,200,185,F);
        // SUBTITULOS
        $pdf->SetY(58);
        $pdf->SetX(16);
        $pdf->ChapterTitle('CHECK LIST DE CAMPO');
        
        $ssql="SELECT ins_detalle.id_claveservicio, ins_detalle.id_numreporte, ins_detalle.id_numseccion, ins_detalle.id_numreactivo, ins_detalle.id_aceptado, ins_detalle.id_noaplica, cue_reactivos.r_descripcionesp FROM
ins_detalle Inner Join cue_reactivos ON cue_reactivos.ser_claveservicio = ins_detalle.id_claveservicio AND cue_reactivos.sec_numseccion = ins_detalle.id_numseccion AND cue_reactivos.r_numreactivo = ins_detalle.id_numreactivo
WHERE ins_detalle.id_claveservicio =  '3' AND ins_detalle.id_numreporte =  '$numrep' AND ins_detalle.id_numseccion =  '2'
GROUP BY ins_detalle.id_numreactivo";
        
        $rs=DatosPond::listaReactivos($servicio,2,$numrep);
    
       $i=69;
        $j=70;
        foreach($rs as $row) {
            $pdf->SetFillColor(184,211,235);
            $pdf->SetFont('Arial','',11);
            $pdf->Rect(13,$i,16,10,F);
            $pdf->SetY($j);
            $pdf->SetX(14);
            $pdf->multiCell(12,6,$row["id_numreactivo"], 0, 'C' , TRUE);
            
            $pdf->SetFont('Arial','',8);
            $pdf->Rect(32,$i,150,10,F);
            $pdf->SetY($j);
            $pdf->SetX(32);
            $pdf->multiCell(150,4,$row["r_descripcionesp"], 0, 'L' , TRUE);
            
            $pdf->SetFillColor(216,231,243);
            //	$pdf->SetFont('Arial','B',12);
            $pdf->Rect(189,$i,16,10,F);
            if ($row["id_aceptado"]) {
                $resas="SI";
            } else if ($row["id_noaplica"]) {
                $resas="N/A";
            } else {
                $pdf->SetTextColor(255, 0,0);
                $resas="NO";
            }
            
            $pdf->SetY($j+2);
            $pdf->SetX(189);
            $pdf->MultiCell(16,4,$resas, 0 ,'C', TRUE);
            $pdf->SetTextColor(0, 0,0);
            
            $i=$i+12;
            $j=$j+12;
        }
        
        
        
        // pagina 5
        
        $pdf->AddPage();
        // SUBTITULOS
        $pdf->SetY(38);
        $pdf->SetX(16);
        $pdf->ChapterTitle('FOTOGRAFIAS');
        
        
        
        // RECUADRO GENERAL
        $pdf->SetFillColor(152,185,235);
        $pdf->Rect(10,44,200,200,F);
        
        
        $pdf->SetFont('Arial','',8);
      
        $ssql="SELECT ins_imagendetalle.id_ruta, ins_imagendetalle.id_descripcion FROM ins_imagendetalle WHERE
ins_imagendetalle.id_imgclaveservicio =  '3' AND ins_imagendetalle.id_imgnumreporte =  '$numrep' AND ins_imagendetalle.id_presentar =  '-1'";
        $rs=DatosImagenDetalle::getImagenDetallePresentar($servicio,$numrep,"ins_imagendetalle");
    
         $x=14;
        $y=60;
        $cont=0;
        $Band=0;
      //  $rs=null;
        foreach($rs as $row) {
            $ee = RAIZ."/".$row["id_ruta"];
  //         echo "<br>".$ee;
            if ($cont<6) {
                
                if (($cont==0) || ($cont==3)){
                    $pdf->Image($ee,$x,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    
                }
                else if (($cont==1) || ($cont==4) ){
                    $pdf->Image($ee,$x+66,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+66);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                }
                else if (($cont==2) || ($cont==5) ){
                    $pdf->Image($ee,$x+132,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+132);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    $y=$y+90;
                }
                // $cont++;
            } else if ($cont>=6 && $cont<12) {
                // pagina 6
                if ($Band==0) {
                    $pdf->AddPage();
                    $pdf->SetFillColor(152,185,235);
                    $pdf->Rect(10,44,200,200,F);
                    $x=14;
                    $y=60;
                    $Band++;
                }
                if (($cont==6) || ($cont==9)){
                    $pdf->Image($ee,$x,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    
                }
                else if (($cont==7) || ($cont==10) ){
                    $pdf->Image($ee,$x+66,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+66);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                }
                else if (($cont==8) || ($cont==11) ){
                    $pdf->Image($ee,$x+132,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+132);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    $y=$y+90;
                }
                
            }
            $cont++;
        }
        
        // pagina 5
        
        
        $pdf->Output();
    }
    
    public function reporteAnalisis(){
      
       
        define('RAIZ',"fotografias");
        $numrep=filter_input(INPUT_GET,"nrep",FILTER_SANITIZE_NUMBER_INT);
        
        //$a=html_entity_decode("&aacute;");
        //$a=$reportSubtitle = iconv('UTF-8', 'windows-1252', "&aacute;");
        //$e=html_entity_decode("&eacute;");
        //$i=html_entity_decode("&iacute;");
        //$o=html_entity_decode("&oacute;");
        //$u=html_entity_decode("&uacute;");
        $a=$reportSubtitle = iconv('UTF-8', 'windows-1252', "á");
        $e=$reportSubtitle = iconv('UTF-8', 'windows-1252', "é");
        $i=$reportSubtitle = iconv('UTF-8', 'windows-1252', "í");
        $o=$reportSubtitle = iconv('UTF-8', 'windows-1252', "ó");
        $u=$reportSubtitle = iconv('UTF-8', 'windows-1252', "ú");
        $n=utf8_decode("&ntilde;");
        
        
        $pdf=new PDFAnalisis('p','mm','letter');
        $pdf->AddPage();
        
        
        $pdf->SetLineWidth(0.4);   // ancho de linea
        $pdf->SetFillColor(0,0,0);
        $pdf->Rect(23,35,180,1);
        
        
        // RECUADRO GENERAL
        $pdf->SetFillColor(152,185,235);
        
        
        
        // SUBTITULOS
        $pdf->Image('img/gepp.png' , 23 ,18, 40 , 15,'PNG');
        
        $pdf->SetY(20);
        $pdf->SetX(16);
        $pdf->ChapterTitle('POST MIX');
        
        $pdf->SetY(28);
        $pdf->SetX(16);
        $pdf->ChapterTitle('ANALISIS DE LIBERACION DE AGUA');
        
        
        //**** ETIQUETAS
        
        $pdf->SetFont('Arial','',8);
        $pdf->SetY(58);
        $pdf->SetX(172);
        $pdf->Cell(25,4,'(Fecha de emisi'.$o.'n del reporte) ', 0 ,'R', TRUE);
        
        $pdf->SetLineWidth(0.4);   // ancho de linea
        $pdf->SetFillColor(0,0,0);
        $pdf->Rect(150,57,50,0);
        
        $pdf->SetFont('Arial','',10);
        $pdf->SetY(70);
        $pdf->SetX(23);
        $pdf->multiCell(180,6,'Por medio del presente documento se emiten los resultados del an'.$a.'lisis fisicoqu'.$i.'micos y/o microbiol'.$o.'gicos de la muestra tomada del establecimiento, as'.$i.' como la validaci'.$o.'n de las condiciones del establecimiento para obtener la aprobaci'.$o.'n del servicio de distribuci'.$o.'n de productos PEPSI a trav'.$e.'s de un equipo post mix.', 0, 'L' , FALSE);
        
        
        
        
        $pdf->SetFillColor(152,185,235);
        
        //$pdf->Rect(11,52,180,4,F);
        // RECUADRO DOS
        $pdf->Rect(23,92,180,8,F);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetY(94);
        $pdf->SetX(23);
        $pdf->Cell(75,4,'Informaci'.$o.'n de establecimiento', 'N', 'L' , false);
        
        $pdf->SetY(105);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(75,4,'Nombre del establecimiento', 0, 'L' , FALSE);
        
        $pdf->SetLineWidth(0.4);   // ancho de linea
        $pdf->SetFillColor(0,0,0);
        $pdf->Rect(83,109,120,0);
        $pdf->Rect(60,117,143,0);
        $pdf->Rect(60,125,143,0);
        $pdf->Rect(35,134,30,0);
        $pdf->Rect(85,134,45,0);
        $pdf->Rect(150,134,54,0);
        
        $pdf->SetY(113);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Direcci'.$o.'n ', 0, 'L' , FALSE);
        
        $pdf->SetY(130);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'C.P. ', 0, 'R' , FALSE);
        
        $pdf->SetY(130);
        $pdf->SetX(68);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Ciudad', 0, 'R' , FALSE);
        
        $pdf->SetY(130);
        $pdf->SetX(135);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Estado', 0, 'R' , FALSE);
        $servicio=3;
        // Coloca Datos
        $ssql="SELECT  ca_unegocios.cue_clavecuenta, ca_unegocios.une_id, ca_unegocios.une_descripcion,
ca_unegocios.une_idpepsi, ca_unegocios.une_idcuenta, ca_unegocios.une_dir_calle, ca_unegocios.une_dir_numeroext,
ca_unegocios.une_dir_numeroint, ca_unegocios.une_dir_manzana, ca_unegocios.une_dir_lote, ca_unegocios.une_dir_colonia,
ca_unegocios.une_dir_delegacion, ca_unegocios.une_dir_municipio, ca_unegocios.une_dir_estado, ca_unegocios.une_dir_cp,
ca_unegocios.une_dir_referencia, ca_unegocios.une_dir_telefono, ins_generales.i_fechavisita, ins_generales.i_mesasignacion,
ins_generales.i_horaentradavis, ins_generales.i_horasalidavis, ins_generales.i_responsablevis, ins_generales.i_puestoresponsablevis,
ins_generales.i_numreporte,  ins_generales.i_fechafinalizado, ca_inspectores.ins_nombre FROM ca_unegocios
Inner Join ins_generales ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
Inner Join ca_inspectores ON ins_generales.i_claveinspector = ca_inspectores.ins_clave
WHERE ins_generales.i_claveservicio =  ".$servicio." AND ins_generales.i_numreporte = :numrep";
        
        $rs=Conexion::ejecutarQuery($ssql,array("numrep"=>$numrep));
         //echo $treg;
        foreach($rs as $row) {
            $pdf->SetFont('Arial','',8);
            $pdf->SetY(53);
            $pdf->SetX(166);
            $pdf->multiCell(60,4,Utilerias::formato_fecha($row["i_fechafinalizado"]), 0, 'L' , FALSE);
            
            $pdf->SetY(105);
            $pdf->SetX(85);
            $pdf->multiCell(140,4,$row["une_descripcion"], 0, 'L' , false);
            
            
            $pdf->SetY(113);
            $pdf->SetX(65);
            $pdf->multiCell(160,4,$row["une_dir_calle"]." No. ".$row["une_dir_numeroext"]. " COLONIA ".$row["une_dir_colonia"], 0, 'L' , false);
            
            $pdf->SetY(130);
            $pdf->SetX(45);
            $pdf->multiCell(60,4,$row["une_dir_cp"], 0, 'L' , false);
            
            $pdf->SetY(130);
            $pdf->SetX(95);
            $pdf->multiCell(60,4,$row["une_dir_municipio"], 0, 'L' , false);
            
            $pdf->SetY(130);
            $pdf->SetX(155);
            $pdf->multiCell(60,4,$row["une_dir_estado"], 0, 'L' , false);
            
            $pdf->SetY(161);
            $pdf->SetX(89);
            $pdf->multiCell(60,4,$row["ins_nombre"], 0, 'L' , false);
            
        }
        
        
        
        $pdf->SetFillColor(152,185,235);
        $pdf->Rect(23,140,180,8,F);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetY(142);
        $pdf->SetX(23);
        $pdf->Cell(75,4,'Informaci'.$o.'n de la visita', 'N', 'L' , false);
        $pdf->Rect(80,157,122,0);
        
        $pdf->SetY(153);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Fecha de la toma de muestra ', 0, 'L' , FALSE);
        $pdf->Rect(80,165,122,0);
        
        $pdf->SetY(161);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Nombre quien realiza el muestreo ', 0, 'L' , FALSE);
        $pdf->Rect(80,172,122,0);
        
        $pdf->SetY(169);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Laboratorio que realiza los an'.$a.'lisis ', 0, 'L' , FALSE);
        
        
        $pdf->SetY(178);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Nombre de quien recibe la muestra ', 0, 'L' , FALSE);
        $pdf->Rect(80,181,122,0);
        
        
        // datos de la muestra
        $ssql1="SELECT ide_idmuestra, cad_descripcionesp, rm_fechahora, rm_personarecibe  FROM
(SELECT ins_detalleestandar.ide_idmuestra FROM ins_detalleestandar Inner Join cue_secciones
ON cue_secciones.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND cue_secciones.sec_numseccion = ins_detalleestandar.ide_numseccion
WHERE ins_detalleestandar.ide_claveservicio =  $servicio AND ins_detalleestandar.ide_numreporte = :numrep AND cue_secciones.sec_indagua =  '1'
GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte) AS A
INNER JOIN (SELECT aa_recepcionmuestradetalle.mue_idmuestra, aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestra.rm_personarecibe, aa_recepcionmuestra.rm_fechahora, 
ca_catalogosdetalle.cad_descripcionesp FROM aa_recepcionmuestradetalle Inner Join aa_recepcionmuestra 
ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
Inner Join ca_catalogosdetalle ON aa_recepcionmuestra.rm_embotelladora = ca_catalogosdetalle.cad_idopcion
Inner Join ca_catalogos ON ca_catalogosdetalle.cad_idcatalogo = ca_catalogos.ca_idcatalogo 
WHERE ca_catalogos.ca_idcatalogo =  '43' 
GROUP BY aa_recepcionmuestradetalle.mue_idmuestra ) AS b ON  ide_idmuestra=mue_idmuestra";
        $rs1=Conexion::ejecutarQuery($ssql1,array("numrep"=>$numrep));
   
        //echo $treg;
        foreach($rs1 as $row1) {
            $pdf->SetFont('Arial','',8);
            $pdf->SetY(153);
            $pdf->SetX(89);
            $pdf->multiCell(60,4,Utilerias::formato_fecha($row1["rm_fechahora"]), 0, 'L' , false);
            
            $pdf->SetFont('Arial','',8);
            $pdf->SetY(168);
            $pdf->SetX(89);
            $pdf->multiCell(60,4,$row1["cad_descripcionesp"], 0, 'L' , false);
            
            $pdf->SetFont('Arial','',8);
            $pdf->SetY(177);
            $pdf->SetX(89);
            $pdf->multiCell(60,4,$row1["rm_personarecibe"], 0, 'L' , false);
            
        }
        
        $pdf->SetFillColor(152,185,235);
        $pdf->Rect(23,191,136,8,F);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetY(193);
        $pdf->SetX(23);
        $pdf->Cell(75,4,'Validaci'.$o.'n del establecimiento realizada por Muesmerc', 'N', 'L' , false);
        
        $pdf->Image('img/muesmerc_logo.png' , 162 ,188, 40 , 13,'PNG');
        
        
        $pdf->SetY(203);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'El establecimiento dispone de un sistema de tratamiento y purificaci'.$o.'n de agua', 0, 'L' , FALSE);
        
        $pdf->SetY(211);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Cuenta el establecimiento con dep'.$o.'sito y lineas de agua que eviten su contaminacion', 0, 'L' , FALSE);
        
        $pdf->SetY(219);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Tipo de agua que se abastece al establecimiento (red municipal, particular, etc.)', 0, 'L' , FALSE);
        
        $pdf->SetY(227);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'El dep'.$o.'sito de agua esta resguardada bajo llave y solo personal autorizado tiene acceso', 0, 'L' , FALSE);
        
        $pdf->SetY(235);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'El sistema de tratamiento de agua incluye l'.$a.'mpara de luz UV', 0, 'L' , FALSE);
        
        $pdf->SetY(243);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Existe registro de control de operaci'.$o.'n de los equipos del tratamiento de agua', 0, 'L' , FALSE);
        
        $pdf->SetY(251);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Existe equipo necesario para regeneraci'.$o.'n y repuestos de los equipos de tratamiento', 0, 'L' , FALSE);
        
        
        // COLOCO DATOS RESULTADO
        
        $ssql2="SELECT if(id_numreactivo=8,1,if(id_numreactivo=3,2,if(id_numreactivo=2,4,if(id_numreactivo=12,5,if(id_numreactivo=9,6,if(id_numreactivo=14,7,0)))))) as nvo_orden,
ins_detalle.id_claveservicio, ins_detalle.id_numreporte, ins_detalle.id_numseccion, ins_detalle.id_numreactivo,
ins_detalle.id_aceptado, ins_detalle.id_noaplica
FROM
ins_detalle Inner Join cue_reactivos ON cue_reactivos.ser_claveservicio = ins_detalle.id_claveservicio AND cue_reactivos.sec_numseccion = ins_detalle.id_numseccion AND cue_reactivos.r_numreactivo = ins_detalle.id_numreactivo
WHERE ins_detalle.id_claveservicio =  ".$servicio." AND ins_detalle.id_numreporte =  :numrep AND ins_detalle.id_numseccion =  '2'
AND (if(id_numreactivo=8,1,if(id_numreactivo=3,2,if(id_numreactivo=2,4,if(id_numreactivo=12,5,if(id_numreactivo=9,6,if(id_numreactivo=14,7,0)))))))>0
ORDER BY if(id_numreactivo=8,1,if(id_numreactivo=3,2,if(id_numreactivo=2,4,if(id_numreactivo=12,5,if(id_numreactivo=9,6,if(id_numreactivo=14,7,0))))))";
        $rs2=Conexion::ejecutarQuery($ssql2,array("numrep"=>$numrep));
        $i=203;
        $j=1;
        foreach($rs2 as $row2) {
            if ($row2["id_noaplica"]) {
                $resas="N/A";
                $pdf->SetFont('Arial','',8);
                $pdf->SetY($i);
                $pdf->SetX(192);
                $pdf->multiCell(60,4,$resas, 0, 'L' , false);
            } else if ($row2["id_aceptado"]) {
                $pdf->Image('img/palomita.png' , 192 ,$i, 5 , 5,'PNG');
            } else {
                $pdf->Image('img/tache.png' , 192 ,$i, 5 , 5,'PNG');
            }
            if ($j==2){
                $i=$i+16;
            } else {
                $i=$i+8;
            }
            $j=$j+1;
        }
        
        $ssql3="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion, 
ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, cue_reactivosestandardetalle.red_estandar, 
cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo,
cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado FROM ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio 
AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion
AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo
AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente
AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1
AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2
AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
WHERE ins_detalleestandar.ide_claveservicio =  ".$servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1' AND ins_detalleestandar.ide_numcaracteristica3=21";
        $rs3=Conexion::ejecutarQuery($ssql3,array("numrep"=>$numrep));
        foreach($rs3 as $row3) {
            $valop=round($row3["ide_valorreal"],1);
            $numcat=$row3["red_clavecatalogo"];
            // busca el valor en el catalogo
            $sqlcat="SELECT * FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '".$numcat."' AND
ca_catalogosdetalle.cad_idopcion =  '".$valop."';";
            $valreal=DatosCatalogoDetalle::getCatalogoDetalle($numcat,$valop,"ca_catalogosdetalle");
          
            $pdf->SetFont('Arial','',8);
            $pdf->SetY(221);
            $pdf->SetX(183);
            $pdf->multiCell(25,4,$valreal, 0, 'C' , false);
            
            
        }
        
        
        //*** pagina dos
        $pdf->AddPage();
        
        $pdf->SetY(20);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Las condiciones con las que se recibe la muestra de agua para efectuar el an'.$a.'lisis es:', 0, 'L' , FALSE);
        
        $pdf->SetY(26);
        $pdf->SetX(73);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Aceptable', 0, 'L' , FALSE);
        
        $pdf->SetY(26);
        $pdf->SetX(123);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'No Aceptable', 0, 'L' , FALSE);
        
        
        
        $pdf->SetY(40);
        $pdf->SetX(23);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Tipo de an'.$a.'lisis a realizar', 0, 'L' , FALSE);
        
        $pdf->SetY(46);
        $pdf->SetX(73);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Fisicoquimicos', 0, 'L' , FALSE);
        
        
        $pdf->SetY(46);
        $pdf->SetX(123);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,4,'Microbiologicos', 0, 'L' , FALSE);
        
        
        $pdf->SetFillColor(152,185,235);
        $pdf->Rect(23,60,180,8,F);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetY(62);
        $pdf->SetX(23);
        $pdf->Cell(75,4,'Resultado de an'.$a.'lisis de agua', 'N', 'L' , false);
        
        
        
        // RECUADRO GENERAL
        //$pdf->SetFillColor(152,185,235);
        
        //**** ETIQUETAS
        $pdf->SetFont('Arial','B',8);
        $pdf->Rect(27,73,174,6,F);
        $pdf->SetY(74);
        $pdf->SetX(27);
        $pdf->multiCell(176,4,'ANALISIS FISICOQUIMICOS DE AGUA', 0, 'C' , FALSE);
        
        $pdf->Rect(27,80,58,6);
        $pdf->SetY(82);
        $pdf->SetX(27);
        $pdf->multiCell(58,4,'CARACTERISTICA', 0, 'C' , FALSE);
        
        $pdf->Rect(85,80,58,6);
        $pdf->SetY(82);
        $pdf->SetX(85);
        $pdf->multiCell(58,4,'ESPECIFICACION', 0, 'C' , FALSE);
        
        $pdf->Rect(143,80,58,6);
        $pdf->SetY(82);
        $pdf->SetX(144);
        $pdf->multiCell(58,4,'RESULTADO', 0, 'C' , FALSE);
        
        $pdf->Rect(27,160,174,6,F);
        $pdf->SetY(161);
        $pdf->SetX(27);
        $pdf->multiCell(176,4,'ANALISIS MICROBIOLOGICOS DE AGUA', 0, 'C' , FALSE);
        
        $pdf->Rect(27,166,58,6);
        $pdf->SetY(168);
        $pdf->SetX(27);
        $pdf->multiCell(58,4,'CARACTERISTICA', 0, 'C' , FALSE);
        
        $pdf->Rect(85,166,58,6);
        $pdf->SetY(168);
        $pdf->SetX(85);
        $pdf->multiCell(58,4,'ESPECIFICACION', 0, 'C' , FALSE);
        
        $pdf->Rect(143,166,58,6);
        $pdf->SetY(168);
        $pdf->SetX(144);
        $pdf->multiCell(58,4,'RESULTADO', 0, 'C' , FALSE);
        
        $pdf->SetFont('Arial','',8);
        
        $ssql4="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion,
ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, cue_reactivosestandardetalle.red_estandar,
 cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo,
 cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado FROM ins_detalleestandar 
Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio 
AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo
 AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente 
AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 
AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio 
AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
 WHERE
ins_detalleestandar.ide_claveservicio = ".$servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
and (ins_detalleestandar.ide_numcaracteristica3<>14 and ins_detalleestandar.ide_numcaracteristica3<>20 
and ins_detalleestandar.ide_numcaracteristica3<>21 and ins_detalleestandar.ide_numcaracteristica3<>15)
ORDER BY if(ins_detalleestandar.ide_numcaracteristica3=2,1, if(ins_detalleestandar.ide_numcaracteristica3=1,2,  
if(ins_detalleestandar.ide_numcaracteristica3=12,7,  if(ins_detalleestandar.ide_numcaracteristica3=4,11,  
if(ins_detalleestandar.ide_numcaracteristica3=5,5,  if(ins_detalleestandar.ide_numcaracteristica3=9,4,  
if(ins_detalleestandar.ide_numcaracteristica3=6,6, if(ins_detalleestandar.ide_numcaracteristica3=13,8,
 if(ins_detalleestandar.ide_numcaracteristica3=19,10, ins_detalleestandar.ide_numcaracteristica3))))))))) ASC";
        $rs4=Conexion::ejecutarQuery($ssql4,array("numrep"=>$numrep));
      
        $num_reg = sizeof($rs4);
        if ($num_reg>0){
            // condiciones de la muestra
            $pdf->Image('img/palomita.png' , 65 ,26, 5 , 5,'PNG');
            $pdf->Image('img/palomita.png' , 65 ,46, 5 , 5,'PNG');
            $pdf->Image('img/palomita.png' , 115 ,46, 5 , 5,'PNG');
            
            $i=86;
            $j=87;
            $x=1;
            $valreal="";
            // coloca nombre y estandar
            for ($x=1; $x<14; $x++){
                switch($x) {
                    case '1':
                        $concepto="OLOR";
                        $standar="SIN OLOR";
                        $numop=2;
                        break;
                    case '2':
                        $concepto="SABOR";
                        $standar="SIN SABOR EXTRANO";
                        $numop=1;
                        break;
                    case '3':
                        $concepto="COLOR";
                        $standar="SIN COLOR";
                        $numop=3;
                        break;
                    case '4':
                        $concepto="SOLIDOS DISUELTOS TOTALES";
                        $standar="<=750 mg/L";
                        $numop=9;
                        break;
                    case '5':
                        $concepto="ALCALINIDAD";
                        $standar="<=175 mg/L CaCO3";
                        $numop=5;
                        break;
                    case '6':
                        $concepto="DUREZA + ALCALINIDAD";
                        $standar="<=400 mg/L CaCO3 ";
                        $numop=6;
                        break;
                    case '7':
                        $concepto="HIERRO";
                        $standar="<=0.1 mg/L";
                        $numop=12;
                        break;
                    case '8':
                        $concepto="MANGANESO";
                        $standar="<=0.05 mg/L ";
                        $numop=13;
                        break;
                    case '9':
                        $concepto="CLORO TOTAL";
                        $standar="<=0.5 mg/L";
                        $numop=8;
                        break;
                    case '10':
                        $concepto="TURBIDEZ";
                        $standar="<=1 NTU ";
                        $numop=19;
                        break;
                    case '11':
                        $concepto="PH";
                        $standar="6.5 - 8.5 ";
                        $numop=4;
                        break;
                    case '12':
                        $concepto="COLIFORMES TOTALES";
                        $standar="0 UFC/100ml ";
                        $numop=17;
                        break;
                    case '13':
                        $concepto="E COLI";
                        $standar="0 UFC/100ml ";
                        $numop=18;
                        break;
                }
                $pdf->Rect(27,$i,58,6);
                $pdf->SetY($j);
                $pdf->SetX(29);
                $pdf->multiCell(58,4,$concepto, 0, 'C' , FALSE);
                
                $pdf->Rect(85,$i,58,6);
                $pdf->SetY($j);
                $pdf->SetX(89);
                $pdf->multiCell(58,4,$standar, 0, 'C' , FALSE);
                $pdf->Rect(143,$i,58,6);
                
                // busca valor real
                if ($x==6) {
                    $sql5="SELECT SUM(ins_detalleestandar.ide_valorreal) AS VALTOT
FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
WHERE  ins_detalleestandar.ide_claveservicio =  ".$servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
and (ins_detalleestandar.ide_numcaracteristica3=6 OR ins_detalleestandar.ide_numcaracteristica3=5)";
                    $rs5=Conexion::ejecutarQuery($sql5,array("numrep"=>$numrep));
                    $num_reg = sizeof($rs5);
                    if ($num_reg>0){
                        foreach($rs5 as $row5) {
                            $valreal=round($row5["VALTOT"],3);
                            
                        }
                        if ($valreal>400) {
                            $pdf->SetTextColor(255, 0,0);
                        }
                    } else {
                        $valreal="*";
                    }
                } else {
                    
                    $sql5="SELECT ins_detalleestandar.ide_valorreal,  ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado
FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
WHERE  ins_detalleestandar.ide_claveservicio =  ".$servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
and ins_detalleestandar.ide_numcaracteristica3=$numop";
                    $rs5=Conexion::ejecutarQuery($sql5,array("numrep"=>$numrep));
                    $num_reg = sizeof($rs5);
                    if ($num_reg>0){
                        foreach($rs5 as $row5) {
                            $tipocat=$row5["red_tipodato"];
                            switch ($tipocat) {
                                case "C" :
                                    $valop=round($row5["ide_valorreal"],1);
                                    $numcat=$row5["red_clavecatalogo"];
                                    // busca el valor en el catalogo
                                    $sqlcat="SELECT * FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '".$numcat."' AND
	ca_catalogosdetalle.cad_idopcion =  '".$valop."';";
                                    $valreal=DatosCatalogoDetalle::getCatalogoDetalle($numcat,$valop);
                                   
                                    break;
                                case "N" :
                                    if (($row5["ide_numcaracteristica3"]==17) || ($row5["ide_numcaracteristica3"]==18)) {
                                        //echo "entre a validacion 17 y 18";
                                        if (round($row5["ide_valorreal"],3)>=100){
                                            //			$pdf->SetTextColor(255, 0,0);
                                            $valreal="Incontables";
                                        } else {
                                            $valreal=round($row5["ide_valorreal"],3);
                                        }  // fin de mayor a 100
                                    } else {
                                        $valreal=round($row5["ide_valorreal"],3);
                                    }// fin de caracteristica 17 y 18
                                    break;
                            } // switch
                            $pdf->Rect(143,$i,58,6);
                            if ($row5["ide_aceptado"]) {
                                $pdf->SetTextColor(0, 0,0);
                            }else{
                                $pdf->SetTextColor(255, 0,0);
                            }
                        }
                    }else{ //band=0
                        $valreal="*";
                    } // si hay registro
                }
                //$pdf->SetTextColor(0, 0,0);
                //$pdf->Rect(143,$i,58,6);
                $pdf->SetY($j);
                $pdf->SetX(145);
                $pdf->multiCell(58,4,$valreal, 0, 'C' , FALSE);
                $pdf->SetTextColor(0, 0,0);
                if ($x==11) {
                    $i=$i+26;
                    $j=$j+26;
                } else {
                    $i=$i+6;
                    $j=$j+6;
                }
                
            } // fin del for
            $pdf->SetTextColor(0, 0,0);
        } else {
            // agrega tabla vacia
            $i=86;
            $j=87;
            for ($x=1; $x<14; $x++){
                switch($x) {
                    case '1':
                        $concepto="OLOR";
                        $standar="SIN OLOR";
                        break;
                    case '2':
                        $concepto="SABOR";
                        $standar="SIN SABOR EXTRANO";
                        break;
                    case '3':
                        $concepto="COLOR";
                        $standar="SIN COLOR";
                        break;
                    case '4':
                        $concepto="SOLIDOS DISUELTOS TOTALES";
                        $standar="<=750 mg/L";
                        break;
                    case '5':
                        $concepto="ALCALINIDAD";
                        $standar="<=175 mg/L CaCO3";
                        break;
                    case '6':
                        $concepto="DUREZA + ALCALINIDAD";
                        $standar="<=400 mg/L CaCO3 ";
                        break;
                    case '7':
                        $concepto="HIERRO";
                        $standar="<=0.1 mg/L";
                        break;
                    case '8':
                        $concepto="MANGANESO";
                        $standar="<=0.05 mg/L ";
                        break;
                    case '9':
                        $concepto="CLORO TOTAL";
                        $standar="<=0.5 mg/L";
                        break;
                    case '10':
                        $concepto="TURBIDEZ";
                        $standar="<=1 NTU ";
                        break;
                    case '11':
                        $concepto="PH";
                        $standar="6.5 - 8.5 ";
                        break;
                    case '12':
                        $concepto="COLIFORMES TOTALES";
                        $standar="0 UFC/100ml ";
                        break;
                    case '13':
                        $concepto="E COLI";
                        $standar="0 UFC/100ml ";
                        break;
                }
                $pdf->Rect(27,$i,58,6);
                $pdf->SetY($j);
                $pdf->SetX(29);
                $pdf->multiCell(58,4,$concepto, 0, 'C' , FALSE);
                
                $pdf->Rect(85,$i,58,6);
                $pdf->SetY($j);
                $pdf->SetX(89);
                $pdf->multiCell(58,4,$standar, 0, 'C' , FALSE);
                $pdf->Rect(143,$i,58,6);
                
                $pdf->SetY($j);
                $pdf->SetX(145);
                $pdf->multiCell(58,4," * ", 0, 'C' , FALSE);
                if ($x==11) {
                    $i=$i+36;
                    $j=$j+36;
                } else {
                    $i=$i+6;
                    $j=$j+6;
                }
            } // for
        }  //if sin registros
        $pdf->SetY(208);
        $pdf->SetX(27);
        $pdf->multiCell(176,4,'OBSERVACIONES:', 'N', 'L' , FALSE);
        
        $pdf->SetY(222);
        $pdf->SetX(30);
        $pdf->multiCell(60,4,'* NO SE REALIZA ANALISIS', 0, 'L' , FALSE);
        
        $pdf->SetY(222);
        $pdf->SetX(80);
        $pdf->multiCell(60,4,'** NO APLICA', 0, 'L' , FALSE);
        
        
        $pdf->AddPage();
        $pdf->Rect(23,28,180,8,F);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetY(30);
        $pdf->SetX(27);
        $pdf->multiCell(176,4,'Comentarios', 'N', 'L' , FALSE);
        $pdf->SetFont('Arial','',8);
        $ssql="SELECT ins_detalleabierta.ida_descripcionreal 
FROM ins_detalleabierta WHERE ins_detalleabierta.ida_claveservicio =  '3' AND ins_detalleabierta.ida_numseccion =  '6' 
AND ins_detalleabierta.ida_numreporte =  '$numrep'";
        
        $rs=DatosAbierta::consultaAbiertoDetallexSeccion($servicio,6,$numrep, "ins_detalleabierta");
        $i=40;
        
        foreach($rs as $row) {
            $pdf->Rect(23,$i,180,17);
            $pdf->SetY($i+1);
            $pdf->SetX(24);
            $pdf->multiCell(180,4,$row["ida_descripcionreal"], 0, 'C' , FALSE);
            $i=$i+21;
        }
        
        $i=120;
        $pdf->SetFillColor(152,185,235);
        $pdf->Rect(23,$i+18,180,8,F);
        $pdf->SetFont('Arial','B',12);
        $i=$i+20;
        $pdf->SetY($i);
        $pdf->SetX(23);
        $pdf->Cell(75,4,utf8_decode('Dictamen del análisis'), 'N', 'L' , false);
        
        $i=$i+17;
        $pdf->SetFont('Arial','',10);
        $pdf->SetY($i);
        $pdf->SetX(23);
        $pdf->multiCell(180,6,'Conforme a los resultados de los an'.$a.'lisis realizados, se determina que el agua ', 0, 'L' , FALSE);
        
        $ssql5="SELECT ins_detalle.id_claveservicio, ins_detalle.id_numreporte, ins_detalle.id_numseccion, ins_detalle.id_numreactivo, ins_detalle.id_aceptado, ins_detalle.id_noaplica, cue_reactivos.r_descripcionesp FROM
ins_detalle Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
WHERE ins_detalle.id_claveservicio =  '3' AND ins_detalle.id_numseccion =  '5' AND ins_detalle.id_numreactivo =  '4' and
ins_detalle.id_numreporte =  '$numrep'";
        $rs5=DatosPond::listaReactivos($servicio,4,$numrep);
       foreach($rs5 as $row5) {
            if ($row5["id_aceptado"]) {
                $resas="CUMPLE";
            } else {
                $pdf->SetTextColor(255, 0,0);
                $resas="NO CUMPLE";
            }
        }
        
        $pdf->SetY($i);
        $pdf->SetX(156);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(50,2,$resas, 0 ,'L', FALSE);
        $pdf->SetTextColor(0, 0,0);
        
        
        $pdf->SetFont('Arial','',10);
        $pdf->SetY($i);
        $pdf->SetX(186);
        $pdf->multiCell(20,6,'con las ', 0, 'L' , FALSE);
        
        $i=$i+3;
        $pdf->Rect(148,$i,34,0);
        $i=$i+2;
        $pdf->SetY($i);
        $pdf->SetX(150);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(80,2,"Cumple/No cumple", 0 ,'L', FALSE);
        
        //$i=$i+3;
        $pdf->SetFont('Arial','',10);
        $pdf->SetY($i);
        $pdf->SetX(23);
        $pdf->multiCell(100,6,'especificaciones establecidas por PEPSICO. ', 0, 'L' , FALSE);
        $i=$i+18;
        
        
        
        $pdf->SetFont('Arial','',10);
        $pdf->SetY($i);
        $pdf->SetX(23);
        $pdf->multiCell(100,6,'Para cualquier aclaracion quedo a sus ordenes. ', 0, 'L' , FALSE);
        
        if ($i>=245) {
            $pdf->AddPage();
            $i=35;
        }
        
        $i=$i+30;
        $pdf->SetFont('Arial','B',10);
        $pdf->SetY($i);
        $pdf->SetX(23);
        $pdf->multiCell(180,6,'ATENTAMENTE', 0, 'C' , FALSE);
        
        
        // registra analista de calidad
        $i=$i+10;
        $ssql6="select rm_embotelladora, cad_otro from
(select rm_embotelladora from aa_muestras
inner join aa_recepcionmuestradetalle on aa_muestras.mue_idmuestra=aa_recepcionmuestradetalle.mue_idmuestra
inner join aa_recepcionmuestra on aa_recepcionmuestra.rm_idrecepcionmuestra=aa_recepcionmuestradetalle.rm_idrecepcionmuestra
where aa_muestras.mue_numreporte=:numrep and aa_muestras.mue_claveservicio=".$servicio."
group by rm_embotelladora) as a
Inner Join (select * from ca_catalogosdetalle where cad_idcatalogo=43) as b ON a.rm_embotelladora = b.cad_idopcion";
        $rs6=Conexion::ejecutarQuery($ssql6,Array("numrep"=>$numrep));
        foreach($rs6 as $row6) {
            $pdf->SetFont('Arial','',10);
            $pdf->SetY($i+10);
            $pdf->SetX(72);
            $pdf->multiCell(80,4,$row6["cad_otro"], 0, 'C' , FALSE);
        }
        $i=$i+16;
        $pdf->Rect(82,$i,60,0);
        $i=$i+1;
        $pdf->SetY($i);
        $pdf->SetX(92);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(80,2,"Nombre y firma del jefe de calidad", 0 ,'L', FALSE);
        
        $i=$i+6;
        
        $pdf->SetFont('Arial','',6);
        $pdf->SetY($i);
        $pdf->SetX(23);
        $pdf->multiCell(200,6,'Los resultados que contiene este documento, solo corresponde a la muestra recibida, la informaci'.$o.'n es propiedad de GEPP y no debe ser usada con fines ajenos al proposito destinado.  ', 0, 'L' , FALSE);
        
        // pagina de imagenes
        
        
        $pdf->AddPage();
        // SUBTITULOS
        $pdf->SetY(38);
        $pdf->SetX(16);
        $pdf->ChapterTitle('FOTOGRAFIAS');
        
        
        
        // RECUADRO GENERAL
        
        $pdf->SetFont('Arial','',8);
        $ssql="SELECT ins_imagendetalle.id_ruta, ins_imagendetalle.id_descripcion FROM ins_imagendetalle WHERE
ins_imagendetalle.id_imgclaveservicio =  '3' AND ins_imagendetalle.id_imgnumreporte =  '$numrep' AND ins_imagendetalle.id_presentar =  '-1'";
        $rs=DatosImagenDetalle::getImagenDetallePresentar($servicio,$numrep,"ins_imagendetalle");
        $x=14;
        $y=60;
        $cont=0;
        $Band=0;
     
       // $rs=null;
        foreach($rs as $row) {
            $ee = RAIZ."/".$row[0];
          
            if ($cont<6) {
                
                if (($cont==0) || ($cont==3)){
                    $pdf->Image($ee,$x,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    
                }
                else if (($cont==1) || ($cont==4) ){
                    $pdf->Image($ee,$x+66,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+66);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                }
                else if (($cont==2) || ($cont==5) ){
                    $pdf->Image($ee,$x+132,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+132);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    $y=$y+90;
                }
                // $cont++;
            } else if ($cont>=6 && $cont<12) {
                // pagina 6
                if ($Band==0) {
                    $pdf->AddPage();
                    $pdf->SetFillColor(152,185,235);
                    $pdf->Rect(10,44,200,200,F);
                    $x=14;
                    $y=60;
                    $Band++;
                }
                if (($cont==6) || ($cont==9)){
                    $pdf->Image($ee,$x,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    
                }
                else if (($cont==7) || ($cont==10) ){
                    $pdf->Image($ee,$x+66,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+66);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                }
                else if (($cont==8) || ($cont==11) ){
                    $pdf->Image($ee,$x+132,$y,60,70);
                    $pdf->SetY($y+71);
                    $pdf->SetX($x+132);
                    $pdf->multiCell(60,4,$row["id_descripcion"], 0, 'C' , FALSE);
                    $y=$y+90;
                }
                
            }
            $cont++;
        }
        
        $pdf->Output();
    }
}

class PDFCert extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('img/logo_mues.jpg' , 63 ,6, 80 , 20,'JPG');
        $this->SetFont('Arial','B',14);
        // Movernos a la posicion
        $this->SetY(27);
        $this->SetX(13);    // Título
        $this->Cell( 0 , 8 , "CERTIFICACION CALIDAD DE AGUA PARA SISTEMA POST MIX", 0,  0, 'C',false);
        $this->SetLineWidth(0.4);   // ancho de linea
        $this->SetFillColor(0,0,0);
        $this->Rect(10,36,200,1);
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

class PDFAnalisis extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        
        $this->SetFont('Arial','B',14);
        // Movernos a la posicion
        $this->SetY(27);
        $this->SetX(13);    // Título
        //	$this->Cell( 0 , 0 , "POST MIX", 0,  0, 'C',false);
        $this->SetLineWidth(0.4);   // ancho de linea
        $this->SetFillColor(0,0,0);
        //$this->Rect(23,35,180,1);
    }
    
    // Pie de página
    
    
    function ChapterTitle($label)
    {
        // Arial 12
        $this->SetFont('Arial','B',14);
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
