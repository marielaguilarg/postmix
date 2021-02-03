<?php

include "Models/crud_graficaindicadores.php";

//include "Models/crud_estandar.php";

class ConfigGraficaIndiController
{
    

    private $listaSecciones;
    private $listareactivos;
    private $reactivossel;
    private $seccionsel;
 public $mensaje;
    
    public function vistaListaSecciones(){
      
        
        $sqlsec="select cue_secciones.sec_numseccion, sec_nomsecesp, sec_nomsecing 
from cue_secciones 
inner join cnfg_graficaindicadores on  cue_secciones.sec_numseccion=cnfg_graficaindicadores.gri_seccion
		
		group by cue_secciones.sec_numseccion";
        $rs1=Conexion::ejecutarQuery($sqlsec, null);
    
        foreach($rs1 as $row1)
        {
           $renglon=array();
            $renglon["no"]=$row1[0];
            $renglon["desc"]=$row1[1];
           $renglon["det"]="index.php?action=sedicionconfig&secc=".$row1[0];
           $this->listaSecciones[]=$renglon;
           
        }
        $navegacion=new Navegacion();
        $navegacion->iniciar();
        $navegacion->borrarRutaActual("secgraf");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        $navegacion::agregarRuta("secgraf", $rutaact, "SECCIONES GRAFICADAS");
      
    }
    
    public function insertarReactivo(){
       
        $seccion=filter_input(INPUT_POST, "seccion",FILTER_SANITIZE_STRING);
        $reactivosgraf=$_POST["reactivosgraf"];
    
      
      //  $aux=explode('.',$componente);
        try{
          
        for($j=0;$j< sizeof($reactivosgraf);$j++)
        {
            
            DatosGraficaIndicadores::insertarReactivo($seccion, $reactivosgraf[$j], $j+1, 'E');
          
        }
        $this->mensaje="<div class='alert alert-success'>El reactivo se editó correctamente</div>";
      //  echo "wwwwww". $this->mensaje;
       // echo Utilerias::enviarPagina("index.php?action=sconfiguragrafica&seccion=".$seccion);
      
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
        	
            DatosGraficaIndicadores::eliminarxSeccion($id, "cnfg_graficaindicadores");
        $this->mensaje="<div class='alert alert-success'>El reactivo se eliminó correctamente</div>";
        echo Utilerias::enviarPagina("index.php?action=srangosgraffrec&secc=".$secc);
        
         }catch(Exception $ex){
            $this->mensaje="<div class='alert alert-danger'>".$ex->getMessage()."</div>";
        }
        
        
    }
    
  
    
    public function vistaNuevoReactivo(){
          include "Utilerias/leevar.php";
          if($admin=="borrar"){
            $this->borrarRango();
        }
        else if($admin=="insertar"){
          //primero elimino todos los de la seccion
            DatosGraficaIndicadores::eliminarxSeccion($seccion, "cnfg_graficaindicadores");
            $this->insertarReactivo();
            
        }
       
       //busco las secciones estandar
        $sqlsec="select cue_secciones.sec_numseccion, sec_nomsecesp
from cue_secciones where sec_tiposeccion='E' and cue_secciones.ser_claveservicio=1";
        $rs1=Conexion::ejecutarQuery($sqlsec, null);
    
       
        $this->listaSecciones=$rs1;
        
          if(isset($seccion)&&$seccion!=""){
      
//busco los reactivos disponibles que no han sido seleccionados
   
        $sql="  select CONCAT(
    cue_reactivosestandardetalle.sec_numseccion,
    '.',
    cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,
    '.',
    cue_reactivosestandardetalle.re_numcaracteristica,
    '.',
    cue_reactivosestandardetalle.re_numcomponente2,
    '.',
    red_numcaracteristica2) as refer, cue_reactivosestandardetalle.red_parametroesp, re_descripcionesp
        from cue_reactivosestandardetalle
        inner join cue_reactivosestandar
        on cue_reactivosestandar.ser_claveservicio=cue_reactivosestandardetalle.ser_claveservicio
        and cue_reactivosestandar.sec_numseccion=cue_reactivosestandardetalle.sec_numseccion and  
       cue_reactivosestandar.r_numreactivo= cue_reactivosestandardetalle.r_numreactivo and 
        cue_reactivosestandar.re_numcomponente=cue_reactivosestandardetalle.re_numcomponente and 
        cue_reactivosestandar.re_numcaracteristica= cue_reactivosestandardetalle.re_numcaracteristica and 
        cue_reactivosestandar.re_numcomponente2= cue_reactivosestandardetalle.re_numcomponente2
         where /*re_tipoevaluacion <>0 
  and*/ cue_reactivosestandardetalle.ser_claveservicio=1 and cue_reactivosestandardetalle.sec_numseccion=:seccion
  /* and  CONCAT(
    cue_reactivosestandardetalle.sec_numseccion,
    '.',
    cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,
    '.',
    cue_reactivosestandardetalle.re_numcaracteristica,
    '.',
    cue_reactivosestandardetalle.re_numcomponente2,
    '.',
    red_numcaracteristica2) not in(SELECT 
    `cnfg_graficaindicadores`.`gri_reactivo`
FROM `cnfg_graficaindicadores`
where gri_seccion=cue_reactivosestandardetalle.sec_numseccion )*/   ";
        $res=Conexion::ejecutarQuery($sql, array("seccion"=> $seccion));
 	
    
 	$this->listareactivos=$res;
        //busco los reactiovos que ya están seleccionados
          $this->reactivossel= DatosGraficaIndicadores::getReactivosxSeccion($seccion);
        //  var_dump( $this->reactivossel);
          $this->seccionsel=$seccion;
          }
      
    }
    function getListaSecciones() {
        return $this->listaSecciones;
    }

    function getReactivossel() {
        return $this->reactivossel;
    }


    function getListareactivos() {
        return $this->listareactivos;
    }
    function getSeccionsel() {
        return $this->seccionsel;
    }



    
    
}

