<?php
/**
 * Safety school block template
 *
 * @package skykingfireworks/blocks/safety-school
 * @since 1.0.0
 */

$specials_title       = get_field( 'specials__title' );
$specials_description = get_field( 'specials__description' );
$specials_items       = get_field( 'specials__items' );

?>
<div class="safety-school">
    <div class="container">
        <?php if ( $specials_title || $specials_description ) : ?>
            <div class="safety-school__header">
                <?php if ( $specials_title ) : ?>
                    <h2 class="safety-school__heading"><?php echo esc_html( $specials_title ); ?></h2>
                <?php endif; ?>
                <?php if ( $specials_description ) : ?>
                    <p class="safety-school__sub-heading"><?php echo esc_html( $specials_description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="safety-school__list">
            <?php
            if ( $specials_items ) :
                foreach ( $specials_items as $specials_item ) :

                    $post_img = $specials_item['image'];
                    $post_url = $specials_item['url'];
                    ?>
                    <div class="safety-school__item">
                        <div class="safety-school__img">
                            <a href="<?php echo esc_url( $post_url ); ?>" >
                                <img src="<?php echo ( $post_img ) ? esc_url( $post_img ) : esc_url( get_template_directory_uri() . '/assets/images/blue-american-flag.jpg' ); ?>" alt="">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
