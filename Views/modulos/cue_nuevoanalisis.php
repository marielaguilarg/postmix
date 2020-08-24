<script language="JavaScript" type="text/JavaScript">
function validarSiNumero(numero){
    if (!/^([0-9.])*$/.test(numero))
	 return true;
	 else return false;
	alert("El valor " + numero + " no es un número");
  }

function validar(){
	var frm = document.getElementById("form1");
	band=0;
	vn=0;
	var largo
    vcero=0; 
//valido para coliformes

	if($("#itipoana").val()=="MB")
	{
	
		val2=$("input[name='desc18']").val();
		val1=$("input[name='desc17']").val();
		
		if(($("input[name='desc18']").val().length>0&&val2>0)&&(val1.length>0&&val1==0))
		{	alert("SI EL RESULTADO DE E COLI ES DIFERENTE DE 0\nEL RESULTADO DE COLIFORMES TOTALES NO PUEDE SER 0,\nFAVOR DE VERFICAR");
		return false;
		}
				
	
	}
	for (i=0;i<frm.elements.length;i++)
	{
		
	
	    if (frm.elements[i].type=="text"&&frm.elements[i].name!="itipoana") {    
		  largo = frm.elements[i].value.length
	        if(largo==0) {   //campo nulo
			   band++;
			} 
			
			if (validarSiNumero(frm.elements[i].value) == true)   {	
				  vn++;  
			} 
			
			 if (frm.elements[i].value==0) {
			      vcero++;	  
			}
		}		  
	}

	if (vn>0) {
	    alert ("Existen caracteres especiales, el sistema solo acepta valores numéricos, favor de corregir.")
	    return false;  
	} else if (band>0) {
	        if (confirm("Un campo vacío significa que no se realizó la prueba y por lo tanto no hay resultado que capturar. ¿Desea continuar?")) {
		        if (vcero>0) {
				  if (confirm ("Cero significa que se realizó la prueba y ese fue su resultado. ¿Desea continuar? ")) {
				      return true;
		          } else {
				      return false;
				  }  // CONFIRMACION DE CERO
				} // SI HAY CERO
			} else {
				   return false;
		    } // CONFIRMACION DE VACIO	
	} else if (vcero>0) {
	   if (confirm ("Cero significa que se realizó la prueba y ese fue su resultado. ¿Desea continuar?")) {
		   return true;
	   } else {
		   return false;
	   }  // CONFIRMACION DE CERO	
	} // SI HAY VACIO			   
}

//-->

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
             <input type="hidden" id="itipoana" name="itipoana" value="<?= filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_STRING)?>">
               <input type="hidden" id="idserv" name="idserv" value="<?= filter_input(INPUT_GET, "sv", FILTER_SANITIZE_STRING)?>">
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

  <div class="pull-right">   
                  <button type="submit" class="btn btn-info">Guardar</button>
                  <a class="btn btn-default" style="margin-left: 10px" href="index.php?action=analisisFQ&tipo=<?php echo $tipo.'&ntoma='.$analisisController->getNmues()?>"> Cancelar </a> 
 </div></div>

</section>

       

    
   <!-- /.content-wrapper -->
