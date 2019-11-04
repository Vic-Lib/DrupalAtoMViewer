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
 
 //dpm(arg());
 //dpm($row);
 //$row->information_object_identifier 
 //dpm($output);
 /*
 //arguments from the url
 $args = arg();
 $fonds = $args[2];
 
 //elements from the identifier (split by -) 
 $identifier = $row->information_object_identifier; 
 $identifier_splited = explode('-', $identifier); 
 
 $args[3] = 'series_' . $identifier_splited[1];
 $args[4] = 'subseries_' . $identifier_splited[2];
  
 $link = implode('/', $args); 
 $pattern = '/href="(.*?)"/';
 $replacement = 'href="/' . $link . '"';
 $output = preg_replace($pattern, $replacement, $output);
 */
 
 
 ////////////////////////
 
 
 //NOTE: this override file is for the VISIBLE row only
   
 //hidden row is $row->views_php_4
 //visible row is $row->views_php_5
 
 //dpm($view->args);
 //dpm(current_path());  
 
 
if($row->views_php_5) {

	//arguments from the url
	$args = arg();
	$fonds = $args[2]; 

	//elements from the identifier (split by -) 
	$identifier = $row->information_object_identifier; 
	$identifier_splited = explode('-', $identifier); 

	$args[3] = 'series_' . $identifier_splited[1];
	$args[4] = 'subseries_' . $identifier_splited[2];

	$link = implode('/', $args); 
	//$pattern = '/href="(.*?)"/';
	//$replacement = 'href="/' . $link . '"';
	//$output = preg_replace($pattern, $replacement, $output);

	//build link 
	$title = $identifier_splited[2] . '. ' . $row->information_object_i18n_title;
	$attributes = array('attributes' => array('class' => array('sidebar_active')));
	$output = l($title, $link, $attributes); 

} 
 
 
?>
<?php print $output; ?>