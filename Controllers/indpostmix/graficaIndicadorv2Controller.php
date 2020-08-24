<?php


class GraficaIndicadorv2Controller {

    private $navegacion;
   
    private $mes_indice;
  
  
    private $lb_buscar;
    private $lb_indicadores;
   
    
    private $lugar;
  
    private $periodo;
  
    private $servicio;
    private $cliente;
    private $opciones_anio;
    private $opciones_mes;
    private $listaSecciones;
    private $listanivel2;
    private $listanivel3;
    private $listanivel4;
    private $listanivel5;
    private $listanivel6;
   
    private $filnivelreg; //de la forma 1.1.2.3
    private $filnivelcedis; //de la forma 1.1.2.3
    private $filcuenta; //de la forma 1.1.2.3
    private $UrlCobertura;
    private $UrlCoberturaxReg;
    private $UrlCoberturaxCta;
    private $UrlIndicadores;
    private $titulos; //arreglo para los encabezados de las graficas
    

    public function mostrarFiltros() {
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            eval($asignacion);
        }
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";

            eval($asignacion);
        }
        $_SESSION["servicioind"] = 1;
        $_SESSION["clienteind"]=1;
        $_SESSION["idiomaus"]=1;
        $select2=$clanivel2;
        $select3=$clanivel3;
        $select4=$clanivel4;
        $select5=$clanivel5;
        $select6=$clanivel6;
        $grupo = $_SESSION["GrupoUs"];
        $vidiomau = $_SESSION["idiomaus"];
        $_SESSION["fbuscapv"] = null;
        $this->servicio = 1;
        
        $this->cliente = 1;
      //  $_SESSION['UsuarioInd']="marisol";
        
        /* busca opciones de usuario */
        if(isset ($_SESSION['UsuarioInd']))
                  $Usuario = $_SESSION['UsuarioInd'];
        else{
       //mandar al login
          
        }

        //   include("MENindbarramenu.php");
// genera info grafica

        $this->filtroPeriodo($mes_solo, $anio);
     
// verifico el tipo de usuario
        //filtro de niveles
        $rs_usuarios = UsuarioModel::getUsuario($Usuario,"cnfg_usuarios");
      //  var_dump($rs_usuarios);
        foreach ($rs_usuarios as $row_usuarios ) {
        //            $html->asignar('USUARIO', "<span class='TitPost'>" . $row_usuarios ["cus_nombreusuario"] . "</span>");
            $VarNivel2 = $row_usuarios ["cus_tipoconsulta"];
            $grupo = $row_usuarios ["cus_clavegrupo"];
            $Nivel01 = $row_usuarios ["cus_nivel1"];
            $Nivel02 = $row_usuarios ["cus_nivel2"];
        //                    echo "niv".$Nivel02;
            $Nivel03 = $row_usuarios ["cus_nivel3"];
            $Nivel04 = $row_usuarios ["cus_nivel4"];
            $Nivel05 = $row_usuarios ["cus_nivel5"];
            $Nivel06 = $row_usuarios ["cus_nivel6"];
  
        }
          $_SESSION["fniv"] = $VarNivel2; 
        if ($grupo == "cli" || $grupo == "cue") {
           
            if ($grupo == "cli") {
                if ($VarNivel2 >= 4)
                    $permiso = $VarNivel2; //devuelvo nivel de consulta
                else if ($VarNivel2 < 4)
                    $permiso = 0; //puede ver todos
            } else
            if ($grupo == "cue") {

                if ($Nivel01 > 0) { //es usuario de franquicia
                    $permiso = "P"; //devuelvo cuenta y franquicia
                    if ($Nivel03 > 0) //es usuario por p.v.
                        $permiso = "PP";
                } else    //puede ver toda la cuenta
                    $permiso = "F";
            }
        }

