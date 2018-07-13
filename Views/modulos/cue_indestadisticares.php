
<?php 
$estadisticasController=new EstadisticasController;
$estadisticasController->generarBusquedaRes();
        
        ?>
<style >
    #container, #container2,#graficagen,#graficafrec,#graficacumplaj {
    width: 100%;
    height: 300px;
    margin: 0;
    padding: 0;
}
</style>

  <script src="Views/anychart8.2.1/js/anychart-base.min.js" type="text/javascript"></script>
          <script src="Views/anychart8.2.1/js/anychart-exports.min.js"></script>
          <script src="Views/anychart8.2.1/js/anychart-data-adapter.min.js"></script>
            <script src="Views/anychart8.2.1/js/anychart-linear-gauge.min.js"></script>
              <script src="Views/anychart8.2.1/js/anychart-ui.min.js"></script>
                <script src="Views/anychart8.2.1/js/anychart-table.min.js"></script>
          <script type="text/javascript">
anychart.onDocumentReady(function () {
          anychart.data.loadJsonFile("<?php echo $estadisticasController->getGraficaaplica(); ?>", function (data) {
	// create a chart and set loaded data
    var cumplen = anychart.pie(data);
//   cumplen.pie(data);
 
cumplen.labels(true);
    cumplen.container("container");
    cumplen.draw();
  
});
  anychart.data.loadJsonFile("<?php echo $estadisticasController->getGraficanivelcumpl(); ?>", function (data) {
	// create a chart and set loaded data
    chart = anychart.line();
    var series=chart.line(data);
    series.markers(true);
 var yAxis = chart.yAxis();
    //yAxis.title("%Establecimientos que cumplen con el estandar");
     yAxis.labels().format('{%value}%');
   // chart.title("%Establecimientos que cumplen con el estandar");

    chart.container("container2");
    chart.draw();
  
});
  anychart.data.loadJsonFile("<?php echo $estadisticasController->getGraficagen(); ?>", function (data) {
	// create a chart and set loaded data
    chart = anychart.line();
    var series=chart.line(data);
 var yAxis = chart.yAxis();
      series.markers(true);
        //yAxis.title("%Establecimientos que cumplen con el estandar"); //poner el estandar
  //   yAxis.labels().format('{%value}%');
  //  chart.title("%Establecimientos que cumplen con el estandar");

    chart.container("graficagen");
    chart.draw();
  
});
  anychart.data.loadJsonFile("<?php echo $estadisticasController->getGraficafrec(); ?>", function (data) {
	// create a chart and set loaded data
    chart = anychart.column();
    var series=chart.column(data);
      var splineSeries = chart.line(data);
  splineSeries.name('Spline');
  splineSeries.markers(true);
    chart.barGroupsPadding(0);
 var yAxis = chart.yAxis();
    yAxis.title("Frecuencia");
    chart.noData().label().enabled(true);
 //    yAxis.labels().format('{%value}%');
   // chart.title("%Establecimientos que cumplen con el estandar");
 chart.animation(true);
    chart.container("graficafrec");
    chart.draw();
  
});
var urlcj="<?php echo $estadisticasController->getGraf_cumplaj(); ?>";
if(urlcj!=""){
 anychart.data.loadJsonFile("<?php echo $estadisticasController->getGraf_cumplaj(); ?>", function (data) {
	// create a chart and set loaded data
    chart = anychart.column();
    var series=chart.column(data);
 var yAxis = chart.yAxis();
    yAxis.title("%Establecimientos que cumplen con el estandar");
     yAxis.labels().format('{%value}%');
    chart.title("%Establecimientos que cumplen con el estandar");

    chart.container("graficacumplaj");
    chart.draw();
  
});
}
});
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function act_grafica(id)
{		
	document.form1.action="MENprincipal.php?op=Acuenta&Opcion=grafica";
	document.form1.submit();
}
function MuestraOculta(opcion)
{
//alert(opcion);
	if(opcion=='C')// es cualitativa
	{

		document.getElementById('promedio').style.display='none';
		//document.getElementById('promedio2').style.display='none';
		 document.getElementById('graficas2').style.display='none';
		
	}
	
	

}

function enviar()
{
	
	document.form1.submit();
}


/***************** funciones para la lista de establecimientos ***********************/

function abrirVentana()
	{
		
			document.getElementById("capaFondo").style.visibility="visible";
		
	
		
		document.getElementById("list_ptosventa").style.visibility="visible";
	
	}
	
	function cerrarVentana()
	{
		document.getElementById("capaFondo").style.visibility="hidden";
	
		document.getElementById("list_ptosventa").style.visibility="hidden";
	
	}
	
