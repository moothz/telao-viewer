<?php

define("MYSQL_SERVER","localhost");
define("MYSQL_USER","nupedee");
define("MYSQL_PASS","0Blw6fXVN2RCFnFQ");

define("CONFIG_SENHA_ADM","abrileomaiscrueldosmeses");
//define("CONFIG_SENHA_ADM","testarosistemapraver");
define("CONFIG_DIRETORIO_TELAO","/var/www/html/TelaoCT/");

function mysqliConn($db="telaoCT"){
	

	$con = new PDO("mysql:host=".MYSQL_SERVER.";dbname=$db", MYSQL_USER, MYSQL_PASS);
	if (!$con){
		die("Erro no MYSQL: " . mysql_error());
	}
	$con->exec("set names utf8");
	$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	return $con;
}