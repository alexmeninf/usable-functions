<?php

/*=====================================
=            Send whatsapp            =
=====================================*/
function api_link_whatsApp($number, $msg = '', $prefix = '55')
{
  $number = $prefix . $number;
  $number = preg_replace('/\(|\)|\s+|\+|\-/', '', $number);
  $msg = str_replace(' ', '%20', $msg);

  $url = 'https://api.whatsapp.com/send?phone=' . $number;
  $url .= $msg ? '&text=' . $msg : '';

  return $url;
}
