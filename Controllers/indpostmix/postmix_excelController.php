<?php

include 'Models/crud_estandar.php';
include 'Models/crud_catalogoDetalle.php';
include 'Models/crud_temporales.php';
require_once "libs/writeexcel/class.writeexcel_workbook.inc.php";
require_once "libs/writeexcel/class.writeexcel_worksheet.inc.php";

error_reporting(E_ERROR | E_PARSE);


class PostmixExcelController
{
    private $servicio;
    private $cliente;
    private  $workbook;
    private $worksheet;
    private  $select4,$select5,$select6;
    private  $select1;
    private $select2;
    private $select3,$letras;
    
    public function prueba(){
        $fname = tempnam(sys_get_temp_dir(), "demo.xls");
        $workbook =new writeexcel_workbook($fname);
        $worksheet =& $workbook->addworksheet('Demo');
        $worksheet2 =& $workbook->addworksheet('Another sheet');
        $worksheet3 =& $workbook->addworksheet('And another');
        #######################################################################
        #
        # Write a general heading
        #
        $worksheet->set_column('A:B', 32);
        $heading  =& $workbook->addformat(array(
            "bold"    => 1,
            "color"   => 'blue',
            "size"    => 18,
            "merge"   => 1,
        ));
        $headings = array('Features of php_writeexcel', '');
        $worksheet->write_row('A1', $headings, $heading);
        #######################################################################
        #
        # Some text examples
        #
        $text_format =& $workbook->addformat(array(
            "bold"    => 1,
            "italic"  => 1,
            "color"   => 'red',
            "size"    => 18,
            "font"    => 'Comic Sans MS'
        ));
        $worksheet->write('A2', "Text");
        $worksheet->write('B2', "Hello Excel");
        $worksheet->write('A3', "Formatted text");
        $worksheet->write('B3', "Hello Excel", $text_format);
        #######################################################################
        #
        # Some numeric examples
        #
        $num1_format =& $workbook->addformat(array("num_format" => '$#,##0.00'));
        $num2_format =& $workbook->addformat(array("num_format" => ' d mmmm yyy'));
        $worksheet->write('A4', "Numbers");
        $worksheet->write('B4', 1234.56);
        $worksheet->write('A5', "Formatted numbers");
        $worksheet->write('B5', 1234.56, $num1_format);
        $worksheet->write('A6', "Formatted numbers");
        $worksheet->write('B6', 37257, $num2_format);
        #######################################################################
        #
        # Formulae
        #
        $worksheet->set_selection('B7');
        $worksheet->write('A7', 'Formulas and functions, "=SIN(PI()/4)"');
        $worksheet->write('B7', '=SIN(PI()/4)');
        #######################################################################
        #
        # Hyperlinks
        #
        $worksheet->write('A8', "Hyperlinks");
        $worksheet->write('B8',  'http://www.php.net/');
        #######################################################################
        #
        # Images
        #
        $worksheet->write('A9', "Images");
        //$worksheet->insert_bitmap('B9', 'php.bmp', 16, 8);
        #######################################################################
        #
        # Misc
        #
        $worksheet->write('A17', "Page/printer setup");
        $worksheet->write('A18', "Multiple worksheets");
        $workbook->close();
       
        header("Content-Type: application/x-msexcel; name=\"example-demo.xls\"");
        header("Content-Disposition: inline; filename=\"example-demo.xls\"");
        $fh=fopen($fname, "rb");
        fpassthru($fh);
        unlink($fname);
    }
   public function exportar(){
       
    $ini = microtime(true);
    set_time_limit(500);
    ini_set("memory_limit","120M");
   
   
    @session_start();
   
    $user = $_SESSION["UsuarioInd"];
    $this->cliente=1;
    $this->servicio=1;
  
    $sql="select `cus_usuario`,
    `cus_contrasena`,
    `cus_nombreusuario`,
    `cus_empresa`,
    `cus_cargo`,
    `cus_telefono`,
    `cus_email`,
    `cus_clavegrupo`,
    `cus_tipoconsulta`,
    `cus_nivel1`,
    `cus_nivel2`,
    `cus_nivel3`,
    `cus_nivel4`,
    `cus_nivel5`,
    `cus_nivel6`,
    `cus_idioma`,
    `cus_cliente`,
    `cus_servicio`,
    `cus_solcer` from cnfg_usuarios where cus_usuario=:idusuario";
    $param=array("idusuario"=>$user);		
    $rsu=Conexion::ejecutarQuery($sql,$parametros);
    
   
    foreach ($rsu as $rowu) {
        $gpous= $rowu["cus_clavegrupo"];
        $GradoNivel = $rowu ["cus_tipoconsulta"];
        
        $this->select1 = $rowu ["cus_nivel1"];
        $this->select2 = $rowu ["cus_nivel2"];
        
        $this->select3 = $rowu ["cus_nivel3"];
        $this->select4 = $rowu ["cus_nivel4"];
        $this->select5 = $rowu ["cus_nivel5"];
        $this->select6 = $rowu ["cus_nivel6"];
        $uscliente=$rowu ["cus_cliente"];
        $usservicio=$rowu ["cus_servicio"];
        
    }
//     // echo $this->select1."--".$this->select2."--".$this->select3;
    
    
//     $VarNivel2 = $GradoNivel;
//     //CREA EL ARCHIVO PARA EXPORTAR
         $nomarch="base postmix".date("dmyHi");
    $base=getcwd();
   
  
    ////echo "--".strrpos($base,"\\");
    $base=substr($base, 0, strrpos($base,"\\"));
    
    $arrcolores=array("azul"=>"48","verde"=>"31","naranja"=>"orange","amarillo"=>"yellow",
        "rojo"=>"62","verdeo"=>"30","gris"=>"gray", "blanco"=>"white", "verdef"=>"green", "rojof"=>"60" );
   
   $fname = tempnam($base."\\Archivos\\", $nomarch.".xls");
  //  $fname = tempnam( sys_get_temp_dir(), $nomarch.".xls");
    //$fname = tempnam("/tmp", "demo.xls");
    $this->workbook = new writeexcel_workbook($fname);
    $this->worksheet = $this->workbook->addworksheet('Postmix');
    
    $this->worksheet->set_column(0, 0, 40);
    $this->worksheet->set_column(1, 2, 12);
    $this->worksheet->set_column(3, 3, 15);
    $this->worksheet->set_column(4, 4, 25);
    $this->worksheet->set_column(5, 5, 10);
    $this->worksheet->set_column(6, 6, 20);
    
    $this->worksheet->set_column(7, 7, 55);
    $this->worksheet->set_column(8, 8, 25);
    if ($gpous=="cic") {
        $this->worksheet->set_column(9, 12, 17);
        $this->worksheet->set_column(13, 26, 15);
        $this->worksheet->set_column(27, 28, 20);
        $this->worksheet->set_column(28, 28, 125);
    } else {
        $this->worksheet->set_column(9, 9, 55);
        $this->worksheet->set_column(10, 10, 25);
        $this->worksheet->set_column(11, 11, 55);
        $this->worksheet->set_column(12, 12, 25);
        $this->worksheet->set_column(13, 30, 15);
        $this->worksheet->set_column(31, 46, 25);
        $this->worksheet->set_column(47, 47, 15);
        $this->worksheet->set_column(48, 48, 20);
        $this->worksheet->set_column(49, 49, 20);
        $this->worksheet->set_column(50, 52, 20);
        $this->worksheet->set_column(53, 54, 25);
        $this->worksheet->set_column(55, 55, 30);
        $this->worksheet->set_column(56, 56, 125);
    }
    
    
    
    
    // REGISTRA DIVISION
     $text_format =& $this->workbook->addformat(array(
        "bold"    => 1,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["rojo"],
        "size"    => 12,
        "font"    => 'Comic Sans MS',
        "Align" => 'Center'
    ));
    
    
    
    $text_format_a =& $this->workbook->addformat(array(
        "bold"    => 1,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["azul"],
        "size"    => 12,
        "font"    => 'Comic Sans MS',
        "Align" => 'Left'
    ));
    
    $text_format1 =& $this->workbook->addformat(array(
        "bold"    => 1,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["azul"],
        "size"    => 12,
        "font"    => 'Comic Sans MS',
        "Align" => 'Center'
    ));
    
    $text_format_b =& $this->workbook->addformat(array(
        "bold"    => 1,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["verdeo"],
        "size"    => 10,
        "font"    => 'Comic Sans MS',
       /* vAlign => 'vjustify',*/
        "Align" => 'Center'
    ));
    
    $text_format_c =& $this->workbook->addformat(array(
        "bold"    => 1,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["verde"],
        "size"    => 10,
        "font"    => 'Comic Sans MS',
       /* "vAlign" => 'vjustify',*/
        "Align" => 'Center'
    ));
     $letrae=65;
  
    $this->worksheet->write($this->michr($letrae++)."1", "",$text_format);
    $this->worksheet->write($this->michr($letrae++)."1", "DATOS",$text_format);
    $this->worksheet->write($this->michr($letrae++)."1", "DE",$text_format);
    $this->worksheet->write($this->michr($letrae++)."1", "AUDITORIA",$text_format);
    for($i=0;$i<3;$i++) {
        $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format);
    }
    if ($gpous=="cic") {
        $this->worksheet->write($this->michr($letrae++)."1", "ORDEN",$text_format1);
        $this->worksheet->write($this->michr($letrae++)."1", "TRABAJO",$text_format1);
        
    } else {
        for($i=0;$i<1;$i++) {
            $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format1);
        }
        $this->worksheet->write($this->michr($letrae++)."1", "ORDEN",$text_format1);
        $this->worksheet->write($this->michr($letrae++)."1", "DE",$text_format1);
        $this->worksheet->write($this->michr($letrae++)."1", "TRABAJO",$text_format1);
        for($i=0;$i<2;$i++) {
            $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format1);
        }
    }
    for($i=0;$i<6;$i++) {
        $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format);
    }
    
    $this->worksheet->write($this->michr($letrae++)."1", " ATRIBUTOS ",$text_format);
    $this->worksheet->write($this->michr($letrae++)."1", " DE ",$text_format);
    $this->worksheet->write($this->michr($letrae++)."1", " LA ",$text_format);
    $this->worksheet->write($this->michr($letrae++)."1", " BEBIDA ",$text_format);
    if ($gpous=="cic") {
        for($i=0;$i<6;$i++) {
            $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format);
        }
    } else {
        for($i=0;$i<8;$i++) {
            $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format);
        }
        for($i=0;$i<8;$i++) {
            $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format1);
        }
        
        $this->worksheet->write($this->michr($letrae++)."1", " FISICOQUIMICO ",$text_format1);
        $this->worksheet->write($this->michr($letrae++)."1", " AGUA ",$text_format1);
        for($i=0;$i<6;$i++) {
            $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format1);
        }
        
        for($i=0;$i<1;$i++) {
            $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format);
        }
        $this->worksheet->write($this->michr($letrae++)."1", " MICROBIOLOGICO ",$text_format);
        $this->worksheet->write($this->michr($letrae++)."1", " AGUA ",$text_format);
    }
    for($i=0;$i<2;$i++) {
        $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format1);
    }
    $this->worksheet->write($this->michr($letrae++)."1", " DATOS ",$text_format1);
    $this->worksheet->write($this->michr($letrae++)."1", " DEL ",$text_format1);
    $this->worksheet->write($this->michr($letrae++)."1", " ESTABLECIMIENTO ",$text_format_a);
    for($i=0;$i<2;$i++) {
        $this->worksheet->write($this->michr($letrae++)."1", " ",$text_format1);
    }
    
