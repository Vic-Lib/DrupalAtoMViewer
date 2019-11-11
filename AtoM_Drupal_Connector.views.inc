<?php

/**
 * @file
 * Responsible for hooking views to add each database and its tables.
 */

/**
 * Implements hook_views_data().
 * Describes data tables (or the equivalent) to Views.
 * This hook should be placed in MODULENAME.views.inc and it will be auto loaded. MODULENAME.views.inc must be in the directory specified by the 'path' key returned by MODULENAME_views_api(), or the same directory as the .module file, if 'path' is unspecified.
 * Return value
 * array An associative array describing the data structure. Primary key is the name used internally by Views for the table(s) – usually the actual table name. The values for the key entries are described in detail below.
 * 
 * https://api.drupal.org/api/views/views.api.php/function/hook_views_data/7.x-3.x
 * 
*/

//This doesn't work, it sets it to the views main title, not to the rendered output value for that page
/**
 * 
 * This function sets the TITLE of the View to the title of the AtoM node.  Probably not needed
 * The original idea, before I realized you can pre process in the header PHP code in the vew, was to set it up so it would add the title to the end of the breadcrumb.
 * 
 */

function AtoM_Drupal_Connector_views_pre_render(&$view) {
  if (($view->name == 'atomdrupalconnector') && (($view->current_display == 'fond_page')||($view->current_display == 'series_page'))) { 
    //Disabled now, here's to enable it:
    //$view->build_info['title'] = $view->result[0]->information_object_i18n_title;
    /*
    //This sets the breadcrumb trail so the end of it is the name of the current view
    $view->build_info['breadcrumb']['atomdrupalconnector/all'] = $view->result[0]->information_object_i18n_title;    
    $view->build_info['breadcrumb']['breadcrumb_args'] = $view->result[0]->information_object_i18n_title;
    */
  }
}

/**
 * Helper function to create a properly formatted data object that views will accept
 */

function Add_column_to_data($table, $data) {
  // Add each column to its respective table.
  foreach ($table[1] as $col) {
    if ($col[0] == 'numeric') {
      $data[$table[0]][$col[1]] = array(
        'title' => $col[2],
        'help' => $col[3],
        'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
        ),
        'sort' => array(
          'handler' => 'views_handler_sort',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_numeric',
        ),
        'argument' => array(
          'handler' => 'views_handler_argument_numeric',
        ),
      );
    }
    if ($col[0] == 'date') {
      $data[$table[0]][$col[1]] = array(
        'title' => $col[2],
        'help' => $col[3],
        
        'field' => array(
          'handler' => 'views_handler_field_date',
          'click sortable' => TRUE,
        ),
        'sort' => array(
          'handler' => 'views_handler_sort_date',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_date',
        ),

      );
    }
    if ($col[0] == 'string') {
      $data[$table[0]][$col[1]] = array(
        'title' => $col[2],
        'help' => $col[3],
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
        ),
        'sort' => array(
          'handler' => 'views_handler_sort',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_string',
        ),
        'argument' => array(
          'handler' => 'views_handler_argument_string',
        ),
      );
    }
    if ($col[0] == 'broken') {
      $data[$table[0]][$col[1]] = array(
        'title' => $col[2],
        'help' => $col[3],
        
  	'field' => array(
          'handler' => 'views_handler_field_broken',
          'click sortable' => TRUE,
        ),
        'sort' => array(
          'handler' => 'views_handler_sort_broken',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_broken',
        ),
        'argument' => array(
          'handler' => 'views_handler_argument_broken',
        ),
      );
    }
  }
  return $data;
} 

/**
 * implements hook_views_data()
 * This defines the relationships between elements in the AtoM database and then sends that relationship information to Views so it can properly display it
 */

