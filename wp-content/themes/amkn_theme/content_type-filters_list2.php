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
$excludeTypes = array("flickr_photos", "agtrials");
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
    var treeData = [
<?php
$fst = 1;
foreach ($post_types as $post_type) {
    if (!in_array($post_type->name, $excludeTypes)) {
//                echo "<li class='onmap' id='accord_" . $post_type->name . "' > 
//                    <a href='javascript:void(0)'>" . $post_type->label . "</a>
//                    </li>";
        echo $fst == 1 ? "" : ",";
        $fst = 0;
        echo "{ title: \"" . $post_type->label . "\", 
                key: \"accord_" . $post_type->name . "\", 
                noLink: true, 
                isFolder: false,                
                select: true,
                selectMode: 2,
                hideCheckbox: true,
                    ";
        switch ($post_type->name) {
            case "ccafs_sites":
                echo "icon: \"../../../images/ccafs_sites-mini.png\"";
                break;
            case 'video_testimonials':
                echo "icon: \"../../../images/video_testimonials-mini.png\"";
                break;
            case 'amkn_blog_posts':
                echo "icon: \"../../../images/amkn_blog_posts-mini.png\"";
                break;
            case 'biodiv_cases':
                echo "icon: \"../../../images/biodiv_cases-mini.png\"";
                break;
            case 'photo_testimonials':
                echo "icon: \"../../../images/photo_testimonials-mini.png\"";
                break;
        }
        echo "
            , children: [ // Pass an array of nodes.
                {title: 'Item 1'},
                {title: 'Folder 2', isFolder: true}]
            }";
    }
}
?>        
    ];
</script>
<!-- div element in wich the tree will appear. -->
<div id="cFiltersList2" style="width: 100%; height: 68%; overflow: hidden;">
</div> <!-- end cFiltersList2-->

<div dojoType="dijit.layout.AccordionContainer" minSize="20" style="width: 100%; height: 98%; overflow: hidden;"
     id="cFiltersList" region="top" splitter="true">
         <?php
         $args1 = array(
             'public' => true,
             '_builtin' => false
         );
         $excludeTypes = array("flickr_photos");
         $output = 'objects'; // names or objects
         $operator = 'and'; // 'and' or 'or'
         $post_types = get_post_types($args1, $output, $operator);
//asort($post_types);
         $sortArray = array();
         /*foreach ($post_types as $post_type) {
             foreach ($post_type as $key => $value) {
                 if (!isset($sortArray[$key])) {
                     $sortArray[$key] = array();
                 }
                 $sortArray[$key][] = $value;
             }
         }
         $orderby = "menu_position";
         array_multisort($sortArray[$orderby], SORT_ASC, $post_types);*/
         //echo "<ul id='treeData'>";
         //foreach ($post_types as $post_type) {
           //  if (!in_array($post_type->name, $excludeTypes)) {
                 //echo '<div class="onmap" id="accord_' . $post_type->name . '" dojoType="dijit.layout.AccordionPane" title="' . $post_type->label . '"><div id="onmap_' . $post_type->name . '"></div></div>';
             //}
         //}
         //echo "</ul>";
         ?>
    <div class="onmap" id="accord_legend" dojoType="dijit.layout.AccordionPane" title="Data Legend">
        <div id="legendDiv"></div>
    </div>  
</div>
