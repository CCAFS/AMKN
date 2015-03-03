<?php
/*
 * Plugin Name: Activities Importer (P&R)
 * Description: Plugin to generate a XML from app Planning and Reporting from CCAFS CGIAR
 * Author: Camilo Rodriguez
 * Version: 1.0
 */

add_action('admin_menu', 'OpcionMenu');

function OpcionMenu() {
  add_menu_page('Options', 'Activities generator XML', 'manage_options', 'pr-admin.php', 'AdminOpciones');
// add_submenu_page('pc-admin.php','cot opciones generales', 'Mi cot', 'manage_options', 'pc-admin.php-cot', 'AdminCotizador');
}

function AdminOpciones() {
  if (!current_user_can('manage_options')) {
    wp_die('User have not enough permission');
  }
//  wp_enqueue_style('pcadminstyle', plugins_url('css/pcadmin.css', __FILE__));
  if ($_POST) {
    if (isset($_POST['year'])) :
      $dir = plugin_dir_path(__FILE__);
      update_option('pr_year', $_POST['pr_year']);
      update_option('pr_limit', $_POST['pr_limit']);
      $origen = file_get_contents('http://activities.ccafs.cgiar.org/xml.do?year=' . $_POST['year']);
      $fh = fopen("origen.xml", 'w');
      $stringData = $origen;
      fwrite($fh, $stringData);
      fclose($fh);
      ?>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script type="text/javascript">
        var templateUrl = '<?php echo plugins_url(); ?>';
        var templatePath = '<?php echo get_template_directory_uri(); ?>';
      </script>
      <div id="loading"><img style="" src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" alt="Loader" /></div>
      <form style="display:none" action="<?php echo plugins_url(); ?>/activitiesImporter/createXML.php" method="post" name="pas" id="pas" target="fake">
        Name: <input type="text" name="name"><br>
        <textarea id="dataxml" name="dataxml"></textarea>
        <input type="submit">
      </form>
      <script type="text/javascript" src="<?php echo plugins_url(); ?>/activitiesImporter/importer.js">
      </script> 
      <?php
    endif;
//    if ($_POST['limit'])
//      update_option('pr_limit', $_POST['pr_limit']);
  }
  ?>
  <h2>Service options</h2>
  <form method="post" class='formopciones'>
    <label>Year</label><input type='text' name='year' value='<?php echo get_option('pr_year') ?>'>
    <label>Limit</label><input type='text' name='limit' value='<?php echo get_option('pr_limit') ?>'>
    <input type='submit' name='sent' value='Generate'>
  </form>
  <iframe id="fake" style="display:block" frameborder="0"></iframe>
  <?php
}

//$year = 2012;
//$limit = 20;
//if (isset($_GET['year']) && $_GET['year'] != '')
//  $year = $_GET['year'];
//if (isset($_GET['limit']) && $_GET['limit'] != '')
//  $limit = $_GET['limit'];
//$origen = file_get_contents('http://activities.ccafs.cgiar.org/xml.do?year=' . $year . '&limit=' . $limit);
//$fh = fopen("origen.xml", 'w');
//$stringData = $origen;
//fwrite($fh, $stringData);
//fclose($fh);
?>
<!--<html>
  <body>
    <iframe id="fake" style="display:block" frameborder="0"></iframe>
    <form style="display:none" action="createXML.php" method="post" name="pas" id="pas" target="fake">
      Name: <input type="text" name="name"><br>
      <textarea id="dataxml" name="dataxml"></textarea>
      <input type="submit">
    </form>
    <script type="text/javascript" src="importer.js">
    </script>  
  </body>
</html>-->
<?php 
