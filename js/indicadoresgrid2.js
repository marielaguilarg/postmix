// JavaScript Document


	
function Cargar(menu,opcion){
	
	var mes="";
	var opcionsem="";
	//alert(getRadioButtonSelectedValue(document.form1.semcumplimiento)+"jaja");
	switch(menu)//veo la opcion del menu que se elijio
	{
		case 'p':
		
		     if(getRadioButtonSelectedValue(document.form1.semcumplimiento)!="")
                opcionsem=getRadioButtonSelectedValue(document.form1.semcumplimiento);
		     mes=opcion;
		     break;
		 case 's': opcionsem=opcion;
			if(document.getElementById("mes_asignacion").value!="")
        		mes=document.getElementById("mes_asignacion").value;
			break;
		default:
		      if(document.getElementById("mes_asignacion").value!="")
        		mes=document.getElementById("mes_asignacion").value;
		
			if(getRadioButtonSelectedValue(document.form1.semcumplimiento)!="")
                opcionsem=getRadioButtonSelectedValue(document.form1.semcumplimiento);
				break;
	}
		
	var sec=document.form1.sec.value;
	var filx=document.form1.filx.value;
	var fily=document.form1.fily.value;
	var ren=document.form1.ren.value;
	var ref=document.form1.ref.value;
	var niv=document.form1.niv.value;
	var rdata="";
	var filuni=document.form1.filuni.value;
	if(document.form1.visdatos1.checked)
		rdata="1.";
	else
		rdata="0.";
	if(document.form1.visdatos2.checked)
		rdata+="1.";
	else
		rdata+="0.";
	/*if(document.form1.visdatos3.checked)*/
		rdata+="1.";
	/*else
		rdata+="0.";*/
	var per="";
	if(document.form1.checkbox[0].checked)
		per="1.";
	else
		per=".";
	if(document.form1.checkbox[1].checked)
		per+="1.";
	else
		per+=".";
	if(document.form1.checkbox[2].checked)
		per+="1.";
	else
		per+=".";
	
	
	window.location='index.php?action=indindicadoresgrid&mes='+mes+"&sec="+sec+"&filx="+filx+"&fily="+fily+"&ren="+ren+"&niv="+niv+"&rdata="+rdata+"&per="+per+"&ref="+ref+"&sem="+opcionsem+"&filuni="+filuni;
}

function CargarSem(opcion,seccion,ref){
    var mes=document.getElementById("fechainicio").value+"."+document.getElementById("fechainicio2").value;
	
	var sec=document.form1.sec.value;
	
	var filx=document.form1.filx.value;
	var fily=document.form1.fily.value;
	var ren=document.form1.ren.value;
	var niv=document.form1.niv.value;
	var filuni=document.form1.filuni.value;
	var rdata="";
	if(document.form1.visdatos1.checked)
		rdata="1.";
	else
		rdata="0.";
	if(document.form1.visdatos2.checked)
		rdata+="1.";
	else
		rdata+="0.";
	/*if(document.form1.visdatos3.checked)*/
		rdata+="1.";
	/*else
		rdata+="0.";*/
	var per="";
	if(document.form1.checkbox[0].checked)
		per="1.";
	else
		per="0.";
	if(document.form1.checkbox[1].checked)
		per+="1.";
	else
		per+="0.";
	if(document.form1.checkbox[2].checked)
		per+="1.";
	else
		per+="0.";
	window.location='index.php?action=indindicadoresgrid&mes='+mes+"&sec="+sec+"&filx="+filx+"&fily="+fily+"&ren="+ren+"&niv="+niv+"&rdata="+rdata+"&per="+per+"&ref="+ref+"&sem="+opcion+"&filuni="+filuni;
	
}

function getRadioButtonSelectedValue(ctrl)
{
	
    for(i=0;i<ctrl.length;i++)
        if(ctrl[i].checked)
		{
		return ctrl[i].value;}
	return ctrl[0].value;
}

function exportar(){
var periodo=document.getElementById("mes_asignacion").value;
var opcion=document.getElementById("seccion").value;
	 window.location='index.php?action=indindicadoresgrid&admin=exp&mes='+periodo+"&sec="+opcion;
}

function imprimir(){
	var mes="";
	var opcionsem="";
	  if(document.getElementById("mes_asignacion").value!="")
       mes=document.getElementById("mes_asignacion").value;
		
	   if(getRadioButtonSelectedValue(document.form1.semcumplimiento)!="")
       opcionsem=getRadioButtonSelectedValue(document.form1.semcumplimiento);

	var sec=document.form1.sec.value;
	var filx=document.form1.filx.value;
	var fily=document.form1.fily.value;
	var ren=document.form1.ren.value;
	var ref=document.form1.ref.value;
	var niv=document.form1.niv.value;
	var rdata="";
	if(document.form1.visdatos1.checked)
		rdata="1.";
	else
		rdata="0.";
	if(document.form1.visdatos2.checked)
		rdata+="1.";
	else
		rdata+="0.";
	/*if(document.form1.visdatos3.checked)*/
		rdata+="1.";
	/*else
		rdata+="0.";*/
	var per="";
	if(document.form1.checkbox[0].checked)
		per="1.";
	else
		per=".";
	if(document.form1.checkbox[1].checked)
		per+="1.";
	else
		per+=".";
	if(document.form1.checkbox[2].checked)
		per+="1.";
	else
		per+=".";
	
	 window.open('cue_indindicadoresxregion_expimp.php?mes='+mes+"&sec="+sec+"&filx="+filx+"&fily="+fily+"&ren="+ren+"&niv="+niv+"&rdata="+rdata+"&per="+per+"&ref="+ref+"&sem="+opcionsem);
}
/*window.onload = function() {
	
		//window.parent.Menu.location="../MEmodulos/MEPtop.php?ver=2";
	
	}
*/	
	
      
function objetoAjax()
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