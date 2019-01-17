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
include "Controllers/pruebaController.php";
$pruebaController=new PruebaController();
$pruebaController->vistaDetalle();?>
 <section class="content-header">
  <div class="row" style="margin-top:-40px;" >

   <h1 style="font-size:25px; margin-left: 15px; ">
PRUEBAS PARA EL ANALISIS DE AGUA <br><small><?php echo $pruebaController->getTITULO5()?></small></h1>  


</div>
 
 </section>     

    <section class="content container-fluid">
<div class="row">
<div class="col-md-12">
    
<a class="btn btn-default pull-right" style="margin-right: 18px" href="index.php?action=nuevaprueba&serv=<?php echo $pruebaController->getIds()?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a>
       </div>
   </div>
   <?php echo $pruebaController->getMensaje()?>
  <div class="box">
          
            <div class="box-header">

            </div>
            <!-- /.box-header -->
             <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-striped">
              <thead>
            <tr>

                <th>NO.</th>

              
                <th>NOMBRE DE LA PRUEBA</th>

                <th>ESTANDAR</th>

                <th>TIPO DE ANALISIS</th>
                <th>BORRAR</th>

                
            </tr>
		
    </thead>

        <tbody>

        

        <?php foreach($pruebaController->getListaPruebas() as $prueba){
        	if 	($prueba["pa_tipoanalisis"]=="FQ") {
        		$tp="Fisicoquímico";
        	} else{
        		$tp="Microbiológico";
        	}	
?>
          <tr> 
          <?php echo "<td >".$prueba["pa_numprueba"]."</td>
  <td >".
				                  
								 $prueba["red_parametroesp"]."</div></td>
<td >".$prueba["red_estandar"]."</td>
 <td >".$tp."</td>
 <td ><a href='index.php?action=listapruebasdet&np=".$prueba["pa_numprueba"]."&admin=borrar&serv=".$pruebaController->getIds()."' onClick=\"return validar(this);\"><i class=\"fa fa-remove\"></i><a></div></td>
 ";?>
            </tr>

                 <?php } //fin foreach?>



        </tbody>

    </table>

            </div>

            <!-- /.box-body -->
  


          </div>

</section>

       

    
   <!-- /.content-wrapper -->
