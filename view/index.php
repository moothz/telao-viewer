<?php
require_once("funcoes.php");
$telas = getTelas();
//print_r($telas);


?>
<html>
<head>
	<title>Telão CT</title>
	<!-- <meta http-equiv="refresh" content="0; url=http://farol.ufsm.br/transmissao/aovivo/430-transmissao-ao-vivo-debate-eleicoes-ufsm-19062017-10h"> -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="estilos.css" type="text/css" />
	<link rel="stylesheet" href="estilosAvaliacao.css" type="text/css" />
	<script type="text/javascript" src="jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="chart.js"></script>

	<script type="text/javascript">
	function resetCanvas(id){
		var elementoPai = $("#"+id).parent();
		$("#"+id).remove(); // this is my <canvas> element
		elementoPai.append('<canvas id="'+id+'" width="1800" height="800"><canvas>');
	};

	$(document).keypress(function(e) {
	    if(e.which == 13) {
	    	console.log("Trocando página...");
			togglePaginas();
		}
	});
		$(document).ready(function(){
			window.graphOptions = {
				scaleLineColor: "rgba(255,255,255,.5)",
				scaleOverride: true,
				scaleSteps: 2,
				scaleStepWidth: 50,
				scaleStartValue: 0,
				scaleLineWidth: 2,
				scaleLabel: "<%=value%>%",
				scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
				scaleFontSize: 40,
				scaleFontStyle: "normal",
				scaleFontColor: "rgba(10,10,10,.6)"
			}

			window.tFadeOut = 800;
			window.tFadeIn = 800;
			window.timeoutAtual = setTimeout(togglePaginas,500);
			setInterval(atualizarTudo,3600000);

			window.paginaAtual = 1;
		});

		function atualizarTudo(){
			console.log(atualizarTudo);
			window.location.href = window.location.href;
		}

		function togglePaginas(){
			console.log("[togglePaginas]");
			for(var i=0; i<$("video").length;i++){
				$("video").get(i).currentTime = 0;
			}

			clearTimeout(window.timeoutAtual);
			console.log(window.paginaAtual);
			
			switch(window.paginaAtual){
				/*
				//Fixo para mostrar resultados da auto avaliaca
				case 1:
					$('.container').fadeOut(window.tFadeOut);
					$("#autoavaliacao-graficos1").fadeIn(window.tFadeIn);


					$.getJSON('dadosAvaliacao/graduacao.php', function(json) {
						resetCanvas("alunosGraduacao");
						var ctx = $("#alunosGraduacao").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});

					$.getJSON('dadosAvaliacao/posgraduacao.php', function(json) {
						resetCanvas("alunosPosGraduacao");
						var ctx = $("#alunosPosGraduacao").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});

					$.getJSON('dadosAvaliacao/professores.php', function(json) {
						console.log(json);
						resetCanvas("docentes");
						var ctx = $("#docentes").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});


					console.log("1 - Graficos 1");
					window.timeoutAtual = setTimeout(togglePaginas,20000);
					break;

				case 2:
					$('.container').fadeOut(window.tFadeOut);
					$("#autoavaliacao-graficos2").fadeIn(window.tFadeIn);

					$.getJSON('dadosAvaliacao/funcionarios.php', function(json) {
						resetCanvas("tecAdministrativos");
						var ctx = $("#tecAdministrativos").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});

					$.getJSON('dadosAvaliacao/funcionarios2.php', function(json) {
						resetCanvas("tecAdministrativos2");
						var ctx = $("#tecAdministrativos2").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});

					$.getJSON('dadosAvaliacao/gestores.php', function(json) {
						resetCanvas("gestores");
						var ctx = $("#gestores").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});

					console.log("2 - Graficos 2");
					window.timeoutAtual = setTimeout(togglePaginas,20000);
					break;
					
				case 3:
					$('.container').fadeOut(window.tFadeOut);
					$("#autoavaliacao-graficos3").fadeIn(window.tFadeIn);

					$.getJSON('dadosAvaliacao/dadosFinaisUFSM.php', function(json) {
						resetCanvas("graficoDadosUFSM");
						var ctx = $("#graficoDadosUFSM").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});

					$.getJSON('dadosAvaliacao/dadosFinaisCT.php', function(json) {
						resetCanvas("graficoDadosCT");
						var ctx = $("#graficoDadosCT").get(0).getContext("2d");
						new Chart(ctx).HorizontalBar(json,window.graphOptions);
					});

					console.log("3 - Graficos 3");
					window.timeoutAtual = setTimeout(togglePaginas,20000);
					break;
					*/
				<?php
				$i = 1;
				$anterior = end($telas);
				
				foreach ($telas as $tela) {
					echo "\n\t\t\t\tcase $i:\n";
					// echo "\t\t\t\t\t$('#conteudo_tela_".$anterior["id"]."').fadeOut(window.tFadeOut);\n";
					echo "\t\t\t\t\t$('.container').fadeOut(window.tFadeOut);\n";
					echo "\t\t\t\t\t$('#conteudo_tela_".$tela["id"]."').fadeIn(window.tFadeIn);\n";
					echo "\t\t\t\t\tconsole.log('".$tela["id"]." - ".$tela["descricao"]."');\n";
					echo "\t\t\t\t\twindow.timeoutAtual = setTimeout(togglePaginas,".$tela["duracao"]."000);\n";
					echo "\t\t\t\t\tbreak;\n";
					$anterior = $tela["id"];
					$i++;
				}
				
				?>
			}

			window.paginaAtual++;
			if(window.paginaAtual > <?php echo count($telas); ?>){
				window.paginaAtual = 1;
			}
		}
	</script>
