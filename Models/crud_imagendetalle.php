<?php



require_once "Models/conexion.php";

class DatosImagenDetalle

{

    

    public function consultaImagenDetalle($idser,$idreporte,$idnumseccion,$numreactivo, $tabla){

     

        $sql="SELECT

               *

                FROM ".

                $tabla."

                where ins_imagendetalle.id_imgclaveservicio=:idser and

                ins_imagendetalle.id_imgnumreporte=:idreporte and

                ins_imagendetalle.id_imgnumseccion=:idnumseccion and

                ins_imagendetalle.id_imgnumreactivo=:numreactivo";

        

                $stmt = Conexion::conectar()-> prepare($sql);

     

        $stmt-> bindParam(":idnumseccion", $idnumseccion, PDO::PARAM_INT);

        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);

        $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);

        $stmt-> bindParam(":numreactivo", $numreactivo, PDO::PARAM_INT);

        

        $stmt-> execute();

      

        $respuesta=$stmt->fetchall();

       

        

        if($stmt->errorInfo()[1]!=null)

        {

            //var_dump($stmt->errorInfo());

            throw new Exception("Error al ejecutar consulta en la bd");

            

        }

      

        return $respuesta;

        

        

    }

    

    public function getImagenDetalle($idser,$idreporte, $tabla){

        /*         * ******************************* consulta para saber si el reporte tiene imagenes ********************************** */

        $query_isec = "SELECT *

FROM ".$tabla."

where id_imgclaveservicio=:idser 

and id_imgnumreporte=:numrep ;";

                

        $stmt = Conexion::conectar()-> prepare($query_isec);

                

              

                $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);

                $stmt-> bindParam(":numrep", $idreporte, PDO::PARAM_INT);

               

                

                $stmt-> execute();

        //        $stmt->debugDumpParams();

                

                return $stmt->fetchall();

                

            

                

    }

    

    public function getImagenDetallePresentar($idser,$idreporte, $tabla){

        /*         * ******************************* consulta para saber si el reporte tiene imagenes ********************************** */

        $query_isec = "SELECT ins_imagendetalle.id_ruta, ins_imagendetalle.id_descripcion

FROM ".$tabla."

where id_imgclaveservicio=:idser

and id_imgnumreporte=:numrep AND ins_imagendetalle.id_presentar =  '-1' ;";

        

        $stmt = Conexion::conectar()-> prepare($query_isec);

        

        

        $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);

        $stmt-> bindParam(":numrep", $idreporte, PDO::PARAM_INT);

        

        

        $stmt-> execute();

        //        $stmt->debugDumpParams();

        

        return $stmt->fetchall();

        

        

    }

    public function insertarImagenDetalle($idser,$idreporte,$seccion,$reactivo,$ruta,$descripcion, $presentar,$tabla){
    	
    	/*         * ******************************* consulta para saber si el reporte tiene imagenes ********************************** */
    	
    	$query_isec = "SELECT
                    Max(ins_imagendetalle.id_idimagen) AS id
                    FROM
                   $tabla
                    where ins_imagendetalle.id_imgclaveservicio=:servicio and
                    ins_imagendetalle.id_imgnumreporte=:reporte and
                    ins_imagendetalle.id_imgnumseccion=:seccion and
                    ins_imagendetalle.id_imgnumreactivo=:reactivo;";
                   try{
    	$stmt = Conexion::conectar()-> prepare($query_isec);
    	$stmt-> bindParam(":servicio", $idser, PDO::PARAM_INT);
    	$stmt-> bindParam(":reporte", $idreporte, PDO::PARAM_INT);
    	$stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
    	$stmt-> bindParam(":reactivo", $reactivo, PDO::PARAM_INT);
    	$stmt-> execute();
    	
    	 $res=$stmt->fetch();
    	 if($res[0]>0){
    	 	$id=$res[0]+1;
    	 }
    	 else $id=1;
    	
    	 $sqlcu = "INSERT INTO `ins_imagendetalle` (`id_imgclaveservicio`,`id_imgnumreporte`,`id_imgnumseccion`,`id_imgnumreactivo`,`id_idimagen`,`id_ruta`,  `id_descripcion`,`id_presentar`)
         VALUES (:idser,:idreporte,:seccion,:reactivo,:id,:ruta,:descripcion, :presentar);";
    	 $stmt = Conexion::conectar()-> prepare($sqlcu);
    	 $stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
    	 $stmt-> bindParam(":idreporte", $idreporte, PDO::PARAM_INT);
    	 $stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
    	 $stmt-> bindParam(":reactivo", $reactivo, PDO::PARAM_INT);
    	 $stmt-> bindParam(":id", $id, PDO::PARAM_INT);
    	 $stmt-> bindParam(":ruta", $ruta, PDO::PARAM_STR);
    	 $stmt-> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
    	 $stmt-> bindParam(":presentar", $presentar, PDO::PARAM_STR);
    	 if( !$stmt-> execute()){
    	
    	 	throw new Exception("Hubo un error al insertar la imagen");
    	 }
    	
         }catch(Exception $ex){
                   	throw new Exception("Hubo un error al insertar la imagen");
         }
    	
    	
    	
    	
    }
    
    
    public function eliminarImagenDetalle($idser,$idreporte,$seccion,$reactivo,$id,$tabla){
    	
    	/*         * ******************************* consulta para saber si el reporte tiene imagenes ********************************** */
    	
    
                   try{
                   	$sql="DELETE FROM $tabla
WHERE id_imgclaveservicio=:servicio
and id_imgnumreporte=:reporte
and id_imgnumseccion=:seccion
and id_imgnumreactivo=:reactivo
and id_idimagen=:idimagen";
$stmt = Conexion::conectar()-> prepare($sql);
                   	$stmt-> bindParam(":servicio", $idser, PDO::PARAM_INT);
                   	$stmt-> bindParam(":reporte", $idreporte, PDO::PARAM_INT);
                   	$stmt-> bindParam(":seccion", $seccion, PDO::PARAM_INT);
                   	$stmt-> bindParam(":reactivo", $reactivo, PDO::PARAM_INT);
                   	$stmt-> bindParam(":idimagen", $id, PDO::PARAM_INT);
                  
                   	if( !$stmt-> execute()){
                   		$stmt->debugDumpParams();
                   		throw new Exception("Hubo un error al eliminar la imagen");
                   	}
                  
                   }catch(Exception $ex){
                   	throw new Exception("Hubo un error al eliminar la imagen");
                   }
                   
                   
                   
                   
    }
    

    

}



