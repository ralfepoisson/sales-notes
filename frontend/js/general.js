/*
##################################################################
#
#         PROJECT
#
#         General JavaScript Functions
#
#         Ralfe Poisson
#         ralfepoisson@gmail.com
#         http://www.implyit.co.za
#
##################################################################

This Script contains javascript functions of a general nature.

*/

// Automatically sets focus to the first non hidden, non-disabled
// input element on the page.

function logg(message) {
	// Output Message
	console.log(message);
}

function auto_focus() {
	var bFound = false;
	
	// for each form
	for (f=0; f < document.forms.length; f++) {
		// for each element in each form
		for(i=0; i < document.forms[f].length; i++){
			// if it's not a hidden element
			if (document.forms[f][i].type != "hidden"){
				// and it's not disabled
				if (document.forms[f][i].disabled != true){
					// set the focus to it
					document.forms[f][i].focus();
					var bFound = true;
				}
			}
			// if found in this element, stop looking
			if (bFound == true) break;
		}
		// if found in this form, stop looking
		if (bFound == true) break;
	}
}

function makePOSTRequest(url, parameters) {
        http_request = false;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
                 http_request = new XMLHttpRequest();
                 if (http_request.overrideMimeType) {
                        // set type accordingly to anticipated content type
                        //http_request.overrideMimeType('text/xml');
                        http_request.overrideMimeType('text/html');
                 }
        } else if (window.ActiveXObject) { // IE
                 try {
                        http_request = new ActiveXObject("Msxml2.XMLHTTP");
                 } catch (e) {
                            try {
                                http_request = new ActiveXObject("Microsoft.XMLHTTP");
                            } catch (e) {}
                 }
        }
        if (!http_request) {
                 alert('Cannot create XMLHTTP instance');
                 return false;
        }

        http_request.onreadystatechange = alertContents;
        http_request.open('POST', url, true);
        http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http_request.setRequestHeader("Content-length", parameters.length);
        http_request.setRequestHeader("Connection", "close");
        http_request.send(parameters);
}

function alertContents() {
        if (http_request.readyState == 4) {
		post_result = http_request.responseText;                 
        }
}

function isset( variable ) {
        return (!(variable == null));
}

function fetch_element( element ) {
	// Get Element
	var e = "";
	e = document.getElementById(element);
	if (e == null) {
		e = document.all.namedItem(element);
	}
	
	// Return Element
	return e
}

function add_table_row(tableRef, fields, tr_id){
        // Get Table Element
        var table = fetch_element(tableRef);
        
        // Create a new Row
        var row = document.createElement('tr');
        
        // Set TR's ID
        var attr = document.createAttribute('id');
        attr.nodeValue = tr_id;
        row.setAttributeNode(attr);
        
        // Add Cells to Row
        for (x = 0; x < fields.length; x++) {
                var cell = document.createElement('td');
                cell.innerHTML = fields[x];
                row.appendChild (cell);
        }
        
        // Add Row to Table
        table.appendChild(row);
} 

function get_browser() {
        // Get Browser and Version
        var browser = navigator.appName;
        var b_version = navigator.appVersion;
        
        // Return in an Array
        return Array(browser, b_version);
}

function toggel_section(section) {
	// Get Visibility Settings
	var obj                                 = fetch_element(section);
	var current                             = obj.style.display;
	
	// Toggle
	if (current                             == "none") {
		obj.style.display               = "block";
	}
	else {
		obj.style.display               = "none";
	}
}

function trim(stringValue) {
	// Local Variables
	var newString				= "";
	
	// Remove Surrounding White Space
	newString				= stringValue.replace(" ", "");
	newString				= newString.replace("\n", "");
	newString				= newString.replace("\r", "");
	
	// Return String
	return newString;
}

function confirm_delete(delete_page) {
	var where_to= confirm ("Are you sure you want to delete this item?");
	if (where_to== true) {
		window.location = delete_page;
	}
	else {
		// Nothing
	}

}

function confirm_update(submit_form, message) {
	var where_to= confirm (message);
	if (where_to== true) {
		document.getElementById(submit_form).submit();;
	}
	else {
		// Nothing
	}

}

function set_all_checkboxes(thisform, value)
{
	if(!document.forms[thisform]) {
		return;
	}
	
	var objElements = document.forms[thisform].elements;
	
	if(!objElements) {
		return;
	}
	
	var countElements = objElements.length;
	
	if(!countElements) {
		//objElements.checked = value;
	}
	else {
		// set the check value for all check boxes
		for(var i = 0; i < countElements; i++) {
			if (objElements[i].type == "checkbox") {
				objElements[i].checked = value;
			}
		}
	}
}

function get_url_part(this_part) {
	var parts = window.location.search.substr(1).split("&");
	var $_GET = {};
	for (var i = 0; i < parts.length; i++) {
    	var temp = parts[i].split("=");
    	$_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    	return $_GET[this_part];
	}
}

function disableEnterKey(e) {
     var key;

     if(window.event)
          key = window.event.keyCode;     //IE
     else
          key = e.which;     //firefox

     if(key == 13)
          return false;
     else
          return true;
}

function get_selected_item(select_id) {
	return document.getElementById(select_id).options[fetch_element(select_id).selectedIndex].value;
}

function get_selected_text(select_id) {
	return document.getElementById(select_id).options[fetch_element(select_id).selectedIndex].text;
}

function ajax_get_data(this_url) {
	// Get Response
	var new_html = $.ajax({
		url: this_url,
		async: false,
		dataType: "html"
	}).responseText;
	
	// Return Response
	return new_html;
}

$(document).ready(function(){
	$('.date').datepicker({
		dateFormat: 'yy-mm-dd'
	});
});

