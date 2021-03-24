<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$order = wc_get_order( $_GET['id'] );
$order->payment_complete();
update_option('webhook_debug', $_GET);

?>