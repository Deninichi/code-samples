<?php
/**
 * Contact Us block template
 *
 * @package skykingfireworks/blocks/contact-us
 * @since 1.0.0
 */

$contact_us_title           = get_field( 'contact-us__title' );
$contact_us_content         = get_field( 'contact_us__content' );
$contact_us_mobile_content  = get_field( 'contact_us_mobile__content' );
$conatact_form_shortcode_id = get_field( 'contact_us__contact_form-id' );

?>

<section class="contact-us">
    <div class="container">
        <div class="contact-us__row">
                <div class="contact-us__left">
                        <p class="contact-us__caption">Contact</p>
                        <h1 class="contact-us__title"><?php echo ( $contact_us_title ) ? esc_html( $contact_us_title ) : 'GET IN TOUCH'; ?></h1>
                        <div class="content">
                            <p class="contact-us__mobile"><?php echo ( $contact_us_mobile_content ) ? esc_html( $contact_us_mobile_content ) : 'Contact Us Description Mobile.'; ?></p>
                            <p class="contact-us__content"><?php echo ( $contact_us_content ) ? esc_html( $contact_us_content ) : 'Contact Us Description.'; ?></p>
                        </div>
                        <div class="contact-us__img">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/svg/logo-in-a-red-circle.svg' ); ?>" alt="Contact Us logo section">
                        </div>
                </div>
                <div class="contact-us__right">
                    <div class="feedback">
                        <div class="contact-us__form">
                            <?php echo ( $conatact_form_shortcode_id ) ? do_shortcode( '[contact-form-7 id="' . esc_html( $conatact_form_shortcode_id ) . '"]' ) : 'Unfortunately, the contact form is temporarily unavailable.'; ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>