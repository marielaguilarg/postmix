<!-- Content Header (Page header) -->
<?php
//error_reporting(E_ALL);
include "Controllers/indpostmix/graficaIndicadorv2Controller.php";
$graficaIndicador = new GraficaIndicadorv2Controller ();
$graficaIndicador->vistaGraficasIndicador();
?><style>
    .container {
        width: 100%;
        height: 300px;
        margin: 0;
        padding: 0;
    }
    
     .containerbar {
        width: 100%;
        height: 400px;
        margin: 0;
        padding: 0;
    }

/*    @media ( min-width : 992px) and (min-width: 1200px) {
        .container {
            width: 100%;
            position: relative;
            left: 0px;
            height: 400px;
            margin: 0;
            padding: 0;
        }
    }*/
      @media ( min-width : 992px) and (min-width: 1200px) {
        .containerpeq {
            width: 100%;
            position: relative;
            left: 0px;
            height: 180px;
            margin: 0;
            padding: 0;
        }
    }
</style>
<script src="js/anychart8.2.1/js/anychart-base.min.js"
type="text/javascript"></script>
<script src="js/anychart8.2.1/js/anychart-exports.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-data-adapter.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-linear-gauge.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-ui.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-table.min.js"></script>
<script type="text/javascript">
    /****** cargar las demás graficas hasta que haya scroll************/
 var bandera = 0;
    $(window).scroll(function () {

        var posicion_div_oculto = $("#divs_ocultos").offset().top;
       
        if ($(window).scrollTop() + $(window).height() >= posicion_div_oculto && bandera == 0) {
         
            cargardatos();
            bandera = 1;
        }
    });
    $(document).ready(function () {
// $("#divs_ocultos").hide();
    });
    function cargardatos() {
        $("#divs_ocultos").show();
        //BUSCO LOS DATOS y muestro el div
<?php echo '  dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'O","contoperacion",["Silver", "SlateGray"]);';
    echo '  dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'IC","continocuidadc",["Lime", "LimeGreen"]);';
    echo '  dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'IG","continocuidadg",["SkyBlue", "SlateBlue"]);';?>

    }
    /***** graficas de barras de secciones estandar*****/
  function graficasEstandar(urlDatos,container1, container2){
    anychart.onDocumentReady(function () {
            
            anychart.data.loadJsonFile(urlDatos, function (data) {
               
            // create data
            databebida = data["8"];
             dataagua =data["5"];
             
             console.log(Object.values(dataagua));
            drawColumns(Object.values(databebida),"nose",container1, anychart.palettes.defaultPalette);
              drawColumns(Object.values(dataagua),"nose",container2, anychart.palettes.morning);
            });  
    });
    }
        function drawColumns(dataBarras,  url,container,paleta) {
               console.log(dataBarras);
                console.log(container);
          var data= anychart.data.set(dataBarras);
            var serieData1 = data.mapAs({x: 0, value: 2});
            var serieData2 = data.mapAs({x: 0, value: 3});
            var serieData3 = data.mapAs({x: 0, value: 4});
            // set the gauge type
            var chart = anychart.column();
            var series1 = chart.column(serieData1);
            series1.name("Acumulado 12 meses");
            series1.enabled(false);
            var series2 = chart.column(serieData2);
            series2.name("Acumulado 6 meses");
             series2.enabled(false);
            var series3 = chart.column(serieData3);
            series3.name("Indicador mensual");
            chart.barGroupsPadding(2);
// create an event listener for hovering the chart
            chart.listen("mouseOver", function (e) {
// change the cursor style on hovering the chart
                document.body.style.cursor = "pointer";
            });

// create an event listener for unhovering the chart
            chart.listen("mouseOut", function (e) {
// set the default cursor style on unhovering the chart
                document.body.style.cursor = "auto";
            });
            chart.animation(true);
                chart.legend().enabled(true);
                chart.tooltip().format("{%seriesName}: {%value}%");
            noDataLabel = chart.noData().label().enabled(true);

            noDataLabel.text("Por el momento no hay información. Intente otra consulta");
          chart.palette(paleta);
             chart.yAxis().title("% cumplimiento");
            chart.xAxis().labels().format(function() {
             var value = this.value;
             // limit the number of symbols to 3
             value = value.substr(0, 18);
             return value;
           });
            chart.xAxis().labels().fontSize(8);
            var xLabels = chart.xAxis().labels();
           xLabels.width(50);
           xLabels.wordWrap("break-word");
           xLabels.wordBreak("break-all");
            chart.container(container);

// configure the scale
          chart.yScale().minimum(0);
            chart.yScale().maximum(100);
           chart.yScale().ticks().interval(10);
 

//add a listener
//            chart.listen("click", function (e) {
////  alert(url);
////var new_value = e.iterator.get("url");
//                window.open(url, "_self");//mostrar el div
//            });
            
         chart.draw();
        }

   /************graficas horizontales*****************/
  function dibujarGrafBarras( urlDatos,container,color){
        anychart.onDocumentReady(function () {
             anychart.data.loadJsonFile(urlDatos, function (dataBarras) {
            // create a chart and set loaded data
               data = anychart.data.set(dataBarras);
                if (data) {

                    // set the gauge type
                    var chart = anychart.bar();
                      var serieData1 = data.mapAs({x: 0, value: 2});
                  // create a bar series and set the data
                    var series = chart.bar(serieData1);
                    series.name("%Cumplimiento");
                    series.labels(true);
series.fill(color);
series.labels().fontWeight(900);
series.labels().fontColor('black');
series.labels().format("{%value}%");
chart.barGroupsPadding(0.5);
                    chart.legend(true);
                //    chart.palette(paleta);
//                       chart.yAxis().labels().format(function() {
//             var value = this.value;
//             // limit the number of symbols to 3
//             value = value.substr(0, 18);
//             return value;
//           });
            chart.xAxis().labels().fontSize(10);
            var xLabels = chart.xAxis().labels();
           xLabels.width(380);
           xLabels.wordWrap("break-word");
           xLabels.wordBreak("break-all");
            chart.container(container);
               chart.yScale().minimum(0);
            chart.yScale().maximum(100);
             chart.yScale().ticks().interval(10);
                  //  chart.yAxis().title("PUNTOS DE VENTA");
                    chart.container(container);

                    // initiate drawing the chart
                    chart.draw();


                }
            });
        });

    }



   
 var idioma;
