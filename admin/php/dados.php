<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("protege.php");
require_once("config.php");

require_once("class.upload.php");

$request = array_merge($_POST,$_GET);

if(!isset($request["acao"])){
	die("{erro: 'Nenhuma ação informada.'}");
}

switch ($request["acao"]){
	case "novaTela":
		echo json_encode(novaTela());
		break;
	case "excluirTela":
		echo json_encode(excluirTela($request["id"]));
		break;
	case "updateTela":
		echo json_encode(updateTela($request["idTela"],$request["descricao"],$request["tipo"],$request["duracao"],$request["dataLimite"]));
		break;
	case "uploadArquivo":
		echo json_encode(uploadArquivo($_FILES["arquivo"],$request["idTela"],$request["posicao"]));
		break;
	case "excluirConteudo":
		echo json_encode(excluirConteudo($request["idConteudo"]));
		break;
	case "duplicarConteudo":
		echo json_encode(duplicarConteudo($request["idConteudo"],$request["idDestino"],$request["posDestino"]));
		break;
	case "getTelas":
		echo json_encode(getTelas());
		break;
	case "getTela":
		echo json_encode(getTela($request["id"]));
		break;
	default:
		$r = array("erro" => "Ação inválida: '".$request["acao"]."'");
		die(json_encode($r));
}

function duplicarConteudo($idConteudo,$idDestino,$posDestino){
	$retorno = array();
	try {
		$con = mysqliConn("telaoCT");
		$stmt = $con->prepare("SELECT idTela,tipo,dados,duracaoVideo FROM conteudo WHERE id = :idConteudo");
		$stmt->bindParam(":idConteudo",$idConteudo);
		$stmt->execute();
		$origem = $stmt->fetch(PDO::FETCH_ASSOC);

		if($idDestino == 0){	// Copiando para espaço vazio, fazer um insert
			$stmt = $con->prepare("INSERT INTO conteudo (idTela,tipo,posicao,dados,duracaoVideo) VALUES (:idTela,:tipo,:posicao,:dados,:duracaoVideo)");
			$stmt->bindParam(":idTela",$origem["idTela"]);
			$stmt->bindParam(":tipo",$origem["tipo"]);
			$stmt->bindParam(":posicao",$posDestino);
			$stmt->bindParam(":dados",$origem["dados"]);
			$stmt->bindParam(":duracaoVideo",$origem["duracaoVideo"]);
			$stmt->execute();
			
		} else {
			$stmt = $con->prepare("SELECT dados FROM conteudo WHERE id = :idConteudo");
			$stmt->bindParam(":idConteudo",$idDestino);
			$stmt->execute();
			$destino = $stmt->fetch(PDO::FETCH_ASSOC);

			$stmt = $con->prepare("UPDATE conteudo SET idTela = :idTela,tipo = :tipo,posicao = :posicao,dados = :dados,duracaoVideo = :duracaoVideo WHERE id = :idConteudo");
			$stmt->bindParam(":idConteudo",$idDestino);
			$stmt->bindParam(":idTela",$origem["idTela"]);
			$stmt->bindParam(":tipo",$origem["tipo"]);
			$stmt->bindParam(":posicao",$posDestino);
			$stmt->bindParam(":dados",$origem["dados"]);
			$stmt->bindParam(":duracaoVideo",$origem["duracaoVideo"]);
			$stmt->execute();

			// unlink(CONFIG_DIRETORIO_TELAO.$destino["dados"]);
			$retorno["status"] = 1;
		}

	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}
	return $retorno;
}

