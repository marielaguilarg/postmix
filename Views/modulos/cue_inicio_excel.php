<script>
<!--
function Cargar()
{
var m1=parseInt(document.form1.fechainicio.value);
var m2=parseInt(document.form1.fechafin.value);

	if (parseInt(document.form1.fechainicio2.value)==parseInt(document.form1.fechafin2.value))	
	{//si es el mismo año verifica los meses
		//alert(m1+">="+m2);
		if (m1>m2)
		{
		alert("Verifica la fecha");
		return false;}}
		else
	if (document.form1.fechainicio2.value>document.form1.fechafin2.value)	
		{alert("Verifica la fecha");
		return false;}
		
	var ban=0;
	if(document.form1.consulta[1].checked)	
	{for(i=0;i<document.form1.cuenta.length;i++)
	{
		if(document.form1.cuenta[i].checked) //hay una seleccionada
		{
			ban=1;
		}
	
	}
	if(ban==0)
	{alert("Elige una cuenta para el reporte"); //error
			return false;
			}	
			}
	/*if((!document.form1.cuenta[1].checked) &&(!document.form1.cuenta[0].checked) &&(!document.form1.cuenta[2].checked)	)									//si no eligió una opcion de cuenta marca un 			
			{alert("Elige una cuenta para el reporte"); //error
			return false;
			}										
		
		*/
	document.form1.submit();
}
function oculta(id)
{
	if (document.getElementById)
	{ //se obtiene el id
		var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
		el.style.display = 'none'; //damos un atributo display:none que oculta el div
	}
}
function muestra(id)
{
	if (document.getElementById)
	{ //se obtiene el id
		var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
		el.style.display = ''; //damos un atributo  que muestra el div
		
	}
}
window.onload = function()
	{/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
		oculta('cuentas');/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
	}
	
function oCargar(action){
document.form1.action=action;
document.form1.submit();

}
//-->
</script>

<?php
include "Controllers/inicioExcelController.php";
$inicioController=new InicioExcelController();
$inicioController->vistaArchivoInicio();


?>

   

<!-- Main content -->
<section class="content container-fluid">
<!--  filtros -->
    <div class="box box-info">
        <div class="box-header with-border">
        
            <h3 class="box-title">REPORTE INICIO</h3>
        </div>
        <div class="box-body">
<form name="form1" id="form1" method="post" action="imprimirReporte.php?admin=Cinid" >
<input name="tipo_consulta" type="hidden" value="d"  >
<div>ESTIMADO USUARIO, PARA EXPORTAR EL ARCHIVO DEFINA EL CLIENTE : </div>
<div class="form-group">
                <label>CLIENTE: </label>
<select  name="claclien"  id="claclien" class="form-control" >
<?php 

foreach($inicioController->getListaclientes() as $cliente){

    echo '<option value="'.$cliente["cli_id"].'">'.$cliente["cli_nombre"].'</option>';
}
    ?>
	

</select></div>
 <button type="submit" class="btn btn-info btn-flat" >
 <?php echo T_("Generar")?></button>


</form>
</div></div>
</section>