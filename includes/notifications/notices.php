<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	add_action( 'admin_notices', 'woocommerce_cashapp_missing_wc_notice' );
}

function woocommerce_cashapp_missing_wc_notice() {
	echo '<div class="error"><p><strong>MOMO Cash App requires WooCommerce to be installed and active.</strong> <a href="' . esc_html(admin_url('plugin-install.php?s=woocommerce&tab=search&type=term')) . '">Download and Activate WooCommerce here</a></p></div>';
	echo '<div class="notice notice-success"><p><strong>MOMO Cash App Plugin has been deactivated.</strong></p></div>';
}

?>