<?php
/**
 * Actions block template
 *
 * @package skykingfireworks/blocks/actions
 * @since 1.0.0
 */

$action_items = get_field( 'actions__actions-items' );
$action_type  = get_field( 'actions__block_view' );

$marquee_items = [ 'SKY KING FIREWORKS', 'RULE THE SKY!', 'SKY KING FIREWORKS', 'RULE THE SKY!' ];
$marquee_icon  = file_get_contents( esc_url( get_template_directory_uri() . '/assets/images/blocks/global-components/svg/marquee-big.svg' ) );
$main_logo     = get_field( 'main_logo', 'option' );
?>

<section class="actions-section <?php echo $action_type && $action_type === 'simple' ? 'simple-view' : ''; ?>">
    <?php if ( $action_type && $action_type === 'with_text' ) : ?>
        <?php
        get_template_part(
            'template-parts/common/marquee',
            'marque',
            [
                'items' => $marquee_items,
                'icon'  => $marquee_icon,
            ]
        );
        ?>
    <?php endif; ?>
    <div class="actions">
        <div class="container">
            <h2 hidden>Actions</h2>
            <?php if ( $action_items ) : ?>
                <ul class="actions__list" role="list">
                    <?php foreach ( $action_items as $action_item ) : ?>
                        <?php
                            $action_image = $action_item['action__image'] ? $action_item['action__image'] : get_template_directory_uri() . '/assets/images/blocks/global-components/banner-item.png';
                            $action_link  = $action_item['action__link']['url'] ?? '#';
                     
                        ?>
                        <li>
                            <div class="banner-item">
                                <a href="<?php echo esc_url( home_url( $action_link ) ); ?>" class="banner-item__wrapper">
                                    <img src="<?php echo esc_url( $main_logo ); ?>" class="banner-item__logo" alt="">
                                    <img src="<?php echo esc_url( $action_image ); ?>" class="banner-item__bg" alt="">
                                    <span class="banner-item__link view-all-link">
                                        <span><?php echo esc_html( $action_title ); ?></span>
                                       
                                            <path d="M0.666667 0.496664L4 3.83L0.666667 7.16333" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
            <?php endif; ?>
        </div>
    </div>
</section>
