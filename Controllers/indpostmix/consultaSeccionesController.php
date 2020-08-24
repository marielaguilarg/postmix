<?php

include ( 'Models/crud_comentDetalle.php');
// echo "aqui",filter_input(INPUT_GET, "tiposec",FILTER_SANITIZE_STRING);
// switch (filter_input(INPUT_GET, "tiposec",FILTER_SANITIZE_STRING)){
//     case "A" : header('index.php?action=indconsultaabierta.php');
//     break;
//     case "AD":include("views/modulos/cue_indconsultaabiertadetalle.php");
//     break;
//     case "V" : header('index.php?action=indconsultaproducto.php');
//     break;
//     case "E" : header('index.php?action=indconsultaestandar.php');
//     break;
//     case "P" : header('index.php?action=indconsultaponderado.php');
//     break;
//     case "C" : header('index.php?action=indconsultacomentpond.php');
//     break;
//     case 'img':	header('index.php?action=indconsultaimagen.php');
//     break;
//     case "coment" :
//         header('index.php?action=indconsultacomentario.php');
//         break;
//     case "datos" :
//         header('index.php?action=indconsultadatosestableci2.php');
//         break;
// }


class ConsultaSeccionesController
{
    private $nomunegocio;
    private $titulo1;
    private $titulo2;
    private $listaSecciones;

