<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
$currType = get_query_var('taxonomy');
$themes = array('1' => 'Adaptation to Progressive Climate Change', '2' => 'Adaptation through Managing Climate Risk', '3' => ' Pro-Poor Climate Change Mitigation', '4.1' => ' Linking Knowledge to Action', '4.2' => 'Data and Tools for Analysis and Planning', '4.3' => 'Policies and Institutions');
?>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<div id="container">
  <div class="content">
    <h2 class="title"><?php echo get_post_type_object(get_query_var('post_type'))->labels->name; ?></h2>
    <?php
    if (get_query_var('post_type') == 'ccafs_activities') :
      $args = array('meta_query' => array(array('key' => 'leaderAcronym')), 'posts_per_page' => 600, 'post_type' => array('ccafs_activities'), 'orderby' => 'post_date', 'order' => 'DESC');
      $myposts = get_posts($args);

      foreach ($myposts as $key => $post) {
        $lead = get_post_meta($post->ID, 'leaderAcronym', true);
        if (!cgValidate($lead))
          $leader[str_replace(' ', '', $lead)] = $lead;
      }
      ksort($leader);
//        echo "<pre>".count($myposts).print_r($leader,true)."</pre>";
      ?>
      <meta charset="utf-8">
      <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/libs/jquery.tablesorter/themes/blue/style.css">        
      <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/libs/jquery.tablesorter/jquery.tablesorter.js"></script>        
      <script>
        var treeData;
        $(function() {
          $("#initDate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
          });
          $("#endDate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
          });
          $('#reset').click(function() {
            var elements = document.getElementById("search-activities").elements;

            //            $('#search-activities').reset();

            for (i = 0; i < elements.length; i++) {

              field_type = elements[i].type;

              switch (field_type) {

                case "text":
                case "password":
                case "textarea":
                case "hidden":

                  elements[i].value = "";
                  break;

                case "radio":
                case "checkbox":
                  if (elements[i].checked) {
                    elements[i].checked = false;
                  }
                  break;

                case "select-one":
                case "select-multi":
                  elements[i].selectedIndex = 0;
                  break;

                default:
                  break;
              }
            }
          });
        });
        $(document).ready(function()
        {
          //                  $("#projectsTable").tablesorter(); 
        }
        );
        function orderColumn(colm) {
          if (document.getElementById('order').value == 'true') {
            document.getElementById('order').value = 'false';
          } else {
            document.getElementById('order').value = true
          }
          document.getElementById('orderby').value = colm;
          document.getElementById('search-activities').submit();
        }
      </script>
      <div class="pure-g" style="margin-top: 20px">
        <div class="pure-u-1-4">
          <form class="pure-form pure-form-stacked" name ="search-activities" id ="search-activities" method="get" action="/ccafs-activities/">
            <?php if ($_GET['order'] == 'true'): ?>
              <input type="hidden" id="order" name="order" value="true">
            <?php else: ?>
              <input type="hidden" id="order" name="order" value="false">
            <?php endif; ?>
            <input type="hidden" id="orderby" name="orderby" value="title">
            <div class="pure-table" style="background:white">
              <div style="padding: 15px 15px 15px 15px;background: #E3BB3B; font-weight: bold;color: white;">
                Search By
              </div>
              <div style="padding: 15px 15px 15px 15px;font-weight: bold;">
                Keyword

                <input type="text" name="keyword" id="keyword" value="<?php echo $_GET['keyword'] ?>" class="pure-input-2-3">
              </div>
              <div style="padding: 15px 15px 15px 15px">
                <div style="margin-bottom: 10px; font-weight: bold;">Topic</div>
                <ul style="list-style-type: none;padding: 0px; margin: 0px;">
                  <?php foreach ($themes as $key => $theme): ?>
                    <?php
                    $selected = '';
                    if (isset($_GET['theme']) && in_array($key, $_GET['theme'])) {
                      $selected = 'checked';
                    }
                    ?>
                    <li style="display: inline-flex;margin-bottom: 5px;"><input type="checkbox" id="theme" name="theme[]" value="<?php echo $key ?>" onclick="document.getElementById('search-activities').submit();" <?php echo $selected ?>/><div> <?php echo $theme ?></div></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div style="padding: 15px 15px 15px 15px">
                <div style="margin-bottom: 10px;font-weight: bold;">Status</div>

                <?php
                $selected1 = '';
                if (isset($_GET['view']) && in_array('active', $_GET['view'])) {
                  $selected1 = 'checked';
                }
                $selected2 = '';
                if (isset($_GET['view']) && in_array('closed', $_GET['view'])) {
                  $selected2 = 'checked';
                }
                ?>
                <ul style="list-style-type: none;padding: 0px; margin: 0px;">
                  <li><input type="checkbox" name="view[]" id="<?php echo "active" ?>" value="active" onclick="document.getElementById('search-activities').submit();" <?php echo $selected1 ?>/> Active</li>
                  <li><input type="checkbox" name="view[]" id="<?php echo "closed" ?>" value="closed" onclick="document.getElementById('search-activities').submit();" <?php echo $selected2 ?>/> Closed</li>
                </ul>
              </div>
              <div style="padding: 15px 15px 15px 15px">
                <div style="margin-bottom: 10px;font-weight: bold;">Lead Center</div>
                <ul style="list-style-type: none;padding: 0px; margin: 0px;">
                  <?php
                  foreach ($leader as $key => $lead):
                    ?>
                    <?php
                    $selected = '';
                    if (isset($_GET['leader']) && in_array($lead, $_GET['leader'])) {
                      $selected = 'checked';
                    }
                    ?>
                    <li><input type="checkbox" id="leader" name="leader[]" value="<?php echo $lead ?>" onclick="document.getElementById('search-activities').submit();" <?php echo $selected ?>/> <?php echo $lead ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </form>
        </div>
        <div class="pure-u-3-4">
          <div id="tabs-min" style="">
            <ul>
              <li><a href="#tabs-1">Projects</a></li>
              <li><a href="#tabs-2">Charts</a></li>

            </ul>
            <div id="tabs-1">
              <table id="projectsTable" class="tablesorter pure-table-striped" style="width: 100%; float:right;margin: 0px 0pt 15px;">
                <thead>
                  <tr>
                    <th onclick="orderColumn('title')">
                      Project title
                    </th>            
                    <th onclick="orderColumn('theme')">
                      Topic
                    </th>
                    <th onclick="orderColumn('leaderName')">
                      Lead
                    </th>
          <!--            <th onclick="orderColumn('budget')">
                      Budget (USD)
                    </th>-->
                  </tr>
                </thead>
                <tbody> 
                  <?php get_template_part('loop', 'activities'); ?>        

                <?php elseif (get_query_var('post_type') == 'ccafs_sites') : ?>
          <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
                <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.scrollTo.js"></script>
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
                <script>
                      var map;
                      var markerArray = {};
                      function initialize() {
                        var myLatlng = new google.maps.LatLng(12.968888, 10.138147);
                        var mapOptions = {
                          zoom: 2,
                          center: myLatlng
                        }
                        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                        rgs = 'East%20Africa,West%20Africa,South%20Asia,Southeast%20Asia,Latin%20America';
                        var script = document.createElement('script');
                        script.src = '<?php bloginfo('url'); ?>/sitesgeojson/?rgs=' + rgs;
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(script, s);

                        google.maps.event.addListener(map, "center_changed", function() {
                          filterPanel();
                        });
                      }

                      window.eqfeed_callback = function(results) {
                        var image = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniH.png";
                        var infobox;
                        var markeri = new google.maps.Marker();
                        for (var i = 0; i < results.features.length; i++) {
                          idx = i;
                          var coords = results.features[i].geometry.coordinates;
                          var latLng = new google.maps.LatLng(coords[1], coords[0]);
                          var marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            icon: image
                                    //              title: results.features[i].properties.title
                          });

                          markerArray[results.features[i].id] = marker;
                          //            google.maps.event.addListener(marker, 'click', function(event) {alert(results.features[idx].properties.title)});
                          google.maps.event.addListener(marker, 'mouseover', (function(marker, i, results) {
                            return function() {
                              if (infobox) {
                                eval(infobox).close();
                              }
                              if (markeri) {
                                eval(markeri).setMap(null);
                              }
                              $("div#" + results.features[i].id).addClass("ccafs_sites_selected").siblings().removeClass("ccafs_sites_selected");
                              $('#sites').scrollTo($("div#" + results.features[i].id), 100, {offset: {top: -135, left: 0}});
                              var contentString = infoWindowContent(results.features[i]);
                              infobox = getBox(contentString);
                              infobox.open(map, marker);
                              google.maps.event.addListener(infobox, "closeclick", function() {
                                markeri.setMap(null);
                              });
                              var imagei = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniI.png";
                              var coords = results.features[i].geometry.coordinates;
                              var latLng = new google.maps.LatLng(coords[1], coords[0]);
                              markeri = new google.maps.Marker({
                                position: latLng,
                                map: map,
                                zIndex: 9999999,
                                icon: imagei
                              });
                              google.maps.event.addListener(markeri, 'click', (function(i, results) {
                                return function() {
                                  document.location = "./?p=" + results.features[i].id;
                                };
                              })(i, results));
                            };
                          })(marker, i, results));

                          google.maps.event.addListener(marker, 'dblclick', (function(marker, i, results) {
                            return function() {
                              if (infobox) {
                                eval(infobox).close();
                              }
                              if (markeri) {
                                eval(markeri).setMap(null);
                              }
                              $("div#" + results.features[i].id).addClass("ccafs_sites_selected").siblings().removeClass("ccafs_sites_selected");
                              var contentString = infoWindowContent(results.features[i]);
                              infobox = getBox(contentString);
                              infobox.open(map, marker);
                              google.maps.event.addListener(infobox, "closeclick", function() {
                                markeri.setMap(null);
                              });
                              var imagei = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniI.png";
                              var coords = results.features[i].geometry.coordinates;
                              var latLng = new google.maps.LatLng(coords[1], coords[0]);
                              markeri = new google.maps.Marker({
                                position: latLng,
                                map: map,
                                zIndex: 9999999,
                                icon: imagei
                              });
                            };
                          })(marker, i, results));

                          //            google.maps.event.addListener(marker, 'click', (function(i, results) {
                          //              return function() {
                          //                document.location = "./?p=" + results.features[i].id;
                          //              };
                          //            })(i, results));
                          google.maps.event.addListener(map, "click", function() {
                            infobox.close();
                            markeri.setMap(null);
                          });
                        }
                      }

                      function infoWindowContent(result) {
                        return '<div class="gmap" id="content"><b>' + result.properties.title + ' [' + result.properties.country + '] </b><br>CCAFS Region: ' + result.properties.region
                                + '<br>'
                                + '<a href="/ccafs-activities/?nearest_site=' + result.id + '&order=false&orderby=title"><img src="<?php bloginfo('template_directory'); ?>/images/ccafs_activities-mini.png"/> Projects: ' + result.properties.activities + '</a>'
                                + '<br><a href="/blog-posts/?nearest_site=' + result.id + '"><img src="<?php bloginfo('template_directory'); ?>/images/amkn_blog_posts-mini.png"/> Blogs: ' + result.properties.blogs + '</a>'
                                + '<br><a href="/photo-sets/?nearest_site=' + result.id + '"><img src="<?php bloginfo('template_directory'); ?>/images/photo_testimonials-mini.png" /> Photos: ' + result.properties.photos + '</a>'
                                + '<br><a href="/video/?nearest_site=' + result.id + '"><img src="<?php bloginfo('template_directory'); ?>/images/video_testimonials-mini.png" /> Videos: ' + result.properties.videos + '</a>'
                                + '</div>';
                      }

                      function getBox(contentString) {
                        return new InfoBox({
                          content: contentString,
                          disableAutoPan: false,
                          maxWidth: 150,
                          pixelOffset: new google.maps.Size(-140, 0),
                          zIndex: null,
                          boxStyle: {
                            background: "url('<?php bloginfo('template_directory'); ?>/images/tipbox1.gif') no-repeat",
                            width: "200px"
                          },
                          closeBoxMargin: "12px 4px 2px 2px",
                          closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
                          infoBoxClearance: new google.maps.Size(1, 1)
                        });
                      }

                      function openDialog(marker) {
                        google.maps.event.trigger(marker, 'dblclick');
                      }

                      function filterMap(rgs) {
                        var myLatlng;
                        var zoom = 4;
                        if (rgs == 'East Africa') {
                          myLatlng = new google.maps.LatLng(-0.314705, 35.022805);
                        } else if (rgs == 'West Africa') {
                          myLatlng = new google.maps.LatLng(13.3686965, -5.762451);
                        } else if (rgs == "Latin America") {
                          myLatlng = new google.maps.LatLng(15.2, -87.883333);
                        } else if (rgs == 'Southeast Asia') {
                          myLatlng = new google.maps.LatLng(21.033333, 105.85);
                        } else if (rgs == 'South Asia') {
                          myLatlng = new google.maps.LatLng(27.5446255, 83.4506495);
                        } else if (rgs == 'all') {
                          myLatlng = new google.maps.LatLng(12.968888, 10.138147);
                          zoom = 2;
                          rgs = 'ccafs_sites';
                        }
                        map.setZoom(zoom);
                        map.panTo(myLatlng);
                      }

                      function filterPanel() {
                        $(".ccafs_sites").css("display", "none");
                        $.each(markerArray, function(i, val) {
                          if (map.getBounds().contains(val.getPosition())) {
                            $("#" + i).css("display", "block");
                          }
                        });
                      }
                      google.maps.event.addDomListener(window, 'load', initialize);
                </script>
                <?php
