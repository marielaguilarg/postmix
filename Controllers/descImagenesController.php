<?php
require 'libs/ZipStream/ZipStream.php';
require 'libs/ZipStream/Exception.php';
//require 'libs/ZipStream/Exception/OverflowException.php';
// require 'libs/ZipStream/Option/Archive.php';
// require 'libs/ZipStream/Option/File.php';
// require 'libs/ZipStream/Option/Method.php';

require "Models/crud_servicios.php";
//echo "cargo";
class DescImagenesController
{
	private $cont;
    
    public function descargarImagenes(){
        // crea archivo "al vuelo" pero sin subcarpetas
        define('RAIZ',"fotografias");
        ini_set('max_execution_time', 1200);
        ini_set("memory_limit","500M");
        
        # load zipstream class
       
        require "Utilerias/leevar.php";
        
        $arr_arch=array();
        $cont=0;
        $ricliente=$crcliente;
        $riservicio=$crservicio;
        $ricuenta=$cuenta;
        if($ricliente!=0)
            
            if($riservicio!=0) {
                if($ricuenta!=0) {
                    $arr_cue[$ricuenta]=$this->buscaImagenesXFecha($fechainicio, $fechainicio2, $fechafin, $fechafin2, $riservicio, $ricuenta);
                    $arr_arch[$riservicio]=$arr_cue;
                    
                }
                else // todas las cuentas
                {
                    // con periodo
                    
                    $arr_arch[$riservicio]=$this->buscaImagenesXServicio($fechainicio, $fechainicio2, $fechafin, $fechafin2, $riservicio);
                    
                }
            }
        else {// todos los servicios
            // con periodo
            // busco los servicios
            $sql_serv="SELECT
        `ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp` FROM `muestreo`.`ca_servicios`
        where `ca_servicios`.`cli_idcliente`='$ricliente';";
            $rs_serv = DatosServicio::vistaServicioxCliente($ricliente,"ca_servicios");
            foreach($rs_serv as $row_cuentas) {   //para cada cuenta busco los meses seleccionados
                $servicio=$row_cuentas[0];
                if(is_dir(RAIZ."/".$servicio))// verifico que exista la carpeta
                    
                    $arr_arch[$servicio] =$this->buscaImagenesXServicio($fechainicio, $fechainicio2, $fechafin, $fechafin2, $servicio);
                    
            }
            
        }
        else {//todos los clientes
            //con periodo
            // busco todos los servicios
            $sql_serv="SELECT
        `ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp` FROM `muestreo`.`ca_servicios`;";
            $rs_serv = DatosServicio::vistaServiciosModel("ca_servicios");
            foreach($rs_serv as $row_cuentas) {   //para cada cuenta busco los meses seleccionados
                $servicio=$row_cuentas[0];
                if(is_dir(RAIZ."/".$servicio))// verifico que exista la carpeta
                    $arr_arch[$servicio] =$this->buscaImagenesXServicio($fechainicio, $fechainicio2, $fechafin, $fechafin2, $servicio);
                    
            }
            
            
        }
       
        $files = RAIZ;
        $arch_zip="imagenes_".date("dmyHi").".zip";
        //$op=array("large_file_method"=>"store","content_type"=>'application/x-zip',"content_disposition"=>'attachment; filename=\"test.zip"' );
        $op="";
        $zip = new ZipStream\ZipStream($arch_zip);
   //     var_dump($arr_arch);
        $base=getcwd().DIRECTORY_SEPARATOR;
     //   echo $base;
      //  $pos=strrpos($base,'\\');
      //  $base=substr($base,0,$pos).DIRECTORY_SEPARATOR;
      // var_dump($arr_arch);die();
        foreach ($arr_arch as $key => $arrc) {
            //    echo "servicio ".$key;
            foreach ($arrc as $key2=>$value) {
                //        echo "--cuenta ".$key2."<br/>";
                // var_dump($value);
                foreach($value as $key3=>$value3 ) {
                    //agrego archivos
                    //$directorio=RAIZ."/".$value3;
                  
                    $directorio=$value3;
                     //Llamámos a la función para comprimir
                  //  echo "*****".$base."--".$directorio;
                    $this->comprimirDirectorio($directorio, $zip);
                   
                }
            }
        }
        
       // $this->comprimirDirectorio("C:\\xampp\htdocs\postmixsep\\postmix\\fotografias/1/1/9-2015/DSCN5018.JPG", $zip);
        
        $zip->finish();
        
        $_SESSION["arch_borrar"]=$arr_arch;
        
        
    }
        //----------------------------------------
        // seccion de funciones
        //----------------------------------------
        function buscaImagenesXFecha($fechainicio,$fechainicio2,$fechafin,$fechafin2, $riservicio,$ricuenta) {
            
            $arr_arch=array();
            $cont=0;
         
            // busco los reportes de ese periodo y su respectivas carpetas
            
            $sql="SELECT
id_ruta
FROM ins_imagendetalle
INNER JOIN ins_generales ON i_claveservicio=id_imgclaveservicio AND i_numreporte=id_imgnumreporte
inner join `ca_unegocios`
ON `une_id`=`i_unenumpunto` 
WHERE id_imgclaveservicio=:riservicio";
if($ricuenta!="")
{$sql.=" AND cue_clavecuenta=:ricuenta";
$parametros["ricuenta"]=$ricuenta;
}
	$sql.=" AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechainicio,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin,'.',:fechafin2),'%d.%m.%Y');";
            
            $parametros["riservicio"]=$riservicio;
          
            $parametros["fechainicio"]=$fechainicio;
            $parametros["fechainicio2"]=$fechainicio2;
            $parametros["fechafin"]=$fechafin;
            $parametros["fechafin2"]=$fechafin2;
            $rs=Conexion::ejecutarQuery($sql,$parametros);
       
            foreach($rs as $row) {
                // busco si existe el mes asignacion
            	$ruta=RAIZ."/".$row[0];
               
                //if(is_dir($ruta))
                if(is_file($ruta))
                {
                    
                    $arr_arch[$cont++]=$ruta; //lo guardo
                }
                
            }

            
            return $arr_arch;
        }
        function buscaImagenesXServicio($fechainicio,$fechainicio2,$fechafin,$fechafin2, $riservicio) {
//             $sql_cuentas = "SELECT * FROM ca_cuentas
//                                 where
// `ca_cuentas`.`ser_claveservicio`='$riservicio';";
            
//             $rs_cuentas = DatosCuenta::($sql_cuentas); //ya nohay cuentas por servicio

        	
        //    foreach($row_cuentas = @mysql_fetch_array($rs_cuentas)) {   //para cada cuenta busco los meses seleccionados
               

                if(is_dir(RAIZ."/".$riservicio))// verifico que exista la carpeta
                {
                	
                	$arr_cue[$riservicio]=$this->buscaImagenesXFecha($fechainicio, $fechainicio2, $fechafin, $fechafin2, $riservicio,'' );
                    //  $html->expandir ( 'CUENTA', '+bucacuenta' );
            
                }
            
            return $arr_cue;
        }
        
        
        
