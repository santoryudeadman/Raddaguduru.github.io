<?php
/**
 * The template for displaying posts in the Video post format
 */
global $fwp_data;
?>
<div class="post-not-found"> <!-- Post item -->

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'fastwp' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fastwp' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fastwp' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
</div> <!-- Post item -->