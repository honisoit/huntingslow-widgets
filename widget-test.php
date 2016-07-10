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
require_once MY_PLUGIN_PATH . 'includes/widget-popular.php';
require_once MY_PLUGIN_PATH . 'includes/widget-related.php';
require_once MY_PLUGIN_PATH . 'includes/widget-single-article.php';

add_action( 'widgets_init', function(){
     register_widget( 'Widget_Popular' );
});


add_action( 'widgets_init', function(){
     register_widget( 'Widget_Related' );
});

add_action( 'widgets_init', function(){
     register_widget( 'Widget_Single_Article' );
});
