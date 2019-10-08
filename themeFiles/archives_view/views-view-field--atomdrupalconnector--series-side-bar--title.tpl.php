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
    information_object_id (String, 4 characters ) 2868
    information_object_identifier (String, 6 characters ) 2133-1
    information_object_i18n_title (String, 26 characters ) Minutes and correspondence
 */
 
 
 
 $identifier = $row->information_object_identifier;
 $title = $identifier . '. ' . $row->information_object_i18n_title;
 $elements = explode('-', $identifier);
 //$link = 'archives/holdings/f' . $elements[0] . '/series_' . $elements[1];
 $attributes = array('attributes' => array('class' => array('sidebar_active')));

$request_path = request_path();
$dirs = explode('/', $request_path);
//fonds page
if(count($dirs) == 3) {
	$dirs[3] = 'series_' . $elements[1];
}

//series page
if(count($dirs) == 4) {
	$dirs[3] = 'series_' . $elements[1];
}

$link = implode('/', $dirs);
 
 //dpm(request_path());
 //dpm($view);
 //dpm($link);
 //dpm($_GET['q']);
 //TODO: add class active when $_GET['q'] == $link
 $output = l($title, $link, $attributes); 
?>
<?php print $output; ?>