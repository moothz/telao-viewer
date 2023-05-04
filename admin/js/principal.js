$(document).ready(function(){
	atualizarListaTelas();

	// Seletor da Tela sendo editada atualmente ou criando nova
	$("#seletor-tela").change(function(){
		var idTela = $("#seletor-tela").val();
		if(idTela > 0){
			loadTela(idTela);
			$("#dadosTela").show();
		} else {
			selecionarTipoExibicao(1);
			$("#dadosTela").hide();
		}
	});

	// Comandos
	$("#botao-novaTela").click(novaTela);
	$("#botao-excluirTela").click(excluirTela);
	

	// Listeners pra atualizar os dados
	$("#botao-guardar").click(guardarDados);
	$("#valor-tipo").change(guardarDados);
	$("#valor-nome").change(guardarDados);
	$("#valor-duracao").change(guardarDados);
	$("#picker-arquivo").change(enviarArquivo);
	$(".overlay-branco").click(selecionarArquivo);
	$(".overlay-branco").contextmenu(excluirConteudo);


	// Seleção do tipo de Tela
	$("#botao-escolher-tipo").click(function(){
		$("#seletor-tipo").fadeToggle(100);
	});
	$(".thumb-tipo").click(function(){
		$(".thumb-tipo").removeClass("selecionado");
		$(this).addClass("selecionado");
		var tipo = $(this).attr("tipo");
		console.log(tipo);

		$("#valor-tipo").val(tipo);
		selecionarTipoExibicao(tipo);

		$("#seletor-tipo").fadeOut(50);

		guardarDados();
	});

	// Ação duplicar conteúdo
	window.shiftPressionado = false;
	window.ctrlPressionado = false;
	window.idConteudoCopiado = 0;

	// Ajuda
	$("#botao-verComandos").click(function(){
		$("#comandos").fadeToggle(200);
	});

	$("#botao-fecharComandos").click(function(){
		$("#comandos").fadeOut(200);
	});
});

$(document).keydown(function(event){
	if(event.which=="17"){
		window.ctrlPressionado = true;
	} else if(event.which == "16"){
		window.shiftPressionado = true;
	}
});

$(document).keyup(function(){
	window.ctrlPressionado = false;
	window.shiftPressionado = false;
	$("html").removeClass("copiando");
	window.idConteudoCopiado = 0;
});

function loading(s){
	if(s){
		$("#loading").show();
	} else {
		$("#loading").hide();
	}
}

function novaTela(){
	loading(true);

	$.post("php/dados.php", {acao: "novaTela"},function(d){
		loading(false);
		try{
			var resultado = $.parseJSON(d);

			// console.log(resultado);
			if(resultado.erro){
				alert(resultado.erro);
				console.log(resultado.erro);
			}
			$(".thumb").css("background-image","");
			atualizarListaTelas(resultado.tela.idTela);
		} catch(ex){
			alert(ex);
			console.log(ex);
			console.log(ex);
			console.log(d);
		}
	});
}

function excluirTela(){
	if(confirm("Tem certeza que deseja excluir esta tela?")){
		loading(true);

		var idTela = $("#seletor-tela").val();
		$.post("php/dados.php", {acao: "excluirTela", id: idTela},function(d){
			loading(false);
			try{
				var resultado = $.parseJSON(d);

				// console.log(resultado);
				if(resultado.erro){
					alert(resultado.erro);
					console.log(resultado.erro);
				} else {
					$("#dadosTela").hide();
					$(".thumb").css("background-image","");
				}

				$(".duracao-video").remove();
				selecionarTipoExibicao(1);
				atualizarListaTelas();
			} catch(ex){
				alert(ex);
				console.log(ex);
				console.log(ex);
				console.log(d);
			}
		});
	}
}

function handlerProgresso(e){
	if(e.lengthComputable){
		$("#barraProgresso").attr({value:e.loaded,max:e.total});
	}
}


