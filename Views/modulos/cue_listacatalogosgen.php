  <?php include "Controllers/catalogosController.php";
  $catalogosControl=new CatalogosController();
  $catalogosControl->vistaLista();
  if($catalogosControl->op=="cat"){
  	$nuevo="&cat=".filter_input(INPUT_GET, "cat",FILTER_SANITIZE_NUMBER_INT);
  }
  else{
  $nuevo="";
  }
  ?>

<section class="content-header">
      <h1><?php echo $catalogosControl->titulo?></h1>
     <h1><small>
      <?php echo $catalogosControl->nombrecat?></small></h1>
          <?php if($catalogosControl->op=="cat"){?>
     <ol class="breadcrumb" >
	<li><a href="index.php?action=listacatalogos"><em class="fa fa-dashboard"></em>CATALOGOS</a></li>
     

       
</ol>
<?php }?>
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
	<div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; "><a href="index.php?action=nuevocatalogo&op=<?php echo $catalogosControl->op.$nuevo?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
	 </div>
	 </div>
    
    <?php 
    $i=$bac=1;
    foreach($catalogosControl->lista as  $item){
        	if(($i-1)%3==0){
        		echo '<div class="row">';
        		$bac=0;
        	}
         if($catalogosControl->op=="cat"){
        		$id=$item["cad_idcatalogo"].'.'.$item["cad_idopcion"]."&cat=".$item["cad_idcatalogo"];
        	}
        	else{
        		$id=$item[0];
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
                       <?php echo '<li><a href="index.php?action=nuevocatalogo&op='.$catalogosControl->op.'&id='.$id.'"><strong>'.$item[1].'</strong></a></li>';?>
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
                      
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">
                   
                    <a class="btn btn-block btn-info" onclick="return dialogoEliminar()"  href="<?php echo 'index.php?action=listacatalogosgen&admin=eli&op='.$catalogosControl->op.'&id='.$id ?>"><i class="fa fa-trash-o"></i></a>
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

