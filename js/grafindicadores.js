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

function header(title, titulo, subtitulo) {

	title.text(titulo + "\u000A" + subtitulo);
	title.enabled(true);

	title.fontSize(14);



}

function iconsLabelFormat(series1, series2, series3) {
	var legendItem1 = series1.legendItem();
	var legendItem2 = series2.legendItem();
	var legendItem3 = series3.legendItem();
	legendItem1.iconFill("none");
	legendItem2.iconFill("none");
	legendItem3.iconFill("none");
	legendItem1.iconStroke("#A52A2A", 4);
	legendItem2.iconStroke("#CD853F", 4);
	legendItem3.iconStroke("#DEB887", 4);
}


/****
   * Funcion para mostrar grafica de barras
   * @param {type} dataBarras
   * @param {type} url
   * @param {type} container
   * @param {type} paleta
   * @returns {undefined}
   */
var i=0;
function drawColumns12meses(dataBarras, j, container, paleta, titulosec, titulo) {

	
	var data = anychart.data.set(dataBarras);
	var serieData1 = data.mapAs({ x: 0, value: 4, ref: 1, fill: 5, stroke: 5, pruebas: 12, cumplen: 13 });
	var serieData2 = data.mapAs({ x: 0, value: 3, ref: 1, fill: 6, stroke: 6, pruebas: 10, cumplen: 11 });
	var serieData3 = data.mapAs({ x: 0, value: 2, ref: 1, fill: 7, stroke: 7, pruebas: 8, cumplen: 9 });
	// set the gauge type
	var chart = anychart.column();
	var series1 = chart.column(serieData1);
	series1.name("Acumulado 12 meses");
	series1.enabled(false);
	var series2 = chart.column(serieData2);
	series2.name("Acumulado 6 meses");
	series2.enabled(false);
	// series2.fill(anychart.graphics.hatchFill('diagonal', 'red'));
	var series3 = chart.column(serieData3);
	series3.name("Mensual");
	series3.enabled(true);
	iconsLabelFormat(series1, series2, series3);
	chart.barGroupsPadding(0.3);

	var title = chart.title();
	header(title, titulosec, titulo);


	chart.labels(true);

	//chart.labels().fontWeight(600);
	chart.labels().fontColor('black');
	chart.labels().format("{%value}{decimalsCount:1} %");

	chart.labels().fontSize(12);
	chart.labels().position("center");
    chart.labels().anchor("left");
    chart.labels().offsetY(-10);
    chart.labels().rotation(-90);
	// create an event listener for hovering the chart

	// chart.animation(true);
	chart.legend().enabled(true);
	chart.tooltip().format("{%seriesName}: {%value}%\nNum. pruebas: {%pruebas} \nResultados que cumplen: {%cumplen}");
	//   chart.tooltip().format("{%seriesName}: {%value}%");
	noDataLabel = chart.noData().label().enabled(true);

	noDataLabel.text("Por el momento no hay información. Intente otra consulta");
	//     chart.palette(paleta);
	chart.yAxis().title("% cumplimiento");
	chart.xAxis().labels().format(function() {
		var value = this.value;
		// limit the number of symbols to 3
		value = value.substr(0, 30);
		return value;
	});

	// configure the scale
	chart.yScale().minimum(0);
	chart.yScale().maximum(120);
	chart.yScale().ticks().interval(10);
	// chart.xAxis().staggerMode(true);
	// adjusting settings for stagger mode
	//chart.xAxis().staggerLines(2);
	chart.background().fill('#F8F5F5');
	chart.xAxis().labels().fontSize(8);
	var xLabels = chart.xAxis().labels();
	//xLabels.width(53);
	//xLabels.width(200);
	xLabels.wordWrap("break-word");
	xLabels.wordBreak("normal");
	//chart.xScroller().orientation("bottom");
	
	//  alert(j+"%");
	
	//reviso cuantos reactivos son
	var numcols=dataBarras.length;
	//para saber en cuantas columnas lo dividiré
	let p=Math.ceil(numcols/2);
	if(numcols>10){
		p=Math.ceil(numcols/3);
		console.log(j);
		//para ubicarla en la pantalla
		chart.bounds("10%", j + "%", "80%", "44%");
		chart.container(container);
	
		chart.draw();
		data2=dataBarras.splice(p,numcols-p);
		dibujarTabla(dataBarras,container,49);
		data3=data2.splice(p,numcols-p);
		dibujarTabla(data2,container,50+16);
		dibujarTabla(data3,container,49+34);
		
	}else
	if(numcols>4){
		//		//divido el arreglo y hago 2 tablas
		//		for(i=4;i<numcols;i++){
		//			data2.push(dataBarras[i]);
		//		}
		console.log(j);
		//para ubicarla en la pantalla
		chart.bounds("10%", j + "%", "80%", "51%");
		chart.container(container);
		//    anychart.theme(anychart.themes.sea);
		//chart.background().fill(["#cccccc"]);
		//chart.xGrid().palette(["#ffffff 0.6"]);
		chart.draw();
		
		data2=dataBarras.splice(p,numcols-p);
		//encabezados
		let table=generarEncabezadosAny2(dataBarras);
	    table.bounds("10%", "58%", "80%", "5%");
 	     i+=40;
  		  table.container(container).draw();
		 table=generarTablaResultados(generarTablaAny2( dataBarras));
	 	table.bounds("10%", "62%", "80%", "14%");
    	table.container(container).draw();
		let table2=generarEncabezadosAny2(data2);
	    table2.bounds("10%", "78%", "80%", "5%");
 	     i+=40;
  		  table2.container(container).draw();
		 table2=generarTablaResultados(generarTablaAny2( data2));
	 	table2.bounds("10%", "82%", "80%", "14%");
     // 	i+=40;
    	table2.container(container).draw();
		
	}else{
		//para ubicarla en la pantalla
		chart.bounds("10%", j + "%", "80%", "66%");
		chart.container(container);
		//    anychart.theme(anychart.themes.sea);
		//chart.background().fill(["#cccccc"]);
		//chart.xGrid().palette(["#ffffff 0.6"]);
		chart.draw();
		let table=generarEncabezadosAny2(dataBarras);
		 table.bounds("10%", "73%", "80%", "25%");
 	     i+=40;
  		  table.container(container).draw();
		 table=generarTablaResultados(generarTablaAny2( dataBarras));
		 table.bounds("10%", "78%", "80%", "20%");
 	     i+=40;
  		  table.container(container).draw();

	}
	dibujarlogogep(container, (j + 2) + "%");
	dibujarlogomu(container, (j + 2) + "%");
	return chart;
}

