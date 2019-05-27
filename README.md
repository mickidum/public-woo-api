# Public Woo Api - Wordpress plugin

**Public Woo Api - view on wordpress.org:** https://wordpress.org/plugins/public-woo-api

Allows to fetch WooCommerce products, categories, tags, variations and reviews without authentication.

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
