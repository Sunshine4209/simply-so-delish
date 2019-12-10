<?php


//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

//delete all added options
delete_option( 'jpibfi_selection_options' );
delete_option( 'jpibfi_visual_options' );
delete_option( 'jpibfi_version' );
delete_option( 'jpibfi_options_version' );
delete_option( 'jpibfi_pro_ad' );
delete_option( 'jpibfi_license' );