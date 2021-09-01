<?php
session_start();
if (isset($_SESSION['Usuario'])) { //valido que este logeado

error_reporting(E_ERROR|E_PARSE);
  require "Models/crud_abierta.php";
  require "Models/crud_ponderacion.php";
  require "Models/crud_imagendetalle.php";
  //require_once "Models/crud_solicitudes.php";

 $admin=filter_input(INPUT_GET, "admin",FILTER_SANITIZE_STRING);


if($admin=="impcert"){
    require "Controllers/imprimirCertificadoController.php";
    $imp=new ImprimirCertificadoController();
    $imp->reporteCERTAgua();
    
}else
    if($admin=="impanag")
    {  require "Controllers/imprimirCertificadoController.php";

        $imp=new ImprimirCertificadoController();
        $imp->reporteAnalisis();
}else
	if($admin=="impcerpm") /***imrpimir alerta**/
	{  require "Controllers/imprimirCertificadoController.php";
	try{
	$imp=new ImprimirCertificadoController();
	$imp->certificadoPostmix();
	}catch(Exception $ex){
		echo $ex->getMessage();
	}
}
else   if($admin=="descarc")
{ 
    require "Models/crud_solicitudes.php";
    require "Controllers/certificacionController.php";
$imp=new CertificacionController();
$imp->descargarArchivo();
}else   if($admin=="repres"){
    
    require "Controllers/archivoVMController.php";
   
    $imp=new ArchivoVMController();
    $imp->descargarArchivo();
}else if($admin=="CSD"){
    
    require "Controllers/surveyDataController.php";
    
    $imp=new SurveyDataController();
    $imp->descargarArchivo();
}else if($admin=="Cinid")
{
    include "Models/crud_catalogoDetalle.php";
    require "Controllers/inicioExcelController.php";
    include "Models/crud_generales.php";
    $imp=new InicioExcelController();
    $imp->descargarArchivo();
}else if($admin=="repfac")
{
    include 'Controllers/repFacturacionController.php';
    include 'Controllers/subnivelController.php';
    $repFacturaController=new RepFacturacionController;
    $repFacturaController->generarArchivo();
}else if($admin=="respimg")
{
	include 'Controllers/respImagenesController.php';
 	$respimgController=new RespImagenesController();
	$respimgController->respaldobdImagen();
	
}else  if($admin=="desimg")
{
	include 'Controllers/descImagenesController.php';
	$desimgController=new DescImagenesController();
	//$desimgController->prueba();
	$desimgController->descargarImagenes();
	//require "Views/modulos/prueba.php";

}else if($admin=="recibomue")
{
	include 'Controllers/recepcionController.php';
	include "Utilerias/utilerias.php";
	include "Models/crud_catalogoDetalle.php";
	include "Models/crud_muestras.php";
	$recController=new RecepcionController();
	
	$recController->imprimir();
//	$recController->imprimir();
	
}else if($admin=="impetiq")
{
	include 'Controllers/muestrasController.php';
	include "Models/crud_catalogoDetalle.php";
	include "Models/crud_muestras.php";
	include "Utilerias/utilerias.php";
	$muestraController=new muestrasController;
	$muestraController->imprimir();
	
}else if($admin=="Tarcr")
{
	
	include "Utilerias/utilerias.php";
	include "Models/crud_catalogoDetalle.php";
	include "Models/crud_muestras.php";
	include "Controllers/archivoAguaController.php";
	$aguaController=new ArchivoAguaController();
	$aguaController->generarArchivo();
	
}else if($admin=="repinsp")
{
	
	
	
	
	include "Controllers/reporteInspeccionController.php";
	$repinspeccion=new ReporteInspeccion();
	$repinspeccion->vistaReporte();
	
}
else
    { 
       
        include "Controllers/indpostmix/postmix_excelController.php";
        
    
       $postmixexcel=new PostmixExcelController();
       $postmixexcel->exportar();
     // $postmixexcel->prueba();
    }
    
} else {
    header("location:index.php");
}