<?php
class FastWP_UI {
	static function getMenu($id = '', $class = 'menu', $echo = true){
		$menu_params = array(
			'container'		=> null,
			'menu_class' 	=> $class, 
			'menu_id' 		=> $id,
			'echo'			=> $echo,
			'fallback_cb'   => array('Walker_Menu_FastWP','do_default_page_menu'),
	        'walker'  		=> new Walker_Menu_FastWP()
	    );

		$nav_menu_id = apply_filters('fastwp_filter_menu_id', 0);
		if($nav_menu_id === 0){
			$menu_params['theme_location'] = 'primary';
		} else {
			$menu_params['menu'] = $nav_menu_id;
		}
	    return wp_nav_menu($menu_params);
	} 

	static function getAffixSize(){
		global $fwp_data;
		$c_page_tpl		= (is_page() || is_single())? basename(get_page_template()) : '';

		if($c_page_tpl == 'template-one-page.php'){
			return (isset($fwp_data['fwp_affix_onepage']) && is_numeric($fwp_data['fwp_affix_onepage']))? $fwp_data['fwp_affix_onepage'] : 50;
		} elseif(is_front_page() || is_home()){
			return (isset($fwp_data['fwp_affix_home']) && is_numeric($fwp_data['fwp_affix_home']))? $fwp_data['fwp_affix_home'] : 0;
		} elseif(is_page()) {
			return (isset($fwp_data['fwp_affix_page']) && is_numeric($fwp_data['fwp_affix_page']))? $fwp_data['fwp_affix_page'] : 0;
		} else {
			return (isset($fwp_data['fwp_affix_blog']) && is_numeric($fwp_data['fwp_affix_blog']))? $fwp_data['fwp_affix_blog'] : 0;
		}

		return 0;
	}

	static function displayBorder( $echo = true){
	global $fwp_data;
	  $border_markup = (isset($fwp_data['show_border']) && $fwp_data['show_border'] == 1) ? '
	  <div class="ThickBorder">
		  <div class="left"></div>
		  <div class="right"></div>
		  <div class="top"></div>
		  <div class="bottom"></div>
	  </div><div class="borderedWrapper">' : '';
	  if($echo == false){
			return $border_markup;
		}else {
			echo $border_markup;
		};
	}

	static function displayMenu($id = '', $class = 'menu', $echo = true){
		global $fwp_data;
		$nav_affix = 'data-spy="affix"';
		$Navbar_class = (isset($fwp_data['fwp_navigation_class'])) ? $fwp_data['fwp_navigation_class'] : 'default'; 
		$Navbar_class = apply_filters('fastwp_filter_menu_class_id', $Navbar_class);
		switch ($Navbar_class) {
			case '1':
				$Navbar_class = "";
				break;
			case '2':
				$Navbar_class = "NavbarStyle2";
				$nav_affix = '';
				break;
			case '3':
				$Navbar_class = "NavbarStyle3";
				break;
			case '4':
				$Navbar_class = "NavbarStyle4";
				break;
		}
		$c_page_tpl		= (is_page() || is_single())? basename(get_page_template()) : '';
		$blank_markup 	= '<nav class="navbar navbar-default %s%s navbar-fixed-top" role="navigation" %s data-offset-top="%s"><div class="container-fluid"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="%s" %s>%s</a> </div><div class="collapse navbar-collapse navbar-right" id="navbar-collapse">%s</div> </div></nav>';
		$offset 		= UI_getAffixSize();
		$scrollOrNot 	= ($c_page_tpl == 'template-one-page.php')? ' data-scroll':'';
		$bordered 		= (isset($fwp_data['show_border']) && $fwp_data['show_border'] == 1) ? ' bordered' : '';
		$textLogoValue 	= (isset($fwp_data['fwp_text_logo']))? esc_attr($fwp_data['fwp_text_logo']) :'PHOENIX';
		$TextOrLogo 	= (isset($fwp_data['fwp_logo']) && isset($fwp_data['fwp_logo']) && !empty($fwp_data['fwp_logo']['url']))?$fwp_data['fwp_logo']: $textLogoValue;
		
		if(is_array($TextOrLogo)){
			$logoImg 	= (isset($TextOrLogo['url']))? esc_url($TextOrLogo['url']) : '';
			$extraStyle = (isset($fwp_data['fwp_margin_top_logo']) && $fwp_data['fwp_margin_top_logo'] != '0')? sprintf('style="margin-top:%spx;"', $fwp_data['fwp_margin_top_logo']):'';
			$TextOrLogo = sprintf('<img src="%s" %s>', $logoImg, $extraStyle);
		}
		$logoTargetUrl = (isset($fwp_data['fwp_logotarget']) && !empty($fwp_data['fwp_logotarget']))? $fwp_data['fwp_logotarget'] : site_url().'#';
		$menu_markup   =  sprintf($blank_markup, $Navbar_class, $bordered, $nav_affix, $offset,$logoTargetUrl,$scrollOrNot, $TextOrLogo, UI_getMenu($id, $class, false));

		if($echo == false){
			return 	$menu_markup;
		} else {
			echo 	$menu_markup;
		}
	}

