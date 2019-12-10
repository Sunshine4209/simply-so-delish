<?php

abstract class JPIBFI_Nag {

	protected $plugin_prefix;
	private $install_date_key;

	function __construct( $plugin_prefix ) {
		$this->plugin_prefix    = $plugin_prefix;
		$this->install_date_key = $plugin_prefix . '_install_date';
	}

	protected function get_install_date() {
		$date_string = get_site_option( $this->install_date_key, '' );
		if ( $date_string == '' ) {
			$date_string = $this->insert_install_date();
		}

		return new DateTime( $date_string );
	}

	protected function insert_install_date() {
		$datetime_now = new DateTime();
		$date_string  = $datetime_now->format( 'Y-m-d' );
		add_site_option( $this->install_date_key, $date_string );

		return $date_string;
	}

}