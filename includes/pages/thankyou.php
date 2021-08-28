<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $order;
$order = wc_get_order( $order_id );
$amount = $order->get_total();

echo '<h2>Cash App Notice</h2>';

echo '<p><strong style="font-size:large;">Please use your Order Number: ' . $order_id  . ' as the payment reference.</strong></p>';
// echo '<br>';

echo '<p class="momo-cashapp">Click > ';

echo '<a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img style="float: none!important; max-height:150px!important; max-width:150px!important;" alt="Square Cash app link" src="' , esc_url( MOMOCASHAPP_PLUGIN_DIR_URL . 'assets/images/cashapp.png' ) , '"></a>';

echo ' or Scan > <a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img style="float: none!important; max-height:150px!important; max-width:150px!important;" alt="Square Cash app link" src="https://chart.googleapis.com/chart?cht=qr&chld=L|0&chs=150x150&chl=https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '"></a></p>';
// echo '<br>';

echo '<p><strong>Disclaimer: </strong>Your order will not be processed until funds have cleared in our Cash App account.</p>';

echo '<br><hr><br>';

?>