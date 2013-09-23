<?php
/**
 * Export
 * @author Michael Marus
 */
$export_file = "amkn_content_store.xls";
header('Content-Type: application/msexcel;');
header('Content-Disposition: attachment; filename="'.$export_file.'"');
require_once("../../../wp-config.php");
$defaults = array('fields'=>'names');
?><html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<style id="or_report"><!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl6330485
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6730485
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Verdana, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid #999999;
	border-right:none;
	border-bottom:.5pt solid #999999;
	border-left:.5pt solid #999999;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7030485
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Verdana, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border:.5pt solid #999999;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}


.xl7130487
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Verdana, sans-serif;
	mso-font-charset:0;
	mso-number-format:"yyyy\\-mm\\-dd\;\@";
	text-align:left;
	vertical-align:top;
	border:.5pt solid #999999;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}

.xl7130485
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Verdana, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border:.5pt solid #999999;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
--></style>
</head>

<body>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
  <table class="xl6330485" border="1" align="left" bordercolor="#999999" id="or_projects">
   <thead>
    <tr align="left" valign="top">
      <th colspan="12" class="xl6730485">
	  <h1>AMKN Content Report</h1>

	  </th>
    </tr>
	<tr align="left" valign="top">
<th class="xl7030485">ID</th>
<th class="xl7030485">Author</th>
<th class="xl7030485">Date</th>
<th class="xl7030485">Title</th>
<th class="xl7030485">Status</th>
<th class="xl7030485">Type</th>
<th class="xl7030485">Nearest Site</th>
<th class="xl7030485">Geocoordinates</th>
<th class="xl7030485">Nearest Town</th>
<?php
$args2=array(
  'public'   => true,
  '_builtin' => false
);
$excludeTaxonomies = array("agroecological_zones", "farming_systems");
$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies=get_taxonomies($args2,$output,$operator);
if  ($taxonomies) {
    asort($taxonomies);
    foreach ($taxonomies  as $taxonomy ) {
        if(!in_array($taxonomy->name, $excludeTaxonomies)){
    $args3=array(
    'orderby'   => 'name'
    );
            $terms = get_terms($taxonomy->name, $args3);
            $count = count($terms);
             echo '<th class="xl7030485">' . $taxonomy->label . '</th>';

        }
    }
}
?>
  </tr>
  </thead>
    <tbody>
<?php
global $post;
$args = array( 'post_status' => 'any', 'post_type' => 'any', 'numberposts' => -1, 'orderby' => 'post_date', 'order' => 'DESC' );
$pageposts = get_posts( $args );
foreach( $pageposts as $post ) : setup_postdata($post);?>
<tr align="left" valign="top">
<td class="xl7130485"><?php the_ID(); ?>&nbsp;</td>
<td class="xl7130485"><?php the_author(); ?>&nbsp;</td>
<td class="xl7130487"><?php echo $post->post_modified_gmt; ?>&nbsp;</td>
<td class="xl7130485"><?php the_title(); ?>&nbsp;</td>
<td class="xl7130485"><?php echo $post->post_status; ?>&nbsp;</td>
<td class="xl7130485"><?php echo get_post_type_object( $post->post_type )->labels->name; ?>&nbsp;</td>
<td class="xl7130485"><?php echo get_the_title(get_post_meta($post->ID, 'nearestBenchmarkSite', true)); ?>&nbsp;</td>
<td class="xl7130485"><?php echo get_post_meta($post->ID, 'geoRSSPoint', true); ?>&nbsp;</td>
<td class="xl7130485"><?php echo (get_post_meta($post->ID, 'village', true)) ? get_post_meta($post->ID, 'village', true) : get_post_meta($post->ID, 'city', true); ?>&nbsp;</td>

<?php
$args2=array(
  'public'   => true,
  '_builtin' => false
);
$excludeTaxonomies = array("agroecological_zones", "farming_systems");
$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies=get_taxonomies($args2,$output,$operator);
if  ($taxonomies) {
    asort($taxonomies);
    foreach ($taxonomies  as $taxonomy ) {
        if(!in_array($taxonomy->name, $excludeTaxonomies)){
    $args3=array(
    'orderby'   => 'name'
    );
            $terms = get_terms($taxonomy->name, $args3);
            $count = count($terms);
             echo '<td class="xl7130485">' . implode(", ", wp_get_object_terms($post->ID, $taxonomy->name, $defaults)) . '&nbsp;</td>';
        }
    }
}
?>
</tr>
<?php endforeach; ?>
      </tbody>
  </table>
 </body>
</html>