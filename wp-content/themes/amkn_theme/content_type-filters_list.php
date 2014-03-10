<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>
<div dojoType="dijit.layout.AccordionContainer" minSize="20" style="width: 100%; height: 98%; overflow: hidden;"
            id="cFiltersList" region="top" splitter="true">
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
  foreach ($post_types  as $post_type ) {
    if(!in_array($post_type->name, $excludeTypes)){
    echo '<div class="onmap" id="accord_' . $post_type->name . '" dojoType="dijit.layout.AccordionPane" title="' . $post_type->label . '"><div id="onmap_' . $post_type->name . '"></div></div>';
      }
  }
?>
<div class="onmap" id="accord_legend" dojoType="dijit.layout.AccordionPane" title="Data Legend">
<div id="legendDiv"></div>
</div>  
</div>