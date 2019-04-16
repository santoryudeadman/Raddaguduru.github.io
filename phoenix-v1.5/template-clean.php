<?php
/* Template Name: Empty Page */
global $fwp_do_skip_menu;
$fwp_do_skip_menu = true;
	get_header();
	the_post();
?>
<section id="page-content">
<?php echo the_content(); ?>
</section>
<?php
	get_footer();