
<script language="JavaScript" type="text/JavaScript">
<!--

function oCargar(action){
	
document.dform.action=action;
document.dform.submit();
}
$(document).ready(function()
{

	$("#nud").focusout(function(){
		
		if($("#nud").val().length>3)
	cargarniv();
	}
	);
	$("#cta").focusout(function(){
		cargarniv();
	}
			);
});

function cargarniv()
{

	if($("#nud").val()!=""&&$("#nud").val().length>1)
		if($("#cta").val()>=1)
		{	
	document.aform.action="index.php?action=nuevasolicitudgepp&admin=validadato";
	document.aform.submit();
		
	}
	//alert(a.value);
}



function validar1(dform){
	if(form.INSPECTOR.value==''){
		alert("Por favor, selecciona al nombre del inspector");
		dform.INSPECTOR.focus();
		dform.INSPECTOR.select();
	    return false;
	}else{
		//Si el codigo llega hasta aqu?, todo estar? bien  y realizamos el Submit
		return true;
	}
}	
//-->
</script>
   <?php 
     include 'Controllers/nuevaSolicitudController.php';
 
     $solicitudController=new NuevaSolicitudController();
     $solicitudController->vistaFormulario();
  ?>
<section class="content-header">
      <h1> NUEVA SOLICITUD CERTIFICACION DE CALIDAD DE AGUA GEPP</h1>
         <ol class="breadcrumb">
             <?php Navegacion::desplegarNavegacion();?>
             </ol>
    </section>
