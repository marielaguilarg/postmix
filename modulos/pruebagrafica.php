<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
          <script src="../anychart8.2.1/js/anychart-base.min.js" type="text/javascript"></script>
          <script src="../anychart8.2.1/js/anychart-exports.min.js"></script>
          <script src="../anychart8.2.1/js/anychart-data-adapter.min.js"></script>
            <script src="../anychart8.2.1/js/anychart-linear-gauge.min.js"></script>
              <script src="../anychart8.2.1/js/anychart-ui.min.js"></script>
                <script src="../anychart8.2.1/js/anychart-table.min.js"></script>
          <script type="text/javascript">

//          anychart.data.loadJsonFile("indgeneragrafindicjson.php?sec=5&mes=5.2018&filx=&fily=&niv=4&filuni=1.1", function (data) {
//	// create a chart and set loaded data
//    chart = anychart.column();
//    var series=chart.column(data);
//
//    chart.title("Load JSON data and create a chart");
//    chart.container("container");
//    chart.draw();
//});
anychart.onDocumentReady(function () {
function drawGauge(value, rango1,rango2,rango3,rango4) {
   // create data
   var data = [value];

   // set the gauge type
   var gauge = anychart.gauges.linear();

   // set the data for the gauge
   gauge.data(data);
  
   // set the layout
   gauge.layout('horizontal');

   // create a color scale
   var scaleBarColorScale = anychart.scales.ordinalColor().ranges(
   [
       {
           from: 0,
           to: rango1,
           color: ['#D81E05', '#EB7A02']
       },
       {
           from: rango1,
           to: rango2,
           color: ['#EB7A02', '#FFD700']
       },
       {
           from: rango2,
           to: rango3,
           color: ['#FFD700', '#CAD70b']
       },
      {
          from: rango3,
          to: rango4,
          color: ['#CAD70b', '#2AD62A']
      }
   ]
   );

   // create a Scale Bar
   var scaleBar = gauge.scaleBar(0);

   // set the height and offset of the Scale Bar (both as percentages of the gauge height)
   scaleBar.width('40%');
   scaleBar.offset('31.5%');

   // use the color scale (defined earlier) as the color scale of the Scale Bar
   scaleBar.colorScale(scaleBarColorScale);

   // add a marker pointer
   var marker = gauge.marker(0);

   // set the offset of the pointer as a percentage of the gauge width
   marker.width('25%');
    marker.offset('32%');
   marker.fill("#707B7C");
   
   // set the marker type
   marker.type('triangle-up');
 
   // set the zIndex of the marker
   marker.zIndex(10);

   // configure the scale
   var scale = gauge.scale();
   scale.minimum(0);
   scale.maximum(100);
   scale.ticks().interval(10);

   // configure the axis
   var axis = gauge.axis();
   axis.minorTicks(true);
   axis.minorTicks().stroke('#cecece');
   axis.width('1%');
   axis.offset('29.5%');
   axis.orientation('top');

   // format axis labels
   axis.labels().format('{%value}%');
    // set paddings
   gauge.padding([0, 50]);

return gauge;
}

 
  // set stage
  var stage = anychart.graphics.create("container");
  
  anychart.data.loadJsonFile("indgeneragrafindicjson.php?sec=5&mes=5.2018&filx=&fily=&niv=4&filuni=1.1", function (data) {
//	
   var Availability = anychart.data.set(data);
  // Data for charts in table
//  var Availability = anychart.data.set([
//    ["Network",98.6, 0, 70,80, 100],
//    ["ERP",98.4, 0, 60,97.9, 100],
//    ["Data Warehouse",  98.5,0,87.2, 98.2, 100]
//  ]);
  var AcceptedAvailability = anychart.data.set([
    [ 99],
    [ 98],
    [98]
  
  ]);
  
  // content for first row
  var contents = [[ "ATRIBUTO", "% DE ESTABLECIMIENTOS QUE CUMPLEN CON EL ESTANDAR"]];
  
  
  
  
  // Table settings
  
  // create table
  var table = anychart.standalones.table();
  
 // table.top(title.getRemainingBounds().getTop());
  
  for(var i= 0; i<Availability.getRowsCount(); i++){
    contents.push([
                               // create line charts in the first column
      Availability.row(i)[0],       // get names for second column
      drawGauge(Availability.row(i)[1],Availability.row(i)[2],Availability.row(i)[3],Availability.row(i)[4],Availability.row(i)[5])                        // create bullet charts for third column
     
    ]);
  }
  
//  var axis = anychart.standalones.axes.linear();
//  axis.scale(bulletScale);
//  axis.orientation("bottom").staggerMode(false).stroke("#ccc");
//  axis.minorTicks().enabled(false);
//  axis.title().enabled(false);
//  axis.labels()
//    .fontSize("9px")
//    .format(function(value) {
//      return value["tickValue"] + "%";
//    });
//  axis.ticks().stroke("#ccc");
//  
//  contents.push([null, null, axis, null]);
  
  // set table content
  table.contents(contents);
  
  // disable borders and adjust width of second and fourth column
  table.cellBorder(null);
  table.getCol(0).width(130);
 // table.getCol(2).width(50);
  table.getRow(0).height(20);
 // table.getRow(3).height(25);
  
  // visual settings for the first row
  table.getCell(0,0).fill("#444444").fontColor("#FFF");
  table.getCell(0,1).fill("#444444").fontColor("#FFF");
 // table.getCell(0,2).fill("#444444").colSpan(2).fontColor("#FFF").hAlign("right");
  table.getCell(1,2).padding(0,9);
  
  // visual settings for text in table
  table.vAlign("middle").hAlign("center").fontWeight(600).fontSize(12);
  
  // set table container and initiate draw
  table.container(stage).draw();
  
  
  // Settings for table content
  
  
  
  // create legend
  var legend = anychart.standalones.legend();
//  legend.itemsFormatter(function (){
////    var items = [
////      {
////"index": 0,
////"text": "Actual",
////"iconType": function(path, size) {
////  path.clear();
////  var x = Math.round(size / 2);
////  var y = Math.round(size / 2);
////  var height = size * 0.6;
////  path.clear()
////    .moveTo(x, y - height / 2)
////    .lineTo(x, y + height / 2)
////    .lineTo(x + 2, y + height / 2)
////    .lineTo(x + 2, y - height / 2)
////    .close();
////},
////"iconStroke": "none",
////"iconFill": "#000"
////      },
////      {
////"index": 1,
////"text": "Acceptable",
////"iconType": function(path, size) {
////  path.clear();
////  var x = Math.round(size / 2);
////  var y = Math.round(size / 2);
////  var height = size * 0.8;
////  path.clear()
////    .moveTo(x - 2, y - height / 2)
////    .lineTo(x - 2, y + height / 2)
////    .lineTo(x + 3, y + height / 2)
////    .lineTo(x + 3, y - height / 2)
////    .close();
////},
////"iconStroke": "none",
////"iconFill": "#ccc"
////      }
////    ];
//    return items;
//  });
  legend.title().enabled(false);
  legend.titleSeparator().enabled(false);
  legend.paginator().enabled(false);
  legend.fontSize("10px").itemsLayout("horizontal").iconTextSpacing(0).align("right").position("center-bottom").padding(0).margin(0).itemsSpacing(0);
  legend.parentBounds(anychart.math.rect(0, 15, stage.width(),15));
  legend.background().enabled(false);
  legend.container(stage).draw();



  
   // set the container id
 //  gauge.container('container');

   // initiate drawing the gauge
  // gauge.draw();
  });
});
 
</script>
    </head>
    <body>      



         <div id="container" style="width: 1024px; height: 450px;"></div>
        <?php
        // put your code here
        ?>
    </body>
</html>
