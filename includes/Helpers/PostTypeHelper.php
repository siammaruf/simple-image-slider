<?php

namespace Cofixer\KC\Slider\Helpers;

class PostTypeHelper {
	/**
	 * @param $post_types
	 */
	public function __construct($post_types) {
		$this->custom_post_types($post_types);
	}

	/**
	 * @param $post_types
	 * @return void
	 */
	public function custom_post_types($post_types): void {
		foreach ($post_types as $handler => $type){
			$name = !empty($type['name']) ? ucwords($type['name']) : false;
			$plural = !empty($type['plural']) ? ucwords($type['plural']) : false;
			$menu_name = !empty($type['menu_name']) ? ucwords($type['menu_name']) : false;
			$position = !empty($type['position']) ? $type['position'] : 5;
			$description = !empty($type['description']) ? $type['description'] : false;
			$supports_default = ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'];
			$supports = !empty($type['supports']) ? $type['supports'] : $supports_default;

			$labels = [
				'name'                => _x( $plural, 'Post Type General Name', 'kc' ),
				'singular_name'       => _x( $name, 'Post Type Singular Name', 'kc' ),
				'menu_name'           => __( $menu_name, 'kc' ),
				'parent_item_colon'   => __( 'Parent '.$name, 'kc' ),
				'all_items'           => __( 'All '.$plural, 'kc' ),
				'view_item'           => __( 'View '.$name, 'kc' ),
				'add_new_item'        => __( 'Add New '.$name, 'kc' ),
				'add_new'             => __( 'Add New', 'kc' ),
				'edit_item'           => __( 'Edit '.$name, 'kc' ),
				'update_item'         => __( 'Update '.$name, 'kc' ),
				'search_items'        => __( 'Search '.$name, 'kc' ),
				'not_found'           => __( 'Not Found', 'kc' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'kc' ),
			];

			$args = [
				'label'               => __( $handler, 'kc' ),
				'description'         => __( $description, 'kc' ),
				'labels'              => $labels,
				'supports'            => $supports,
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => $position,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'show_in_rest'        => true,
			];

			if (!empty($type['icon'])){
				$args['menu_icon'] = $type['icon'];
			}

			if (!empty($type['taxonomies'])){
				$args['taxonomies'] = $type['taxonomies'];
			}

			// Registering your Custom Post Type
			register_post_type( $handler, $args );

		}
	}
}