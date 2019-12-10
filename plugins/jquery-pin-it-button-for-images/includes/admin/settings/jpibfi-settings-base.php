<?php

abstract class JPIBFI_Settings_Tab {

	abstract function get_module_settings();

	/**
	 * @var string
	 */
	private $slug;

	/**
	 * @var JPIBFI_Admin_Notice[]
	 */
	protected $notices;

	function __construct( $slug ) {
		$this->slug = $slug;
		$this->notices = array();

		add_action( 'admin_notices', array( $this, 'show_notices' ) );
	}

	function get_settings_configuration() {
		return array();
	}

	function get_settings_i18n() {
		return array(
			'submit'            => __( 'Save Changes', 'jquery-pin-it-button-for-images' ),
			'pro_feature_error' => sprintf(
				__( 'This feature is available in <a target="_blank" href="%s">the PRO version</a>.', 'jquery-pin-it-button-for-images' ),
				'https://highfiveplugins.com/downloads/jquery-pin-it-button-for-images-pro/'
			)
		);
	}

	function get_slug() {
		return $this->slug;
	}

	function save_settings( $settings ) {

	}

	function show_notices( ) {
		foreach ( $this->notices as $notice ) {
			echo $notice->get_html();
		}
	}

}

abstract class JPIBFI_Settings_Base extends JPIBFI_Settings_Tab {

	/**
	 * @var JPIBFI_Options
	 */
	protected $options;

	function __construct( $slug, $options ) {
		parent::__construct( $slug );
		$this->options = $options;
	}

	function save_settings( $settings ) {
		$validator = new JPIBFI_Validator( $settings, $this->options->get_default_options(), $this->get_settings_configuration() );
		$errors    = $validator->get_errors();
		if ( count( $errors ) > 0 ) {
			$error_messages = array_merge(
				array( '<strong>' .__( 'Settings not saved.', 'jquery-pin-in-button-for-images' ) . '</strong>' ),
				$errors
			);
			$this->notices[] = new JPIBFI_Admin_Notice( 'error', true, join( '<br/>', $error_messages ) );
		} else {
			$sanitized = $validator->get_result();
			$sanitized = $this->options->sanitize( $sanitized );
			$this->options->update( $sanitized );
			$this->notices[] = new JPIBFI_Admin_Notice( 'success', true, '<strong>' . __( 'Settings saved.', 'jquery-pin-in-button-for-images' ) . '</strong>' );
		}
	}
}