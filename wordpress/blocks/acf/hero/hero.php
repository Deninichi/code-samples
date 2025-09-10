<?php
/**
 * Hero block template
 *
 * @package skykingfireworks/blocks/hero
 * @since 1.0.0
 */

$background       = get_field( 'hero__background' );
$hero__left__img  = get_field( 'hero__left-img' );
$hero__right__img = get_field( 'hero__right-img' );
$left_btn_link    = get_field( 'left_button_link' );
$right_btn_link   = get_field( 'right_button_link' );
$text_color       = get_field( 'hero__text-color' );
$left_btn_color   = get_field( 'left_button_color' );
$right_btn_color  = get_field( 'right_button_color' );

?>

<section class="hero" style="background-image: url( <?php echo ( esc_url( $background ) ) ? esc_url( $background ) : esc_url( get_template_directory_uri() . '/assets/images/blocks/hero/hero_background.jpg' ); ?> ); ">
    <div class="container">
        <div class="hero__block-row">
            <div class="hero__left">
                <img src="<?php echo $hero__left__img ? esc_url( $hero__left__img ) : esc_url( get_template_directory_uri() . '/assets/images/blocks/hero/hero_left.png' ); ?>;" alt="hero section illustration">
            </div>
            <div class="hero__right">
                <img src="<?php echo $hero__right__img ? esc_url( $hero__right__img ) : esc_url( get_template_directory_uri() . '/assets/images/blocks/hero/hero_right.png' ); ?>" alt="hero section illustration">
                <div class="hero__text-button">
                    <p
                        <?php if ( $text_color ) : echo 'style="color:'.$text_color.'"'; endif; ?>
                        class="hero__text"><?php the_field( 'hero__ad-text' ); ?></p>
                    <div class="hero__buttons">
                        <a
                            <?php if ( $left_btn_color ) : echo 'style="background-color:'.$left_btn_color.'"'; endif; ?>
                            href="<?php echo ( $left_btn_link ) ? esc_url( home_url( $left_btn_link['url'] ) ) : '#'; ?>" class="custom-button"><?php echo ( $left_btn_link && $left_btn_link['title'] ) ? esc_html( $left_btn_link['title'] ) : 'Find a Store'; ?></a>
                        <a
                            <?php if ( $right_btn_color ) : echo 'style="background-color:'.$right_btn_color.'"'; endif; ?>
                            href="<?php echo ( $right_btn_link ) ? esc_url( home_url( $right_btn_link['url'] ) ) : '#'; ?>" class="custom-button custom-button--red"> <?php echo ( $right_btn_link && $right_btn_link['title'] ) ? esc_html( $right_btn_link['title'] ) : 'Shop Online'; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

