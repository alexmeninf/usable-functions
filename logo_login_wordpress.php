<?php
/*===================================================
=            UPDATE WORDPRESS LOGIN LOGO            =
===================================================*/
function my_login_logo() { ?>
<style type="text/css">
    #login h1 a, .login h1 a {
        background-image: url('http://s3.dvulgsolucoes.com.br/assets/img/logo-dvulg-wordpress.png');
        background-repeat: no-repeat;
        height: 105px;
        padding-bottom: 30px;
        width: 105px;
    }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
