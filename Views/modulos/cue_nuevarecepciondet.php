
<script type="text/javascript">
var numero=0;

function InsertarFila(){
var elmTBODY = document.getElementById('tbl_producto');
var elmTR;
var elmTD;
var elmText;
numero++;
	//var aux=document.getElementById('oCantidad');
	//aux.setAttribute("value", ""+numero); 
	
    elmTR = elmTBODY.insertRow(numero);
	if(numero%2)
		elmTR.setAttribute('bgcolor','#FFFFFF');
	else
		elmTR.setAttribute('bgcolor','#f4f4f4');
	
	//Numero
	  elmTD = elmTR.insertCell(0);
	  elmTD.innerHTML=numero;


	//num cajas  
	    elmTD = elmTR.insertCell(1);
	  var txt2=document.createElement("input");
 	  txt2.setAttribute("name", "codigo"+numero);
	  txt2.setAttribute("id", "codigo"+numero);
	  txt2.setAttribute("size", "10"); 
	   txt2.setAttribute("maxlenght", "10"); 
	     txt2.setAttribute("onkeydown", "return enterxtab(event, this);"); 
	
	  elmTD.appendChild(txt2);
	  
	
	  	  
}
function CrearTabla()
{
	var rens=document.getElementById('registros').value;
	if(rens=="")
	{	alert('Favor de indicar el total de cajas');
		document.getElementById('registros').focus();
	}
	else
	{	for (i=0;i<rens;i++)
		{
			InsertarFila();
		}
		document.getElementById('guardar').disabled=false;
                document.getElementById("codigo1").focus();
	}
}


function CreaCalendario(numero)
{
 Calendar.setup(
    {
      inputField  : "feccad"+numero,         // ID of the input field
      ifFormat    : "%d/%m/%Y",    // the date format
      button      : "trigger"+numero       // ID of the button
    }
  );
}

function Validar()
{
	var rens=document.getElementById('registros').value;
	var ban=0; // avisa que todo el renglon esta lleno
	for(i=1;i<=rens;i++)
	{
		ban=0;
		campo=document.getElementById('codigo'+i);
		if(!CampoVacio(campo)) ban++;
//		campo=document.getElementById('lugarcajasno'+i);
//		if(!CampoVacio(campo)) ban++;
	
		if(ban==1&&i==1)
		{	alert('Debes capturar al menos una muestra');
			return false;}
		else
		/*	if(ban==1)
			{	alert('Datos incompletos, revisa');
				return false;
				}
			else*/
		continue;
	}
	suma=0;
	for(i=1;i<=rens;i++)
	{
		
		campo=document.getElementById('codigo'+i);
		if(campo.value!="")
		    suma++;
	//		suma+=parseInt(campo.value);
		
	}
	
	if(suma!=rens)
	if(confirm('El total de muestras capturadas no coincide con el proporcionado. Si deseas guardar da click en Aceptar'))
	
		return true;
	else return false;
				
				
		
		
		
}
function CampoVacio(campo)
{
	if(campo.value=="")
	{
		
		campo.focus();
		return false;}
	else return true;	
}


	function enterxtab(e,obj) {
  tecla = (document.all) ? e.keyCode : e.which;
 
  if (tecla==13) {
	
  frm=obj.form;
  for(i=0;i<frm.elements.length;i++) 
    if(frm.elements[i]==obj) { 
      if (i==frm.elements.length-1) i=-1;
      break; }
  frm.elements[i+1].focus();
  return false; 
 }
 return true;
}
</script>
<?php 
include "Controllers/recepcionDetalleController.php";
$nueva=new RecepcionDetalleController();
$nueva->vistaNuevo();
?>
<section class="content container-fluid">
<div class="row">
<div class="col-md-12">
    
   <div class="box box-info">
<form id="form1" name="form1" method="post" action="index.php?action=recepciondetalle&admin=insertar" onsubmit="return Validar();">
 <div class="box-header">NUEVA RECEPCION</div>
             <div class="box-body">
             <div class="form-group col-md-12">
      
   
       <label>TOTAL DE UNIDADES</label>
        <input type="hidden" name="numrecibo" id="numrecibo" maxlength="5" size="10" value="<?php echo $nueva->getNumrec()?>" />
    <input type="hidden" name="cat" id="cat" maxlength="5" size="10" value="<?php echo $nueva->getNumrec()?>" />
   
      <input type="text" name="registros" id="registros" maxlength="5" size="10" value="1" />
	  <button  name="generar" type="button"  onClick="CrearTabla();" class="btn btn-info">ACEPTAR</button>
  </div>
 
   <table width="100%" border="0" cellpadding="1" id="tbl_producto">
  <tr class="infocuadro">
  
    <td width="7%" class="subtitulo3"><div align="center">NO.</div></td>
	 <td width="18%"  class="subtitulo3"><div align="center">CODIGO</div></td>
  </tr>

</table></div>
<div class="box box-footer">
<div class="pull-right">
 <button type="submit" name="Submit" id="guardar" disabled="disabled" class="btn btn-info">GUARDAR</button>
      <button name="Submit22" type="button"  onClick="history.go(-1);" class="btn btn-default" >CANCELAR</button>
	   <button name="nuevo" type="button" onclick="window.location='index.php?action=nuevarecepciondet&nuevo=S&refer=<?php echo $nueva->getNumrec()?>';" class="btn btn-info ">NUEVO</button>
   </div>
   </div>
</form></div>

</div></div></section>