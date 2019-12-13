<?php
global $product;
$attachment_ids = $product->get_gallery_attachment_ids();

foreach( $attachment_ids as $attachment_id ) 
{
  //Get URL of Gallery Images - default wordpress image sizes
  echo $Original_image_url = wp_get_attachment_url( $attachment_id );
  echo $full_url = wp_get_attachment_image_src( $attachment_id, 'full' )[0];
  echo $medium_url = wp_get_attachment_image_src( $attachment_id, 'medium' )[0];
  echo $thumbnail_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0];

  //Get URL of Gallery Images - WooCommerce specific image sizes
  echo $shop_thumbnail_image_url = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' )[0];
  echo $shop_catalog_image_url = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' )[0];
  echo $shop_single_image_url = wp_get_attachment_image_src( $attachment_id, 'shop_single' )[0];

  //echo Image instead of URL
  echo wp_get_attachment_image($attachment_id, 'full');
  echo wp_get_attachment_image($attachment_id, 'medium');
  echo wp_get_attachment_image($attachment_id, 'thumbnail');
  echo wp_get_attachment_image($attachment_id, 'shop_thumbnail');
  echo wp_get_attachment_image($attachment_id, 'shop_catalog');
  echo wp_get_attachment_image($attachment_id, 'shop_single');
}
?>