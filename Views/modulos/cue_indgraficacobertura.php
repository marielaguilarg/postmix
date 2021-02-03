<!-- Content Header (Page header) -->
<?php
//error_reporting(E_ALL);
include "Controllers/indpostmix/graficaIndicadorv2Controller.php";
$graficaCobertura = new GraficaIndicadorv2Controller ();
$graficaCobertura->vistaGraficasCobertura();
?><style>
    .container {
        width: 100%;
        height: 800px;
        margin: 0;
        padding: 0;
    }
     

    
        .container2 {
            width: 100%;
            position: relative;
            left: 1px;
            height: 810px;
            margin: 0;
            padding: 0;
        }
   
    
      
      h5{
        margin-left: 20px !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.anychart.com/releases/8.7.1/css/anychart-ui.min.css"/>
<script src="js/anychart8.2.1/js/anychart-base.min.js"
type="text/javascript"></script>
<script src="js/anychart8.2.1/js/anychart-exports.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-data-adapter.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-linear-gauge.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-ui.min.js"></script>
<script src="js/anychart8.2.1/js/anychart-table.min.js"></script>
 <script src="https://cdn.anychart.com/themes/2.0.0/light_earth.min.js"></script>
<script src="js/grafindicadores.js"></script>
<script type="text/javascript">
    var bandera = 0;
    $(window).scroll(function () {

posicion_div_oculto=1900/2;
      //  var posicion_div_oculto = $("#divs_ocultos").offset().top;
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
      //  stage2 = anychart.graphics.create("container2");
         stage2 = anychart.graphics.create("container3");
<?php echo ' dibujarGrafCoberturaPastel("' . $graficaCobertura->getUrlCoberturaxCta() . '",stage2,"por_cuenta","CUENTA","por_cuenta2",anychart.palettes.morning,"'.$graficaCobertura->getTitulos()[4].'","'.$graficaCobertura->getTitulos()[5].'");'; ?>
console.log("todo bien hasta aqui");

    }
    function generarEncabezados(data) {
        let $tr = $("<tr></tr>");
        //espacio en blanco
        var arre=new Array();
        arre[0]="";
        $tr.append("<th>&nbsp;</th>");
        //$tr.attr("bgcolor", "FFFDC1");
        // $tr.css("background-color", "#FFFDC1");
        let $td;
        let i = 0;
        while (i < data.length) {
             arre[i+1]=data[i][0];
            $td = $('<th>' + data[i][0] + '</th>');
            $tr.append($td);
            i++;
        }
 contents = [arre];
		
        return $tr;
    }
    function generarTabla(cols, data, tabla) {
        var i;
        var j;
     

        for (i = 0; i < data.length; i++) {
              var arre=new Array();
            let $tr = $("<tr></tr>");
            //$tr.attr("bgcolor", "FFFDC1");
            // $tr.css("background-color", "#FFFDC1");
            let $td;
            j = 0;
            while (j < cols) {

            arre[j]=data[i][j];
                $td = $('<td>' + data[i][j] + '</td>');
                $tr.append($td);
                j++;
            }
            contents.push(arre);
          
            tabla.append($tr);
        }
        auditoriastot=$(".auditorias").val();
       // alert(auditoriastot);
        contents.push(["TOTAL",auditoriastot]);

    }

    function generarTablaInv(cols, data, tabla) {
        var i;
        var j;
        var titulos = ["", "AUDITADOS", "SOLICITADOS", "EQ. INST."];
     
     
        for (i = 1; i < data[0].length; i++) {
               var arre=new Array();
            let $tr = $("<tr></tr>");
            //$tr.attr("bgcolor", "FFFDC1");
            // $tr.css("background-color", "#FFFDC1");
            //pongo titulos

            $tr.append("<td>" + titulos[i] + "</td>");
             arre[0]= titulos[i];
            let $td;
            j = 0;
            while (j < cols) {

            arre[j+1]= data[j][i];
                $td = $('<td>' + data[j][i] + '</td>');
                $tr.append($td);
                j++;
            }
           
              contents.push(arre);
     //       tabla.append($tr);
        }

    }
 var ismobile=0;
 $(document).ready(function() { 
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {


            ismobile=1;
          
        }
    });
    anychart.theme(anychart.themes.lightEarth);

    var idioma;
    var titulo="<?php echo $graficaCobertura->getPeriodo()."\u000A".$graficaCobertura->getLugar(); ?>";

    function dibujarGrafCoberturaGeneral(urlDatos, idioma, stage) {
    

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
                        $(".auditorias").val(auditoriastot);
//                           var obj=data;
                        datosCobertura.push(obj[0]);
                        datosCobertura.push(obj[1]);
            //          console.log("cobertura");
            //          console.log(datosCobertura);
                        //AGREGANDO COLOR
                      obj[2].push("#CC0066");
                      obj[3].push("#2683C6");
            //          console.log( obj[2]);
                        datosTamMuestra.push(obj[2]);
                        datosTamMuestra.push(obj[3]);

                         cumplen = anychart.pie(datosCobertura);
                        //   cumplen.pie(data);
                        cumplen.legend().position('top').itemsLayout('horizontal');
                        cumplen.labels(true);
                        cumplen.bounds("10%", "5%", "80%", "45%");
                    
                        var title = cumplen.title();
                        titulosec="COBERTURA";
                        title.text(titulosec+"\u000A"+titulo);
                        title.enabled(true);
                        //title.align("left");
                        title.fontSize(14);
                          var palette = anychart.palettes.distinctColors();
                          palette.items([
                            {color: '#2683C6'},
                            {color: '#CC0066'}
                            
                        ]);
                          var title = cumplen.legend().title();
                          title.enabled(true);
                          title.fontSize(12);
                          title.padding(5);
                          title.useHtml(true);
                        //  title.hAlign("left");
                          title.text("<i style=\"color: #999; font-weight: 500; font-size: 14px;\">"+obj[4]+"</i><br>");
                          cumplen.tooltip().format("Valor: {%yPercentOfTotal}{decimalsCount:1}%");	
						cumplen.labels().position("outside");
                        cumplen.container(stage);
                     
                         cumplen.palette(palette);
                        cumplen.draw();

                        muestra = anychart.pie(datosTamMuestra);
                        //   cumplen.pie(data);
                        var palette = anychart.palettes.distinctColors();
                        palette.items([
                            {color: '#1D9BA1'},
                            {color: '#CC0066'},
                           
                            
                        ]);
                        titulosec="TAMAÑO TOTAL DE LA MUESTRA";
                        var title = muestra.title();
                        title.text(titulosec+"\u000A"+titulo);

                        title.enabled(true);
                        //title.align("left");
                        title.fontSize(14);
                        muestra.legend().position('top').itemsLayout('horizontal');
//                         var label = anychart.standalones.label();
//                         label
//                           .enabled(true)
//                           .text('Website Pages Visits by\nCategory Nov-2017')
                        
//                           .fontColor('#60727b')
//                           .position('center')
//                           .anchor('center-bottom');
//                         muestra.center().content(label);
 						var title = muestra.legend().title();
                          title.enabled(true);
                          title.fontSize(15);
                          title.padding(5);
                          title.useHtml(true);
                        //  title.hAlign("left");
                          title.text("<i style=\"color: #999; font-weight: 500; font-size: 14px;\">"+obj[5]+"</i><br>");
                          muestra.tooltip().format("Valor: {%yPercentOfTotal}{decimalsCount:1}%");
                        muestra.palette(palette);
                        muestra.labels(true);
                        muestra.labels().position("outside");
                         muestra.bounds("10%", "52%", "80%", "45%");
                     //    muestra.padding().top(50);
                       //  muestra.background({fill: "#ffd54f 0.2"});
                        muestra.container(stage);
                        muestra.draw();
                      // 
                   //     title = anychart.standalones.title();
                       //   title.bounds(300, 50, 100,50);
//title.text(titulosec+"\u000A"+titulo);
//title.container(stage);
//  title.padding().top(50);
//title.draw();
 						  dibujarlogogep(stage, "7%");
                       		 dibujarlogomu(stage,"7%");
  
                         dibujarlogogep(stage, "54%");
                       
                         dibujarlogomu(stage,"54%");
                    } else
                    {
                        var chart = anychart.pie(datosCobertura);
                        noDataLabel = chart.noData().label().enabled(true);

                        noDataLabel.text("Por el momento no hay información. Intente otra consulta");
                    }
                });


