<?php


class RestImagenController
{
    
    public function cargarRespaldo(){
        
        include "Utilerias/leevar.php";
        if($adm=="car"){
        $base=getcwd();
        
        $pos=strrpos($base,'\\');
        $base=substr($base,0,$pos);
        define('RAIZ',$base."\\fotografias");
        //define('RAIZ',"C:\\AppServ\\www\\Muesmerc\\fotografias");
        
        
        ini_set('max_execution_time', 3600);
        ini_set("memory_limit","500M");
        
        // var_dump($_FILES);
        //
        // valido archivos
        // valido extension
        
        $nomcampo="userfile";
        $archivozip=$_FILES[$nomcampo]["name"];
        $ext=substr(strrchr($archivozip, "."),1);
        //echo "ww".$archivozip;
        // valido que sea .zip
        $msg = "EL ARCHIVO DE RESPALDO ES INCORRECTO";
        $msg2 = '<table width="400" border="0"  align="center"  >' .
            '<tr><td height="30px"></td></tr><tr><td class="infocuadro" align="center">' . $msg . '</td></tr><tr><td height="30px"></td></tr>
                <tr><td align="center"><a href="MESprincipal.php?op=respimg&adm=res">&lt;&lt;  '."Regresar".'  </a> </td></tr></table>';
        
        if($ext=='zip'){
            if($_FILES["userfile"]["type"]!="application/octet-stream"&&$_FILES["userfile"]["type"]!="application/zip"&&$_FILES["userfile"]["type"]!="application/x-zip-compressed"&&$_FILES["userfile"]["type"]!="application/binary") // el primero debe ser zip
            {
                //finalizo con
                //  echo $_FILES["userfile"]["type"];
                die($msg2);
            }
        }
        else
            die("err2".$msg2);
            // reviso sql;
            $msg = "err2 EL ARCHIVO DE RESPALDO DE DATOS ES INCORRECTO";
            $msg2 = '<table width="400" border="0"  align="center"  >' .
                '<tr><td height="30px"></td></tr><tr><td class="infocuadro" align="center">' . $msg . '</td></tr><tr><td height="30px"></td></tr>
         <tr><td align="center"><a href="MESprincipal.php?op=respimg&adm=res">&lt;&lt;  '."Regresar".'  </a> </td></tr></table>';
            $nomcampo="archsql";
            $archivobk=$_FILES[$nomcampo]["name"];
            $ext=substr(strrchr($archivobk, "."),1);
            
            if($ext=='txt'){
                if($_FILES[$nomcampo]["type"]!="text/plain") // este debe ser txt
                {
                    //finalizo con
                    die($msg2);
                }
            }
            else
                die($msg2);
                
                if(restauraimagen())
                //        echo "todo bien<br>";
                {restaurabd($_FILES);
                $msg = "PROCESO FINALIZADO SATISFACTORIAMENTE";
                $msg2 = '<table width="400" border="0"  align="center"  >' .
                    '<tr><td height="30px"></td></tr><tr><td class="infocuadro" align="center">' . $msg . '</td></tr><tr><td height="30px"></td></tr>
                    <tr><td align="center"><a href="MESprincipal.php?op=respimg">&lt;&lt;  '."Regresar".'  </a> </td></tr></table>';
                echo $msg2;
                }
                else
                {
                    $msg2 = '<table width="400" border="0"  align="center"  >' .
                        '<tr><td height="30px"></td></tr>
                    <tr><td align="center"><a href="MESprincipal.php?op=respimg">&lt;&lt;  '."Regresar".'  </a> </td></tr></table>';
                    echo $msg2;
                }
        }
                
        }
                //----------------------------------------------
                //           seccion de funciones
                //----------------------------------------------
                function restaurabd($_FILES) {
                    $ress=subirarchivo($_FILES , RAIZ , "archsql");
                    $arch_bd =RAIZ."/".$_FILES ["archsql"] ["name"];
                    $f = fopen ($arch_bd,"r");
                    $ln= 0;
                    
                    // echo $content;
                    while (! feof ($f)) {
                        $line= fgets ($f);
                        ++$ln;
                        if ($line===FALSE||$line==""||$line=="NULL")
                        {
                        }
                        else {
                            mysql_query($line);
                        }
                    }
                    fclose ($f);
                    //lo borro
                    unlink($arch_bd);
                    
                }
                
                
                function restauraimagen( ) {
                    $ress=0;
                    $resd=0;
                    /* subida de archivo a la carpeta fotografias*/
                    $folder = "../fotografias/";
                    $maxlimit = 5000000; // Máximo límite de tamaño (en bits)
                    $allowed_ext = "rar,jpg,zip"; // Extensiones permitidas (usad una coma para separarlas)
                    $overwrite = "no"; // Permitir sobreescritura? (yes/no)
                    
                    $match = "";
                    $filesize = $_FILES['userfile']['size']; // toma el tamaño del archivo
                    $filename = strtolower($_FILES['userfile']['name']); // toma el nombre del archivo y lo pasa a minúsculas
                    
                    //$error="";
                    if(!$filename || $filename==""){ // mira si no se ha seleccionado ningún archivo
                        $error = "- Ningún archivo selecccionado para subir.<br>";
                    }elseif(file_exists($folder.$filename) && $overwrite=="no"){ // comprueba si el archivo existe ya
                        $error = "- El archivo <b>$filename</b> ya existe<br>";
                    }
                    
                    // comprobar tamaño de archivo
                    if($filesize < 1){ // el archivo está vacío
                        $error .= "- Archivo vacío.<br>";
                    }
                    
                    
                    $file_ext = preg_split("/\./",$filename); //
                    $allowed_ext = preg_split("/\,/",$allowed_ext); // ídem, algo con las extensiones
                    foreach($allowed_ext as $ext){
                        if($ext==$file_ext[1]) $match = "1"; // Permite el archivo
                    }
                    
                    // Extensión no permitida
                    if(!$match){
                        $error .= "- Este tipo de archivo no está permitido: $filename<br>";
                    }
                    
                    if($error){
                        print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
                    }else{
                        //echo "subiendo..";
                        if(move_uploaded_file($_FILES['userfile']['tmp_name'], $folder.$filename)){ // Finalmente sube el archivo
                            //     print "<b>$filename</b> se ha subido correctamente!"; //el mensaje que saldra cuando el archivo este subido
                            $ress=1;
                            
                        }else{
                            print "Error! Puede que el tamaño supere el máximo permitido por el servidor. Inténtelo de nuevo."; // Otro error
                        }
                    }
                    
                    /*
                     * descomprimo archivo
                     */
                    $name = $_FILES ["userfile"] ["name"];
                    if ($ress==1) {
                        // descomprime archivo
                        $resd=descomprime(RAIZ."/".$name );
                        //borra zip
                        unlink(RAIZ."/".$name );
                    } else {
                        echo '<div align="center">';
                        echo "<br><h2>Error al cargar el archivo, intenta de nuevo</h2>";
                        echo "</div>";
                        $ban=1;
                        
                    }
                    //echo "todo ok";
                    return $resd;
                }
                