	static function getFaviconUrl($echo = false){
		global $fwp_data;
		
		$favicon_url = (isset($fwp_data['fwp_favicon']) && !empty($fwp_data['fwp_favicon']))? $fwp_data['fwp_favicon']['url'] : get_template_directory_uri() .'/favicon.ico';
		if($echo == false){
			return $favicon_url;
		}else {
			echo $favicon_url;
		}
	}

	static function getPreloaderMarkup(){
		global $fwp_data;
		
		$preloaderImg = (isset($fwp_data['preloader_logo']['url']) && !empty($fwp_data['preloader_logo']['url'])) ? $fwp_data['preloader_logo']['url'] : get_template_directory_uri().'/assets/img/logoWhite.png';

        return sprintf( '<div class="ip-header">
            <div class="black-overlay"></div>
            <div class="ip-logo">
                <img class="img-responsive preloaderLogo center-block" src="%s" alt="preloader">
            </div>

            <div class="ip-loader">
                <svg class="ip-inner" width="50px" height="50px" viewBox="0 0 80 80">
                    <path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"></path>
                    <path style="stroke-dashoffset: 0; stroke-dasharray: 192.617;" id="ip-loader-circle" class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"></path>
                </svg>
            </div>
        </div>', $preloaderImg );


	}

	static function showPreloader($forceVisible = false){
		global $fwp_data;
		$forceVisible = (
				$forceVisible == true || 
				(
					isset($fwp_data['show_preloader']) && 
					$fwp_data['show_preloader'] == 1 && 
					(
						is_front_page() || 
						!isset($fwp_data['disable_inner_preloader']) || 
						(isset($fwp_data['disable_inner_preloader']) && $fwp_data['disable_inner_preloader'] != 1) 
					) && (
						UI_getPreloaderStatusForCurrentPage()
					)
				))? true : false;
		if($forceVisible == true){
			echo UI_getPreloaderMarkup();
			do_action('fwp_after_preloader');
		}
	}

	static function getPreloaderStatusForCurrentPage(){
		return true;
	}

	static function getNavMenuItems($showHome = '0'){
		/* Get data */
		$menu_locations 	= get_nav_menu_locations();
		$menu_query_args 	= array('order'=>'ASC', 'orderby'=>'menu_order', 'post_type'=>'nav_menu_item', 'post_status'=>'publish', 'output_key'=>'menu_order', 'nopaging'=>true, 'update_post_term_cache'=>false ); 
		$primary_menu		= (isset($menu_locations) && isset($menu_locations['primary']))? $menu_locations['primary'] : '';

		$primary_menu = apply_filters('fastwp_filter_menu_id', $primary_menu);
		$menu_items 		= wp_get_nav_menu_items($primary_menu, $menu_query_args );
		/* Add home button if needed */
		if($showHome === '1'){
			$menu_home_item 		= new stdClass;
			$menu_home_item->title 	= __('Home' ,'fastwp');
			$menu_home_item->url 	= home_url();
			$menu_home_item->type 	= null;
			$menu_home_item->object_id 	= null;
			$menu_home_item->menutype 	= null;
			$menu_items 			= array_merge(array($menu_home_item), $menu_items);
		}

		return $menu_items;
	}

	static function displayMultipage($menu_after_first_section=false){
		global $fwp_custom_shortcode_css;

		do_action('fastwp_before_generate_sections');
		$menu = sprintf('<header>%s</header>',UI_displayMenu('','nav navbar-nav', false));
		$sections_and_pages = UI_getNavMenuItems(0);
		if(!is_array($sections_and_pages)){
			do_action('_fastwp_no_sections_defined');
			return;
		}
		$sections_and_pages = apply_filters('fwp_filter_sections', $sections_and_pages);

		/* Remove from list individual pages */
		$sections = array();
		for($i=0;$i<count($sections_and_pages);$i++){
			$type = get_post_meta( $sections_and_pages[$i]->ID, '_menu_item_menutype', true );
			if(isset($type) && $type != '' && $type != 'page'){
				$sections[] = $sections_and_pages[$i];
			}
		}

		$sections_and_pages = $sections;
		$content = '';
		$demo_found = false;	
		for($i=0;$i<count($sections_and_pages);$i++){
	
			if(($i==0 && $menu_after_first_section==false) || ($i==1 && $menu_after_first_section==true)){
				$content .= $menu;
			}
			if($sections_and_pages[$i]->xfn == 'demo'){
				if(isset($_REQUEST['demo_id'])&&!empty($_REQUEST['demo_id'])){
		    		if($_REQUEST['demo_id'] != $sections_and_pages[$i]->object_id) {
		    			continue;
		    		}
		    	} else {
		    		if($demo_found == false){
		    			$demo_found = true;
		    		} else {
		    			continue;
		    		}
		    	}
	    	}

	    	/* Get Visual Composer meta style just if composer is installed and enabled */
	    	if(defined('WPB_VC_VERSION')){
				$fwp_custom_shortcode_css 	.= get_post_meta( $sections_and_pages[$i]->object_id, '_wpb_shortcodes_custom_css', true );
				$fwp_custom_shortcode_css 	.= get_post_meta( $sections_and_pages[$i]->object_id, '_wpb_post_custom_css', true );
			}
			/* Get page template name */
			$template 				= get_post_meta( $sections_and_pages[$i]->object_id, '_wp_page_template', true );
			/* Get section page object */
			$section_page 			= get_page($sections_and_pages[$i]->object_id);

			if($template == 'template-page-boxed.php'){
				$content_template 	= '<div class="container"><div class="row">%s</div></div>';
			}else {
				$content_template 	= '%s';
			}

            global $post;
            $post->ID               = $sections_and_pages[$i]->object_id;

			$section_ori_class		= ( $template === 'template-page-nobg.php' ? "clearfix no-bg-color" : "clearfix" );
			$section_id 			= FastWP::getMenuSectionId($sections_and_pages[$i]);
			$section_class			= apply_filters('fwp_page_class', $section_ori_class, $sections_and_pages[$i]->object_id);
			$section_content 		= sprintf($content_template, apply_filters('the_content',$section_page->post_content));
			$section_content		= apply_filters('fastwp_filter_section_content', $section_content, $sections_and_pages[$i]);
			$temp_section 			= sprintf('<section id="%s" class="%s" data-page-id="%s">%s</section>', $section_id, $section_class, $post->ID, $section_content);
			$content 				.= apply_filters('fastwp_filter_section_output', $temp_section);
			$temp_section 			= '';
			
			do_action('fwp_after_page_content', $sections_and_pages[$i]->object_id, '#'.$section_id);
		}
		
		do_action('fastwp_sections_generated');

		echo $content;
	}

	static function add_custom_css(){
		global $fwp_custom_shortcode_css, $fwp_data;
		
		$fwp_custom_shortcode_css .= (isset($fwp_data['custom_css']))? $fwp_data['custom_css'] : '';

		if(isset($fwp_data['nav_bg_color']) && !empty($fwp_data['nav_bg_color'])){
			if(is_array($fwp_data['nav_bg_color'])){
				$fwp_data['nav_bg_color'] = FastWP::hex2rgba($fwp_data['nav_bg_color']['color'],$fwp_data['nav_bg_color']['alpha']);
			}
			$fwp_custom_shortcode_css .= sprintf('nav.navbar.affix { background-color:%s;}', $fwp_data['nav_bg_color']);
			
		}

		$fwp_custom_shortcode_css .= (isset($fwp_data['fwp_preloader_svg_inner_color']))? sprintf('body .ip-header .ip-loader svg path.ip-loader-circle {stroke:%s;}', $fwp_data['fwp_preloader_svg_inner_color']) : '';
		$fwp_custom_shortcode_css .= (isset($fwp_data['fwp_preloader_bg_svg_color']))? sprintf('body .ip-header .ip-loader svg path.ip-loader-circlebg {stroke:%s;}', $fwp_data['fwp_preloader_bg_svg_color']) : '';
		$fwp_custom_shortcode_css .= (isset($fwp_data['fwp_menu_links_color']))? sprintf('.navbar-default .navbar-nav > li.active a {color:%s;}', $fwp_data['fwp_menu_links_color']['active']) : '';
		$fwp_custom_shortcode_css .= (isset($fwp_data['fwp_menu_links_color']))? sprintf('.navbar-default .navbar-nav > li.active a:hover {color:%s;}', $fwp_data['fwp_menu_links_color']['hover']) : '';
		$fwp_custom_shortcode_css .= (isset($fwp_data['fwp_menu_cotainer']))? sprintf('nav.navbar .container-fluid {max-width:%spx}', $fwp_data['fwp_menu_cotainer']) : '';
		$fwp_custom_shortcode_css .= ( isset( $fwp_data['show_border']) && $fwp_data['show_border'] == 1 ) ? ( 'body .navbar.bordered {padding-left:0px;padding-right:0px;margin-left:50px;margin-right:50px;}' ) : '';
		$fwp_custom_shortcode_css .= ( isset( $fwp_data['responsive_border']) && $fwp_data['responsive_border'] !='' ) ? 
		sprintf('@media screen and (max-width:768px) {body .navbar.bordered {margin-left:%spx!important;margin-right:%spx!important;} body .borderedWrapper {padding:%spx;} .ThickBorder .left, .ThickBorder .right {width:%spx!important;} .ThickBorder .top, .ThickBorder .bottom {height:%spx!important;}}', $fwp_data['responsive_border'], $fwp_data['responsive_border'], $fwp_data['responsive_border'], $fwp_data['responsive_border'], $fwp_data['responsive_border'] )  : '';




		if ( ! empty( $fwp_custom_shortcode_css ) ) {
			echo '<style type="text/css" data-type="vc-shortcodes-custom-css">';
			echo $fwp_custom_shortcode_css;
			echo '</style>';
		}

		$fwp_custom_shortcode_css = '';

		if(isset($fwp_data['font_montserrat']) || isset($fwp_data['font_opensans'])){
			$has_override 	= false;
			$font_override 	= '';
			$css_template 	= fwp_theme_path . '/assets/css/font.override.tpl.css';

			if(file_exists($css_template)){
				$font_override = file_get_contents($css_template);
			}

			if(isset($fwp_data['font_montserrat']['font-family']) && $fwp_data['font_montserrat']['font-family'] != 'Montserrat'){
				$font_override 	= str_replace('Montserrat', $fwp_data['font_montserrat']['font-family'], $font_override);
				$has_override 	= true;
			}

			if(isset($fwp_data['font_opensans']['font-family']) && $fwp_data['font_opensans']['font-family'] != 'Open Sans'){
				$font_override 	= str_replace('Open Sans', $fwp_data['font_opensans']['font-family'], $font_override);
				$has_override 	= true;
			}

			if(!empty($font_override) && $has_override == true):
				echo '<style type="text/css" data-type="fwp-font-override-css">';
				echo $font_override;
				echo '</style>';
			endif;
		}
	}

	static function alert($type, $message) {
		return sprintf('<div class="alert alert-%s" role="alert">%s</div>', $type, $message);
	} 
}

class Walker_Menu_FastWP extends Walker {
   var $db_fields = array(
        'parent' => 'menu_item_parent', 
        'id'     => 'db_id' 
    );
	
