/*----------  SEND CONTACT  ----------*/
$('#contact_form').on('submit', function(){
    // Get values
    var name        = $('#form_name').val();
    var email       = $('#form_email').val();
    var phone       = $('#form_phone').val();
    var subject     = $('#form_subject').val();
    var message     = $('#form_message').val();
    // Validate values
    if( name.trim() == '' ){
	iziToast.warning({
	    title: 'Atenção!',
	    message: 'Insira o seu nome.',
	    position: 'topRight'

	});

    }else if( email.trim() == '' ){
	iziToast.warning({
	    title: 'Atenção!',
	    message: 'Insira seu e-mail.',
	    position: 'topRight'
	});

    }else if( phone.trim() == '' ){
	iziToast.warning({
	    title: 'Atenção!',
	    message: 'Insira seu telefone.',
	    position: 'topRight'
	});

    }else if( subject.trim() == '' ){
	iziToast.warning({
	    title: 'Atenção!',
	    message: 'Insira o assunto de envio.',
	    position: 'topRight'
	});

    }else if( message.trim() == '' ){
	iziToast.warning({
	    title: 'Atenção!',
	    message: 'Escreva sua mensagem.',
	    position: 'topRight'
	});

    }else{
	$('#contact_form button').html('Enviando...');
	let content = `
		<h2 style="color:#002a4e">Formulário de Contato</h2>
		<p>
			<b>Nome:</b> ${name} <br>
			<b>E-mail:</b> ${email} <br>
			<b>Telefone:</b> ${phone} <br>
			<b>Assunto:</b> ${subject} <br>
		</p>
		<p>
			<b>Mensagem:</b><br> ${message}
		</p>
	`;

	$.ajax({
		    url: 'https://mailsender.dvulgsolucoes.com.br/api/email/send',
		    method: 'POST',
		    data: { request:'Local', from:email, to:'exemplo@gmail.com', subject:subject, message:content },
		    success: function(response){
			let data = JSON.parse(response);

			if( data.success ) {
				$('#form_name').val("");
				$('#form_email').val("");
				$('#form_phone').val("");
				$('#form_subject').val("");
				$('#form_message').val("");

		    $('#contact_form button').html('Enviar');
				iziToast.success({
				    title: 'Mensagem enviada com sucesso! ',
				    position: 'topRight',
				    timeout: 10500
				});
			    }else {
		    $('#contact_form button').html('Enviar Novamente');
				iziToast.danger({
				    title: 'Ops! Ocorreu um erro ao tentar enviar sua mensagem. ',
				    position: 'topRight',
				    timeout: 10500
				});
			    }
		    }
		});
    }
});
