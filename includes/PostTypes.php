<?php

namespace Cofixer\KC\Slider;

use Cofixer\KC\Slider\Helpers\PostTypeHelper;

class PostTypes{
	/**
	 * Init Custom Post Types
	 */
	public function __construct()
	{
		add_action( 'init', [$this, 'custom_post_type'], 0 );
		//add_action('admin_menu', [$this, 'hide_slider_menu'], 11);
	}
	/**
	 * Create Custom Post Types
	 *
	 * @return void
	 */
	public function custom_post_type(): void
	{
		new PostTypeHelper($this->creat_custom_post_type());
	}
	/**
	 * Add custom post types
	 *
	 * @return array[]
	 */
	public function creat_custom_post_type(): array
	{
		return [
			'kcs-sliders' => [
				'name' => 'Slider',
				'plural' => 'Sliders',
				'menu_name' => 'CF Slider',
				'position' => 10,
				'description' => 'Simple Image Slider',
				'supports' => ['title','editor','thumbnail'],
			],
		];
	}

	public function hide_slider_menu(): void {
		remove_menu_page('edit.php?post_type=kcs-sliders');
	}
}