/**
 * Use esse código para exibir um elemento depois de determinado tempo na página
 * A cada segundo passado na página, será discontado no tempo final de exibição
 * Após o perído o elemento fica visivel mesmo com reload, isso fica setado atráves do localStorage.
*/

// Global
const timeInPage = localStorage.getItem("totalTimeInPage") !== null ? parseFloat(localStorage.getItem("totalTimeInPage")) : undefined; // Tempo em segundos

jQuery(function ($) {
  let miliTime = (timeInPage * 1000); // Tempo de segundos para milessimos

  const watched    = localStorage.getItem("watched_keepup_pg") !== null ? localStorage.getItem("watched_keepup_pg") : undefined; // Verifica se o vídeo foi todo asssistido
  const fixedTime  = 3000000; // 50 Mins em milessimos
  const timeout    = typeof timeInPage !== 'undefined' && miliTime <= fixedTime ? fixedTime - miliTime : fixedTime; // Verifica o tempo ficado na páginas em outras requisições e subtrai com o tempo de espera definido acima.
  console.log(miliTime <= fixedTime)

  if (typeof watched === 'undefined') {
    console.log('Asista até o final, para liberar o resto da página! Faltam: ' + Math.floor(timeout / 1000 / 60) + ' minutos' );

    setTimeout(() => {
      console.log('Final do vídeo!');
      $('.show-after-mins').removeClass('show-after-mins');
      localStorage.setItem("watched_keepup_pg", true)
    }, timeout);

  } else {
    console.log('Assistido!');
    $('.show-after-mins').removeClass('show-after-mins');
  }
});


document.addEventListener("DOMContentLoaded", () => {
  const start = new Date().getTime();

  window.addEventListener("beforeunload", () => {
    const end = new Date().getTime();
    const totalTime = (end - start) / 1000;

    if (typeof timeInPage !== 'undefined') {
      localStorage.setItem("totalTimeInPage", timeInPage + totalTime)
    } else {
      localStorage.setItem("totalTimeInPage", totalTime)
    }
  });
});
