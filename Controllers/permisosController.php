<?php
include "Models/crud_grupo.php";
include "Models/crud_permisos.php";

class PermisosController
{
    private $listaPermisos;
    private $IdGrup;
    private $grupo;
    private $titulo1;
    private $titulo2;
    private $titmenu;
    private $submenu;
    private $ids;
    private $subop;
    private $mensaje;
    
    public function vistaListaPermisos(){
        include ('Utilerias/leevar.php');
        switch($admin)
        {
            case "insertar" :
               $this->insertarPermiso();
               $id=$grupo;
                break;
            case	"borrar" :
              $this->borrarPermiso();
                break;
            case "actualizar" :
                include('./MESactualizapermiso.php');
                break;
                
                
        }
        
        $op2=$id;
    
        $this->IdGrup=$op2;
        $ssql= "SELECT *
			  FROM cnfg_grupos
			 WHERE cgr_clavegrupo='".$op2."'";
        $rs=DatosGrupo::getGrupo($op2,"cnfg_grupos");
       
        $this->grupo="GRUPO: ".$rs["cgr_nombregrupo"];
            
       
        $sqq= "SELECT cnfg_permisos.cpe_grupo,
				  cnfg_permisos.cpe_claveopcion,
				  cnfg_permisos.cpe_insertar,
				  cnfg_menu.men_nombreopcion,
				  cnfg_permisos.cpe_modificar,
				  cnfg_permisos.cpe_borrar
			 FROM cnfg_permisos
	   Inner Join cnfg_menu
	           ON cnfg_permisos.cpe_claveopcion = cnfg_menu.men_claveopcion
			WHERE cpe_grupo='".$op2."'";
        $rts=DatosPermisos::vistaPermisosMenu($op2);
        $cont=0;
        foreach ($rts as $row)
        {
          $permiso=array();
            $permiso['claveopcion']=$row["cpe_claveopcion"];
            $permiso['ID']=$row["cpe_grupo"];
            $permiso['borraid']=$row["cpe_claveopcion"];
            //$permiso['editapermiso']="<div align='left'>"."<a href='MESprincipal.php?op=Bgrup&admin=permisos&nuevo=E&id2=".$row["cpe_claveopcion"]."&id=".$op2."'>".$row["men_nombreopcion"]."</a></div></td>");
            $permiso['editapermiso']=$row["men_nombreopcion"];
            
            if ($row["cpe_insertar"]==0)
            {
                $permiso['insertap']= "No";
            }
            else
            {
                $permiso['insertap']= "Si";
            }
            if ($row["cpe_modificar"]==0)
            {
                $permiso['modificap']="No";
            }
            else
            {
                $permiso['modificap']= "Si";
            }
            if ($row["cpe_borrar"]==0)
            {
                $permiso['borrarp']=  "No";
            }
            else
            {
                $permiso['borrarp']=  "Si";
            }
         
            $cont++;
          $this->listaPermisos[]=$permiso;
        }//Termina foreach
        
    
    }
    