function dibujarTabla(dataBarras,container,yini){
	
	//encabezados
	let table=generarEncabezadosAny2(dataBarras);
	table.bounds("10%", yini+"%", "80%", "4%");
 	yini=yini+3
  	table.container(container).draw();
	table=generarTablaResultados(generarTablaAny2( dataBarras));
	table.bounds("10%", yini+"%", "80%", "14%");
    table.container(container).draw();
}
function dibujarlogogep(container, y2) {
	var urllogog = "https://muesmerc.mx/postmixv3/img/gepp2020.jpg";

	if (ismobile) {
		//alert(urllogog);
		//alert(y2);
		var image = anychart.graphics.image(urllogog, "12%", y2, "15%", "4%");
		image.align('x-mid-y-mid');
		image.parent(container);
	}
	else {
		var image = anychart.graphics.image(urllogog, "12%", y2, "15%", 43);
		image.align('x-mid-y-mid');
		image.parent(container);
	}


}
function dibujarlogomu(container, y2) {
	var urllogomu = "https://muesmerc.mx/postmixv3/img/logo_mues2020.png";
	ancho = container.width();
	if (ismobile) {
		w = "17%";
		h = "6%";
		x = "72%";
	}

	else {
		w = "17%";
		h = 48;
		x = "72%";
		//console.log("ancho" + ancho);
		//	x=ancho-w-70;

	}
	var image = anychart.graphics.image(urllogomu, x, y2, w, h);
	image.align('x-mid-y-mid');
	image.parent(container);

}
//        anychart.onDocumentReady(function () {
//  // create a preloader
//  preloader = anychart.ui.preloader();
//  // cover only chart container
//  preloader.render(document.getElementById("contoperacion"));      
//  // show preloader
//  preloader.visible(true);
//
// 
//  setTimeout(function() { 
//    // hide preloader after 20 seconds
//    preloader.visible(false);
//    }, 20000);
//});


