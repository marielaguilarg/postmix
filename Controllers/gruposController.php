<?php
include "Models/crud_grupo.php";

class GruposController
{
    
    private $listaGrupos;
    private $mensaje;
    private $IDS;
    private $NOMESP;
    private $titulo1;
    private $titulo2;
    private $admin;
    
    public function control(){
        include ('Utilerias/leevar.php');
       
        switch($admin) {
            case "insertar" :
                $this->insertarGrupo();
                break;
                
            case "actualizar" :
                $this->actualizarGrupo();
                break;
            case "nuevo":
                $this->titulo1="AGREGAR GRUPO";
                $this->titulo2="Nuevo grupo";
                $this->admin="insertar";
                break;
            case "editar":
                $this->editarGrupo();
                break;
            case "permisos" :
                include('./MESpermiso.php');
                break;
            case "usuarios" :
                include('./MESusuarios.php');
                break;
                
          
               
        }
        
        $this->vistaListaGrupos();
    }
    
    public function vistaListaGrupos(){
        
       $ssql="SELECT *
				 FROM cnfg_grupos";
        $rs=DatosGrupo::vistaGrupos("cnfg_grupos");
        $cont=0;
       
        foreach( $rs as $row)
        {
            if($cont%2==0)
            {
                $color="subtitulo31";
            }
            else  //class="subtitulo31"
            {
                $color="subtitulo3";
            }
            $grupo=array();
            $grupo['clavegrupo']=$row["cgr_clavegrupo"];
            $grupo['editagrupo']="<a href='index.php?action=snuevogrupo&admin=editar&id=".$row["cgr_clavegrupo"]."'><strong>".$row["cgr_nombregrupo"]."</strong></a>";
            $grupo['borrargrupo']= $row["cgr_clavegrupo"].".".$row["cgr_nombregrupo"];
            $grupo['clavep']=$row["cgr_clavegrupo"];
            $grupo['ccolor']= $color;
            $cont++;
            $this->listaGrupos[]=$grupo;            
        }
        $navegacion=new Navegacion();
        $navegacion->iniciar();
        $navegacion->borrarRutaActual("grupos");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        $navegacion::agregarRuta("grupos", "index.php?action=slistagrupos", "GRUPOS");
        
    }
    
    public function insertarGrupo(){
       include "Utilerias/leevar.php";
    
       
        // genera clave de servicio, la consulta debe estar agrupada y debera presentar el numero maximo para obtenerlo
        $ssql="SELECT max(cgr_clavegrupo) as clavegroup
		 FROM cnfg_grupos;";
        try{
        $numgroup=DatosGrupo::ultimoGrupo("cnfg_grupos");
     
        $numgroup++;
        
        //procedimiento de insercion del servicio
        //$sSQL= "insert into cnfg_grupos (cgr_clavegrupo,cgr_nombregrupoesp,cgr_nombregrupoing) values ('$numgroup','$nomesp','$noming')";
        $sSQL= "insert into cnfg_grupos (cgr_clavegrupo,cgr_nombregrupo) values ('$numgroup','$nomesp')";
        DatosGrupo::insertarGrupo($numgroup,$nomesp,"cnfg_grupos");
        $this->mensaje='<div class="alert alert-success">La información se guardó correctamente</div>';
       $this->NOMESP="";
       echo Utilerias::enviarPagina("index.php?action=slistagrupos");
        }catch(Exception $ex){
            $this->mensaje='<div class="alert aler-danger">'.$ex->getMessage().". Intente nuevamente</div>";
        }
    }
    public function borrarGrupo(){
        $id = filter_input(INPUT_GET, "id",FILTER_SANITIZE_STRING);
        //$sSQL="Delete From cnfg_grupos Where concat(cgr_clavegrupo,'.',cgr_nombregrupoesp) like '". $id."'";
        //Borra el grupo seleccionado
        $sSQL="Delete From cnfg_grupos Where concat(cgr_clavegrupo,'.',cgr_nombregrupo) like '". $id."'";
        try{
       DatosGrupo::eliminarGrupo($id,"cnfg_grupos");
       $this->mensaje='<div class="alert alert-success"">Se actualizó el grupo correctamente</div>';
       echo Utilerias::enviarPagina("index.php?action=slistagrupos");
        }catch(Exception $ex){
        $this->mensaje='<div class="alert aler-danger">'.$ex->getMessage().". Intente nuevamente</div>";
    }
    }
    public function actualizarGrupo(){
     
        $error="";
        if ($error==""){
           include "Utilerias/leevar.php";
            
            $sSQL="update cnfg_grupos set cgr_nombregrupoesp='$nomesp', cgr_nombregrupoing='$noming' where cgr_clavegrupo='".$idper."'";
            try{
            DatosGrupo::actualizarGrupo($idper,$nomesp,"cnfg_grupos");
            $this->mensaje='<div class="alert alert-success"">Se actualizó el grupo correctamente</div>';
            echo Utilerias::enviarPagina("index.php?action=slistagrupos");
        }catch(Exception $ex){
            $this->mensaje='<div class="alert aler-danger">'.$ex->getMessage().". Intente nuevamente</div>";
        }
        }
    }
    
    public function editarGrupo(){
       include "Utilerias/leevar.php";
       $this->titulo1="GRUPOS";
       $this->titulo2="Editar grupo";
       $this->admin="actualizar";
        $op2=$id;
      
        $sqle="SELECT *
			 FROM cnfg_grupos
			WHERE cgr_clavegrupo = '".$op2."'";
        $row=DatosGrupo::getGrupo($op2,"cnfg_grupos");
        
            $this->IDS=$id;
            $this->NOMESP=$row['cgr_nombregrupo'];
            $this->NOMING=$row['cgr_nombregrupoing'];
            
        

        
    }
    /**
     * @return mixed
     */
    public function getListaGrupos()
    {
        return $this->listaGrupos;
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
    public function getIDS()
    {
        return $this->IDS;
    }

    /**
     * @return mixed
     */
    public function getNOMESP()
    {
        return $this->NOMESP;
    }
    /**
     * @return string
     */
    public function getTitulo1()
    {
        return $this->titulo1;
    }

    /**
     * @return string
     */
    public function getTitulo2()
    {
        return $this->titulo2;
    }
    /**
     * @return string
     */
    public function getAdmin()
    {
        return $this->admin;
    }




    
    
}

