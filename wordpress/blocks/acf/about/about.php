<?php
/**
 * About block template
 *
 * @package skykingfireworks/blocks/about
 * @since 1.0.0
 */

$default_main_image_url = get_theme_file_uri( 'assets/images/blocks/about/about-main-image.png' );

$about_default_content        = 'About block description text';
$about_benefits_default_icons = [
    get_theme_file_uri( 'assets/images/blocks/about/svg/down-arrow.svg' ),
    get_theme_file_uri( 'assets/images/blocks/about/svg/two-files.svg' ),
    get_theme_file_uri( 'assets/images/blocks/about/svg/gift-box.svg' ),
];


$about_title      = get_field( 'about__title' );
$about_main_image = get_field( 'about_main_image' ) ? get_field( 'about_main_image' ) : $default_main_image_url;
$about_content    = get_field( 'about_content' ) ? get_field( 'about_content' ) : $about_default_content;
$about_benefits   = get_field( 'about__benefits' );
?>

<section class="about-section">
    <div class="container">
        <div class="about">
            <div class="about__col">
                <img src="<?php echo esc_url( $about_main_image ); ?>" alt="about image" class="about__image">
            </div>
            <div class="about__col">
                <div class="about__content">
                    <p class="about__page-link"></p>
                    <h2 class="about__title"><?php echo esc_html( $about_title ); ?></h2>
                    <p class="about__paragraph"><?php echo esc_html( $about_content ); ?></p>

                    <div class="about__links">
                        <?php if ( $about_benefits ) : ?>
                            <?php foreach ( $about_benefits as $index => $benefit ) : ?>
                            <div class="about__link">
                                <div class="about__link-image-wrapper">
                                    <img src="<?php echo esc_url( ! empty( $benefit['about__icon'] ) ? $benefit['about__icon'] : $about_benefits_default_icons[ $index ] ); ?>" alt="link-left" class="about__link-image">
                                </div>
                                <p class="about__link-text"><?php echo esc_html( ! empty( $benefit['about__benefit_text'] ) ? $benefit['about__benefit_text'] : $about_benefits_default_text[ $index ] ); ?></p>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
