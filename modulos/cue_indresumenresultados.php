
<style >
    .los_demas {
    display: none;
}
</style>
<script language="JavaScript" type="text/JavaScript"> 

 function MostrarFilas(Fila,objeto) {
var elementos = document.getElementsByName(Fila);
    for (i = 0; i< elementos.length; i++) {
        if(navigator.appName.indexOf("Microsoft") > -1){
               var visible = 'block'
        } else {
               var visible = 'table-row';
        }
		if(elementos[i].style.display=='none'||elementos[i].style.display=='')
			{elementos[i].style.display = visible;
			//document.getElementById(objeto).innerHTML="minimizar lista";
			document.getElementById(objeto).innerHTML="minimizar";
			}
			else
			{	elementos[i].style.display='none';
				document.getElementById(objeto).innerHTML="desplegar";
			}
        }
	//alert(objeto);
	
	//	objeto.parent.innerHTML="otra cosa";
}

	


</script>


<section class="content container-fluid">
<form id="form1" name="form1" method="post" action="">
  <input name="fechainicio" type="hidden" id="fechainicio" value="<?php echo $resumenRes->getFiltros_indi()->getMes_indice(); ?>"  >
 <input type='hidden' name='select3' value="1">
 <input type='hidden' name='select4' value='<?php echo $resumenRes->getNivel04(); ?>'>
 <input type='hidden' name='select5' value="<?php echo $resumenRes->getNivel05(); ?>">
 <input type='hidden' name='select6' value="<?php echo $resumenRes->getNivel06(); ?>">
 </form>
  
            

   
  
	
	 <?php echo $resumenRes->getLb_Promedio_resultados() ;?>

<!--<tr height="15px"><td bgcolor="#FFFFFF">RESUMEN DE RESULTADOS</td></tr>-->
<!-- inicioBloque: listasec -->
 
	 <?php foreach($resumenRes->getLista_tablas() as $tabla){
             echo 
            ' <div class="row">
             <div class="col-xs-12">
             <div class="box">'.
             $tabla.
            ' </div></div></div>';
         }?>

	<!-- finBloque: listasec -->
	
	


</section>
 
