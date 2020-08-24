      <script type="text/javascript" >
function dialogoEliminar(){
	if(confirm("¿ESTA SEGURO QUE DESEA ELIMINAR?"))
		return true;
	else return false;
}
 </script>
    <section class="content-header">
      <h1>SECCIONES <small></small></h1>
<ol class="breadcrumb" >

<?php
$ingreso = new seccionController();
$ingreso -> vistaNomServicioController();
?>        
        
</ol>
 </section>     

      <div class="row">
    <div class="col-md-12" >
     
       

<?php

$ingreso = new seccionController();
$ingreso -> borrarSeccionController();
$ingreso -> vistaseccionController();

?>



       

    </section>
    
   <!-- /.content-wrapper -->