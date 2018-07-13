<?php
$cump = filter_input(INPUT_GET, "cump",FILTER_SANITIZE_STRING);
//include('MEutilerias.php');
$subseccionl =  filter_input(INPUT_GET, "refer",FILTER_SANITIZE_STRING);
//guardofiltrocue_indcumplimientoestabl

$tiposec =  filter_input(INPUT_GET, "tiposec",FILTER_SANITIZE_STRING);
$estadisticasController=new EstadisticasController;
$estadisticasController->vistaCumplimientoEstabl($cump, $subseccionl, $tiposec)
?>



<script type="text/javascript">
function ordenar(orden)
{
	window.location=document.URL+"&ord="+orden;
}


</script>

    <section class="content-header">
                <h1><?php  echo $estadisticasController->getFiltrosSel()->getNombre_seccion();
              echo "<br>".$estadisticasController->getFiltrosSel()->getPeriodo();
              echo "<br>".$estadisticasController->getFiltrosSel()->getNombre_nivel();
              echo "<br>".$estadisticasController->getTitulo2();?></h1>
      <ol class="breadcrumb">
        <li><a href="#"><em class="fa fa-dashboard"></em> Home</a></li>
        <li class="active"><?php /*echo $estadisticasController->getFiltrosSel()->getNombre_seccion(); */ ?></li>
      </ol>
    </section>

<section class="content container-fluid">
    <div class="box-header">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
     <!--   <tr>
          <td height="39" class="regresar">
        <a href="{ligareg}"  style="color:#FFFFFF">&lt;&lt;{lb_Regresar}</a>
  </td></tr>-->
        <tr>
          <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="table table-striped">
              <tbody>
               
                <!--<tr>
                  <td class="Titulo" colspan="4">{lb_ESTABLECIMIENTOS_QUEC}:<span style="color:#FF6600" > {estandar}</span></td>
                </tr>-->
                  
                  <?php 
                  echo 
               ' <tr>
                  <th class="subtitulo" width="293">'.T_("FRANQUICIA").'</th>
                  <th class="subtitulo" width="293">'.T_("CIUDAD").'</th>
                  <th class="subtitulo" width="293">'.T_("PUNTO DE VENTA").'</th>
                  <th class="subtitulo" width="115">'.T_("RESULTADO").
                          ' <span  style="font-size:9px">'.$estadisticasController->getNotaEstabl().
                          '</span><a href="javascript: ordenar(\'valor.desc\');" style="font-size:9px; color:#FFFFFF;  text-decoration:underline"  title="'.T_("Ordenar de mayor a menor").'">max</a> <a href="javascript: ordenar(\'valor.asc\');" style="font-size:9px; color:#FFFFFF;  text-decoration:underline "  title="'.T_("Ordenar de menor a mayor").'">min</a></th>
                </tr>';
                
            foreach($estadisticasController->getListaEstablecimientos() as $resultado){
             
              echo'  <tr>
                  <td class="'.$resultado->getEstilo().'"><a href="'.$resultado->getLiga().'"> '.$resultado->getPuntoVenta()->getFranquicia().'</a></td>
                  <td class="'.$resultado->getEstilo().'"><a href="'.$resultado->getLiga().'">  '.$resultado->getPuntoVenta()->getCiudad().'</a></td>
                  <td class="'.$resultado->getEstilo().'"><a href="'.$resultado->getLiga().'"> '.$resultado->getPuntoVenta()->getPuntoVenta().'</a></td>
                  <td class="'.$resultado->getEstilo().'"><a href="'.$resultado->getLiga().'" onclick="guardarLiga(this, \'SECCIONES\');"> '.$resultado->getResultado().'</a></td>
                </tr>';
            }
               
             ?>
                </tbody>
            </table></td>
        </tr>
          </tbody>
        
</table>
    </div>
</section>