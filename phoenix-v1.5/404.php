<?php
global $fwp_do_skip_menu;

$fwp_do_skip_menu = (isset($fwp_data['e404_menu']) && $fwp_data['e404_menu'] == 1)? false : true;
get_header();
$img = (isset($fwp_data['e404_bg']['url']))? esc_url($fwp_data['e404_bg']['url']) : '';
$introLogo = (isset($fwp_data['e404_logo']['url']))? esc_url($fwp_data['e404_logo']['url']) : '';
if(isset($fwp_data['e404_override']) && $fwp_data['e404_override'] == 1 && $fwp_data['e404_page_id'] != ''){
	$page = get_page($fwp_data['e404_page_id']);
	echo (isset($page->post_content))? apply_filters('the_content', $page->post_content) : '';
}else {
?>
        <section id="intro" class="no-bg-color default-404" style="background-image:url(<?php echo esc_url($img); ?>); background-attachment:fixed; background-size:cover;height:100%;">
            <div class="black-overlay"></div>
            <div class="container valign">
                <div class="row">
                <?php if($introLogo != ''): ?>
                    <div class="col-md-12">
                        <img src="<?php echo esc_url($introLogo); ?>" class="img-responsive center-block introLogo" alt="Intro Logo">
                    </div>
                <?php endif; 
					echo (isset($fwp_data['e404_text']))? $fwp_data['e404_text'] : '<h1 class="error-not-found-title">'.__( 'Oops...', 'fastwp' ).'</h1>' . '<h2 class="error-not-found-text">'.__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fastwp' ).'</h2>' ;
                ?>
                </div>
            </div>
        </section>
<?php
}
get_footer();
