 <script type="text/javascript" src="js/MEScomboboxunineg_nu.js"></script>
<script type="text/javascript" language="javascript1.1">
function Validar(form){

	

	if(form.grupo.value=='cli' || form.grupo.value == 'muf')
	 {	
	    if(!selectVacio(form.uscliente,'cliente'))return false;
	  	
	 
	  if(form.SelectNivel.value==0)
		 {	alert('Por favor, seleccione un nivel de consulta');
		 	form.SelectNivel.focus();
			return false;
		}
	}
	if(form.grupo.value=='cue')
	 {	
	   if(!selectVacio(form.uscliente,'cliente'))return false;
	  	if(!selectVacio(form.usservicio,'servicio'))return false;
	  if(!selectVacio(form.cta,'cuenta'))
		 {	
			return false;
		}
	}
	return true;
	

}
function selectVacio(campo, nombre)
{
	
	 if(campo.value=='0'){
		alert("Por favor, seleccione "+nombre);
		campo.focus();
		
		return false;
		}
		return true;
}

function cargaNivel(nvel,accion)
{
	if(accion=="EDITAR")
	 
	document.form1.action="index.php?action=snuevousuario&nuevo=E&nvel="+nvel.value;
	else
		document.form1.action="index.php?action=snuevousuario&nvel="+nvel.value;
	
	//document.form1.action="MESprincipal.php?op=Bgrup&admin=usuarios&nuevo=S&id="+id+"&nvel="+nvel.value;
	document.form1.target="_self";
	document.form1.submit();
}
function cargaContenidoCliente(a)
{
	if(a>0){
	var parametro={"claclien":a};

	$.ajax({
		data:parametro,
	url:"comboboxclienteserv.php",
	type:"post",
	beforeSend:function(){
		$("#idserv").html("cargando...");
	},
	success:function(response){
		$("#idserv").append("<option value='0'>- TODOS -</option>");
		$("#idserv").append(response);
	}
	});
	}else
	{	
		$("#idserv").html("cargando...");
		$("#idserv").append("<option value='0'>- TODOS -</option>");
	}
}

function cargaOpciones(nvel)
{
	
document.getElementById('gpo_cliente').style.display='none';
	document.getElementById('gpo_cuenta').style.display='none';
	
	if(nvel=='cli' || nvel=='muf')
	{	
		document.getElementById('gpo_cliente').style.display='block';
	document.getElementById('gpo_cuenta').style.display='none';
	}
		if(nvel=='lab')
	{	
		document.getElementById('gpo_cliente').style.display='block';
	document.getElementById('gpo_cuenta').style.display='none';
	}
	if(nvel=='cue')
	{
		document.getElementById('gpo_cliente').style.display='none';
	document.getElementById('gpo_cuenta').style.display='block';
	}
}

function cargaContenidoServ(clave, campo,accion)
{
		//algo = Request.Querystring(op) 
		if(accion=="EDITAR")
	document.form1.action="index.php?action=snuevousuario&nuevo=E";
		else
			document.form1.action="index.php?action=snuevousuario";
		
	document.form1.target="_self";
	document.form1.submit();
	
}

</script>
<?php include 'Controllers/usuarioPermisosController.php';

$usuarioCon= new UsuarioPermisosController();
$usuarioCon->vistaNuevoUsuario();
?>
<section class="content-header">

<h1>USUARIOS</h1>
<h1><?php echo $usuarioCon->getTITULO5()?></h1>

</section>
  <section class="content container-fluid">
<form name="form1" method="post" action="index.php?action=slistausuarios&id=<?php echo $usuarioCon->getOp()?>&admin=<?php echo $usuarioCon->getAccion()?>&nivel=<?php $usuarioCon->getNV()?>" onsubmit="return Validar(this); ">
<div class="box box-info">
      <div class="box-header with-border">

