<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'simplexlsx.class.php';
class ImportadorExcelController{
    private $nombreArchivo;
    private $rutaArchivo;
    private $tabladestino;
    
    public function __construct($rutaArchivo,$nombreArchivo,$tabladestino){
        $this->nombreArchivo=$nombreArchivo;
        $this->rutaArchivo=$rutaArchivo;
        
        
    }
    
    public function importar(){
        $xlsx = new SimpleXLSX( $this->rutaArchivo."/".$this->nombreArchivo);
        $nuevorow=array();
      
      
        foreach($xlsx->rows() as $ren){
//            var_dump($ren);
//            echo "<br>";
            //me salto encabezados
            //para pasar solo las que tienen datos
            if($ren[0]!="")
            $nuevorow[]=$ren;
        }
         unset($nuevorow[0]);
            //envio $xlsx->rows() directo a mi consulta
                //inserto todo
       //  echo "casi llego";
            DatosUnegociosAsignados::insertarMultipleTemporal($nuevorow);
         


    }
    
}
