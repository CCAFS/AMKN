<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$metaDesc = get_post_meta($post->ID, 'content_description', true);
$srcID = get_post_meta($post->ID, 'syndication_feed_id', true);
$start = get_post_meta($post->ID, 'startDate', true);
$end = get_post_meta($post->ID, 'endDate', true);
$milestone = get_post_meta($post->ID, 'milestone', true);
$budget = get_post_meta($post->ID, 'budget', true);
$idActivity = get_post_meta($post->ID, 'activityId', true);
$theme = get_post_meta($post->ID, 'theme', true);
$keywords = get_post_meta($post->ID, 'keywords');
$contacts = get_post_meta($post->ID, 'contactName');
$contactsEmail = get_post_meta($post->ID, 'contactEmail');

//$budget = 1500000;

if (isset($_GET["embed"]) && $_GET["embed"] == "true") {
  get_header('embed');
} else {
  get_header();
}

if (isset($_GET["embed"]) && $_GET["embed"] == "true") {
  ?>
  <div class="content">
    <a class="msGenButton" target="_blank" href="<?php the_permalink(); ?>">Open in new window</a>
    <h2 class="title"><?php the_title(); ?></h2>
    <div class="entrymeta">Source: <em><?php echo get_bookmark($srcID)->link_description; ?></em> <a target="_blank" href="<?php echo get_post_meta($post->ID, 'syndication_permalink', true); ?>">permalink</a></div>
    <div class="entrymeta">Posted by <?php the_author(); ?> on <?php the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses', 'one response', '% responses'); ?></a>--><?php echo get_the_tag_list(' | ', ', ', ''); ?> </div>
    <!--Begin Share Button-->
    <?php
    if (function_exists('sociable_html')) {
//    echo sociable_html();
    }
    ?>
    <!--End Share Button-->
    <?php //get_sidebar('sidemap_embed'); ?>
    <div class="video blog-post">
      <?php if (have_posts()) while (have_posts()) : the_post(); ?>
          <?php the_excerpt(); ?>
          <p>
            <a target="_top" href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a>
          </p>   
          <br clear="all" />
        <?php endwhile; // end of the loop. ?>
      <?php echo "<p><b>Start Date: </b>" . $start . "<br><b>End date: </b>" . $end . "<br><b>Milestone: </b>" . $milestone . "<br><b>Budget: </b>$" . number_format($budget, 2) . "</p>"; ?>
      <?php if ($metaDesc != ''): ?>
        <h3>Themes</h3>
        <p><?php echo $metaDesc; ?></p>
      <?php endif; ?>
      <?php
      $args2 = array(
          'public' => true,
          '_builtin' => false
      );
      $excludeTaxonomies = array("cgmap-countries", "farming_systems");
      $output = 'objects'; // or names
      $operator = 'and'; // 'and' or 'or'
      $taxonomies = get_taxonomies($args2, $output, $operator);
      if ($taxonomies) {
        asort($taxonomies);
        foreach ($taxonomies as $taxonomy) {
          $getArgs = array(
              'orderby' => 'name'
          );
          $terms = wp_get_object_terms($post->ID, $taxonomy->name);
          $count = count($terms);
          if ($count > 0 && (!in_array($taxonomy->name, $excludeTaxonomies))) {
            echo '<h3 class="videolabels">' . $taxonomy->label . ': <span class="taxItems">';
            unset($termNames);
            foreach ($terms as $term) {
              $termNames[] = $term->name;
            }
            echo join(", ", $termNames) . '</span></h3>';
          }
        }
      }
      ?>
    </div>
  </div><!-- end content -->
  <!--</div>-->
  <?php
  get_footer('embed');
} else {
  ?>
  <div id="container">

    <div id="sidebar">&nbsp;
      <?php // get_sidebar('sidemap'); ?>
      <?php // get_sidebar('sidemore'); ?>  
    </div><!--end sidebar -->
    <div class="content">
      <h3><?php echo 'Activity '.$idActivity.' - Theme '.$theme?></h3><hr>
      <div class="entrymeta">Source: <em><?php echo get_bookmark($srcID)->link_description; ?></em> <a target="_blank" href="<?php echo get_post_meta($post->ID, 'syndication_permalink', true); ?>">permalink</a></div>
      <div class="entrymeta">Posted by <?php the_author(); ?> on <?php the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses', 'one response', '% responses'); ?></a>--><?php echo get_the_tag_list(' | ', ', ', ''); ?> </div>
      <br><b>Title:</b><br>
      <?php the_title(); ?>
      <?php if (count($keywords)):?>
        <?php 
          foreach($keywords as $key => $keyword):         
            $keyw .= $keyword.", ";
          endforeach;
        ?>
      <?php endif;?>
      <br><br><b>Keywords:</b><br>
      <?php echo ($keyw)?substr_replace($keyw, ".", -2):''; ?>          
      <div class="blog-post">        
        <?php // if (have_posts()) while (have_posts()) : the_post(); ?>
          <br><b>Description:</b><br>
          <?php the_content(); ?>
        <?php // endwhile; // end of the loop.  ?>
        <br><br>
        <table id="indicators" class="generalInformation">
          <tr>
            <td>
              <?php echo "<b>Start Date: </b>"?>
            </td>
            <td>
              <?php echo ($start)?date('d F, Y', strtotime($start)):'No data';?>
            </td>
            <td>
              <?php echo "<b>Budget:<b>"?>
            </td>
            <td>
              <?php // echo "USD ".$budget;?>
              <?php echo "USD ".number_format(str_replace(',', '', $budget), 2,',','.')?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo "<b>End date: </b>"?>  
            </td>
            <td>
              <?php echo ($end)?date('d F, Y', strtotime($end)):'No data';?>
            </td>
            <td>
              <?php echo "<b>Milestone: </b>" ?>
            </td>
            <td>
              <?php echo $milestone?>
            </td>
          </tr>
          </table>
          <br>
          <table class="">
          <?php foreach($contacts as $key => $contact): ?>
            <?php if ($key==0) :?>
            <tr>
              <td style="width: 160px;">
                <b>Contact Person:</b>
              </td>                     
              <td colspan="3"><?php echo $contact; if(isset($contactsEmail[$key])) echo "(".$contactsEmail[$key].")"?></td>
            </tr>
            <?php else:?>
              <tr>
                <td></td>
                <td colspan="3"><?php echo $contact; if(isset($contactsEmail[$key])) echo "(".$contactsEmail[$key].")"?></td>
              </tr>
            <?php endif;?>
          <?php endforeach;?>          
        </table>
        <?php if ($metaDesc != ''): ?>
          <h3>Themes</h3>
          <p><?php echo $metaDesc; ?></p>
        <?php endif; ?>
        <?php
        $args2 = array(
            'public' => true,
            '_builtin' => false
        );
        $excludeTaxonomies = array("cgmap-countries", "farming_systems");
        $output = 'objects'; // or names
        $operator = 'and'; // 'and' or 'or'
        $taxonomies = get_taxonomies($args2, $output, $operator);
        if ($taxonomies) {
          asort($taxonomies);
          foreach ($taxonomies as $taxonomy) {
            $getArgs = array(
                'orderby' => 'name'
            );
            $terms = wp_get_object_terms($post->ID, $taxonomy->name);
            $count = count($terms);
            if ($count > 0 && (!in_array($taxonomy->name, $excludeTaxonomies))) {
              echo '<h3 class="videolabels">' . $taxonomy->label . ': <span class="taxItems">';
              unset($termNames);
              foreach ($terms as $term) {
                $termNames[] = $term->name;
              }
              echo join(", ", $termNames) . '</span></h3>';
            }
          }
        }
        ?>   
      </div>
      <?php
      if (function_exists('sociable_html')) {
        echo sociable_html();
      }
      ?>
    </div><!-- end content -->


  </div><!-- end Container -->

  <?php
  get_footer();
}
?>