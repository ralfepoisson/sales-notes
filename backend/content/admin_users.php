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
	
		# Get Data
		$query															= "	SELECT
																				CONCAT(\"<a href='$this->cur_page&action=profile&id=\", `uid`, \"'>\", `username`, \"</a>\")as 'Username',
																				`last_name`				as 'Last Name',
																				`first_name`			as 'First Name',
																				`email`					as 'Email Address',
																				`tel`					as 'Tel',
																				`mobile`				as 'Mobile'
																			FROM
																				`users`
																			WHERE
																				`active`				= 1
																			ORDER BY
																				`username`";
		
		# Generate HTML
		$html															= "
		
		cur_page = {$this->cur_page}
		
		<!-- Title -->
		<h2>User Administration</h2>
	
		" . button("Add", "$this->cur_page&action=add") . "
	
		<!-- Listing -->
		" . paginated_listing($query) . "
		<!-- END: Listing -->
	
		";
	
		# Display HTML
		print $html;
	}

	function profile() {
		# Global Variables
		global $_db;
	
		# Get GET Data
		$uid															= $_GET['id'];
	
		# Generate HTML
		$html															= "
		<!-- Title -->
		<h2>User Administration</h2>
	
		<!-- Form -->
		" . user_profile($uid) . "
		";
	
		# Display HTML
		print $html;
	}

	function add() {
		# Global Variables
		global $_db;
	
		# Create new User Object
		$user																= new User();
	
		# Generate HTML
		$html																= "
		<!-- Title -->
		<h2>New User</h2>
	
		<!-- Form -->
		" . $user->form() . "
		";
	
		# Display HTML
		print $html;
	}

	# =========================================================================
	# PROCESSING FUNCTIONS
	# =========================================================================

	function save() {
		# Global Variables
		global $_db, $validator;
	
		# Get POST Data
		$uid															= $validator->validate($_POST['uid'], "Integer");
		$user															= new User($uid);
		$user->username													= $validator->validate($_POST['username'], "AlphaNumeric");
		$user->first_name												= $validator->validate($_POST['first_name'], "String");
		$user->last_name												= $validator->validate($_POST['last_name'], "String");
		$user->email													= $validator->validate($_POST['email'], "Email");
		$user->tel														= $validator->validate($_POST['tel'], "String");
		$user->mobile													= $validator->validate($_POST['mobile'], "String");
		$user->fax														= $validator->validate($_POST['fax'], "String");
		$password														= $validator->validate($_POST['password'], "String");
	
		# Update Password
		if (strlen($password)) {
			$user->password												= $password;
		}
	
		# Save User
		$user->save();
	
		# Set info message
		set_info("User {$username} has been saved successfully.");
	
		# Redirect
		redirect("{$this->cur_page}&action=profile&id={$uid}");
	}

	function delete() {
		# Global Variables
		global $_db, $validator;
	
		# Get GET Data
		$uid															= $validator->validate($_GET['id'], "Integer");
	
		# Create User Object
		$user															= new User($uid);
	
		# Delete From Database
		$user->delete();
	
		# Set info message
		set_info("User {$user->username} has been deleted successfully.");
	
		# Redirect
		redirect($this->cur_page);
	}

	function save_auths() {
		# Global Variables
		global $_db, $validator;
	
		# Get POST Data
		$uid															= $validator->validate($_POST['uid'], "Integer");
	
		# Create User
		$user															= new User($uid);
	
		# Save Auths
		$user->clear_auths();
		foreach ($_POST as $key => $value) {
			if (substr($key, 0, 2) == "f_") {
				# Get Function
				$function_id											= substr($key, 2);
				$function												= $_db->get_data("functions", "function", "uid", $function_id);
			
				# Add function to user
				$user->add_allowed_function($function);
			}
		}
	
		# Redirect
		redirect("{$this->cur_page}&action=profile&id={$uid}");
	}
}

# =========================================================================
# THE END
# =========================================================================
