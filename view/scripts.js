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
	setInterval(atualizarTudo,1500000);

	window.paginaAtual = 1;
});

function atualizarTudo(){
	window.location.href = window.location.href;
}

function togglePaginas(){
	clearTimeout(window.timeoutAtual);
	console.log(window.paginaAtual)
		// Ordem da avaliacao
		updateDados();
		$("#Graficos").fadeIn(window.tFadeIn);
		$("#SegGraficos").fadeIn(window.tFadeIn);
		$("#GraficosFinais").fadeIn(window.tFadeIn);



}

function resetVideos(){
	var itep1 = document.getElementById("videoItep2");
	var itep2 = document.getElementById("videoItep3");
	var redbull = document.getElementById("redbull4k");
	itep1.currentTime = itep2.currentTime = 0;
	redbull.currentTime = 5;


}
function reseatVideos(){

	document.getElementById('videoItep1').addEventListener('loadedmetadata', function() {
		this.currentTime = 1;
	}, false);
	document.getElementById('videoItep2').addEventListener('loadedmetadata', function() {
		this.currentTime = 1;
	}, false);
	document.getElementById('videoItep3').addEventListener('loadedmetadata', function() {
		this.currentTime = 1;
	}, false);
	document.getElementById('videoItep4').addEventListener('loadedmetadata', function() {
		this.currentTime = 1;
	}, false);

}
function updateDados(){
	$.getJSON('graduacao.php', function(json) {
	  	resetCanvas("alunosGraduacao","Principal-05");
		var ctx = $("#alunosGraduacao").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});

	$.getJSON('posgraduacao.php', function(json) {
	  	resetCanvas("alunosPosGraduacao","Principal-10");
		var ctx = $("#alunosPosGraduacao").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});

	$.getJSON('professores.php', function(json) {
	  	resetCanvas("docentes","Principal-09");
		var ctx = $("#docentes").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});
}

function updateDados2(){
	
	$.getJSON('funcionarios.php', function(json) {
	  	resetCanvas("tecAdministrativos","SegPrincipal-05");
		var ctx = $("#tecAdministrativos").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});

	$.getJSON('funcionarios2.php', function(json) {
	  	resetCanvas("tecAdministrativos2","SegPrincipal-10");
		var ctx = $("#tecAdministrativos2").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});

	$.getJSON('gestores.php', function(json) {
	  	resetCanvas("gestores","SegPrincipal-09");
		var ctx = $("#gestores").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});
}

function updateDados3(){
	
	$.getJSON('dadosFinaisUFSM.php', function(json) {
	  	resetCanvas("graficoDadosUFSM","FimPrincipal-05");
		var ctx = $("#graficoDadosUFSM").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});

	$.getJSON('dadosFinaisCT.php', function(json) {
	  	resetCanvas("graficoDadosCT","FimPrincipal-10");
		var ctx = $("#graficoDadosCT").get(0).getContext("2d");
		new Chart(ctx).HorizontalBar(json,window.graphOptions);
	});
	$("#tabelaFinal").load("tabelaFinal.php");
}


function resetCanvas(id,idPai){
  $("#"+id).remove(); // this is my <canvas> element
  $("#"+idPai).append('<canvas id="'+id+'" width="1600" height="800"><canvas>');
};
