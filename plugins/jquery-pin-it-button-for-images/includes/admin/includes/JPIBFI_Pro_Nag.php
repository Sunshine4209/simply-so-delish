<?php

require_once 'jpibfi_nag.php';
class JPIBFI_Pro_Nag extends JPIBFI_Nag {

	private $plugin_name;
	private $pro_link;
	private $notice_key;
	private $notice_text;

	function __construct( $plugin_prefix, $plugin_name, $pro_link ) {
		parent::__construct( $plugin_prefix );
		$this->pro_link = $pro_link;
		$this->plugin_name = $plugin_name;
		$this->notice_key = $plugin_prefix . '_pro_notice_date';

		$this->notice_text   = sprintf(
			__( "You've been using <b>%s</b> for quite some time now. How about checking out the Pro version? <a class='button button-primary' href='%s' target='_blank'>Yes, take me there &rarr;</a> <a class='button button-secondary' href='%s'>Thanks, but no thanks.</a>", 'jquery-pin-in-button-for-images' ),
			$plugin_name,
            $pro_link,
			'%s'
		);

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
		
		/* remove old user meta if it still exists */
		delete_user_meta($current_user->ID, $this->plugin_prefix . '_pro_notice');

		$datetime_install = $this->get_install_date();
		$next_date = $this->getNextNagDate( $datetime_install );
		update_user_meta( $current_user->ID, $this->notice_key, $next_date->format( 'Y-m-d' ) );
		wp_redirect( remove_query_arg( $this->notice_key ) );
		exit;
	}

	private function getNextNagDate($install_date) {
		$base_period = 45;
		$stages = array(
			new DateTime( '-180 days' ),
			new DateTime( '-365 days' ),
			new DateTime( '-730 days' ),
			new DateTime( '-1100 days' )
		);
		
		for( $i = count( $stages) - 1; $i >= 0; $i--) {
			if ( $install_date < $stages[ $i ]  ) {
				return new DateTime( sprintf( '+%s days', ($i + 1) * $base_period ) );
			}
		}
		return new DateTime( '+30 days' );
	}

	/**
	 * Display the admin notice
	 */
	public function display_admin_notice() {
		$now = new DateTime();
		$current_user = wp_get_current_user();
		$notice_date_string  = get_user_meta( $current_user->ID, $this->notice_key, true );
		$notice_date = '' == $notice_date_string
			? $now
			: new DateTime( $notice_date_string );

		if ( $notice_date > $now ) {
			return;
		}
		?>
		<div class="notice notice-info is-dismissible">
			<p><?php printf( $this->notice_text, add_query_arg( $this->notice_key, '1' ) ); ?></p>
		</div>
		<?php
	}

}