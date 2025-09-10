<?php
/**
 * Main Slider template
 *
 * @package skykingfireworks/blocks/main-slider
 * @since 1.0.0
 */

$slides = get_field('main-slider__slides');

?>

<section class="main-slider">
    <div class="swiper main-slider-swiper" data-main-slider>
        <div class="swiper-wrapper">
            <?php if (empty($slides)) : ?>
                <div class="swiper-slide main-slider-slide" data-main-slider-slide 
                     style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/blocks/banner/banner-background.jpg'); ?>');">
                    <h3 class="main-slider-slide__title animate-item">No Info</h3>
                </div>
            <?php else : ?>
                <?php foreach ($slides as $slide) : ?>
                    <?php
                        $background_image = !empty($slide['main-slider__background_image']) ? esc_url($slide['main-slider__background_image']) : esc_url(get_template_directory_uri() . '/assets/images/blocks/banner/banner-background.jpg');
                        $mobile_background_image = !empty($slide['main-slider__mobile_background_image']) ? esc_url($slide['main-slider__mobile_background_image']) : $background_image;
                        $adaptive_background_image = wp_is_mobile() ? $mobile_background_image : $background_image;
                        $text_title = !empty($slide['main-slider__text_title']) ? esc_html($slide['main-slider__text_title']) : '';
                        $text_description = !empty($slide['main-slider__text_description']) ? esc_html($slide['main-slider__text_description']) : '';
                        $button_text = !empty($slide['main-slider__button_text']) ? esc_html($slide['main-slider__button_text']) : '';
                        $button_link = !empty($slide['main-slider__button_link']) ? esc_url($slide['main-slider__button_link']) : '#';
                    ?>

                    <div
                        class="swiper-slide main-slider-slide <?php echo !empty($slide['main-slider__slide_with_text']) ? 'main-slider-slide--content' : ''; ?>"
                        data-main-slider-slide
                        style="background-image: url('<?php echo esc_url($background_image); ?>');"
                    >
                        <div class="main-slider-slide__mobile_image" style="background-image: url('<?php echo esc_attr( $mobile_background_image ); ?>')"></div>
                        <?php if (!empty($slide['main-slider__slide_with_text'])) : ?>
                            <div class="main-slider-slide__content">
                                <?php if ($text_description) : ?>
                                    <p class="main-slider-slide__description animate-item">
                                        <?php echo $text_description; ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($text_title) : ?>
                                    <h3 class="main-slider-slide__title animate-item">
                                        <?php echo $text_title; ?>
                                    </h3>
                                <?php endif; ?>
                                <?php if ($button_text) : ?>
                                    <a href="<?php echo $button_link; ?>" class="custom-button animate-item" onclick="event.stopPropagation();">
                                        <?php echo $button_text; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <?php if ($button_text) : ?>
                                <a href="<?php echo $button_link; ?>" class="custom-button animate-item" onclick="event.stopPropagation();">
                                    <?php echo $button_text; ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="swiper-pagination" data-main-slider-pagination></div>
    </div>
</section>
