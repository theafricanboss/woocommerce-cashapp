<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// if our payment gateway is disabled, we do not have to enqueue JS too
if ( 'no' === $this->enabled ) {
    return;
}

// we need JS or CSS to process a token only on specific pages
if ( is_checkout() ) {
    // Load CSS
    wp_register_style( 'checkout', MOMOCASHAPP_PLUGIN_DIR_URL . 'assets/css/checkout.css' );
    wp_enqueue_style('checkout');
    // return;
}

// we need JS or CSS to process a token only on cart/checkout pages
if ( ! is_cart() || ! is_checkout() || ! isset( $_GET['pay_for_order'] ) ) {
    wp_enqueue_script( 'woocommerce_cashapp' );
    return;
}

?>