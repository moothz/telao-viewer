<?php

	if(session_id() == '') {
    	session_start();
	}

	if(isset($_SESSION["logado"])){
		
	} else {
		if(basename($_SERVER['PHP_SELF']) != "login.php"){
			header("Location: /tct/login.php");	
		}
	}