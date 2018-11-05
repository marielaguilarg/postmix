<?php
include "Controllers/indpostmix/datosUnegocioController.php";
$datosEstController=new DatosUnegocioController();
$datosEstController->vistaDatosEstablecimiento();

?>

  <section class="content-header">
<h1><?php echo $datosEstController->getUnegocio()  ?></h1>
<h1><?php echo $datosEstController->getReporte();?></h1>
<h1><?php echo $datosEstController->getTitulo()?></h1>
<ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion();?>
</ol>
</section>
	<section class="content container-fluid">

  

  
    <div class="box box-info" >
       

<div class="box-header with-border"><h3 class="box-title"><?php echo T_("DATOS DEL ESTABLECIMIENTO")?></h3></div>
	<div class="box-body">
 
      <div class="row">
        <div class="col-md-3"><?php echo T_("REPORTE DE VISITA")?>: </div>
		<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["ReporteN"]?></strong></div>
   
        <div class="col-md-3"><?php echo T_("PUNTO DE VENTA")?> </div>
		<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["PuntoVenta"]?></strong></div>
      </div>
    
  <div class="row">
    <div class="col-md-3"><?php echo T_("ID PEPSI")?></div>
	<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["IDPepsi"]?></strong></div>
 
    <div class="col-md-3"><?php echo T_("ID CUENTA")?>:</div>
	<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["IDCuenta"]?></strong></div>
  </div>
</div>

  </div>


<div class="box box-info" ><div class="box-header with-border"><h3 class="box-title"><?php echo T_("DIRECCION")?></h3></div>
<div class="box-body">
  <div class="row">
   
        <div class="col-md-3"><?php echo T_("CALLE")?>:</div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion1"]?></strong></div>
     
        <div class="col-md-3"><?php echo T_("NO. EXTERIOR") ?>: </div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion2"]?></strong></div>
    </div>
    <div class="row">
        <div class="col-md-2"><?php echo T_("NO. INTERIOR")?>: </div>
        <div class="col-md-2" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion3"]?></strong></div>
        <div class="col-md-2"><?php echo T_("MANZANA")?>:</div>
        <div class="col-md-2" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion4"]?></strong></div>
        <div class="col-md-2"><?php echo T_("LOTE")?>:</div>
        <div class="col-md-2" ><strong>&nbsp;<?php echo $datosEstController->getInfoGeneral()["Direccion12"]?></strong></div>
      </div>
      <div class="row">
        <div class="col-md-3"><?php echo T_("COLONIA")?>:</div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion6"]?></strong></div>
       <div class="col-md-3"><?php echo T_("C.P.")?>:</div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion8"]?></strong></div>
      </div>
      <div class="row">
         <div class="col-md-3"><?php echo T_("DELEGACION")?>:</div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion5"]?></strong></div>
        <div class="col-md-3"><?php echo T_("CIUDAD")?>:</div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion9"]?></strong></div>
       </div>
      <div class="row"> 
        <div class="col-md-3"><?php echo T_("ESTADO")?>:</div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion7"]?></strong></div>
     
        <div class="col-md-3"><?php echo T_("TELEFONO")?>:</div>
        <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion10"]?></strong></div>
      </div>
      <div class="row">
        <div class="col-md-6"><?php echo T_("REFERENCIA")?>:</div>
        <div class="col-md-6" ><strong><?php echo $datosEstController->getInfoGeneral()["Direccion11"]?></strong></div>
        </div>
    
    </div>
  </div>


<div class="box box-info" ><div class="box-header with-border"><h3 class="box-title"><?php echo T_("DATOS DE LA VISITA")?></h3></div>

	<div class="box-body">
  
  	<div class="row">
    <div class="col-md-3" ><span class="etiquetas"><?php echo T_("FECHA VISITA")?>: </span></div>
    <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["FechaVisita"]?></strong></div>
     <div class="col-md-3"><span class="etiquetas"><?php echo T_("INSPECTOR")?>:</span></div>
    <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Inspector"]?></strong></div>
    </div>
  <div class="row">
    <div class="col-md-3"><span class="etiquetas"><?php echo T_("INDICE")?>: </span></div>
    <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["MesAsignacion"]?></strong></div>
  
    <div class="col-md-3"><span class="etiquetas"><?php echo T_("RESPONSABLE")?>:</span></div>
    <div class="col-md-3" ><strong><?php echo $datosEstController->getInfoGeneral()["Reponsable"]?></strong></div>
    </div>
  <div class="row">
   <div class="col-md-3 pull-right" ><strong><?php echo $datosEstController->getInfoGeneral()["Cargo"]?></strong></div>
   
    <div class="col-md-3 pull-right"><span class="etiquetas"><?php echo T_("PUESTO")?>:</span></div>
    </div>

  <div class="row">
    
        <div class="col-md-12"><span class="etiquetas"><?php echo T_("HORA DE")?>:</span></div>
      </div>
      <div class="row">
        <div class="col-md-4" ><span ><?php echo T_("ENTRADA")?>: <strong><?php echo $datosEstController->getInfoGeneral()["HEntrada"]?></strong></span></div>
        <div class="col-md-4" ><?php echo T_("ANALISIS SENSORIAL")?>: <strong><?php echo $datosEstController->getInfoGeneral()["HSanalisis"]?></strong></div>
        <div class="col-md-4" ><?php echo T_("SALIDA")?>: <strong><?php echo $datosEstController->getInfoGeneral()["HSalida"]?></strong></div>
      </div>
    </div>
  </div>


<div class="box box-info">
<div class="box-header with-border"><h3 class="box-title"><?php echo T_("CLASIFICACION")?></h3></div>
    <div class="box-body">
       <div class="row">
                <div class="col-md-3" ><?php echo T_("COMPAÑIA")?>: </div>
				<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["compania"]?></strong></div>
            
                <div class="col-md-3"><?php echo T_("UNIDAD DE NEGOCIO")?>: </div>
				<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["pais"]?></strong></div>
              </div>
              <div class="row">
                <div class="col-md-3"><?php echo T_("FRANQUICIA")?>: </div>
				<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["zona"]?></strong></div>
           
                <div class="col-md-3"><?php echo T_("REGION")."/".T_("GRUPO")?>:</div>
				<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["estado"]?></strong></div>
              </div>
              <div class="row">
                <div class="col-md-3"><?php echo T_("ZONA")."/".T_("ESTADO")?>: </div>
				<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["ciudad"]?></strong></div>
            
                <div class="col-md-3"><?php echo T_("CEDIS")." / ".T_("CIUDAD")?>: </div>
				<div class="col-md-3"><strong><?php echo $datosEstController->getInfoGeneral()["nivelseis"]?></strong></div>
              </div>
            </div>
          </div>
   

	  <!----- Finaliza contenido ----->
    </section>
 