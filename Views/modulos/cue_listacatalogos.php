  <?php include "Controllers/catalogosController.php";
  $catalogosControl=new CatalogosController();
  $catalogosControl->vistaListaCat();
  ?>

<section class="content-header">
      <h1>CATALOGOS<small></small></h1>
     
    </section>
   <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>
    <!-- Main content -->
    <section class="content container-fluid">
    <div class="row">
	<div class="col-md-12" >
	<a  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; " href="index.php?action=nuevocatalogo&op=cc"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
	 </div>
	 </div>
    
    <?php 
    $i=$bac=1;
    foreach($catalogosControl->lista as  $item){
        	if(($i-1)%3==0){
        		echo '<div class="row">';
        		$bac=0;
        	}
     
         ?>
            <div class="col-md-4" >
              <div class="box box-info" >
                <div class="box-header with-border">
              <?php echo '<h3 class="box-title">No. '.$item[0].'</h3>'?>
                  <div class="box-tools pull-right">
                   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="arrow">
                  	  <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                       <?php echo '<li><a href="index.php?action=nuevocatalogo&op=cc&id='.$item[0].'"><strong>'.$item[1].'</strong></a></li>';?>
                        </ul>
                      
                    </div>
                  </div>
                   <div class="row" >
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                     
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                       <a class="btn btn-block btn-info"  href="<?php echo 'index.php?action=listacatalogosgen&op=cat&cat='.$item["ca_idcatalogo"] ?>">DETALLE</a>
                    
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">
                     
                     <a class="btn btn-block btn-info" onclick="return dialogoEliminar()"  href="<?php echo 'index.php?action=listacatalogos&admin=eli&cat='.$item["ca_idcatalogo"] ?>"><i class="fa fa-trash-o"></i></a>
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
           <?php 
           if(($i)%3==0){
           	
           	echo '</div>';
           	$bac=1;
           }
           $i++;
      }?>
    </section>

