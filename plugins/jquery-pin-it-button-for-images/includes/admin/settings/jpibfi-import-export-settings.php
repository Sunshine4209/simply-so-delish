<?php

class JPIBFI_Import_Export_Settings extends JPIBFI_Settings_Tab {

	private $ajax_import_action;

	private $options_to_import_export;

	function __construct() {
		parent::__construct( 'import' );
		$this->ajax_import_action       = 'import';
		$this->options_to_import_export = array(
			'jpibfi_selection_options',
			'jpibfi_visual_options',
			'jpibfi_advanced_options',
			'jpibfi_version',
		);
		add_filter( 'export_args', array( $this, 'export_args' ) );
		add_action( 'export_wp', array( $this, 'export_wp' ) );
	}

	function import() {
		$file = wp_import_handle_upload();

		if ( isset( $file['error'] ) ) {
			$this->notices[] = new JPIBFI_Admin_Notice( 'error', true, esc_html( $file['error'] ) );

			return;
		}

		if ( ! isset( $file['file'], $file['id'] ) ) {
			$this->notices[] = new JPIBFI_Admin_Notice( 'error', true, __( 'The file did not upload properly. Please try again.', 'jquery-pin-it-button-for-images' ) );

			return;
		}

		if ( ! file_exists( $file['file'] ) ) {
			wp_import_cleanup( $file['id'] );

			$this->notices[] = new JPIBFI_Admin_Notice( 'error', true, sprintf( __( 'The export file could not be found at <code>%s</code>. It is likely that this was caused by a permissions problem.', 'jquery-pin-it-button-for-images' ), esc_html( $file['file'] ) ) );

			return;
		}

		if ( ! is_file( $file['file'] ) ) {
			wp_import_cleanup( $file['id'] );
			$this->notices[] = new JPIBFI_Admin_Notice( 'error', true, __( 'The path is not a file, please try again.', 'jquery-pin-it-button-for-images' ) );

			return;
		}

		$file_contents = file_get_contents( $file['file'] );
		$data          = json_decode( $file_contents, true );
		wp_import_cleanup( $file['id'] );

		$options_to_import = $data['options'];
		foreach ( (array) $options_to_import as $option_name => $option_value ) {
			$options_to_import[ $option_name ] = maybe_unserialize( $option_value );
		}
		$options_to_import[ 'jpibfi_version' ] = ! isset( $options_to_import[ 'jpibfi_version' ] ) ? '2.2.2' : $options_to_import[ 'jpibfi_version' ];

		foreach ( $this->options_to_import_export as $option_name ) {
			if ( isset( $options_to_import[ $option_name ] ) ) {
				update_option( $option_name, $options_to_import[ $option_name] );
			}
		}

		$this->notices[] = new JPIBFI_Admin_Notice( 'success', true, __( 'Import Successful', 'jquery_pin_it_button_for_images' ) );
	}

	function get_settings_i18n() {
		$parent                     = parent::get_settings_i18n();
		$i18n                       = array();
		$i18n['export_title']       = __( 'Export', 'jquery-pin-it-button-for-images' );
		$i18n['export_url']         = admin_url( 'export.php?download=true&content=jpibfi' );
		$i18n['export_button_text'] = __( 'Download Export File', 'jquery-pin-it-button-for-images' );

		$i18n['import_title']       = __( 'Import', 'jquery-pin-it-button-for-images' );
		$i18n['import_button_text'] = __( 'Import Settings', 'jquery-pin-it-button-for-images' );
		$i18n['import_action_name'] = $this->ajax_import_action;

		return array_merge( $parent, $i18n );
	}

	function get_module_settings() {
		return array(
			'slug' => 'import',
			'name' => __( 'Import/Export', 'jquery-pin-it-button-for-images' ),
		);
	}

	/**
	 * @param  array $args The export args being filtered.
	 *
	 * @return array The (possibly modified) export args.
	 */
	public function export_args( $args ) {
		if ( ! empty( $_GET['content'] ) && 'jpibfi' == $_GET['content'] ) {
			return array( 'jpibfi' => true );
		}

		return $args;
	}


	/**
	 * Export options as a JSON file if that's what the user wants to do.
	 *
	 * @param  array $args The export arguments.
	 *
	 * @return void
	 */
	public function export_wp( $args ) {
		if ( empty( $args['jpibfi'] ) ) {
			return;
		}

		$filename = 'jpibfi_settings_' . date( 'Y-m-d' ) . '.json';

		header( 'Content-Description: File Transfer' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ), true );

		$export_options = array();
		foreach ( $this->options_to_import_export as $option_name ) {
			$option_value = get_option( $option_name );
			if (false !== $option_value ) {
				$export_options[ $option_name ] = maybe_serialize( $option_value );
			}
		}

		$JSON_PRETTY_PRINT = defined( 'JSON_PRETTY_PRINT' ) ? JSON_PRETTY_PRINT : null;
		echo json_encode( array( 'options' => $export_options ), $JSON_PRETTY_PRINT );
		exit;
	}

	public function save_settings( $settings ) {
		$this->import();
	}
}