//echo $permiso;
// si permiso=-1 no ver� nada
        if ($permiso == -1) {
            $html->asignar('veo_res', "none");
            $html->asignar('noveo_res', "table-row");
            $html->asignar('lb_Notiene', T_("LO SENTIMOS, NO CUENTA CON PERMISO PARA VER ESTA INFORMACION"));
        } else {
         
// 

            if ($grupo == "cue") {
//                if ($gnivel == "")
//                    $nivel = 2;


//                $reng = $permiso;
                if ($Nivel03!= 0)
                    $gfily = $Nivel01. "." . $Nivel02 . "." . $Nivel03;
                    else if ($Nivel02 != 0)
                   $gfily = $Nivel01. "." . $Nivel02;
               else
                   $gfily = $Nivel01;
                   $gfiluni = $this->crearReferenciaNivelUni($row_usuarios, $grupo);
               // $gfily = UsuarioModel::buscarReferenciaNivel($Usuario,$grupo,$this->servicio,$this->cliente);
            }
            else {
               
                if(isset($select2)&&$select2!="")
                {     //vengo del formulario
                     $gfiluni="1.".$select2.".".$select3;
                     $gfilx=$select4.".".$select5.".".$select6;
                 
                }
                else
                {
                    if($Nivel01=="")
                        $gfiluni="1.1.5";
                    else{
                      $gfiluni=$Nivel01.".".$Nivel02.".".$Nivel03;
                     $gfilx=$Nivel04.".".$Nivel05.".".$Nivel06;
                    }
                }
                ////o vengo del menu
//                     if (($grupo == "cli" || $grupo == "muf") && $permiso > 3) {// si no tengo filtro
//                         $gfilx =    $row_usuarios["cus_nivel4"] . "." . $row_usuarios["cus_nivel5"] . "." . $row_usuarios["cus_nivel6"];
//                     //    $refer = $row_usuarios["cus_nivel4"] . "." . $row_usuarios["cus_nivel5"] . "." . $row_usuarios["cus_nivel6"];
//                     } 
              
            }
                    
          
            $this->filnivelcedis=$gfilx;
            $this->filcuenta=$gfily;
            
            
            $aux = explode(".", $gfilx);
            
            $this->filnivelreg = $gfiluni;
            
            $filx = array();
            
            $filx["reg"] = $aux[0];
            
            $filx["ciu"] = $aux[1];
            $filx["niv6"] = $aux[2];
            
            
            $this->Nivel03 = $aux[0];
            $this->Nivel04 = $aux[1];
            $this->Nivel05 = $aux[2];
            $this->Nivel06 = $aux[3];
            
            $auxy = explode(".", $gfily);
            
            $fily = array();
            
            $fily["cta"] = $auxy[0];
            
            $fily["fra"] = $auxy[1];
            $fily["pv"] = $auxy[2];
            
            $auxuni = explode(".", $gfiluni);
            
            $filx["pais"] = $auxuni[0];
            $filx["uni"] = $auxuni[1];
            $filx["zon"] = $auxuni[2];
//             if ($filx["pais"] != "" && $filx["pais"] != 0) {

//                 $nompais = Datosnuno::nombreNivel1($filx["pais"], "ca_nivel1");
//             }



            if ($filx["uni"] != "" && $filx["uni"] != 0) {
                $nivel=2;
                $nomuni = Datosndos::nombreNivel2($filx["uni"], "ca_nivel2");
            }
            if ($filx["zon"] != "" && $filx["zon"] != 0) {
                $nivel=3;
                $nomzon = "-" . Datosntres::nombreNivel3($filx["zon"], "ca_nivel3");
            }
            if ($filx["reg"] != "" && $filx["reg"] != 0) {
                $nivel=4;
                $nomreg = "-" . Datosncua::nombreNivel4($filx["reg"], "ca_nivel4");
            }
            if ($filx["ciu"] != "" && $filx["ciu"] != 0) {
                $nivel=5;
                $nomciu = "-" . Datosncin::nombreNivel5($filx["ciu"], "ca_nivel5");
            }

//echo $filx["niv6"]; 
            if ($filx["niv6"] != "" && $filx["niv6"] != 0) {
                $nivel=6;
                $nomniv6 = "-" . Datosnsei::nombreNivel6($filx["niv6"], "ca_nivel6");
            }


            if ($fily["cta"] != ""){
                
                $nivel=1;
                $nomcta = DatosCuenta::nombreCuenta($fily["cta"],$this->cliente);
            }
            if ($fily["fra"] != ""){
                 $nivel=2;
                $nomfra = "-" . DatosFranquicia::nombreFranquicia($fily["cta"], $fily["fra"]);
            }
            if ($fily["pv"] != ""){
                 $nivel=3;
                $nompv = "-" . DatosUnegocio::nombrePV( $fily["pv"]);
            }



            $this->lugar = $nomuni . " " . $nomzon . " " . $nomreg . " " . $nomciu . " " . $nomniv6 . " " . $nomcta . " " . $nomfra . " " . $nompv;



     //busco el nivel de consulta y agrupo

         //   die($VarNivel2);

            if($VarNivel2=="")
               $VarNivel2=1;
            
         //   $this->varnivel=$niv;
          //  die($niv);
      //echo $niv;
            if($grupo!="cue"){
                //nivel uno por default
                  
                  //  if($niv>=$VarNivel2){
             //   var_dump($filx);
            	if ($VarNivel2 == 1||$VarNivel2 == 2) {
                                        
                         
                            $RS_SQM_TE = Datosntres::vistantresModel($filx["uni"],"ca_nivel3");
                           
                            $this->listanivel3 = Utilerias::crearSelectCascada(Estructura::nombreNivel(3,$_SESSION["idiomaus"]),3, Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select3),"");
                          //   die( $this->listanivel3 )  ; 
                            $this->listanivel4=Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesNivel(4,  $select3,$select4),"disabled");
                         
                          $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                           $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                           $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $filx["uni"] . "'>";
                           
                          
                            if(isset($select3)&&$select3!=0){
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
                                $RS_SQM_TE = Datosncua::vistancuaModel($filx["zon"],"ca_nivel4");
                                $this->listanivel4 = Utilerias::crearSelectCascada(Estructura::nombreNivel(4,$_SESSION["idiomaus"]),4,Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select4),"");
                             
                                /*                     * **************************************************** */
                               $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"disabled");
                               $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"disabled");
                               $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $filx["uni"]  . "'>";
                               $this->listanivel3 = "<input type='hidden' name='clanivel3'  id='select3' value='" . $filx["zon"]  . "'>";
                                
                               if(isset($select4)&&$select4!=0){
                                   $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"");
                               }
                                 if(isset($select5)&&$select5!=0){
                                     $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesNivel(5,  $select4,$select5),"");
                                     $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"");
                                     
                                }
                                  
                                if(isset($select6)&&$select6!=0){
                                     $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5, $select6),"");
                                }
                            }

                            if ($VarNivel2==4) {
                                /*                     * **NUEVO MODULO PHP** */
                            	
                                $RS_SQM_TE = Datosncin::vistancinModel($filx["reg"],"ca_nivel5");
                                $this->listanivel5 = Utilerias::crearSelectCascada(Estructura::nombreNivel(5,$_SESSION["idiomaus"]),5,Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select5),"");
                           
                               $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5,$select6),"disabled");
                               $this->listanivel2 = "<input type='hidden' name='clanivel2' id='select2' value='" . $filx["uni"]  . "'>";
                               $this->listanivel3 = "<input type='hidden' name='clanivel3'  id='select3' value='" . $filx["zon"]  . "'>";
                               $this->listanivel4 = "<input type='hidden' name='clanivel4' id='select4' value='" . $filx["reg"]  . "'>";
                               
                               if(isset($select5)&&$select5!=0){
                                   $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5,$select6),"");
                               }
                                if(isset($select6)&&$select6!=0){
                                     $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5,$select6),"");
                                }
                            }
 
                            if ($VarNivel2== 5) {
                              
                    
                                 $RS_SQM_TE = Datosnsei::vistanseiModel($filx["ciu"],"ca_nivel6");
                                 $this->listanivel6 = Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesSelCad( $RS_SQM_TE, $select6),"");
                            //    $this->listanivel1 = "<input type='hidden' name='clanivel1' value='" . $Nivel01 . "'>";
                                $this->listanivel2= "<input type='hidden' name='clanivel2' value='" . $Nivel02 . "'>";
                                $this->listanivel3= "<input type='hidden' name='clanivel3' value='" . $Nivel03 . "'>";
                                $this->listanivel4 = "<input type='hidden' name='clanivel4' value='" . $Nivel04 . "'>";
                                $this->listanivel5 = "<input type='hidden' name='clanivel5' value='" . $filx["ciu"]  . "'>";
                          //      $this->listanivel6= "<input type='hidden' name='clanivel6' value='" . $Nivel06 . "'>";
                    //           if(isset($select6)&&$select6!=0){
                    //                  $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select5,$select6),"");
                    //             }
                            
                            }
         if ($VarNivel2 == 6) {
             $this->listanivel2= "<input type='hidden' name='clanivel2' value='" . $Nivel02 . "'>";
             $this->listanivel3= "<input type='hidden' name='clanivel3' value='" . $Nivel03 . "'>";
             $this->listanivel4 = "<input type='hidden' name='clanivel4' value='" . $Nivel04 . "'>";
             $this->listanivel5 = "<input type='hidden' name='clanivel5' value='" . $Nivel05 . "'>";
             $this->listanivel6= "<input type='hidden' name='clanivel6' value='" . $Nivel06 . "'>";
             
//             /*                    
//                $RS_SQM_TE = Datosnsei::vistanseiOpcionModel($Nivel06,"ca_nivel6");
//            $this->listanivel6 =Utilerias::crearSelectCascada(Estructura::nombreNivel(6,$_SESSION["idiomaus"]),6,Utilerias::crearOpcionesNivel(6, $select6,$select6),"");
//             /*                     * ******************************************************************* */


         }
         
         
         //guardo var de sesion
         if(isset($nivel)&&$nivel!="")
         $_SESSION["fniv"]=$nivel;
         else
             $_SESSION["fniv"]=$VarNivel2;
        //   die("yo".$_SESSION["fniv"]);
            //-----------------------------------
            //  inicializo etiquetas por idioma
            //  -----------------------------------
            
         if ($fily["pv"] == "") //no muestro para usr cuenta con nivel 3
            $this->lb_buscar = $cad_buscapv;
         else
            $this->lb_buscar = '<div class="seleccionidioma" >';
        /* 		echo '<script>alert("'.$gfilx.'")</script>';   */
         $cad_buscapv = ' <div class="seleccionidioma" >
 <a href="index.php?action=indindicadores&mes=' . $mes_asig . '&filx=' . $gfilx . '&fily=' . $gfily . '&filuni=' . $gfiluni . '" >' . T_("INDICADORES") . '</a><span > | </span>';
        //s $cad_buscapv=''
         $this->lb_indicadores = $cad_buscapv;

      
   
