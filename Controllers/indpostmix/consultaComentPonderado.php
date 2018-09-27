<?php

include 'Controllers/indpostmix/consultaSeccionesController.php';
class ConsultaComentPonderado
{
    private $nombreuni;
    private $nombreSeccion;
    private $titulo;
    private $listaComentarios;

    
    public function vistaComentPonderado(){
    include "Utilerias/leevar.php";
    
    
    $idsec = $secc;
    //echo $refer;
    //include ('MEutilerias.php');
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
    
    //-----------------------------------
    //  inicializo etiquetas por idioma
    //  -----------------------------------
  
    
    $nomuni=ConsultaSeccionesController::nombreUnegocio($idclaveuninegocio);
        // $html->asignar('FechaVisita', formato_fecha($rowfranquicia["i_fechavisita"]));
    
    $this->nombreuni= $nomuni;
  
    
    /* Crea nombre de seccion */
   
    $rs =DatosSeccion::descripcionSeccionIdioma($idnumseccion,$idser,$_SESSION["idiomaus"]);
   
          
                
    $this->nombreSeccion= $idnumseccion." ".$rs;
                
        
        
            $cont = 0;
            // buca los valores ya seleccionados
//             $sqlcs = "SELECT ins_comentdetalle.id_comentario, rc_numcomentario, rc_descomentarioing, rc_descomentarioesp
//     FROM ins_comentdetalle inner join cue_reactivoscomentarios on sec_numseccion=id_comnumseccion
//     and r_numreactivo=id_comreactivo and ser_claveservicio=id_comclaveservicio and id_comentario=rc_numcomentario
//     WHERE concat(id_comnumseccion,'.',id_comreactivo)='" . $idsec . "'  AND id_comclaveservicio='" . $idser . "' and id_comnumreporte='" . $numrep . "';";
            
     $rs_cs = DatosComentDetalle::consultaComentPond($idser,$numrep,$idsec);
     foreach ($rs_cs as $row_cs) {
           $com = $row_cs["id_comentario"];
                
                if ($cont % 2 == 0) {
                    $color = "subtitulo3";
                } else {  //class="subtitulo31"
                    $color = "subtitulo31";
                }
                
                
                $comentario['numcomen']= $row_cs["rc_numcomentario"] ;
                $valant = T_("SI");
                if($_SESSION["idiomaus"]==2)
                    $campo_des="rc_descomentarioing";
                    else
                        $campo_des="rc_descomentarioesp";
                 $comentario['selcomen']= $row_cs[$campo_des] ;
                 $this->listaComentarios[]=$comentario;       
                        
                   
                      
            }
            $infoarea=T_("NO. DE REPORTE") . " : " . $idreporte;
            $this->titulo=$infoarea;
       
            Navegacion::borrarRutaActual("e");
            $rutaact = $_SERVER['REQUEST_URI'];
            // echo $rutaact;
            Navegacion::agregarRuta("e", $rutaact,  T_("SUBSECCION"));
    }
    
    public function vistaSeccionComentario(){
        
        @session_start();
        
        include ('Utilerias/leevar.php');
        
        
        $refer = $referencia;
       
        $idsec = $secc;
        
    
        $datinic = SubnivelController::obtienedato($refer, 1);
        $londatc = SubnivelController::obtienelon($refer, 1);
        $idclien = substr($refer, $datinic, $londatc);
        
        $datini = SubnivelController::obtienedato($refer, 2);
        $londat = SubnivelController::obtienelon($refer, 2);
        $idser = substr($refer, $datini, $londat);
        
        $datiniu = SubnivelController::obtienedato($refer, 3);
        $londatu = SubnivelController::obtienelon($refer, 3);
        $idcuen = substr($refer, $datiniu, $londatu);
        
        $datiniu = SubnivelController::obtienedato($refer, 4);
        $londatu = SubnivelController::obtienelon($refer, 4);
        $iduneg = substr($refer, $datiniu, $londatu);
        
        $datini = SubnivelController::obtienedato($idsec, 2);
        $londat = SubnivelController::obtienelon($idsec, 2);
        $numsec = substr($idsec, $datini, $londat);
        //-----------------------------------
        //  inicializo etiquetas por idioma
        //  -----------------------------------
        
      
        if ($_SESSION["idiomaus"] == 2)
            $sufijo = "ing";
            else
                $sufijo = "esp";
                
              
        $nomuni=ConsultaSeccionesController::nombreUnegocio($iduneg);
                // $html->asignar('FechaVisita', formato_fecha($rowfranquicia["i_fechavisita"]));
                
        $this->nombreuni= $nomuni;
                
                
                /* Crea nombre de seccion */
                
        $TITULO5=DatosSeccion::descripcionSeccionIdioma($numsec,$idser,"cue_secciones");
                
                /* Crea nombre de seccion */
       
        $this->nombreSeccion= $numsec . ". " . $TITULO5;
             
                // busca los valores ya seleccionados
//                 $ssql_r = "select * from ins_comentseccion
//             Inner Join cue_seccioncomentario ON ins_comentseccion.is_claveservicio = cue_seccioncomentario.ser_claveservicio AND ins_comentseccion.is_numseccion = cue_seccioncomentario.sec_numseccion AND ins_comentseccion.is_comentario = cue_seccioncomentario.sec_numcoment
// WHERE concat(is_claveservicio,'.',is_numseccion)='" . $idsec . "' and is_numreporte = '" . $numrep . "' and ins_comentseccion.is_claveservicio='$idser'";
                //        echo $ssql_r;
           $rs_r = DatosComentDetalle::consultaComentSeccion($idser,$numrep,$numsec);
                
                foreach ($rs_r as $row_r) {
                    $comentario=array();
                    $com = $row_r["is_comentario"];
                    //
                    
                    if ($cont % 2 == 0) {
                        $color = "subtitulo3";
                    } else {  //class="subtitulo31"
                        $color = "subtitulo31";
                    }
                    $comentario['numcomen']=
                        $row_r["sec_numcoment"] ;
                    $comentario['selcomen']= $row_r["sec_coment" . $sufijo] ;
                    //
                  $this->listaComentarios[]=$comentario;
                    $cont++;
                }
                
                
                
                
                $infoarea = T_("NO. DE REPORTE"). " : " . $numrep;
                $this->titulo= $infoarea;
              
                Navegacion::borrarRutaActual("e");
                $rutaact = $_SERVER['REQUEST_URI'];
                // echo $rutaact;
                Navegacion::agregarRuta("e", $rutaact,  T_("SUBSECCION"));
              
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
     * @return  $listaComentarios
     */
    public function getListaComentarios()
    {
        return $this->listaComentarios;
    }

    
    
}

