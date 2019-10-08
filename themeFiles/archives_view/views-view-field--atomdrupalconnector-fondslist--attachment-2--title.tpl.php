<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
 //dpm($row);
 //$row->information_object_identifier;

 //Note: make sure the IDENTIFIER field is added before the TITLE field in the view
 if(isset($row->information_object_identifier) && $row->information_object_identifier) {
    $request_path = request_path();
	$fonds_num = intval($row->information_object_identifier);
	$title = trim($row->information_object_i18n_title);
	
	/***** slug creation STARTS here *****/
	//Note: this slug is NOT the same as the slug in AtoM!!!  For readability only
	$slug = strtolower($title);
	//replace non alphanumeric characters with underscores
	$slug = preg_replace('/[^a-z0-9]/', '_', $slug);
	//remove repeating underscore sign	
	$slug = preg_replace('/[_]{2,}/', '_', $slug);
	//TODO: remove underscore at the end of the string /_{1,}$/
	$slug = preg_replace('/_{1,}$/', '', $slug);
	/***** slug creation ENDS here *****/ 	
	
	//create link
    $link = $request_path . '/f' . $fonds_num . '_' . $slug;
	$output = l($title, $link); 
 }

?>
<?php print $output; ?>