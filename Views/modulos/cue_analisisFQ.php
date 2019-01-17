<?php

include "Controllers/analisisController.php";

$analisisController=new AnalisisController();
$tipo=filter_input(INPUT_GET, "tipo",FILTER_SANITIZE_STRING);
$analisisController->listaAnalisis($tipo);

?>
 <section class="content-header">
   <h1 class="box-title">&nbsp;</h1>
  <ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
      </ol>
 </section>

    <!-- Content Header (Page header) -->
  
      <section class="content-header">
  
     
  <div class="row">
    <div class="col-md-6"><br></div>
    <div class="col-md-6"><?php echo $analisisController->getTITULO4()?></div>
 </div>
  <div class="row">
 <div class="col-md-6"><?php  echo $analisisController->getTITULO()." ".$analisisController->getTITULO2()?></div>
    <div class="col-md-6"><?php echo $analisisController->getNUMREP()?></div>
  
  </div>
  <div class="row">
   <div class="col-md-6"> <?php echo $analisisController->getTITULO5()?></div>
	<div class="col-md-6"><?php echo $analisisController->getFechaVisita()?></div>
  </div>
    <div class="row">
   <div class="col-md-6"><input type="hidden" name="numtoma" id="numtoma" value="<?php echo $analisisController->getntoma()?>"></div>
	<div class="col-md-6"></div>
  </div>
 
 
</section>
 
    <!-- Main content -->
    <section class="content container-fluid">
   
<div class="row">
<div class="col-md-12">
    
   <?php echo $analisisController->getBotnvo()?>
       </div>
   </div>
      <!----- Inicia contenido ----->
           
        <div class="row">
        	 <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo  "RESULTADO" ." ". $numren;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 20%"><?php echo "REACTIVO"?></th>
                  <th style="width: 24%"><?php echo "ESTANDAR"?></th>
                  <th style="width: 56%"><?php echo "RESULTADO"?></th>
                </tr>
         <?php 
         foreach($analisisController->getListaEstandar()  as $reactivo){
             
         echo "<tr><td>".$reactivo["atributo"]."</td>";
         echo "<td>".$reactivo["estandar"]."</td>";
                echo "<td>".$reactivo["resultado"]."</td></tr>";
         }
                ?>
              </table>
            </div>
            <!-- /.box-body -->
         
          </div>
          <!-- /.box -->
        </div>
        </div>
      
        
	  <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
 