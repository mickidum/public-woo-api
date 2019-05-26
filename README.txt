=== Public Woo Api ===
Contributors: mickidum
Donate link: https://mickidum.github.io
Tags: WooCommerce REST API, woocommerce rest api, pwa, progressive web apps, react, redux, vue, angular, android, iOS, convert to app, create e-commerce app, mobile woocommerce app, woocommerce to mobile app, woocommerce app, wp-api, wc-api
Requires PHP: 5.6
Requires at least: 4.8
Tested up to: 5.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
WC requires at least: 3.0
WC tested up to:      3.6

Allows to fetch WooCommerce products, categories, tags, variations and reviews without authentication.

== Description ==

Allows to fetch WooCommerce products, categories, tags, variations and reviews without authentication.

**Support and Requests in Github:** https://github.com/mickidum/public-woo-api

### This plugin supports:

* products
* categories
* tags
* variations
* reviews

All requests support only GET method.

To find all possible parameters follow documentation: [WooCommerce Rest Api V3](https://woocommerce.github.io/woocommerce-rest-api-docs).

### REQUIREMENTS

#### WooCommerce REST API V3

This plugin uses A PHP wrapper for the WooCommerce REST API [WooCommerce API - PHP Client](https://github.com/woocommerce/wc-api-php) for interact with the WooCommerce REST API.

### CONFIGURATION

* Go to the WooCommerce/Settings/Advanced/REST API
* Click "Add key"
* Generate your keys with permissions read only
* Go to Tools/Public Woo Options
* Insert generated keys to the form
* If you want you can change base Rest Api Endpoint(default is public-woo/v1)
* After save full url will appear above the form

== Screenshots ==

1. Plugin Settings

== Frequently Asked Questions ==

= Documentation =

Full documentation is available here: [WooCommerce Rest Api V3](https://woocommerce.github.io/woocommerce-rest-api-docs)

= Which endpoints I can use?

products, categories, tags, variations and reviews without authentication

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'public-woo-api'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select 'public-woo-api.zip' from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

== Changelog ==

= 1.0.0 =
* Initial Release.

== Upgrade Notice ==
.