</head>
<body style="background-color:#FFFFFF; margin-top: 0px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px;">
<!--
<div id="autoavaliacao-graficos1" class="containerGraficos container">
	<img src="enfeiteAvaliacao.png" class="enfeiteAvaliacao" />
	<div class="containerTituloGrafico top-left"></div>
	<div class="containerGrafico top-left">
		
	</div>
	<div class="containerTituloGrafico top-right">Discentes Graduação</div>
	<div class="containerGrafico top-right">
		<canvas id="alunosGraduacao" width="1800" height="800"></canvas>
		
	</div>
	<div class="containerTituloGrafico bottom-left">Docentes</div>
	<div class="containerGrafico bottom-left">
		<canvas id="docentes" width="1800" height="800"></canvas>
	</div>
	<div class="containerTituloGrafico bottom-right">Discentes Pós-Graduação</div>
	<div class="containerGrafico bottom-right">
		<canvas id="alunosPosGraduacao" width="1800" height="800"></canvas>
	</div>

</div>

<div id="autoavaliacao-graficos2" class="containerGraficos container">
	<img src="enfeiteAvaliacao.png" class="enfeiteAvaliacao" />
	<div class="containerTituloGrafico top-left"></div>
	<div class="containerGrafico top-left">
		
	</div>
	<div class="containerTituloGrafico top-right">Técnicos Administrativos</div>
	<div class="containerGrafico top-right">
		<canvas id="tecAdministrativos" width="1800" height="800"></canvas>
		
	</div>
	<div class="containerTituloGrafico bottom-left">Gestores</div>
	<div class="containerGrafico bottom-left">
		<canvas id="gestores" width="1800" height="800"></canvas>
	</div>
	<div class="containerTituloGrafico bottom-right">Técnicos Administrativos</div>
	<div class="containerGrafico bottom-right">
		<canvas id="tecAdministrativos2" width="1800" height="800"></canvas>
	</div>

</div>

<div id="autoavaliacao-graficos3" class="containerGraficos container">

	<div class="containerTituloGrafico top-left"></div>
	<div class="containerGrafico top-left">
		
	</div>
	<div class="containerTituloGrafico top-right"></div>
	<div class="containerGrafico top-right">
		
		
	</div>
	<div class="containerTituloGrafico bottom-left"></div>
	<div class="containerGrafico bottom-left">
		<canvas id="graficoDadosUFSM" width="1800" height="900"></canvas>
	</div>
	<div class="containerTituloGrafico bottom-right"></div>
	<div class="containerGrafico bottom-right">
		<canvas id="graficoDadosCT" width="1800" height="800"></canvas>
	</div>

</div>
-->
<?php
foreach ($telas as $tela) {
	echo "<!-- Exibindo conteudo da tela '".$tela["descricao"]."' -->\n";
	echo "\t<div class='container' id='conteudo_tela_".$tela["id"]."' style='display:none'>\n";
	switch ($tela["tipo"]) {
		case 1:
		$cont1 = getConteudoFromTelaRaw($tela["id"],0);
		switch($cont1["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont1["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont1["posicao"].'" src="'.$cont1["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont1["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont1["posicao"].'" autoplay muted loop><source src="'.$cont1["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		break;
//".base64_encode($imagemMapa)
		case 2:
		$cont1 = getConteudoFromTelaRaw($tela["id"],0);
		$cont2 = getConteudoFromTelaRaw($tela["id"],1);
		$cont3 = getConteudoFromTelaRaw($tela["id"],2);
		$cont4 = getConteudoFromTelaRaw($tela["id"],3);
		switch($cont1["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont1["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont1["posicao"].'" src="'.$cont1["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont1["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont1["posicao"].'" autoplay muted loop><source src="'.$cont1["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		switch($cont2["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont2["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont2["posicao"].'" src="'.$cont2["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont2["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont2["posicao"].'" autoplay muted loop><source src="'.$cont2["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		switch($cont3["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont3["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont3["posicao"].'" src="'.$cont3["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont3["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont3["posicao"].'" autoplay muted loop><source src="'.$cont3["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		switch($cont4["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont4["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont4["posicao"].'" src="'.$cont4["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont4["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont4["posicao"].'" autoplay muted loop><source src="'.$cont4["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		break;

		case 3:
		case 4:
		case 5:
		case 6:
		$cont1 = getConteudoFromTelaRaw($tela["id"],0);
		$cont2 = getConteudoFromTelaRaw($tela["id"],1);
		$cont3 = getConteudoFromTelaRaw($tela["id"],2);
		switch($cont1["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont1["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont1["posicao"].'" src="'.$cont1["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont1["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont1["posicao"].'" autoplay muted loop><source src="'.$cont1["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		switch($cont2["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont2["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont2["posicao"].'" src="'.$cont2["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont2["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont2["posicao"].'" autoplay muted loop><source src="'.$cont2["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		switch($cont3["tipo"]){
			case 1: // Imagem
				echo "\t\t".'<img id="conteudo_tela_'.$tela["id"].'_'.$cont3["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont3["posicao"].'" src="'.$cont3["dados"].'"/>'."\n";
				break;
			case 2: // Video
				echo "\t\t".'<video id="conteudo_tela_'.$tela["id"].'_'.$cont3["id"].'" class="tipo_'.$tela["tipo"].'_posicao_'.$cont3["posicao"].'" autoplay muted loop><source src="'.$cont3["dados"].'" type="video/mp4"></video>'."\n";
				break;
		}
		break;

	}
	echo "\t</div>\n";
}
?>

<audio autoplay>
<source src="kalimba.mp3" type="audio/mpeg">
</audio>
</body>
</html>

<!-- 





 -->