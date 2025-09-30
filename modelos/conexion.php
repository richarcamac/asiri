<?php 

class Conexion{

	static public function conectar(){

		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
		
		$username = "asiridata";
		$password = "123456789";
		$host     = "mysql-asiridata.alwaysdata.net";
		$dbname   = "asiridata_usuarios";
		
		$link = new PDO("mysql:host={$host};dbname={$dbname};", $username, $password, $options);

		$link->exec("set names utf8");

		$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$link->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, 1);

		return $link;

	}

}
