<?php
// create custom plugin settings menu
add_action('admin_menu', 'amkn_create_menu');

function amkn_create_menu() {

	//create new top-level menu
	add_menu_page('AMKN Rules Settings', 'AMKN Rules', 'administrator', __FILE__, 'amkn_settings_page',plugins_url('/pin-mini.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}



function register_mysettings() {
	//register our settings
	register_setting( 'amkn-settings-group', 'google_analytics' );
	register_setting( 'amkn-settings-group', 'email_notifications' );
}

function amkn_settings_page() {
?>
<div class="wrap">
<h2>AMKN Rules Settings</h2>
<form method="post" action="options.php">
    <?php settings_fields( 'amkn-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Google Analytics Code (Only the code, e.g., UA-xxxxxxx-y)</th>
        <td><input type="text" name="google_analytics" value="<?php echo get_option('google_analytics'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Email address for Editorial notifications</th>
        <td><input type="text" name="email_notifications" value="<?php echo get_option('email_notifications'); ?>" /></td>
        </tr>

    </table>

    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>