//        print_r($_GET['region']);
                $checkOng = 'checked';
                ?>
                <form class="pure-form pure-form-stacked" name ="search-sources" id ="search-sources" method="get">
                  <fieldset>
                    <legend>Filter By CCAFS Region</legend>                      
                    <div class="pure-g">
                      <div class="pure-u-1-6">
                        <label for="space">
                          &nbsp;
                        </label>
                        <label for="remember">
                          <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="all" <?php echo (!isset($_GET['region']) || $_GET['region'] == 'all') ? 'checked' : '' ?>>Show all
                        </label>
                      </div>
                      <div class="pure-u-1-6">
                        <label for="space">
                          &nbsp;
                        </label>
                        <label for="remember">
                          <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="East Africa" <?php echo ($_GET['region'] == 'East Africa') ? 'checked' : '' ?>>East Africa
                        </label>
                      </div>
                      <div class="pure-u-1-6">
                        <label for="space">
                          &nbsp;
                        </label>
                        <label for="remember">
                          <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="West Africa" <?php echo ($_GET['region'] == 'West Africa') ? 'checked' : '' ?>>West Africa
                        </label>
                      </div>
                      <div class="pure-u-1-6">
                        <label for="space">
                          &nbsp;
                        </label>
                        <label for="remember">
                          <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="Latin America" <?php echo ($_GET['region'] == 'Latin America') ? 'checked' : '' ?>>Latin America
                        </label>
                      </div>
                      <div class="pure-u-1-6">
                        <label for="space">
                          &nbsp;
                        </label>
                        <label for="remember">
                          <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="Southeast Asia" <?php echo ($_GET['region'] == 'Southeast Asia') ? 'checked' : '' ?>> Southeast Asia 
                        </label>
                      </div>
                      <div class="pure-u-1-6">
                        <label for="space">
                          &nbsp;
                        </label>
                        <label for="remember">
                          <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="South Asia" <?php echo ($_GET['region'] == 'South Asia') ? 'checked' : '' ?>>South Asia
                        </label>
                      </div>
                    </div>            
                  </fieldset>        
                </form>
                <!--<button id="search" class="pure-button pure-button-primary" onclick="updateMap()">Test</button>-->
                <div style="height: 400px; width: 700px;float:left;margin-bottom: 20px" id="map-canvas"></div>
                <div id="sites" style="height: 400px; width: 310px;float:left; overflow: scroll;margin-bottom: 20px;background: #F5F5F5;overflow-x: auto">
                  <?php get_template_part('loop', 'archive'); ?>
                </div>
                <div>
                  <?php
