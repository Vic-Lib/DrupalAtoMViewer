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
 
 /*
    information_object_identifier (String, 6 characters ) 2063-1
    information_object_id (String, 5 characters ) 23694 <---------- SERIES
    information_object_parent_id (String, 5 characters ) 23689 <--- FONDS
    information_object_i18n_title (String, 30 characters ) Correspondence / Subject Files
 */
 
 $current_path = current_path();
 
 $identifier = $row->information_object_identifier; 
 $elements = explode('-', $identifier);
 $series = 'series_' . $elements[1];
 
 $title = 'Series ' . $elements[1] . ': ' . $row->information_object_i18n_title;
 $link = $current_path . '/' .  $series;
 $output = l($title, $link); 
  
?>
<?php print $output; ?>