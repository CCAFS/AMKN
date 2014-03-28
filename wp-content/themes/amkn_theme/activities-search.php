<?php

/**
 * Template Name: Activities (P&R) Search Template
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$searchQ = $_GET["q"];
echo $_GET["leader"];
get_header('home');
?>
<div id="container">
<div class="content">
<h3 class="title"><?php the_title(); ?></h3>
<?php
$args = array('meta_query' => array(array('key' => 'leaderAcronym')), 'suppress_filters' => 0, 'post_type' => array('ccafs_activities'), 'orderby' => 'post_date', 'order' => 'DESC', 'post_status' => 'publish');
$myposts = get_posts($args);

foreach ($myposts as $key => $post){
  $lead = get_post_meta($post->ID, 'leaderAcronym', true);
  $leader[$lead] = $lead;
}
//echo "<pre>".print_r($leader,true)."</pre>";
?>
<meta charset="utf-8">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
<script>
  var treeData;
$(function() {
  $( "#initDate" ).datepicker();
  $( "#endDate" ).datepicker();
  $( "#search" ).click(function () {
//    alert($( "search-activities" ).serialize());
    $.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "my_user_vote", post_id : post_id, nonce: nonce},
         success: function(response) {
            if(response.type == "success") {
               $("#resultActivities").html(response.vote_count)
            }
            else {
               alert("Your vote could not be added")
            }
         }
      }); 
  });
});
</script>
<div >
  <form class="pure-form pure-form-stacked" name ="search-activities" id ="search-activities">
  <fieldset>
    <legend>Filters</legend>    
      <label for="theme">Search by Theme</labe>          
      <input type="text" id="theme">
      
      <label for="leader">Leader</labe>      
      <select id="leader">
        <option value="0">---</option>
        <?php foreach ($leader as $lead):?>
        <option value=<?php echo $lead?>><?php echo $lead?></option>
        <?php endforeach;?>
      </select>
      
      <div class="pure-g">
        <div class="pure-u-1-3">
          <label for="initDate">
            Start date
          </label>
          <input type="text" id="initDate">          
        </div>
        <div class="pure-u-1-3">
          <label for="endDate">
            End date
          </label>          
          <input type="text" id="endDate">
        </div>
      </div>
      <!--<button id="search" class="pure-button">Search</button>-->
      <input type="button" id="search" class="pure-button pure-button-primary" value="Search">      
  </fieldset>  
  </form>
</div>
<div id="resultActivities">
  
</div>

</div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>