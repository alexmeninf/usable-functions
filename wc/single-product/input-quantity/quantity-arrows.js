/**
 * 
 * Single product, input quantity
 * 
 * */
const inputQty = "input.qty",
  btnArrow = "button.arrow-qty";

var timer = null,
  interval = 200;

if (is_mobile()) {
  $("body").on("touchstart", btnArrow, function () {
    btnDown($(this));
  });
  $("body").on("touchend", btnArrow, function () {
    btnUp();
  });
} else {
  $("body").on("mousedown", btnArrow, function () {
    btnDown($(this));
  });
  $("body").on("mouseup mouseleave", btnArrow, function () {
    btnUp();
  });
}

// Verifica se foi digitado a quantidade pelo teclado
$(inputQty).on('keyup', function (e) {
  if (e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 109) {
    qntClick($(this), 'typed');
  }
});

function btnDown(elem) {
  qntClick(elem);
  if (timer !== null) return;
  timer = setInterval(function () {
    qntClick(elem);
  }, interval);
}

function btnUp() {
  clearInterval(timer);
  timer = null;
  // in Cart
  let btnUpdate = $("[name='update_cart']");
  if (btnUpdate.length) {
    btnUpdate.data("disabled", "false");
    btnUpdate.removeAttr("disabled");

    setTimeout(() => {
      btnUpdate.trigger("click");
    }, 2500);
  }
}

function qntClick(elem, action = 'click') {
  const parentBtn = elem.parent();
  const $input = parentBtn.find(inputQty);
  // Faz o acrescimo ou decréscimo de acordo com os passos dos numeros
  const step = fixFormat($input.attr('step'));
  // Limite do estoque
  const max = $input.attr('max') != undefined ? fixFormat($input.attr('max')) : Infinity;
  // Valor na input
  var num = $input.val();
  // Verifica se existe casa decimal e a input permite numero flutuante
  var hasDecimal = (num.indexOf(".") == -1) ? false : true;
  // Transforma em number a string
  num = Number(num);

  if ($input.val() === "") $input.val(step);

  if (action == 'typed') {
    if (num <= 0) {
      $input.val(hasDecimal ? parseFloat(step).toFixed(3) : (step));
    } else if (num > max) {
      $input.val(hasDecimal ? parseFloat(max).toFixed(3) : (max));
    }

  } else {
    if (elem.hasClass("acrescimo")) {
      if (num <= 0) {
        $input.val(hasDecimal ? parseFloat(step).toFixed(3) : (step));
      } else if (num >= max) {
        $input.val(hasDecimal ? parseFloat(max).toFixed(3) : (max));
      } else {
        $input.val(hasDecimal ? parseFloat(num + step).toFixed(3) : parseInt(num + step));
      }
    } else if (elem.hasClass("decrescimo")) {
      if (num > max) {
        $input.val(hasDecimal ? parseFloat(max).toFixed(3) : parseInt(max));
      } else if (num > step) {
        $input.val(hasDecimal ? parseFloat(num - step).toFixed(3) : parseInt(num - step));
      }
    }
  }
}

function fixFormat(value) {
  if (value.indexOf(".") == -1) {
    return parseInt(value);
  } else {
    return parseFloat(value);
  }
}