	function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= ' <ul class="'.fwp_menu_child_class.' level-'.($depth + 1).'" role="menu"> ';
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= ' </ul> ';
	}
	
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    	global $fwp_demo_found;
    	$c_page_tpl		= (is_page() || is_single())? basename(get_page_template()) : '';
    	if(isset($_REQUEST['demo_id'])&&!empty($_REQUEST['demo_id'])){
    		if($_REQUEST['demo_id'] != $item->object_id && $item->xfn == 'demo') {
    			return;
    		}
    	} else {
    		if($item->xfn == 'demo'){
		    	if($fwp_demo_found == false){
		    		$fwp_demo_found = true;
		    	} else {
		    		return;
		    	}
	    	}
	    }
    	if(isset($item->post_status) && isset($item->ID) && !isset($item->object_id)){
    		$item->object_id= $item->ID;
    		$item->title 	= $item->post_title;
    		$item->url 		= get_permalink($item->ID);
    	}
		$type 				= get_post_meta( $item->ID, '_menu_item_menutype', true );
		$onepage_separator 	= false;
		$onepage_section 	= false;
		if(isset($type) && $type != '' && $type != 'page'){
			$onepage_section= true;
			if($type == 'separator'){
				$onepage_separator = true;
			}
		}
		if($onepage_separator === true) return;

