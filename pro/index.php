<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'plugin_action_links_' . MOMOCASHAPP_PLUGIN_BASENAME , 'cashapp_settings_link' );

// Settings Button
function cashapp_settings_link( $links_array ){
	array_unshift( $links_array, '<a href="' .  esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=cashapp', __FILE__ ) ) . '">Settings</a>' );

	if( ! is_plugin_active( 'wc-cashapp-pro/cashapp.php' ) ) {
		$links_array['wc_cashapp_pro'] = sprintf('<a href="https://theafricanboss.com/cashapp/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro for $29','wc-cashapp') . '</a>');
	}

	return $links_array;
}

add_action( 'admin_notices', function () {
	echo '<div class="notice notice-warning is-dismissible"><p>You are currently not using our Checkout with Cash App PRO plugin. <strong>Please <a href="http://theafricanboss.com/cashapp" target="_blank">upgrade</a> for a better experience</strong></p></div>';
});

?>