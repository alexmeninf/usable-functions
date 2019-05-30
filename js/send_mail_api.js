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
		    title: 'Oops! ',
		    message: 'O campo <b>nome</b> é obrigatório.',
		    position: 'topRight'
		});

    }else if( email.trim() == '' ){
        iziToast.warning({
		    title: 'Oops! ',
		    message: 'O campo <b>e-mail</b> é obrigatório.',
		    position: 'topRight'
		});

    }else if( phone.trim() == '' ){
        iziToast.warning({
		    title: 'Oops! ',
		    message: 'O campo <b>telefone</b> é obrigatório.',
		    position: 'topRight'
		});

    }else if( subject.trim() == '' ){
        iziToast.warning({
		    title: 'Oops! ',
		    message: 'O campo <b>assunto</b> é obrigatório.',
		    position: 'topRight'
		});

    }else if( message.trim() == '' ){
        iziToast.warning({
		    title: 'Oops! ',
		    message: 'O campo <b>mensagem</b> é obrigatório.',
		    position: 'topRight'
		});

    }else{
        $('#contact_form button').html('Enviando...');

        var url = window.location.href; // Returns full URL (https://example.com/path/example.php)
    	let content = `
    		<div style="max-width:550px;border:1px solid #dedede;border-radius:22px;margin:0 auto;padding:30px 35px;display:flex;align-items:center;justify-content:center;">
				<div>
					<h2 style="color:#2196f3;font-size:25px;margin-bottom:20px;">
						Formulário de Contato - Nome site
					</h2>
					<p>
						<b style="font-size:16px">Nome:</b> ${name} <br>
						<b style="font-size:16px">E-mail:</b> ${email} <br>
						<b style="font-size:16px">Telefone:</b> ${phone} <br>
						<b style="font-size:16px">Assunto:</b> ${subject} <br>
					</p>
					<p>
						<b style="margin-bottom:20px;font-size:16px">Mensagem:</b><br> ${message}
					</p><hr>
					<small style="font-size:12px;color:#595959;">E-mail enviado através da página do site <b><a href="${url}" target="_blank">${url}</a><b>.</small>
				</div>
			</div>
    	`;

        $.ajax({
		    url: 'https://mailsender.dvulgsolucoes.com.br/api/email/send',
		    method: 'POST',
		    data: { request:'Local', from:email, to:'exemple@gmail.com', subject:subject, message:content },
		    success: function(response){
		        let data = JSON.parse(response);

		    	if( data.success ) {
		    		$('#form_name').val("");
					$('#form_email').val("");
					$('#form_phone').val("");
					$('#form_subject').val("");
					$('#form_message').val("");
                    $('#contact_form button').html('Enviar <i class="icon-next"></i>');

			    	iziToast.success({
					    title: 'Mensagem enviada com sucesso!',
					    position: 'topRight',
					    timeout: 10500
					});
			    }else {
                    $('#contact-form button').html('Enviar Novamente');
                    iziToast.danger({
					    title: 'Oops! Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde.',
					    position: 'topRight',
					    timeout: 10500
					});
			    }
		    }
		});
    }
});
