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

    

    

}