function uploadArquivo($arquivo,$idTela,$posicao){
	$retorno = array();
	try {
		$extensao = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));
		$tipo = 0;
		$caminhoArquivo = "";
		$deuCerto = false;
		$nomeArquivo = generateRandomString(20);

		$duracao = 0;
		if($extensao == "jpg" || $extensao == "jpeg" || $extensao == "png" || $extensao == "gif"){
			// Imagem
			$tipo = 1;

			$arq = new Upload($arquivo); 
			// $arq->jpeg_quality = 100;
			// $arq->image_resize = true;
			// $arq->image_y = 800;
			// $arq->image_ratio_x = true;
			$conteudoArquivo = $arq->Process();

			$tmb = new Upload($arquivo); 
			$tmb->image_resize = true;
			$tmb->image_x = 384;
			$tmb->image_ratio_y = true;
			$conteudoThumb = $tmb->Process();
			
			

			$caminhoArquivo = "arquivos/".$nomeArquivo.".".$extensao;
			$caminhoThumb = "arquivos/".$nomeArquivo."_thumb.jpg";
			file_put_contents(CONFIG_DIRETORIO_TELAO.$caminhoArquivo, $conteudoArquivo);
			file_put_contents(CONFIG_DIRETORIO_TELAO.$caminhoThumb, $conteudoThumb);
			$deuCerto = true;
		} elseif($extensao == "mp4" || $extensao == "avi"){
			$out = "";

			$tipo = 2;
			$caminhoArquivo = "arquivos/".$nomeArquivo.".mp4";
			$caminhoThumb = "arquivos/".$nomeArquivo."_thumb.gif";

			$arquivoDest = CONFIG_DIRETORIO_TELAO.$caminhoArquivo;
			$resMove = move_uploaded_file($arquivo["tmp_name"],$arquivoDest);
			$out = "tmp_name: '".$arquivo["tmp_name"]."'' / arquivoDest: '$arquivoDest' / caminhoThumb: '$caminhoThumb' => '$resMove'\n";

			// Processa thumbnail
			$source = $arquivoDest;
			$dest = CONFIG_DIRETORIO_TELAO.$caminhoThumb;

			$duracao = shell_exec(CONFIG_FFPROBE." $source -show_format 2>&1 | sed -n 's/duration=//p'");
			if($duracao == null){
				$duracao = "0";
			}
			$duracao = floatval(preg_replace('/\s+/', '', $duracao));
			$out .= CONFIG_FFPROBE." $source -show_format 2>&1 | sed -n 's/duration=//p' => '$duracao'";

			$nomeTemp = CONFIG_DIRETORIO_TELAO."admin/tmp/".generateRandomString(20);

			if($duracao == 0){
				$duracao = 50;
			}
			$fator = 5/$duracao;
			
			$strCmd = CONFIG_FFMPEG.' -y -i '.$source.' -an -filter:v "setpts='.$fator.'*PTS" '.$nomeTemp.'.mp4';
			$out .= $strCmd."\n";
			$out .= shell_exec($strCmd);
			$strCmd = CONFIG_FFMPEG.' -y -i '.$nomeTemp.'.mp4 -vf palettegen '.$nomeTemp.'.png';
			$out .= $strCmd."\n";
			$out .= shell_exec($strCmd);
			$strCmd = CONFIG_FFMPEG.' -y -i '.$nomeTemp.'.mp4 -i '.$nomeTemp.'.png -filter_complex paletteuse -r 10 -s 191x108 '.$dest;
			$out .= $strCmd."\n";
			$out .= shell_exec($strCmd);

			@unlink($nomeTemp.'.mp4');
			@unlink($nomeTemp.'.png');

			$retorno["debug"] .= $out;
			$deuCerto = true;
		} else {
			$deuCerto = false;
			$retorno["erro"] = "Extensão '$extensao' não supoortada!";
		}

		if($deuCerto){
			$con = mysqliConn("telaoCT");

			$stmtRemove = $con->prepare("DELETE FROM conteudo WHERE idTela = :idTela AND posicao = :posicao");
			$stmtRemove->bindParam(":idTela",$idTela);
			$stmtRemove->bindParam(":posicao",$posicao);
			$stmtRemove->execute();

			$stmt = $con->prepare("INSERT INTO conteudo (idTela,tipo,posicao,dados,duracaoVideo) VALUES (:idTela,:tipo,:posicao,:dados,:duracao)");
			$stmt->bindParam(":idTela",$idTela);
			$stmt->bindParam(":tipo",$tipo);
			$stmt->bindParam(":posicao",$posicao);
			$stmt->bindParam(":dados",$caminhoArquivo);
			$stmt->bindParam(":duracao",$duracao);
			$stmt->execute();
		}

	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}
	return $retorno;
}

function excluirConteudo($id){
	$retorno = array();
	try{	
		$idConteudo = intval($id);

		if($idConteudo > 0){
			$con = mysqliConn("telaoCT");
			$stmt = $con->prepare("SELECT dados FROM conteudo WHERE id = :idConteudo");
			$stmt->bindParam(":idConteudo",$idConteudo);
			$stmt->execute();
			$conteudo = $stmt->fetch(PDO::FETCH_ASSOC);

			$stmt = $con->prepare("DELETE FROM conteudo WHERE id = :idConteudo");
			$stmt->bindParam(":idConteudo",$idConteudo);

			if($stmt->execute()){
				if(strlen($conteudo["dados"]) > 1){
					// $arq = CONFIG_DIRETORIO_TELAO.$conteudo["dados"];
					// $thumb = explode(".",$arq);
					// $thumb = $thumb[0]."_thumb*";
					// @unlink($arq);
					// foreach(glob($thumb) as $file){
					// 	@unlink($file);
					// }
					// $retorno["debug"] = $arq."\n".$thumb;
					$retorno["status"] = 1;
				} else {
					$retorno["erro"] = "Erro Excluindo Arquivo";	
				}
			} else {
				$retorno["erro"] = "Erro Excluindo Conteudo";
			}
		} else {
			$retorno["erro"] = "Erro Excluindo Conteudo (ID invalido: $id)";
		}
	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}

	return $retorno;
}