function agregarLiga(chart, urldetalle) {

	chart.listen("mouseOver", function(e) {
		// change the cursor style on hovering the chart
		document.body.style.cursor = "pointer";
	});

	// create an event listener for unhovering the chart
	chart.listen("mouseOut", function(e) {
		// set the default cursor style on unhovering the chart
		document.body.style.cursor = "auto";
	});
	//add a listener
	chart.listen("pointClick", function(e) {
		//alert(e.point);
		var new_value = e.point.get("ref");
		var fil = e.point.get("fill");

		window.open(urldetalle + new_value + "&color=" + fil.substring(1, 7), "_self");//mostrar el div
	});

}
function generarTablaAny(cols, data) {
	var i;
	var j;


	for (i = 0; i < data.length; i++) {
		var arre = new Array();

		j = 0;
		while (j < cols) {

			arre[j] = data[i][j];

			j++;
		}
		contents.push(arre);


	}
	auditoriastot = $(".auditorias").val();
	// alert(auditoriastot);
	contents.push(["TOTAL", auditoriastot]);

}

function generarEncabezadosAny2(data) {
		var table = anychart.standalones.table();
	contents = new Array();
//	generarEncabezados(dataBarras);
//	console.log(dataBarras);
	
	var j;

	

	j =0 ;

	var arre = new Array();
	arre[0]="";
	while (j < data.length) {

		arre[j+1] = data[j][0]; //para el titulo
		
		j++;
		}
	//	console.log("encabezado");
	//	console.log(arre);
	table.cellFill('#F8F5F5');
 	table
   
   
    .hAlign("center");
	table.getRow(0).height(35).fontWeight(600);//titulo
	
	table.getCol(0).width(100);
	table.fontSize(8);
	table.contents([arre]);
	return table;
	}

function generarTablaAny2( data) {
	var i;
	var j;
	var titulos = ["", "%CUMPLEN",  "NUM. PRUEBAS","RES. CUMPLEN"];
	var subtitulos=["12m","6m","1m"];
	//console.log(data.length);
	//console.log(data);
//	var cols=3*data.length+1;
	
	j =0 ;
	var contents=new Array();
	var arre = new Array();
	arre[0]="";
	k=1;
//	while (j < data.length) {
//
//		arre[k++] = data[j][0]; //para el titulo
//		arre[k++]=null;
//		arre[k++]=null;
//		j++;
//	}
//	contents.push(arre);
		j=0;
	arre = new Array();
	k=1;
	arre[0]=null;
	for(i=0;i<data.length;i++){
		j=0;
		while (j < 3) {
	//console.log(k+"--"+ subtitulos[j]);
			arre[k] = subtitulos[j]; //para el titulo
			k++;
			j++;
		}
	}
	contents.push(arre);
	//para %cumple
	 arre = new Array();
		
	 arre[0] = titulos[1];

	
	k=1;	
	for(i=0;i<data.length;i++){
		j = 4;
	
		while (j >1) {
			
			if(data[i][j])
			arre[k] = data[i][j];
			else
			 arre[k]=0;
			k++;
			j--;
			
		}
	}
	contents.push(arre);

	//para cumplen
	 arre = new Array();
		
	 arre[0] = titulos[3];

	
	k=1;	
	for(i=0;i<data.length;i++){
		j = 13;
	
		while (j >8) {
			if(data[i][j])
			arre[k] = data[i][j];
			else
			 arre[k]=0;
			k++;
			j=j-2;
			
		}
	}
	contents.push(arre);
	
	//para num pruebas
	 arre = new Array();
		
	 arre[0] = titulos[2];

	
	k=1;	
	for(i=0;i<data.length;i++){
		j = 12;
	
		while (j >7) {
			
			if(data[i][j])
			arre[k] = data[i][j];
			else
			 arre[k]=0;
			k++;
			j=j-2;
			
		}
	}
	contents.push(arre);

	
	//console.log("contentes:");
	//console.log(contents);
	return contents;

}

