<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 1.0
 * @package Project
 */

# ==========================================================================================
# CLASS
# ==========================================================================================

class Category extends Model {
	
	# --------------------------------------------------------------------------------------
	# ATTRIBUTES
	# --------------------------------------------------------------------------------------
	
	var $y;
	
	# --------------------------------------------------------------------------------------
	# METHODS
	# --------------------------------------------------------------------------------------
	
	/**
	 * Constructor
	 * 
	 * Set the Table and the UID of the object.
	 * 
	 * @param $uid Integer: The Unique Identifier of the object.
	 */
	function __construct($uid=0) {
		# Set Table
		$this->table													= "categories";
		
		# Initialize UID from Parameter
		$this->uid														= $uid;
		if ($uid) {
			$this->load();
		}
	}
	
	/**
	 * Something
	 */
	function something() {
		// ...
	}
	
	public static function category_menu() {
		// Get parent categories
		$factory														= new Category();
		$parents														= $factory->get("active = 1, parent = 0");
		
		// Create HTML
		$html															= "";
		if (sizeof($parents)) {
			foreach ($parents as $parent) {
				// Get Children
				$children												= $factory->get("active = 1, parent = {$parent->uid}");
				
				// Create Children HTML
				$children_html											= "";
				if (sizeof($children)) {
					foreach ($children as $child) {
						# Generate HTML
						$file											= dirname(dirname(dirname(__FILE__))) . "/frontend/html/contacts/category_item.html";
						$vars											= array(
																					"title"		=> $child->name,
																					"id"		=> $child->uid,
																					"parent_id"	=> $parent->uid
																				);
						$template										= new Template($file, $vars);
						$children_html									.= $template->toString();
					}
				}
				
				# Generate HTML
				$file													= dirname(dirname(dirname(__FILE__))) . "/frontend/html/contacts/category_menu_item.html";
				$vars													= array(
																					"title"		=> $parent->name,
																					"contents"	=> $children_html,
																					"id"		=> $parent->uid
																				);
				$template												= new Template($file, $vars);
				$html													.= $template->toString();
			}
		}
		$parent_html													= $html;
		
		# Generate HTML
		$file															= dirname(dirname(dirname(__FILE__))) . "/frontend/html/contacts/category_menu.html";
		$vars															= array(
																					"panels"	=> $parent_html
																				);
		$template														= new Template($file, $vars);
		$html															= $template->toString();
		
		// Return HTML
		return $html;
	}
}

# ==========================================================================================
# THE END
# ==========================================================================================

