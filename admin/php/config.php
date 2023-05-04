<?php

define("MYSQL_SERVER","localhost");
define("MYSQL_DB","telao");
define("MYSQL_USER","usuario");
define("MYSQL_PASS","senha");


// Caminho completo para o FFMPEG e FFPROBE
// Usados para compactar os vídeos e criar thumbnails
define("CONFIG_FFMPEG","/usr/bin/ffmpeg");
define("CONFIG_FFPROBE","/usr/bin/ffprobe");


define("CONFIG_SENHA_ADM","senha_administracao");
define("CONFIG_DIRETORIO_TELAO","/var/www/html/telao/");
define("CONFIG_URL","/telao/");

function mysqliConn(){
	$con = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DB, MYSQL_USER, MYSQL_PASS);
	if (!$con){
		die("Erro no MYSQL: " . mysql_error());
	}
	$con->exec("set names utf8");
	$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	return $con;
}