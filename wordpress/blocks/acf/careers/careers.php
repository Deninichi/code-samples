<?php
/**
 * Careers block template
 *
 * @package skykingfireworks/blocks/careers
 * @since 1.0.0
 */

$careers_title = get_field( 'careers_title' );

?>

<div class="careers">
    <div class="container">
        <div class="careers__main">
            <h1 class="careers__title"><?php echo ( $careers_title ) ? esc_html( $careers_title ) : 'Work At Sky King'; ?></h1>
            <div class='careers__list'><script type="text/javascript" src="https://app.jazz.co/widgets/basic/create/skykingfireworks" charset="utf-8"><span data-mce-type="bookmark" style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;" class="mce_SELRES_start">﻿</span></script></div>
        </div>
    </div>
</div>