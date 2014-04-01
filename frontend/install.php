<?php
/**
 * Project
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

# Set Cur Page
$cur_page																= "login.php";

# Include Required Scripts
include_once(dirname(dirname(__FILE__)) . "/backend/framework/include.php");
Application::include_models();

# ===================================================
# DISPLAY FUNCTIONS
# ===================================================

function display() {
	# Global Variables
	global $_GLOBALS;
	
	# Get GET Data
	$error																= Form::get_str("error");
	
	# Generate Page
	$vars																= array(
																				"mysql_host"		=> config::get("mysql_host"),
																				"mysql_pass"		=> config::get("mysql_pass"),
																				"mysql_user"		=> config::get("mysql_user"),
																				"mysql_db"			=> config::get("mysql_db"),
																				"error"				=> $error
																				);
	$html_file															= dirname(__FILE__) . "/html/install.html";
	$template															= new Template($html_file, $vars);
	print $template->toString();
}

# ===================================================
# PROCESSING FUNCTIONS
# ===================================================

function save() {
	# Global Variables
	global $_GLOBALS;
	
	# Get POST Data
	$mysql_host															= Form::get_str("mysql_host");
	$mysql_user															= Form::get_str("mysql_user");
	$mysql_pass															= Form::get_str("mysql_pass");
	$mysql_db															= Form::get_str("mysql_db");
	$root_password														= Form::get_str("root_password");
	
	# Update Config
	config::update("mysql_host", $mysql_host);
	config::update("mysql_user", $mysql_user);
	config::update("mysql_pass", $mysql_pass);
	config::update("mysql_db", $mysql_db);
	logg("Installation: Updated config file with new database credentials: {$mysql_host}, {$mysql_user}, {$mysql_pass}, {$mysql_db}.");
	
	# If Root Password is provided, attempt to connect as that user and setup login credentials.
	if (strlen($root_password)) {
		if ($link														= mysql_connect($mysql_host, "root", $root_password)) {
			# Create Database
			logg("Installation: Creating database `{$mysql_db}`.");
			mysql_query("CREATE DATABASE `{$mysql_db}`");
			if (mysql_error()) {
				logg("Installation: DB ERROR: " . mysql_error());
			}
			
			# Setup Login Details
			logg("Installation: Granting Privileges to '{$mysql_user}'.");
			mysql_query("GRANT ALL PRIVILEGES ON `{$mysql_db}`.* TO '{$mysql_user}'@'localhost' IDENTIFIED BY '{$mysql_pass}'");
			mysql_query("GRANT ALL PRIVILEGES ON `{$mysql_db}`.* TO '{$mysql_user}'@'%' IDENTIFIED BY '{$mysql_pass}'");
			if (mysql_error()) {
				logg("Installation: DB ERROR: " . mysql_error());
			}
		}
	}
	
	# Test Configuration
	$error																= install_test_db_connect();
	if (strlen($error)) {
		logg("Installation: Database errors. Running installation process. ($error_message)");
		run_installation($error_message);
	}
	
	# If the test passes, run database script
	$db																	= new db_engine(	$mysql_host,
																							$mysql_user,
																							$mysql_pass,
																							$mysql_db,
																							true
																						);
	$sql_script															= $_GLOBALS['base_dir'] . "backend/framework/config/db.sql";
	logg("Installation: Running SQL Script at location: {$sql_script}.");
	$command															= "mysql -u {$mysql_user} -p{$mysql_pass} -h {$mysql_host} {$mysql_db} < {$sql_script}";
	logg("Installation: - `{$command}`");
	exec($command);
	
	# Redirect
	redirect("./");
}

# ===================================================
# ACTION HANDLER
# ===================================================

if (isset($_GET['action'])){
	$action																= $_GET['action'];
	if ($action															== "display"){
		display();
	}
	else if ($action													== "save"){
		save();
	}
	else {
		print "Invalid Action `$action`.";
	}
}
else {
	display();
}

# ===================================================
# THE END
# ===================================================
