<?php

if (!function_exists('fastwp_is_blog')) {

	function fastwp_is_blog() {
		if (!is_front_page() && is_home())
			return TRUE;
	}

}

if (!function_exists("fastwp_blog_type")) {
	function fastwp_blog_type() {
		global $fwp_data;
		if(is_single())
		return "blogPost3"; 
		if (isset($_GET['blog_type'])) {

			switch($_GET['blog_type']) {
				case 1 :
					return "blogPost3";
					break;
				case 2 :
					return "blogPost2";
					break;
				case 3 :
					return "blogPost";
					break;
			}
		}
		return (isset( $fwp_data['fwp_blog_type']))?  $fwp_data['fwp_blog_type'] : "blogPost";
	}
}

if (!function_exists("fastwp_sidebar_position")) {
	function fastwp_sidebar_position() {
		global $fwp_data;
		if (isset($_GET['sidebar_position'])) {
				return $_GET['sidebar_position'];
		}
		return (isset( $fwp_data['fwp_sidebar_pos']))?  $fwp_data['fwp_sidebar_pos'] : "right";
	}
}
if (!function_exists("fastwp_blog_wrapper")) {
	function fastwp_blog_wrapper() {
		switch(fastwp_blog_type()) {
			case "blogPost" :
				return "blogPostsWrapper";
				break;
			case 'blogPost2' :
				return "blogPostsWrapper2";
				break;
		}
	}

}
if (!function_exists('fastwp_grid_sizer')) {

	function fastwp_grid_sizer() {
		switch(fastwp_blog_type()) {
			case "blogPost" :
				return "grid-sizer-blog-3";
				break;
			case 'blogPost2' :
				return "grid-sizer-blog-2";
				break;
		}
	}
}

if ( ! function_exists( 'fastwp_category_list' ) ) {
	function fastwp_category_list($strip_tags = false)
	{
		$categories_list= get_the_category_list( __( ' / ', 'fastwp' ) );
		if($strip_tags == true) {
			echo strip_tags($categories_list);
		}else {
			echo $categories_list;
		}
	}
}
if ( ! function_exists( 'fastwp_post_title' ) ) {
	function fastwp_post_title()
	{
		global $post; 
		if(!isset($post->ID)) return;
		if(!is_single()){
			$html = '<%s><a href="%s" alt="%s"%s> %s </a></%s>';
			if("blogPost3" == fastwp_blog_type()){
				$tag = 'h2';
			}else{
				$tag = 'h3';
			}
			return sprintf($html, $tag, get_permalink($post->ID), $post->post_title, ( is_archive() ? ' target="_blank"' : '' ), apply_filters('the_title',$post->post_title), $tag );
		}else{
			$html =  '<h2>%s</h2>';
			return sprintf($html,$post->post_title);
		}
	}
}


if ( ! function_exists( 'post_link_attributes' ) ) :
add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');
 
function post_link_attributes($output) {
	global $fwp_post_navigation_style;
	if($fwp_post_navigation_style == 2){
		$code = 'class="new-style-nav"';
	}
	else {
		$code = 'class="btn btn-default btn-black"';
	}
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}
endif;

if ( ! function_exists( 'fastwp_post_nav' ) ) :
function fastwp_post_nav(){
	fastwp_set_navigation_style(1);
	echo '<div class="clearfix paginationRow">';
ob_start();
previous_post_link( '<div class="col-xs-6">%link</div>', 'Prev');
$prev = ob_get_clean();
$class = (strlen($prev) > 5)? 'col-xs-6' : 'col-xs-12';
echo $prev;
next_post_link( '<div class="'.$class.' text-right">%link</div>', 'Next' );
echo '</div>';
}
endif;

if ( ! function_exists( 'fastwp_post_nav_arrow' ) ) :
function fastwp_post_nav_arrow($grid_action){
	fastwp_set_navigation_style(2);
	echo '<div class="row PaddingTop30">';
		previous_post_link( '<div class="col-xs-4">%link</div>', '<i class="fa fa-angle-left fa-2x"></i>');
		echo '<div class="col-xs-4 text-center"><a href="'.$grid_action.'"><i class="fa fa-th fa-2x"></i></a></div>';
		next_post_link( '<div class="col-xs-4 text-right">%link</div>', '<i class="fa fa-angle-right fa-2x"></i>' );
	echo '</div>';
}
endif;

if ( ! function_exists( 'fastwp_get_category_list' ) ) :
function fastwp_get_category_list($id = null, $separator = ' / '){
	$id = ($id != null)? $id : get_the_ID();
	$tl = wp_get_object_terms($id, 'portfolio-category');
	$cats 		= array();
	foreach($tl as $term){
		$cats[] = $term->name;
	}
	return implode($separator, $cats);
}

