<?php 
 /*
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.


/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */

if (post_password_required() || (!have_comments() && !comments_open()))
	return;
?>
	<hr>
	<!-- <h6 class="blog-page-title uppercase"><?php _e('Comments','spacia') ?><small><?php printf('(%s)',get_comments_number());?></small></h6> -->
	<h3><?php printf('(%s)',get_comments_number());?> <?php _e('comments','fastwp'); ?></h3>
	

	<?php if ( have_comments() ) : ?>
		<div class="row">
			
				<?php wp_list_comments( array( 'callback' => 'fastwp_comment','end-callback' => 'fastwp_comment_close_tag', 'style' => 'div' ) ); ?>
		
		</div>
		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			
			<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'fastwp')); ?></div>
			<div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'fastwp')); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e('Comments are closed.', 'fastwp'); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	
		<?php fastwp_comment_form(); ?>
	

