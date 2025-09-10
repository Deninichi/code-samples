<?php
/**
 * Categories block template
 *
 * @package skykingfireworks/blocks/categories
 * @since 1.0.0
 */

$heading         = get_field( 'categories__title' );
$link_url        = get_field( 'categories__link' );
$categories_list = get_field( 'categories__list' );

$term_query_args = [
    'taxonomy'  => 'product_cat',
    'childless' => true,
];

if ( $categories_list ) {
    $term_query_args['include'] = $categories_list;
}

$categories = get_categories( $term_query_args );

?>

<section class="categories">
    <div class="container">
        <div class="categories__heading">
            </a>
        </div>
        <div class="swiper categories-slider">
            <div class="swiper-wrapper">
                <?php foreach ( $categories as $category ) : ?>
                    <div class="swiper-slide">
                        <?php get_template_part( 'template-parts/category/category-item', 'category-item', [ 'category' => $category ] ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next custom-swiper-arrow custom-swiper-arrow--next">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/svg/arrow-slider.svg' ); ?>" alt="">
            </div>
            <div class="swiper-button-prev custom-swiper-arrow custom-swiper-arrow--prev">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/svg/arrow-slider.svg' ); ?>" alt="">
            </div>
        </div>
    </div>
</section>
