<?php
/**
 * 
 * Added arrow in input quantity
 * 
 */
function arrow_qty_before()
{
  echo '<button type="button" aria-label="decrescimo" class="arrow-qty decrescimo"><i class="fal fa-minus"></i></button>';
}

function arrow_qty_after()
{
  echo '<button type="button" aria-label="acrescimo" class="arrow-qty acrescimo"><i class="fal fa-plus"></i></button>';
}

add_action('woocommerce_before_quantity_input_field', 'arrow_qty_before');
add_action('woocommerce_after_quantity_input_field', 'arrow_qty_after');