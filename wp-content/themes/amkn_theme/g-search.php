<?php

/**
 * Template Name: Google Search Template
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$searchQ = $_GET["q"];
get_header();

?>
<div id="container">
<div class="content">
<h2 class="title"><?php the_title(); ?></h2>
  <div style="display:none">
    <!-- Return the unescaped result URL.-->
    <div id="amkn_webResult">
      <div class="gs-webResult gs-result"
        data-vars="{longUrl:function() {
          var i = unescapedUrl.indexOf(visibleUrl);
          return i < 1 ? visibleUrl : unescapedUrl.substring(i);}, resThumb:function() {
          var i = unescapedUrl.indexOf(visibleUrl);
		  var cType = unescapedUrl.split('/')[3];
		  var imgLoc = '';
			switch (cType) {
			  case 'video':
				imgLoc = '/wp-content/themes/amkn_theme/images/video_testimonials-mini.png';
				break;
			  case 'factsheets':
				imgLoc = '/wp-content/themes/amkn_theme/images/video_testimonials-mini.png';
				break;
			  case 'photo-sets':
				imgLoc = '/wp-content/themes/amkn_theme/images/photo_testimonials-mini.png';
				break;
			  case 'benchmark-sites':
				imgLoc = '/wp-content/themes/amkn_theme/images/ccafs_sites-mini.png';
				break;
                          case 'ccafs-sites':
				imgLoc = '/wp-content/themes/amkn_theme/images/ccafs_sites-mini.png';
				break;
			  case 'blog-posts':
				imgLoc = '/wp-content/themes/amkn_theme/images/amkn_blog_posts-mini.png';
				break;
                          case 'ccafs-activities':
				imgLoc = '/wp-content/themes/amkn_theme/images/ccafs_activities-mini.png';
				break;
                          case 'biodiv_cases':
				imgLoc = '/wp-content/themes/amkn_theme/images/biodiv_cases-mini.png';
				break;
			  default:
				break;
			}
			return imgLoc;
          }}">

        <!-- Build the result data structure.-->
        <table>
          <tr>
            <td valign="top">

              <!-- Append results within the table cell.-->
		<!-- Create 21px x 21px thumbnails.-->
              <div data-if="resThumb()" id="amkn_thumbnail">
                <div class="gs-image-box gs-web-image-box">
                  <a class="gs-image" data-attr="{href:url, target:target}">
                    <img class="gs-image" data-attr="{src:resThumb(), width:21, height: 21}"/>
                  </a>
                </div>
              </div>
              <div class="gs-title">
                <a class="gs-title" data-attr="{href:unescapedUrl,target:target}"
                  data-body="html(title)"></a>
              </div>
              <div class="gs-snippet" data-body="html(content)"></div>
              <div class="gs-visibleUrl gs-visibleUrl-short" data-body="longUrl()"></div>


            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
<div id="cse" style="width: 100%;">Loading</div>
<script src="//www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
  google.load('search', '1', {language : 'en', style : google.loader.themes.MINIMALIST});
  google.setOnLoadCallback(function() {
    var customSearchControl = new google.search.CustomSearchControl('007658706490572941822:v04khf-g68y');
    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
    // Use "amkn_" as a unique ID to override the default rendering.
    google.search.Csedr.addOverride("amkn_");
    customSearchControl.setLinkTarget(google.search.Search.LINK_TARGET_TOP);
    customSearchControl.draw('cse');
    customSearchControl.execute('<?php echo $searchQ; ?>');
  }, true);
</script>

<style type="text/css">
  .gsc-control-cse {
    font-family: Museo300,trebuchet MS,Helvetica,Sans-serif;
    border-color: #FFFFFF;
    background-color: #FFFFFF;
    float: right;
  }
  input.gsc-input {
    border-color: #777777;
  }
  input.gsc-search-button {
    border-color: #333333;
    background-color: #333333;
  }
  .gsc-tabHeader.gsc-tabhInactive {
    border-color: #777777;
    background-color: #777777;
  }
  .gsc-tabHeader.gsc-tabhActive {
    border-color: #333333;
    background-color: #333333;
  }
  .gsc-tabsArea {
    border-color: #333333;
  }
  .gsc-webResult.gsc-result {
    border-color: #FFFFFF;
    background-color: #FFFFFF;
  }
  .gsc-webResult.gsc-result:hover {
    border-color: #000000;
    background-color: #FFFFFF;
  }
  a.gs-title{
    font-size:14pt !important;
    text-decoration: none !important;
    padding: 5px !important;
    text-transform: none !important;
    color: #55322B !important;
    font-weight: bold !important;
    padding-left: 0 !important;

  }
  .gs-webResult.gs-result a.gs-title:link,
  .gs-webResult.gs-result a.gs-title:link b {
    color: #444444;
  }
  .gs-webResult.gs-result a.gs-title:visited,
  .gs-webResult.gs-result a.gs-title:visited b {
    color: #444444;
  }
  .gs-webResult.gs-result a.gs-title:hover,
  .gs-webResult.gs-result a.gs-title:hover b {
    color: #444444;
  }
  .gs-webResult.gs-result a.gs-title:active,
  .gs-webResult.gs-result a.gs-title:active b {
    color: #777777;
  }
  .gsc-cursor-page {
    color: #444444;
  }
  a.gsc-trailing-more-results:link {
    color: #444444;
  }
  .gs-webResult .gs-snippet {
    color: #333333;
  }
  .gs-webResult div.gs-visibleUrl {
    color: #000000;
  }
  .gs-webResult div.gs-visibleUrl-short {
    color: #000000;
  }
  .gs-webResult div.gs-visibleUrl-short {
    display: none;
  }
  .gs-webResult div.gs-visibleUrl-long {
    display: block;
  }
  .gsc-cursor-box {
    border-color: #FFFFFF;
  }
  .gsc-results .gsc-cursor-page {
    border-color: #777777;
    background-color: #FFFFFF;
  }
  .gsc-results .gsc-cursor-page.gsc-cursor-current-page {
    border-color: #333333;
    background-color: #333333;
  }
  .gs-promotion {
    border-color: #CCCCCC;
    background-color: #E6E6E6;
  }
  .gs-promotion a.gs-title:link,
  .gs-promotion a.gs-title:link *,
  .gs-promotion .gs-snippet a:link {
    color: #0000CC;
  }
  .gs-promotion a.gs-title:visited,
  .gs-promotion a.gs-title:visited *,
  .gs-promotion .gs-snippet a:visited {
    color: #0000CC;
  }
  .gs-promotion a.gs-title:hover,
  .gs-promotion a.gs-title:hover *,
  .gs-promotion .gs-snippet a:hover {
    color: #444444;
  }
  .gs-promotion a.gs-title:active,
  .gs-promotion a.gs-title:active *,
  .gs-promotion .gs-snippet a:active {
    color: #00CC00;
  }
  .gs-promotion .gs-snippet,
  .gs-promotion .gs-title .gs-promotion-title-right,
  .gs-promotion .gs-title .gs-promotion-title-right *  {
    color: #333333;
  }
  .gs-promotion .gs-visibleUrl,
  .gs-promotion .gs-visibleUrl-short {
    color: #00CC00;
  }
.gs-result img.gs-image {
vertical-align: middle;
border: none !important;
}
.gs-web-image-box{
border: none !important;
height: 34px;
}
</style>
</div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>