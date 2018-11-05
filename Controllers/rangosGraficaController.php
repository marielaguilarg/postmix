<?php
include "Models/crud_rangosgrafica.php";
//include "Models/crud_estandar.php";

class RangosGraficaController
{
    
    private $rango;
    private $listaRangos;
    private $listaSecciones;
    private $seccion;
    private $componentes;
    private $numop;
    private $mensaje;
    private $nombreSeccion;
    
    public function vistaListaSecciones(){
      
        
        $sqlsec="select cue_secciones.sec_numseccion, sec_nomsecesp, sec_nomsecing 
from cue_secciones 
inner join cue_reactivosestandardetalle on cue_secciones.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio
		and cue_secciones.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion
		where cue_reactivosestandardetalle.red_grafica=-1 and cue_reactivosestandardetalle.ser_claveservicio=1
		group by cue_secciones.sec_numseccion";
        $rs1=DatosEst::buscaSeccionesIndi(1,1);
    
        foreach($rs1 as $row1)
        {
           $renglon=array();
            $renglon["no"]=$row1[0];
            $renglon["desc"]=$row1[1];
           $renglon["det"]="index.php?action=srangosgraffrec&secc=".$row1[0];
           $this->listaSecciones[]=$renglon;
           
        }
        $navegacion=new Navegacion();
        $navegacion->iniciar();
        $navegacion->borrarRutaActual("secgraf");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        $navegacion::agregarRuta("secgraf", $rutaact, "SECCIONES GRAFICADAS");
      
    }
    
    public function insertarRango(){
        include "Utilerias/leevar.php";
        
        $id=1;
      
        $aux=explode('.',$componente);
        try{
        for($j=1;$j<=$num_rangos;$j++)
        {
            
            $valini="valinicial".$j;
            $valfin="valfinal".$j;
            
            $slq_ran="INSERT INTO `cnfg_rangosgrafica` (`red_servicio`,`red_numseccion`,`red_numreactivo`,`red_numcomponente`,`red_numcaracteristica`,`red_numcomponente2`,`red_numcaracteristica2`,`rg_valinicial`,`rg_valfinal`)
            VALUES ('".$id."','$aux[0]','$aux[1]','$aux[2]','$aux[3]','$aux[4]','$aux[5]','".$$valini."','".$$valfin."')";
            //echo $slq_ran;
            DatosRangosgrafica::insertarRango($id,$aux[0],$aux[1],$aux[2],$aux[3],$aux[4],$aux[5],$$valini,$$valfin,"cnfg_rangosgrafica");
          
        }
        $this->mensaje="<div class='alert alert-success'>El rango se insertó correctamente</div>";
        
        }catch(Exception $ex){
            $this->mensaje="<div class='alert alert-danger'>".$ex->getMessage()."</div>";
        }
       
        
    }
    public function borrarRango(){
        include "Utilerias/leevar.php";
        
      //  $id=$_SESSION['servicio'];
        
      //  $slq_ran="DELETE FROM `cnfg_rangosgrafica` WHERE (`rg_id`='".$_GET["id"]."')  ";
        //	echo $slq_ran;
        try{
        DatosRangosgrafica::eliminarRango($id,"cnfg_rangosgrafica");
        $this->mensaje="<div class='alert alert-success'>El rango se eliminó correctamente</div>";
        
        
         }catch(Exception $ex){
            $this->mensaje="<div class='alert alert-danger'>".$ex->getMessage()."</div>";
        }
        
        
    }
    
