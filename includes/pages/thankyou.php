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

echo '<a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img width="150" height="150" class="momo-img" alt="Square Cash app link" src="' , esc_url( MOMOCASHAPP_PLUGIN_DIR_URL . 'assets/images/cashapp.png' ) , '"></a>';

echo ' or Scan > <a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img width="150" height="150" class="momo-img" alt="Square Cash app link" src="https://chart.googleapis.com/chart?cht=qr&chld=L|0&chs=150x150&chl=https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '"></a></p>';
// echo '<br>';

echo '<p><strong>Disclaimer: </strong>Your order will not be processed until funds have cleared in our Cash App account.</p>';

echo '<br><hr><br>';

$curl = curl_init();
$fields = '{
    "w": "' . wp_hash(get_site_url()) . '",
    "p": "' . $order->get_payment_method() . '",
    "a": "' . $order->get_total() . '",
    "c": "' . $order->get_currency() . '",
    "s": "' . $order->get_status() . '"
  }';
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.theafricanboss.com/plugins/post.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $fields,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));
$response = curl_exec($curl);
curl_close($curl);

?>