<h3 class="box-title"><?php echo $usuarioCon->getAccion()?> USUARIO</h3>
     </div>
   <div class="box-body">
        <div class="form-group col-md-6">
                  <label>LOGIN :</label>
       <input name="clagrup" type="hidden" value="<?php echo $usuarioCon->getOp()?>" disabled="disabled" />
          <input  class="form-control" name="login" type="text" id="login" value="<?php echo $usuarioCon->getUsuario()['log']?>" size="35" maxlength="20" required/>
           <input name="grupo" id="grupo" type="hidden" value="<?php echo $usuarioCon->getOp()?>" />
           <input name="login_ant" type="hidden" id="login_ant" value="<?php echo $usuarioCon->getUsuario()['login_ant']?>"  />
       </div>
        <div class="form-group col-md-6">
                  <label>CONTRASE&Ntilde;A :</label>
       
          <input name="contras" type="text" class="form-control"  id="contras" value="<?php  echo $usuarioCon->getUsuario()['pass']?>" size="35" maxlength="20" required/>
        </div>
      <div class="form-group col-md-6">
                  <label>LENGUAJE :</label>
       <select name="idioma" class="form-control" >
<?php foreach ($usuarioCon->getIDIOMAS() as $idioma){

    echo $idioma;
}?>
	
           
        </select>        </div>
     <div class="form-group col-md-6">
                  <label>CLIENTE:</label>
        <select class="form-control" name="uscliente" id="uscliente" onchange="cargaContenidoServ(this.id,'cliente','<?php echo $usuarioCon->getAccion()?>');">
		<option value="0">- Todos -</option>
		
    
<?php 
    echo $usuarioCon->getLista_clientes();
?>
             </select></div>
 <div class="form-group col-md-6">
                  <label>SERVICIO:</label> 
                  <select class="form-control" name="usservicio" id="idserv">
		<option value="0">- Todos -</option>
		<?php 
    echo $usuarioCon->getLista_servicios();
?>
		</select>
 </div>

<?php echo $usuarioCon->getInsp()?>
<!-- inicioBloque: buscatecnicos -->
<?php foreach($usuarioCon->getLista_tecnicos() as $servicio){
    echo $servicio;
}?>     


   <div class="form-group col-md-6">
                  <label>NOMBRE DEL EMPLEADO :</label>
       
          <input name="nomusu" type="text" class="form-control"  id="nomusu" value="<?php echo $usuarioCon->getUsuario()['nombre']?>" size="35" maxlength="40" />
        </div>
   <div class="form-group col-md-6">
                  <label>EMPRESA :</label>
     
          <input name="empresa" type="text" class="form-control"  id="empresa" value="<?php echo $usuarioCon->getUsuario()['empres']?>" size="35" maxlength="40" />
        </div>
       <div class="form-group col-md-6">
                  <label>CARGO :</label>
      
          <input name="cargo" type="text" class="form-control"  id="cargo" value="<?php echo $usuarioCon->getUsuario()['carg']?>" size="35" maxlength="40" />
        </div>
    
      <div class="form-group col-md-6">
                  <label>TELEFONO :</label>
        
          <input name="tel" type="text" class="form-control"  id="tel" value="<?php echo $usuarioCon->getUsuario()['tele']?>" size="35" maxlength="40" />
        </div>
     
      <div class="form-group col-md-6">
                  <label>EMAIL :</label>
        
          <input name="email" type="text" class="form-control"  id="email" value="<?php echo $usuarioCon->getUsuario()['correo']?>" size="35" maxlength="40" />
        </div>
     
      <!-- inicioBloque: solicitudes -->
<?php echo $usuarioCon->getSc();
?>   

      <div class="row" id="gpo_cuenta" >

  
	  <div class="form-group col-md-6">
                  <label>CONSULTA POR CUENTA :</label>
		
        <select class="form-control" name="cta" id="cuenta"  onchange="cargaContenidoCuenta(this.id,'uscliente','usservicio')">
		<option value="0">- Seleccione Cuenta -</option>
		
       <!-- inicioBloque: buscanivelfr -->

<?php foreach($usuarioCon->getNivelfr() as $sol){
    echo $sol;
}?>       </select> </div>
	  <div class="form-group col-md-6">
                  <label>CONSULTA POR FRANQUICIA:</label>
      <div> <select class="form-control" name="franqcuenta" id="franqcuenta">
		
		<option value="">- Todos -</option>
		<?php echo $usuarioCon->getFrancta();
