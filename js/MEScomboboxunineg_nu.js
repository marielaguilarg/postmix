
function CuentaAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

// Declaro los selects que componen el documento HTML. Su atributo ID debe figurar aqui.
var listadoSelectsCuenta=new Array();
listadoSelectsCuenta[0]="cuenta";
listadoSelectsCuenta[1]="franqcuenta";
listadoSelectsCuenta[2]="unidadnegocio";


function buscarEnArrayCuenta(array, dato)
{
	// Retorna el indice de la posicion donde se encuentra el elemento en el array o null si no se encuentra
	var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}

function cargaContenidoCuenta(idSelectOrigen, idSelect1, idSelect2)
{
	
	
	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArrayCuenta(listadoSelectsCuenta, idSelectOrigen)+1;
	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
	
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelectsCuenta[x])
		{
			selectActual=document.getElementById(listadoSelectsCuenta[x]);
			selectActual.length=0;
			
			var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="- Todas -";
			selectActual.appendChild(nuevaOpcion);	selectActual.disabled=true;
			x++;
		}
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelectsCuenta[listadoSelectsCuenta.length-1])
	{
		// Obtengo el elemento del select que debo cargar
		var idSelectDestino=listadoSelectsCuenta[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=CuentaAjax();
                var selectCliente=document.getElementById(idSelect1).value;
                
                 if(posicionSelectDestino>1)    // envio cta y franquicia
                  {
                    idSelectOrigen=listadoSelectsCuenta[posicionSelectDestino-2];
                    selectOrigen=document.getElementById(idSelectOrigen);
                   opcionSeleccionada2=selectOrigen.options[selectOrigen.selectedIndex].value;
                      opcionSeleccionada=opcionSeleccionada2+"."+opcionSeleccionada;

                  }
		ajax.open("GET", "indcomboboxcuenta_us.php?fec="+new Date()+"&selectcuenta="+idSelectDestino+"&opcioncuenta="+opcionSeleccionada+"&mer=1&scli="+selectCliente, true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;	
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
			} 
		}
		ajax.send(null);
	}
	
	
}