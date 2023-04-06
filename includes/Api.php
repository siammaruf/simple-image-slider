<?php

namespace Cofixer\KC\Slider;
use Cofixer\KC\Slider\Api\SlidersApi;
use WP_REST_Controller;

/**
 * Rest Api Handler
 */
class Api extends WP_REST_Controller{
	/**
	 * Construct Function
	 */
	public function __construct(){
		add_action( 'rest_api_init',[ $this, 'register_rest_routes' ] );
	}

	/**
	 * Register API routes
	 */
	public function register_rest_routes(){
		( new SlidersApi() ) ->register_routes();
	}
}