function AtoM_Drupal_Connector_views_data() {

  //Array to return to Drupal Views with properly formatted paths for the data
  $data = array ();  

  ////////////////////////////////////////////////////////////////////
  ///////// Database relationship to the entity
  ////////////////////////////////////////////////////////////////////

  //Define tables
  
  $data['information_object']['table']['group'] = t('AtoMitems');
  $data['information_object_i18n']['table']['group'] = t("AtoMitems");
  $data['digital_object']['table']['group'] = t("AtoMitems");

  //Define Joins

  //This is the base AtoM node definition for entering the view.
  $data['information_object']['table']['base'] = array(
    'field' => 'level_of_description_id',
    'title' => t('AtoM Connecton Records'),
    'database' => "atomDatabase",
    'help' => t('This is the main AtoM Database'),
    'weight' => -10,
  );

  //These are the joins between tables which relate to the db entry point
  $data['information_object_i18n']['table']['join'] = array(
    'information_object' => array(
      'left_field' => 'id',
      'field' => 'id',
    ),
  );

  $data['digital_object']['table']['join'] = array(
    'information_object' => array(
      'left_field' => 'id',
      'field' => 'information_object_id',
    ),
  );

  //Define table elements and give plain text description

  $io_table = array('information_object',array(
    array ("numeric","id","id","The AtoM id"),
    array ("numeric","level_of_description_id","Level of Description","This is the AtoM node type, fonds 227, series 230, subseries 231, file 232"),
    array ("numeric","parent_id","Parent ID","This is the parent of the AtoM node, so for a file it would be a series"),
    array ("string","identifier","Identifier","The fonds or location of the collection or object"),
    //array ("string","object_id","Object ID","The index of actors related to this collection"),
  ));


  $io_i18n_table = array('information_object_i18n',array(  
    array ("string","title","title","The title of the AtoM object"),
    array ("string","alternate_title","alternate title","Alternate title"),
    array ("string","edition","edition","the edition"),
    array ("string","extent_and_medium","Extent and Medium","The size and type of the holding"),
    array ("string","archival_history","archival history","The archival history"),
    array ("string","acquisition","Imediate Source of Acquisition","The Immediate Source of Acquisition or transfer"),
    array ("string","scope_and_content","Scope and Content","The type of object held"),
    array ("string","appraisal","Appraisal","Appraisal field"),
    array ("string","accruals","accrurals","DESCRIPTION"),
    array ("string","arrangement","arrangement","DESCRIPTION"),
    array ("string","access_conditions","access conditions","DESCRIPTION"),
    array ("string","reproduction_conditions","reprodction conditions","DESCRIPTION"),
    array ("string","physical_characteristics","physical characteristics","DESCRIPTION"),
    array ("string","finding_aids","finding aids","DESCRIPTION"),
    array ("string","location_of_originals","location of originals","DESCRIPTION"),
    array ("string","location_of_copies","location of copies","DESCRIPTION"),
    array ("string","related_units_of_description","related units of description","DESCRIPTION"),
    array ("string","institution_responsible_identifier","institution responsible identifier","DESCRIPTION"),
    array ("string","rules","rules","DESCRIPTION"),
    array ("string","sources","sources","This is NOT immediate source of acquisition, but rather sources under descirption control area"),
    array ("string","revision_history","revision history","DESCRIPTION"),
  ));

  $digital_object_table = array('digital_object',array(  
    array ("string","path","URL","digital object"),
    array ("string","name","Title of digital object","Title of the digital object"),
    array ("string","byte_size","Size (bytes)","Size of the digital object"),
    array ("nunmeric","information_object_id","information object id","AtoM node the digital object relates to"),
    )
  );

  //Add database record to main data object 

  $data = Add_column_to_data($io_table, $data);
  $data = Add_column_to_data($io_i18n_table, $data);
  $data = Add_column_to_data($digital_object_table, $data);

  ////////////////////////////////////////////////////////////////////
  ///////// Notes as related to AtoM item...
  ////////////////////////////////////////////////////////////////////

  //Define tables
  
  $data['note']['table']['group'] = t("AtoMConnector_General Notes");
  $data['term_i18n']['table']['group'] = t("AtoMConnector_General Notes");  
  $data['note_i18n']['table']['group'] = t("AtoMConnector_General Notes");

  //Define Joins

  $data['note']['table']['base'] = array(
    'field' => 'level_of_description_id',
    'title' => t('AtoM Connecton Notes'),
    'database' => "atomDatabase",
    'help' => t('these are the general notes and their headers'),
    'weight' => -10,
  );
  
  $data['note_i18n']['table']['join'] = array(
    'note' => array(
      'left_field' => 'id',
      'field' => 'id',
      //'left_table' => 'note'
    ),
  );

  $data['term_i18n']['table']['join'] = array(
    'note' => array(
      'left_field' => 'type_id',
      'field' => 'id',
      //'left_table' => 'note',
    ),
  );

  //Define table elements and give plain text description
  
  $note_table = array('note',array(
    array ("string","id","Note ID","This is the notes id"),
    array ("string","object_id","AtoM object ID","This is the ID of the AtoM item the note is attached to"),
    array ("string","source_culture","Language Tag","This is the language setting of the note which defines the title"),
    )
  );
  
  $note_i18n_table = array('note_i18n',array(
    array ("string","content","Note content","This is the title of the general note attached to the atom record"),
    )
  );

  $term_i18n_table = array('term_i18n',array(
    array ("string","name","Note title","This is the title of the general note attached to the atom record"),
    array ("string","culture","Language Options","This is the language this term is in"),

    )
  );

  //Add database record to main data object 

  $data = Add_column_to_data($note_table, $data);
  $data = Add_column_to_data($term_i18n_table, $data);
  $data = Add_column_to_data($note_i18n_table, $data);

  ////////////////////////////////////////////////////////////////////
  ///////// Event...
  ////////////////////////////////////////////////////////////////////


  $data['event']['table']['group'] = t("AtoMitems");
  $data['event_i18n']['table']['group'] = t("AtoMitems");

  $data['event']['table']['base'] = array(
    'field' => 'level_of_description_id',
    'title' => t('AtoM Connecton Events'),
    'database' => "atomDatabase",
    'help' => t('These are events related to an item'),
    'weight' => -10,
  );

  $data['event_i18n']['table']['join'] = array(
    'event' => array( 
      'left_field' => 'id',
      'field' => 'id',
      //'left_table' => 'event',
    ),
  );

  $event_table = array('event',array(
    array ("string","object_id","Object ID","This is the id to join the atom record with"),    
    )
  );

  $event_i18n_table = array('event_i18n',array(
    array ("string","date","Date","The date(s)"),
    )
  );

  $data = Add_column_to_data($event_table, $data);
  $data = Add_column_to_data($event_i18n_table, $data);

  ////////////////////////////////////////////////////////////////////
  ///////// Actor...
  ////////////////////////////////////////////////////////////////////

  $data['actor']['table']['group'] = t("AtoMitems");
  $data['actor_i18n']['table']['group'] = t("AtoMitems");

  $data['actor']['table']['base'] = array(
    'field' => 'level_of_description_id',
    'title' => t('AtoM Connecton Actor'),
    'database' => "atomDatabase",
    'help' => t('These are actors related to an item'),
    'weight' => -10,
  );

  $data['actor_i18n']['table']['join'] = array(
    'actor' => array(
      'left_field' => 'id',
      'field' => 'id',
      //'left_table' => 'actor',
    ),
  );

  $data['event']['table']['join'] = array(
    'actor' => array(
      'left_field' => 'id',
      'field' => 'actor_id',
      //'left_table' => 'actor',
    ),
  );

  $event_table = array('event',array(
    array ("string","id","actor ID","The ObjectID of the atom Record to connect with"),
    )
  );

  $actor_table = array('actor',array(
    array ("string","id","ID","This ID relates to the event table"),
    )
  );

  $actor_i18n_table = array('actor_i18n',array(
    array ("string","authorized_form_of_name","Authorized form of name","The name of the actor"),
    array ("string","history","History","Bibliographic History"),
    )
  );

  $data = Add_column_to_data($event_table, $data);
  $data = Add_column_to_data($actor_table, $data);
  $data = Add_column_to_data($actor_i18n_table, $data);

  ////////////////////////////////////////////////////////////////////
  ///////// Property...
  ////////////////////////////////////////////////////////////////////

  $data['property']['table']['group'] = t("AtoMitems");
  $data['property_i18n']['table']['group'] = t("AtoMitems");

  $data['property']['table']['base'] = array(
    'field' => 'level_of_description_id',
    'title' => t('AtoM Connecton Property'),
    'database' => "atomDatabase",
    'help' => t('These are events related to an item'),
    'weight' => -10,
  );

  $data['property_i18n']['table']['join'] = array(
    'property' => array(
      'left_field' => 'id',
      'field' => 'id',
      //'left_table' => 'property',
    ),
  );

  $property_table = array('property',array(
    array ("string","object_id","Object ID", "Object ID of the AtoM record"),
    array ("string","scope","Additional Attribute TYPE","The AtoM defined type of the additaional attribute, for example alternativeIdentfiers"),
    array ("string","name","Additional Attribute NAME","User generated name for the class of addional identifiers, for example \"category\""),
    )
  );

  $property_i18n_table = array('property_i18n',array(
    array ("string","value","Additional Attribute VALUE","Additional attribute for the item, like a category"),
    )
  );

  $data = Add_column_to_data($property_table, $data);
  $data = Add_column_to_data($property_i18n_table, $data);
  
  ////////////////////////////////////////////////////////////////////
  ///////// Final return statement with the complete database connectors
  ////////////////////////////////////////////////////////////////////

  return $data;
}


