<?php
require_once("../admin/config.php");

function getConteudoFromTelaRaw($idTela,$posicao){
	$retorno = NULL;
	try {
		$con = mysqliConn();
		$stmt = $con->prepare("SELECT id,tipo,posicao,dados FROM conteudo WHERE conteudo.idTela = ? AND conteudo.posicao = ?");
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
		$con = mysqliConn();
		$stmt = $con->prepare("SELECT * FROM telas WHERE dataLimite >= CURRENT_DATE() ORDER BY id ASC");

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