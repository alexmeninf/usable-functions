<?php

add_action( 'woocommerce_login_form_end', 'action_function_login_form_end' );
add_action( 'woocommerce_register_form_end', 'action_function_register_form_end' );
add_action( 'wp_head', 'wc_style_login', 10 );
add_action( 'wp_footer', 'wc_script_login', 30 );


function action_function_login_form_end(){ ?>	
  <div class="btn-forms">
    <span>Ainda não possui uma conta?</span>
    <button type="button" id="create-account-form">Criar conta</button>
  </div>
  <?php
}


function action_function_register_form_end(){ ?>
	<div class="btn-forms">
    <span>Possui uma conta?</span>
    <button type="button" id="login-account-form">Faça login</button>
  </div>
  <?php
}


function wc_style_login() { ?>
  <style>
  .woocommerce-account 
  .btn-forms {
    display: block;
    text-align: center;
    margin-top: 35px;
    border-top: 1px solid #dedede;
    padding-top: 30px;
    position: relative;
  }
  .woocommerce-account 
  .btn-forms::before {
    content: 'ou';
    font-weight: bold;
    background-color: #fff;
    position: absolute;
    top: -13px;
    left: 50%;
    font-size: 16px;
    padding: 0 8px;
    transform: translateX(-50%);
  }
  .woocommerce-account
  .btn-forms button {
    border: 0;
    padding: 5px;
    font-weight: 700;
    color: #4f71e8;
    background: transparent;
    text-decoration: underline;
    font-size: 15px;
  }
  .woocommerce-account
  .btn-forms button:hover {
    opacity: .6;
  }
</style>
<?php
}


function wc_script_login() { ?>
  <script type="text/javascript">
    if ( undefined !== window.jQuery ) {
      jQuery(function(){
        $("#create-account-form").on("click", function(e){
          e.preventDefault();
          $(".u-column1").hide();
          $(".u-column1").css({opacity: 0});
          $(".u-column2").show();
          $(".u-column2").css({opacity: 1});
        });

        $("#login-account-form").on("click", function(e){
          e.preventDefault();
          $(".u-column1").show();
          $(".u-column1").css({opacity: 1});
          $(".u-column2").hide();
          $(".u-column2").css({opacity: 0});
        });
      });
    }
  </script>
  <?php
}
