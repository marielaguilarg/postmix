<?php

class Conexion{

	public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=inspeccionpostmix", "root", "");
		return $link;


	}
}


?>