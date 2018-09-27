<?php
$resumenRes=new ResumenResultadosController;

$resumenRes->vistaResumenResultados();

?>


  <section class="content-header">
                <h1><?php echo $resumenRes->getFiltros_indi()->getNombre_seccion();
              echo "<br>".$resumenRes->getFiltros_indi()->getPeriodo();
              echo "<br>".$resumenRes->getFiltros_indi()->getNombre_nivel();
              echo "<br>".$resumenRes->getFiltros_indi()->getNombre_franquicia();?></h1>
      <ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
      </ol>
    </section>

<?php include "cue_indresumenresultados.php"?>
