<!-- Content Header (Page header) -->
<?php
//error_reporting(E_ALL);

include "Controllers/indpostmix/graficaIndicadorv2Controller.php";
$graficaIndicador = new GraficaIndicadorv2Controller ();
$graficaIndicador->vistaGraficasIndicador();
?><style>
    .container {
        width: 100%;
        height: 1200px;
        margin: 0;
        padding: 0;
    }
      .container2 {
        width: 100%;
        height: 500px;
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
     
      h5{
        margin-left: 20px !important;
    }
</style>
<script src="js/anychart8.2.1/js/anychart-base.min.js"
type="text/javascript"></script>
<script src="js/anychart8.2.1/js/anychart-exports.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-data-adapter.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-linear-gauge.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-ui.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-table.min.js"></script>
 <script src="https://cdn.anychart.com/themes/2.0.0/light_earth.min.js"></script>
<script src="js/grafindicadores.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.anychart.com/releases/8.9.0/css/anychart-ui.min.css"/>
<script type="text/javascript">
    var bandera = 0;
    $(window).scroll(function () {

        posicion_div_oculto=1200/2;
        
        // console.log($(window).scrollTop()+$(window).height()+"---"+posicion_div_oculto);
        //$(document).height() - $(window).height()-100
        if ($(window).scrollTop() + $(window).height() >= posicion_div_oculto && bandera == 0) {
            // pagina++;
            //  console.log("bajé el scroll");
            //  console.log("*************************");
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
        <?php //echo 'graficaHistorico("' . $graficaIndicador->getUrlIndicadores() . 'H",stage2,anychart.palettes.pastel);'; ?>

    }
    var color1 = "#FF0000";

    // Variable for controlling color enlightenment
    var colorIndex = 0;
    var titulo="<?php //echo $graficaIndicador->getNombreSeccion()."\u000A" ?>";
    var subtitulo="<?php echo "\u000A".$graficaIndicador->getPeriodo()."\u000A".$graficaIndicador->getLugar(); ?>";
    anychart.theme(anychart.themes.lightEarth);
    /***** graficas de barras de secciones estandar*****/
    function graficasEstandar(urlDatos,container1){
     
        anychart.data.loadJsonFile(urlDatos, function (data) {
        console.log(data);
        //  content=JSON.parse(data);
        //  console.log(content);
        dataagua =data["TEMPERATURA DE LA BEBIDA"];
        datavol=data["VOLUMENES DE CO2"];
        databebida = data["PROPORCION AGUA JARABE"];
         
        console.log(Object.values(databebida));
        preloader = anychart.ui.preloader();
        // cover only chart container
        preloader.render(document.getElementById("contestandar1"));      
        // show preloader
        preloader.visible(true);
        drawColumns(dataagua,"TEMPERATURA DE LA BEBIDA",container1, anychart.palettes.defaultPalette);
        drawColumns(datavol,"VOLUMENES DE CO2",container1, anychart.palettes.defaultPalette);
        drawColumns(databebida,"PROPORCION AGUA JARABE",container1, anychart.palettes.defaultPalette);
        setTimeout(function() { 
    // hide preloader after 30 seconds
    preloader.visible(false);
    }, 2000)
        });  
   
    }
    
    var j=5;
    function drawColumns(dataBarras,  titulo,container,paleta) {
        console.log(dataBarras);
        console.log(container);
        var data= anychart.data.set(dataBarras);
  
        var serieData1 = data.mapAs({x: 0, value: 1, fill: 4, stroke:4});
        var serieData2 = data.mapAs({x: 0, value: 2, fill: 3, stroke:3});
    
        // set the gauge type
        var chart = anychart.column();
        var series1 = chart.column(serieData1);
        series1.name("Indicador sin ajuste");

        var series2 = chart.column(serieData2);
        series2.name("Indicador con ajuste");
      
      //cambio el cuadrito seleccionable
        var legendItem1 = series1.legendItem();
        var legendItem2 = series2.legendItem();
        legendItem1.iconFill("none");
        legendItem2.iconFill("none");
      
        legendItem1.iconStroke("#A52A2A", 4);
        legendItem2.iconStroke("#CD853F", 4);
      
        chart.barGroupsPadding(0.5);

        chart.animation(true);
        chart.legend().enabled(true);
        var title = chart.title();
        title.text(titulo+subtitulo);
        title.enabled(true);

        title.fontSize(14);
   
        chart.tooltip().format("{%seriesName}: {%value}%");
        noDataLabel = chart.noData().label().enabled(true);

        noDataLabel.text("Por el momento no hay información. Intente otra consulta");
   
        chart.yAxis().title("% cumplimiento");
        chart.xAxis().labels().format(function() {
            var value = this.value;
            // limit the number of symbols to 3
            value = value.substr(0, 30);
            return value;
        });
        chart.xAxis().labels().fontSize(10);
        var xLabels = chart.xAxis().labels();
        xLabels.width(80);
        xLabels.wordWrap("break-word");
        xLabels.wordBreak("break-all");
        chart.bounds("10%", j+"%", "80%", "30%");
        j=j+31;
        chart.container(container);
       
        // configure the scale
        chart.yScale().minimum(0);
        chart.yScale().maximum(120);
        chart.yScale().ticks().interval(20);
        
       
      
         chart.draw();
          dibujarlogogep(container);
        }

        var ismobile=0;
      $(document).ready(function() { 
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

        
            ismobile=1;
           
        }
    });
    var urllogog= "https://muesmerc.mx/postmixv3/img/gepp2020.jpg";
     var urllogomu= "https://muesmerc.mx/postmixv3/img/logo_mues2020.png";
    function dibujarlogogep(container){
     if(ismobile)
//        
         { var image = anychart.graphics.image(urllogog, "12%", "6%", 66, 43);
				image.parent(container);}
        else
         { var image = anychart.graphics.image(urllogog, "12%", "6%", 160, 71);
				image.parent(container);}
   //      container.rect(115, 53, 160, 71).stroke('none')
//         .fill({
//             src: urllogog,

//         });
       
   		if(ismobile)
   
        { var image = anychart.graphics.image(urllogomu, "68%", "6%", 68, 45);
			image.parent(container);}
			else
			 { var image = anychart.graphics.image(urllogomu, "68%", "6%", 165, 64);
			image.parent(container);}
       
        }
     function pdf() {
        stage.saveAsPdf();
    };
        function pdf2() {
        stage2.saveAsPdf();
    };

    anychart.onDocumentReady(function () { 
        stage = anychart.graphics.create("contestandar1");
          stage2 = anychart.graphics.create("contestandar2");
        <?php

         echo ' graficasEstandar("' . $graficaIndicador->getUrlIndicadores() . 'RR",stage);';
       

        ?>
    });
    
</script>
<script language="JavaScript" type=text/javascript>



    function CambiaIdioma(pagina, idioma)
    {	//cambio idioma de usuario y boton salir
        //window.parent.Menu.location="../MEmodulos/MEPtop.php?lan="+idioma;
        window.location = pagina;
    }


</script>

<section class="content-header">
      <h1>COMPARATIVO CON AJUSTE/SIN AJUSTE</h1>
    <h5> <?php echo $graficaIndicador->getPeriodo() ?></h5>
    <h5> <?php echo $graficaIndicador->getLugar() ?></h5>
    
    <ol class="breadcrumb">
        <?php Navegacion::desplegarNavegacion(); ?>

    </ol>
       <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="index.php?action=indgraficaindicadorv2">INDICADORES DE CALIDAD</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">COBERTURA</a>
  </li>
  <li class="nav-item">
          <a class="nav-link active" href="index.php?action=indgraficacomparares">COMPARATIVO CON AJUSTE/SIN AJUSTE</a>
        </li>
</ul>
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
                    <form name="form1" action="index.php?action=indgraficacomparares"
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
   
  <!-- grafica seccion 8 y 5-->
   <div class="row">
        <div class="col-md-12">
                <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php //echo $graficaIndicador->getNombreSeccion();  ?></h3>
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
                                   <input type="button" onclick="pdf()" value="IMPRIMIR" class="btn btn-primary"/>
                                    <div class="container" id="contestandar1" ></div>
                                    
                           </div>
                             
                        
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