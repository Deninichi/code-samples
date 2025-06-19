<?php

use Elementor\Widget_Base;

/**
 * Elementor Support Posts Widget.
 *
 * @since 1.0.0
 */
class Elementor_Support_Posts_Widget extends Widget_Base {

	/**
	 * Support posts query.
	 *
	 * @var WP_Query
	 */
	protected $posts_query;

	/**
	 * Support posts tags.
	 *
	 * @var WP_Term[]
	 */
	protected $tags;

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

		wp_register_script( 'support-posts-script', get_stylesheet_directory_uri() . '/inc/elementor/widgets/support-posts/assets/support-posts.js', [ 'elementor-frontend' ], '2.0.0', true );
		wp_register_style( 'support-posts-style', get_stylesheet_directory_uri() . '/inc/elementor/widgets/support-posts/assets/support-posts.css', [], '2.0.1' );
	}

	/**
	 * Include widget scripts.
	 *
	 * @return string[]
	 */
	public function get_script_depends() {
		return [ 'support-posts-script' ];
	}

	/**
	 * Include widget styles.
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return [ 'support-posts-style' ];
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
		return 'support-posts';
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
		return __( 'Support Posts', 'gop' );
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
		return 'eicon-post-list';
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

		$this->get_posts();
		$this->get_tags();

		$this->start_wrap();
		$this->render_tags();
		$this->render_posts();
		$this->end_wrap();

	}

	/**
	 * Start widget container.
	 */
	protected function start_wrap() {
		echo '<div class="support-posts-container">';
	}

	/**
	 * Render Support Posts tags.
	 */
	protected function render_tags() {
		if ( $this->tags && ! is_wp_error( $this->tags ) ) {
			include 'templates/tags.php';
		}
	}

	/**
	 * Render Support Posts.
	 */
	protected function render_posts() {
		if ( $this->posts_query->have_posts() ) {
			echo '<div class="support-posts-wrap">';
			while ( $this->posts_query->have_posts() ) {
				$this->posts_query->the_post();
				include 'templates/post.php';
			}
			echo '<div>';
		}
	}

	/**
	 * End widget container.
	 */
	protected function end_wrap() {
		echo '</div>';
	}

	/**
	 * Get Support posts query.
	 */
	protected function get_posts() {
		$this->posts_query = new WP_Query(
			[
				'post_type'      => 'support_post',
				'posts_per_page' => -1,
			]
		);
	}

	/**
	 * Get Support posts query.
	 */
	protected function get_tags() {
		$this->tags = get_terms(
			[
				'taxonomy'   => 'support_post_tag',
				'hide_empty' => false,
				'orderby'    => 'count',
				'order'      => 'DESC',
			]
		);
	}

}
