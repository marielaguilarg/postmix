<?php

include "Controllers/indpostmix/consultaSeccionesController.php";

include ( '../Models/crud_comentDetalle.php');



class ConsultaPonderadoController
{
    
    private $nombreuni;
    private $nombreSeccion;
    private $titulo;
    private $listaPonderados;
    private $nivelCumplimiento;

    
    public function vistaPonderado(){
      
        
        include "Utilerias/leevar.php";
        
      
        $Id = $Op;
        
        $tache = "<img src='img/tache.png' width='20' height='20' border='0' alt='no cumple'>";
        $paloma= "<i class=\"fa-check-square-o\"></i>" ;
      //  $paloma = "<img src='img/palomita.png' width='20' height='20' border='0' alt='cumple'>";
        
        
        $datini = SubnivelController::obtienedato($Id, 1);
        $londat = SubnivelController::obtienelon($Id, 1);
        $idclient = substr($Id, $datini, $londat);
        
        
        $datini = SubnivelController::obtienedato($Id, 2);
        $londat = SubnivelController::obtienelon($Id, 2);
        $idser = substr($Id, $datini, $londat);
        
        
        $datini = SubnivelController::obtienedato($Id, 3);
        $londat = SubnivelController::obtienelon($Id, 3);
        $idreporte = substr($Id, $datini, $londat);
        
        
        $datini = SubnivelController::obtienedato($Id, 4);
        $londat = SubnivelController::obtienelon($Id, 4);
        $idclavecuenta = substr($Id, $datini, $londat);
        
        
        $datini = SubnivelController::obtienedato($Id, 5);
        $londat = SubnivelController::obtienelon($Id, 5);
        $idnumseccion = substr($Id, $datini, $londat);
       
        
        $datini = SubnivelController::obtienedato($Id, 6);
        $londat = SubnivelController::obtienelon($Id, 6);
        $idclaveuninegocio = substr($Id, $datini, $londat);
     
        $nomuni =ConsultaSeccionesController::nombreUnegocio($idclaveuninegocio);
 
        
        /* Crea nombre de seccion */
       
        //echo $ssql;
        $nomsec= DatosSeccion::descripcionSeccionIdioma($idnumseccion,$idser,$_SESSION["idiomaus"]);
       
        $this->nombreuni=$nomuni;
      
     
        //verifica si los reactivos ya existen
        /* crea reactivos */
        $sumapond = 0;
        $sumanoap = 0;
        $ssql = "SELECT *
           FROM cue_reactivos
                  WHERE sec_numseccion = :idnumseccion 
                    AND ser_claveservicio= :servicio
                        AND r_numreactivo<>0;";
        
        $rs = Conexion::ejecutarQuery($ssql, array("idnumseccion"=>$idnumseccion,"servicio"=>$idser));
        $numRows = sizeof($rs);
       
        $cont = 0;
        foreach ($rs as $row) {
            if ($cont % 2 == 0) {
                $color = "subtitulo31";
            } else {  //class="subtitulo31"
                $color = "subtitulo3";
            }
            
            $datosController= array("sec"=>$idnumseccion,
                "ser"=>$idser,
                "nrep"=>$idreporte,
                "nreac"=>$row["r_numreactivo"],
            );
           
            $rse = DatosPond::leeDatosPonderaModel($datosController,"ins_detalle");
            
        $numRows =sizeof($rse);
            if ($numRows != 0) { // existe en la base
                foreach ($rse as $rowe) {
                    if ($rowe["id_aceptado"]) {
                     //   $valant = "checked";
                       // $valant2=$paloma;
                        $valant2=T_("ACEPTADO");
                        //$sumapond++;
                    } else {
                       // $valant = "";
                        $valant2=T_("NO ACEPTADO");
                    }
                    if ($rowe["id_noaplica"]) {
                        $valnoap = "checked";
                        $valant2=T_("NO APLICA");
                    } else {
                        $valnoap = "";
                    }
                  //  $valcom = $rowe["id_comentario"];
                    $pondcta = $rowe["id_ponderacionreal"];
                }
            } else {
               // $valant = "";
              //  $valcom = "";
                $valant2="";
            }
            $resultado=array();
            //$sumapond=$sumapond+$pondcta;
            $resultado['numreac']= $row["r_numreactivo"] ;
            if($_SESSION["idiomaus"]==2)
                $resultado['descreac']=  $row["r_descripcioning"] ;
            else
                 $resultado['descreac']= $row["r_descripcionesp"] ;
                    //			$html->asignar('checkreac'," <td class='$color'><div align='center'>".
                    //								 		"<input type='checkbox' disabled='disabled' name='chk".$row["r_numreactivo"]."' ".$valant."></div></td>");
                    //			$html->asignar('checknoap'," <td class='$color'><div align='center'>".
                    //								 		"<input type='checkbox' disabled='disabled' name='noap".$row["r_numreactivo"]."' ".$valnoap."></div></td>");
                    $resultado['checkreac']= $valant2 ;
                    if ($valnoap == "checked") {
                        $sumanoap = $sumanoap + $pondcta;
                    } else {
                        $sumapond = $sumapond + $pondcta;
                    }
                    /*     * ******************************************************************************************* */
                    //busca comentarios en tabla correspondiente
                    
                    // $ssqlcom = "SELECT *
                    //		   				  FROM cue_reactivoscomentarios
                    //						 WHERE concat(sec_numseccion,'.',r_numreactivo) ='" . $idnumseccion . '.' . $row["r_numreactivo"] . "' 						   AND ser_claveservicio='" . $idser . "'";
                    //consulto para saber si se capturó algun comentario
               
                    
                    $rsc = DatosComentDetalle::consultaComentDetalle($idser,$idreporte, $idnumseccion . '.' . $row["r_numreactivo"] ,"ins_comentdetalle");
                    $num_reg = sizeof($rsc);
                    if ($num_reg != 0) {
//                         $resultado['comentario']= "<a class=\"btn  btn-sm btn-info\"  tabindex='0'  data-toggle=\"popover\" data-trigger=\"focus\" ".
//                         "title=\"Dismissible popover\" data-content=\"And here's some amazing content. It's very engaging. Right?\"  >" .T_("COMENTARIO"). "</a>";
                        $resultado['comentario']= "<a class=\"btn btn-block btn-sm btn-info\" href='index.php?action=indlistasecciones&tiposec=C&secc=" . $row["sec_numseccion"] . "." . $row["r_numreactivo"] . "&Op=" . $Id . "'  >" .T_("COMENTARIO"). "</a>";
// '<div class="collapse" id="collapseExample">
//   <div class="card card-body">
//     Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
//   </div>
// </div>';
                        
                        //href='index.php?action=indlistasecciones&tiposec=C&secc=" . $row["sec_numseccion"] . "." . $row["r_numreactivo"] . "&Op=" . $Id . "'
                    } else {
                        $resultado['comentario']="<a class=\"btn btn-block  btn-sm btn-info\" disabled><span style=\"font-size: 12px\">" .T_("COMENTARIO"). "</span></a>";
                      //  $resultado['comentario']="";
                    }
                    /*     * ************************************************************************************************ */
                     $resultado['detareac']= "<a class=\"btn btn-block btn-sm btn-info\" disabled>".T_("DETALLE")."</a>";
                  //  $resultado['detareac']="";
                    if ($row["r_tiporeactivo"] != "") {
                    //    echo "<br>****".$row["r_tiporeactivo"]."--". $row["r_numreactivo"] ;
                        if($this->buscaReactivos($row["r_tiporeactivo"], $idser, $idnumseccion, $row["r_numreactivo"])>0)
                            $resultado['detareac']=  "<a class=\"btn btn-block btn-sm btn-info\" href='index.php?action=indlistasecciones&tiposec=" . $row["r_tiporeactivo"] . "&secc=" . $row["sec_numseccion"] . "." . $row["r_numreactivo"] . "&Op=" . $Id . "'>".T_("DETALLE")."</a>";
//                             $resultado['detareac']=  "<a class=\"btn  btn-info\" href='index.php?action=indlistasecciones&tiposec=" . $row["r_tiporeactivo"] . "&secc=" . $row["sec_numseccion"] . "." . $row["r_numreactivo"] . "&Op=" . $Id . "'>".
//                         "<i class=\"fa fa-plus\"></i></a>";
                            
                    }
                    
                    // verifica si hay imagenes y crea la liga
                  
                  
                    $rs1=DatosImagenDetalle::consultaImagenDetalle($idser,$idreporte,$idnumseccion,$row["r_numreactivo"],"ins_imagendetalle");
                    
                    //            if (mysql_num_rows($rs1) > 0) {
                   
                    if(sizeof($rs1)>0) {
                        
                       $imagenes="<a  class=\"btn btn-block btn-info\" data-trigger=\"gallery_".$row["r_numreactivo"]."\"  href='index.php?action=indlistasecciones&tiposec=img&secc=".$idser.".".
                        $idnumseccion .".".$row["r_numreactivo"]."&numrep=".$idreporte."'>".
                        "<i class=\"fa fa-image\"></i></a>";
                        foreach($rs1 as $row_max) {
                            $rutaFoto="fotografias/".$row_max["id_ruta"];
                            /* $html->asignar('imagen',"<td  class='$color' ><div align='center'>".
                             "<a href='../fotografias/".$rutaFoto."' class='lytebox'   data-lyte-options='group:seccion".$cont."'>".
                             "<img src='../img/agregar.gif' width='27' height='21' border='0'></a></div>");*/
                         
                             $imagenes.='<a href="'.$rutaFoto.'" data-fancybox="gallery_'.$row["r_numreactivo"].'"  style="display:none;">
                              foto
                                </a>';
                        }
                        $resultado['imagen']=$imagenes;
                        /* while($row_max = mysql_fetch_array($rs1)) {
                        
                        $rutaFoto=$row_max["id_ruta"];
                        
                        $href.='<a href="../fotografias/'.$rutaFoto.'" class="lytebox"   data-lyte-options="group:seccion'.$cont.'" >
                        <img  src="../fotografias/'.$rutaFoto.'" width="120" height="120" alt="" /></a>';
                        }
                        $html->asignar('divImg',$divImg.$href."</div>");*/
                    }
                    else    // $resultado['imagen']=  "&nbsp;";
                     $resultado['imagen']=  "<a  class=\"btn btn-block btn-info\" disabled>".
                         "<i class=\"fa fa-image\"></i></a>";
                    $this->listaPonderados[]=$resultado;
                    $cont++;
        }
        $sumacien = 100 - $sumanoap;
        $nivelacep = round(($sumapond * 100) / $sumacien);
        $this->nivelCumplimiento= $nivelacep;
        
       
        if (isset($prin))
        { if($prin==1)//ayuda a definir de que pagina vengo y a cual regresar
        {
            $blista = 0;
            $this->prin=$prin;
        }
        }
        else //vengo de la lista
        {
            $blista = 1;
            
        }
        $this->titulo=(T_("NO. DE REPORTE")) . " : " . $idreporte;
        $this->nombreSeccion=$idnumseccion.". ".$nomsec;
        
        //$navegacion='<li><a href="MENindprincipal.php?op=mindi" style="z-index:9;">'.T_("GRAFICA").'</a></li>';
        //If($_SESSION["fbuscapv"]==1)
        //     $navegacion.='<li><a href="MENindprincipal.php?admin=buspv" style="z-index:8;">'.T_("BUSCAR PUNTO DE VENTA").'</a></li>';
        //  else
            //      $navegacion.='<li><a href="MENindprincipal.php?op=mindi&admin=cons&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&ref='.$_SESSION["fref"].'&niv='.$_SESSION["fniv"].'" style="z-index:8;">'.T_("INDICADORES").'</a></li>';
            //  $navegacion.=' <li><a href="MENindprincipal.php?op=mindi&admin=datos&numrep='.$idreporte.'&cser=1&ccli=100" style="z-index:6;">'.$nomuni.'</a></li>
            // <li><a href="MENindprincipal.php?op=mindi&admin=seccion&numrep='.$idreporte.'&referencia=100.1.'.$idclavecuenta.'.'.$idclaveuninegocio.'" style="z-index:5;">'.T_("SECCIONES").'</a></li>
            // <li><a href="#" style="z-index:4;">'.T_("SUBSECCION").'</a></li>';
            // //<li><a href="#" style="z-index:4;">'.$idnumseccion.". ".$nomsec.'</a></li>';
            // $html->asignar('NAVEGACION',$navegacion);
        Navegacion::borrarRutaActual("e");
        $rutaact = $_SERVER['REQUEST_URI'];
      
        Navegacion::agregarRuta("e", $rutaact, T_("DETALLE"));
     
        
    }
      
        function buscaReactivos($tipoReac,$servicio,$seccion,$reactivo) {
            
            switch($tipoReac) {
                case 'A':$rse=DatosAbierta::getReactivoAbiertoxReactivo($servicio,$seccion.".".$reactivo,"cue_reactivosabiertos");
                break;
                case 'E':$rse=DatosEst::getReactivoEstandarn1($servicio, $seccion . '.' . $reactivo,"cue_reactivosestandar");
                break;
                
                
                
            }
            
            $numRows = sizeof($rse);
            return $numRows;
    }
        /**
         * @return  $nombreuni
         */
        public function getNombreuni()
        {
            return $this->nombreuni;
        }
    
        /**
         * @return  $nombreSeccion
         */
        public function getNombreSeccion()
        {
            return $this->nombreSeccion;
        }
    
        /**
         * @return  $titulo
         */
        public function getTitulo()
        {
            return $this->titulo;
        }
    
        /**
         * @return  $listaPonderados
         */
        public function getListaPonderados()
        {
            return $this->listaPonderados;
        }
    
        /**
         * @return  $nivelCumplimiento
         */
        public function getNivelCumplimiento()
        {
            return $this->nivelCumplimiento;
        }
    

    
    }