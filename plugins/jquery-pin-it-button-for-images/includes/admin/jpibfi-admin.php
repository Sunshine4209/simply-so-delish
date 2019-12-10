<?php

class JPIBFI_Admin {

	private $file;
	private $version;
	private $save_settings_action;
	private $save_settings_tab;

	private $admin_screen_hook = '';

	/**
	 * @var JPIBFI_Settings_Tab[]
	 */
	private $tab_modules;

	function __construct( $file, $version ) {
		$this->file    = $file;
		$this->version = $version;

		$this->tab_modules          = array();
		$this->save_settings_action = 'jpibfi_save_settings';
		$this->save_settings_tab    = 'jpibfi_save_settings_tab';

		$this->load_dependencies();
		$this->setup();

		add_action( 'admin_init', array( $this, 'save_settings' ) );
		add_action( 'admin_menu', array( $this, 'print_admin_page_action' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );

		$jpibfi_plugin = plugin_basename( $this->file );
		add_filter( "plugin_action_links_$jpibfi_plugin", array( $this, 'add_settings_link' ) );
		add_action( 'admin_init', array( $this, 'show_nags' ) );
		add_action( 'admin_notices', array( $this, 'show_ad' ), 11 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_meta_links' ), 10, 2 );
	}

	function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=jpibfi_settings">' . __( 'Settings', 'jquery-pin-it-button-for-images' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * @param $tab_module JPIBFI_Settings_Tab
	 */
	private function add_tab_module( $tab_module ) {
		$this->tab_modules[ $tab_module->get_slug() ] = $tab_module;
	}

	private function load_dependencies() {
		$deps = array(
			'JPIBFI_Welcome_Screen.php',
			'includes/jpibfi_ajax_result_builder.php',
			'includes/jpibfi_admin_notice.php',
			'settings/jpibfi-settings-base.php',
			'settings/jpibfi_validator.php',
			'settings/jpibfi-import-export-settings.php',
			'settings/jpibfi-selection-settings.php',
			'settings/jpibfi-visual-settings.php',
			'settings/jpibfi-advanced-settings.php',
		);
		foreach ( $deps as $dep ) {
			require_once $dep;
		}
	}

	private function setup() {
		$this->add_tab_module( new JPIBFI_Selection_Settings() );
		$this->add_tab_module( new JPIBFI_Visual_Settings() );
		$this->add_tab_module( new JPIBFI_Advanced_Settings() );
		$this->add_tab_module( new JPIBFI_Import_Export_Settings() );

		new JPIBFI_Welcome_Screen( $this->file, $this->version );
	}

	public function print_admin_page_action() {

		$name = 'jQuery Pin It Button For Images Lite';

		$this->admin_screen_hook = add_options_page(
			$name,
			$name,
			'manage_options',
			'jpibfi_settings',
			array( $this, 'print_admin_page' )
		);
	}

	public function add_admin_scripts( $hook ) {
		if ( $this->admin_screen_hook === $hook ) {
			$this->add_settings_scripts();
		}
	}

	private function add_settings_scripts() {
		$plugin_dir_url = plugin_dir_url( $this->file );

		wp_enqueue_style( 'jquery-pin-it-button-admin-style', $plugin_dir_url . 'css/admin.css', array(), $this->version, 'all' );

		$links = array(
			array(
				'url'   => 'https://highfiveplugins.com/jpibfi/jquery-pin-it-button-for-images-documentation/',
				'label' => __( 'Documentation', 'jquery-pin-it-button-for-images' )
			),
			array(
				'url'   => 'https://wordpress.org/support/plugin/jquery-pin-it-button-for-images',
				'label' => __( 'Support', 'jquery-pin-it-button-for-images' )
			)
		);


		$slug     = isset( $_GET['tab'] ) ? $_GET['tab'] : 'select';
		$tab_mod  = $this->get_tab( $slug );
		$slug = $tab_mod->get_slug();

		$settings = array(
			'tabs'       => $this->get_tabs(),
			'currentTab' => $slug,
			'page'       => 'jpibfi_settings',
			'save'       => array(
				'post_url' => add_query_arg( array( 'tab' => $slug ) ),
				'action'   => $this->save_settings_action,
				'nonce'    => wp_create_nonce( $this->save_settings_action ),
				'tab'      => $this->save_settings_tab,
				'submit'   => __( 'Save Changes', 'jquery-pin-it-button-for-images' )
			),
			'links'      => $links,
			'settings'   => $tab_mod->get_settings_configuration(),
			'i18n'       => array(
				'editor' => $tab_mod->get_settings_i18n(),
				'status' => array( 'pending' => __( 'Saving changes ...', 'jquery-pin-it-button-for-images' ) ),
			),
		);
		$settings['version'] = 'lite';
		wp_enqueue_script( 'jpibfi', $plugin_dir_url . 'js/jpibfi.admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'jpibfi', 'jpibfi_settings', $settings );

		if ( function_exists( "wp_enqueue_media" ) ) {
			wp_enqueue_media();
		}
	}

	private function get_tab( $tab_slug ) {
		return array_key_exists( $tab_slug, $this->tab_modules )
			? $this->tab_modules[ $tab_slug ]
			: $this->tab_modules[ 'select' ];
	}

	private function get_tabs() {
		$res = array();
		foreach ( $this->tab_modules as $slug => $tab_module ) {
			$res[] = $tab_module->get_module_settings();
		}

		return $res;
	}

	public function print_admin_page() {
		?>
        <div id="jpibfi-container" class="wrap">
            <h2><?php _e( 'jQuery Pin It Button For Images Options', 'jquery-pin-it-button-for-images' ); ?></h2>
            <div id="icon-plugins" class="icon32"></div>
            <jpibfi settings-name="jpibfi_settings"></jpibfi>
            <h3 id="jpibfi-error"><?php printf(__('If you cannot see the settings page, <a href="%s" target="_blank">click here</a>', 'jquery-pin-it-button-for-images'), 'https://highfiveplugins.com/jpibfi/jquery-pin-it-button-for-images-documentation/#Empty_settings_page'); ?></h3>
        </div>
		<?php
	}


	function save_settings() {
		$return_condition = ! isset( $_POST[ $this->save_settings_action ] ) ||
		                    ! wp_verify_nonce( $_POST[ $this->save_settings_action ], $this->save_settings_action );
		if ( $return_condition ) {
			return;
		}
		$tab    = $_POST[ $this->save_settings_tab ];
		$module = $this->get_tab( $tab );
		$module->save_settings( $_POST );
	}
	
	function show_nags() {
		require_once 'includes/jpibfi_review_nag.php';
		new JPIBFI_Review_Nag( 'jpibfi', 'jQuery Pin It Button For Images', 'http://wordpress.org/support/view/plugin-reviews/jquery-pin-it-button-for-images', '-10 days' );

		require_once 'includes/JPIBFI_Pro_Nag.php';
		new JPIBFI_Pro_Nag( 'jpibfi', 'jQuery Pin It Button For Images', 'https://highfiveplugins.com/downloads/jquery-pin-it-button-for-images-pro/' );
		
	}

	public function show_ad() {
		global $hook_suffix;
		if ( $hook_suffix !== $this->admin_screen_hook ) {
		    return;
		}
        ?>
        <div class="notice notice-success">
            <p>
                <?php printf(
                    __( '<strong>jQuery Pin It Button for Images Pro</strong> is available. <a class="button button-primary" href="%1$s" target="_blank">Check it out &rarr;</a>', 'jquery-pin-it-button-for-images' ),
                    'https://highfiveplugins.com/downloads/jquery-pin-it-button-for-images-pro/'
                );
                ?>
            </p>
        </div>
        <?php
	}

	function plugin_meta_links( $links, $file ) {
		$plugin = plugin_basename( $this->file );
		if ( $file == $plugin ) {
			return array_merge( $links, array( '<a href="https://highfiveplugins.com/downloads/jquery-pin-it-button-for-images-pro/">jQuery Pin It Button for Images Pro</a>' ) );
		}

		return $links;
	}
}