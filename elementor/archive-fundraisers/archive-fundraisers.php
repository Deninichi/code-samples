<?php

use Elementor\Widget_Base;

/**
 * Elementor Archive Fundraisers Widget.
 *
 * @since 1.0.0
 */
class Elementor_Archive_Fundraisers_Widget extends Widget_Base {

	/**
	 * Elementor_Support_Posts_Widget constructor.
	 *
	 * @param array $data
	 * @param null  $args
	 *
	 * @throws Exception
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'archive-fundraisers-style', get_stylesheet_directory_uri() . '/inc/elementor/widgets/archive-fundraisers/assets/archive-fundraisers.css', [], '2.0.1' );
	}

	/**
	 * Include widget styles.
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return [ 'archive-fundraisers-style' ];
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'archive-fundraisers';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return __( 'Archive Fundraisers', 'gop' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-products';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return [ 'woocommerce-elements-archive' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->start_wrap();
		$this->render_fundraisers();
		$this->end_wrap();

	}

	/**
	 * Start widget container.
	 */
	protected function start_wrap() {
		echo '<div class="support-posts-container">';
	}

	/**
	 * Render fundraisers.
	 */
	protected function render_fundraisers() {
		ob_start();

		do_action( 'woocommerce_before_shop_loop' );

		wpcf_function()->template( 'wpneo-listing' );
		$html = ob_get_clean();
		wp_reset_query();
		echo $html;
	}

	/**
	 * End widget container.
	 */
	protected function end_wrap() {
		echo '</div>';
	}
}
