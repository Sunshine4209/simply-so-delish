<?php

class JPIBFI_Advanced_Options extends JPIBFI_Options {

	function get_default_options() {
		$defaults = array(
			'custom_css'						  =>
'a.pinit-button {
	border-bottom: 0 !important;
	box-shadow: none !important;
	margin-bottom: 0 !important;
}
a.pinit-button::after {
    display: none;
}',
			'filter_the_content_on'               => true,
			'filter_the_content_priority'         => 10,
			'filter_the_excerpt_on'               => true,
			'filter_the_excerpt_priority'         => 10,
			'filter_post_thumbnail_html_on'       => true,
			'filter_post_thumbnail_html_priority' => 10,
			'scroll_selector'                     => '',
			'support_srcset'					  => false,
		);

		return $defaults;
	}

	function get_option_name() {
		return 'jpibfi_advanced_options';
	}

	function get_types() {
		return array(
			'custom_css'						  => 'string',
			'filter_the_content_on'               => 'boolean',
			'filter_the_content_priority'         => 'int',
			'filter_the_excerpt_on'               => 'boolean',
			'filter_the_excerpt_priority'         => 'int',
			'filter_post_thumbnail_html_on'       => 'boolean',
			'filter_post_thumbnail_html_priority' => 'int',
			'scroll_selector'                     => 'string',
			'support_srcset'					  => 'boolean',
		);
	}

	function get_options_for_view() {
		$options = $this->get();

		return array( 
			'scroll_selector' => $options['scroll_selector'],
			'support_srcset' => $options['support_srcset'],
		);
	}

	function sanitize( $input ) {
		$input = parent::sanitize( $input );
		$save  = false;
		if ( $input['support_srcset'] != false ) {
			$input['support_srcset'] = false;
			$save = true;
		}

		if ( $save ) {
			$this->update( $input );
		}

		return $input;
	}
}