//-->
</script>

 
        <section class="content-header">
                <h1><?php echo $estadisticasController->getFiltrosSel()->getNombre_seccion();
              echo "<br>".$estadisticasController->getFiltrosSel()->getPeriodo();
              echo "<br>".$estadisticasController->getFiltrosSel()->getNombre_nivel();
              echo "<br>".$estadisticasController->getFiltrosSel()->getNombre_franquicia();?></h1>
      <ol class="breadcrumb">
        <li><a href="#"><em class="fa fa-dashboard"></em> GRAFICA</a></li>
        <li class="active"><a href="index.php?action=indindicadoresgrid">TABLA DINAMICA</a></li>
          <li class="active">ESTADISTICAS</li>
      </ol>
    </section>

<section class="content container-fluid">

<div class="container">
    <div class="row">
 
            <div class="box box-info">
              
         <table class="lineaTabla" align="center" border="0" cellpadding="0" cellspacing="0" height="15" width="100%">
              <tbody><tr>
                <td align="center"  width="69%">
				<!--<div style=" width:273px">-->
	        <table  border="0" cellpadding="0" cellspacing="0"  width="100%">
                  <tbody><tr>
                    <td class="subtit_graf" align="center" height="20" width="139"><?php echo T_("TOTAL DE RESULTADOS")?></td> 
                   <!-- se vuelve din�mico este campo
                    -->
                   <?php echo $estadisticasController->getLb_tamanio_muestra(); ?>
                    <td class="subtit_graf" align="center" width="100"><?php echo T_("ESTANDAR")?></td> 
                    <td class="subtit_graf" align="center" width="98"><?php echo T_("CUMPLEN")?></td>
                    <td class="subtit_graf" align="center"  width="134"><?php echo T_("NO CUMPLEN")?></td>
					</tr>
					
					  <tr>
                                              <td class="datos_graf" align="center" height="19"><?php echo $estadisticasController->getEstadisticas()->getTotalresultados(); ?></td>
					<!-- <td class="datos_graf" align="center">--><?php echo $estadisticasController->getEstadisticas()->getTamano_muestra(); ?>
                    <td class="datos_graf"><?php echo $estadisticasController->getEstadisticas()->getEstandar(); ?></td>
		<?php 
                echo  '<td class="datos_graf"><a href="'.$estadisticasController->getLigasi() .'" onclick="return guardarLiga(this, \'CUMPLEN\');" ><span class="liga_esp">'.$estadisticasController->getEstadisticas()->getCumplen().'</span></a></td>
                    		
                    <td class="datos_graf"><a href="'.$estadisticasController->getLigano().'" onclick="return guardarLiga(this, \'NO CUMPLEN\');"><span class="liga_esp">'.$estadisticasController->getEstadisticas()->getNoCumplen().'</span></a></td>
                  </tr>
                </tbody></table></td><td width="31%">
					<div id="promedio">
					<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
					<tbody><tr>
                    <td class="subtit_graf" height="50%" width="50%">'.T_("PROMEDIO").'</td>
                    <td class="subtit_graf" align="center" width="50%">'.T_("DESVIACION ESTANDAR").'</td>
					</tr><tr height="50%">
					
                    <td class="datos_graf">'.$estadisticasController->getEstadisticas()->getPromedio().'</td>
				
                    <td class="datos_graf">'.$estadisticasController->getEstadisticas()->getDesviacion_estandar().'</td>
					</tr></tbody></table>
					</div>
					
				</td>
              </tr>
            </tbody></table>	
        
       
        
            <div><span class="SubtituloGraf" ><br />'.$estadisticasController->getNombreSeccion().'</span><br /><label>'.T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR").'</label></div>
          
           <div id="container"></div>
            
         <div><span class="SubtituloGraf"><br />'.$estadisticasController->getNombreSeccion().'</span>
            <br />  
           <label> '.T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR POR MES").'</label></div>'
                        . '<div id="container2"></div>';
         //  $estadisticasController->getGraficanivelcumpl().'</div>
              
          echo 
        '<div id="graficas2"  > 
     
              <div><span class="SubtituloGraf">'.$estadisticasController->getNombreSeccion().'</span><br />
                <label>'.T_("VALOR PROMEDIO MENSUAL").'</label></div>
           
             <div id="graficagen"></div>
              
          
              <div><span class="SubtituloGraf">'.$estadisticasController->getNombreSeccion()."</span><br><label>".T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR POR PRODUCTO").'</label></div>
          
             <div id="graficafrec"></div>
          
          </div>
      
            <div ><label><span class="SubtituloGraf">'.$estadisticasController->getTit_cumplaj().'</span></div>
         
           <div id="graficacumplaj"></div>';
       
        
        ?>
        
        
        
                    </div>
    </div>
            
    </div>
</section>




<script type="text/javascript">
if(document.form1.tipo_reactivo.value!="")
	MuestraOculta(document.form1.tipo_reactivo.value);

</script>
