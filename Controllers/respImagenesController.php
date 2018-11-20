<?php

include "Controllers/borrarImagenesController.php";
class RespImagenesController
{
    private $OPCLIENTES;
    private $OPSERVICIOS;
    private $OPCUENTAS;
    private $crcliente;
    private $crservicio;
    private $cuenta;
    private $referencia;
    private $meses_opt;
    private $fechainicio;
    private $fechainicio2;
    private $fechafin;
    private $fechafin2;
    private $txt;
    private $verligas;
    public function vistaRespladoImagenes(){
       include "Utilerias/leevar.php";  
       $this->verligas="style='display:none'";
        switch ($adm) {
            
            case 'desc' :
                
                //para descargar
               
                $f="../Archivos/".$f;
                //nombre corto
                //$arch_zip="imagenes_".date("dmyHi").".zip";
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"$f\"\n");
                $fp=fopen("$f", "r");
                fpassthru($fp);
                break;
            case 'del' :
                $borrar=new BorrarImagenesController();
                $borrar->borrarImagenes();
                break;
           die();
            case 'eli' :
                include ('./MESselecrespaldo.php');
                break;
            
            case 'ini':
                include ('./MESdescargaimagenes_3.php');
                break;
            case 'ini2':
                //	 include ('./MESdescargaimagenes.php');
                header("prueba_respaldo2.php");
                break;
            case 'lis':
              $this->renRespaldos();
             
               break;
           
        }
                
               
                
                $arr_meses=array(strtoupper("Enero"),strtoupper("Febrero"),strtoupper("Marzo"),strtoupper("Abril"),strtoupper("Mayo"),strtoupper("Junio"),strtoupper("Julio"),strtoupper("Agosto"),strtoupper("Septiembre"),strtoupper("Octubre"),strtoupper("Noviembre"),strtoupper("Diciembre"));
                $sql_cli="SELECT
`ca_clientes`.`cli_idcliente`,
`ca_clientes`.`cli_nombrecliente`
FROM `muestreo`.`ca_clientes`;";
                $sql_cli=Datos::vistaClientesModel("ca_clientes");
             
