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
			Swal.fire({
				type: 'warning',
				title: 'Oops...',
				html: 'O campo <b>nome</b> é obrigatório.'
			});

	    }else if( email.trim() == '' ){
	        Swal.fire({
				type: 'warning',
				title: 'Oops...',
				html: 'O campo <b>e-mail</b> é obrigatório.'
			});

	    }else if( phone.trim() == '' ){
	        Swal.fire({
				type: 'warning',
				title: 'Oops...',
				html: 'O campo <b>telefone</b> é obrigatório.'
			});

	    }else if( subject.trim() == '' ){
	        Swal.fire({
				type: 'warning',
				title: 'Oops...',
				html: 'O campo <b>assunto</b> é obrigatório.'
			});

	    }else if( message.trim() == '' ){
	        Swal.fire({
				type: 'warning',
				title: 'Oops...',
				html: 'O campo <b>mensagem</b> é obrigatório.'
			});

	    }else{
	        $('#contact_form button').html('Enviando...');
	    	let content = `
	    		<h2 style="color:#c5a47e">Formulário de Contato - Nome aqui</h2>
	    		<p>
	    			<b>Nome:</b> ${name} <br>
	    			<b>E-mail:</b> ${email} <br>
	    			<b>Telefone:</b> ${phone} <br>
	    			<b>Assunto:</b> ${subject} <br>
	    		</p>
	    		<p>
	    			<b>Mensagem:</b><br> ${message}
	    		</p>
	    		<small>Enviado pelo através do site.</small>
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
	                    
				    	Swal.fire({
						    title: 'Enviado!',
						    text: 'Sua mensagem foi enviada com sucesso.',
						    type: 'success',
						    confirmButtonText: 'Fechar'
						});
				    }else {
	                    $('#contact-form button').html('Enviar Novamente');
	                    Swal.fire({
						    title: 'Oops!',
						    text: 'Ocorreu um erro ao tentar enviar sua mensagem.',
						    type: 'error',
						    confirmButtonText: 'Fechar'
						});
				    }
			    }
			});
	    }
	});
