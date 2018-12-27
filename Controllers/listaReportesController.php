<?php


class ListaReportesController {
	
	private $listaReportes;
	private $NumeroReportes;
	private $vserviciou,
	$vclienteu;
	private $pages;
	
	public function vistaListaReportes(){
		include "Utilerias/leevar.php";
		$usuario=$_SESSION["NombreUsuario"];
		
		$this->vclienteu=1;
		$this->vserviciou=1;
		
		/*************************************************/
		$ban=$bconsulta;
		$ban=1;
		/*******CONDICION QUE ELIMINA LA TABLA Gtabla**********/
	
		
			$sql_c = "SELECT
ins_generales.i_numreporte as NumReporte,
ca_unegocios.une_descripcion as PuntoVenta,
ins_generales.i_mesasignacion as MesAsignacion,
ca_unegocios.une_idpepsi,
ca_unegocios.une_idcuenta,
ca_unegocios.une_dir_municipio,concat(une_dir_calle,' ',

    une_dir_numeroext,' ',

    une_dir_colonia) as direccion,une_dir_estado
FROM tmp_estadistica 
  INNER JOIN ins_generales ON tmp_estadistica.numreporte = ins_generales.i_numreporte 
  INNER JOIN ca_unegocios ON 
     ins_generales.`i_unenumpunto` = ca_unegocios.une_id
where tmp_estadistica.usuario=:usuario and ins_generales.i_claveservicio=:vserviciou ";

			$parametros = array("vserviciou" => $this->vserviciou, "usuario" => $usuario);
			if(isset($fil_ptoventa))
			{
				$sql_c.=" and une_descripcion like :fil_ptoventa ";
				$parametros["fil_ptoventa"]="%".$fil_ptoventa."%";
			}
			
			
			$this->listaReportes = Conexion::ejecutarQuery( $sql_c,$parametros );
		
			$numreportes = sizeof( $this->listaReportes  );
			if ( $ban== 1) {
				//echo $numreportes;
				if($numreportes>10){
					$this->pages = new Paginator($numreportes, 9, array(
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
					$sql_c.=" limit ".$this->pages->limit_start.",".$this->pages->limit_end;
				
					
					
					$this->listaReportes = Conexion::ejecutarQuery( $sql_c,$parametros );
					
					
			
				}
			if ($numreportes == 0) {
				$this->NumeroReportes="<label style='color:#F00'>Su búsqueda no produjo ningún resultado !!!</label>" ;
			} else {
				$this->NumeroReportes= strtoupper(T_("Total de Reportes")).": " . $numreportes ;
			}
			
		}
	
		Navegacion::borrarRutaActual("b");
		$rutaact = $_SERVER['REQUEST_URI'];
		// echo $rutaact;
		Navegacion::agregarRuta("b", $rutaact, T_("REPORTES VISITA"));
	}
	/**
	 * @return mixed
	 */
	public function getListaReportes() {
		return $this->listaReportes;
	}

	/**
	 * @return string
	 */
	public function getNumeroReportes() {
		return $this->NumeroReportes;
	}
	/**
	 * @return number
	 */
	public function getVserviciou() {
		return $this->vserviciou;
	}

	/**
	 * @return number
	 */
	public function getVclienteu() {
		return $this->vclienteu;
	}
	/**
	 * @return mixed
	 */
	public function getPages() {
		return $this->pages;
	}



	
	
}

