 
 <script type="text/javascript">

var numero=0;

function InsertarFila(){
var elmTBODY = document.getElementById('tbl_rangos');
var elmTR;
var elmTD;
var elmText;
numero++;
	//var aux=document.getElementById('oCantidad');
	//aux.setAttribute("value", ""+numero); 
	
    elmTR = elmTBODY.insertRow(numero+1);

	
	//Numero
	  elmTD = elmTR.insertCell(0);
	  elmTD.setAttribute("class","NuevoEtiqueta");
	  elmTD.setAttribute("width","185");

	  elmTD.innerHTML="Rango "+(numero);


	  elmTD = elmTR.insertCell(1);
	   var txt3=document.createElement("input");
 	  txt3.setAttribute("name", "valinicial"+numero);
	  txt3.setAttribute("id", "valinicial"+numero);
	  txt3.setAttribute("size", "8"); 
	   txt3.setAttribute("maxlength", "10"); 
		txt3.setAttribute("class","campoTxt");
	//  txt3.value=numero;
	 elmTD.appendChild(txt3);
	
	  
	    elmTD = elmTR.insertCell(2);
	  var txt2=document.createElement("input");
 	  txt2.setAttribute("name", "valfinal"+numero);
	  txt2.setAttribute("id", "valfinal"+numero);
	  txt2.setAttribute("size", "8"); 
	   txt2.setAttribute("maxlength", "10"); 
	txt2.setAttribute("class","campoTxt");
	txt2.setAttribute("align","left");
	
	  elmTD.appendChild(txt2);
	  
	
}
function CrearTabla()
{
	
	var rens=document.getElementById('num_rangos').value;
	if(rens!=""&&!isNaN(rens))
	for (i=0;i<rens;i++)
		{
			InsertarFila();
		}
		
	
}

</script>
<?php




include 'Controllers/rangosGraficaController.php';

$rangoGController= new RangosGraficaController();

$rangoGController->vistaNuevoRango();

?>
 <section class="content-header">

<h3>
RANGOS PARA GRAFICA DE FRECUENCIAS</h3>


</section>
   <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">NUEVO PARAMETRO</h3>
            </div>
            <div class="box-body">
             <form role="form" name="form1" method="post" action="index.php?action=srangosgraffrec&secc=<?php echo $rangoGController->getSeccion() ?>&admin=insertar">
            
       
<table width="39%" border="0" align="left" id="tbl_rangos">
        
  <input type="hidden" name="componente" id="componente" value="<?php echo $rangoGController->getNumop()?>">
 
  <tr>
    <td width="245"  height="30"  class="NuevoEtiqueta">NUMERO DE RANGOS:
</td>
    <td   height="30" width="51"   class="AreaCampos"><input name="num_rangos" id="num_rangos" type="text" size="8" maxlength="5" class="campoTxt" ></td>

    <td width="93"><span class="AreaCampos">
    <button type="button" class="btn btn-info pull-right" onClick="CrearTabla();"  >ACEPTAR</button>
    </span></td>
  </tr>
  <tr>
    <td></td>
    <td width="51" class="NuevoEtiqueta" >MIN</td>
    <td width="93" class="NuevoEtiqueta" >&nbsp;&nbsp;MAX</td>
  </tr>
</table>
          <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                 <button type="button" class="btn btn-default pull-right" style="margin-left: 10px" onclick="window.location='index.php?action=srangosgraffrec&secc=<?php echo $rangoGController->getSeccion() ?>'">Cancelar</button>
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>


       