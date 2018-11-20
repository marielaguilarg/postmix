
<script type="text/javascript">
 
	function Activar()
	{
		document.getElementById("subbutton").disabled=false;
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

require 'Controllers/restImagenController.php';

$restaurarController= new RestImagenController();

$restaurarController->cargarRespaldo();

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
             <form role="form" name="uform" action="index.php?action=srestaurarimagen&adm=car" method="post" enctype="multipart/form-data" onsubmit="cargando(this);" >
              
              
	 <div class="col-sm-10" ><label> Archivo de imagenes zip  </label>
        <input type="file" name="userfile" id="userfile" class="form-control"   onchange="Activar();" accept=".zip" /></div>
        <div class="col-sm-10" ><label>
        Archivo sql</label>
        <input type="file" name="archsql" id="archsql" class="form-control"   onchange="Activar();" accept=".txt"  />
           
	</div>
                <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                 <a class="btn btn-default pull-right" href="index.php?action=srespaldoimagenes" style="margin-left: 10px">Cancelar</a>
                <button type="submit" id="subbutton" class="btn btn-info pull-right" disabled="disabled">Restaurar</button>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>


    