<?php
/**
 * Bestsellers block template
 *
 * @package skykingfireworks/blocks/best-sellers
 * @since 1.0.0
 */

$heading                          = get_field( 'best-sellers__title' );
$link_url                         = get_field( 'best-sellers__link' );
$best_sellers_products_ids        = get_field( 'best-sellers__products' );
$global_best_sellers_products_ids = get_field( 'global__best-sellers_products', 'options' );

$banner_link = get_field( 'best-sellers__banner_link' );
$banner_img  = get_field( 'best-sellers__banner_img' ) ?? get_template_directory_uri() . '/assets/images/blocks/global-components/banner-item.png';
$banner_text = get_field( 'best-sellers__banner_text' );
$main_logo   = get_field( 'main_logo', 'option' );

$args = [];

if ( $best_sellers_products_ids || $global_best_sellers_products_ids ) {
    $args = [
        'post_status' => 'publish',
        'include'     => $best_sellers_products_ids ? $best_sellers_products_ids : $global_best_sellers_products_ids,
    ];
} else {
    $args = [
        'limit'    => 4,
        'meta_key' => 'total_sales',
        'orderby'  => [
			'meta_value_num' => 'DESC',
			'title'          => 'ASC',
		],
    ];
}

$best_sellers_products = wc_get_products( $args );

?>

<section class="best-sellers">
    <div class="container">
        <div class="best-sellers__heading">
        </div>
        <div class="swiper best-sellers-slider">
            <div class="swiper-wrapper">
                <?php if ( $banner_link || $banner_text ) : ?>
                <div class="swiper-slide">
                    <div class="banner-item">
                        <a href="<?php echo esc_url( home_url( $banner_link ) ); ?>" class="banner-item__wrapper">
                            <img src="<?php echo esc_url( $main_logo ); ?>" class="banner-item__logo" alt="Skyking logo">
                            <img src="<?php echo esc_url( $banner_img ); ?>" class="banner-item__bg" alt="Skyking banner">
                            <span class="banner-item__link view-all-link">
                                <span><?php echo $banner_text ? esc_html( $banner_text ) : 'Shop Now'; ?></span>
                                <svg class="view-all-link__icon" width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.666667 0.496664L4 3.83L0.666667 7.16333" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php foreach ( $best_sellers_products as $product ) : ?>
                    <div class="swiper-slide">
                        <?php get_template_part( 'template-parts/product/product-item', 'product-item', [ 'product' => $product ] ); ?>
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
