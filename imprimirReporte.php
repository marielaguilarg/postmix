<?php
session_start();
if (isset($_SESSION['Usuario'])) { //valido que este logeado
 


error_reporting(E_ERROR|E_PARSE);

//error_reporting(E_ALL);
 

 
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
}else   if($admin=="descarc")
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
}else
    { 
       
        include "Controllers/indpostmix/postmix_excelController.php";
        
    
       $postmixexcel=new PostmixExcelController();
       $postmixexcel->exportar();
     // $postmixexcel->prueba();
    }
    
} else {
    include "Controllers/controller.php";
    $mvc =new MvcController();
  
    $mvc -> inicio();
}