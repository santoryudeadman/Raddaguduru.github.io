<?php
/* Template Name: Full Width */
	global $_page_meta, $fwp_pageClass;
	get_header();
	the_post();
	do_action('fwp_before_page_content');

	$fwp_pageClass = (isset($fwp_pageClass))? ' '.$fwp_pageClass : ''; 
	$fwp_pageClass = apply_filters('fwp_page_class', 'page-content' . $fwp_pageClass);
?>
<section id="page-content" class="<?php echo esc_attr($fwp_pageClass); ?>">
<?php
//echo apply_filters('fastwp_filter_section_content', '', $post);
?>
	<div class="row content">
		<?php 
		$temp_content = apply_filters('the_content', $post->post_content);
		$temp_content = apply_filters('fastwp_filter_section_content', $temp_content, $post);
		echo $temp_content;
		 ?>
	</div>
	<?php wp_link_pages(array('before' => '<p class="o-post-paging">' . __( 'Pages:', 'fastwp'), 'pagelink'=>'<span class="post-paging--page">%</span>')); ?>
</section>
<?php
	do_action('fwp_after_page_content');
	get_footer();