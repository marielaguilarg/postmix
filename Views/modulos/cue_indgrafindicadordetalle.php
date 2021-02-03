<!-- Content Header (Page header) -->
<?php
//error_reporting(E_ALL);
include "Controllers/indpostmix/grafIndiDetalleController.php";
$graficaIndicador = new GrafIndiDetalleController();
$graficaIndicador->vistaGraficasIndDetalle();
?><style>
    .container {
        width: 100%;
        height: 750px;
        margin: 0;
        padding: 0;
    }
      .container2 {
        width: 100%;
        height: 550px;
        margin: 0;
        padding: 0;
    }
    
    .container3 {
        width: 100%;
        height: 850px;
        margin: 0;
        padding: 0;
    }
    

/*    @media ( min-width : 500px) and (max-width: 1000px) { */
/*         .container { */
/*             width: 750px; */
/*             position: relative; */
/*             left: 0px; */
/*             height: 800px; */
/*             margin: 0; */
/*             padding: 0; */
/*         } */
/*           .container2 { */
/*         width: 750px; */
/*         height: 800px; */
/*         margin: 0; */
/*         padding: 0; */
/*     } */
/*     } */
/*        @media ( min-width : 200px) and (max-width: 500px) { */
/*         .container { */
/*             width: 250px; */
/*             position: relative; */
/*             left: 0px; */
/*             height: 800px; */
/*             margin: 0; */
/*             padding: 0; */
/*         } */
/*           .container2 { */
/*         width: 250px; */
/*         height: 800px; */
/*         margin: 0; */
/*         padding: 0; */
/*     } */
/*     } */
     
     
      h5{
        margin-left: 20px !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.anychart.com/releases/8.7.1/css/anychart-ui.min.css"/>
  <script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-base.min.js" type="text/javascript"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-exports.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-data-adapter.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-linear-gauge.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-ui.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-table.min.js"></script>
 <script src="https://cdn.anychart.com/themes/2.0.0/light_earth.min.js"></script>
<script src="js/grafindicadores.js"></script>


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
        <?php
        if($graficaIndicador->getReactivo()=='8.0.1.0.0.9'||$graficaIndicador->getReactivo()=='8.0.2.0.0.6'||$graficaIndicador->getReactivo()=='8.0.2.0.0.9')
        {
           
            echo ' $("#div_contestandar2").show(); drawComparativo("' . $graficaIndicador->getUrlIndicadores() . 'RR",stage2,anychart.palettes.defaultPalette);';
        
        }
        else echo ' $("#div_contestandar2").hide(); ';
       
        echo 'graficaHistorico("' . $graficaIndicador->getUrlIndicadores() . 'H",stage4,anychart.palettes.pastel);'; ?>

    }
    var color1 = "#<?php echo $graficaIndicador->colorhist ?>";
     var color2 = "#<?php echo $graficaIndicador->colorhist." 0.5" ?>";
      var color3 = "#<?php echo $graficaIndicador->colorhist." 0.2" ?>";

    // Variable for controlling color enlightenment
    var colorIndex = 0;
    var titulo="<?php echo $graficaIndicador->getNombreSeccion()."\u000A" ?>";
    var subtitulo="<?php echo "\u000A".$graficaIndicador->getPeriodo()." ".$graficaIndicador->getLugar(); ?>";
    
    var nota= "<?php echo $graficaIndicador->nota."\u000A" ?>";
    anychart.theme(anychart.themes.lightEarth);
    /***** graficas de barras de secciones estandar*****/
    function graficasEstandar(urlDatos,container1,titulo2,j){
     
        anychart.data.loadJsonFile(urlDatos, function (data) {
        //  console.log(Object.values(dataagua));
          //  drawColumns1s(data,"nose",container1, anychart.palettes.defaultPalette);
            graf1=drawColumns12meses(Object.values(data),j,container1, anychart.palettes.defaultPalette,titulo+titulo2,subtitulo);
            var xLabels = graf1.xAxis().labels();
            xLabels.width(55);
            xLabels.hAlign("center");
            //xLabels.wordWrap("break-word");
            //xLabels.wordBreak("break-all");   
        });  
   
    }
 
       
        function drawComparativo(urlDatos,  container,paleta) {
			preloader = anychart.ui.preloader();
                // cover only chart container
                //console.log(container)
            preloader.render(document.getElementById("contestandar2"));  
                // show preloader
                preloader.visible(true);
        	anychart.data.loadJsonFile(urlDatos, function (dataBarras) {
                console.log(data);
                
                var data= anychart.data.set(dataBarras);
          
                var serieData1 = data.mapAs({x: 0, value: 1, fill: 4, stroke:4, pruebas:6, cumplen:8});
                var serieData2 = data.mapAs({x: 0, value: 2, fill: 3, stroke:3, pruebas:7, cumplen:9});
            
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
                title.text(titulo+" COMPARATIVO INDICADOR SIN AJUSTE vs \u000AINDICADOR CON AJUSTE "+subtitulo);
                title.enabled(true);
        
                title.fontSize(14);
                  var title = chart.legend().title();
            title.enabled(true);
            title.fontSize(12);
            title.padding(5);
            title.useHtml(true);
          //  title.hAlign("left");
            title.text("<i style=\"color: #999; font-weight: 400; font-size: 11px;\">*AJUSTE: "+nota+"</i><br>");
          		/* layer_text = container.layer();
          		 chartLegend.container(layer_text).draw();

    // create main title
	layer_text.text(20, 20, "Animals activitiy", {fontSize:20});
                */ chart.labels(true);
                
                chart.labels().fontWeight(600);
                chart.labels().fontColor('black');
                chart.labels().format("{%value}{decimalsCount:1}");
                chart.labels().fontSize(10);
                chart.labels().position("center");
               // chart.labels().anchor("left");
              
                chart.tooltip().format("{%seriesName}: {%value}%\nNum. pruebas: {%pruebas} \nResultados que cumplen: {%cumplen}");
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
                chart.bounds("10%", "5%", "80%", "66%");
              //  j=j+31;
                chart.container(container);
               
                // configure the scale
                chart.yScale().minimum(0);
                chart.yScale().maximum(120);
                chart.yScale().ticks().interval(20);
                let table2=generarEncabezadosAny2(dataBarras);
       		    table2.bounds("10%", "73%", "80%", "5%");
       		    table2.container(container).draw();
                let table=generarTablaR1R2( dataBarras);
           	    table.bounds("10%", "78%", "80%", "20%");
                 i+=40;
                table.container(container).draw();
               
              
                 chart.draw();
                  dibujarlogogep(container,"7%");
              	dibujarlogomu(container,"7%");
               setTimeout(function() { 
                    // hide preloader after 30 seconds
                    preloader.visible(false);
                    }, 2000);
      		  });  
      		    
        }
       
