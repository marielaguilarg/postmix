<?php


class DatosUnegocioController
{
    
    private $titulo;
    private $reporte;
    private $infoGeneral;
    private $unegocio;
    
    public function vistaDatosEstablecimiento(){
    
    //-----------------------------------
    //  inicializo etiquetas por idioma
    //  -----------------------------------
    
    $this->titulo=T_("INFORMACION GENERAL DEL ESTABLECIMIENTO");
   include "Utilerias/leevar.php";
    $lista = $numrep;
    $idser=$_SESSION["servicionind"];
    $cliente=$cli;
  
   
    
    /******************************************************/
    
    /*********** SUBTITULO DE LA SECCION****************/
   
    //echo $sql_titulo;
    $row_rs_sql_titulo = DatosGenerales::consultaReporteUnegocioInspector($lista,$idser);
  
        $idser=$row_rs_sql_titulo["i_claveservicio"];
     
        $this->unegocio= $row_rs_sql_titulo["une_descripcion"];
        $this->infoGeneral=array();
        //$html->asignar('FechaVisita',$row_rs_sql_titulo["i_fechavisita"]);
        $this->infoGeneral["FechaVisita"]=Utilerias::formato_fecha($row_rs_sql_titulo["i_fechavisita"]);
        $this->infoGeneral['Inspector']=$row_rs_sql_titulo["ins_nombre"];
        $this->infoGeneral['MesAsignacion']=$row_rs_sql_titulo["i_mesasignacion"];
        $this->infoGeneral['Reponsable']=$row_rs_sql_titulo["i_responsablevis"];
        $this->infoGeneral['Cargo']=$row_rs_sql_titulo["i_puestoresponsablevis"];
        $this->infoGeneral['HEntrada']=$row_rs_sql_titulo["horent"];
        $this->infoGeneral['HSalida']=$row_rs_sql_titulo["horsal"];
        $this->infoGeneral['HSanalisis']=$row_rs_sql_titulo["horana"];
        /***************************************************************************/
        $this->infoGeneral['ReporteN']=$row_rs_sql_titulo["i_numreporte"];
        $this->infoGeneral['PuntoVenta']=$row_rs_sql_titulo["une_descripcion"];
        $this->infoGeneral['IDPepsi']=$row_rs_sql_titulo["une_idpepsi"];
        $this->infoGeneral['IDCuenta']=$row_rs_sql_titulo["une_idcuenta"];
        $this->infoGeneral['Direccion1']=$row_rs_sql_titulo["une_dir_calle"];
        $this->infoGeneral['Direccion2']=$row_rs_sql_titulo["une_dir_numeroext"];
        $this->infoGeneral['Direccion3']=$row_rs_sql_titulo["une_dir_numeroint"];
        $this->infoGeneral['Direccion4']=$row_rs_sql_titulo["une_dir_manzana"];
        $this->infoGeneral['Direccion9']=$row_rs_sql_titulo["une_dir_lote"];
        $this->infoGeneral['Direccion6']=$row_rs_sql_titulo["une_dir_colonia"];
        $this->infoGeneral['Direccion5']=$row_rs_sql_titulo["une_dir_delegacion"];
        $this->infoGeneral['Direccion8']=$row_rs_sql_titulo["une_dir_cp"];
        $this->infoGeneral['Direccion7']=$row_rs_sql_titulo["une_dir_estado"];
        $this->infoGeneral['Direccion9']=$row_rs_sql_titulo["une_dir_municipio"];
        $this->infoGeneral['Direccion10']=$row_rs_sql_titulo["une_dir_telefono"];
        $this->infoGeneral['Direccion11']=$row_rs_sql_titulo["une_dir_referencia"];
        $this->infoGeneral['Direccion12']=$row_rs_sql_titulo["une_dir_lote"];
        /*************************************************************/
        $cvereg=$row_rs_sql_titulo["une_cla_region"];
        $sqlc="select * from ca_regiones where reg_clave='".$cvereg."'";
        
       
     
        $this->infoGeneral['compania']=Datosnuno::nombreNivel1($cvereg,"ca_nivel1");
      
        
        $cvepais=$row_rs_sql_titulo["une_cla_pais"];
      
         $this->infoGeneral['pais']=Datosndos::nombreNivel2($cvepais,"ca_nivel2");
      
        $cvezona=$row_rs_sql_titulo["une_cla_zona"];
        $this->infoGeneral['zona']=Datosntres::nombreNivel3($cvezona,"ca_nivel3");
        
        
        $cveedo=$row_rs_sql_titulo["une_cla_estado"];
      
        $this->infoGeneral['estado']=Datosncua::nombreNivel4($cveedo,"ca_nivel4");
        
        
        $cvecd=$row_rs_sql_titulo["une_cla_ciudad"];
      
        $this->infoGeneral['ciudad']=Datosncin::nombreNivel5($cvecd,"ca_nivel5");
       
        $cvefran=$row_rs_sql_titulo["une_cla_franquicia"];
        //$sqlc="select * from ca_franquicias where fra_clavefranquicia='".$cvefran."'";
         $this->infoGeneral['nivelseis']=Datosnsei::nombreNivel6($cvefran,"ca_nivel6");
      
    
    
  
    $this->reporte=T_("NO. DE REPORTE: ").$lista;
    //
    //$navegacion='<li><a href="MENindprincipal.php?op=mindi&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&niv=" style="z-index:9;">'.T_("GRAFICA").'</a></li>';
    //If($_SESSION["fbuscapv"]==1)
    //     $navegacion.='<li><a href="MENindprincipal.php?admin=buspv" style="z-index:8;">'.T_("BUSCAR PUNTO DE VENTA").'</a></li>';
    //  else
        //      $navegacion.='<li><a href="MENindprincipal.php?op=mindi&admin=cons&mes='.$_SESSION["fmes"].'&sec=5&filx='.$_SESSION["ffilx"].'&ref='.$_SESSION["fref"].'&niv='.$_SESSION["fniv"].'" style="z-index:8;">'.T_("INDICADORES").'</a></li>';
        // $navegacion.='     <li><a href="MENindprincipal.php?op=mindi&admin=datos&numrep='.$lista.'&cser=1&ccli=100" style="z-index:6;">'.$nomunegocio.'</a></li>
        // <li><a href="MENindprincipal.php?op=mindi&admin=seccion&numrep='.$lista.'&referencia=100.1.'.$idcuen.'.'.$idclaveuninegocio.'" style="z-index:5;">'.T_("SECCIONES").'</a></li>
        //
        //   <li><a href="#" style="z-index:4;">'.T_("DATOS GENERALES").'</a></li>';
   Navegacion:: borrarRutaActual("e");
    $rutaact = $_SERVER['REQUEST_URI'];
    // echo $rutaact;
    Navegacion::agregarRuta("e", $rutaact, T_("DATOS GENERALES"));
    }
    /**
     * @return Ambigous <unknown, string>
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @return string
     */
    public function getReporte()
    {
        return $this->reporte;
    }

    /**
     * @return multitype:
     */
    public function getInfoGeneral()
    {
        return $this->infoGeneral;
    }

    /**
     * @return mixed
     */
    public function getUnegocio()
    {
        return $this->unegocio;
    }

    
    
    
}