endif;

if ( ! function_exists( 'fastwp_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function fastwp_paging_nav() {
	global $wp_query;
	if ( $wp_query->max_num_pages < 2 )
		return;
		$nextpostlink =  explode('"', get_next_posts_link());
		$nextpostlink = (isset($nextpostlink[1]))? $nextpostlink[1] : false;
		$previouspostlink = explode('"', get_previous_posts_link());
 		$previouspostlink = (isset($previouspostlink[1]))? $previouspostlink[1] : false;
	?>
	    <hr>
		<div class="row">
			<br>
			<br>
			<?php 
			$has_prevlink = false;
			if ( get_previous_posts_link() ) : ?>
				<div class="col-xs-6">
					<a class="btn btn-default btn-black" href="<?php echo $previouspostlink; ?>"> <?php _e('&lt; Previous','fastwp'); ?></a>
				</div>
			<?php 
			$has_prevlink = true;
			endif; ?>
			<?php if ( get_next_posts_link() ) : 
				$classNum = ($has_prevlink)? 6 : 12;
			?>
				<div class="col-xs-<?php echo $classNum; ?> text-right">
					<a class="btn btn-default btn-black" href="<?php echo $nextpostlink; ?>"> <?php _e('Next &gt;','fastwp'); ?></a>
				</div>
			<?php endif; ?>
		</div>
		
	<?php
}
endif;

if ( ! function_exists( 'fastwp_video_post' ) ) :

function fastwp_video_post() {
        global $post;
        $url = get_post_meta( $post->ID, 'post-video-url', true );
        $html = get_post_meta( $post->ID, 'post-video-html', true );

        if( !empty( $html ) ) {
            return $html;
        }

    	if( preg_match( '/http(s)?:\/\/(www.)?youtube.com/i', $url ) ) {
    	    preg_match( '/http(s)?:\/\/(www.)?youtube.com\/watch\?v=([a-z0-9-_]+)/i', $url, $video );
            if( isset( $video[3] ) ) {
                $url = 'https://www.youtube.com/embed/' . $video[3];
            }
    	} else if( preg_match( '/http(s)?:\/\/(www.)?youtu.be/i', $url ) ) {
    	    preg_match( '/http(s)?:\/\/(www.)?youtu.be\/([a-z0-9-_]+)/i', $url, $video );
            if( isset( $video[3] ) ) {
                $url = 'https://www.youtube.com/embed/' . $video[3];
            }
    	} else if( preg_match( '/http(s)?:\/\/(www.)?vimeo.com/i', $url ) ) {
    	    preg_match( '/http(s)?:\/\/(www.)?vimeo.com\/([0-9]+)/i', $url, $video );
            if( isset( $video[3] ) ) {
                $url = 'https://player.vimeo.com/video/' . $video[3];
            }
    	}

        if( !empty( $url ) ) {
            return $url;
        }
    	return;
}
endif;

if(!function_exists("fastwp_gallery_post")):
	
	function fastwp_gallery_post() {
		global $post; 
		if(!isset($post->ID)) return;

        $items = get_post_meta( $post->ID, 'post-gallery', true );

		$gallery = '';

		$posturl = !is_single() ? get_permalink( $post->ID ) : '#';

		if( !empty( $items ) ) {

			foreach( $items as $photo ) {

				if( !isset( $photo['image'] ) ) continue;

				$gallery .= '<a href="' . $posturl . '">
                               <img class="img-responsive" src="' .esc_url( $photo['image'] ) .' " alt="image">
                            </a>';
			}

		}

		if( $gallery != ' ') return sprintf( '<div id="owl-blog-single" class="owl-carousel">%s</div>', $gallery );
	   return false;

	}
endif;

if ( ! function_exists( 'fastwp_audio_post' ) ) :
	function fastwp_audio_post() {
		global $post; 
		if(!isset($post->ID)) return;
        $url = get_post_meta( $post->ID, 'post-audio-url', true );
        if( !empty( $url ) ) {
            return $url;
        }
		 return false;
	}
endif;

if(!function_exists('fastwp_blog_header')){
	function fastwp_blog_header($type){
		global $fwp_data;

		if(isset($fwp_data['fwp_show_blog_hero']) && $fwp_data['fwp_show_blog_hero'] == 0){
			return '<div style="height:150px; width:100%"></div>';
		}

		$img = '<img src="'.get_template_directory_uri().'/assets/img/separatorBlack.png" class="img-responsive center-block separator" alt="separator">';
		$description  = (isset($fwp_data['fwp_blog_description_page']) && !empty($fwp_data['fwp_blog_description_page']))? FastWP::getPageContent($fwp_data['fwp_blog_description_page'], true) : '';
		switch ($type) {
			case 'tag':
				$title = sprintf( __( 'Tag Archives: %s', 'fastwp' ), single_tag_title( '', false ) );
				break;
			case 'category':
				$title  = sprintf( __( 'Category Archives: %s', 'fastwp' ), single_cat_title( '', false ) );
				break;
			case 'archive':
				switch (TRUE) {
					case is_day():
						$title = sprintf(__( 'Daily Archives: %s', 'fastwp' ),get_the_date());
						break;
					case is_month():
						$title = sprintf( __( 'Monthly Archives: %s', 'fastwp' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'fastwp' ) ) );
						break;
					case is_year():
						$title = sprintf( __( 'Yearly Archives: %s', 'fastwp' ), get_the_date( _x( 'Y', 'yearly archives date format', 'fastwp' ) ) );
						break;
					default:
						$title = __( 'Archives', 'fastwp' );
						break;
				}
				break;
			case 'author':
				$title = sprintf( __( 'All posts by %s', 'fastwp' ), '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a>' );
				break;
			default:
				$title = (isset($fwp_data['fwp_default_blog_title']) && !empty($fwp_data['fwp_default_blog_title']))? esc_attr($fwp_data['fwp_default_blog_title']) : __('Blog','fastwp');
				break;
		}

		$title_markup = '<h2 data-scroll-reveal="enter top move 10px over 1s after 0.2s"><span>%s</span></h2>';
		$html = '<section id="blogIntro">
            <div class="container">
                <!--header-->
                <div class="row sectionIntro">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        %s
                        %s
                        %s
                    </div>
                </div>
                <!--end header-->
            </div>

        </section>';
        $finalTitle = (isset($fwp_data['fwp_show_blog_title']) && $fwp_data['fwp_show_blog_title'] == 0)? '' : sprintf($title_markup, $title);
        if($description == '' && $finalTitle == '') return '<div class="u-top-spacing"></div>';
		return sprintf($html,$finalTitle,$description,$img);
	}
}

