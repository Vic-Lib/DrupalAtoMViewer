<?php

/**
 * 

  This is the alphabetic view for special collections.  Each category section is sent to this for rendering
 
 * * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */


?>


<div class="collapsable-table" style="display: 
<?php
if (preg_match("/.*alphabet.*/",current($classes_array), $match)) { 
  print "inline-block;";
} else {
  print "inline-block;";

}
?> width:100%">



<table class="<?php print  str_replace("-","-",current($classes_array)) #beacuse drupal sends out _ as - ?> " style="width:100%">
  <thead class="show-hide-button">
	<tr class="field-name-field-ada-heading">
	<?php if (!empty($title)): ?>
	    <th><span class="sec-nav-open"></span>
<?php print $title; ?></th>
	<?php endif; ?>
	</tr>
  </thead>


<tbody class="show-hide" >
  <tr>  
    <td>
    <?php 
    $count = ceil(sizeof($rows) / 2) + 1;
    $i = 0;
    ?>

    <?php foreach ($rows as $id => $row): 
      
      $i ++;
      if ($i == $count) : ?>
        </td>
        <td>
      <?php endif; ?>

      <?php print $row;?>
      <br>
    <?php endforeach; ?>
  </td> 
</tbody>
</table>

</div>
