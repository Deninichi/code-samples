<?php
/**
 * Banner block template
 *
 * @package skykingfireworks/blocks/banner
 * @since 1.0.0
 */

$background      = get_field( 'banner__background' );
$bunner__title   = get_field( 'banner__title' );
$bunner_btn_link = get_field( 'banner__link' );
$bunner_btn_link = get_field( 'banner__link' );
$main_logo       = get_field( 'main_logo', 'option' );

?>

<section class="banner-section">
    <div class="banner" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.18)), url( <?php echo ( esc_url( $background ) ) ? esc_url( $background ) : esc_url( get_template_directory_uri() . '/assets/images/blocks/banner/banner-background.jpg' ); ?> ); ">
        <div class="container">
            <div class="banner__row">
                <div class="banner__main">
                    <div class="banner__img">
                        <img src="<?php echo esc_url( $main_logo ); ?>" alt="banner section illustration">
                    </div>
                    <h2 class="banner__text"><?php echo ( $bunner__title ) ? esc_html( $bunner__title ) : 'About Fireworks'; ?></h2>
                    <div class="banner__button">
                        <a class="custom-button custom-button--red" href="<?php echo ( home_url( $bunner_btn_link ) ) ? esc_url( home_url( $bunner_btn_link['url'] ) ) : '#'; ?>" class="custom-button"> <?php echo ( $bunner_btn_link && $bunner_btn_link['title'] ) ? esc_html( $bunner_btn_link['title'] ) : 'Shop Fireworks'; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>