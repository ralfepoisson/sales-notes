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

class Contact extends Model {
	
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
		$this->table													= "contacts";
		
		# Initialize UID from Parameter
		$this->uid														= $uid;
		if ($uid) {
			$this->load();
		}
	}
	
	/**
	 * Something
	 */
	public function get_name() {
		return $this->title . " " . $this->first_name . " " . $this->last_name;
	}
	
	public function get_profile() {
		# Prepare Profile Vars
		$vars															= $this->get_obj_array();
		$vars["company_select"]											= generate_select("contact_company_id", company_select($this->category), $this->company);
		$vars["tasks"]													= tasks("i" . $this->uid);
		$vars["notes"]													= notes("i" . $this->uid);
		$vars["interactions"]											= interactions("i" . $this->uid);
		
		# Generate HTML
		$file															= dirname(dirname(dirname(__FILE__))) . "/frontend/html/contacts/contact_profile.html";
		$template														= new Template($file, $vars);
		$html															= $template->toString();
		
		# Return HTML
		return $html;
	}
}

# ==========================================================================================
# THE END
# ==========================================================================================

