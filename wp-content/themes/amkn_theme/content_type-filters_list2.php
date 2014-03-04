<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>

<?php
$args1 = array(
    'public' => true,
    '_builtin' => false
);
$excludeTypes = array("flickr_photos", "agtrials","ccafs_activities");
$output = 'objects'; // names or objects
$operator = 'and'; // 'and' or 'or'
$post_types = get_post_types($args1, $output, $operator);
$sortArray = array();
foreach ($post_types as $post_type) {
    foreach ($post_type as $key => $value) {
        if (!isset($sortArray[$key])) {
            $sortArray[$key] = array();
        }
        $sortArray[$key][] = $value;
    }
}
$orderby = "menu_position";
array_multisort($sortArray[$orderby], SORT_ASC, $post_types);
?>
<!-- java script to configure the custom post types that are in the tree -->
<script type="text/javascript">
  <?php 
  $bookmarks = get_bookmarks( array(
      'orderby'        => 'name',
      'order'          => 'ASC',
      'category_name'  => 'MapServerLayers'
  ));
  ?>
    var treeData = [
<?php
$fst = 1;
foreach ($post_types as $post_type) {
    if (!in_array($post_type->name, $excludeTypes)) {
        echo $fst == 1 ? "" : ",";
        $fst = 0;
        echo "{ title: \"" . $post_type->label . "\", 
                key: \"accord_" . $post_type->name . "\", 
                noLink: true, 
                isFolder: false,                
//                select: true,
                selectMode: 2,
                hideCheckbox: false,
                    ";
        switch ($post_type->name) {
            case "ccafs_sites":
                echo "icon: \"../../../../images/ccafs_sites-mini.png\",";
                break;
            case 'video_testimonials':
                echo "icon: \"../../../../images/video_testimonials-mini.png\",";
                break;
            case 'amkn_blog_posts':
                echo "icon: \"../../../../images/amkn_blog_posts-mini.png\",";
                break;
            case 'biodiv_cases':
                echo "icon: \"../../../../images/biodiv_cases-mini.png\",";
                break;
            case 'photo_testimonials':
                echo "icon: \"../../../../images/photo_testimonials-mini.png\",";
                break;
            case 'ccafs_activities':
                echo "icon: \"../../../../images/ccafs_activities-mini.png\",";
                break;
        }
        echo "
            children: [ // Pass an array of nodes.
                ]
            }";
    }
}
$layers =  ",{ title: \"Data Layer (".count($bookmarks).")\", 
                key: \"accord_data_layer\", 
                noLink: true, 
                isFolder: true,
                hideCheckbox: true,            
                select: false,
                icon: '../../../../images/data_layersM.png',
                selectMode: 3,
                children: [";
$i=0;
foreach($bookmarks as $bm) {
  $bmLStr = explode("||",$bm->link_url);
  if(count($bmLStr) == 1){
    $bmLURL = $bm->link_url;
    $singleLayer = "null";
  } else{
    $bmLURL = $bmLStr[0];
    $singleLayer = $bmLStr[1];
  }
  $layers .= "{title: '".$bm->link_name."', isFolder: true, hideCheckbox: true, key: 'aglyr".$bm->link_id."-".$singleLayer."-".$bmLURL."-".$bm->link_id."'},";
//  $layers .= "children: [ test[".$i."]]},";
  $i++;
}
$layers .=    "]
       }";
echo $layers;

$args2=array(
  'public'   => true,
  '_builtin' => false

);
$excludeTaxonomies = array("cgmap-countries", "crops_livestock", "agroecological_zones", "farming_systems");

$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies=get_taxonomies($args2,$output,$operator);
if  ($taxonomies) {
  $taxoTree =  ",{ title: \"Filter by Resource Theme\", 
                key: \"accord_filter_resource_theme\", 
                noLink: true, 
                isFolder: true,
                //hideCheckbox: true,            
                //select: false,
                //icon: '../../../../images/data_layersM.png',
                selectMode: 3,
                children: [";
  asort($taxonomies);
  foreach ($taxonomies  as $taxonomy ) {
    if(!in_array($taxonomy->name, $excludeTaxonomies)){
      $args3=array(
      'orderby'   => 'name'
      );
      $terms = get_terms($taxonomy->name, $args3);
      $count = count($terms);
      $taxoTree .= "{title: '".$taxonomy->label." (".$count.")', 
                     isFolder: true, 
                     key: '".$taxonomy->name."',
                     selectMode: 3,
                     children: [";
      if($count > 0){
        foreach ($terms as $term) {
          $taxoTree .= "{title: '".$term->name."',                       
                        key: 'taxio_".$term->term_id."',
                        },";
        }
      }
      $taxoTree .= "]},";      
    }
  }
  $taxoTree .=    "]
       }";
  echo $taxoTree;
}
?>        
    ];
</script>
<!-- div element in wich the tree will appear. -->
<!--<div id="cFiltersList2" style="width: 100%; height: 68%; overflow: hidden;">
</div>  end cFiltersList2-->

<div dojoType="dijit.layout.AccordionContainer" minSize="20" style="width: 100%; height: 98%; overflow: hidden;"
     id="cFiltersList" region="top" splitter="true">
    <div class="onmap" id="accord_content" dojoType="dijit.layout.AccordionPane" title="Content">
        <div id="cFiltersList2" style="width: 100%; height: 100%; overflow: hidden;">
        </div>
    </div> 
    <div class="onmap" id="accord_legend" dojoType="dijit.layout.AccordionPane" title="Data Legend">
        <div id="legendDiv"></div>
    </div>  
</div>
