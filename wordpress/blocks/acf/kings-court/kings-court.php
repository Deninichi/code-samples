<?php
/**
 * Kings Court block template
 *
 * @package skykingfireworks/blocks/kings-court
 * @since 1.0.0
 */

$field_objecs        = get_field_objects();
$kings_court_title   = get_field( 'kings_court__title' ) ? get_field( 'kings_court__title' ) : $field_objecs['kings_court__title']['default_value'];
$kings_court_content = get_field( 'kings_court__content' ) ? get_field( 'kings_court__content' ) : $field_objecs['kings_court__content']['default_value'];
$main_logo           = get_field( 'main_logo', 'option' );
?>

<section class="kings-court">
    <div class="container">
        <div class="kings-court__wrapper">
            <img src="<?php echo esc_url( $main_logo ); ?>" alt="Logo" class="kings-court__logo">
            <h2 class="kings-court__title"><?php echo esc_html( $kings_court_title ); ?></h2>
            <p class="kings-court__content"><?php echo esc_html( $kings_court_content ); ?></p>
        </div>
    </div>
</section>
