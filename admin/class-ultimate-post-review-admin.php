<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://codecanyon.net/user/dedalx/
 * @since      1.0.0
 *
 * @package    Ultimate_Post_Review
 * @subpackage Ultimate_Post_Review/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Post_Review
 * @subpackage Ultimate_Post_Review/admin
 * @author     dedalx <dedalx.rus@gmail.com>
 */
class Ultimate_Post_Review_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Post_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Post_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-post-review-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Post_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Post_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}


	/**
	 * Check for CMB2 plugin installation
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function display_cmb2_warning() {

		$plugin_name = 'cmb2';
		$install_cmb2_link = '<a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $plugin_name ) ) . '" target="_blank">install and activate CMB2 plugin</a>';

	    $message_html = '<div class="notice notice-error"><p><strong>WARNING:</strong> Ultimate Post Review plugin use CMB2 plugin. Please '.$install_cmb2_link.'.</p></div>';

	    echo wp_kses_post($message_html);

	}

	/**
	 * Add review options metaboxes
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_metaboxes() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = '_upr_';

		// POST SETTINGS METABOX
		$cmb_post_review_settings = new_cmb2_box( array(
			'id'           => $prefix . 'post_review_metabox',
			'title'        => esc_html__( 'Post Review', 'ultimate-post-review' ),
			'object_types' => array( 'post' ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		) );

		$cmb_post_review_settings->add_field( array(
			'name' => 'You are using Free version of Ultimate Post Review plugin',
			'desc' => 'Purchase PRO version to unlock more features and remove all limits:<br><br>
			<ul>
				<li>- Unlimited review criterias with separate ratings</li>
				<li>- Unlimited positives and negatives display</li>
				<li>- Review rating badge display (Single post, Posts listings)</li>
				<li>- Affiliate buy button with custom text and url</li>
				<li>- Custom color ascent for every review</li>
				<li>- Rounded and squared elements styles</li>
				<li>- Google Rich Snippets Support (schema.org)</li>
				<li>- Shortcodes and custom functions for custom placing review badges anywhere in your theme</li>
				<li>- Free Plugin updates and dedicated support</li>
			</ul><br>
			<a href="https://codecanyon.net/item/ultimate-post-review-responsive-wordpress-posts-reviews-and-rating-plugin/23841089" target="_blank" class="button button-primary">Purchase PRO version</a>',
			'type' => 'title',
			'id'   => 'upr_free_version_text'
		) );

		$cmb_post_review_settings->add_field( array(
			'name' => esc_html__( 'Enable review block', 'ultimate-post-review' ),
			'desc' => esc_html__( 'Enable to show review block for post and set review settings below.', 'ultimate-post-review' ),
			'id'   => $prefix . 'post_review_enabled',
			'type' => 'checkbox',
		) );

		$cmb_post_review_settings->add_field( array(
			'name'    => esc_html__( 'Review block title', 'ultimate-post-review' ),
			'desc'    => esc_html__( 'Displayed in review block header.', 'ultimate-post-review' ),
			'default' => '',
			'id'      => $prefix . 'post_review_title',
			'type'    => 'text_medium',
		) );

		$cmb_post_review_settings->add_field( array(
			'name'    => esc_html__( 'Review block summary', 'ultimate-post-review' ),
			'desc'    => esc_html__( 'Short summary for review.', 'ultimate-post-review' ),
			'default' => '',
			'id'      => $prefix . 'post_review_summary',
			'type'    => 'textarea_small',
		) );

		$cmb_post_review_settings->add_field( array(
			'name'    => esc_html__( 'Positives', 'ultimate-post-review' ),
			'desc'    => esc_html__( 'Positives list (1 per line), up to 5 in free version', 'ultimate-post-review' ),
			'default' => '',
			'id'      => $prefix . 'post_review_positives',
			'type'    => 'textarea_small',
		) );

		$cmb_post_review_settings->add_field( array(
			'name'    => esc_html__( 'Negatives', 'ultimate-post-review' ),
			'desc'    => esc_html__( 'Negatives list (1 per line), up to 5 in free version', 'ultimate-post-review' ),
			'default' => '',
			'id'      => $prefix . 'post_review_negatives',
			'type'    => 'textarea_small',
		) );

		$cmb_review_criteria_group = $cmb_post_review_settings->add_field( array(
			'id'          => $prefix . 'review_criteria_group',
			'type'        => 'group',
			// 'repeatable'  => false, // use false if you want non-repeatable group
			'options'     => array(
			  'group_title'       => esc_html__( 'Review criteria {#} (Up to 3 criterias in free version)', 'ultimate-post-review' ),
			  'add_button'        => esc_html__( 'Add review criteria', 'ultimate-post-review' ),
			  'remove_button'     => esc_html__( 'Remove review criteria', 'ultimate-post-review' ),
			  'sortable'          => true,
			  // 'closed'         => true, // true to have the groups closed by default
			  // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
			),
		) );

		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb_post_review_settings->add_group_field( $cmb_review_criteria_group, array(
			'name' => esc_html__( 'Criteria title', 'ultimate-post-review' ),
			'id'   => 'criteria_title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_post_review_settings->add_group_field( $cmb_review_criteria_group, array(
			'name' => esc_html__( 'Criteria rating (%)', 'ultimate-post-review' ),
			'description' => esc_html__( 'Your rating for this criteria, for ex: 95 (means 95%)', 'ultimate-post-review' ),
			'id'   => 'criteria_value',
			'type' => 'text_small',
		) );

	}

	/**
	 * Add admin settings page
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_admin_page() {
		add_options_page(esc_html__('Ultimate Post Review', 'ultimate-post-review'), esc_html__('Ultimate Post Review', 'ultimate-post-review'), 'manage_options', 'upr_settings', array( $this, 'upr_settings' ));
	}

	/**
	 * Register settings
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function upr_register_settings() {

		$upr_options_default = array(
			'enable_single_post_review' 		=> 1,
			'enable_loop_post_review'   		=> 0,
			'style'   		=> 'square',
		);

		/* Install the default plugin options */
        if ( ! get_option( 'upr_options' ) ){
            add_option( 'upr_options', $upr_options_default, '', 'yes' );
        }
	}

	/**
	 * Print all plugin options.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function upr_settings() {

		$this->upr_register_settings();

		$display_add_options = $message = $error = $result = '';

		$upr_options = get_option( 'upr_options' );

		if ( isset( $_POST['upr_form_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'upr_nonce_name' ) ) {
			/* Update settings */
			$upr_options['enable_single_post_review'] = isset( $_POST['enable_single_post_review'] ) ? sanitize_text_field($_POST['enable_single_post_review']) : '0';
			$upr_options['enable_loop_post_review'] = isset( $_POST['enable_loop_post_review'] ) ? sanitize_text_field($_POST['enable_loop_post_review']) : '0';
			$upr_options['style'] = isset( $_POST['style'] ) ? sanitize_text_field($_POST['style']) : 'square';

			/* Update settings in the database */
			if ( empty( $error ) ) {
				if($_POST['save_form'] == 1) {
					update_option( 'upr_options', $upr_options );
					$message .= esc_html__( "Settings saved.", 'ultimate-post-review' );
				}
			} else {
				$error .= " " . esc_html__( "Settings are not saved.", 'ultimate-post-review' );
			}
		}

		// All available styles
		$upr_styles_list['square'] = 'Square edges';

		?>
		<div class="upr-settings wrap" id="upr-settings">
			<h2><?php esc_html_e( "Ultimate Post Review - Free version", 'ultimate-post-review' ); ?></h2>
			<p>Thanks for using plugin developed by <a href="https://magniumthemes.com/" target="blank">MagniumThemes</a> company.</p>
			<a href="https://magniumthemes.com/themes" target="blank" class="button button-secondary">Our Premium Themes</a> <a href="https://magniumthemes.com/wordpress-plugins/" target="blank" class="button button-secondary">Our Ultimate Plugins</a> <a href="https://magniumthemes.com/go/bluehost/" target="blank" class="button button-secondary">WordPress Hosting</a> <a href="https://codecanyon.net/item/ultimate-post-review-responsive-wordpress-posts-reviews-and-rating-plugin/23841089" target="blank" class="button button-primary">Purchase PRO version</a><br><br>
			<div class="updated fade" <?php if( empty( $message ) ) echo "style=\"display:none\""; ?>>
				<p><strong><?php echo esc_html($message); ?></strong></p>
			</div>

			<div class="upr-settings-wrapper">

				<form id="upr_settings_form" method="post" action="">
						<input type="hidden" name="save_form" id="save_form" value="1"/>
						<h3><?php esc_html_e( 'Getting started', 'ultimate-post-review' ); ?></h3>
						<table class="form-table">
						<tr valign="top">
							<th scope="row">How to add reviews</th>
							<td>
								<div class="option-info"><?php echo wp_kses_post(__('<strong>Edit/Add your Posts</strong> and you will see new <strong>Post Review</strong> settings metabox for every post at the bottom after post content editor.', 'ultimate-post-review' )); ?></div>
							</td>
						</tr>
						</table>
						<h3><?php esc_html_e( 'Display settings', 'ultimate-post-review' ); ?></h3>
						<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php esc_html_e( "Single post page", 'ultimate-post-review' ); ?></th>
							<td>
								<?php if(isset($upr_options['enable_single_post_review']) && $upr_options['enable_single_post_review'] == 1) {
									$enable_single_post_review = ' checked';
								} else {
									$enable_single_post_review = '';
								}
								?>
								<label><input type="checkbox" name="enable_single_post_review" value="1"<?php echo esc_attr($enable_single_post_review); ?>/>
								<span><?php esc_html_e( "Add post review block after post content automatically", 'ultimate-post-review' ); ?></span></label>
								<div class="option-info"><?php echo wp_kses_post(__( "If automatical position does not work well in your theme or you want to display block in custom position you can disable this option and place post review block manually:<ul><li>Add <strong>[post_review_block]</strong> shortcode in your post content.</li><li><strong>OR</strong> add code <strong>&lt;?php ultimate_post_review_display_post_review_block(); ?&gt;</strong> to your theme <strong>single.php</strong> template file (or other template file used in your theme for single post display).</li></ul>", 'ultimate-post-review' )); ?></div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( "Blog listing pages", 'ultimate-post-review' ); ?></th>
							<td>
								<?php if(isset($upr_options['enable_loop_post_review']) && $upr_options['enable_loop_post_review'] == 1) {
									$enable_loop_post_review = ' checked';
								} else {
									$enable_loop_post_review = '';
								}
								?>
								<label><input disabled type="checkbox" name="enable_loop_post_review" value="1"<?php echo esc_attr($enable_loop_post_review); ?>/>
								<span><?php esc_html_e( "Add post review rating badge inside blog post thumbnail automatically", 'ultimate-post-review' ); ?></span></label>
								<div class="option-info"><?php echo wp_kses_post(__( "<strong><a href='https://codecanyon.net/item/ultimate-post-review-responsive-wordpress-posts-reviews-and-rating-plugin/23841089' target='_blank'>Purchase PRO version</a> to unlock this feature.</strong>", 'ultimate-post-review' )); ?></div>
							</td>
						</tr>
						</table>
						<h3><?php esc_html_e( 'Styles settings', 'ultimate-post-review' ); ?></h3>
						<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php esc_html_e( "Post review elements style", 'ultimate-post-review' ); ?></th>
							<td>
								<select name="style">
								    <?php
								    $i = 0;
								    foreach ($upr_styles_list as $style => $inner_html) {
								    	if($style == $upr_options['style']) {
								    		$style_selected = ' selected';
								    	} else {
								    		$style_selected = '';
								    	}
								    	echo '<option data-id="'.esc_attr($i).'" value="'.$style.'"'.$style_selected.'>'.$inner_html.'</option>';
								    	$i++;
								    }
								    ?>
							    </select>
							    <p>More styles available in PRO version.</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( "Additional styles", 'ultimate-post-review' ); ?></th>
							<td>
								<div class="option-info"><?php echo wp_kses_post(__( "You can restyle any element in our plugin with Custom CSS code added in <strong>Appearance > Customize > Additional CSS</strong>.<br><br>Please <a href='https://help.magniumthemes.com/hc/en-us/articles/115001505454-How-to-change-theme-elements-styles-move-or-hide-elements' target='_blank'>read this help guide</a> about using Custom CSS.", 'ultimate-post-review' )); ?></div>
							</td>
						</tr>
						</table>

						<p class="submit">
							<input type="submit" id="settings-form-submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'upr' ) ?>" />

							<input type="hidden" name="upr_form_submit" value="submit" />
							<?php wp_nonce_field( plugin_basename( __FILE__ ), 'upr_nonce_name' ); ?>
						</p>
				</form>

			</div>

		</div>

		<?php
	}

}
