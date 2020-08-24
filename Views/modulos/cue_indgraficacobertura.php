<!-- Content Header (Page header) -->
<?php
//error_reporting(E_ALL);
include "Controllers/indpostmix/graficaIndicadorv2Controller.php";
$graficaCobertura = new GraficaIndicadorv2Controller ();
$graficaCobertura->vistaGraficasCobertura();
?><style>
    .container {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    @media ( min-width : 992px) and (min-width: 1200px) {
        .container {
            width: 100%;
            position: relative;
            left: 1px;
            height: 350px;
            margin: 0;
            padding: 0;
        }
    }
    
       @media ( min-width : 992px) and (min-width: 1200px) {
        .containerpeq {
            width: 100%;
            position: relative;
            left: 1px;
            height: 200px;
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
<script src="https://cdn.anychart.com/releases/v8/themes/morning.min.js"></script>
<script type="text/javascript">
    var bandera = 0;
    $(window).scroll(function () {

        var posicion_div_oculto = $("#divs_ocultos").offset().top;
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
<?php echo ' dibujarGrafCoberturaPastel("' . $graficaCobertura->getUrlCoberturaxCta() . '","container5","por_cuenta","container6","por_cuenta2");'; ?>

    }
    function generarEncabezados(data) {
        let $tr = $("<tr></tr>");
        //espacio en blanco

        $tr.append("<th>&nbsp;</th>");
        //$tr.attr("bgcolor", "FFFDC1");
        // $tr.css("background-color", "#FFFDC1");
        let $td;
        let i = 0;
        while (i < data.length) {
            $td = $('<th>' + data[i][0] + '</th>');
            $tr.append($td);
            i++;
        }

        return $tr;
    }
    function generarTabla(cols, data, tabla) {
        var i;
        var j;


        for (i = 0; i < data.length; i++) {
            let $tr = $("<tr></tr>");
            //$tr.attr("bgcolor", "FFFDC1");
            // $tr.css("background-color", "#FFFDC1");
            let $td;
            j = 0;
            while (j < cols) {


                $td = $('<td>' + data[i][j] + '</td>');
                $tr.append($td);
                j++;
            }
            tabla.append($tr);
        }

    }

    function generarTablaInv(cols, data, tabla) {
        var i;
        var j;
        var titulos = ["", "AUDITADOS", "SOLICITADOS", "EQ. INSTALADOS"];

        for (i = 1; i < data[0].length; i++) {
            let $tr = $("<tr></tr>");
            //$tr.attr("bgcolor", "FFFDC1");
            // $tr.css("background-color", "#FFFDC1");
            //pongo titulos

            $tr.append("<td>" + titulos[i] + "</td>");

            let $td;
            j = 0;
            while (j < cols) {


                $td = $('<td>' + data[j][i] + '</td>');
                $tr.append($td);
                j++;
            }
            tabla.append($tr);
        }

    }


    
    var idioma;

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


//             var cumplen = anychart.pie(  anychart.data.set(datosCobertura));
//                    //   cumplen.pie(data);
//  //var cumplen = anychart.pie(  datosCobertura);
//            cumplen.labels(true);
//            cumplen.container("container1");
//            cumplen.draw();

        });

    }
    var dataBarras, datapie;

    function dibujarGrafCoberturaPastel(urlDatos, containerPas, tablaPas, conteinerBar, tablaBar) {
        anychart.onDocumentReady(function () {
            anychart.theme('morning');
            var palette = anychart.palettes.distinctColors();
            palette.items([
                {color: '#CCFF33'},
                {color: '#99EF50'},
                {color: '#66DF6C'},
                {color: '#33CF88'}
            ]);
            anychart.data.loadJsonFile(urlDatos, function (data) {

                // create a chart and set loaded data
                datapie = data["dona"];
                dataBarras = data["barras"];
                chart = anychart.pie(anychart.data.set(datapie));
                chart.legend().position('left').itemsLayout('vertical');
                //   cumplen.pie(data);
                chart.innerRadius("30%");
                chart.labels(true);
                //   chart.palette(palette);
                chart.labels().position("outside");
                chart.connectorStroke({color: "#595959", thickness: 2, dash: "2 2"});
                chart.container(containerPas);
                chart.draw();
                //lleno la tabla

                generarTabla(2, datapie, $("#" + tablaPas).find("tbody"));
                dibujarGrafBarras(conteinerBar, tablaBar);
            });

        });

    }

    function dibujarGrafBarras(container, tabla) {
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
                chart.barGroupsPadding(2);
                chart.legend(true);
                chart.yAxis().title("PUNTOS DE VENTA");
                chart.container(container);

                // initiate drawing the chart
                chart.draw();
                //lleno tabla

                $("#" + tabla).find("thead").append(generarEncabezados(dataBarras));

                generarTablaInv(dataBarras.length, dataBarras, $("#" + tabla).find("tbody"));

            }
        });

    }




    //  preloader.visible(false);


