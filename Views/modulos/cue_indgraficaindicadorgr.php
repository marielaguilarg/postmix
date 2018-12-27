<!-- Content Header (Page header) -->
<?php
$graficaIndicador = new GraficaIndicadorController ();
$graficaIndicador->vistaGraficaIndicadores ();

?><style>
.container {
	width: 100%;
	height: 350px;
	margin: 0;
	padding: 0;
}

@media ( min-width : 992px) and (min-width: 1200px) {
	.container {
		width: 80%;
		position: relative;
		left: 100px;
		height: 350px;
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

    anychart.onDocumentReady(function () {
  
        function drawGauge(value, rango1, rango2, rango3, rango4, url) {
// create data
            var data = [value];

// set the gauge type
            var gauge = anychart.gauges.linear();
// create an event listener for hovering the chart
            gauge.listen("mouseOver", function (e) {
// change the cursor style on hovering the chart
                document.body.style.cursor = "pointer";
            });

// create an event listener for unhovering the chart
            gauge.listen("mouseOut", function (e) {
// set the default cursor style on unhovering the chart
                document.body.style.cursor = "auto";
            });

            noDataLabel = gauge.noData().label().enabled(true);

            noDataLabel.text("Por el momento no hay información. Intente otra consulta");
// set the data for the gauge
            gauge.data(data);

// set the layout
            gauge.layout('horizontal');

// create a color scale
            var scaleBarColorScale = anychart.scales.ordinalColor().ranges(
                    [
                        {
                            from: 0,
                            to: rango2,
                            color: ['#D81E05', '#FFD700']
                        },
                        {
                            from: rango2,
                            to: rango2 + ((rango3 - rango2) / 2),
                            color: ['#FFD700', '	#ffff00']
                        },
                        {
                            from: rango2 + ((rango3 - rango2) / 2),
                            to: rango3,
                            color: ['#ffff00', '#d6d629']
                        },
                        {
                            from: rango3,
                            to: 100,
                            color: ['#d6d629', '#2AD62A']
                        }
                    ]
                    );

// create a Scale Bar
            var scaleBar = gauge.scaleBar(0);

// set the height and offset of the Scale Bar (both as percentages of the gauge height)
            scaleBar.width('20%');
            scaleBar.offset('10%');

// use the color scale (defined earlier) as the color scale of the Scale Bar
            scaleBar.colorScale(scaleBarColorScale);

// add a marker pointer
            var marker = gauge.marker(0);
marker.name(" ");
// set the offset of the pointer as a percentage of the gauge width
            marker.width('28%');
            marker.offset('20%');
            marker.color("#707B7C");

// set the marker type
            marker.type('triangle-up');
            marker.labels()
                    .enabled(true)
                    .position('right-center')
                    .offsetX(-28)
                    .offsetY(7)
                    .anchor('left-center')
                    .fontSize(10)
                    .fontColor('#212121')
                    .format('{%value}%');
// set the zIndex of the marker
            marker.zIndex(10);

// configure the scale
            var scale = gauge.scale();
            scale.minimum(0);
            scale.maximum(100);
            scale.ticks().interval(10);

// configure the axis
            /*  var axis = gauge.axis();
             axis.minorTicks(true);
             axis.minorTicks().stroke('#cecece');
             axis.width('1%');
             axis.offset('29.5%');
             axis.orientation('top');
             
             // format axis labels
             axis.labels().format('{%value}%');*/
// set paddings
            gauge.padding([0, 3]);
//add a listener
            gauge.listen("click", function (e) {
//  alert(url);
//var new_value = e.iterator.get("url");
                window.open(url, "_self");
            });
            return gauge;
        }

        function dibujarTablaGraf(container, urlDatos, idtabla,idioma) {
        	var	preloader = anychart.ui.preloader();
        	// render preloader to the DOM
           //	preloader.render();
//             	  preloader = anychart.ui.preloader();
//               	// cover only chart container
         	preloader.render(document.getElementById(container));
              	// show preloader
            preloader.visible(true);
// set stage
            var stage = anychart.graphics.create(container);
        	anychart.data.loadJsonFile(urlDatos, function (data) {
		
                var Availability = anychart.data.set(data);
// content for first row
				if(idioma==2)
					var contents=[["ATTRIBUTE / STANDARD","% TESTS THAT MEET THE STANDARD"]];
				else
                var contents = [["ATRIBUTO / ESTANDAR", "% DE ESTABLECIMIENTOS QUE CUMPLEN CON EL ESTANDAR"]];
				
// Table settings

// create table
                var table = anychart.standalones.table();
				for (var i = 0; i < Availability.getRowsCount(); i++) {
                    if (Availability.row(i) != null)
                        contents.push([
                            // create line charts in the first column
                            Availability.row(i)[0]+"\n"+Availability.row(i)[1], // get names for second column
                            drawGauge(Availability.row(i)[2], Availability.row(i)[4], Availability.row(i)[5], Availability.row(i)[6], Availability.row(i)[7], Availability.row(i)[9])
                            
                        ]);
                    else
                        contents.push(["", "Por el momento no hay información.Intente otra consulta"]);
                }

// set table content
                table.contents(contents);

// disable borders and adjust width of second and fourth column				table.hAlign("left");
                table.cellBorder(null);
                table.getCol(0).width(150);
               // table.getCol(1).width("70%");
			
         
                table.getRow(0).height(50).fontWeight(500);
                // table.getRow(3).height(25);
                
                // visual settings for the first row
                 table.getCell(0,0).fill("#444444").fontColor("#FFF");
                 table.getCell(0,1).fill("#444444").fontColor("#FFF");         
                //  table.getCell(0, 2).colSpan(2).hAlign("left");
                // table.getCell(1,2).padding(0,9);

// visual settings for text in table
                table.vAlign("middle").fontWeight(400).fontSize(11);

// set table container and initiate draw
                table.container(stage).draw();
               
                //preloader.visible(false);

// Settings for table content



// create legend
//  var legend = anychart.standalones.legend();
//
//  legend.title().enabled(false);
//  legend.titleSeparator().enabled(false);
//  legend.paginator().enabled(false);
//  legend.fontSize("10px").itemsLayout("horizontal").iconTextSpacing(0).align("right").position("center-bottom").padding(0).margin(0).itemsSpacing(0);
//  legend.parentBounds(anychart.math.rect(0, 15, stage.width(),15));
//  legend.background().enabled(false);
//  legend.container(stage).draw();

          //      dibujarTabla(idtabla, data);

            });
        //  preloader.visible(false);
        }

        function dibujarTabla(idtabla, datos) {

            var table = $('<table>').addClass('table no-margin');
          
            table.append(' <tr>  <th>ATRIBUTO</th> <th >ESTANDAR</th>' +
                    ' <th  >%</th>' +
                    ' </tr>');
            table.append("<tbody>");
            for (i = 0; i < datos.length; i++) {
                var row = '<tr><td>' + datos[i][0] + '</td>' +
                        '<td>' + datos[i][1] + '</td>' +
                        '<td>' + datos[i][2] + '</td></tr>';
                table.append(row);
            }
		
            $('#' + idtabla).append(table);
        }
    
            
<?php

$i = 0;

foreach ( $graficaIndicador->getListaSecciones () as $seccionind ) {

	echo 'dibujarTablaGraf("container' . ($i) . '","' . $seccionind->getUrlDatos () . '","tabla' . ($i ++) . '",' . $_SESSION ["idiomaus"] . ');';
}

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
	<h1> <?php echo $graficaIndicador->getPeriodo() ?></h1>
	<h1> <?php echo $graficaIndicador->getNombre_nivel() ?></h1>
	<ol class="breadcrumb">
        <?php Navegacion::desplegarNavegacion();?>

    </ol>
</section>
<!-- Main content -->
<section class="content container-fluid">
	<!----- Filtros ----->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info collapsed-box">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo T_("FILTROS")?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-plus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<form name="form1" action="index.php?action=indgraficaindicadorgr"
						method="post">
						<div class="row">
							<div class="col-sm-4 border-right filtros">
								<input name="alertanav" type="hidden" id="alertanav"
									value="<?php echo $graficaIndicador->getAlertanav(); ?>"> <input
									name="opcionuni" type="hidden" id="opcionuni"
									value="<?php echo $graficaIndicador->getOpcionuni(); ?>">
								<!-- /.form-group -->
                        
                                <?php

				echo $graficaIndicador->getListanivel2 ();

			 echo $graficaIndicador->getListanivel3 ();

			?>
                        
<?php

echo $graficaIndicador->getListanivel4 ();

?>
                   
                      
<?php

echo $graficaIndicador->getListanivel5 ();

?>
                    </div>
							<div class="col-sm-4 border-right">                 
<?php

echo $graficaIndicador->getListanivel6 ();

?>
                        
                        <div class="form-group">
									<input name="action" type="hidden"
										value="indgraficaindicadorgr"> <label><?php echo T_("PERIODO")?></label>
									<select name="anio" class="form-control" id="anio_asig"
										required>
										<option value=""><?php echo T_("Seleccione el periodo")?></option>       
<?php echo $graficaIndicador->getOpciones_anio(); ?>
                            </select>
								</div>
							</div>
							<div class="col-sm-4 border-right">
								<div class="form-group">
									<label><?php echo T_("MES");?></label> <select
										class="form-control" name="mes_solo" id="mes" required>
										<option value="" selected><?php echo T_("Seleccione el mes")?></option>
<?php echo $graficaIndicador->getOpciones_mes(); ?>
                            </select>
								</div>
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-info pull-right"><?php echo T_("Filtrar")?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">

<?php

$i = 0;

foreach ( $graficaIndicador->getListaSecciones () as $seccionind ) {

	?>

            <div class="box ">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $seccionind->getTitulo(); ?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
						<!--    <div class="btn-group">
                            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-wrench"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>-->
					</div>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">

    <?php

	echo '<div class="container" id="container' . ($i ++) . '" ></div>';

	?>


                        </div>
						<!-- inicia tabla-->
						<!-- 						<div class="col-md-5"> -->
						<!-- 		<div class="table-responsive" id="tabla<?php //echo ($i++) ?>"></div>-->
						<!-- /.table-responsive -->
						<!-- 						</div> -->
						<!-- /.col -->
					</div>
				</div>
			</div>  
<?php } ?>
       
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