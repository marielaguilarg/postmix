<?php
namespace postmix\Controllers;

class DescImagenesController
{
    
    public function descargarImagenes(){
        // crea archivo "al vuelo" pero sin subcarpetas
        define('RAIZ',"../fotografias");
        ini_set('max_execution_time', 1200);
        ini_set("memory_limit","500M");
        
        # load zipstream class
        require '../libs/zipstream.php';
        
        require "Utilerias/leevar.php";
        
        $arr_arch=array();
        $cont=0;
        $ricliente=$crcliente;
        $riservicio=$crservicio;
        $ricuenta=$cuenta;
        if($ricliente!=0)
            
            if($riservicio!=0) {
                if($ricuenta!=0) {
                    $arr_cue[$ricuenta]=buscaImagenesXFecha($fechainicio, $fechainicio2, $fechafin, $fechafin2, $riservicio, $ricuenta);
                    $arr_arch[$riservicio]=$arr_cue;
                    
                    
                    
                }
                else // todas las cuentas
                {
                    // con periodo
                    
                    $arr_arch[$riservicio]=buscaImagenesXServicio($fechainicio, $fechainicio2, $fechafin, $fechafin2, $riservicio);
                    
                }
            }
        else {// todos los servicios
            // con periodo
            // busco los servicios
            $sql_serv="SELECT
        `ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp` FROM `muestreo`.`ca_servicios`
        where `ca_servicios`.`cli_idcliente`='$ricliente';";
            $rs_serv = mysql_query($sql_serv);
            while($row_cuentas = @mysql_fetch_array($rs_serv)) {   //para cada cuenta busco los meses seleccionados
                $servicio=$row_cuentas[0];
                if(is_dir(RAIZ."/".$servicio))// verifico que exista la carpeta
                    
                    $arr_arch[$servicio] =buscaImagenesXServicio($fechainicio, $fechainicio2, $fechafin, $fechafin2, $servicio);
                    
            }
            
        }
        else {//todos los clientes
            //con periodo
            // busco todos los servicios
            $sql_serv="SELECT
        `ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp` FROM `muestreo`.`ca_servicios`;";
            $rs_serv = mysql_query($sql_serv);
            while($row_cuentas = @mysql_fetch_array($rs_serv)) {   //para cada cuenta busco los meses seleccionados
                $servicio=$row_cuentas[0];
                if(is_dir(RAIZ."/".$servicio))// verifico que exista la carpeta
                    $arr_arch[$servicio] =buscaImagenesXServicio($fechainicio, $fechainicio2, $fechafin, $fechafin2, $servicio);
                    
            }
            
            
        }
        //echo "--".$sql_serv;
        //die();
        //var_dump( $arr_arch);
        $files = RAIZ;
        $arch_zip="imagenes_".date("dmyHi").".zip";
        //$op=array("large_file_method"=>"store","content_type"=>'application/x-zip',"content_disposition"=>'attachment; filename=\"test.zip"' );
        $op="";
        $zip = new ZipStream($arch_zip,$op);
        
        foreach ($arr_arch as $key => $arrc) {
            //    echo "servicio ".$key;
            foreach ($arrc as $key2=>$value) {
                //        echo "--cuenta ".$key2."<br/>";
                // var_dump($value);
                foreach($value as $key3=>$value3 ) {
                    //agrego archivos
                    //$directorio=RAIZ."/".$value3;
                    $directorio=$value3;
                    //  echo '--mes <a href="MESlistaimagenes.php?f='.RAIZ."/".$value3.'">'.$value3."</a><br/>";
                    //Llamámos a la función para comprimir
                    //          echo $directorio."<br>";
                    //          echo strpos ($directorio , "/",4);
                    //
                    //
                    //
                    //         echo  substr($directorio,strlen(RAIZ)+1);
                    comprimirDirectorio($directorio, $zip);
                    
                }
            }
        }
        
        
        $zip->finish();
        
        $_SESSION["arch_borrar"]=$arr_arch;
        
        //header('Location: MESlistaimagenes.php');
        
        //echo "total de archivos".$cont;
        ////
        //echo 'HAGA  CLICK EN LA SIGUIENTE LIGA PARA DESCARGAR EL ARCHIVO Y ELIJA GUARDARLO EN SU EQUIPO<br>
        //   <a href="MENdescargaarchivo.php?f='.$arch_zip.'">DESCARGAR ARCHIVO</a><br/>';
        //////$referencia=$ricliente.".".$riservicio.".".$ricuenta;
        //echo 'HAGA  CLICK EN LA SIGUIENTE LIGA PARA BORRAR LOS ARCHIVOS<br>
        //  <a href="MESprincipal.php?op=respimg&adm=del&ref='.$referencia.'&feci='.$fechainicio.'.'.$fechainicio2.'&fecf='.$fechafin.'.'.$fechafin2.'">DESCARGAR ARCHIVO</a><br/>';
        
    }
        //----------------------------------------
        // seccion de funciones
        //----------------------------------------
        function buscaImagenesXFecha($fechainicio,$fechainicio2,$fechafin,$fechafin2, $riservicio,$ricuenta) {
            
            $arr_arch=array();
            $cont=0;
            // veo los archivos que estan en esa cuenta
            //        $ruta=RAIZ."/".$riservicio."/".$ricuenta;
            //        $exis=scandir($ruta);
            //        print "<br>";
            //        print_r ($exis);
            // busco los reportes de ese periodo y su respectivas carpetas
            
            $sql="SELECT
id_ruta
FROM ins_imagendetalle
INNER JOIN ins_generales ON i_claveservicio=id_imgclaveservicio AND i_numreporte=id_imgnumreporte
WHERE id_imgclaveservicio=".$riservicio." AND i_clavecuenta=".$ricuenta."
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.','".$fechainicio."','.','".$fechainicio2."'),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.','".$fechafin."','.','".$fechafin2."'),'%d.%m.%Y');";
            
            
            $rs=mysql_query($sql);
            while($row=mysql_fetch_array($rs)) {
                // busco si existe el mes asignacion
                
                $ruta=RAIZ."/".$row[0];
                
                //if(is_dir($ruta))
                if(is_file($ruta))
                {
                    
                    $arr_arch[$cont++]=$ruta; //lo guardo
                }
                
            }
            //    if($fechainicio2==$fechafin2) {
            //        while($fechainicio<=$fechafin) {
            //// busco si existe el mes asignacion
            //
            //            $ruta=RAIZ."/".$riservicio."/".$ricuenta."/".$fechainicio."-".$fechainicio2;
            //
            //            if(is_dir($ruta))
                //                {
                //
                //                $arr_arch[$cont++]=$ruta; //lo guardo
                //                }
            //            $fechainicio++;
            //        }
            //    }
            //    else if($fechainicio2<$fechafin2) {
            //        $anio1=$fechainicio2;
            //        $mes1=$fechainicio;
            //        while($anio1<$fechafin2) {
            //
            //
            //            while($mes1<=12) {
            //                $ruta=$riservicio."/".$ricuenta."/".$mes1."-".$anio1;
            //                //                    echo "zz".RAIZ."/".$ruta;
            //
            //                if(is_dir( RAIZ."/".$ruta))
                //                   { $arr_arch[$cont++]=$ruta;
                //
                //                }
            //                $mes1++;
            //            }
            //            $anio1++;
            //            $mes1=1;
            //        }
            //        $fechainicio=1;
            //        while($fechainicio<=$fechafin) {
            //            $ruta=$riservicio."/".$ricuenta."/".$fechainicio."-".$fechafin2;
            //            //                     echo "zz".RAIZ."/".$ruta;
            //
            //            if(is_dir(RAIZ."/".$ruta))
                //              {  $arr_arch[$cont++]=$ruta;
                //
                //            }
            //            $fechainicio++;
            //        }
            ////               echo "--".$ruta."<br/>";
            //
            //    }
            
            return $arr_arch;
        }
        function buscaImagenesXServicio($fechainicio,$fechainicio2,$fechafin,$fechafin2, $riservicio) {
            $sql_cuentas = "SELECT * FROM ca_cuentas
                                where
`ca_cuentas`.`ser_claveservicio`='$riservicio';";
            
            $rs_cuentas = mysql_query($sql_cuentas);
            while($row_cuentas = @mysql_fetch_array($rs_cuentas)) {   //para cada cuenta busco los meses seleccionados
                
                if(is_dir(RAIZ."/".$riservicio."/".$row_cuentas ["cue_clavecuenta"]))// verifico que exista la carpeta
                    
                    $arr_cue[ $row_cuentas ["cue_clavecuenta"]]=buscaImagenesXFecha($fechainicio, $fechainicio2, $fechafin, $fechafin2, $riservicio,  $row_cuentas ["cue_clavecuenta"] );
                    //  $html->expandir ( 'CUENTA', '+bucacuenta' );
            }
            mysql_free_result($rs_cuentas);
            
            return $arr_cue;
        }
        
        
        
        function comprimirDirectorio($dir, $zip) {
            //$pwd = dirname(__FILE__);
            global $cont;
            static $carpeta="";
            // ini_set("memory_limit","100M");
            //Primero comprabamos que sea un directorio
            
            if (is_dir($dir)) {
                
                $carpeta=$dir;
                //Por cada elemento dentro del directorio
                foreach (scandir($dir) as $item) {
                    //Evitamos la carpeta actual y la anterior
                    if ($item == '.' || $item == '..') continue;
                    //Si encuentra una que no sea las anteriores,
                    //vuelve a llamar a la función, con un nuevo directorio
                    comprimirDirectorio($dir . "/" . $item, $zip);
                }
            }else {
                //En el caso de que sea un archivo, lo añade al zip
                //          $zip->addFile($dir);
                
                if(is_file($dir))
                {      $cont++;
                $path = ($dir[0] == '\\') ? $dir : "$dir";
                //echo "--".$path;
                $data = file_get_contents($path);
                $file_opt="";
                # add file to archive
                //$zip->add_file(basename($dir), $data, $file_opt);
                
                
                
                # add file to archive
                //echo substr(strstr($carpeta,"/"),1);
                
                $dir= iconv( "ISO-8859-1","UTF-8", $dir);
                //  $zip->add_file(substr(strstr($carpeta,"/"),1)."/". basename($dir), $data, $file_opt);
                //    echo $dir."<br>";  substr($directorio,strlen(RAIZ)+1);
                $dir_rec=substr($dir,strlen(RAIZ)+1);
                $zip->add_file(($dir_rec), $data, $file_opt);
                }
                
            }
        }
    
}

