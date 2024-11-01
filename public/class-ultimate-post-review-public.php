<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://codecanyon.net/user/dedalx/
 * @since      1.0.0
 *
 * @package    Ultimate_Post_Review
 * @subpackage Ultimate_Post_Review/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ultimate_Post_Review
 * @subpackage Ultimate_Post_Review/public
 * @author     dedalx <dedalx.rus@gmail.com>
 */
class Ultimate_Post_Review_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-post-review-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-post-review-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Show post review data on single post page.
	 *
	 * @since    1.0.0
	 */
	public function show_post_review_single( $content ) {

		$upr_options = get_option( 'upr_options' );
		$post_review_enabled = get_post_meta( get_the_ID(), '_upr_post_review_enabled', true );

		if( is_single() && $post_review_enabled && $upr_options['enable_single_post_review'] ) {

			$content .= $this->get_post_review_block();

		}

		return $content;

	}

	/**
	 * Show post review block as shortcode
	 *
	 * @since    1.0.0
	 */
	public function post_review_block_shortcode() {

		echo $this->get_post_review_block();

	}

	/**
	 * Get post review block HTML for display anywhere
	 *
	 * @since    1.0.0
	 */
	private function get_post_review_block() {

		$upr_options = get_option( 'upr_options' );

		// Get post review settings
		$post_review_title = get_post_meta( get_the_ID(), '_upr_post_review_title', true );
		$post_review_summary = get_post_meta( get_the_ID(), '_upr_post_review_summary', true );
		$post_review_positives = get_post_meta( get_the_ID(), '_upr_post_review_positives', true );
		$post_review_positives = explode("\n", str_replace("\r", "", $post_review_positives));
		$post_review_negatives = get_post_meta( get_the_ID(), '_upr_post_review_negatives', true );
		$post_review_negatives = explode("\n", str_replace("\r", "", $post_review_negatives));
		$post_review_criteria_group = get_post_meta( get_the_ID(), '_upr_review_criteria_group', true );

		$criterias = array();

		$criteria_value_total = 0;

		$post_review_html = '';

		$i = 0;

		foreach ( (array) $post_review_criteria_group as $key => $value ) {

			$i++;

			if($i == 4) {
				break;
			}

		    $criteria_title = $criteria_value = '';

		    if ( !empty( $value['criteria_value'] ) ) {
		        $criteria_value = $value['criteria_value'];
		        $criteria_value_total += $criteria_value;
		    }

		    if ( !empty( $value['criteria_title'] ) ) {
		        $criteria_title = $value['criteria_title'];
		        $criterias[$criteria_title] = $criteria_value;
		    }

		}

		$post_review_rating = 0;

		if(count($criterias) > 0) {
		    $post_review_rating = $criteria_value_total / count($criterias);
		} else {
		    $post_review_rating = 0;
		}

		ob_start();
		?>
		<div id="post-review" class="post-review-block post-review-block-style-<?php echo esc_attr($upr_options['style']); ?>">
		    <div class="post-review-header"><h3><?php echo esc_html($post_review_title); ?></h3></div>
		    <?php if(!empty($post_review_summary)): ?>
		    <div class="post-review-summary"><?php echo wp_kses_post($post_review_summary); ?></div>
		    <?php endif; ?>
		    <?php if(count($criterias) > 0): ?>
		    <div class="post-review-criteria-group">
		        <?php foreach ($criterias as $key => $value): ?>
		        <div class="post-review-criteria">
		            <div class="post-review-criteria-rating headers-font"><?php echo wp_kses_post($value); ?>%</div>
		            <div class="post-review-criteria-title"><h4><?php echo wp_kses_post($key); ?></h4></div>

		            <div class="post-review-criteria-progress"><div class="post-review-criteria-value" style="width: <?php echo wp_kses_post($value); ?>%;"></div></div>
		        </div>
		        <?php endforeach; ?>
		    </div>
		    <?php endif; ?>
		    <div class="post-review-details">
		        <div class="post-review-details-column post-review-positives">
		            <?php if(count($post_review_positives) > 0): ?>
		            <h4><?php esc_html_e('Positives', 'ultimate-post-review'); ?></h4>
		            <ul>
		                <?php
		                $i = 0;
		                foreach ($post_review_positives as $value) {
		                	$i++;

		                	if($i == 6) {
		                		break;
		                	}

		                    echo '<li><span>+</span>'.wp_kses_post($value).'</li>';
		                }
		                ?>
		            </ul>
		            <?php endif; ?>
		        </div>
		        <div class="post-review-details-column post-review-negatives">
		            <?php if(count($post_review_negatives) > 0): ?>
		            <h4><?php esc_html_e('Negatives', 'ultimate-post-review'); ?></h4>
		            <ul>
		                <?php
		                $i = 0;
		                foreach ($post_review_negatives as $value) {
		                	$i++;

		                	if($i == 6) {
		                		break;
		                	}
		                    echo '<li><span>-</span>'.wp_kses_post($value).'</li>';
		                }
		                ?>
		            </ul>
		            <?php endif; ?>
		        </div>
		        <div class="post-review-details-column post-review-rating">
		            <?php if($post_review_rating > 0): ?>
		            <div class="post-review-rating-total headers-font"><?php echo esc_html(number_format($post_review_rating, 0)); ?>%</div>
		            <?php endif; ?>
		        </div>
		    </div>
		</div>
		<?php

		$post_review_html = ob_get_contents();
		ob_end_clean();

		return $post_review_html;

	}

}
