
<?php 
include "Controllers/pruebaController.php";
$pruebaController=new PruebaController();
$tipo=filter_input(INPUT_GET, "tipo",FILTER_SANITIZE_STRING);


if($tipo=="E")
{$pruebaController->vistaEditaPrueba();
$accion="actualizar";
$titulo="EDITAR";
}
else {
	$pruebaController->vistaNuevaPrueba();
$titulo="NUEVA";
$accion="insertar";}
?>
 <section class="content-header">
  <div class="row" style="margin-top:-40px;" >

   <h1 style="font-size:25px; margin-left: 15px; ">
PRUEBAS PARA EL ANALISIS DE AGUA <br><small><?php echo $pruebaController->getTITULO5()?></small></h1>  


</div>
 
 </section>     

    <section class="content container-fluid">
<div class="row">
<div class="col-md-12">
    
   <div class="box box-info">
     <form name="form1" method="post" action="index.php?action=listapruebasdet&id=<?php echo $_SESSION['catalogo']."&serv=".$pruebaController->getIds()."&admin=".$accion ?>" onSubmit="return validar(this);">
             
   <div class="box-header"><?php echo $titulo ?> PRUEBA</div>
             <div class="box-body">
                 <!-- Datos iniciales alta de punto de venta -->
                <div class="form-group col-md-12">
      
      <label>REACTIVO : </label>
           <input type="hidden" name="numcomp" id="numcomp" value=<?php echo $pruebaController->getNcomp()?>>
       <input type="hidden" name="idserv" id="idserv" value=<?php echo $pruebaController->getIds()?>>
    
      <?php echo $pruebaController->getDatocardet1()?>
    
     </div>
     <div class="form-group col-md-12">
      <label>TIPO DE ANALISIS:</label>
    
      <?php echo $pruebaController->getDatocardet()?>
      </div>
   
  </div>
  <div class="box-footer col-md-12">
       <A  class="btn btn-default pull-right" style="margin-left: 10px" href="index.php?action=listapruebasdet&serv=<?php echo $pruebaController->getIds()?>"> Cancelar </a>
                
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              
</form></div>
</div></div>
</section>