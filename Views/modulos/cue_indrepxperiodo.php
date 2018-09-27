
<script type="text/javascript">
<!--
function muestra(id)
{
	if (document.getElementById)
	{ //se obtiene el id
		var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
		el.style.display = ''; //damos un atributo  que muestra el div
		
	}
}
function oculta(id, id2)
{
	if (document.getElementById)
	{ //se obtiene el id
		var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
		el.style.display = 'none'; //damos un atributo display:none que oculta el div
	}
	
	if (document.getElementById(id2))
	{ //se obtiene el id
		var el2 = document.getElementById(id2); //se define la variable "el" igual a nuestro div
		el2.style.display = ''; //damos un atributo  que muestra el div
		
	}
}
//-->
</script>
<?php

$basepController = new BasePostmixController();
$basepController->vistaReportePeriodo();
?>
  <section class="content-header">
                <h2><?php echo $basepController->getTitulo1()?></h2>
     
    </section>
<section class="content container-fluid">
	<!--  filtros -->
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $basepController->getSubtitulo()?></h3>
		</div>
		<div class="box-body">
			<form name="form1" id="form1" method="post"
				action="imprimirReporte.php?<?php echo "admin=".$basepController->getOpcion() ?>">
<input name="tipo_consulta" type="hidden" value="p"   >
				<div><?php echo T_("ESTIMADO USUARIO, PARA EXPORTAR EL ARCHIVO DEFINA EL PERIODO")?>:</div>

				
				<div class="form-row">
					<div class="col-md-2">

			    <label><?php echo T_("INDICE DE")?>: </label>
					</div>
					<div class="col-md-2">
						<select class="form-control" name="fechainicio" id="fechainicio">
							<?php echo '<option value="1">'.T_("Enero").'</option>
							<option value="2">'.T_("Febrero").'</option>
							<option value="3">'.T_("Marzo").'</option>
							<option value="4">'.T_("Abril").'</option>
							    <option value="5">'.T_("Mayo").'</option>
							<option value="6">'.T_("Junio").'</option>
							<option value="7">'.T_("Julio").'</option>
							    <option value="8">'.T_("Agosto").'</option>
							<option value="9">'.T_("Septiembre").'</option>
							<option value="10">'.T_("Octubre").'</option>
							    <option value="11">'.T_("Noviembre").'</option>
							<option value="12">'.T_("Diciembre").'</option>';?>
						</select>
					</div>
					<div class="col-md-2">
						<select name="fechainicio2" class="form-control">

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
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
							<option value="2025">2025</option>
						</select>

					</div>

					<div class="col-md-2">
						<label><?php echo T_("AL INDICE DE")?> </label>
					</div>
					<div class="col-md-2">
						<select class="form-control" id="fechafin" name="fechafin">
						<?php echo '<option value="1">'.T_("Enero").'</option>
							<option value="2">'.T_("Febrero").'</option>
							<option value="3">'.T_("Marzo").'</option>
							<option value="4">'.T_("Abril").'</option>
							<option value="5">'.T_("Mayo").'</option>
							<option value="6">'.T_("Junio").'</option>
							<option value="7">'.T_("Julio").'</option>
							<option value="8">'.T_("Agosto").'</option>
							<option value="9">'.T_("Septiembre").'</option>
							<option value="10">'.T_("Octubre").'</option>
							<option value="11">'.T_("Noviembre").'</option>
							<option value="12">'.T_("Diciembre").'</option>';?>
						</select>
					</div>
					<div class="col-md-2">
						<select class="form-control" name="fechafin2">

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
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
							<option value="2025">2025</option>
						</select>

					</div>

				</div>
				<div class="form-row">

					<div class="col-md-6"
						<?php echo $basepController->getEstilotcuenta()?>>


						<div class="form-check">
							<input class="form-check-input" name="consulta" type="radio"
								value="t" checked="checked" onClick="oculta('cuentas')"> <?php echo T_("TODAS LAS CUENTAS")?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-check">
							<input class="form-check-input" name="consulta" type="radio"
								value="u" onClick="muestra('cuentas')"> <?php echo T_("SOLO 1 CUENTA")?>
						</div>


						<div id="cuentas" class="form-check" style="display:none">


							<label><?php echo T_("Cuentas")?>: </label>

							<!-- inicioBloque: tBusqueda -->

<?php  foreach($basepController->getListaCuentas() as $cuenta ){

    echo $cuenta;
    
}?>
   
<!-- finBloque: tBusqueda -->


						</div>

					</div>
				</div>
					<div class="form-row">

						<button type="submit" class="btn btn-primary"><?php echo T_("Generar")?></button>
					</div>
				
			</form>
		</div>
	</div>
</section>