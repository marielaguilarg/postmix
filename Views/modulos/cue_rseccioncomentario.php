 <?php 

 ?>
 <script type="text/javascript">
<!--
function Cargar()
{

	 $( "#form1" ).submit();
}
//-->
</script>
  <section class="content container-fluid">
 <form id="form1" name="form1" method="post" action="<?php echo $comentarioController->liga?>">
           
      <!----- Inicia contenido ----->
     
        <?php
     echo $comentarioController->mensaje;   
        $i=1;
        $bac=1;
     
        foreach( $comentarioController->getListaComentarios() as $resultado ) {
        	if(($i-1)%3==0){
        		echo '<div class="row">';
        		$bac=0;
        	}
        	
        	?>
        <div class="col-md-4" >
          <div class="box box-info" >
            <div class="box-header with-border">
             <h3 class="box-title">No. <?php echo $resultado["numcomen"]?> </h3>

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
                   <?php echo $resultado["CeldaComent1"]?>
                    
                </div>
                </div>
               <div class="box-footer arrow">
                <div class=" col-md-12 text-center">                 
                   
                     <ul class="nav nav-stacked">
                      <li><label>SELECCIONAR 
                       <?php echo $resultado["checkcomen"];
                       echo $resultado["valcom"];
                       ?>
                      </label></li>
                        </ul>   
                   		   <input name="idseccion" type="hidden" value="<?php echo $comentarioController->getIdSecc()?>">
   <input name="IdR" type="hidden" value="<?php echo $comentarioController->getIdReport()?>">
      <input name="sv" type="hidden" value="<?php echo $comentarioController->sv?>">
      <input name="pv" type="hidden" value="<?php echo $comentarioController->pv?>">
              		  
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
        
       echo '<button type="button" class="btn btn-default pull-right" style="margin-right: 18px"  onclick="document.location=\''.$comentarioController->regresar.'\'" >  Cancelar  </a>';?>
   
     <button  tyrpe="button" class="btn btn-info pull-right" onclick="javascript: Cargar();">Guardar</button>
             
	     		</form>
	     		</section>