<?php
include 'consultaSeccionesController.php';

class ConsultaAbiertaController
{
    
    private $titulo1;
    private $nombreseccion;
    private $unegocio;
    private $listaresultados;
    private $listaTitulos;
    
    
    public function vistaListaAbierta(){
        
        include "Utilerias/leevar.php";
        
        
        
        $refer = $Op;
        
        //include ('MEutilerias.php');
        $datini = SubnivelController::obtienedato($refer, 1);
        $londat = SubnivelController::obtienelon($refer, 1);
        $idclient = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 2);
        $londat = SubnivelController::obtienelon($refer, 2);
        $idser = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 3);
        $londat = SubnivelController::obtienelon($refer, 3);
        $idreporte = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 4);
        $londat = SubnivelController::obtienelon($refer, 4);
        $idclavecuenta = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 5);
        $londat = SubnivelController::obtienelon($refer, 5);
        $idnumseccion = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 6);
        $londat = SubnivelController::obtienelon($refer, 6);
        $idclaveuninegocio = substr($refer, $datini, $londat);
        
        $numrep = $idreporte;
        //obtinee datos
        if(isset($secc)&&$secc!=""){
            $datinis = SubnivelController::obtienedato($secc, 1);
            $londats = SubnivelController::obtienelon($secc, 1);
            $numsec = substr($secc, $datinis, $londats);
            
            $datinir = SubnivelController::obtienedato($secc, 2);
            $londatr = SubnivelController::obtienelon($secc, 2);
            $numreac = substr($secc, $datinir, $londatr);
            
            $datinico = SubnivelController::obtienedato($secc, 3);
            $londatco =SubnivelController::obtienelon($secc, 3);
            $numcom = substr($secc, $datinico, $londatco);
            
            $datinica = SubnivelController::obtienedato($secc, 4);
            $londatca = SubnivelController::obtienelon($secc, 4);
            $numcar = substr($secc, $datinica, $londatca);
            
            $datinico2 = SubnivelController::obtienedato($secc, 5);
            $londatco2 = SubnivelController::obtienelon($secc, 5);
            $numcom2 = substr($secc, $datinico2, $londatco2);
        }
        else
        {
            $numsec=$idnumseccion;
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
        //-----------------------------------
        //  inicializo etiquetas por idioma
        //  -----------------------------------
        
        
        $this->titulo1=T_("NO. DE REPORTE : ".$numrep);
        
        /* Crea nombre de seccion */
        $ssql = "SELECT cue_secciones.sec_numseccion,
	   				 cue_secciones.sec_descripcionesp, sec_descripcioning,
					 cue_secciones.sec_tiposeccion,une_descripcion
				FROM ca_unegocios
		  INNER JOIN cue_secciones
		  		  ON ca_unegocios.une_id =:une_id
			   WHERE
				 ca_unegocios.cue_clavecuenta =:idclavecuenta
            
			     AND cue_secciones.sec_numseccion =:idnumseccion";
        $parametros=array("une_id"=>$idclaveuninegocio,
            "idclavecuenta"=>$idclavecuenta,
            "idnumseccion"=>$idnumseccion
        );
        $rs = Conexion::ejecutarQuery($ssql,$parametros);
        foreach ($rs as $row) {
            
            $nomuni = $row['une_descripcion'];
            if($_SESSION["idiomaus"]==2){
                
                
                $nomsec = $row['sec_descripcioning'];
            }
            else
                $nomsec= $row["sec_descripcionesp"];
                
                //
        }
        //$html->asignar('TITULO5',$idnumseccion." ".$nomsec);
        $TITULO5=$idnumseccion.". ".$nomsec;
        
        //$nomuni=ConsultaSeccionesController::nombreUnegocio($idclaveuninegocio);
        $this->unegocio= $nomuni;
        // busca desc reactivo
        //	 echo $secc;
        
        if ($numreac != 0) {
            
            $rowpn = DatosPond::editaPonderaModel($numsec,$idser,$numreac,"cue_reactivos");
            
            if($_SESSION["idiomaus"]==2)
                $nompn = $rowpn['r_descripcioning'];
                else
                    $nompn = $rowpn['r_descripcionesp'];
                    
                    $TITULO5= $numsec.".".$numreac." ".$nompn . " ";
                   
                    $rscu = DatosAbierta::getReactivoAbiertoxReactivo($idser,$secc,"cue_reactivosabiertos");
                    $cont = 0;
                    if($_SESSION["idiomaus"]==2)
                        $campo_des="ra_descripcioning";
                        else
                            $campo_des="ra_descripcionesp";
                            foreach ($rscu as $rowcu) {
                                if ($cont % 2 == 0) {
                                    $color = "subtitulo31";
                                } else {  //class="subtitulo31"
                                    $color = "subtitulo3";
                                }
                                
                                if ($numcom) {
                                    
                                } else
                                    $this->listaresultados[]= 
                                    "<a href='index.php?action=indlistasecciones&tiposec=AD&secc=" . $secc . "." .
                                    $rowcu["ra_numcomponente"] . "." . $numcar . "." . $numcom2 . "&Op=".$refer."'><strong>" . $rowcu[$campo_des] . "</strong></a>";
                            }
                            
                            $cont++;
                            
                            $opreg = "index.php?action=indlistasecciones&secc=" . $numsec . "&tiposec=" . $tiposec . "&numrep=" . $numrep;
        } else {
            // http://localhost/muesmerc/MEmodulos/MENprincipal.php?op=seccion&numrep=409&referencia=100.1.1.37&prin=
            $auxref=$idclient . "." . $idser . "." . $idclavecuenta . "." . $idclaveuninegocio ;
            $opreg ="index.php?action=indconsultasecciones&numrep=$numrep&referencia=$auxref&prin=";
            if ($numcar == 0) { // es primer nivel
                
                $TITULO5=$idnumseccion.". ".$nomsec . " ";
                $seccom = $idnumseccion . "." . $numreac . "." . $numcar . "." . $numcom2;
                
                $rscu=DatosAbierta::vistaAbiertaModeln1($idser,$seccom,"cue_reactivosabiertos");
            } else {
                $seccom = $numsec . "." . $numreac . "." . $numcom . "." . $numcar . "." . $numcom2;
                
                // 	            $rscu =DatosAbierta::vistaAbDetModel($idser,$seccom,"cue_reactivosabiertosdetalle");
                // 	            foreach ($rscu as $rowcu) {
                // 	                if($_SESSION["idiomaus"]==2)
                    // 	                    $nomcomu2 = substr($rowcu['rad_descripcioning'] 0, 50);
                    // 	                    else
                        // 	                        $nomcomu2 =substr($rowcu['rad_descripcionesp'], 0, 50) ;
                        // 	                        //$tiposec=$rowcu['rad_tiporeactivo'];
                        // 	            }
                    $TITULO5=$seccom.". ".$nomsec;
                    $secccom = $secc . $numcom . "." . $numcar;
                    //        echo "la seccion" . $secc;
                    // 	            $sqlcu = "SELECT *
                    //                   FROM `cue_reactivosabiertos`
                    //                  WHERE `cue_reactivosabiertos`.`ser_claveservicio` = '" . $idser . "'
                    //                  AND concat(sec_numseccion,'.', r_numreactivo,'.', ra_numcomponente,'.', ra_numcaracteristica) = '" . $seccom . "'";
                    $rscu=DatosAbierta::vistaAbiertaModeln3($idser,$seccom,"cue_reactivosabiertos");
            }
            
            
            
            $cont = 0;
            if($_SESSION["idiomaus"]==2)
                $campo_des="ra_descripcioning";
                else
                    $campo_des="ra_descripcionesp";
                    foreach ($rscu as $rowcu) {
                        if ($cont % 2 == 0) {
                            $color = "subtitulo31";
                        } else {  //class="subtitulo31"
                            $color = "subtitulo3";
                        }
                        if ($numcom) {
                            
                            $this->listaresultados= 
                                "<a href='index.php?action=indlistasecciones&tiposec=AD&secc=" . $secc . "." .
                                $rowcu["ra_numcomponente2"] . "&Op=".$refer."'><strong>" . $rowcu[$campo_des] . "</strong></a>";
                        } else {
                            $this->listaresultados= 
                            "<a href='index.php?action=indlistasecciones&tiposec=AD&secc=" . $numsec . "." . $numreac . "." .
                            $rowcu["ra_numcomponente"] . "." . $numcar . "." . $numcom2 . "&Op=".$refer."'><strong>" . $rowcu[$campo_des] . "</strong></a>";
                        }
                    }
                    
                    $cont++;
        }
        
        $this->nombreseccion=$TITULO5;
      // echo ($this->nombreSeccion);
        
        Navegacion::borrarRutaActual("e");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("e", $rutaact, T_("DETALLE"));
        
    }
    
    public function vistaAbiertaDetalle(){
        include "Utilerias/leevar.php";
      
     
        $numsec = $secc;
        // echo $numsec;
        if ($numsec) {
            if (!isset($_SESSION['secc'])) {
                $_SESSION['secc'] = $numsec;
            } else {
                $_SESSION['secc'] = $numsec;
            }
        } else {
            //echo "no hay variable";
            $numsec = $_SESSION['secc'];
            //			 echo $secc;
        }
        $secc = $numsec;
        // echo $secc;
        
        $numrep = $_SESSION['numreporte'];
        //    echo $secc;
        
        $refer=$Op;
        
    
        $datini = SubnivelController::obtienedato($refer, 1);
        $londat = SubnivelController::obtienelon($refer, 1);
        $idclien = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 2);
        $londat = SubnivelController::obtienelon($refer, 2);
        $idser = substr($refer, $datini, $londat);
        
        
        $datini = SubnivelController::obtienedato($refer, 3);
        $londat = SubnivelController::obtienelon($refer, 3);
        $idreporte = substr($refer, $datini, $londat);
        
        $numrep = $idreporte;
        
        $datini = SubnivelController::obtienedato($refer, 4);
        $londat = SubnivelController::obtienelon($refer, 4);
        $idclavecuenta = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 5);
        $londat = SubnivelController::obtienelon($refer, 5);
        $idnumseccion = substr($refer, $datini, $londat);
        
        $datini = SubnivelController::obtienedato($refer, 6);
        $londat = SubnivelController::obtienelon($refer, 6);
        $idclaveuninegocio = substr($refer, $datini, $londat);
        
        //obtinee datos
        $datinis = SubnivelController::obtienedato($secc, 1);
        $londats = SubnivelController::obtienelon($secc, 1);
        $numsec = substr($secc, $datinis, $londats);
        
        $datinir = SubnivelController::obtienedato($secc, 2);
        $londatr = SubnivelController::obtienelon($secc, 2);
        $numreac = substr($secc, $datinir, $londatr);
        
        $datinico = SubnivelController::obtienedato($secc, 3);
        $londatco = SubnivelController::obtienelon($secc, 3);
        $numcom = substr($secc, $datinico, $londatco);
        
        $datinica = SubnivelController::obtienedato($secc, 4);
        $londatca = SubnivelController::obtienelon($secc, 4);
        $numcar = substr($secc, $datinica, $londatca);
        
        $datinico2 = SubnivelController::obtienedato($secc, 5);
        $londatco2 = SubnivelController::obtienelon($secc, 5);
        $numcom2 = substr($secc, $datinico2, $londatco2);
        
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
        
     
        
        
    
        if($_SESSION["idiomaus"]==2)
        {   $suf="ing";
        $suf_alias="_i";
        
        }
        else
        {     $suf="esp";
        $suf_alias="";
        }
        
        
        //busca el nombre de la unidad de negocio
      
        $nomuni=ConsultaSeccionesController::nombreUnegocio($idclaveuninegocio);
         $this->unegocio= $nomuni;
        
        /* Crea nombre de seccion */
    
        $rs = DatosSeccion::vistaSeccionModel($numsec,"cue_secciones");
        foreach($rs as $row) {
            $nomsec = $row['sec_descripcion'.$suf];
        }
       // busca desc reactivo
       if ($numreac != 0) { // es nivel 2
              
//                 $rspn = DatosPond::editaPonderaModel($numsec, $idser,$numreac,"cue_reactivos");
              
//                 foreach ($rspn as $rowpn) {
                    
//                     $nompn =substr( $rowpn['r_descripcion'.$suf],0,50);
//                 }
              
                $rscu = DatosAbierta::getAbierta($idser,$secc ,"cue_reactivosabiertos");
            
               
                $nomcomu = $rscu['ra_descripcion'.$suf];
                    
             
                //        $html->asignar('TITULO3', T_("SECCION ") . $numsec . "." . $numreac . $numcom);
              
                $TITULO5= $numsec . "." . $numreac . "." . $numcom . "   " . $nomcomu;
              
                //despliega encabezado
                $rsd = Datosabierta::getAbDetModel($idser,$secc,"cue_reactivosabiertosdetalle");
                $this->listaTitulos[]= "NO";
               
                foreach ($rsd as $rowd) {
                  
                    if ($rowd[rad_tiporeactivo] != "") {
                        $subsec = $numsec . "." . $numreac . "." . $numcom . "." . $rowd[rad_numcaracteristica2] . "." . $numcom2;
                        $linksubn = "<a href='MEIprincipal.php?op=subnivel&secc=" . $subsec . "&tiposec=" . $rowd[rad_tiporeactivo] . "'>" .
                            "<img src='../img/agregar.gif' width='27' height='21' border='0'></a>";
                        $this->listaTitulos[]=$rowd["rad_descripcion".$suf] . "  " . $linksubn ;
                    } else {
                        $this->listaTitulos[]=$rowd["rad_descripcion".$suf] ;
                    }
                   // $html->expandir('FILASENC', '+tBusquedaenc');
                }
               
                
            } else {
                if ($numcar == 0) {   //es primer nivel
                    $rscu = DatosAbierta::getAbierta($idser,$secc ,"cue_reactivosabiertos");
                    foreach ($rscu as $rscu) {
                        $nomcomu = $rowcu['ra_descripcion'.$suf];
                    }
                 
                    $TITULO5= $numsec . "." . $numcom . "   " . $nomcomu;
                   // busco caracteristicas en abierto detalle
                    $rsd = Datosabierta::getAbDetModel($idser,$secc,"cue_reactivosabiertosdetalle");
                    $this->listaTitulos[]= "NO";
                   
                    foreach ($rsd as $rowd) {
                      
                        if ($rowd[rad_tiporeactivo] != "") {
                            $subsec = $numsec . "." . $numreac . "." . $numcom . "." . $rowd[rad_numcaracteristica2] . "." . $numcom2;
                            $linksubn = "<a href='MEIprincipal.php?op=subnivel&secc=" . $subsec . "&tiposec=" . $rowd[rad_tiporeactivo] . "'>" .
                                "<img src='../img/agregar.gif' width='27' height='21' border='0'></a>";
                            $this->listaTitulos[]=  $rowd["rad_descripcion".$suf] . "  " . $linksubn ;
                        } else {
                            $this->listaTitulos[]= $rowd["rad_descripcion".$suf] ;
                        }
                      
                    }
                   
                    
                    
                } else {    // descripcion de subtitulo completa a segundo nivel
                    $rscu = DatosAbierta::EditaAbiertaModel($idser,$secc ,"cue_reactivosabiertos");
                   
                    //            echo $sqlcu;
                    foreach ($rscu as $rowcu) {
                        $nomcomu = substr($rowcu["ra_descripcion".$suf],0,50);
                    }
                    $TITULO5= $numsec . "." . $numcom . "." . $numcar . "." . $numcom2 . "   " . $nomcomu;
                    //despliega encabezado
                    $rsd =Datosabierta::vistaAbDetModel($idser,$secc,"cue_reactivosabiertosdetalle");
                    $this->listaTitulos[]="NO";
                 
                    foreach ($rsd as $rowd) {
                        if ($rowd[rad_tiporeactivo] != "") {
                            $subsec = $numsec . "." . $numreac . "." . $numcom . "." . $rowd[rad_numcaracteristica2] . "." . $numcom2;
                            $linksubn = "<a href='MEIprincipal.php?op=subnivel&secc=" . $subsec . "&tiposec=" . $rowd[rad_tiporeactivo] . "'>" .
                                "<img src='../img/agregar.gif' width='27' height='21' border='0'></a>";
                            $this->listaTitulos[]=  $rowd["rad_descripcion".$suf] . "  " . $linksubn ;
                        } else {
                            $this->listaTitulos[]= $rowd["rad_descripcion".$suf] ;
                        }
                        
                    }
                    
                }
            }
        
        
        // Despliega contenido
          
        $rsnr = DatosAbierta::consultaAbiertoDetalle($idser,$secc,$numrep,"ins_detalleabierta");
      
        $cont = 0;
       
        foreach ($rsnr as $rownr) {
            if ($cont % 2 == 0) {
                $color = "subtitulo3";
            } else {  //class="subtitulo31"
                $color = "subtitulo31";
            }
            
            $numren = $rownr["ida_numrenglon"];
            //   $ssqldet=("SELECT * FROM `ins_detalleabierta` WHERE `ins_detalleabierta`.`ida_claveservicio` = ".$idser." AND `ins_detalleabierta`.`ida_numreporte` = ".$numrep."  AND concat(ida_numseccion,'.',ida_numreactivo,'.',ida_numcomponente,'.',ida_numcaracteristica1,'.',ida_numcaracteristica2) = '".$secc."' and ida_numrenglon=".$numren.";");
           
            $rsc = DatosAbierta::vistaReporteAbiertoDetalle($idser,$secc,$numrep,$numren,"ins_detalleabierta");
          $resultado=array();
            $resultado[]=  $numren ;
          
            foreach ($rsc as $rowdet) {
                $tipocat = $rowdet["rad_formatoreactivo"];
                $numcat = $rowdet["rad_clavecatalogo"];
                $valop = $rowdet["ida_descripcionreal"];
                switch ($tipocat) {
                    case "C" :
                      
                        $rscat = DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valop);
                        foreach ($rscat as $rowca) {
                            $valreal = $rowca["cad_descripcion".$suf];
                        }
                        break;
                    default :
                        $valreal = $valop;
                }
                $resultado[]=$valreal ;
               
            }
            $this->listaresultados[]=$resultado;
            
            $cont++;
            
        }
        //echo $numcar;
        //echo $numsec;
        if ($numcar == 0) {
            $secreg = $numsec . "." . $numreac;
        } else {
            $secreg = $numsec . "." . $numreac . "." . $numcom . "." . $numcar . "." . $numcom2;
        }
        
      
        $infoarea=T_("NO. DE REPORTE") . " : " . $idreporte;
        $this->titulo1= $infoarea;
        $this->nombreseccion=$TITULO5;
        
        //$navegacion='<li><a href="MENindprincipal.php?op=mindi" style="z-index:9;">'.T_("GRAFICA").'</a></li>';
        //If($_SESSION["fbuscapv"]==1)
        //     $navegacion.='<li><a href="MENindprincipal.php?admin=buspv" style="z-index:8;">'.T_("BUSCAR PUNTO DE VENTA").'</a></li>';
        //  else
            //$navegacion.='<li><a href="MENindprincipal.php?op=mindi&admin=cons&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&ref='.$_SESSION["fref"].'&niv='.$_SESSION["fniv"].'" style="z-index:8;">'.T_("INDICADORES").'</a></li>';
            //$navegacion.=' <li><a href="MENindprincipal.php?op=mindi&admin=datos&numrep='.$idreporte.'&cser=1&ccli=100" style="z-index:6;">'.$nomuni.'</a></li>
            // <li><a href="MENindprincipal.php?op=mindi&admin=seccion&numrep='.$idreporte.'&referencia=100.1.'.$idclavecuenta.'.'.$idclaveuninegocio.'" style="z-index:5;">'.T_("SECCIONES").'</a></li>
            //  <li><a href="#" style="z-index:4;">'.T_("SUBSECCION").'</a></li>';
        //<li><a href="#" style="z-index:3;">'.$TITULO5.'</a></li>';
        Navegacion::borrarRutaActual("e");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("e", $rutaact, T_("DETALLE"));
       
    }
    /**
     * @return the $titulo1
     */
    public function getTitulo1()
    {
        return $this->titulo1;
    }
    
    /**
     * @return the $nombreseccion
     */
    public function getNombreseccion()
    {
      
        return $this->nombreseccion;
    }
    
    /**
     * @return the $unegocio
     */
    public function getUnegocio()
    {
        return $this->unegocio;
    }
    
    /**
     * @return the $listaresultados
     */
    public function getListaresultados()
    {
        return $this->listaresultados;
    }
    /**
     * @return the $listaTitulos
     */
    public function getListaTitulos()
    {
        return $this->listaTitulos;
    }

    
    
    
}

