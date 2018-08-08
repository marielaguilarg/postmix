<script>
function oCargar(action){
	document.form1.action=action;
	document.form1.submit();

	}
</script>

<?php  $basepController=new BasePostmixController();
$basepController->vistaReportediario();
?>
<!-- Main content -->
<section class="content container-fluid">
<!--  filtros -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Reporte diario</h3>
        </div>
        <div class="box-body">
<form name="form1" id="form1" method="post" action="Controllers/indpostmix/postmix_excelController.php" >

<div>ESTIMADO USUARIO, PARA EXPORTAR EL ARCHIVO DIARIO, SELECIONE EL DIA: </div>
<div class="form-group">
       <label> Fecha de Inspecci&oacute;n : </label>
<select  name="fechareporte" type="text" id="fechareporte" class="form-control" >
<?php 
foreach($basepController->getListaFechas() as $fecha){

    echo '<option value="'.$fecha.'">'.$fecha.'</option>';
}
    ?>
	

</select></div>
 <button type="submit" class="btn btn-info btn-flat" ">
 Generar</button>
</div>


</div>

</form>
</section>