                //'application/octet-stream'
                function subirarchivo($_FILES,$carpeta_guarda,$nomcampo) {
                    $folder = "../fotografias/";
                    $maxlimit = 5000000; // Máximo límite de tamaño (en bits)
                    
                    $overwrite = "no"; // Permitir sobreescritura? (yes/no)
                    
                    $match = "";
                    $filesize = $_FILES[$nomcampo]['size']; // toma el tamaño del archivo
                    $filename = strtolower($_FILES[$nomcampo]['name']); // toma el nombre del archivo y lo pasa a minúsculas
                    
                    
                    if(!$filename || $filename==""){ // mira si no se ha seleccionado ningún archivo
                        $error = "- Ningún archivo selecccionado para subir.<br>";
                    }elseif(file_exists($folder.$filename) && $overwrite=="no"){ // comprueba si el archivo existe ya
                        $error = "- El archivo <b>$filename</b> ya existe<br>";
                    }
                    
                    // comprobar tamaño de archivo
                    if($filesize < 1){ // el archivo está vacío
                        $error .= "- Archivo vacío.<br>";
                    }
                    
                    if($error){
                        print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
                    }else{
                        if(move_uploaded_file($_FILES[$nomcampo]['tmp_name'], $folder.$filename)){ // Finalmente sube el archivo
                            //   print "<b>$filename</b> se ha subido correctamente!"; //el mensaje que saldra cuando el archivo este subido
                            return 1;
                        }else{
                            print "Error! Puede que el tamaño supere el máximo permitido por el servidor. Inténtelo de nuevo."; // Otro error
                        }
                    }
                    return 0;
                }
                
                function descomprime($nombre){
                    $zip = new COM("Chilkat.Zip2");
                    
                    //  Any string unlocks the component for the 1st 30-days.
                    $success = $zip->UnlockComponent('ZIPT34MB34N_79F1DB3Ep8pN');
                    if ($success != true) {
                        print "Error".$zip->lastErrorText() . "\n";
                        return 0;
                    }
                    
                    $success = $zip->OpenZip($nombre);
                    if ($success != true) {
                        print $zip->lastErrorText() . "\n";
                        return 0;
                    }
                    $n = $zip->NumEntries;
                    for ($i = 0; $i <= $n - 1; $i++) {
                        
                        $entry = $zip->GetEntryByIndex($i);
                        if ($entry->IsDirectory == false) {
                            
                            
                            $nombre=$entry->fileName();
                            
                            // Supongamos entrada no es nulo.  Si no GetEntryByName
                            // Para encontrar la entrada, devuelve una referencia nula.
                            $entry-> filename = iconv("UTF-8", "ISO-8859-1", $nombre);
                        }
                    }
                    
                    
                    //  Returns the number of files and directories unzipped.
                    //  Unzips to /my_files, re-creating the directory tree
                    //  from the .zip.
                    /*$unzipCount = $zip->UnzipInto("C:/my_files/1_1");
                    
                    if ($unzipCount < 0) {
                    print $zip->lastErrorText() . "\n";
                    }
                    else {
                    print $unzipCount.'Success!' .$nombre. "\n";
                    }*/
                    
                    
                    $success=$zip->Extract(RAIZ);
                    //  print 'Success!' .$success."--".$n. "\n";
                    return $success;
                }
}

