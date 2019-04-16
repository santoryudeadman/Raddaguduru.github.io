<?php
global $fwp_data;

?>
<div class="post-content"><!-- Post content wrapper -->
		<div class="post-title"><!-- Post title -->
			<?php echo fastwp_post_title(); ?>
		</div><!-- Post title -->
		
		<div class="post-info"> <!-- Post meta -->
			<div class="postBy">
				<p>
					<i class="fa fa-pencil"></i>
					<?php if(!isset($fwp_data['fwp_blog_author_meta']) || (isset($fwp_data['fwp_blog_author_meta']) && $fwp_data['fwp_blog_author_meta'] != false)){
					 _e('Posted by ','fastwp'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a> <?php _e('in ','fastwp'); 
					} 
					  if(!isset($fwp_data['fwp_blog_category_meta']) || (isset($fwp_data['fwp_blog_category_meta']) && $fwp_data['fwp_blog_category_meta'] != false)){ 
					  	fastwp_category_list(); 
					  }
					  if(!isset($fwp_data['fwp_blog_date_meta']) || (isset($fwp_data['fwp_blog_date_meta']) && $fwp_data['fwp_blog_date_meta'] != false)){
					  	_e(' on ','fastwp'); 
					  	the_time( get_option( 'date_format' ) ); 
					}
					the_tags( '<span class="o-post-tags">'.__('Tags: ','fastwp'), ' / ', '</span>' ); 
					?>
				</p>
			</div>
		</div> <!-- Post meta  -->
		<img src="<?php echo get_template_directory_uri(); ?>/assets/img/lineSeparatorBlack.png" class="img-responsive blogSeparator" alt="separator">
		<!--Post content -->
		<?php if(!is_single()): ?>
			<p class="excerpt">
				<?php the_excerpt(); ?>
			</p>
		<?php else: ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fastwp' ) ); ?>
		<?php endif; ?>
	  	<?php if(!is_single()): ?>
			<a class="btn btn-default btn-black center-block" href="<?php the_permalink(); ?>"<?php echo ( is_archive() ? ' target="_blank"' : '' ); ?>><?php _e('Read More','fastwp'); ?></a>
		<?php endif; ?>
		<?php 
			if(is_single()){  wp_link_pages(array('before' => '<p class="o-post-paging">' . __( 'Pages:', 'fastwp' ), 'pagelink'=>'<span class="post-paging--page">%</span>')); }
		?>
		<!--Post content -->
</div> <!-- Post-content wrapper -->
