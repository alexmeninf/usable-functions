<?php 
function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );

    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );

    /*----------  Minify html  ----------*/
    $buffer = preg_replace($search, $replace, $buffer);
    /*----------  Remove spaces CSS  ----------*/
	$buffer = preg_replace("/\s{2,}/", " ", $buffer);
	$buffer = str_replace("\n", "", $buffer);
	/*----------  Remove comments  ----------*/
	$buffer = preg_replace("/(\/\*[\w\'\s\r\n\*\+\,\"\-\.]*\*\/)/", "", $buffer);

    return $buffer;
}

ob_start("sanitize_output");
