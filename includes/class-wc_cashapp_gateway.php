<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists ( 'WC_Payment_Gateway' ) ) {

	class wc_cashapp_gateway extends WC_Payment_Gateway {

		public function __construct() {

			$this->id = 'cashapp'; // payment gateway plugin ID
			$this->icon = MOMOCASHAPP_PLUGIN_DIR_URL . 'assets/images/cashapp_35.png'; // URL of the icon that will be displayed on checkout page near your gateway name
			$this->has_fields = true; // in case you need a custom form
			$this->method_title = 'Cash App';
			$this->method_description = 'Easily receive Cash App payments'; // will be displayed on the options page

			$this->init_settings();
			$this->enabled = $this->get_option( 'enabled' );
			$this->title = $this->get_option( 'checkout_title' );
			$this->ReceiverCASHAPPNo = $this->get_option( 'ReceiverCASHAPPNo' );
			$this->ReceiverCASHAPPNoOwner = $this->get_option( 'ReceiverCASHAPPNoOwner' );
			$this->ReceiverCashApp = $this->get_option( 'ReceiverCashApp' );
			$this->ReceiverCashAppOwner = $this->get_option( 'ReceiverCashAppOwner' );
			$this->ReceiverCASHAPPEmail = $this->get_option( 'ReceiverCASHAPPEmail' );
			$this->checkout_description = $this->get_option( 'checkout_description' );
			$this->cashapp_notice = $this->get_option( 'cashapp_notice' );
			$this->store_instructions = $this->get_option( 'store_instructions' );
			$this->display_cashapp = $this->get_option( 'display_cashapp' );
			$this->display_cashapp_logo_button = $this->get_option( 'display_cashapp_logo_button' );
			$this->toggleSupport = $this->get_option( 'toggleSupport' );
			$this->toggleTutorial = $this->get_option( 'toggleTutorial' );
			$this->toggleCredits = $this->get_option( 'toggleCredits' );

			if ( isset( $this->ReceiverCashApp ) ) { $test = ' <a href="https://cash.app/'. esc_attr( wp_kses_post( $this->ReceiverCashApp ) ). '/1" target="_blank">Test</a>'; } else { $test = ''; }

			$this->form_fields = array(
				'enabled' => array(
					'title'       => 'Enable CASHAPP' . $test,
					'label'       => 'Check to Enable / Uncheck to Disable',
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
				'ReceiverCASHAPPNo' => array(
					'title'       => 'Receiver Cash App No',
					'type'        => 'text',
					'description' => 'This is the phone number associated with your store Cash App account or your receiving Cash App account. Customers will send money to this number',
					'placeholder' => "+1234567890",
				),
				'ReceiverCashApp' => array(
					'title'       => 'Receiver Cash App account' . $test,
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
				'checkout_description' => array(
					'title'       => 'Checkout Page Notice <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
					'type'        => 'textarea',
					'description' => 'This is the description which the user sees during checkout. <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">APPLY CHANGES WITH PRO</a>',
					'default'     => 'Send money to $cashtag or click the Cash App button below',
					'css'     => 'width:80%; pointer-events: none;',
					'class'     => 'disabled',
				),
				'cashapp_notice'    => array(
					'title'       => 'Thank You Notice <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
					'type'        => 'textarea',
					'description' => 'Notice that will be added to the thank you page before store instructions if any. <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">APPLY CHANGES WITH PRO</a>',
					'default'     => "<p>We are checking our systems to confirm that we received. If you haven't sent the money already, please make sure to do so now.</p>" .
					'<p>Once confirmed, we will proceed with the shipping and delivery options you chose.</p>' .
					'<p>Thank you for doing business with us! You will be updated regarding your order details soon.</p>',
					'css'     => 'width:80%; pointer-events: none;',
					'class'     => 'disabled',
				),
				'store_instructions'    => array(
					'title'       => 'Store Instructions <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
					'type'        => 'textarea',
					'description' => 'Store Instructions that will be added to the thank you page and emails. <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">APPLY CHANGES WITH PRO</a>',
					'default'     => "Please send the total amount requested to our store if you haven't yet",
					'css'     => 'width:80%; pointer-events: none;',
					'class'     => 'disabled',
				),
				'display_cashapp' => array(
					'title'       => 'Customers place order first before getting Cash App info <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
					'label'       => 'Uncheck to remove Cash App info before placing order / Check to show Cash App info first',
					'type'        => 'checkbox',
					'description' => 'Disable to remove BOTH the Cash App image and QR code from your payment method on checkout. It will still be displayed on the thank you page, email notifications, and customer notes <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">APPLY CHANGES WITH PRO</a>',
					'default'     => 'yes',
					'class'     => 'disabled',
				),
				'display_cashapp_logo_button' => array(
					'title'       => 'Show ONLY the QR code in the payment method on checkout <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
					'label'       => 'Check to show the Cash App logo button / Uncheck to remove the Cash App logo button',
					'type'        => 'checkbox',
					'description' => 'Disable to remove the big Cash App image button in the payment method on checkout <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">APPLY CHANGES WITH PRO</a>',
					'default'     => 'no',
					'class'     => 'disabled',
				),
				'toggleSupport' => array(
					'title'       => 'Enable Support message <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank"><sup style="color:red">PRO</sup></a>',
					'label'       => 'Check to Enable / Uncheck to Disable',
					'type'        => 'checkbox',
					'description' => 'Help your customers checkout with ease by letting them know how to contact you <a style="text-decoration:none" href="https://theafricanboss.com/cashapp/" target="_blank">APPLY CHANGES WITH PRO</a>',
					'default'     => 'yes',
					'class'     => 'disabled',
				),
				'toggleTutorial' => array(
					'title'       => 'Enable Tutorial to display 1min video link',
					'label'       => 'Check to Enable / Uncheck to Disable',
					'type'        => 'checkbox',
					'description' => 'Help your customers checkout with ease by showing this tutorial link',
					'default'     => 'no',
				),
				'toggleCredits' => array(
					'title'       => 'Enable Credits to display Powered by The African Boss',
					'label'       => 'Check to Enable / Uncheck to Disable',
					'type'        => 'checkbox',
					'description' => 'Help us spread the word about this plugin by sharing that we made this plugin',
					'default'     => 'no',
				),
			);

			// Gateways can support subscriptions, refunds, saved payment methods
			$this->supports = array('products');

			// This action hook saves the settings
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

			// We need custom JavaScript to obtain a token
			add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );

			// Thank you page
			add_action( 'woocommerce_thankyou_cashapp', array( $this, 'thankyou_page' ) );

			// Customer Emails
			add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );

		}

		//Checkout page
		public function payment_fields () {
			require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/pages/checkout.php';
		}

		//Payment Custom JS and CSS
		public function payment_scripts() {
			require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/functions/payment_scripts.php';
		}

		//Thank you page
		public function thankyou_page( $order_id ) {
			global $woocommerce, $order;
			$order = wc_get_order( $order_id );
			if ( 'cashapp' === $order->get_payment_method() ) {
				require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/pages/thankyou.php';
			}
		}

		//Add content to the WC emails
		public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
			if ( ! $sent_to_admin && 'on-hold' === $order->get_status() && 'cashapp' === $order->get_payment_method() ) {
				require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/notifications/email.php';
			}
		}

		//Process Order
		public function process_payment( $order_id ) {
			global $woocommerce, $order;
			$order = wc_get_order( $order_id );

			if( ! is_wp_error($order) ) {

				// Mark as on-hold (we're awaiting the payment).
				$order->update_status( apply_filters( 'woocommerce_cashapp_process_payment_order_status', 'on-hold', $order ), __( 'Checking for payment', 'woocommerce' ) );

				if ( 'cashapp' === $order->get_payment_method() ) {
					require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/notifications/note.php';
				}

				// reduce inventory
				$order->reduce_order_stock();

				// Empty cart
				$woocommerce->cart->empty_cart();

				// Redirect to the thank you page
				return array( 'result' => 'success', 'redirect' => $this->get_return_url( $order ) );

			} else {
				wc_add_notice(  'Connection error.', 'error' );
				return;
			}

		}

		//Webhook
		public function webhook() {
			require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/functions/webhook.php';
		}

	}

} else {
	deactivate_plugins( MOMOCASHAPP_PLUGIN_BASENAME );
	require_once MOMOCASHAPP_PLUGIN_DIR . 'includes/notifications/notices.php';
}
?>