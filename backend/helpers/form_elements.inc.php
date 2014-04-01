<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 2.0
 * @package Project
 */

# ==========================================================================================
# FUNCTIONS
# ==========================================================================================

/*
	To simplify the creation of Drop-down boxes (select tags), use the generate_select_values()
	function. The syntax is as follows:
	
	generate_select_values($table_name, $id_field, $label_field);
*/

function user_select() {
	return generate_select_values("users", "uid", "name");
}

function company_select($cat = 0) {
	return generate_select_values("companies", "uid", "name", "category = {$cat}");
}

# ==========================================================================================
# THE END
# ==========================================================================================