//TODO generalize this template

////////////////////////////////////////////////////////////////////
///////// Template for adding a database...
////////////////////////////////////////////////////////////////////

//Define tables

//The array define the AtoM database tables that are reference
//the element in the array are formatted as such:
//$data['TABLE NAME']['table']['group'] = t("AtoMitems");
//$data['term_i18n']['table']['group'] = t("AtoMConnector_General Notes");  

//Define Joins

/*
$data['note']['table']['base'] = array(
  'field' => 'level_of_description_id',
  'title' => t('AtoMConnector_General Notes'),
  'database' => "atomDatabase",
  'help' => t('This is a list of general notes'),
  'weight' => -10,
);

//Template For how to add another table to the base table

$data['TABLENAMETOJOIN']['table']['join'] = array(
  'information_object' => array(
    'left_field' => 'id field in information_object',
    'field' => 'id, colum in this table', 
    'left_table' => 'if the left table isnt the main one but one already in a relation list it here', 
  ),
);
*/

//Define table elements and give plain text description

/*

//$table [table_name,[datatype,SQLcolumnName,UserTitle,Description]]
//array ("string","COLIMN NAME","TITLE","DESCRIPTION"),

$note_table = array('note',array(
  array ("string","id","Note ID","This is the notes id"),
  array ("string","object_id","AtoM object ID","This is the ID of the AtoM item the note is attached to"),
  )
);
*/

