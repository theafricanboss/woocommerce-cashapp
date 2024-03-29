<?php
/*
 * Plugin Name: Checkout with Cashapp on WooCommerce
 * Plugin URI: https://theafricanboss.com/cashapp
 * Description: The #1 finance app in the App Store now on WordPress. Receive Cash App payments on your website with WooCommerce + Cash App
 * Author: The African Boss
 * Author URI: https://theafricanboss.com
 * Version: 3.4
 * WC requires at least: 4.0.0
 * WC tested up to: 5.9.0
 * Created: 2020
 * Copyright 2021 theafricanboss.com All rights reserved
 */

// Reach out to The African Boss for website and mobile app development services at theafricanboss@gmail.com
// or at www.TheAfricanBoss.com or download our app at www.TheAfricanBoss.com/app

// If you are using this version, please send us some feedback
// via email at theafricanboss@gmail.com on your thoughts and what you would like improved

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . 'wp-includes/pluggable.php');

define('MOMOCASHAPP_PLUGIN_DIR', plugin_dir_path(__FILE__) );
define('MOMOCASHAPP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define('MOMOCASHAPP_PLUGIN_DIR_URL', plugins_url( '/' , __FILE__ ));
define('MOMOCASHAPPPRO_PLUGIN_DIR', plugin_dir_path( 'wc-cashapp-pro' ) );

if( ! is_plugin_active ( 'woocommerce/woocommerce.php' ) ){
	deactivate_plugins( MOMOCASHAPP_PLUGIN_BASENAME );
	require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/notifications/notices.php';
}

if ( current_user_can( 'manage_options' ) ) {

	add_action( 'admin_enqueue_scripts', function () {
		$currentScreen = get_current_screen();
		// var_dump($currentScreen);
		if ($currentScreen->id == 'cashapp_page_momo_cashapp_recommended_menu_page' || $currentScreen->id == 'cashapp_page_momo_cashapp_tutorials_menu_page' ) {
			wp_register_style( 'bootstrap', MOMOCASHAPP_PLUGIN_DIR_URL . 'assets/css/bootstrap.min.css');
			wp_enqueue_style( 'bootstrap' );
		} else {
			return;
		}
	});


	if ( is_plugin_active( 'wc-cashapp-pro/cashapp.php' ) ) {
		deactivate_plugins( MOMOCASHAPP_PLUGIN_BASENAME );
		activate_plugin( 'wc-cashapp-pro/cashapp.php');
		wp_die( '<div><p>Checkout with Cashapp has been deactivated because the PRO version is activated.
		<strong>Enjoy the upgrade</strong></p></div>
		<div><a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=cashapp' ) . '">Set up the plugin</a> | <a href="' . admin_url('plugins.php') . '">Return</a></div>' );
	}

	include_once MOMOCASHAPP_PLUGIN_DIR . 'pro/index.php';
	require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/admin/dashboard.php';
}

add_filter( 'woocommerce_payment_gateways', 'cashapp_add_gateway_class' );
add_action( 'plugins_loaded', 'cashapp_init_gateway_class' );


//This action hook registers our PHP class as a WooCommerce payment gateway
function cashapp_add_gateway_class( $gateways ) {
	$gateways[] = 'wc_cashapp_gateway'; // your class name is here
	return $gateways;
}

//The class itself, please note that it is inside plugins_loaded action hook
function cashapp_init_gateway_class() {
	require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/class-wc_cashapp_gateway.php';
}

?>