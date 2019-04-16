<?php
/**
 * The template for displaying posts in the Audio post format
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(fastwp_blog_type()); ?> > <!-- Post item -->
	<?php if($audio = fastwp_audio_post()): ?>
		<iframe width="100%" height="166" scrolling="no" frameborder="no" src="//w.soundcloud.com/player/?url=<?php echo esc_url($audio); ?>&color=ff6600&auto_play=false&show_artwork=false"></iframe>
	<?php elseif ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
		</div> 
	<?php endif; ?>
	<?php get_template_part('extend-helpers/content','common' ); ?>
</div><!-- Post item -->		
