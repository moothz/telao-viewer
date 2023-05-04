<?php 
	require_once("php/protege.php");
	$cacheFix = "?c=".rand(1000,10000); 
	$dataLimite = date("Y-m-d",strtotime("today + 7 days"));
?><!DOCTYPE html>
<html>
<head>
	<title>Administração Telão</title>
	<link rel="stylesheet" type="text/css" href="css/fa.css">
	<link rel="stylesheet" type="text/css" href="css/principal.css<?php  echo $cacheFix; ?>">
	<meta charset="utf-8">
</head>
<body>

	<h1>Telão</h1>

	<table class="container-edicao">
		<tr>
			<td colspan="2"><h2>Criação/Edição de Telas</h2></td>
		</tr>
		<tr>
			<td style="max-width: 490px; width: 490px; height: 315px;  text-align: center;">
				<div id="tipo-visualizacao-1" class="container-tv" style="display: block">
					<table class="tvs-view">
						<tr>
							<td class="thumb tv-1x1f pos-1" idConteudo="0" tipo="1" posicao="0"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>

				<div id="tipo-visualizacao-2" class="container-tv">
					<table class="tvs-view">
						<tr>
							<td class="thumb tv-4x4 pos-1" idConteudo="0" tipo="2" posicao="0"><div class="overlay-branco"></div></td>
							<td class="thumb tv-4x4 pos-2" idConteudo="0" tipo="2" posicao="1"><div class="overlay-branco"></div></td>
						</tr>
						<tr>
							<td class="thumb tv-4x4 pos-3" idConteudo="0" tipo="2" posicao="2"><div class="overlay-branco"></div></td>
							<td class="thumb tv-4x4 pos-4" idConteudo="0" tipo="2" posicao="3"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>

				<div id="tipo-visualizacao-3" class="container-tv">
					<table class="tvs-view">
						<tr>
							<td colspan="2" class="thumb tv-1x2h pos-1" idConteudo="0" tipo="3" posicao="0"><div class="overlay-branco"></div></td>
						</tr>
						<tr>
							<td class="thumb tv-1x2h pos-2" idConteudo="0" tipo="3" posicao="1"><div class="overlay-branco"></div></td>
							<td class="thumb tv-1x2h pos-3" idConteudo="0" tipo="3" posicao="2"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>

				<div id="tipo-visualizacao-4" class="container-tv">
					<table class="tvs-view">
						<tr>
							<td class="thumb tv-2x1h pos-1" posicao="0" tipo="4"><div class="overlay-branco" idConteudo="0" tipo="4" posicao="0"></div></td>
							<td class="thumb tv-2x1h pos-2" posicao="1" tipo="4"><div class="overlay-branco" idConteudo="0" tipo="4" posicao="1"></div></td>
						</tr>
						<tr>
							<td colspan="2" class="thumb tv-2x1h pos-3" idConteudo="0" tipo="4" posicao="2"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>

				<div id="tipo-visualizacao-5" class="container-tv">
					<table class="tvs-view">
						<tr>
							<td rowspan="2" class="thumb tv-1x2v pos-1" idConteudo="0" tipo="5" posicao="0"><div class="overlay-branco"></div></td>
							<td class="thumb tv-1x2v pos-2" idConteudo="0" tipo="5" posicao="1"><div class="overlay-branco"></div></td>
						</tr>
						<tr>
							<td class="thumb tv-1x2v pos-3" idConteudo="0" tipo="5" posicao="2"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>

				<div id="tipo-visualizacao-6" class="container-tv">
					<table class="tvs-view">
						<tr>
							<td class="thumb tv-2x1v pos-1" idConteudo="0" tipo="6" posicao="0"><div class="overlay-branco"></div></td>
							<td rowspan="2" class="thumb tv-2x1v pos-2" idConteudo="0" tipo="6" posicao="1"><div class="overlay-branco"></div></td>
						</tr>
						<tr>
							<td class="thumb tv-2x1v pos-3" idConteudo="0" tipo="6" posicao="2"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>

				<div id="tipo-visualizacao-7" class="container-tv">
					<table class="tvs-view">
						<tr>
							<td class="thumb tv-1x1v pos-1" idConteudo="0" tipo="7" posicao="0"><div class="overlay-branco"></div></td>
							<td class="thumb tv-1x1v pos-2" idConteudo="0" tipo="7" posicao="1"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>

				<div id="tipo-visualizacao-8" class="container-tv">
					<table class="tvs-view">
						<tr>
							<td class="thumb tv-1x1h pos-1" idConteudo="0" tipo="8" posicao="0"><div class="overlay-branco"></div></td>
						</tr>
						<tr>
							<td class="thumb tv-1x1h pos-2" idConteudo="0" tipo="8" posicao="1"><div class="overlay-branco"></div></td>
						</tr>
					</table>
				</div>
				<progress id="barraProgresso" value="0"></progress>
			</td>

			<td style="width: 300px;">
				<input type="hidden" id="valor-tipo" value="1">

				Selecione uma tela: 
				<select id="seletor-tela">
					<option value="-1" selected>Selecione...</option>
					<optgroup label="Ativas" id="lista-ativas">
					</optgroup>
					<optgroup label="Expiradas" id="lista-expiradas">
					</optgroup>
				</select>
				<br>
				<button id="botao-novaTela">Criar Nova tela</button>
				<br><br>

				<div id="dadosTela">
					Nome: <input type="text" id="valor-nome" placeholder="Nome de referência"><br>
					Tempo de exibição (s): <input type="number" id="valor-duracao" value="10" style="width: 40px;"><br>
					Data Limite: <input type="date" id="valor-data" value="<?php echo $dataLimite; ?>" style="width: 130px;"><br>
					Tipo de exibição: <button id="botao-escolher-tipo">Escolher Tipo</button>
					<div style="position: relative;">
						<div id="seletor-tipo">
							<table>
								<tr>
									<td><img class="thumb-tipo selecionado" src="css/img/tipos-tela-1.jpg" idConteudo="0" tipo="1"/></td>
									<td><img class="thumb-tipo" src="css/img/tipos-tela-2.jpg" idConteudo="0" tipo="2"/></td>
									<td><img class="thumb-tipo" src="css/img/tipos-tela-3.jpg" idConteudo="0" tipo="3"/></td>
									<td><img class="thumb-tipo" src="css/img/tipos-tela-4.jpg" idConteudo="0" tipo="4"/></td>
								</tr>
								<tr>
									<td><img class="thumb-tipo" src="css/img/tipos-tela-5.jpg" idConteudo="0" tipo="5"/></td>
									<td><img class="thumb-tipo" src="css/img/tipos-tela-6.jpg" idConteudo="0" tipo="6"/></td>
									<td><img class="thumb-tipo" src="css/img/tipos-tela-7.jpg" idConteudo="0" tipo="7"/></td>
									<td><img class="thumb-tipo" src="css/img/tipos-tela-8.jpg" idConteudo="0" tipo="8"/></td>
								</tr>
							</table>
						</div>
					</div>
					<br>
					<button id="botao-excluirTela">Excluir</button> <button id="botao-guardar">Guardar</button><br>

				</div>
				<div id="loading">
					<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				<h2 id="botao-verComandos">Ver atalhos/comandos</h2>
			</td>
			<td></td>
		</tr>
		<tr><tr><td colspan="2" style="height: 1px;"><input type="file" id="picker-arquivo" accept=".avi,.mp4,.jpg,.jpeg,.png,.gif" style="opacity: 0"/> </td></tr>		<tr>
	</table>
	<div id="comandos">
		<table class="comandos">
			<tr>
				<td>
					Enviar conteúdo para o bloco
				</td>
				<td>
					<img src="css/img/mouse_esquerdo.png" class="icone">
				</td>
			</tr>
			<tr>
				<td>
					Excluir conteúdo do bloco
				</td>
				<td>
					<img src="css/img/mouse_direito.png" class="icone">
				</td>
			</tr>
			<tr>
				<td>
					Fazer download do conteúdo do bloco
				</td>
				<td>
					<img src="css/img/botao_shift.png" class="icone"> <img src="css/img/botao_mais.png" class="icone"> <img src="css/img/mouse_esquerdo.png" class="icone">
				</td>
			</tr>
			<tr>
				<td>
					Copia conteúdo de um bloco para o outro
				</td>
				<td>
					<img src="css/img/botao_ctrl.png" class="icone"> <img src="css/img/botao_mais.png" class="icone"> <img src="css/img/mouse_esquerdo.png" class="icone"> <img src="css/img/botao_mais.png" class="icone"> <img src="css/img/mouse_esquerdo.png" class="icone">
				</td>
			</tr>
		</table>
		<button id="botao-fecharComandos">Fechar Janela</button>
	</div>

	
	<script type="text/javascript" src="js/jq.js<?php  echo $cacheFix; ?>"></script>
	<script type="text/javascript" src="js/principal.js<?php  echo $cacheFix; ?>"></script>
</body>
</html>