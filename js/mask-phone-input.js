  $("input[type=tel]").on("keyup", function () {
    if ($(this).val().length >= 15) {
      $(this).mask("(00) 0 0000-0000");
    } else {
      $(this).mask("(00) 0000-00009");
    }
  }).trigger("keyup");
