<?php

include  "Controllers/indpostmix/consultaPonderadoController.php";


$cponderadoController=new ConsultaPonderadoController();

$cponderadoController->vistaPonderado();
?>

<script type="text/javascript">
<!--
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
//-->
</script>

<style >
    .los_demas {
    display: none;
}
</style>
<link rel="stylesheet" href="libs/fancybox/dist/jquery.fancybox.min.css" />
<script src="libs/fancybox/dist/jquery.fancybox.min.js"></script>
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><?php echo $cponderadoController->getNombreuni();?></h1>
<h1><?php echo $cponderadoController->getTitulo();?></h1>
<h1><?php echo $cponderadoController->getNombreseccion();?></h1>
<ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion();?>
</ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!----- Inicia contenido ----->
     
        <?php
        
        $i=1;
        $bac=1;
     
        foreach( $cponderadoController->getListaPonderados() as $resultado ) {
        	if(($i-1)%3==0){
        		echo '<div class="row">';
        		$bac=0;
        	}
        	
        	?>
        <div class="col-md-4" >
          <div class="box box-info" >
            <div class="box-header with-border">
             <h3 class="box-title">No. <?php echo $resultado["numreac"]?> </h3>

              <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="arrow">
              	  <div class="box-footer no-padding">
                   <?php echo $resultado["descreac"]?>
                    
                </div>
                </div>
               <div class="box-footer arrow">
                <div class=" col-md-12 text-center">                 
                   
                     <label><?php echo $resultado["checkreac"]?></label>
                   				  
                 </div> 
          
              </div>
               <div class="row" >
                <div class="col-sm-4 border-right">
                  <div class="description-block"> <?php echo $resultado["detareac"]?>
                
                </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block"><?php echo $resultado["comentario"]?>
              

</div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block"><?php echo $resultado["imagen"]?>
                 
                  </div>
                  <!-- /.description-block -->
                </div>

              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <?php 
        if(($i)%3==0){
        	
        	echo '</div>';
        	$bac=1;
        }
        $i++;
        } //fin foreach
        if($bac==0)
        	echo '</div>';
        	?>
      <div class="row">  
	<div class="col-md-12">	
 
    <div class="box box-info">  <div class="box-body"><strong>
        <?php echo T_("NIVEL DE CUMPLIMIENTO").": ".$cponderadoController->getNivelCumplimiento()?>
       %</strong> </div><!-- /.box-body -->
       </div></div></div>
	  </section>
  <!-- /.content-wrapper -->
 
