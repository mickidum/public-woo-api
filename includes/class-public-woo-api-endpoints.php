<?php

/**
 * Public_Woo_Api_Endpoints class
 * Here is all enpoints with their callback functions
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
	        'verify_ssl' => false,
	        'query_string_auth' => true
	    ]
		);
		add_action( 'rest_api_init', array($this, 'register_public_woo_routes') );
	}

	public function register_public_woo_routes() {
    register_rest_route( $this->endpoint, '/products', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products' . '/(?P<id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_product'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products' . '/(?P<id>[\d]+)' . '/variations', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_product_variations'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products' . '/(?P<id>[\d]+)' . '/variations' . '/(?P<v_id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_product_variation'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products/categories', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products_categories'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products/categories' . '/(?P<id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products_category'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products/tags', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products_tags'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products/tags' . '/(?P<id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products_tag'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products/reviews', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products_reviews'),
        'permission_callback' => '__return_true',
    ));

    register_rest_route( $this->endpoint, '/products/reviews' . '/(?P<id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => array($this, 'view_products_review'),
        'permission_callback' => '__return_true',
    ));
	}

	public function view_products($request) {
		
		$filters = $request->get_query_params();
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			
			$products = $this->woocommerce->get( 'products', $filters );
			$response_wc = $this->woocommerce->http->getResponse();
			$headers = $response_wc->getHeaders();
			if (isset($headers['X-WP-Total']) && isset($headers['X-WP-TotalPages'])) {
				header('X-WP-Total: ' . $headers['X-WP-Total']);
				header('X-WP-TotalPages: ' . $headers['X-WP-TotalPages']);
			}
			return $products;

		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_product( $request ) {
		$id = $request->get_param('id');

		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$product = $this->woocommerce->get( 'products/' . $id);
			return $product;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_product_variations( $request ) {

		$id = $request->get_param('id');
		$filters = $request->get_query_params();

		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}
		
		try {
			$variations = $this->woocommerce->get( 'products/' . $id . '/variations', $filters);
			return $variations;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_product_variation( $request ) {

		$id = $request->get_param('id');
		$v_id = $request->get_param('v_id');

		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$variation = $this->woocommerce->get( 'products/' . $id . '/variations/' . $v_id);
			return $variation;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_products_categories($request) {
		
		$filters = $request->get_query_params();
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$categories = $this->woocommerce->get( 'products/categories', $filters );
			return $categories;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_products_category($request) {

		$id = $request->get_param('id');
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$category = $this->woocommerce->get( 'products/categories/' . $id );
			return $category;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_products_tags($request) {
		
		$filters = $request->get_query_params();
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$tags = $this->woocommerce->get( 'products/tags', $filters );
			return $tags;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_products_tag($request) {

		$id = $request->get_param('id');
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$tag = $this->woocommerce->get( 'products/tags/' . $id );
			return $tag;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_products_reviews($request) {
		
		$filters = $request->get_query_params();
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$reviews = $this->woocommerce->get( 'products/reviews', $filters );
			return $reviews;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}

	public function view_products_review($request) {

		$id = $request->get_param('id');
		
		if ( isset( $request['_embed'] ) )  {
			return new WP_Error(500, 'there are some bugs this _embed parameter, don\'t use it');
		}

		try {
			$review = $this->woocommerce->get( 'products/reviews/' . $id );
			return $review;
		} catch (HttpClientException $e) {
			return new WP_Error($e->getCode(), $e->getMessage());
		}
	}
}
