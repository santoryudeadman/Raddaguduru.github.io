<?php
/**
 * The template for displaying posts in the Gallery post format
 */
global $fwp_data;
?>
<div id="post-<?php the_ID(); ?>"   <?php post_class(fastwp_blog_type()); ?> ><!-- Post item -->
	<?php $gallery  = fastwp_gallery_post(); ?>
	
	<?php if(!is_single()): ?>
		<?php if(!$gallery): ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			   <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
					<div class="post-thumbnail">
						<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
					</div>
				<?php endif; ?>
			</a>
		 <?php else:  ?>
		 		<div class="post-thumbnail glallery">
	   					<?php echo $gallery; ?>
	   			</div>
		 <?php endif; ?>
	<?php else: ?>
	   	 <?php if ($gallery) : ?>
	   		   		<div class="post-thumbnail">
	   					<?php  echo $gallery; ?>
	   				</div>
	   			<?php elseif(!(isset($fwp_data['fwp_single_type'] ) && $fwp_data['fwp_single_type']) && has_post_thumbnail() && ! post_password_required() && ! is_attachment()): ?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
				</div> 
	  		 <?php endif; ?>
	<?php  endif; ?>
	<?php get_template_part('extend-helpers/content','common' ); ?>
</div><!-- Post item -->


