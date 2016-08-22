<?php
/*
Plugin Name: Huntingslow Widget Pack
Plugin URI: http://github.com/honisoit/
Description: Luxe widgets for use with Honi Soit's Huntingslow theme
Author: Honi Soit
Version: 1.0
Author URI: http://www.honisoit.com
*/
// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

//Get the absolute path of the directory that contains the file, with trailing slash.
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
//This is important, otherwise we'll get the path of a subdirectory
require_once MY_PLUGIN_PATH . 'includes/widget-related.php';
require_once MY_PLUGIN_PATH . 'includes/link-banner.php';
require_once MY_PLUGIN_PATH . 'includes/pane-headline-list.php';
require_once MY_PLUGIN_PATH . 'includes/pane-popular.php';
require_once MY_PLUGIN_PATH . 'includes/pane-single-lg.php';
require_once MY_PLUGIN_PATH . 'includes/pane-single-md.php';
require_once MY_PLUGIN_PATH . 'includes/pane-single-sm.php';
require_once MY_PLUGIN_PATH . 'includes/pane-link-sm.php';
require_once MY_PLUGIN_PATH . 'includes/aggregator-md.php';
require_once MY_PLUGIN_PATH . 'includes/frame-lg.php';
require_once MY_PLUGIN_PATH . 'includes/frame-md.php';
require_once MY_PLUGIN_PATH . 'includes/frame-sm.php';

add_action( 'widgets_init', function(){
     register_widget( 'Widget_Related' );
     register_widget( 'Huntingslow_Pane_Banner_Link' );
     register_widget( 'Huntingslow_Pane_Headline_List' );
     register_widget( 'Huntingslow_Pane_Popular' );
     register_widget( 'Huntingslow_Pane_Single_Lg' );
     register_widget( 'Huntingslow_Pane_Single_Md' );
     register_widget( 'Huntingslow_Pane_Single_Sm' );
     register_widget( 'Huntingslow_Pane_Link_Sm' );
     register_widget( 'Huntingslow_Pane_Aggregator_Md' );
		 register_widget( 'Huntingslow_Frame_Lg' );
		 register_widget( 'Huntingslow_Frame_Md' );
		 register_widget( 'Huntingslow_Frame_Sm' );
});
