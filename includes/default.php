<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* === Set default options for ACh Updates Manager plugin === */

function upnm_get_options() {
			
	$defaults = array(
		'dis-wpupn'			=> 0, #Deactivate by default
		'dis-alln'			=> 0,
		'dis-pupn'			=> 0,
		'dis-tupn'			=> 0,
		'dis-wpcupn'		=> 0,
		'dis-wpcn'			=> 0,
		'up-zip'			=> 0
	);
	return get_option( 'ach_upnm_options', $defaults );

}

?>