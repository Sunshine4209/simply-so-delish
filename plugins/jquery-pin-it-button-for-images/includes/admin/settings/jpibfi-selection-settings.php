<?php

class JPIBFI_Selection_Settings extends JPIBFI_Settings_Base {

	function __construct() {
		parent::__construct( 'select', new JPIBFI_Selection_Options() );
		add_action( 'add_meta_boxes', array( $this, 'add_post_selection_meta_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_post_selection_meta' ), 10, 3 );
	}

	function add_post_selection_meta_box( $post_type, $post ) {
		add_meta_box(
			'jpibfi-disable-plugin_meta',
			__( 'jQuery Pin It Button for Images Settings', 'jquery-pin-it-button-for-images' ),
			array( $this, 'render_post_selection_meta_box' ),
			array( 'post', 'page' ),
			'side'
		);
	}

	function get_settings_i18n() {
		$existing_post_types = get_post_types( array( 'public' => true ) );

		$parent                                = parent::get_settings_i18n();
		$i18n                                  = array();
		$i18n['title']                         = __( 'Selection settings', 'jquery-pin-it-button-for-images' );
		$i18n['image_resolution_label']        = __( 'Minimum image resolution', 'jquery-pin-it-button-for-images' );
		$i18n['image_resolution_desc']         = __( 'Use this settings to hide the "Pin it" button on small images (e.g. social media icons).', 'jquery-pin-it-button-for-images' );
		$i18n['image_resolution_desc_2']       = __( '* - screen that is less than 768 pixels wide', 'jquery-pin-it-button-for-images' );
		$i18n['min_resolution_template_small'] = __( 'For small screens* the "Pin it" button will show up if the image is at least %height% pixels high and %width% pixels wide.', 'jquery-pin-it-button-for-images' );
		$i18n['min_resolution_template']       = __( 'Otherwise, the "Pin it" button will show up if the image is at least %height% pixels high and %width% pixels wide.', 'jquery-pin-it-button-for-images' );

		$i18n['show_on_field_label'] = __( 'On which pages the "Pin it" button should be shown', 'jquery-pin-it-button-for-images' );
		$i18n['show_on_field_desc']  = __( 'Separate settings using commas. For the button to show up on a certain page, the page must be included in the "Show on" section and not included in the "Disable on" section. You can use the following settings:' )
           . '<p>'
           . __( 'number (e.g. 588) - the ID of a certain page or post' ) . '<br/>'
           . __( '[front] - front page' ) . '<br/>'
           . __( '[single] - single posts' ) . '<br/>'
           . __( '[page] - single pages' ) . '<br/>'
           . sprintf( __( '[archive] - <a href="%s" target="_blank">archive pages</a>' ) . '<br/>', 'https://codex.wordpress.org/Function_Reference/is_archive' )
           . __( '[search] - search pages' ) . '<br/>'
           . __( '[category] - category pages' ) . '<br/>'
           . __( '[tag] - tag pages' ) . '<br/>'
		   . __( '[home] - blog page' ) . '<br/>'
		   . __( '[post_type] where post_type is one of the following: ') . join(', ', $existing_post_types) . '.</p>';

		return array_merge( $parent, $i18n );
	}

	function get_module_settings() {
		return array(
			'slug'         => 'select',
			'name'         => __( 'Selection', 'jquery-pin-it-button-for-images' ),
		);
	}

