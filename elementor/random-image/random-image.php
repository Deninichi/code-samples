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
 * Elementor Random _Image Widget.
 *
 * @since 1.0.0
 */
class Elementor_Random_Image_Widget extends Widget_Base {

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

		wp_register_style( 'random-image-style', get_stylesheet_directory_uri() . '/inc/elementor/widgets/random-image/assets/random-image.css', [], '2.0.1' );
	}

	/**
	 * Include widget styles.
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return [ 'random-image-style' ];
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
		return 'random-image';
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
		return __( 'Random Image', 'gop' );
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
		return 'eicon-image';
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
			'section_image',
			[
				'label' => __( 'Image', 'elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$repeater->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'images_list',
			[
				'label'  => __( 'Images List', 'plugin-domain' ),
				'type'   => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => __( 'Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => __( 'Max Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label'     => __( 'Object Fit', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options'   => [
					''        => __( 'Default', 'elementor' ),
					'fill'    => __( 'Fill', 'elementor' ),
					'cover'   => __( 'Cover', 'elementor' ),
					'contain' => __( 'Contain', 'elementor' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab(
			'normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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

		$this->settings = $this->get_settings_for_display();
		$images_list    = $this->settings['images_list'];

		if ( ! $images_list || count( $images_list ) < 1 ) {
			return;
		}

		$image_index = wp_rand( 0, count( $images_list ) - 1 );
		$image       = $images_list[ $image_index ];

		$this->start_wrap();
		$this->render_image( $image );
		$this->end_wrap();

	}

	/**
	 * Start widget container.
	 */
	protected function start_wrap() {
		echo '<div class="support-posts-container">';
	}

	/**
	 * Render Support Posts.
	 *
	 * @param array $image Random image array.
	 */
	protected function render_image( $image ) {
		echo wp_kses_post( $this->get_attachment_image_html( $image ) );
	}

	/**
	 * End widget container.
	 */
	protected function end_wrap() {
		echo '</div>';
	}

	/**
	 * Generate image HTML.
	 *
	 * @param array $image Random Image.
	 *
	 * @return mixed|void
	 */
	protected function get_attachment_image_html( $image ) {
		$html        = '';
		$image_class = '';
		$size        = $image['image_size'];

		// If is the new version - with image size.
		$image_sizes = get_intermediate_image_sizes();

		$image_sizes[] = 'full';

		if ( ! empty( $image['image']['id'] ) && ! wp_attachment_is_image( $image['image']['id'] ) ) {
			$image['image']['id'] = '';
		}

		$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();

		// On static mode don't use WP responsive images.
		if ( ! empty( $image['image']['id'] ) && in_array( $size, $image_sizes, true ) && ! $is_static_render_mode ) {
			$image_class .= " attachment-$size size-$size";
			$image_attr   = [
				'class' => trim( $image_class ),
			];

			$html .= wp_get_attachment_image( $image['image']['id'], $size, false, $image_attr );
		} else {
			$image_src = wp_get_attachment_image_src( $image['image']['id'], $size );

			if ( ! $image_src && isset( $image['image']['url'] ) ) {
				$image_src = $image['image']['url'];
			}

			if ( ! empty( $image_src ) ) {
				$image_class_html = ! empty( $image_class ) ? ' class="' . $image_class . '"' : '';

				$html .= sprintf( '<img src="%s" title="%s" alt="%s"%s />', esc_attr( $image_src ), Control_Media::get_image_title( $image ), Control_Media::get_image_alt( $image ), $image_class_html );
			}
		}

		return $html;
	}
}
