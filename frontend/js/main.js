
function get_cur_folder() {
	// Log Activity
	logg(" [*] Retrieving Current Folder");
	
	// Get Active Folder
	var active_folder = $("#cur_folder").val();

	// Log Activity
	logg(" - Current Folder: " + active_folder);	
	
	// Return the Active folder
	return active_folder;
}

function add_folder_modal(parent_id) {
	// Log Activity
	logg(" [*] Add Folder Modal.");
	logg(" - Parent: " + parent_id);
	
	
	// Set Parent Id
	$("#new_folder_parent").val(parent_id);
	
	// Show Modal
	$('#add_folder_modal').modal('show');
}

function add_child_folder(parent_id) {
	// Log Activity
	logg(" [*] Add Child Folder.");
	logg(" - Parent: " + parent_id);
	
	// Set Parent Id
	$("#new_folder_parent").val(parent_id);
	
	// Show Modal
	$('#add_folder_modal').modal('show');
}

function add_folder() {
	// Log Activity
	logg(" [*] Saving new Folder.");
	
	// Get Parent Folder
	var parent_id = $("#new_folder_parent").val();
	logg(" - Parent: " + parent_id);
	
	// Get New Folder Name
	var name = $("#new_folder_name").val();
	
	// AJAX Request
	var new_html = ajax_get_data("ajax.php?action=new_folder&parent=" + parent_id + "&name=" + name);
	
	// Update DOM
	if (!parent_id) {
		$("#folders").append(new_html);
	}
	else {
		$("#menu_item_" + parent_id + "_contents").append(new_html);
	}
	
	// Clear Form
	$('#new_folder_name').val("");
	
	// Hide Modal
	$('#add_folder_modal').modal('hide');
	
	// Log Activity
	logg(" - Done.");
}

function add_company() {
	// Log Activity
	logg(" [*] Adding Company.");
	
	// Get Contact Data
	var name = $("#new_company_name").val();
	var address = $("#new_company_address").val();
	var tel = $("#new_company_tel").val();
	var fax = $("#new_company_fax").val();
	var email = $("#new_company_email").val();
	
	// Construct URL
	var url = "ajax.php?action=add_company";
	url += "&category=" + get_cur_folder();
	url += "&name=" + name;
	url += "&address=" + encodeURI(address);
	url += "&tel=" + tel;
	url += "&fax=" + fax;
	url += "&email=" + email;
	
	// AJAX Call
	ajax_get_data(url);
	
	// Clear Form
	$("#new_company_name").val("");
	$("#new_company_address").val("");
	$("#new_company_tel").val("");
	$("#new_company_fax").val("");
	$("#new_company_email").val("");
	
	// Hide Modal
	$("#add_company_modal").modal("hide");
	
	// Reload Contacts
	load_contacts(get_cur_folder());
}

function add_contact() {
	// Log Activity
	logg(" [*] Adding Contact.");
	
	// Get Contact Data
	var company	= $("#new_company_select").val();
	var title = $("#new_contact_title").val();
	var first_name = $("#new_contact_firstname").val();
	var last_name = $("#new_contact_lastname").val();
	var tel = $("#new_contact_tel").val();
	var fax = $("#new_contact_fax").val();
	var email = $("#new_contact_email").val();
	
	// Construct URL
	var url = "ajax.php?action=add_contact";
	url += "&category=" + get_cur_folder();
	url += "&company=" + company;
	url += "&title=" + title;
	url += "&first_name=" + first_name;
	url += "&last_name=" + last_name;
	url += "&tel=" + tel;
	url += "&fax=" + fax;
	url += "&email=" + email;
	
	// AJAX Call
	ajax_get_data(url);
	
	// Clear Form
	$("#new_company_select").val("");
	$("#new_contact_title").val("");
	$("#new_contact_firstname").val("");
	$("#new_contact_lastname").val("");
	$("#new_contact_tel").val("");
	$("#new_contact_fax").val("");
	$("#new_contact_email").val("");
	
	// Hide Modal
	$("#add_contact_modal").modal("hide");
	
	// Reload Contacts
	load_contacts(get_cur_folder());
}

