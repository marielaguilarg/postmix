<?php
class muestrasController{


  public function listaMuestrasPendientes(){
        $gpo = UsuarioController::Obten_grupo();
    
    $idusuario=UsuarioController::Obten_Usuario();
    
    $usuario =UsuarioModel::getUsuarioId($idusuario,"cnfg_usuarios");
        #presrenta datos de unegocio
    //var_dump($usuario);

    $tipocons = $usuario["cus_tipoconsulta"];
    
    if ($gpo=="lab") {
        $respuesta = DatosMuestra::vistaMuestrasLab(4, $tipocons, $tabla);
     
    } else {     
        $respuesta = DatosMuestra::vistaMuestras(4, $tabla);
     
    }

    // despliega datos
      foreach($respuesta as $row => $item){
          echo '
            <div class="col-md-6" >
              <div class="box box-info" >
                <div class="box-header with-border">
                <h3 class="box-title">Muestra No.'. $item["mue_idmuestra"].'</h3>

                  <div class="box-tools pull-right">
                   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
<div class="row col-sm-12">
                 <div class="arrow">
                      <div class="box-footer no-padding">
                      
                        <ul class="nav nav-stacked">
                        <li><a>SERVICIO : <strong>'. $item["ser_descripcionesp"].'</strong></a></li>
                        </ul>
                    </div>
                  </div>
            </div>           

            <div class="row col-sm-12">
                 <div class="arrow">
                      <div class="box-footer no-padding">
                      
                        <ul class="nav nav-stacked">
                        <li><a>PUNTO DE VENTA : <strong>'. $item["une_descripcion"].'</strong></a></li>
                        </ul>
                    </div>
                  </div>
            </div>';
            #CALCULA LABORATORIO
            $numlab=$item["rm_embotelladora"];
            $cat = DatosCatalogoDetalle::listaCatalogoDetalleOpc(43, $numlab, "ca_catalogosdetalle");
            $catnombre = $cat["cad_descripcionesp"];
            echo '
            <div class="row col-sm-12">
                 <div class="arrow">
                      <div class="box-footer no-padding">
                      
                        <ul class="nav nav-stacked">
                        <li><a>LABORATORIO : <strong>'. $catnombre.'</strong></a></li>
                        </ul>
                    </div>
                  </div>
            </div>

                   <div class="row" col-sm-12>
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                     
                       ANALISIS FISICOQUIMICO :

                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">';
                  
                  if ($item["mue_estatusFQ"]==1) {
                      echo '
                    <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="javascript:imprimirFQ('.$item["mue_idmuestra"].');"> IMPRIMIR </a></span></button>';
                  }  
                  echo '
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">';
                      if ($item["mue_estatusFQ"]==2) {
                        echo '
                          <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=rsn&sec='.$item["sec_numseccion"].'&ts='.$item["sec_tiposeccion"].'&sv='.$item["ser_claveservicio"].'&nrep='.$nrep.'&pv='.$pv.'&idc='.$idc.'"> Detalle </a></span></button>';
                      }    
                      echo '    
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div> 

                  <div class="row" col-sm-12>
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                     
                       ANALISIS MICROBIOLOGICO :

                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">';
                      if ($item["mue_estatusMB"]==1) { 
                        echo '
                    <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="javascript:imprimirMB('.$item["mue_idmuestra"].');"> IMPRIMIR </a></span></button>';
                  }
                     echo '
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">';

                      if ($item["mue_estatusMB"]==2) {
                          echo '
                          <button type="button" class="btn btn-block btn-info"><span style="font-size: 12px"><a href="index.php?action=rsn&sec='.$item["sec_numseccion"].'&ts='.$item["sec_tiposeccion"].'&sv='.$item["ser_claveservicio"].'&nrep='.$nrep.'&pv='.$pv.'&idc='.$idc.'"> Detalle </a></span></button>';
                      }
                      echo '    
  </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div> 





                       </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
           
            
        </div>';
                 

      }
   } 

