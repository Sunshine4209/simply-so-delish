<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.1.0
 * @package WPZOOM_Recipe_Card_Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPZOOM_Assets_Manager' ) ) {
	/**
	 * Main WPZOOM_Assets_Manager Class.
	 *
	 * @since 1.1.0
	 */
	class WPZOOM_Assets_Manager {
		/**
		 * This plugin's instance.
		 *
		 * @var WPZOOM_Assets_Manager
		 * @since 1.1.0
		 */
		private static $instance;

		/**
		 * Provides singleton instance.
		 *
		 * @since 1.1.0
		 * @return self instance
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new WPZOOM_Assets_Manager();
			}

			return self::$instance;
		}

		/**
		 * The base directory path.
		 *
		 * @var string $_dir
		 */
		private $_dir;

		/**
		 * The base URL path.
		 *
		 * @var string $_url
		 */
		private $_url;

		/**
		 * The Plugin version.
		 *
		 * @var string $_slug
		 */
		public $_slug;

		/**
		 * The Constructor.
		 */
		private function __construct() {
			$this->_slug = 'wpzoom-rcb-block';
			$this->_url  = untrailingslashit( WPZOOM_RCB_PLUGIN_URL );

			add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );
			add_action( 'enqueue_block_assets', array( $this, 'load_icon_fonts' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'editor_assets' ) );

			// Include admin scripts & styles
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		}

		/**
		 * Get array of dependencies.
		 *
		 * @param string|string $handle The handle slug.
		 *
		 * @since 1.1.0
		 */
		public function get_dependencies( $handle ) {
			$dependencies = array();

			if ( $this->_slug . '-js' === $handle ) {
				$dependencies = array( 'wp-editor', 'wp-components', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-compose' );
			}
			elseif ( $this->_slug . '-editor-css' === $handle ) {
				$dependencies = array( 'wp-edit-blocks' );
			}
			elseif ( $this->_slug . '-script' === $handle ) {
				$dependencies = array( 'jquery' );
			}
			elseif ( $this->_slug . '-icon-fonts-css' === $handle ) {
				$dependencies = array( 'wp-edit-blocks' );
			}
			elseif ( 'wpzoom-rating-stars-script' === $handle ) {
				$dependencies = array( 'jquery' );
			}

			return $dependencies;
		}

		/**
		 * Enqueue Gutenberg block assets for both frontend + backend.
		 *
		 * `wp-blocks`: includes block type registration and related functions.
		 *
		 * @since 1.1.0
		 */
		public function block_assets() {
            if ( is_admin() ) {
                
                wp_enqueue_style(
                    $this->_slug . '-style-css', // Handle.
                    $this->asset_source( '', 'blocks.style.build.css' ), // Block style CSS.
                    $this->get_dependencies( $this->_slug . '-style-css' ), // Dependency to include the CSS after it.
                    WPZOOM_RCB_VERSION
                );

                // Enable Google Fonts
                if ( '1' === WPZOOM_Settings::get('wpzoom_rcb_settings_enable_google_fonts') ) {
                    wp_enqueue_style(
                        $this->_slug . '-google-font',
                        'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400i,700,700i',
                        false
                    );
                }

            } else {

                if ( has_block( 'wpzoom-recipe-card/block-details' ) || 
                     has_block( 'wpzoom-recipe-card/block-ingredients' ) || 
                     has_block( 'wpzoom-recipe-card/block-directions' ) || 
                     has_block( 'wpzoom-recipe-card/block-print-recipe' ) || 
                     has_block( 'wpzoom-recipe-card/block-jump-to-recipe' ) || 
                     has_block( 'wpzoom-recipe-card/block-recipe-card' ) ||
                     has_block( 'wpzoom-recipe-card/block-nutrition' )
                ) {

                    // Scripts.
                    wp_enqueue_script(
                        $this->_slug . '-script',
                        $this->asset_source( 'js', 'script.js' ),
                        $this->get_dependencies( $this->_slug . '-script' ),
                        WPZOOM_RCB_VERSION,
                        true
                    );

                    wp_enqueue_script(
                        $this->_slug . '-pinit',
                        'https://assets.pinterest.com/js/pinit.js',
                        array(),
                        false,
                        true
                    );

                    // Styles.
                    wp_enqueue_style(
                        $this->_slug . '-style-css', // Handle.
                        $this->asset_source( '', 'blocks.style.build.css' ), // Block style CSS.
                        $this->get_dependencies( $this->_slug . '-style-css' ), // Dependency to include the CSS after it.
                        WPZOOM_RCB_VERSION
                    );

                    // Enable Google Fonts
                    if ( '1' === WPZOOM_Settings::get('wpzoom_rcb_settings_enable_google_fonts') ) {
                        wp_enqueue_style(
                            $this->_slug . '-google-font',
                            'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400i,700,700i',
                            false
                        );
                    }

                    /**
                     * Localize script data.
                     */
                    $this->localize_script(
                        $this->_slug . '-script',
                        'wpzoomRecipeCard',
                        array(
                            'pluginURL' => WPZOOM_RCB_PLUGIN_URL,
                        )
                    );                    
                }

            }
            
		}

		/**
		 * Enqueue Gutenberg block assets for backend editor.
		 *
		 * `wp-blocks`: includes block type registration and related functions.
		 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
		 * `wp-i18n`: To internationalize the block's text.
		 *
		 * @since 1.1.0
		 */
        public function editor_assets() {
            global $post;

        	$options = WPZOOM_Settings::get_settings();

            // Scripts.
            wp_enqueue_script(
                $this->_slug . '-js', // Handle.
                $this->asset_source( '', 'blocks.build.js' ), // Block.build.js: We register the block here. Built with Webpack.
                $this->get_dependencies( $this->_slug . '-js' ), // Dependencies, defined above.
                WPZOOM_RCB_VERSION,
                true // Enqueue the script in the footer.
            );

            // Tell to WordPress that our script contains translations
            // this function was added in 5.0 version
            if ( function_exists( 'wp_set_script_translations' ) ) {
	            wp_set_script_translations( $this->_slug .'-js', WPZOOM_RCB_TEXT_DOMAIN, WPZOOM_RCB_PLUGIN_DIR . 'languages' );
            }

            // Styles.
            wp_enqueue_style(
                $this->_slug . '-editor-css', // Handle.
                $this->asset_source( '', 'blocks.editor.build.css' ), // Block editor CSS.
                $this->get_dependencies( $this->_slug . '-editor-css' ), // Dependency to include the CSS after it.
                WPZOOM_RCB_VERSION
            );

            /**
             * Localize script data.
             */
            $this->localize_script(
                $this->_slug . '-js',
                'wpzoomRecipeCard',
                array(
                    'version' => WPZOOM_RCB_VERSION,
                    'textdomain' => WPZOOM_RCB_TEXT_DOMAIN,
                    'pluginURL' => WPZOOM_RCB_PLUGIN_URL,
                    'post_permalink' => str_replace( '?p=', '', get_the_permalink( $post->ID ) ),
                    'post_thumbnail_url' => get_the_post_thumbnail_url( $post->ID ),
                    'post_thumbnail_id' => get_post_thumbnail_id( $post->ID ),
                    'post_title' => $post->post_title,
                    'post_author_name' => get_the_author_meta( 'display_name', $post->post_author ),
                    'is_pro' => WPZOOM_Recipe_Card_Block_Gutenberg::is_pro(),
                    'setting_options' => ( !empty( $options ) ? $options : WPZOOM_Settings::get_defaults() ),
                    'nutritionFactsLabel' => WPZOOM_Nutrition_Block::$labels
                )
            );
        }

        /**
         * Enqueue admin scripts and styles
         *
         * @since 2.2.0
         */
        public function admin_scripts() {
        	wp_enqueue_style(
        		'wpzoom-rcb-admin-css',
        		$this->asset_source( '', 'assets/admin/css/admin.css' ),
        		$this->get_dependencies( 'wpzoom-rcb-admin-css' ),
        		WPZOOM_RCB_VERSION
        	);
        }


		/**
		 * Load icon fonts.
		 *
		 * To make backward compatibility we include icons from version 1.1.0
		 * That's why we named it 'oldicon'
		 *
		 * @since 1.1.0
		 */
		public function load_icon_fonts() {
            // enqueue all icon fonts only in admin panel
            if ( is_admin() ) {

                wp_enqueue_style(
                    $this->_slug . '-icon-fonts-css', // Handle.
                    $this->asset_source( 'css', 'icon-fonts.build.css' ), // Block editor CSS.
                    $this->get_dependencies( $this->_slug . '-icon-fonts-css' ), // Dependency to include the CSS after it.
                    WPZOOM_RCB_VERSION
                );

            }

            if ( ! is_admin() && ( has_block( 'wpzoom-recipe-card/block-details' ) || has_block( 'wpzoom-recipe-card/block-recipe-card' ) ) ) {

                wp_enqueue_style(
                    $this->_slug . '-icon-fonts-css', // Handle.
                    $this->asset_source( 'css', 'icon-fonts.build.css' ), // Block editor CSS.
                    $this->get_dependencies( $this->_slug . '-icon-fonts-css' ), // Dependency to include the CSS after it.
                    WPZOOM_RCB_VERSION
                );

            }
		}

		/**
		 * Source assets.
		 *
		 * @since 1.1.0
		 * @param string|string $type The type of resource.
		 * @param string|string $directory Any extra directories needed.
		 */
		public function asset_source( $type = 'js', $directory = null ) {
			if ( 'js' === $type || 'css' === $type ) {
				return $this->_url . '/dist/assets/' . $type . '/' . $directory;
			} else {
				return $this->_url . '/dist/' . $directory;
			}
		}

		/**
		 * Enqueue localization data.
		 *
		 * @since 1.1.0
		 * @access public
		 */
		public function localize_script( $handle, $name, $data ) {
			wp_localize_script( $handle, $name, $data );
		}
	}
}

WPZOOM_Assets_Manager::instance();
