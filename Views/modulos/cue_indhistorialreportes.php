<?php 
$generarbusquedacont=new GenerarBusquedaController;
$generarbusquedacont->generarBusquedaRes();
$historialRepController=new HistorialReportesController();
$historialRepController->vistaHistorialReportes();
?>
<style >
    .los_demas {
    display: none;
}
</style>
 
<script language="JavaScript" type="text/JavaScript"> 
 
function enviar(direccion)
{
	if(direccion=="")

	direccion="MENprincipal.php?op=Bhistorico2&Opcion=listrep";
			/*if(navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i))
	 {	document.form1.target='_blank';
		 document.form1.action=direccion+'&mb=si';
	 }*/
	document.form1.submit();
}
 function MostrarFilas(Fila,objeto) {
var elementos = document.getElementsByName(Fila);
    for (i = 0; i< elementos.length; i++) {
        if(navigator.appName.indexOf("Microsoft") > -1){
               var visible = 'block'
        } else {
               var visible = 'table-row';
        }
		if(elementos[i].style.display=='none'||elementos[i].style.display=='')
			{elementos[i].style.display = visible;
			//document.getElementById(objeto).innerHTML="minimizar lista";
			document.getElementById(objeto).innerHTML="{lb_minimizar}";
			}
			else
			{	elementos[i].style.display='none';
				document.getElementById(objeto).innerHTML="{lb_desplegar}";
			}
        }
	//alert(objeto);
	
	//	objeto.parent.innerHTML="otra cosa";
}

</script>

<section class="content-header">
   
    <h3><?php echo $historialRepController->getUnidadneg(); ?></h3>
    <ol class="breadcrumb">
             <?php Navegacion::desplegarNavegacion();?>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <!----- Filtros ----->
   <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
               <h3 class="box-title"><?php echo $historialRepController->getTitulo1()?></h3>
         <input name="cuenta" type="hidden" value="{cuenta}" />
 <input name="periodo" type="hidden" value="{periodo}" />
 <input name="unidadnegocio" type="hidden" value="{ID_PTO_VTA}" />
 <input name="num_rep" type="hidden" value="{total_res}" />
      </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
 
 
            <tr>
                <th ><?php echo T_("REPORTE NO.")?></th>
                
                  <th ><?php echo T_("MES")?></th>
                  
  </tr>
    <?php foreach($historialRepController->getListaReportes() as $reporte){
                 
             
        echo "    <tr>";
           
			 echo $reporte["IdInspeccion"];
			 echo $reporte["MesAsignacion"];
            
  echo "</tr>";
         
 }?>
</table> 
        </div><!-- /.box-body -->
        <div class="box-footer">
         <?php echo $historialRepController->getNumeroReportes();
         echo $generarbusquedacont->getMensaje();
         ?>
            
        </div><!-- box-footer -->
      </div><!-- /.box -->
        </div>
      </div>
      
 <?php if($generarbusquedacont->getMensaje()==""){
     $resumenRes=new ResumenResultadosController;
     
     $resumenRes->vistaResumenResultados();
     
     include "cue_indresumenresultados.php";
}?>


 
 


<!-- finBloque: PanelHisto -->