//    hasta aqui todo correcto
  
    ////////////////////////////////// nombres de cada columna o prueba//////////////////////////////
    $enctablas=array("PUNTO DE VENTA","ID CUENTA","NUD","NO. DE ACTIVO","FECHA VISITA","NO. REPORTE","MES ASIGNACION","MANTTO CORRECTIVO","FUERA DE RANGO","SANITIZACION","FUERA DE RANGO","DIAGNOSTICO MANEJO DE AGUA","FUERA DE RANGO",
        "TEMPERATURA (°C)", "PRESION","TEMPERATURA (F)","VOLUMENES C02",
        "RATIO PEPSI",  "RATIO PEPSI LIGHT",
        "RATIO MIRINDA","RATIO SEVEN UP", "RATIO MANZANITA",
        "RATIO KAS", "RATIO LIMONADA MINERAL 7UP", "RATIO SANGRIA CASERA", "RATIO VITAFRESA", "RATIO BE LIGHT JAMAICA",
        "RATIO BE LIGHT LIMON", "RATIO BE LIGHT MANGO",  "RATIO LIPTON", "RATIO JUMEX FRESH CITRUS",
        "LUGAR DE TOMA DE MUESTRA",
        "SABOR","OLOR","COLOR","TURBIEDAD","pH",
        "ALCALINIDAD","DUREZA","CLORO LIBRE","CLORO TOTAL","SOLIDOS TOTALES DISUELTOS",
        "TEMPERATURA","CONDUCTIVIDAD","FIERRO","MANGANESO","FLUORUROS",
        "CUENTA TOTAL","COLIFORMES TOTALES","E COLI",
        "FRANQUICIA DEL CLIENTE","CUENTA","REGION","ESTADO","CIUDAD",
        "FRANQUICIA DE LA CUENTA","DIRECCION COMPLETA");
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    /*** DESPLIEGO TITULOS DE COLUMNA**/
    $arr_colxsec=array(
        4,3,3,5,3,3,3,3,3,4,4);
    
    $text_format =& $this->workbook->addformat(array(
        "bold"    => 1,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["verde"],
        "size"    => 10,
        "font"    => 'Comic Sans MS',
       /* "vAlign" => 'vjustify',*/
        "Align" => 'center'
    ));
    
    $text_format1 =& $this->workbook->addformat(array(
        "bold"    => 1,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["verdeo"],
        "size"    => 12,
        "font"    => 'Comic Sans MS',
        "Align" => 'Center'
    ));
    
    
    $text_format_det =& $this->workbook->addformat(array(
        "bold"    => 0,
        "italic"  => 0,
        "size"    => 10,
        "font"    => 'Comic Sans MS',
        "Align" => 'Center'
    ));
    
    
    $text_format_det1 =& $this->workbook->addformat(array(
        "bold"    => 0,
        "italic"  => 0,
        "size"    => 10,
        "font"    => 'Comic Sans MS',
        "Align" => 'Left'
    ));
    // inicio en letra a=65
    $letra=65;
    $ren_ex=3;
    $i=0;
    for($i=0;$i<7;$i++) {
        $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_b);
    }
    if ($gpous=="cic") {
        for($i=7;$i<13;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_c);
        }
        for($i=13;$i<31;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_b);
        }
    } else {
        for($i=7;$i<13;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_c);
        }
        for($i=13;$i<31;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_b);
        }
    }
    if ($gpous=="cic") {
        for($i=46;$i<53;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_c);
        }
    } else {
        for($i=31;$i<47;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_c);
        }
        
        for($i=47;$i<50;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_b);
        }
        
        for($i=50;$i<57;$i++) {
            $this->worksheet->write($this->michr($letra++)."2", $enctablas[$i],$text_format_c);
        }
    }
    
    // DESPLEGAR ESTANDARES
    $esttablas=array(" ",""," "," "," "," "," "," "," "," "," "," "," ");
    //$esttablas[] = "4.24 a 5.76 (tolerancia de +- .75)";
    
    
    $text_format_std =& $this->workbook->addformat(array(
        "bold"    => 0,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["verdeo"],
        "size"    => 8,
        "font"    => 'Comic Sans MS',
      /* vAlign => 'center',*/
        "Align" => 'center'
    ));
    
    $text_format_std1 =& $this->workbook->addformat(array(
        "bold"    => 0,
        "italic"  => 0,
        'fg_color'   =>  $arrcolores["verde"],
        "size"    => 8,
        "font"    => 'Comic Sans MS',
       /* vAlign => 'vjustify',*/
        "Align" => 'center'
    ));
    
    $sql="SELECT
