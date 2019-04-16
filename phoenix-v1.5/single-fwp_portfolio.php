<?php
global $fwp_data;

$nav_style =  (isset($fwp_data['fwp_portfolio_nav_style']))? (int) $fwp_data['fwp_portfolio_nav_style'] : 1;
$grid_action = (isset($fwp_data['fastwp_portfolio_action']))? $fwp_data['fastwp_portfolio_action'] : '#';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
?>
<div id="transmitter">
<div class="container">
<?php

/* Make sure visual oomposer CSS is loaded on ajax called portfolio items */

$custom_css   = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );

if( isset( $custom_css ) && !empty( $custom_css ) ) {
    echo '<style>'.$custom_css.'</style>';
}  

the_post(); ?>
<div class="row text-center project-title" data-scroll-reveal="enter top move 30px over 1s after 0.2s">
    <br><br><br>
    <h1><?php the_title(); ?></h1>
    <p><?php echo fastwp_get_category_list(); ?></p>
</div>
<?php
the_content();
?>
</div>
<div class="is-hidden">
<?php wp_footer(); ?>
</div>
</div>
<?php
FastWP_UI::add_custom_css();
} else {
	get_header();
	the_post();
    do_action('fwp_before_page_content');
?>

<section class="project-single">

<?php

$page_boxed = get_post_meta( get_the_ID(), 'portfolio-page-layout', true );
$show_title = get_post_meta( get_the_ID(), 'portfolio-title', true );

if( empty( $page_boxed ) ) echo '<div class="container">';

if( !empty( $show_title ) ) {
?>
	<div class="row text-center project-title">

        <h1><?php the_title(); ?></h1>
        <p><?php echo fastwp_get_category_list(); ?></p>
    </div>
<?php }

the_content(); 

if( $nav_style === 1 ) {
	fastwp_post_nav();
} else {

    if( $page_boxed == 1 ) { ?>
    <div class="container gridnavigation"><hr><?php fastwp_post_nav_arrow( $grid_action ); ?></div>
    <?php } else {
        fastwp_post_nav_arrow( $grid_action );
    }
}

if( empty( $page_boxed ) ) echo '</div>'; ?>

</section>

<?php

do_action('fwp_after_page_content');
get_footer();

}
