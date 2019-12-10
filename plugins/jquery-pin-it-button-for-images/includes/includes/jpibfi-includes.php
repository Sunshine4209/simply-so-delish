<?php

class JPIBFI_Includes {

    private $file;
    private $version;

    function __construct( $file, $version ){
        $this->version = $version;
        $this->file = $file;
        $this->load_dependencies();
    }

    function load_dependencies(){
	    require_once 'options/jpibfi-options.php';
	    require_once 'options/jpibfi-selection-options.php';
	    require_once 'options/jpibfi-visual-options.php';
	    require_once 'options/jpibfi-advanced-options.php';


	    require_once 'JPIBFI_Version_Updater.php';
    }
}