  positionScrollSection = () => {
    let offsetTopSection = $('#about').offset().top; // posição da sessão no scroll 
    let sectionHeight = $('#about').height(); // altura da sessão
    let currentScroll, scrollInSection;

    $(window).scroll(function () {
      currentScroll = $(this).scrollTop(); // obtem a posição do scroll
      scrollInSection = (currentScroll - offsetTopSection); // posição do scroll dentro da sessão

      // Verifica se o scroll está dentro da sessão
      if (currentScroll >= offsetTopSection && currentScroll <= (offsetTopSection + sectionHeight)) {
        console.log((scrollInSection / sectionHeight) * 100);
      }
    });
  }
  
  // efeito de sumir o texto

   transformText = () => {
    let element = $('.offset-top'),
      innerWindow = $(window).innerHeight();

    element.each(function () {
      let distance = $(this).offset().top,
        itemAnimate = $(this);

      innerWindow = $(window).innerHeight() <= 400 ? (innerWindow / 3) : (innerWindow / 1.1);

      $(window).scroll(function () {
        if ($(this).scrollTop() + innerWindow >= distance) {
          itemAnimate.css({
            transition: '.4s all',
            transform: 'translateY(0)',
            opacity: 1
          });
        } else {
          itemAnimate.css({
            transition: '.4s all',
            transform: 'translateY(50px)',
            opacity: 0
          });
        }
      });
    });
  }
