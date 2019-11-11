<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 * 
 * 
 * You cant group by view type so the output style has to get rewritten to show by alphabet and category
 * 
 * The show hide button works with a css filter, add class="show-hide-button" to classes that should have the ability to expand
 * and class="sec-nav-open to the span that holds the text
 */

$baseClass = array (
  "Category" => 'class="special-collection-by-category"',
  "Alphabetical" => 'class="special-collection-by-alphabet" style="display: none;"',
);

$sorted_rows = array ();

foreach ($rows as $row) {
  $doc = new DOMDocument();
  $doc->loadHTML($row);
  foreach ($doc->getElementsByTagName("a") as $category) {    
    foreach ($baseClass as $key => $dontcare) {    
      $sorted_rows[$key][$doc->getElementById($key)->nodeValue][] = "<a href='".$category->getAttribute('href')."'> $category->textContent </a>";
    }
  }
}

ksort($sorted_rows["Alphabetical"]);

foreach (["Category","Alphabetical"] as $displayType): 
  print("<div ".$baseClass[$displayType].">"); 
    print "<h3>".($displayType)." List </h3>"; 
    foreach ($sorted_rows[$displayType] as $categoryName => $sorted_row_filter):?>
      <div class="collapsable-table" style="display:inline-block; width:100%">
        <table class="<?php print  str_replace("-","-",current($classes_array)) #beacuse drupal sends out _ as - ?> " style="width:100%">
          <thead class="show-hide-button">
            <tr class="field-name-field-ada-heading">
              <?php if (true): ?>
                <th><span class="sec-nav-open"></span>
                  <?php print($categoryName) ?>
                </th>
              <?php endif; ?>
            </tr>
          </thead>

          <tbody class="show-hide" >
            <tr>  
              <td>
                <?php 
                $count = ceil(sizeof($rows) / 2) + 1;
                $i = 0;
                foreach ($sorted_rows[$displayType][$categoryName] as $id => $row):
                  $i ++;
                  if ($i == $count) : ?>
                    </td>
                    <td>
                  <?php endif; ?>
                  <?php print ($row) ?>
                  <br>
                <?php endforeach; ?>
              </td>
            </tr>  
          </tbody>
        </table>
      </div>
    <?php endforeach;?>
  </div>
<?php endforeach;?>