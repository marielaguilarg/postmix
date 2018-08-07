<?php
namespace indpostmix;

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
    
  
    
    $ssql = "SELECT *
			 FROM ca_unegocios
			WHERE concat(cli_idcliente,'.',ser_claveservicio,'.',cue_clavecuenta,'.',une_claveunegocio)='" . $refer . "'";
    $this->nomunegocio = DatosUnegocio::nombrePV($iduneg);
   
    
    
    // asigna numero de reporte
    
    $this->titulo2= T_("REPORTE NO.")." : " . $numrep;
   
    $this->titulo1=T_("CONSULTA REPORTE");
 
  
    
    //muestra secciones
    $rs = DatosSeccion::vistaSeccionModel($idser,"cue_secciones");
    $sumapond = 0;
    $cont = 0;
    foreach ($rs as $row ) {
        if ($cont % 2 == 0) {
            $color = "subtitulo3";
        } else { //class="subtitulo31"
            $color = "subtitulo31";
        }
        $secciones['numsec']= "<td class='$color'>" . ($row ["sec_numseccion"]) . "</td>";
        if($_SESSION["idiomaus"]==2)
            $secciones['nomsec']= "<td class='$color'><div align='left'>" . $row ["sec_descripcioning"] . "</div></td>";
            else
                $secciones['nomsec']="<td class='$color'><div align='left'>" . $row ["sec_descripcionesp"] . "</div></td>";
                
                /*             * ************************************Busca Ponderacion********************************************* */
              
                
                
                
                $sqlp = "SELECT *
	         	 FROM cue_seccioncomentario
                         inner join ins_comentseccion ON ins_comentseccion.is_claveservicio = cue_seccioncomentario.ser_claveservicio AND ins_comentseccion.is_numseccion = cue_seccioncomentario.sec_numseccion AND ins_comentseccion.is_comentario = cue_seccioncomentario.sec_numcoment
				WHERE ser_claveservicio = '" . $idser . "'
			  	  AND sec_numseccion = " . $row ["sec_numseccion"]." and is_numreporte = '".$numrep."'";
                
                //          echo $sqlp;
                $rsp = @mysql_query($sqlp);
                $num_reg = @mysql_num_rows($rsp);
                if ($num_reg != 0) {
                    while ($rowp = @mysql_fetch_array($rsp)) {
                        
                        $secciones['celdaComent']= "<td class='$color' >" . "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=coment&secc=" . $idser . "." . $row ["sec_numseccion"] . "&referencia=" . $refer . "&numrep=" . $numrep . "'>" . "<img src='../img/agregar.png' height='20' width='20' border='0'></a></td>";
                    }
                } else {
                    $secciones['celdaComent']= "<td class='$color'></td>";
                }
                
                
                
                if(revisaImagenes($idser, $numrep,  $row ["sec_numseccion"])) { //muestro boton de imagenes
                    
                    // verifica si hay imagenes y crea la liga
                    $sql="SELECT
                   id_ruta
                    FROM
                    ins_imagendetalle
                    where ins_imagendetalle.id_imgclaveservicio='".$idser."' and
                    ins_imagendetalle.id_imgnumreporte='".$numrep."' and
                    ins_imagendetalle.id_imgnumseccion='".$row ["sec_numseccion"]."' and
                    ins_imagendetalle.id_imgnumreactivo='';";
                    //             echo $sql;
                    $rs1=mysql_query($sql);
                    
                    //            if (mysql_num_rows($rs1) > 0) {
                    $divImg='<div style="display:none;">';
                    $href="";
                    $i=1;
                    if($row_max = mysql_fetch_array($rs1))
                    {
                        $rutaFoto=$row_max["id_ruta"];
                        
                        $html->asignar('celdaImg',"<td  class='$color' ><div align='center'>".
                            "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=img&secc=".$idser.".".
                            $row ["sec_numseccion"] ."&numrep=".$numrep."'>".
                            "<img src='../img/camara.png' width='27' height='21' border='0'></a></div></td>");
                    }
                    while($row_max = mysql_fetch_array($rs1)) {
                        
                        $rutaFoto=$row_max["id_ruta"];
                        
                        $href.='<a href="../fotografias/'.$rutaFoto.'"  >
                        <img  src="../fotografias/'.$rutaFoto.'" width="120" height="120" alt="" /></a>';
                        /*	 $href.='<a href="../fotografias/'.$rutaFoto.'" class="lytebox"   data-lyte-options="group:seccion'.$cont.'" >
                         <img  src="../fotografias/'.$rutaFoto.'" width="120" height="120" alt="" /></a>';
                         */
                        
                    }
                    // $html->asignar('divImg',$divImg.$href."</div>");
                    
                }
                else
                    $html->asignar('celdaImg', "<td class='$color'></td>");
                    
                    /*             * ************************************************************************************************************* */
                    //excepcion para la liga de los datos generales
                    if( $row ["sec_numseccion"] ==1) {
                        $liga="MENprincipal.php?op=mindi&admin=Cconsec&tiposec=datos&cser=".$idser."&numrep=".$numrep."&prin=".$_SESSION["prin"]."&cli=".$idclien;
                        $OPD="";
                    }
                    else {
                        $OPD = $idclien . "." . $idser . "." . $numrep . "." . $idcuen . "." . $row ["sec_numseccion"] . "." . $iduneg;
                        $liga = "MENprincipal.php?op=mindi&admin=Cconsec&tiposec=" . $row["sec_tiposeccion"] . "&Op=";
                    }
                    $html->asignar('celdaSumniv', "<td class='$color' >" . "<a href='" . $liga . $OPD . "'>" . "<img src='../img/agregar.png' height='20' width='20' border='0'></a></td>");
                    $html->expandir('FILAS', '+tBusqueda');
                    $cont++;
    }
    //$html->asignar('sumapondfinal', $sumapond);
    $html->asignar('NRP', $numrep);
    $infoarea=strtoupper(T_("No. de Reporte")) . " : " . $numrep;
    $html->asignar('INFOAREA2', $nomunegocio."<br> ".$infoarea);
    
   
    Navegacion::borrarRutaActual("d");
    $rutaact = $_SERVER['REQUEST_URI'];
    // echo $rutaact;
    Navegacion::agregarRuta("d", $rutaact, T_("SECCIONES"));
    }
    
    function revisaImagenes($idservicio,$idreporte,$idseccion) {
        $ban=0; //no hay fotos
        $sql="SELECT
                   id_ruta
                    FROM
                    ins_imagendetalle
                    where ins_imagendetalle.id_imgclaveservicio='".$idservicio."' and
                    ins_imagendetalle.id_imgnumreporte='".$idreporte."' and
                    ins_imagendetalle.id_imgnumseccion='".$idseccion."' and
                    ins_imagendetalle.id_imgnumreactivo='';";
        //             echo $sql;
        $rs1=mysql_query($sql);
        
        //            if (mysql_num_rows($rs1) > 0) {
        
        while($row_max = mysql_fetch_array($rs1)) {
            $ban=1; //tiene almenos una
            break;
        }
        if($ban>0)
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
}

