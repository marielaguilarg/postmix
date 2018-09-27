<?php

include 'Controllers/indpostmix/consultaSeccionesController.php';
class ConsultaEstandarController
{
    
    private $nombreUnegocio;
    private $titulo;
    private $nombreSeccion;
    private $listaAtributos;
    private $listaEstandar;
    private $Sumapond;
    
    public function vistaListaEstandar(){
        include "Utilerias/leevar.php";
       
   
                
                
                $misec = $secc;
                if (isset($secc)) {
                    $aux = explode('.', $misec);
                    
                    $numreac = $aux[1];
                }
                
                if ($numreac) {
                    
                } else {
                    $numreac = 0;
                }
                if ($numcar) {
                    
                } else {
                    $numcar = 0;
                }
                if ($numcom2) {
                    $numcom2+=1;
                } else {
                    $numcom2 = 0;
                }
                
                
                $Id = $Op;
                //echo "Esto es una impresion";
                $datini = SubnivelController::obtienedato($Id, 1);
                $londat = SubnivelController::obtienelon($Id, 1);
                $idclient = substr($Id, $datini, $londat);
                
                
                $datini = SubnivelController::obtienedato($Id, 2);
                $londat = SubnivelController::obtienelon($Id, 2);
                $idser = substr($Id, $datini, $londat);
                
                
                $datini =SubnivelController::obtienedato($Id, 3);
                $londat = SubnivelController::obtienelon($Id, 3);
                $idreporte = substr($Id, $datini, $londat);
                
                
                $datini = SubnivelController::obtienedato($Id, 4);
                $londat = SubnivelController::obtienelon($Id, 4);
                $idclavecuenta = substr($Id, $datini, $londat);
                
                $datini = SubnivelController::obtienedato($Id, 5);
                $londat = SubnivelController::obtienelon($Id, 5);
                $idnumseccion = substr($Id, $datini, $londat);
                //echo $idnumseccion;
                
                $datini = SubnivelController::obtienedato($Id, 6);
                $londat = SubnivelController::obtienelon($Id, 6);
                $idclaveuninegocio = substr($Id, $datini, $londat);
                $nomuni=ConsultaSeccionesController::nombreUnegocio($idclaveuninegocio);
                $this->nombreUnegocio=$nomuni;
                
                /* Crea nombre de seccion */
                $rs =  DatosSeccion::editaSeccionModel($idnumseccion,$idser,"cue_secciones");
             
                   if($_SESSION["idiomaus"]==2)
                       $nomsec = $rs['sec_descripcioning'];
                   else
                       $nomsec = $rs['sec_descripcionesp'];
                   if ($numcom) {
                                
                    } else {   // no hay numcom, es decir es de un primer nivel
                        $tiposec = $rs['sec_tiposeccion'];
                     }
               
                // asigna numero de reporte
                $numrep = $idreporte;
                
               
                // busca desc reactivo
                if ($numreac != 0) {
                    //            $sqlpn = "SELECT left(r_descripcionesp,50) as descreactivo,left(r_descripcioning,50) as descreactivo_i
                    //	             FROM `cue_reactivos`
                    //				WHERE `cue_reactivos`.`ser_claveservicio` = " . $idser . "
                    //				  AND `cue_reactivos`.`sec_numseccion` =  " . $idnumseccion . "
                    //				  AND `cue_reactivos`.`r_numreactivo`=" . $numreac . ";";
                    //
                    //            $rspn = mysql_query($sqlpn);
                    //            while ($rowpn = mysql_fetch_array($rspn)) {
                    //                if($_SESSION["idiomaus"]==2)
                    //                    $nompn = $rowpn['descreactivo_i'];
                    //                else
                    //                     $nompn = $rowpn['descreactivo'];
                    //            }
                    $rowpn=DatosPond::editaPonderaModel($idnumseccion, $idser,$numreac,"cue_reactivos");
                    if($_SESSION["idiomaus"]==2)
                               $nompn = substr($rowpn['r_descripcioning'],0,50);
                           else
                                $nompn = substr($rowpn['r_descripcionesp'],0,50);
                    
                    $TITULO5=$idnumseccion.".".$numreac." ". $nompn;
               
                    $rscu=DatosEst::getReactivoEstandarn1($idser, $idnumseccion . '.' . $numreac,"cue_reactivosestandar");
                } else {
                 
                    if ($numcar == 0) {
                      
                        $TITULO5=$idnumseccion.". ".$nomsec;
                        
                        $secc = $idnumseccion . "." . $numreac . "." . $numcar . "." . $numcom2;
                        
//                         $sqlcu = "SELECT *
// 		             FROM `cue_reactivosestandar`
// 					WHERE `cue_reactivosestandar`.`ser_claveservicio` =  " . $idser . "
// 					  AND concat(sec_numseccion,'.',r_numreactivo,'.',re_numcaracteristica,'.',re_numcomponente2) =  '" . $secc . "';";
                        $rscu=DatosEst::getReactivoEstandarn2($idser, $secc,"cue_reactivosestandar");
                        
                    } else {
                        $seccom = $idnumseccion . "." . $numreac . "." . $numcom . "." . $numcar . "." . $numcom2;
                        $TITULO5=$idnumseccion.". ".$nomsec;
                        
                        $secc = $idnumseccion . "." . $numreac . "." . $numcom . "." . $numcar;
//                         $sqlcu = "SELECT *
// 		             FROM `cue_reactivosestandar`
// 					WHERE `cue_reactivosestandar`.`ser_claveservicio` = " . $idser . "
// 					  AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica) = '" . $secc . "';";
                        $rscu=DatosEst::getReactivoEstandarn3($idser, $secc,"cue_reactivosestandar");
                    }
                }
                
             
                $cont = 0;
            
                foreach ($rscu as $rowcu) {
                    if ($cont % 2 == 0) {
                        $color = "subtitulo31";
                    } else {
                        $color = "subtitulo3";
                    }
                    
                    if ($numcom) {
                        if($_SESSION["idiomaus"]==2)
                            $this->listaEstandar[]= 
                                "<a href='index.php?action=indlistasecciones&tiposec=ED&subsecc=" . $secc . "." .
                                $rowcu["re_numcomponente2"] . "'><strong>" . $rowcu["re_descripcioning"] . "</strong></a>";
                            else
                                $this->listaEstandar[]= 
                                    "<a href='index.php?action=indlistasecciones&tiposec=ED&subsecc=" . $secc . "." .
                                    $rowcu["re_numcomponente2"] . "'><strong>" . $rowcu["re_descripcionesp"] . "</strong></a>";
                    } else {
                        if($_SESSION["idiomaus"]==2)
                            $this->listaEstandar[]= 
                                "<a href='index.php?action=indlistasecciones&tiposec=ED&subsecc=" . $idnumseccion . "." . $numreac . "." .
                                $rowcu["re_numcomponente"] . "." . $numcar . "." . $numcom2 . "&num=" . $Id . "'><strong>" .
                                $rowcu["re_descripcioning"] . "</strong></a>";
                            else
                                $this->listaEstandar[]=
                                    "<a href='index.php?action=indlistasecciones&tiposec=ED&subsecc=" . $idnumseccion . "." . $numreac . "." .
                                    $rowcu["re_numcomponente"] . "." . $numcar . "." . $numcom2 . "&num=" . $Id . "'><strong>" .
                                    $rowcu["re_descripcionesp"] . "</strong></a>";
                               
                    }
                   
                    $cont++;
                }
                
                $this->titulo=T_("NO. DE REPORTE") . " : " . $numrep;
                $this->nombreSeccion=$TITULO5;
                
                //$navegacion='<li><a href="MENindprincipal.php?op=mindi" style="z-index:9;">'.T_("GRAFICA").'</a></li>';
                //If($_SESSION["fbuscapv"]==1)
                //     $navegacion.='<li><a href="MENindprincipal.php?admin=buspv" style="z-index:8;">'.T_("BUSCAR PUNTO DE VENTA").'</a></li>';
                //  else
                //    $navegacion.='<li><a href="MENindprincipal.php?op=mindi&admin=cons&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&ref='.$_SESSION["fref"].'&niv='.$_SESSION["fniv"].'" style="z-index:8;">'.T_("INDICADORES").'</a></li>';
                // $navegacion.='<li><a href="MENindprincipal.php?op=mindi&admin=datos&numrep='.$numrep.'&cser=1&ccli=100" style="z-index:6;">'.$nomuni.'</a></li>
                // <li><a href="MENindprincipal.php?op=mindi&admin=seccion&numrep='.$numrep.'&referencia=100.1.'.$idclavecuenta.'.'.$idclaveuninegocio.'" style="z-index:5;">'.T_("SECCIONES").'</a></li>
                // <li><a href="#" style="z-index:4;">'.T_("SUBSECCION").'</a></li>';
                // //<li><a href="#" style="z-index:3;">'.$TITULO5.'</a></li>';
                // $html->asignar('NAVEGACION',$navegacion);
                Navegacion::borrarRutaActual("e");
                $rutaact = $_SERVER['REQUEST_URI'];
                // echo $rutaact;
                Navegacion::agregarRuta("e", $rutaact, T_("DETALLE"));
               
      
        
       
    }
    
