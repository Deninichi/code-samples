<?php
/**
 * Safety school block template
 *
 * @package skykingfireworks/blocks/safety-school
 * @since 1.0.0
 */

$education_title       = get_field( 'safety-school__title' );
$education_description = get_field( 'safety-school__description' );
$education_posts       = get_field( 'safety-school__subpages' );

?>
<div class="safety-school">
    <div class="container">
        <?php if ( $education_title || $education_description ) : ?>
            <div class="safety-school__header">
                <?php if ( $education_title ) : ?>
                    <h2 class="safety-school__heading"><?php echo esc_html( $education_title ); ?></h2>
                <?php endif; ?>
                <?php if ( $education_description ) : ?>
                    <p class="safety-school__sub-heading"><?php echo esc_html( $education_description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="safety-school__list">
            <?php
            if ( $education_posts ) :
                foreach ( $education_posts as $education_post ) :
					setup_postdata( $education_post );
                    $post_img   = get_the_post_thumbnail_url( $education_post->ID );
                    $post_title = get_the_title( $education_post->ID );
                    ?>
                    <div class="safety-school__item">
                        <div class="safety-school__img">
                            <a href="<?php the_permalink( $education_post->ID ); ?>" >
                                <img src="<?php echo ( $post_img ) ? esc_url( $post_img ) : esc_url( get_template_directory_uri() . '/assets/images/blue-american-flag.jpg' ); ?>" alt="<?php echo esc_attr( $post_title ); ?>">
                            </a>
                        </div>
                        <div class="safety-school__content">
                            <div class="safety-school__category-date">
                                <span class="safety-school__category">Safety</span>
                                <!-- <span class="safety-school__date"><?php echo esc_html( get_the_date( '', $education_post->ID ) ); ?></span> -->
                            </div>
                            <div class="safety-school__title">
                                <a href="<?php esc_url( the_permalink( $education_post->ID ) ); ?>"><?php echo esc_html( $post_title ); ?></a>
                            </div>
                            <p class="safety-school__description"><?php echo ( get_the_excerpt( $education_post->ID ) ) ? esc_html( get_the_excerpt( $education_post->ID ) ) : 'How To Light Description.'; ?></p>
                            <a class="safety-school__read" href="<?php the_permalink( $education_post->ID ); ?>"> Read More
                                <svg class="view-all-link__icon" width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.666667 0.496664L4 3.83L0.666667 7.16333" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </div>

</div>
