<?php

namespace Cofixer\KC\Slider\Shortcodes;

class SliderShortcode {
	public function __construct(){
		add_shortcode( 'kcs_slider', [$this,'create_short_code'] );
	}

	public function create_short_code($atts): bool|string {
		$attributes = shortcode_atts( array(
			'id' => '',
		), $atts );
		ob_start();
		load_template(
			dirname(__FILE__).'/template-parts/slider_template_01.php',
			true,
			['attributes' => $attributes]
		);
		return ob_get_clean();
	}
}