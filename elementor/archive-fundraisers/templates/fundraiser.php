<?php
/**
 * Single Support Post template in the widget.
 *
 * @package gop
 */

?>
<article <?php post_class(); ?>>
	<div class="heading"><a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a></div>
    <div class="content"><?php the_excerpt(); ?></div>
</article>
