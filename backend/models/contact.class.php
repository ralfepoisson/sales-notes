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
		
	}
}

# ==========================================================================================
# THE END
# ==========================================================================================

