<?php


class InicioExcelController
{
    private $listaclientes;
    private  $worksheet;
    
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
    require_once "libs/writeexcel/class.writeexcel_workbook.inc.php";
    require_once "libs/writeexcel/class.writeexcel_worksheet.inc.php";
  
    include "Utilerias/leevar.php";
    //CREA EL ARCHIVO PARA EXPORTAR
  
    $nomarch="base postmix".date("dmyHi");
    $base=getcwd();
    ////echo $base;
    ////echo "--".strrpos($base,"\\");
    $base=substr($base, 0, strrpos($base,"\\"));
    
    $arrcolores=array("azul"=>"48","verde"=>"31","naranja"=>"orange","amarillo"=>"yellow",
        "rojo"=>"62","verdeo"=>"30","gris"=>"gray", "blanco"=>"white", "verdef"=>"green", "rojof"=>"60" );
    
    $fname = tempnam($base."\\Archivos\\", $nomarch.".xls");
    $workbook =new writeexcel_workbook($fname);
    $this->worksheet =& $workbook->addworksheet('Inicio');
 
    $this->worksheet->set_column(0, 0, 12);
    $this->worksheet->set_column(1, 2, 20);
    $this->worksheet->set_column(3, 3, 35);
    $this->worksheet->set_column(4, 4, 42);
    $this->worksheet->set_column(5, 5, 20);
    $this->worksheet->set_column(6, 6, 25);
    $this->worksheet->set_column(7, 7, 25);
    
    $this->worksheet->set_column(8, 8, 60);
    $this->worksheet->set_column(9, 10, 15);
    $this->worksheet->set_column(11, 11, 125);
    $this->worksheet->set_column(12, 15, 17);
    // REGISTRA DIVISION
     $workbook->addformat(array(
        bold    => 1,
        italic  => 0,
        'fg_color'   =>  $arrcolores["rojo"],
        size    => 12,
        font    => 'Comic Sans MS',
        Align => 'Center'
    ));
    
    
    
     $workbook->addformat(array(
        bold    => 1,
        italic  => 0,
        'fg_color'   =>  $arrcolores["azul"],
        size    => 12,
        font    => 'Comic Sans MS',
        Align => 'Left'
    ));
 
     $workbook->addformat(array(
        bold    => 1,
        italic  => 0,
        'fg_color'   =>  $arrcolores["azul"],
        size    => 12,
        font    => 'Comic Sans MS',
        Align => 'Center'
    ));
    
    $text_format_b =& $workbook->addformat(array(
        bold    => 1,
        italic  => 0,
        'fg_color'   =>  $arrcolores["verdeo"],
        size    => 10,
        font    => 'Comic Sans MS',
        //vAlign => 'vjustify',
        Align => 'Center'
    ));
    
    $workbook->addformat(array(
        bold    => 1,
        italic  => 0,
        'fg_color'   =>  $arrcolores["verde"],
        size    => 10,
        font    => 'Comic Sans MS',
       // vAlign => 'vjustify',
        Align => 'Center'
    ));
    
    //////////////////////////////////// nombres de cada columna o prueba//////////////////////////////
    $enctablas=array("NO DE PUNTO DE VENTA", "UNIDAD DE NEGOCIO", "FRANQUICIA CLIENTE", "CUENTA", "FRANQUICIA", "REGION", "ESTADO", "CIUDAD O MUNICIPIO", "PUNTO DE VENTA (NOMBRE)","ID PEPSICO","ID CUENTA","DOMICILIO","ESTATUS","FECHA DE ESTATUS","TOTAL DE REPORTES","NO DE REPORTES ASIGNADOS");
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    /*** DESPLIEGO TITULOS DE COLUMNA**/
   
     $workbook->addformat(array(
        bold    => 1,
        italic  => 0,
        'fg_color'   =>  $arrcolores["verde"],
        size    => 10,
        font    => 'Comic Sans MS',
      //  vAlign => 'vjustify',
        Align => 'center'
    ));
    
    $workbook->addformat(array(
        bold    => 1,
        italic  => 0,
        'fg_color'   =>  $arrcolores["verdeo"],
        size    => 12,
        font    => 'Comic Sans MS',
        Align => 'Center'
    ));
    
    
    $text_format_det =& $workbook->addformat(array(
        bold    => 0,
        italic  => 0,
        size    => 10,
        font    => 'Comic Sans MS',
        Align => 'Center'
    ));
    
    
    $text_format_det1 =& $workbook->addformat(array(
        bold    => 0,
        italic  => 0,
        size    => 10,
        font    => 'Comic Sans MS',
        Align => 'Left'
    ));
    // inicio en letra a=65
    $letra=65;

    $i=0;
    for($i=0;$i<16;$i++) {
        $this->worksheet->write($this->michr($letra++)."1", $enctablas[$i],$text_format_b);
    }
    
    
     $workbook->addformat(array(
        bold    => 0,
        italic  => 0,
        'fg_color'   =>  $arrcolores["verdeo"],
        size    => 8,
        font    => 'Comic Sans MS',
     //   vAlign => 'vjustify',
        Align => 'center'
    ));
    
