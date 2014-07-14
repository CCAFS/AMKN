<?php
/*
  Plugin Name:Trabaria Flickr API
  Plugin URI: http://www.trabaria.com/
  Description: Adds a plugin config form as part of the plugin page
  Author: trabaria, michaelmarus
  Version: 0.3
  Author URI: http://www.trabaria.com/
  Generated At: http://www.trabaria.com/;
 */

/*  Copyright 2011  trabaria  (email : admin@trabaria.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

function show_trab_feeder_options_page() {

  if (isset($_POST['info_update'])) {
    update_option('trab_flickrUserID', (string) $_POST["trab_flickrUserID"]);
    update_option('trab_flickrAPIKey', (string) $_POST["trab_flickrAPIKey"]);

    echo '<div id="message" class="updated fade">';
    echo '<p><strong>Configuration has been updated</strong></p></div>';
  }

  $flickrUserID = get_option('trab_flickrUserID');
  $flickrAPIKey = get_option('trab_flickrAPIKey');
  ?>

  <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/ui-lightness/jquery-ui.css" />

  <style type="text/css">
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>

  <h2>Trabaria Flickr API Settings</h2>
  <script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAbjNZedVL8o9u2qgfhw77kxS4aEWQEBuh5wNQngQauAIJkgqH0hQrmkAmVymeO9R_7sKiHOfEIdBUsw"></script>
  <script type="text/javascript">
    //<![CDATA[
    google.load("jquery", "1.4.2");
    google.load("jqueryui", "1.8.2");
    google.load("feeds", "1");

    function feedSample() {
      // Create a feed control
      var feedControl = new google.feeds.FeedControl();
      // Add two feeds.
      feedControl.addFeed("<?php echo get_option('siteurl') . '/wp-content/plugins/trabaria-flickr/'.$flickrUserID.'.xml'; ?>", "Photo Sets");
      // Draw it.
      console.log("<?php echo get_option('siteurl') . '/wp-content/plugins/trabaria-flickr/'.$flickrUserID.'.xml'; ?>");
      feedControl.draw(document.getElementById("feedContent"));
    }
    google.setOnLoadCallback(feedSample);
    //]]>
  </script>
  <script type="text/javascript">
  //<![CDATA[
    $(function() {
      $("#tabs").tabs();
    });

  //]]>
  </script>
  <div class="feeds">
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">Flickr API Key</a></li>
        <li><a href="#tabs-2">Sample Usage</a></li>
        <li><a href="#tabs-3">Feedback</a></li>
      </ul>
      <div id="tabs-1">
        <p>For information, please visit:<br />
          <a href="http://www.trabaria.com/">http://www.trabaria.com</a></p>
        <form method="post">
          <input type="hidden" name="info_update" id="info_update" value="true" />
          <div class="postbox">
            <h3>
              <label for="title">Trabaria Settings</label>
            </h3>
            <div class="inside">
              <?php
              $taxonomies = get_taxonomies('', 'names');
              echo '
	<table class="form-table">
	<tr valign="top">
	<th scope="row">Flickr API Key</th>
	<td><input type="text" name="trab_flickrAPIKey" value="' . $flickrAPIKey . '" size="40" /></td>
	</tr>
	<tr valign="top">
	<th scope="row">Flickr UserID</th>
	<td><input type="text" name="trab_flickrUserID" value="' . $flickrUserID . '" size="40" /></td>
	</tr>
	</table>
	';
              ?>
            </div>
          </div>
          <div class="submit">
            <input type="submit" name="info_update" value="Update Options &raquo;" />
          </div>
        </form>
      </div>
      <div id="tabs-2">
        Here is your feed URL:  <a href="<?php echo get_option('siteurl') . '/wp-content/plugins/trabaria-flickr/getPhotoSetsAsFeed.php'; ?>">Flickr PhotoSets</a>
        <div class="submit">
          <input type="submit" name="info_update" value="Update feed &raquo;" />
        </div>
        <div id="feedContent">Loading...</div>
      </div>
      <div id="tabs-3">


      </div>
    </div>
  </div>
  <?php
}

function wp_trab_feeder_options() {
  echo '<div class="wrap"><h2>Trabaria Flickr API</h2>';
  echo '<div id="poststuff"><div id="post-body">';
  show_trab_feeder_options_page();
  echo '</div></div>';
  echo '</div>';
}

// Display The Options Page
function wp_trab_feeder_options_page() {
  add_options_page('TrabFeeder', 'Trabaria Flickr API Options', 'manage_options', __FILE__, 'wp_trab_feeder_options');
}

add_action('admin_menu', 'wp_trab_feeder_options_page');
if (!class_exists('trabaria_flickr_plugin')) {

  class trabaria_flickr_plugin {

    /**
     * PHP 4 Compatible Constructor
     */
    function trabaria_flickr_plugin() {
      $this->__construct();
    }

    /**
     * PHP 5 Constructor
     */
    function __construct() {

      add_action("load-plugins.php", array(&$this, "add_scripts"));
      add_action("admin_head-plugins.php", array(&$this, "add_css"));
      add_action("after_plugin_row", array(&$this, "add_config_form"), 10, 3);
      add_action("wp_ajax_pcsc_config-update", array(&$this, "save_config"));
      add_filter("plugin_action_links", array(&$this, 'add_settings_link'), 10, 2);
    }

    /**
     * Add the link to open the settings panel
     * I have left this as a javascript only link but it could
     * easily be changed to link to an actual page, but without adding
     * an additional menu, just in case javascript didn't work
     */
    function add_settings_link($links, $file) {
      if ($file == plugin_basename(__FILE__)) {
        $links[] = '<a id="pluginconfsamplelink" href="javascript:void(0)" title="Configure this plugin">Settings</a>';
        $links[] = '<a href="?page=trabaria_flickr/settings.php" title="Configure this plugin">Settings w/o JS</a>';

        return $links;
      }
      return $links;
    }

    /**
     * 
     * @return 
     * @param $pluginfile Object
     * @param $plugindata Object
     * @param $context Object
     */
    function add_config_form($pluginfile, $plugindata, $context) {
      if ($plugindata['Name'] == 'Plugin Config Sample' && $context == 'active') {
        ?>
        <tr id="pcsc_config_tr" >
          <td colspan="5">
            <div id="pcsc_config_row" class="<?php echo ( $_GET['show'] == 'pcsconfig' ) ? '' : 'config_hidden'; ?>">
              <div class="updated fade" style="display:none" id="pcsc_message" style="background-color: rgb(255, 251, 204);"><p>Plugin config <strong>updated</strong>.</p></div>
              <h3>Plugin Config Sample Configuration</h3>
              <input type="hidden" name="action" value="pcsc_config-update" />
              <p><label for="pcsc_config-API">API Key:</label><input type="text" id="pcsc_config-API" name="pcsc_config-API" value="<?php echo get_option('pcsc_config-API'); ?>" /> <input id="pcsc_config_submit" type="button" value="Save" class="button-secondary" /></p>
            </div>
          </td>
        </tr>
        <?php
      }
    }

    /**
     * Handle the submitted information and reply with a note
     * @return 
     */
    function save_config() {
      if (!update_option('pcsc_config-API', $_POST['pcsc_config-API'])) {
        add_option('pcsc_config-API', $_POST['pcsc_config-API']);
      };

      die('updated');
    }

    /**
     * Output some CSS into the admin header to hide the config
     * @return 
     */
    function add_css() {
      echo '<style>
			#pcsc_config_tr, #pcsc_config_tr td { padding:0 }
			#pcsc_config_row {margin:10px;}
			.config_hidden {display:none;}
			</style>';
    }

    /**
     * Tells WordPress to load the scripts
     */
    function add_scripts() {
      wp_enqueue_script("jquery");
      wp_enqueue_script('trabaria_flickr_plugin_script', '/wp-content/plugins/trabaria_flickr/js/script.php', array("jquery"), 0.1);
    }

  }

}

//instantiate the class
if (class_exists('trabaria_flickr_plugin')) {
  $trabaria_flickr_plugin = new trabaria_flickr_plugin();
}
?>