
//se utiliza para los filtros avanzados de la consulta de resultados
function nuevoAjax()
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
var listadoSelectsC=new Array();
listadoSelectsC[0]="crcliente";
listadoSelectsC[1]="crservicio";
listadoSelectsC[2]="cuenta";



function buscarEnArray(array, dato)
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

function cargaContenidoCliente(idSelectOrigen)
{
    // Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
    var posicionSelectDestino=buscarEnArray(listadoSelectsC, idSelectOrigen)+1;
    // Obtengo el select que el usuario modifico
    var selectOrigen=document.getElementById(idSelectOrigen);
    // Obtengo la opcion que el usuario selecciono
    var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
    // Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
    if(opcionSeleccionada==0)
    {
        var x=posicionSelectDestino, selectActual=null;
        // Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
        while(listadoSelectsC[x])
        {
            selectActual=document.getElementById(listadoSelectsC[x]);
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
    else if(idSelectOrigen!=listadoSelectsC[listadoSelectsC.length-1])
    {
        // Obtengo el elemento del select que debo cargar
        var idSelectDestino=listadoSelectsC[posicionSelectDestino];
        var selectDestino=document.getElementById(idSelectDestino);
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
        var ajax=nuevoAjax();
        var opciona="";
        var opciona2="";
        //concateno todas las opciones
      
        for(i=0;i<posicionSelectDestino;i++)
                {

                var selectant=listadoSelectsC[i];
                selectant=document.getElementById(selectant);
              
                  
                  
                 opciona2=selectant.options[selectant.selectedIndex].value;
                opciona=opciona+'.'+opciona2;

                }
             
              
        switch(idSelectDestino)
        {
          
            case 'crservicio':
               
                ajax.open("GET", "MESlistalig_cliente.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
                break;
         
            case 'cuenta':
              
                ajax.open("GET", "MESlistalig_cliente.php?select="+idSelectDestino+"&opcion="+opciona, true);
                break;
          


        }
     //   ajax.open("GET", "MENconsultacombobox.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
        ajax.onreadystatechange=function()
        {
            if (ajax.readyState==1)
            {
                // Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."

                //regresa los demas a 0
                x=0;
                 for(x=posicionSelectDestino+1;x<listadoSelectsC.length;x++)
                {
                    selectActual=document.getElementById(listadoSelectsC[x]);
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
                selectDestino.appendChild(nuevaOpcion);
                selectDestino.disabled=true;

            }
            if (ajax.readyState==4)
            {

                selectDestino.parentNode.innerHTML=ajax.responseText;
            }
        }
        ajax.send(null);
    }
}
