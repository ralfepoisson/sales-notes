<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 2.0
 * @package Project
 */

# =========================================================================
# PAGE CLASS
# =========================================================================

class Page extends AbstractPage {
	
	# =========================================================================
	# DISPLAY FUNCTIONS
	# =========================================================================
	
	/**
	 * The default function called when the script loads
	 */
	function display(){
		# Global Variables
		global $_db;
		
		# Generate HTML
		$file															= dirname(dirname(dirname(__FILE__))) . "/frontend/html/contacts/display.html";
		$vars															= array(
																					"folders"			=> Category::category_menu()
																				);
		$template														= new Template($file, $vars);
		$html															= $template->toString();
		
		# Display HTML
		print $html;
	}
	
	# =========================================================================
	# PROCESSING FUNCTIONS
	# =========================================================================
	
}

# =========================================================================
# THE END
# =========================================================================
