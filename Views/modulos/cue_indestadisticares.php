
<?php 
$estadisticasController=new EstadisticasController;
$estadisticasController->vistaIndEstadisticaRes();
        
        ?>
<style >
    #container, #container2,#graficagen,#graficafrec,#graficacumplaj {
    width: 100%;
    height: 300px;
    margin: 0;
    padding: 0;
}
</style>

  <script src="../js/anychart8.2.1/js/anychart-base.min.js" type="text/javascript"></script>
          <script src="../js/anychart8.2.1/js/anychart-exports.min.js"></script>
          <script src="../js/anychart8.2.1/js/anychart-data-adapter.min.js"></script>
            <script src="../js/anychart8.2.1/js/anychart-linear-gauge.min.js"></script>
              <script src="../js/anychart8.2.1/js/anychart-ui.min.js"></script>
                <script src="../js/anychart8.2.1/js/anychart-table.min.js"></script>
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
		document.getElementById('promedio2').style.display='none';
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
           <?php Navegacion::desplegarNavegacion();?>
      </ol>
    </section>

<section class="content container-fluid">

     
  <div class="box box-default">
               <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
            <div class="table-responsive">
                <table class="table no-margin">
                   <tbody>
                  <tr>
                    <td style="font-weight: bold;"><?php echo T_("TOTAL DE RESULTADOS")?></td>
 					<td>
                      <div class="sparkbar pull-right" data-height="20"><?php echo $estadisticasController->getEstadisticas()->getTotalresultados(); ?></div>
                    </td>
                  </tr>
			                  </tbody>
                </table>
              </div>
			   <!-- se vuelve din�mico este campo
                    -->
                 
                  <!-- <td class="datos_graf" align="center">--><?php echo $estadisticasController->getEstadisticas()->getTamano_muestra(); ?>
                 
		
			<div class="table-responsive">
                <table class="table no-margin">
                   <tbody>
                  <tr>
                    <td style="font-weight: bold"><?php echo T_("ESTANDAR")?></td>                  
                    <td>
                      <div class="sparkbar pull-right" data-height="20"><?php echo $estadisticasController->getEstadisticas()->getEstandar(); ?><</div>
                    </td>
                  </tr>
			</tbody>
                </table>
				</div>
			<div class="table-responsive">
                <table class="table no-margin">
                   <tbody>
				    <tr>
                    <td style="font-weight: bold"><?php echo T_("CUMPLEN")?> </td>                
                    <td>
                      <div class="sparkbar pull-right" data-height="20"><?php echo '<a href="'.$estadisticasController->getLigasi() .'" onclick="return guardarLiga(this, \'CUMPLEN\');" >'.$estadisticasController->getEstadisticas()->getCumplen().'</a>';?></div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
				<div class="table-responsive">
                <table class="table no-margin">
                   <tbody>
                  <tr>
                    <td style="font-weight: bold"><?php echo T_("NO CUMPLEN")?></td><td>
					<?php 
                echo  '<div class="sparkbar pull-right" data-height="20"> <a href="'.$estadisticasController->getLigano().'" onclick="return guardarLiga(this, \'NO CUMPLEN\');"><span class="liga_esp">'.$estadisticasController->getEstadisticas()->getNoCumplen().'</span></a></div>';?>
               
                    
                    </td>
                  </tr>
					</tbody>
                </table>
				</div>
				<?php echo '
				<div class="table-responsive" id="promedio">
                <table class="table no-margin">
                   <tbody>
                  <tr>
                    <td style="font-weight: bold">'.T_("PROMEDIO").'<br></td>
					<td>
                      <div class="sparkbar pull-right" data-height="20">'.$estadisticasController->getEstadisticas()->getPromedio().'</div>
                    </td>
                  </tr>
				</tbody>
                </table>
				</div>
				<div class="table-responsive" id="promedio2">
                <table class="table no-margin">
                   <tbody>
					<tr>
                    <td style="font-weight: bold">'.T_("DESVIACION ESTANDAR").'</td>
                    
                   
                    <td>
                      <div class="sparkbar pull-right" data-height="20">'.$estadisticasController->getEstadisticas()->getDesviacion_estandar().'</div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div> ';?>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
	
      <!-- /.row -->
 <?php echo ' <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">
        
           '.$estadisticasController->getNombreSeccion().'</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                  </div>
            </div>
              <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center"> <strong>'.T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR").'</strong></p>
                  
					                   
                     <div id="container"></div>
               
                  <!-- /.chart-responsive -->

                </div>
 
              </div>
              <!-- /.row -->
            </div>
               <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">'.$estadisticasController->getNombreSeccion().'</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                  </div>
            </div>
              <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center"> <strong>'.T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR POR MES").'</strong></p>
               
					                   
                    <div id="container2"></div>
                 
                 

                </div>
 
              </div>
              <!-- /.row -->
            </div>
               <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
           <div class="row" id="graficas2">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">'.$estadisticasController->getNombreSeccion().'</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                  </div>
            </div>
              <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center"> <strong>'.T_("VALOR PROMEDIO MENSUAL").'</strong></p>
                
					                   
                    <div id="graficagen"></div>
                 
                </div>
 
              </div>
              <!-- /.row -->
            </div>
               <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
          <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">'.$estadisticasController->getNombreSeccion().'</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                  </div>
            </div>
              <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center"> <strong>'.T_("PORCENTAJE DE PRUEBAS QUE CUMPLEN CON EL ESTANDAR POR PRODUCTO").'</strong></p>
                  <div class="chart">
					                   
                    <div id="graficafrec"></div>
                  </div>
                  <!-- /.chart-responsive -->

                </div>
 
              </div>
              <!-- /.row -->
            </div>
               <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->';
  if($estadisticasController->getTit_cumplaj()!=""){
      
       echo '<div class="row" >
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">'.$estadisticasController->getTit_cumplaj().'</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                  </div>
            </div>
              <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                   <div class="chart">
					                   
                    <div id="graficacumplaj"></div>
                  </div>
                  <!-- /.chart-responsive -->

                </div>
 
              </div>
              <!-- /.row -->
            </div>
               <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>';
  }
            
       
        ?>
          <!-- /.row -->
        
        
                 
            
    </div>
</section>




<script type="text/javascript">
if(document.form1.tipo_reactivo.value!="")
	MuestraOculta(document.form1.tipo_reactivo.value);

</script>
