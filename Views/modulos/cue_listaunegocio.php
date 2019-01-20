<script type="text/javascript">
<!--
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
function buscaCiudades(estado, referuni)
{
	/*if(estado!=0)
	{*/
		var ajax=nuevoAjax();
		
		ajax.open("GET", "comboestado_ciudad.php?estado="+estado+"&referuni="+referuni, true);
		selectDestino=document.getElementById("ciudad");
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option");
				nuevaOpcion.value=0;
				nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;	
			}
			if (ajax.readyState==4)
			{
			
			opcion=ajax.responseText;
			
				selectDestino.parentNode.innerHTML=opcion;
				
				selectDestino.disabled=false;
			} 
		}
		ajax.send(null);
	
	//}
}
//-->
</script>
    <section class="content-header">
      <h1>Puntos de venta &nbsp; &nbsp; <small></small></h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
<?php

$ingreso = new unegocioController();
$ingreso->iniciarFiltros();
?>
      
        <div class="row">
		<div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Búsqueda de punto de venta</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
              <form role="form" method="post">
               <div class="col-sm-3">
               <label>ESTADO </label>
   <div> <select class="form-control" name="estado" id="estado" onChange="buscaCiudades(this.value,'<?php echo $ingreso->getRef()?>');">
    <option value="0">Todos</option><?php echo $ingreso->getListaEstados()?></select>
    </div>
    </div>
    <div class="col-sm-3">
      <label>CIUDAD</label>
     <div> <select class="form-control" name="ciudad" id="ciudad"><option value="">Todas</option><?php echo $ingreso->getCiudades()?></select>
      </div></div>
      <div class="col-sm-3">
       <label>PUNTO DE VENTA</label>
                 <input type="text" name="opcionuneg" id="opcionuneg" class="form-control" placeholder="Escribe palabra relacionada con el punto de venta" >
</div>
<div class="col-sm-3">
               
                      <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i>Buscar</button>
                   
                </div>
               
                </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
			</div>
        </div>
        
        <div class="row">
           <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Resultado de búsqueda</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 20%">No.</th>
                  <th style="width: 20%">ID PEPSI</th>
                  <th style="width: 24%">ID CUENTA</th>
                  <th style="width: 56%">NOMBRE</th>
                </tr>
              
<?php

$ingreso -> vistaUnegocioController();

?>

               </table>
            </div>
            <!-- /.box-body -->
                      </div>
          <!-- /.box -->
        </div>
        </div>


	  <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">&nbsp; &nbsp; &nbsp;</div>
    <!-- Default to the left --><strong>Copyright &copy; 2018 Muesmerc S.A. de C.V.</strong> Todos los derechos reservados. </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>