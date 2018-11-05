
<script type="text/javascript">
 
	function Activar()
	{
		document.uform.submit.disabled=false;
	}
	function cargando(form){
	if(document.getElementById("userfile").value.length||document.getElementById("archsql").value.length)
	{
	document.getElementById("form1").style.display='none';
	document.getElementById("form2").style.display='none';
	document.getElementById('loading').style.display='inline';

	}
	
	}

	
</script>
<?php

include 'Controllers/restImagenController.php';

$permisoController= new RestImagenController();

$permisoController->cargarRespaldo();

?>
 <section class="content-header">

<h3>RESTAURAR IMAGENES</h3>

</section>
   <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">SELECCIONAR ARCHIVOS :</h3>
            </div>
            <div class="box-body">
             <form role="form" name="uform" action="index.php?sresaurarimagen&adm=car" method="post" enctype="mutipart/form-data" onsubmit="cargando(this);" >
              
               <input name="grupo" type="hidden" value="<?php echo $permisoController->getGrupo()?>" />
	 <div class="col-sm-10" ><label> Archivo de imagenes zip  </label>
        <input type="file" name="userfile" id="userfile" class="form-control"   onchange="Activar();"  /></div>
        <div class="col-sm-10" ><label>
        Archivo sql
        <input type="file" name="archsql" id="archsql" class="form-control"   onchange="Activar();"   />
            </label>
	
                <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                 <button  type="button" class="btn btn-default pull-right" style="margin-left: 10px" ><a href="index.php?action=slistapermisos&id=<?php echo $permisoController->getGrupo()?>">Cancelar</a></button>
                <button type="submit" class="btn btn-info pull-right" disabled>Guardar</button>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>


    