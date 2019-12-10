<?php

class JPIBFI_Client {

	private $selection_options;
	private $visual_options;
	/**
	 * @var JPIBFI_Advanced_Options
	 */
	private $advanced_options;
	private $version;
	private $plugin_dir_url;

	public function __construct( $file, $version ) {
		$this->version           = $version;
		$this->plugin_dir_url    = plugin_dir_url( $file );
		$this->selection_options = new JPIBFI_Selection_Options();
		$this->visual_options    = new JPIBFI_Visual_Options();
		$this->advanced_options  = new JPIBFI_Advanced_Options();

		add_action( 'wp_enqueue_scripts', array( $this, 'add_plugin_scripts' ) );
		add_action( 'wp_head', array( $this, 'print_header_style' ) );
		$this->add_conditional_filters();

		//load dependency
		require_once 'JPIBFI_Client_Helper.php';
	}

	private function add_conditional_filters() {
		$advanced_value = $this->advanced_options->get();

		$filters = array(
			'post_thumbnail_html',
			'the_excerpt',
			'the_content'
		);

		foreach ( $filters as $filter ) {
			if ( $advanced_value[ 'filter_' . $filter . '_on' ] ) {
				add_filter( $filter, array(
					$this,
					'the_content'
				), $advanced_value[ 'filter_' . $filter . '_priority' ] );
			}
		}
	}

	public function add_plugin_scripts() {
		if ( ! $this->add_jpibfi() ) {
			return;
		}
		
		wp_enqueue_script( 'jpibfi-script', $this->plugin_dir_url . 'js/jpibfi.client.js', array( 'jquery' ), $this->version, true );
		
		$parameters_array = array(
			'hover' => array_merge(
				array( 'siteTitle' => esc_attr( get_bloginfo( 'name', 'display' ) ) ),
				$this->selection_options->get(),
				$this->visual_options->get_options_for_view(),
				$this->advanced_options->get_options_for_view()
			),
		);
		wp_localize_script( 'jpibfi-script', 'jpibfi_options', $parameters_array );
		wp_enqueue_style( 'jpibfi-style', $this->plugin_dir_url . 'css/client.css', array(), $this->version );
	}

	public function print_header_style() {
		if ( ! $this->add_jpibfi() ) {
			return;
		}

		$visual_options_js = $this->visual_options->get_options_for_view();
		$advanced_options = $this->advanced_options->get();

		$custom_button_span_css = '';
		if ( $visual_options_js['pin_image'] === 'custom' ) {
			$custom_button_span_css .= sprintf( 'background-image: url("%s");', $visual_options_js['custom_image_url'] );
		}
		ob_start();
		?>
<style type="text/css">
	a.pinit-button.custom span {
	<?php echo $custom_button_span_css; ?>
	}

	.pinit-hover {
		opacity: <?php echo (1 - $visual_options_js['transparency_value']); ?> !important;
		filter: alpha(opacity=<?php echo (1 - $visual_options_js['transparency_value']) * 100; ?>) !important;
	}
	<?php echo $advanced_options['custom_css']; ?>
</style>
		<?php
		echo ob_get_clean();
	}

	/*
	* Adds data-jpibfi-description attribute to each image that is added through media library. The value is the "Description"  of the image from media library.
	* This piece of code uses a lot of code from the Photo Protect http://wordpress.org/plugins/photo-protect/ plugin
	*/
	function the_content( $content ) {
		if ( ! $this->add_jpibfi() ) {
			return $content;
		}
		global $post;

		$visual_options = $this->visual_options->get();

		$get_description = in_array( 'img_description', $visual_options['description_option'] );
		$get_caption     = in_array( 'img_caption', $visual_options['description_option'] );

		$imgPattern  = '/<img[^>]*>/i';
		$attrPattern = '/ ([-\w]+)[ ]*=[ ]*([\"\'])(.*?)\2/i';

		preg_match_all( $imgPattern, $content, $images, PREG_SET_ORDER );

		foreach ( $images as $img ) {

			preg_match_all( $attrPattern, $img[0], $attributes, PREG_SET_ORDER );

			$new_img = '<img';
			$src     = '';
			$id      = '';

			foreach ( $attributes as $att ) {
				$full  = $att[0];
				$name  = $att[1];
				$value = $att[3];

				$new_img .= $full;

				if ( 'class' == $name ) {
					$id = $this->get_post_id_from_image_classes( $value );
				}

				if ( 'src' == $name ) {
					$src = $value;
				}
			}

            $att = $get_description || $get_caption ? $this->get_attachment( $id, $src ): null;
            if ( $att != null ) {
                $new_img .= $get_description ? sprintf( ' data-jpibfi-description="%s"', esc_attr( $att->post_content ) ): '';
                $new_img .= $get_caption ? sprintf( ' data-jpibfi-caption="%s"', esc_attr( $att->post_excerpt ) ): '';
            }

			$new_img .= sprintf( ' data-jpibfi-post-excerpt="%s"', esc_attr( wp_kses( $post->post_excerpt, array() ) ) );
			$new_img .= sprintf( ' data-jpibfi-post-url="%s"', esc_attr( get_permalink() ) );
			$new_img .= sprintf( ' data-jpibfi-post-title="%s"', esc_attr( get_the_title() ) );
			$new_img .= sprintf( ' data-jpibfi-src="%s"', esc_attr( $src ) );
			$new_img .= ' >';
			$content = str_replace( $img[0], $new_img, $content );
		}
		$jscript = '';
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			ob_start();
			?>
            <script type="text/javascript">
                (function () {
                    if (!jQuery) return;
                    jQuery(document).ready(function () {
						var $inputs = jQuery('.jpibfi');
						var $closest = $inputs.closest('div, article');
						$closest = $closest.length ? $closest : $inputs.parent();
						$closest.addClass('jpibfi_container');
                    });
                })();
            </script>
			<?php
			$jscript = ob_get_clean();
		}

