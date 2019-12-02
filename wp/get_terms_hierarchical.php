<?php
  function get_terms_hierarchical($terms, $output = '', $parent_id = 0, $level = 0) {
    //Out Template
    $outputTemplate = '<option value="%ID%">%PADDING%%NAME%</option>';

    foreach ($terms as $term) {
      if ($parent_id == $term->parent) {
        //Replacing the template variables
        $itemOutput = str_replace('%ID%', $term->term_id, $outputTemplate);
        $itemOutput = str_replace('%PADDING%', str_pad('', $level*12, '&nbsp;&nbsp;'), $itemOutput);
        $itemOutput = str_replace('%NAME%', $term->name, $itemOutput);

        $output .= $itemOutput;
        $output = get_terms_hierarchical($terms, $output, $term->term_id, $level + 1);
      }
    }
    return $output;
}

$terms = get_terms('product_cat', array('hide_empty' => false));
$output = get_terms_hierarchical($terms);

echo '<select>';
echo '<option value="" disabled selected>' . __("Select Category") . '</option>';
echo $output . '</select>';  
?>