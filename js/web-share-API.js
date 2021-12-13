shareButton.addEventListener('click', event => {
  if (navigator.share) {
    const title = document.title;
    const url = document.querySelector('link[rel=canonical]') ? document.querySelector('link[rel=canonical]').href : document.location.href;

    navigator.share({
      title: title,
      url: url
    }).then(() => {
      console.log('Thanks for sharing!');
    }).catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
});
