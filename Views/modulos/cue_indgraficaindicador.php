<!-- Content Header (Page header) -->
<?php
$graficaIndicador = new GraficaIndicadorController();

$graficaIndicador->vistaGraficaIndicadores();
?>
       <script src="views/anychart8.2.1/js/anychart-base.min.js" type="text/javascript"></script>
          <script src="views/anychart8.2.1/js/anychart-exports.min.js"></script>
          <script src="views/anychart8.2.1/js/anychart-data-adapter.min.js"></script>
            <script src="views/anychart8.2.1/js/anychart-linear-gauge.min.js"></script>
              <script src="views/anychart8.2.1/js/anychart-ui.min.js"></script>
                <script src="views/anychart8.2.1/js/anychart-table.min.js"></script>
          <script type="text/javascript">
anychart.onDocumentReady(function () {
          anychart.data.loadJsonFile("Controllers/indpostmix/indgeneragrafindicjson.php?sec=5&mes=5.2018&filx=&fily=&niv=4&filuni=1.1", function (data) {
	// create a chart and set loaded data
    chart = anychart.column();
    var series=chart.column(data);
 var yAxis = chart.yAxis();
    yAxis.title("%Establecimientos que cumplen con el estandar");
     yAxis.labels().format('{%value}%');
    chart.title("%Establecimientos que cumplen con el estandar");
    chart.listen("pointClick", function(e){ 
  var new_value = e.iterator.get(6);
  window.open(new_value,"_self"); 
});
    chart.container("container");
    chart.draw();
  
});
});

  
  $(document).ready(function(){

   // jQuery methods go here...


    


    function Cargar(menu,opcion, niv,opcionuni){
    var mes="";
    var seccion;
    var filx="";
    var nivel="";


    switch(menu)//veo la opcion del menu que se elijio
    {
    case 'u': //reviso si ya se eligio periodo y seccion
    if(document.getElementById("fechainicio").value!="")
      mes=document.getElementById("fechainicio").value;
    seccion=document.form1.numsecc.value;
    filx=opcion;
    nivel=niv;

    break;
    case 'p': //reviso si ya hay ubicacion y seccion
    mes=opcion;
    filx="";
    nivel="";
    if(document.form1.select3){
    if(document.form1.select3.value!=0)
    { var sel3=document.form1.select3.value;
    nivel=4;
    }
    else
    var sel3="";
    }
    if(document.form1.select4){
    if(document.form1.select4.value!=0)
    { var sel4=document.form1.select4.value;
    nivel=5;
    }
    else
    var sel4="";
    if (document.form1.select5.value!=0)
    { var sel5=document.form1.select5.value;
    nivel++;}
    else sel5="";
    if (document.form1.select6.value!=0)
    {
    var sel6=document.form1.select6.value;
    nivel++;
    }
    else
    sel6="";
    filx=sel3+"."+sel4+"."+sel5+"."+sel6;
    }
    seccion=document.form1.numsecc.value;

    opcionuni=document.getElementById("opcionuni").value;
    break;
    case 's': //reviso si hay ubicacion y periodo
    seccion=opcion;
    if(document.getElementById("fechainicio").value!="")
    mes=document.getElementById("fechainicio").value;
    //filx="";
    //nivel="";

    opcionuni=document.getElementById("opcionuni").value;
    if(document.form1.select3){
    if(document.form1.select3.value!=0)
    { var sel3=document.form1.select3.value;
    nivel=4;
    }
    else
    var sel3="";
    }

    if(document.form1.select4){
    if(document.form1.select4.value!=0)
    { var sel4=document.form1.select4.value;
    nivel=5;
    }
    else
    var sel4="";
    if (document.form1.select5.value!=0)
    { var sel5=document.form1.select5.value;
    nivel++;}
    else sel5="";
    if (document.form1.select6.value!=0)
    {
    var sel6=document.form1.select6.value;
    nivel++;
    }
    else
    sel6="";
    filx=sel3+"."+sel4+"."+sel5+"."+sel6;
    }
    break;
    }



    //document.form1.action='MENindprincipal.php?op=mindi&mes='+mes+"&sec="+opcion;
    // esta instruccion de abajo es la que desactive

    window.location='MENindprincipal.php?op=mindi&mes='+mes+"&sec="+seccion+"&filx="+filx+"&niv="+nivel+"&filuni="+opcionuni;

    }
    });
    function CambiaIdioma(pagina,idioma)
    {	//cambio idioma de usuario y boton salir
    //window.parent.Menu.location="../MEmodulos/MEPtop.php?lan="+idioma;
    window.location=pagina;
    }
    //alert(window.document.forms.length);

  
