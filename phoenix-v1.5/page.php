<?php
	get_header();
	the_post();
	do_action('fwp_before_page_content');
?>

<section id="page-content">
	<div class="container">
		<div class="row content">
			<?php
		$temp_content = apply_filters('the_content', $post->post_content);
		$temp_content = apply_filters('fastwp_filter_section_content', $temp_content, $post);
		echo $temp_content;
		 ?>
		</div>
		<?php wp_link_pages(); ?>
	</div>
</section>

<?php
    do_action('fwp_after_page_content');
    get_footer();