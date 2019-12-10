<?php

class JPIBFI_Selection_Options extends JPIBFI_Options {

	function get_default_options() {
		$defaults = array(
			'image_selector'         => '.jpibfi_container img',
			'disabled_classes'       => 'wp-smiley;nopin',
			'enabled_classes'        => '',
			'min_image_height'       => 0,
			'min_image_height_small' => 0,
			'min_image_width'        => 0,
			'min_image_width_small'  => 0,
			'show_on'                => '[front],[home],[single],[page],[archive],[search],[category]',
			'disable_on'             => ''
		);

		return $defaults;
	}

	function get_option_name() {
		return 'jpibfi_selection_options';
	}

	function get_types() {
		return array(
			'image_selector'         => 'string',
			'disabled_classes'       => 'string',
			'enabled_classes'        => 'string',
			'min_image_height'       => 'int',
			'min_image_height_small' => 'int',
			'min_image_width'        => 'int',
			'min_image_width_small'  => 'int',
			'show_on'                => 'string',
			'disable_on'             => 'string'
		);
	}
}