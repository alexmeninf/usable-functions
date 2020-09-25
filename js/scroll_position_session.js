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
