<?php
require('../../../wp-blog-header.php'); 
get_header('home');

$url = "http://lab.amkn.org/wp-content/themes/amkn_theme/services.php/DataAndTools/get";
$http_respone_header = file_get_contents($url);
$apps = json_decode($http_respone_header,true);
//echo "<pre>".print_r( json_decode($http_respone_header,true),true)."</pre>"; 
?>
<table>
<?php
foreach ($apps as $app) :
?>

    <tr >
      <td>
      <a href="<?php echo $app['url']?>">
        <img float="inherit" width="300" height="212" src="<?php echo $app['imageUrl']?>" />
      </a>
      </td>

      <td style="vertical-align: top">
      <h4><?php echo $app['title']?></h4>
      <?php echo $app['description']?>
      </td>
    </tr>

<?php    
endforeach;
?>
  </table>
<?php
get_footer('home'); 
?>