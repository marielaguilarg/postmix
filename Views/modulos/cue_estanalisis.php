<!-- inicioBloque: Panel -->

<script language="JavaScript" type="text/JavaScript">
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

	
function oCargar(action){
document.form1.action=action;
document.form1.submit();

}
//-->
</script>
<section class="content-header">
     <h1 class="box-title">EXTRAER ARCHIVO DE AGUA</h1>
  
</section>
<section class="content container-fluid">
 

<form name="form1" id="form1" method="post" action="imprimirReporte.php?admin=Tarcr" >
<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">ESTIMADO USUARIO, PARA EXPORTAR EL ARCHIVO DEFINA EL PERIODO:</h3>
        </div>
        <div class="box-body">

          <input name="NomUsuario" type="hidden" id="NomUsuario" value="{USUARIO}" />
       
	
 <div class="row">
            
              <div class="col-sm-3">&nbsp;</div>
            <div class="col-sm-2">    <label>INDICE DE : </label></div>  <div class="col-sm-2">
  <select  name="fechainicio"  id="fechainicio" class="form-control">
	<option value="1">Enero</option>
      <option value="2">Febrero</option>
      <option value="3">Marzo</option>
      <option value="4">Abril</option>
	   <option value="5">Mayo</option>
	    <option value="6">Junio</option>
		 <option value="7">Julio</option>
		  <option value="8">Agosto</option>
		   <option value="9">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option> 
	   <option value="12">Diciembre</option>       
	</select></div>
	 <div class="col-sm-2">
	 <select name="fechainicio2" class="form-control">
     <option value="2011">2011</option>
      <option value="2012">2012</option>
         <option value="2013">2013</option>
         <option value="2014">2014</option>
         <option value="2015">2015</option>
		 <option value="2016">2016</option>
		 <option value="2017">2017</option>
         <option value="2018">2018</option>
         <option value="2019">2019</option>
         <option value="2020">2020</option>
         <option value="2021">2021</option>
         <option value="2022">2022</option>
         <option value="2023">2023</option>
         <option value="2024">2024</option>
         <option value="2025">2025</option>
       </select>
       </div>
        <div class="col-sm-3">&nbsp;</div>
       </div>
       
         <div class="row">
             <div class="col-sm-3">&nbsp;</div>
              <div class="col-sm-2">
              
          
<label>AL INDICE DE :</label></div><div class="col-sm-2">
    <select   id="fechafin" name="fechafin" class="form-control" >
        <option value="1">Enero</option>
      <option value="2">Febrero</option>
      <option value="3">Marzo</option>
      <option value="4">Abril</option>
	   <option value="5">Mayo</option>
	    <option value="6">Junio</option>
		 <option value="7">Julio</option>
		  <option value="8">Agosto</option>
		   <option value="9">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option> 
	   <option value="12">Diciembre</option>        
	</select></div><div class="col-sm-2">
       <select name="fechafin2" class="form-control">
       <option value="2011">2011</option>
      <option value="2012">2012</option>
         <option value="2013">2013</option>
         <option value="2014">2014</option>
         <option value="2015">2015</option>
		  <option value="2016">2016</option>
		 <option value="2017">2017</option>
         <option value="2018">2018</option>
         <option value="2019">2019</option>
         <option value="2020">2020</option>
         <option value="2021">2021</option>
         <option value="2022">2022</option>	
         <option value="2023">2023</option>
         <option value="2024">2024</option>
         <option value="2025">2025</option> 
       </select></div>
       <div class="col-sm-3">&nbsp;</div>
      </div>
      </div>
   
      <div class="box-footer">
      
        <span class="input-group-btn">
    <button type="submit" class="btn btn-info btn-flat pull-right">GENERAR</button>
    </span>   </div>
    </div>

</form>

</section>
<!-- finBloque: Panel -->