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
		'margin'=>12,
		'show_title'=>1,
		'background_color'=>'#ede9e7',
		//if this value is set, the exhibit ID will be ignored and the loves for this username instead
		'love_handle'=>false,
		'limit'=>25,
		'show_footer'=>false,
		'new_window'=>false,
		'method'=>'append',
		'debug'=>false
    ), $atts );
	
	if ($a['debug'] && $a['debug'] != 'false') echo '<h3>Before</h3><pre>',print_r($a,1),'</pre>';
	
	if ($a['load_css']==1) wp_enqueue_style( 'bbcw-virtual-exhibitor-stylesheet' );
	if ($a['show_title']==1) $display_title='true';
	else $display_title='false';
	//do some basic error checking
	$error=false;
	if (intval($a['tile_size'])<=0){
		$error.=' tile_size parse error ';
		$a['tile_size']=180;
	}
	if (intval($a['margin'])<=0){
		$error.=' margin parse error ';
		$a['margin']=12;
	}
	if (intval($a['limit'])>100 || intval($a['limit'])<1) $a['limit']=25;
	if ($a['show_footer']) $footer='true';
	else $footer='false';
	if ($a['new_window']) $target='true';
	else $target='false';
	if ($a['love_handle']){
		$type='loved';
		$id=$a['love_handle'];
	}
	else {
		$type='exhibit';
		$id=$a['id'];
	}
	if ($a['method']!='replace' && $a['method']!='append'){
		$error.=' invalid value for method ';
		$method='append';
	}
	else $method=$a['method'];
	
	if ($a['layout']!='grid' && $a['layout']!='list'){
		$error.=' invalid value for layout ';
		$layout='grid';
	}
	else $layout=$a['layout'];

	ob_start();
	?>
	<style>
	<?php //if ($a['layout']=='grid'):?>
	.bbcw-exhibit-item{
		height: <?=intval($a['tile_size'])?>px;
		width: <?=intval($a['tile_size'])?>px;
		background-color: <?=$a['background_color']?>;
		margin: <?=$a['margin']?>px;
	}
	<?php //endif ?>
	<?php if ($a['layout']=='list'):?>
	.bbcw-exhibit-link{
		min-height: <?=intval($a['tile_size'])+($a['margin']*2)?>px;
		height:auto;
	}
	.bbcw-exhibit-item-container.bbcw-exhibit-list {
		margin:<?=intval($a['margin'])?>px;
	}
	.bbcw-exhibit-item-caption.bbcw-exhibit-list>p{
		padding:<?=intval($a['margin'])?>px;
	}
	<?php endif ?>
	</style>
	<script>
	//loadVirtual exhibit params: id/handle, type, layout, selector,limit,title(bool),footer(bool),target(bool),method
	jQuery(document).ready(function(){
		bbcwLoadVirtualExhibit('<?=$id?>','<?=$type?>','<?=$layout?>','<?=$a['selector']?>',<?=intval($a['limit'])?>,<?=$display_title?>,<?=$footer?>,<?=$target?>,'<?=$method?>');

	});
	</script>
	<?php if ($error) echo '<p class="bbcw-exhibit-error">'.$error.'</p>'; ?>
	<?php // if ($a['layout']=='grid'):?>
	
	<div id="bbcw_exhibit_row">
	
	</div>
	<?php  // endif //grid layout ?>
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