    public function insertarPermiso(){
       include "Utilerias/leevar.php";
        //echo $op2;
        //echo $combito;
        if ($ins) {
            $insdata=-1;
        }else{
            $insdata=0;
        }
        if ($mod) {
            $moddata=-1;
        }else{
            $moddata=0;
        }
        if ($borrar) {
            $bordata=-1;
        }else{
            $bordata=0;
        }
        try{
        if($subop>0)
        {
            $sSQL= "insert into cnfg_permisos(cpe_grupo,cpe_claveopcion,cpe_insertar,cpe_modificar,cpe_borrar)
 values ('$grupo','$combito',$insdata,$moddata,$bordata);";
            //echo $sSQL;
            DatosPermisos::insertarPermisos($grupo,$combito,$bordata,$moddata,$insdata,"cnfg_permisos");
            for($j=0;$j<$subop;$j++)
            {
                $val="submen_".$j;
                if($$val)
                {$sSQL= "insert into cnfg_permisos(cpe_grupo,cpe_claveopcion,cpe_insertar,cpe_modificar,cpe_borrar) 
values ('$grupo','".$$val."',$insdata,$moddata,$bordata);";
                
                DatosPermisos::insertarPermisos($grupo,$$val,$bordata,$moddata,$insdata,"cnfg_permisos");}
            }
        }
        else
        {
            $sSQL= "insert into cnfg_permisos(cpe_grupo,cpe_claveopcion,cpe_insertar,cpe_modificar,cpe_borrar) 
values ('$grupo','$combito',$insdata,$moddata,$bordata);";
            //echo $sSQL;
            DatosPermisos::insertarPermisos($grupo,$combito,$bordata,$moddata,$insdata,"cnfg_permisos");
        }
        
        $this->mensaje='<div class="alert alert-success">Permiso agregado</div>';
        }catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage()."</div>";
        }
       
    }
    
    public function borrarPermiso(){
        //cacha id adm etc
       include"Utilerias/leevar.php";
      
       
        //reviso si es le unico de un menu
        $query_rev="SELECT
cnfg_permisos.cpe_grupo,
cnfg_permisos.cpe_claveopcion,
cnfg_menu.men_claveopcion,
cnfg_menu.men_nombreopcion,
cnfg_menu.men_imagenopcion,
cnfg_menu.men_nivelopcion,
cnfg_menu.men_claseopcion,
cnfg_menu.men_nivel,
cnfg_menu.men_superopcion
FROM
cnfg_permisos
Inner Join cnfg_menu ON cnfg_permisos.cpe_claveopcion = cnfg_menu.men_claveopcion
WHERE
cnfg_permisos.cpe_grupo =  '".$op2."' AND
    
cnfg_permisos.cpe_claveopcion='".$id."';";
        $resv=DatosPermisos::vistaPermisosMenuxId($id,$id2);
  
        foreach( $resv as $rowv)
        {
            if($rowv["men_nivel"]==2)
            {
                $query2="select * FROM
cnfg_permisos
Inner Join cnfg_menu ON cnfg_permisos.cpe_claveopcion = cnfg_menu.men_claveopcion
WHERE
cnfg_permisos.cpe_grupo = :op2 AND
men_superopcion=:superopcion;";
                $parametros=array("op2"=>$id2,
                    "superopcion"=>$rowv["men_superopcion"]);
                $result2=Conexion::ejecutarQuery($query2,$parametros);
                if(sizeof($result2)==1)// no tiene otras opciones y se borra
                {	$query_b="Delete From cnfg_permisos where cpe_claveopcion = '".$rowv["men_superopcion"]."' and cpe_grupo='".$id2."' ";
                DatosPermisos::eliminarPermisos($rowv["men_superopcion"],$id2,"cnfg_permisos");
                }
                
               
            }
        }
      
        $sSQL="Delete From cnfg_permisos where cpe_claveopcion = '". $id."' and cpe_grupo='".$id2."' ";
        DatosPermisos::eliminarPermisos($id,$id2,"cnfg_permisos");
        $this->mensaje='<div class="alert alert-success">Permiso eliminado</div>';
        
    }
    
    public function vistaNuevo(){
        include "Utilerias/leevar.php";
        $op2 = $id;
        $this->grupo=$op2 ;
        
        //include ('MEleevar.php');
        $ssql= "SELECT *
			  FROM cnfg_grupos
			 WHERE cgr_clavegrupo='".$op2."'";
        $rs=DatosGrupo::getGrupo($op2,"cnfg_grupos");
        
        $this->titulo1="GRUPO: ".$rs["cgr_nombregrupo"];
        
        $sqle = "SELECT * FROM cnfg_menu where men_nivel=1 ";
        $rse = DatosPermisos::getMenuxNivel(1, "cnfg_menu");
        //		$html->asignar('cbox',"<option value='' selected='selected'>_</option>");
        //		$html->expandir('PERMISOS', 'buscacuenta');
        //echo $_POST["combito"];
        if(isset($combito))
        {	$menu=$combito;
        }
        $this->listaPermisos=array();
        foreach ( $rse as $row  ) {
            if($menu==$row ['men_claveopcion'])
                $select="selected";
                else $select="";
                $permiso['cbox']= "<option value='" . $row ['men_claveopcion'] . "'". $select.">" . $row ['men_nombreopcion'] . "</option>" ;
             
              $this->listaPermisos[]=$permiso;
        }
        
        $this->ids=$id;
       
        if ($menu!=""||$menu!=0) {
            $query2 = "SELECT
cnfg_menu.men_claveopcion,
cnfg_menu.men_nombreopcion,
cnfg_menu.men_imagenopcion,
cnfg_menu.men_nivelopcion,
cnfg_menu.men_claseopcion,
cnfg_menu.men_nivel,
cnfg_menu.men_superopcion
FROM
cnfg_menu
where men_superopcion='$menu'";
            $cbox="";
            $tabla="";
            $rs2 = DatosPermisos::getMenuxSuperopcion($menu, "cnfg_menu" );
            //		$html->asignar('cbox',"<option value='' selected='selected'>_</option>");
            //		$html->expandir('PERMISOS', 'buscacuenta');
            $tabla = '<div>';
            $i=0;
            foreach ($rs2 as  $row2  ) {
                $this->titmenu="Elija las opciones";
                //verifico si ya tiene la opcion para seleccionarla
                $sql_ver="SELECT cnfg_permisos.cpe_grupo, cnfg_permisos.cpe_claveopcion FROM cnfg_permisos
                            where cnfg_permisos.cpe_grupo='".$op2."' and cnfg_permisos.cpe_claveopcion='".$row2 ['men_claveopcion'] ."'";
                $res=DatosPermisos::getPermisosxGrupoOp($op2,$row2 ['men_claveopcion'] ,"cnfg_permisos");
                $checked="";
                foreach($res as $rowv)
                {
                    $checked="checked";
                }
                $cbox .= ' <div><input name="submen_' . $i . '" type="checkbox" value="' . $row2 ['men_claveopcion'] . '" '.$checked.' />'.$row2["men_nombreopcion"].'</div>';
                $i++;
            }
            $this->subop=$i;
            $tabla = $tabla . $cbox . '</div>';
            $this->submenu= $tabla ;
            
        }
       
      
    }
    /**
     * @return mixed
     */
    public function getListaPermisos()
    {
        return $this->listaPermisos;
    }

    /**
     * @return mixed
     */
    public function getIdGrup()
    {
        return $this->IdGrup;
    }

    /**
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @return mixed
     */
    public function getTitulo1()
    {
        return $this->titulo1;
    }

    /**
     * @return mixed
     */
    public function getTitulo2()
    {
        return $this->titulo2;
    }
    /**
     * @return string
     */
    public function getTitmenu()
    {
        return $this->titmenu;
    }

    /**
     * @return string
     */
    public function getSubmenu()
    {
        return $this->submenu;
    }

    /**
     * @return mixed
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @return number
     */
    public function getSubop()
    {
        return $this->subop;
    }
    /**
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }



    
    
}

