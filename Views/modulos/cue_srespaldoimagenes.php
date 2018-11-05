<?php


include 'Controllers/respImagenesController.php';

$respImgController= new respImagenesController();

$respImgController->vistaRespladoImagenes();

?>
<script type="text/javascript" src="js/MESlistalig_cliente.js"></script>
<section class="content-header">

<h1>
MANTENIMIENTO DE IMAGENES</h1>

<div class="row">
<div class="col-md-12">
    
<button  class="btn btn-default pull-right" style="margin-right: 18px">
<a href="index.php?action="> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Restaurar </a></button>
       </div> </div>
</section>

<!-- Main content -->

<section class="content container-fluid">

<div class="box " >

<div class="box-header with-border">

<h3 class="box-title">SELECCIONE LOS SIGUIENTES CRITERIOS DE RESPALDO:</h3>

<!-- /.box-tools -->

</div>

<!-- /.box-header -->

<div class="box-body">
<form name="form1" method="post"	action="MESprincipal.php?op=respimg&adm=lis" >
<div class="col-sm-6" ><label>CLIENTE:</label>
						
						<?php echo $respImgController->getOPCLIENTES()?> 
						</div>
						<div class="col-sm-6" ><label>SERVICIO:</label>
						
						<div><?php echo $respImgController->getOPSERVICIOS()?></div> 
						</div>
						<div class="col-sm-10" ><label>CUENTA:</label>
						
						<div><?php echo $respImgController->getOPCUENTAS()?></div> </div>
						<div class="col-sm-10" ><label>PERIODO:</label>
					</div>
						<div class="col-sm-10" ><label>INDICE DE:</label>
						<select class="form-control" name="fechainicio"  id="fechainicio">
						<?php echo $respImgController->getmeses_opt()?>
						</select> <select class="form-control" name="fechainicio2">

							
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
						</select>
						
						</div>
						<div class="col-sm-10" ><label>AL INDICE DE:</label>
						<select class="form-control"  id="fechafin" name="fechafin">
						<?php echo $respImgController->getmeses_opt()?>
						</select> <select class="form-control" name="fechafin2">

						
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2013">2014</option>
							<option value="2015">2015</option>
						</select></div>
						  <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
        
                <button type="submit" class="btn btn-info pull-right">Generar</button>
              </div>
	</form>
</div>
</div>
<div class="box " >

	<div class="box-header">
				<h3  class="box-title">PARA RESPALDAR LAS IMAGENES SIGA LOS SIGUIENTES PASOS:</h3></div>
				<div class="box-info">
				
<form name="form2" method="post"	action="MESrespaldobdimagen.php" >
				1. DESCARGUE EL RESPALDO DE LA BASE DE DATOS DE LA SIGUIENTE LIGA <a  href="javascript: Enviar(2);" style="text-decoration:underline; color:#0066FF"><span class="lig_img">DESCARGAR ARCHIVO</span></a><br />
 2. HAGA  CLICK EN LA SIGUIENTE LIGA PARA DESCARGAR EL ARCHIVO DE IMAGENES Y ELIJA GUARDARLO EN SU EQUIPO
  <a href="javascript: Enviar();" style="text-decoration:underline; color:#0066FF">DESCARGAR ARCHIVO</a> <!--{liga}--><br /> 
3. HAGA  CLICK EN  LA SIGUIENTE LIGA PARA BORRAR LOS ARCHIVOS
 <a style="text-decoration:underline; color:#0066FF" href="javascript: if(confirm('Si está seguro de haber realizado los respaldos adecuadamente elija ACEPTAR para eliminar'))  
  document.location='MESprincipal.php?op=respimg&adm=del&ref={referencia}&feci={fechainicio}.{fechainicio2}&fecf={fechafin}.{fechafin2}' ;">ELIMINAR IMAGENES</a><br/><input name="crcliente" type="hidden" value="{crcliente}" />
 <input name="crservicio" type="hidden" value="{crservicio}" />
 <input name="cuenta" type="hidden" value="{cuenta}" />

				
			<input name="fechainicio" type="hidden" id="fechainicio" value="{fechainicio}">
						 <input name="fechainicio2" type="hidden" value="{fechainicio2}">

						<input type="hidden" id="fechafin" name="fechafin" value="{fechafin}">
						<input type="hidden" name="fechafin2" value="{fechafin2}">


</form>
</div></div>

</section>