	function get_settings_configuration() {

		$option_value = $this->options->get();
		$res          = array();

		$res['image_selector'] = array(
			'key'   => 'image_selector',
			'label' => __( 'Image selector', 'jquery-pin-it-button-for-images' ),
			'desc'  => sprintf( __( 'jQuery selector for all the images that should have the "Pin it" button. Set the value to %s if you want the "Pin it" button to appear only on images in content or %s to appear on all images on site (including sidebar, header and footer). If you know a thing or two about jQuery, you might use your own selector. %sClick here%s to read about jQuery selectors.', 'jquery-pin-it-button-for-images' ),
				'<strong>.jpibfi_container img</strong>',
				'<strong>img</strong>',
				'<a href="http://api.jquery.com/category/selectors/" target="_blank">',
				'</a>'
			),
			'type'  => 'string',
            'required' => true
		);

		$res['disabled_classes'] = array(
			'key'   => 'disabled_classes',
			'label' => __( 'Disabled classes', 'jquery-pin-it-button-for-images' ),
			'desc'  => __( 'Images with these CSS classes won\'t show the "Pin it" button. Please separate multiple classes with semicolons. Spaces are not accepted.', 'jquery-pin-it-button-for-images' ),
			'type'  => 'string'
		);

		$res['enabled_classes'] = array(
			'key'   => 'enabled_classes',
			'label' => __( 'Enabled classes', 'jquery-pin-it-button-for-images' ),
			'desc'  => __( 'Only images with these CSS classes will show the "Pin it" button. Please separate multiple classes with semicolons. If this field is empty, images with any (besides disabled ones) classes will show the Pin It button.', 'jquery-pin-it-button-for-images' ),
			'type'  => 'string'
		);

		$local_args              = array(
			'min'  => '0',
			'step' => '1',
			'type' => 'int'
		);
		$res['min_image_height'] = array_merge( $local_args, array(
			'key'         => 'min_image_height',
			'label'       => __( 'Height', 'jquery-pin-it-button-for-images' ),
			'error_label' => __( 'Minimum image height', 'jquery-pin-it-button-for-images' )
		) );
		$res['min_image_width']  = array_merge( $local_args, array(
			'key'         => 'min_image_width',
			'label'       => __( 'Width', 'jquery-pin-it-button-for-images' ),
			'error_label' => __( 'Minimum image width', 'jquery-pin-it-button-for-images' )
		) );

		$res['min_image_height_small'] = array_merge( $local_args, array(
			'key'         => 'min_image_height_small',
			'label'       => __( 'Height', 'jquery-pin-it-button-for-images' ),
			'error_label' => __( 'Minimum image height for mobile', 'jquery-pin-it-button-for-images' )
		) );
		$res['min_image_width_small']  = array_merge( $local_args, array(
			'key'         => 'min_image_width_small',
			'label'       => __( 'Width', 'jquery-pin-it-button-for-images' ),
			'error_label' => __( 'Minimum image width for mobile', 'jquery-pin-it-button-for-images' )
		) );

		$res['show_on'] = array(
			'key'   => 'show_on',
			'label' => __( 'Show on', 'jquery-pin-it-button-for-images' ),
			'type'  => 'string'
		);

		$res['disable_on'] = array(
			'key'   => 'disable_on',
			'label' => __( 'Disable on', 'jquery-pin-it-button-for-images' ),
			'type'  => 'string'
		);

		foreach ( $res as $key => $setting ) {
			$res[ $key ]['value'] = $option_value[ $key ];
		}

		return $res;
	}

	function render_post_selection_meta_box() {
		global $post;
		$id             = $post->ID;
		$options        = $this->options->get();
		$disabled_list  = $options['disable_on'];
		$disabled_array = explode( ',', $disabled_list );
		$result         = in_array( (string) $id, $disabled_array );
		wp_nonce_field( 'jpibfi-post-selection', "jpibfi-post-selection" );
		?>
        <div>
            <label>
                <input name="jpibfi-disable-post" type="checkbox" <?php checked( true, $result, true ); ?> value="1"/>
				<?php _e( 'Disable plugin on this post', 'jquery-pin-it-button-for-images' ); ?>
            </label>
        </div>
		<?php
	}

	function save_post_selection_meta( $post_id, $post, $update ) {
		if ( ! isset( $_POST["jpibfi-post-selection"] ) || ! wp_verify_nonce( $_POST["jpibfi-post-selection"], 'jpibfi-post-selection' ) ) {
			return $post_id;
		}

		if ( ! current_user_can( "edit_post", $post_id ) ) {
			return $post_id;
		}

		if ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$should_be_in_array = isset( $_POST["jpibfi-disable-post"] );

		$options        = $this->options->get();
		$disabled_str   = $options['disable_on'];
		$disabled_array = explode( ',', $disabled_str );
		$is_in_array    = in_array( (string) $post_id, $disabled_array );

		if ( $should_be_in_array === $is_in_array ) {
			return $post_id;
		}

		if ( $should_be_in_array ) {
			$disabled_array[] = (string) $post_id;
		} else {
			$disabled_array = array_diff( $disabled_array, array( (string) $post_id ) );
		}

		$disabled_str          = implode( ',', $disabled_array );
		$options['disable_on'] = $disabled_str;
		$this->options->update( $options );
	}
}