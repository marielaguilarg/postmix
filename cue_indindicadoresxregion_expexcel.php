<?php 
require_once "Controllers/indpostmix/tablaDinamicaController.php";
require_once "Controllers/tablahtml.php";
require_once 'libs/php-gettext-1.0.11/gettext.inc';
include('Utilerias/inimultilenguaje.php');
include('Utilerias/utilerias.php');
require_once "Models/conexion.php";

include "Models/crud_estandar.php";
include "Models/crud_estructura.php";
$nomarch="Indicadores".date("dmyHi");
// header("Content-Type: application/x-msexcel; name=\"".$nomarch.".xls\"");
// header("Content-Disposition: attachment; filename=\"".$nomarch.".xls\"");
$tabladin=new TablaDinamicaController();
$tabladin->exportarExcel();
?>

<HTML xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">

<!--- Using XML you can set all sorts of options for the excel document before
you include the HTML table that contains the cell data --->

<HEAD>
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<style>
<!--table
@page
{mso-page-orientation:Portrait;
margin:.24in .24in .79in .31in;
	mso-header-margin:0in;
	mso-footer-margin:.51in;}
-->

</style>

<!--- A simple search on google will give you an XML schema for excel, in this
example, after setting the page orientation to landscape I set the page to Fit
to one page wide, the 50 page long basically says the excel document can be as
long as it needs to be, we just don't want it to span multiple page
horizontally. --->
<xml>
<x:ExcelWorkbook>
<x:ExcelWorksheets>
<x:ExcelWorksheet>
<x:WorksheetOptions>
<x:FitToPage/>
<x:Print>
<x:FitWidth>1</x:FitWidth>
<x:FitHeight>1</x:FitHeight>
<x:ValidPrinterInfo/>
</x:Print>
</x:WorksheetOptions>
</x:ExcelWorksheet>
</x:ExcelWorksheets>
</x:ExcelWorkbook>
</xml>

<style> 

.indiTit1{background-color:#6B9EDC; color:#000000; font-size:16px;  font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold; height:30px ; text-align:center; vertical-align:middle;}	
.indiTit2{background-color:#6B9EDC; color:#000000; font-size:14px;  font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold; height:30px ; text-align:center; vertical-align:middle;}	
.Estilo1 {color: #40C6F2}
.cabcol {background-color:#C5D9F1; color:#000000; font-size:12px;
}
.cabcols {background-color:#C5D9F1; color:#000000; font-size:12px; font-weight:bold;
}
.tablabord td{
font-size:12px;
border:#CCCCCC solid;
	border-width:1px;}
	.renazul{
	background-color:#C4DAF2; color:#000000; }
	.rencrema{
	background-color:#FFFFDD;}
	
</style>
 

</head>

<body>
 
 
		
		    <table width="897" height="77"  border="0" align="center" cellpadding="0" cellspacing="0" style='border-collapse:
 collapse;table-layout:fixed;width:877pt'>
 <tr> <td height=94 width=283 style='height:70.85pt;width:212pt' align=left
  valign=top><!--[if gte vml 1]><v:shape id="_x0031__x0020_Imagen" o:spid="_x0000_s1025"
   type="#_x0000_t75" alt="{url_imagen}" style='position:absolute;
   margin-left:0;margin-top:0;width:278.68113mm;height:21.56604mm;z-index:1;
   visibility:visible' o:gfxdata="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
">
   <v:imagedata src="{url_imagen}" o:title=""/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]-->
 <![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:1;margin-left:1px;margin-top:0px;width:1053px;
  height:82px'><img width=1086 height=92 src="<?php echo $tabladin->getUrl_imagen()?>" 
  v:shapes="_x0031__x0020_Imagen"></span><![endif]>
<!--
  <tr>
        <td width="99%"  > <img src="{url_imagen}" alt="logos" width="1077" height="81">     </td>
		
		
      </tr>
	  <tr>
        <td width="99%"  >&nbsp;     </td>
		
		
      </tr>
	  <tr>
        <td width="99%"  >&nbsp;    </td>
		
		
      </tr>
	    <tr>
        <td width="99%"  >&nbsp;    </td>
		
		
      </tr>
	    <tr>
        <td width="99%"  >&nbsp;    </td>
		
		
      </tr>
 -->
  <tr>
      <td width="99%" class="indiTit1"  >  INDICADORES POST MIX  <?php echo $tabladin->getMes_asig()?><br />
   </td>
		<td width="9%"> </td>
      </tr>
  <tr>
    <td>
    
    
<table width="100%" border="1" cellpadding="0" cellspacing="0">

<!-- inicioBloque: listasec -->
  <tr>
  <td style='height:24.6pt;border-top:none;
  width:10pt' width="126" class="indiTit2">
	<?php echo $tabladin->getNombreSeccion()?>
	<br />
	<?php echo $tabladin->getEstandar()?>	</td>
    </tr>
    <tr>
    <td width="634pt">
	
	<?php echo $tabladin->getListaResultados()?>	</td>
  </tr>
	
	
  
</table>


</td><td><table width="100%" border="0">
 <tr>
    <td width="80">&nbsp;</td>
  </tr>
   <tr>
    <td >&nbsp;</td>
  </tr>
   <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
 <!-- <tr>
    <td  style="font-size:12px;">{lb_nopruebas}</td>
  </tr>
  <tr>
    <td style="font-size:12px;">{lb_porcentaje}</td>
  </tr>-->
</table></td>
  </tr>
  

</table>
	

	

</body>
<!-- finBloque: Panel -->