  public function tomaMuestraRep(){
    #lee varia{ble
    $gpous = UsuarioController::Obten_grupo();
    $sv=$_GET["sv"];
    $sec=$_GET["sec"];
    $nrep=$_GET["nrep"];
    $pv=$_GET["pv"];
    $idc=$_GET["idc"];
 
    $idsec=substr($sec,4,1);
    $datini=SubnivelController::obtienedato($sec,1);
    $londat=SubnivelController::obtienelon($sec,1);
    $numsec=substr($sec,$datini,$londat);

    $datini=SubnivelController::obtienedato($sec,2);
    $londat=SubnivelController::obtienelon($sec,2);
    $numreac=substr($sec,$datini,$londat);
       
    $datini=SubnivelController::obtienedato($sec,3);
    $londat=SubnivelController::obtienelon($sec,3);
    $numcom=substr($sec,$datini,$londat);
  
    $datini=SubnivelController::obtienedato($sec,4);
    $londat=SubnivelController::obtienelon($sec,4);
    $numcom=substr($sec,$datini,$londat);
 
    $datini=SubnivelController::obtienedato($sec,5);
    $londat=SubnivelController::obtienelon($sec,5);
    $numcom=substr($sec,$datini,$londat);
   
    
      echo '<div class="row">
  <div class="col-md-12" ><button  class="btn btn-default pull-right" style="margin-right: 18px; margin-top:15px; margin-bottom:15px; "><a href="index.php?action=rsn&sec='.$sec.'&sv='.$sv.'&ts=TN&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Nuevo  </a></button>
   </div>
   </div>';
  
    #determina el tipo de evaluacion
  echo '<section class="content container-fluid">';

        #presenta encabezado
        $muestra=DatosMuestra::vistaMuestrasRep($idsec, $nrep, $sv, $tabla);
           
            $i=1;

            foreach ($muestra as $key => $rownr) {
           
      echo '

        <!----- Inicia contenido ----->
        
      <div class="col-md-4" >
      <div class="box box-info" >
      <div class="box-header with-border">
      <h3 class="box-title">No.'. $i.'</h3>

<table class="table">
            <tr>
              <th style="width: 26%">REACTIVO</th>
              
              <th style="width: 24%">RESULTADO</th>';

            #busca reactivos en cuestionario
              $tipomue =$rownr["mue_tipomuestra"];
              $unidadFQ =$rownr["mue_numunidadesFQ"];
              $capacidadFQ =$rownr["mue_capacidadFQ"];
              $unidadMB =$rownr["mue_numunidadesMB"];
              $capacidadMB =$rownr["mue_capacidadMB"];
              $origen =$rownr["mue_origenmuestra"]; 
              $numtoma =$rownr["mue_numtoma"];
              $fec_toma =SubnivelController::cambiaf_a_normal($rownr["fectom"]);
              $hor_toma =$rownr["hortom"]; 
              $numrep =$rownr["mue_numreporte"];  
              $estatus=$rownr["mue_estatusmuestra"];
              $fuenab=$rownr["mue_fuenteabas"];

                //tipomuestra
              $tipos = DatosCatalogoDetalle::listaCatalogoDetalleOpc(41, $tipomue, "ca_catalogosdetalle");

              $tipomuestra= $tipos['cad_descripcionesp'];
  
              //origen
              $origenrow = DatosCatalogoDetalle::listaCatalogoDetalleOpc(21, $origen, "ca_catalogosdetalle");

              $origendes= $origenrow['cad_descripcionesp'];
              
                //numero de toma
              $tomas = DatosCatalogoDetalle::listaCatalogoDetalleOpc(42, $numtoma, "ca_catalogosdetalle");

              $numerotoma= $tomas['cad_descripcionesp'];
  
              $fuente = DatosCatalogoDetalle::listaCatalogoDetalleOpc(45, $fuenab, "ca_catalogosdetalle");

              $fuentedes= $fuente['cad_descripcionesp'];

              if ($estatus==5){
                       $nomestatus="Terminada";
                   } else if ($estatus==6){    
                           $nomestatus="Cancelada";
                   } else {        
                      $nomestatus="En proceso";
                  }

  
            echo '
              <tr> <td> No. Muestra</td>
              
               <td > '. $rownr["mue_idmuestra"]. '</td></tr>
               <tr> <td> Tipo de Muestra</td>
               <td > '. $tipomuestra .'</td></tr>
               <tr> <td> Fecha</td>
               
               <td > '. $fec_toma .'</td></tr>
               <tr> <td> Hora</td>
               
               <td > '. $hor_toma .'</td></tr>
               <tr> <td> Estatus</td>
               
               <td > '. $nomestatus .'</td></tr>
               <tr> <td> Unidad Fisicoquimico</td>
               
               <td > '. $unidadFQ .'</td></tr>
               <tr> <td> Capacidad Fisicoquimico</td>
               
               <td > '. $capacidadFQ .'</td></tr>
               
               <tr> <td> Unidad Microbiológico</td>
               
               <td > '. $unidadMB .'</td></tr>
               <tr> <td> Capacidad Microbiológico</td>
               
               <td > '. $capacidadMB .'</td></tr>
              <tr> <td> Origen de la Muestra</td>
               
               <td > '. $origendes .'</td></tr>
               <tr> <td> No. de Toma</td>
               
               <td > '. $numerotoma .'</td></tr>
               <tr> <td> Fuente de Abastecimiento</td>
               
               <td > '. $fuentedes .'</td></tr>';
               if ($estatus==1){
                 echo '
               <tr> <td><button type="button" class="btn btn-block btn-info"><a href="index.php?action=rsn&idb='. $numren.'&sv='.$sv.'&nrep='. $nrep.'&ts=ED&idc='. $idc.'&sec='. $sec.'">Imprimir</a></button> </td>';
             }else{
              echo '
              <tr> <td>&nbsp;</td>';
             }
             echo '
               <td><button type="button" class="btn btn-block btn-info"><a href="index.php?action=rsn&idb='. $numren.'&sv='.$sv.'&nrep='. $nrep.'&ts=ED&idc='. $idc.'&sec='. $sec.'">Resultados</a></button> </td>';
               
               if ($gpous=="adm") {
                   echo '
                  <td><button type="button" class="btn btn-block btn-info"><a href="index.php?action=rsn&idb='. $numren.'&sv='.$sv.'&nrep='. $nrep.'&ts=ED&idc='. $idc.'&sec='. $sec.'"><i class="fa fa-trash-o"></i></a></button> </td>'; 
               
                } else {
                     if ($estatus==1 or $estatus==2){
                         echo '
                  <td><button type="button" class="btn btn-block btn-info"><a href="index.php?action=rsn&idb='. $numren.'&sv='.$sv.'&nrep='. $nrep.'&ts=ED&idc='. $idc.'&sec='. $sec.'"><i class="fa fa-trash-o"></i></a></button> </td>'; 
                      } else {
                        echo '<td >&nbsp;</td>';
                      }
                }
                echo '</tr>';
              $i++;
          //}  // foreach

          echo '<tr>  <td > &nbsp;</td> <td > &nbsp;</td>';
          echo '  </table>



        <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
        <!-- /.box-tools -->
      </div>
        <!-- /.box-header -->
          <div class="box-body no-padding">
              
           </div>
          </div>
          <!-- /.box -->
        </div>
                <!----- Finaliza contenido ----->
      <!-- /.content -->';

    }  // for each
  } // fin de la funcion


