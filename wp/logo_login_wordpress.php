<?php

/**
 * Update Layout to Login Admin
 */
function wp_custom_logo_in_login() {

  $css = '<style type="text/css">
    #login h1 a,
    .login h1 a {
      background-image: url(https://via.placeholder.com/120);
      background-repeat: no-repeat;
      background-size: 120px;
      height: 120px;
      width: 120px;
    }

    body {background: #141414 !important}

    .login #backtoblog a,
    .login #nav a {color: #adadad !important}

    .login #login_error,
    .login .message,
    .login .success,
    .login form {
      border-radius: 10px
    }

    .wp-core-ui .button-primary {
      background: #000 !important;
      border-color: #000 !important;
      box-shadow: none !important;
      color: #fff !important;
      text-decoration: none !important;
      text-shadow: none !important;
      border-radius: 0 !important;
    }

    input[type=text]:focus,
    input[type=password]:focus {
      border-color: #ff0083 !important;
      box-shadow: none !important;
    }
  </style>';

  echo $css;
}

add_action('login_enqueue_scripts', 'wp_custom_logo_in_login');