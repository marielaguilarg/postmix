<?php
include "Models/crud_cnfgsurveydata.php";

class ConfiguracionSDController
{
    private $listaColumnas;
    private $mensaje;
    private $columna;
    public function vistaConfiguracion(){
        include "Utilerias/leevar.php";
        switch($admin) {
            case "actualizarC" :
                $this->actualizaColumna();
                break;
            case "actualizarR" :
              $this->actualizaRenglon();        
              break;
            case "borrar" :
              
                $this->borrar($id);
                // header("Location: MEprincipal.php?op=survey");
                break;
            case "insertar" :
               $this->insertarNuevaCol();
                break;
            case "cargar":
                $this->conf_surveydata();
        }
        
  
    
    
    $sqlc="select * from cnfg_surveydata order by surv_numerocol";
    //echo $sqlc;
    $rsc =DatosCnfgSurveyData::vistaCnfgSurveyData();
    
    $cont=0;
    foreach($rsc as $rowsd)
    {
        
        $columna['numerocol']=$rowsd["surv_numerocol"];
        $columna['tiporeac']=$rowsd["surv_tiporeactivo"];
        $columna['numeroreac']=$rowsd["surv_numeroreac"];
        $columna['descripcion']=$rowsd["surv_descripcion"];
        
        $columna['nombrecol']="<a href='index.php?action=seditasd&referencia=".$rowsd['surv_numerocol']."'>".$rowsd['surv_nombrecol']."</a>";
        $columna['numerorenglon']=" <a href='index.php?action=seditasd&referencia=".$rowsd['surv_numerocol']."'>".$rowsd['surv_numeroreng']."</a>";
        $columna['valor']=$rowsd["surv_valorini"];
        
       
        $cont++;
       $this->listaColumnas[]=$columna;
    }
    }
    
    
    function conf_surveydata()
    { include "Utilerias/leevar.php";
    
        try{
        $sql0="delete from cnfg_surveydata ";
        //	echo $sql0;
        DatosCnfgSurveyData::eliminarTodo("cnfg_surveydata");
        //para cue_reactivos
        $sql1="insert into cnfg_surveydata (surv_numerocol,surv_tiporeactivo,surv_numeroreac,surv_descripcion,surv_nombrecol)
	SELECT
	cue_reactivos.r_lugarsyd,'P',concat(cue_reactivos.sec_numseccion,'.',cue_reactivos.r_numreactivo),
	cue_reactivos.r_descripcionesp,
	cue_reactivos.r_descripcionesp
	FROM
	cue_reactivos
	WHERE
	cue_reactivos.r_syd =  '-1'
        and ser_claveservicio=1
	ORDER BY
	cue_reactivos.r_lugarsyd ASC";
        
        //para cue_reactivosabiertadetalle
        
        $sql2="insert into cnfg_surveydata (surv_numerocol,surv_tiporeactivo,surv_numeroreac,surv_descripcion,surv_nombrecol,surv_numeroreng)
		SELECT
		cue_reactivosabiertosdetalle.rad_lugarsyd,'A',concat(sec_numseccion,'.',r_numreactivo,'.',ra_numcomponente,'.',ra_numcaracteristica,
		'.',ra_numcomponente2,'.',rad_numcaracteristica2),rad_descripcionesp,
		rad_descripcionesp,1
		FROM
		cue_reactivosabiertosdetalle
		WHERE
		cue_reactivosabiertosdetalle.rad_syd =  '-1'
		ORDER BY
		cue_reactivosabiertosdetalle.rad_lugarsyd ASC";
        
        //para cue_reactivosestandardetalle
        $sql3="insert into cnfg_surveydata (surv_numerocol,surv_tiporeactivo,surv_numeroreac,surv_descripcion,surv_nombrecol,surv_numeroreng)
	SELECT
	cue_reactivosestandardetalle.red_lugarsyd,'E',
	concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,'.',
	cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2),
	cue_reactivosestandardetalle.red_parametroesp,
	cue_reactivosestandardetalle.red_parametroesp,1
	FROM
	cue_reactivosestandardetalle
	WHERE
	cue_reactivosestandardetalle.red_syd =  '-1'
	order by
	cue_reactivosestandardetalle.red_lugarsyd";
        $ren=1;
        $j=0;
        DatosCnfgSurveyData::ejecutarInsert($sql1);
         DatosCnfgSurveyData::ejecutarInsert($sql2);
         DatosCnfgSurveyData::ejecutarInsert($sql3);
         $this->mensaje='<div class="alert alert-success">Configuración exitosa</div>';
         echo Utilerias::enviarPagina("index.php?action=ssurveydata");
        }catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage().". Intente de nuevo</div>";
        }
    }
    function borrar($col)
    {
        
        $sql="DELETE FROM `cnfg_surveydata` WHERE (`surv_numerocol`='$col') ";
        try{
        DatosCnfgSurveyData::eliminarCnfgSurveyData($col,"cnfg_surveydata");
        $this->mensaje='<div class="alert alert-success">Columna eliminada</div>';
        echo Utilerias::enviarPagina("index.php?action=ssurveydata");
    }catch(Exception $ex){
        $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage()."</div>";
    }
    }
    
    public function insertarNuevaCol(){
        include "Utilerias/leevar.php";
        
        try{
       
        DatosCnfgSurveyData::insertarCnfgSurveyData($numcol, $tiporeac, $numreactivo, $descripcion, $nomcol, $numren, $valini, "cnfg_surveydata");
        $this->mensaje='<div class="alert alert-success">Columna agregada</div>';
        echo Utilerias::enviarPagina("index.php?action=ssurveydata");
        }catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage()."</div>";
        }
    }
    
    
    public function actualizaColumna(){
        include "Utilerias/leevar.php";
        
        
        $sSQL=("UPDATE `cnfg_surveydata` 
SET `surv_valorini`='$valini',`surv_numerocol`='$numcol',`surv_descripcion`='$descripcion',
`surv_nombrecol`='$nomcol', `surv_numeroreng`='$numren',`surv_valorini`='$valini' 
where surv_numerocol=".$numcol2." and `surv_numeroreac`='$reactivo'  LIMIT 1;");
       
        try{
        DatosCnfgSurveyData::editarCnfgSurveyData($numcol, $numcol2,  $reactivo, $descripcion, $nomcol, $numren, $valini, "cnfg_surveydata");
        $this->mensaje='<div class="alert alert-success">Columna actualizada</div>';
        echo Utilerias::enviarPagina("index.php?action=ssurveydata");
        }catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage()."</div>";
        }
        
    }
    
    public function actualizaRenglon(){
        
        include "Utilerias/leevar.php";
        
        $sSQL=("update cnfg_surveydata set surv_numeroreng=:numren where surv_numerocol=:numcol");
        //echo $sSQL;
        if (Conexion::ejecutarInsert($sSQL,array("numren"=>$numren,"numcol"=>$numcol)))
            header("Location: MEprincipal.php?op=survey");
            else echo "error al insertar";
    }
    ////////////////////////////////////////////////////////////////////////////////
    //																			  //
    //   codigo que despliega los datos a editar del surveydata					  //
    //  																		  //
    ////////////////////////////////////////////////////////////////////////////////
    public function vistaEditaColumna(){
        
        include "Utilerias/leevar.php";
        
        $idref = $referencia;
        
        $sqlr="select * from cnfg_surveydata where surv_numerocol=".$idref.";";
        
        $row=DatosCnfgSurveyData::getCnfgSurveyData($idref);
        
            $this->columna['NUMCOL']=$idref;
            $this->columna['NOMBRECOL']=$row['surv_nombrecol'];
            $this->columna['DESCRIP']=$row['surv_descripcion'];
            $this->columna['NUMREN']=$row['surv_numeroreng'];
            $this->columna['VALORINI']=$row['surv_valorini'];
            $this->columna['REACTIVO']=$row['surv_numeroreac'];
            
      
        
    }
    /**
     * @return mixed
     */
    public function getListaColumnas()
    {
        return $this->listaColumnas;
    }

    /**
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }
    /**
     * @return mixed
     */
    public function getColumna()
    {
        return $this->columna;
    }


    
    
}

