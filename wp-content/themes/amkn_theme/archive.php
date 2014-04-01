<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
$currType=get_query_var( 'taxonomy' );
$themes = array('1'=>'1','2'=>'2','3'=>'3','4.1'=>'4.1','4.2'=>'4.2','4.3'=>'4.3');
?>
<div id="container">
  <div class="content">
    <h2 class="title"><?php echo get_post_type_object( get_query_var( 'post_type' ) )->labels->name; ?></h2>
    <?php 
      if (get_query_var( 'post_type')== 'ccafs_activities') :
        $args = array('meta_query' => array(array('key' => 'leaderAcronym')),  'posts_per_page'   => 600, 'post_type' => array('ccafs_activities'), 'orderby' => 'post_date', 'order' => 'DESC');
        $myposts = get_posts($args);

        foreach ($myposts as $key => $post){
          $lead = get_post_meta($post->ID, 'leaderAcronym', true);
          $leader[str_replace(' ', '',$lead)] = $lead;
        }
        ksort($leader);
//        echo "<pre>".count($myposts).print_r($leader,true)."</pre>";
    ?>
        <meta charset="utf-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
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
        </script>
        <form class="pure-form pure-form-stacked" name ="search-activities" id ="search-activities" method="get" action="/ccafs-activities/">
          <fieldset>
            <legend>Filters</legend>  
            <div class="pure-g">
              <div class="pure-u-1-3">
                <label for="theme">Search by Theme</labe>
                <select name="theme">
                  <option value="0">---</option>
                  <?php foreach ($themes as $theme):?>
                    <?php $selected = ''; if ($_GET['theme'] == $theme) $selected = 'selected';?>
                    <option value=<?php echo $theme?> <?php echo $selected?>><?php echo $theme?></option>
                  <?php endforeach;?>
                </select>            
              </div>
              <div class="pure-u-1-3">
                <label for="leader">Leader</labe>      
                <select name="leader">
                  <option value="0">---</option>
                  <?php foreach ($leader as $key => $lead):?>
                    <?php $selected = ''; if ($_GET['leader'] == $lead) $selected = 'selected';?>
                    <option value='<?php echo $lead?>' <?php echo $selected?>><?php echo $lead?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
            <div class="pure-g">
              <div class="pure-u-1-3">
                <label for="initDate">
                  Start date
                </label>
                <input type="text" name="initDate" id="initDate" value="<?php echo $_GET['initDate']?>">          
              </div>
              <div class="pure-u-1-3">
                <label for="endDate">
                  End date
                </label>          
                <input type="text" name="endDate" id="endDate" value="<?php echo $_GET['endDate']?>">
              </div>
            </div>
            <button id="search" type="submit" class="pure-button pure-button-primary">Search</button>
            <button id="reset" type="button" class="pure-button pure-button-active">Reset</button>
            <!--<input type="submit" name="search" class="pure-button pure-button-primary" value="Search">-->      
          </fieldset>  
        </form>    
    <?php   
        endif;        
        get_template_part( 'loop', 'archive' ); 
    ?>        

  </div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>