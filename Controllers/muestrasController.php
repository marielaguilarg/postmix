<?php

class muestrasController{
	private $TITULO;
	private $listamuestras;
	private $pages;
	
  public function listaMuestrasPendientes(){
        $gpo = UsuarioController::Obten_grupo();
    
    $idusuario=UsuarioController::Obten_Usuario();
    
    $usuario =UsuarioModel::getUsuarioId($idusuario,"cnfg_usuarios");
        #presrenta datos de unegocio
 

    $tipocons = $usuario["cus_tipoconsulta"];
   
    if ($gpo=="lab") {
        $respuesta = DatosMuestra::vistaMuestrasLab(4, $tipocons, $tabla);
     
    } else {     
        $respuesta = DatosMuestra::vistaMuestras(4, $tabla);
     
    }
    $i=1;
    $bac=1;
    // despliega datos
      foreach($respuesta as $row => $item){
      	if(($i-1)%2==0){
      		echo '<div class="row">';
      		$bac=0;
      	}
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
                        <li>SERVICIO : <strong>'. $item["ser_descripcionesp"].'</strong></li>
                        </ul>
                    </div>
                  </div>
            </div>           

            <div class="row col-sm-12">
                 <div class="arrow">
                      <div class="box-footer no-padding">
                      
                        <ul class="nav nav-stacked">
                        <li>PUNTO DE VENTA : <strong>'. $item["une_descripcion"].'</strong></li>
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
                        <li>LABORATORIO : <strong>'. $catnombre.'</strong></li>
                        </ul>
                    </div>
                  </div>
            </div>

                   <div class="row col-sm-12  ">
    <div class="box-footer no-padding">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                   
  <ul class="nav nav-stacked">
                       ANALISIS <br>FISICOQUIMICO :
</ul>
                     
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
</div>
                    <div class="col-sm-4 border-right">
                      <div class="description-block">';
                  
                  if ($item["mue_estatusFQ"]==1) {
                      echo '
                    <button type="button" class="btn btn-block btn-info" style="font-size: 12px" onclick="javascript:imprimirFQ('.$item["mue_idmuestra"].');"> IMPRIMIR </button>';
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
                          <button type="button" class="btn btn-block btn-info"
 style="font-size: 12px" onclick="detalle(\'FQ\',\''.$item["mue_idmuestra"].'\')"> Detalle </button>';
                      }    
                      echo '    
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div> 
</div>
                  <div class="row col-sm-12 ">
  <div class="box-footer no-padding">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                     
                       ANALISIS<br> MICROBIOLOGICO :

                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">';
                      if ($item["mue_estatusMB"]==1) { 
                        echo '
                    <button type="button" class="btn btn-block btn-info" style="font-size: 12px" onclick="javascript:imprimirMB('.$item["mue_idmuestra"].');"> IMPRIMIR </button>';
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
                          <button type="button" class="btn btn-block btn-info" style="font-size: 12px" 
onclick="detalle(\'MB\','.$item["mue_idmuestra"].')"> Detalle </button>';
                      }
                      echo '    
  </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div> 
</div>

                       </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
           
          </div>';
                 

                      if(($i)%2==0){
                      	
                      	echo '</div>';
                      	$bac=1;
                      }
                      $i++;
      } //fin foreach
      if($bac==0)
      	echo '</div>';
      	
      Navegacion::iniciar();
      Navegacion:: borrarRutaActual("a");
      $rutaact = $_SERVER['REQUEST_URI'];
      // echo $rutaact;
      Navegacion::agregarRuta("a", $rutaact, T_("MUESTRAS POR ANALIZAR"));
   } 

   
   public function listaMuestrasRealizadas(){
   	include "Utilerias/leevar.php";
   	$gpo = UsuarioController::Obten_grupo();
   	
   	$idusuario=UsuarioController::Obten_Usuario();
   
  
   
   	if ($gpo=="lab") {
   		//busca laboratorio
   		$usuario =UsuarioModel::getUsuarioId($idusuario,"cnfg_usuarios");
   		#presrenta datos de unegocio
   		//var_dump($usuario);
   		
   		$tipocons = $usuario["cus_tipoconsulta"];
   		// busca descripcion de laboratorio
   		$numcat=43;
   		$this->TITULO=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle", $numcat, $tipocons);
   		
   		$ssql="SELECT mue_numreporte, mue_nomanalistaFQ, mue_fechoranalisisFQ,mue_nomanalistaMB,mue_fechoranalisisMB, 
rm_embotelladora,mue_idmuestra,une_num_unico_distintivo,une_descripcion,une_idpepsi,ser_descripcionesp, cad_descripcionesp FROM (SELECT aa_muestras.mue_numreporte, 
aa_muestras.mue_nomanalistaFQ,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_nomanalistaMB, aa_muestras.mue_fechoranalisisMB,
aa_recepcionmuestra.rm_embotelladora,aa_muestras.mue_idmuestra,cad_descripcionesp FROM aa_muestras
INNER JOIN aa_recepcionmuestradetalle ON aa_recepcionmuestradetalle.mue_idmuestra = aa_muestras.mue_idmuestra
INNER JOIN aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
LEFT JOIN `ca_catalogosdetalle` ON `cad_idcatalogo`=43 AND `cad_idopcion`=rm_embotelladora
 WHERE aa_muestras.mue_estatusmuestra = '5'  AND
aa_recepcionmuestra.rm_embotelladora =  :tipocons
 GROUP BY aa_muestras.mue_idmuestra) AS A LEFT JOIN (SELECT ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_claveservicio,
ins_detalleestandar.ide_numreporte,une_num_unico_distintivo, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreactivo,
ins_detalleestandar.ide_numcomponente, ca_unegocios.une_descripcion, ca_unegocios.une_idpepsi,
ca_servicios.ser_descripcionesp FROM ins_detalleestandar INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio 
AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
INNER JOIN ca_unegocios ON ins_generales.`i_unenumpunto` = ca_unegocios.une_id
INNER JOIN ca_servicios ON `ins_generales`.`i_claveservicio` = ca_servicios.ser_id
 GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_idmuestra)
AS B ON A.mue_idmuestra=B.ide_idmuestra  AND B.ide_claveservicio=A.mue_claveservicio";
   		$parametros=array("tipocons"=>$tipocons);
   		if($fil_ptoventa!="")
   		{	$ssql.=" where une_descripcion like :fil_ptoventa ";
   		
   		$parametros=array("tipocons"=>$tipocons,"fil_ptoventa"=>"%".$fil_ptoventa."%");
   		}
   		
$ssql.=" ORDER BY A.mue_idmuestra ";

   		
   	} else {
   		$ssql="SELECT 
  mue_numreporte,
  mue_nomanalistaFQ,
  mue_fechoranalisisFQ,
  mue_nomanalistaMB,
  mue_fechoranalisisMB,
  rm_embotelladora,
  mue_idmuestra,
  une_descripcion,
  une_num_unico_distintivo,
  une_idpepsi,
  ser_descripcionesp,
  cad_descripcionesp 
FROM
  (SELECT 
    aa_muestras.mue_numreporte,
    aa_muestras.mue_nomanalistaFQ,
    aa_muestras.mue_fechoranalisisFQ,
    aa_muestras.mue_nomanalistaMB,
    aa_muestras.mue_fechoranalisisMB,
    aa_recepcionmuestra.rm_embotelladora,
    cad_descripcionesp,
    aa_muestras.mue_idmuestra ,aa_muestras.`mue_claveservicio`
  FROM
    aa_muestras 
    INNER JOIN aa_recepcionmuestradetalle 
      ON aa_recepcionmuestradetalle.mue_idmuestra = aa_muestras.mue_idmuestra 
    INNER JOIN aa_recepcionmuestra 
      ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra 
    LEFT JOIN `ca_catalogosdetalle` 
      ON `cad_idcatalogo` = 43 
      AND `cad_idopcion` = rm_embotelladora 
  WHERE aa_muestras.mue_estatusmuestra = '5' 
  GROUP BY aa_muestras.mue_idmuestra) AS A 
  LEFT JOIN 
    (SELECT 
      ins_detalleestandar.ide_idmuestra,
      ins_detalleestandar.ide_claveservicio,
      ins_detalleestandar.ide_numreporte,
      ins_detalleestandar.ide_numseccion,
      ins_detalleestandar.ide_numreactivo,
      ins_detalleestandar.ide_numcomponente,
      une_num_unico_distintivo,
      ca_unegocios.une_descripcion,
      ca_unegocios.une_idpepsi,
      ca_servicios.ser_descripcionesp 
    FROM
      ins_detalleestandar 
      INNER JOIN ins_generales 
        ON ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte AND `ide_claveservicio`=`i_claveservicio` 
      INNER JOIN ca_unegocios 
        ON ins_generales.`i_unenumpunto` = ca_unegocios.une_id 
      INNER JOIN ca_servicios 
        ON `ins_generales`.`i_claveservicio` = ca_servicios.ser_id 
    GROUP BY ins_detalleestandar.ide_claveservicio,
      ins_detalleestandar.ide_numreporte,
      ins_detalleestandar.ide_idmuestra) AS B 
    ON A.mue_idmuestra = B.ide_idmuestra AND B.ide_claveservicio=A.mue_claveservicio";
   		if($fil_ptoventa!="")
   		{	$ssql.=" where  une_descripcion like :fil_ptoventa ";
   		$parametros=array("fil_ptoventa"=>"%".$fil_ptoventa."%");
   		}
$ssql.=" ORDER BY A.mue_idmuestra DESC ";

   	}
   	
   	$this->listamuestras=Conexion::ejecutarQuery($ssql,$parametros);
//    	if(sizeof($this->listamuestras)>10){
//    	$this->pages = new Paginator(sizeof($this->listamuestras), 9, array(
//    			10,
//    			25,
//    			50,
//    			100,
//    			250,
//    			'All'
//    	));
//    	if ($gpo=="lab") {
//    	  		$ssql="SELECT mue_numreporte, mue_nomanalistaFQ, mue_fechoranalisisFQ,mue_nomanalistaMB,mue_fechoranalisisMB,
// rm_embotelladora,mue_idmuestra,une_descripcion,une_idpepsi,ser_descripcionesp, cad_descripcionesp FROM (SELECT aa_muestras.mue_numreporte,
// aa_muestras.mue_nomanalistaFQ,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_nomanalistaMB, aa_muestras.mue_fechoranalisisMB,
// aa_recepcionmuestra.rm_embotelladora,aa_muestras.mue_idmuestra,cad_descripcionesp FROM aa_muestras
// INNER JOIN aa_recepcionmuestradetalle ON aa_recepcionmuestradetalle.mue_idmuestra = aa_muestras.mue_idmuestra
// INNER JOIN aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
// LEFT JOIN `ca_catalogosdetalle` ON `cad_idcatalogo`=43 AND `cad_idopcion`=rm_embotelladora
//  WHERE aa_muestras.mue_estatusmuestra = '5'  AND
// aa_recepcionmuestra.rm_embotelladora =  :tipocons
//  GROUP BY aa_muestras.mue_idmuestra) AS A LEFT JOIN (SELECT ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_claveservicio,
// ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreactivo,
// ins_detalleestandar.ide_numcomponente, ca_unegocios.une_descripcion, ca_unegocios.une_idpepsi,
// ca_servicios.ser_descripcionesp FROM ins_detalleestandar INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio
// AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
// INNER JOIN ca_unegocios ON ins_generales.`i_unenumpunto` = ca_unegocios.une_id
// INNER JOIN ca_servicios ON `ins_generales`.`i_claveservicio` = ca_servicios.ser_id
//  GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_idmuestra)
// AS B ON A.mue_idmuestra=B.ide_idmuestra";
// if($fil_ptoventa!="")
//    			$ssql.=" where une_descripcion like :fil_ptoventa ";
// $ssql.=" ORDER BY A.mue_idmuestra limit ".$this->pages->limit_start.",".$this->pages->limit_end;
   	  		
// $parametros=array("tipocons"=>$tipocons,"fil_ptoventa"=>"%".$fil_ptoventa."%");
   		
//    	} else {
//    		$ssql="SELECT mue_numreporte, mue_nomanalistaFQ, mue_fechoranalisisFQ,mue_nomanalistaMB,mue_fechoranalisisMB, rm_embotelladora,
// mue_idmuestra,une_descripcion,une_idpepsi,ser_descripcionesp,cad_descripcionesp FROM
// (SELECT aa_muestras.mue_numreporte, aa_muestras.mue_nomanalistaFQ,
// aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_nomanalistaMB, aa_muestras.mue_fechoranalisisMB,
// aa_recepcionmuestra.rm_embotelladora,cad_descripcionesp,
// aa_muestras.mue_idmuestra FROM aa_muestras
// INNER JOIN aa_recepcionmuestradetalle ON aa_recepcionmuestradetalle.mue_idmuestra = aa_muestras.mue_idmuestra
// INNER JOIN aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
//  LEFT JOIN `ca_catalogosdetalle` ON `cad_idcatalogo`=43 AND `cad_idopcion`=rm_embotelladora
// WHERE aa_muestras.mue_estatusmuestra = '5' GROUP BY aa_muestras.mue_idmuestra) AS A LEFT JOIN (
// SELECT ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_claveservicio,
// ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreactivo,
// ins_detalleestandar.ide_numcomponente, ca_unegocios.une_descripcion, ca_unegocios.une_idpepsi,
// ca_servicios.ser_descripcionesp FROM ins_detalleestandar
// INNER JOIN ins_generales ON  ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
// INNER JOIN ca_unegocios ON ins_generales.`i_unenumpunto` = ca_unegocios.une_id
// INNER JOIN ca_servicios ON `ins_generales`.`i_claveservicio` = ca_servicios.ser_id
//  GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_idmuestra)
// AS B ON A.mue_idmuestra=B.ide_idmuestra";
//    		if($fil_ptoventa!="")
//    		{	$ssql.=" where une_descripcion like :fil_ptoventa ";
//    		$parametros=array("fil_ptoventa"=>"%".$fil_ptoventa."%");}
// $ssql.=" ORDER BY A.mue_idmuestra DESC limit ".$this->pages->limit_start.",".$this->pages->limit_end;


//    	}
//    	$this->listamuestras=Conexion::ejecutarQuery($ssql,$parametros);
//    	}
   	Navegacion::iniciar();
   	Navegacion:: borrarRutaActual("a");
   	$rutaact = $_SERVER['REQUEST_URI'];
   	// echo $rutaact;
   	Navegacion::agregarRuta("a", $rutaact, T_("MUESTRAS ANALIZADAS"));
   
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
   
    
      echo '

<div class="row">
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
          //  $estatus=1;
          //     if ($estatus==1){
                 echo '
               <tr> <td>
<a class="btn btn-block btn-info"  href="imprimirReporte.php?admin=impetiq&tipoimp=zbr&ntoma='.$rownr["mue_idmuestra"]."&idserv=".$sv."&numrep=".$numrep.'">Imprimir zeb</a>
<a class="btn btn-block btn-info" href="javascript:return 0"
onclick="ajax_printz(\'imprimirReporte.php?admin=impetiq&tipoimp=zbr2&ntoma='.$rownr["mue_idmuestra"]."&idserv=".$sv."&numrep=".$numrep.'\',this)">Imprimir zeb2</a>
<a class="btn btn-block btn-info" href="javascript:return 0"
onclick="ajax_print(\'imprimirReporte.php?admin=impetiq&tipoimp=gen&ntoma='.$rownr["mue_idmuestra"]."&idserv=".$sv."&numrep=".$numrep.'\',this)">Imprimir</a></td>';
         //    }else{
           //   echo '
            //  <tr> <td>&nbsp;</td>';
             //}
             echo '
               <td><a class="btn btn-block btn-info" href="index.php?action=rsn&idb='. $numren.'&sv='.$sv.'&nrep='. $nrep.'&ts=ED&idc='. $idc.'&sec='. $sec.'&pv='.$pv.'">Resultados</a></td>';
               
               if ($gpous=="adm") {
                   echo '
                  <td><a class="btn btn-block btn-info" href="index.php?action=rsn&sec='.$sec.'&sv='.$sv.'&ts=ET&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'&mue='.$rownr["mue_idmuestra"].'"><i class="fa fa-trash-o"></i></a></td>'; 
               
                } else {
                     if ($estatus==1 or $estatus==2){
                         echo '
                  <td><a class="btn btn-block btn-info" href="index.php?action=rsn&sec='.$sec.'&sv='.$sv.'&ts=ET&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'&mue='.$rownr["mue_idmuestra"].'"><i class="fa fa-trash-o"></i></a> </td>'; 
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
    
         <a class="btn btn-default pull-right" style="margin-right: 10px" href="index.php?action=rsn&nrep='.$nrep.'&ts=TM&idc='.$idc.'&pv='.$pv.'&sv='.$sv.'&sec='.$sec.'"> Cancelar </a>
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
      

       date_default_timezone_set('America/Mexico_City');
       $fecvis=date("Y-m-d H:i:s");
      //echo $numcom;
       try{
      #busca si hay registros en proceso
      //reviso que ya exista el reporte
      $regs=DatosGenerales::validaExisteReporte($sv, $nrep, "ins_generales");
      if($regs<=0)
      {	// se debe guardar primero el reporte
      	print("<script language='javascript'>alert('Favor de capturar la INFORMACION GENERAL DEL ESTABLECIMIENTO antes de crear la muestra'); </script>");
      	return;
      }
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
          $nummuestra=DatosMuestra::insertaToma($datosController, "aa_muestras");
        
        
          if($nummuestra!="error"){
         	 $resant=DatosMuestra::buscaResAntMuestra($sv, $nsec, $nummuestra, "ins_detalleestandar");
         // var_dump($resant); die();
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
          
	          }
	         

          } // if resultados ya existem 
          else {
          	throw new Exception("Error al insertar");
          }

       } // if regproceso
       }catch(Exception $ex){
       	print("<script language='javascript'>alert('Hubo un error al guardar'); </script>");
       	
       }
    }  // fin del if
    
  }  // fin de la funcion

  public function imprimir(){
  	$error="";
  	include "Utilerias/leevar.php";
  
  	//despliega codigos
  	$sqleti="SELECT 
  aa_muestras.mue_idmuestra,
  aa_muestras.mue_tipomuestra,
  aa_muestras.mue_fechahora,
  aa_muestras.mue_numreporte,
  ins_generales.`i_unenumpunto`,
  aa_muestras.mue_numunidadesFQ,
  TIME(aa_muestras.mue_fechahora) AS hortom,
  aa_muestras.mue_numunidadesMB,
  ca_unegocios.une_descripcion,
  ca_unegocios.une_idpepsi , ca_unegocios.une_num_unico_distintivo
FROM
  aa_muestras 
  INNER JOIN ins_detalleestandar 
    ON (`aa_muestras`.`mue_claveservicio` = `ins_detalleestandar`.`ide_claveservicio`) 
AND (`aa_muestras`.`mue_idmuestra` = `ins_detalleestandar`.`ide_idmuestra`)
  INNER JOIN ins_generales 
    ON ins_generales.i_claveservicio = ins_detalleestandar.ide_claveservicio 
    AND ins_generales.i_numreporte = ins_detalleestandar.ide_numreporte 
  INNER JOIN ca_unegocios 
    ON ca_unegocios.une_id= ins_generales.`i_unenumpunto` 
WHERE aa_muestras.mue_idmuestra =:ntoma and mue_claveservicio=:servicio
GROUP BY ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte,
ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_idmuestra";
  
   
  	$rseti=Conexion::ejecutarQuery($sqleti,array("ntoma"=>$ntoma, "servicio"=>$idserv));
  
  	foreach($rseti as $valor ) {
  		$nmuesX=$valor["mue_idmuestra"];
  		$uninegX=$valor["une_descripcion"];
  		$cveunegX=$valor["une_idpepsi"];
  		$nud=$valor["une_num_unico_distintivo"];
  		$tipomueX=$valor["mue_tipomuestra"];
  		$fechorX=Utilerias::formato_fecha($valor["mue_fechahora"]);
  		$horX=$valor["hortom"];
  		$numrepX=$valor["mue_numreporte"];
  		$uniFQX=$valor["mue_numunidadesFQ"];
  		$uniMBX=$valor["mue_numunidadesMB"];
  		
  		$codgenX="FQ".$nmuesX;
  		
  		//obtiene desc tipo muestra
  		$sqltimu="SELECT ca_catalogosdetalle.cad_idcatalogo, ca_catalogosdetalle.cad_idopcion, ca_catalogosdetalle.cad_descripcionesp, ca_catalogosdetalle.cad_descripcioning FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '41' AND ca_catalogosdetalle.cad_idopcion =  '".$tipomueX."'";
  
  		$destmX=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle", 41, $tipomueX);
  		
  		$etiFQ==1;
  		//codigo para z
  		if($tipoimp=="zbr"||$tipoimp=="zbr2"){
  		while ($etiFQ<$uniFQX) {
  			$tipoan="FISICOQUIMICO";
  			
  			$texto="! 0 200 200 276 1
LABEL
CONTRAST 0
TONE 0
SPEED 2
PAGE-WIDTH 392
GAP-SENSE 15
T 7 0 20 1 NO. DE MUESTRA :
T 7 0 225 1 $nmuesX
T 7 0 20 25 $uninegX
T 7 0 20 50 NUD $nud
T 7 0 20 75 $destmX
T 7 0 184 75 $tipoan
B 128 2 0 40 16 100 $codgenX
T 7 0 20 150 $fechorX
T 7 0 170 150 $horX
SETFF 25.5.2
PRINT
";
  			$etiFQ++;
  			
  			$textofin=$textofin.$texto;
  			
  		}  // etiquetas para fisicoquimico
  		
  		// ETIQUETAS PARA MICROBIOLOGICO
  		$etiMB==1;
  		while ($etiMB<$uniMBX) {
  			$tipoan="MICROBIOLOGICO";
  			$codgenX="MB".$nmuesX;
  			
  			$texto="! 0 200 200 276 1
LABEL
CONTRAST 0
TONE 0
SPEED 2
PAGE-WIDTH 392
GAP-SENSE 15
T 7 0 20 1 NO. DE MUESTRA
T 7 0 225 1 $nmuesX
T 7 0 20 25 $uninegX
T 7 0 20 50 NUD $nud
T 7 0 20 75 $destmX
T 7 0 184 75 $tipoan
B 128 2 0 40 16 100 $codgenX
T 7 0 20 150 $fechorX
T 7 0 170 150 $horX
SETFF 25.5.2
PRINT
";
  			$etiMB++;
  			
  			$textofin=$textofin.$texto;
  		}  // etiquetas para MICROBIOLOGICO
  		$texto=$textofin;
  		}
  			
  		else{
  			$texto="";
  		}
  			while ($etiFQ<$uniFQX) {
  				$tipoan="FISICOQUIMICO";
  				
  			$texto.=$this->etiquetaESC($codgenX, $nmuesX, $uninegX, $nud, $destmX, $tipoan, $fechorX, $horX);
  			$etiFQ++;
  			}
  			$etiMB==1;
  			while ($etiMB<$uniMBX) {
  				$tipoan="MICROBIOLOGICO";
  				$codgenX="MB".$nmuesX;
  				$texto.=$this->etiquetaESC($codgenX, $nmuesX, $uninegX, $nud, $destmX, $tipoan, $fechorX, $horX);
  				$etiMB++;
  			}
  		
  		
  	}
  
   	if($tipoimp=="zbr"){
   		$base=getcwd();
   		
   		
   		//$base=substr($base, 0, strrpos($base,"\\"));
   		$nomarchivo=$base.DIRECTORY_SEPARATOR."Archivos".DIRECTORY_SEPARATOR."etiquetas".$nmuesX.".fmt";
   		
   		//$textofin=$textofin.$texto;
   		$archivo = fopen($nomarchivo,"w+");
   		
   		fwrite($archivo, $textofin);
   		fclose($archivo);
   		header("Content-type: application/octet-stream");
   		//   	header("Content-type: application/force-download");
   		// $f="calendario.ZIP";
   		header("Content-Disposition: attachment; filename=\"etiquetas".$nmuesX.".fmt\"");
   		readfile($nomarchivo);
   	}	
  	
  	// actualiza estatus
   	$sqlu="UPDATE aa_muestras SET
aa_muestras.mue_estatusmuestra=2
WHERE aa_muestras.mue_idmuestra='".$ntoma."'";
   	DatosMuestra::actualizarEstatus(2,$idserv,$ntoma);
  	if($tipoimp!="zbr"){
  		//redirecciono para imprimir
//   		echo '<script>
// function miajax_print(data){
  
//             var S = "#Intent;scheme=rawbt;";
//             var P =  "package=ru.a402d.rawbtprinter;end;";
//             window.location.href="intent:"+data+S+P;
      
//     return false;
// }
// miajax_print("base64,'.base64_encode($texto).'",this);
// </script>';

echo base64_encode($texto);

  	}
  
  }
  
  public function eliminarTomaMue(){
  	include "Utilerias/leevar.php";
  	switch($admin){
  		case "x": $this->borraMuestra();break;
  		default:
  	
  $numsec=$sec;
  $ntoma=$mue;
  	echo ' <section class="content container-fluid">
		<div class="row">
  			
		<div class="col-md-12">
  			
		<div class="box box-info">
		<div class="box-body">
		<form role="form"  method="post" action="index.php?action=rsn&admin=x&sec='.$numsec.'&sv='.$sv.'&ts=ET&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'&mue='.$ntoma.'">';
  	echo '<div class="form-group col-md-6">
				  <label>SELECCIONA LA CAUSA DE ELIMINACION</label>
 <div>No. de Muestra :'.$ntoma.'<input name="ntoma" type="hidden" value="'.$ntoma.'"></div>     
				<select name="causaid" id="causaid" class="form-group">';
  	#busca catalogo
  	$respcat=DatosCatalogo::listaCatalogo(44, "ca_catalogosdetalle");
  	echo '<option value="">--- Seleccione opcion ---</option>';
  	
  	foreach ($respcat as $key => $itemc) {
  		echo '<option value="'.$itemc["cad_idopcion"].'">'.$itemc["cad_descripcionesp"].'</option>';
  	}
  	echo '   </select>
			   </div>';
  	echo '
		 <input type="hidden" name="nsec" id="nsec" value="'.$numsec.'">
          	<div class="row">
		<div class="col-md-12">
				 <a class="btn btn-default pull-right" style="margin-right: 10px" href="index.php?action=rsn&sec='.$numsec.'&ts=TM&idc='.$idc.'&pv='.$pv.'&nrep='.$nrep.'&sv='.$sv.'"> Cancelar </a>
				 <button type="submit" class="btn btn-info pull-right">Guardar</button>
			  </div>
				 		
		</form>
			  </div>
			  </div>
			</div>
		</div>
	 </section>';
  	}
  }
  
  public function borraMuestra(){
  	include "Utilerias/leevar.php";
  	
  	try{
  	// ELIMINA INFORMACION DE RESULTADOS POR MUESTRA
  	$sqld="DELETE FROM ins_detalleestandar WHERE ins_detalleestandar.ide_idmuestra =  '$ntoma'";
  	DatosEst::eliminarEstandarMuestra($ntoma, "ins_detalleestandar");
  	
  	//actualiza estatus
  	$ssqle=("UPDATE aa_muestras SET aa_muestras.mue_estatusmuestra =6, aa_muestras.mue_causacan =$causaid WHERE aa_muestras.mue_idmuestra =  ".$ntoma);
  	DatosMuestra::actualizarCausa($causaid,$ntoma);
  	}catch(Exception $ex){
  		echo Utilerias::mensajeError($ex->getMessage());
  	}
  	echo "<script type='text/javascript'>
          window.location.href='index.php?action=rsn&sec=".$sec."&ts=TM&sv=".$sv."&idc=".$idc."&pv=".$pv."&nrep=".$nrep."';
          </script>
          ";
  	
  }
  
  function etiquetaESC($codgenX,$nmuesX,$uninegX,$cveunegX,$destmX,$tipoan,$fechorX,$horX){
  	
  	
  	
  	$texto="NO. DE MUESTRA:".$nmuesX."\n".
    	$uninegX."\n".
    	"NUD:". $cveunegX."\n".
    	$destmX." ".$tipoan."\n";
    	$texto.=$fechorX." ".$horX."\n";
    	
    	//aqui va el codigo
    	$texto .= "\x1d\x48\x00";
    	$texto .= "\x1d\x68\x40";   # GS w 4 alto
    	
    	
    	//$texto .= "\x1d\x6b\x49\x".substr($long,strlen($long)-2,strlen($long));# GS k 2
    	$texto.="\x1d\x77\x03";
    	$texto .= "\x1d\x6b\x49".chr(strlen($codgenX));# GS k 2
    	
    	$texto .= $codgenX."\x0A\x0A\x0A";  # [data] 00
    	
    	// 	$texto.=$fechorX." ".$horX;
    	
    	return $texto;
    	
  }
/**
	 * @return mixed
	 */
	public function getTITULO() {
		return $this->TITULO;
	}

/**
	 * @return array
	 */
	public function getListamuestras() {
		return $this->listamuestras;
	}
	/**
	 * @return mixed
	 */
	public function getPages() {
		return $this->pages;
	}




}
?>