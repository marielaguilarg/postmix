<?php


class DatosTemporales
{
    
    public function eliminarTemporal($cliente,$servicio,$reporte){
        $queryi="delete from  tmp_generales 
where i_idcliente = :i_idcliente
    AND i_claveservicio = :claveservicio
    AND i_numreporte =:numreporte;";
     
        $resulti=Conexion::conectar()->prepare($queryi);
        $resulti->bindParam(":i_idcliente", $cliente);
        $resulti->bindParam(":claveservicio", $servicio);
        $resulti->bindParam(":numreporte", $reporte);
        if (!$resulti->execute())
            throw new Exception("Hubo un error al eliminar");
       
    }
}

