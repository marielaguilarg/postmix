<script language="JavaScript" type="text/JavaScript"> 
function validar(form){
	if(confirm("¿Realmente desea eliminar?")){
		return true;
	}else{
		//Si el codigo llega hasta aquí, todo estará bien  y realizamos el Submit
		return false;
	}
}</script>


<?php
include "Controllers/recepcionDetalleController.php";
$detalle= new RecepcionDetalleController();
$detalle -> vistaDetalle();

?>
 <section class="content-header">
  <div class="row" style="margin-top:-40px;" >

   <h1 style="font-size:25px; margin-left: 15px; ">

RECEPCION DE MUESTRAS DETALLE</h1>  

</div>
   
<ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
  </ol>  
<ol class="breadcrumb" >
     
        
</ol>
 </section>     

    <section class="content container-fluid">
<?php echo $detalle->getMensaje();?>

	<!----- Inicia contenido ----->
<div class="row">
<div class="col-md-12">
    
<a class="btn btn-default pull-right" style="margin-right: 18px" href="<?php echo $detalle->getNumrec() ?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
       </div>
   </div>
      <div class="row">
    <div class="col-md-12" >
     
       
<?php 

 foreach($detalle->getListaRecepciones() as $item){
          echo '
            <div class="col-md-6" >
              <div class="box box-info" >
                <div class="box-header with-border">
                <h3 class="box-title">NO.'. $item["nummues"].'</h3>

                  <div class="box-tools pull-right">
                   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
<div class="row col-sm-12">
                 <div class="arrow">
                      <div class="box-footer no-padding">
                      
                        <ul class="nav nav-stacked">
                        <li><a>NO. MUESTRA <strong>'. $item["idmue"].'</strong></a></li>
                        </ul>
                    </div>
                  </div>
            </div>      
                  
<div class="row col-sm-12">
                 <div class="arrow">
                      <div class="box-footer no-padding">
                      
                        <ul class="nav nav-stacked">
                        <li><a>TIPO DE AGUA : <strong>'. $item["tipomue"].'</strong></a></li>
                        </ul>
                    </div>
                  </div>
            </div>           

           ';
         ?>

                   <div class="row col-sm-12">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                     
                        FISICOQUIMICO :

                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-text">UNIDADES</h5>
            <strong> <?php echo $item["uFQ"];?></strong>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                         <h5 class="description-text">CAPACIDAD ML</h5>
             <strong> <?php echo $item["capacidadFQ"];?></strong>
                      </div>
                      <!-- /.description-block -->
                    </div>
                  </div> 

                  <div class="row col-sm-12">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                     
                        MICROBIOLOGICO :

                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                         <h5 class="description-text">UNIDADES</h5>
                 <strong>   <?php echo $item["uMB"];?></strong>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  
                     <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                         <h5 class="description-text">CAPACIDAD ML</h5>
                   <strong> <?php echo $item["capacidadMB"];?></strong>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div> 





                       </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
           
            
        </div>
                 

      <?php }?>

</div>
</div>
</section>

       

    
   <!-- /.content-wrapper -->
