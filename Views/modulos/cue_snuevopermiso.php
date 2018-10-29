<?php

include 'Controllers/permisosController.php';

$permisoController= new PermisosController();

$permisoController->vistaNuevo();

?>
  
  <script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function validar(form){
	if((form.nomcta.value=='')){
		alert("Por favor, escribe el nombre de la cuenta");
		form.nomcta.focus();
		form.nomcta.select();
		return false;	
	}else{
		//Si el codigo llega hasta aquí, todo estará bien  y realizamos el Submit
		return true;
	}
}

function cargaMenu(opc, grupo)
{
	document.form1.action='index.php?action=snuevopermiso&id='+grupo;
	document.form1.submit();
	
}
//-->
</script>
  <section class="content-header">

<h3>PERMISOS</h3>
<h3><?php echo $permisoController->getTitulo1()?></h3>

</section>
   <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">NUEVO PERMISO</h3>
            </div>
            <div class="box-body">
             <form role="form" name="form1" method="post" action="index.php?action=slistapermisos&admin=insertar">
              
               <input name="grupo" type="hidden" value="<?php echo $permisoController->getGrupo()?>" />
	 <div class="col-sm-10" ><label>NOMBRE DEL PERMISO  :</label>
	 
          <select name="combito"  class="campoTxt" id="combito" onchange="cargaMenu(this.value,'<?php echo $permisoController->getGrupo()?>');">
		  <option value="0">-Seleccione una opci&oacute;n-</option>
           
			<?php foreach($permisoController->getListaPermisos() as $permiso){
			    echo $permiso["cbox"];
			}?>
             
             
			 <!-- finBloque: buscacuenta -->
			 
          </select>
          
		  <input name="idper" type="hidden" value="<?php echo $permisoController->getIds()?>" />
	  
	      <input type="hidden" name="subop" value="<?php echo $permisoController->getSubop()?>" />
	    
	  </div>
    <div class="col-sm-10"><?php echo $permisoController->getTitmenu()?></div>
	<div class="col-sm-10"><?php echo $permisoController->getSubmenu()?></div>
	
                <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                 <button  class="btn btn-default pull-right" style="margin-left: 10px" ><a href="index.php?action=slistapermisos&id=<?php echo $permisoController->getGrupo()?>">Cancelar</a></button>
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>


       