		$class = $liclass = '';
		
		$class = ( $item->object_id === get_the_ID() )?' active ':'';
		if(isset($item->hasChildren) && $item->hasChildren){
			$liclass 	.= ' class="dropdown parent"';
			$class 		.= ' dropdown-toggle ';
		}
		$class 	.= (isset($item->classes))? implode(' ',$item->classes) :'';

		$href 	 = ($onepage_section == true && (!isset($item->object) || $item->object != 'custom'))? sprintf('#%s', FastWP::getMenuSectionId($item)) : $item->url;
		if($href != $item->url){
			if($c_page_tpl != 'template-one-page.php'){
				$href 	= site_url() . $href;
			}
		}
		if(substr_count($class,'divider-before')){
        	$output 	.= '<li class="divider"></li>';
        }
        $output 		.= sprintf( "\n<li%s><a href='%s'%s>%s</a>",
			$liclass,
            $href,
            ' class="'.$class.'" ' . 
            ((isset($item->hasChildren) && $item->hasChildren)?' data-toggle="dropdown"':'') . 
            ((isset($item->target))?sprintf(' target="%s" ', $item->target):'') . 
            ((isset($onepage_section) && $onepage_section == true && (!isset($item->hasChildren) || !$item->hasChildren))?' data-scroll="" ':'')
            ,
            $item->title . ((isset($item->hasChildren) && $item->hasChildren)?' <span class="caret"></span>':'')
        );
        if(substr_count($class,'divider-after')){
        	$output 	.= '<li class="divider"></li>';
        }
    }
	
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		global $fwp_demo_found;
		if(isset($_REQUEST['demo_id'])&&!empty($_REQUEST['demo_id'])){
    		if($_REQUEST['demo_id'] != $item->object_id && $item->xfn == 'demo') {
    			return;
    		}
    	} else {
    		if($item->xfn == 'demo'){
		    	if($fwp_demo_found == false){
		    		$fwp_demo_found = true;
		    	} else {
		    		return;
		    	}
	    	}
	    }
		$output .= '</li>';
	}


	public static function do_default_page_menu($args = array()){
		$defaults 	= array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
		$args 		= wp_parse_args( $args, $defaults );
		$args 		= apply_filters( 'wp_page_menu_args', $args );
		$menu 		= '';
		$list_args 	= $args;

		if ( ! empty($args['show_home']) ) {
			if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
				$text = __('Home','fastwp');
			else
				$text = $args['show_home'];
			$class = '';
			if ( is_front_page() && !is_paged() )
				$class = 'class="current_page_item"';
			$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
			// If the front page is a page, add it to the exclude list
			if (get_option('show_on_front') == 'page') {
				if ( !empty( $list_args['exclude'] ) ) {
					$list_args['exclude'] .= ',';
				} else {
					$list_args['exclude'] = '';
				}
				$list_args['exclude'] .= get_option('page_on_front');
			}
		}

		$list_args['echo'] = false;
		$list_args['title_li'] = '';
		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

		if ( $menu )
			$menu = '<ul class="nav navbar-nav">' . $menu . '</ul>';

		$menu = '<div class="' . esc_attr($args['menu_class']) . '">' . $menu . "</div>\n";
		$menu = apply_filters( 'wp_page_menu', $menu, $args );
		if ( $args['echo'] )
			echo $menu;
		else
			return $menu;
	} 
}

