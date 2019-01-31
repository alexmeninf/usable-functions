	/*----------  comment facebook plugin  ----------*/
	// função para manipular a largura do PlugIn de comentários do Facebook
	function fluidComments() {
	var $myWrap = $('.comment-box');     // elemento wrapper dos comentários
	width   = $myWrap.width();       // recolhemos a largura em pixeis

	// passamos a largura para o Facebook
	$('.fb-comments').attr("data-width", width);

	/* se existe a iFrame é porque não é o primeiro carregamento
	* e também precisas de a actualizar
	*/
	if ($(".fb-comments > span > iframe").length ==1)
	FB.XFBML.parse(); // indicação ao código do Facebook para se actualizar
	}

	// Correr quando o DOM está pronto
	$(function() {
		fluidComments();
	});

	/* Monitorizar o progresso do "resize" para saber se acabou
	* e assim chamar a função que manipula a largura
	*/
	var progresso;
	window.onresize = function(){
		clearTimeout(progresso);
		progresso = setTimeout(fluidComments, 100);
	};
