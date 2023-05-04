<?php
	require_once("funcoes.php");
	$telas = getTelas();
?>
<html>
<head>
	<title>Telão</title>
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