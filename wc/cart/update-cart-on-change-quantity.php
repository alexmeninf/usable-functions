<?php
// Atualiza o carrinho ao mudar a quantidade
add_action( 'wp_footer', 'programa_wp_atualizar_qtd_carrinho' ); 
function programa_wp_atualizar_qtd_carrinho() { 
	if( is_cart() ) { 
		?> 
		<script type="text/javascript"> 
			jQuery('div.woocommerce').on('click', 'input.qty', function(){ 
				jQuery("[name='update_cart']").trigger("click"); 
			}); 
		</script> 
		<?php 
	} 
}
