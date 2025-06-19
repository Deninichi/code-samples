<?php
/**
 * Single Support Post template in the widget.
 *
 * @package gop
 */

$post_tags = wp_get_post_terms( get_the_ID(), 'support_post_tag' );
$tags_str  = '';
if ( $post_tags && ! is_wp_error( $post_tags ) ) {
    foreach ( $post_tags as $post_tag ) {
	    $tags_str .= $post_tag->slug . ',';
    }
	$tags_str = rtrim( $tags_str, ',' );
}

?>
<article <?php post_class(); ?> data-tag="<?php echo esc_attr( $tags_str ); ?>">
	<div class="heading"><a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a></div>
    <div class="content"><?php the_excerpt(); ?></div>
</article>
