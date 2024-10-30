<?php

/*

Plugin Name: Morphii

Plugin URI: https://morphii.com/

Description: A plugin that for adding reviews to your product by adding morphii reactions.

Author: Morphii Team

Text Domain: morphii

Version: 2.0

Author URI: https://morphii.com/

License: GPL2

*/



// don't call the file directly

if ( ! defined( 'ABSPATH' ) ) exit;



if ( ! function_exists( 'is_plugin_active' ) ) {

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

}
if (is_plugin_active('morphii-pro/morphii-init.php') )
	return;
else
{
define( 'MORPHII_DIR', plugin_dir_path( __FILE__ ) );

define( 'MORPHII_MWAR_URL', plugins_url( '/', __FILE__ ) );

define( 'MORPHII_INCLUDE_DIR', MORPHII_DIR . '/includes/' );

define( 'MORPHII_ASSETS_URL', MORPHII_DIR . 'assets' );

define( 'MORPHII_TEMPLATE_PATH', MORPHII_DIR . 'templates' );

define( 'MORPHII_TEMPLATES_DIR', MORPHII_DIR . '/templates/' );

add_action('morphii_start', 'morphii_buffering');

function morphii_buffering()
{
    ob_start();
}

function morphii_init() {

	require_once MORPHII_DIR . 'morphii.php';

	require_once MORPHII_INCLUDE_DIR . 'class.morphii-shortcode.php';

	require_once MORPHII_INCLUDE_DIR . 'class.morphii-data.php';

	global $Morphii_AdvancedReview, $Morphii_Shortcode, $Morphii_Data;

	$Morphii_AdvancedReview = Morphii::get_instance();

	$Morphii_Shortcode = Morphii_Shortcode::get_instance();

	$Morphii_Data = Morphii_Data::get_instance();

}



add_action( 'morphii_init', 'morphii_init' );



function morphii_install() {

	// if ( ! function_exists( 'WC' ) ) {

	// 	add_action( 'admin_notices', 'morphii_install_woocommerce_admin_notice' );

	// } else {

		do_action( 'morphii_init' );

		do_action( 'morphii_start' );

	//}

}

add_action( 'plugins_loaded', 'morphii_install', 11 );

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'morphii_go_pro_link' );

function morphii_go_pro_link( $links ) {

	$links = array_merge($links , array(
		'<a target="_blank" href="https://morphii.com/pro" style="color:green;font-weight:bold">Go Pro</a>'
	));

	return $links;

}
}