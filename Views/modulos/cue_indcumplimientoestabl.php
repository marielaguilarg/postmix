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
              echo "<br>".$estadisticasController->getFiltrosSel()->getNombre_nivel(); ?>
             </h1>
      <ol class="breadcrumb">
           <?php Navegacion::desplegarNavegacion();?>
      </ol>
    </section>

<section class="content container-fluid">
     <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> <?php echo "<br>".$estadisticasController->getTitulo2();?></h3>
            
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
            <table  class="table table-striped">
              <tbody>
               
                <!--<tr>
                  <td class="Titulo" colspan="4">{lb_ESTABLECIMIENTOS_QUEC}:<span style="color:#FF6600" > {estandar}</span></td>
                </tr>-->
                  
                  <?php 
                  echo 
               ' <tr>
                  <th >'.T_("FRANQUICIA").'</th>
                  <th >'.T_("CIUDAD").'</th>
                  <th >'.T_("PUNTO DE VENTA").'</th>
                  <th >'.T_("RESULTADO").
                          ' <span  style="font-size:9px">'.$estadisticasController->getNotaEstabl().
                          '</span><a href="javascript: ordenar(\'valor.desc\');" style="font-size:9px; color:#979494;  text-decoration:underline"  title="'.T_("Ordenar de mayor a menor").'">max</a> <a href="javascript: ordenar(\'valor.asc\');" style="font-size:9px; color:#979494;  text-decoration:underline "  title="'.T_("Ordenar de menor a mayor").'">min</a></th>
                </tr>';
                
            foreach($estadisticasController->getListaEstablecimientos() as $resultado){
             
              echo'  <tr>
                  <td ><a href="'.$resultado->getLiga().'"> '.$resultado->getPuntoVenta()->getFranquicia().'</a></td>
                  <td ><a href="'.$resultado->getLiga().'">  '.$resultado->getPuntoVenta()->getCiudad().'</a></td>
                  <td ><a href="'.$resultado->getLiga().'"> '.$resultado->getPuntoVenta()->getPuntoVenta().'</a></td>
                  <td ><a href="'.$resultado->getLiga().'" onclick="guardarLiga(this, \'SECCIONES\');"> '.$resultado->getResultado().'</a></td>
                </tr>';
            }
               
             ?>
                </tbody>
            </table>
</div>
    </div>
</section>