//        var cumplen = anychart.pie(  anychart.data.set(datosCobertura));
//            

       

    }
    var dataBarras, datapie;
k=15;
    function dibujarGrafCoberturaPastel(urlDatos, containerPas, tablaPas, nivel, tablaBar,colores,titulosec,titulotammues) {
      
        
      
        anychart.data.loadJsonFile(urlDatos, function (data) {

            // create a chart and set loaded data
            datapie = data["dona"];
            dataBarras = data["barras"];

            chart = anychart.pie(anychart.data.set(datapie));
           //  chart.legend().position('top').itemsLayout('horizontal');
            chart.legend().position('left').itemsLayout('vertical');
             chart.legend().maxWidth("30%");
             chart.legend().fontSize(10);
             var paginator = chart.legend().paginator();
           
            // place paginator on the right
            paginator.orientation("bottom");
       	 //     chart.title(titulo);
            //   cumplen.pie(data);
            chart.innerRadius("30%");
            chart.labels(true);
            var title = chart.title();
            title.text(titulosec+"\u000A"+titulo);
            title.enabled(true);
            //title.align("left");
            title.fontSize(14);
             chart.palette(colores);
            chart.labels().position("outside");
            chart.connectorStroke({color: "#595959", thickness: 2, dash: "2 2"});
            chart.tooltip().format("Valor: {%yPercentOfTotal}{decimalsCount:1}%");
            
            chart.bounds("10%", "5%", "80%", "41%");
              
            chart.container(containerPas);
            chart.draw();
            
            //lleno la tabla
            if(datapie){
                var table = anychart.standalones.table();
                table.rowsCount(datapie.length+1);
              //table.colsCount(5);
                   contents=[[nivel,"PV AUDITADOS"]];

                generarTabla(2, datapie, $("#" + tablaPas).find("tbody"));
                 
                table.getCell(0,0).fill("#0000AA").fontColor("#FFF");
                table.getCell(0,1).fill("#0000AA").fontColor("#FFF");
               table.getRow(0).height(25).fontWeight(500);
               console.log(datapie);
                    //  table.getRow(7).height(25);
                   //     table.getCell(datapie.length,0).fill("#0000AA").fontColor("#FFF");
               // table.getCell(datapie.length+1,1).fill("#0000AA").fontColor("#FFF");
                table.contents(contents);
                table.bounds("70%", "20%", "25%", "40%");
                k=k+18;
             //   table.container(containerPas).draw();
                dibujarlogogep(containerPas,"7%");
                dibujarlogomu(containerPas,"7%");
            }else{
                noDataLabel = chart.noData().label().enabled(true);

                noDataLabel.text("Por el momento no hay información. Intente otra consulta");
            }
            if(dataBarras)
                dibujarGrafBarras(containerPas, tablaBar,colores,titulotammues);
                  
            });

    }
 
    function dibujarGrafBarras(container, tabla,paleta_colores,titulosec) {
        anychart.onDocumentReady(function () {
            //  anychart.data.loadJsonFile(urlDatos, function (data) {
            // create a chart and set loaded data
            data = anychart.data.set(dataBarras);
            if (data) {
                var serieData1 = data.mapAs({x: 0, value: 1});
                var serieData2 = data.mapAs({x: 0, value: 2});
                var serieData3 = data.mapAs({x: 0, value: 3});
                // set the gauge type
                var chart = anychart.column();
                var series1 = chart.column(serieData1);
                series1.name("AUDITADOS");
                var series2 = chart.column(serieData2);
                series2.name("SOLICITADOS");
                var series3 = chart.column(serieData3);
                series3.name("EQ. INSTALADOS");
              
                iconsLabelFormat(series1,series2,series3);
                chart.palette(paleta_colores);
                chart.barGroupsPadding(2);
                chart.legend(true);
                chart.yAxis().title("PUNTOS DE VENTA");
                 chart.bounds("10%", "48%", "80%", "38%");
                var xLabels = chart.xAxis().labels();
				var palette = anychart.palettes.distinctColors();
                palette.items([
                   {color: '#CC0066'},
                   {color: '#2683C6'},
                    {color: '#1D9BA1'}  ,  
                            
                   ]);
                   if(titulosec.toLowerCase()=="tamaño de la muestra por region"){
                chart.palette(palette);
                }
                xLabels.width(53);
                xLabels.wordWrap("break-word");
                xLabels.wordBreak("break-all");
                xLabels.fontSize(8);
                chart.container(container);
                k=k+16;
                var title = chart.title();
               
                header(title,titulosec,titulo);
              
                
                chart.yScale().ticks().interval(10);
                // initiate drawing the chart
                chart.draw();
                //lleno tabla
                var table = anychart.standalones.table();
                contents=new Array();
                generarEncabezados(dataBarras);
               
                generarTablaInv(dataBarras.length, dataBarras, $("#" + tabla).find("tbody"));
                table.cellFill('#F8F5F5');
                
                table.getRow(0).height(25).fontWeight(900);
                 table.getCol(0).width(90).fontWeight(900); 
                table.getRow(1).height(25);
                table.getRow(2).height(25);
                table.getRow(3).height(25);
				table.fontSize(9);
                table.contents(contents);
                table.bounds("10%", "85%", "80%", "17%");
                k=k+8;
                table.container(container).draw();
                dibujarlogogep(container,"50%");
                dibujarlogomu(container,"50%");
            }
        });

    }

