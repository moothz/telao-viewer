<?php
	require_once("config.php");
	if(session_id() == '') {
    	session_start();
	}

	if(isset($_SESSION["logado"])){
		
	} else {
		if(basename($_SERVER['PHP_SELF']) != "login.php"){
			header("Location: ".CONFIG_URL."admin/login.php");	
		}
	}