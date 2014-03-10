<?php
require('../../../wp-blog-header.php'); 
get_header('home');

$url = "http://amkn.org/wp-content/themes/amkn_theme/services.php/DataAndTools/get";
$http_respone_header = file_get_contents($url);
$apps = json_decode($http_respone_header,true);
//echo "<pre>".print_r( json_decode($http_respone_header,true),true)."</pre>"; 
?>
<script>
  document.getElementById("menu-item-2598").className =
   document.getElementById("menu-item-2598").className.replace
      ( /(?:^|\s)current-menu-item(?!\S)/ , '' );
  document.getElementById("menu-item-846").className =
   document.getElementById("menu-item-846").className.replace
      ( /(?:^|\s)current-menu-item(?!\S)/ , '' );
  document.getElementById("menu-item-846").className =
   document.getElementById("menu-item-846").className.replace
      ( /(?:^|\s)current_page_item(?!\S)/ , '' );
</script>
<div id="container">
<h2>Data & Tools</h2>
<?php
foreach ($apps as $app) :
?>

    <div id="tool">
      <div id="tool-img">
      <a href="<?php echo $app['url']?>">
        <img src="<?php echo $app['imageUrl']?>" />
      </a>
      </div>

      <div id="tool-content">
      <a href="<?php echo $app['url']?>"><h4><?php echo $app['title']?></h4> </a>
      <?php echo $app['description']?>
      </div>
    </div>

<?php    
endforeach;
?>
</div>
<?php
get_footer('home'); 
?>