cue_reactivosestandardetalle.red_estandar
FROM `cue_reactivosestandardetalle`
WHERE cue_reactivosestandardetalle.ser_claveservicio = 1  and concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica,'.', re_numcomponente2) ='8.0.2.0.0' and (cue_reactivosestandardetalle.red_numcaracteristica2=6
 or cue_reactivosestandardetalle.red_numcaracteristica2=7 or cue_reactivosestandardetalle.red_numcaracteristica2=8 or cue_reactivosestandardetalle.red_numcaracteristica2=9)
ORDER BY cue_reactivosestandardetalle.red_numcaracteristica2  ASC";
    $res0=Conexion::ejecutarQuerysp($sql);
   
    $totalE= sizeof($res0);
    $nomres="";
    If ($totalE>0) {
        foreach ($res0 as $row) {
            $esttablas[] = $row[0];
        }
    }
    
    for($i=0;$i<14;$i++) {
        $esttablas[] = "4.5 - 5.5";
    }
    
    $esttablas[] = " ";
    
    $sql="SELECT
cue_reactivosestandardetalle.red_estandar
FROM `cue_reactivosestandardetalle`
WHERE cue_reactivosestandardetalle.ser_claveservicio = 1 AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica,'.', re_numcomponente2) = '5.0.2.0.0' AND cue_reactivosestandardetalle.red_numcaracteristica2 <> '14' AND cue_reactivosestandardetalle.red_numcaracteristica2 <> '15' AND cue_reactivosestandardetalle.red_numcaracteristica2 <> '21'
ORDER BY  if (cue_reactivosestandardetalle.red_numcaracteristica2=19,4, if ((cue_reactivosestandardetalle.red_numcaracteristica2>=4 and cue_reactivosestandardetalle.red_numcaracteristica2<=13),cue_reactivosestandardetalle.red_numcaracteristica2+1,if (cue_reactivosestandardetalle.red_numcaracteristica2=20,15,cue_reactivosestandardetalle.red_numcaracteristica2))) ASC";
    
    $res0=Conexion::ejecutarQuerysp($sql);
   
    $totalE= sizeof($res0);
    $nomres="";
    If ($totalE>0) {
        foreach ($res0 as $row) {
            $esttablas[] = $row[0];
        }
    }
    
    for($i=0;$i<7;$i++) {
        $esttablas[] = " ";
    }
    
    $letra=65;
    for($i=0;$i<7;$i++) {
        $this->letras= $this->michr($letra++);
        $this->worksheet->write ($this->letras."3", $esttablas[$i],$text_format_std);
    }
    if ($gpous=="cic") {
        for($i=7;$i<13;$i++) {
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3", $esttablas[$i],$text_format_std1);
        }
        for($i=13;$i<31;$i++) {
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3", $esttablas[$i],$text_format_std);
        }
        for($i=49;$i<59;$i++) {
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3", $esttablas[$i],$text_format_std1);
        }
    } else {
        for($i=7;$i<13;$i++) {
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3", $esttablas[$i],$text_format_std1);
        }
        for($i=13;$i<31;$i++) {
         
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3", utf8_decode($esttablas[$i]),$text_format_std);
        }
        for($i=31;$i<47;$i++) {
          
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3",utf8_decode($esttablas[$i]),$text_format_std1);
        }
        for($i=47;$i<50;$i++) {
           
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3", $esttablas[$i],$text_format_std);
        }
        for($i=50;$i<57;$i++) {
            $this->letras= $this->michr($letra++);
            $this->worksheet->write ($this->letras."3", $esttablas[$i],$text_format_std1);
        }
    }
    
    
    // HASTA AQUI, TODO OK
    
    foreach($_POST as $nombre_campo => $valor) {
        $asignacion = "\$" . $nombre_campo . "='" .filter_input(INPUT_POST,$nombre_campo, FILTER_SANITIZE_STRING) . "';";
        eval($asignacion);
       
    }
    
    // detalle
 
    if($consulta=="t")
        $cuenta=-1;
        
        if (isset($tipo_consulta)) {
            $tcons=$tipo_consulta;
        } else {
            $tcons=filter_input(INPUT_GET,"tipo_consulta", FILTER_SANITIZE_STRING) ;
        }
        $fecharep=$fechareporte;
        //echo $fecharep;
        $fr=explode('-', $fecharep);
        $fecrec=$fr[2]."-".$fr[1]."-".$fr[0];
        
        $mes_asig=$fechainicio.".".$fechainicio2;
        $mes_asig2=$fechafin.".".$fechafin2;
        

        
        $punvta=filter_input(INPUT_GET,"punvta", FILTER_SANITIZE_STRING) ;
       
        try{
        $this->datosUNegocio($mes_asig,$mes_asig2,$cuenta, $fecrec, $tcons, $text_format_det, $text_format_det1, $gpous, $punvta);
        //echo $punvta;
        $fin = microtime(true);
        $tiempo = $fin - $ini;

        $this->workbook->close();
        //
     
        //$fh=fopen($fname, "rb");
        //fpassthru($fh);
        //unlink($fname);
        header("Content-Type: application/x-msexcel; name=\"".$nomarch.".xls\"; charset=iso-8859-1");
       header("Content-Disposition: inline; filename=\"".$nomarch.".xls\"");
      
        $fh=fopen($fname, "rb");
        fpassthru($fh);
        }catch (Exception $ex){
            echo $ex;
        }
     //   unlink($fname);
   }  
        
        
        function datosUNegocio($mes_asig,$mes_asigfin, $cuenta, $fechar, $tipo_cons, $text_format_det, $text_format_det1, $grupous, $punvta) {
            
           
        
            //echo $this->select1."--".$this->select2."--".$this->select3;
            
            $reactivos=array("8.0.2.0.0.6","8.0.2.0.0.7",
                "8.0.2.0.0.8",
                "8.0.2.0.0.9",
                "5.0.2.0.0.14",
                "5.0.2.0.0.1",
                "5.0.2.0.0.2",
                "5.0.2.0.0.3",
                "5.0.2.0.0.19",
                "5.0.2.0.0.4",
                
                "5.0.2.0.0.5",
                "5.0.2.0.0.6",
                "5.0.2.0.0.7",
                "5.0.2.0.0.8",
                
                "5.0.2.0.0.9",
                "5.0.2.0.0.10",
                "5.0.2.0.0.11",
                "5.0.2.0.0.12",
                
                "5.0.2.0.0.13",
                "5.0.2.0.0.20",
                "5.0.2.0.0.16",
                "5.0.2.0.0.17",
                "5.0.2.0.0.18"
            );
            
            $sqluneg="SELECT ca_unegocios.une_descripcion,
 CONVERT(ca_unegocios.une_idpepsi,UNSIGNED INTEGER) AS IDPEPSI, 
CONVERT(ca_unegocios.une_num_unico_distintivo,UNSIGNED INTEGER) AS NUD,
 date_format( ins_generales.i_fechavisita ,'%d-%m-%Y') as fecha_visita, 
ins_generales.i_numreporte,
    concat(case SUBSTRING_INDEX( ins_generales.i_mesasignacion,'.',1) when 1 THEN 'ENERO'
        WHEN 2 THEN 'FEBRERO' when 3 THEN 'MARZO' WHEN 4 THEN 'ABRIL'
        when 5 THEN 'MAYO' WHEN 6 THEN 'JUNIO' when 7 THEN 'JULIO' WHEN 8 THEN 'AGOSTO'
        WHEN 9 THEN 'SEPTIEMBRE' when 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE'
        WHEN 12 THEN 'DICIEMBRE' END,
        '.',SUBSTRING_INDEX( ins_generales.i_mesasignacion,'.',-1)) as mesasignacion,
        ca_nivel3.n3_nombre, ca_cuentas.cue_descripcion, ca_nivel4.n4_nombre,
        ca_nivel5.n5_nombre, ca_nivel6.n6_nombre, ca_franquiciascuenta.cf_descripcion,
        concat(ca_unegocios.une_dir_calle,' ', ca_unegocios.une_dir_numeroext,' ',
        ca_unegocios.une_dir_numeroint,' ', ca_unegocios.une_dir_manzana,' ', ca_unegocios.une_dir_lote,' ',
        ca_unegocios.une_dir_colonia,' ', ca_unegocios.une_dir_delegacion,' ', ca_unegocios.une_dir_municipio,
        ' ', ca_unegocios.une_dir_estado,' ', ca_unegocios.une_dir_cp) dir
        FROM ins_generales
        Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
        Inner Join ca_cuentas ON ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
        Inner Join ca_nivel3 ON  ca_unegocios.une_cla_zona = ca_nivel3.n3_id
        Inner Join ca_nivel4 ON  ca_unegocios.une_cla_estado =ca_nivel4.n4_id
        left Join ca_nivel5 ON ca_unegocios.une_cla_ciudad = ca_nivel5.n5_id
        left Join ca_nivel6 ON  ca_unegocios.une_cla_franquicia = ca_nivel6.n6_id
        left Join ca_franquiciascuenta ON ca_unegocios.fc_idfranquiciacta = ca_franquiciascuenta.fc_idfranquiciacta
        where
ins_generales.i_claveservicio=1 ";
            
            
            
            if($grupous=="cue")
            {if($this->select2!=""&&$this->select2!="0")
            {
                $sqluneg.=" AND ca_unegocios.fc_idfranquiciacta='$this->select2'";
                
                
            }
            
            if ($this->select3 != ""&&$this->select3 != "0") {
                $sqluneg.= " and ins_generales.i_unenumpunto='" . $this->select3 . "' ";
            }
            if($this->select1!=""&&$this->select1!="0"){
                $cuenta=$select1;
            }
            
            }
            // validamos los niveles de la estructura
            
            if($grupous=="cli" || $grupous=="muf"){
                if ($this->select1 != ""&&$this->select1 != "0") {
                    $sqluneg.= " AND ca_unegocios.une_cla_region='" . $this->select1 . "' ";
                    
                    
                }
                if ($this->select2 != ""&&$this->select2!= "0") {
                    $sqluneg.= " AND ca_unegocios.une_cla_pais='" . $this->select2 . "' ";
                    
                    
                }
                if ($this->select3 != ""&&$this->select3!= "0") {
                    $sqluneg.= " AND ca_unegocios.une_cla_zona='" . $this->select3 . "' ";
                    
                    
                }
                if ($this->select4 != ""&&$this->select4!= "0") {
                    $sqluneg.= " AND ca_unegocios.une_cla_estado='" . $this->select4 . "' ";
                    
                    
                }
                if ($this->select5 != ""&&$this->select5!= "0") {
                    $sqluneg.= " AND ca_unegocios.une_cla_ciudad='" . $this->select5 . "' ";
                    
                    
                }
                if ($this->select6 != ""&&$this->select6 != "0") {
                    $sqluneg.= " AND ca_unegocios.une_cla_franquicia='" . $this->select6 . "' ";
                    
                    
                }
                
            }
            
            if($cuenta) {
                if($cuenta!=-1)
                    $sqluneg.=" and ca_unegocios.cue_clavecuenta=".$cuenta;
            }
           
            //echo $mes_asig."--".$mes_asigfin;
            if($tipo_cons=="p") {
                $sqluneg.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:mes_asig),'%d.%m.%Y') 
                            and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:mes_asigfin),'%d.%m.%Y') order by ins_generales.i_numreporte";
                $parametros["mes_asig"]=$mes_asig;
                $parametros["mes_asigfin"]=$mes_asigfin;
            } else if($tipo_cons=="v") {
                $sqluneg.=" and concat(ca_unegocios.une_id) = :punvta";
                $parametros["punvta"]=$punvta;
            } else {
                $sqluneg.=" and ins_generales.i_fechavisita=:fechar order by ins_generales.i_numreporte";
                $parametros["fechar"]=$fechar;
            }
            //echo $sqluneg;
            //die();
            $resultuneg=Conexion::ejecutarQuery($sqluneg,$parametros);
        
            //comenzamos en a
            $ren_ex=4;
            try{
            Conexion::ejecutarQuerysp("truncate table tmp_generales");
          
            foreach($resultuneg as $rowuneg) {
                $letra=65;
                // inserto enla tabla temporal
                $reporte=$rowuneg["i_numreporte"];
                $queryi="insert into tmp_generales values(:cliente,1,'". $rowuneg["i_numreporte"]."')";
                $parametros2=array("cliente"=>$this->cliente);
                $resulti=Conexion::ejecutarInsert($queryi,$parametros2);
                
                for($i=0;$i<3;$i++) {//despliego cada columna
                    if ($i>=1) {
                        $this->worksheet->write($this->michr($letra).$ren_ex, $rowuneg[$i], $text_format_det);
                    } else {
                        $this->worksheet->write($this->michr($letra).$ren_ex, $rowuneg[$i], $text_format_det1);
                    }
                    $letra++;
                }
                $letra++;
                for($i=3;$i<6;$i++) {//despliego cada columna
                    if ($i>=1) {
                        $this->worksheet->write($this->michr($letra).$ren_ex, $rowuneg[$i], $text_format_det);
                    } else {
                        $this->worksheet->write($this->michr($letra).$ren_ex, $rowuneg[$i], $text_format_det1);
                    }
                    $letra++;
                }
                if ($grupous=="cic") {
                    $this->worksheet->write($this->michr(88).$ren_ex, $rowuneg[5], $text_format_det1);
                    $this->worksheet->write($this->michr(89).$ren_ex, $rowuneg[6], $text_format_det1);
                    $this->worksheet->write($this->michr(90).$ren_ex, $rowuneg[7], $text_format_det1);
                    $this->worksheet->write($this->michr(91).$ren_ex, $rowuneg[8], $text_format_det1);
                    $this->worksheet->write($this->michr(92).$ren_ex, $rowuneg[9], $text_format_det1);
                    $this->worksheet->write($this->michr(93).$ren_ex, $rowuneg[10], $text_format_det1);
                    $this->worksheet->write($this->michr(94).$ren_ex, $rowuneg[11], $text_format_det1);
                } else {
                    $this->worksheet->write($this->michr(115).$ren_ex, $rowuneg[6], $text_format_det1);
                    $this->worksheet->write($this->michr(116).$ren_ex, $rowuneg[7], $text_format_det1);
                    $this->worksheet->write($this->michr(117).$ren_ex, $rowuneg[8], $text_format_det1);
                    $this->worksheet->write($this->michr(118).$ren_ex, $rowuneg[9], $text_format_det1);
                    $this->worksheet->write($this->michr(119).$ren_ex, $rowuneg[10], $text_format_det1);
                    $this->worksheet->write($this->michr(120).$ren_ex, $rowuneg[11], $text_format_det1);
                    $this->worksheet->write($this->michr(121).$ren_ex, utf8_decode($rowuneg[12]), $text_format_det1);
                }
                $ren_ex++;
            }  // termina el while
           
            }
            catch(Exception $ex){
          
                throw new Exception ("Hubo un error al hacer su consulta, intente otra");
            }
            
            //busco resultados de estandar
            if ($grupous=="cic") {
                $letra=74;
            } else {
                $letra=78;
            }
            
            for($i=0;$i<4;$i++){
                $this->consultaEstandarRes($reactivos[$i], $letra, $text_format_det,$text_format_det1);
                $letra++;
            }
         
            
            ///********** obtengo los ratios
            
            if ($grupous=="cic") {
            } else {
                $letra=96;
                for($i=4;$i<sizeof($reactivos);$i++){
                    $this->consultaEstandarRes($reactivos[$i], $letra, $text_format_det, $text_format_det1);
                    $letra++;
                }
            }
          
            
            // asigna mantenimiento correctivo
            $ren_ex=4;
        
            $this->asmantcor1( $this->letras,$ren_ex, $text_format_det,$grupous);
            
            // asigna sanitizacion y agua
            if ($grupous=="cic") {
            } else {
                $ren_ex=4;
                $this->assanitiza($this->letras, $ren_ex, $text_format_det);
                $ren_ex=4;
              
                $this->asagua($this->letras, $ren_ex, $text_format_det);
            }
            //numero de activo
            $ren_ex=4;
            $this->letras=68;
          
           $this->asNumActivo($ren_ex,$this->letras, $text_format_det, $text_format_det);
       // die(); 
     
        }
        
        
        function asNumActivo($renglon,$letra, $text_format_det, $text_format_det1){
           
          
            // busca el numero de renglon a utilizar
            $queryren="SELECT i_numreporte,ida_numrenglon FROM tmp_generales left Join
(SELECT  ida_claveservicio, ida_numreporte, ida_numrenglon FROM `ins_detalleabierta`
where ida_claveservicio=1 and ida_numseccion=2 and ida_numreactivo=1 and ida_numcomponente=2
and ida_numcaracteristica1=0 and ida_numcaracteristica2=0 and ida_numcaracteristica3=10
and ida_descripcionreal = 1)  AS A on tmp_generales.i_claveservicio = ida_claveservicio AND i_numreporte = ida_numreporte
group by i_numreporte order by i_numreporte;";
            $result_ren = Conexion::ejecutarQuerysp($queryren);
            foreach ($result_ren as $row_ren) {
                $numren=$row_ren["ida_numrenglon"];
                $numreporte=$row_ren["i_numreporte"];
                if ($numren) {
//                     $query_na="SELECT ida_descripcionreal, ida_numreporte FROM `ins_detalleabierta`
// where ida_claveservicio=1 and ida_numseccion=2 and ida_numreactivo=1 and ida_numcomponente=2
// and ida_numcaracteristica1=0 and ida_numcaracteristica2=0 and ida_numcaracteristica3=9 and ida_numreporte='".$numreporte."' and ida_numrenglon=".$numren;
                    //echo $query_na;$reporte,$numser,$seccion,$reactivo,$componente,$caract1,$caract2,$caract3,$renglon, $tabla
                   
                    $result_numact = DatosAbierta::consultaInsDetalleAbierta($numreporte,$this->servicio,2,1,2,0,0,9,$numren,"ins_detalleabierta");
                    foreach ($result_numact as $row_na) {
                        $numactivo=$row_na["ida_descripcionreal"];
                    }
                }else{
                    $numactivo="";
                }
                $this->worksheet->write($this->michr($letra).$renglon, $numactivo, $text_format_det1);
                $renglon++;
            }
        }
        
        
        
        
        function asmantcor1($letrai, $nren, $text_format_det, $grupous){
           
            $mantcor=" ";
            $razonmant=" ";
            
            $query="select   ide_valorreal,  ide_aceptado, red_clavecatalogo, ide_numcaracteristica3, ide_numseccion, sum(causa) as totcausa, ide_numreporte
FROM tmp_generales left Join
(select ide_claveservicio, ide_numreporte, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreactivo, ins_detalleestandar.ide_numcomponente, ins_detalleestandar.ide_numcaracteristica1, ins_detalleestandar.ide_numcaracteristica2,
ins_detalleestandar.ide_numcaracteristica3, ins_detalleestandar.ide_valorreal, cue_reactivosestandardetalle.red_tipodato, cue_reactivosestandardetalle.red_clavecatalogo, ins_detalleestandar.ide_aceptado,
if (ide_numcaracteristica3=6 and ide_aceptado =0,1,if (ide_numcaracteristica3=9 and ide_aceptado =0,2,0)) as causa
FROM ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND
ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
where (ins_detalleestandar.ide_numseccion=8 and ins_detalleestandar.ide_numreactivo=0 and ins_detalleestandar.ide_numcomponente=2 and ins_detalleestandar.ide_numcaracteristica1=0 and ins_detalleestandar.ide_numcaracteristica2=0
and ins_detalleestandar.ide_numcaracteristica3=6)  or (ins_detalleestandar.ide_numseccion=8 and ins_detalleestandar.ide_numreactivo=0 and ins_detalleestandar.ide_numcomponente=2 and ins_detalleestandar.ide_numcaracteristica1=0 and ins_detalleestandar.ide_numcaracteristica2=0
and ins_detalleestandar.ide_numcaracteristica3=9)and ins_detalleestandar.ide_claveservicio=1 and ide_numrenglon=1 ) as res on tmp_generales.i_claveservicio = ide_claveservicio AND i_numreporte = ide_numreporte group by i_numreporte order by i_numreporte";
          
            $result=Conexion::ejecutarQuerysp($query);
            foreach($result as $row) {
                switch ($row["totcausa"])
                {
                    case '0' :
                        $mantcor= "";
                        $razonmant= "";
                        break;
                    case '1' :
                        $mantcor= "Si";
                        $razonmant= "TEMPERATURA";
                        break;
                    case '2' :
                        $mantcor= "Si";
                        $razonmant= "VOLUMEN DE CO2";
                        break;
                    case '3' :
                        $mantcor= "Si";
                        $razonmant= "TEMPERATURA Y VOLUMEN DE CO2";
                        break;
                    default :
                        $mantcor= "";
                        $razonmant= "";
                        break;
                }
                $nrep=$row["ide_numreporte"];
                $saboresX=$this->consultaRatio($nrep, $nren, $text_format_det,$grupous);
                if ($saboresX) {
                    if ($razonmant) {
                        $razonmant = $razonmant.";".$saboresX;
                    } else {
                        $mantcor= "Si";
                        $razonmant = $saboresX;
                    }
                }
                $this->letras= $this->michr(72);
                $this->worksheet->write ($this->letras.$nren, $mantcor, $text_format_det);
                
                $this->letras= $this->michr(73);
                $this->worksheet->write ($this->letras.$nren, $razonmant, $text_format_det);
                $nren++;
            }
        }
        
        function assanitiza($letrai, $nren, $text_format_det){
            //echo $referencia;
         
            
            $sanitiza=" ";
            $descsani=" ";
            $query="select ide_valorreal, ide_aceptado, red_clavecatalogo,  ide_numseccion, ide_numreporte, sum(causa) as totcausa, ide_numcaracteristica3  FROM tmp_generales  left Join
(select ide_claveservicio, ide_numreporte, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreactivo, ins_detalleestandar.ide_numcomponente, ins_detalleestandar.ide_numcaracteristica1, ins_detalleestandar.ide_numcaracteristica2, ins_detalleestandar.ide_numcaracteristica3, ins_detalleestandar.ide_valorreal, cue_reactivosestandardetalle.red_tipodato, cue_reactivosestandardetalle.red_clavecatalogo, ins_detalleestandar.ide_aceptado,
 if (ide_numcaracteristica3=16 and ide_aceptado =0,1,if (ide_numcaracteristica3=17 and ide_aceptado =0,2,if (ide_numcaracteristica3=18 and ide_aceptado =0,9,0))) as causa
FROM ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2 AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2
WHERE
ins_detalleestandar.ide_numseccion =  5 AND
ins_detalleestandar.ide_numreactivo =  0 AND
ins_detalleestandar.ide_numcomponente =  2 AND
ins_detalleestandar.ide_numcaracteristica1 =  0 AND
ins_detalleestandar.ide_numcaracteristica2 =  0 AND
ins_detalleestandar.ide_claveservicio =  1 AND
ins_detalleestandar.ide_numrenglon =  1 AND
(ins_detalleestandar.ide_numcaracteristica3 =  '17'  OR ins_detalleestandar.ide_numcaracteristica3 =  '16' OR ins_detalleestandar.ide_numcaracteristica3 =  '18')
 ) as res
on tmp_generales.i_claveservicio = ide_claveservicio AND i_numreporte = ide_numreporte group by i_numreporte order by i_numreporte";
            //echo $query;
            $result=Conexion::ejecutarQuerysp($query);
            foreach($result as $row) {
                switch ($row["totcausa"])
                {
                    case '0' :
                        $mantcor= "";
                        $razonmant= "";
                        break;
                    case '1' :
                        $mantcor= "Si";
                        $razonmant= "CUENTA TOTAL";
                        break;
                    case '2' :
                        $mantcor= "Si";
                        $razonmant= "COLIFORMES TOTALES";
                        break;
                    case '9' :
                        $mantcor= "Si";
                        $razonmant= "E COLI";
                        break;
                    case '10' :
                        $mantcor= "Si";
                        $razonmant= "CUENTA TOTAL Y E COLI";
                        break;
                    case '3' :
                        $mantcor= "Si";
                        $razonmant= "CUENTA TOTAL Y COLIFORMES TOTALES";
                        break;
                    case '11' :
                        $mantcor= "Si";
                        $razonmant= "COLIFORMES TOTALES Y E COLI";
                        break;
                    case '12' :
                        $mantcor= "Si";
                        $razonmant= "CUENTA TOTAL, COLIFORMES TOTALES Y E COLI";
                        break;
                    default :
                        $mantcor= "";
                        $razonmant= "";
                        break;
                }
                //$this->letras= $this->michr(70);
                //$this->worksheet->write ($this->letras.$nren, $mantcor, $text_format_det);
                $this->letras= $this->michr(74);
               
                $this->worksheet->write ($this->letras.$nren, $mantcor, $text_format_det);
                $this->letras= $this->michr(75);
                $this->worksheet->write ($this->letras.$nren, $razonmant, $text_format_det);
                $nren++;
            }
        }
        
        function asagua($letrai, $nren, $text_format_det){
        
            
            $sanitiza=" ";
            $descsani=" ";
            
            $query="select ide_valorreal, ide_aceptado, red_clavecatalogo, ide_numcaracteristica3, ide_numseccion, sum(causa) as totcausa FROM tmp_generales left Join
(select ide_claveservicio, ide_numreporte, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreactivo, ins_detalleestandar.ide_numcomponente, ins_detalleestandar.ide_numcaracteristica1, ins_detalleestandar.ide_numcaracteristica2,
ins_detalleestandar.ide_numcaracteristica3, ins_detalleestandar.ide_valorreal, cue_reactivosestandardetalle.red_tipodato, cue_reactivosestandardetalle.red_clavecatalogo, ins_detalleestandar.ide_aceptado,
if (ide_numcaracteristica3=5 and ide_aceptado =0,1,if (ide_numcaracteristica3=6 and ide_aceptado =0,2,if (ide_numcaracteristica3=9 and ide_aceptado =0,9,if (ide_numcaracteristica3=7 and ide_aceptado =0,13,if (ide_numcaracteristica3=8 and
 ide_aceptado =0,17,0))))) as causa FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica
AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
where ins_detalleestandar.ide_numseccion=5 and ins_detalleestandar.ide_numreactivo=0 and ins_detalleestandar.ide_numcomponente=2
and ins_detalleestandar.ide_numcaracteristica1=0 and ins_detalleestandar.ide_numcaracteristica2=0 and (ins_detalleestandar.ide_numcaracteristica3=5 or  ins_detalleestandar.ide_numcaracteristica3=6 or  ins_detalleestandar.ide_numcaracteristica3=9
or  ins_detalleestandar.ide_numcaracteristica3=7 or  ins_detalleestandar.ide_numcaracteristica3=8) and ins_detalleestandar.ide_claveservicio=1 and ide_numrenglon=1)
as res on tmp_generales.i_claveservicio = ide_claveservicio AND i_numreporte = ide_numreporte group by i_numreporte order by i_numreporte";
            $result=Conexion::ejecutarQuerysp($query);
            foreach($result as $row) {
                switch ($row["totcausa"])
                {
                    case '0' :
                        $mantcor= "";
                        $razonmant= "";
                        break;
                    case '1' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD";
                        break;
                    case '2' :
                        $mantcor= "Si";
                        $razonmant= "DUREZA";
                        break;
                    case '3' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD Y DUREZA";
                        break;
                    case '9' :
                        $mantcor= "Si";
                        $razonmant= "SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '10' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '11' :
                        $mantcor= "Si";
                        $razonmant= "DUREZA Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '12' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD, DUREZA Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '13' :
                        $mantcor= "Si";
                        $razonmant= "CLORO LIBRE";
                        break;
                    case '14' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD Y CLORO LIBRE";
                        break;
                    case '15' :
                        $mantcor= "Si";
                        $razonmant= "DUREZA Y CLORO LIBRE";
                        break;
                    case '17' :
                        $mantcor= "Si";
                        $razonmant= "CLORO TOTAL";
                        break;
                    case '18' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD Y CLORO TOTAL";
                        break;
                    case '19' :
                        $mantcor= "Si";
                        $razonmant= "DUREZA Y CLORO TOTAL";
                        break;
                    case '22' :
                        $mantcor= "Si";
                        $razonmant= "CLORO LIBRE Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '24' :
                        $mantcor= "Si";
                        $razonmant= "DUREZA, CLORO LIBRE Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '25' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD, DUREZA, CLORO LIBRE Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '26' :
                        $mantcor= "Si";
                        $razonmant= "CLORO TOTAL Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '30' :
                        $mantcor= "Si";
                        $razonmant= "CLORO LIBRE Y CLORO TOTAL";
                        break;
                    case '31' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD, CLORO LIBRE Y CLORO TOTAL";
                        break;
                    case '32' :
                        $mantcor= "Si";
                        $razonmant= "DUREZA, CLORO LIBRE Y CLORO TOTAL";
                        break;
                    case '33' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD, DUREZA, CLORO LIBRE Y CLORO TOTAL";
                        break;
                    case '39' :
                        $mantcor= "Si";
                        $razonmant= "CLORO LIBRE, CLORO TOTAL Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '40' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD, CLORO LIBRE, CLORO TOTAL Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    case '42' :
                        $mantcor= "Si";
                        $razonmant= "ALCALINIDAD, DUREZA, CLORO LIBRE, CLORO TOTAL Y SOLIDOS TOTALES DISUELTOS";
                        break;
                    default :
                        $mantcor= "";
                        $razonmant= "";
                        break;
                }
                $this->letras= $this->michr(76);
                $this->worksheet->write ($this->letras.$nren, $mantcor, $text_format_det);
                $this->letras= $this->michr(77);
                $this->worksheet->write ($this->letras.$nren, $razonmant, $text_format_det);
                $nren++;
            }
        }
        
        function consultaRatio($reporte, $ren, $text_format_det,$grupous) {
         
            if ($grupous=="cic") {
                $letra=78;
            } else {
                $letra=82;
            }
            $calival="";
            $motcali="";
            $sabores="";
            $opcion_sabor=array(1,2,4,3,6,5,23,17,16,11,12,15,13,22);
            
            
            // OBTENGO ESTANDAR
            $loop=sizeof($opcion_sabor);
            $sabores="";
            for($i=0;$i<$loop;$i++) {
//                 $queryren="SELECT
//                 ins_detalleestandar.ide_numrenglon
//                 FROM ins_detalleestandar
//                 WHERE ins_detalleestandar.ide_numcaracteristica3 = '4' AND ins_detalleestandar.ide_numseccion = '8'
//                 AND ins_detalleestandar.ide_numcomponente = '1' AND ins_detalleestandar.ide_claveservicio = '1'
//                 AND ins_detalleestandar.ide_numreactivo = '0' AND ins_detalleestandar.ide_numreporte = '$reporte'
//                 AND ins_detalleestandar.ide_valorreal=".$opcion_sabor[$i]." limit 1";
                //echo $queryren;
                $resultren=DatosEst::consultaDetalleEstandarxval($this->servicio, $reporte,4,8,1,0,$opcion_sabor[$i]);
                if(sizeof($resultren)>0){
                    $rowren=$resultren[0]; //solo el primer resultado
//                         $query="SELECT truncate(ide_valorreal,2) as valreal, ide_numrenglon,ide_claveservicio, ide_numreporte, ide_numseccion, ide_numreactivo, ide_numcomponente
//                         FROM ins_detalleestandar  WHERE ide_numcaracteristica3 = '9'
//                         AND ins_detalleestandar.ide_numseccion = '8'
//                         AND ins_detalleestandar.ide_numcomponente = '1' AND ins_detalleestandar.ide_claveservicio = '1'
//                         AND ins_detalleestandar.ide_numreactivo = '0' AND ins_detalleestandar.ide_numreporte = '$reporte'
//                         AND ide_numrenglon=".$rowren["ide_numrenglon"].";";
                       // $vservicio,  $reporte,$caract3,$seccion,$componente,$reactivo,$opcion
                        $result=DatosEst::consultaDetalleEstandar($this->servicio, $reporte,9,8,1,0,$rowren["ide_numrenglon"]);
                     
                        foreach($result as $row) {
                             if (round($row["ide_valorreal"],2)<=4.49 or round($row["ide_valorreal"],2)>=5.51) {
                             
                              //  $calival="Si";
                              //  $sqlsab="SELECT ca_catalogosdetalle.cad_descripcionesp FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '2' AND ca_catalogosdetalle.cad_idopcion =  '".$opcion_sabor[$i]."'";
                                 $motcali=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",2,$opcion_sabor[$i]);
                               
                               //     $motcali=$rowsab["cad_descripcionesp"];
                                    if ($sabores) {
                                        $sabores = $sabores.",".$motcali;
                                    } else {
                                        $sabores = $motcali;
                                    }
                                
                            }
                            $this->worksheet->write($this->michr($letra).$ren, round($row["ide_valorreal"],2), $text_format_det);
                        }
                  
                      $letra++;
                    
                }
                else
                { $this->worksheet->write($this->michr($letra).$ren, "", $text_format_det);
                $letra++;
                }
            }
       
            //	 $this->worksheet->write($this->michr(70).$ren, $calival, $text_format_det);
            //	 $this->worksheet->write($this->michr(71).$ren, $sabores);
            return $sabores;
        }
        
        
        function consultaEstandarRes($referencia,$letra, $text_format_det, $text_format_det1){
            //echo $letra;
            $aux=explode('.', $referencia);
            $renglon=4;
          
            $query="
            select ide_valorreal, red_tipodato,
            red_clavecatalogo FROM tmp_generales
            left Join (select ide_claveservicio,ide_numreporte, ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreactivo,
            ins_detalleestandar.ide_numcomponente, ins_detalleestandar.ide_numcaracteristica1, ins_detalleestandar.ide_numcaracteristica2, ins_detalleestandar.ide_numcaracteristica3,
            ins_detalleestandar.ide_valorreal,
            cue_reactivosestandardetalle.red_tipodato,
            cue_reactivosestandardetalle.red_clavecatalogo FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
            AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo
            AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
            AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND
            ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
            where ins_detalleestandar.ide_numseccion=:seccion and
            ins_detalleestandar.ide_numreactivo=:reactivo and
            ins_detalleestandar.ide_numcomponente=:componente and
            ins_detalleestandar.ide_numcaracteristica1=:caract1 and
            ins_detalleestandar.ide_numcaracteristica2=:caract2 and
            ins_detalleestandar.ide_numcaracteristica3=:caract3 and ins_detalleestandar.ide_claveservicio=:servicio
            and ide_numrenglon=1) as res
            on tmp_generales.i_claveservicio = ide_claveservicio AND i_numreporte = ide_numreporte
            order by i_numreporte";
            
          
            $parametros=array("seccion"=>$aux[0],
                "reactivo"=>$aux[1],
                "componente"=>$aux[2],
                "caract1"=>$aux[3],
                "caract2"=>$aux[4],
                "caract3"=>$aux[5],
                "servicio"=>$this->servicio);
            $result=Conexion::ejecutarQuery($query,$parametros);
         
            foreach($result as $row) {
                //echo $letra;
                if($row["red_tipodato"]=="C")   // busco el valor en catalogo
                {
                    
                    
                    $estandar = DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$row["red_clavecatalogo"],$row["ide_valorreal"]);
                   
                   
                    $this->worksheet->write($this->michr($letra).$renglon,utf8_decode($estandar), $text_format_det1);
                   
                }
                else
                    //echo $letra;
                    $this->worksheet->write($this->michr($letra).$renglon, $row[0], $text_format_det);
                    $renglon++;
                    
            }
            
          
            //return $letra; //regresa la columna que sigue
            
        }
        
        
        function michr($indice){
            //echo $indice;
            if($indice>=65&&$indice<=90){
                return chr($indice);
            }
            if($indice>90&&$indice<=116){
                return "A".chr($indice-26);
            }
            if($indice>116&&$indice<=142){
                return "B".chr($indice-52);
            }
            if($indice>142&&$indice<=168){
                return "C".chr($indice-78);
            }
        }
        
        
        function rangoCeldas($linicio,$renglon, $colspan,$text_format,$worksheet){
            
            //  echo $rango."<br>";
            for($i=1;$i<$colspan;$i++){
                $worksheet->write_blank($this->michr($linicio+$i).$renglon,$text_format);
            }
            
            return $worksheet;
            
        }
        
       
}

