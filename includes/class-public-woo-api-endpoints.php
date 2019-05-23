<?php

/**
 * mywoo class
 */

use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

class Public_Woo_Api_Endpoints
{
	
	protected $woocommerce;
	protected $endpoint;

	public function __construct( $consumer_key, $consumer_secret, $endpoint = null )
	{
		if ($endpoint) {
			$this->endpoint = $endpoint;
		} else {
			$this->endpoint = 'public-woo/v1';
		}
		
		$this->woocommerce = new Client(
	    get_site_url(),
	    $consumer_key,
	    $consumer_secret,
	    [
	        'version' => 'wc/v3',
	        'verify_ssl' => false
	    ]
		);
		add_action( 'rest_api_init', array($this, 'register_public_woo_routes') );
	}

	public function register_public_woo_routes() {
    register_rest_route( $this->endpoint, '/products', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products')
    ));

    register_rest_route( $this->endpoint, '/products'. '/(?P<id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_product')
    ));
	}

	public function view_products($request) {
		
		$filters = $request->get_query_params();
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$products = $this->woocommerce->get( 'products', $filters );
			return $products;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_product( $request ) {
		$id = $request->get_param('id');
		try {
			$product = $this->woocommerce->get( 'products/' . $id);
			return $product;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}
}