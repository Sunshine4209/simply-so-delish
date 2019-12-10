<?php

require_once 'jpibfi_nag.php';
/**
 * Class JPIBFI_Nag
 *
 * Heavily influenced by What The File Plugin
 * https://wordpress.org/plugins/what-the-file/
 */
class JPIBFI_Review_Nag extends JPIBFI_Nag {

	private $notice_key;
	private $notice_text;
	private $notice_period;

	function __construct($plugin_prefix, $plugin_name, $review_link, $period = '-10 days') {
	    parent::__construct( $plugin_prefix );
		$this->notice_key = $plugin_prefix . '_review_notice';

		$this->notice_text   = sprintf(
			__( "You've been using <b>%s</b> for some time now, could you please give it a review at wordpress.org? <a class='button button-primary' href='%s' target='_blank'>Yes, take me there &rarr;</a> <a class='button button-secondary' href='%s'>I've already done this!</a>" ),
            $plugin_name,
			$review_link,
			'%s'
		);
		$this->notice_period = $period;

		$this->setup();
	}

	public function setup() {
		if ( current_user_can( 'install_plugins' ) ) {
			$this->catch_hide_notice();
			add_action( 'admin_notices', array( $this, 'display_admin_notice' ) );
		}
	}

	private function catch_hide_notice() {
		if ( ! isset( $_GET[ $this->notice_key ] ) ) {
			return;
		}
		global $current_user;
		add_user_meta( $current_user->ID, $this->notice_key, '1', true );
		wp_redirect( remove_query_arg( $this->notice_key ) );
		exit;
	}

	/**
	 * Display the admin notice
	 */
	public function display_admin_notice() {
		$current_user = wp_get_current_user();
		$hide_notice  = get_user_meta( $current_user->ID, $this->notice_key, true );

		if ( '' != $hide_notice ) {
			return;
		}

		$datetime_install = $this->get_install_date();
		$datetime_past    = new DateTime( $this->notice_period );

		if ( $datetime_past < $datetime_install ) {
			return;
		}
		?>
        <div class="notice notice-info is-dismissible">
            <p><?php printf( $this->notice_text, add_query_arg( $this->notice_key, '1' ) ); ?></p>
        </div>
		<?php
	}
}