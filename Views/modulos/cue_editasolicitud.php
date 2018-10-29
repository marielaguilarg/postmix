<link href="../css/Estilosind.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--

function oCargar(action){
	
document.dform.action=action;
document.dform.submit();
}

function carganiv2(a)
{
	document.aform.action="index.php?action=editasolicitud&admin=validadato"
	document.aform.submit();
	//alert(a.value);
}

function validar(form){
	if(form.desuneg.value==''){
		alert("Por favor, escribe el Nombre del Punto de Venta");
		form.desuneg.focus();
		form.desuneg.select();
	    return false;
	}else if(form.idcta.value==''){
		alert("Por favor, escribe el ID de Cuenta");
		form.idcta.focus();
		form.idcta.select();
	    return false;
	}else if(form.calle.value==''){
		alert("Por favor, escribe la Calle");
		form.calle.focus();
		form.calle.select();
		return false;
	}else if(form.numext.value==''){
	    alert("Por favor, escribe el Numero Exterior");
		   form.numext.focus();
		   form.numext.select();
		   return false;
	} else if(form.col.value==''){
		alert("Por favor, escribe la Colonia");
		form.col.focus();
		form.col.select();
		return false;
	}else if(form.del.value==''){
		alert("Por favor, escribe la Delegación");
		form.del.focus();
		form.del.select();
		return false;
	}else if(form.mun.value==''){
		alert("Por favor, selecciona la Ciudad");
		form.mun.focus();
		form.mun.select();
		return false;
	}else if(form.nom_edo.value==''){
		alert("Por favor, selecciona el Estado");
		form.nom_edo.focus();
		form.nom_edo.select();
		return false;
	}else if(form.fecaper.value==''){
		alert("Por favor, escribe la Fecha de Apertura");
		form.fecaper.focus();
		form.fecaper.select();
		return false;
	}else if(form.conuneg.value==''){
		alert("Por favor, escribe el nombre del Contacto");
		form.conuneg.focus();
		form.conuneg.select();
		return false;
	}else if(form.tel.value==''){
		alert("Por favor, escribe el telefono");
		form.tel.focus();
		form.tel.select();
		return false;		
	}else if(form.cel.value==''){
		alert("Por favor, escribe el Numero Celular del Contacto");
		form.cel.focus();
		form.cel.select();
		return false;
	}else if(form.email.value==''){
		alert("Por favor, escribe el correo electronico del Contacto");
		form.email.focus();
		form.email.select();
		return false;		
	}else{
		//Si el codigo llega hasta aqu?, todo estar? bien  y realizamos el Submit
		return true;
	}
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
<section class="content-header">
      <h1> NUEVA SOLICITUD</h1>
      
    </section>
<section class="content container-fluid">
     <?php 
     include 'Controllers/certificacionController.php';
     $facturasController=new CertificacionController();
     $facturasController->vistaEditaSolicitud();
   echo  $facturasController->getMsg();
                    ?>
      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
                 <form role="form" action="index.php?action=editasolicitud&admin=ingsol&nsol=<?php echo $facturasController->getUnegocio()['CLAVEUNINEG']?>"  name="aform" method="post" enctype="multipart/form-data"  onsubmit="return validar(this);"> 
                 
                <!-- Datos iniciales alta de punto de venta -->
                 
                  <div class="form-group col-md-6">
                  <label>NO. SOLICITUD :</label>
                   <?php echo $facturasController->getUnegocio()['CLAVEUNINEG']?>
      </div>
     
       <div class="form-group col-md-6"><label> CUENTA  :</label>
        <select class="form-control" name="cta" id="cta" required> <option value="">- - - - - - - - - - - </option><?php echo $facturasController->getListaCuentas()?></select>       </div>
     <div class="form-group col-md-6"><label>ID CUENTA  :</label>
        <input class="form-control" required name="idcta" type="text" id="idcta" value="<?php echo $facturasController->getUnegocio()['IDC']?>" size="60" onChange="carganiv2(this)"/>
     </div>
        <div class="form-group col-md-6"><label>NOMBRE DEL PUNTO DE VENTA  :</label>
        <input class="form-control" name="desuneg" required type="text" id="desuneg" value="<?php echo $facturasController->getUnegocio()['NOMUNEG'] ?>" size="60">
        <input class="form-control" name="clauneg" type="hidden" value="<?php echo $facturasController->getUnegocio()['CLAVEUNINEG'] ?>" />
        <input class="form-control" name="numpun" type="hidden" value="<?php echo $facturasController->getUnegocio()['NPUN'] ?>" />
        </div>
     
        <div class="form-group col-md-6"><label>CONTACTO :</label>
       <input class="form-control" name="conuneg" required type="text" id="conuneg" value="<?php echo $facturasController->getUnegocio()['ICON'] ?>" size="60">        </div>
    
         <div class="form-group col-md-6"><label>TELEFONO :</label>
        <input class="form-control" name="tel" required type="text" id="tel" value="<?php echo $facturasController->getUnegocio()['TELUNEG'] ?>" size="60" maxlength="25">        </div>
     
       <div class="form-group col-md-6"><label>TELEFONO MOVIL:</label>
        <input class="form-control" name="cel" required type="text" id="cel" value="<?php echo $facturasController->getUnegocio()['TELCEL'] ?>" size="60" maxlength="25">        </div>
     
       <div class="form-group col-md-6"><label>CORREO ELECTRONICO :</label>
       <input class="form-control" name="email" required type="text" id="email" value="<?php echo $facturasController->getUnegocio()['MAIL'] ?>" size="60">        </div>  
     
    
        <div class="form-group col-md-6"><label>CALLE :</label>
       <input class="form-control" name="calle" required type="text" id="calle" value="<?php echo $facturasController->getUnegocio()['CALLEUNEG'] ?>" size="60">        </div>
    
         <div class="form-group col-md-6"><label>NUMERO EXTERIOR :</label>
        <input class="form-control" name="numext"  required type="text" id="noext" value="<?php echo $facturasController->getUnegocio()['NUMEXUNEG'] ?>" size="60">        </div>
    
         <div class="form-group col-md-6"><label>  NUMERO INTERIOR :</label>
        <input class="form-control" name="numint" type="text" id="noint" value="<?php echo $facturasController->getUnegocio()['NUMINUNEG'] ?>" size="60">        </div>
      
        <div class="form-group col-md-6"><label>MANZANA :</label>
        <input class="form-control" name="mz" type="text" id="mz" value="<?php echo $facturasController->getUnegocio()['MZUNEG'] ?>" size="60">        </div>
     
        <div class="form-group col-md-6"><label>LOTE :</label>
        <input class="form-control" name="lt" type="text" id="lt" value="<?php echo $facturasController->getUnegocio()['LTUNEG'] ?>" size="60">        </div>
     
       <div class="form-group col-md-6"><label>COLONIA :</label>
        <input class="form-control" name="col" type="text" id="col" value="<?php echo $facturasController->getUnegocio()['COLUNEG'] ?>" size="60">        </div>
     
        <div class="form-group col-md-6"><label> DELEGACION O MUNICIPIO :</label>
        <input class="form-control" name="del" required type="text" id="del" value="<?php echo $facturasController->getUnegocio()['DELEGUNEG'] ?>" size="60">        </div>
      
        <div class="form-group col-md-6"><label> CIUDAD :</label>
        <input class="form-control" name="mun" required type="text" id="mun" value="<?php echo $facturasController->getUnegocio()['MUNUNEG'] ?>" size="60">        </div>
     
        <div class="form-group col-md-6"><label> ESTADO :</label>
        
        <select class="form-control" name="edo" id="edo" required> <option value="">- - - - - - - - - - - </option><?php echo $facturasController->getListaEstados()?></select>       </div>
     
         <div class="form-group col-md-6"><label>CP :</label>
        <input class="form-control" name="cp" type="text" id="cp" value="<?php echo $facturasController->getUnegocio()['CPUNEG'] ?>" size="60">        </div>
     
         <div class="form-group col-md-6"><label>REFERENCIA :</label>
        <input class="form-control" name="ref" type="text" id="ref" value="<?php echo $facturasController->getUnegocio()['REFUNEG'] ?>" size="60"> 
             </div>
    
        <div class="form-group col-md-6"><button type="submit" class="btn btn-info pull-right">   Guardar </button></div>
          
     
</form>
</div>
</div>
 </div>
 </div>
 <div class="row">
   <div class="col-md-12">
             <div class="box box-info">
             <div class="box-header with-border">ARCHIVOS</div>
             <div class="box-body">
<?php echo $facturasController->getSubtitulo();
?>
<?php 
     foreach($facturasController->getListaSolDet() as $detalle){
        echo $detalle["id_arc_exist"];
  
       echo $detalle["arc_exist"];
          
      }
     ?>
  
</div>
</div>
</div>
</div>
<div class="row">
  <div class="col-md-12">
             <div class="box box-info">
             <div class="box-header with-border">COMENTARIOS</div>
             <div class="box-body"> 
<form  name="cform" action="index.php?action=editasolicitud&admin=ingcom" method="post" enctype="multipart/form-data"> 

       <?php 
       echo $facturasController->getEnc_comen();
       ?>
      
       <?php 
        foreach ($facturasController->getListaComentarios() as $comentario){
         echo $comentario['fec'];        
        
         echo $comentario['hor'];       
       
          echo $comentario['user'];
        
         echo $comentario['comen'];       

        }?>
 
 </form>
</div></div>
</div>
</div>
<div class="row">
  <div class="col-md-12">
             <div class="box box-info">
             <div class="box-header with-line">AUTORIZACION</div>
             <div class="box-body">
<form  name="dform" action="index.php?action=editasolicitud&admin=autsol" method="post" > 
      <?php echo $facturasController->getEnc_autor()?>
        <!-- inicioBloque: PanelbusquedaC -->
          <!-- finBloque: PanelbusquedaC -->
             
      <?php  echo $facturasController->getAutor_ex()?>
 
</form> 
</div></div>
</div></div>  

</section>
<!-- finBloque: tnuevo -->