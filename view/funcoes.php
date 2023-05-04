<?php
function getConteudoFromTelaRaw($idTela,$posicao){
	$retorno = NULL;
	try {
		$con = mysqlConn();
		$stmt = $con->prepare("SELECT id,tipo,posicao,dados FROM telaoCT.conteudo WHERE conteudo.idTela = ? AND conteudo.posicao = ?");
		$stmt->bindParam(1, $idTela);
		$stmt->bindParam(2, $posicao);

		if($stmt->execute()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$retorno = $row;
			}
		}

	} catch (PDOException $e) {
		echo "Erro MySQL: ".$e->getMessage();
	}
	unset($con);	

	return $retorno;
}


function getTelas(){

	$retorno = array();
	try {
		$con = mysqlConn();
		$stmt = $con->prepare("SELECT * FROM telaoCT.telas WHERE dataLimite >= CURRENT_DATE() ORDER BY id ASC");

		if($stmt->execute()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				array_push($retorno, $row);
			}
		}

	} catch (PDOException $e) {
		echo "Erro MySQL: ".$e->getMessage();
	}
	unset($con);	
	return $retorno;

}

function inserirTela($duracao,$tipo,$descricao,$dataLimite){
	try {
		$con = mysqlConn();
		$stmt = $con->prepare("INSERT INTO  telaoCT.telas (duracao,tipo,descricao,dataLimite,ordem) VALUES (?,?,?,?,0);");

		$stmt->bindParam(1, $duracao);
		$stmt->bindParam(2, $tipo);
		$stmt->bindParam(3, $descricao);
		$stmt->bindParam(4, $dataLimite);

		if($stmt->execute()){
			return true;
		} else {
			print_r($stmt->errorInfo());
			return false;
		}

	} catch (PDOException $e) {
		echo "Erro MySQL: ".$e->getMessage();
		return false;
	}
	unset($con);	
}

function atualizarTela($idTela,$duracao,$tipo,$descricao,$dataLimite){
	try {
		$con = mysqlConn();
		$stmt = $con->prepare("UPDATE telaoCT.telas SET duracao = ?, tipo = ?, descricao = ?,dataLimite = ? WHERE id = ?");

		$stmt->bindParam(1, $duracao);
		$stmt->bindParam(2, $tipo);
		$stmt->bindParam(3, $descricao);
		$stmt->bindParam(4, $dataLimite);
		$stmt->bindParam(5, $idTela);

		if($stmt->execute()){
			return true;
		} else {
			print_r($stmt->errorInfo());
			return false;
		}

	} catch (PDOException $e) {
		echo "Erro MySQL: ".$e->getMessage();
		return false;
	}
	unset($con);	
}


function inserirConteudo($idTela,$tipo,$posicao,$conteudo){
	try {
		$con = mysqlConn();
		$stmt = $con->prepare("INSERT INTO  telaoCT.conteudo (idTela,tipo,posicao,dados) VALUES (?,?,?,?);");

		$stmt->bindParam(1, $idTela);
		$stmt->bindParam(2, $tipo);
		$stmt->bindParam(3, $posicao);
		$stmt->bindParam(4, $conteudo);

		if($stmt->execute()){
			return true;
		} else {
			return false;
		}

	} catch (PDOException $e) {
		echo "Erro MySQL: ".$e->getMessage();
		return false;
	}
	unset($con);	
}

function atualizarConteudo($id,$tipo,$conteudo){
		try {
		$con = mysqlConn();
		$stmt = $con->prepare("UPDATE  telaoCT.conteudo SET dados = ?, tipo = ? WHERE id = ?");

		$stmt->bindParam(1, $conteudo);
		$stmt->bindParam(2, $tipo);
		$stmt->bindParam(3	, $id);

		if($stmt->execute()){
			return true;
		} else {
			return false;
		}

	} catch (PDOException $e) {
		echo "Erro MySQL: ".$e->getMessage();
		return false;
	}
	unset($con);	
}


function getConteudosList(){

	$retorno = array();
	try {
		$con = mysqlConn();
		$stmt = $con->prepare("SELECT id,idTela,tipo,posicao FROM telaoCT.conteudo ORDER BY id");

		if($stmt->execute()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				array_push($retorno, $row);
			}
		}

	} catch (PDOException $e) {
		echo "Erro MySQL: ".$e->getMessage();
	}
	unset($con);	
	return $retorno;

}




function mysqlConn(){
	$con = new PDO("mysql:host=localhost;dbname=telaoCT", "nupedee", "0Blw6fXVN2RCFnFQ");
	if (!$con){
		die("Erro no MYSQL: " . mysql_error());
	}
	$con->exec("set names utf8");
	return $con;
}
function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


?>

