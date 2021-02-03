<?php 
session_start();

require_once "Controllers/indpostmix/tablaDinamicaController.php";
require_once 'libs/PHPExcel-1.8/PHPExcel.php';
require_once 'libs/php-gettext-1.0.12/gettext.inc';
include('Utilerias/inimultilenguaje.php');
include('Utilerias/utilerias.php');
require_once "Models/conexion.php";

include "Models/crud_estandar.php";
include "Models/crud_estructura.php";
if (isset($_SESSION['UsuarioInd'])) { //valido que este logeado
    
    
 
$nomarch="Indicadoresx".date("dmyHi");
$fname = tempnam("Archivos/", $nomarch.".xlsx");

$workbook =new PHPExcel();

$worksheet =$workbook->getActiveSheet();
$workbook->getActiveSheet()->setTitle(T_("INDICADORES"));


$tabladin=new TablaDinamicaController();

 $tabladin->exportarExcel($worksheet);
// echo "..".$tabladin->getUrl_imagen();

 $objDrawing = new PHPExcel_Worksheet_Drawing();
 $objDrawing->setName('Logo');
 $objDrawing->setDescription('Logo');
 $objDrawing->setPath($tabladin->getUrl_imagen());
 $objDrawing->setHeight(70);
 $objDrawing->setWorksheet($worksheet);



 $cellIterator = $worksheet->getRowIterator()->current()->getCellIterator();
 $cellIterator->setIterateOnlyExistingCells(true);
 /** @var PHPExcel_Cell $cell */
 foreach ($cellIterator as $cell) {
 	$worksheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
 }


$objWriter = PHPExcel_IOFactory::createWriter(   $workbook, 'Excel2007');

//echo $fname;

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=iso-8859-1");
header("Content-Disposition: inline; filename=\"".$nomarch.".xlsx\"");
$objWriter->save("php://output");

}else{
  include "Controllers/controller.php";
    $mvc =new MvcController();
  
    $mvc -> inicio();
}?>