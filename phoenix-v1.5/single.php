<?php
/**
 * The template for displaying all single posts
 */
  get_header(); 	

do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts

  $mainContentClass = (is_active_sidebar( 'sidebar-2' )  && fastwp_sidebar_position() != '')? 'col-md-9 col-xs-12':'col-md-12';
  do_action('fwp_before_page_content');
  if(isset($fwp_data['fwp_single_type'] ) && $fwp_data['fwp_single_type'] == 'image'){
  	setup_postdata($post);
  	get_template_part('extend-helpers/bg','full-image-header');
  }else {
  	if('post'==  get_post_type()){ echo fastwp_blog_header('blog'); }
  }
?>
		<?php if('post'==  get_post_type()) : ?>
			<section id="blogContent" class="group">
				<div  class="container">
					<div class="row">
		<?php else: ?>
			<section  class="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php endif; ?>
		<?php if(is_active_sidebar( 'sidebar-2' )  && 'left' == fastwp_sidebar_position()  ): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<?php if('post'==  get_post_type()) : ?>
				<div class="<?php echo esc_attr($mainContentClass); ?>">
					<div class="blogPost3">
					    <div class="grid-sizer-blog-1"></div>
		<?php endif; ?>
	    <?php if ( have_posts() ) : ?>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				 get_template_part('extend-helpers/content', get_post_format() ); 
				?>
			<?php endwhile; ?>
			
			<?php else : ?>
				<?php get_template_part('extend-helpers/content', 'none' ); ?>
			<?php endif; ?>
		<?php if('post'==  get_post_type()) : ?>
			    <?php fastwp_paging_nav(); 
				?>
					</div><!--blogPost3-->
					<?php 
					fastwp_post_nav(); 
					comments_template(); ?>
			</div><!-- blog column size -->
		<?php endif; ?>
		
		<?php if(is_active_sidebar( 'sidebar-2' )  && 'right' == fastwp_sidebar_position() ): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<?php if('post'==  get_post_type()) : ?>
					</div><!-- .row -->
				</div><!-- .container -->
			</section><!-- #blogContent -->
		<?php else: ?>
		</section><!--section-->
		<?php endif; ?>

<?php do_action('fwp_after_page_content');
get_footer(); 