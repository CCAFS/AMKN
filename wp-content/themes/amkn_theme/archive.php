<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
$currType=get_query_var( 'taxonomy' );
$themes = array('1'=>'Theme 1','2'=>'Theme 2','3'=>'Theme 3','4.1'=>'Theme 4.1','4.2'=>'Theme 4.2','4.3'=>'Theme 4.3');
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
          if (!cgValidate($lead))
            $leader[str_replace(' ', '',$lead)] = $lead;
        }
        ksort($leader);
//        echo "<pre>".count($myposts).print_r($leader,true)."</pre>";
    ?>
        <meta charset="utf-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/libs/jquery.tablesorter/themes/blue/style.css">
        <script src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <!--<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/libs/jquery.tablesorter/jquery-latest.js"></script>--> 
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/libs/jquery.tablesorter/jquery.tablesorter.js"></script>
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
        $(document).ready(function() 
            { 
//                $("#myTable").tablesorter(); 
            } 
        );
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
                <label for="theme">Theme / Flagship</labe>
                <select name="theme">
                  <option value="0">---</option>
                  <?php foreach ($themes as $key => $theme):?>
                    <?php $selected = ''; if ($_GET['theme'] == $key) $selected = 'selected';?>
                    <option value=<?php echo $key?> <?php echo $selected?>><?php echo $theme?></option>
                  <?php endforeach;?>
                </select>            
              </div>
              <div class="pure-u-1-6">
                <label for="leader">CG Center</labe>      
                <select name="leader">
                  <option value="0">---</option>
                  <?php foreach ($leader as $key => $lead):?>
                    <?php $selected = ''; if ($_GET['leader'] == $lead) $selected = 'selected';?>
                    <option value='<?php echo $lead?>' <?php echo $selected?>><?php echo $lead?></option>
                  <?php endforeach;?>
                </select>
              </div>
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
              <div class="pure-u-1-5">
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
        <table id="myTable" class="tablesorter">
          <thead>
          <tr>
            <th>
              Title
            </th>            
            <th>
              Theme / Flagship
            </th>
            <th>
              CG Center
            </th>
            <th onclick="if(document.getElementById('order').value=='true') {document.getElementById('order').value='false';} else {document.getElementById('order').value=true};document.getElementById('orderby').value='budget';document.getElementById('search-activities').submit();">
              Budget (USD)
            </th>
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
    <?php  else:
        get_template_part( 'loop', 'archive' );         
      endif;
    ?>

  </div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>