function excluirTela($id){
	$retorno = array();
	try{	
		$con = mysqliConn("telaoCT");

		$stmt = $con->prepare("SELECT tipo,dados FROM conteudo WHERE idTela = :id");
		$stmt->bindParam(":id",$id);
		$stmt->execute();
		$conteudo = $stmt->fetchAll(PDO::FETCH_ASSOC);
		

		$stmt = $con->prepare("DELETE FROM conteudo WHERE idTela = :id");
		$stmt->bindParam(":id",$id);

		if($stmt->execute()){
			$stmt = $con->prepare("DELETE FROM telas WHERE id = :id");
			$stmt->bindParam(":id",$id);

			if($stmt->execute()){
				$retorno["status"] = 1;
				foreach ($conteudo as $c) {
					$arq = CONFIG_DIRETORIO_TELAO.$c["dados"];
					$thumb = explode(".",$arq);
					$thumb = $thumb[0]."_thumb*";
					@unlink($arq);
					foreach(glob($thumb) as $file){
						@unlink($file);
					}
				}
			} else {
				$retorno["erro"] = "Erro Excluindo Tela";
			}
		} else {
			$retorno["erro"] = "Erro Excluindo Tela";
		}
	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}

	return $retorno;
}

function updateTela($idTela,$descricao,$tipo,$duracao,$dataLimite){
	$retorno = array();
	try{	
		$con = mysqliConn("telaoCT");
		
		$stmt = $con->prepare("UPDATE telas SET descricao = :descricao,tipo = :tipo,duracao = :duracao,dataLimite = :dataLimite WHERE id = :id");
		$stmt->bindParam(":id",$idTela);
		$stmt->bindParam(":tipo",$tipo);
		$stmt->bindParam(":duracao",$duracao);
		$stmt->bindParam(":descricao",$descricao);
		$stmt->bindParam(":dataLimite",$dataLimite);

		if($stmt->execute()){
			$retorno["tela"] = array(
				"idTela" => $idTela,
				"descricao" => $descricao,
				"tipo" => $tipo,
				"duracao" => $duracao,
				"dataLimite" => $dataLimite
			);
		} else {
			$retorno["erro"] = "Erro Inserindo";
		}
	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}

	return $retorno;
}

function novaTela(){
	$retorno = array();
	try{	
		$con = mysqliConn("telaoCT");

		$descricao = "Nova Tela #".rand(0,1000);
		$tipo = 1;
		$duracao = 15;
		$dataLimite = date("Y-m-d",strtotime("yesterday"));
		$stmt = $con->prepare("INSERT INTO telas (descricao,tipo,duracao,dataLimite) VALUES (:descricao,:tipo,:duracao,:dataLimite)");
		$stmt->bindParam(":descricao",$descricao);
		$stmt->bindParam(":tipo",$tipo);
		$stmt->bindParam(":duracao",$duracao);
		$stmt->bindParam(":dataLimite",$dataLimite);

		if($stmt->execute()){
			$idTela = $con->lastInsertId();
			$retorno["tela"] = array(
				"idTela" => $idTela,
				"descricao" => $descricao,
				"tipo" => $tipo,
				"duracao" => $duracao,
				"dataLimite" => $dataLimite
			);
		} else {
			$retorno["erro"] = "Erro Inserindo";
		}
	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}

	return $retorno;
}

function getTela($id){
	$retorno = array();
	try{	
		$con = mysqliConn("telaoCT");

		$stmt = $con->prepare("SELECT descricao,tipo,duracao,dataLimite FROM telas WHERE id = :id");
		$stmt->bindParam(":id",$id);
		$stmt->execute();

		$retorno["tela"] = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $con->prepare("SELECT id as idConteudo,tipo,posicao,dados as arquivo, duracaoVideo FROM conteudo WHERE idTela = :id ORDER BY posicao");
		$stmt->bindParam(":id",$id);
		$stmt->execute();
		
		$retorno["tela"]["conteudo"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}

	return $retorno;
}

function getTelas(){
	$retorno = array();
	try{	
		$con = mysqliConn("telaoCT");
		
		$stmt = $con->prepare("SELECT id,descricao,tipo,duracao,dataLimite FROM telas");
		$stmt->execute();

		$retorno["resultados"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch(Exception $e){
		$retorno["erro"] = $e->getMessage();
	}

	return $retorno;
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