     $workbook->addformat(array(
        bold    => 0,
        italic  => 0,
        'fg_color'   =>  $arrcolores["verde"],
        size    => 8,
        font    => 'Comic Sans MS',
        //vAlign => 'vjustify',
        Align => 'center'
    ));
    
    
   
    if($consulta=="t")
        $cuenta=-1;
      
        $this->datosUNegocio($mes_asig,$mes_asig2,$cuenta, $fecrec, $tcons, $text_format_det, $text_format_det1, $gpous, $claclien);
        $fin = microtime(true);
        $tiempo = $fin - $ini;
        $workbook->close();
        //
        header("Content-Type: application/x-msexcel; name=\"".$nomarch.".xls\"");
        header("Content-Disposition: inline; filename=\"".$nomarch.".xls\"");
        //$fh=fopen($fname, "rb");
        //fpassthru($fh);
        //unlink($fname);
        //header("Content-Type: application/x-msexcel; name=\"example-demo.xls\"");
        //header("Content-Disposition: inline; filename=\"example-demo.xls\"");
        $fh=fopen($fname, "rb");
        fpassthru($fh);
        unlink($fname);
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
ca_unegocios.une_idpepsi, 
ca_unegocios.une_idcuenta,
 CONCAT(ca_unegocios.une_dir_calle,' ',
 ca_unegocios.une_dir_numeroext,' ',ca_unegocios.une_dir_numeroint,' ',ca_unegocios.une_dir_manzana,' ',
 ca_unegocios.une_dir_lote,' ',ca_unegocios.une_dir_colonia,' ',ca_unegocios.une_dir_delegacion,' ',
 ca_unegocios.une_dir_municipio,' ',ca_unegocios.une_dir_estado,' ',ca_unegocios.une_dir_cp) AS dir,
  ca_unegocios.une_estatus,
 DATE_FORMAT(ca_unegocios.une_fechaestatus,'%d-%m-%Y') AS fecha_estatus, 
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
ORDER BY une_numpunto";
            $parametros=array("claclien1"=>$claclien1);
          
            $resultuneg=Conexion::ejecutarQuery($sqluneg,$parametros);
          
            $letra=65;
            $ren_ex=2;
            
            foreach($resultuneg as $rowuneg) {
                for($i=0;$i<12;$i++) {//despliego cada columna
                    // echo $letra;
                    $this->worksheet->write($this->michr($letra+$i).$ren_ex, $rowuneg[$i], $text_format_det);
                }
                $cveest = $rowuneg[12];
                $fecest = $rowuneg[13];
                $cvecli = $rowuneg[14];
               // $cveser = $rowuneg[15];
                $cvecta = $rowuneg[15];
                $cveuneg = $rowuneg[16];
                $this->busest($cveest, $fecest, $ren_ex, $text_format_det);
                $this->totrep( $cvecli, $cveuneg, $ren_ex, $text_format_det);
                $this->asnumrep( $cvecli,  $cveuneg, $ren_ex, $text_format_det);
                $ren_ex++;
            }
          //  die();
        }
        
        function busest($cveest1, $fecest1, $ren_ex1,$text_format_det){
           
           
            //ECHO $sqltrep;
            $rstreg=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",46,$cveest1);
          
            $this->worksheet->write($this->michr(77).$ren_ex1, $rstreg, $text_format_det);
                $this->worksheet->write($this->michr(78).$ren_ex1, $fecest1, $text_format_det);
            
        }
        
        
        
        
        
        function totrep( $cvecli, $cveuneg, $ren_ex1, $text_format_det){
            
            $sqltrep="SELECT  TOTREP FROM
	(SELECT
COUNT(ins_generales.i_numreporte) AS TOTREP,
ins_generales.i_claveservicio,

ins_generales.i_unenumpunto
FROM
ins_generales
inner join ca_servicios  on  ins_generales.i_claveservicio=ser_id
where ser_idcliente =:cvecli 
GROUP BY
 ins_generales.i_claveservicio,

ins_generales.i_unenumpunto
ORDER BY
ins_generales.i_claveservicio,

ins_generales.i_unenumpunto) AS A
WHERE

i_unenumpunto =:cveuneg";
            $parametros=array("cvecli"=>$cvecli,
                "cveuneg"=>$cveuneg
            );
            $rstreg=Conexion::ejecutarQuery($sqltrep,$parametros);
          
            $numRows = sizeof($rstreg);
            if ($numRows==0)
            {
                $this->worksheet->write($this->michr(79).$ren_ex1, 0, $text_format_det);
            } else {
                foreach($rstreg as $rowtr) {
                    $this->worksheet->write($this->michr(79).$ren_ex1, $rowtr[0], $text_format_det);
                }
            }
        }
        
        
        function asnumrep($cveser, $cveuneg, $ren_ex1, $text_format_det) {
            $numreps= "";
            $rstreg=DatosGenerales::consultaReportexServicioUneg($cveser,$cveuneg,"ins_generales");
            foreach($rstreg as $rowtr) {
                $numreps=$numreps.$rowtr[0].", ";
            }
            $totlen=strlen($numreps);
            if ($totlen>0) {
                $numreps= substr($numreps,0,strlen($numreps)-2);
            }
            $this->worksheet->write($this->michr(80).$ren_ex1, $numreps, $text_format_det);
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

