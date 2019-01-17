

<?php
include 'Controllers/consultaResController.php';

$consultaResCon=new consultaResController();
$consultaResCon->vistaConsultaRes();
?>
<script type="text/javascript">
<!--
function muestra_oculta(id, grupo) {
	if (document.getElementById) { //se obtiene el id
		var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
		el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
		el = document.getElementById('tipo_mer');
		el.style.visibility = (el.style.visibility == 'visible') ? 'hidden' : 'visible';

	}
}
function CambiaIdioma(pagina,idioma)
{	//cambio idioma de usuario y boton salir
	//window.parent.Pie.location="index.php?action=consultaResultados&lan="+idioma;
	window.location=pagina;
}
//-->
</script>
   <script type="text/javascript" src="js/MENindcomboboxcuenta.js"></script>

<section class="content-header">

     <h1 class="box-title"><?php echo T_("CONSULTAS / RESULTADOS")?></h1>
<a href="javascript: CambiaIdioma('<?php echo $consultaResCon->getLiga_esp()?>','esp');" >
<span style=" text-align:right; width:100%; font-size:9px; color:#336600" >VERSION ESPAÑOL</span></a> 
&nbsp;<a href="javascript: CambiaIdioma('<?php echo $consultaResCon->getliga_ing()?>','en');"><span style=" text-align:right; width:100%; font-size:9px; color:#336600" >ENGLISH VERSION</span></a></span></td>
	
    <ol class="breadcrumb">
           <?php Navegacion::desplegarNavegacion();?>
       
    </ol>
</section>
<!-- Main content -->
<section class="content container-fluid">
<!--  filtros -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo T_("ESTIMADO USUARIO, PARA CONSULTAR LOS RESULTADOS DEFINA LOS SIGUIENTES CRITERIOS:")?></h3>
        </div>
        <div class="box-body">
        <form name="form1" method="post"	action="index.php?action=resumenresultados&admin=prin">
        <div class="row align-items-center">
            
              <div class="col-md-6">
              
         
				
                <div class="form-group">
                    <label><?php echo T_("TIPO MERCADO")?>  </label>  
                    <?php echo $consultaResCon->getOPMERCADO();?>
                </div>
              
                   <div class="form-group ">
        <label><?php echo T_("CUENTA")?></label>
     <div>
  <?php
 
            foreach ($consultaResCon->getListaCuentas() as $cuenta) {
                echo $cuenta;
            }
            ?>
     </div>
    </div>
                   <div class="form-group ">
        <label><?php echo T_("FRANQUICIA")?></label>
       <div>
  <?php
            foreach ($consultaResCon->getListaFranquicias() as $franq) {
                echo $franq;
            }
            ?>
       
</div>
    </div>
         <div class="form-group ">
        <label><?php echo T_("PUNTO DE VENTA")?>:</label>
       <div>
  <?php
           echo $consultaResCon->getOPUNEGOCIO() 
            ?>
       
</div></div>
  
  
    </div>
    
    
          
            <div class="col-md-6 align-self-center"> 
             <div class="row ">  <div class="col-md-12">&nbsp;</div></div>
             <div class="row "> <div class="col-md-12">&nbsp;</div></div>
             <div class="row ">  <div class="col-md-12">&nbsp;</div></div>
               <div class="row ">  <div class="col-md-12">&nbsp;</div></div>
                 <div class="row ">  <div class="col-md-12">&nbsp;</div></div>
                   <div class="row ">  <div class="col-md-12">&nbsp;</div></div>
             <div class="row ">
     <div class="col-md-4">
        
    <label>INDICE DE : </label></div>
       <div class="col-md-4"><select class="form-control"  name="fechainicio"  id="fechainicio" >
	
    
         <?php echo $consultaResCon->getMeses_opt()?>
      
             
       
	</select></div>
	<div class="col-md-4">
	 <select class="form-control" name="fechainicio2">
 <option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>                 										                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
       </select></div></div>
        <div class="row align-items-start">
          <div class="col-md-4">
    <label>AL INDICE DE :</label></div>
       <div class="col-md-4">
   <select class="form-control"   id="fechafin" name="fechafin" >
      <?php echo $consultaResCon->getMeses_opt()?>
      
	</select></div>
       <div class="col-md-4">
       <select class="form-control" name="fechafin2">
	 <option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>                 										                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
       </select>
      
       
  </div></div></div>
  
  </div> <!-- fin consulta básica -->
 <div class="row"><div class="col-md-12">
  <?php echo $consultaResCon->getAvanzada()?></div>
  </div>
  <div class="row" id="contenido_a_mostrar" style="display:none">
<div class=" col-md-6">     
         
            <?php   echo $consultaResCon->getListanivel1() ?>
            <input	name="varnivel2" type="hidden" id="varnivel2" value="<?php echo $consultaResCon->getVarnivel() ?>" />
                          
          <?php   echo $consultaResCon->getListanivel2() ?>
     <?php   echo $consultaResCon->getListanivel3() ?>
   
    
</div>
                <div class=" col-md-6">     
      <?php   echo $consultaResCon->getListanivel4() ?>
      <?php   echo $consultaResCon->getListanivel5() ?>
      <?php   echo $consultaResCon->getListanivel6() ?>
      
      </div></div>
    <div class="col-md-12 form-group">
    
    <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i><?php echo T_("BUSCAR")?></button>
   </div>

  </form>
  </div>
    </div>
   
 
<!----- Finaliza contenido ----->
</section>
<!-- /.content -->
<!-- /.content-wrapper -->
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
   <script src="js/jquery.cascading-drop-down.js"></script>
    <script>
    $('.cascada').ssdCascadingDropDown({
        nonFinalCallback: function(trigger, props, data, self) {
            trigger.closest('form')
                    .find('input[type="submit"]')
                    .attr('disabled', true);
        },
        finalCallback: function(trigger, props, data) {
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