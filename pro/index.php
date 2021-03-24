<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'plugin_action_links_' . MOMOCASHAPP_PLUGIN_BASENAME , 'cashapp_settings_link' );

if ( ! is_plugin_active( 'wc-cashapp-pro/cashapp.php' ) ) {
	// add_action( 'admin_notices', 'wc_cashapp_pro_available_notice' );
} else {
	deactivate_plugins( MOMOCASHAPP_PLUGIN_BASENAME );
	echo '<div class="notice notice-success is-dismissible"><p>MOMO Cash App has been deactivated because the PRO version is activated. Enjoy the upgrade</p></div>';
}

// Settings Button
function cashapp_settings_link( $links_array ){
	array_unshift( $links_array, '<a href="' .  esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=cashapp', __FILE__ ) ) . '">Settings</a>' );
	
	if( ! is_plugin_active( 'wc-cashapp-pro/cashapp.php' ) ) {
		$links_array['wc_cashapp_pro'] = sprintf('<a href="https://theafricanboss.com/cashapp/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro for $29','wc-cashapp') . '</a>');
	}
	
	return $links_array;
}

function wc_cashapp_pro_available_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>You are currently not using our MOMO Cash App PRO plugin. <strong>Please upgrade for a better experience</strong></p></div>';
}

?>