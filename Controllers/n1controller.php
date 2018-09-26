<?php
class NunoController{

public function vistanunoController(){
			
			$respuesta =Datosnuno::vistan1Model("ca_nivel1");

			foreach($respuesta as $row => $item){


			echo '
		        <div class="col-md-4" >
		          <div class="box box-info" >
		            <div class="box-header with-border">
		              <h3 class="box-title">No. '.$item["n1_id"].'</h3>
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
		                      <li><a href="index.php?action=editan1&id='.$item["n1_id"].'"><strong>'.$item["n1_nombre"].'</strong></a></li>
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
		                   <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=listan2&idnuno='.$item["n1_id"].'"> Detalle </a></span></button>
		                  </div>
		                  <!-- /.description-block -->
		                </div>
		                <!-- /.col -->
		                <div class="col-sm-4">
		                  <div class="description-block">
		                 <button type="button" class="btn btn-block btn-info"><i class="fa fa-trash-o"></i></button>
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
		        
		   

			 
		    <!-- /.content -->
		';
		}

	}	
}


?>