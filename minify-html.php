<?php 
function sanitize_output($buffer) {
	$search = array(
		'/\>[^\S ]+/s',      // strip whitespaces after tags, except space
		'/[^\S ]+\</s',      // strip whitespaces before tags, except space
		'/(\s)+/s',          // shorten multiple whitespace sequences
		'/<!--(.|\s)*?-->/', // Remove HTML comments
		'/\s{2,}/',          // More two Whitespaces
		'/\n/',              // Break line
		'/(\/\*[\w\'\s\r\n\*\+\,\"\-\.]*\*\/)/' // remove CSS comments
	);
	$replace = array(
		'>',
		'<',
		'\\1',
		'',
		' ',
		'',
		''
	);
	/*----------  Minify html  ----------*/
	$buffer = preg_replace($search, $replace, $buffer);
	return $buffer;
}
ob_start("sanitize_output");
