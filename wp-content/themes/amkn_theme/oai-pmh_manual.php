<?php
//verb=GetRecord&metadataPrefix=oai_dc&identifier=oai:cgspace.cgiar.org:10568/25109
$verb = $_GET['verb'];
$metadataPrefix = $_GET['metadataPrefix'];
$identifier = $_GET['identifier'];
$post = explode("/",$identifier);

$args = array(
  'post_status' => 'publish',
  'p' => $post[1],
  'post_type' => 'any'
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) {
  while ($the_query->have_posts()):
    $the_query->the_post();
//    if (has_post_thumbnail()) {
//      $imgd = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
//    }
    $publisher = get_post_meta(get_the_ID(), 'syndication_source', true);
    $creator = get_the_author();
    $source = get_post_meta(get_the_ID(), 'syndication_source_uri', true);
    $point = get_post_meta(get_the_ID(), 'geoRSSPoint', true);
    header("Content-type: text/xml");
    
    ?>
    <OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/" 
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
             http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
      <responseDate><?php echo mysql2date('D, d M Y H:i:s +0000', date('Y-m-d H:i:s'), false); ?></responseDate>
      <request verb="GetRecord" identifier="oai:arXiv.org:hep-th/9901001"
               metadataPrefix="oai_dc">http://an.oa.org/OAI-script</request> 
      <GetRecord>
        <record>
          <header>
            <identifier>oai:amkn.org:<?php echo get_post_type(get_the_ID())."/".  get_the_ID()?></identifier> 
            <datestamp><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></datestamp>
            <setSpec><?php echo get_post_type(get_the_ID())?></setSpec> 
            <setSpec>math</setSpec>
          </header>
          <metadata>
            <oai_dc:dc 
              xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/" 
              xmlns:dc="http://purl.org/dc/elements/1.1/" 
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
              xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ 
              http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
              <dc:title><?php echo get_the_title()?></dc:title>
              <dc:creator><?php echo $creator?></dc:creator>
              <dc.publisher><?php echo $publisher?></dc.publisher>
              <dc:subject>Digital Libraries</dc:subject> 
              <dc:date><?php echo get_post_time('Y-m-d', true); ?></dc:date>
              <dc:identifier><?php echo get_permalink()?></dc:identifier>
              <dc:source><?php echo $source?></dc:source>
              <dc:language><?php echo "EN"?></dc:language>
              <dc:coverage><?php echo $point ?></dc:coverage>
              <dc:rights><?php echo "Open Access"?></dc:rights>
            </oai_dc:dc>
          </metadata>
        </record>
      </GetRecord> 
    </OAI-PMH>
    <?php
  endwhile;
}
wp_reset_postdata();