    public function vistaEstandarDetalle(){
        include "Utilerias/leevar.php";
       
        
        if ($subsecc) {
            
            //session_register("seccioncompuesta");
            
            $seccioncompuesta = $subsecc;
            
        } else {
            
            $subsecc = $_SESSION["seccioncompuesta"];
            
        }
        
        $numsec = $subsecc;
     
        
        $datini = SubnivelController::obtienedato($num, 1);
        
        $londat = SubnivelController::obtienelon($num, 1);
        
        $idcliente = substr($num, $datini, $londat);
        
        
        
        
        
        $datini = SubnivelController::obtienedato($num, 2);
        
        $londat = SubnivelController::obtienelon($num, 2);
        
        $idser = substr($num, $datini, $londat);
        
        
        
        $datini = SubnivelController::obtienedato($num, 3);
        
        $londat = SubnivelController::obtienelon($num, 3);
        
        $numreporte = substr($num, $datini, $londat);
        
        
        
        $datini = SubnivelController::obtienedato($num, 4);
        
        $londat = SubnivelController::obtienelon($num, 4);
        
        $clavecuenta = substr($num, $datini, $londat);
        
        
        
        $datini = SubnivelController::obtienedato($num, 6);
        
        $londat = SubnivelController::obtienelon($num, 6);
        
        $clavenegocio = substr($num, $datini, $londat);
        
        //echo $numrep;
        
        
        
        $datinis = SubnivelController::obtienedato($subsecc, 1);
        
        $londats = SubnivelController::obtienelon($subsecc, 1);
        
        $numsec = substr($subsecc, $datinis, $londats);
        
        
        
        
        
        $datinir = SubnivelController::obtienedato($subsecc, 2);
        
        $londatr = SubnivelController::obtienelon($subsecc, 2);
        
        $numreac = substr($subsecc, $datinir, $londatr);
        
        
        
        $datinico = SubnivelController::obtienedato($subsecc, 3);
        
        $londatco = SubnivelController::obtienelon($subsecc, 3);
        
        $numcom = substr($subsecc, $datinico, $londatco);
        
        
        
        $datinica = SubnivelController::obtienedato($subsecc, 4);
        
        $londatca = SubnivelController::obtienelon($subsecc, 4);
        
        $numcar = substr($subsecc, $datinica, $londatca);
        
        
        
        $datinico2 = SubnivelController::obtienedato($subsecc, 5);
        
        $londatco2 = SubnivelController::obtienelon($subsecc, 5);
        
        $numcom2 = substr($subsecc, $datinico2, $londatco2);
        
        
        
        if ($numcar) {
            
            
            
        } else {
            
            $numcar = 0;
            
        }
        
        if ($numcom2) {
            
            
            
        } else {
            
            $numcom2 = 0;
            
        }
        
        //-----------------------------------
        
        //  inicializo etiquetas por idioma
        
        //  -----------------------------------
    //    $refer = $idcliente . "." . $idser . "." . $clavecuenta . "." . $clavenegocio;
        
      
        /* CrEA TITULO 4 */
        
        $this->nombreUnegocio =ConsultaSeccionesController::nombreUnegocio($clavenegocio);
        
        /* Crea nombre de subseccion */
        
        $nomsec= DatosSeccion::descripcionSeccionIdioma($numsec,$idser,$_SESSION["idiomaus"]);
        
         // busca desc reactivo
     
        if ($numreac != 0) {
            
            
            
            $rspn =  DatosPond::editaPonderaModel($numsec,$idser, $numreac,"cue_reactivos");
           
            foreach ($rspn as $rowpn) {
                if($_SESSION["idiomaus"]==2)
                    $nompn = $rowpn['r_descripcioning'];
                    else
                        $nompn = $rowpn['r_descripcionesp'];
            }
            
            
            $nomcomu = $this->nomSecEstandar($idser, $subsecc);
         
            $TITULO5 = $subsecc . "." . $nompn . " / " . $nomcomu;
            
            
            
       //     $cont_rea = $this->despliegaReactivos($idser, $subsecc);
            
       
        
            
        } else {   // si no es un subnivel
         
            if ($numcar == 0) {   //es pirmer nivel
                
                $nomcomu = $this->nomSecEstandar($idser, $subsecc);
                
                $TITULO5 = $subsecc . "." . $nomsec . " / " . $nomcomu;
                
                // busco caracteristicas en estandar detalle
                
//                  $rsd =DatosEst::vistaRepEstandarDet($idser,$subsecc,"cue_reactivosestandardetalle");
                
//                 if ($subsecc == '5.0.2.0.0') {
                    
//                     $classsub = "subtitulo2";
                    
//                 }
                
          
//                 $cont_rea = 0;
              
//               foreach($rsd as $rowd) {
                    
                   
                        
//                         if ($_SESSION["idiomaus"] == 2)
                            
//                             $id=$rowd["red_parametroing"];
                            
//                             else
                                
//                                 $id= $rowd["red_parametroesp"];
                
                
            
//                     $estandar = "";
                    
//                     if ($rowd["red_tipodato"] == "C") {
//                        $result_cat = DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$rowd["red_clavecatalogo"], $rowd ["red_valormin"] );
                        
//                         foreach($result_cat as $row_cat) {
                            
//                             if ($_SESSION["idiomaus"] == 2)
                                
//                                 $estandar = $row_cat["cad_descripcioning"];
                                
//                                 else
                                    
//                                     $estandar = $row_cat["cad_descripcionesp"];
                                    
//                         }
                        
                   
                        
//                     }
                    
//                     else
                        
//                         $estandar = $rowd["red_estandar"];
                        
                     
                            
//                     $this->listaAtributos[$rowd["red_numcaracteristica2"] ]=array("estandar"=> $estandar,"reactivo"=>$id);
//                     $cont_rea++;
                        
//                 } //termino de desplegar estandares
                
                // $html->asignar('areaenc', "<td width='65' class='subtitulo2'> </td></tr>");
                
                // $html->expandir('FILASENC', '+tBusquedaenc');
                
            } else {    // SI HAY NUMCAR
                
              
                $nomcomu=$this->nomSecEstandar($idser, $subsecc);
                
                $TITULO5 = $subsecc . "." . $nomsec . " / " . $nomcomu;
                
                //despliega encabezado
                
//                $rsd = DatosEst::vistaRepEstandarDet($idser,$subsecc,"cue_reactivosestandardetalle");
                
                
                
             
                
//                 if ($_SESSION["idiomaus"] == 2) {
                    
//                     $campo_des = "red_parametroing";
                    
//                 }
                
//                 else
                    
//                     $campo_des = "red_parametroesp";
                    
//                     $cont_rea = 0;
                    
                 //   foreach($rsd as $rowd) {
                        //pendiente
                        
//                         if ($rowd["rad_tiporeactivo"] != "") {
                            
//                             $subsec = $numsec . "." . $numreac . "." . $numcom . "." . $rowd[red_numcaracteristica2] . "." . $numcom2;
                            
//                             $linksubn = "<a href='MENprincipal.php?op=subnivel&secc=" . $subsec . "&tiposec=" . $rowd["red_tiporeactivo"] . "'>" .
                                
//                                 "<img src='../img/agregar.gif' width='27' height='21' border='0'></a>";
                            
//                             $html->asignar('areaenc', "<td width='65' class='" . $classsub . "'>"
                                
//                                 . $rowd[$campo_des] . "  " . $linksubn . "</td>");
                            
//                         } else {
                            
//                             $html->asignar('areaenc', "<td width='65' class='" . $classsub . "'>"
                                
//                                 . $rowd[$campo_des] . "</td>");
                            
//                         }
                        
//                         $html->expandir('FILASENC', '+tBusquedaenc');
                        
                 //   }
                    
                    //$html->asignar('areaenc', "<td  height='30' bgcolor='#ACDFE3' class='TabSubtituloReporte1'>Eliminar</td>");
                    
                  
                    
            }
            
        }
        
   
        
        
        $rsg = DatosEst::getReactivoEstandarn3($idser,$numsec . "." . $numreac . "." . $numcom . ".0","cue_reactivosestandar");
       
        foreach($rsg  as $rowg) {
            
            $tipoeva = $rowg['re_tipoevaluacion'];
            
        }
        
        $sumapond = 0;
        
     
        
        // Despliega contenido
        
        
            
            $numdes = T_("Resultado") . $numren;
            
          
                
                /*busco el resultado de cada caracteristica*/
                
                $ssqldet = "SELECT *
    FROM `ins_detalleestandar` INNER JOIN `cue_reactivosestandardetalle`
    ON `ser_claveservicio`=`ide_claveservicio`
    AND`sec_numseccion`=`ide_numseccion`
    AND `r_numreactivo`=`ide_numreactivo`
    AND `re_numcomponente`=`ide_numcomponente`
    AND `re_numcaracteristica`=`ide_numcaracteristica1`
     AND `re_numcomponente2`=`ide_numcaracteristica2`
    AND `red_numcaracteristica2`=`ide_numcaracteristica3`
                    
       WHERE `ins_detalleestandar`.`ide_claveservicio` =   :idser 
           
             AND concat(ide_numseccion,'.',ide_numreactivo,'.',ide_numcomponente,'.',ide_numcaracteristica1,'.',ide_numcaracteristica2) = :subsecc 
                 
             AND `ins_detalleestandar`.`ide_numreporte` = :numrep                
            
             order by ide_numrenglon,ide_numcaracteristica3  ;";
                
                // echo "<br>".$ssqldet;
                
                $rsc = Conexion::ejecutarQuery($ssqldet,array(
                    "idser"=>$idser,
                    "subsecc"=>$subsecc,
                    "numrep"=>$numreporte
                ));
                
                
            
                
                if (sizeof($rsc) > 0) {
                    $numrenant=1;
                    foreach($rsc as $rowcue) {
                        
                        $resultado=array();
                        $numren=$rowcue["ide_numrenglon"] ;
                      
                    
                        $estandar = $rowcue["red_estandar"];
                        
                        //echo "zz".$estandar;
                        
                        $tipocat = $rowcue["red_tipodato"];
                        
                        $resacep = $rowcue["ide_aceptado"];
                       
                        switch ($tipocat) {
                            
                            case "C" :
                                
                                $siguno = $rowcue["red_signouno"];
                                
                                $valmin = $rowcue["red_valormin"];
                                
                                $valop = $rowcue["ide_valorreal"];
                                
                                $numcat = $rowcue["red_clavecatalogo"];
                                
                                $valpond = $rowcue["ide_ponderacion"];
                                
                                // busca el valor en el catalogo
                                                           
                                $valreal = DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle", $numcat,$valop);
                                break;
                                    
                            case "N" :
                                
                                $siguno = $rowcue["red_signouno"];
                                
                                $valmin = $rowcue["red_valormin"];
                                
                                If (($rowcue["ide_numcaracteristica3"]==17) ||  ($rowcue["ide_numcaracteristica3"]==18)) {
                                    
                                    //echo "entre a valor 17 o 18";
                                    
                                    //echo round($rowdet["ide_valorreal"], 3);
                                    
                                    if ((round($rowcue["ide_valorreal"], 3))>=100){
                                        
                                        //echo "es mayor de 100";
                                        
                                        $valreal="Incontables";
                                        
                                    } else {
                                        
                                        $valreal = round($rowcue["ide_valorreal"], 3);
                                        
                                    }
                                    
                                }else {
                                    
                                    $valreal = round($rowcue["ide_valorreal"], 3);
                                    
                                }
                                
                                $valmax = $rowcue["red_valormax"];
                                
                                $sigdos = $rowcue["red_signodos"];
                                
                                $valpond = $rowcue["ide_ponderacion"];
                                
                        }
                        
                        //  echo "xxz".$valpond;
                        
                       
                            
                            if (isset($estandar) && $estandar != "") {
                                
                                // echo $resacep."--";
                                
                                if ($resacep != 0) { //es aceptado
                                    
                                    $resultado["resultado"]="<span class='label label-primary'>".$valreal."</div>";
                                    
                                    //verifico que no tenga ponderacion
                                    
                                    //if ($valpond > 0)
                                    
                                    //$valpond = 100;
                                    
                                } else {
                                    
                                    $resultado["resultado"]="<div  class='label label-danger'><strong> " . $valreal . "</strong></div>";
                                    
                                    $valpond = 0;
                                    
                                }
                                
                            } else {
                                
                                $resultado["resultado"]= "<span class='label label-primary'>".$valreal."</span>" ;
                                
                                $valpond = 0;
                                
                            }
                            $resultado["id"]=$rowcue["ide_numcaracteristica3"];
                           // $resultado["estandar"]="<span class='label label-primary'>".$estandar."</span>";
                            $resultado["estandar"]=$estandar;
                            if ($_SESSION["idiomaus"] == 2)
                                
                               $resultado["reactivo"]=$rowcue["red_parametroing"];
                                
                                else
                                    
                                 $resultado["reactivo"]=$rowcue["red_parametroesp"];
                                    
                            
                       
                           $this->listaAtributos[$rowcue["ide_numcaracteristica3"]]=$resultado;
                            if($numren>$numrenant)
                            {      $this->listaEstandar[$numren]= $this->listaAtributos;
                            $numrenant=$numren;
                            $sumapond = 0;
                            }
                            
                       
                        
                        
                         
                        if ($tipoeva == 1 && $rowcue["ide_numrenglon"] == 1) {
                            
                            $sumapond = $sumapond + $valpond;
                           
                        }
                        
                        else
                            
                            $sumapond = $sumapond + $valpond;
                       
                            
                    } //termino despliegue de datos
                    $this->listaEstandar[$numren]= $this->listaAtributos;
                    
                }
              
                
             
                
                $cont_rea++;
                
           
            
            // $html->expandir('FILASDATOS', '+tBusqueda');
            
            $cont++;
            
        
        
        
        
        //calcula nivel de cumplimiento
        
        if ($tipoeva == 2) {
            
            $sumapond = $sumapond / $numren;
            
        }
        
        $this->Sumapond=round($sumapond, 2);
        
        if ($numreac == 0) {
            
            $secreg = $numsec;
            
        } else {
            
            $secreg = $numsec . "." . $numreac;
            
        }
         $this->titulo = strtoupper(T_("No. de Reporte")) . " : " . $numreporte;
        
        $this->nombreSeccion=$TITULO5;
        
        $mes = $_SESSION["fmes"];
        
    
        
               Navegacion::borrarRutaActual("e");
                
                $rutaact = $_SERVER['REQUEST_URI'];
                
                // echo $rutaact;
                
                Navegacion::agregarRuta("e", $rutaact,  T_("DETALLE"));
                
            
                
    }      
                