function generarTablaR1R2(data) {
	var i;
	var j;
	var titulos = ["", "%CUMPLEN", "NUM. PRUEBAS", "RES. CUMPLEN"];
	var subtitulos=["12 MESES","6 MESES","MENSUAL"];
	var subtitulos2=["Sin ajuste","Con ajuste"];

	var cols=3*data.length+1;
	
	j =0 ;
	var contents=new Array();
	var arre = new Array();
	arre[0]=null;
	k=1;
//	while (j < 3) {
//
//		arre[k++] = subtitulos[j]; //para el titulo
//		arre[k++]=null;
//	
//		j++;
//	}
//	contents.push(arre);
		j=0;
	arre = new Array();
	
	k=1;
	arre[0]=null;
	
		j=0;
		while (j < 3) {
	
			arre[k++] = subtitulos2[0]; //para el titulo
			arre[k++] = subtitulos2[1];
			
			j++;
		}
	
	contents.push(arre);
	j=1
	
	 arre = new Array();
		
	 arre[0] = titulos[1];

	
	k=1;	
	for(i=0;i<3;i++){
		
			arre[k++] = data[i][1]; 
			arre[k++] = data[i][2]; 
			
	}
	
	
	contents.push(arre);

	
	//para num pruebas
	 arre = new Array();
		
	 arre[0] = titulos[2];

	
	k=1;	
	for(i=0;i<data.length;i++){
		
				arre[k++] = data[i][6]; 
			arre[k++] = data[i][7]; 
			
			
	}
	contents.push(arre);

	
	//para cumplen
	 arre = new Array();
		
	 arre[0] = titulos[3];

	
	k=1;	
	for(i=0;i<data.length;i++){
	
			arre[k++] = data[i][8]; 
			arre[k++] = data[i][9]; 
		
	}
	contents.push(arre);
	var table = anychart.standalones.table();
	
//	generarEncabezados(dataBarras);
//	console.log(dataBarras);
	
	//table.cellFill('#F8F5F5');
    table.rowOddFill('#F8F5F5');  // color for odd rows
    table.rowEvenFill('#FFFFFF');
   
	table.getRow(0).height(30).fontWeight(600);//titulo
	table.getCol(0).width(100).fontWeight(600);
	
	table.getRow(1).height(25);
	table.getRow(2).height(25);
	table.getRow(3).height(25);
	table.fontSize(9);
	table.contents(contents);
	return table;

}

function generarTablaResultados(funcion) {
	//lleno tabla
	var table = anychart.standalones.table();
	contents = new Array();
//	generarEncabezados(dataBarras);
//	console.log(dataBarras);
	contents=funcion;
	//table.cellFill('#F8F5F5');
 table.rowOddFill('#F8F5F5');  // color for odd rows
table.rowEvenFill('#FFFFFF');
   
   // .hAlign("right");
	table.getRow(0).height(25).fontWeight(600);//titulo
	table.getCol(0).width(100).fontWeight(600);
	//table.getCell(0,1).colSpan(3);  // span 2 cells 
	//table.getCell(0,8).fontWeight(800);
	
	table.getRow(1).height(25);
	table.getRow(2).height(25);
	table.getRow(3).height(25);
	table.fontSize(8);
	table.contents(contents);
	return table;
}

function generarEncabezados(data) {
	let $tr = $("<tr></tr>");
	//espacio en blanco
	var arre = new Array();
	arre[0] = "";
	$tr.append("<th>&nbsp;</th>");
	//$tr.attr("bgcolor", "FFFDC1");
	// $tr.css("background-color", "#FFFDC1");
	let $td;
	let i = 0;
	while (i < data.length) {
		arre[i + 1] = data[i][0];
		$td = $('<th>' + data[i][0] + '</th>');
		$tr.append($td);
		i++;
	}
	contents = [arre];

	return $tr;
}