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
 //dpm(get_defined_vars()); 
 //dpm(arg());
 //dpm($view);
 
/** 
Shorten the identifier so that it starts at the Accession number
Before:
2167-5-2007.005V 10-7
After:
2007.005V 10-7
*/
 
preg_match('/[0-9]{4}\..*/', $output, $match);
if($match) {
	$new_output = '<span class="file_details" data-identifier="' . $output . '"></span>' . $match[0];
	$output = $new_output;
}


//<span class="" data-id=""></span>
 
?>
<?php print $output; ?>