  <?php include "Controllers/catalogosController.php";
  $catalogosControl=new CatalogosController();
  $catalogosControl->vistaNuevo();
  $catalogo=$catalogosControl->resultado;

  ?>
  <section class="content-header">
  <h1>  <?php echo $catalogosControl->titulo2." ".$catalogosControl->titulo?></h1>
   
  </section>
 
  <section class="content container-fluid">
 <div class="box box-info">
  
   <form role="form" method="post" action="<?php echo $catalogosControl->action?>">
<div class="box-body">
             <?php
             $opcion=filter_input(INPUT_GET, "op",FILTER_SANITIZE_STRING);
             $regresar="index.php?action=listacatalogosgen&op=".$opcion;
             switch($opcion){
             
             	case "cc":
             		$archivo="catalogop";
             		$regresar="index.php?action=listacatalogos";
             		break;
             	case "cat":
             		$archivo="catalogo";
             		$id=filter_input(INPUT_GET, "cat",FILTER_SANITIZE_STRING);
             		if($id==""){
             			$id=filter_input(INPUT_POST, "clavecat",FILTER_SANITIZE_STRING);
             		}
             		$regresar="index.php?action=listacatalogosgen&op=cat&cat=".$id;
             		break;
             	case "ins":
             		$archivo="inspector";
             		break;
             	case "vol":
             		$archivo="volumen";
             		$regresar="index.php?action=listacatalogosgen2&op=".$opcion;
             		break;
             	case "mes":
             		$archivo="mesasig";
             		$regresar="index.php?action=listamesas&op=".$opcion;
             		break;
             	case "tm":
             		$archivo="TipoMercado";
             		break;
             }
             include "nuevo".$archivo.".php";
             
             ?> </div>
                   <div class="box-footer" style="border-bottom: hidden">
                   
               <div class="pull-right"> 
  <button type="submit" class="btn btn-info">GUARDAR</button> 
                 <a  class="btn btn-default" style="margin-left: 10px" href="<?= $regresar ?>"> CANCELAR </a>
              
</div>
              </div>
             
               </form>
             
            </div>
            </section>