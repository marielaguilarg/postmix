<?php


class Tablahtml {
   var $tabla="<table  border=\"1\"> ";
	//var $columna;
	//var $renglon;
	var $fin="</table>";
/*	function construye()
	{
		$this->$tabla="<table  border=\"1\"> ";
		echo $this->$tabla;
		
	}*/
        
         function tablahtml($estilo){
           $this->tabla='<table width="100%"  border="1" cellpadding="0" cellspacing="0" class="'.$estilo.'"> ';
        }
	function nuevoren()			//funcion para nuevo renglon
	{
		$renglon="<tr >";
		$this->tabla=$this->tabla.$renglon;
		//echo "hola".$this->tabla;
		
	}
	function finren()			//funcion para cerrar renglon
	{
		$renglon="</tr >";
		$this->tabla=$this->tabla.$renglon;
		
	}
	function nuevacol($dato,$color,$combinar)
	{
		//$color="#3300FF";
		$columna="<td height=\"15\" ";
		if ($color!='')
		{
		 $columna=$columna."bgcolor='".$color."' ";
		 }
		 if ($combinar!='')
		   $columna=$columna." colspan='".$combinar."' ";
		$columna=$columna." >".$dato." </td >";
		$this->tabla=$this->tabla.$columna;
		
	}
        //columna con estilo
        function nuevacolest($dato,$estilo,$combinar)
	{
		//$color="#3300FF";
		$columna="<td  ";
		if ($estilo!='')
		{
		 $columna=$columna."class='".$estilo."' ";
		 }
		 if ($combinar!='')
		   $columna=$columna." colspan='".$combinar."' ";
		$columna=$columna." >".$dato." </td >";
		$this->tabla=$this->tabla.$columna;

	}
         function nuevacolestanch($dato,$estilo,$combinar,$ancho)
	{
		//$color="#3300FF";
		$columna="<td  ";
		if ($estilo!='')
		{
		 $columna=$columna."class='".$estilo."' width='".$ancho."' ";
		 }
		 if ($combinar!='')
		   $columna=$columna." colspan='".$combinar."' ";
		$columna=$columna." >".$dato." </td >";
		$this->tabla=$this->tabla.$columna;

	}
	function cierretabla()
	{
	 $fin="</table>";
	$this->tabla=$this->tabla.$fin;
	return $this->tabla;
	}
	
}
