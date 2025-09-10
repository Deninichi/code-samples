<?php
/**
 * Newsletter block template
 *
 * @package skykingfireworks/blocks/newsletter
 * @since 1.0.0
 */

$newsletter_heading              = get_field( 'newsletter__heading' );
$newsletter_description          = get_field( 'newsletter__description' );
$newsletter_heading_shortcode_id = get_field( 'newsletter__shortcode-id' );
$main_logo                       = get_field( 'main_logo', 'option' );

?>

<section class="newsletter">
    <div class="newsletter__wrapper">
        <div class="container">
            <div class="newsletter__content">
                <img class="newsletter__logo" src="<?php echo esc_url( $main_logo ); ?>" alt="Logo">
                <h1 class="newsletter__title">
                    <?php echo $newsletter_heading ? esc_html( $newsletter_heading ) : 'Receive Exclusive Savings in your mailbox!'; ?>
                </h1>
                <p class="newsletter__description">
                    <?php echo $newsletter_description ? esc_html( $newsletter_description ) : 'Our mailer is created and only sent once a year and includes our newest products and exclusive money saving coupons. Fill out the form and we’ll be sure to send you a mailer in May-June every year. For exclusive coupons year-round, sign up for our King’s Corner Emails and follow us on Facebook.'; ?>
                </p>
                <div class="shortcode-form">
                    <?php if ( isset( $newsletter_heading_shortcode_id ) && ! empty( $newsletter_heading_shortcode_id ) ) : ?>
                        <?php echo do_shortcode( '[contact-form-7 id="' . esc_html( $newsletter_heading_shortcode_id ) . '"]' ); ?>
                    <?php else : ?>
                        <h3 class="subscribe__unavailable">Mailbox is temporarily unavailable</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
