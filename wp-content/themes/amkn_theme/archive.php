<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
$currType=get_query_var( 'taxonomy' );
$themes = array('1'=>'Adaptation to Progressive Climate Change','2'=>'Adaptation through Managing Climate Risk','3'=>' Pro-Poor Climate Change Mitigation','4.1'=>' Linking Knowledge to Action','4.2'=>'Data and Tools for Analysis and Planning','4.3'=>'Policies and Institutions');
?>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<div id="container">
  <div class="content">
    <h2 class="title"><?php echo get_post_type_object( get_query_var( 'post_type' ) )->labels->name; ?></h2>
    <?php 
      if (get_query_var( 'post_type')== 'ccafs_activities') :
        $args = array('meta_query' => array(array('key' => 'leaderAcronym')),  'posts_per_page'   => 600, 'post_type' => array('ccafs_activities'), 'orderby' => 'post_date', 'order' => 'DESC');
        $myposts = get_posts($args);

        foreach ($myposts as $key => $post){
          $lead = get_post_meta($post->ID, 'leaderAcronym', true);
          if (!cgValidate($lead))
            $leader[str_replace(' ', '',$lead)] = $lead;
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
          $( "#initDate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
          });
          $( "#endDate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
          }); 
          $('#reset').click(function(){
            var elements = document.getElementById("search-activities").elements;

//            $('#search-activities').reset();

            for(i=0; i<elements.length; i++) {

            field_type = elements[i].type.toLowerCase();

            switch(field_type) {

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
//                  $("#myTable").tablesorter(); 
              } 
          );
          function orderColumn(colm){
            if(document.getElementById('order').value=='true') {
              document.getElementById('order').value='false';
            } else {
              document.getElementById('order').value=true
            }
            document.getElementById('orderby').value=colm;document.getElementById('search-activities').submit();
          }
        </script>
        <form class="pure-form pure-form-stacked" name ="search-activities" id ="search-activities" method="get" action="/ccafs-activities/">
          <fieldset>
            <legend>Search By</legend>
            <?php if ($_GET['order'] == 'true'):?>
              <input type="hidden" id="order" name="order" value="true">
            <?php else:?>
              <input type="hidden" id="order" name="order" value="false">
            <?php endif;?>
            <input type="hidden" id="orderby" name="orderby" value="title">            
            <div class="pure-g">              
              <div class="pure-u-1-6">
                <label for="leader">Lead Center</labe>      
                <select name="leader">
                  <option value="0">All Centers</option>
                  <?php foreach ($leader as $key => $lead):?>
                    <?php $selected = ''; if ($_GET['leader'] == $lead) $selected = 'selected';?>
                    <option value='<?php echo $lead?>' <?php echo $selected?>><?php echo $lead?></option>
                  <?php endforeach;?>
                </select>
              </div>             
              <div class="pure-u-1-6">
                <label for="keyword">
                  Keyword
                </label>          
                <input type="text" name="keyword" id="keyword" value="<?php echo $_GET['keyword']?>" class="pure-input-2-3">
              </div>
               <?php
                $checkOng='';
                $checkPast='';
                ($_GET['view'] == 'true')?$checkOng='checked':'';
                ($_GET['view'] == 'false')?$checkPast='checked':'';
              ?>
              <div class="pure-u-1-6">
                <label for="space">
                  &nbsp;
                </label>
                <label for="remember">
                    <input id="ong" name="view" type="radio" value="true" <?php echo $checkOng?>> Ongoing projects
                </label>
              </div>
              <div class="pure-u-1-8">
                <label for="space">
                  &nbsp;
                </label>
                <label for="remember">
                    <input id="past" name="view" type="radio" value="false" <?php echo $checkPast?>> Past projects
                </label>                
              </div>
              <div class="pure-u-1-6">
                <label for="space">
                  &nbsp;
                </label> 
                <button id="search" type="submit" class="pure-button pure-button-primary">Search</button>
                <button id="reset" type="button" class="pure-button pure-button-active">Reset</button>
              </div>
              <div class="pure-u-1-1">
                <label for="theme">Topic</labe>
                <select name="theme">
                  <option value="0">All Topics</option>
                  <?php foreach ($themes as $key => $theme):?>
                    <?php $selected = ''; if ($_GET['theme'] == $key) $selected = 'selected';?>
                    <option value=<?php echo $key?> <?php echo $selected?>><?php echo $theme?></option>
                  <?php endforeach;?>
                </select>            
              </div>              
            </div>            
            <!--<input type="submit" name="search" class="pure-button pure-button-primary" value="Search">-->      
          </fieldset>  
        </form>        
        <table id="myTable" class="tablesorter">
          <thead>
          <tr>
            <th onclick="orderColumn('title')">
              Title
            </th>            
            <th onclick="orderColumn('theme')">
              Topic
            </th>
            <th onclick="orderColumn('leaderName')">
              Lead Center
            </th>
<!--            <th onclick="orderColumn('budget')">
              Budget (USD)
            </th>-->
          </tr>
          </thead>
          <tbody> 
            <?php get_template_part( 'loop', 'activities' );?>
          </tbody> 
      </table>
      <?php if($wp_query->found_posts == 0): ?>
        <script>                  
            $( "#myTable" ).hide();                 
        </script>  
      <?php endif;?>
      <br clear="all" />
      <div id="amkn-paginate">
      <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
          <div class="alignleft"><?php next_posts_link('&larr; Previous Entries'); ?></div>
          <div class="alignright"><?php previous_posts_link('Next Entries &rarr;'); ?></div>
          <?php } ?>
      </div>
      <br clear="all">
      <br clear="all">
      <script>        
         document.getElementById("menu-item-3841").className += ' current-menu-item';
      </script>
    <?php elseif (get_query_var( 'post_type')== 'ccafs_sites') :?>
      <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
      <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.scrollTo.js"></script>        
      <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
      <script>  
        var map;
        var markerArray = {};
        function initialize() {
          var myLatlng = new google.maps.LatLng(12.968888, 41.138147);
          var mapOptions = {
            zoom: 3,
            center: myLatlng
          }
          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
          // Create a script tag and set the USGS URL as the source.
//          if(!location.hash)
          if(location.search) {
            rgs = location.search;
            rgs = rgs.replace(/%5B/g, '[').replace(/%5D/g, ']').replace(/\+/g, ' ').replace(/\?/g, '');
            rgs = rgs.split('&');
            strRg = '';
            for(i=0;i<rgs.length;i++) {
              rg = rgs[i].split('=');
              strRg += rg[1]+',';
            }
            rgs = strRg;
//            alert(rgs);
          } else {
            rgs = 'East%20Africa,West%20Africa,South%20Asia,Southeast%20Asia,Latin%20America';
          }
          var script = document.createElement('script');
          script.src = 'http://amkn.local/sitesgeojson/?rgs='+rgs;
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(script, s);        
        }

        window.eqfeed_callback = function(results) {
          var image = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniH.png";          
          var infowindow;
          for (var i = 0; i < results.features.length; i++) {
            idx = i;
            var coords = results.features[i].geometry.coordinates;
            var latLng = new google.maps.LatLng(coords[1], coords[0]);
            var marker = new google.maps.Marker({
              position: latLng,
              map: map,
              icon: image,
              title: results.features[i].properties.title
            });
            
            markerArray[results.features[i].id] = marker;
//            google.maps.event.addListener(marker, 'click', function(event) {alert(results.features[idx].properties.title)});
            google.maps.event.addListener(marker,'mouseover', (function(marker,i,results){
              return function() {
                if(infowindow){
                    eval(infowindow).close();
                }
                $("div#"+results.features[i].id).addClass("ccafs_sites_selected").siblings().removeClass("ccafs_sites_selected");  
                $('#sites').scrollTo($("div#"+results.features[i].id), 500,{offset: {top:-135, left:0}});
                var contentString = '<div id="content"><b>'+results.features[i].properties.title+' ['+results.features[i].properties.country+'] <br>CCAFS Region: '+results.features[i].properties.region+'</b></div>';
                infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                 infowindow.open(map,marker);
              };
            })(marker,i,results));
            
            google.maps.event.addListener(marker,'dblclick', (function(marker,i,results){
              return function() {
                if(infowindow){
                    eval(infowindow).close();
                }
                $("div#"+results.features[i].id).addClass("ccafs_sites_selected").siblings().removeClass("ccafs_sites_selected");  
                var contentString = '<div id="content"><b>'+results.features[i].properties.title+' ['+results.features[i].properties.country+'] <br>CCAFS Region: '+results.features[i].properties.region+'</b></div>';
                infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                 infowindow.open(map,marker);
              };
            })(marker,i,results));
            
            google.maps.event.addListener(marker,'click', (function(i,results){
              return function() {
                document.location = "./?p="+results.features[i].id;
              };
            })(i,results));
            google.maps.event.addListener(map, "click", function(){
              infowindow.close();
            });
          }
        }
        
        function openDialog (marker) {
          google.maps.event.trigger(marker, 'dblclick');
        }
        
        function updateMap () {
          var script = document.createElement('script');
          script.src = 'http://amkn.local/sitesgeojson/?rgs=East%20Africa';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(script, s);
          google.maps.event.trigger(map, 'resize');
        }
        google.maps.event.addDomListener(window, 'load', initialize);
      </script>
      <?php
//        print_r($_GET['region']);
        $checkOng='checked';        
      ?>
      <form class="pure-form pure-form-stacked" name ="search-sources" id ="search-sources" method="get">
          <fieldset>
            <legend>Search By</legend>                      
            <div class="pure-g">
              <div class="pure-u-1-6">
                <label for="space">
                  &nbsp;
                </label>
                <label for="remember">
                    <input id="ong" name="region[ea]" onchange="this.form.submit()" type="checkbox" value="East Africa" <?php echo (isset($_GET['region']['ea']))?'checked':'' ?>>East Africa
                </label>
              </div>
              <div class="pure-u-1-6">
                <label for="space">
                  &nbsp;
                </label>
                <label for="remember">
                    <input id="ong" name="region[wa]" onchange="this.form.submit()" type="checkbox" value="West Africa" <?php echo (isset($_GET['region']['wa']))?'checked':'' ?>>West Africa
                </label>
              </div>
              <div class="pure-u-1-6">
                <label for="space">
                  &nbsp;
                </label>
                <label for="remember">
                    <input id="ong" name="region[la]" onchange="this.form.submit()" type="checkbox" value="Latin America" <?php echo (isset($_GET['region']['la']))?'checked':''?>>Latin America
                </label>
              </div>
              <div class="pure-u-1-6">
                <label for="space">
                  &nbsp;
                </label>
                <label for="remember">
                    <input id="ong" name="region[sea]" onchange="this.form.submit()" type="checkbox" value="Southeast Asia" <?php echo (isset($_GET['region']['sea']))?'checked':''?>> Southeast Asia 
                </label>
              </div>
              <div class="pure-u-1-6">
                <label for="space">
                  &nbsp;
                </label>
                <label for="remember">
                    <input id="ong" name="region[sa]" onchange="this.form.submit()" type="checkbox" value="South Asia" <?php echo (isset($_GET['region']['sa']))?'checked':''?>>South Asia
                </label>
              </div>
            </div>            
          </fieldset>  
        </form>
        <div style="height: 400px; width: 700px;float:left;margin-bottom: 20px" id="map-canvas"></div>
        <div id="sites" style="height: 400px; width: 310px;float:left; overflow: auto;margin-bottom: 20px">
          <?php get_template_part( 'loop', 'archive' );?>
        </div>
        <div>
        <?php 
//          global $wp_query;
//          echo $wp_query->found_posts;
        ?>
        </div>
    <?php  else: ?>
      <script>         
        $(function() {
          $( "#initDate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
          });
          $( "#endDate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
          }); 
          $('#reset').click(function(){
            var elements = document.getElementById("search-sources").elements;

            for(i=0; i<elements.length; i++) {

            field_type = elements[i].type.toLowerCase();

            switch(field_type) {

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
            <?php if ($_GET['order'] == 'true'):?>
              <input type="hidden" id="order" name="order" value="true">
            <?php else:?>
              <input type="hidden" id="order" name="order" value="false">
            <?php endif;?>
            <input type="hidden" id="orderby" name="orderby" value="title">            
            <div class="pure-g">
              <div class="pure-u-1-6">
                <label for="initDate">
                  Start date
                </label>
                <input type="text" name="initDate" id="initDate" value="<?php echo $_GET['initDate']?>" class="pure-input-2-3">          
              </div>
              <div class="pure-u-1-6">
                <label for="endDate">
                  End date
                </label>          
                <input type="text" name="endDate" id="endDate" value="<?php echo $_GET['endDate']?>" class="pure-input-2-3">
              </div>
              <div class="pure-u-1-6">
                <label for="keyword">
                  Keyword
                </label>          
                <input type="text" name="keyword" id="keyword" value="<?php echo $_GET['keyword']?>" class="pure-input-2-3">
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
      get_template_part( 'loop', 'archive' );
      endif;
    ?>

  </div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>