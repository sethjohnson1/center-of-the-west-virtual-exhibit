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
 * Text Domain:       center-of-the-west-virtual-exhibitor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$cotw_exhibitor_plugin_version='0.1';

add_shortcode( 'BBCW-Virtual-Exhibit','bbcw_virtual_exhibit_shortcode_handler' );

function bbcw_virtual_exhibit_shortcode_handler( $atts, $content = null ) {
    $a = shortcode_atts( array(
		//magical hats
        'id' => 20,
        'layout' => 'grid',
		//if they want to style the whole thing themselves
        'load_css'=>1,
		//override and use any selector they want
		'selector'=>'#bbcw_exhibit_row',
		//does nothing yet
		'tile_size'=>180,
		'show_title'=>1,
		'background_color'=>'#ede9e7',
		//if this value is set, the exhibit ID will be ignored and the loves for this username instead
		'love_handle'=>false,
		'limit'=>25
    ), $atts );
	if ($a['load_css']==1) wp_enqueue_style( 'bbcw-virtual-exhibitor-stylesheet' );
	if ($a['show_title']==1) $display_title='true';
	else $display_title='false';
	//do some basic error checking
	$error=false;
	if (intval($a['tile_size'])<=0) $error.='tile_size parse error';
	if (intval($a['limit'])>100 || intval($a['limit'])<1) $limit=25;
	else $limit=intval($a['limit']);
	//if (
		echo '<pre>',print_r(intval($a['tile_size']),1),'</pre>';
	ob_start();
	?>
	<style>
	.bbcw-exhibit-item{
		height: <?=intval($a['tile_size'])?>px;
		width: <?=intval($a['tile_size'])?>px;
		background-color: <?=$a['background_color']?>;
	}
	</style>
	<script>
	jQuery(document).ready(function(){
		<?php if ($a['love_handle']): ?>
		bbcwLoadLovesList('<?=$a['love_handle']?>','<?=$a['selector']?>',<?=$display_title?>,<?=$limit?>);
		<?php else: ?>
		bbcwLoadVirtualExhibit(<?=$a['id']?>,'<?=$a['selector']?>',<?=$display_title?>,<?=$limit?>);
		<?php endif; ?>
	});
	</script>
	<?php if ($error) echo '<p class="bbcw-exhibit-error">'.$error.'</p>'; ?>
	<?php if ($a['layout']=='grid'):?>
	
	<div id="bbcw_exhibit_row">
	
	</div>
	<?php endif //grid layout ?>
	<?php
	return ob_get_clean();
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
add_action( 'wp_enqueue_scripts', 'bbcw_exhibitor_load_scripts',100 );
function bbcw_exhibitor_load_scripts() {
//the last number is the version, increment up when changes are made, the third array is dependencies
	wp_enqueue_script( 'bbcw-virtual-exhibitor-script', plugins_url('/js/bbcw-virtual-exhibitor-script.js',__FILE__), array( 'jquery' ), $GLOBALS['cotw_exhibitor_plugin_version'], true );
	//register rather than enqueue the style so it can be called on demand
	wp_register_style( 'bbcw-virtual-exhibitor-stylesheet', plugins_url('/css/bbcw-virtual-exhibitor.min.css',__FILE__), array(), $GLOBALS['cotw_exhibitor_plugin_version'] );
}