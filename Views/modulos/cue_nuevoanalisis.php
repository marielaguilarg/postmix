<script language="JavaScript" type="text/JavaScript">

</script>

<?php 
include "Controllers/analisisController.php";

$analisisController=new AnalisisController();
$tipo=filter_input(INPUT_GET, "tipo",FILTER_SANITIZE_STRING);
if($tipo=="MB")
$analisisController->nuevoAnalisisMB();
 if($tipo=="FQ")
	$analisisController->nuevoAnalisisFQ();
?>
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

    <section class="content container-fluid">

  <div class="box">
       <form id="form1" name="form1" method="post" action="index.php?action=analisisFQ&tipo=<?php echo $tipo?>&admin=insertar<?php echo $tipo?>&ntoma=<?php echo $analisisController->getNmues()?>" onSubmit="return validar();">
          
            <div class="box-header">
NUEVO REGISTRO
            </div>
            <!-- /.box-header -->
             <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-striped">
              <thead>
            <tr>

               <th>No. </th>
            <th>PRUEBA</th>
            <th>ESTANDAR</th>
            <th>RESULTADO</th>
                
            </tr>
		
    </thead>

        <tbody>

        

        <?php foreach($analisisController->getListaEstandar() as $prueba){
        	
?>
          <tr> 
          <?php echo $prueba;?>
            </tr>

                 <?php } //fin foreach?>



        </tbody>

    </table>

            </div>
<div class="box-footer">
 <a class="btn btn-default pull-right" style="margin-left: 10px" href="index.php?action=analisisFQ&tipo=<?php echo $tipo.'&ntoma='.$analisisController->getNmues()?>"> Cancelar </a> 
                 
                  <button type="submit" class="btn btn-info pull-right">Guardar</button></div>
            <!-- /.box-body -->
  

</form>
          </div>

</section>

       

    
   <!-- /.content-wrapper -->