<section class="content container-fluid">
  
      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
                 <form role="form" action="index.php?action=nuevasolicitudgepp&admin=ingsol&nsol=<?php echo $solicitudController->getUnegocio()['CLAVEUNINEG']?>"  name="aform" method="post" enctype="multipart/form-data"  > 
                 
                <!-- Datos iniciales alta de punto de venta -->
              
                  <div class="form-group col-md-12">
                  <label>NO. SOLICITUD :</label>
                   <?php 
                   echo $solicitudController->getUnegocio()["CLAVEUNINEG"]?>
      </div>
         
                 
                  
                
       <div class="form-group col-md-6"><label> *CUENTA  :</label>
        <select class="form-control" name="cta" id="cta" required> <option value="">- - - - - - - - - - - </option><?php echo $solicitudController->getListaCuentas()?></select>       </div>
     <div class="form-group col-md-6"><label>*NUD  :</label>
    <div class="input-group">
        <input class="form-control" required name="nud" type="text" id="nud" value="<?php echo $solicitudController->getUnegocio()['NUD']?>" size="30" />
    
  <span class="input-group-btn">
    <a href="javascript:cargarniv()" class="btn btn-info btn-flat"><i class="fa fa-search"></i>BUSCAR</a>
    </span>
    </div>
     </div>
        <div class="form-group col-md-6"><label>NOMBRE DEL PUNTO DE VENTA  :</label>
        <input class="form-control" name="desuneg" required type="text" id="desuneg" value="<?php echo $solicitudController->getUnegocio()['NOMUNEG'] ?>" size="60" readonly>
        <input class="form-control" name="clauneg" type="hidden" value="<?php echo $solicitudController->getUnegocio()['CLAVEUNINEG'] ?>" />
        <input class="form-control" name="numpun" type="hidden" value="<?php echo $solicitudController->getUnegocio()['NPUN'] ?>" />
        <input class="form-control" name="idserv" type="hidden" value="5" />
       
        </div>
     
        <div class="form-group col-md-6"><label>CONTACTO :</label>
       <input class="form-control" name="conuneg"  type="text" id="conuneg" value="<?php echo $solicitudController->getUnegocio()['ICON'] ?>" size="60" readonly>        </div>
    
         <div class="form-group col-md-6"><label>TELEFONO :</label>
        <input class="form-control" name="tel"  type="text" id="tel" value="<?php echo $solicitudController->getUnegocio()['TELUNEG'] ?>" size="60" maxlength="25" readonly>        </div>
     
       <div class="form-group col-md-6"><label>TELEFONO MOVIL:</label>
        <input class="form-control" name="cel"  type="text" id="cel" value="<?php echo $solicitudController->getUnegocio()['TELCEL'] ?>" size="60" maxlength="25" readonly>        </div>
     
       <div class="form-group col-md-6"><label>CORREO ELECTRONICO :</label>
       <input class="form-control" name="email"  type="text" id="email" value="<?php echo $solicitudController->getUnegocio()['MAIL'] ?>" size="60" readonly>        </div>  
     
    
        <div class="form-group col-md-6"><label>CALLE :</label>
       <input class="form-control" name="calle"  type="text" id="calle" value="<?php echo $solicitudController->getUnegocio()['CALLEUNEG'] ?>" size="60" readonly>        </div>
    
         <div class="form-group col-md-6"><label>NUMERO EXTERIOR :</label>
        <input class="form-control" name="numext"   type="text" id="noext" value="<?php echo $solicitudController->getUnegocio()['NUMEXUNEG'] ?>" size="60" readonly>        </div>
    
         <div class="form-group col-md-6"><label>  NUMERO INTERIOR :</label>
        <input class="form-control" name="numint" type="text" id="noint" value="<?php echo $solicitudController->getUnegocio()['NUMINUNEG'] ?>" size="60" readonly>        </div>
      
        <div class="form-group col-md-6"><label>MANZANA :</label>
        <input class="form-control" name="mz" type="text" id="mz" value="<?php echo $solicitudController->getUnegocio()['MZUNEG'] ?>" size="60" readonly>        </div>
     
        <div class="form-group col-md-6"><label>LOTE :</label>
        <input class="form-control" name="lt" type="text" id="lt" value="<?php echo $solicitudController->getUnegocio()['LTUNEG'] ?>" size="60" readonly>        </div>
     
       <div class="form-group col-md-6"><label>COLONIA :</label>
        <input class="form-control" name="col" type="text" id="col" value="<?php echo $solicitudController->getUnegocio()['COLUNEG'] ?>" size="60" readonly>        </div>
     
        <div class="form-group col-md-6"><label> DELEGACION O MUNICIPIO :</label>
        <input class="form-control" name="del"  type="text" id="del" value="<?php echo $solicitudController->getUnegocio()['DELEGUNEG'] ?>" size="60" readonly>        </div>
      
        <div class="form-group col-md-6"><label> CIUDAD :</label>
        <input class="form-control" name="mun"  type="text" id="mun" value="<?php echo $solicitudController->getUnegocio()['MUNUNEG'] ?>" size="60" readonly>        </div>
     
        <div class="form-group col-md-6"><label> ESTADO :</label>
        
        <select class="form-control" name="edo" id="edo" readonly><?php echo $solicitudController->getListaestados()?></select>       </div>
     
         <div class="form-group col-md-6"><label>CP :</label>
        <input class="form-control" name="cp" type="text" id="cp" value="<?php echo $solicitudController->getUnegocio()['CPUNEG'] ?>" size="60" readonly>        </div>
     
         <div class="form-group col-md-6"><label>REFERENCIA :</label>
        <input class="form-control" name="ref" type="text" id="ref" value="<?php echo $solicitudController->getUnegocio()['REFUNEG'] ?>" size="60" readonly> 
             </div>
    
        <div class="form-group col-md-12"><button type="submit" <?=$solicitudController->btnGuardar ?>  class="btn btn-info pull-right">   Guardar </button></div>
          
     
</form>
</div>
</div>
 </div>
 </div>


<div class="row">
  <div class="col-md-12">
             <div class="box box-info">
             <div class="box-header with-line">AUTORIZACION</div>
             <div class="box-body">
<form  name="dform" action="index.php?action=nuevasolicitudgepp&admin=autsol" method="post" > 
   <input class="form-control" name="idserv" type="hidden" value="5" />
       
    
      <?php echo $solicitudController->getEnc_autor()?>
        <!-- inicioBloque: PanelbusquedaC -->
          <!-- finBloque: PanelbusquedaC -->
             
      <?php  echo $solicitudController->getAutor_ex()?>
 
</form> 
</div></div>
</div></div>  

</section>
<!-- finBloque: tnuevo -->