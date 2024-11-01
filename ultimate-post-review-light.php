<?php

/**
 *
 * @link              http://codecanyon.net/user/dedalx/
 * @since             1.0.0
 * @package           Ultimate_Post_Review
 *
 * @wordpress-plugin
 * Plugin Name:       Ultimate Post Review
 * Plugin URI:        #
 * Description:       Display detailed post reviews with ratings by criterias.
 * Version:           1.0.0
 * Author:            MagniumThemes
 * Author URI:        https://magniumthemes.com/
 * License:           GPL
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:       ultimate-post-review
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ULTIMATE_POST_REVIEW_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ultimate-post-review-activator.php
 */
function ultimate_post_review_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-post-review-activator.php';
	Ultimate_Post_Review_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ultimate-post-review-deactivator.php
 */
function ultimate_post_review_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-post-review-deactivator.php';
	Ultimate_Post_Review_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ultimate_post_review_activate' );
register_deactivation_hook( __FILE__, 'ultimate_post_review_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-post-review.php';

/**
 * Display post review rating block, to use in themes
 */
function ultimate_post_review_display_post_review_block() {
    do_shortcode('[post_review_block]');
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ultimate_post_review_run() {

	$plugin = new Ultimate_Post_Review();
	$plugin->run();

}
ultimate_post_review_run();