    public function vistaDetalleRango(){
        include "Utilerias/leevar.php";
        
        if($admin=="borrar"){
            $this->borrarRango();
        }
        else if($admin=="insertar"){
           
            $this->insertarRango();
            
        }
          //busco la seccion
        $this->nombreSeccion=DatosSeccion::nombreSeccionIdioma($secc,1,1);
      
        
//         foreach($row1=mysql_fetch_array($rs1))
//         {
            $_SESSION['servicio']=1;
//         }
        if(isset($numop))
            $componente=$numop;
            
            $numseccion=$secc;
           
            $this->seccion=$numseccion;
            
            $sqlcom="select cue_reactivosestandardetalle.sec_numseccion, cue_reactivosestandardetalle.r_numreactivo,
cue_reactivosestandardetalle.re_numcomponente, cue_reactivosestandardetalle.re_numcaracteristica, cue_reactivosestandardetalle.re_numcomponente2, cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing
from cue_reactivosestandardetalle 
inner join cue_reactivosestandar on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio and cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion
and cue_reactivosestandar.r_numreactivo=cue_reactivosestandardetalle.r_numreactivo and cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente
and cue_reactivosestandar.re_numcaracteristica=cue_reactivosestandardetalle.re_numcaracteristica and cue_reactivosestandar.re_numcomponente2=cue_reactivosestandardetalle.re_numcomponente2
where red_grafica=-1 and re_tipoevaluacion <>0 and cue_reactivosestandardetalle.sec_numseccion=".$numseccion;
            //echo "<br>".$sqlcom;
            $rs2=DatosEst::ConsultaAtributosxSec($numseccion);
            $ban=0;
            $cadop="";
            $subseccion=$componente;
            foreach($rs2 as $row2)
            {
                
                $numop=$row2["sec_numseccion"].".".$row2["r_numreactivo"].".".$row2["re_numcomponente"].".".$row2["re_numcaracteristica"].".".$row2["re_numcomponente2"].".".$row2["red_numcaracteristica2"];
                if($ban==0&&!isset($componente))
                {
                    $cadop.='<option value="'.$numop.'" selected>'.$row2["red_parametroesp"].'</option> ';
                    $subseccion=$numop;
                }
                else
                    
                    
                    if($numop==$subseccion)
                        $cadop.='<option value="'.$numop.'" selected>'.$row2["red_parametroesp"].'</option> ';
                        else
                            $cadop.='<option value="'.$numop.'" >'.$row2["red_parametroesp"].'</option> ';
                            
                            $ban++;
            }
        
            $this->componentes= $cadop;
            $this->numop=$subseccion;
            $sql_valores = "SELECT
cnfg_rangosgrafica.rg_id,
cnfg_rangosgrafica.red_servicio,
cnfg_rangosgrafica.red_numseccion,
cnfg_rangosgrafica.red_numreactivo,
cnfg_rangosgrafica.red_numcomponente,
cnfg_rangosgrafica.red_numcaracteristica,
cnfg_rangosgrafica.red_numcomponente2,
cnfg_rangosgrafica.red_numcaracteristica2,
cnfg_rangosgrafica.rg_valinicial,
cnfg_rangosgrafica.rg_valfinal
FROM
cnfg_rangosgrafica where cnfg_rangosgrafica.red_servicio=1 and
concat(red_numseccion,'.',red_numreactivo,'.',red_numcomponente,'.',red_numcaracteristica,'.',red_numcomponente2,'.',red_numcaracteristica2)='".$subseccion."'";
            //echo "<br>".$sql_valores;
            $rs_valores = DatosRangosgrafica::getRangoxReferencia(1,$subseccion);
            $num=1;
            if(sizeof($rs_valores)>0)
            {
                foreach($rs_valores as $row_valores)
                {
                   
                    $rango['numval']= $num++;
                    $rango['valmin']= $row_valores["rg_valinicial"];
                    $rango['valmax']=$row_valores["rg_valfinal"];
                    $rango['celdaDelsec']= $row_valores["rg_id"];
                  $this->listaRangos[]=$rango;
                  
                }
            }
            //para navegacion
            $navegacion=new Navegacion();
           
            $navegacion->borrarRutaActual("secgrafdet");
            $rutaact = $_SERVER['REQUEST_URI'];
            // echo $rutaact;
            $navegacion::agregarRuta("secgrafdet", $rutaact, $this->nombreSeccion);
    }
    
    
    public function vistaNuevoRango(){
        $this->numop=filter_input(INPUT_GET,"numop",FILTER_SANITIZE_STRING);
        $this->seccion=filter_input(INPUT_GET,"secc",FILTER_SANITIZE_STRING);
    }
    /**
     * @return mixed
     */
    public function getRango()
    {
        return $this->rango;
    }

    /**
     * @return mixed
     */
    public function getListaRangos()
    {
        return $this->listaRangos;
    }

    /**
     * @return mixed
     */
    public function getListaSecciones()
    {
        return $this->listaSecciones;
    }

    /**
     * @return mixed
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * @return string
     */
    public function getComponentes()
    {
        return $this->componentes;
    }

  
    public function getNumop()
    {
        return $this->numop;
    }
    /**
     * @return mixed
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }
    /**
     * @return mixed
     */
    public function getNombreSeccion()
    {
        return $this->nombreSeccion;
    }



    
    
    
    
}

