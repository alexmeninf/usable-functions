<?php
/**
 * Support Facebook comments
 */
function support_comments_facebook($url = '') {
	if ($url == '') {
		$url = esc_url( get_permalink() );
	} ?>

  <style>
    .fb_iframe_widget_fluid_desktop iframe { width: 100% !important; }
    .face-link {font-size: 14px}
    .face-link a {color: var(--bs-primary); }
  </style>

  <?php if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad') || strstr($_SERVER['HTTP_USER_AGENT'], 'Mac')) : ?>
    <p class="ms-2 face-link">
      <i class="fab fa-facebook me-1"></i> 
      <?php _e('Não consegue comentar?', 'startertheme') ?> 
      <?php _e('<a href="https://facebook.com/home.php" target="_blank" rel="noreferrer noopener" title="Conecte ao facebook" class="text-decoration-none">Conecte à sua conta do Facebook</a> em outra página e volte.', 'startertheme') ?>
    </p>
  <?php endif; ?>

  <div class="comment-box">
    <div class="fb-comments" data-order-by="reverse_time" data-href="<?php echo $url ?>" data-width="100%" data-numposts="5"></div>
  </div>  
  
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v13.0" nonce="lkGf2c72"></script>
  
  <?php
}