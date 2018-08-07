<?php


class ConsultaEstandarController
{
    
    private $nombreUnegocio;
    private $titulo;
    private $nombreSeccion;
    private $listaEstandar;
    
    public function vistaListaEstandar(){
        include "Utilerias/leevar.php";
       
        switch ($opadmin) {
            case "detalle_consulta":
                include('./MENindestandardetalle.php');
                break;
            default:
                
                
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
                $datini = Utilerias::obtienedato($Id, 1);
                $londat = Utilerias::obtienelon($Id, 1);
                $idclient = substr($Id, $datini, $londat);
                
                
                $datini = Utilerias::obtienedato($Id, 2);
                $londat = Utilerias::obtienelon($Id, 2);
                $idser = substr($Id, $datini, $londat);
                
                
                $datini =Utilerias::obtienedato($Id, 3);
                $londat = Utilerias::obtienelon($Id, 3);
                $idreporte = substr($Id, $datini, $londat);
                
                
                $datini = Utilerias::obtienedato($Id, 4);
                $londat = Utilerias::obtienelon($Id, 4);
                $idclavecuenta = substr($Id, $datini, $londat);
                
                $datini = Utilerias::obtienedato($Id, 5);
                $londat = Utilerias::obtienelon($Id, 5);
                $idnumseccion = substr($Id, $datini, $londat);
                //echo $idnumseccion;
                
                $datini = Utilerias::obtienedato($Id, 6);
                $londat = Utilerias::obtienelon($Id, 6);
                $idclaveuninegocio = substr($Id, $datini, $londat);
                $nomuni=ConsultaSeccionesController::nombreUne($idclaveuninegocio);
                $this->nombreUnegocio=$nomuni;
                
                /* Crea nombre de seccion */
               $rs = DatosSeccion::vistaSeccionModel($idnumseccion,"cue_secciones");
                foreach ($rs as $row) {
                   if($_SESSION["idiomaus"]==2)
                        $nomsec = $row['sec_descripcioning'];
                   else
                        $nomsec = $row['sec_descripcionesp'];
                   if ($numcom) {
                                
                    } else {   // no hay numcom, es decir es de un primer nivel
                         $tiposec = $row['sec_tiposeccion'];
                     }
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
                    $nompn=DatosPond::editaPonderaModel($idnumseccion, $idser,$numreac,"cue_reactivos");
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
                         $seccom = $numsec . "." . $numreac . "." . $numcom . "." . $numcar . "." . $numcom2;
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
                            $this->listaEstandar[]= "<td class='$color'>" .
                                "<a href='MEIprincipal.php?op=ED&subsecc=" . $secc . "." .
                                $rowcu["re_numcomponente2"] . "'>" . $rowcu["re_descripcioning"] . "</a></td>";
                            else
                                $this->listaEstandar[]= "<td class='$color'>" .
                                    "<a href='MEIprincipal.php?op=ED&subsecc=" . $secc . "." .
                                    $rowcu["re_numcomponente2"] . "'>" . $rowcu["re_descripcionesp"] . "</a></td>";
                    } else {
                        if($_SESSION["idiomaus"]==2)
                            $this->listaEstandar[]= "<td class='$color'>" .
                                "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=E&opadmin=detalle_consulta&subsecc=" . $idnumseccion . "." . $numreac . "." .
                                $rowcu["re_numcomponente"] . "." . $numcar . "." . $numcom2 . "&num=" . $Id . "'>" .
                                $rowcu["re_descripcioning"] . "</a></td>";
                            else
                                $this->listaEstandar[]="<td class='$color'>" .
                                    "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=E&opadmin=detalle_consulta&subsecc=" . $idnumseccion . "." . $numreac . "." .
                                    $rowcu["re_numcomponente"] . "." . $numcar . "." . $numcom2 . "&num=" . $Id . "'>" .
                                    $rowcu["re_descripcionesp"] . "</a></td>";
                               
                    }
                   
                    $cont++;
                }
                
                if ($numreac == 0) {
                    $opreg = "MEIprincipal.php?op=editarep&referencia=" . $refer . "&numrep=" . $numrep;
                } else {
                    $opreg = "MEIprincipal.php?op=subnivel&secc=" . $idnumseccion . "&tiposec=" . $tiposec;
                }
                
                $html->asignar('REGRESAR', $opreg);
                
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
        
       
    }
    
    
    
}

