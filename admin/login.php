<?php
	require_once("php/config.php");
	
	if(isset($_POST["pw"])){
		if($_POST["pw"] == CONFIG_SENHA_ADM){
			if(session_id() == '') {
    			session_start();

			}
			$_SESSION["logado"] = "jjj";
			header("Location: index.php");
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin TelaoCT</title>
	<style type="text/css">
		body,html{
			background-color: #060606;
			color: #1db931;
			text-align: center;
			font-family: monospace;
			font-size: 18px;
			font-weight: bold;
		}
		input{
			background-color: #1c1c1c;
			outline: 0;
			border: 1px solid #1db931;
			color: #1db931;
			text-align: center;
			padding: 5px;
			font-size: 18px;
			font-family: monospace;	
		}
		table{
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
		}
		td{
			width: 100%;
			height: 100%;
			text-align: center;
			vertical-align: middle;
		}
	</style>
</head>
<body>
<table>
	<tr>
		<td><form action="login.php" method="POST"><input type="password" name="pw" placeholder="***************************" /></form></td>
	</tr>	
</table>


</body>
</html>