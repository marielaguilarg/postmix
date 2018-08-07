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
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>

<section class="content-header">
   
    <h3><?php echo $resultadosxrepCont->getTitulo1(); ?></h3>
    <h3><?php echo $resultadosxrepCont->getNombre_une(); ?></h3>
    <h3><?php echo $resultadosxrepCont->getNumreporte();?></h3>
    <h3><?php echo $resultadosxrepCont->getFechaVisita(); ?></h3>
    <ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <!----- Filtros ----->
    <div class="box box-info"  >
    <?php foreach($resultadosxrepCont->getListaImagenes() as $rutaimg){
    
        echo '  <a data-fancybox="gallery" href="'.$rutaimg.'"><img src="'.$rutaimg.'"></a>';
        
    }?>
  
<!--url's used in the movie-->
<!--text used in the movie-->
<!-- saved from url=(0013)about:internet -->
<?php //echo $resultadosxrepCont->getnotitaimg();   ?>
</div>
<div>
<a href="<?php echo $resultadosxrepCont->getLigaconsultarRep()?>" onClick="guardarLiga(this, \'REPORTE\');"><?php echo T_("CONSULTAR TODO EL REPORTE"); ?></a>
        
  </div>
 
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