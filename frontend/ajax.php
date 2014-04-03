<?php
/**
 * Project: AJAX Script
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.cm>
 * @version 2.0
 * @package Project
 */
 
# ===================================================
# SCRIPT SETTINGS
# ===================================================

# Start Session
session_start();

# Include Required Scripts
include_once(dirname(dirname(__FILE__)) . "/backend/framework/include.php");
Application::include_models();
Application::include_helpers();
Application::db_connect();

# ===================================================
# FUNCTIONS
# ===================================================

function add_company() {
	# Create New Object
	$company															= new Company();
	
	# Get GET Data
	$company->category													= Form::get_int("category");
	$company->name														= Form::get_str("name");
	$company->address													= Form::get_str("address");
	$company->tel														= Form::get_str("tel");
	$company->fax														= Form::get_str("fax");
	$company->email														= Form::get_str("email");
	
	# Prepare new Object
	$company->datetime													= date("Y-m-d H:i:s");
	$company->user														= get_user_uid();
	$company->active													= 1;
	
	# Log Activity
	logg("AJAX: Adding Company '{$company->name}'.");
	
	# Save
	$company->save();
}

function add_contact() {
	# Create New Object
	$contact															= new Contact();
	
	# Get GET Data
	$contact->category													= Form::get_int("category");
	$contact->company													= Form::get_int("company");
	$contact->first_name												= Form::get_str("first_name");
	$contact->last_name													= Form::get_str("last_name");
	$contact->job_title													= Form::get_str("job_title");
	$contact->address													= Form::get_str("address");
	$contact->tel														= Form::get_str("tel");
	$contact->fax														= Form::get_str("fax");
	$contact->email														= Form::get_str("email");
	
	# Prepare new Object
	$contact->datetime													= date("Y-m-d H:i:s");
	$contact->user														= get_user_uid();
	$contact->active													= 1;
	
	# Log Activity
	logg("AJAX: Adding Company '{$company->name}'.");
	
	# Save
	$contact->save();
}

function get_contacts() {
	# Local Variables
	$html																= "";
	
	# Get GET Data
	$folder_id															= Form::get_str("folder");
	
	# Get Companies
	$factory															= new Company();
	$companies															= $factory->get("active = 1, category = {$folder_id}");
	
	# Generate HTML
	if (sizeof($companies)) {
		foreach ($companies as $company) {
			# Generate HTML
			$file														= dirname(__FILE__) . "/html/contacts/contact_company_icon.html";
			$vars														= array(
																					"name"		=> $company->name,
																					"id"		=> $company->uid
																				);
			$template													= new Template($file, $vars);
			$html														.= $template->toString();
		}
	}
	
	# Get Contacts
	$factory															= new Contact();
	$contacts															= $factory->get("active = 1, category = {$folder_id}");
	
	# Generate HTML
	if (sizeof($contacts)) {
		foreach ($contacts as $contact) {
			# Generate HTML
			$file														= dirname(__FILE__) . "/html/contacts/contact_icon.html";
			$vars														= array(
																					"name"		=> $contact->get_name(),
																					"id"		=> $contact->uid
																				);
			$template													= new Template($file, $vars);
			$html														.= $template->toString();
		}
	}
	
	# Return HTML
	print $html;
}

function new_folder() {
	# Get GET Data
	$parent																= Form::get_int("parent");
	$name																= Form::get_str("name");
	
	# Create new Category
	$obj																= new Category();
	$obj->parent														= $parent;
	$obj->name															= $name;
	$obj->datetime														= date("Y-m-d H:i:s");
	$obj->user															= get_user_uid();
	$obj->active														= 1;
	
	# Save
	$obj->save();
	
	# Generate HTML
	$file																= (!$parent)? dirname(__FILE__) . "/html/contacts/category_menu_item.html" : dirname(__FILE__) . "/html/contacts/category_item.html";
	$vars																= array(
																					"title"		=> $obj->name,
																					"contents"	=> "",
																					"id"		=> $obj->uid,
																					"parent_id"	=> $obj->parent_id
																				);
	$template															= new Template($file, $vars);
	$html																= $template->toString();
	
	# Return HTML
	print $html;
}

function get_company_select() {
	# Get GET Data
	$category															= Form::get_int("folder");
	
	# Get HTML
	$html																= generate_select("company_id", company_select($category));
	
	# Return HTML
	print $html;
}

function get_company_name() {
	# Get GET Data
	$id																	= Form::get_int("id");
	
	# Get Data
	$company															= new Company($id);
	
	# Return Name
	print $company->name;
}

function get_company_profile() {
	# Get GET Data
	$id																	= Form::get_int("id");
	
	# Get Data
	$company															= new Company($id);
	
	# Return Name
	print $company->get_profile();
}

function get_contact_name() {
	# Get GET Data
	$id																	= Form::get_int("id");
	
	# Get Data
	$contact															= new Contact($id);
	
	# Return Name
	print $contact->get_name();
}

function get_contact_profile() {
	# Get GET Data
	$id																	= Form::get_int("id");
	
	# Get Data
	$contact															= new Contact($id);
	
	# Return Name
	print $contact->get_profile();
}

function delete_folder() {
	# Get GET Data
	$parent_id															= Form::get_int("parent_id");
	$id																	= Form::get_int("id");
	
	# Create Object
	$cat																= new Category($id);
	
	# Delete
	$cat->delete();
}

function add_note() {
	# Get GET Data
	$item																= Form::get_str("item");
	$comment															= Form::get_str("comment");
	
	# Create new Comment
	$obj																= new Comment();
	$obj->item															= $item;
	$obj->comment														= $comment;
	$obj->datetime														= date("Y-m-d H:i:s");
	$obj->user															= get_user_uid();
	$obj->active														= 1;
	
	# Save
	$obj->save();
	
	# Generate HTML
	$html																= $obj->display();
	
	# Return HTML
	print $html;
}

function delete_note() {
	# Get GET Data
	$id																	= Form::get_int("id");
	
	# Create Note Object
	$note																= new Comment($id);
	
	# Log Activity
	logg("AJAX: Deleting Comment #{$id}.");
	
	# Delete
	$note->delete();
}

function add_task() {
	# Get GET Data
	$item																= Form::get_str("item");
	$date																= Form::get_str("date");
	$time																= Form::get_str("time");
	$task																= Form::get_str("task");
	
	# Create Task
	$obj																= new Task();
	$obj->datetime														= date("Y-m-d H:i:s");
	$obj->user															= get_user_uid();
	$obj->item															= $item;
	$obj->date															= $date;
	$obj->time															= $time;
	$obj->active														= 1;
	$obj->save();
	
	# Get HTML
	$html																= $obj->display();
	
	# Return HTML
	print $html;
}

# ===================================================
# ACTION HANDLER
# ===================================================

if (isset($_GET["action"])) {
	$action																= Form::get_str("action");
	if (function_exists($action)) {
		$action();
	}
	else {
		print "Invalid action.";
	}
}
else {
	print "No Action was specified.";
}

# ===================================================
# THE END
# ===================================================
