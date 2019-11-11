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
 
 $fonds = arg(2); 
 $new_output = str_replace($row->information_object_id, $fonds, $output); 
 
 if(function_exists('_pratt_get_href')) {
	$href = _pratt_get_href($new_output);
	$href = substr($href, 1);  //skip the leading slash
	$new_output = l('Fonds', $href);
 }
 
 $output = $new_output;
 
?>
<?php print $output; ?>