</script>

<section class="content-header">
    <h1> <?php echo $graficaIndicador->getNombre_indicador(); ?></h1>
    <h1> <?php echo $graficaIndicador->getPeriodo() ?></h1>
    <h1> <?php echo $graficaIndicador->getNombre_nivel() ?></h1>

</section>


<!-- Main content -->
<section class="content container-fluid">
    	<!----- Filtros ----->
    <div class="row" >
        <div class="col-md-12" >
        	<div class="box box-info" style="background-color: #FFFFFF; font-size: 13px; max-height: 200px; padding: 10px; min-height: 50px" >
		    <form name="form1" action="index.php?action=indindicadoresgrid" method="post" >
                    <div class="col-sm-4 border-right filtros" >
                          <label for="anio_asig">Seleccione el periodo</label>
				   <select name="anio" class="form-control" id="anio_asig">
    <?php echo $graficaIndicador->getOpciones_anio();?>
    </select>	
             
                    		</div>
                        <div class="col-sm-3 border-right filtros"  >
                            <label >Selecciones el mes</label>
				<select class="custom-select" name="mes">
    <?php echo $graficaIndicador->getOpciones_mes();?>
</select>
					
				</div>

			<div class="col-sm-3 border-right filtros"  >
					<label>
                Seleccione la seccion
                </label><select class="custom-select" name="sec">
    <?php echo $graficaIndicador->getListaSeccion();?>
</select>
				
				</div>
				<div class="col-sm-1 filtros"   >
					<button type="submit" class="btn btn-info pull-right">Aplicar filtros</button>
				</div>

                    </form>
			</div>
		</div>
	</div>


    <div class="row">

        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body">
                  <div id="container" style="width: 100%; height: 450px;"></div>
                    <form id="form1" name="form1" method="post" action="">

                  
                            <input name="fechainicio" type="hidden" id="fechainicio" value="{mes_indice}"  >
                            <input type='hidden' name='select3' value="<?php echo $graficaIndicador->getNivel03(); ?>">
                            <input type='hidden' name='select4' value='<?php echo $graficaIndicador->getNivel04(); ?>'>
                            <input type='hidden' name='select5' value="<?php echo $graficaIndicador->getNivel05() ;?>">
                            <input type='hidden' name='select6' value="<?php echo $graficaIndicador->getNivel06(); ?>">
                            <input name="text" type="hidden" id="numsecc" value="<?php echo $graficaIndicador->getNumsecc(); ?>"  >
                            <input name="alertanav" type="hidden" id="alertanav" value="<?php echo $graficaIndicador->getAlertanav(); ?>"  >
                            <input name="opcionuni" type="hidden" id="opcionuni" value="<?php echo $graficaIndicador->getOpcionuni();?>"  >
                         
                        <div id="dialogo2" title="Atenci&oacute;n" style="display:none;font-family:Arial, Helvetica, sans-serif;color:#808080;line-height:28px;font-size:15px;text-align:justify; ">

                            <p> Este sitio est&aacute; dise&ntilde;ado para su mejor funcionamiento en los navegadores Mozilla Firefox o Chrome. Le recomendamos su uso</p>


                        </div>
                    </form>
                    <script type="text/javascript">

    if (document.getElementById("alertanav").value == 1) //muestro alerta
        if ((/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) || (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent))) { //test for Firefox/x.x 
            var ffversion = new Number(RegExp.$1); // capture x.x portion and store as a number

        } else
        {
            $(function () {
                $("#dialogo2").dialog({
                    width: 490,
                    height: 250,
                    show: "scale",
                    hide: "scale",
                    resizable: "false",
                    position: "center",
                    modal: true,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            });
                          }
</script>
        </div>
	    </div>
	    </div>
	    </div>
	  