function pdf(muestra) {

   muestra.saveAsPdf();
};


    //  preloader.visible(false);
    anychart.onDocumentReady(function () {
   stage = anychart.graphics.create("container1");
     stage1 = anychart.graphics.create("container2");
<?php
echo ' dibujarGrafCoberturaGeneral("' . $graficaCobertura->getUrlCobertura() . '","' . $_SESSION ["idiomaus"] . '",stage);';
echo ' dibujarGrafCoberturaPastel("' . $graficaCobertura->getUrlCoberturaxReg() . '",stage1,"por_region","REGION","por_region2",anychart.palettes.defaultPalette,"'.$graficaCobertura->getTitulos()[2].'","'.$graficaCobertura->getTitulos()[3].'");';
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
  
    <h1>AVANCE DE AUDITORIAS SOLICITADAS</h1>
    <h5> <?php echo $graficaCobertura->getPeriodo() ?></h5>
    <h5> <?php echo $graficaCobertura->getLugar() ?></h5>
    <ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion(); ?>

    </ol>
        <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="index.php?action=indgraficaindicadorv2">INDICADORES DE CALIDAD</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">COBERTURA</a>
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
                    <form name="form1" action="index.php?action=indgraficacobertura" method="post" >
                         <div class="row">
                             <div class="col-sm-6 border-right filtros">
                                 <input   name="opcionuni" type="hidden" id="opcionuni"    value="<?php echo $graficaCobertura->getFilnivelreg(); ?>">
                <!-- /.form-group -->

                                    <?php
                                    echo $graficaCobertura->getListanivel2();

                                    echo $graficaCobertura->getListanivel3();
                                    ?>

                                    <?php
                                    echo $graficaCobertura->getListanivel4();
                                    ?>

  <?php
                                echo $graficaCobertura->getListanivel5();
                                ?>

                             </div>
                        
                            <div class="col-sm-6 border-right">
                                <div class="form-group">
                                    <input name="action" type="hidden"
                                       value="indgraficaindicadorgr">
                                    <label><?php echo T_("PERIODO") ?></label>

                                    <select name="anio" class="form-control" id="anio_asig"
                                            required>
                                        <option value=""><?php echo T_("Seleccione el periodo") ?></option>       
                                        <?php echo $graficaCobertura->getOpciones_anio(); ?>
                                                            </select></div>
                                <div class="form-group">
                                    <label><?php echo T_("MES"); ?></label> <select
                                    class="form-control" name="mes_solo" id="mes" required>
                                    <option value="" selected><?php echo T_("Seleccione el mes") ?></option>
                                    <?php echo $graficaCobertura->getOpciones_mes(); ?>
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
    
<!--    fin filtros-->

<!-- cobertura x region o nivel-->

    <div class="box ">
        <div class="box-header with-border">
            <h3 class="box-title"> AVANCE DE AUDITORIAS SOLICITADAS</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool"
                        data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>

            </div>
        </div>
        <div class="box-body no-padding">
        
            <div class="col-md-12">
             <input    type="hidden" class="auditorias"   value="">
          
   <button onclick="pdf(stage)" class="btn btn-primary">IMPRIMIR</button>
  
                 <div class="container" id="container1" ></div>


             </div>
   <div class="col-md-12">
             <input    type="hidden" class="auditorias"   value="">
          
   <button onclick="pdf(stage1)" class="btn btn-primary ">IMPRIMIR</button>
  
                 <div class="container2" id="container2" ></div>


             </div>
               <div class="col-md-12">
             <input    type="hidden" class="auditorias"   value="">
          
   <button onclick="pdf(stage2)" class="btn btn-primary ">IMPRIMIR</button>
  
                 <div class="container2" id="container3" ></div>


             </div>

         
        </div>
    </div>


 </section>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
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