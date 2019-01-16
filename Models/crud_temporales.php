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
    
    public function eliminarEstadistica($Usuario){
    	
    	$sql_del_us = "delete from tmp_estadistica WHERE tmp_estadistica.usuario =:Usuario";
    	
    	
    	
    	$resulti=Conexion::conectar()->prepare($sql_del_us);
    	
    
    	
    	$resulti->bindParam(":Usuario", $Usuario);
    	
    	if (!$resulti->execute())
    		
    		throw new Exception("Hubo un error al eliminar");
    		
    		
    		
    }

}



