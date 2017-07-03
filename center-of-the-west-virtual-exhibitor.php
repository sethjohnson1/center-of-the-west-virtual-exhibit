<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://centerofthewest.org/
 * @since             1.0.0
 * @package           Buffalo Bill Center of the West Virtual Exhibitor
 *
 * @wordpress-plugin
 * Plugin Name:       Buffalo Bill Center of the West Virtual Exhibitor
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Embed Virtual Exhibits created from https://collections.centerofthewest.org into your Wordpress site.
 * Version:           0.1
 * Author:            Seth Johnson
 * Author URI:        https://centerofthewest.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_shortcode( 'BBCW-Virtual-Exhibit','bbcw_virtual_exhibit_shortcode_handler' );

function bbcw_virtual_exhibit_shortcode_handler( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'attr_1' => 'attribute 1 default',
        'attr_2' => 'attribute 2 default',
        // ...etc
    ), $atts );
	
	echo '<pre>',print_r($atts,1),'</pre>';
	echo 'hey';
}

//remember this
/*
function my_shortcode() {
	ob_start();
	?> <HTML> <here> ... <?php
	return ob_get_clean();
}
*/

//very helpful, shows how to add jquery dependency
//https://code.tutsplus.com/articles/how-to-include-javascript-and-css-in-your-wordpress-themes-and-plugins--wp-24321
add_action( 'wp_enqueue_scripts', 'custom_load_custom_style_sheet',100 );
function custom_load_custom_style_sheet() {
//the last number is the version, increment up when changes are made, the third array is dependencies
//this stylesheet loads after genesis and infinity pro
	wp_enqueue_style( 'bbcw-virtual-exhibitor-stylesheet', plugins_url('/css/bbcw-virtual-exhibitor.css',__FILE__), array(), $GLOBALS['rr_custom_plugin_version'] );
	wp_enqueue_script( 'bootstrap', plugins_url('/js/bootstrap.min.js',__FILE__), array( 'jquery' ), $GLOBALS['rr_custom_plugin_version'], true );
}