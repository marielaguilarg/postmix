<?php

require_once "libs/PHP_XLSXWriter-master/xlsxwriter.class.php";
class InicioExcelController
{
    private $listaclientes;
    private  $worksheet;
    private $hoja;
    
    public function vistaArchivoInicio(){
        include "Utilerias/leevar.php";
        
        
        $this->listaclientes=Datos::vistaClientesModel("ca_clientes");
       
        /*    $num_reg = @mysql_num_rows($rs);
         $i=0; */
        
    }
    

    
    public function descargarArchivo(){
    $ini = microtime(true);
    set_time_limit(800);
    ini_set("memory_limit","120M");
  
  
    include "Utilerias/leevar.php";
    //CREA EL ARCHIVO PARA EXPORTAR
  
    $nomarch="base postmix".date("dmyHi");
    $base=getcwd();
    ////echo $base;
    ////echo "--".strrpos($base,"\\");
    $base=substr($base, 0, strrpos($base,"\\"));
    
    $arrcolores=array("azul"=>"48","verde"=>"31","naranja"=>"orange","amarillo"=>"yellow",
        "rojo"=>"62","verdeo"=>"#0066cc","gris"=>"gray", "blanco"=>"white", "verdef"=>"green", "rojof"=>"60" );
    
    $fname = tempnam($base."\\Archivos\\", $nomarch.".xlsx");
    $this->worksheet =new XLSXWriter($fname);
    $this->hoja='Inicio';
 

    
    $text_format_b =array(
        'font-style'=>'bold',
        
        'fill'   =>  $arrcolores["verdeo"],
        'font-size'    => 10,
        'font'    => 'Arial Unicode MS',
        'halign' => 'center',
        'valign' => 'center',
    		'widths'=>array(20,20,30,
    				30,60,30,
    				40,40,60,
    				20,20,130,
    				20,40,20,
    				35),
    		'wrap_text'=>true
    );
    
   
    
    //////////////////////////////////// nombres de cada columna o prueba//////////////////////////////
    $enctablas=array("NO DE PUNTO DE VENTA"=>"integer", "UNIDAD DE NEGOCIO"=>'string', "FRANQUICIA CLIENTE"=>'string',
    		"CUENTA"=>'string', "FRANQUICIA"=>'string', "REGION"=>'string',
    		"ESTADO"=>'string', "CIUDAD O MUNICIPIO"=>'string', "PUNTO DE VENTA (NOMBRE)"=>'string',
    		"NUD"=>"string","ID CUENTA"=>"string","DOMICILIO"=>'string',
    		"ESTATUS"=>'string',"FECHA DE ESTATUS"=>'string',"TOTAL DE REPORTES"=>"integer",
    		"NO DE REPORTES ASIGNADOS"=>'string');
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    /*** DESPLIEGO TITULOS DE COLUMNA**/
   

    
    
    $text_format_det =array(
        
        
        'font-size'    => 10,
        'font'    => 'Arial Unicode MS',
        'halign' => 'center',
        'valign' => 'center',
    		
    );
    
    
    $text_format_det1 =array(
        
        
        'font-size'    => 10,
        'font'    => 'Arial Unicode MS',
        'halign' => 'Left'
    );
    // inicio en letra a=65
    $letra=65;

    $i=0;
    //for($i=0;$i<16;$i++) {
    $this->worksheet->writeSheetHeader($this->hoja, $enctablas,$text_format_b);
    //}
    
    if($consulta=="t")
        $cuenta=-1;

        $this->datosUNegocio($mes_asig,$mes_asig2,$cuenta, $fecrec, $tcons, $text_format_det, $text_format_det1, $gpous, $claclien);
        $fin = microtime(true);
        $tiempo = $fin - $ini;
    // die();
        //
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($nomarch).'.xlsx"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $this->worksheet->writeToStdOut();
       
    }
        function datosUNegocio($mes_asig,$mes_asigfin, $cuenta, $fechar, $tipo_cons, $text_format_det, $text_format_det1, $grupous, $claclien1) {
          
            $sqluneg="SELECT ca_unegocios.une_numpunto,
 ca_nivel2.n2_nombre,
 ca_nivel3.n3_nombre, 
ca_cuentas.cue_descripcion, 
ca_franquiciascuenta.cf_descripcion, 
ca_nivel4.n4_nombre,
 n5_nombre,
 ca_unegocios.une_dir_municipio,
 ca_unegocios.une_descripcion, 
ca_unegocios.une_num_unico_distintivo,
ca_unegocios.une_idcuenta,
 CONCAT(ca_unegocios.une_dir_calle,' ',
 ca_unegocios.une_dir_numeroext,' ',ca_unegocios.une_dir_numeroint,' ',ca_unegocios.une_dir_manzana,' ',
 ca_unegocios.une_dir_lote,' ',ca_unegocios.une_dir_colonia,' ',ca_unegocios.une_dir_delegacion,' ',
 ca_unegocios.une_dir_municipio,' ',ca_unegocios.une_dir_estado,' ',ca_unegocios.une_dir_cp) AS dir,
  ca_unegocios.une_estatus,
 if(une_fechaestatus='0000-00-00','',DATE_FORMAT(ca_unegocios.une_fechaestatus,'%d-%m-%Y')) AS fecha_estatus,
 cue_idcliente, 
 ca_unegocios.cue_clavecuenta,
ca_unegocios.une_id 
  FROM ca_unegocios 
  LEFT JOIN ca_cuentas ON ca_cuentas.cue_id = ca_unegocios.cue_clavecuenta
  LEFT JOIN ca_nivel6 ON ca_unegocios.une_cla_franquicia = ca_nivel6.n6_id 
  LEFT JOIN ca_nivel5 ON `une_cla_ciudad`= ca_nivel5.`n5_id` LEFT JOIN ca_nivel4 ON `une_cla_estado`= ca_nivel4.n4_id 
  LEFT JOIN ca_nivel3 ON `une_cla_zona`= ca_nivel3.n3_id LEFT JOIN ca_nivel2 ON `une_cla_pais`= ca_nivel2.n2_id 
  LEFT JOIN ca_nivel1 ON `une_cla_region`= ca_nivel1.n1_id 
  LEFT JOIN ca_franquiciascuenta ON ca_unegocios.fc_idfranquiciacta = ca_franquiciascuenta.fc_idfranquiciacta
  where ca_cuentas.cue_idcliente=:claclien1
ORDER BY une_numpunto,une_idcuenta";
            $parametros=array("claclien1"=>$claclien1);
          
            $resultuneg=Conexion::ejecutarQuery($sqluneg,$parametros);
          
            $letra=65;
            $ren_ex=2;
        
         
            foreach($resultuneg as $rowuneg) {
            	$this->renglon=array();
                for($i=0;$i<12;$i++) {//despliego cada columna
                    // echo $letra;
                  //  $this->worksheet->writeSheetRow($this->hoja, $rowuneg[$i], $text_format_det);
                	$this->renglon[]= $rowuneg[$i];
                }
                $cveest = $rowuneg[12];
                $fecest = $rowuneg[13];
                $cvecli = $rowuneg[14];
               // $cveser = $rowuneg[15];
                $cvecta = $rowuneg[15];
                $cveuneg = $rowuneg[16];
          
                 $this->busest($cveest, $fecest, $ren_ex, $text_format_det);
               
//                 $this->totrep( $cvecli, $cveuneg, $ren_ex, $text_format_det);
           
                 $this->asnumrep( $cvecli,  $cveuneg, $ren_ex, $text_format_det);
           
                $ren_ex++;
              
                $this->worksheet->writeSheetRow($this->hoja, $this->renglon, $text_format_det);
             
            }
         
           
        }
        