                $this->OPCLIENTES=Utilerias::crearSelectOnChange($sql_cli,'crcliente','cargaContenidoCliente(this.id)');
                $this->OPSERVICIOS=Utilerias::crearSelectOnChange('','crservicio','cargaContenidoCliente(this.id)');
                $this->OPCUENTAS= Utilerias::crearSelectOnChange('', 'cuenta','cargaContenidoCliente(this.id)');
                
                
                $opciones_mes="";
                foreach ($arr_meses as $key => $value) {
                    $opciones_mes.='<option value="'.($key+1).'">'.$value.'</option>';
                }
                $this->meses_opt=$opciones_mes;
            
        
    }
        public function renRespaldos(){
            include "Utilerias/leevar.php";  
            $arr_arch=array();
            $cont=0;
            $ricliente=$crcliente;
            $riservicio=$crservicio;
            $ricuenta=$cuenta;
            
            $this->crcliente=$crcliente;
            $this->crservicio=$crservicio;
            $this->cuenta=$cuenta;
            $this->referencia=$crcliente.".".$crservicio.".".$cuenta ;
            
            $this->fechainicio=$fechainicio;
            $this->fechainicio2=$fechainicio2;
            $this->fechafin=$fechafin;
            $this->fechafin2=$fechafin2;
           
            $this->verligas="style='display:block'";
        }
        
        function respaldobdImagen(){
            include "Utilerias/leevar.php"; 
            $tabla="ins_imagendetalle";
            $ruta_respaldo="bk_".$tabla.date("dmYhi").".txt";
            $array_tablas_chicas=array();//en un array junto todas las tablas chicas
            
            $registro_tablas_chicas=100000;//las tablas que tienen esta cantidad de registros o menos, se consideran como tablas chicas... se respaldan todas juntas de un viaje
            
            $maximo_registros=100000;//el maximo de registros que aguanta un backup. Si una tabla tiene mas de estos registros, se tiene que respaldar por partes
            
            
            
            if (!isset($paso)) {
              
                $paso=0;
                //unlink($ruta_respaldo);// Lo borro en caso de que exista
            }//cerrando altiro el If que ve si hay get del paso
            
            //Recorro las tablas de la base de datos y veo cuantos registros tiene cada una de ellas
            $contador_tablas=1;//Por defecto, para llevar el orden de la que toca respaldar en cada momento
            $search_info_tabla=Conexion::ejecutarQuerysp("DESCRIBE ".$tabla);
            //La consulta sacada lanza todos los atributos de la entidad, pero solo me interesa en este caso sacar el primero el cual es la clave de la tabla
       
            $clave_obtenida='no';//para poder hacer lo anteriormente comentado
            
            foreach($search_info_tabla as $row) {
                if ($clave_obtenida=='no') {
                    $clave_principal=$row[0];
                    $clave_obtenida='si';
                }//cerrando altiro el if que ve si me falta obtener la clave principal
            }//cerrando el foreach que recorre la descripccion de la tabla
            
            //consulto el total de registros que tiene la tabla
            $sql="SELECT COUNT($clave_principal) FROM $tabla";
            //echo $sql;
            $search_total_registros_tabla=Conexion::ejecutarQuerysp($sql) ;
           
            foreach($search_total_registros_tabla as $row ) {
                $total_registros=$row[0];
            }//cerrando el foreach que recorre la descripccion de la tabla
            
            
            //RESPALDO TABLAS GRANDES
          //  echo $total_registros.">".$registro_tablas_chicas;
            if ($total_registros>$registro_tablas_chicas) {//es una tabla grande
                if ($paso==$contador_tablas) {//Toca respaldar la tabla !!!
                    
                    if ($total_registros>$maximo_registros) {//se respalda por parte
                        if (!isset($from)) {
                           
                            $from=0;
                        }//cerrando altiro el If que ve si hay get del from
                        
                        $tope=$from+$maximo_registros;
                        //echo $from;
                        //die();
                        if ($from<=$total_registros) {//se respalda la parte que estamos recorriendo
                            $txt='';
                            $this->crear_respaldo($tabla,$from,'no',$maximo_registros);
                            $this->respaldar();
                            
                            $from=$from+$maximo_registros;//Para que continue con la siguiente parte
                            echo "<a href='MESrespaldobdimagen.php?paso=$paso&from=$from'>Faltaron datos por descargar</a>";
                            //  echo "<META HTTP-EQUIV='REFRESH' CONTENT=0;URL='MESrespaldobdimagen.php?paso=$paso&from=$from'>";
                        }//cerrando if que ve si se respalda la parte que estamos recorriendo
                        
                        
                        
                        
                        
                    }else {//se puede respaldar enterita !!!
                        $txt='';
                        $this->crear_respaldo($tabla,'0','si',$maximo_registros);
                        $this->respaldar();
                    }//cerrando if que revisa si la tabla se respalda por parte o enterita
                    
                    
                }//cerrando if que revisa si toca respaldar la tabla grande
                
            }else {//la tabla es chica, la paso al array de las tablas chicas
                $array_tablas_chicas[]=$tabla;
            }//cerrando el if que ve si se trata de una tabla grande
            //FIN RESPALDO TABLAS GRANDES
            
            $contador_tablas++;
              // RESPALDO DE LAS TABLAS CHICAS
            
            if ($paso==0) {
                $txt='';
                foreach ($array_tablas_chicas as $tabla) {
                    
                	$this->crear_respaldo($tabla,'0','si',$maximo_registros);
                    $paso++;
                }//cerrando el foreach que recorre el array de las tablas chicas
                
            }//cerrando if que revisa si estamos en el paso 0, respaldo de tablas chicas
            // FIN RESPALDO DE LAS TABLAS CHICAS
            //
            //include ('MEcon_off.php');
            
        
            $cantidad_tablas_base_datos=1;
           // echo $paso.">=".$cantidad_tablas_base_datos;
            if ($paso>=$cantidad_tablas_base_datos) {//Proceso finalizado
                //echo "paso".$cantidad_tablas_base_datos;
                //
                
                //   echo 'HAGA  CLICK EN LA SIGUIENTE LIGA PARA BORRAR LOS ARCHIVOS<br>
                //    <a href="MESprincipal.php?op=respimg&adm=del&ref='.$referencia.'&feci='.$fechainicio.'.'.$fechainicio2.'&fecf='.$fechafin.'.'.$fechafin2.'">DESCARGAR ARCHIVO</a><br/>';
                
                // RESPALDO
            	$this->respaldar($ruta_respaldo);
            }else {//faltan tablas por recorrer
                $paso=$paso+1;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT=0;URL='MESrespaldobdimagen.php?paso=$paso'>";
            }//cerrando el if que ve si faltan tablas por recorrer
            
        }
            // FUNCIONES
            
        function crear_respaldo($tablita,$desde,$todo,$maximo_registros) {
                
              
           
        	include "Utilerias/leevar.php"; 
                
                  
                //Datos
                if ($todo=='si') {//se respalda toda la tabla
                   
                    $consulta="SELECT ins_imagendetalle.id_imgclaveservicio,
ins_imagendetalle.id_imgnumreporte,
ins_imagendetalle.id_imgnumseccion,
ins_imagendetalle.id_imgnumreactivo,
ins_imagendetalle.id_idimagen,
ins_imagendetalle.id_ruta, `id_descripcion`,`id_presentar` FROM $tablita";
                }else {//se respalda la parte que corresponde
                    $consulta="SELECT ins_imagendetalle.id_imgclaveservicio,
ins_imagendetalle.id_imgnumreporte,
ins_imagendetalle.id_imgnumseccion,
ins_imagendetalle.id_imgnumreactivo,
ins_imagendetalle.id_idimagen,
ins_imagendetalle.id_ruta,`id_descripcion`,`id_presentar` FROM $tablita LIMIT $desde,$maximo_registros";
                 
                }//cerrando If que ve si se respalda toda la tabla o una parte de ella
                $consulta.=" INNER JOIN ins_generales ON i_claveservicio=id_imgclaveservicio AND i_numreporte=id_imgnumreporte";
                // armo filtros
                if($crcliente!=0)
                    if($crservicio!=0) {
                        if($cuenta!=0) { //  por periodo
                            //por cuenta;
                            $consulta.=" inner join `ca_unegocios`
ON `une_id`=`i_unenumpunto`  AND cue_clavecuenta=:cuenta
 WHERE id_imgclaveservicio=:crservicio 
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechainicio,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin ,'.',:fechafin2),'%d.%m.%Y') ;    ";
                            $parametros["crservicio"]=$crservicio;
                            $parametros["cuenta"]=$cuenta;
                            $parametros["fechainicio"]=$fechainicio;
                            $parametros["fechainicio2"]=$fechainicio2;
                            $parametros["fechafin"]=$fechafin;
                            $parametros["fechafin2"]=$fechafin2;
                        }
                        else // todas las cuentas
                        {
                            // con periodo y por servicio
                            $consulta.=" WHERE id_imgclaveservicio=:crservicio
  AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechainicio ,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin ,'.',:fechafin2),'%d.%m.%Y')  ;    ";
                            $parametros["crservicio"]=$crservicio;
                           
                            $parametros["fechainicio"]=$fechainicio;
                            $parametros["fechainicio2"]=$fechainicio2;
                            $parametros["fechafin"]=$fechafin;
                            $parametros["fechafin2"]=$fechafin2;
                            
                            
                        }
                    }
                else {// todos los servicios
                    // con periodo
                    // busco los servicios
                    $consulta.=" inner join `ca_servicios` ON `ser_id`=`i_claveservicio` WHERE `ser_idcliente`=:crcliente and   STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechainicio ,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin ,'.',:fechafin2),'%d.%m.%Y') ;     ";
                    $parametros["crcliente"]=$crcliente;
                 
                    $parametros["fechainicio"]=$fechainicio;
                    $parametros["fechainicio2"]=$fechainicio2;
                    $parametros["fechafin"]=$fechafin;
                    $parametros["fechafin2"]=$fechafin2;
                    
                }
                else {//todos los clientes
                    //con periodo
                    $consulta.=" WHERE STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechainicio ,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin ,'.',:fechafin2),'%d.%m.%Y') ;     ";
                    $parametros["fechainicio"]=$fechainicio;
                    $parametros["fechainicio2"]=$fechainicio2;
                    $parametros["fechafin"]=$fechafin;
                    $parametros["fechafin2"]=$fechafin2;
                    
                }
                //echo $consulta;
                //die();
                $respuesta=Conexion::ejecutarQuery($consulta,$parametros );
                foreach($respuesta as $fila) {
                    $columnas=array_keys($fila);
                    
                    
                    foreach($columnas as $columna) {
                        
                        if(gettype($fila[$columna])=="NULL") {
                            $values[]="NULL";
                        }else {
                            if(gettype($columna)=="string")
                                $values[]="'".$fila[$columna]."'";
                        }
                    }//end del foreach
                    $this->txt.="INSERT INTO `$tablita` VALUES (".implode(",",$values).");\n";
                    
                    unset($values);
                }//cerrando el foreach
                //Fin de Datos
                
                $this->txt.="\n\n\n";//para hacer espacio a la escructura de la siguiente tabla, para que no quede todo junto
            }//Fin de la funcion
            //**********************************************************
            //**********************************************************
            
            
            function respaldar($ruta_respaldo) {
                 $ruta_respaldo;
              
              
             
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"$ruta_respaldo\"\n");
                echo $this->txt;
            }//fin de la funcion

         
            	
            
            /**
             * @return mixed
             */
            public function getOPCLIENTES()
            {
                return $this->OPCLIENTES;
            }
        
            /**
             * @return mixed
             */
            public function getOPSERVICIOS()
            {
                return $this->OPSERVICIOS;
            }
        
            /**
             * @return mixed
             */
            public function getOPCUENTAS()
            {
                return $this->OPCUENTAS;
            }
        
            /**
             * @return mixed
             */
            public function getCrcliente()
            {
                return $this->crcliente;
            }
        
            /**
             * @return mixed
             */
            public function getCrservicio()
            {
                return $this->crservicio;
            }
        
            /**
             * @return mixed
             */
            public function getCuenta()
            {
                return $this->cuenta;
            }
        
            /**
             * @return string
             */
            public function getReferencia()
            {
                return $this->referencia;
            }
        
            /**
             * @return mixed
             */
            public function getFechainicio()
            {
                return $this->fechainicio;
            }
        
            /**
             * @return mixed
             */
            public function getFechainicio2()
            {
                return $this->fechainicio2;
            }
        
            /**
             * @return mixed
             */
            public function getFechafin()
            {
                return $this->fechafin;
            }
        
            /**
             * @return mixed
             */
            public function getFechafin2()
            {
                return $this->fechafin2;
            }
        
            /**
             * @return string
             */
            public function getTxt()
            {
                return $this->txt;
            }
            /**
             * @return string
             */
            public function getMeses_opt()
            {
                return $this->meses_opt;
            }
			/**
			 * @return string
			 */
			public function getVerligas() {
				return $this->verligas;
			}
		
        
                
            
}
        
        
       
        


