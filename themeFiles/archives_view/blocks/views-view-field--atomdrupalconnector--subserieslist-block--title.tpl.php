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
 
/*
    information_object_identifier (String, 8 characters ) 2063-4-1
    information_object_id (String, 5 characters ) 24376 <-------------- SUB-SERIES
    information_object_parent_id (String, 5 characters ) 24374 <------- SERIES
    information_object_i18n_title (String, 44 characters ) Files on teaching staff (general categories)
*/ 
 //dpm($row);
 
 $current_path = current_path();
 //dpm($current_path);
 
 $identifier = $row->information_object_identifier; 
 $elements = explode('-', $identifier);
 $subseries = 'subseries_' . $elements[2];
 
 $title = 'Sub-series ' . $elements[2] . ': ' . $row->information_object_i18n_title;
 $link = $current_path . '/' .  $subseries;
 //dpm($link);
 $output = l($title, $link);  
 
?>
<?php print $output; ?>