if(!function_exists('fastwp_post_separator')):

	  function fastwp_post_separator(){
	  	global $postcount, $wp_query;
	  	if('blogPost3' == fastwp_blog_type()){
		  	$maxposts = get_option('posts_per_page');
			$url = (defined('child_theme_url'))? child_theme_url : get_template_directory_uri(); 
			if($wp_query->current_post < $maxposts -1 &&  $wp_query->current_post < $wp_query->post_count -1 ){
				?>
					<img id="separator-<?php echo esc_attr($postcount); ?>" src="<?php echo esc_url($url); ?>/assets/img/separatorBlack.png" class="img-responsive center-block separator blogArticlesSeparator" alt="separator">
				<?php 
			}else{
				$postcount = 0;
				return FALSE;
			}
	  }
	return FALSE;
  }
endif;

if ( ! function_exists( 'fastwp_search_form' ) ) :
function fastwp_search_form( $form ) {
    $form = '
		<form role="search" method="get" id="searchform" class="form-inline form"  action="' . home_url( '/' ) . '" >
		   <div class="input-group">
			    <input type="text" name="s" value="' . get_search_query() . '" class="form-control" placeholder="'.__('SEARCH...','fastwp').'"  />
			    <span class="input-group-addon">
			    	<button class="search-button animate" type="submit" title="Start Search"><i class="fa fa-search"></i></button>
			    </span>
		    </div>
	    </form>
   ';
    return $form;
}
add_filter( 'get_search_form', 'fastwp_search_form' );
endif;