// grafica de linea
     function graficaHistorico( url,container,paleta) {
        anychart.data.loadJsonFile(url, function (dataBarras) {
            var data= anychart.data.set(dataBarras);
            var serieData1 = data.mapAs({x: 0, value: 4 });
            var serieData2 = data.mapAs({x: 0, value: 3});
            var serieData3 = data.mapAs({x: 0, value: 2});
            // create a chart and set loaded data
            chart = anychart.line();
            var series=chart.line(serieData1);
            series.markers(true);
            series.name("Acumulado 12 meses");
            series1=chart.line(serieData2);
            series1.markers(true);
            series1.name("Acumulado 6 meses");
            series2=chart.line(serieData3);
            series2.markers(true);
            series2.name("Mensual");
            series.normal().stroke(color1,2);
            series.hovered().stroke(color1, 2);
            series.selected().stroke(color1, 2);
             series1.normal().stroke(color2,2);
            series1.hovered().stroke(color2, 2);
            series1.selected().stroke(color2, 2);
             series2.normal().stroke(color3,2);
            series2.hovered().stroke(color3, 2);
            series2.selected().stroke(color3, 2);
             //cambio el cuadrito seleccionable
            var legendItem1 = series1.legendItem();
            var legendItem2 = series2.legendItem();
            var legendItem = series.legendItem();
  // series.color(color1);
                  // set the types of legend icons
//            legendItem1.iconType("line");
 //           legendItem2.iconType("line");
  //          legendItem.iconType("line");-->
        

//            // set the strokes of icon markers
            legendItem1.iconMarkerStroke(series1.color(), 6);
            legendItem2.iconMarkerStroke(series2.color(), 6);
            legendItem.iconMarkerStroke(series.color(), 6);


            var title = chart.title();
            title.text(titulo+"MONITOREO DE AVANCE DE INDICADORES"+subtitulo);
            title.enabled(true);
            //title.align("left");
            title.fontSize(14);
//            var title = chart.legend().title();
//            title.enabled(true);
//            title.fontSize(12);
//            title.padding(5);
//            title.text(subtitulo);
            chart.legend().enabled(true);
            chart.tooltip().format("{%seriesName}: {%value}%");
            noDataLabel = chart.noData().label().enabled(true);
           
            noDataLabel.text("Por el momento no hay información. Intente otra consulta");
            var yAxis = chart.yAxis();
            chart.yAxis().title("% cumplimiento");
             chart.xAxis().labels().fontSize(8);
            //yAxis.title("%Establecimientos que cumplen con el estandar");
            yAxis.labels().format('{%value}%');
           // chart.title("%Establecimientos que cumplen con el estandar");
            chart.yScale().minimum(30);
            chart.yScale().maximum(110);
            chart.yScale().ticks().interval(10);
            //chart.yScroller(true);
            //chart.yScroller().enabled(true);
            <?php 
//             if($graficaIndicador->getReactivo()=='8.0.1.0.0.9'||$graficaIndicador->getReactivo()=='8.0.2.0.0.6'||$graficaIndicador->getReactivo()=='8.0.2.0.0.9')
//                 echo 'chart.bounds("10%","57%", "80%", "43%");
//                         posy="59%";';
             echo ' chart.bounds("10%","5%", "80%", "46%");
                        posy="7%";'
             ;?>
            chart.container(container);
          
      
            chart.draw();
            let numcols=dataBarras.length;
            let p=Math.ceil(dataBarras.length/3);
    		
    		//dibujo tabala de datos
    		
    		data2=dataBarras.splice(p,numcols-p);
    		dibujarTabla(dataBarras,container,51);
    		data3=data2.splice(p,numcols-p);
    		dibujarTabla(data2,container,51+16);
    		dibujarTabla(data3,container,51+32);
            
            
    		dibujarlogogep(container,posy);
    		dibujarlogomu(container,posy);
        });
     }
     var ismobile=0;
      $(document).ready(function() { 
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

        
            ismobile=1;
           
        }
    });
   
     function pdf(num) {
    	 if(num==4)
        	 stage4.saveAsPdf();
         if(num==3)
        	 stage3.saveAsPdf();
         else
        stage.saveAsPdf();
    }
     function pdf2() {
        stage2.saveAsPdf();
    }

    anychart.onDocumentReady(function () { 
        stage = anychart.graphics.create("contestandar1");
        stage3 = anychart.graphics.create("contestandar3");
        
        stage2 = anychart.graphics.create("contestandar2");
        stage4 = anychart.graphics.create("contestandar4");
        <?php

        echo ' graficasEstandar("' . $graficaIndicador->getUrlIndicadores() . 'DetN",stage,"COMPARATIVO POR REGION",7);';
        echo ' graficasEstandar("' . $graficaIndicador->getUrlIndicadores() . 'DetM",stage3,"COMPARATIVO POR CUENTA",7);';

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
      <h1><?php echo $graficaIndicador->getNombreSeccion();  ?> <small>

          <?php echo $graficaIndicador->getEstandar();  ?>

            </small></h1>
    <h5> <?php echo $graficaIndicador->getPeriodo() ?></h5>
    <h5> <?php echo $graficaIndicador->getLugar() ?></h5>
    
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
                    <form name="form1" action="index.php?action=indgrafindicadordetalle"
                          method="post" >
                        <div class="row">
                            <div class="col-sm-4 border-right filtros">
                                <input
                                    name="opcionuni" type="hidden" id="opcionuni"
                                    value="<?php echo $graficaIndicador->getFilnivelreg(); ?>">
                                 <input name="ref" type="hidden" id="opcionuni"    value="<?php echo $graficaIndicador->getReactivo(); ?>">
                                 <input name="color" type="hidden" id="color"    value="<?php echo $graficaIndicador->colorhist; ?>">
                                
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
                                    <label><?php echo T_("AÑO") ?></label>

                                    <select name="anio_ini" class="form-control" id="anio_asig_ini"
                                            required>
                                        <option value=""><?php echo T_("Seleccione el periodo") ?></option>       
                                <?php echo $graficaIndicador->getOpciones_anio(); ?>
                                    </select>  
                                    <label><?php echo T_("MES"); ?></label> <select
                                        class="form-control" name="mes_solo_ini" id="mes_ini" required>
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
                        <h3 class="box-title"><?php echo $graficaIndicador->getNombreSeccion();  ?></h3>
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
                             <div class="col-md-12">
                           
                                   <input type="button" onclick="pdf(3)" value="IMPRIMIR" class="btn btn-primary"/>
                                    <div class="container" id="contestandar3" ></div>
                                    
                           </div>
                          
                               <div class="col-md-12" id="div_contestandar2">
                                   <input type="button" onclick="pdf2()" value="IMPRIMIR" class="btn btn-primary"/>
                                    <div class="container2" id="contestandar2" ></div>
                                    
                           </div>
                              <div class="col-md-12">
                           
                                   <input type="button" onclick="pdf(4)" value="IMPRIMIR" class="btn btn-primary"/>
                                    <div class="container3" id="contestandar4" ></div>
                                    
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