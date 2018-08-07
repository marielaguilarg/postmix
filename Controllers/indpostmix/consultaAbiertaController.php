<?php
namespace indpostmix;

class ConsultaAbiertaController
{
    
    private $titulo1;
    private $nombreseccion;
    private $unegocio;
    private $listaresultados;
    
    
    public function vistaListaAbierta(){
        
        include "Utilerias/leevar.php";
        
        
        
        $refer = $Op;
        
        //include ('MEutilerias.php');
        $datini = Utilerias::obtienedato($refer, 1);
        $londat = Utilerias::obtienelon($refer, 1);
        $idclient = substr($refer, $datini, $londat);
        
        $datini = Utilerias::obtienedato($refer, 2);
        $londat = Utilerias::obtienelon($refer, 2);
        $idser = substr($refer, $datini, $londat);
        
        $datini = Utilerias::obtienedato($refer, 3);
        $londat = Utilerias::obtienelon($refer, 3);
        $idreporte = substr($refer, $datini, $londat);
        
        $datini = Utilerias::obtienedato($refer, 4);
        $londat = Utilerias::obtienelon($refer, 4);
        $idclavecuenta = substr($refer, $datini, $londat);
        
        $datini = Utilerias::obtienedato($refer, 5);
        $londat = Utilerias::obtienelon($refer, 5);
        $idnumseccion = substr($refer, $datini, $londat);
        
        $datini = Utilerias::obtienedato($refer, 6);
        $londat = Utilerias::obtienelon($refer, 6);
        $idclaveuninegocio = substr($refer, $datini, $londat);
        
        $numrep = $idreporte;
        //obtinee datos
        if(isset($secc)&&$secc!=""){
            $datinis = Utilerias::obtienedato($secc, 1);
            $londats = Utilerias::obtienelon($secc, 1);
            $numsec = substr($secc, $datinis, $londats);
            
            $datinir = Utilerias::obtienedato($secc, 2);
            $londatr = Utilerias::obtienelon($secc, 2);
            $numreac = substr($secc, $datinir, $londatr);
            
            $datinico = Utilerias::obtienedato($secc, 3);
            $londatco =Utilerias::obtienelon($secc, 3);
            $numcom = substr($secc, $datinico, $londatco);
            
            $datinica = Utilerias::obtienedato($secc, 4);
            $londatca = Utilerias::obtienelon($secc, 4);
            $numcar = substr($secc, $datinica, $londatca);
            
            $datinico2 = Utilerias::obtienedato($secc, 5);
            $londatco2 = Utilerias::obtienelon($secc, 5);
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
				 AND ca_unegocios.cue_clavecuenta =:idclavecuenta
            
			     AND cue_secciones.sec_numseccion =:idnumseccion";
        $parametros=array("une_id"=>$idclaveuninegocio,
            "idclavecuenta"=>idclavecuenta,
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
        $TITULO5=$idnumseccion." ".$nomsec;
        
        
        // busca desc reactivo
        //	 echo $secc;
        if ($numreac != 0) {
            
            $rowpn = DatosPond::editaPonderaModel($numsec,$idser,$numreac);
            
            if($_SESSION["idiomaus"]==2)
                $nompn = $rowpn['descreactivo_i'];
                else
                    $nompn = $rowpn['descreactivo'];
                    
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
                                    $this->listaresultados[]= "<td >" .
                                    "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=AD&secc=" . $secc . "." .
                                    $rowcu["ra_numcomponente"] . "." . $numcar . "." . $numcom2 . "&Op=".$refer."'>" . $rowcu[$campo_des] . "</a></td>";
                            }
                            
                            $cont++;
                            
                            $opreg = "MENprincipal.php?op=mindi&admin=subnivel&secc=" . $numsec . "&tiposec=" . $tiposec . "&numrep=" . $numrep;
        } else {
            // http://localhost/muesmerc/MEmodulos/MENprincipal.php?op=seccion&numrep=409&referencia=100.1.1.37&prin=
            $auxref=$idclient . "." . $idser . "." . $idclavecuenta . "." . $idclaveuninegocio ;
            $opreg ="MENprincipal.php?op=mindi&admin=seccion&numrep=$numrep&referencia=$auxref&prin=";
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
                            
                            $this->listaresultados= "<td  >" .
                                "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=AD&secc=" . $secc . "." .
                                $rowcu["ra_numcomponente2"] . "&Op=".$refer."'>" . $rowcu[$campo_des] . "</a></td>";
                        } else {
                            $this->listaresultados= "<td class='$color' >" .
                            "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=AD&secc=" . $numsec . "." . $numreac . "." .
                            $rowcu["ra_numcomponente"] . "." . $numcar . "." . $numcom2 . "&Op=".$refer."'>" . $rowcu[$campo_des] . "</a></td>";
                        }
                    }
                    
                    $cont++;
        }
        
        $this->nombreSeccion=$TITULO5;
        
        
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
    
    
}

