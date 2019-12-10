<?php

class JPIBFI_Version_Update_2_2_3 {

	function __construct() {
		$this->update_options_if_needed();
		$this->cleanup();
	}

	public function update_options_if_needed() {

		$options_val = get_option( 'jpibfi_selection_options' );
		if ( $options_val ) {
			$options_val   = $this->fix_selection_options( $options_val );
			$options       = new JPIBFI_Selection_Options();
			$defaults      = $options->get_default_options();
			$with_defaults = array_merge( $defaults, $options_val );
			$result = array();
			foreach($defaults as $key => $val) {
				$result[ $key ] = $with_defaults[ $key ];
			}
			$options->update( $result );
		}

		$options_val = get_option( 'jpibfi_visual_options' );
		if ( $options_val ) {
			$options_val   = $this->fix_visual_options( $options_val );
			$options       = new JPIBFI_Visual_Options();
			$defaults      = $options->get_default_options();
			$with_defaults = array_merge( $defaults, $options_val );
			$result = array();
			foreach($defaults as $key => $val) {
				$result[ $key ] = $with_defaults[ $key ];
			}
			$options->update( $result );
		}
	}

	private function fix_selection_options( $options ) {
		$resolution_options = array(
			'min_image_height',
			'min_image_height_small',
			'min_image_width',
			'min_image_width_small'
		);
		foreach ( $resolution_options as $resolution_option ) {
			$options[ $resolution_option ] = isset( $options[ $resolution_option ] ) && is_numeric( $options[ $resolution_option ] )
				? intval( $options[ $resolution_option ] )
				: 0;
		}
		if ( ! isset( $options['show_on'] ) ) {
			$options['show_on'] = $this->create_show_on( $options );
		}
		if ( ! isset( $options['disable_on'] ) ) {
			$options['disable_on'] = $this->create_disable_on();
		}

		return $options;
	}

	private function create_show_on( $selection_settings ) {
		$show_on = array();
		if ( isset( $selection_settings['show_on_home'] ) && $selection_settings['show_on_home'] == "1" ) {
			$show_on[] = '[front]';
		}

		if ( isset( $selection_settings['show_on_single'] ) && $selection_settings['show_on_single'] == "1" ) {
			$show_on[] = '[single]';
		}

		if ( isset( $selection_settings['show_on_page'] ) && $selection_settings['show_on_page'] == "1" ) {
			$show_on[] = '[page]';
		}

		if ( isset( $selection_settings['show_on_category'] ) && $selection_settings['show_on_category'] == "1" ) {
			$show_on[] = '[category]';
			$show_on[] = '[archive]';
			$show_on[] = '[search]';
		}

		if ( isset( $selection_settings['show_on_blog'] ) && $selection_settings['show_on_blog'] == "1" ) {
			$show_on[] = '[home]';
		}

		return implode( ',', $show_on );
	}

	private function create_disable_on() {
		global $wpdb;
		$result   = array();

		$entries = $wpdb->get_results( "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'jpibfi_meta'", ARRAY_A );
		for($i = 0; $i < count( $entries ); $i++ ){
			$meta_val = maybe_unserialize( $entries[ $i ][ 'meta_value'] );
			$post_id = $entries[ $i ][ 'post_id' ];
			if ( array_key_exists( 'jpibfi_disable_for_post', $meta_val ) && '1' == $meta_val['jpibfi_disable_for_post'] ) {
				$result[] = $post_id;
			}
		}

		return implode( ',', $result );
	}

	private function fix_visual_options( $options ) {
		$int_options = array(
			'button_margin_bottom',
			'button_margin_top',
			'button_margin_left',
			'button_margin_right',
			'custom_image_height',
			'custom_image_width'
		);
		foreach ( $int_options as $int_option ) {
			$options[ $int_option ] = isset( $options[ $int_option ] ) && is_numeric( $options[ $int_option ] )
				? intval( $options[ $int_option ] )
				: 0;
		}
		if ( isset( $options['pinLinkedImages'] ) && is_string( $options['pinLinkedImages'] ) ) {
			$options['pinLinkedImages'] = '1' == $options['pinLinkedImages'];
		}
		if ( isset( $options['use_custom_image'] ) && is_string( $options['use_custom_image'] ) ) {
			$options['use_custom_image'] = '1' == $options['use_custom_image'];
		}

		$options['transparency_value'] = isset( $options['transparency_value'] ) && is_numeric( $options['transparency_value'] )
			? floatval( $options['transparency_value'] )
			: 0.5;

		if ( isset( $options['button_position'] ) ) {
			$options['button_position'] = $this->convert_button_position( $options['button_position'] );
		}
		if ( isset( $options['description_option'] ) && ! is_array( $options['description_option'] ) ) {
			$options['description_option'] = $this->convert_description_option( $options['description_option'] );
		}

		return $options;
	}

	private function convert_button_position( $button_position ) {
		switch ( $button_position ) {
			case 'top-left':
			case 'top-right':
			case 'bottom-left':
			case 'bottom-right':
			case 'middle':
				return $button_position;
			case '0':
				return 'top-left';
			case '1':
				return 'top-right';
			case '2':
				return 'bottom-left';
			case '3':
				return 'bottom-right';
			case '4':
				return 'middle';
			default:
				return 'top-left';
		}
	}

	private function convert_description_option( $description_option ) {
		switch ( $description_option ) {
			case '1':
				return array( 'post_title' );
			case '2':
				return array( 'post_excerpt' );
			case '3':
				return array( 'img_title' );
			case '4':
				return array( 'site_title' );
			case '5':
				return array( 'img_description' );
			case '6':
				return array( 'img_alt' );
			default:
				return array( 'img_title', 'img_alt', 'post_title' );
		}
	}

	private function cleanup() {
		delete_option( 'jpibfi_lightbox_options' );
		delete_option( 'jpibfi_options_version' );
		delete_post_meta_by_key( 'jpibfi_meta' );
	}

}