<?php

include "Models/crud_pruebaAnalisis.php";
class PruebaController{
	
	private $listaPruebas;
	private $datocardet1;
	private $datocardet;
	private $nomprue;
	private $numprue;
	private $ncomp;
	private $TITULO5;
	private $ids;
	private $mensaje;
	
	public function vistaListaPruebas(){
		
		
		$ssql=("SELECT
cue_reactivosestandar.re_numcomponente,
cue_reactivosestandar.re_descripcionesp,
cue_reactivosestandar.re_descripcioning,
cue_reactivosestandar.ser_claveservicio,
cue_reactivosestandar.sec_numseccion
FROM
cue_reactivosestandar
Inner Join cue_secciones ON cue_reactivosestandar.ser_claveservicio = cue_secciones.ser_claveservicio
 AND cue_reactivosestandar.sec_numseccion = cue_secciones.sec_numseccion
WHERE
cue_secciones.sec_indagua =  '1'");
		$this->listaPruebas=Conexion::ejecutarQuerysp($ssql);
		Navegacion::iniciar();
		Navegacion::agregarRuta("a",$_SERVER['REQUEST_URI'], "PRUEBA");
		
		
	}
	
	public function vistaDetalle(){
		
		include "Utilerias/leevar.php";
		
		switch($admin) {
			case "insertar" :
				$this->insertar();
				break;
			case	"borrar" :
				$this->borrar();
				break;
			case "actualizar" :
				$this->actualizar();
				break;
		}
		$numcat = $id;
		$idserv = $serv;
		//echo $idserv;
		
		if ($numcat){
			if (!isset($_SESSION['catalogo'])) {
				$_SESSION['catalogo']=$numcat;
			} else {
				$_SESSION['catalogo']=$numcat;
			}
		}else {
			$numcat=$_SESSION['catalogo'];
		}
		
		
		$ssqlT=("SELECT cue_reactivosestandar.re_descripcionesp
 FROM cue_reactivosestandar
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandar.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandar.sec_numseccion WHERE
cue_reactivosestandar.ser_claveservicio = :idserv AND
cue_secciones.sec_indagua =  '1' AND
cue_reactivosestandar.re_numcomponente =  :numcat");
		
		$rsT=Conexion::ejecutarQuery($ssqlT,array("idserv"=>$idserv,"numcat"=>$numcat));
		foreach ($rsT as $rowt){
			$this->TITULO5=$rowt["re_descripcionesp"];
		}
		
		$ssql=("SELECT pa_numprueba, pa_tipoanalisis, red_parametroesp, red_estandar FROM (
SELECT aa_pruebaanalisis.pa_numprueba, aa_pruebaanalisis.pa_tipoanalisis FROM aa_pruebaanalisis WHERE aa_pruebaanalisis.pa_numcomponente = :numcat AND
aa_pruebaanalisis.pa_numservicio =  :idserv) AS a
inner join ( select cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing, 
cue_reactivosestandardetalle.red_estandar 
FROM cue_reactivosestandardetalle Inner Join cue_reactivosestandar ON cue_reactivosestandar.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
 AND cue_reactivosestandar.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
AND cue_reactivosestandar.r_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND cue_reactivosestandar.re_numcomponente = cue_reactivosestandardetalle.re_numcomponente
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandar.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandar.sec_numseccion
WHERE cue_secciones.sec_indagua = '1' AND cue_reactivosestandardetalle.ser_claveservicio = :idserv AND cue_reactivosestandardetalle.re_numcomponente = :numcat) AS b 
ON pa_numprueba=red_numcaracteristica2 order by pa_numprueba");
		//ECHO $ssql;
		
		$this->ids=$idserv;
		$this->listaPruebas=null;
		$this->listaPruebas=Conexion::ejecutarQuery($ssql,array("idserv"=>$idserv,"numcat"=>$numcat));
		Navegacion::borrarRutaActual("b");
		
		$rutaact = $_SERVER['REQUEST_URI'];
		// echo $rutaact;
		Navegacion::agregarRuta("b", $rutaact, "PRUEBA NO.".$numcat);
	}
	
	public function insertar(){
		
		include "Utilerias/leevar.php";
		try{
		
			DatosPruebaAnalisis::insertar($idserv,$numcomp, $numreacen, $tipoana,"aa_pruebaanalisis");
			
			echo Utilerias::enviarPagina("index.php?action=nuevaprueba&serv=".$idserv);
		}catch (Exception $ex){
			$this->mensaje=Utilerias::mensajeError($ex->getMessage());
		}
	}
	
	public function borrar(){
		
		include "Utilerias/leevar.php";
	
		
		$idserv=$serv;
		
	   try{
			
	   	DatosPruebaAnalisis::borrarPruebaAnalisis($idserv,$_SESSION['catalogo'],$np,  "aa_pruebaanalisis");
	   echo 	Utilerias::enviarPagina("index.php?action=listapruebasdet&id=".$_SESSION['catalogo']."&serv=".$idserv);
		}catch (Exception $ex){
			$this->mensaje=Utilerias::mensajeError($ex->getMessage());
		}
		
	}
	public function actualizar(){
		include "Utilerias/leevar.php";
		try{
				
				DatosPruebaAnalisis::actualizar($idserv,$numcomp,$reacenlace,  $tipoana,"aa_pruebaanalisis");
				Utilerias::mensajeExito("La prueba se actualizó correctamente");
			
			}catch (Exception $ex){
				$this->mensaje=Utilerias::mensajeError($ex->getMessage());
			}
			
			
	}
	
	public function vistaNuevaPrueba(){
		include "Utilerias/leevar.php";
		
		
		$numcat=$_SESSION['catalogo'];
		$idserv = $serv;
		$this->ncomp= $numcat;
		
		
		$this->ids=$idserv;
		// llena tipo de analisis
		$opcionc="<option value='MB'>MICROBIOLOGICO</option>";
		$opcionc=$opcionc."<option value='FQ'>FISICOQUIMICO</option>";
		$tipocampo="
<div ><select class='form-control' name='tipoana' id='tipoana'>".$opcionc."</select></div>";
		$this->datocardet=$tipocampo;
		
		
		// busca el catalogo
		
		$sqlca="SELECT cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_parametroesp,
cue_reactivosestandardetalle.red_parametroing 
FROM cue_reactivosestandardetalle
Inner Join cue_reactivosestandar ON cue_reactivosestandar.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
 AND cue_reactivosestandar.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion AND cue_reactivosestandar.r_numreactivo = cue_reactivosestandardetalle.r_numreactivo 
AND cue_reactivosestandar.re_numcomponente = cue_reactivosestandardetalle.re_numcomponente 
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandar.ser_claveservicio 
AND cue_secciones.sec_numseccion = cue_reactivosestandar.sec_numseccion
WHERE cue_secciones.sec_indagua =  '1' AND cue_reactivosestandardetalle.re_numcomponente =:numcat AND
cue_reactivosestandardetalle.ser_claveservicio =:idserv";
		
		
		$rsca=Conexion::ejecutarQuery($sqlca,array("idserv"=>$idserv,"numcat"=>$numcat));
		$opcionc1="";
		if ($rsca) {
			foreach ($rsca as $rowca){
				$opcionc1=$opcionc1."<option value=".$rowca[red_numcaracteristica2].">".$rowca[red_parametroesp]."</option>";
			}
		}
		$tipocampo="<div ><select class='form-control' name='numreacen' id='numreacen'>".$opcionc1."</select></div>";
		
		$this->datocardet1=$tipocampo;
	}
		
	
	public function vistaEditaPrueba(){
		include "Utilerias/leevar.php";
		
		$numcat=$_SESSION['catalogo'];
		$id = $referencia;
		
		if(isset($_SESSION["idserv"]))
			$idserv= $_SESSION["idserv"];
		else $idserv=$serv;
	
		$this->ids=$idserv;
			$sqlrec="SELECT aa_pruebaanalisis.pa_numcomponente, aa_pruebaanalisis.pa_numprueba, aa_pruebaanalisis.pa_tipoanalisis
FROM aa_pruebaanalisis 
WHERE aa_pruebaanalisis.pa_numprueba =:id AND aa_pruebaanalisis.pa_numcomponente =:numcat 
AND aa_pruebaanalisis.pa_numservicio = :idserv";
			
			$rowca=DatosPruebaAnalisis::getPruebaAnalisis($idserv,$numcat,$id,"aa_pruebaanalisis");
			
				$tipoana=$rowca["pa_tipoanalisis"];
				$this->nomprue=$rowca["pa_nomprueba"];
				$this->estprue=$rowca["pa_estandar"];
				$this->numprue=$id;
			
			
			// llena tipo de analisis
			if ($tipoana=="MB"){
				$opcionc="<option value='MB' selected>MICROBIOLOGICO</option>";
			} else {
				$opcionc="<option value='MB' >MICROBIOLOGICO</option>";
			}
			if ($tipoana=="FQ"){
				$opcionc=$opcionc."<option value='FQ' selected>FISICOQUIMICO</option>";
			} else {
				$opcionc=$opcionc."<option value='FQ'>FISICOQUIMICO</option>";
			}
			
			$tipocampo="<td  height='30'><div align='left'><select name='tipoana' id='tipoana'>".$opcionc."</select></div></td>";
			$this->datocardet=$tipocampo;
			
			
			// busca el catalogo
			/*   $sqlca="SELECT cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_parametroesp, cue_reactivosestandardetalle.red_parametroing FROM cue_reactivosestandardetalle WHERE cue_reactivosestandardetalle.sec_numseccion =  '5' AND cue_reactivosestandardetalle.re_numcomponente =:numcat' AND cue_reactivosestandardetalle.ser_claveservicio =  '1'"; */
			$sqlca="SELECT cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_parametroesp,
 cue_reactivosestandardetalle.red_parametroing FROM cue_reactivosestandardetalle
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND 
cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion WHERE
cue_secciones.sec_indagua =  '1' AND cue_reactivosestandardetalle.re_numcomponente =:numcat AND
cue_reactivosestandardetalle.ser_claveservicio =:idserv";
			
			
			$rsca=Conexion::ejecutarQuery($sqlca,array("idserv"=>$idserv,"numcat"=>$numcat) );
			$opcionc="";
			if ($rsca) {
				foreach ($rsca as $rowca){
					if ($rowca[red_numcaracteristica2]==$id){
						$opcionc=$opcionc."<option value=".$rowca[red_numcaracteristica2]." selected>".$rowca[red_parametroesp]."</option>";
					} else {
						$opcionc=$opcionc."<option value=".$rowca[red_numcaracteristica2].">".$rowca[red_parametroesp]."</option>";
					}
				}
			}
			$tipocampo="<td  height='30'><div align='left'><select name='reacenlace' id='reacenlace'>".$opcionc."</select></div></td>";
			
			$this->datocardet1=$tipocampo;
			
			$this->ncomp=$numcat;
		
			
	}
	/**
	 * @return mixed
	 */
	public function getListaPruebas() {
		return $this->listaPruebas;
	}
	/**
	 * @return string
	 */
	public function getDatocardet1() {
		return $this->datocardet1;
	}

	/**
	 * @return string
	 */
	public function getDatocardet() {
		return $this->datocardet;
	}

	/**
	 * @return mixed
	 */
	public function getNomprue() {
		return $this->nomprue;
	}

	/**
	 * @return mixed
	 */
	public function getNumprue() {
		return $this->numprue;
	}
	/**
	 * @return mixed
	 */
	public function getTITULO5() {
		return $this->TITULO5;
	}
	/**
	 * @return mixed
	 */
	public function getNcomp() {
		return $this->ncomp;
	}
	/**
	 * @return mixed
	 */
	public function getIds() {
		return $this->ids;
	}
	/**
	 * @return string
	 */
	public function getMensaje() {
		return $this->mensaje;
	}






	
	
}