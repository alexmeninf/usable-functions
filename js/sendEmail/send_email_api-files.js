/*----------  SEND CURRICULO  ----------*/
$('#NAME_HERE').on('submit', function () {
	// Get values
	var name = $('#form_name').val();
	var email = $('#form_email').val();
	var file = $('#form_file')[0].files[0];

	// Validate values
	if (name.trim() == '') {
		Swal.fire({
			type: 'warning',
			title: 'Oops...',
			html: 'O campo <b>nome</b> é obrigatório.'
		});

	} else if (email.trim() == '') {
		Swal.fire({
			type: 'warning',
			title: 'Oops...',
			html: 'O campo <b>e-mail</b> é obrigatório.'
		});

	} else if ($('#form_file')[0].files.length === 0) {
		Swal.fire({
			type: 'warning',
			title: 'Oops...',
			html: 'O campo <b>arquivo</b> é obrigatório.'
		});

	} else {
		$('#NAME_HERE button').html('Enviando...');

		var url = window.location.href; // Returns full URL (https://example.com/path/example.php)

		let subject = 'Exemplo de envio';

		let content = `
			<div style="max-width:550px;border:1px solid #dedede;border-radius:22px;margin:0 auto;padding:30px 35px;display:flex;align-items:center;justify-content:center;">
			<div>
				<h2 style="color:#2196f3;font-size:25px;margin-bottom:20px;">
					Formulário de Contato - NOME EMPRESA
				</h2>
				<p>
					<b style="font-size:16px">Nome:</b> ${name} <br>
					<b style="font-size:16px">E-mail:</b> ${email} <br>
				</p><hr>
				<small style="font-size:12px;color:#595959;">E-mail enviado através da página do site <b><a href="${url}" target="_blank">${url}</a><b>.</small>
			</div>
		</div>
		`;

		let myData = new FormData();
		myData.append('request', 'Local');
		myData.append('from', email);
		myData.append('to', 'exemple@gmail.com');
		myData.append('subject', subject);
		myData.append('message', content);
		myData.append('files[]', file, file.name);

		$.ajax({
			url: 'https://mailsender.dvulgsolucoes.com.br/api/email/send',
			method: 'POST',
			processData: false,
			contentType: false,
			data: myData,
			success: function (response) {
				console.log(response);
				let data = JSON.parse(response);

				if (data.success) {
					$('#form_name').val("");
					$('#form_email').val("");
					$('#form_file').val(null);
					$('#NAME_HERE button').html('Enviar');

					Swal.fire({
						title: 'Enviado!',
						text: 'Sua mensagem foi enviada com sucesso.',
						type: 'success',
						confirmButtonText: 'Fechar'
					});
				} else {
					$('#NAME_HERE button').html('Enviar Novamente');
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