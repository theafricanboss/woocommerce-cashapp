=== Checkout with Cashapp on WooCommerce ===
Contributors: theafricanboss
Donate Link: https://theafricanboss.com
Tags: cashapp, cash app, finance, payments, money, transfer, receive, send, money transfer, usa, mobile money, cash, momo, woocommerce
Requires at least: 4.0
Tested up to: 5.8
Stable tag: trunk
Requires PHP: 5.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

The #1 finance app in the App Store now available on WordPress. Receive Cash App payments on your website with WooCommerce + Cash App

== Description ==

**MOMO Cashapp is now Checkout with Cashapp on WooCommerce**

> If using the PRO version, deactivate this plugin first.

For more details about this woocommerce extension, **please visit [The African Boss](https://theafricanboss.com/cashapp)**

See available screenshots or the store example of [Gura Stores](https://gurastores.com/test/) for visual details.

= PRO or customized version =

Please reach out to theafricanboss@gmail.com for a custom version of this plugin.

Visit [The African Boss](https://theafricanboss.com/cashapp) for more details

= Demo =

An example of the plugin in use is the following store:

[Gura Stores](https://gurastores.com/test/)

This plugin displays a Cash App link

See the screenshots or the store example of [Gura Stores](https://gurastores.com/test/) for visual details.

== Installation ==

= From Dashboard ( WordPress admin ) =

- Go to Plugins -> Add New
- Search for ‘Checkout with Cashapp’
- Click on Install Now
- Activate the plugin through the “Plugins” menu in WordPress.

= Using cPanel or FTP =

- Download ‘Checkout with Cashapp’ from [The African Boss](https://theafricanboss.com/cashapp)
- Unzip wc-cashapp.zip’ file and
- Upload wc-cashapp folder to the “/wp-content/plugins/” directory.
- Activate the plugin through the “Plugins” menu in WordPress.

= After Plugin Activation =

Find and click Cash App in your admin dashboard left sidebar to access Cash App settings

**or**

Go to Woocommerce-> Settings-> Payments screen to configure the plugin

Also _you can visit_ the [plugin page](https://theafricanboss.com/cashapp) for further setup instructions.

== Frequently Asked Questions ==

= Does Cash App integrate Payment APIs? =

Cash App plugin is a quick and easy way to display to your customers your CashTag and to link them to it.
Unfortunately, this plugin doesn't integrate a full CashApp end-to-end payment. It only displays your cashtag to the customer and redirects them to it so that the off site Cash App transaction can take place.
Please check screenshots for more details on what is reported.

== Screenshots ==

1. This is what the customer visiting your website will see at the checkout page
2. This is what you will submit when setting up the plugin and this information will be displayed to your customers
3. This is what the customer visiting your website will see on the thank you page after placing the order

== Changelog ==

= 3.2 August 27, 2021 =

- Added test button to settings page to see what customers see when they click the button or run the QR code
- Sharing payment methods with free versions to keep data across
- Fixed 'if functions for on-hold and check payment methods' placement
- Improved deactivate free plugins when PRO activated
Smooth upgrade from free to PRO
- PRO invitation admin notice when using free plugin
- Fixed bootstrap CSS enqueued on menu pages
- Added .momo-*** class to checkout CSS to apply custom CSS to payment icons and QR codes
Removed content from assets/css/checkout that was forcing 35px size on some themes
Added important height to force 100px in size of QR code and buttons on checkout and thank you page
Added setup plugin link to wp_die when upgrading from free to PRO plugin
- Better settings links on plugins page
- Better installation instructions
- renamed PRO versions to [payment_name PRO]
- Added free and paid recommended menus in sidebar with colors
- Fixed menu buttons in PRO plugin
- Updated WP and WC compatibility

= 3.1 June 1, 2021 =

- Only send email with cashapp link when order is on hold
- Cashapp checkout icon resized
- Plugin name changed from MOMO Cashapp to 'Checkout with Cashapp on WooCommerce'
- Send specific notices while awaiting payment with $order->get_status() &&  $order->get_payment_method()
- Updated WP and WC compatibility

= 3.0 Mar 1, 2021 =

- Refactored entire plugin structure (Going from a single file to multiple folders like admin, functions, notifications, pages, languages, and more)
- Now you can choose to show Cash App information after customers place order in PRO (Feature requested by a user - Orion Technologies)
- Added 3 New PRO functionalities and fields in plugin settings (display_cashapp, display_cashapp_logo_button, toggleSupport)
- Added new pages (tutorials, help, recommended plugins, etc)
- Updated the function to deactivate plugin when Woocommerce is not found
- Updated the function to deactivate plugin when PRO is active
- Better notices and warnings for different actions especially involving PRO
- Better use of global variables with define() function
- Deactivate plugin very early on when needed
- Updated compatibility with WP v5.7
- Updated compatibility with WC v5.0

= 2.2 Jan 14, 2021 =

- Added QR code
- Updated compatibility with WP v5.6

= 2.1 Dec 1, 2020 =

- Fixed cashapp icon styles on some themes where it was floating
- Fixed thank you page and email total amount
- Removed email from author
- Calling file locations and directories according to WP docs
- Added Go PRO button
- Added Get featured button
- Cleaned up the extra fields in the cashapp settings
- Now requiring PHP version starting at 5.0

= 2.0 Oct 1, 2020 =

- Fixed cashapp icon link that was not displaying icon properly
- Fixed cashapp link total amount
- Added new fields in cashapp settings: checkout instructions, store instructions, and thank you notice
- Added new links for PRO version
- Added review and upgrade buttons to admin dashboard
- Now requiring PHP version starting at 5.0

= 1.0 Aug 1, 2020 =

- Added cashapp icon on checkout with link
- Added fields in admin dashboard for cashapp plugin

<?php code();?>
