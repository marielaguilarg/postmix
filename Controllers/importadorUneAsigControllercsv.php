<?php
//error_reporting(E_ALL);
include 'libs/simplexlsx.class.php';
include 'Controllers/importadorExcelController.php';
include 'Models/crud_unegociosasignados.php';

/**
 * 
 *Clase para importar un excel en la tabla de unegociosasignados
 * @author Marisol
 */
class ImportadorUneAsigController {
    
    public $resultado;
    public $listaFalta;
    public $hayDatos;
    
    
    public function importar(){
          $anio=filter_input(INPUT_POST, "anio",FILTER_SANITIZE_STRING);
           $folder=getcwd().DIRECTORY_SEPARATOR."Archivos".DIRECTORY_SEPARATOR;
       //$filename="temporalunegociosasignados.xlsx";
       $filename="temporalunegociosasignados.csv";
     try{
        if (filter_input(INPUT_GET, "adm",FILTER_SANITIZE_STRING)=="imp"){
    
   
     //valido el archivo
      $archivozip=$_FILES["archivoimport"]["name"];
       $ext=substr(strrchr($archivozip, "."),1);
     
        // valido que sea .xlsx
        $msg = "EL ARCHIVO A IMPORTAR NO ES UN EXCEL COMPATIBLE, VERIFIQUE";
        $msg2 = '<div class="alert alert-danger" role="alert" >' .
             $msg .
                '</div>';
      
        if($ext=='csv'){
//             if($_FILES["archivoimport"]["type"]!="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") // el primero debe ser zip
//             {
//                 //finalizo con
//               //  echo "--".$_FILES["userfile"]["type"][0];
//                 $this->resultado=$msg2;
//             }
        //    echo "subiendo ".$folder.$filename;
       if(move_uploaded_file($_FILES['archivoimport']['tmp_name'], $folder.$filename)){ // Finalmente sube el archivo
                      
         //revisar si tengo datos de ese año
             //se puede volver a hacer solo validar que no haya info de ese año y si exite confirmar eliminación
         $sql="select count(*) from ca_unegociosasignados where una_anio=:anio";
         $resul1=Conexion::ejecutarQuery($sql,["anio"=>$anio]);
  
      
         foreach ($resul1 as $res){
             if($res[0]>0)
             {  
                 Utilerias::guardarError("ya tengo info del ".$anio."--$res[0]=".$res[0]);
                 $this->hayDatos=true;
                  return; 
             } 
         }
          //  echo "---".$anio;
    //importar el archivo en la tabla temporal
    $importador=new ImportadorExcelController($folder, $filename, "tmp_unegociosasignados");
    $importador->importarCsv();
       Utilerias::guardarError("Terminando de importar en temporal");
    //buscar los id que hacen falta
    DatosUnegociosAsignados::actualizarIds($anio) ;   
     //verificar que los id's estén llenos y sino enviar informe
     $resultado=DatosUnegociosAsignados::buscarIdsNulos();
   // var_dump($resultado);
   
     if(sizeof($resultado)>0)
     {
         $this->listaFalta=$resultado;
     }else
     {
    //pasar a la tabla definitiva
    DatosUnegociosAsignados::pasaraCatalogo();
    //finalizó con exito
    $this->resultado='<div class="alert alert-success" role="alert" >La importación finalizó con éxito</div>';
     }
   
  
       }
       else die("no tengo permiso para subir ".$folder.$filename);
        
    }
    else $this->resultado=$msg2;
        }
          if (filter_input(INPUT_GET, "adm",FILTER_SANITIZE_STRING)=="cont"){
              $this->pasarADefinitiva($anio);
          }
            if (filter_input(INPUT_GET, "adm",FILTER_SANITIZE_STRING)=="cont1"){
                  //importar el archivo en la tabla temporal
    $importador=new ImportadorExcelController($folder, $filename, "tmp_unegociosasignados");
    $importador->importarCsv();
    //buscar los id que hacen falta
    DatosUnegociosAsignados::actualizarIds($anio) ;   
     //verificar que los id's estén llenos y sino enviar informe
     $resultado=DatosUnegociosAsignados::buscarIdsNulos();
    // var_dump($resultado);
   
     if(sizeof($resultado)>0)
     {
         $this->listaFalta=$resultado;
     }else
     {
    //pasar a la tabla definitiva
    DatosUnegociosAsignados::pasaraCatalogo();
    //finalizó con exito
    $this->resultado='<div class="alert alert-success" role="alert" >La importación finalizó con éxito</div>';
     }
   
  
            }
     }catch(Exception $ex){
     Utilerias::guardarError($ex->getMessage());
     $this->resultado='<div class="alert alert-error" role="alert" >Hubo un error al importar verifique que el archivo es correcto'+$ex->getMessage()+'</div>';
  
     }
    }
    public function pasarADefinitiva($anio){
        //elimino lo que haya
         $sql="delete from ca_unegociosasignados where una_anio=:anio";
         Conexion::ejecutarQuery($sql,["anio"=>$anio]);
         DatosUnegociosAsignados::pasaraCatalogo();
         $this->resultado='<div class="alert alert-success" role="alert" >La importación finalizó con éxito</div>';
    
    }
}
