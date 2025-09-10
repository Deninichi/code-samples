<?php
/**
 * About Hero block template
 *
 * @package skykingfireworks/blocks/about-hero
 * @since 1.0.0
 */

$default_image        = get_theme_file_uri( 'assets/images/blocks/about-hero/about-hero--image-left.png' );
$logo_in_a_red_circle = get_theme_file_uri( 'assets/images/svg/logo-in-a-red-circle.svg' );

$default_content        = 'Description about us.';
$about_hero_title       = get_field( 'about_hero__title' );
$about_hero_contents    = get_field( 'about_hero__contents' );
$about_hero__image_left = get_field( 'about_hero__image_left' );
?>

<section class="about-hero-section">
    <div class="container">
        <div class="about-hero__wrapper">
            <div class="about-hero__content">
                <div class="about-hero__title-wrapper">
                    <div class="about-hero__caption">ABOUT US</div>
                    <h2 class="about-hero__title"><?php echo esc_html( ! empty( $about_hero_title ) ? $about_hero_title : 'About us' ); ?></h2>
                </div>
                <?php if ( $about_hero_contents ) : ?>
                            <?php foreach ( $about_hero_contents as $content ) : ?>
                                <p class="about-hero__paragraph"><?php echo esc_html( ! empty( $content['about_hero__content'] ) ? $content['about_hero__content'] : $default_content ); ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>                
            </div>
            <img src="<?php echo esc_url( ! empty( $about_hero__image_left ) ? $about_hero__image_left : $default_image ); ?>" class="about-hero__image-left" alt="About-hero Image">
            <img src="<?php echo esc_url( $logo_in_a_red_circle ); ?>" class="about-hero__image-right" alt="About-hero Image">
            
            </div>   
    </div>
</section>
