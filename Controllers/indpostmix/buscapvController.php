<?php
include 'libs/paginator.class.php';

class BuscapvController
{

    private $nombreSeccion;

    private $titulopagina;

    private $listanivel1;

    private $listanivel2;

    private $listanivel3;

    private $listanivel4;

    private $listanivel5;

    private $listanivel6;

    private $nombrenivel1;

    private $nombrenivel2;

    private $nombrenivel3;

    private $nombrenivel4;

    private $nombrenivel5;

    private $nombrenivel6;

    private $listaFranquicias;

    private $listaCuentas;

    private $varnivel;

    private $listaunegocios;

    private $pages;

    function vistaindBuscarpv()
    {
        
        // -----------------------------------------
        // inicializacion de etiquetas para traduccion
        // -----------------------------------------
        $this->nombreSeccion = T_("BUSCAR PUNTO DE VENTA");
        $this->titulopagina = strtoupper(T_("Estimado usuario, defina los siguientes criterios para buscar el punto de venta"));
        
        foreach ($_POST as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_POST, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
        foreach ($_GET as $nombre_campo => $valor) {
            $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo, FILTER_SANITIZE_STRING) . "';";
            
            eval($asignacion);
        }
        
        /* * ************************************** */
        $_SESSION["clienteind"]=1;
        $_SESSION["servicionind"]=1;
        $MiVar = $_SESSION["UsuarioInd"] ;
        $uscliente = $_SESSION["clienteind"];
        $usservicio = $_SESSION["servicioind"];
        /* * ************************************** */
        
        $ban = $busqueda;
        
        /* * ****** SECCION DONDE SE GENERAN LOS FILTROS A UTILIZAR *********** */
        $select1 = $clanivel1;
        $select2 = $clanivel2;
        $select3 = $clanivel3;
        $select4 = $clanivel4;
        $select5 = $clanivel5;
        $select6 = $clanivel6;
        $rs_usuarios = UsuarioModel::getUsuario($MiVar, "cnfg_usuarios");
        foreach ($rs_usuarios as $row_usuarios) {
            // $html->asignar('USUARIO', "<span class='TitPost'>" . $row_usuarios ["cus_nombreusuario"] . "</span>");
            $GradoNivel = $row_usuarios["cus_tipoconsulta"];
            $grupo = $row_usuarios["cus_clavegrupo"];
            $Nivel01 = $row_usuarios["cus_nivel1"];
            $Nivel02 = $row_usuarios["cus_nivel2"];
            // echo "niv".$Nivel02;
            $Nivel03 = $row_usuarios["cus_nivel3"];
            $Nivel04 = $row_usuarios["cus_nivel4"];
            $Nivel05 = $row_usuarios["cus_nivel5"];
            $Nivel06 = $row_usuarios["cus_nivel6"];
        }
        
        $VarNivel2 = $GradoNivel;
        
        // muestra select de cliente y servicio
        $bancli = 0;
        $banserv = 0;
        $bancuenta = 0;
        $banfran = 0;
        
        if ($VarNivel2 == "")
            $VarNivel2 = 1;
        
        $this->varnivel = $VarNivel2;
        
        if ($grupo == 'adm' || $grupo == 'mue' || $grupo == 'cli' || $grupo == 'aud' || $grupo == 'muf') {
            
            if ($grupo == 'adm' || $grupo == 'mue' || $grupo == 'aud' || $grupo == 'muf')
                // nivel uno por default
                $GradoNivel = $VarNivel2;
            $this->varnivel = $VarNivel2;
            if ($VarNivel2 == NULL) { $Nivel01 = 1;} else {
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
//                 
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
        
        /**
         * ********* para select cuentas ******************
         */
        
        $sql_cuentas = "SELECT * FROM ca_cuentas";
        
        if ($grupo == "cue") { // si es un usuario por cuenta busca su cuenta
            
            $sql_cuentas .= " where cue_id=:Nivel01  and `ca_cuentas`.`cue_idcliente`=:uscliente;";
            // echo "--".$sql_cuentas;
            // $html->asignar ( 'CUENTAS', "<select name='cuenta' id='cuenta' onChange='cargaContenidoCuenta(this.id)'> <option value='0'>- Seleccione Una Opcion -</option>" );
            
            $parametros = array(
                "Nivel01" => $Nivel01,
                "uscliente" => $uscliente
            );
            $rs_cuentas = Conexion::ejecutarQuery($sql_cuentas, $parametros);
            if (sizeof($rs_cuentas) > 0) {
                
                $this->listacuentas = $row_cuentas["cue_descripcion"] . "<input type='hidden' name='cuenta' id='cuenta' value='" . $row_cuentas["cue_id"] . "'>";
                $bancuenta = 0;
                // $html->expandir ( 'CUENTA', '+buscacuenta' );
            }
        } else {
            
            if ($banserv == 0) {
                if ($grupo == 'cli' || $grupo == 'muf') {
                    
//      
                 }
                $referencia=array("",$Nivel01,$Nivel02,$Nivel03,$Nivel04,$Nivel05,$Nivel06);
                $rs_cuentas = DatosCuenta::cuentasxNivel($VarNivel2,$referencia,$uscliente);
              //  die();
                $this->listaCuentas[] = '<select style="width:300px" class="form-control"  name="cuenta" id="cuenta" onChange="cargaContenidoCuenta(this.id,\'crcliente\',\'crservicio\');">';
                $i = 0;
                if (sizeof($rs_cuentas) > 1) // si tiene mas de una cuenta aparece la opcion todas
{
                    
                    $this->listaCuentas[] = '<option value="">- ' . strtoupper(T_("Todas")) . ' -</option>';
                    
                    $bancuenta = 1;
                    
                    $banfran = 1;
                } else {
                    $bancuenta = 0;
                }
                
                // var_dump($rs_cuentas);
                foreach ($rs_cuentas as $row_cuentas) {
                    if ($cuenta == $row_cuentas["cue_id"])
                        $this->listaCuentas[] = "<option value='" . $row_cuentas["cue_id"] . "' selected>" . $row_cuentas["cue_descripcion"] . "</option>";
                    else
                        $this->listaCuentas[] = "<option value='" . $row_cuentas["cue_id"] . "'>" . $row_cuentas["cue_descripcion"] . "</option>";
                    
                    $bancuenta = 1;
                }
                $this->listaCuentas[] = '</select>';
            } // despliega opciones de cuentas
                  // else {
                  // // solo creo el select
                  // $html->asignar('CUENTAS', '<select style="width:300px" name="cuenta" id="cuenta" onChange="cargaContenidoCuenta(this.id,\'crcliente\',\'crservicio\');">');
                  // $html->asignar('OPCUENTAS', '<option value="0">- '.strtoupper(T_("Todas")).' -</option></select>');
                  // $html->expandir('CUENTA', '+buscacuenta');
                  // $bancuenta=0;
                  //
                  //
                  //
                  // }
                  //
        }
        
        if (isset($cuenta) && $cuenta != 0) {
            $banserv = 0;
            $bancuenta = 0;
        }
        
        // --------------------------
        // para franquicias
        // -------------------------
        
        if ($banserv == 0 && $bancuenta == 0) { // empieza la eleccion desde franquicias
            
            $sql_fran = "SELECT ca_franquiciascuenta.fc_idfranquiciacta, ca_franquiciascuenta.cf_descripcion
FROM
ca_unegocios
Inner Join ca_franquiciascuenta ON ca_unegocios.fc_idfranquiciacta = ca_franquiciascuenta.fc_idfranquiciacta";
            // consulta para clientes
            if ($grupo == 'cli' || $grupo == 'muf') {
                $sql_fran .= " where
ca_franquiciascuenta.cli_idcliente= :uscliente";
                $parametros = array(
                    "uscliente"=>$uscliente
                );
                
                $filtro = "";
                // busco por nivel
                switch ($VarNivel2) {
                    case 6:
                        $filtro = "
ca_unegocios.une_cla_franquicia=:Nivel ";
                        $parametros = array(
                            "Nivel" => $Nivel06
                        );
                        break;
                    case 5:
                        $filtro = " 
ca_unegocios.une_cla_ciudad=:Nivel ";
                        $parametros = array(
                            "Nivel" => $Nivel05
                        );
                        break;
                    case 4:
                        $filtro = " 
ca_unegocios.une_cla_estado=:Nivel ";
                        $parametros = array(
                            "Nivel" => $Nivel04
                        );
                        break;
                    case 3:
                        $filtro = "
ca_unegocios.une_cla_zona=:Nivel  ";
                        $parametros = array(
                            "Nivel" => $Nivel03
                        );
                        break;
                    case 2:
                        $filtro = "
ca_unegocios.une_cla_pais=:Nivel";
                        $parametros = array(
                            "Nivel" => $Nivel02
                        );
                        break;
                    case 1:
                        $filtro = "ca_unegocios.une_cla_region=:Nivel";
                        $parametros = array(
                            "Nivel" => $Nivel01
                        );
                        break;
                }
                if (isset($cuenta) && $cuenta != 0) {
                    $filtro .= " and ca_franquiciascuenta.cue_clavecuenta=:cuenta";
                    $parametros["cuenta"] = $cuenta;
                }
                $sql_fran .= $filtro . " group by ca_franquiciascuenta.fc_idfranquiciacta;";
                // echo $sql_fran;
                $res_fran = Conexion::ejecutarQuery($sql_fran, $parametros);
                $this->listaFranquicias[] = Utilerias::crearSelectOnChange($res_fran, 'franquiciacta', "");
                $banfran = 1;
            } else if ($grupo == 'cue') { // consulta para cclientes cuenta
                                         
                // veo si es de franquicia
                if ($Nivel02 != 0 && $Nivel02 != "") {
                    
                    $this->listaFranquicias[] = $this->buscaFranquicia($Nivel02) . '<input name="franquiciacta" id="franquiciacta" type="hidden" value="' . $Nivel02 . '">';
                } 
                else {
                    $sql_fran .= " where
ca_franquiciascuenta.cli_idcliente=:uscliente
   
    and ca_franquiciascuenta.cue_clavecuenta=:Nivel01";
                    $parametros["uscliente"] = $uscliente;
                    $parametros["Nivel01"] = $Nivel01;
                    $sql_fran .= " group by ca_franquiciascuenta.fc_idfranquiciacta;";
                    $res_fran = Conexion::ejecutarQuery($sql_fran, $parametros);
                    $this->listaFranquicias[] =Utilerias::crearSelectOnChange($res_fran, 'franquiciacta', "");
                    $banfran = 1;
                }
            } else // todos los demas
{
                // veo si tiene cliente
                if ($uscliente != 0 && $uscliente != "")
                    $sql_fran .= " where
ca_franquiciascuenta.cli_idcliente= '$uscliente'";
                
                if (isset($cuenta) && $cuenta != 0) {
                    $sql_fran .= " and ca_franquiciascuenta.cue_clavecuenta='" . $cuenta . "'";
                    $parametros["cuenta"] = $cuenta;
                }
                
                $sql_fran .= " group by ca_franquiciascuenta.fc_idfranquiciacta;";
                $RS_SQM_TE = Conexion::ejecutarQuery($sql_fran, $parametros);
                $this->listaFranquicias[] = Utilerias::crearSelectOnChange($RS_SQM_TE, 'franquiciacta', "");
                $banfran = 1;
            }
        } else // select vacio
{
            $this->listaFranquicias[] = Utilerias::crearSelectOnChange(null, 'franquiciacta', "");
            // var_dump($this->listaFranquicias);
            $banfran = 1;
        }
        $usuario = $_SESSION["UsuarioInd"];
        $ban = $busqueda;
        
        if ($ban == 1) {
            
            /* creo consulta generica */
            
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
            
            $rs_sql_us = DatosUnegocio::unegociosxNivel($fil_ptoventa, $fil_idpepsi, $filx, $fily, "", "");
            
            $num_rows = sizeof($rs_sql_us);
            
            if (sizeof($rs_sql_us) == 1) { // si es uno envia al punto de venta
                header("Location: index.php?action=indhistorialreportes&prin=1&numrep=" . $row["numreporte"] . "&cser=" . $vserviciou . "&ccli=" . $vclienteu);
            } else if (sizeof($rs_sql_us) > 0) {
                
                $this->pages = new Paginator($num_rows, 9, array(
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
                $rs_sql_us = DatosUnegocio::unegociosxNivel($fil_ptoventa, $fil_idpepsi, $filx, $fily, $this->pages->limit_start, $this->pages->limit_end);
                
                foreach ($rs_sql_us as $row_rs_sql_c) {
                    
                    $color = "subtitulo31";
                    $fily = $row_rs_sql_c["cue_clavecuenta"] . "." . $row_rs_sql_c["fc_idfranquiciacta"];
                    
                    $direccion = "index.php?action=indhistorialreportes&ptv=" . $row_rs_sql_c["une_id"] . "&fily=" . $fily;
                    $une['NomPuntoVenta'] = "<td  class='$color'><a href='" . $direccion . "'>" . $row_rs_sql_c["une_descripcion"] . "</a></td>";
                    $une['Pepsi'] = "<td  class='$color'><a href='" . $direccion . "'>" . $row_rs_sql_c["une_idpepsi"] . "</a></td>";
                    $une['CiudadN'] = "<td  class='$color' ><a href='" . $direccion . "'>" . $row_rs_sql_c["une_dir_municipio"] . "</a></td>";
                    $une['Direccion'] = "<td  class='$color' ><a href='" . $direccion . "'>" . $row_rs_sql_c["direccion"] . "</a></td>";
                    $this->listaunegocios[] = $une;
                }
                if ($numreportes == 0) {
                    $this->NumeroReportes = "<label style='color:#F00'>Su búsqueda no produjo ningún resultado !!!</label>";
                } else {
                    $this->NumeroReportes = strtoupper(T_("Total de Reportes")) . ": " . $numreportes;
                }
            }
        }
        
        // $navegacion='<li><a href="MENindprincipal.php?op=mindi" style="z-index:9;">'.T_("GRAFICA").'</a></li>';
        // $navegacion.='<li><a href="#" style="z-index:8;">'.T_("BUSCAR PUNTO DE VENTA").'</a></li>';
        //
        // $html->asignar('NAVEGACION',$navegacion);
        Navegacion::iniciar();
        Navegacion::borrarRutaActual("a");
        $rutaact = $_SERVER['REQUEST_URI'];
        // echo $rutaact;
        Navegacion::agregarRuta("a", $rutaact, T_("BUSCAR PUNTO DE VENTA"));
        // $html->asignar('NAVEGACION2',desplegarNavegacion());
    }

    function getNombreSeccion()
    {
        return $this->nombreSeccion;
    }

    function getTitulopagina()
    {
        return $this->titulopagina;
    }

    function getListanivel1()
    {
        return $this->listanivel1;
    }

    function getListanivel2()
    {
        return $this->listanivel2;
    }

    function getListanivel3()
    {
        return $this->listanivel3;
    }

    function getListanivel4()
    {
        return $this->listanivel4;
    }

    function getListanivel5()
    {
        return $this->listanivel5;
    }

    function getListanivel6()
    {
        return $this->listanivel6;
    }

    function getNombrenivel1()
    {
        return $this->nombrenivel1;
    }

    function getNombrenivel2()
    {
        return $this->nombrenivel2;
    }

    function getNombrenivel3()
    {
        return $this->nombrenivel3;
    }

    function getNombrenivel4()
    {
        return $this->nombrenivel4;
    }

    function getNombrenivel5()
    {
        return $this->nombrenivel5;
    }

    function getNombrenivel6()
    {
        return $this->nombrenivel6;
    }

    function getListaFranquicias()
    {
        return $this->listaFranquicias;
    }

    function getListaCuentas()
    {
        return $this->listaCuentas;
    }

    function getVarnivel()
    {
        return $this->varnivel;
    }

    function getListaunegocios()
    {
        return $this->listaunegocios;
    }

    function getPages()
    {
        return $this->pages;
    }
}
?>


