<?php
/*
 * Plugin Name: MOMO Cashapp
 * Plugin URI: https://theafricanboss.com/cashapp
 * Description: The #1 finance app in the App Store now on WordPress. Receive Cash App payments on your website with WooCommerce + Cash App
 * Author: The African Boss
 * Author URI: https://theafricanboss.com
 * Version: 2.2
 * WC requires at least: 3.0.0
 * WC tested up to: 4.9.1
 * Version Date: Jan 14, 2020
 * Created: 2020
 * Copyright 2020 theafricanboss.com All rights reserved
 */
 
// Reach out to The African Boss for website and mobile app development services at theafricanboss@gmail.com
// or at www.TheAfricanBoss.com or download our app at www.TheAfricanBoss.com/app

// If you are using this version, please send us some feedback
// via email at theafricanboss@gmail.com on your thoughts and what you would like improved

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce fallback notice.
 * @return string
 */
function woocommerce_cashapp_missing_wc_notice() {
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Cash App requires WooCommerce to be installed and active. You can download %s here.', 'wc_cashapp_gateway' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}

/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'cashapp_add_gateway_class' );
function cashapp_add_gateway_class( $gateways ) {
	$gateways[] = 'wc_cashapp_gateway'; // your class name is here
	return $gateways;
}

/*
 * Dashboard Menu Button
 */
function cashapp_admin_menu(){
	add_menu_page( null, 'CASHAPP', 'manage_options', 'wc-settings&tab=checkout&section=cashapp', 'cashapp_admin_menu', 'dashicons-money-alt' );
	add_submenu_page( 'wc-settings&tab=checkout&section=cashapp' , 'Upgrade CASHAPP' , '<span style="color:#99FFAA">Go Pro >> </span>' , 'manage_options' , 'https://theafricanboss.com/cashapp' , null, null );
	add_submenu_page( 'wc-settings&tab=checkout&section=cashapp' , 'Feature my store' , 'Get Featured' , 'manage_options' , 'https://theafricanboss.com/cashapp#feature' , null, null );
	add_submenu_page( 'wc-settings&tab=checkout&section=cashapp' , 'Review CASHAPP' , 'Review' , 'manage_options' , 'https://wordpress.org/support/plugin/wc-cashapp/reviews/?filter=5' , null, null );
}
add_action('admin_menu','cashapp_admin_menu');

/*
 * Settings Button
 */
function cashapp_settings_link( $links_array ){
	array_unshift( $links_array, '<a href="' .  esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=cashapp', __FILE__ ) ) . '">Settings</a>' );

	if( !is_plugin_active( esc_url( plugins_url( 'wc-cashapp-pro/cashapp.php', dirname(__FILE__) ) ) ) ){
		$links_array['wc_cashapp_pro'] = sprintf('<a href="https://theafricanboss.com/cashapp/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro for $29','wc-cashapp') . '</a>');
	}
	
	return $links_array;
}
$plugin = plugin_basename(__FILE__); 
add_filter( "plugin_action_links_$plugin", 'cashapp_settings_link' );


