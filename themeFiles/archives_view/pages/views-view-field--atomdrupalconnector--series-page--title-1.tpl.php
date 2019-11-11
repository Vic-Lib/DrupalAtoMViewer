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
 //dpm($row->information_object_identifier);
 //dpm($row->information_object_i18n_title);
 
 $identifier = $row->information_object_identifier;  //2065-5-1 Fonds-Series-Subseries
 $series_title = $row->information_object_i18n_title;
 
 $identifier_sliced = explode('-', $identifier);
 if(count($identifier_sliced) == 2) {
	 $output = 'Series ' . $identifier_sliced[1] . ': ' . $series_title;
 }
 
 if(count($identifier_sliced) == 3) {
	 $output = 'Series ' . $identifier_sliced[1] . ', Sub-Series ' . $identifier_sliced[2] . ': ' . $series_title;
 }
 
?>
<?php print $output; ?>