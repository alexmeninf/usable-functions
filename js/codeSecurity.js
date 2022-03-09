var codeSecurity = function() {
    document.onkeydown = function(e) {
      if (e.keyCode === 123 || (e.ctrlKey && 
        (e.keyCode === 67 || 
         e.keyCode === 115 ||
         e.keyCode === 99 ||
         e.keyCode === 85 || 
         e.keyCode === 117))) {
        return false;
      } else {
        return true;
      }
    };

    document.addEventListener("contextmenu", function(e){
      e.preventDefault();
    }, false);

    $(document).keypress("u",function(e) {
      if(e.ctrlKey){return false;}
      else {return true;}
    });
  }
