<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class JPIBFI_Welcome_Screen {
	private $minimum_capability = 'manage_options';
	private $transient_name = '_jpibfi_activation_redirect';
	private $plugin_name;
	private $file;
	private $version;

	function __construct( $file, $version ) {
		$this->file    = $file;
		$this->version = $version;

		$this->plugin_name = 'jQuery Pin It Button for Images Lite';
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_init', array( $this, 'redirect' ), 11 );
	}

	public function admin_menus() {
		// About Page
		add_dashboard_page(
			__( 'Welcome to jQuery Pin It Button for Images', 'jquery-pin-it-button-for-images' ),
			__( 'Welcome to jQuery Pin It Button for Images', 'jquery-pin-it-button-for-images' ),
			$this->minimum_capability,
			'jpibfi-welcome',
			array( $this, 'welcome_message' )
		);

		// Now remove them from the menus so plugins that allow customizing the admin menu don't show them
		remove_submenu_page( 'index.php', 'jpibfi-welcome' );
	}

	public function welcome_message() {
		?>
        <div class="wrap about-wrap">
            <h1><?php printf( __( 'Welcome to %s&nbsp;%s', 'jquery-pin-it-button-for-images' ), $this->plugin_name, $this->version ); ?></h1>

            <p class="about-text"><?php printf( __( 'Thank you for updating to the latest version! %s helps your readers share your images using Pinterest.', 'jquery-pin-it-button-for-images' ), $this->plugin_name, $this->version ); ?></p>

            <hr/>

            <div class="feature-section one-col">
                <h2><?php _e( 'Settings', 'jquery-pin-it-button-for-images' ); ?></h2>
                <p class="lead-description"><?php _e( 'The most important part of the plugin is the settings panel.', 'jquery-pin-it-button-for-images' ); ?></p>
            </div>

            <div class="feature-section two-col">
                <div class="col">
                    <h3><?php _e( 'Finding the settings panel', 'jquery-pin-it-button-for-images' ); ?></h3>
                    <p><?php printf( __( 'You can find the plugin\'s settings panel in the <b>Settings</b> submenu under the name <b>%s</b>. There you can find all the settings the plugin allows you to adjust. All settings are divided into several tabs so you can find what you\'re looking for easily.', 'jquery-pin-it-button-for-images' ), $this->plugin_name ); ?></p>
                </div>
                <div class="col">
                    <?php
                    $file_name = 'settings_link.png';
                    ?>
                    <img src="<?php echo plugin_dir_url( $this->file ) . '/images/' . $file_name ?>"
                         title="<?php _e( 'Settings link', 'jquery-pin-it-button-for-images' ); ?>"/>
                </div>
            </div>
            <div class="feature-section one-col">
                <h3><?php _e( 'Everything at hand', 'jquery-pin-it-button-for-images' ); ?></h3>
                <p style="margin-left: 0; margin-right: 0;"><?php _e( 'You can find all the links mentioned below in the settings panel.', 'jquery-pin-it-button-for-images' ); ?></p>
                <p style="text-align: center;"><img
                            src="<?php echo plugin_dir_url( $this->file ) . '/images/settings_tabs.png' ?>"
                            title="<?php _e( 'Settings tabs', 'jquery-pin-it-button-for-images' ); ?>"/>
                </p>
            </div>
            <div class="feature-section two-col">
                <div class="col">
                    <h3><?php _e( 'Selection settings', 'jquery-pin-it-button-for-images' ); ?></h3>
                    <p><?php _e( 'In this tab you choose which images should feature the "Pin it" button. You can choose images with specific classes or set up a minimum image resolution to prevent the button from showing up on small images. You can also choose on which pages the "Pin it" button should show up.', 'jquery-pin-it-button-for-images' ); ?></p>
					<?php printf( __( '<a href="%s" class="button button-primary">Go to Selection settings</a>', 'jquery-pin-it-button-for-images' ), admin_url( 'options-general.php?page=jpibfi_settings&tab=select' ) ); ?>
                </div>
                <div class="col">
                    <h3><?php _e( 'Visual settings', 'jquery-pin-it-button-for-images' ); ?></h3>
                    <p><?php _e( 'This tab helps you configure how the "Pin it" button looks like and where it appears. If you want to use your own "Pin it" icon or make the button show up in the upper right corner of the image, this is the tab you are looking for.', 'jquery-pin-it-button-for-images' ); ?></p>
					<?php printf( __( '<a href="%s" class="button button-primary">Go to Visual settings</a>', 'jquery-pin-it-button-for-images' ), admin_url( 'options-general.php?page=jpibfi_settings&tab=visual' ) ); ?>
                </div>
            </div>
            <div class="feature-section two-col">
                <div class="col">
                    <h3><?php _e( 'Advanced settings', 'jquery-pin-it-button-for-images' ); ?></h3>
                    <p><?php _e( 'In most cases you won\'t have to visit this tab ever. It features a few advanced settings used in most cases to resolve conflicts with other plugins.', 'jquery-pin-it-button-for-images' ); ?></p>
					<?php printf( __( '<a href="%s" class="button button-primary">Go to Advanced settings</a>', 'jquery-pin-it-button-for-images' ), admin_url( 'options-general.php?page=jpibfi_settings&tab=advanced' ) ); ?>
                </div>
                <div class="col">
                    <h3><?php _e( 'Import/Export', 'jquery-pin-it-button-for-images' ); ?></h3>
                    <p><?php _e( 'If you would like to quickly copy the plugin\'s settings to another instance of WordPress, that\'s the place for you. You can download a file with your current settings and import it to another instance easily.', 'jquery-pin-it-button-for-images' ); ?></p>
					<?php printf( __( '<a href="%s" class="button button-primary">Go to Import/Export</a>', 'jquery-pin-it-button-for-images' ), admin_url( 'options-general.php?page=jpibfi_settings&tab=import' ) ); ?>
                </div>
            </div>

            <hr/>

            <div class="feature-section one-col">
                <h2><?php _e( 'Finding help', 'jquery-pin-it-button-for-images' ); ?></h2>
                <p class="lead-description"><?php _e( 'If you\'re stuck and can\'t get the plugin to work the way you want it to, get help!', 'jquery-pin-it-button-for-images' ); ?></p>
            </div>

            <div class="feature-section two-col">
                <div class="col">
                    <h3><?php _e( 'Documentation', 'jquery-pin-it-button-for-images' ); ?></h3>
                    <p><?php printf( __( 'If you are having difficulties with some aspects of the plugin, the first place to look for help is <a href="%s" target="_blank">the documentation</a> of the plugin. Chances are you will find what you are looking for there.', 'jquery-pin-it-button-for-images' ), 'https://highfiveplugins.com/jpibfi/jquery-pin-it-button-for-images-documentation/' ); ?></p>
                </div>
                <div class="col">
                    <h3><?php _e( 'Support', 'jquery-pin-it-button-for-images' ); ?></h3>
                    <p><?php
						printf( __( 'Users of the free version of the plugin can find support <a href="%s" target="_blank">in the support forum</a>. When posting to the support forum, make sure you include the URL of your website.', 'jquery-pin-it-button-for-images' ), 'https://wordpress.org/support/plugin/jquery-pin-it-button-for-images' );
						?></p>
                </div>
            </div>
            <hr />
            <div class="feature-section one-col">
                <h2><?php _e( 'Next steps', 'jquery-pin-it-button-for-images' ); ?></h2>
                <?php
                $next_steps_text = sprintf( __( 'In most cases, the plugin is ready to go without any configuration. If there is anything you would like to change, go to the <a href="%s">Settings panel</a>.', 'jquery-pin-it-button-for-images' ), admin_url( 'options-general.php?page=jpibfi_settings' ) );
                ?>
                <p class="lead-description"><?php echo $next_steps_text; ?></p>
            </div>
        </div>
		<?php
	}

	public function redirect() {
		if ( ! get_transient( $this->transient_name ) ) {
			return;
		}
		delete_transient( $this->transient_name );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}
		wp_safe_redirect( admin_url( 'index.php?page=jpibfi-welcome' ) );
		exit;
	}
}