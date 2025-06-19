<?php
/**
 * Tags filter for support posts.
 *
 * @var $this->tags WP_Term[] Support post tags.
 *
 * @package gop
 */

?>
<div class="tags-wrap">
	<ul>
		<?php foreach ( $this->tags as $item ) : ?>
			<li>
				<a href="#" data-tag="<?php echo esc_attr( $item->slug ); ?>"><?php echo esc_attr( $item->name ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
