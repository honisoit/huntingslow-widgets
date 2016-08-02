<?php
/*
Plugin Name: My Widget
Plugin URI: http://mydomain.com
Description: My first widget
Author: Me
Version: 1.0
Author URI: http://mydomain.com
*/
// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

//Get the absolute path of the directory that contains the file, with trailing slash.
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
//This is important, otherwise we'll get the path of a subdirectory
require_once MY_PLUGIN_PATH . 'includes/widget-related.php';
require_once MY_PLUGIN_PATH . 'includes/widget-single-article.php';
require_once MY_PLUGIN_PATH . 'includes/pane-banner-link.php';
require_once MY_PLUGIN_PATH . 'includes/pane-headline-list.php';
require_once MY_PLUGIN_PATH . 'includes/pane-popular.php';
require_once MY_PLUGIN_PATH . 'includes/pane-single-lg.php';
require_once MY_PLUGIN_PATH . 'includes/pane-single-md.php';
require_once MY_PLUGIN_PATH . 'includes/pane-single-sm.php';
require_once MY_PLUGIN_PATH . 'includes/pane-link-sm.php';
require_once MY_PLUGIN_PATH . 'includes/pane-aggregator-md.php';

add_action( 'widgets_init', function(){
     register_widget( 'Widget_Related' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Widget_Single_Article' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Banner_Link' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Headline_List' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Popular' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Single_Lg' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Single_Md' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Single_Sm' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Link_Sm' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Huntingslow_Pane_Aggregator_Md' );
});