        function busest($cveest1, $fecest1, $ren_ex1,$text_format_det){
           
           
            //ECHO $sqltrep;
            $rstreg=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",46,$cveest1);
          
         //   $this->worksheet->writeSheetRow($this->hoja, $rstreg, $text_format_det);
          //      $this->worksheet->writeSheetRow($this->hoja, $fecest1, $text_format_det);
            $this->renglon[]=$rstreg;
            $this->renglon[]=$fecest1;
        }
        
        
        
        
        
        function totrep( $cliente, $cveuneg, $ren_ex1, $text_format_det){
            
            $sqltrep="SELECT
COUNT(ins_generales.i_numreporte) AS TOTREP,
ins_generales.i_claveservicio,

ins_generales.i_unenumpunto
FROM
ins_generales
inner join ca_servicios  on  ins_generales.i_claveservicio=ser_id
WHERE
ser_idcliente=:cliente and
i_unenumpunto =:cveuneg
GROUP BY ser_idcliente,
ins_generales.i_unenumpunto
";
            $parametros=array("cliente"=>$cliente,
                "cveuneg"=>$cveuneg
            );
            $rstreg=Conexion::ejecutarQuery($sqltrep,$parametros);
          //  var_dump($rstreg);
            $numRows =sizeof($rstreg);
            if ($numRows==0)
            {
            	$this->renglon[]= 0;
                
            } else {
                foreach($rstreg as $rowtr) {
                	$this->renglon[]= $rowtr[0];
                }
            }
        }
        
        
        function asnumrep($cliente, $cveuneg, $ren_ex1, $text_format_det) {
            $numreps= "";
            $rstreg=DatosGenerales::consultaReportexCliUneg($cliente,$cveuneg,"ins_generales");
            
            foreach($rstreg as $rowtr) {
                $numreps=$numreps.$rowtr[0].", ";
            }
            $totlen=strlen($numreps);
            if ($totlen>0) {
                $numreps= substr($numreps,0,strlen($numreps)-2);
            }
         //   echo "<br>".$cveuneg."***".$numreps;
            $this->renglon[]=sizeof($rstreg);
            $this->renglon[]=$numreps;
        }
        
        function michr($indice){
            //echo $indice;
            if($indice>=65&&$indice<=90){
                return chr($indice);
            }
            if($indice>90&&$indice<=116){
                return "A".chr($indice-26);
            }
            /*if($indice>116&&$indice<=142){
             return "B".chr($indice-52);
             }
             if($indice>142&&$indice<=168){
             return "C".chr($indice-78);
             }*/
        }
        /**
         * @return array
         */
        public function getListaclientes()
        {
            return $this->listaclientes;
        }
    
        
        
}

