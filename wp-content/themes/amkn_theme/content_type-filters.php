<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>
<h2>Filter by Resource Type</h2>
<ul class="homebox-list">
<?php
$args1=array(
  'public'   => true,
  '_builtin' => false
);
$excludeTypes = array("flickr_photos");
$output = 'objects'; // names or objects
$operator = 'and'; // 'and' or 'or'
$post_types=get_post_types($args1,$output,$operator);
//asort($post_types);
$sortArray = array(); 
foreach($post_types as $post_type){ 
    foreach($post_type as $key=>$value){ 
        if(!isset($sortArray[$key])){ 
            $sortArray[$key] = array(); 
        } 
        $sortArray[$key][] = $value; 
    } 
}
$orderby = "menu_position";
array_multisort($sortArray[$orderby],SORT_ASC,$post_types);
echo '<form name="pts">';
  foreach ($post_types  as $post_type ) {
    if(!in_array($post_type->name, $excludeTypes)){
    echo '<li><input id="' . $post_type->name . '" class="homebox-check" type="checkbox" value="' . $post_type->name . '"  name="' . $post_type->name . '" onClick="updateDataLayer(true)">
    <label for="' . $post_type->name . '">' . $post_type->label . '
     <img src="' . get_template_directory_uri() . '/images/' . $post_type->name . '-mini.png" alt="' . $post_type->label . '"/></label></li>
    ';
      }
  }
  echo '</form>';
  echo '<li><div class="checkCtrls"><a href="javascript:void(0)" onClick="clearAllChecks(document.pts);">Clear selection</a></div></li>';
?>
</ul>