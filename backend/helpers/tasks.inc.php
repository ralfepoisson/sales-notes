<?php

function tasks($item) {
	# Generate HTML
	$file																= dirname(dirname(dirname(__FILE__))) . "/frontend/html/components/tasks.html";
	$vars																= array(
																					
																				);
	$template															= new Template($file, $vars);
	$html																= $template->toString();
	
	# Return HTML
	return $html;
}
