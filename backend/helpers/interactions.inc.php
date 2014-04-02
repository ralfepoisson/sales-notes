<?php

function interactions($item) {
	# Generate HTML
	$file																= dirname(dirname(dirname(__FILE__))) . "/frontend/html/components/interactions.html";
	$vars																= array(
																					
																				);
	$template															= new Template($file, $vars);
	$html																= $template->toString();
	
	# Return HTML
	return $html;
}
