<?php


class BasePostmixController
{
    
    
    private $estilotcuenta;
    private $listaCuentas;
    private $titulo1;
    private $subtitulo;
    private $listaFechas;
    private $listamesIni;
    private $listamesFin;
    private $listaanioIni;
    private $listaanioFin;
    private $listanivel1;
    
    private $listanivel2;
    
    private $listanivel3;
    
    private $listanivel4;
    
    private $listanivel5;
    
    private $listanivel6;
    private $listaUnegocios;
    private $NumeroReportes;
    private $pages;
    private $opcion;
    
    
    /*
    //////////////////////////////////////////////////////////////////////////
    //																		//
    //	codigo para generar reporte en excel   			//
    //																		//
    //////////////////////////////////////////////////////////////////////////*/
    
    public function vistaReportediario(){
    define(VACIO,"");
    
    
    foreach($_POST as $nombre_campo => $valor) {
        $asignacion = "\$" . $nombre_campo . "='" .filter_input(INPUT_POST,$nombre_campo, FILTER_SANITIZE_STRING) . "';";
        eval($asignacion);
        //echo "<br>".$asignacion;
    }
    
    
    @session_start();
    $opcion=filter_input(INPUT_GET,"archivo", FILTER_SANITIZE_STRING); 	//opcionj para saber si genera el archivo o despliega el html
    $_SESSION["clienteind"]=1;
    $_SESSION["servicioind"]=1;
    //$cuenta=$_POST["cuenta"];
    $servicio=$_SESSION["servicioind"];
    $cliente=$_SESSION["clienteind"];
    set_time_limit(360);
    ini_set("memory_limit","120M");
   
    $this->titulo1=T_("EXTRAER BASE POSTMIX");
    $user = $_SESSION["UsuarioInd"];
    $gpous=$_SESSION["GrupoUs"]; 
    $refer=UsuarioModel::buscarReferenciaNivel($user);
    // crea lista de fecha de inspeccion
    // validamos el grupo
    if($gpous=="muf"){
       $ssql=("SELECT date_format(ins_generales.i_fechavisita,'%d-%m-%Y') as fecvis 
FROM ins_generales  Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
      WHERE YEAR(ins_generales.i_fechavisita) >=  '2013' 
AND ins_generales.i_claveservicio =  :servicio and
      concat(ca_unegocios.une_cla_region,'.',ca_unegocios.une_cla_pais,'.',ca_unegocios.une_cla_zona,'.',ca_unegocios.une_cla_estado)='".$refer."'
      GROUP BY ins_generales.i_fechavisita ORDER BY ins_generales.i_fechavisita DESC");
    }else{
        $ssql=("SELECT date_format(ins_generales.i_fechavisita,'%d-%m-%Y') as fecvis 
FROM ins_generales WHERE YEAR(ins_generales.i_fechavisita) >=  '2013' 
AND ins_generales.i_claveservicio =  :servicio GROUP BY ins_generales.i_fechavisita 
ORDER BY ins_generales.i_fechavisita DESC");
    }
    $rs=Conexion::ejecutarQuery($ssql,array("servicio"=>$servicio));

    
    foreach ($rs as $row) {
        $this->listaFechas[]=$row["fecvis"];
     
    }
    
    
    }
    
    public function vistaReportePeriodo()
    {
    
        $_SESSION["clienteind"]=1;
        $_SESSION["servicioind"]=1;
        $gpous=$_SESSION["GrupoUs"]; 
        $this->opcion=filter_input(INPUT_GET, "op",FILTER_SANITIZE_STRING);
        /*para la opcion de extraer bd o resumen de result.*/
        if($this->opcion=="bp"){
            $this->titulo1=T_("EXTRAER BASE POSTMIX");
            $this->subtitulo=T_("REPORTE POR PERIODO");
        }else
            if($this->opcion=="CSD"){
                $this->titulo1="SURVEY DATA";
                $this->subtitulo="";
        }
        else {$this->titulo1=T_("RESUMEN ANUAL");
            $this->subtitulo="";
        }
    //muestro menu cuentas
        if($gpous=="cue"){
            $this->estilotcuenta='style="display:none"';
            
        }else{
            /***************para las listas de seleccion******************/
            
           $rs=DatosCuenta::cuentasxCliente2("ca_cuentas",$_SESSION["clienteind"]);
           $i=0;
            foreach ($rs as $row) {
                
                $this->listaCuentas[]="<div  >".
                    " <input type=\"checkbox\" id=\"cuenta_".$i++."\" name=\"cuenta[]\" value=\"".$row["cue_id"]."\" />".$row["cue_descripcion"]."</div>";
              
            }
         }
    }
    public function vistaHistoricoPV(){
        $_SESSION["clienteind"]=1;
        $_SESSION["servicioind"]=1;
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
        
        $select1=$clanivel1;
       $select2=$clanivel2;
        $select3=$clanivel3;
        $select4=$clanivel4;
        $select5=$clanivel5;
        $select6=$clanivel6;
    // inicia llenado de listas
   
    $rs_usuarios =  UsuarioModel::getUsuario($_SESSION["UsuarioInd"], "cnfg_usuarios");
    foreach ($rs_usuarios as  $row_usuarios) {
        $GradoNivel = $row_usuarios ["cus_tipoconsulta"];
        $grupo = $row_usuarios ["cus_clavegrupo"];
        $Nivel01 = $row_usuarios ["cus_nivel1"];
        $Nivel02 = $row_usuarios ["cus_nivel2"];
        $Nivel03 = $row_usuarios ["cus_nivel3"];
        $Nivel04 = $row_usuarios ["cus_nivel4"];
        $Nivel05 = $row_usuarios ["cus_nivel5"];
        $Nivel06 = $row_usuarios ["cus_nivel6"];
        $uscliente= $row_usuarios ["cus_cliente"];
       
    }
    
    $VarNivel2 = $GradoNivel;
   
   // muestra select de cliente y servicio
    $bancli=0;
    $banserv=0;
    $bancuenta=0;
    $banfran=0;
    
    if($VarNivel2=="")
        $VarNivel2=1;
        if ($grupo == 'adm' || $grupo == 'mue' || $grupo == 'cli'|| $grupo == 'aud' || $grupo == 'muf') {
            
            
            if ($grupo == 'adm' || $grupo == 'mue'|| $grupo == 'aud' || $grupo == 'muf')
                //nivel uno por default
                $GradoNivel = $VarNivel2 ;
                $this->varnivel=$VarNivel2;
                if ($VarNivel2 == NULL) {
                    
                } else {
                    // die($VarNivel2."--".$grupo);
                    $Nivel01 = 1;
                    
                    if ($VarNivel2 == 1) {
                        
                        $rs = Datosndos::vistandosModel($Nivel01, "ca_nivel2");
                        $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                        
                        //  $this->listanivel1=  Utilerias::crearSelectCascada(Estructura::nombreNivel(1,$_SESSION["idiomaus"]),1, Utilerias::crearOpcionesSelCad( $rs, $select1),"");;
                        $this->listanivel2=  Utilerias::crearSelectCascada(Estructura::nombreNivel(2,$_SESSION["idiomaus"]),2, Utilerias::crearOpcionesSelCad( $rs, $select2),"");
                        
                        $this->listanivel3 = Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3, Utilerias::crearOpcionesNivel(3,  $select2,$select3),"disabled");
                        //   die( $this->listanivel3 )  ;
                        $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"disabled");
                        
                        $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                        $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                        if(isset($select2)&&$select2!=0){
                            $this->listanivel3=Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3,Utilerias::crearOpcionesNivel(3,  $select2,$select3),"");
                        }
                        if(isset($select3)&&$select3!=0){
                            $this->listanivel3=Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3,Utilerias::crearOpcionesNivel(3,  $select2,$select3),"");
                            
                            $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                            
                        }
                        if(isset($select4)&&$select4!=0){
                            $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                            $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                            
                        }
                        if(isset($select5)&&$select5!=0){
                            $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                            
                        }
                        
                        if(isset($select6)&&$select6!=0){
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                        }
                        //                     foreach ($rs as $row) {
                        //                         // if ($row["n1_id"] == $clanivel1) {
                        //                         // $this->listanivel1[] = "<option value='" . $row["reg_clave"] . "' selected='selected'>" . $row["reg_nombre"] . "</option>";
                        //                         // } else {
                        //                         $this->listanivel1[] = "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                        //                         // }
                        //                     }
                        // $this->listanivel1[] = "</select>";
                        
                        //                     $this->nombrenivel2 = Estructura::nombreNivel(2, $_SESSION["idiomaus"]);
                        //                     $this->nombrenivel3 = Estructura::nombreNivel(3, $_SESSION["idiomaus"]);
                        
                        //                     $this->nombrenivel4 = Estructura::nombreNivel(4, $_SESSION["idiomaus"]);
                        
                        //                     $this->nombrenivel5 = Estructura::nombreNivel(5, $_SESSION["idiomaus"]);
                        //                     $this->nombrenivel6 = Estructura::nombreNivel(6, $_SESSION["idiomaus"]);
                        //                     $this->listanivel3 = Utilerias::crearOpcionesNivel($Nivel01, $select2, $select3);
                        
                        //                     if (isset($select3) && $select3 != 0) {
                        //                         $this->listanivel4 = Utilerias::crearOpcionesNivel($Nivel01, $select3, $select4);
                        //                     }
                        //                     if (isset($select4) && $select4 != 0) {
                        //                         $this->listanivel5 = Utilerias::crearOpcionesNivel($Nivel01, $select4, $select5);
                        //                     }
                        
                        //                     if (isset($select5) && $select5 != 0) {
                        //                         $this->listanivel6 = Utilerias::crearOpcionesNivel($Nivel01, $select5, $select6);
                        //                     }
                    }
                    if ($VarNivel2 == 2) {
                        
                        $RS_SQM_TE = Datosntres::vistantresModel($Nivel02,"ca_nivel3" );
                        
                        $this->listanivel3 = Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3,  Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select3),"");
                        //   die( $this->listanivel3 )  ;
                        $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"disabled");
                        
                        $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                        $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                        
                        //  $this->listanivel2[] = Utilerias::crearSelect("select3", $RS_SQM_TE, $select2);
                        
                        /* * **************************************************** */
                        //   $this->listanivel4[] = "<select style='width:300px' name='select4' id='select4' >
                        //                                                                  <option value=''>- " . strtoupper(T_("Todos")) . " -</option></select>";
                        $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                        $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $Nivel02 . "'>";
                        
                        //                     $this->listanivel3[] = "<input type='hidden' name='select2' id='select2' value='" . $Nivel02 . "'>";
                        //                     $this->listanivel5[] = "<select style='width:300px' name='select5' id='select5' >
                        //                                                                  <option value=''>- " . strtoupper(T_("Todos")) . " -</option></select>";
                        //                     $this->listanivel6[] = "<select style='width:300px' name='select6' id='select6' >
                        //                                                 <option value=''>- " . strtoupper(T_("Todos")) . " -</option></select>";
                        
                        /* * ******************************************************************* */
                        if(isset($select3)){
                            $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                        }
                        if(isset($select4)&&$select4!=0){
                            $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"");
                            $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                            
                        }
                        if(isset($select5)&&$select5!=0){
                            $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                            
                        }
                        
                        if(isset($select6)&&$select6!=0){
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                        }
                    }
                    if ($VarNivel2 == 3) {
                        $RS_SQM_TE = Datosncua::vistancuaModel( $Nivel03,"ca_nivel4");
                        $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4, Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select4),"");
                        
                        $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                        $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                        
                        //  $this->listanivel2[] = Utilerias::crearSelect("select3", $RS_SQM_TE, $select2);
                        
                        /* * **************************************************** */
                        //   $this->listanivel4[] = "<select style='width:300px' name='select4' id='select4' >
                        //                                                                  <option value=''>- " . strtoupper(T_("Todos")) . " -</option></select>";
                        $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                        $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $Nivel02 . "'>";
                        $this->listanivel3 = "<input type='hidden' name='clanivel3' id='select3' value='" . $Nivel03 . "'>";
                        if(isset($select4)&&$select4!=0){
                            $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                        }
                        if(isset($select5)&&$select5!=0){
                            $this->listanivel5=Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5, $select4,$select5),"");
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                            
                        }
                        
                        if(isset($select6)&&$select6!=0){
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                        }
                    }
                    
                    if ($VarNivel2 == 4) {
                        /* * **NUEVO MODULO PHP** */
                        
                        $RS_SQM_TE = Datosncin::vistancinModel( $Nivel04, "ca_nivel5");
                        $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5, Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select5),"");
                        $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                        
                        //  $this->listanivel2[] = Utilerias::crearSelect("select3", $RS_SQM_TE, $select2);
                        
                        /* * **************************************************** */
                        //   $this->listanivel4[] = "<select style='width:300px' name='select4' id='select4' >
                        //                                                                  <option value=''>- " . strtoupper(T_("Todos")) . " -</option></select>";
                        $this->listanivel1 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                        $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $Nivel02 . "'>";
                        $this->listanivel3 = "<input type='hidden' name='clanivel3' id='select3' value='" . $Nivel03 . "'>";
                        $this->listanivel4 = "<input type='hidden' name='clanivel4' id='select4' value='" . $Nivel04 . "'>";
                        if(isset($select5)&&$select5!=0){
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                        }
                        if(isset($select6)&&$select6!=0){
                            $this->listanivel6= Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6,  $select5,$select6),"");
                        }
                    }
                    
                    if ($VarNivel2 == 5) {
                        
                        $RS_SQM_TE = Datosnsei::vistanseiModel( $Nivel05,"ca_nivel6");
                        
                        $this->listanivel6 = Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6, Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select6),"");
                        //$this->listanivel1 = "<input type='hidden' name='select1' id='select1' value='" . $Nivel01 . "'>";
                        
                        $this->listanivel2 = "<input type='hidden' name='clanivel1' id='select1' value='" . $Nivel01 . "'>";
                        $this->listanivel3 = "<input type='hidden' name='clanivel2'  id='select2' value='" . $Nivel02 . "'>";
                        $this->listanivel4 = "<input type='hidden' name='clanivel3' id='select3' value='" . $Nivel03 . "'>";
                        $this->listanivel5 = "<input type='hidden' name='clanivel4' id='select4' value='" . $Nivel04 . "'>";
                        $this->listanivel1 = "<input type='hidden' name='clanivel5' id='select5' value='" . $Nivel05 . "'>";
                        /* * ******************************************************************* */
                        
                        
                    }
                    if ($VarNivel2 == 6) {
                        /* * **NUEVO MODULO PHP** */
                        
                        $this->listanivel1 = "<input type='hidden' name='clanivel1' value='" . $Nivel01 . "'>";
                        $this->listanivel2= "<input type='hidden' name='clanivel2' value='" . $Nivel02 . "'>";
                        $this->listanivel3= "<input type='hidden' name='clanivel3' value='" . $Nivel03 . "'>";
                        $this->listanivel4 = "<input type='hidden' name='clanivel4' value='" . $Nivel04 . "'>";
                        $this->listanivel5 = "<input type='hidden' name='clanivel5' value='" . $Nivel05 . "'>";
                        $this->listanivel6= "<input type='hidden' name='clanivel6' value='" . $Nivel06 . "'>";
                        /* * ******************************************************************* */
                    }
                }
        }
        
        
        // inicio despliegue de listas
        
     
        if ($busqueda==1) {
            
            
            $vclienteu=$_SESSION["clienteind"];
            $vserviciou=1;
            $fily = array(
                "cta" => $cuenta,
                "fra" => $franquiciacta
            );
            $filx = array(
                "pais" => $select1,
                "uni" => $select2,
                "zon=>" => $select3,
                "reg" => $select4,
                "ciu" => $select5,
                "niv6" => $select6
            );
            
            // //inserta reportes en la tabla temporal tmp_estadistica
            
            $rs_sql_us = DatosUnegocio::unegociosxNivelxServicio($vserviciou,$fil_ptoventa, $fil_idpepsi, $filx, $fily, "", "");
            
            $num_reg = sizeof($rs_sql_us);
                if ($num_reg >0) {
                    
                 
                        
                        $this->pages = new Paginator($num_reg, 9, array(
                            10,
                            3,
                            6,
                            9,
                            12,
                            25,
                            50,
                            100,
                            250,
                            'All'
                        ));
                      
                       // die();
                        $rs_sql_us = DatosUnegocio::unegociosxNivelxServicio($vserviciou,$fil_ptoventa, $fil_idpepsi, $filx, $fily, $this->pages->limit_start, $this->pages->limit_end);
                        
                        
                        foreach ($rs_sql_us  as $row_rs_sql_c) {
                        $color = "subtitulo31";
                        $fily=$row_rs_sql_c["cue_clavecuenta"].".".$row_rs_sql_c["fc_idfranquiciacta"];
                        
                        //$direccion="MENprincipal.php?op=mindi&admin=consulta2&ptv=".$row_rs_sql_c["une_claveunegocio"]."&fily=".$fily;
                        $direccion="imprimirReporte.php?punvta=".$row_rs_sql_c["une_id"]."&tipo_consulta=v";
                        $uneg=array();
                        $uneg['NomPuntoVenta']= "<td  class='$color'><a href='".$direccion."'>" . $row_rs_sql_c ["une_descripcion"] . "</a></td>" ;
                      //  $uneg['Pepsi']= "<td  class='$color'><a href='".$direccion."'>" . $row_rs_sql_c ["une_idpepsi"] . "</a></td>" ;
                        $uneg['NUD']= "<td  class='$color'><a href='".$direccion."'>" . $row_rs_sql_c ["une_num_unico_distintivo"] . "</a></td>" ;
                        
                        // $html->asignar ( 'ICuenta', "<td  class='$color' ><a href='".$direccion."'>" . $row_rs_sql_c ["une_idcuenta"] . "</a></td>" );
                        $uneg['CiudadN']= "<td  class='$color' ><a href='".$direccion."'>" . $row_rs_sql_c ["une_dir_municipio"] . "</a></td>" ;
                        $uneg[ 'Direccion']="<td  class='$color' ><a href='".$direccion."'>" . $row_rs_sql_c ["direccion"] . "</a></td>" ;
                        
                        $this->listaUnegocios[]=$uneg;
                       
                    }
                    if ($num_reg == 0) {
                        $this->NumeroReportes="<label style='color:#F00'>Su búsqueda no produjo ningún resultado !!!</label>" ;
                    } else {
                        $this->NumeroReportes=strtoupper(T_("Total de Reportes")).": " . $num_reg ;
                    }
                    
                    
                    
                } 
        // finaliza llenado de listas
        }   
        // termina nueva seccion historico
        }
    /**
     * @return the $estilotcuenta
     */
    public function getEstilotcuenta()
    {
        return $this->estilotcuenta;
    }

    /**
     * @return the $listaCuentas
     */
    public function getListaCuentas()
    {
        return $this->listaCuentas;
    }

    /**
     * @return the $titulo1
     */
    public function getTitulo1()
    {
        return $this->titulo1;
    }

    /**
     * @return the $listaFechas
     */
    public function getListaFechas()
    {
        return $this->listaFechas;
    }

    /**
     * @return the $listamesIni
     */
    public function getListamesIni()
    {
        return $this->listamesIni;
    }

    /**
     * @return the $listamesFin
     */
    public function getListamesFin()
    {
        return $this->listamesFin;
    }

    /**
     * @return the $listaanioIni
     */
    public function getListaanioIni()
    {
        return $this->listaanioIni;
    }

    /**
     * @return the $listaanioFin
     */
    public function getListaanioFin()
    {
        return $this->listaanioFin;
    }

    /**
     * @return the $listanivel1
     */
    public function getListanivel1()
    {
        return $this->listanivel1;
    }

    /**
     * @return the $listanivel2
     */
    public function getListanivel2()
    {
        return $this->listanivel2;
    }

    /**
     * @return the $listanivel3
     */
    public function getListanivel3()
    {
        return $this->listanivel3;
    }

    /**
     * @return the $listanivel4
     */
    public function getListanivel4()
    {
        return $this->listanivel4;
    }

    /**
     * @return the $listanivel5
     */
    public function getListanivel5()
    {
        return $this->listanivel5;
    }

    /**
     * @return the $listanivel6
     */
    public function getListanivel6()
    {
        return $this->listanivel6;
    }

    /**
     * @return the $listaUnegocios
     */
    public function getListaUnegocios()
    {
        return $this->listaUnegocios;
    }

    /**
     * @return the $NumeroReportes
     */
    public function getNumeroReportes()
    {
        return $this->NumeroReportes;
    }
    /**
     * @return the $pages
     */
    public function getPages()
    {
        return $this->pages;
    }
    /**
     * @return mixed
     */
    public function getOpcion()
    {
        return $this->opcion;
    }
    /**
     * @return mixed
     */
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }



 
      
      
        
       
        
        
    }