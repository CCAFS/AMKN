<?php

require_once('../../../../wp-load.php');

header('Content-Type: text/Javascript'); 
?>

// JavaScript Document

jQuery(document).ready( function($){

	
	$('#pluginconfsamplelink').click(function(s){jQuery('#pcsc_config_row').slideToggle('fast');});
	
	$('#pcsc_config_submit').click(function(){ pcsc_config_update()});
	
	
	function pcsc_config_update(){
		
		//get the important value
		API_Val = $('#pcsc_config-API').val();
		
		url = '<?php echo get_bloginfo('wpurl') ?>/wp-admin/admin-ajax.php';
		
		$.post(url , { "action" : "pcsc_config-update" , "pcsc_config-API" : API_Val }, function(d){
			if ( d == 'updated' ) {
				$('#pcsc_message').show();
			}
		});
	}
	
	
});