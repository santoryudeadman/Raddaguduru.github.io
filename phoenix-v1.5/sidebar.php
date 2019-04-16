<?php
/**
 * The sidebar containing the secondary widget area
 */

if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div class="sidebar-container col-md-3 col-xs-12" role="complementary">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-2'); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #tertiary -->
<?php endif; ?>