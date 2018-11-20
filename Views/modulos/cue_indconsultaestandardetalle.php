<?php
include  "Controllers/indpostmix/consultaEstandarController.php";
$estandarController=new ConsultaEstandarController();
$estandarController->vistaEstandarDetalle();
?>


    <!-- Content Header (Page header) -->
    
      <section class="content-header">
<h1><?php echo $estandarController->getNombreUnegocio();?></h1>
<h1><?php echo $estandarController->getTitulo();?></h1>
<h1><?php echo $estandarController->getNombreSeccion()?></h1>
<ol class="breadcrumb">
<?php Navegacion::desplegarNavegacion();?>
</ol>
</section>


    <!-- Main content -->
    <section class="content container-fluid">

      <!----- Inicia contenido ----->
             <?php 
              //despliego los renglones
                foreach($estandarController->getListaEstandar() as $numren=>$renglon){
                    ?>
        <div class="row">
        	 <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo  T_("RESULTADO") ." ". $numren;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 20%"><?php echo T_("REACTIVO")?></th>
                  <th style="width: 24%"><?php echo T_("ESTANDAR")?></th>
                  <th style="width: 56%"><?php echo T_("RESULTADO")?></th>
                </tr>
         <?php 
         foreach($renglon as $reactivo){
             
         echo "<tr><td>".$reactivo["reactivo"]."</td>";
         echo "<td>".$reactivo["estandar"]."</td>";
                echo "<td>".$reactivo["resultado"]."</td></tr>";
         }
                ?>
              </table>
            </div>
            <!-- /.box-body -->
         
          </div>
          <!-- /.box -->
        </div>
        </div>
        <?php }?>
          <div class="box box-info">  <div class="box-body"><strong>
        <?php echo T_("NIVEL DE CUMPLIMIENTO").": ".$estandarController->getSumapond()?>
       %</strong> </div><!-- /.box-body --></div>
	  <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
 