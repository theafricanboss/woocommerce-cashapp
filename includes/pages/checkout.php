<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce, $total, $amount;
$woocommerce->cart->get_cart();
$total = $woocommerce->cart->get_total();
$amount = $woocommerce->cart->total;

echo '<fieldset id="wc-' . esc_attr( $this->id ) . 'form" style="padding:3%">';

// Add this action hook if you want your custom payment gateway to support it
do_action( 'woocommerce_form_start', $this->id );

echo '<p>Send <a style="color:green" href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank">' , $total , ' to ', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '</a> or click/scan the Cash App button below</p>';
// echo '<br>';

echo '<p>Please <strong style="font-size:large;">use your Order Number (available once you place order)</strong> as the payment reference.</p>';
// echo '<br>';

echo '<p>Click > ';

echo '<a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img style="float: none!important; max-height:100px!important; max-width:100px!important;" alt="Square Cash app link" src="' , esc_url( MOMOCASHAPP_PLUGIN_DIR_URL . 'assets/images/cashapp.png' ) , '"></a>';

echo ' or Scan > <a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img style="float: none!important; max-height:100px!important; max-width:100px!important;" alt="Square Cash app link" src="https://chart.googleapis.com/chart?cht=qr&chld=L|0&chs=100x100&chl=https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '"></a></p>';
// echo '<br>';

echo '<p><strong>After paying, please come back here and place the order</strong> below so we can receive shipping and delivery options.</p>';
// echo '<br>';
	
// if cashapp number is provided, we show it
if ( '' === $this->ReceiverCASHAPPNo ) {
	$call = '';
} else {
	$call = 'call <a href="tel:' . esc_html( wp_kses_post($this->ReceiverCASHAPPNo)) . '" target="_blank">' . esc_html( wp_kses_post($this->ReceiverCASHAPPNo)) . '</a>.';
}

// if email address is provided, we show it
if ( '' === $this->ReceiverCASHAPPEmail ) {
	$email = '';
} else {
	$email = ' You can also email <a href="mailto:' . esc_html( wp_kses_post($this->ReceiverCASHAPPEmail)) . '" target="_blank">' . esc_html( wp_kses_post($this->ReceiverCASHAPPEmail)) . '</a>';
}

echo '<p>If you are having an issue, please ' , $call , $email , '</p>';
// echo '<br>';

// if toggle Tutorial is disabled, we do not show credits
if ( 'no' === $this->toggleTutorial ) {
	// echo '<br>';
} else {
	echo '<p>See this <a href=' . esc_url("https://theafricanboss.com/cashappdemo") . ' style="text-decoration: underline" target="_blank">1min video demo</a> explaining how this works.</p>';
	// echo '<br>';
}

// if toggle Credits is disabled, we do not show credits
if ( 'no' === $this->toggleCredits ) {
	// echo '<br>';
} else {
	echo '<p><a href=' . esc_url("https://theafricanboss.com/cashapp") . ' style="text-decoration: underline;" target="_blank">Powered by The African Boss</a></p>';
	// echo '<br>';
}

do_action( 'woocommerce_form_end', $this->id );

echo '<div class="clear"></div></fieldset>';

?>