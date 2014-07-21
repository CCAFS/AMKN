<?php
/*
 * Copyright (C) 2014 CRSANCHEZ CCAFS-CIAT
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

//echo $_SESSION['lastDate'];
$newsV = false;
$newsP = false;
$newsB = false;
$args = array(
  'post_type' => 'video_testimonials',
  'order' => 'DESC',
  'showposts' => '1',
  'date_query' => array(
    array(
      'after' => $_SESSION['lastDate'],
      'inclusive' => true,
    ),
  ),
);
query_posts($args);
global $wp_query;
if ($wp_query->found_posts > 0)
  $newsV = true;
$postType = "";
?>
<?php /* Start the Loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php
  $postType = $post->post_type;
  $postThumb = "";

  switch ($postType) {
    case "video_testimonials":
      $firstPostThumb = get_post_meta($post->ID, 'thumb', true);
      $postThumb = substr($firstPostThumb, 0, strrpos($firstPostThumb, '/') + 1) . "0.jpg";
      //$postThumb = str_replace( $firstPostThumb, $postThumbName, "0.jpg");
      break;
    case "photo_testimonials":
      $postThumb = get_post_meta($post->ID, 'galleryThumb', true);
      break;
    case "amkn_blog_posts":
      //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) );
      $postThumb = get_post_thumbnail_id($post->ID);

      //echo "i equals 2";
      break;
  }
  $metaDesc = get_post_meta($post->ID, 'content_description', true);
  if (strlen($metaDesc) > 65)
    $metaDesc = substr($metaDesc, 0, 65) . "...";
  ?>
  <div class="notice" style="display: none;" id="grabMe">
    <img class="titleico" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-mini.png" alt="<?php echo get_post_type_object($postType)->labels->singular_name; ?>"/> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <br><a href="./video" style="font-size: 12px"><?php echo $wp_query->found_posts ?> video posts unread</a>
  </div>
  <?php
endwhile;

$args = array(
  'post_type' => 'photo_testimonials',
  'order' => 'DESC',
  'showposts' => '1',
  'date_query' => array(
    array(
      'after' => $_SESSION['lastDate'],
      'inclusive' => true,
    ),
  ),
);
query_posts($args);
global $wp_query;
if ($wp_query->found_posts > 0)
  $newsP = true;
$postType = "";
?>
<?php /* Start the Loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php
  $postType = $post->post_type;
  $postThumb = "";

  switch ($postType) {
    case "video_testimonials":
      $firstPostThumb = get_post_meta($post->ID, 'thumb', true);
      $postThumb = substr($firstPostThumb, 0, strrpos($firstPostThumb, '/') + 1) . "0.jpg";
      //$postThumb = str_replace( $firstPostThumb, $postThumbName, "0.jpg");
      break;
    case "photo_testimonials":
      $postThumb = get_post_meta($post->ID, 'galleryThumb', true);
      break;
    case "amkn_blog_posts":
      //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) );
      $postThumb = get_post_thumbnail_id($post->ID);

      //echo "i equals 2";
      break;
  }
  $metaDesc = get_post_meta($post->ID, 'content_description', true);
  if (strlen($metaDesc) > 65)
    $metaDesc = substr($metaDesc, 0, 65) . "...";
  ?>
  <div class="notice" style="display: none;" id="grabMe2">
    <img class="titleico" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-mini.png" alt="<?php echo get_post_type_object($postType)->labels->singular_name; ?>"/><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <br><a href="./photo-sets" style="font-size: 12px"><?php echo $wp_query->found_posts ?> photo sets unread</a>
  </div>
  <?php
endwhile;

$args = array(
  'post_type' => 'amkn_blog_posts',
  'order' => 'DESC',
  'showposts' => '1',
  'date_query' => array(
    array(
      'after' => $_SESSION['lastDate'],
      'inclusive' => true,
    ),
  ),
);
query_posts($args);
global $wp_query;
if ($wp_query->found_posts > 0)
  $newsB = true;
$postType = "";
?>
<?php /* Start the Loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php
  $postType = $post->post_type;
  $postThumb = "";

  switch ($postType) {
    case "video_testimonials":
      $firstPostThumb = get_post_meta($post->ID, 'thumb', true);
      $postThumb = substr($firstPostThumb, 0, strrpos($firstPostThumb, '/') + 1) . "0.jpg";
      //$postThumb = str_replace( $firstPostThumb, $postThumbName, "0.jpg");
      break;
    case "photo_testimonials":
      $postThumb = get_post_meta($post->ID, 'galleryThumb', true);
      break;
    case "amkn_blog_posts":
      //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) );
      $postThumb = get_post_thumbnail_id($post->ID);

      //echo "i equals 2";
      break;
  }
  $metaDesc = get_post_meta($post->ID, 'content_description', true);
  if (strlen($metaDesc) > 65)
    $metaDesc = substr($metaDesc, 0, 65) . "...";
  ?>
  <div class="notice" style="display: none;" id="grabMe3">
    <img class="titleico" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-mini.png" alt="<?php echo get_post_type_object($postType)->labels->singular_name; ?>"/><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <br><a href="./blog-posts" style="font-size: 12px"><?php echo $wp_query->found_posts ?> blog posts unread</a>
  </div>
<?php endwhile; ?>
<?php if ($newsV || $newsP || $newsB): ?>
  <script>
    jQuery(document).ready(function($) {
      setTimeout(function() {
        new jBox('Notice', {
          id: 'jBoxInit',
          content: 'A new content is available!',
          attributes: {
            x: 'right',
            y: 'bottom'
          },
          position: {
            x: 5,
            y: 10
          },
          autoClose: false,
          onCloseComplete: function() {
            if ('<?php echo $_SESSION['lastDate']?>' != '0') {
              if (<?php echo ($newsV) ? 'true' : 'false'; ?>) {
                new jBox('Notice', {
                  content: $('#grabMe'),
                  //          color: 'red',
                  attributes: {
                    x: 'right',
                    y: 'bottom'
                  },
                  position: {
                    x: 5,
                    y: 10
                  },
                  autoClose: false,
                });
              }
              if (<?php echo ($newsP) ? 'true' : 'false'; ?>) {
                setTimeout(function() {
                  new jBox('Notice', {
                    content: $('#grabMe2'),
                    //          color: 'blue',
                    attributes: {
                      x: 'right',
                      y: 'bottom'
                    },
                    position: {
                      x: 5,
                      y: 10
                    },
                    autoClose: false,
                  });
                }, 500);
              }
              if (<?php echo ($newsB) ? 'true' : 'false'; ?>) {
                setTimeout(function() {
                  new jBox('Notice', {
                    content: $('#grabMe3'),
                    //          color: 'green',
                    attributes: {
                      x: 'right',
                      y: 'bottom'
                    },
                    position: {
                      x: 5,
                      y: 10
                    },
                    autoClose: false,
                  })
                }, 1000);
              }
            } else {
              scrollNew()
            }
          }
        })
      }, 5000);
    });
  </script>
<?php endif; ?>
