/** Ajax para consultaResultados**/

//Cambia franquicia y u. de negocio
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
listadoSelectsCuenta[1]="franquiciacta";
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
	if(dato=="mercado")
		return -1;
	return null;
}

function cargaContenidoCuenta(idSelectOrigen,cliente,servicio)
{
	
	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArrayCuenta(listadoSelectsCuenta, idSelectOrigen)+1;
       // alert("+++00"+posicionSelectDestino);
	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
      
         var nivel=document.getElementById("varnivel2").value;
    var lisNiveles=new Array();
    lisNiveles[0]="clanivel1";
lisNiveles[1]="clanivel2";
lisNiveles[2]="clanivel3";
lisNiveles[3]="clanivel4";
lisNiveles[4]="clanivel5";
lisNiveles[5]="clanivel6";
var refnivel="";
for(i=0;i<6;i++){
//alert(i+"--"+lisNiveles[i]);
campo=eval("document.form1."+lisNiveles[i]);

   refnivel=refnivel+"."+campo.value;
}
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelectsCuenta[x])
		{
			selectActual=document.getElementById(listadoSelectsCuenta[x]);
			selectActual.length=0;
			
			var nuevaOpcion=document.createElement("option");
			nuevaOpcion.value=0;
			nuevaOpcion.innerHTML="- TODOS -";
			selectActual.appendChild(nuevaOpcion);
			selectActual.disabled=true;
			x++;
		}
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelectsCuenta[listadoSelectsCuenta.length-1])
	{
		// Obtengo el elemento del select que debo cargar
		var idSelectDestino=listadoSelectsCuenta[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		
                 if(posicionSelectDestino>1)    // envio cta y franquicia
                  {
                    idSelectOrigen=listadoSelectsCuenta[posicionSelectDestino-2];
                    selectOrigen=document.getElementById(idSelectOrigen);
                      if(selectOrigen.type=='hidden')
                        opcionSeleccionada2=selectOrigen.value;
                    else
                   opcionSeleccionada2=selectOrigen.options[selectOrigen.selectedIndex].value;
                      opcionSeleccionada=opcionSeleccionada2+"."+opcionSeleccionada;

                  }
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=CuentaAjax();
		ajax.open("GET", "indcomboboxcuenta.php?selectcuenta="+idSelectDestino+"&opcioncuenta="+opcionSeleccionada+"&niv="+refnivel+"&varn="+nivel, true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				 for(x=posicionSelectDestino+1;x<listadoSelectsCuenta.length;x++)
                                {
                                    selectActual=document.getElementById(listadoSelectsCuenta[x]);
                                    selectActual.length=0;

                                    var nuevaOpcion=document.createElement("option");
                                    nuevaOpcion.value=0;
                                    nuevaOpcion.innerHTML="- TODOS -";
                                    selectActual.appendChild(nuevaOpcion);
                                    selectActual.disabled=true;

                                }
                                selectDestino.length=0;
				var nuevaOpcion=document.createElement("option");
				nuevaOpcion.value=0;
				nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion);selectDestino.disabled=true;	
			}
			if (ajax.readyState==4)
			{

				selectDestino.parentNode.innerHTML=ajax.responseText;
			} 
		}
		ajax.send(null);
	}
	if(idSelectOrigen=='mercado') //modifico tambien los pv
	{
		// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
		var posicionSelectDestino2=buscarEnArrayCuenta(listadoSelectsCuenta, idSelectOrigen)+2;
		// Obtengo el select que el usuario modifico
		var selectOrigen2=document.getElementById(idSelectOrigen);
		// Obtengo la opcion que el usuario selecciono
		var opcionSeleccionada2=selectOrigen2.options[selectOrigen2.selectedIndex].value;
		// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
		if(opcionSeleccionada2==0)
		{
			var x=posicionSelectDestino2, selectActual=null;
			// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
			while(listadoSelectsCuenta[x])
			{
				selectActual=document.getElementById(listadoSelectsCuenta[x]);
				selectActual.length=0;
				
				var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="- Todas -";
				selectActual.appendChild(nuevaOpcion);selectActual.disabled=true;
				x++;
			}
		}
		// Compruebo que el select modificado no sea el ultimo de la cadena
		else if(idSelectOrigen!=listadoSelectsCuenta[listadoSelectsCuenta.length-1])
		{
			// Obtengo el elemento del select que debo cargar
			var idSelectDestino2=listadoSelectsCuenta[posicionSelectDestino2];
			var xxx=1;
			
			var selectDestino2=document.getElementById(idSelectDestino2);
			// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
			var ajax2=CuentaAjax();
			ajax2.open("GET", "indcomboboxcuenta.php?selectcuenta="+idSelectDestino2+"&opcioncuenta="+opcionSeleccionada+"&mer=1"+"&niv="+refnivel+"&varn="+nivel, true);
			ajax2.onreadystatechange=function() 
			{ 
				if (ajax2.readyState==1)
				{
					// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
                                         for(x=posicionSelectDestino+1;x<listadoSelectsCuenta.length;x++)
                                {
                                    selectActual=document.getElementById(listadoSelectsCuenta[x]);
                                    selectActual.length=0;

                                    var nuevaOpcion=document.createElement("option");
                                    nuevaOpcion.value=0;
                                    nuevaOpcion.innerHTML="- TODOS -";
                                    selectActual.appendChild(nuevaOpcion);
                                    selectActual.disabled=true;

                                }
					selectDestino2.length=0;
					var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="Cargando...";
					selectDestino.appendChild(nuevaOpcion);selectDestino.disabled=true;	
				}
				if (ajax2.readyState==4)
				{
					
					selectDestino2.parentNode.innerHTML=ajax2.responseText;
				} 
			}
			ajax2.send(null);
		}	
	}
	
}