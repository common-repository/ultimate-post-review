<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://codecanyon.net/user/dedalx/
 * @since      1.0.0
 *
 * @package    Ultimate_Post_Review
 * @subpackage Ultimate_Post_Review/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ultimate_Post_Review
 * @subpackage Ultimate_Post_Review/includes
 * @author     dedalx <dedalx.rus@gmail.com>
 */
class Ultimate_Post_Review_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ultimate-post-review',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
