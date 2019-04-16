<?php
/**
 * The template for displaying posts in the Status post format
 */
global $fwp_data;
?>
<div id="post-<?php the_ID(); ?>"   <?php post_class(fastwp_blog_type()); ?> ><!-- Post item -->
	<?php if(!is_single()): ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		   <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
				<div class="post-thumbnail">
					<!-- <img class="img-responsive" src="img/gallery/1.jpg" alt="image"> -->
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
				</div> 
			<?php endif; ?>
		</a>
	<?php else: ?>
	   <?php if (!(isset($fwp_data['fwp_single_type'] ) && $fwp_data['fwp_single_type']) &&  has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
				<div class="post-thumbnail">
					<!-- <img class="img-responsive" src="img/gallery/1.jpg" alt="image"> -->
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
				</div> 
	   <?php endif; ?>
	<?php  endif; ?>
	<?php get_template_part('extend-helpers/content','common' ); ?> 
</div><!-- Post item -->
