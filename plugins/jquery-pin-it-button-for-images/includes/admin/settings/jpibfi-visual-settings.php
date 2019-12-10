<?php

class JPIBFI_Visual_Settings extends JPIBFI_Settings_Base {

	function __construct() {
		parent::__construct( 'visual', new JPIBFI_Visual_Options() );
	}

	function get_settings_i18n() {
		$parent = parent::get_settings_i18n();
		$i18n                                      = array();
		$i18n['margins_label']                     = __( '"Pin it" button margins', 'jquery-pin-it-button-for-images' );
		$i18n['margins_desc']                      = sprintf( __( 'Margins are used to adjust the position of the "Pin it" button, but not all margins are used on all button positions. Here is an example. If you\'re using the "%s" position, the button\'s position will be affected only by top and left margins. Bottom and right margins affect "%s" position, etc. The "%s" position does not use any margins at all.', 'jquery-pin-it-button-for-images' ),
			__( 'Top left', 'jquery-pin-it-button-for-images' ),
			__( 'Bottom right', 'jquery-pin-it-button-for-images' ),
			__( 'Middle', 'jquery-pin-it-button-for-images' )
		);
		$i18n['preview']                           = __( 'Preview', 'jquery-pin-it-button-for-images' );
		$i18n['mode']                              = __( 'Mode', 'jquery-pin-it-button-for-images' );
		$i18n['settings']                          = __( 'Settings', 'jquery-pin-it-button-for-images' );
		$i18n['custom_button_desc']                = __( 'Click the button to choose an image from your WordPress media library. Height and width should fill automatically.', 'jquery-pin-it-button-for-images' );
		$i18n['custom_button_no_image_to_preview'] = __( 'No image to preview', 'jquery-pin-it-button-for-images' );
		$i18n['custom_button_upload']              = __( 'Upload an image using media library', 'jquery-pin-it-button-for-images' );
		$i18n['custom_button_frame_title']         = __( 'Select your custom "Pin It" button', 'jquery-pin-it-button-for-images' );
		$i18n['custom_button_frame_button_text']   = __( 'Use as "Pin It" button', 'jquery-pin-it-button-for-images' );

		$i18n['attribution'] = sprintf( __( 'Available icons come from the following icon packs: %s and %s.', 'jquery-pin-it-button-for-images' ),
			'<a href="http://fontawesome.io/" target="_blank">Font Awesome</a>',
			'<a href="https://icomoon.io/icons-icomoon.html" target="_blank">Icomoon</a>'
		);

		return array_merge( $parent, $i18n );
	}

	function get_module_settings() {
		return array(
			'slug'         => 'visual',
			'name'         => __( 'Visual', 'jquery-pin-it-button-for-images' ),
		);
	}