    public function vistaListaSecciones(){
        
    include "Utilerias/leevar.php";
   
    
    //$numrep = $_SESSION['numreporte'];
    $refer = $referencia;
    
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
    
  
    
    
    /* Crea titulo */
    
  
    
     $this->nomunegocio =    ConsultaSeccionesController::nombreUnegocio($iduneg);
   
    
    
    // asigna numero de reporte
       $this->titulo1=T_("CONSULTA REPORTE");

    
    //muestra secciones
    $rs = DatosSeccion::vistaSeccionModel($idser,"cue_secciones");
   
    $sumapond = 0;
    $cont = 0;
    foreach ($rs as $row ) {
        $secciones=array();
        if ($cont % 2 == 0) {
            $color = "subtitulo3";
        } else { //class="subtitulo31"
            $color = "subtitulo31";
        }
        $secciones['numsec']=  ($row ["sec_numseccion"]) ;
        if($_SESSION["idiomaus"]==2)
            $secciones['nomsec']=  $row ["sec_descripcioning"];
            else
                $secciones['nomsec']= $row ["sec_descripcionesp"] ;
                
                /*             * ************************************Busca Ponderacion********************************************* */
//                  $sqlp = "SELECT *
// 	         	 FROM cue_seccioncomentario
//                          inner join ins_comentseccion ON ins_comentseccion.is_claveservicio = cue_seccioncomentario.ser_claveservicio AND ins_comentseccion.is_numseccion = cue_seccioncomentario.sec_numseccion AND ins_comentseccion.is_comentario = cue_seccioncomentario.sec_numcoment
// 				WHERE ser_claveservicio = '" . $idser . "'
// 			  	  AND sec_numseccion = " . $row ["sec_numseccion"]." and is_numreporte = '".$numrep."'";
                
                //          echo $sqlp;
                 $rsp =DatosComentDetalle::consultaComentSeccion($idser,$numrep,$row ["sec_numseccion"]);
                $num_reg = sizeof($rsp);
                if ($num_reg != 0) {
                   
                        
                        $secciones['celdaComent']= "<a  class=\"btn btn-block btn-info\" href='index.php?action=indlistasecciones&tiposec=coment&secc=" . $idser . "." . $row ["sec_numseccion"] . "&referencia=" . $refer . "&numrep=" . $numrep . "'>
<i class=\"fa fa-comment fa-lg\" aria-hidden=\"true\"></i></a>";
                    
                } else {
                    $secciones['celdaComent']= "<a class=\"btn btn-block btn-info\" disabled>
<i class=\"fa fa-comment fa-lg\" aria-hidden=\"true\"></i></a>";
                }
                
                
                
             //   if($this->revisaImagenes($idser, $numrep,  $row ["sec_numseccion"])) { //muestro boton de imagenes
                    
//                     // verifica si hay imagenes y crea la liga
//                     $sql="SELECT
//                    id_ruta
//                     FROM
//                     ins_imagendetalle
//                     where ins_imagendetalle.id_imgclaveservicio='".$idser."' and
//                     ins_imagendetalle.id_imgnumreporte='".$numrep."' and
//                     ins_imagendetalle.id_imgnumseccion='".$row ["sec_numseccion"]."' and
//                     ins_imagendetalle.id_imgnumreactivo='';";
                    //             echo $sql;
                    $rs1=DatosImagenDetalle::consultaImagenDetalle($idser,$numrep,$row ["sec_numseccion"],'',"ins_imagendetalle");
                    
                    
                    
                    if (sizeof($rs1) > 0) {
                        $imagenes= "<a class=\"btn btn-block btn-info\" data-trigger=\"gallery_".$row["sec_numseccion"]."\"  href='index.php?action=indlistasecciones&tiposec=img&secc=".$idser.".".
                            $row ["sec_numseccion"] ."&numrep=".$numrep."'  ><i class=\"fa fa-image\"></i></a>";
                   
                    foreach($rs1 as $row_max ) {
                        
                        $rutaFoto="fotografias/".$row_max["id_ruta"];
                        
                        $imagenes.='<a href="'.$rutaFoto.'" data-caption="'.$row_max["id_descripcion"].'" data-fancybox="gallery_'.$row["sec_numseccion"].'"  style="display:none;">
                              foto
                                </a>';
                        
                    }
                    $secciones["celdaImg"]=$imagenes;
                    // $html->asignar('divImg',$divImg.$href."</div>");
                    
                }
                else
                    $secciones['celdaImg']="<a class=\"btn btn-block btn-info\" disabled>
<i class=\"fa fa-image\"></i></a>";
                    
                    /*             * ************************************************************************************************************* */
                    //excepcion para la liga de los datos generales
                    if( $row ["sec_numseccion"] ==1) {
                        $liga="index.php?action=indlistasecciones&tiposec=datos&cser=".$idser."&numrep=".$numrep."&prin=".$_SESSION["prin"]."&cli=".$idclien;
                        $OPD="";
                    }
                    else {
                        $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . $row ["sec_numseccion"] . "." . $iduneg;
                        $liga = "index.php?action=indlistasecciones&tiposec=" . $row["sec_tiposeccion"] . "&Op=";
                    }
                    $secciones['celdaSumniv']= "<a href='" . $liga . $OPD . "' class='btn btn-block btn-info' ><span style='font-size: 10px'>".T_("DETALLE")."</span></a>";
                    $this->listaSecciones[]=$secciones;
                    $cont++;
    }
    //$html->asignar('sumapondfinal', $sumapond);
   
    $infoarea=strtoupper(T_("No. de Reporte")) . " : " . $numrep;
    $this->titulo2=$infoarea;
    
   
    Navegacion::borrarRutaActual("d");
    $rutaact = $_SERVER['REQUEST_URI'];
    // echo $rutaact;
    Navegacion::agregarRuta("d", $rutaact, T_("SECCIONES"));
    }
    
    function revisaImagenes($idservicio,$idreporte,$idseccion) {
        $ban=0; //no hay fotos
      
        //             echo $sql;
        $rs1=DatosImagenDetalle::consultaImagenDetalle($idservicio,$idreporte,$idseccion,'',"ins_imagendetalle");
        
        //            if (mysql_num_rows($rs1) > 0) {
        
     
        if(sizeof($rs1)>0)
            return true;
            else
                return false;
    }
    
    public function nombreUnegocio($idune){
        if(isset($_SESSION["nombreune"])&&$_SESSION["nombreune"])
            return $_SESSION["nombreune"];
        else {
            return DatosUnegocio::nombrePV($idune);
        }
    }
    /**
     * @return  $nomunegocio
     */
    public function getNomunegocio()
    {
        return $this->nomunegocio;
    }

    /**
     * @return  $titulo1
     */
    public function getTitulo1()
    {
        return $this->titulo1;
    }

    /**
     * @return  $titulo2
     */
    public function getTitulo2()
    {
        return $this->titulo2;
    }

    /**
     * @return  $listaSecciones
     */
    public function getListaSecciones()
    {
        return $this->listaSecciones;
    }

    
    
}

