 <section class="content-header">
 <!-- generar nombre de seccion -->
 <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>

<div style="margin-top:10px">
 </div>
<?php
	$ingreso = new ReporteController();
	echo $ingreso->vistaEncabezado();
	
	?>
	
    <h1 >
	<?php
	$ingreso -> vistaNombreSeccion();
	?>     

   </h1>  
	

	<?php
	if ($_GET["ts"]=="P"){
		$ingreso = new PonderacionController();
		$ingreso -> vistanivelcumplimiento();
	} else {
		if ($_GET["ts"]=="ED"){
		  $ingreso = new EstandarController();
		  $ingreso -> nivelCumplimientoEstandar();
		  
		}
	}	
	?>
     


	<ol class="breadcrumb"  >
	<?php
	$ingreso = new ReporteController();
	$ingreso -> vistaRnomservController();
	$ingreso->SeleccionaseccionLigabc();
	echo $ingreso->ligaRegresar;
	?>     
    </ol>

</section>
<script>
function ajax_print(url){
    $.ajax(url).
    done(function(data){
        var S = "#Intent;scheme=rawbt;";
        var P =  "package=ru.a402d.rawbtprinter;end;";
        window.location.href="intent:base64,"+data+S+P;
      
    });
return false;
}
function ajax_printz(url){
    $.ajax(url).
    done(function(data){
      
        window.location.href="arrowhead://x-callback-url/cpclcode?code="+data;
      
    });
return false;
}
</script>


<?php
	
 
$ingreso -> SeleccionaseccionReporteController();

?>
	


     