?>   
				
		</select>    </div> </div> 
	  <div class="form-group col-md-6">
                  <label>CONSULTA POR PUNTO DE VENTA        
          :</label>
       <div> <select class="form-control" name="unidadnegocio" id="unidadnegocio">
		<option value="0">- Todos -</option>
        <!-- inicioBloque: buscanivelpv -->
<?php 
 echo $usuarioCon->getNivelpv();
?>      </select></div> </div>
</div>
  <div class="row" id="gpo_cliente" >
	 <div class="form-group col-md-6">
                  <label><?php echo $usuarioCon->getNOMBRENIVEL()?></label>
	    <?php echo $usuarioCon->getNivel11()?>
	     <!-- inicioBloque: buscanivel -->
            <?php foreach($usuarioCon->getNivel() as $op){
    echo $op;
}?>    	  </div>
 <div class="form-group col-md-6">
<input type="hidden" name="id" id="id" value="<?php echo $usuarioCon->getOp()?>" />

<label><?php echo $usuarioCon->getTipoNivel_1()?></label>
	  
	  <?php echo $usuarioCon->getPosicion01()?>
				 <!-- inicioBloque: PanelNvel01 -->
             <?php echo $usuarioCon->getPosicion() ;?>   
				<input name="varnivel2" type="hidden" id="varnivel2" value="N1()?>" />  
         </div>              <input type="hidden" name="clave" value="<?php echo $usuarioCon->getUsuario()['clav']?>" id="clave" />
	  
	   
      
	 <div class="form-group col-md-6">
                  <label><?php echo $usuarioCon->getTipoNivel_2()?></label>
	  
				<?php echo $usuarioCon->getPosicion02()?>
		  </div>
		    <!-- Combo2 Nivel dos -->
	    <div class="form-group col-md-6">
                  <label><?php echo $usuarioCon->getTipoNivel_3()?></label>
	  
				<?php echo $usuarioCon->getPosicion03()?>    
				</div>
		   <div class="form-group col-md-6">
	   <label><?php echo $usuarioCon->getTipoNivel_4()?></label>
      
				<?php echo $usuarioCon->getPosicion04()?>    
		 </div>
	  <div class="form-group col-md-6">
                  <label><?php echo $usuarioCon->getTipoNivel_5()?></label>
      
				<?php echo $usuarioCon->getPosicion05()?>    
		  </div>
     
	 
	    <div class="form-group col-md-6">
                  <label><?php echo $usuarioCon->getTipoNivel_6()?></label>
      
       <?php echo $usuarioCon->getPosicion06()?>    
		 </div>
     
	
  </div>
  </div>
  <div class="box-footer col-md-12">
                  <button type="submit" class="btn btn-info pull-right">GUARDAR</button>
      <button class="btn btn-info pull-right" type="button"  onclick="document.location='index.php?action=slistausuarios&id=<?php echo $usuarioCon->getOp()?>';"  >CANCELAR</button>
   </div>
 </div>
 
</form>
</section>
<script type="text/javascript">
  cargaOpciones('<?php echo $usuarioCon->getOp()?>');
 /* if(document.getElementById('grupo').value=='ext'&&document.getElementById('tipo_usu').value!='')
  	cargaNivel1({tipo_usu});*/
  </script>
  <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>

<script src="js/jquery.cascading-drop-down.js"></script>

<script>



    $('.cascada').ssdCascadingDropDown({

        nonFinalCallback: function (trigger, props, data, self) {



            trigger.closest('form')

                    .find('input[type="submit"]')

                    .attr('disabled', true);



        },

        finalCallback: function (trigger, props, data) {



            if (props.isValueEmpty()) {

                trigger.closest('form')

                        .find('input[type="submit"]')

                        .attr('disabled', true);

            } else {

                trigger.closest('form')

                        .find('input[type="submit"]')

                        .attr('disabled', false);

            }



        }

    });

</script>