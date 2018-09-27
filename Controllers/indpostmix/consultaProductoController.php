<?php
include "Controllers/indpostmix/consultaSeccionesController.php";

class ConsultaProductoController
{
    
    private $unegocio;
    private $titulo1;
    private $nombreSeccion;
    private $listaProductos;
    private $totpond;
    
    public function vistaListaProducto(){
        include "Utilerias/leevar.php";
        
        
        
        $Id = $Op;
        
        $datini=SubnivelController::obtienedato($Id,1);
        $londat=SubnivelController::obtienelon($Id,1);
        $idclient=substr($Id,$datini,$londat);
        
        $datini=SubnivelController::obtienedato($Id,2);
        $londat=SubnivelController::obtienelon($Id,2);
        $idser=substr($Id,$datini,$londat);
        
        
        $datini=SubnivelController::obtienedato($Id,3);
        $londat=SubnivelController::obtienelon($Id,3);
        $idreporte=substr($Id,$datini,$londat);
        
        $datini=SubnivelController::obtienedato($Id,4);
        $londat=SubnivelController::obtienelon($Id,4);
        $idclavecuenta=substr($Id,$datini,$londat);
        
        $datini=SubnivelController::obtienedato($Id,5);
        $londat=SubnivelController::obtienelon($Id,5);
        $idnumseccion=substr($Id,$datini,$londat);
        
        
        $datini=SubnivelController::obtienedato($Id,6);
        $londat=SubnivelController::obtienelon($Id,6);
        $idclaveuninegocio=substr($Id,$datini,$londat);
        
        /***********************************************************/
        if ($secc) {
            
            $seccioncompuesta=$secc;
        }
        
        $numsec=$secc;
        
        
        //obtinee datos
        $datinis=SubnivelController::obtienedato($secc,1);
        $londats=SubnivelController::obtienelon($secc,1);
        
        $numsec=substr($secc,$datinis,$londats);
        
        $datinir=SubnivelController::obtienedato($secc,2);
        $londatr=SubnivelController::obtienelon($secc,2);
        
        $numreac=substr($secc,$datinir,$londatr);
        
        $datinico=SubnivelController::obtienedato($secc,3);
        $londatco=SubnivelController::obtienelon($secc,3);
        
        $numcom=substr($secc,$datinico,$londatco);
        if ($numreac) {
        }
        else {
            $numreac=0;
        }
        $vidiomau=$_SESSION["idiomaus"];
        // $numsec=$numseccom;
        $nomuni=ConsultaSeccionesController::nombreUnegocio($idclaveuninegocio);
        
        $rss=DatosSeccion::editaSeccionModel($idnumseccion,$idser,"cue_secciones");
        
        if ($vidiomau == 2) {
            $nomcampo = "sec_descripcioning";
        } else {
            
            
            $nomcampo = "sec_descripcionesp";
        }
        $pondsec=$rss["sec_ponderacion"];
        $nomseccion = $rss[$nomcampo] ;
         
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
            $producto['num']= $rowd["ip_numrenglon"];
            $producto['numsis']= $rowd["ip_numsistema"];
            // busca el nombre del producto
            
            $prod=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",2,$rowd["ip_descripcionproducto"]);
          
           
            $producto['prod']= $prod;
       
            $producto['cajas']= $rowd["ip_numcajas"];
            if($rowd["ip_sinetiqueta"]=="-1") {
                $producto['fecprod']="";
                $producto['feccad']= "";
                $producto['condic']= "Sin etiqueta";
                $producto['edadd']= "";
                $producto['sem']= "";
            }
            else {
                $producto['fecprod']= SubnivelController::cambiaf_a_normal($rowd["ip_fechaproduccion"]);
                $producto['feccad']= SubnivelController::cambiaf_a_normal($rowd["ip_fechacaducidad"]);
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
                    
                    $producto['condic']= $condicionV;
                    $sumcajaV=$sumcajaV+$rowd["ip_numcajas"];
                }
                else {
                    
                    $producto['condic']= "<span  class='text-red'>".$condicionC."</span>";
                }
                $sumcajaT=$sumcajaT+$rowd["ip_numcajas"];
                $producto['edadd']= $rowd["ip_edaddias"];
                $producto['sem']= $rowd["ip_semana"];
            }
            //    if ($rowd["ip_estatus"]=="I") {
            //        $estatus="INSTALADO";
            //    }
            //    else {
            //        $estatus="ALMACENADO";
            //    }
            $producto['estatus']= $estatus;
            
            $this->listaProductos[]=$producto;
            $cont++;
        }
        if ($sumcajaT>0) {
            $totpond=($sumcajaV*100)/$sumcajaT;
        }
        $tpond=number_format($totpond);
        $this->totpond=$tpond;
        
        
        // 2. multiplica y obtiene la ponderacion real
        $valreal=($tpond*$pondsec)/100;
        
        
        
        $infoarea=strtoupper(T_("No. de Reporte")) . " : " . $idreporte;
        $this->titulo1= $infoarea;
        
        
        Navegacion::borrarRutaActual("e");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("e", $rutaact, T_("DETALLE"));
        
        
        
        // $html->asignar('REGRESAR', "MEIprincipal.php?op=editarep&referencia=".$refer."&numrep=".$numrep);
        
        
        
    }
    /**
     * @return  $unegocio
     */
    public function getUnegocio()
    {
        return $this->unegocio;
    }
    
    /**
     * @return  $titulo1
     */
    public function getTitulo1()
    {
        return $this->titulo1;
    }
    
    /**
     * @return  $nombreSeccion
     */
    public function getNombreSeccion()
    {
        return $this->nombreSeccion;
    }
    
    /**
     * @return  $listaProductos
     */
    public function getListaProductos()
    {
        return $this->listaProductos;
    }
    /**
     * @return string
     */
    public function getTotpond()
    {
        return $this->totpond;
    }

    
    
    
}

