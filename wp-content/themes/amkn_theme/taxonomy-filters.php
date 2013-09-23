<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>
<h2>Filter by Resource Theme</h2>
<ul class="filters">
<?php
$args2=array(
  'public'   => true,
  '_builtin' => false

);
$excludeTaxonomies = array("cgmap-countries", "crops_livestock", "agroecological_zones", "farming_systems");

$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies=get_taxonomies($args2,$output,$operator);
if  ($taxonomies) {
    asort($taxonomies);
//echo '<div dojoType="dijit.form.DropDownButton" id="d_blank"><span>aaa</span><button dojoType="dijit.form.Button" type="submit"></button></div>';
  foreach ($taxonomies  as $taxonomy ) {
    if(!in_array($taxonomy->name, $excludeTaxonomies)){
$args3=array(
'orderby'   => 'name'
);
        $terms = get_terms($taxonomy->name, $args3);
        $count = count($terms);
         echo '<li><div class="taxonomies" dojoType="dijit.form.DropDownButton" id="d_' . $taxonomy->name . '">
    <span>' . $taxonomy->label . '</span>
    <div dojoType="dijit.TooltipDialog" class="hide" id="c_' . $taxonomy->name . '">
    <button dojoType="dijit.form.Button" type="submit" class="checkCtrls"><a>Close</a></button>
    <form name="' . $taxonomy->name . '">';
         if($count > 0){
            //asort($terms);
         echo '<ul class="taxListing">';
            foreach ($terms as $term) {
            echo '
            <li id="taxList"><input id="' . $taxonomy->name.'_'.$term->term_id . '" type="checkbox" name="' . $taxonomy->name.'_'.$term->term_id . '" value="'.$term->term_id . '" onClick="updateDataLayer(true)">
            <label for="' . $taxonomy->name.'_'.$term->term_id . '">
            ' .$term->name. '
            </label></li>
            ';
             }
         echo '</ul>';
         }

         echo '</form>
             <br clear="all" /><div class="checkCtrls"><a onclick="clearAllChecks(document.' . $taxonomy->name . ')" href="javascript:void(0)">Clear Selections</a></div>
</div></div></li>';
    }
  }
  echo '<li><div class="checkCtrls"><a onclick="clearAllTaxSelections();" href="javascript:void(0)">Clear Selection</a></div></li>';
}
?>
</ul>