if( ! function_exists('fastwp_comment_form')):
	
	function fastwp_comment_form()
	{
		global $post; 		
		if(!isset($post->ID)) return;
		
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$user_identity = esc_attr( $commenter['comment_author']);
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$required_text = __('Field is required', 'fastwp');
		$args = array(
		  'id_form'           => 'contact_form',
		  'id_submit'         => 'submit',
		  'class_submit'     =>  'btn btn-black',
		  'title_reply'       => __( 'Leave a comment', 'fastwp' ),
		  'title_reply_to'    => __( 'Leave a Reply to %s', 'fastwp' ),
		  'cancel_reply_link' => __( 'Cancel Reply', 'fastwp' ),
		  'label_submit'      => __( 'Post Comment', 'fastwp' ),
		
		  'comment_field' =>  '<div class="col-md-12" style=""><label for="comments"  ><textarea id="comments" name="comment" cols="45" rows="8" class="comment-field" aria-required="true" placeholder="'._x( 'Comment', 'noun' ).'">' .
		    '</textarea></label></div>',
		
		  'must_log_in' => '<p class="must-log-in">' .
		    sprintf(
		      __( 'You must be <a href="%s">logged in</a> to post a comment.', 'fastwp' ),
		      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		    ) . '</p>',
		
		  'logged_in_as' => '<p class="logged-in-as">' .
		    sprintf(
		    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
		      admin_url( 'profile.php' ),
		      $user_identity,
		      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		    ) . '</p>',
		
		  'comment_notes_before' => '<p class="comment-notes" style="padding-left: 15px;"> ' .
		    __( 'Your email address will not be published.', 'fastwp' ) . ( $req ? $required_text : '' ) .
		    '</p>',
		
		  'comment_notes_after' => '<p class="form-allowed-tags" style="padding-left: 15px;">' .
		    sprintf(
		      __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
		      ' <code>' . allowed_tags() . '</code>'
		    ) . '</p>',
		
		  'fields' => apply_filters( 'comment_form_default_fields', array(
		
		    'author' =>
		      '<div class="col-md-12 name" style="">' .
		      '<label for="name" style=""> ' .
		     
		      '<input id="name" class="name-field" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		      '" size="30"' . $aria_req . '  placeholder="'. __( 'Name', 'fastwp' ).'"/></label></div>',
		
		    'email' =>
		      '<div class="col-md-6 email-filed" style=""> 
		      <label for="email">' .
		      
		      '<input id="email" class="email-field" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		      '" size="30"' . $aria_req . ' placeholder="' . __( 'Email', 'fastwp' ) . '" /></lable></div>',
		
		    'url' =>
		      '<div class="col-md-6 webiste-url" style="">
		       <label for="website">' .
		      '<input id="website" name="url" class="website-field"  type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		      '" size="30" placeholder="' .  __( 'Website', 'fastwp' ) . '" /> </label></div>'
		    )
		  ),
		);
		return comment_form( $args, $post->ID ); 
	}
endif;


add_action( 'comment_form_top', 'fastwp_pre_comment_text' );
function fastwp_pre_comment_text() {
	echo '<div class="row test">';
}
add_action( 'comment_form', 'fastwp_after_comment_text' );
function fastwp_after_comment_text() {
	echo '</div>';
}
function fastwp_comment_form_submit_button($button) {
	$button =
		'<input name="submit" type="submit" class="submit btn btn-default btn-black"  id="[args:id_submit]" value="[args:label_submit]" />' .
		get_comment_id_fields();
	return $button;
}
apply_filters('comment_form_submit_button', 'fastwp_comment_form_submit_button');


if ( ! function_exists( 'fastwp_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own fastwp_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since fastwp 1.0
 *
 * @return void
 */
function fastwp_comment( $comment, $args, $depth ) {
	global $post; 
	if(!isset($post->ID)) return;
 $GLOBALS['comment'] = $comment;
 switch ( $comment->comment_type ) :
  case 'pingback' :
  case 'trackback' :
  // Display trackbacks differently than normal comments.
 ?>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="li-comment-<?php comment_ID(); ?>">
 	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
  <p><?php _e( 'Pingback:', 'fastwp' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'fastwp' ), '<span class="edit-link">', '</span>' ); ?></p>
 <?php
   break;
  default :
  // Proceed with normal comments.

 ?>
 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment" id="li-comment-<?php comment_ID(); ?>">
 		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 gvatar">
			<?php echo get_avatar( $comment, 140); ?>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<h4 class="bold">
                <?php 
                   echo  get_comment_author();    
                 ?>
            </h4>
            <p>
            	<a>
            	 <?php printf( __( '%1$s at %2$s,', 'fastwp' ), get_comment_date('F j, Y'), get_comment_time() );?>
            	 <?php if(comments_open( $post->ID )):?>
            	</a>
						<?php echo " &#183; ";
							    echo  comment_reply_link( array_merge( $args, array( 'reply_text' =>  __( 'Reply', 'fastwp' ), 'before'=>'', 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
								endif;
		    				 ?> 
            </p>
            <div class="blogPostSeparator"></div>
            <?php if ( '0' == $comment->comment_approved ) : ?>
			     	<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fastwp' ); ?></p>
			  <?php else: ?>
			  <?php comment_text(); ?>
			  <?php endif; ?>
	      
 <?php
  break;
 endswitch; // end comment_type check
}
endif;
if(!function_exists('fastwp_comment_close_tag')):
	function fastwp_comment_close_tag(){
		 ?>
			</div></div>  
		<?php 
	}
endif;

if(!function_exists('fastwp_widgets_init')):
function fastwp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'fastwp' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'fastwp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'fastwp_widgets_init' );
endif;


if(!function_exists('fastwp_set_navigation_style')):
function fastwp_set_navigation_style( $new_style) {
	global $fwp_post_navigation_style;
	$fwp_post_navigation_style = $new_style;
}
endif;