function enviarArquivo(){
	loading(true);
	if($(this).val() != ""){
		$("#barraProgresso").show();
		var arquivo = new FormData();

		var idTela = $("#seletor-tela").val();

		arquivo.append("acao", "uploadArquivo");
		arquivo.append("idTela",idTela);
		arquivo.append("posicao",window.posicaoClicada);
		arquivo.append("arquivo", this.files[0]);

		$.ajax({
			url: "php/dados.php",
			 xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				if(myXhr.upload){ // Check if upload property exists
					myXhr.upload.addEventListener('progress',handlerProgresso, false); // For handling the progress of the upload
				}
				return myXhr;
			},
			data: arquivo,
			processData: false,
			contentType: false,
			type: "POST",
			success: function(data){
				try{
					if(data.indexOf("exceeds the limit") != -1){
						alert("O arquivo excede o tamanho limite (200Mb)");
						console.log("O arquivo excede o tamanho limite (200Mb)");
					}
					var resultado = $.parseJSON(data);

					if(resultado.erro){
						alert(resultado.erro);
						console.log(resultado.erro);
					}
				} catch(ex){
					alert(ex);
					console.log(ex);
					console.log(ex);
					console.log(data);
				}


				$("#picker-arquivo").val("");
				$("#barraProgresso").hide();
				loading(false);
				loadTela(idTela);
			}
		}).fail(function(data){
			alert("Erro!");
			console.log("Erro!");
			console.log(data);
			$("#barraProgresso").hide();
				loading(false);
		});
	}

}

function excluirConteudo(){
	var idTela = $("#seletor-tela").val();
	
	if(idTela > 0){
		if(confirm("Tem certeza que deseja excluir este arquivo?")){
			var idConteudo = $(this).parent().attr("idConteudo");
			loading(true);
			$.post("php/dados.php",{
				acao: "excluirConteudo",
				idConteudo: idConteudo
			}, function(d){
				try{
					var resultado = $.parseJSON(d);
					// console.log(resultado);
					if(resultado.erro){
						alert(resultado.erro);
						console.log(resultado.erro);
					}

					if(resultado.debug){
						console.log(resultado.debug);
					}

					var idTela = $("#seletor-tela").val();
					atualizarListaTelas(idTela);
					loading(false);
				} catch(ex){
					window.ctrlPressionado = false;
					loading(false);
					alert(ex);
					console.log(ex);
					console.log(ex);
					console.log(d);
				}
			});
		}
	}

	return false;
}
function selecionarArquivo(evt){
	console.log($(evt.target));
	window.posicaoClicada = $(evt.target).parent().attr("posicao");
	console.log(window.posicaoClicada);

	evt.preventDefault();
	var idTela = $("#seletor-tela").val();
	console.log(window.shiftPressionado);
	
	if(idTela > 0){
		if(window.ctrlPressionado){
			if(window.idConteudoCopiado == 0){
				$("html").addClass("copiando");
				window.idConteudoCopiado = $(this).parent().attr("idConteudo");
				// console.log(window.idConteudoCopiado);
				if(window.idConteudoCopiado == 0){
					alert("Só é possível copiar o conteúdo caso já exista um previamente!");
					console.log("Só é possível copiar o conteúdo caso já exista um previamente!");
				}
			} else {
				var idDestino = $(this).parent().attr("idConteudo");
				var posDestino = $(this).parent().attr("posicao");
				// console.log("Copiando de {0} para {1}, pos {2}".format(window.idConteudoCopiado,idDestino,posDestino));

				loading(true);
				$.post("php/dados.php",{
					acao: "duplicarConteudo",
					idConteudo: window.idConteudoCopiado,
					idDestino: idDestino,
					posDestino: posDestino
				}, function(d){
					try{
						var resultado = $.parseJSON(d);
						// console.log(resultado);
						if(resultado.erro){
							alert(resultado.erro);
							console.log(resultado.erro);
						}
						var idTela = $("#seletor-tela").val();
						atualizarListaTelas(idTela);
						loading(false);
					} catch(ex){
						window.ctrlPressionado = false;
						loading(false);
						alert(ex);
						console.log(ex);
						console.log(ex);
						console.log(d);
					}
				});
			}
		} else if(window.shiftPressionado){
			var url = $(this).parent().attr("urlConteudo");

			window.open(url, "_blank");
		} else {
			window.posicaoClicada = $(this).parent().attr("posicao");
			$("#picker-arquivo").trigger("click");
		}
	}
}

function guardarDados(){

	loading(true);

	var idTela = $("#seletor-tela").val();
	var tipo = $("#valor-tipo").val();
	var descricao = $("#valor-nome").val();
	var duracao = $("#valor-duracao").val();
	var dataLimite = $("#valor-data").val();

	// console.log("idTela: {0}\ntipo: {1}\nnome: {2}\nduracao: {3}".format(idTela,tipo,nome,duracao))

	$.post("php/dados.php", {
			acao: "updateTela",
			idTela: idTela,
			tipo: tipo,
			descricao: descricao,
			duracao: duracao,
			dataLimite: dataLimite
			},
	function(d){
		loading(false);
		try{
			var resultado = $.parseJSON(d);
			// console.log(resultado);
			if(resultado.erro){
				alert(resultado.erro);
				console.log(resultado.erro);
			}

			atualizarListaTelas(resultado.tela.idTela);
		} catch(ex){
			alert(ex);
			console.log(ex);
			console.log(ex);
			console.log(d);
		}
	});
}

