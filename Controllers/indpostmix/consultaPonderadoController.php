<?php
namespace indpostmix;

class ConsultaPonderadoController
{
    
    private $nombreuni;
    private $nombreSeccion;
    private $titulo;
    private $listaPonderados;
    private $nivelCumplimiento;

    
    public function vistaPonderado(){
        session_start();
        
        include "Utilerias/leevar.php";
        
      
        $Id = $Op;
        
        $tache = "<img src='../img/tache.png' width='20' height='20' border='0' alt='no cumple'>";
        $paloma = "<img src='../img/palomita.png' width='20' height='20' border='0' alt='cumple'>";
        
        
        $datini = Utilerias::obtienedato($Id, 1);
        $londat = Utilerias::obtienelon($Id, 1);
        $idclient = substr($Id, $datini, $londat);
        
        
        $datini = Utilerias::obtienedato($Id, 2);
        $londat = Utilerias::obtienelon($Id, 2);
        $idser = substr($Id, $datini, $londat);
        
        
        $datini = Utilerias::obtienedato($Id, 3);
        $londat = Utilerias::obtienelon($Id, 3);
        $idreporte = substr($Id, $datini, $londat);
        
        
        $datini = Utilerias::obtienedato($Id, 4);
        $londat = Utilerias::obtienelon($Id, 4);
        $idclavecuenta = substr($Id, $datini, $londat);
        
        
        $datini = Utilerias::obtienedato($Id, 5);
        $londat = Utilerias::obtienelon($Id, 5);
        $idnumseccion = substr($Id, $datini, $londat);
        
        
        $datini = Utilerias::obtienedato($Id, 6);
        $londat = Utilerias::obtienelon($Id, 6);
        $idclaveuninegocio = substr($Id, $datini, $londat);
     
        $nomuni =ConsultaSeccionesController::nombreUne($idclaveuninegocio);
     
        
        /* Crea nombre de seccion */
       
        //echo $ssql;
        $nomsec= DatosSeccion::nombreSeccionIdioma($idnumseccion,$idser,$_SESSION["idiomaus"]);
        $this->titulo= $row["sec_descripcioning"];
         
        
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
            
        $rse = DatosInspecciones::consultaInsDetalle($idser,$idreporte,$idnumseccion,$row["r_numreactivo"],"ins_detalle");
        $numRows =sizeof($rse);
            if ($numRows != 0) { // existe en la base
                foreach ($rse as $rowe) {
                    if ($rowe["id_aceptado"]) {
                        $valant = "checked";
                        $valant2=$paloma;
                        //$sumapond++;
                    } else {
                        $valant = "";
                        $valant2=$tache;
                    }
                    if ($rowe["id_noaplica"]) {
                        $valnoap = "checked";
                        $valant2="<strong>NA</strong>";
                    } else {
                        $valnoap = "";
                    }
                    $valcom = $rowe["id_comentario"];
                    $pondcta = $rowe["id_ponderacionreal"];
                }
            } else {
                $valant = "";
                $valcom = "";
                $valant2="";
            }
            //$sumapond=$sumapond+$pondcta;
            $resultado['numreac']= " <td class='$color' >
                <div align='left'>" . $row["r_numreactivo"] . "</td>";
            if($_SESSION["idiomaus"]==2)
                $resultado['descreac']= " <td class='$color' >
                    <div align='left'>" . $row["r_descripcioning"] . "</div></td>";
            else
                 $resultado['descreac']= " <td class='$color' >
                        <div align='left'>" . $row["r_descripcionesp"] . "</div></td>";
                    //			$html->asignar('checkreac'," <td class='$color'><div align='center'>".
                    //								 		"<input type='checkbox' disabled='disabled' name='chk".$row["r_numreactivo"]."' ".$valant."></div></td>");
                    //			$html->asignar('checknoap'," <td class='$color'><div align='center'>".
                    //								 		"<input type='checkbox' disabled='disabled' name='noap".$row["r_numreactivo"]."' ".$valnoap."></div></td>");
                    $resultado['checkreac']= " <td class='$color'><div align='center'>" . $valant2 . "</div></td>";
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
                    $ssqlcom = "SELECT ins_comentdetalle.id_comentario FROM ins_comentdetalle
            WHERE concat(id_comnumseccion,'.',id_comreactivo)='" . $idnumseccion . '.' . $row["r_numreactivo"]  . "' 
 AND id_comclaveservicio='" . $idser . "' and id_comnumreporte='" . $idreporte . "'";
                    
                    
                    $rsc = DatosComentDetalle::consultaComentDetalle($idser,$idreporte, $idnumseccion . '.' . $row["r_numreactivo"] ,"ins_comentdetalle");
                    $num_reg = sizeof($rsc);
                    if ($num_reg != 0) {
                        $resultado['comentario']= "<td class='$color'><div align='center'>" . "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=C&secc=" . $row["sec_numseccion"] . "." . $row["r_numreactivo"] . "&Op=" . $Id . "'>" . "<img src='../img/agregar.png' width='20' height='20' border='0'></a></div></td>";
                    } else {
                        $resultado['comentario']="<td class='$color'>
                            <div align='center'></div></td>";
                    }
                    /*     * ************************************************************************************************ */
                    $resultado['detareac']= "<td class='$color'>
                        <div align='center'></div></td>";
                    if ($row["r_tiporeactivo"] != "") {
                        if($this->buscaReactivos($row["r_tiporeactivo"], $idser, $idnumseccion, $row["r_numreactivo"])>0)
                            $resultado['detareac']= "<td class='$color'> <div align='center'>" . "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=" . $row["r_tiporeactivo"] . "&secc=" . $row["sec_numseccion"] . "." . $row["r_numreactivo"] . "&Op=" . $Id . "'>" . "<img src='../img/agregar.png' width='20' height='20' border='0'></a></div></td>";
                    }
                    
                    // verifica si hay imagenes y crea la liga
                  
                  
                    $rs1=DatosImagenDetalle::consultaComentDetalle($idser,$idreporte,$idnumseccion,ins_imagendetalle,"ins_imagendetalle");
                    
                    //            if (mysql_num_rows($rs1) > 0) {
                    $divImg='<div style="display:none;">';
                    $href="";
                    $i=1;
                    if(sizeof($rs1)>0) {
                        if($row_max = $rs1[0]) {
                            $rutaFoto=$row_max["id_ruta"];
                            /* $html->asignar('imagen',"<td  class='$color' ><div align='center'>".
                             "<a href='../fotografias/".$rutaFoto."' class='lytebox'   data-lyte-options='group:seccion".$cont."'>".
                             "<img src='../img/agregar.gif' width='27' height='21' border='0'></a></div></td>");*/
                            $resultado['imagen']="<td  class='$color' ><div align='center'>".
                                "<a href='MENprincipal.php?op=mindi&admin=Cconsec&tiposec=img&secc=".$idser.".".
                                $idnumseccion .".".$row["r_numreactivo"]."&numrep=".$idreporte."'>".
                                "<img src='../img/camara.png' width='20' height='22' border='0'></a></div></td>";
                        }
                        /* while($row_max = mysql_fetch_array($rs1)) {
                        
                        $rutaFoto=$row_max["id_ruta"];
                        
                        $href.='<a href="../fotografias/'.$rutaFoto.'" class="lytebox"   data-lyte-options="group:seccion'.$cont.'" >
                        <img  src="../fotografias/'.$rutaFoto.'" width="120" height="120" alt="" /></a>';
                        }
                        $html->asignar('divImg',$divImg.$href."</div>");*/
                    }
                    else     $resultado['imagen']= "<td class='$color'></td>";
                    
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
        // echo $rutaact;
        Navegacion::agregarRuta("e", $rutaact, T_("DETALLE"));
     
        
    }
      
        function buscaReactivos($tipoReac,$servicio,$seccion,$reactivo) {
            switch($tipoReac) {
                case 'A':$query="SELECT
    cue_reactivosabiertos.ser_claveservicio
    FROM
    cue_reactivosabiertos
    where cue_reactivosabiertos.ser_claveservicio='".$servicio."' and
    cue_reactivosabiertos.sec_numseccion='".$seccion."' and
    cue_reactivosabiertos.r_numreactivo='".$reactivo."';";
                break;
                case 'E':$query="SELECT
    cue_reactivosestandar.ser_claveservicio
    FROM
    cue_reactivosestandar
    where cue_reactivosestandar.ser_claveservicio='".$servicio."' and
    cue_reactivosestandar.sec_numseccion='".$seccion."' and
    cue_reactivosestandar.r_numreactivo='".$reactivo."'";
                break;
                
                
                
            }
            $rse = mysql_query($query);
            $numRows = @mysql_num_rows($rse);
            return $numRows;
    }

    }