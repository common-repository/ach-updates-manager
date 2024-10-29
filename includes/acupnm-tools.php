<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* === All ACh Updates Manager functions === */

function upnm_update_settings() {
	
	/* =================================== Options =================================== */
	
	$options=upnm_get_options();
	if( $options['dis-wpupn'] == 1 ) {
		
		// 1- Disable all WordPress update and notifications.
		function upnm_remove_all_updates(){
			global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
		}
		add_filter('pre_site_transient_update_core','upnm_remove_all_updates');
		add_filter('pre_site_transient_update_plugins','upnm_remove_all_updates');
		add_filter('pre_site_transient_update_themes','upnm_remove_all_updates');
	}
	else {

		if( $options['dis-pupn'] == 1 ) {
			
			// 2- Disable the WordPress plugins updates and notifications.
			remove_action('load-update-core.php', 'wp_update_plugins');
			add_filter('pre_site_transient_update_plugins', '__return_null');
		}
		if( $options['dis-tupn'] == 1 ) {
			
			// 3- Disable the WordPress themes updates and notifications.
			remove_action( 'load-update-core.php', 'wp_update_themes' );
			add_filter( 'pre_site_transient_update_themes', '__return_null' );
		}
		if( $options['dis-wpcupn'] == 1 ) {
			
			// 4- Disable the WordPress core update and notification.
			function upnm_remove_core_updates(){
				global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
			}
			add_filter('pre_site_transient_update_core','upnm_remove_core_updates');
		}
		if( $options['dis-wpcn'] == 1 ) {
			
			// 5- Hide WordPress core update notice on admin dashboard.
			function achupn_hide_nag() {
				remove_action( 'admin_notices', 'update_nag', 3 );
			}
			add_action('admin_menu','achupn_hide_nag');
		}
	}
	if( $options['up-zip'] == 1 ) {
			
		// 6- This feature allows you to update plugins and themes using a zip file.
		include( ACHUPM_PATH. 'includes/easy-update/ach-easy-update.php');
	}
	if( $options['dis-alln'] == 1 ) {
			
		// 7- Hide all notices from WordPress dashboard.
		function achupnm_disable_admin_notices() {
			echo '<style>
			.update-nag, .updated, .error, .update-message, .notice-alt, .woocommerce-message, .bsf-update-nag, .notice, .notice-warning, .is-dismissible {
				display: none !important;
			}
			</style>';
		}
		add_action('admin_head', 'achupnm_disable_admin_notices', 1000, 2);
		add_action('admin_enqueue_scripts', 'achupnm_disable_admin_notices', 1000, 2);
	}
}
add_action( 'init', 'upnm_update_settings');

?>