/*********graficas de pastel**********/
    function dibujarGrafCoberturaGeneral(urlDatos, idioma) {
        anychart.onDocumentReady(function () {

            var datosCobertura = [];
            var datosTamMuestra = [];
            idioma = idioma;
            $.get(urlDatos,
                    function (data) {
                        if (data != "") {
                            //  console.log(data);

                            var obj = JSON.parse(data);
                            //saco el total de auditorias
                            var auditoriastot = obj[1][1];
                            // alert(auditoriastot);
                            $(".auditorias").append(auditoriastot);
//             var obj=data;
                            datosCobertura.push(obj[0]);
                            datosCobertura.push(obj[1]);
//            console.log("cobertura");
//             console.log(datosCobertura);
                            //AGREGANDO COLOR
//                obj[2].push("#99EF50");
//                 obj[3].push("#66DF6C");
//                 console.log( obj[2]);
                            datosTamMuestra.push(obj[2]);
                            datosTamMuestra.push(obj[3]);
                            //  console.log(datosTamMuestra);
                            var cumplen = anychart.pie(datosCobertura);
                            //   cumplen.pie(data);
                            cumplen.legend().position('top').itemsLayout('horizontal');
                            cumplen.labels(true);
                            cumplen.container("container1");
                            cumplen.draw();

                            var muestra = anychart.pie(datosTamMuestra);
                            //   cumplen.pie(data);
                            var palette = anychart.palettes.distinctColors();
                            palette.items([
                                {color: '#7d9db6'},
                                {color: '#8db59d'},
                                {color: '#f38367'},
                                {color: '#b97792'}
                            ]);
                            muestra.legend().position('top').itemsLayout('horizontal');
                            muestra.palette(palette);
                            muestra.labels(true);
                            muestra.container("container2");
                            muestra.draw();
                        } else
                        {
                            var chart = anychart.pie(datosCobertura);
                            noDataLabel = chart.noData().label().enabled(true);

                            noDataLabel.text("Por el momento no hay información. Intente otra consulta");
                        }
                    });




        });

    }
    
<?php
echo ' dibujarGrafCoberturaGeneral("' . $graficaIndicador->getUrlCobertura() . '","' . $_SESSION ["idiomaus"] . '");';
echo ' graficasEstandar("' . $graficaIndicador->getUrlIndicadores() . 'E","contestandar1","contestandar2");';
echo ' dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'S","contservicio",["DeepSkyBlue", "DodgerBlue"]);';

?>

    
</script>
<script language="JavaScript" type=text/javascript>



    function CambiaIdioma(pagina, idioma)
    {	//cambio idioma de usuario y boton salir
//window.parent.Menu.location="../MEmodulos/MEPtop.php?lan="+idioma;
        window.location = pagina;
    }


