<?php
/*
Plugin Name: jQuery Pin It Button for Images
Plugin URI: https://highfiveplugins.com/jpibfi/jquery-pin-it-button-for-images-documentation/
Description: Highlights images on hover and adds a "Pin It" button over them for easy pinning.
Text Domain: jquery-pin-it-button-for-images
Domain Path: /languages
Author: Marcin Skrzypiec
Version:3.0.5
Author URI: https://highfiveplugins.com/
*/

if ( !defined( 'WPINC' ) )
	die;

if ( !class_exists( 'jQuery_Pin_It_Button_For_Images' ) ) {

	final class jQuery_Pin_It_Button_For_Images {

		function __construct() {
			$version = '3.0.5';
			require_once plugin_dir_path(__FILE__) . 'includes/jpibfi.php';
			new JPIBFI(__FILE__,  $version);
		}
	}

	$JPIBFI = new jQuery_Pin_It_Button_For_Images();

	function jpibfi_activation_hook() {
		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// Add the transient to redirect
		set_transient( '_jpibfi_activation_redirect', true, 30 );
    }
	register_activation_hook( __FILE__, 'jpibfi_activation_hook' );

} else {
	function jpibfi_duplicate_error() {
		?>
		<div class="notice notice-error">
			<p><strong>
				<?php _e('You have two versions of jQuery Pin It Button for Images installed. Please deactivate and remove one of them.', 'jquery-pin-it-button-for-images'); ?>
			</strong></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'jpibfi_duplicate_error' );
}