		return '<input class="jpibfi" type="hidden">' . $content . $jscript;
	}


	//function gets the id of the image by searching for class with wp-image- prefix, otherwise returns empty string
	function get_post_id_from_image_classes( $class_attribute ) {
		$classes = preg_split( '/\s+/', $class_attribute, - 1, PREG_SPLIT_NO_EMPTY );
		$prefix  = 'wp-image-';

		foreach ( $classes as $class ) {
			if ( $prefix === substr( $class, 0, strlen( $prefix ) ) ) {
				return str_replace( $prefix, '', $class );
			}
		}

		return '';
	}

	/**
	 * @param $id
	 * @param $src
	 *
	 * @return array|null|WP_Post
	 */
	function get_attachment( $id, $src ) {
		$result = is_numeric( $id ) ? get_post( $id ) : null;
		if ( $result )
		    return $result;

        $id = $this->get_attachment_id_by_url( $src );
        return  $id !== 0 ? get_post( $id ) : null;
	}

	/**
	 * Function copied from https://wpscholar.com/blog/get-attachment-id-from-wp-image-url/
	 * Return an ID of an attachment by searching the database with the file URL.
	 *
	 * @return {int} $attachment
	 */
	function get_attachment_id_by_url( $url ) {
		$attachment_id = 0;
		$dir           = wp_upload_dir();
		if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) {
			$file       = basename( $url );
			$query_args = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'fields'      => 'ids',
				'meta_query'  => array(
					array(
						'value'   => $file,
						'compare' => 'LIKE',
						'key'     => '_wp_attachment_metadata',
					),
				)
			);
			$query      = new WP_Query( $query_args );
			if ( $query->have_posts() ) {
				foreach ( $query->posts as $post_id ) {
					$meta                = wp_get_attachment_metadata( $post_id );
					$original_file       = basename( $meta['file'] );
					$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
						$attachment_id = $post_id;
						break;
					}
				}
			}
		}

		return $attachment_id;
	}

	function add_jpibfi() {
		if ( is_feed() ) {
			return false;
		}
		$existing_post_types = get_post_types();
		$add_jpibfi               = false;
		$jpibfi_selection_options = $this->selection_options->get();
		$show_on                  = $jpibfi_selection_options['show_on'];
		$show_array               = explode( ',', $show_on );

		foreach ( $show_array as $show_tag ) {
			if ( $this->is_tag( $show_tag, $existing_post_types ) ) {
				$add_jpibfi = true;
				break;
			}
		}
		if ( ! $add_jpibfi ) {
			return false;
		}

		$disable_on    = $jpibfi_selection_options['disable_on'];
		$disable_array = explode( ',', $disable_on );

		foreach ( $disable_array as $disable_tag ) {
			if ( $this->is_tag( $disable_tag, $existing_post_types ) ) {
				return false;
			}
		}

		return true;
	}

	function is_tag( $tag, $existing_post_types ) {
		$tag = trim( $tag );
		if ( is_numeric( $tag ) ) {
			$int = intval( $tag );

			return get_the_ID() === $int;
		}
		$tag_without = str_replace(']', '', str_replace('[', '', $tag));
		
		if ( in_array( $tag_without, $existing_post_types ) ) {
			return is_singular( $tag_without ) || is_post_type_archive( $tag_without );
		}
				
		switch ( strtolower( $tag ) ) {
			case '[front]':
				return is_front_page();
			case '[single]':
				return is_single();
			case '[archive]':
				return is_archive();
			case '[search]':
				return is_search();
			case '[category]':
				return is_category();
			case '[tag]':
				return is_tag();
			case '[home]':
				return is_home();
			default:
				return false;
		}
	}
}