/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'cashapp_init_gateway_class' );
function cashapp_init_gateway_class() {
    
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'woocommerce_cashapp_missing_wc_notice' );
		return;
	}

	class wc_cashapp_gateway extends WC_Payment_Gateway {

	/**
	 * Class constructor
	 */
	public function __construct() {
	$this->id = 'cashapp'; // payment gateway plugin ID
	$this->icon = ''; // URL of the icon that will be displayed on checkout page near your gateway name
	$this->has_fields = true; // in case you need a custom form
	$this->method_title = 'Cash App';
	$this->method_description = 'Easily receive Cash App payments'; // will be displayed on the options page

	// gateways can support subscriptions, refunds, saved payment methods
	$this->supports = array(
		'products'
	);


	// Method with all the options fields
	$this->init_form_fields();

	// Load the settings.
	$this->init_settings();
	$this->enabled = $this->get_option( 'enabled' );
	$this->title = $this->get_option( 'checkout_title' );
	$this->ReceiverCASHAPPNo = $this->get_option( 'ReceiverCASHAPPNo' );
	$this->ReceiverCASHAPPNoOwner = $this->get_option( 'ReceiverCASHAPPNoOwner' );
	$this->ReceiverCashApp = $this->get_option( 'ReceiverCashApp' );
	$this->ReceiverCashAppOwner = $this->get_option( 'ReceiverCashAppOwner' );
	$this->ReceiverCASHAPPEmail = $this->get_option( 'ReceiverCASHAPPEmail' );
	$this->checkout_description = $this->get_option( 'checkout_description' );
	$this->store_instructions = $this->get_option( 'store_instructions' );
	$this->cashapp_notice = $this->get_option( 'cashapp_notice' );
	$this->toggleTutorial = $this->get_option( 'toggleTutorial' );
	$this->toggleCredits = $this->get_option( 'toggleCredits' );

	// This action hook saves the settings
	add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

	// We need custom JavaScript to obtain a token
	add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );

	//Thank you page
	add_action( 'woocommerce_before_thankyou', array( $this, 'thankyou_page' ) );

	// Customer Emails.
	add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
			
	}

		
	/**
	 * Plugin options
	 */
	public function init_form_fields(){
	$this->form_fields = array(
		'enabled' => array(
			'title'       => 'Enable CASHAPP',
			'label'       => 'Check to Enable/Uncheck to Disable',
			'type'        => 'checkbox',
			'default'     => 'no'
		),
		'checkout_title' => array(
			'title'       => 'Checkout Title',
			'type'        => 'text',
			'description' => 'This is the title which the user sees on the checkout page.',
			'default'     => 'CashApp',
			'placeholder' => 'CashApp',
		),
		'checkout_description' => array(
			'title'       => 'Checkout Page Notice <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
			'type'        => 'textarea',
			'description' => 'This is the description which the user sees during checkout. <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">EDIT WITH PRO</a>',
			'default'     => 'Send money to $cashtag or click the Cash App button below',
			'css'     => 'width:80%; pointer-events: none;',
			'class'     => 'disabled',
		),
		'ReceiverCASHAPPNo' => array(
			'title'       => 'Receiver Cash App No',
			'type'        => 'text',
			'description' => 'This is the phone number associated with your store Cash App account or your receiving Cash App account. Customers will send money to this number',
			'placeholder' => "+1234567890",
		),
		'ReceiverCashApp' => array(
			'title'       => 'Receiver Cash App account',
			'type'        => 'text',
			'description' => 'This is the Cash App account associated with your store Cash App account. Customers will send money to this Cash App account',
			'default'     => '$',
			'placeholder' => '$cashId',
		),
		'ReceiverCashAppOwner' => array(
			'title'       => "Receiver Cash App Owner's Name",
			'type'        => 'text',
			'description' => 'This is the name associated with your store Cash App account. Customers will send money to this Cash App account name',
			'placeholder' => 'Jane D',
		),
		'ReceiverCASHAPPEmail' => array(
			'title'       => "Receiver Cash App Owner's Email",
			'type'        => 'text',
			'description' => 'This is the email associated with your store Cash App account or your receiving Cash App account. Customers will send money to this email',
			'default'     => "@gmail.com",
			'placeholder' => "email@website.com",
		),
		'store_instructions'    => array(
			'title'       => 'Store Instructions <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
			'type'        => 'textarea',
			'description' => 'Store Instructions that will be added to the thank you page and emails. <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">EDIT WITH PRO</a>',
			'default'     => "Please send the total amount requested to our store if you haven't yet",
			'css'     => 'width:80%; pointer-events: none;',
			'class'     => 'disabled',
		),
		'cashapp_notice'    => array(
			'title'       => 'Thank You Notice <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
			'type'        => 'textarea',
			'description' => 'Notice that will be added to the thank you page before store instructions if any. <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">EDIT WITH PRO</a>',
			'default'     => "<p>We are checking our systems to confirm that we received. If you haven't sent the money already, please make sure to do so now.</p>" . 
			'<p>Once confirmed, we will proceed with the shipping and delivery options you chose.</p>' . 
			'<p>Thank you for doing business with us! You will be updated regarding your order details soon.</p>',
			'css'     => 'width:80%; pointer-events: none;',
			'class'     => 'disabled',
		),
		'toggleTutorial' => array(
			'title'       => 'Enable Tutorial to display 1min video link',
			'label'       => 'Check to Enable/Uncheck to Disable',
			'type'        => 'checkbox',
			'description' => 'Help your customers checkout with ease by showing this tutorial link',
			'default'     => 'no',
		),
		'toggleCredits' => array(
			'title'       => 'Enable Credits to display Powered by The African Boss',
			'label'       => 'Check to Enable/Uncheck to Disable',
			'type'        => 'checkbox',
			'description' => 'Help us spread the word about this plugin by sharing that we made this plugin',
			'default'     => 'no',
		),
	);
			
	}
		
		
	/**
	 * Custom form 
	 */
	public function payment_fields () {
		global $woocommerce, $total, $amount;
		
		$woocommerce->cart->get_cart();
		$total = $woocommerce->cart->get_total();
		$amount = $woocommerce->cart->total;
		
		echo '<fieldset id="wc-' . esc_attr( $this->id ) . 'form" style="padding:3%">';

		// Add this action hook if you want your custom payment gateway to support it
		do_action( 'woocommerce_form_start', $this->id );
			
		echo '<p>Send ' , $total , ' to <a style="color:green" href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank">', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '</a> or click the Cash App button below</p><br>';
			
		echo '<p>Click > <a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img style="float: none!important; max-height:150px!important"  width="150" height="150" alt="Square Cash app link" src="' ,  esc_url( plugins_url( 'cashapp.png', __FILE__ ) ), '"></a> or Scan > <a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '" target="_blank"><img style="float: none!important; max-height:150px!important"  width="150" height="150" alt="Square Cash app link" src="https://chart.googleapis.com/chart?cht=qr&chld=L|0&chs=150x150&chl=https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $amount  ) ), '"></a></p><br>';
			
		echo '<p>Once done, <strong>come back to this page</strong>, and place the order below so we can receive shipping and delivery options.</p><br>';

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
		
		echo 'If you are having an issue, please ' , $call , $email ;
		
		echo '<div class="clear"></div>';
			
		// if toggle Tutorial is disabled, we do not show credits
		if ( 'no' === $this->toggleTutorial ) {
			echo '<br>';
		} else {
			echo '<br>See this <a href=' . esc_url("https://theafricanboss.com/cashappdemo") . ' style="text-decoration: underline" target="_blank">1min video demo</a> explaining how this works. <br>';
		}
		
		// if toggle Credits is disabled, we do not show credits
		if ( 'no' === $this->toggleCredits ) {
			echo '<br>';
		} else {
			echo '<br><br> <a href=' . esc_url("https://theafricanboss.com/cashapp") . ' style="text-decoration: underline;" target="_blank">Powered by The African Boss</a><br>';
		}

		do_action( 'woocommerce_form_end', $this->id );

		echo '<div class="clear"></div></fieldset>';
	}

	/*
	* Payment Custom JS and CSS
	*/
	public function payment_scripts() {

		// we need JavaScript to process a token only on cart/checkout pages, right?
		if ( ! is_cart() && ! is_checkout() && ! isset( $_GET['pay_for_order'] ) ) {
			return;
		}

		// if our payment gateway is disabled, we do not have to enqueue JS too
		if ( 'no' === $this->enabled ) {
			return;
		}

		wp_enqueue_script( 'woocommerce_cashapp' );

	}


	public function thankyou_page( $order_id ) {
		
			$order = wc_get_order( $order_id );
		
			$total = $order->get_total();
			
    		if ( 'cashapp' === $order->get_payment_method() ) {
		    
    		echo '<h2>Cash App Notice</h2><p>Send the requested total to <a style="color:green" href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $total  ) ), '" target="_blank">', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '</a> or click the Cash App button below</p>';
    
			echo '<p>Click > <a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $total  ) ), '" target="_blank"><img style="float: none!important; max-height:150px!important"  width="150" height="150" alt="Square Cash app link" src="' ,  esc_url( plugins_url( 'cashapp.png', __FILE__ ) ), '"></a> or Scan > <a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $total  ) ), '" target="_blank"><img style="float: none!important; max-height:150px!important"  width="150" height="150" alt="Square Cash app link" src="https://chart.googleapis.com/chart?cht=qr&chld=L|0&chs=150x150&chl=https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '/' , esc_attr( wp_kses_post( $total  ) ), '"></a></p><br>';

    
    		if ( $this->store_instructions ) {
    			echo '<h2>Store Instructions</h2>';
    			echo 'Here are some additional store instructions: <br>' , "Please send the total amount requested to our store if you haven't yet" , '<br><hr><br>';
    		}
		
		}
	}

	/**
	 * Add content to the WC emails.
	 *
	 * @param WC_Order $order Order object.
	 * @param bool     $sent_to_admin Sent to admin.
	 * @param bool     $plain_text Email format: plain text or HTML.
	 */
	public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
		
		if ( ! $sent_to_admin && 'cashapp' === $order->get_payment_method() ) {

			echo '<p>Send the requested total to <a style="color:green" href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '" target="_blank">', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '</a> or click the Cash App button below</p>';
	
			echo '<p><a href="https://cash.app/', esc_attr( wp_kses_post( $this->ReceiverCashApp ) ), '" target="_blank"><img width="150" height="150" alt="Square Cash app link" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Square_Cash_app_logo.svg/512px-Square_Cash_app_logo.svg.png"></a></p>';

			if ( $this->store_instructions ) {
				echo 'Here are some additional store instructions: <br>' , "Please send the total amount requested to our store if you haven't yet";
			}
			
		}

	}
		
		
	/*
	* Process Payment
	*/
	public function process_payment( $order_id ) {
		global $woocommerce, $total;
		
		// we need it to get any order details
		$order = wc_get_order( $order_id );

		$woocommerce->cart->get_cart();
		$total = $woocommerce->cart->get_total();
		
		
		if( !is_wp_error($order) ) {

			// reduce inventory
			$order->reduce_order_stock();
			
			$note = 'Your order was received!'.'<br><br>'.
				'We are checking our Cash App to confirm that we received the <strong style="text-transform:uppercase;">' . $total . '</strong> you sent so we can proceed with the shipping and delivery options you chose.'.'<br><br>'.
				'Thank you for doing business with us!<br> You will be updated regarding your order details soon<br>'.
				'Kindest Regards,<br>'.
				'Store Assistant';

			// some notes to customer (replace true with false to make it private)
			$order->add_order_note( $note , true );
			
			// Mark as on-hold (we're awaiting the payment).
			$order->update_status( apply_filters( 'woocommerce_cashapp_process_payment_order_status', 'on-hold', $order ), __( 'Checking for payment', 'woocommerce' ) );
			
			// Empty cart
			$woocommerce->cart->empty_cart();

			// Redirect to the thank you page
			return array( 'result' => 'success', 'redirect' => $this->get_return_url( $order ) );

		} else {
			wc_add_notice(  'Connection error.', 'error' );
			return;
		}
		
	}
		
		public function webhook() {
			$order = wc_get_order( $_GET['id'] );
			$order->payment_complete();
			$order->reduce_order_stock();
			
			update_option('webhook_debug', $_GET);
		}
	}
	
}

// Reach out to The African Boss for website and mobile app development services at theafricanboss@gmail.com
// or at www.TheAfricanBoss.com or download our app at www.TheAfricanBoss.com/app

// If you are using this version, please send us some feedback
//via email at theafricanboss@gmail.com on your thoughts and what you would like improved