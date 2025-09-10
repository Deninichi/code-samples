<?php
/**
 * Effects block template
 *
 * @package skykingfireworks/blocks/effects
 * @since 1.0.0
 */

$field_objecs                = get_field_objects();
$effects__title              = get_field( 'effects__title' ) ? get_field( 'effects__title' ) : $field_objecs['effects__title']['default_value'];
$effects__cards              = get_field( 'effects__cards' );
$effects__default_image      = get_theme_file_uri( 'assets/images/blocks/effects/effects-default-image.gif' );
$effects__default_card_title = 'CHRYSANTHEMUM';
?>

<section class="effects">
    <div class="container">
        <div class="effects__wrapper">
            <h1 class="effects__title"><?php echo esc_html( $effects__title ); ?></h1>
            <div class="effects__cards">
                <?php
                if ( $effects__cards ) :
                    foreach ( $effects__cards as $card ) :
						?>
                        <div class="effects__card">
                            <img src="<?php echo esc_url( ! empty( $card['effects__image'] ) ? $card['effects__image'] : $effects__default_image ); ?>" alt="Effects" class="effects__image">
                            <h3 class="effects__card-title"><?php echo esc_html( ! empty( $card['effects__card-title'] ) ? $card['effects__card-title'] : $effects__default_card_title ); ?></h3>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
