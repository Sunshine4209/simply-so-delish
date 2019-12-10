<?php

class JPIBFI_Version_Updater {

	private $version;
	private $option_name = 'jpibfi_version';

	function __construct( $version ) {
		$this->version = $version;
	}

	function update() {
		$version = get_option( $this->option_name );
		if ( $this->version == $version ) {
			return;
		}

		if ( version_compare( $version, '2.2.3', 'lt' ) ) {
			$this->update_2_2_3();
		}
		update_option( $this->option_name, $this->version );
	}

	private function update_2_2_3() {
		require_once 'versions/JPIBFI_Version_Update_2_2_3.php';
		new JPIBFI_Version_Update_2_2_3();
	}
}