 public function nuevaTomaMuestraRep(){
 #lee varia{ble
    $sv=$_GET["sv"];
    $sec=$_GET["sec"];
    $nrep=$_GET["nrep"];
    $pv=$_GET["pv"];
    $idc=$_GET["idc"];

    echo ' <section class="content container-fluid">

    <div class="row">
    
    <div class="col-md-12">
    <div class="box box-info">
    <div class="box-body">
    <form role="form"  method="post">';
   
    echo '<input type="hidden" name="sec" value="'.$sec.'">';
    echo '<input type="hidden" name="sv" value="'.$sv.'">';
    echo '<input type="hidden" name="nrep" value="'.$nrep.'">';
    echo '<input type="hidden" name="pv" value="'.$pv.'">';
    echo '<input type="hidden" name="idc" value="'.$idc.'">';

    echo '<div class="form-group col-md-6">
          <label>Unidades para analisis Fisicoquimico : </label>
          <input type="text" class="form-control" name="unidadFQ">
        </div>';

    echo '<div class="form-group col-md-6">
          <label>Capacidad en ml para analisis Fisicoquimico : </label>
          <input type="text" class="form-control" name="capacidadFQ">
        </div>';

    echo '<div class="form-group col-md-6">
          <label>Unidades para analisis Microbiológico : </label>
          <input type="text" class="form-control" name="unidadMB">
        </div>';

    echo '<div class="form-group col-md-6">
          <label>Capacidad en ml para analisis Microbiológico : </label>
          <input type="text" class="form-control" name="capacidadMB">
        </div>';
        
     echo '<div class="form-group col-md-6">
          <label>Origen de la Muestra : </label>

          <select class="form-control" name="origenmues"></div>';
         #busca catalogo
          $numcat=21;
          $respcat=DatosCatalogo::listaCatalogo($numcat, "ca_catalogosdetalle");
      echo '<option value="">--- Seleccione opcion ---</option>';

         foreach ($respcat as $key => $itemc) {
         echo '<option value="'.$itemc["cad_idopcion"].'">'.$itemc["cad_descripcionesp"].'</option>';
         }
        echo '   </select>
         </div>';
         
        $numcat=45;
     echo '<div class="form-group col-md-6">
          <label>Fuente de Abastecimiento : </label>

          <select class="form-control" name="fuenteabas"></div>';
         #busca catalogo
          $respcat=DatosCatalogo::listaCatalogo($numcat, "ca_catalogosdetalle");
      echo '<option value="">--- Seleccione opcion ---</option>';

         foreach ($respcat as $key => $itemc) {
         echo '<option value="'.$itemc["cad_idopcion"].'">'.$itemc["cad_descripcionesp"].'</option>';
         }
        echo '   </select>
         </div>';

              $registro = New muestrasController();
              $registro-> insertaTomaMuestraRep();
             
          echo '
        <div class="row">
    
    <div class="col-md-12">
    
         <button class="btn btn-default pull-right" style="margin-right: 10px"><a href="index.php?action=rsn&nrep='.$nrep.'&ts=TM&idc='.$idc.'&pv='.$pv.'&sv='.$sv.'&sec='.$sec.'"> Cancelar </a></button>
         <button type="submit" class="btn btn-info pull-right">Guardar</button>  
        </div>

        </div>

        </form>
         </div> </div> </div> </div>

         ';
  }

