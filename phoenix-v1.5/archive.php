<?php 
/**
 * The template for displaying Archive pages
 */
	get_header();
	echo fastwp_blog_header('archive');
	do_action('fwp_before_page_content');
	$mainContentClass = (fastwp_sidebar_position() != '' && ("blogPost2" == fastwp_blog_type() || "blogPost3" == fastwp_blog_type()) )? 'col-md-9 col-xs-12':'col-md-12';
?>
<section id="blogContent">
	<div  class="container">
		<div class="row">
			<?php if('left' == fastwp_sidebar_position() && ("blogPost2" == fastwp_blog_type() || "blogPost3" == fastwp_blog_type()) ): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			<div class="<?php echo esc_attr($mainContentClass); ?>">
				<?php if("blogPost2" == fastwp_blog_type() || "blogPost" == fastwp_blog_type() ):
				?>
				<div class="<?php echo fastwp_blog_wrapper() ?>">
					<div class="<?php echo fastwp_grid_sizer() ?>"></div>
					<?php endif; ?>
	
						<?php if ( have_posts() ) : ?>
		
						<?php /* The loop */ ?>
						<?php while ( have_posts() ) : the_post();
						?>
							<?php get_template_part('extend-helpers/content', get_post_format()); ?>
						<?php endwhile; ?>
		
						<?php else : ?>
							<?php get_template_part('extend-helpers/content', 'none'); ?>
						<?php endif; ?>
	
					<?php if("blogPost2" == fastwp_blog_type() || "blogPost" == fastwp_blog_type() ): ?>
						</div> <!-- blogWrapper -->
					<?php endif; ?>
				<?php fastwp_paging_nav(); ?>
			</div><!-- blog column size -->
			<?php if('right' == fastwp_sidebar_position() && ("blogPost2" == fastwp_blog_type() || "blogPost3" == fastwp_blog_type()) ): ?>
				<?php get_sidebar(); ?>
	   		<?php endif; ?>
		</div><!-- .row -->
	</div><!-- .container -->
</section><!-- #blogContent -->

<?php get_footer(); ?>