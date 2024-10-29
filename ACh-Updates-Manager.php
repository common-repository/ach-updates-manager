<?php
/*
 * Plugin Name: ACh Updates Manager
 * Plugin URI: https://wordpress.org/plugins/ach-updates-manager
 * Description: The ACh Updates and Notices Manager is an easy way to manage all your WordPress updates and notifications with one click! e.g. Disable all updates or notifications, Disable automatic updates, Hide errors and warnings messages, Update themes and plugins from zip file and etc.
 * Author: ACh
 * Version: 1.0.2
 * Author URI: https://ach.li
 * Text Domain: ach_upn_manager
 * Domain Path: /languages/
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define( 'ACHUPM_URL', plugin_dir_url( __FILE__ ) );
define( 'ACHUPM_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACHUPM_BASENAME', plugin_basename( __FILE__ ) );
define( 'ACHUPM_PLUGIN_VERSION', '1.0.2' );

require_once( ACHUPM_PATH. 'includes/acupnm-settings.php' );
require_once( ACHUPM_PATH. 'includes/acupnm-tools.php' );
require_once( ACHUPM_PATH. 'includes/default.php' );

// Load plugin styles.
function ach_upnm_admin_style() {
	$current_screen = get_current_screen();
    if ( strpos( $current_screen->base, 'ach-upn-manager') !== false ) {
		wp_enqueue_style( 'acupnm_style', ACHUPM_URL. 'assets/css/style.css', array(), '1.0.0' );
		wp_style_add_data( 'acupnm_style', 'rtl', 'replace' );
		wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
		wp_enqueue_script( 'jquery-upnmTabs', ACHUPM_URL. 'assets/js/jquery-upnmTabs.js', array(), '1.0.0', false );
	}
}
add_action( 'admin_enqueue_scripts', 'ach_upnm_admin_style', 100, 10 );

// Plugin activation hook and notice.
register_activation_hook( __FILE__, 'achupnm_plugin_run_on_activation' );
register_deactivation_hook( __FILE__, 'achupnm_plugin_run_on_deactivation' );

function achupnm_plugin_run_on_activation() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }
    set_transient( 'achupnm-admin-notice-on-activation', true, 5 );
}

function achupnm_plugin_install_notice() { 
    if( get_transient( 'achupnm-admin-notice-on-activation' ) ) { ?>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php printf( __( 'Thanks for installing %1$s v%2$s plugin. Click <a href="%3$s">here</a> to configure plugin settings.', 'ach_upn_manager' ), 'ACh Updates Manager', ACHUPM_PLUGIN_VERSION, admin_url( 'options-general.php?page=ach-upn-manager' ) ); ?></strong></p>
        </div> <?php
        delete_transient( 'achupnm-admin-notice-on-activation' );
    }
}
add_action( 'admin_notices', 'achupnm_plugin_install_notice' ); 

// add plugin action links.
function achupnm_add_action_links( $links ) {
    $rmlinks = array(
        '<a href="' . admin_url( 'options-general.php?page=ach-upn-manager' ) . '">' . __( 'Manage', 'ach_upn_manager' ) . '</a>',
    );
    return array_merge( $rmlinks, $links );
}
add_filter( 'plugin_action_links_' . ACHUPM_BASENAME, 'achupnm_add_action_links', 10, 2 );

// plugin row links and elements.
function achupnm_plugin_meta_links( $links, $file ) {
	$plugin = ACHUPM_BASENAME;
	if ( $file == $plugin ) // only for this plugin
		return array_merge( $links, 
            array( '<a href="https://wordpress.org/support/plugin/ach-updates-manager/reviews/#new-post" target="_blank">' . __( 'Support', 'ach_upn_manager' ) . '</a>' ),
            array( '<a href="https://paypal.me/AChopani/5usd" target="_blank">' . __( 'Donate', 'ach_upn_manager' ) . '</a>' )
		);
	return $links;
}
add_filter( 'plugin_row_meta', 'achupnm_plugin_meta_links', 10, 2 );

/*
 * load language
 */
function achupnm_load_textdomain() {
	load_plugin_textdomain('ach_upn_manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
}
add_action('plugins_loaded', 'achupnm_load_textdomain');

#add ACh UpN Manager settings in admin side panel.
function admin_menu_upnm_settings() {
    add_options_page( __( 'ACh Updates and Notices Manager', 'ach_upn_manager'), __( 'Updates Manager', 'ach_upn_manager'), 'manage_options', 'ach-upn-manager', 'upnm_option_page');
}
add_action('admin_menu', 'admin_menu_upnm_settings');

?>