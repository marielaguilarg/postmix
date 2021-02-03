<?php


class GrafIndiDetalleController {

    private $navegacion;
   
    private $mes_indice_ini;
      private $mes_indice_fin;
  
    private $lb_buscar;
    private $lb_indicadores;
   
    
    private $lugar;
  
    private $periodo;
  
    private $servicio;
    private $cliente;
    private $opciones_anio;
    private $opciones_mes;

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
    private $reactivo;
    private $nombreSeccion;
    private $estandar;
    public $nota;
    public $colorhist;

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
                { //vengo de la seccion anterior
                  
                        $gfiluni=$filuni;
                  
                     $gfilx=$filx;
                     $gfily=$fily;
                    
                }
                ////o vengo del menu
//                     if (($grupo == "cli" || $grupo == "muf") && $permiso > 3) {// si no tengo filtro
//                         $gfilx =    $row_usuarios["cus_nivel4"] . "." . $row_usuarios["cus_nivel5"] . "." . $row_usuarios["cus_nivel6"];
//                     //    $refer = $row_usuarios["cus_nivel4"] . "." . $row_usuarios["cus_nivel5"] . "." . $row_usuarios["cus_nivel6"];
//                     } 
              
            }
                    
          
            $this->filnivelcedis=$gfilx;
            $this->filcuenta=$gfily;
            
              if($gfiluni=="1.1"||$gfiluni=="1.1.")
                $gfiluni="1.1.5";
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
                                        
                         
                           // $RS_SQM_TE = Datosntres::vistantresModel($filx["uni"],"ca_nivel3");
                             $RS_SQM_TE = Datosntres::vistatresModel($filx["uni"],5,"ca_nivel3");
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
            }
         }//fin oermiso 1
    }//fin funcion

    
    public function vistaGraficasIndDetalle(){
        
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            eval($asignacion);
        }
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
         $this->colorhist=$color;
      //   die($this->colorhist);
         //inicio titulos
        $this->titulos=array("COMPARATIVO POR REGION","COMPARATIVO POR CUENTA","MONITOREO DE AVANCE DE INDICADORES");
        $notas=array(
            "8.0.2.0.0.6"=>"ADICION O FRACTURA DE PUENTES DE HIELO",
            "8.0.1.0.0.9"=>"REEMPLAZO DE BIB'S",
            "8.0.2.0.0.9"=>"REEMPLAZO DE TANQUE DE CO2 | <br> ADICION O FRACTURA DE PUENTES DE HIELO");
        
        $navegacion=new Navegacion();
      //  $navegacion->iniciar();
        $navegacion->borrarRutaActual("graficadet");
        $rutaact = $_SERVER['REQUEST_URI'];
       
       
      //  $mes_asig_ini="7.2019";
     
       
          if (isset($mes_solo_ini) && $mes_solo_ini != "") {
            
            $this->mes_indice_ini = $mes_asig_ini = $mes_solo_ini . "." . $anio_ini;
        } else
            $mes_asig_ini=$mes;
     
       $aux = explode(".", $mes_asig_ini);
      
    
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
      //     print_r($mes_pivote."--".$mes_asig_ini);
        // echo $rutaact;
       
        $mesletra = Utilerias::cambiaMesGIng($mes_pivote) . "-" . Utilerias::cambiaMesGIng($mes_asig_ini);
        
        $this->mostrarFiltros();
        /** variables de sesi�n para los filtros */
        /* 		echo '<script>alert("'.$gfilx.'")</script>';   */
      
        $_SESSION["fmes"] = $mes; /* indice de aignacion */
        
        $_SESSION["fref"] = $ref;
        if($ref==6){
            $referencia=DatosSeccion::editaSeccionModel($ref,$this->servicio, "cue_secciones");
         //   var_dump($referencia);
           
            $this->nombreSeccion = $referencia["sec_descripcionesp"];
            $this->estandar = "";
           
        }
        else 
        {$referencia = DatosEst::buscaIndicadores($ref, $vidiomau, $this->servicio);
       
        $this->nombreSeccion = $referencia[0][1];
        $this->estandar = $referencia[0][2];
        }
        
        $this->mes_asig = $mesletra;
     
        
        $this->periodo = $mesletra;
        //meto datos en la tabla temporal
       
          $this->reactivo=$ref;
          $this->nota=$notas[$this->reactivo];
       $this->UrlIndicadores="indgeneragrafjsonv2.php?mes=" .$mes_asig_ini  . "&filx=" . $this->filnivelcedis . "&fily=" . $this->filcuenta.  "&filuni=" . $this->filnivelreg."&ref=".$this->reactivo."&tipo=";
         $navegacion::agregarRuta("graficadet", $rutaact,    $this->nombreSeccion );
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
   

    function getNavegacion() {
        return $this->navegacion;
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
 
    function getReactivo() {
        return $this->reactivo;
    }

    function getNombreSeccion() {
        return $this->nombreSeccion;
    }

    function getEstandar() {
        return $this->estandar;
    }




}
