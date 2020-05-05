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

		 let url = window.location.href,
		  host = window.location.host,
		  content = "";
		let wrap =
		  'style="max-width: 600px;margin: 0 auto;font-family:Roboto,Google Sans,Helvetica,Arial,sans-serif;"',
		  card =
		  'style="border:1px solid #dedede;border-radius:20px;overflow:hidden"',
		  header =
		  'style="padding:15px;background: #fff;text-align: center;"',
		  info =
		  'style="padding: 20px 50px 50px;font-size:16px;border-top:1px solid #ddd"',
		  title =
		  'style="color:#3c3c3b;font-size: 30px;font-weight: 800;margin: 20px 0 40px 0;font-family: Google Sans,Roboto,Helvetica,Arial,sans-serif;"',
		  subtitle = 'style="font-weight: 200;margin-top: 40px;"',
		  footer =
		  'style="margin-top: 30px;font-size: 13px;text-align:center;color: #666767"',
		  year = new Date().getFullYear(),
		  linkColor = 'style="color: #2f2e2e;text-decoration:none"';
		content = `
	      <html>
		<head>
		  <meta name="viewport" content="width=device-width, initial-scale=1.0">    
		</head>
		<body>
		  <div ${wrap}>
		    <div ${card}>
		      <div>
			<div ${header}>
			  <a href="#">
			    <img src="/logo.png" style="width:auto;height: 38px;">
			  </a>
			</div>

			<div ${info}>
			  <h2 ${title}>Titulo aqui</h2>
			   <p>Subtítulo aqui</p>
			  <h2 ${subtitle}>Informações recebidas</h2>
			  <p><b>Nome:</b> ${name}</p>
			  <p style="margin-bottom:0!important"><b>E-mail:</b> ${email}</p>
			</div>
		      </div>
		    </div>

		    <div ${footer}>
		      <p>E-mail recebido através da página do site: <a href="${url}" target="_blank" ${linkColor}>${host}</a>.</p>
		      <p>&copy; ${year} Empresa.</p>
		    </div>
		  </div>
		</body>
	      </html>`;
		
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
