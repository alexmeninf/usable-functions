<?php

/*=====================================
=            Send whatsapp            =
=====================================*/
function send_whatsapp($number, $msg = '', $prefix = '55')
{
  $number = $prefix . $number;
  $number = preg_replace('/\(|\)|\s+|\+|\-/', '', $number);
  $msg = str_replace(' ', '%20', $msg); //mensage

  $url = 'https://api.whatsapp.com/send?phone=' . $number . '&text=' . $msg;

  return $url;
}
