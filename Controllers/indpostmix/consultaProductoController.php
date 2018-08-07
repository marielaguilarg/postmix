<?php
namespace indpostmix;

class ConsultaProductoController
{
    
    private $unegocio;
    private $titulo1;
    private $nombreSeccion;
    private $listaProductos;
    
    
    public function vistaListaProducto(){
        include "Utilerias/leevar.php";
        
        
        
        $Id = $Op;
        
        $datini=Utilerias::obtienedato($Id,1);
        $londat=Utilerias::obtienelon($Id,1);
        $idclient=substr($Id,$datini,$londat);
        
        $datini=Utilerias::obtienedato($Id,2);
        $londat=Utilerias::obtienelon($Id,2);
        $idser=substr($Id,$datini,$londat);
        
        
        $datini=Utilerias::obtienedato($Id,3);
        $londat=Utilerias::obtienelon($Id,3);
        $idreporte=substr($Id,$datini,$londat);
        
        $datini=Utilerias::obtienedato($Id,4);
        $londat=Utilerias::obtienelon($Id,4);
        $idclavecuenta=substr($Id,$datini,$londat);
        
        $datini=Utilerias::obtienedato($Id,5);
        $londat=Utilerias::obtienelon($Id,5);
        $idnumseccion=substr($Id,$datini,$londat);
        
        
        $datini=Utilerias::obtienedato($Id,6);
        $londat=Utilerias::obtienelon($Id,6);
        $idclaveuninegocio=substr($Id,$datini,$londat);
        
        /***********************************************************/
        if ($secc) {
            
            $seccioncompuesta=$secc;
        }
        
        $numsec=$secc;
        
        
        //obtinee datos
        $datinis=Utilerias::obtienedato($secc,1);
        $londats=Utilerias::obtienelon($secc,1);
        
        $numsec=substr($secc,$datinis,$londats);
        
        $datinir=Utilerias::obtienedato($secc,2);
        $londatr=Utilerias::obtienelon($secc,2);
        
        $numreac=substr($secc,$datinir,$londatr);
        
        $datinico=Utilerias::obtienedato($secc,3);
        $londatco=Utilerias::obtienelon($secc,3);
        
        $numcom=substr($secc,$datinico,$londatco);
        if ($numreac) {
        }
        else {
            $numreac=0;
        }
        $vidiomau=$_SESSION["idiomaus"];
        // $numsec=$numseccom;
        $nomuni=ProductoController::nombreUnegocio($idclaveuninegocio);
        
        $rss=DatosSeccion::editaSeccionModel($idnumseccion,$idser,"cue_secciones");
        if ($vidiomau == 2) {
            $nomcampo = "sec_nomsecing";
        } else {
            
            
            $nomcampo = "sec_nomsecesp";
        }
        
        foreach ($rss as $rows) {
            $pondsec=$rows["sec_ponderacion"];
            $nomseccion = $rows[$nomcampo] ;
            
        }
        
        
        $this->nombreSeccion=$idnumseccion." ".$nomseccion;
        $this->unegocio=$nomuni;
        
        // asigna numero de reporte
        $numrep=$idreporte;
        
        
        
        // busca registros
        $sumcajaT=0;
        $sumcajaV=0;
        
        $rscu=DatosProducto::getDetalleProducto($idser,$idnumseccion,$numrep);
        $cont=0;
        foreach ($rscu as $rowd) {
            if($cont%2==0) {
                $color="subtitulo3";
            }
            else {
                $color="subtitulo31";
            }
            $producto['num']= "<td class='$color'>".$rowd["ip_numrenglon"]."</td>";
            $producto['numsis']= "<td class='$color'>".$rowd["ip_numsistema"]."</td>";
            // busca el nombre del producto
            
            $rspr=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",2,$rowd["ip_descripcionproducto"]);
            if($_SESSION["idiomaus"]==2)
                foreach ($rspr as $rowpr) {
                    $producto['prod']= "<td class='$color'>".$rowpr["cad_descripcioning"]."</td>";
                }
            else
                foreach ($rspr as $rowpr) {
                    $producto['prod']= "<td class='$color'>".$rowpr["cad_descripcionesp"]."</td>";
                }
            $producto['cajas']= "<td class='$color'>".$rowd["ip_numcajas"]."</td>";
            if($rowd["ip_sinetiqueta"]=="-1") {
                $producto['fecprod']="<td class='$color'></td>";
                $producto['feccad']= "<td class='$color'></td>";
                $producto['condic']= "<td class='$color'>Sin etiqueta</td>";
                $producto['edadd']= "<td class='$color'></td>";
                $producto['sem']= "<td class='$color'></td>";
            }
            else {
                $producto['fecprod']= "<td class='$color'>".SubnivelController::cambiaf_a_normal($rowd["ip_fechaproduccion"])."</td>";
                $producto['feccad']= "<td class='$color'>".SubnivelController::cambiaf_a_normal($rowd["ip_fechacaducidad"])."</td>";
                if($_SESSION["idiomaus"]==2) {
                    
                    $condicionV="CURRENT";
                    $condicionC="EXPIRED";
                    if ($rowd["ip_estatus"]=="I") {
                        $estatus="INSTALLED";
                    }
                    else {
                        $estatus="STORAGE";
                    }
                }
                else {
                    $condicionV="VIGENTE";
                    $condicionC="CADUCO";
                    if ($rowd["ip_estatus"]=="I") {
                        $estatus="INSTALADO";
                    }
                    else {
                        $estatus="ALMACENADO";
                    }
                }
                
                if ($rowd["ip_condicion"]=="V") {
                    
                    $producto['condic']= "<td class='$color'>".$condicionV."</td>";
                    $sumcajaV=$sumcajaV+$rowd["ip_numcajas"];
                }
                else {
                    
                    $producto['condic']= "<td class='$color'><div align='center' class='caduco'>".$condicionC."</div></td>";
                }
                $sumcajaT=$sumcajaT+$rowd["ip_numcajas"];
                $producto['edadd']= "<td class='$color'>".$rowd["ip_edaddias"]."</td>";
                $producto['sem']= "<td class='$color'>".$rowd["ip_semana"]."</td>";
            }
            //    if ($rowd["ip_estatus"]=="I") {
            //        $estatus="INSTALADO";
            //    }
            //    else {
            //        $estatus="ALMACENADO";
            //    }
            $producto['estatus']= "<td class='$color'>".$estatus."</td>";
            $producto['borrar']= "<td class='$color' disabled='disabled'>".
                "<a href='MEIprincipal.php?op=V&secc=".$secc.".".$rowd["ip_numrenglon"]."&admin=eliminar'>".
                "<img src='../img/borrar.gif' width='27' height='21' border='0' ></a></td></tr>";
            $this->listaProductos[]=$producto;
            $cont++;
        }
        if ($sumcajaT>0) {
            $totpond=($sumcajaV*100)/$sumcajaT;
        }
        $tpond=number_format($totpond);
        $producto['TOTPOND']=$tpond;
        
        
        // 2. multiplica y obtiene la ponderacion real
        $valreal=($tpond*$pondsec)/100;
        
        
        
        $infoarea=strtoupper(T_("No. de Reporte")) . " : " . $idreporte;
        $this->titulo= $infoarea;
        
        
        Navegacion::borrarRutaActual("e");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("e", $rutaact, T_("DETALLE"));
        
        
        
        // $html->asignar('REGRESAR', "MEIprincipal.php?op=editarep&referencia=".$refer."&numrep=".$numrep);
        
        
        
    }
    /**
     * @return the $unegocio
     */
    public function getUnegocio()
    {
        return $this->unegocio;
    }
    
    /**
     * @return the $titulo1
     */
    public function getTitulo1()
    {
        return $this->titulo1;
    }
    
    /**
     * @return the $nombreSeccion
     */
    public function getNombreSeccion()
    {
        return $this->nombreSeccion;
    }
    
    /**
     * @return the $listaProductos
     */
    public function getListaProductos()
    {
        return $this->listaProductos;
    }
    
}

