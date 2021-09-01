<!-- Content Header (Page header) -->
<?php
//error_reporting(E_ALL);
include "Controllers/indpostmix/graficaIndicadorv2Controller.php";
$graficaIndicador = new GraficaIndicadorv2Controller ();
$graficaIndicador->vistaGraficasIndicador();

?><style>
    .container {
        width: 100%;
        height: 650px;
        margin: 0;
        padding: 0;
    }
     .containert {
        width: 100%;
        height: 650px;
        margin: 0;
        padding: 0;
    }
    
     .containerbar {
        width: 100%;
        height: 1200px;
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
    h5{
        margin-left: 20px !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.anychart.com/releases/8.7.1/css/anychart-ui.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.anychart.com/releases/8.6.0/fonts/css/anychart-font.min.css"/>
  <script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-base.min.js" type="text/javascript"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-exports.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-data-adapter.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-linear-gauge.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-ui.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-table.min.js"></script>
 <script src="https://cdn.anychart.com/themes/2.0.0/light_earth.min.js"></script>
<script src="js/grafindicadores.js"></script>
 
<script type="text/javascript">
    var ismobile=0;
    var titulo="<?php echo $graficaIndicador->getPeriodo()."\u000A".$graficaIndicador->getLugar(); ?>";
    var titulogh="<?php echo $graficaIndicador->mes_indice_letra."\u000A".$graficaIndicador->getLugar(); ?>";

    
//        if( navigator.userAgent.match(/Android/i)
//     || navigator.userAgent.match(/webOS/i)
//     || navigator.userAgent.match(/iPhone/i)
//     || navigator.userAgent.match(/iPad/i)
//     || navigator.userAgent.match(/iPod/i)
//     || navigator.userAgent.match(/BlackBerry/i)
//     || navigator.userAgent.match(/Windows Phone/i)
 
    /****** cargar las demás graficas hasta que haya scroll************/
    var bandera = 0;
    $(window).scroll(function () {
        //console.log( ">>"+$("#areaImprimir").offset().top+">>"+ ($("#areaImprimir").offset().top/2));
        //  var posicion_div_oculto = $("#divs_ocultos").offset().top;
        var posicion_div_oculto = 1900/2;
        if ($(window).scrollTop() + $(window).height() >= posicion_div_oculto && bandera == 0) {

            cargardatos();
            bandera = 1;
        }
    });
    
   
     $(document).ready(function() { 
         
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

         
            ismobile=1;
            <?php
            	    if(empty($_SESSION["alertagraf"])){
            	        //muestro la alerta y la creo
            	        echo "
            	            //mando alerta para cambiar el cel
            	            $('#myModal').modal('show');";
            	        $_SESSION["alertagraf"]=1;
            	    }
            	    ?>
           
        }
  
    }
		
     );
    var k=0;
    function cargardatos() {
        $("#divs_ocultos").show();
        //BUSCO LOS DATOS y muestro el div
        <?php

        echo '   dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'IC",stage2,["#0984B4", "#015372"],"'.$graficaIndicador->getTitulos()[6].'",51);';
        echo 'k=5; dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'O",stage3,["#8BD2EE", "#26AFE3"],"'.$graficaIndicador->getTitulos()[5].'",7);';

        echo '  dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'IG",stage3,["#8BD2EE", "#26AFE3"],"'.$graficaIndicador->getTitulos()[7].'",51);';?>

    }
    /***** graficas de barras de secciones estandar*****/
     anychart.theme(anychart.themes.lightEarth);
    var j=7;
    function graficasEstandar(urlDatos,container1, container2,urldetalle){
  	  var urldetalle="index.php?action=indgrafindicadordetalle"+urldetalle;
        anychart.data.loadJsonFile(urlDatos, function (data) {
       
       
            if(data["error"])
            {
                title = anychart.standalones.title();
                title.text(data["error"]);  
                title.container(stage);
                title.draw();
                title = anychart.standalones.title();
                title.text(data["error"]);  
                title.container(stage4);
                title.draw();
            }else{
            // create data
                databebida = data["8"];
                dataagua =data["5"];

                //   console.log(Object.values(dataagua));

                graf1=drawColumns12meses(Object.values(databebida),j,stage, anychart.palettes.defaultPalette,"BEBIDA",titulo);
                //j=50;
             agregarLiga(graf1,urldetalle);
                graf2=drawColumns12meses(Object.values(dataagua),j,stage4, anychart.palettes.morning,"AGUA",titulo);
                agregarLiga(graf2,urldetalle);
                var xLabels = graf1.xAxis().labels();
                xLabels.width(90);
             
                var xLabels = graf2.xAxis().labels();
                xLabels.width(60);
              
                }
        });  
    }
    function coloringFunction() {
        //  return this.sourceColor+" 0.4";
        return anychart.graphics.hatchFill('diagonal', this.sourceColor);
    }

   
/************graficas horizontales*****************/
    function dibujarGrafBarras( urlDatos,container,color,titulosec,k){

        // create a preloader
        preloader = anychart.ui.preloader();
        // cover only chart container
        preloader.render(document.getElementById(container));      
        // show preloader
        preloader.visible(true);

        anychart.data.loadJsonFile(urlDatos, function (dataBarras) {
        // create a chart and set loaded data
        data = anychart.data.set(dataBarras);
        if (data) {

            // set the gauge type
            var chart = anychart.bar();
            var serieData1 = data.mapAs({x: 0, value: 2, pruebas:3, cumplen:4});
            // create a bar series and set the data
            var series = chart.bar(serieData1);
            series.name("%Cumplimiento (Resultados que cumplen/Num. pruebas) ");
            series.labels(true);
            series.fill(color);
            series.stroke(color);
            //series.labels().fontWeight(600);
            series.labels().fontColor('black');
            series.labels().format("{%value}%   ({%cumplen}/{%pruebas})");
            series.labels().fontSize(12);
            series.labels().anchor('left-center');
            series.labels().position('right-center');
            series.labels().offsetY(2);
         //   "Num. pruebas:".$rowt["total"] ."\nResultados que cumplen:". $rowt["pasa"]
           
            chart.tooltip().format("Cumplimiento: {%value}%\nNum. pruebas: {%pruebas} \nResultados que cumplen: {%cumplen}");
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
           // 
            
            var xLabels = chart.xAxis().labels();
            if(ismobile)//para el mobil hago mas pequeños los titulos
                 xLabels.width(150);
            //            else
            xLabels.width(335);
         
            xLabels.hAlign('end');
               xLabels.wordWrap("break-word");
            xLabels.wordBreak("normal");
            var title = chart.title();
          
            header(title,titulosec,titulogh);
            chart.yScale().minimum(0);
            chart.yScale().maximum(250);
            chart.yAxis().labels().fontSize(10);
            chart.yScale().ticks().interval(20);
            //  chart.yAxis().title("PUNTOS DE VENTA");

            //   alert(k+"%");
            chart.bounds("10%", k+"%", "80%", "43%");
           // console.log(">>"+k);
            chart.container(container);
           
            // initiate drawing the chart
            chart.draw();
             dibujarlogogep(container, (k+2)+"%");
            dibujarlogomu(container, (k+2)+"%");
           }
        });
     //    k=k+50;
        preloader.visible(false);


    }

    function printDiv(nombreDiv) {
         var contenido= document.getElementById(nombreDiv).innerHTML;
         var contenidoOriginal= document.body.innerHTML;

         document.body.innerHTML = contenido;

         window.print();

         document.body.innerHTML = contenidoOriginal;
    }

   
    var idioma;

        // save the chart as pdf
    function pdf1() {
      stage.saveAsPdf();
    
     // stage2.print("<printing resizing_mode='Recalculate'/>");
    };
    function pdf2() {
     
      stage2.saveAsPdf();
     // stage2.print("<printing resizing_mode='Recalculate'/>");
    };
    function pdf3() {
      
      stage3.saveAsPdf();
     // stage2.print("<printing resizing_mode='Recalculate'/>");
    };
    function pdf4() {
        
        stage4.saveAsPdf();
       // stage2.print("<printing resizing_mode='Recalculate'/>");
      };
    anychart.onDocumentReady(function () { 
        stage = anychart.graphics.create("contestandar1");
        stage4 = anychart.graphics.create("contestandar4");
         stage2 = anychart.graphics.create("contestandar2");
           stage3 = anychart.graphics.create("contestandar3");
        <?php

        //echo ' dibujarGrafCoberturaGeneral("' . $graficaIndicador->getUrlCobertura() . '","' . $_SESSION ["idiomaus"] . '");';
        echo ' graficasEstandar("' . $graficaIndicador->getUrlIndicadores() . 'E","contestandar1","contestandar2","&' . $graficaIndicador->getUrlIndicadoresDet() . '");';
        
        echo ' k=5; dibujarGrafBarras("' . $graficaIndicador->getUrlIndicadores() . 'S",stage2,["#0984B4", "#015372"],"'.$graficaIndicador->getTitulos()[4].'",7);';

        ?>
    });
    
</script>
<script language="JavaScript" type=text/javascript>
    /****esta función tiende a desaparecer, ya no se usa****/
    function CambiaIdioma(pagina, idioma)
    {	//cambio idioma de usuario y boton salir
        //window.parent.Menu.location="../MEmodulos/MEPtop.php?lan="+idioma;
        window.location = pagina;
    }

</script>
<section class="content-header">
   
    <h1> INDICADORES DE CALIDAD POSTMIX</h1>
    <h5> <?php echo $graficaIndicador->getPeriodo() ?></h5>
    <h5> <?php echo $graficaIndicador->getLugar() ?></h5>
     
    <ol class="breadcrumb">
    <?php Navegacion::desplegarNavegacion(); ?>

    </ol>
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="#">INDICADORES DE CALIDAD</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=indgraficacobertura">COBERTURA</a>
        </li>
         
 
    </ul>
</section>
<div class="modal" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Esta página se visualiza mejor con el dispositivo de manera horizontal</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    
      </div>
    </div>
  </div>
</div>
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
                          method="get" >
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
                                           value="indgraficaindicadorv2">
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
   <div class="row" id="areaImprimir">
        <div class="col-md-12">
                <div class="box ">
                    <div class="box-header with-border">
                        <h3 class="box-title">INDICADORES DE CALIDAD POSTMIX</h3>
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
                                <input type="button" onclick="pdf1()" value="IMPRIMIR" class="btn btn-primary"/>
                                <div class="container" id="contestandar1" ></div>
                           </div>
                            <div class="col-md-12">
                                <input type="button" onclick="pdf4()" value="IMPRIMIR" class="btn btn-primary"/>
                                <div class="containert" id="contestandar4" ></div>
                           </div>
                              <div class="col-md-12">
                              <input type="button" onclick="pdf2()" value="IMPRIMIR" class="btn btn-primary"/>
                                <div class="containerbar" id="contestandar2" ></div>
                           </div>
                             <div class="col-md-12">
                              <input type="button" onclick="pdf3()" value="IMPRIMIR" class="btn btn-primary"/>
                                <div class="containerbar" id="contestandar3" ></div>
                           </div>
                        </div>
                    </div>
                </div>  
                           

        </div>
   </div>
  
  
  
    
</section>

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