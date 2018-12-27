

<style >

    .los_demas {

    display: none;

}

</style>

<script language="JavaScript" type="text/JavaScript"> 

function enviar(direccion)
{
if(direccion!="")
		document.form1.action=direccion;
		
	document.form1.submit();
}

 function MostrarFilas(Fila,objeto) {

var elementos = document.getElementsByName(Fila);

    for (i = 0; i< elementos.length; i++) {

        if(navigator.appName.indexOf("Microsoft") > -1){

               var visible = 'block'

        } else {

               var visible = 'table-row';

        }

		if(elementos[i].style.display=='none'||elementos[i].style.display=='')

			{elementos[i].style.display = visible;

			//document.getElementById(objeto).innerHTML="minimizar lista";

			document.getElementById(objeto).innerHTML="minimizar";

			}

			else

			{	elementos[i].style.display='none';

				document.getElementById(objeto).innerHTML="desplegar";

			}

        }

	//alert(objeto);

	

	//	objeto.parent.innerHTML="otra cosa";

}



	





</script>

<?php
include "Controllers/generaBusqResController.php";
$resumenRes=new ResumenResultadosController;

$resumenRes->vistaResumenResultados();
$resumenRes->encabezaConsulta();

?>

<section class="content-header">

<ol class="breadcrumb">

            <?php Navegacion::desplegarNavegacion();?>

  </ol></section>

<section class="content container-fluid">




		  <div id="encabezado2"  class="encabezado_cons"  >
<form name="form1" action="index.php?action=listaconsultaRep" method="post">
  <?php include "encabeza_resultados.php";?>
 </form>

</div>
   
  <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><?php echo T_("RESULTADOS")?></a></li>
              <li><a class="nav-link"  href="javascript:enviar('');"> <?php echo T_("REPORTES VISITA")?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                 <div class="box">
            <div class="box-header">
              <h3 class="box-title">  <?php echo $resumenRes->getTotal_res() ;?></h3>
            </div>
 

 

	 <?php foreach($resumenRes->getLista_tablas() as $tabla){

             echo 

            ' <div class="row">

             <div class="col-xs-12">

             <div class="box">'.

             $tabla.

            ' </div></div></div>';

         }?>



	<!-- finBloque: listasec -->
 </div>
				</div>
	

	
</div></div></div></div>




</section>

 

