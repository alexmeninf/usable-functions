
const form = document.forms.form447;
const isRequired = [];
const NAME_REQUIRED = "Este campo é obrigatório";
const EMAIL_REQUIRED = "Seu e-mail é obrigatório";
const EMAIL_INVALID = "Por favor, forneça um e-mail com formado valido.";

// Remover atributo required para validação do script
for (let i = 0; i < form.elements.length; i++) {
  isRequired.push(form.elements[i].required);
  form.elements[i].required = false;
}

form.addEventListener("submit", function (event) {
  // stop form submission
  event.preventDefault();

  let elems = [], result;
  for (let i = 0; i < form.elements.length; i++) {
    if (form.elements[i].type !== 'submit') {
      if (form.elements[i].name == 'email') {
        result = validateEmail(form.elements[i], EMAIL_REQUIRED, EMAIL_INVALID, isRequired[i]);
      } else {
        result = hasValue(form.elements[i], NAME_REQUIRED, isRequired[i]);
      }
      elems.push(result);
    }
  }
  
  // Verifica se todos os campos obrigatórios foram preenchidos 
  if (elems.every( (val, i, arr) => val === arr[0] )) {
    const formData = $('#'+form.id).serialize();

    $.ajax({
      url: '',
      method: 'POST',
      data: formData /* form serialize */,
      beforeSend: () => {
        document.getElementsByName(form.btnSubmit.name)[0].innerText = 'Enviando...';
      }
    }).done(function(data) {
      const obj = JSON.parse(data);    
      if (obj.success) {
        Swal.fire({
          title: 'Enviado!',
          text: `${obj.message}`,
          type: 'success',
          confirmButtonText: 'Fechar'
        });
      } else {
        Swal.fire({
          title: 'Algo deu errado!',
          text: `${obj.message}`,
          type: 'error',
          confirmButtonText: 'Ok'
        });
      }
      clear_form_elements('#'+form.id);
    }).always(function() {
      document.getElementsByName(form.btnSubmit.name)[0].innerText = 'Feito!';
    });
  }
});

form.addEventListener("change", function () {
  for (let i = 0; i < form.elements.length; i++) {    
    if (form.elements[i].type !== 'submit') {
      console.log('oi')
      if (form.elements[i].type == 'email') {
        validateEmail(form.elements[i], EMAIL_REQUIRED, EMAIL_INVALID, isRequired[i]);
      } else {
        hasValue(form.elements[i], NAME_REQUIRED, isRequired[i]);
      }
    }
  }
});

form.addEventListener("keypress", function (e) {
  const input = form.elements[e.target.name];
  let position = 0;

  for (let i = 0; i < form.elements.length; i++) {
    if ( e.target.name === form.elements[i].name ) {
      position = i;
    }  
  }
  
  if (e.target.type == 'email') {
    validateEmail(input, EMAIL_REQUIRED, EMAIL_INVALID, isRequired[position]);
  } else {
    hasValue(input, NAME_REQUIRED, isRequired[position]);
  }
});

// show a message with a type of the input
function showMessage(input, message, type) {
  // get the small element and set the message
  const msg = document.querySelector(".msg-"+input.name);
  if (! type) {
    msg.innerText = message;
  } else if ( msg !== null) {
    msg.innerText = '';
  }
  // update the class for the input
  input.className = type ? "input-success" : "input-error";
  return type;
}

function showError(input, message) {
  return showMessage(input, message, false);
}

function showSuccess(input) {
  return showMessage(input, "", true);
}

function hasValue(input, message, required) {
  if (input.value.trim() == "" && required) {
    return showError(input, message);
  }
  return showSuccess(input);
}

function validateEmail(input, requiredMsg, invalidMsg, required) {
  // check if the value is not empty
  if (!hasValue(input, requiredMsg, required)) {
    return false;
  }
  // validate email format
  const emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  const email = input.value.trim();
  if (!emailRegex.test(email)) {
    return showError(input, invalidMsg);
  }
  return true;
}
