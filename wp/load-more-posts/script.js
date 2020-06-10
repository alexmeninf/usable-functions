ajaxLoadMore = () => {

  const button = document.querySelector('.load-more-button');
  let current_page = document.querySelector('.posts-list').dataset.page;
  let max_pages = document.querySelector('.posts-list').dataset.max;

  if (typeof (button) != 'undefined' && button != null) {

    button.addEventListener('click', (e) => {
      e.preventDefault();

      $('.load-more-button').html(`<i class="material-icons loading-icon">&#xE5D5;</i>
      <span>Carregando...</span>`);

      let baseUrl = $('meta[name="getURL"]').attr('content'),
        currentUrl = $('meta[name="currentUrl"]').attr('content');

      let params = new URLSearchParams();
      params.append('action', 'load_more_posts');
      params.append('current_page', current_page);
      params.append('max_pages', max_pages);

      axios.post(baseUrl + '/wp-admin/admin-ajax.php', params)
        .then(res => {
          let posts_list = document.querySelector('.posts-list');

          posts_list.innerHTML += res.data.data;

          window.history.pushState('', '', currentUrl + 'page/' + (parseInt(document.querySelector('.posts-list').dataset.page) + 1));

          document.querySelector('.posts-list').dataset.page++;

          $('.load-more-button').html(`<i class="material-icons">&#xE5D5;</i>
            <span>Mais notícias</span>`);

          // get update data
          current_page = document.querySelector('.posts-list').dataset.page;
          max_pages = document.querySelector('.posts-list').dataset.max;

          if (current_page == max_pages) {
            button.remove();
          }
        })
    });

    if (current_page == max_pages) {
      button.remove();
    }
  }
}

ajaxLoadMore();
