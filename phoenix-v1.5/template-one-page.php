<?php
/*
Template Name: One Page
*/
get_header();
the_post();
do_action('fwp_before_page_content');
?>

<div class="multipage-container" id="top">
<?php FastWP_UI::displayMultipage(); ?>
</div>
       
<?php
do_action('fwp_after_page_content');
get_footer();