//          global $wp_query;
//          echo $wp_query->found_posts;
                  ?>
                </div>
              <?php else: ?>
                <script>
                  $(function() {
                    $("#initDate").datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'dd/mm/yy'
                    });
                    $("#endDate").datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'dd/mm/yy'
                    });
                    $('#reset').click(function() {
                      var elements = document.getElementById("search-sources").elements;

                      for (i = 0; i < elements.length; i++) {

                        field_type = elements[i].type.toLowerCase();

                        switch (field_type) {

                          case "text":
                          case "password":
                          case "textarea":
                          case "hidden":

                            elements[i].value = "";
                            break;

                          case "radio":
                          case "checkbox":
                            if (elements[i].checked) {
                              elements[i].checked = false;
                            }
                            break;

                          case "select-one":
                          case "select-multi":
                            elements[i].selectedIndex = 0;
                            break;

                          default:
                            break;
                        }
                      }
                    });
                  });
                </script>
                <form class="pure-form pure-form-stacked" name ="search-sources" id ="search-sources" method="get">
                  <fieldset>
                    <legend>Search By</legend>
                    <?php if ($_GET['order'] == 'true'): ?>
                      <input type="hidden" id="order" name="order" value="true">
                    <?php else: ?>
                      <input type="hidden" id="order" name="order" value="false">
                    <?php endif; ?>
                    <input type="hidden" id="orderby" name="orderby" value="title">            
                    <div class="pure-g">
                      <div class="pure-u-1-6">
                        <label for="initDate">
                          Start date
                        </label>
                        <input type="text" name="initDate" id="initDate" value="<?php echo $_GET['initDate'] ?>" class="pure-input-2-3">          
                      </div>
                      <div class="pure-u-1-6">
                        <label for="endDate">
                          End date
                        </label>          
                        <input type="text" name="endDate" id="endDate" value="<?php echo $_GET['endDate'] ?>" class="pure-input-2-3">
                      </div>
                      <div class="pure-u-1-6">
                        <label for="keyword">
                          Keyword
                        </label>          
                        <input type="text" name="keyword" id="keyword" value="<?php echo $_GET['keyword'] ?>" class="pure-input-2-3">
                      </div>
                      <div class="pure-u-1-6">
                        <label for="space">
                          &nbsp;
                        </label> 
                        <button id="search" type="submit" class="pure-button pure-button-primary">Search</button>
                        <button id="reset" type="button" class="pure-button pure-button-active">Reset</button>
                      </div>
                    </div>            
                    <!--<input type="submit" name="search" class="pure-button pure-button-primary" value="Search">-->      
                  </fieldset>  
                </form>      
                <?php
                get_template_part('loop', 'archive');
              endif;
              ?>

          </div><!-- end content -->
        </div><!-- end Container -->
        <?php get_footer(); ?>