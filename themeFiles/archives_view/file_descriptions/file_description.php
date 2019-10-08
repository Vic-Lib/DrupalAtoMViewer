<?php
include 'simple_html_dom.php';

header('Content-Type: text/html; charset=utf-8');

//$identifier = '2167-5-2007.005V 10-8';
$identifier = $_GET['identifier'];
$slug = get_slug_by_identifier($identifier);

if($slug) {
  echo get_file_description_by_slug($slug);
}

/***** HELPER FUNCTIONS *****/

function get_slug_by_identifier($identifier) {
  $url = 'http://128.100.124.191:9200/atom/QubitInformationObject/_search?q=referenceCode:' . urlencode('"*' . $identifier . '"');
  $contents = file_get_contents($url);
  $result = json_decode($contents, TRUE);

  if(isset($result['hits']['hits'][0]['_source']['slug']) && $result['hits']['hits'][0]['_source']['slug']) {
    $slug = $result['hits']['hits'][0]['_source']['slug'];
    return $slug;
  }

  return FALSE;
}

function get_file_description_by_slug($slug) {
  $url = 'http://128.100.124.191/index.php/' . $slug;
  //echo $url;

  $contents = file_get_html($url);

  //remove empty fields
  foreach($contents->find('section') as $section_key => $section) {
    $num_fields = count($contents->find('section', $section_key)->find('.field'));
    $num_fields_removed = 0;
    foreach($section->find('.field') as $field_key => $field) {
      foreach($field->find('div') as $div_key => $div) {
        //echo $div->outertext . PHP_EOL;
        $text = trim($div->plaintext);
        if(empty($text)) {
          $contents->find('section', $section_key)->find('.field', $field_key)->outertext = '';
          $num_fields_removed++;
        }
      }
    }
    if($num_fields == $num_fields_removed) {
      $contents->find('section', $section_key)->outertext = '';
    }
  }

  //remove links
  foreach($contents->find('a') as $link_key => $link) {
    $innertext = $link->innertext;
    $contents->find('a', $link_key)->outertext = $innertext;
  }

  $output = $contents->find('#content', 0)->innertext;

  //clear everything to prevent memory leak
  $contents->clear();
  unset($contents);

  return $output;
}
