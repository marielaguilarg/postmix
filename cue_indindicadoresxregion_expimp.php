<?php 
session_start();
if (isset($_SESSION['UsuarioInd'])) { //valido que este logeado
    
require_once "Controllers/indpostmix/tablaDinamicaController.php";
require_once "Controllers/tablahtml.php";
require_once 'libs/php-gettext-1.0.12/gettext.inc';
include('Utilerias/inimultilenguaje.php');
include('Utilerias/utilerias.php');
require_once "Models/conexion.php";

include "Models/crud_estandar.php";
include "Models/crud_estructura.php";
$nomarch="Indicadores".date("dmyHi");

$tabladin=new TablaDinamicaController();
$tabladin->exportarExcel();


?>
<style> 

.indiTit1{background-color:#6B9EDC; color:#000000; font-size:16px;  font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold; height:30px ; text-align:center; vertical-align:middle;}	
.indiTit2{background-color:#6B9EDC; color:#000000; font-size:14px;  font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold; height:30px ; text-align:center; vertical-align:middle;}	
.Estilo1 {color: #40C6F2}
.cabcol {background-color:#C5D9F1; color:#000000; font-size:14px; text-align:center
}
.cabcolsnum {background-color:#C5D9F1; color:#000000; font-size:14px; font-weight:bold; text-align:center
}
.cabcols {background-color:#C5D9F1; color:#000000; font-size:14px; font-weight:bold; text-align:center
}
.tablabord td{
font-size:14px;
border:#CCCCCC solid;
	border-width:1px;}
	.renazul{
	background-color:#C4DAF2; color:#000000; text-align:center }
	.rencrema{
	background-color:#FFFFDD; text-align:center}
	
</style>


 
 
		
		    <table width="1229" height="77"  border="0" align="center" cellpadding="0" cellspacing="0" >
 

  <tr>
        <td width="100%"  > <img src="<?php echo $tabladin->getUrl_imagen()?>" alt="logos" width="100%" height="81">     </td>
		
		
      </tr>
	
 <tr>
        <td width="100%" height="30px"  >&nbsp;    </td>
		
		
      </tr>
	

  <tr>
        <td width="99%" class="indiTit1"  >  INDICADORES POST MIX <?php echo $tabladin->getMes_asig()?><br />
    </td>
		<td width="9%"> </td>
      </tr>
      <tr>
       <td  width="126" class="indiTit2">
	
	<?php echo $tabladin->getNombreSeccion()?><br />
	<?php echo $tabladin->getEstandar()?></td>
      </tr>
  <tr>
    <td>
    
    
<table width="100%" border="1" cellpadding="0" cellspacing="0">

<!-- inicioBloque: listasec -->
  <tr>
 
    <td >
	
		<?php echo $tabladin->getListaResultados()?></td>
  </tr>

	
  
</table>


</td>
<td valign="top"><table width="139" >
 <tr>
    <td width="90"  height="31">&nbsp;</td>
  </tr>
  <!--<tr>
    <td  style="font-size:12px;">{lb_nopruebas}</td>
  </tr>
  <tr>
    <td style="font-size:12px;">{lb_porcentaje}</td>
  </tr>-->
</table></td>
  </tr>
  

</table>
	 <script language="javascript" type="text/javascript">

	
		window.print();
	
	

 </script>
<!-- finBloque: Panel -->
<?php 
}else{
  include "Controllers/controller.php";
    $mvc =new MvcController();
  
    $mvc -> inicio();
}?>