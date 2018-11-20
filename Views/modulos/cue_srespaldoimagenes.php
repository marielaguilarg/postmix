<?php
include 'Controllers/respImagenesController.php';

$respImgController = new respImagenesController ();

$respImgController->vistaRespladoImagenes ();

?>
<script language="JavaScript" type="text/JavaScript">
	function MM_reloadPage(init) { //reloads the window if Nav4 resized
		if (init == true)
			with (navigator) {
				if ((appName == "Netscape") && (parseInt(appVersion) == 4)) {
					document.MM_pgW = innerWidth;
					document.MM_pgH = innerHeight;
					onresize = MM_reloadPage;
				}
			}
		else if (innerWidth != document.MM_pgW
				|| innerHeight != document.MM_pgH)
			location.reload();
	}
	MM_reloadPage(true);
	
	function Enviar(opcion) {
	if(opcion==2){

		ruta="imprimirReporte.php?admin=respimg";
		document.form2.action=ruta;
	
}
else
{
ruta="imprimirReporte.php?admin=desimg";
document.form2.action=ruta;
}


		document.form2.submit();
	}

	
</script>
<script type="text/javascript" src="js/MESlistalig_cliente.js"></script>
<section class="content-header">

	<h1>MANTENIMIENTO DE IMAGENES</h1>

	<div class="row">
		<div class="col-md-12">

			<button class="btn btn-default pull-right" style="margin-right: 18px">
				<a href="index.php?action=srestaurarimagen"> <i class="fa fa-plus-circle"
					aria-hidden="true"></i> Restaurar
				</a>
			</button>
		</div>
	</div>
</section>

<!-- Main content -->

<section class="content container-fluid">

	<div class="box ">

		<div class="box-header with-border">

			<h3 class="box-title">SELECCIONE LOS SIGUIENTES CRITERIOS DE
				RESPALDO:</h3>

			<!-- /.box-tools -->

		</div>

		<!-- /.box-header -->

		<div class="box-body">
			<form name="form1" method="post"
				action="index.php?action=srespaldoimagenes&adm=lis">
<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">CLIENTE:</label>
					</div>

					<div class="col-sm-8">	<?php echo $respImgController->getOPCLIENTES()?> 
						</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">SERVICIO:</label>
					</div>

					<div class="col-sm-8"><?php echo $respImgController->getOPSERVICIOS()?></div>
				</div>
		
		
		<div class="row">
			<div class="col-sm-4">
				<label>CUENTA:</label>
			</div>

			<div class="col-sm-8"><?php echo $respImgController->getOPCUENTAS()?></div>
		</div>
</div>
<div class="col-md-6">

		<div class="row">
			<div class="col-sm-12">
				<label>PERIODO:</label>
			</div></div>
			<div class="form-group row">
				<div class="col-sm-4">
					<label>INDICE DE:</label></div>
					<div class="col-sm-4">
						<select class="form-control" name="fechainicio" id="fechainicio">
						<?php echo $respImgController->getmeses_opt()?>
						</select>
					</div>
					<div class="col-sm-4">
						<select class="form-control" name="fechainicio2">


							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
						</select>
					</div>
				</div>
			
			<div class="row">
				<div class="col-sm-4">
					<label>AL INDICE DE:</label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="fechafin" name="fechafin">
						<?php echo $respImgController->getmeses_opt()?>
						</select>
				</div>
				<div class="col-sm-4">
					<select class="form-control" name="fechafin2">


						<option value="2011">2011</option>
						<option value="2012">2012</option>
						<option value="2013">2013</option>
						<option value="2013">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
						
					</select>
				</div>
			</div></div>
			<div class="col-sm-12"
				style="padding-top: 50px; border-bottom: hidden">

				<button type="submit" class="btn btn-info pull-right">Generar</button>
			</div>
			</form>
		</div>
	</div>
	<div class="box" id="ligas" <?php echo $respImgController->getverligas()?>  >

		<div class="box-header">
			<h3 class="box-title">PARA RESPALDAR LAS IMAGENES SIGA LOS SIGUIENTES
				PASOS:</h3>
		</div>
		<div class="box-info">
<div class="col-ms-12">
			<form name="form2" method="post" action="imprimirReporte.php?admin=respimg">
			
				1. DESCARGUE EL RESPALDO DE LA BASE DE DATOS DE LA SIGUIENTE LIGA <a
					href="javascript: Enviar(2);"
					style="text-decoration: underline; color: #0066FF"><span
					class="lig_img">DESCARGAR ARCHIVO</span></a><br /> 2. HAGA CLICK EN
				LA SIGUIENTE LIGA PARA DESCARGAR EL ARCHIVO DE IMAGENES Y ELIJA
				GUARDARLO EN SU EQUIPO <a href="javascript: Enviar();"
					style="text-decoration: underline; color: #0066FF">DESCARGAR
					ARCHIVO</a>
				<!--{liga}-->
				<br /> 3. HAGA CLICK EN LA SIGUIENTE LIGA PARA BORRAR LOS ARCHIVOS <a
					style="text-decoration: underline; color: #0066FF"
					href="javascript: if(confirm('Si está seguro de haber realizado los respaldos adecuadamente elija ACEPTAR para eliminar'))  
  document.location='index.php?action=srespaldoimagenes&adm=del&ref=<?php echo $respImgController->getReferencia()?>&feci=<?php echo $respImgController->getFechainicio().".".$respImgController->getFechainicio2()."&fecf=".$respImgController->getFechafin().".".$respImgController->getFechafin2()?>' ;">ELIMINAR
					IMAGENES</a>
				<input name="crcliente" type="hidden" value="<?php echo $respImgController->getCrcliente()?>" /> <input
					name="crservicio" type="hidden" value="<?php echo $respImgController->getCrservicio()?>" /> <input
					name="cuenta" type="hidden" value="<?php echo $respImgController->getcuenta()?>" /> <input
					name="fechainicio" type="hidden" id="fechainicio"
					value="<?php echo $respImgController->getFechainicio()?>"> <input name="fechainicio2" type="hidden"
					value="<?php echo $respImgController->getFechainicio2()?>"> <input type="hidden" id="fechafin"
					name="fechafin" value="<?php echo $respImgController->getFechafin()?>"> <input type="hidden"
					name="fechafin2" value="<?php echo $respImgController->getFechafin2()?>">


			</form></div>
		</div>
	</div>

</section>