  public function insertaTomaMuestraRep(){
   if(isset($_POST["unidadFQ"])){

       foreach($_POST as $nombre_campo => $valor){
          $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
            eval($asignacion);
          // echo ($asignacion);         
       }
       $datini=SubnivelController::obtienedato($sec,1);
       $londat=SubnivelController::obtienelon($sec,1);
       $nsec=substr($sec,$datini,$londat);
      
       $datini=SubnivelController::obtienedato($sec,2);
       $londat=SubnivelController::obtienelon($sec,2);
       $nreac=substr($sec,$datini,$londat);
      
       $datini=SubnivelController::obtienedato($sec,3);
       $londat=SubnivelController::obtienelon($sec,3);
       $numcom=substr($sec,$datini,$londat);
      
       $datini=SubnivelController::obtienedato($sec,4);
       $londat=SubnivelController::obtienelon($sec,4);
       $numcar1=substr($sec,$datini,$londat);
      
       $datini=SubnivelController::obtienedato($sec,5);
       $londat=SubnivelController::obtienelon($sec,5);
       $numcom2=substr($sec,$datini,$londat);
      

       $muestras=DatosMuestra::buscaUltimaMuestra("aa_muestras");
    //var_dump($ulnummues);

       $nummuestra=$muestras["ulnummues"];
       $nummuestra++;
       $fecvis=date("Y-m-d H:i:s");
      //echo $numcom;

      #busca si hay registros en proceso
       $regproceso=DatosMuestra::muestraEnProceso($sv, $nrep, $numcom, 4, $origenmues, "aa_muestras");
      //muestraEnProceso( $tabla)
      //var_dump($regproceso); 
      if (($regproceso>=1)){  
         print("<script language='javascript'>alert('No es posible agregar una nueva muestra para este origen. Existe un analisis pendiente'); </script>");
      
         echo "<script type='text/javascript'>
          window.location.href='index.php?action=rsn&sec=".$sec."&ts=TM&sv=".$sv."&idc=".$idc."&pv=".$pv."&nrep=".$nrep."';
          </script>
          ";
      }  else {
          #determina numero de toma
          $numtoma=DatosMuestra::determinaNumToma($sv, $nrep, $numcom, 6, $origenmues, "aa_muestras");
          if (isset($numtoma)){
              if ($numtoma["totmuestras"]>0){ //si existe en la base, no se puede registrar una nueva muestra
                 $numtoma=2;     
              }else{   
                 $numtoma=1;
              }
          } else {
            $numtoma=1;
          }          
            # inserta muestra
          #prepara informacion
          $datosController= array("nser"=>$sv,
                 "nummues"=>$nummuestra,
                 "estatus"=>1,
                 "numcom"=>$numcom,
                 "unidadFQ"=>$unidadFQ,
                 "capacidadFQ"=>$capacidadFQ,
                 "origenmues"=>$origenmues,
                 "numtoma"=>$numtoma,
                 "fecvis"=>$fecvis,
                 "numrep"=>$nrep,
                 "unidadMB"=>$unidadMB,
                 "capacidadMB"=>$capacidadMB,
                 "fuenteab"=>$fuenteabas,
                ); 
          $numtoma=DatosMuestra::insertaToma($datosController, "aa_muestras");
          $resant=DatosMuestra::buscaResAntMuestra($sv, $nsec, $nummuestra, "ins_detalleestandar");
          //var_dump($resant);
          if (isset($resant["claveren"])){
              print("<script language='javascript'>alert('No es posible guardar. Los resultados para esta muestra ya existen'); </script>");
          } else {
           
           #calcula renglon
            $ulren=DatosMuestra::calculaRenglon($sv, $nsec, $nrep, "ins_detalleestandar");
            if ($ulren){
              $numren=$ulren["claveren"];
            } else {
              $numren=0;
            }  
            $numren+=1;    
            if ($numren>1){
               while ($numren>1){
                  $numrenant= $numren-1;
                  $datosController= array("numren"=>$numren,
                 "numrep"=>$nrep,
                 "nserv"=>$sv,
                 "nsec"=>$nsec,
                 "numcom"=>$numcom,
                 "numrenant"=>$numrenant,
                  );
                  $ulren=DatosMuestra::actualizarenglones($datosController, $tabla);
                  $numren=$numrenant;
               } //while
            } // if
            $idser=$sv;
            $pond=0;
            $aceptado=-1;
            $numcar2=14;

            $datosController= array("nserv"=>$sv,      
                                 "numrep"=>$nrep,
                                 "nsec"=>$nsec,
                                 "nreac"=>$nreac,
                                 "numcom"=>$numcom,
                                 "ncar1"=>$numcar1,
                                 "ncom2"=>$numcom2,
                                 "numcar2"=>$numcar2,
                                 "valreal"=>$origenmues,
                                 "numren"=>$numren,
                                 "pond"=>$pond,
                                 "aceptado"=>$aceptado,
                                 "colarc"=>1,
                                 "nummues"=>$nummuestra,
                                  );
          $respuesta=DatosMuestra::insertaReactivoMuestra($datosController, "ins_detalleestandar");
            $numcar2=21;
            $datosController= array("nserv"=>$sv,      
                                 "numrep"=>$nrep,
                                 "nsec"=>$nsec,
                                 "nreac"=>$nreac,
                                 "numcom"=>$numcom,
                                 "ncar1"=>$numcar1,
                                 "ncom2"=>$numcom2,
                                 "numcar2"=>$numcar2,
                                 "valreal"=>$fuenteabas,
                                 "numren"=>$numren,
                                 "pond"=>$pond,
                                 "aceptado"=>$aceptado,
                                 "colarc"=>1,
                                 "nummues"=>$nummuestra,
                                  );
          $respuesta=DatosMuestra::insertaReactivoMuestra($datosController, "ins_detalleestandar");

         echo "<script type='text/javascript'>
        window.location.href='index.php?action=rsn&sec=".$sec."&ts=TM&sv=".$sv."&idc=".$idc."&pv=".$pv."&nrep=".$nrep."'
        </script>
        ";


          } // if resultados ya existem 


       } // if regproceso
    }  // fin del if
  }  // fin de la funcion



}
?>