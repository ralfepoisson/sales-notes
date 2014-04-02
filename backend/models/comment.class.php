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

class Comment extends Model {
	
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
		$this->table													= "comments";
		
		# Initialize UID from Parameter
		$this->uid														= $uid;
		if ($uid) {
			$this->load();
		}
	}
	
	function display() {
		# Get User
		$user															= new User($this->user);
		
		# Generate HTML
		$file															= dirname(dirname(dirname(__FILE__))) . "/frontend/html/components/note_item.html";
		$vars															= array(
																					"name"		=> $user->username,
																					"datetime"	=> $this->datetime,
																					"message"	=> $this->comment,
																					"id"		=> $this->uid
																				);
		$template														= new Template($file, $vars);
		$html															= $template->toString();
		
		# Return HTML
		return $html;
	}
}

# ==========================================================================================
# THE END
# ==========================================================================================

