<?php $resultadosxrepCont=new ResumenResxRepController;
  $resultadosxrepCont->vistaResumenResxRep();
  ?>

<script type="text/javascript" language="javascript">
 function MostrarFilas(Fila, objeto) {
var elementos = document.getElementsByName(Fila);
    for (i = 0; i< elementos.length; i++) {
        if(navigator.appName.indexOf("Microsoft") > -1){
               var visible = 'block'
        } else {
               var visible = 'table-row';
        }
       if(elementos[i].style.display=='none'||elementos[i].style.display=='')
			{elementos[i].style.display = visible;
			document.getElementById(objeto).innerHTML="minimizar";
			}
			else
			{	elementos[i].style.display='none';
				document.getElementById(objeto).innerHTML="desplegar";
			}
}
}
</script>

<style >
    .los_demas {
    display: none;
    }</style>
<section class="content-header">  <div id="encabezado2"   class="encabezado_cons" >  <h3><?php echo $resultadosxrepCont->getTitulo1(); ?></h3>    <h3><?php echo $resultadosxrepCont->getNombre_une(); ?></h3>    <h3><?php echo $resultadosxrepCont->getNumreporte();?></h3>    <h3><?php echo $resultadosxrepCont->getFechaVisita(); ?></h3></div>
    <ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
  </ol>
</section>

<?php //echo $resultadosxrepCont->getnotitaimg();   ?>
<section class="container-fluid">
<div class="row">
 <div class="col-xs-12">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <a class="btn btn-info btn-sm" href="<?php echo $resultadosxrepCont->getLigaconsultarRep()?>" onClick="guardarLiga(this, \'REPORTE\');"><?php echo T_("CONSULTAR TODO EL REPORTE"); ?></a><?php echo $resultadosxrepCont->getlb_notita_img()?>
</div>
    </div>
    </section>
 <section class="content container-fluid">
           <?php            
           foreach ($resultadosxrepCont->getListaTablas() as $seccion) {
               echo ' <div class="row">
               <div class="col-xs-12">
               <div class="box">'.
                $seccion.'  </div>
          <!-- /.box -->
        </div>
      </div>';
           }    
             ?>   
     
</section>