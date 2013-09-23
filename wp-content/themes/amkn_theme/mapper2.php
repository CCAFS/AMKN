<?php
/*
Template Name: Map2 Page Template
*/
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <!--The viewport meta tag is used to improve the presentation and behavior of the samples
      on iOS devices-->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>
    </title>
    <link rel="stylesheet" type="text/css" href="http://serverapi.arcgisonline.com/jsapi/arcgis/2.2/js/dojo/dijit/themes/Nihilo/Nihilo.css">
    <style type="text/css">
      html, body {
        height: 100%; width: 100%;
        margin: 0; padding: 0;
      }
      body{
        background-color:white; overflow:hidden;
        font-family: "Kimberley", sans-serif
      }
      #header {
       -moz-border-radius: 5px;
        margin:2px;
        padding-top: 4px;
        padding-right: 15px;
        background-color:#929761;
        color:#421b14;
        font-size:16pt; text-align:right;font-weight:bold;
        border: solid 2px #79663b;
        height:55px;
      }
      #subheader {
        font-size:small;
        color: #cfcfcf;
        text-align:right;
        padding-right:20px;
      }
      #footer {
        margin:2px;
        padding: 2px;
        background-color:white; color:#2a3537;
        border: solid 2px #79663b;
        font-size:10pt; text-align:center;
        height: 30px;
      }
      #rightPane{
        margin:3px;
        padding:10px;
        background-color:white;
        color:#421b14;
        border: solid 2px #79663b;
        width:20%;
      }
      #leftPane{
        margin:3px;
        padding:5px;
        width:150px;
        color:#3C1700;
        background-color:white;
        border: solid 2px #79663b;
      }
      #map {
        margin:5px;
        border:solid 4px #79663b;
      }
      .shadow{
        -o-border-radius: 6px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        box-shadow: 8px 8px 16px #323834;
        -webkit-box-shadow: 8px 8px 16px #323834;
        -moz-box-shadow: 8px 8px 16px #323834;
        -o-box-shadow: 8px 8px 16px #323834;
      }

      .nihilo .dijitAccordionText {
        margin-left:4px;
        margin-right:4px;
        color:#5c8503;
      }
    </style>
    <script type="text/javascript">
      var djConfig = {
        parseOnLoad: true
      };
    </script>
    <script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.2compact">
    </script>
    <script type="text/javascript">

    </script>
  </head>
  <body class="nihilo">
    <div id="mainWindow" dojotype="dijit.layout.BorderContainer" design="headline" gutters="false" style="width:100%; height:100%;">

      <div dojotype="dijit.layout.ContentPane" region="left" id="leftPane" >
      <div dojoType="dijit.layout.AccordionContainer">
        <div dojoType="dijit.layout.ContentPane" title="See info in">
          East Africa
          <br />
          West Africa
          <br />
          Indo-Gangetic Plains
        </div>
        <div dojoType="dijit.layout.ContentPane" title="Content">
          <p>
<?php
$args1=array(
  'public'   => true,
  '_builtin' => false
);
$excludeTypes = array("flickr_photos");


$output = 'objects'; // names or objects
$operator = 'and'; // 'and' or 'or'
$post_types=get_post_types($args1,$output,$operator);
asort($post_types);
echo '<form name="pts">
          <a href="javascript:void(0)" onClick="clearAllChecks(document.pts)">Clear Selections</a> |
          <a href="javascript:void(0)" onClick="markAllChecks(document.pts)">Select All</a>
          <br />';
  foreach ($post_types  as $post_type ) {
    if(!in_array($post_type->name, $excludeTypes)){
    echo '
    <input id="' . $post_type->name . '" type="checkbox" name="' . $post_type->name . '" value="' . $post_type->name . '" onClick="updateDataLayer(true)">
    <label for="' . $post_type->name . '">
    ' . $post_type->label . '
    </label><br />
    ';
      }
  }
  echo '</form>';
?>
          </p>
        </div>
        <div dojoType="dijit.layout.ContentPane" title="Layers">
          <p>
<input id="gcpFS" type="checkbox" name="gcpFS" value="show" onClick="showHideGCP();">
<label for="gcpFS">
    GCPAtlas Farming Systems
</label>
          </p>
        </div>
        <div dojoType="dijit.layout.ContentPane" title="Icons">
          <p>
<input id="iconType" type="checkbox" name="iconType" value="large" onClick="updateDataLayer(true)">
<label for="iconType">
    Use large icons
</label>
          </p>
        </div>
      </div>
      </div>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<div class="shadow"></div>
<?php endwhile; // end of the loop. ?>
      <div dojotype="dijit.layout.ContentPane" region="right" id="rightPane" >


<div dojoType="dijit.layout.AccordionContainer">
          <div dojoType="dijit.layout.ContentPane" id="legendPane" title="Data Legend">
            <div id="legendDiv"></div>
          </div>
          <div dojoType="dijit.layout.ContentPane" title="Content Legend">
            This pane can contain a legend for the symbols used in the mapped content.
          </div>
<?php
$args2=array(
  'public'   => true,
  '_builtin' => false

);
$excludeTaxonomies = array("cgmap-countries");

$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies=get_taxonomies($args2,$output,$operator);
if  ($taxonomies) {
    asort($taxonomies);
  foreach ($taxonomies  as $taxonomy ) {
    if(!in_array($taxonomy->name, $excludeTaxonomies)){

    echo '
    <div dojoType="dijit.layout.ContentPane" title="' . $taxonomy->label . '">
        ';
$args3=array(
'orderby'   => 'name'
);
        $terms = get_terms($taxonomy->name, $args3);
        $count = count($terms);
         echo '<form name="' . $taxonomy->name . '">
          <a href="javascript:void(0)" onClick="clearAllChecks(document.' . $taxonomy->name . ')">Clear Selections</a> |
          <a href="javascript:void(0)" onClick="markAllChecks(document.' . $taxonomy->name . ')">Select All</a>
          <br />';
         if($count > 0){
            //asort($terms);

            foreach ($terms as $term) {
            echo '
            <input id="' . $taxonomy->name.'_'.$term->term_id . '" type="checkbox" name="' . $taxonomy->name.'_'.$term->slug . '" value="'.$term->term_id . '" onClick="updateDataLayer(true)">
            <label for="' . $taxonomy->name.'_'.$term->slug . '">
            ' .$term->name. '
            </label><br />
            ';
             }
         }
         
         echo '</form>';
    echo '</div>
    ';
    }
  }
}
?>
    </div>
      </div>
    </div>
  </body>
</html>