<?php

use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

/**
 * Elementor Basic Gallery Form Widget.
 *
 * @since 1.0.0
 */
class Elementor_Basic_Gallery_Form_Widget extends Widget_Base {

	/**
	 * Widget settings.
	 *
	 * @var array
	 */
	private $settings;

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

		wp_register_style( 'basic-gallery-form-style', get_stylesheet_directory_uri() . '/inc/elementor/widgets/basic-gallery-form/assets/basic-gallery-form.css', [], time() );
	}

	/**
	 * Include widget styles.
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return [ 'basic-gallery-form-style' ];
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
		return 'basic-gallery-form';
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
		return __( 'Basic Gallery Form', 'gop' );
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
		return 'eicon-gallery-grid';
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
			'section_gallery',
			[
				'label' => __( 'Image Gallery', 'elementor' ),
			]
		);

		$this->add_control(
			'wp_gallery',
			[
				'label' => __( 'Add Images', 'elementor' ),
				'type' => Controls_Manager::GALLERY,
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label'      => __( 'Content', 'elementor' ),
				'type'       => Controls_Manager::WYSIWYG,
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
		$this->render_images();
		$this->end_wrap();
	}

	/**
	 * Start widget container.
	 */
	protected function start_wrap() {
		echo '<div class="basic-gallery-form-container">';
	}

	/**
	 * Render Support Posts.
	 *
	 * @param array $image Random image array.
	 */
	protected function render_images() {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['wp_gallery'] ) {
			return;
		}

		$ids = wp_list_pluck( $settings['wp_gallery'], 'id' );

        foreach ( $ids as $key => $id ) {
			if ( $key === 7 ) {
				echo '<div class="item form"><div class="item-wrap">' . $settings['content'] . '</div></div>';
			}
            echo '<div class="item">' . wp_get_attachment_image( $id, 'large' ) . '</div>';
        }
	}

	/**
	 * End widget container.
	 */
	protected function end_wrap() {
		echo '</div>';
	}

}
