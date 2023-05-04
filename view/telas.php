<?php
	require_once("funcoes.php");

	if(isset($_POST["enviado"])){
		if($_POST["idTela"] == -1){
			
			if(inserirTela($_POST["duracao"],$_POST["tipo"],$_POST["descricao"],$_POST["dataLimite"])){
				echo "Tela Inserida com sucesso";
			} else {
				echo "Erro inserindo tela";
			}
		} else {
			atualizarTela($_POST["idTela"],$_POST["duracao"],$_POST["tipo"],$_POST["descricao"],$_POST["dataLimite"]);
		}

	}

	$optionsTelasExistentes = "<option value='-1' selected>Inserir nova</option>";
	$telasExistentes = getTelas();
	foreach($telasExistentes as $tela){
		$optionsTelasExistentes .= "<option value='".$tela["id"]."' duracao='".$tela["duracao"]."' descricao='".$tela["descricao"]."' dataLimite='".$tela["dataLimite"]."'>".$tela["descricao"]." - ".$tela["dataLimite"]." (".$tela["tipo"].")</option>";		
	}

?>
<script type="text/javascript" src="jquery-1.9.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#idTela").change(function(){
		var ele = $('#idTela').find(":selected");
		console.log(ele);
		var duracao = ele.attr("duracao");
		var descricao = ele.attr("descricao");
		var dataLimite = ele.attr("dataLimite");

		$("#duracao").val(duracao);
		$("#descricao").val(descricao);
		$("#dataLimite").val(dataLimite);

	});
});
</script>
<meta charset="utf-8">
<form action="telas.php" method="POST">
    <input type="hidden" name="enviado" value="1" />
    ID Tela: <select id="idTela" name="idTela"><?php echo $optionsTelasExistentes; ?></select><br><br>

    Duracao: <input type="number" id="duracao" name="duracao" /> <br>
    Tipo: <select name="tipo">
	    <option value="1">Tela Inteira</option>
	    <option value="2">Uma Imagem por TV</option>
	    <option value="3" disabled>1 em cima, 2 embaixo</option>
	    <option value="4" disabled>2 em cima, 1 embaixo</option>
	    <option value="5" disabled>1 na esquerda, 2 na direita</option>
	    <option value="6" disabled>2 na esquerda, 1 na direita</option>
	    </select><br>
    Descricao: <input type="text" id="descricao" name="descricao" /> <br>
    Data Limite: <input type="date" id="dataLimite" name="dataLimite" /> <br><br>

    <input type="submit" value="Cadastrar" />
</form>
