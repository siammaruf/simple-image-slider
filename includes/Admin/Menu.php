<?php

namespace Cofixer\KC\Slider\Admin;

class Menu{

	/**
	 * Initialize the class
	 */
	function __construct(){
		add_action('admin_menu',[$this,'admin_menu']);
	}

	/**
	 * Register menu Page
	 * @return void
	 */
	public function admin_menu(): void{
		global $submenu;

		$capability = "manage_options";
		$slug       = "cf-kc-simple-slider";

		$hook = add_menu_page(
			__("KC Slider","kcs"),
			__("KC Slider","kcs"),
			$capability,
			$slug,
			[ $this, "menu_page_template" ],
			CF_PLUGIN_ASSETS.'/images/plugin-icon.png'
		);

		if (current_user_can($capability)){
			$submenu[ $slug ][] = [ __("All Sliders","kcs"), $capability, "admin.php?page=". $slug ."#/" ];
			//$submenu[ $slug ][] = [ __("Settings","kcs"), $capability, "admin.php?page=". $slug ."#/settings" ];
			//$submenu[ $slug ][] = [ __("About","kcs"), $capability, "admin.php?page=". $slug ."#/about" ];
		}
	}

	/**
	 * Render Main Page
	 * @return void
	 */
	public function menu_page_template(): void{
		echo "<div class='wrap'><div id='cf-kcs-admin-app'></div></div>";
	}
}