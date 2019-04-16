<?php 
global $fwp_data, $wp_scripts, $wp_styles;
?>
<?php do_action('fwp_before_footer'); ?>
<section id="footer" class="dark group">
	<?php do_action('attach_footer_info_page'); ?>
    <div class="bottomLine text-center">
        <?php 
        if(isset($fwp_data['footer_back_to_top']) && $fwp_data['footer_back_to_top'] == '1'):
        $back_to_top_icon = (isset($fwp_data['fastwp_back_to_top_icon']))? $fwp_data['fastwp_back_to_top_icon'] : 'fa-angle-double-up';
        $back_to_top_text = (isset($fwp_data['fastwp_back_to_top_text']))? $fwp_data['fastwp_back_to_top_text'] : __('Back to top','fastwp');
        ?>
		<div class="backToTop">
            <a data-scroll-top href="#bigWrapper">
                <?php if($back_to_top_icon != ''): ?>
                <i class="fa <?php echo $back_to_top_icon; ?>"></i><br>
                <?php
                    endif;
                    if($back_to_top_text != ''):
                ?>
                <h5><?php echo $back_to_top_text;?></h5>
                <?php
                    endif;
                ?>
            </a>
        </div>
        <?php endif; ?>
        <?php
        if(isset($fwp_data['social-media']) && is_array($fwp_data['social-media']) && count($fwp_data['social-media']) > 0){
        ?>
        <ul class="footerSocialIcons">
        <?php
            foreach($fwp_data['social-media'] as $social_media_item){
                if($social_media_item == '') continue;
                list($icon, $url) = explode('|', $social_media_item);
                echo sprintf('<li><a href="%s" target="_blank"><i class="fa %s fa-2x"></i></a></li>', esc_url(trim($url)), esc_attr(trim($icon)));
            }
        ?>
        </ul>
        <?php } 
        if(isset($fwp_data['copyright'])){
            echo apply_filters('the_content', $fwp_data['copyright']);
        }
        ?>
    </div>
</section>
<?php
if (is_single() && isset($fwp_data['fwp_single_type'] ) && $fwp_data['fwp_single_type'] == 'image' && has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 
    $full = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    $url = (isset($full['0']))? $full[0] : ''; 
    if($url != '')
        echo "<script>jQuery(function(){ jQuery.backstretch('$url'); });</script>";
endif; ?>
<?php wp_footer(); 
if (isset($fwp_data['show_border']) && $fwp_data['show_border'] == 1) echo '</div>';
?>
</body>
</html>