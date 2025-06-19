<?php

use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

/**
 * Elementor New Fundraiser Widget.
 *
 * @since 1.0.0
 */
class Elementor_New_Fundraiser_Widget extends Widget_Base {

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

		wp_register_script( 'new-fundraiser-script', get_stylesheet_directory_uri() . '/inc/elementor/widgets/new-fundraiser/assets/new-fundraiser.js', [ 'elementor-frontend' ], '2.0.0', true );
		wp_register_script( 'filepond-validate-script', get_stylesheet_directory_uri() . '/assets/js/filepond/filepond-plugin-file-validate-size.min.js', [], '2.2.5', true );
		wp_register_script( 'filepond-type-validate-script', get_stylesheet_directory_uri() . '/assets/js/filepond/filepond-plugin-file-validate-type.js', [], '1.2.6', true );

		wp_register_style( 'new-fundraiser-style', get_stylesheet_directory_uri() . '/inc/elementor/widgets/new-fundraiser/assets/new-fundraiser.css', [], '2.0.1' );
	}

	/**
	 * Include widget scripts.
	 *
	 * @return string[]
	 */
	public function get_script_depends() {
		return [ 'new-fundraiser-script', 'filepond-validate-script', 'filepond-type-validate-script'];
	}

	/**
	 * Include widget styles.
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return [ 'new-fundraiser-style' ];
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
		return 'new-fundraiser';
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
		return __( 'New Fundraiser Form', 'gop' );
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
		return 'eicon-form-horizontal';
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
		return [ 'general' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'elementor' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$this->start_wrap();
		$this->render_form();
		$this->end_wrap();

	}

	/**
	 * Start widget container.
	 */
	protected function start_wrap() {
		echo '<div class="new-fundraiser-form-container">';
	}

	/**
	 * Render New Fundraiser Form.
	 */
	protected function render_form() {
		$categories = $this->get_woo_categories();
		include 'templates/form.php';
	}

	/**
	 * End widget container.
	 */
	protected function end_wrap() {
		echo '</div>';
	}

	/**
	 * Get woocommerce categories
	 */
	protected function get_woo_categories() {
		$woo_categories = get_categories( [
			'taxonomy'   => 'product_cat',
			'orderby'    => 'name',
			'hide_empty' => false
		] );

		return $woo_categories;
	}
}
