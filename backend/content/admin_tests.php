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
		
		# Setup Test Manager
		$test_manager													= new TestManager();
		$test_manager->get_tests();
		
		# Create Form
		$form															= new Form($this->cur_page . "&action=process");
		foreach ($test_manager->test_files as $item) {
			$form->add(	$item		, "checkbox"	, "t_" . substr($item, strpos($item, ".php")));
		}
		$form->add(		"Action"	, "submit"		, "submit"	, "Submit")
		$form_html														= $form->generate();
		
		# Generate HTML
		$html															= "
		<!-- Title -->
		<h2>Tests</h2>
		
		<p>
			Please select which test(s) you would like to run.
		</p>
		
		{$form_html}
		";
		
		# Display HTML
		print $html;
	}
	
	function process() {
		# Local Variables
		$tests															= array();
		
		# Get POST Data
		foreach ($_POST as $key => $value) {
			if (substr($key, 0, 2) == "t_") {
				$file													= substr($key, 2) . ".php";
				$tests[]												= $file;
			}
		}
		$all															= isset($_POST['all'])? true : false;
		
		# Create TestManager
		$test_manager													= new TestManager();
		
		# Run Tests
		if ($all) {
			$test_manager->test();
		}
		else {
			foreach ($tests as $file) {
				$test_manager->run_test($file);
			}
		}
		
	}
	
	# =========================================================================
	# PROCESSING FUNCTIONS
	# =========================================================================
	
}

# =========================================================================
# THE END
# =========================================================================