//Add database record to main data object 

//$data = Add_column_to_data($note_table, $data);



////////////////////////////////////////////////////////////////////
///////// Notes, ignore.
////////////////////////////////////////////////////////////////////

//CLEAR CACHE AFTER CHANGING THIS

//Note the dummy name otherwise it'll overwrite info in a real table heading
/*  $data['information_object']['dummy_name'] = array (
//$data['event']['object_id']['relationship'] = array (

  'title' => t('Sample relationship, Date relationship'),
  'help' => t('this links to the date field.'),
  'relationship' => array(
    //Table Joining to
    'base' => 'information_object',
    //Field on the joined table
    'base field' => 'parent_id',
    //real field in the main table we're goinging to 
    'field' => 'id',
    'handler' => 'views_handler_relationship',
    'label' => t('model answer'),
    'title' => t('Title seen when adding relationship'),
    'help'  => t('Help info about relationship'),
  ),
);
*/


/*

$data['information_object']['id']['relationship'] = array (
//$data['event']['object_id']['relationship'] = array (

    'base' => 'information_object',
    'base field' => 'parent_id',
    'field' => 'id',
    'handler' => 'views_handler_relationship',

    'label' => t('model answer'),
    'title' => t('Date relationship'),
    'help' => t('this links to the date field.'),
  );

*/


/* Creating a relationship
This technique works, BUT it simply moves the construction of the one to many relationship into the drupal relationship builder.  It is in effect the same join so not very useful.  Likely the best in Drupal option would be to have the date and notes field as a seprate view linked in 
*/

/*



//This allows the event to be seprate...
$data['event']['table']['base'] = array(
  'field' => 'level_of_description_id',
  'title' => t('AtoMEvents'),
  'database' => "atomDatabase",
  'help' => t('This is the help about the field for some reason'),
  'weight' => -10,
);



$data['information_object']['id']['relationship'] = array (
//$data['event']['object_id']['relationship'] = array (

    'base' => 'event',
    'base field' => 'object_id',
    'field' => 'id',
    'handler' => 'views_handler_relationship',

    'label' => t('model answer'),
    'title' => t('Date relationship'),
    'help' => t('this links to the date field.'),
  );
*/


