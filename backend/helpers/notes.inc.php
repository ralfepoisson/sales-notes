<?php

function notes($item) {
	# Get Notes
	$factory															= new Comment();
	$items																= $factory->get("active = 1, item = {$item}");
	$notes																= "";
	if (sizeof($items)) {
		foreach ($items as $i) {
			$notes														.= $i->display();
		}
	}
	
	# Generate HTML
	$file																= dirname(dirname(dirname(__FILE__))) . "/frontend/html/components/notes.html";
	$vars																= array(
																					"item"		=> $item,
																					"notes"		=> $notes
																				);
	$template															= new Template($file, $vars);
	$html																= $template->toString();
	
	# Return HTML
	return $html;
}