<?php
echo ' dibujarGrafCoberturaGeneral("' . $graficaCobertura->getUrlCobertura() . '","' . $_SESSION ["idiomaus"] . '");';
echo ' dibujarGrafCoberturaPastel("' . $graficaCobertura->getUrlCoberturaxReg() . '","container3","por_region","container4","por_region2");';
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
    <h1> <?php echo $graficaCobertura->getPeriodo() ?></h1>
    <h1> <?php echo $graficaCobertura->getLugar() ?></h1>
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
                    <form name="form1" action="index.php?action=indgraficacobertura"
                          method="post" >
                        <div class="row">
                            <div class="col-sm-4 border-right filtros">
                                <input
                                    name="opcionuni" type="hidden" id="opcionuni"
                                    value="<?php echo $graficaCobertura->getFilnivelreg(); ?>">
                                <!-- /.form-group -->

<?php
echo $graficaCobertura->getListanivel2();

echo $graficaCobertura->getListanivel3();
?>

                                <?php
                                echo $graficaCobertura->getListanivel4();
                                ?>



                            </div>
                            <div class="col-sm-4 border-right">                 
<?php
echo $graficaCobertura->getListanivel5();
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
    <div class="row">
        <div class="col-md-6">
            <div class="box ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $graficaCobertura->getTitulos()[4]; ?></h3>
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
                    <h3 class="box-title"><?php echo $graficaCobertura->getTitulos()[5]; ?></h3>
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
    
  
        <div class="box ">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $graficaCobertura->getTitulos()[0]; ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool"
                            data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="box-body no-padding">

                <div class="col-md-8">


                    <div class="container" id="container3" ></div>


                </div>


                <div class="col-md-4">

                    <div class="pad box-pane-right bg-blue" style="min-height: 280px">
                        <table id="por_region" class="table table-bordered"><thead>
                            <th>REGION</th>
                            <th>PV AUDITADOS </th>
                            </thead>
                            <tbody>

                            </tbody></table>

                    </div>
                    <div class="info-box bg-blue">
                        <span class="info-box-text">Auditorias:</span> 
                        <span class="auditorias info-box-number"><span>
                    </div>
                </div>
           </div>
        </div>
    
                                <div class="box" id="ultimo">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?php echo $graficaCobertura->getTitulos()[1]; ?></h3>
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

                                                <div class="container" id="container4" ></div>

                                            </div>

                                            <div class="col-md-12">
                                                <table id="por_region2" class="table table-bordered"><thead>

                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--  graficas por cuenta -->
                                <div id="divs_ocultos" >
                                    <div class="box" >
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><?php echo $graficaCobertura->getTitulos()[2] ?></h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool"
                                                        data-widget="collapse">
                                                    <i class="fa fa-minus"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">

                                                <div class="col-md-8">

                                                    <div class="container" id="container5" ></div>

                                                </div>
                                                <div class="col-md-4">

                                                    <div class="pad box-pane-right bg-blue" style="min-height: 280px">
                                                        <table id="por_cuenta" class="table table-bordered"><thead>
                                                            <th>CUENTA</th>
                                                            <th>PV AUDITADOS </th>
                                                            </thead>
                                                            <tbody>

                                                            </tbody></table>

                                                    </div>
                                                    <div class="small-box bg-aqua">
                                                        <p>Auditorias:</p>
                                                        <h3><span class="auditorias"><span></h3>
                                                                    </div>
                                                                    </div>
                                                                    </div>

                                                                    </div>
                                                                    </div>  

                                                                    <div class="box ">
                                                                        <div class="box-header with-border">
                                                                            <h3 class="box-title"><?php echo $graficaCobertura->getTitulos()[3]; ?></h3>
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

                                                                                    <div class="container" id="container6" ></div>

                                                                                </div>

                                                                                <div class="col-md-12">
                                                                                    <table id="por_cuenta2" class="table table-bordered"><thead>
                                                                                        <th>&nbsp;</th>
                                                                                        </thead>
                                                                                        <tbody>

                                                                                        </tbody>
                                                                                    </table>
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