        function comprimirDirectorio($dir, $zip) {
            //$pwd = dirname(__FILE__);
           
            static $carpeta="";
            // ini_set("memory_limit","100M");
            //Primero comprabamos que sea un directorio
            $dir=str_replace("/", "\\", $dir);
           
            if (is_dir($dir)) {
                
                $carpeta=$dir;
                //Por cada elemento dentro del directorio
                foreach (scandir($dir) as $item) {
                    //Evitamos la carpeta actual y la anterior
                    if ($item == '.' || $item == '..') continue;
                    //Si encuentra una que no sea las anteriores,
                    //vuelve a llamar a la función, con un nuevo directorio
                   $this->comprimirDirectorio($dir . "/" . $item, $zip);
                }
            }else {
                //En el caso de que sea un archivo, lo añade al zip
                //          $zip->addFile($dir);
            	$dir=str_replace("\\", DIRECTORY_SEPARATOR, $dir);
            
                if(is_file($dir))
                {      $this->cont++;
                $path = ($dir[0] == '\\') ? $dir : "$dir";
              //  echo " añadiendo ".$path; die();
                $data = file_get_contents($path);
                $file_opt="";
                # add file to archive
                //$zip->add_file(basename($dir), $data, $file_opt);
                
                
                
                # add file to archive
                //echo substr(strstr($carpeta,"/"),1);
                
                $dir= iconv( "ISO-8859-1","UTF-8", $dir);
              $pos=stripos($dir, RAIZ);
                $dir_rec=substr($dir,$pos+strlen(RAIZ)+1,strlen($dir));
             //   $dir_rec=substr($dir,$pos+1,strlen($dir));
             //   echo $dir_rec; die();
                $zip->addFile(($dir_rec), $data);
                }
                
            }
        }
    
}

