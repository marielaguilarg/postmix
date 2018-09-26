
<script type="text/javascript">
var numero=0;

function InsertarFila(){
var elmTBODY = document.getElementById("tbl_producto");
var elmTR;
var elmTD;
var elmText;
numero++;
	//var aux=document.getElementById("oCantidad");
	//aux.setAttribute("value", ""+numero); 
	
    elmTR = elmTBODY.insertRow(numero);
	if(numero%2)
		elmTR.setAttribute("bgcolor","#FFFFFF");
	else
		elmTR.setAttribute("bgcolor","#EDF8B8");
	
	//Numero
	  elmTD = elmTR.insertCell(0);
	  var txtnum=document.createElement("input");
 	  txtnum.setAttribute("name", "txtnum"+numero);
	  // txtnum.setAttribute("class", "CampoC");
	  txtnum.setAttribute("id", "txtnum"+numero);
	  txtnum.setAttribute("type", "text");  
	  txtnum.setAttribute("size", "5"); 
	    txtnum.setAttribute("readonly", "true");
 	  txtnum.setAttribute("value", ""+numero); 
	  //txtnum.setAttribute("disabled", "disabled"); 
	  elmTD.appendChild(txtnum);

	  elmTD = elmTR.insertCell(1);
	    var txt3=document.createElement("input");
 	  txt3.setAttribute("name", "feccad"+numero);
	  txt3.setAttribute("id", "feccad"+numero);
	  txt3.setAttribute("size", "10"); 
	   txt3.setAttribute("maxlenght", "10"); 
	  var btn=document.createElement("button");// <button id="trigger1">...</button>
	  btn.setAttribute("id","trigger"+numero);
	  btn.setAttribute("type","button");
	   btn.innerHTML="...";
//	btn.setAttribute("value","...");
	  
	 elmTD.appendChild(txt3);
	 elmTD.appendChild(btn);
	  CreaCalendario(numero);
	//num cajas  
	    elmTD = elmTR.insertCell(2);
	  var txt2=document.createElement("input");
 	  txt2.setAttribute("name", "lugarcajasno"+numero);
	  txt2.setAttribute("id", "lugarcajasno"+numero);
	  txt2.setAttribute("size", "10"); 
	   txt2.setAttribute("maxlenght", "10"); 
	
	  elmTD.appendChild(txt2);
	  
	  //etiqueta
	
	 elmTD = elmTR.insertCell(3);
	 var est=document.createElement("select");
 	  est.setAttribute("name", "estatus"+numero);
	  est.setAttribute("id", "estatus"+numero);
	 est.options[0] = new Option("Instalado","I");
	 est.options[1] = new Option("Almacenado","A");
          elmTD.appendChild(est);
	  //fecha
	  elmTD = elmTR.insertCell(4);
	  var chk=document.createElement("input");
 	  chk.setAttribute("name", "sinetiq"+numero);
	  chk.setAttribute("id", "sinetiq"+numero);
	  chk.setAttribute("type", "checkbox");
	
	  elmTD.appendChild(chk);
	 
	  	  
}
function CrearTabla()
{
	alert("entre a CrearTabla");
	var rens=document.getElementById("registros").value;
	if(rens=="")
	{	alert("Favor de indicar el total de cajas");
		document.getElementById("registros").focus();
	}
	else
	{	for (i=0;i<rens;i++)
		{
			InsertarFila();
		}
		document.getElementById("guardar").disabled=false;
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
	var rens=document.getElementById("registros").value;
	var ban=0; // avisa que todo el renglon esta lleno
	for(i=1;i<=rens;i++)
	{
		ban=0;
		campo=document.getElementById("feccad"+i);
		if(!CampoVacio(campo)) ban++;
		campo=document.getElementById("lugarcajasno"+i);
		if(!CampoVacio(campo)) ban++;
	
		if(ban==2&&i==1)
		{	alert("Debes capturar al menos una caja");
			return false;}
		else
			if(ban==1)
			{	alert("Datos incompletos, revisa");
				return false;
				}
			else
		continue;
	}
	suma=0;
	for(i=1;i<=rens;i++)
	{
		
		campo=document.getElementById("lugarcajasno"+i);
		if(campo.value!="")
			suma+=parseInt(campo.value);
		alert(suma);
	}
	
	if(suma!=rens)
	if(confirm("El total de cajas capturadas no coincide con el proporcionado. Si deseas guardar da click en Aceptar"))
	
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

</script>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> ALTA DE PRODUCTO <small></small></h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       <div class="row">
		<div class="col-md-12">
        <div class="box box-info">
            
            <div class="box-body">
  <form role="form"  method="post">          
              <div class="form-group">
               <div class="form-group col-md-12">
                <label for="Sistemano" class="col-sm-2 control-label">Sistema No.</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="numsistema" placeholder="">
                </div>
				  </div>
              <div class="form-group col-md-12">
                <label for="Producto" class="col-sm-2 control-label">Producto</label>
                <div class="col-sm-10">
                    
				<select class="form-control" name="numcatalogo">
					  <option value="">--- Elija el catalogo ---</option>';
				 
  				<?php
					$respuestac = DatosCatalogoDetalle::listaCatalogoDetalle(2, "ca_catalogosdetalle");
					foreach($respuestac as $row => $itemc){
					echo '<option value='.$itemc["cad_idopcion"].'>'.$itemc["cad_descripcionesp"].'</option>';
					}

					?>
				</select>
				  </div>
				 </div> 
              <div class="form-group col-md-12">
                <label for="TotalDeCajas" class="col-sm-2 control-label">Total de cajas</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="totcajas" placeholder="">
                </div>
				  </div>

				  <div class="row">
		<div class="col-md-12" >
		<input name="generar" type="button" value="GENERAR" onClick="CrearTabla();">
		 </div>
		 </div>

        </div>
              </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
			</div>
        </div>
	  <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
