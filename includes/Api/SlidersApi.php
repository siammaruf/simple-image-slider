<?php

namespace Cofixer\KC\Slider\Api;
use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Response;
use WpOrg\Requests\Exception;

class SlidersApi extends WP_REST_Controller {
	protected $namespace;
	protected $rest_base;
	protected int $version;

	public function __construct(){
		$this->version = 1;
		$this->namespace = "/cofixer/kcs/v";
		$this->rest_base = "sliders";
	}

	/**
	 * Register Routers
	 */
	public function register_routes(){
		register_rest_route(
			$this->namespace.$this->version,
			$this->rest_base.'/(?P<id>\d+)',
			[
				[
					'methods'   => WP_REST_Server::READABLE,
					'callback'  => [ $this, 'get_item' ],
					'permission_callback' =>[ $this, 'get_item_permissions_check' ],
					'args'      => $this->get_collection_params()
				],
				[
					'methods'   => WP_REST_Server::EDITABLE,
					'callback'  => [ $this, 'create_item' ],
					'permission_callback' =>[ $this, 'create_items_permission_check' ],
					'args'      => $this->get_endpoint_args_for_item_schema(true)
				],
				[
					'methods'   => WP_REST_Server::DELETABLE,
					'callback'  => [ $this, 'delete_item' ],
					'permission_callback' =>[ $this, 'create_items_permission_check' ],
					'args'      => $this->get_endpoint_args_for_item_schema(true)
				]
			]
		);
		register_rest_route(
			$this->namespace.$this->version,
			$this->rest_base,
			[
				[
					'methods'   => WP_REST_Server::READABLE,
					'callback'  => [ $this, 'get_items' ],
					'permission_callback' =>[ $this, 'create_items_permission_check' ],
					'args'      => $this->get_endpoint_args_for_item_schema(true),
				],
				[
					'methods'   => WP_REST_Server::CREATABLE,
					'callback'  => [ $this, 'create_item' ],
					'permission_callback' =>[ $this, 'create_items_permission_check' ],
					'args'      => $this->get_endpoint_args_for_item_schema(true),
				]
			]
		);
	}
	/**
	 * Get items response
	 */
	public function get_items($request): \WP_Error|WP_REST_Response|\WP_HTTP_Response{
		try {
			$response = [];
			$args = array(
				'numberposts' => 10,
				'post_type'   => 'kcs-sliders'
			);
			$sliders = get_posts( $args );
			foreach ($sliders as $slider){
				$slider->slides = maybe_unserialize(get_post_meta($slider->ID,"_kcs_slides"))[0];
				$response[] = $slider;
			}
			return rest_ensure_response( $response );
		}catch (Exception $e){
			return new WP_REST_Response($e->getMessage(), 404);
		}
	}
	/**
	 * Get items response
	 */
	public function get_item($request): \WP_Error|WP_REST_Response|\WP_HTTP_Response{
		try {
			$post_id = (int)$request['id'];
			$response = get_post($post_id);
			$response->slides = maybe_unserialize(get_post_meta($post_id,"_kcs_slides"))[0];
			return rest_ensure_response( $response );
		}catch (Exception $e){
			return new WP_REST_Response($e->getMessage(), 404);
		}
	}
	/**
	 * Create item response
	 */
	public function create_item($request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response{
		try {
			$params = $request->get_params();
			$title = sanitize_text_field($params['title']);
			$status = sanitize_text_field($params['status']);
			$meta = rest_sanitize_array($params['meta']);

			$slider = [
				"post_title" => $title,
				"post_status" => $status,
				"post_type" => "kcs-sliders",
				"meta_input" => [
					"_kcs_slides" => $meta
				]
			];
			if (isset($params['id'])){
				$slider['ID'] = (int)$params['id'];
				$post_id = wp_update_post( $slider );
			}else{
				$post_id = wp_insert_post($slider);
			}
			$response = get_post($post_id);
			$response->slides = maybe_unserialize(get_post_meta($post_id,"_kcs_slides"))[0];
			return rest_ensure_response($response);
		}catch (Exception $e){
			return new WP_REST_Response($e->getMessage(), 404);
		}
	}
	/**
	 * Get items response
	 */
	public function delete_item($request): \WP_Error|WP_REST_Response|\WP_HTTP_Response{
		try {
			$post_id = (int)$request['id'];
			wp_delete_post($post_id, true);
			$response = "Slider deleted !";
			return rest_ensure_response( $response );
		}catch (Exception $e){
			return new WP_REST_Response($e->getMessage(), 404);
		}
	}
	/**
	 * Get items permission check
	 */
	public function get_item_permissions_check( $request ): bool{
		return true;
	}
	/**
	 * Create item permission check
	 */
	public function create_items_permission_check( $request ): bool{
		if ( current_user_can( 'manage_options' ) ){
			return true;
		}
		return false;
	}
	/**
	 * Retrives the query parameters for the items collection
	 */
	public function get_collection_params(): array{
		return [];
	}
}