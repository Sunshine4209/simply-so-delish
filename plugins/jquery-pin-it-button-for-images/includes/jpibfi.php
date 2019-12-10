<?php

class JPIBFI {

    private $version;
    private $file;

    function __construct($file, $version){

        $this->file = $file;
        $this->version = $version;

        $this->load_dependencies();
        $this->load_textdomain();

        register_activation_hook( $file, array( $this, 'update_plugin' ) );
        add_action( 'plugins_loaded', array( $this, 'update_plugin' ) );
    }

    function load_dependencies(){
        
        require_once 'includes/jpibfi-includes.php';
        new JPIBFI_Includes($this->file, $this->version);

        if (is_admin()){
            require_once 'admin/jpibfi-admin.php';
            new JPIBFI_Admin($this->file, $this->version);
        } else {
            require_once 'public/class-jpibfi-client.php';
            new JPIBFI_Client($this->file, $this->version);
        }
    }

    function load_textdomain() {
        load_plugin_textdomain( 'jquery-pin-it-button-for-images', FALSE, dirname( plugin_basename( $this->file ) ) . '/languages/' );
    }

    public function update_plugin() {
    	$version_updater = new JPIBFI_Version_Updater( $this->version );
    	$version_updater->update();
    }
}