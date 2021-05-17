Forked From 
-----------
This is based on the Views Database Connector Module from:
https://www.drupal.org/project/views_database_connector

Clayfreeman came up with it and I stripped out everything except the MYSQL connector and then manually put in the links in the database tables.

Description
-----------
Views Database Connector is a powerful module that gives Views full access to external database tables found in the settings for your Drupal installation. With this module, you can setup a view around any table in any database configuration. This can be extremely useful to pull external data from a database to show to your users in a view.

The Drupal AtoM connector is a non generalized version of Views Database Connector, VDC was just used as a template.  In Drupal you can create blocks and add whatever sections you need based on an object.

For example adding in a fonds you can link another view in fields of notes types and then link based on id.  Because there can be multiple notes etc... on one record it was easier to add the relations in the Drupal View rather than in the Database Connector

Installation
------------

Move this directory into your Drupal module folder and enable it.

In your Drupal installation edit your sites settings.php file to include a second database connection called atomDatabase.  Make sure the database user has permission to read the AtoM sites database if it's hosted elsewhere.

 $databases['atomDatabase']['default'] = array(
     'driver' => 'mysql',
     'database' => '########',
     'username' => '########',
     'password' => '########',
     'host' => 'localhost',
     'prefix' => '',
   );


Requirements and Limitations
----------------------------
This module depends on access to the information_schema table when using MySQL.  These tables are used to gather information about your tables and their respective column names and data types. If you cannot accommodate this requirement, this module will not work. Also, any table names that conflict with Drupal table names cannot be used, and any conflicting table names among external databases will also need to be resolved. These restrictions are in place because of the way that Views has structured the return value of its hook_views_data() API.

Our setup
---------

We are using it to display an AtoM collection and have a sidebar module enabled as well.  This is just a JS picker that shows and hides two drupal attachments and that script is in another module.  

Utilization
-----------
You create a new view of an AtomDrupal Record.  There are other types, such as AtomDrupal Actor which relate back to the AtomDrupal Record.  Create a view of the subtype you want, such as AtomDrupal Actor, and then add the view to the field of the AtomDrupal Record with AtomID as the contextual filter.

Demo
----
The folder DrupalViews contains an example site.  Create new view from import for all of those and you will see a basic setup.


Issues
------

* The fonds list is setup with some specific ID keys.
* There are some unlabled fields and not every field has been transfered into the module
* The naming convention isn't formalized
* It has only been tested with AtoM version 2.4.0 - 156


Creating views
--------------

Properties and notes has a lot.  Language of material is under properties for example

For the relations you have to set them internally as views linking views.  If you build the relationships into the connector directly then you lose a lot of the styling options.  Thus I have created a few connection endpoint view types.  Use view connector and pass the id as the contextual filter, then the property, notes, etc... type can pull those fields.  You can filter by type, such as type=alternativeidentifier to get the alternative identifiers.


Language
-------------
It is possible to add properties like language.  However they take some processing because they are represtented as iso codes.

<?php

//sudo apt-get install php-intl

preg_match_all ('/".*?"/','{i:0;s:2:"en";i:1;s:2:"fr";}',$output);

$returnVar = "";

foreach ($output[0] as $language) {
  $returnVar .= locale_get_display_language(substr($language,1,-1), 'en') . ", ";
}

print substr($returnVar,0,-2).".";                                                                                         
?>