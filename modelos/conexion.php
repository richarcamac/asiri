<?php 

class Conexion{

	static public function conectar(){

		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
		
		$username = "if0_40048234";
		$password = "jBfwuch5ndok83W";
		$host     = "localhost";
		$dbname   = "if0_40048234_asiri";
		
		$link = new PDO("mysql:host={$host};dbname={$dbname};", $username, $password, $options);

		$link->exec("set names utf8");

		$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$link->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, 1);

		return $link;

	}

}