function load_contacts(folder_id) {
	// Log Activity
	logg(" [*] Loading Contacts for Folder #" +  folder_id);
	
	// Set Current Folder
	$("#cur_folder").val(folder_id);
	
	// Construct URL
	var url = "ajax.php?action=get_contacts&folder=" + get_cur_folder();
	
	// Get AJAX Data
	var data = ajax_get_data(url);
	
	// Update DOM
	$("#contact_listing").html(data);
	
	// Display Contacts Column
	$("#contacts_column").slideDown("Slow");
	
	// Update Company Select
	update_company_select();
}

function update_company_select() {
	// Log Activity
	logg(" [*] Updating Company Select");
	
	// Compile URL
	var url = "ajax.php?action=get_company_select&folder=" + get_cur_folder();
	
	// Get Data
	var new_html = ajax_get_data(url);
	
	// Update DOM
	$("#company_select").html(new_html);
}

function contact_filter() {
	// Get Filter Text
	var filter_text = $("#contact_filter_text").val();

	// Log Activity
	console.log("Filtering Contacts: " + filter_text);

	// Only Show the contacts which have the filter text
	$(".contact_icon").each(function() {
	    // Get Text to analyse
	    var html = $(this).html();
	    var pos = html.indexOf("</span>") + 7;
	    html = html.substring(pos);
	    console.log(html);
		if (html.indexOf(filter_text) > 0 || filter_text == "") {
	    	console.log("Match");
	    	$(this).addClass("active");
	    	$(this).removeClass("disabled");
	    }
	    else {
	    	$(this).removeClass("active");
	    	$(this).addClass("disabled");
	    }
	});
}

function auto_contact_filter(evn) {
	if (window.event && window.event.keyCode == 13) {
		contact_filter();
		document.getElementById("contact_filter_text").focus();
	}
}

function view_company(company_id) {
	// Log Activity
	logg(" [*] Viewing Company Profile for Company #" + company_id);
	
	// Get Name
	var name = ajax_get_data("ajax.php?action=get_company_name&id=" + company_id);
	$("#view_company_name").html(name);
	logg(" - Name: " + name);
	
	// Get Profile
	var profile = ajax_get_data("ajax.php?action=get_company_profile&id=" + company_id);
	$("#view_company_profile").html(profile);
	
	// Show Modal
	logg(" - Displaying modal");
	$("#view_company_modal").modal("show");
	logg(" - Done.");
}

function view_contact(contact_id) {
	// Log Activity
	logg(" [*] Viewing Company Profile for Company #" + company_id);
	
	// Get Name
	var name = ajax_get_data("ajax.php?action=get_contact_name&id=" + contact_id);
	$("#view_contact_name").html(name);
	logg(" - Name: " + name);
	
	// Get Profile
	var profile = ajax_get_data("ajax.php?action=get_contact_profile&id=" + contact_id);
	$("#view_contact_profile").html(profile);
	
	// Show Modal
	logg(" - Displaying modal");
	$("#view_contact_modal").modal("show");
	logg(" - Done.");
}

function delete_folder(e, parent_id, folder_id) {
	// Prevent Default Behaviour
	e.stopPropagation();
	
	// Log Activity
	logg(" [*] Deleting Sub Folder");
	logg(" - Parent Id: " + parent_id);
	logg(" - Folder Id: " + folder_id);
	
	// Hide the element
	if (parent_id) {
		$("#sub_folder_" + folder_id).css("display", "none");
	}
	else {
		$("#folder_" + folder_id).css("display", "none");
	}
	
	// Delete on Server
	ajax_get_data("ajax.php?action=delete_folder&parent_id=" + parent_id + "&id=" + folder_id);
}

