<script>
function oCargar(action){
	document.form1.action=action;
	document.form1.submit();

	}
</script>

<?php  $basepController=new BasePostmixController();
$basepController->vistaReportediario();
?>

    <section class="content-header">
                <h2><?php echo T_("EXTRAER BASE POSTMIX")?></h2>
     
    </section>

<!-- Main content -->
<section class="content container-fluid">
<!--  filtros -->
    <div class="box box-info">
        <div class="box-header with-border">
        
            <h3 class="box-title"><?php echo T_("Reporte diario")?></h3>
        </div>
        <div class="box-body">
<form name="form1" id="form1" method="post" action="imprimirReporte.php" >
<input name="tipo_consulta" type="hidden" value="d"  >
<div><?php echo T_("ESTIMADO USUARIO, PARA EXPORTAR EL ARCHIVO DIARIO, SELECIONE EL DIA")?>: </div>
<div class="form-group">
                <label><?php echo T_("FECHA DE INSPECCION")?> : </label>
<select  name="fechareporte"  id="fechareporte" class="form-control" >
<?php 
foreach($basepController->getListaFechas() as $fecha){

    echo '<option value="'.$fecha.'">'.$fecha.'</option>';
}
    ?>
	

</select></div>
 <button type="submit" class="btn btn-info btn-flat" >
 <?php echo T_("Generar")?></button>


</form>
</div></div>
</section>