                // -------------------------------
                
                //    declaracion funciones
                
                // --------------------------------
                
                function despliegaReactivos($idser, $subsecc) {
                    
               
                    
                      
                    $rsd = DatosEst::vistaRepEstandarDet($idser,$subsecc,"cue_reactivosestandardetalle");
                   
                    $cont_rea = 0;
                    
                    foreach ($rsd as $rowd) {
                        
                     
                            
                        if ($_SESSION["idiomaus"] == 2)
                                
                        $this->listaAtributos[$rowd["red_numcaracteristica2"]]=array("reactivo"=>$rowd["red_parametroing"],"estandar"=>$rowd["red_estandar"]);
                                
                                else
                                    
                                    $this->listaAtributos[$rowd["red_numcaracteristica2"]]=array("reactivo"=>$rowd["red_parametroesp"] ,"estandar"=>$rowd["red_estandar"]);
                                      
                       
                        
                       
                        
                        $cont_rea++;
                        
                    }
                    
                }
                
    
    function nomSecEstandar($idser,$subsecc)
    {
        $rscu = DatosEst::consultaReactivoEstandar($idser, $subsecc,"cue_reactivosestandar");
       foreach($rscu as $rowcu) {
            if($_SESSION["idiomaus"]==2)
                $nomcomu = $rowcu['re_descripcioning'];
                else
                    $nomcomu = $rowcu['re_descripcionesp'];
                    
        }
        return $nomcomu;
    }
    /**
     * @return  $nombreUnegocio
     */
    public function getNombreUnegocio()
    {
        return $this->nombreUnegocio;
    }

    /**
     * @return  $titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @return  $nombreSeccion
     */
    public function getNombreSeccion()
    {
        return $this->nombreSeccion;
    }
    /**
     * @return mixed
     */
    public function getListaAtributos()
    {
        return $this->listaAtributos;
    }
    /**
     * @return mixed
     */
    public function getListaEstandar()
    {
        return $this->listaEstandar;
    }
    /**
     * @return mixed
     */
    public function getSumapond()
    {
        return $this->Sumapond;
    }



   
  
    
    
    
    
}

