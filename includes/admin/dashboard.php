<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Dashboard Menu Button
 */
function cashapp_admin_menu(){
	$parent_slug = 'wc-settings&tab=checkout&section=cashapp';
	$capability = 'manage_options';

	add_menu_page( null, 'CASHAPP', $capability , $parent_slug, 'cashapp_admin_menu', 'dashicons-money-alt' );
	add_submenu_page( $parent_slug , 'Upgrade CASHAPP' , '<span style="color:#99FFAA">Go Pro >> </span>' , $capability  , 'https://theafricanboss.com/cashapp' , null, null );
	add_submenu_page( $parent_slug , 'Feature my store' , 'Get Featured' , $capability  , 'https://theafricanboss.com/cashapp#feature' , null, null );
	add_submenu_page( $parent_slug , 'Review CASHAPP' , 'Review' , $capability  , 'https://wordpress.org/support/plugin/wc-cashapp/reviews/?filter=5' , null, null );
	add_submenu_page( $parent_slug , 'Recommended' , 'Recommended' , $capability  , 'momo_cashapp_recommended_menu_page' , 'momo_cashapp_recommended_menu_page', null );
	add_submenu_page( $parent_slug , 'Tutorials' , 'Tutorials' , $capability  , 'momo_cashapp_tutorials_menu_page' , 'momo_cashapp_tutorials_menu_page', null );
	// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, callable $function = '', int $position = null )
}
add_action('admin_menu','cashapp_admin_menu');

function momo_cashapp_recommended_menu_page() {
	require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/admin/recommended.php';
}

function momo_cashapp_tutorials_menu_page() {
	require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/admin/tutorials.php';
}

?>