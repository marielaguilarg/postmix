<link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">

	<link href="views/dist/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<link href="views/dist/css/responsive.bootstrap.min.css" rel="stylesheet">



	<script type="text/javascript" language="javascript" src="views/dist/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/dataTables.responsive.min.js"></script>

	<script type="text/javascript" language="javascript" src="views/dist/js/responsive.bootstrap.min.js"></script>

<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script language="JavaScript" type="text/JavaScript">



function enviar(direccion)
{
if(direccion!="")
		document.form1.action=direccion;
		
	document.form1.submit();
}




//-->

</script>



<?php

include 'Controllers/listaReportesController.php';

$listaRepController=new ListaReportesController();

$listaRepController->vistaListaReportes();
$resumenRes=new ResumenResultadosController;


$resumenRes->encabezaConsulta();

?>

 <section class="content-header">

<ol class="breadcrumb">

            <?php Navegacion::desplegarNavegacion();?>

  </ol>


    </section>



    <!-- Main content -->

    <section class="content container-fluid">
    <div>
     <form name="form1" action="index.php?action=resumenresultados" method="post">
 <?php include "encabeza_resultados.php";?>
</form>
</div>
     
  <div class="row">
        <div class="col-md-12">


      <!----- Inicia contenido ----->

     <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a class="nav-link"  href="javascript:enviar('');" ><?php echo T_("RESULTADOS")?></a></li>
              <li  class="active"><a href="#tab_2" data-toggle="tab"> <?php echo T_("REPORTES VISITA")?></a></li>
            </ul>
            <div class="tab-pane" id="tab_2">
                  <div class="box">
          
            <div class="box-header">
<form name="formfiltro" action="index.php?action=listaconsultaRep" method="post" > 
  
 
              <h3 class="box-title"><?php echo T_("BUSCAR PUNTO DE VENTA")?></h3>

             <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="fil_ptoventa" class="form-control pull-right" placeholder="Buscar">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div></form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-striped"">
            <tr>

                <th><?php  echo T_("REPORTE NO.")?></th>

              
                <th><?php  echo T_("PUNTO DE VENTA")?></th>

                <th><?php  echo T_("MES")?></th>

                <th><?php  echo T_("ESTADO")?></th>
                <th><?php  echo T_("CIUDAD")?></th>

                <th><?php  echo T_("DIRECCION")?></th>

                
            </tr>

    

        <tbody>

        

        <?php foreach($listaRepController->getListaReportes() as $reporte){

            
        	$mes=Utilerias::cambiaMesGIng($reporte ["MesAsignacion"]);
        	$direccion="index.php?action=resultadosxrep&numrep=" . $reporte ["NumReporte"]."&cser=".$listaRepController->getVserviciou()."&ccli=".$listaRepController->getVclienteu();
        	
            //despliego renglones de solicitud

            ?>

            <tr>

                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["NumReporte"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["PuntoVenta"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $mes?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["une_dir_estado"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["une_dir_municipio"]?></a></td>
                <td><a href="<?php echo $direccion?>"> <?php echo $reporte["direccion"];?></a></td>

             

            </tr>

                 <?php } //fin foreach?>



        </tbody>

    </table>

            </div>

            <!-- /.box-body -->
   <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                 <?php if($listaRepController->getPages()!=null) echo $listaRepController->getPages()->display_pages() ?>
                </ul>
            </div>


          </div>

          <!-- /.box -->

        </div>

        </div>
        </div>
        </div>

	  <!----- Finaliza contenido ----->

    </section>

