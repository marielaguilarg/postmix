
<?php 
include "Controllers/recepcionController.php";
$recepcionController=new RecepcionController();
$tipo=filter_input(INPUT_GET, "nuevo",FILTER_SANITIZE_STRING);


if($tipo=="E")
{$recepcionController->vistaEdita();
$accion="actualizar";
$titulo="EDITAR";
}
else {
	$recepcionController->vistaNuevo();
$titulo="NUEVA";
$accion="insertar";}
?>
      

    <section class="content container-fluid">
<div class="row">
<div class="col-md-12">
    
   <div class="box box-info">
     <form name="form1" method="post" action="index.php?action=listarecepcion&admin=<?php echo $accion ?>" onSubmit="return validar(this);">
             
   <div class="box-header"><?php echo $titulo ?> RECEPCION</div>
             <div class="box-body">
                 <!-- Datos iniciales alta de punto de venta -->
                <div class="form-group col-md-12">
      
   
       <label>ENTREGA</label> 
       <input type="hidden" name="numrecep" id="numrecep" value=<?php echo $recepcionController->getNorec()?>>
     <input name="entmues" type="text" id="entmues" class="form-control" required value="<?php echo $recepcionController->getEntregomues()?>">
    </div>
   <div class="form-group col-md-12">
       <label>LABORATORIO</label> 

	  <!-- inicioBloque: tBusqueda -->
	  <?php 
	   echo $recepcionController->getDatocardet()?>
	  <!-- finBloque: tBusqueda -->
   </div>
     <div class="form-group col-md-12">
       <label>RECIBE</label> 
      
     <input name="recmues" type="text" id="recmues" class="form-control" required value="<?php echo $recepcionController->getRecepcion()?>">
    </div>
    
  </div>
  <div class="box-footer col-md-12">
       <a  class="btn btn-default pull-right" style="margin-left: 10px" type="button" href="index.php?action=listarecepcion" > Cancelar </a>
                
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              
</form></div>
</div></div>
</section>