<?php

require_once  "Models/conexion.php";

class DatosComentDetalle
{
    public function consultaComentDetalle($idser,$idreporte,$seccion, $tabla){
        $ssqlcom = "SELECT ins_comentdetalle.id_comentario FROM ".$tabla."
            WHERE concat(id_comnumseccion,'.',id_comreactivo)=:seccion  AND id_comclaveservicio=:idser  and id_comnumreporte=:idreporte";
        
        $stmt = Conexion::conectar()-> prepare($ssqlcom);
        
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_STR);
        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
      
        $stmt-> execute();
    
        return $stmt->fetchall();
        
        
    }
    
     public function consultaComentPond($idser,$idreporte,$seccion){
         $sqlcs = "SELECT ins_comentdetalle.id_comentario, rc_numcomentario, rc_descomentarioing, rc_descomentarioesp
    FROM ins_comentdetalle inner join cue_reactivoscomentarios on sec_numseccion=id_comnumseccion
    and r_numreactivo=id_comreactivo and ser_claveservicio=id_comclaveservicio and id_comentario=rc_numcomentario
    WHERE concat(id_comnumseccion,'.',id_comreactivo)=:seccion  AND id_comclaveservicio=:idser and id_comnumreporte=:idreporte;";
         
         $stmt = Conexion::conectar()-> prepare($sqlcs);
        
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_STR);
        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
        
        $stmt-> execute();
        
        return $stmt->fetchall();
        
       
    }
    
    public function consultaComentSeccion($idser,$idreporte,$seccion){
        $ssql_r = "select * from ins_comentseccion
            Inner Join cue_seccioncomentario 
ON ins_comentseccion.is_claveservicio = cue_seccioncomentario.ser_claveservicio
 AND ins_comentseccion.is_numseccion = cue_seccioncomentario.sec_numseccion AND ins_comentseccion.is_comentario = cue_seccioncomentario.sec_numcoment
WHERE is_numseccion=:seccion and is_numreporte = :idreporte and ins_comentseccion.is_claveservicio=:idser";
        
        $stmt = Conexion::conectar()-> prepare($ssql_r);
        
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
        
        $stmt-> execute();
        
        return $stmt->fetchall();
        
        
    }
}

