<<<<<<< HEAD
<?php


class DatosComentDetalle
{
    public function consultaComentDetalle($idser,$idreporte,$seccion, $tabla){
        $ssqlcom = "SELECT ins_comentdetalle.id_comentario FROM ".$tabla."
            WHERE concat(id_comnumseccion,'.',id_comreactivo)=:seccion  AND id_comclaveservicio=:idser  and id_comnumreporte=:idreporte";
        
        $stmt = Conexion::conectar()-> prepare($ssqlcom);
        
        $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
      
        $stmt-> execute();
        
        return $stmt->fetchall();
        
        $stmt->close();
    }
}