</script>
<section class="content-header">
    <h1> <?php echo $graficaIndicador->getPeriodo() ?></h1>
    <h1> <?php echo $graficaIndicador->getLugar() ?></h1>
    <ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion(); ?>

    </ol>
</section>
<!-- Main content -->
<section class="content container-fluid">
    <!----- Filtros ----->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo T_("FILTROS") ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool"
                                data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form name="form1" action="index.php?action=indgraficaindicadorv2"
                          method="post" >
                        <div class="row">
                            <div class="col-sm-4 border-right filtros">
                                <input
                                    name="opcionuni" type="hidden" id="opcionuni"
                                    value="<?php echo $graficaIndicador->getFilnivelreg(); ?>">
                                <!-- /.form-group -->

<?php
echo $graficaIndicador->getListanivel2();

echo $graficaIndicador->getListanivel3();
?>

                                <?php
                                echo $graficaIndicador->getListanivel4();
                                ?>


                                <?php
                                echo $graficaIndicador->getListanivel5();
                                ?>
                            </div>
                            <div class="col-sm-4 border-right">                 
                                <?php
                                echo $graficaIndicador->getListanivel6();
                                ?>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="form-group">
                                    <input name="action" type="hidden"
                                           value="indgraficaindicadorgr">
                                    <label><?php echo T_("PERIODO") ?></label>

                                    <select name="anio" class="form-control" id="anio_asig"
                                            required>
                                        <option value=""><?php echo T_("Seleccione el periodo") ?></option>       
                                <?php echo $graficaIndicador->getOpciones_anio(); ?>
                                    </select></div>
                                <div class="form-group">
                                    <label><?php echo T_("MES"); ?></label> <select
                                        class="form-control" name="mes_solo" id="mes" required>
                                        <option value="" selected><?php echo T_("Seleccione el mes") ?></option>
<?php echo $graficaIndicador->getOpciones_mes(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-info pull-right"><?php echo T_("Filtrar") ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- graficas pastel -->
             <div class="col-md-6">
            <div class="box ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[0]; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool"
                                data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="box-body">




                    <div class="containerpeq" id="container1" ></div>


                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[1]; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool"
                                data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="box-body">

  <div class="containerpeq" id="container2" ></div>
 </div>

            </div>
        </div> 
    </div>
    
  <!-- grafica seccion 8 y 5-->
   <div class="row">
        <div class="col-md-12">
                <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[2]; ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
   <div class="container" id="contestandar1" ></div>
                           </div>
                           
                        </div>
                    </div>
                </div>  
                           

        </div>
   </div>
   <div class="row">
        <div class="col-md-12">
                <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[3]; ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
   <div class="container" id="contestandar2" ></div>
                           </div>
                            <!-- inicia tabla-->
                            <!-- 						<div class="col-md-5"> -->
                            <!-- 		<div class="table-responsive" id="tabla<?php //echo ($i++)  ?>"></div>-->
                            <!-- /.table-responsive -->
                            <!-- 						</div> -->
                            <!-- /.col -->
                        </div>
                    </div>
                </div>  
                           

        </div>
   </div>
   <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[4]; ?></h3>
                
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
   <div class="container" id="contservicio" ></div>
                           </div>
                         
                        </div>
                    </div>
                </div>  
  <div id="divs_ocultos">
    <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[5]; ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
   <div class="container" id="contoperacion" ></div>
                           </div>
                         
                        </div>
                    </div>
                </div>  
    <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[6]; ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
   <div class="container" id="continocuidadc" ></div>
                           </div>
                         
                        </div>
                    </div>
                </div>  
    <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $graficaIndicador->getTitulos()[7]; ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
   <div class="containerbar" id="continocuidadg" ></div>
                           </div>
                         
                        </div>
                    </div>
                </div>  
  
  </div>
  
  
    
</section>
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="js/jquery.cascading-drop-down.js"></script>
<script>

    $('.form-control').ssdCascadingDropDown({
        nonFinalCallback: function (trigger, props, data, self) {

            trigger.closest('form')
                    .find('input[type="submit"]')
                    .attr('disabled', true);

        },
        finalCallback: function (trigger, props, data) {

            if (props.isValueEmpty()) {
                trigger.closest('form')
                        .find('input[type="submit"]')
                        .attr('disabled', true);
            } else {
                trigger.closest('form')
                        .find('input[type="submit"]')
                        .attr('disabled', false);
            }

        }
    });
</script>