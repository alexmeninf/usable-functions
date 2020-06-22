  formContact = () => {
    /*----------  SEND CONTACT  ----------*/
    let formSelector = '#contact-form',
      btnForm = 'button[type=submit]';

    $(formSelector).on('submit', function () {
      // Get values
      var name = $('#input_name').val(),
        email = $('#input_email').val(),
        phone = $('#input_phone').val(),
        subject = $('#input_subject').val(),
        message = $('#input_message').val(),
        siteName = $('#input_site_name').val(); // required field

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

      } else if (phone.trim() == '') {
        Swal.fire({
          type: 'warning',
          title: 'Oops...',
          html: 'O campo <b>telefone</b> é obrigatório.'
        });

      } else if (subject.trim() == '') {
        Swal.fire({
          type: 'warning',
          title: 'Oops...',
          html: 'O campo <b>assunto</b> é obrigatório.'
        });

      } else if (message.trim() == '') {
        Swal.fire({
          type: 'warning',
          title: 'Oops...',
          html: 'O campo <b>mensagem</b> é obrigatório.'
        });

      } else {

        let url = window.location.href,
          host = window.location.host,
          wrap = 'style="max-width: 600px;margin: 0 auto;font-family:Roboto,Google Sans,Helvetica,Arial,sans-serif;"',
          card = 'style="border:1px solid #dedede;border-radius:20px;overflow:hidden"',
          header = 'style="padding:15px;background: #fff;text-align: center;"',
          imgHeader = 'style="height:45px;width:auto;display:block;margin:0 auto;"',
          infoContent = 'style="padding: 20px 50px 50px;font-size:16px;border-top:1px solid #ddd"',
          title = 'style="color:#3c3c3b;font-size: 30px;font-weight: 800;margin: 20px 0 40px 0;font-family: Google Sans,Roboto,Helvetica,Arial,sans-serif;"',
          subtitle = 'style="font-weight: 200;margin-top: 40px;"',
          footer = 'style="margin-top: 30px;font-size: 13px;text-align:center;color: #666767"',
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
                    <img src="LOGO_EMPRESA" ${imgHeader}>
                  </a>
                </div>
                
                <div ${infoContent}>
                 <h2 ${title}>Título aqui</h2>
                  <p>Subtítulo aqui</p>
                  <h2 ${subtitle}>Informações recebidas</h2>
                  <p><b>Nome:</b> ${name}</p>
                  <p><b>E-mail:</b> ${email}</p>
                  <p><b>Telefone:</b> ${phone}</p>
                  <p><b>Assunto:</b> ${subject}</p>
                  <p style="margin-bottom:0!important"><b>Mensagem:</b> ${message}</p>
                </div>
              </div>
            </div>
      
            <div ${footer}>
              <p>E-mail recebido através da página do site: <a href="${url}" target="_blank" ${linkColor}>${host}</a>.</p>
              <p>Obs: E-mail automático, ao respondê-lo não será possível retornarmos.</p>
              <p>&copy; ${year}, ${siteName}.</p>
            </div>
          </div>
        </body>
      </html>`;

        $.ajax({
          url: 'https://mailsender.dvulgsolucoes.com.br/api/email/send',
          method: 'POST',
          data: {
            request: siteName,
            from: 'alex.menin11@gmail.com',
            to: email,
            subject: subject ? subject : 'Dados recebidos do site ' + siteName,
            message: content,
            beforeSend: () => {
              $(btnForm, this).html('Enviando...');
            }
          },
          success: (response) => {
            let data = JSON.parse(response);

            if (data.success) {
              clear_form_elements($(this));
              $(btnForm, this).html('Enviar');

              Swal.fire({
                title: 'Enviado!',
                text: 'Sua mensagem foi enviada com sucesso.',
                type: 'success',
                confirmButtonText: 'Fechar'
              });

            } else {
              $(btnForm, this).html('Tentar Novamente');
              
              Swal.fire({
                title: 'Oops!',
                text: 'Ocorreu um erro ao tentar enviar sua mensagem.',
                type: 'error',
                confirmButtonText: 'Fechar'
              });
            }
          } // success
        }); // $.ajax
      } // else
    }); // on submit

    function clear_form_elements(parentClass) {
      $(parentClass).find(':input').each(function () {
        switch (this.type) {
          case 'password':
          case 'text':
          case 'textarea':
          case 'file':
          case 'select-one':
          case 'select-multiple':
          case 'date':
          case 'number':
          case 'tel':
          case 'email':
            $(this).val('');
            break;
          case 'checkbox':
          case 'radio':
            this.checked = false;
            break;
        }
      });
    }
  }

  formContact();
