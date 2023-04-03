<?php
namespace Cofixer\KC\Slider;

use Cofixer\KC\Slider\Admin\Menu;
use Cofixer\KC\Slider\Admin\Assets;

/**
 * The admin class
 */
class Admin{
	/**
	 * Initialize the class
	 */
	public function __construct(){
		new Menu();
		new Assets();
	}
}