	function get_settings_configuration() {

		$option_value = $this->options->get();
		$res          = array();

		$res['show_button'] = array(
			'key'     => 'show_button',
			'label'   => __( 'Show button', 'jquery-pin-it-button-for-images' ),
			'options' => array(
				'hover'        => __( 'On hover', 'jquery-pin-it-button-for-images' ),
				'always_touch' => __( 'Always on touch devices', 'jquery-pin-it-button-for-images' ),
				'always'       => __( 'Always', 'jquery-pin-it-button-for-images' )
			),
			'desc'    => __( 'When the "Pin it" button should be visible.', 'jquery-pin-it-button-for-images' ),
			'type'    => 'select'
		);

		$margin_args                 = array(
			'min'  => '0',
			'step' => '1',
			'unit' => 'px',
			'type' => 'int'
		);
		$res['button_margin_bottom'] = array_merge( $margin_args,
			array(
				'key'         => 'button_margin_bottom',
				'label'       => __( 'Bottom', 'jquery-pin-it-button-for-images' ),
				'error_label' => __( 'Button bottom margin', 'jquery-pin-it-button-for-images' )
			) );
		$res['button_margin_top']    = array_merge( $margin_args,
			array(
				'key'         => 'button_margin_top',
				'label'       => __( 'Top', 'jquery-pin-it-button-for-images' ),
				'error_label' => __( 'Button top margin', 'jquery-pin-it-button-for-images' )
			) );
		$res['button_margin_left']   = array_merge( $margin_args,
			array(
				'key'         => 'button_margin_left',
				'label'       => __( 'Left', 'jquery-pin-it-button-for-images' ),
				'error_label' => __( 'Button left margin', 'jquery-pin-it-button-for-images' )
			) );
		$res['button_margin_right']  = array_merge( $margin_args,
			array(
				'key'         => 'button_margin_right',
				'label'       => __( 'Right', 'jquery-pin-it-button-for-images' ),
				'error_label' => __( 'Button right margin', 'jquery-pin-it-button-for-images' )
			) );

		$res['button_position'] = array(
			'key'     => 'button_position',
			'label'   => __( '"Pin it" button position', 'jquery-pin-it-button-for-images' ),
			'options' => array(
				'top-left'     => __( 'Top left', 'jquery-pin-it-button-for-images' ),
				'top-right'    => __( 'Top right', 'jquery-pin-it-button-for-images' ),
				'bottom-left'  => __( 'Bottom left', 'jquery-pin-it-button-for-images' ),
				'bottom-right' => __( 'Bottom right', 'jquery-pin-it-button-for-images' ),
				'middle'       => __( 'Middle', 'jquery-pin-it-button-for-images' )
			),
			'desc'    => __( 'Where the "Pin it" button should appear on the image.', 'jquery-pin-it-button-for-images' ),
			'type'    => 'select'
		);

		$res['description_option'] = array(
			'key'     => 'description_option',
			'label'   => __( 'Description source', 'jquery-pin-it-button-for-images' ),
			'options' => array(
				"post_title"      => __( 'Post title', 'jquery-pin-it-button-for-images' ),
				"post_excerpt"    => __( 'Post description (excerpt)', 'jquery-pin-it-button-for-images' ),
				"img_title"       => __( 'Image title attribute', 'jquery-pin-it-button-for-images' ),
				"site_title"      => __( 'Site title (Settings->General)', 'jquery-pin-it-button-for-images' ),
				"img_description" => __( 'Image description', 'jquery-pin-it-button-for-images' ),
				"img_caption"     => __( 'Image caption', 'jquery-pin-it-button-for-images' ),
				"img_alt"         => __( 'Image alt attribute', 'jquery-pin-it-button-for-images' ),
				"data_pin_description" => __( 'data-pin-description (Pinterest\'s custom attribute)', 'jquery-pin-it-button-for-images' )
			),
			'desc'    => __( 'From where the Pinterest message should be taken. Check which sources should be considered and prioritize them by dragging and dropping. The description will come from the top source that has data. Please note that "Image description" and "Image caption" work properly only for images that were added to your Media Library.', 'jquery-pin-it-button-for-images' ),
			'type'    => 'multiselect'
		);

		$res['transparency_value'] = array(
			'key'   => 'transparency_value',
			'label' => __( 'Transparency', 'jquery-pin-it-button-for-images' ),
			'desc'  => sprintf( __( 'Choose transparency (between %.02f and %.02f)', 'jquery-pin-it-button-for-images' ), '0.00', '1.00' ),
			'min'   => '0',
			'max'   => '1',
			'step'  => '0.01',
			'type'  => 'float'
		);

		$res['pin_image'] = array(
			'key'     => 'pin_image',
			'label'   => __( 'Pin image', 'jquery-pin-it-button-for-images' ),
			'options' => array(
				'old_default' => __( 'Old default', 'jquery-pin-it-button-for-images' ),
				'default'     => __( 'Default', 'jquery-pin-it-button-for-images' ),
				'custom'      => __( 'Custom', 'jquery-pin-it-button-for-images' )
			),
			'type'    => 'select'
		);

		$res['pin_image_button'] = array(
			'key'     => 'pin_image_button',
			'label'   => __( 'Button', 'jquery-pin-it-button-for-images' ),
			'options' => array(
				'square'            => __( 'Square', 'jquery-pin-it-button-for-images' ),
				'rounded-square'    => __( 'Rounded square', 'jquery-pin-it-button-for-images' ),
				'round'             => __( 'Round', 'jquery-pin-it-button-for-images' ),
				'rectangle'         => __( 'Rectangle', 'jquery-pin-it-button-for-images' ),
				'rounded-rectangle' => __( 'Rounded rectangle', 'jquery-pin-it-button-for-images' )
			),
			'type'    => 'select'
		);

		$res['pin_image_icon'] = array(
			'key'     => 'pin_image_icon',
			'label'   => __( 'Icon', 'jquery-pin-it-button-for-images' ),
			'options' => array(
				'circle'     => __( 'Circle', 'jquery-pin-it-button-for-images' ),
				'plain'      => __( 'Plain', 'jquery-pin-it-button-for-images' ),
				'thumb-tack' => __( 'Thumbtack', 'jquery-pin-it-button-for-images' ),
				'pushpin'    => __( 'Thumbtack #2', 'jquery-pin-it-button-for-images' ),
				'pinterest2' => __( 'Classic', 'jquery-pin-it-button-for-images' ),
			),
			'type'    => 'select'
		);

		$res['pin_image_size'] = array(
			'key'     => 'pin_image_size',
			'label'   => __( 'Size', 'jquery-pin-it-button-for-images' ),
			'options' => array(
				'small'  => __( 'Small', 'jquery-pin-it-button-for-images' ),
				'normal' => __( 'Normal', 'jquery-pin-it-button-for-images' ),
				'large'  => __( 'Large', 'jquery-pin-it-button-for-images' ),
			),
			'type'    => 'select'
		);

		$res['custom_image_url'] = array(
			'key'   => 'custom_image_url',
			'label' => __( 'URL address of the image', 'jquery-pin-it-button-for-images' ),
			'type'  => 'string'
		);

		$image_size                 = array( 'min' => '0', 'step' => '1', 'unit' => 'px', 'type' => 'int' );
		$res['custom_image_height'] = array_merge( $image_size, array(
			'key'         => 'custom_image_height',
			'label'       => __( 'Height', 'jquery-pin-it-button-for-images' ),
			'error_label' => __( 'Custom image height', 'jquery-pin-it-button-for-images' )
		) );
		$res['custom_image_width']  = array_merge( $image_size, array(
			'key'         => 'custom_image_width',
			'label'       => __( 'Width', 'jquery-pin-it-button-for-images' ),
			'error_label' => __( 'Custom image width', 'jquery-pin-it-button-for-images' )
		) );

		$res['scale_pin_image'] = array(
			'key'   => 'scale_pin_image',
			'label' => __( 'Scale Pin Image', 'jquery-pin-it-button-for-images' ),
			'text'  => __( 'Active', 'jquery-pin-it-button-for-images' ),
			'desc'  => __( 'When checked, the "Pin it" button will scale down in size for smaller screens, ensuring best user experience. Left unchecked, the "Pin it" button will show up in full size no matter the screen size.', 'jquery-pin-it-button-for-images' ),
			'type'  => 'boolean',
		);

		$res['pin_linked_url'] = array(
			'key'   => 'pin_linked_url',
			'label' => __( 'Pin linked URL', 'jquery-pin-it-button-for-images' ),
			'text'  => __( 'Active', 'jquery-pin-it-button-for-images' ),
			'desc'  => __( 'When checked, if the image links to another URL in your domain, that URL goes to Pinterest instead of the current one.', 'jquery-pin-it-button-for-images' ),
			'type'  => 'boolean',
		);

		foreach ( $res as $key => $setting ) {
			$res[ $key ]['value'] = $option_value[ $key ];
		}

		return $res;
	}
}