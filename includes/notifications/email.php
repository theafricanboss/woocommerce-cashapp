<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo '<p>Send <a style="color:green" href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '" target="_blank">the requested total to ', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '</a> or click the Cash App button below</p>';

echo '<p><a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '" target="_blank"><img width="150" height="150" alt="Square Cash app link" src="' , esc_url( MOMOCASHAPP_PLUGIN_DIR_URL . 'assets/images/cashapp.png' ) , '"></a></p>'; //https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Square_Cash_app_logo.svg/512px-Square_Cash_app_logo.svg.png

?>