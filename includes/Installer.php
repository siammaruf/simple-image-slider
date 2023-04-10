<?php

namespace Cofixer\KC\Slider;

/**
 * Installer class
 */
class Installer{
	/**
	 * Run the installer
	 *
	 * @return void
	 */
	public function run(): void
	{
		$this->add_version();
	}

	/**
	 * Add time and version on DB
	 */
	public function add_version(): void{
		$installed = get_option( 'cf_kcs_installed' );

		if ( ! $installed ) {
			update_option( 'cf_kcs_installed', time() );
		}

		update_option( 'cf_kcs_version', CF_PLUGIN_VERSION );
	}
}