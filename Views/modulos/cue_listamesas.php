  <?php include "Controllers/catalogosController.php";
  $catalogosControl=new CatalogosController();
  $catalogosControl->vistaLista();
  ?>

<section class="content-header">
      <h1><?php echo $catalogosControl->titulo?><small></small></h1>
     
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
	<div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; "><a href="index.php?action=nuevocatalogo&op=<?php echo $catalogosControl->op?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
	 </div>
	 </div>
    
    <?php 
    $i=$bac=1;
    foreach($catalogosControl->lista as  $item){
        	if(($i-1)%3==0){
        		echo '<div class="row">';
        		$bac=0;
        	}
        	
        	switch ($item["num_mes_asig"]){
        		case 1:
        			$nommes="ENERO";
        			break;
        		case 2:
        			$nommes="FEBRERO";
        			break;
        		case 3:
        			$nommes="MARZO";
        			break;
        		case 4:
        			$nommes="ABRIL";
        			break;
        		case 5:
        			$nommes="MAYO";
        			break;
        		case 6:
        			$nommes="JUNIO";
        			break;
        		case 7:
        			$nommes="JULIO";
        			break;
        		case 8:
        			$nommes="AGOSTO";
        			break;
        		case 9:
        			$nommes="SEPTIEMBRE";
        			break;
        		case 10:
        			$nommes="OCTUBRE";
        			break;
        		case 11:
        			$nommes="NOVIEMBRE";
        			break;
        		case 12:
        			$nommes="DICIEMBRE";
        			break;
        	}
         ?>
            <div class="col-md-4" >
              <div class="box box-info" >
                <div class="box-header with-border">
          
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
                       <?php echo '<li> MES: <strong>'.$nommes.'</strong></a></li>';?>
                        </ul>
                          <ul class="nav nav-stacked">
                   <?php echo '<li>    AÑO: <strong>'.$item[1].'</strong></a></li>';?>
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
                     
                     <a class="btn btn-block btn-info" onclick="return dialogoEliminar()"  href="<?php echo 'index.php?action=listamesas&admin=eli&op='.$catalogosControl->op.'&id='. $item["num_mes_asig"].'.'.$item["num_per_asig"]?>"><i class="fa fa-trash-o"></i></a>
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