function atualizarListaTelas(telaSelecionada){
	$.post("php/dados.php", {acao: "getTelas"}, function(d){
		try{
			$("#lista-expiradas option").remove();
			$("#lista-ativas option").remove();
			var totalDuracao = 0;
			var totalAtivas = 0;
			var totalExpiradas = 0;
			var telas = $.parseJSON(d);
			// console.log(telas);
			var hoje = new Date();
			telas.resultados.forEach(function(tela){
				var dataTela = new Date(tela.dataLimite);
				var t = "<option value='{0}'>{1}</option>".format(tela.id,tela.descricao);
				if(dataTela.getTime() < hoje.getTime()){
					$("#lista-expiradas").append(t);
					totalExpiradas++;
				} else {
					$("#lista-ativas").append(t);
					totalAtivas++;
					totalDuracao += parseInt(tela.duracao);
				}
			});

			var minutos = parseInt(totalDuracao/60);
			var segundos = totalDuracao - minutos*60;

			$("#lista-ativas").attr("label","Ativas ({0} telas, duração total {1}:{2} minutos)".format(totalAtivas,minutos,segundos));
			$("#lista-expiradas").attr("label","Expiradas ({0})".format(totalExpiradas));
			if(telaSelecionada){
				$("#seletor-tela").val(telaSelecionada);
				loadTela(telaSelecionada);
				$("#dadosTela").show();
			}
		} catch(ex){
			alert(ex);
			console.log(ex);
			console.log(ex);
			console.log(d);
		}
	});
}

function loadTela(id){
	$(".duracao-video").remove();
	$(".thumb").css("background-image","");
	$(".thumb").attr("idConteudo","0");
	$("#seletor-tipo").fadeOut(50);
	$.post("php/dados.php", {acao: "getTela", id: id}, function(d){
		try{
			var dados = $.parseJSON(d);
			var tipoTela = dados.tela.tipo;
			var conteudo = dados.tela.conteudo;
			console.log(conteudo);
			selecionarTipoExibicao(tipoTela);

			conteudo.forEach(function(c){
				var seletorConteudo = "td[tipo='{0}'][posicao='{1}']".format(tipoTela,c.posicao);
				$(seletorConteudo).attr("idConteudo",c.idConteudo);
				var urlConteudo = "/TelaoCT/{0}".format(c.arquivo);
				$(seletorConteudo).attr("urlConteudo",urlConteudo);

				console.log($(seletorConteudo),seletorConteudo,c.idConteudo,urlConteudo);	

				var caminhoThumb = "";
				if(c.tipo == 1){
					caminhoThumb = c.arquivo.split(".");
					caminhoThumb = caminhoThumb[0]+"_thumb.jpg";
					$(seletorConteudo).css("background-image","url('../TelaoCT/{0}')".format(caminhoThumb));
				} else {
					caminhoThumb = c.arquivo.split(".");
					caminhoThumb = caminhoThumb[0]+"_thumb.gif";
					$(seletorConteudo).css("background-image","url('../TelaoCT/{0}')".format(caminhoThumb));
					$(seletorConteudo).append("<span class='duracao-video'>{0}s</span>".format(c.duracaoVideo));
				}

				console.log(seletorConteudo,c.idConteudo,urlConteudo,caminhoThumb);	


			});
			
			$("#valor-tipo").val(tipoTela);
			$("#valor-nome").val(dados.tela.descricao);
			$("#valor-data").val(dados.tela.dataLimite);
			$("#valor-duracao").val(dados.tela.duracao);
			$(".thumb-tipo").removeClass("selecionado");
			$(".thumb-tipo[tipo='{0}']".format(tipoTela)).addClass("selecionado");


			// console.log(dados);
		} catch(ex){
			alert(ex);
			console.log(ex);
			console.log(ex);
			console.log(d);
		}
	});
}

function selecionarTipoExibicao(tipo){
	// $(".container-tv").fadeOut(150);
	// $("#tipo-visualizacao-"+tipo).fadeIn(100);
	$(".container-tv").hide();
	$("#tipo-visualizacao-"+tipo).show();

}

if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}