//echo "views/modulos/indgeneragrafindic.php?sec=" . $seccion . "&mes=" . $mes_asig . "&filx=" . $gfilx . "&fily=" . $gfily . "&niv=" . $gnivel . "&filuni=" . $gfiluni;
            //  "Controllers/indpostmix/indgeneragrafindicjson.php?sec=5&mes=5.2018&filx=&fily=&niv=4&filuni=1.1"
                 // }//fin oermiso
                 // else echo "no tiene permiso";
         }//fin grupo
         }//fin oermiso 1
    }//fin funcion

    
    public function vistaGraficasIndicador(){
        
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            eval($asignacion);
        }
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
         //inicio titulos
        $this->titulos=array("COBERTURA","TAMAÑO DE LA MUESTRA","BEBIDAS","AGUA",
            "SERVICIO | RESPONSABILIDAD GEPP","OPERACION | RESPONSABILIDAD CLIENTE","INOCUIDAD | RESPONSABILIDAD GEPP","INOCUIDAD | RESPONSABILIDAD CLIENTE");
       
        $navegacion=new Navegacion();
        $navegacion->iniciar();
        $navegacion->borrarRutaActual("graficaind");
        $rutaact = $_SERVER['REQUEST_URI'];
        if (isset($mes_solo) && $mes_solo != "") {
            
            $this->mes_indice = $mes_asig = $mes_solo . "." . $anio;
        } else { // si no hay mes x defecto es el anterior
            $mes_asig = date("m.Y");
            $aux = explode(".", $mes_asig);
            
            $solomes = $aux[0] - 1;
            $soloanio = $aux[1];
            
            if ($solomes == 0) {
                $solomes = 12;
                $soloanio = $aux[1] - 1;
            }
            
            $mes_asig = $solomes . "." . $soloanio;
            $this->mes_indice = $mes_asig;
        }
      //  $mes_asig="7.2019";
        $mes_consulta = $mes_asig;
      
        $aux = explode(".", $mes_asig);
      
    
        $mes = $aux[0];
        if ($mes - 12 >= 0) { // calculo para los 12m
            $z = $mes - 12 + 1;
            
            $mes_pivote = $aux[1] . "-" . $z . "-01";
            $mes_pivote = $z . "." . $aux[1];
        } else {
            $z = $mes + 1;
            
            $mes_pivote = ($aux[1] - 1) . "-" . $z . "-01";
            $mes_pivote = $z . "." . ($aux[1] - 1);
        }
         
      
     
        // echo $rutaact;
        $navegacion::agregarRuta("graficaind", $rutaact, T_("GRAFICA"));
        $mesletra = Utilerias::cambiaMesGIng($mes_pivote) . "-" . Utilerias::cambiaMesGIng($mes_asig);
        
        $this->mostrarFiltros();
        /** variables de sesi�n para los filtros */
        /* 		echo '<script>alert("'.$gfilx.'")</script>';   */
        $_SESSION["fper"] = null; /*             * variable para el periodo 6M, 12M */
        $_SESSION["fmes"] = $mes; /* indice de aignacion */
        
        $_SESSION["fniv"] = $VarNivel2;  /* nivel de consulta */
        $_SESSION["ffilx"] = $gfilx;
        $_SESSION["ffily"] = $gfily;
        $_SESSION["fref"] = null;
        
        
        $this->mes_asig = $mesletra;
        
        //  $secciones = DatosEst::buscaSeccionesIndi($this->servicio, $vidiomau);
       // $secciones = DatosEst::buscaSeccionesIndi2($this->servicio, $vidiomau);
         $secciones=array("BEBIDAS"=>"E","AGUA"=>"E");
        foreach ($secciones as $key) {
           
            $setUrlDatos="indgeneragrafjsonv2.php?tipo=" . $key[0] . "&mes=" . $mes_asig . "&filx=" . $this->filnivelcedis . "&fily=" . $this->filcuenta .  "&filuni=" . $this->filnivelreg;
            
            // $seccion->generaTabla($key[0]);
            $this->listaSecciones[] = $setUrlDatos;
            
        }
        
        
        
        
       
        $this->periodo = $mesletra;
        //meto datos en la tabla temporal
       
        $this->insertarReportesTemp($mes_consulta,$mes_pivote);
         $this->UrlCobertura="indgeneragrafcoberturajson.php?tipo=Cob&mes=" . $mes_asig . "&filx=" . $this->filnivelcedis . "&fily=" . $this->filcuenta .  "&filuni=" . $this->filnivelreg;
       $this->UrlIndicadores="indgeneragrafjsonv2.php?mes=" . $mes_asig . "&filx=" . $this->filnivelcedis . "&fily=" . $this->filcuenta.  "&filuni=" . $this->filnivelreg."&tipo=";
      
    }

    
     public function vistaGraficasCobertura(){
        
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            eval($asignacion);
        }
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
        
        //inicio titulos
        $this->titulos=array("COBERTURA DE AUDITORIAS POR REGION","TAMAÑO DE LA MUESTRA POR REGION","COBERTURA DE CUENTAS CLAVE","TAMAÑO DE LA MUESTRA POR CUENTA","COBERTURA","TAMAÑO DE LA MUESTRA");
        $navegacion=new Navegacion();
        $navegacion->iniciar();
        $navegacion->borrarRutaActual("graficacob");
        $rutaact = $_SERVER['REQUEST_URI'];
        $navegacion::agregarRuta("graficacob", $rutaact, T_("GRAFICA COBERTURA"));
        
        if (isset($mes_solo) && $mes_solo != "") {
            
            $this->mes_indice = $mes_asig = $mes_solo . "." . $anio;
            $soloanio=$anio;
        } else { // si no hay mes x defecto es el anterior
            $mes_asig = date("m.Y");
            $aux = explode(".", $mes_asig);
            
            $solomes = $aux[0] - 1;
            $soloanio = $aux[1];
            
            if ($solomes == 0) {
                $solomes = 12;
                $soloanio = $aux[1] - 1;
            }
            
            $mes_asig = $solomes . "." . $soloanio;
            $this->mes_indice = $mes_asig;
        }
       // $mes_consulta = $mes_asig;
        
       
            
        $mes_pivote ="01.".$soloanio;
        
      
     
        // echo $rutaact;
      
        $mesletra = Utilerias::cambiaMesGIng($mes_pivote) . "-" . Utilerias::cambiaMesGIng($mes_asig);
       // die($mes_pivote."++".$mes_asig."+++".$mesletra);
        $this->mostrarFiltros();
        /** variables de sesi�n para los filtros */
        /* 		echo '<script>alert("'.$gfilx.'")</script>';   */
        $_SESSION["fper"] = null; /*             * variable para el periodo 6M, 12M */
        $_SESSION["fmes"] = $mes_asig; /* indice de aignacion */
        
       /* nivel de consulta */
        $_SESSION["ffilx"] = $this->filnivelcedis;
        $_SESSION["ffily"] = $this->filcuenta;
        $_SESSION["fref"] = null;
        
        
        $this->mes_asig = $mesletra;
     
       //  die("yo".$_SESSION["fniv"]);
        $this->periodo = $mesletra;
        $this->UrlCobertura="indgeneragrafcoberturajson.php?tipo=Cob&mes=" . $mes_asig . "&filx=" . $this->filnivelcedis . "&fily=" . $this->filcuenta .  "&filuni=" . $this->filnivelreg;
       $this->UrlCoberturaxReg="indgeneragrafcoberturajson.php?tipo=CobxReg&mes=" . $mes_asig . "&filx=" . $this->filnivelcedis . "&fily=" . $this->filcuenta.  "&filuni=" . $this->filnivelreg;
        $this->UrlCoberturaxCta="indgeneragrafcoberturajson.php?tipo=CobxCta&mes=" . $mes_asig . "&filx=" . $this->filnivelcedis . "&fily=" . $this->filcuenta .  "&filuni=" . $this->filnivelreg;
        
        
        
    }


    function crearReferenciaNivelUni($row,  $grupo) {
        $result = 0;
     
   
   
        if ($grupo == "cli") {
            if ($row["cus_nivel3"] != 0)
                $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"];
                else if ($row["cus_nivel2"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"];
                    else
                        $refer = $row["cus_nivel1"];
        } else if ($grupo == "cue") {
            if ($row["cus_nivel3"] != 0)
                $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"];
                else if ($row["cus_nivel2"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"];
                    else
                        $refer = $row["cus_nivel1"];
        } else if ($grupo == "muf") {
            if ($row["cus_nivel4"] != 0)
                $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"] . "." . $row["cus_nivel4"];
                else if ($row["cus_nivel3"] != 0)
                    $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"] . "." . $row["cus_nivel3"];
                    else if ($row["cus_nivel2"] != 0)
                        $refer = $row["cus_nivel1"] . "." . $row["cus_nivel2"];
                        else
                            $refer = $row["cus_nivel1"];
        }
      
        
        return $refer;
    }

    public function filtroPeriodo($mes_solo, $anio) {
        $arr_meses = array(strtoupper(T_("Enero")), strtoupper(T_("Febrero")), strtoupper(T_("Marzo")), strtoupper(T_("Abril")), strtoupper(T_("Mayo")), strtoupper(T_("Junio")), strtoupper(T_("Julio")), strtoupper(T_("Agosto")), strtoupper(T_("Septiembre")), strtoupper(T_("Octubre")), strtoupper(T_("Noviembre")), strtoupper(T_("Diciembre")));

        $sql_anio = "SELECT 	 
	num_per_asig	 
	FROM 
	ca_mesasignacion 
	GROUP BY num_per_asig
	ORDER BY num_per_asig";
        $rsanio = Conexion::ejecutarquerysp($sql_anio);
        $this->opciones_anio = "";
        foreach ($rsanio as $rowanio) {
            $selected="";
            if($rowanio[0] ==$anio)
                $selected="selected";

            $this->opciones_anio .= ' <option value="' . $rowanio[0] . '" '.$selected.'>' . $rowanio[0] . '</option>';

            $this->opciones_mes = "";
            foreach ($arr_meses as $key => $value) {
                $selected="";
                if(($key+1)==$mes_solo)
                    $selected="selected";
                
                $this->opciones_mes .= ' <option value="' . ($key + 1) . '" '.$selected.'>' . $value . '</option>';
            }
        }
    }
     public function insertarReportesTemp($fmes_consulta,$mes_consulta_ant)
    {
      
        $usuario=$_SESSION["UsuarioInd"];
        
        
        if ($this->filnivel == "") {
            $this->filnivel = "1.1.5";
        }
        
        $this->servicio = 1; // siempre es 1
        $aux = explode(".", $this->filnivelreg);
        
        $filuni = array();
        $filuni["reg"] = $aux[0];
        $filuni["uni"] = $aux[1];
        $filuni["zon"] = $aux[2];
        $filx = array();
         $aux = explode(".", $this->filnivelcedis);
       
        $filx["edo"] = $aux[0];
        
        $filx["ciu"] = $aux[1];
        $filx["niv6"] = $aux[2];
        $auxy = explode(".", $this->filcuenta);
        
        $fily = array();
        
        $fily["cta"] = $auxy[0];
        $fily["fra"] = $auxy[1];
        $fily["pv"] = $auxy[2];
      
      /*   * **************************************CONSULTA********************************
         */
        $i = 0;
        
        DatosTemporales::eliminarEstadistica($usuario);
        
        /* creo consulta  generica */
        $sql_porcuenta = "insert into tmp_estadistica (usuario, numreporte,mes_asignacion) select :Usuario, ins_generales.i_numreporte, str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')
FROM
  (
    ins_generales
    INNER JOIN ca_unegocios
      ON  ins_generales.`i_unenumpunto` = ca_unegocios.une_id
  )
  INNER JOIN ca_cuentas
    ON ca_cuentas.cue_id = ca_unegocios.cue_clavecuenta
where cue_idcliente=:vclienteu and ins_generales.i_claveservicio=:vserviciou";
        
        $parametros=array("vserviciou" => $this->servicio, "Usuario" => $usuario,"vclienteu"=>1);
       
        if ($fily["cta"] != 0) {
            $sql_porcuenta .= " AND ca_unegocios.cue_clavecuenta=:cuenta  ";
            $parametros["cuenta"] = $fily["cta"];
            $nivel=1;
        }
        
        if ($fily["fra"] != 0) {
            $sql_porcuenta .= " AND fc_idfranquiciacta=:franquiciacta";
            $parametros["franquiciacta"] = $fily["fra"];
            //busco nombre de la franquicia para guardarlo
                $nivel=2;
            $_SESSION["ffrancuenta"] = DatosFranquicia::nombreFranquicia($fily["cta"], $fily["fra"], $this->vclienteu, $this->vserviciou);
        }
        
        if ($fily["pv"] != 0) {
            $sql_porcuenta .= " and ins_generales.i_unenumpunto=:unidadnegocio";
            $parametros["unidadnegocio"] = $fily["pv"];
                $nivel=3;
        }
        // validamos los niveles de la estructura
        
        
        if ($filuni["reg"] != 0) {
            $sql_porcuenta.= " AND une_cla_region=:select1  ";
            $parametros["select1"] = $filuni["reg"];
                $nivel=1;
            
        }
        if ($filuni["uni"] != 0) {
            $sql_porcuenta.= " AND une_cla_pais=:select2  ";
            $_SESSION["funidadneg"] =Datosndos::nombreNivel2( $filuni["uni"],"ca_nivel2");
            $parametros["select2"] = $filuni["uni"];
                $nivel=2;
        }
        if ($filuni["zon"] != 0) {
            $sql_porcuenta.= " AND une_cla_zona=:select3  ";
            $_SESSION["ffranquicia"] =Datosntres::nombreNivel3( $filuni["zon"],"ca_nivel3");
            $parametros["select3"] = $filuni["zon"];
                $nivel=3;
        }
        if ($filx["edo"] != 0) {
            $sql_porcuenta.= " AND une_cla_estado=:select4  ";
            $_SESSION["fregion"] =Datosncua::nombreNivel4( $filx["edo"] ,"ca_nivel4");
            $parametros["select4"] = $filx["edo"] ;
                $nivel=4;
        }
        if ($filx["ciu"]  != 0) {
            $sql_porcuenta.= " AND une_cla_ciudad=:select5  ";
            $_SESSION["fzona"] =Datosncin::nombreNivel5( $filx["ciu"] ,"ca_nivel5");
            $parametros["select5"] = $filx["ciu"] ;
                $nivel=5;
        }
        if ($filx["niv6"]  != 0) {
            $sql_porcuenta.= " AND une_cla_franquicia=:select6  ";
            $_SESSION["fcedis"] =Datosnsei::nombreNivel6( $filx["niv6"] ,"ca_nivel6");
            $parametros["select6"] = $filx["niv6"] ;
                $nivel=6;
        }
        
      
      //modificacion del filtro de fecha se usa mes de asignacion
	
		//$fechainicioc = mod_fecha($fechainicio);
		$sql_porcuenta.= " AND str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaasig_i ),'%d.%m.%Y')";
		$parametros["fechaasig_i"] = $mes_consulta_ant;
	
		//$fechfinc = mod_fecha($fechafin);
		$sql_porcuenta.= " AND str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechaasig_fin ),'%d.%m.%Y')";
		$parametros["fechaasig_fin"] = $fmes_consulta;
	
        //	echo $select6;
      //  die($mes_consulta_ant."--".$fmes_consulta;)
        ////inserta reportes en la tabla temporal tmp_estadistica
        $rs_sql_us = Conexion::ejecutarInsert($sql_porcuenta,$parametros);
        
        //valido si hay mas de un reporte
        $sqlt = "select * from tmp_estadistica WHERE tmp_estadistica.usuario = :Usuario";
        //echo $sqlt;
        $rs = Conexion::ejecutarQuery($sqlt,array("Usuario"=>$usuario));
        $this->nivel=$nivel+1;
        $num_reg = sizeof($rs);
    }
    

    function getNavegacion() {
        return $this->navegacion;
    }

    function getMes_indice() {
        return $this->mes_indice;
    }

    function getLb_buscar() {
        return $this->lb_buscar;
    }

    function getLb_indicadores() {
        return $this->lb_indicadores;
    }

 

    function getOpciones_anio() {
        return $this->opciones_anio;
    }

    function getOpciones_mes() {
        return $this->opciones_mes;
    }

    function getListaSecciones() {
        return $this->listaSecciones;
    }

    function getListanivel2() {
        return $this->listanivel2;
    }

    function getListanivel3() {
        return $this->listanivel3;
    }

    function getListanivel4() {
        return $this->listanivel4;
    }

    function getListanivel5() {
        return $this->listanivel5;
    }

    function getListanivel6() {
        return $this->listanivel6;
    }

    function getPeriodo() {
        return $this->periodo;
    }


    function getLugar() {
        return $this->lugar;
    }

    function getFilnivelreg() {
        return $this->filnivelreg;
    }

    function getUrlCobertura() {
        return $this->UrlCobertura;
    }

    function getUrlCoberturaxReg() {
        return $this->UrlCoberturaxReg;
    }

  


    function getTitulos() {
        return $this->titulos;
    }


    function getUrlCoberturaxCta() {
        return $this->UrlCoberturaxCta;
    }

    function getUrlIndicadores() {
        return $this->UrlIndicadores;
    }



}
