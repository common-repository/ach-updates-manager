<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add settings panel to ACh Updates Manager plugin.
function upnm_option_page() {
	
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die();
	}
			
	if( isset( $_POST['save'] ) ) {
		
		check_admin_referer( 'acupnm_option_page' );
		
		$new_options = array();
		$new_options['dis-wpupn']		 	= intval(isset( $_POST['dis-wpupn'] ));
		$new_options['dis-alln'] 			= intval(isset( $_POST['dis-alln'] ));
		$new_options['dis-pupn'] 			= intval(isset( $_POST['dis-pupn'] ));
		$new_options['dis-tupn'] 			= intval(isset( $_POST['dis-tupn'] ));
		$new_options['dis-wpcupn'] 			= intval(isset( $_POST['dis-wpcupn'] ));
		$new_options['dis-wpcn'] 			= intval(isset( $_POST['dis-wpcn'] ));
		$new_options['up-zip'] 				= intval(isset( $_POST['up-zip'] ));
		update_option( 'ach_upnm_options', $new_options );
	}
	
$upnm_options = upnm_get_options();
?>
<div class="ach-upnm-header"><h2 class="ach-upn-header"><?php echo _e('ACh Updates and Notices Manager', 'ach_upn_manager'); ?> <span class="ach-upn-version">1.0.2</span></h2></div>
<div class="ach-upn-description"><p><?php echo _e('The ACh Update Manager plugin for WordPress. Manage all your WordPress updates and notifications with one click!', 'ach_upn_manager'); ?></p></div>
<div class="acupnm-wrapper">
	<form action="" method="POST">
	<?php wp_nonce_field( 'acupnm_option_page' );  ?>
	<div id="ach-upnm-tabs" style="display:none">
	<ul>
		<li><a href="#options"><?php esc_html_e( 'Options', 'ach_upn_manager' ); ?></a></li>
		<li><a href="#support"><?php esc_html_e( 'Support', 'ach_upn_manager' ); ?></a></li>
	</ul>
	
	<!-- =================================== Options =================================== -->
	
	<div id="options">
		<table class="ac-upnm-content">
		<tbody class="achupnm-box-left">
			<tr>
			    <th class="ach-upnm-th" scope="row">
			        <label for="dis-wpupn"><?php _e('&#10004; Disable all WP updates and notifs', 'ach_upn_manager'); ?></label>
			    </th>
			    <td>
                    <label class="ac-upnm-switch">
						<input class="ac-upnm-switch-input" name="dis-wpupn" id="dis-wpupn" type="checkbox" value="1" <?php echo ($upnm_options['dis-wpupn'])?' checked="checked"':"";?> />
                        <span class="ac-upnm-switch-label" data-on="ON" data-off="OFF"></span>
                        <span class="ac-upnm-switch-handle"></span>
                    </label>			        
			    </td>
				<td class="ach-upnm-tooltip">&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Disable all WordPress core, themes, plugins and translations updates and notifications.', 'ach_upn_manager' ); ?>"><span title="" class="dashicons dashicons-editor-help" id="ach-upnm-dashicon"></span></span></td>
			</tr>
			<tr>
			    <th class="ach-upnm-th" scope="row">
			        <label for="dis-alln"><?php _e('&#10004; Hide all notices from WP dashboard', 'ach_upn_manager'); ?></label>
			    </th>
			    <td>
                    <label class="ac-upnm-switch">
						<input class="ac-upnm-switch-input" name="dis-alln" id="dis-alln" type="checkbox" value="1" <?php echo ($upnm_options['dis-alln'])?' checked="checked"':"";?> />
                        <span class="ac-upnm-switch-label" data-on="ON" data-off="OFF"></span>
                        <span class="ac-upnm-switch-handle"></span>
                    </label>
			    </td>
				<td class="ach-upnm-tooltip">&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Disable all notices from the WordPress dashboard. e.g. errors, updates, warning, rate us, license, dismissible and etc.', 'ach_upn_manager' ); ?>"><span title="" class="dashicons dashicons-editor-help" id="ach-upnm-dashicon"></span></span></td>
			</tr>
			<tr>
				<th class="ach-upnm-th" scope="row">
					<label for="dis-pupn"><?php _e('&#10004; Disable plugins updates and notifs', 'ach_upn_manager'); ?></label>
				</th>
				<td>
					<label class="ac-upnm-switch">
						<input class="ac-upnm-switch-input" name="dis-pupn" id="dis-pupn" type="checkbox" value="1" <?php echo ($upnm_options['dis-pupn'])?' checked="checked"':"";?> />
						<span class="ac-upnm-switch-label" data-on="ON" data-off="OFF"></span>
						<span class="ac-upnm-switch-handle"></span>
					</label>
				</td>
				<td class="ach-upnm-tooltip">&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Disable the WordPress plugins updates and notifications.', 'ach_upn_manager' ); ?>"><span title="" class="dashicons dashicons-editor-help" id="ach-upnm-dashicon"></span></span></td>
			</tr>
			<tr>
				<th class="ach-upnm-th" scope="row">
					<label for="dis-tupn"><?php _e('&#10004; Disable themes updates and notifs', 'ach_upn_manager'); ?></label>
				</th>
				<td>
					<label class="ac-upnm-switch">
						<input class="ac-upnm-switch-input" name="dis-tupn" id="dis-tupn" type="checkbox" value="1" <?php echo ($upnm_options['dis-tupn'])?' checked="checked"':"";?> />
						<span class="ac-upnm-switch-label" data-on="ON" data-off="OFF"></span>
						<span class="ac-upnm-switch-handle"></span>
					</label>
				</td>
				<td class="ach-upnm-tooltip">&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Disable the WordPress themes updates and notifications.', 'ach_upn_manager' ); ?>"><span title="" class="dashicons dashicons-editor-help" id="ach-upnm-dashicon"></span></span></td>
			</tr>
			<tr>
				<th class="ach-upnm-th" scope="row">
					<label for="dis-wpcupn"><?php _e('&#10004; Disable WP core update and notifs', 'ach_upn_manager'); ?></label>
				</th>
				<td>
					<label class="ac-upnm-switch">
						<input class="ac-upnm-switch-input" name="dis-wpcupn" id="dis-wpcupn" type="checkbox" value="1" <?php echo ($upnm_options['dis-wpcupn'])?' checked="checked"':"";?> />
						<span class="ac-upnm-switch-label" data-on="ON" data-off="OFF"></span>
						<span class="ac-upnm-switch-handle"></span>
					</label>
				</td>
				<td class="ach-upnm-tooltip">&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Disable the WordPress core update and notifications.', 'ach_upn_manager' ); ?>"><span title="" class="dashicons dashicons-editor-help" id="ach-upnm-dashicon"></span></span></td>
			</tr>
			<tr>
			    <th class="ach-upnm-th" scope="row">
			        <label for="dis-wpcn"><?php _e('&#10004; Hide WordPress core update notice', 'ach_upn_manager'); ?></label>
			    </th>
			    <td>
                    <label class="ac-upnm-switch">
						<input class="ac-upnm-switch-input" name="dis-wpcn" id="dis-wpcn" type="checkbox" value="1" <?php echo ($upnm_options['dis-wpcn'])?' checked="checked"':"";?> />
						<span class="ac-upnm-switch-label" data-on="ON" data-off="OFF"></span>
                        <span class="ac-upnm-switch-handle"></span>
                    </label>
			    </td>
				<td class="ach-upnm-tooltip">&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Hide WordPress core update notice from WP dashboard.', 'ach_upn_manager' ); ?>"><span title="" class="dashicons dashicons-editor-help" id="ach-upnm-dashicon"></span></span></td>
			</tr>
			<tr>
			    <th class="ach-upnm-th" scope="row">
			        <label for="up-zip"><?php _e('&#10004; Update theme and plugin from zip', 'ach_upn_manager'); ?></label>
			    </th>
			    <td>
                    <label class="ac-upnm-switch">
						<input class="ac-upnm-switch-input" name="up-zip" id="up-zip" type="checkbox" value="1" <?php echo ($upnm_options['up-zip'])?' checked="checked"':"";?> />
                        <span class="ac-upnm-switch-label" data-on="ON" data-off="OFF"></span>
                        <span class="ac-upnm-switch-handle"></span>
                    </label>
			    </td>
				<td class="ach-upnm-tooltip">&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'This feature allows you to update plugins and themes using a zip file. While upgrading, a backup copy of the old theme or plugin is first created. This allows you to install the old version in case of problems with the new version.', 'ach_upn_manager' ); ?>"><span title="" class="dashicons dashicons-editor-help" id="ach-upnm-dashicon"></span></span></td>
			</tr>
		</tbody>
		</table>
	</div>
	
	<!-- =================================== Support =================================== -->

	<div id="support">
		<div class="upnm-help upnm-ach">
			<div class="ac-upnm-row upnm-ach">
				<div class="ac-upnm-col">
					<div class="upnm-box">
						<h3 class="upnm-box-heading ac-upnm-heading"><i class="fa fa-question-circle"></i> <?php _e( 'Support', 'ach_upn_manager' ); ?></h3>
						<div class="achupnm-content">
							<div class="upnm-ach ac-upnm-about-text">
								<h2><?php _e( 'If you need assistance, see our help resources.', 'ach_upn_manager' ); ?></h2>
								<p><?php _e( 'Please make a search to find help with your problem, or head over to our support forum to ask a question.', 'ach_upn_manager' ); ?></p>
							</div>
							<div class="ac-upnm-row upnm-ach">
								<div class="ac-upnm-col">
									<a class="ac-upnm-forum-button" href="https://ach.li" target="_blank"><i class="fa fa-globe"></i><?php _e( 'Visit my site', 'ach_upn_manager' ); ?></a>
								</div>
								<div class="ac-upnm-col">
									<a class="ac-upnm-forum-button" href="mailto:hello@ach.li"><i class="fa fa-envelope"></i><?php _e( 'Send email', 'ach_upn_manager' ); ?></a>
								</div>
								<div class="ac-upnm-col">
									<a class="ac-upnm-forum-button" href="https://wordpress.org/support/plugin/ach-updates-manager/reviews/#new-post" target="_blank"><i class="fa fa-comments"></i><?php _e( 'Support forum', 'ach_upn_manager' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ac-upnm-col">
					<div class="ac-upnm-col achupnm-last">
						<div class="upnm-box">
							<h3 class="upnm-box-heading ac-upnm-heading"><i class="fa fa-heart"></i> <?php _e( 'About us', 'ach_upn_manager' ); ?></h3>
							<div class="achupnm-content">
								<div class="upnm-ach ac-upnm-about-text">
									<h3><?php _e( 'The ACh Updates and Notices Manager is an easy way to manage all your WordPress updates and notifications with one click!', 'ach_upn_manager' ); ?></h3>
									<p><?php _e( 'ACh Updates and Notices Manager was developed by <a class="achupnm-link-text" href="https://ach.li" target="_blank">A. Ch</a> and is <a class="achupnm-link-text" href="https://wordpress.org" target="_blank">available for free</a> on WordPress.', 'ach_upn_manager' ); ?></p>
									<p><?php _e( 'We work hard to give you an exceptional premium products and 5 star support. To show your appreciation you can buy us a coffee or simply by sharing or follow us on social media.', 'ach_upn_manager' ); ?></p>
								</div>
								<div class="upnm-ach ac-upnm-social-links">
									<ul>
										<li class="achupnm-buy-coffee"><a href="https://paypal.me/AChopani/10usd" target="_blank"><i class="fa fa-coffee"></i> <?php _e( 'Buy us a coffee', 'ach_upn_manager' ); ?></a></li>
										<li class="achupnm-facebook"><a href="#"><i class="fa fa-facebook-f"></i> <?php _e( 'Like us', 'ach_upn_manager' ); ?></a></li>
										<li class="achupnm-twitter"><a href="#"><i class="fa fa-twitter"></i> <?php _e( 'Tweet us', 'ach_upn_manager' ); ?></a></li>
										<li class="achupnm-rate"><a href="https://wordpress.org/support/plugin/ach-updates-manager/reviews/#new-post"><i class="fa fa-thumbs-up"></i> <?php _e( 'Rate us', 'ach_upn_manager' ); ?></a></li>
									</ul>
								</div>
								<p class="footer-links"><a href="https://wordpress.org" class="achupnm-link">www.wordpress.org</a> | <a href="https://ach.li" class="achupnm-link">www.ach.li</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<p class="acupnm-footer"><input type="submit" class="button button-primary" name="save" value="<?php _e('Save Changes', 'ach_upn_manager'); ?>" /></p>
	</div>
	</form>
</div>
<?php
}
?>