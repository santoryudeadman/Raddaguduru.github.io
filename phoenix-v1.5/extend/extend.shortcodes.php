<?php
class fwp_theme_shortcodes {
	public static function titleWithIcon($atts, $content){
		global $fwp_custom_shortcode_css;
		$atts = apply_filters('fwp_filter_shortcode_atts',$atts);
		extract(shortcode_atts(array(
			'icon'			=> 'left-bars',
			'text_position'	=> 'left',
			'animated'		=> 'true',
			'animation'		=> 'enter left move 10px over 1s after 0.2s',
			'icon_animated'	=> 'true',
			'icon_animation'=> 'enter left move 10px over 1s after 0.3s',
			'icon_color'	=> 'Black',
			'tag_name'		=> 'h2',
			'wrap_in'		=> '',
			'wrap_tag'		=> 'div',
			'custom_icon'	=> '',
			'extra_class'	=> '',
			'color'			=> '',
		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);
		$icon_animated = apply_filters('fwp_animation_enable', $icon_animated);
		$icon_src 		= wp_get_attachment_image_src($custom_icon, 'full');
		$blank_markup 	= '%s<%s class="%s" data-scroll-reveal="%s">%s</%s>%s%s';
		$icon_markup	= '%s<img src="%s" alt="" data-scroll-reveal="%s" class="img_responsive %s">%s';
		$resource_url	= (defined('child_theme_url'))? fwp_main_theme_url : get_template_directory_uri();
		$el_class 		=
		$img_class		=
		$wrap_begin		=
		$wrap_end		= '';

		if ( empty( $icon_src ) ) {
			switch( $icon ){
				case 'v-center':
					$img_src = $resource_url.'/assets/img/separator'.$icon_color.'.png';
					$img_class .= ' center-block separator ';
				break;
				default:
					$img_src = $resource_url.'/assets/img/lineSeparator'.$icon_color.'.png';
					$img_class .= ' lineSeparator ';
				break;
			}
		}
			else

		{
		switch( $icon ){
				case 'v-center':
					$img_src = $icon_src[0];
					$img_class .= ' center-block separator ';
				break;
				default:
					$img_src = $icon_src[0];
					$img_class .= ' lineSeparator ';
				break;
			}
		}

		switch($text_position){
			case 'right':
				$el_class = 'text-right';
			break;
			case 'center':
				$el_class = 'text-center';
			break;
			default:

			break;
		}

		if($wrap_in != ''){
			$wrap_begin = sprintf('<%s class="%s">', $wrap_tag, $wrap_in);
			$wrap_end	= sprintf('</%s>', $wrap_tag);
		}

		if($color != ''){
			$rnd = rand(10000,99999);
			$cls = 'fwp_cst_title'.$rnd;
			$fwp_custom_shortcode_css .= sprintf('.%s { color:%s !important; } ', $cls, $color);
			$el_class .= ' '.$cls;
		}

		$icon_output = sprintf($icon_markup, $wrap_begin, $img_src, ($icon_animated == 'true')? $icon_animation:'', $img_class, $wrap_end);
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($blank_markup, $wrap_begin, $tag_name, $el_class, ($animated == 'true')? $animation:'', $content, $tag_name, $icon_output, $wrap_end);
	}

	public static function separator($atts, $content){
		extract(shortcode_atts(array(
			'style'			=> 'zig-zag',
			'icon_color'	=> 'Black',
			'offset_bottom'	=>'',
			'offset_top'	=>'',
			'wrap_in'	=>'',
		), $atts));

		$resource_url	= (defined('child_theme_url'))? fwp_main_theme_url : get_template_directory_uri();
		$custom_id		= '';
		if($offset_bottom != '' || $offset_top != ''){
			$rand_id 	= rand(10000,99999);
			$custom_id 	= ' id="fwp_sep_'.$rand_id.'"';
			global $fwp_custom_shortcode_css;
			$fwp_custom_shortcode_css 		.= "#fwp_sep_$rand_id { ";
				$fwp_custom_shortcode_css 	.= ($offset_bottom != '')? 	sprintf('margin-bottom:%spx;', 	intval($offset_bottom)) : '';
				$fwp_custom_shortcode_css 	.= ($offset_top != '')? 	sprintf('margin-top:%spx;', 		intval($offset_top)) 	: '';
			$fwp_custom_shortcode_css 		.= '}';
		}

		switch($style){
			case '':

			break;
			default:
				$img_src 	= $resource_url.'/assets/img/separator'.$icon_color.'.png';
				$html 		= sprintf('<div class="separator-custom talign-center %s"%s><img src="%s"></div>', $wrap_in . ' ' . $style, $custom_id, $img_src);
			break;
		}

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return $html;
	}

	public static function message($atts, $content){
		extract(shortcode_atts(array(
			'type'			=> 'success',
			'dismissible'	=> 'false',
		), $atts));
		if(!in_array($type, array('success','info','warning','danger'))){
			return FastWP_UI::alert('warning', sprintf(__('Used <b>[fastwp-message]</b> shortcode with incorrect type parameter (<i><b>%s</b></i>)', 'fastwp'),$type));
		}

		$class = 'alert-'.$type;
		$class .= ($dismissible == 'true')?' alert-dismissible':'';
		$html_dismiss = ($dismissible == 'true')? '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' : '';
		$html = '<div class="alert %s" role="alert">%s %s</div>';

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($html, $class, $html_dismiss, do_shortcode($content));
	}

	public static function gMap($atts, $content){
		global $fwp_data, $fwp_custom_js;

		extract( shortcode_atts(array(
			'center'		=> '44.434596,26.080533',
            'pins'          => '',
			'map_style'		=> 'fastwp',
			'map_zoom'		=> '8',
			'map_izoom'		=> '12',
            'extra_class'   => ''
		), $atts ) );

        $pins = vc_param_group_parse_atts( $pins );

        if( empty( $pins ) ) {
            return ;
        }

        $mapId = 'map' . rand( 1, 99999 );

        $pin_list = array();

        foreach( $pins as $pin ) {
            $marker_pos = explode( ',', $pin['marker_addr'] );
    		$fwp_custom_js[$mapId]['gmap_marker_title'][]  = $pin_title = esc_html( $pin['marker_title'] );
    		$fwp_custom_js[$mapId]['gmap_marker_addrs'][]  = $marker_lat_lng = array_map( 'trim', $marker_pos );
    		$fwp_custom_js[$mapId]['gmap_marker_ct'][]     = esc_html( $pin['marker_content'] );
            //$fwp_custom_js[$mapId]['gmap_marker'][]        = self::get_pin_style( $pin['marker_image'] );
            $pin_list[] = array( 'title' => $pin_title,
                                 'lat' => $marker_lat_lng[0],
                                 'lng' => $marker_lat_lng[1]
                                );
        }

		$map_center_pos = explode( ',', $center );
		$fwp_custom_js[$mapId]['gmap_center']      = $center_lat_lng = array_map( 'trim', $map_center_pos );
		$fwp_custom_js[$mapId]['gmap_style'] 		= $map_style;
		$fwp_custom_js[$mapId]['gmap_zoom'] 		= $map_zoom;
		$fwp_custom_js[$mapId]['gmap_izoom'] 		= $map_izoom;

		do_action( 'fwp_enqueue_script', 'googleMapInit,//maps.googleapis.com/maps/api/js?key=' . ( !empty( $fwp_data['fwp_gmap_key'] ) ? esc_html( $fwp_data['fwp_gmap_key'] ) : '' ) );

        return '<div class="map-container' . ( !empty( $extra_class ) ? ' ' . esc_attr( $extra_class ) : '' ) . '">
        <div class="fwp-map" data-mapId="' . $mapId . '"></div>
        </div>';
	}

	public static function titleWithBorder($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'text_position'	=> 'center',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'color'			=> '#333',
			'border_width'	=> '10',
			'border_color'	=> '#282828',
			'tag'			=> 'h2',
			'hide_border'	=> 'false',
			'responsive_border'	=> 'true',
			'extra_class'	=> '',

		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);
		$extra_class .= ' talign-'.$text_position;
		$title_with_border_id = 'title-with-border-'.rand(1000,9999);
		$extra_class .= ($hide_border == 'true')? ' hide-border': '';
		$extra_class .= ($responsive_border == 'true')? ' dyn-border': '';
		$blank_markup = '<%s id="%s" class="bordered-title %s" %s><span>%s</span></%s>';
		$fwp_custom_shortcode_css .= sprintf('#%s span {border-width %spx;border-color:%s;color:%s;}',$title_with_border_id,$border_width,$border_color,$color);
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);return sprintf($blank_markup, $tag, $title_with_border_id, $extra_class, ($animated=='true')?sprintf('data-scroll-reveal="%s"', $animation):'', $content, $tag);
	}

	public static function blockquote($atts, $content){
		extract(shortcode_atts(array(
			'style'			=> 'left',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'extra_class'	=> '',
		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);

		$tag 			= 'blockquote';
		$blank_markup 	= '<%s class="fwp-quote %s" %s>%s</%s>';

		if($style	== 'right'){
			$extra_class 	.= 'blockquote-reverse';
		}

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup,  $tag, $extra_class, ($animated=='true')? sprintf('data-scroll-reveal="%s"', $animation) : '', apply_filters('the_content',$content), $tag);
	}

	public static function aboutItem($atts, $content){
		extract(shortcode_atts(array(
			'animated'		=> 'true',
			'animation'		=> 'enter left move 5px over 1s after 0.6s',
			'layout'		=> 'icon-side',
			'icon'			=> 'fa-code',
			'title'			=> '',
			'extra_class'	=> '',
		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$icon_provider 	= (substr($icon, 0,2) == 'fa')? 'fa' : 'glyphicon';

		$blank_markup 	= '<div class="aboutItem %s clearfix" %s>
                        <div class="aboutIconWrapper" data-stellar-ratio="1.05">
                            <i class="%s %s aboutIcon"></i>
                        </div>
                        <div class="aboutText">
                            <h4>%s</h4>
                            <div class="aboutSeparator"></div>
                            <p>
                                %s
                            </p>
                        </div>
                    </div>';
        $blank_markup_icontop = '<div class="clearfix text-center AboutIconWrapper2 %s" data-scroll-reveal="%s">
                        <div class="AboutIcon2">
                            <i class="%s %s"></i>
                        </div>
                        <div class="">
                            <h4 class="NoLetterSpacing NoTransform">%s</h4>
                            <p class="PaddingHorizontal40">
                                %s
                            </p>
                        </div>
                    </div>';
		$classes = ($extra_class != '')? " $extra_class ": '';
		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return ( $layout == 'icon-top' ? sprintf($blank_markup_icontop, $classes, sprintf('data-scroll-reveal="%s"', $animation), $icon_provider, $icon, $title, do_shortcode($content)) : sprintf($blank_markup, $classes, sprintf('data-scroll-reveal="%s"', $animation), $icon_provider, $icon, $title, do_shortcode($content)) );

	}

	public static function portfolio_overlay_markup(){
		global $fwp_data;
		$close_icon = (isset($fwp_data['fwp_portfolio_close_icon']['url']) && !empty($fwp_data['fwp_portfolio_close_icon']['url']))? ($fwp_data['fwp_portfolio_close_icon']['url']) : fwp_main_theme_url.'/assets/img/xsep.png';
		$_close_markup_top = $_close_markup_bottom = '';
		$close_option = (isset($fwp_data['fwp_portfolio_close_position']) && !empty($fwp_data['fwp_portfolio_close_position'])) ? ($fwp_data['fwp_portfolio_close_position']) : 1 ;
		switch ($close_option) {
		case 1:
			$_close_markup_top 	= '<div class="col-md-12 overlaytop"><a class="overlay-close top"><br><br><img class="img-responsive center-block loader-img" src="'.$close_icon.'" alt="close image"  data-toggle="tooltip" title="Close"><span class="js-loading-msg  project__loading-msg" style="display: none">Loading Project</span></a></div>';
		break;
		case 2:
			$_close_markup_bottom 	= '<div class="col-md-12 overlaybottom"><a class="overlay-close bottom"><br><br><img class="img-responsive center-block loader-img" src="'.$close_icon.'" alt="close image"  data-toggle="tooltip" title="Close"></a></div>';
		break;
			case 3:
			$_close_markup_top 	= '<div class="col-md-12 overlaytop"><a class="overlay-close top"><br><br><img class="img-responsive center-block loader-img" src="'.$close_icon.'" alt="close image"  data-toggle="tooltip" title="Close"><span class="js-loading-msg  project__loading-msg" style="display: none">Loading Project</span></a></div>';
			$_close_markup_bottom 	= '<div class="col-md-12 overlaybottom"><a class="overlay-close bottom"><br><br><img class="img-responsive center-block loader-img" src="'.$close_icon.'" alt="close image"  data-toggle="tooltip" title="Close"></a></div>';

		break;
		}

		echo sprintf('<div class="container overlay overlay-slidedown  js-project-overlay"><div class="row">%s<div class="overlay-section"></div>%s</div></div>',
		$_close_markup_top,
		$_close_markup_bottom
		);
	}

/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

		public static function myPostGrid($atts, $content){
		global $fwp_custom_js;
		extract(shortcode_atts(array(
			'animated'		=> 'true',
			'animation'		=> 'enter bottom move 10px over 1s after 0.2s',
			'classes'		=> 'col-md-6 col-sm-6 col-xs-12',
			'layout'		=> 'masonry',
			'boxed'			=> 'no',
			'styleid'		=> '0',
			'show_filters'	=> 'yes',
			'filter_col'	=> '',
			'filter_bg'		=> '',
			'filter_col_hov'=> '',
			'extra_class'	=> '',
			'cont_class'	=> 'container portfolio-boxed',
			'all_label'		=> '',
			'button_label'	=> 'More',
			'orderby' 		=> 'menu_order',
	      	'cat_orderby' 	=> 'count',
		  	'hide_empty'	=> 0,
		  	'hide_filters'	=> 'no',
		  	'show_overlay' 	=> 'no',
			'include'		=> '',
			'exclude'		=> '',
			'exclude_cat'	=> '',
			'default_cat'	=> '*',
			'gutter_width'	=> '',
			'gutter_color'	=> ''
		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);

/**
#Region GetPortfolioItems
*/
		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'post',
			'suppress_filters'	=> '0',
			);
		if($include != ''){
			$args['include'] = $include;
		}
		if($exclude != ''){
			$args['exclude'] = $exclude;
		}
/**
#Region HandleGeneralError
*/
		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', __('Used [post_grid] shortcode but no project is added yet. <br>Please add at least one project before using this shortcode.', 'fastwp'));
		}
/**
#Region SetupDefaults
*/
		$grids 			= array('grid-sizer', 'grid-sizer-two-columns', 'grid-sizer-four-columns','no-grid');
		$classes 		= array('', 'two-columns', 'four-columns','');
		$grid 			= $grids[$styleid];
		$gal_size_class = $classes[$styleid];
		$before_items 	= '';
		$after_items 	= '';
		$styleid 		= intval($styleid);
		$excluded_cats	= (strlen(trim($exclude_cat)) > 0)? explode(',', trim($exclude_cat)) : array();
 		$items_markup 	= '';
 		$post_grid_id 	= 'fwp_post_grid_'.rand(1000,9999);
 		$fwp_custom_js['portfolio']		= (isset($fwp_custom_js['portfolio']))? $fwp_custom_js['portfolio'] : array();
 		$fwp_custom_js['portfolio'][] 	= array('exclude_cat' => $exclude_cat, 'default_cat' => $default_cat,'id'=>$post_grid_id);

		$all_projects_filter 				= new stdClass;
		$all_projects_filter->class_name 	= 'selected';
		$all_projects_filter->slug 			= '.f--all';
		$all_projects_filter->name 			= ($all_label != '')? $all_label :__('Show All','fastwpp');

		$filters_markup		= '';
		$single_filter		= '<button class="btn btn-default" data-filter="%s" data-toggle="tooltip" data-placement="top" title="%s" %s>%s</button>';

		if($boxed == 'yes'){
			$before_items 	= '<div class="'.$cont_class.'">';
			$after_items 	= '</div>';
		}
		$show_delay = 0.2;


		$item_soundcloud = '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/248496843&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';

		$item_markup 	= '<div class="gallery-inner %s %s">
						<div class="caption text-center">
	                        <div class="captionWrapper valign">
	                            <a class="%s" data-slug="%s" href="%s" data-toggle4="%s" >
	                                <div class="caption-heading">
	                                    <p>%s</p>
	                                    <h4>%s</h4>
	                                    <div class="btn btn-default">%s</div>
	                                </div>
	                            </a>
	                        </div>
	                    </div>
	                    <img alt="thumbnail" class="galleryImage" src="%s">
	                </div>';
		$item_markup_detail_1 = '
				<div class="grayBackground">
                <div class="container portfolio-boxed">
                    <div class="row">
                        <div class="col-md-6 col-sm-7 heightItem">
                            <img class="img-responsive" src="%s" alt="">
                        </div>
                        <div class="col-md-6 col-sm-5 heightItem">
                            <div class="valign">

                                    <div class="caption-heading">
                                        <h4>%s</h4>
                                        <p>%s</p>
                                        %s
                                        <a class="%s" data-slug="%s" href="%s" data-toggle2="%s">
                                            <div class="btn btn-default btn-black">%s</div>
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';

        $item_markup_detail_2 = '
				<div class="whiteBackground">
                <div class="container portfolio-boxed">
                    <div class="row">
                        <div class="col-md-6 col-sm-5 heightItem">
                            <div class="valign">

                                    <div class="caption-heading">
                                        <h4>%s</h4>
                                        <p>%s</p>
                                        %s
                                        <a class="%s" data-slug="%s" href="%s" data-toggle3="%s">
                                            <div class="btn btn-default btn-black">%s</div>
                                        </a>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-7 heightItem">
                            <img class="img-responsive" src="%s" alt="">
                        </div>
                    </div>
                </div>
            </div>
            ';

        $i = 0;
        $just_cats = array();
		foreach($items as $item){
			$category 		= '';

			$more_label 	= $button_label;
			$title 			= $item->post_title;
			$item_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
            $meta_url       = get_post_meta( $item->ID, 'post_grid-target-url', true );
			$project_url 	= !empty( $meta_url ) ? esc_url( $meta_url ) : get_permalink( $item->ID );
			$project_slug	= $item->post_name;
            $meta_opentype  = get_post_meta( $item->ID, 'post_grid-open-type', true );
			$target 		= !empty( $meta_opentype ) ? esc_html( $meta_opentype ) : 'modal';
            $meta_wide      = get_post_meta( $item->ID, 'post_grid-view-type', true );
			$wide 		    = !empty( $meta_wide ) && $layout == 'packery' ? 'wide-' . $styleid : '';

			$a_class = 'no-overlay';
			switch($target){

				case 'singlepage':
					$a_class = ' ';
				break;
				case 'new':
					$a_class = '" target="_blank';
				break;
				case 'lightbox':
					$project_url = $item_image[0];
					$a_class = 'popup-link';
				break;
				default:
				case 'modal':
					$a_class = 'normalpage';
				break;
			}

			$tl 		= wp_get_object_terms($item->ID, 'category');
			$filters 	= 'f--all ';
			$cats 		= array();

			/* go trough category list and build required strings */
			foreach($tl as $term){
				if(in_array($term->term_id, $excluded_cats)) {
					continue;
                }

                $just_cats[$term->term_id] = '';

				$filters .= ' f-'.$term->slug;
				$cats[] = $term->name;
			}
			/* Exclude projects that belongs just to excluded categories */
			if(count($cats) == 0){
				continue;
			}

			$category = implode(' / ', $cats);
			if($styleid != 3){
				$overlay_class = ($show_overlay == 'yes')? ' opaque-caption' : '';
				$overlay_class.= ($gutter_width != '') ? ' BorderedItem' :'';
	            $items_markup .= sprintf($item_markup, $gal_size_class . $overlay_class . ( !empty( $wide ) ? ' ' . $wide : '' ), $filters, $a_class, $project_slug, $project_url, $target, $category, $title, $more_label, $item_image[0]);
			} else {
				/*$item_content = apply_filters('the_content', $item->post_content);*/
				$item_content = apply_filters('the_content', $item->post_excerpt);

				if($i%2 == 0){
	           	 	$items_markup .= sprintf($item_markup_detail_1, $item_image[0], $title, $category, $item_content, $a_class, $project_slug, $project_url, $target, $more_label);
	            } else {
	            	$items_markup .= sprintf($item_markup_detail_2, $title, $category, $item_content, $a_class, $project_slug, $project_url, $target, $more_label, $item_image[0]);
				}
			}
			$i++;
		}

        if( $layout == 'packery' ) {
            $init_isotope = '{ "itemSelector": ".gallery-inner", "layoutMode": "packery", "pakery": { "columnWidth": ".%s" } }';
        } else {
            $init_isotope = '{ "itemSelector": ".gallery-inner", "masonry": { "columnWidth": ".%s" } }';
        }

		if($styleid != 3){
			$blank_markup = '<div id="%s" class="portfolio-holder">';
			$blank_markup .= ($show_filters == 'yes')? '<div class="portfolioFilters text-center"><div class="js-filters" id="filters">%s</div></div>' : '';
			$blank_markup .= '%s<div class="gallery js-isotope" data-isotope-options=\'' . $init_isotope . '\'><div class="%s"></div>%s </div>%s';
			$blank_markup .= '</div>';
		} else {
			$filters_markup = '';
			$blank_markup = '<div id="%s" class="portfolio-holder"><div class="portfolio-block">%s %s<!--  %s %s -->%s %s</div></div>';
		}


		$sc_css 		= '';
		$sc_css 		.= ($gutter_width !='') ? '.portfolio-holder .gallery-inner.BorderedItem {border: '.$gutter_width.'px solid transparent}' : '';
		$sc_css 		.= ($gutter_color !='') ? '.portfolio-holder .gallery-inner.BorderedItem {border-color: '.$gutter_color.'}' : '';

		if($filter_bg != '' || $filter_bg != '#1d1d1d'){
			$sc_css .= "#$portfolio_id .portfolioFilters { background-color: $filter_bg; }";
		}
		if($filter_col != ''){
			$sc_css 	.= "
			#$portfolio_id .portfolioFilters .btn:before,
			#$portfolio_id .portfolioFilters .btn:after { background: $filter_col; }
			#$portfolio_id .portfolioFilters .btn { color: $filter_col; }
			#$portfolio_id .portfolioFilters .btn:hover {background-color: $filter_col; }
			#$portfolio_id .portfolioFilters .btn {border-color:transparent;}
			";
		}
		if($filter_col_hov != ''){
			$sc_css 	.= "#$portfolio_id .portfolioFilters .btn:hover { color: $filter_col_hov; }";
		}

		if($sc_css != ''){
			global $fwp_custom_shortcode_css;
			$fwp_custom_shortcode_css .= $sc_css;
		}

		$categories 		= array_merge(array($all_projects_filter), get_terms(array( 'taxonomy' => 'category', 'include' => array_keys( $just_cats ), 'orderby' => $cat_orderby, 'hide_empty' => $hide_empty)));
		if(count($categories) > 0 && $show_filters == 'yes'){
			foreach ($categories as $category) {
				if(isset($category->term_id) && in_array($category->term_id, $excluded_cats))
					continue;
				$animation		 = 'enter bottom move 10px over 1s after '.$show_delay.'s';
				$final_animation = sprintf('data-scroll-reveal="%s"', $animation);
				$slug = ($category->slug != '.f--all' && $category->slug != '')? '.f-'.$category->slug : $category->slug;
				$filters_markup .= sprintf($single_filter, $slug, $category->name, $final_animation, $category->name);
				$show_delay = $show_delay + 0.2;
			}
		}

		add_action('fwp_before_footer', array('fwp_theme_shortcodes', 'portfolio_overlay_markup'));
        do_action('fwp_enqueue_script', 'scripts,jquery.matchHeight-min,jquery.plugin.min,overlay,modernizr.custom,custom,owl-carousel,owl-theme,packery-mode.pkgd.min'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		if($show_filters == 'yes'){
			return sprintf($blank_markup, $post_grid_id, $filters_markup, $before_items, $grid, $grid, $items_markup, $after_items);

		}else {
			return sprintf($blank_markup, $post_grid_id, $before_items, $grid, $grid, $items_markup, $after_items);
		}
	}


	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

	public static function myPortfolio($atts, $content){
		global $fwp_custom_js;
		extract(shortcode_atts(array(
			'animated'		=> 'true',
			'animation'		=> 'enter bottom move 10px over 1s after 0.2s',
			'classes'		=> 'col-md-6 col-sm-6 col-xs-12',
			'layout'		=> 'masonry',
			'boxed'			=> 'no',
			'styleid'		=> '0',
			'show_filters'	=> 'yes',
			'filter_col'	=> '',
			'filter_bg'		=> '',
			'filter_col_hov'=> '',
			'extra_class'	=> '',
			'cont_class'	=> 'container portfolio-boxed',
			'all_label'		=> '',
			'button_label'	=> 'More',
			'orderby' 		=> 'menu_order',
	      	'cat_orderby' 	=> 'count',
		  	'hide_empty'	=> 0,
		  	'hide_filters'	=> 'no',
		  	'show_overlay' 	=> 'no',
			'include'		=> '',
			'exclude'		=> '',
			'exclude_cat'	=> '',
			'default_cat'	=> '*',
			'gutter_width'	=> '',
			'gutter_color'	=> ''
		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);

/**
#Region GetPortfolioItems
*/
		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_portfolio',
			'suppress_filters'	=> '0',
			);
		if($include != ''){
			$args['include'] = $include;
		}
		if($exclude != ''){
			$args['exclude'] = $exclude;
		}
/**
#Region HandleGeneralError
*/
		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', __('Used [portfolio] shortcode but no project is added yet. <br>Please add at least one project before using this shortcode.', 'fastwp'));
		}
/**
#Region SetupDefaults
*/
		$grids 			= array('grid-sizer', 'grid-sizer-two-columns', 'grid-sizer-four-columns','no-grid');
		$classes 		= array('', 'two-columns', 'four-columns','');
		$grid 			= $grids[$styleid];
		$gal_size_class = $classes[$styleid];
		$before_items 	= '';
		$after_items 	= '';
		$styleid 		= intval($styleid);
		$excluded_cats	= (strlen(trim($exclude_cat)) > 0)? explode(',', trim($exclude_cat)) : array();
 		$items_markup 	= '';
 		$portfolio_id 	= 'fwp_portfolio_'.rand(1000,9999);
 		$fwp_custom_js['portfolio']		= (isset($fwp_custom_js['portfolio']))? $fwp_custom_js['portfolio'] : array();
 		$fwp_custom_js['portfolio'][] 	= array('exclude_cat' => $exclude_cat, 'default_cat' => $default_cat,'id'=>$portfolio_id);

		$all_projects_filter 				= new stdClass;
		$all_projects_filter->class_name 	= 'selected';
		$all_projects_filter->slug 			= '.f--all';
        $all_projects_filter->term_id       = 0;
		$all_projects_filter->name 			= ($all_label != '')? $all_label :__('Show All','fastwpp');

		$filters_markup		= '';
		$single_filter		= '<button class="btn btn-default" data-filter="%s" data-toggle="tooltip" data-placement="top" title="%s" %s>%s</button>';

		if($boxed == 'yes'){
			$before_items 	= '<div class="'.$cont_class.'">';
			$after_items 	= '</div>';
		}
		$show_delay = 0.2;

		$item_soundcloud = '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/248496843&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';

		$item_markup 	= '<div class="gallery-inner %s %s">
						<div class="caption text-center">
	                        <div class="captionWrapper valign">
	                            <a class="%s" data-slug="%s" href="%s" data-toggle="%s" >
	                                <div class="caption-heading">
	                                    <p>%s</p>
	                                    <h4>%s</h4>
	                                    <div class="btn btn-default">%s</div>
	                                </div>
	                            </a>
	                        </div>
	                    </div>
	                    <img alt="thumbnail" class="galleryImage" src="%s">
	                </div>';
		$item_markup_detail_1 = '
				<div class="grayBackground">
                <div class="container portfolio-boxed">
                    <div class="row">
                        <div class="col-md-6 col-sm-7 heightItem">
                            <img class="img-responsive" src="%s" alt="">
                        </div>
                        <div class="col-md-6 col-sm-5 heightItem">
                            <div class="valign">

                                    <div class="caption-heading">
                                        <h4>%s</h4>
                                        <p>%s</p>
                                        %s
                                        <a class="%s" data-slug="%s" href="%s" data-toggle="%s">
                                            <div class="btn btn-default btn-black">%s</div>
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';

        $item_markup_detail_2 = '
				<div class="whiteBackground">
                <div class="container portfolio-boxed">
                    <div class="row">
                        <div class="col-md-6 col-sm-5 heightItem">
                            <div class="valign">

                                    <div class="caption-heading">
                                        <h4>%s</h4>
                                        <p>%s</p>
                                        %s
                                        <a class="%s" data-slug="%s" href="%s" data-toggle="%s">
                                            <div class="btn btn-default btn-black">%s</div>
                                        </a>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-7 heightItem">
                            <img class="img-responsive" src="%s" alt="">
                        </div>
                    </div>
                </div>
            </div>
            ';

        $i = 0;
        $just_cats = array();
		foreach($items as $item){
			$category 		= '';

			$more_label 	= $button_label;
			$title 			= $item->post_title;
			$item_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
            $meta_url       = get_post_meta( $item->ID, 'portfolio-target-url', true );
			$project_url 	= !empty( $meta_url ) ? esc_url( $meta_url ) : get_permalink( $item->ID );
			$project_slug	= $item->post_name;
            $meta_opentype  = get_post_meta( $item->ID, 'portfolio-open-type', true );
			$target 		= !empty( $meta_opentype ) ? esc_html( $meta_opentype ) : 'modal';
            $meta_wide      = get_post_meta( $item->ID, 'portfolio-view-type', true );
			$wide 		    = !empty( $meta_wide ) && $layout == 'packery' ? 'wide-' . $styleid : '';

			$a_class = 'no-overlay';
			switch($target){

				case 'singlepage':
					$a_class = ' ';
				break;
				case 'new':
					$a_class = '" target="_blank';
				break;
				case 'lightbox':
					$project_url = $item_image[0];
					$a_class = 'popup-link';
				break;
				default:
				case 'modal':
					$a_class = 'overlay-ajax';
				break;
			}

			$tl 		= wp_get_object_terms($item->ID, 'portfolio-category');
			$filters 	= 'f--all ';
			$cats 		= array();

			/* go trough category list and build required strings */
			foreach($tl as $term){
				if(in_array($term->term_id, $excluded_cats))  {
					continue;
                }

                $just_cats[$term->term_id] = '';

				$filters .= ' f-'.$term->slug;
				$cats[] = $term->name;
			}
			/* Exclude projects that belongs just to excluded categories */
			if(count($cats) == 0){
				continue;
			}

			$category = implode(' / ', $cats);
			if($styleid != 3){
				$overlay_class = ($show_overlay == 'yes')? ' opaque-caption' : '';
				$overlay_class.= ($gutter_width != '') ? ' BorderedItem' :'';
	            $items_markup .= sprintf($item_markup, $gal_size_class . $overlay_class . ( !empty( $wide ) ? ' ' . $wide : '' ), $filters, $a_class, $project_slug, $project_url, $target, $category, $title, $more_label, $item_image[0]);
			} else {
				/*$item_content = apply_filters('the_content', $item->post_content);*/
				$item_content = apply_filters('the_content', $item->post_excerpt);

				if($i%2 == 0){
	           	 	$items_markup .= sprintf($item_markup_detail_1, $item_image[0], $title, $category, $item_content, $a_class, $project_slug, $project_url, $target, $more_label);
	            } else {
	            	$items_markup .= sprintf($item_markup_detail_2, $title, $category, $item_content, $a_class, $project_slug, $project_url, $target, $more_label, $item_image[0]);
				}
			}
			$i++;
		}


		$categories 		= array_merge(array($all_projects_filter), get_terms(array( 'taxonomy' => 'portfolio-category', 'orderby' => $cat_orderby, 'include' => implode( ',', array_keys( $just_cats ) ), 'hide_empty' => $hide_empty)));

		if(count($categories) > 0 && $show_filters == 'yes'){
			foreach ($categories as $category) {
			    if( !empty( $category->term_id ) && !in_array( $category->term_id, array_keys( $just_cats ) ) ) {
			        continue;
			    }
				if(isset($category->term_id) && in_array($category->term_id, $excluded_cats))
					continue;
				$animation		 = 'enter bottom move 10px over 1s after '.$show_delay.'s';
				$final_animation = sprintf('data-scroll-reveal="%s"', $animation);
				$slug = ($category->slug != '.f--all' && $category->slug != '')? '.f-'.$category->slug : $category->slug;
				$filters_markup .= sprintf($single_filter, $slug, $category->name, $final_animation, $category->name);
				$show_delay = $show_delay + 0.2;
			}
		}


        if( $layout == 'packery' ) {
            $init_isotope = '{ "itemSelector": ".gallery-inner", "layoutMode": "packery", "pakery": { "columnWidth": ".%s" } }';
        } else {
            $init_isotope = '{ "itemSelector": ".gallery-inner", "masonry": { "columnWidth": ".%s" } }';
        }

		if($styleid != 3){
			$blank_markup = '<div id="%s" class="portfolio-holder">';
			$blank_markup .= ($show_filters == 'yes')? '<div class="portfolioFilters text-center"><div class="js-filters" id="filters">%s</div></div>' : '';
			$blank_markup .= '%s<div class="gallery js-isotope" data-isotope-options=\'' . $init_isotope . '\'><div class="%s"></div>%s </div>%s';
			$blank_markup .= '</div>';
		} else {
			$filters_markup = '';
			$blank_markup = '<div id="%s" class="portfolio-holder"><div class="portfolio-block">%s %s<!--  %s %s -->%s %s</div></div>';
		}


		$sc_css 		= '';
		$sc_css 		.= ($gutter_width !='') ? '.portfolio-holder .gallery-inner.BorderedItem {border: '.$gutter_width.'px solid transparent}' : '';
		$sc_css 		.= ($gutter_color !='') ? '.portfolio-holder .gallery-inner.BorderedItem {border-color: '.$gutter_color.'}' : '';

		if($filter_bg != '' || $filter_bg != '#1d1d1d'){
			$sc_css .= "#$portfolio_id .portfolioFilters { background-color: $filter_bg; }";
		}
		if($filter_col != ''){
			$sc_css 	.= "
			#$portfolio_id .portfolioFilters .btn:before,
			#$portfolio_id .portfolioFilters .btn:after { background: $filter_col; }
			#$portfolio_id .portfolioFilters .btn { color: $filter_col; }
			#$portfolio_id .portfolioFilters .btn:hover {background-color: $filter_col; }
			#$portfolio_id .portfolioFilters .btn {border-color:transparent;}
			";
		}
		if($filter_col_hov != ''){
			$sc_css 	.= "#$portfolio_id .portfolioFilters .btn:hover { color: $filter_col_hov; }";
		}

		if($sc_css != ''){
			global $fwp_custom_shortcode_css;
			$fwp_custom_shortcode_css .= $sc_css;
		}

		add_action('fwp_before_footer', array('fwp_theme_shortcodes', 'portfolio_overlay_markup'));
        do_action('fwp_enqueue_script', 'scripts,jquery.matchHeight-min,jquery.plugin.min,overlay,modernizr.custom,custom,owl-carousel,owl-theme,packery-mode.pkgd.min'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		if($show_filters == 'yes'){
			return sprintf($blank_markup, $portfolio_id, $filters_markup, $before_items, $grid, $grid, $items_markup, $after_items);

		}else {
			return sprintf($blank_markup, $portfolio_id, $before_items, $grid, $grid, $items_markup, $after_items);
		}
	}

	public static function project_preloader_markup(){
		echo '
		        <div class="container overlay overlay-slidedown project-preloader">

            <div class="row">

                <div class="overlay-section"></div>

                <div class="col-md-12 ">
                    <a class="overlay-close">
                        <br><br>
                        <img class="img-responsive center-block" src="img/xsep.png" alt="close image"  data-toggle="tooltip" title="Close">
                    </a>
                </div>
            </div>
        </div>';

	}

	public static function ourTeam($atts, $content){
		extract(shortcode_atts(array(
			'layout'			=> '',
			'extra_class'		=> '',
			'animated'			=> 'true',
			'animation'			=> 'enter right move 10px over 1s after ',
			'initial_delay' 	=> '0.8',
			'increment_delay' 	=> '0.2',
			'include'			=> '',
			'exclude'			=> '',
			'autoplay' 			=> 'true',
			'show_controls' 	=> 'true',
			'stop_on_hover' 	=> 'false',
			'slider_speed'  	=> '4000'

		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);

		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_team',
			'suppress_filters'	=> '0',
			'include'			=> $include,
			'exclude'			=> $exclude,
			);


		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', __('Used [our-team] shortcode but no team member is selected. <br>Please add at least one member before using this shortcode.', 'fastwp'));
		}
		$items_markup 	= '';
		$social_item_markup = '<a href="%s" target="_blank" %s><i class="fa %s"></i></a>';
		switch ($layout) {
			case 'columns':
				$item_markup ='
						<div class="PositionRelative OverflowHidden ImagewithCaptionOverlay TeamMember text-center">
                            <div class="PositionRelative">
                                <img src="%s" class="img-responsive center-block" alt="Team Members Image">
                                <div class="TeamMemberCaption2">
                                    <div class="TeamMemberCaption2Text">
                                        <h3 class="NoLetterSpacing">%s</h3>
                                        <p class="position">
                                            <span>
                                               %s
                                            </span>
                                        </p>
                                        <p style="">%s</p>
                                        <img src="%s/assets/img/separatorBlack.png" class="img-responsive center-block separator small" alt="separator" width="170" height="12">
                                        <p class="teamSocial">
                                   		%s
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>';

			break;
			default:
		 		$item_markup 	= '
		                        <!--member-->
		                        <div class="teamMember">

		                            <div class="col-md-6 col-sm-6 col-xs-12">
		                                <img src="%s" class="center-block img-responsive" alt="Team Image">
		                            </div>

		                            <div class="col-md-6 col-sm-6 col-xs-12 memberDescription">
		                                <h2 data-scroll-reveal="enter right move 10px over 1s after 0.2s">%s</h2>
		                                <p class="position"  data-scroll-reveal="enter right move 10px over 1s after 0.4s">
		                                    <span>
		                                        %s
		                                    </span>
		                                </p>

		                                <p class="memberParagraph" data-scroll-reveal="enter right move 10px over 1s after 0.6s">
		                               %s
		                                </p>

		                                <p class="teamSocial">
		                              %s </p>

		                                <img src="%s/assets/img/lineSeparatorBlack.png" class="lineSeparator hidden-xs" alt="separator">


		                            </div>
		                        </div>
		                        <!--end member-->

                ';
				break;
         }

		foreach($items as $item){
            $role           = get_post_meta( $item->ID, 'team-role', true );
            $social_links   = get_post_meta( $item->ID, 'team-social-links', true );
			$title 			= $item->post_title;
			$item_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
			$role 			= !empty( $role ) ? esc_html( $role ) : '';
			$social_markup = '';
			$i = 0;

			if( !empty( $social_links ) && is_array( $social_links ) ) {
				foreach( $social_links as $k => $v ){
					if( substr_count( $v, '|' ) == 0 ) continue;
					$animationTime 	= $initial_delay + $i * $increment_delay;
					$finalAnimation = $animated == true ? sprintf( 'data-scroll-reveal="%s"', $animation . $animationTime . 's' ): '';
					list( $icon, $url ) = explode( '|', $v );
					$social_markup .= sprintf( $social_item_markup, $url, $finalAnimation, $icon );
				    $i++;
				}
			}
            $items_markup .= ($layout != 'columns') ? sprintf($item_markup,  $item_image[0], $title, $role, apply_filters('the_content', $item->post_content), $social_markup, fwp_main_theme_url) : sprintf($item_markup,  $item_image[0], $title, $role, apply_filters('the_content', $item->post_content), fwp_main_theme_url,$social_markup);
		}
		$blank_markup = ($layout != 'columns') ? '<div class="owl-carousel" id="owl-team" data-navigation="true" data-carousel-settings=\'%s\'> %s </div>' : '<div class="Team clearfix">%s</div>';
		$carousel_overrides = '{"autoPlay": "'.$autoplay.'", "showControls": "'.$show_controls.'", "autoPlayTimeout": "'.$slider_speed.'", "stopOnHover": "'.$stop_on_hover.'"}';
		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup,($layout != 'columns') ? $carousel_overrides : $items_markup, $items_markup);
	}

	public static function animatedText($atts, $content){
		extract(shortcode_atts(array(
			'animated'		=> 'true',
			'animation'		=> 'enter right move 10px over 1s after',
			'extra_class'	=> '',
		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);

		$module_markup 	= '<div class="fwp-text-block %s"%s>%s</div>';
		$finalAnimation = ($animated == 'true')? sprintf(' data-scroll-reveal="%s"', $animation):'';
		return sprintf($module_markup, $extra_class, $finalAnimation, do_shortcode($content));
	}

	public static function parallaxLetter($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'anim_ratio'	=> '1.5',
			'anim_offset'	=> '0',
			'hposition'		=> '50%',
			'lcolor'		=> '',
			'extra_class'	=> '',
		), $atts));
		$module_markup 	= '<h1 class="parallaxLetter %s" id="%s" data-stellar-ratio="%s" data-stellar-vertical-offset="%s">%s</h1>';
		$id = 'letter-'.rand(1000,9999);
		$other_css_definitions = ($lcolor != '')? sprintf(' color:%s;', $lcolor) : '';
		$fwp_custom_shortcode_css .= sprintf('#%s { left: %s; %s }', $id, $hposition, $other_css_definitions);
		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		return sprintf($module_markup, $extra_class, $id, $anim_ratio, $anim_offset, strip_tags($content));
	}

	public static function ourClients($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'animated'		=> 'true',
			'animation'		=> 'enter right move 10px over 1s after',
			'animation_delay_start' => '0.6',
			'animation_delay_step' 	=> '0.2',
			'animated_items'=> 3,
			'autoplay' => 'true',
			'show_controls' => 'true',
			'stop_on_hover' => 'false',
			'testimonial_slider_speed' => '4000'

		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$module_output 	= '';
		$module_markup 	= ' <div id="owl-clients" class="owl-clients owl-carousel" data-carousel-settings=\'%s\'>%s</div>';
		$item_markup 	= ' <div class="clientLogo" %s>
                                <a href="%s"><img src="%s" class="img-responsive center-block" alt="image"></a>
                            </div>';
        $items_output   = '';
		if($content != ''){
			$content = strip_tags($content);
			$clients = str_replace("\r\n", "\n", $content);
			$clients = explode("\n",$clients);
			$i = 0;
			foreach($clients as $client){
				if(trim($client) == '') continue;
				$animation_settings = '';
				if(substr_count($client, '|') != 0){
					list($img, $link) = explode('|', $client);
				}else {
					$img 	= $client;
					$link 	= 'javascript:void(0);';
				}
				if($i < $animated_items && $animated == 'true'){
					$delay =  floatval($animation_delay_start) - ($i * floatval($animation_delay_step));
					if($delay > 0)
						$animation_settings = 'data-scroll-reveal="'.$animation.' '.$delay.'s"';
				}

				$items_output .= sprintf($item_markup, $animation_settings, $link, $img);
				$i++;
			}
			$carousel_overrides = '{"autoPlay": "'.$autoplay.'", "showControls": "'.$show_controls.'", "autoPlayTimeout": "'.$testimonial_slider_speed.'", "stopOnHover": "'.$stop_on_hover.'"}';
			$module_output = sprintf($module_markup, $carousel_overrides, $items_output);
			do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
			do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
			return $module_output;
		}
		return FastWP_UI::alert('warning', __('Used [our-clients] shortcode but no client is defined. <br>Please add at least one client within this shortcode.', 'fastwp'));

	}

	public static function ourServices($atts, $content){
		extract(shortcode_atts(array(
			'title' 		=> '',
			'start_pos' 	=> 'left',
			'animated'		=> 'true',
			'animation'		=> 'enter right move 10px over 1s after',
			'extra_class'	=> '',
			'title_overlay'	=> 'true',
			'order'			=> 'DESC',
			'by'			=> 'post_date',
			'type'			=> '',
			'title_col'		=> '',
			'title_bcol'	=> '',
			'title_img'		=> '',
			'css_mode'		=> 'true',
			'include'		=> '',
			'exclude'		=> '',
		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$titleoverlay 	= '';
		global $fwp_custom_shortcode_css;
		$module_output 	= '';
		global $fwp_custom_shortcode_css;
		switch($type){
			case 'icon-top':
			case 'icon-left':
			$module_markup = '<div class="custom-services-wrap service-type-%s clearfix">%s</div>';
			$item_markup = '<div class="col-xs-12 col-sm-6 col-md-4 clearfix" %s>
                        <div class="serviceIconWrapper">
                            <div class="serviceIcon">
                                %s
                            </div>
                            <div class="simpleServiceContent">
                                <h4 %s>%s</h4>
                                <div class="aboutSeparator"></div>
                                <p>
                                    %s
                                </p>
                            </div>
                        </div>
                    </div>';

          $module_class = $type;
			break;
			case 'animated':
			$module_markup 	= '<div class="%s">%s</div>';
			$item_markup = '<div class="col-md-4 col-sm-4 col-xs-12 clearfix text-center ServiceWrapper3D" data-scroll-reveal="%s">
                        <div class="CubeEffect PositionRelative ">
                            <div class="CubeWrapper show-front">
                                <div class="ServiceWrapperIcon">
                                   	%s
                                    <h4 class="NoLetterSpacing">%s</h4>
                                </div>
                                <div class="ServiceWrapperText PositionRelative PaddingHorizontal40">
                                    <p>
                                    %s
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>';
            $module_class = 'services-wrap clearfix';
			break;
			default:
			$module_markup 	= '<div class="%s">%s</div>';
			$item_markup 	= '<div class="serviceBox %s text-center">
	                <div class="valign">
	                    <h4 %s %s>
	                        <span>%s</span>
	                    </h4>
	                    <img class="separator center-block img-responsive" src="%s" alt="separator" %s>
	                    <div class="service-text" %s>%s</div>
	                </div>
	            </div>';
	        $justIconMarkup = '<div class="serviceBox %s %s text-center"><div class="valign">%s </div></div>';
	       	$titleOverlay = ($title_overlay == 'true')? '<div class="black-overlay"></div>':'';
	       	$justTitleMarkup = '
	           <div class="serviceBox introServiceBox text-center %s">
	                %s
	                <h2 %s %s>
	                    <span>%s</span>
	                </h2>
	            </div>
	        ';
	        $module_class = 'services-wrap clearfix';
	       break;
		}

        $items_output   = '';

		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_service',
			'suppress_filters'	=> '0',
			'include'			=> $include,
			'exclude'			=> $exclude,
			'order'				=> $order,
			'orderby'			=> $by
			);


		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', __('Used [our-services] shortcode but no service is defined or selected. <br>Please add at least one service before using this shortcode.', 'fastwp'));
		}

		$i 		= 0;
		$offset = ($start_pos == 'left')? 0 : 1;
		$classes = array('whiteBox', 'blackBox');
		$alternateClass 	= $classes[0];
		$alternateClassNeg 	= $classes[1];
		$separator = fwp_main_theme_url .'/assets/img/separatorBlack.png';
		$animSectionTitle = '';

		foreach($items as $item){
			$animTitle 	= $animSeparator = $animText =$animBigIcon = '';
			$icon 		= get_post_meta( $item->ID, 'service-icon', true );
			$color 		= get_post_meta( $item->ID, 'service-icon-color', true );
			$bcolor		= get_post_meta( $item->ID, 'service-color-background', true );
			$link		= get_post_meta( $item->ID, 'service-target', true );
			$icon_alt	= get_post_meta( $item->ID, 'service-icon-replacement', true );
			$_title 	= $item->post_title;
			$text 		= (isset($item->post_excerpt) && !empty($item->post_excerpt))? apply_filters('the_content', $item->post_excerpt) : apply_filters('the_content', $item->post_content);
			$customActions = (!empty($link))? ' class="is-clickable" onclick="window.open(\''.$link.'\'); return false;"' :'';
			switch($type){
				case 'icon-top':
				case 'icon-left':
					$finalAnimation = ($animated == 'true')? sprintf('data-scroll-reveal="%s"', $animation):'';
					$icon = (!empty($icon_alt))? sprintf('<img src="%s" class="alternative-icon">', $icon_alt) : sprintf('<i class="fa %s"></i>', $icon);
					$items_output 	.= sprintf($item_markup, $finalAnimation, $icon, $customActions, $_title, $text );
				break;
				default:

					$direction 		= ($i%2+$offset == 1)? 'left':'right';
					$direction_alt 	= ($i%2+$offset == 1)? 'right':'left';

					/* Animation settings */
					$animTitle 		= 'data-scroll-reveal="enter '.$direction.' move 10px over 1s after 0.6s"';
					$animSeparator 	= 'data-scroll-reveal="enter '.$direction.' move 10px over 1s after 1s"';
					$animText 		= 'data-scroll-reveal="enter '.$direction.' move 10px over 1s after 1s"';
					$animBigIcon 	= 'data-scroll-reveal="enter '.$direction_alt.' move 10px over 1s after 0.2s"';
					$attr_animation = 'data-scroll-reveal="enter '.$direction_alt.' move 10px over 1s after 0.2s"';

					$custom_css_class = '';
					if($color != '' || $bcolor != ''){
						$rnd = rand(10000,99999);
						$custom_css_class = 'fwp-custom-srvc'.$rnd;
						$custom_css = '.'.$custom_css_class.'{';
						$custom_css .= ($bcolor != '')? sprintf('background-color: %s !important;', $bcolor):'';
						$custom_css .= '}';
						$custom_css .= '.'.$custom_css_class.' i {';
						$custom_css .= ($color != '')? sprintf('color: %s !important;', $color):'';
						$custom_css .= '}';

						$fwp_custom_shortcode_css .= $custom_css;
					}

					$icon = (!empty($icon_alt))? sprintf('<img src="%s" class="alternative-icon" %s>', $icon_alt, $animBigIcon) : sprintf('<i class="fa %s fa-4x" %s></i>', $icon, $animBigIcon);
					$added_class = '';
					if($direction_alt == 'right'){
						$added_class .= ' is-on-right';
					}
					$icon_markup = sprintf($justIconMarkup, $custom_css_class, $added_class . ' ' . $alternateClassNeg . ' ' . $i, $icon);

					if($title != '' && $i == 0){
						$rnd = rand(10000,99999);
						$extra_title_class = '';
						if($title_col != '' || $title_img != '' || $title_bcol != ''){
							if($title_img != ''){
								$title_img = wp_get_attachment_image_src($title_img, 'full');
								$title_img = $title_img[0];
							}

							$extra_title_class = 'fwp-services-custom'.$rnd;
							$custom_css = '.'.$extra_title_class.' {';
							$custom_css .= ($title_img != '')?sprintf('background-image:url(%s) !important;', $title_img):'';
							$custom_css .= '}';
							$custom_css .= '.'.$extra_title_class.' h2 span {';
							$custom_css .= ($title_col != '')?sprintf('color:%s !important;', $title_col):'';
							$custom_css .= ($title_bcol != '')?sprintf('border-color:%s !important;', $title_bcol):'';
							$custom_css .= '}';

							$fwp_custom_shortcode_css .= $custom_css;
						}

						$icon_markup = sprintf($justTitleMarkup, $extra_title_class, $titleoverlay, $attr_animation, $animSectionTitle, $title);
					}
					if($css_mode == 'true')
						$items_output .= $icon_markup;

					if($css_mode == 'false' && $i%2+$offset != 1){ $items_output .= $icon_markup; }
					$items_output 	.= sprintf($item_markup, $alternateClass. ' ' . $i, $animTitle, $customActions, $_title, $separator, $animSeparator, $animText, $text);
					if($css_mode == 'false' && $i%2+$offset == 1){ $items_output 	.= $icon_markup; }
					$i++;

		      	break;
		    	case 'animated':
		    		$finalAnimation = ($animated == 'true')? sprintf('data-scroll-reveal="%s"', $animation):'';
					$icon = (!empty($icon_alt))? sprintf('<img src="%s" class="alternative-icon">', $icon_alt) : sprintf('<i class="fa %s fa-2x"></i>', $icon);
					$items_output 	.= sprintf($item_markup, $finalAnimation, $icon, $_title, $text );
		    	break;
			}
		}
		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($module_markup, $module_class, $items_output);
	}

	public static function faIcon($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'icon'			=> '',
			'size'			=> '1x',
			'animated'		=> 'true',
			'animation'		=> 'enter left move 10px over 1s after 0.2s',
		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$blank_markup 	= '<i class="fa %s fa-%s %s" %s></i>';
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', $animation) : '';
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($blank_markup, $icon, $size, $extra_class, $finalAnimation);
	}

	public static function counter($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'title'			=> '',
			'start'			=> '0',
			'end'			=> '100',
			'speed'			=> '2000',
			'interval'		=> '10',
			'suffix'		=> '',
		), $atts));

		$item_html = '<div class="text-center timerWrapper timer-item %s" data-settings="{start:%s,max:%s,speed:%s,iterval:%s}"><h1><span class="timer">0</span> %s</h1><p>%s</p></div>';
        do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
        do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($item_html, $extra_class, $start, $end, $speed, $interval, $suffix, $title);
	}

	public static function contactInfo($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'icon'			=> '',
			'animated'		=> 'true',
			'animation'		=> 'enter left move 10px over 1s after 0.2s',
		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', $animation) : '';
		$item_html 		= '<div class="col-md-6 col-sm-6 col-xs-6 fwp-contact-info listwrapper %s" %s>
		<div class="ct-icon %s"></div><div class="infoContact">%s</div></div>';
        if(substr($icon,0,3) == 'fa-'){ $icon = 'fa '.$icon; }
        do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($item_html, $extra_class, $finalAnimation, $icon, do_shortcode($content));
	}

	public static function socialWithLink($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'icon'			=> '',
			'link'			=> '',
			'target'		=> '_blank',

		), $atts));
		$item_html = '<a class="%s social-fa-icon %s" href="%s" target="%s"></a>';

        if(substr($icon,0,3) == 'fa-'){ $icon = 'fa '.$icon; }
        do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($item_html, $extra_class, $icon, $link, $target);
	}

	public static function clearfix($atts, $content){
        do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return '<div class="clearfix group"></div>';
	}

	public static function customButtons($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'type'			=> 'success',
			'label'			=> '',
			'link'			=> '#',
			'animate'		=> 'false',
			'action'		=> '',
			'target'		=> '',
			'tag'			=> 'button',
			'align'			=> '',
		), $atts));

		$scroll = ($animate == 'true')? 'data-scroll=""' : '';
		$item_button_html = '<button type="button" class="%s fastwp btn btn-%s" onClick="%s">%s</button>';
		$item_a_html = '<a %s href="%s" class="%s fastwp btn btn-%s" target="%s" onClick="%s">%s</a>';

		if($tag == 'button'){
			$button = sprintf($item_button_html, $extra_class, $type, $action, $label);
		} else {
			$button = sprintf($item_a_html,$scroll, $link, $extra_class, $type, $target, $action, $label);
		}

		if($align != ''){
			$button = sprintf('<div class="fwp-btn-wrap talign-%s">%s</div>', $align, $button);
		}
		return $button;
	}

	public static function priceTable($atts, $content){
		extract(shortcode_atts(array(

			'price'			=> '0',
			'currency'		=> '$',
			'suffix'		=> '/month',
			'suffix_first'	=> 'false',
			'title'			=> '',
			'stars'			=> 5,
			'submit_label'	=> __('SUBSCRIBE!','fastwp'),
			'submit_url'	=> '#',
			'submit_target'	=> '_blank',
			'animated' 		=> 'true',
			'animation' 	=> 'enter bottom move 10px over 1s after 0.2s',
			'extra_class'	=> '',

		), $atts));
		$animated 	= apply_filters('fwp_animation_enable', $animated);

		$separator 	= fwp_main_theme_url .'/assets/img/separatorBlack.png';
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', $animation):'';
		if($suffix_first == 'false'){

		$finalPrice = '<h2>'.$price.$currency.'</h2><p> '.$suffix.'</p>';
		}
		else
		{
		$finalPrice = '<h2>'.$currency.$price.'</h2><p> '.$suffix.'</p>';
		};

		$finalStars = '';
		$fullStars 	= intval($stars);
		$halfStar 	= ($fullStars != $stars)? 1 : 0;
		$emptyStars = 5 - $fullStars - $halfStar;
		$finalStars .= str_repeat('<i class="fa fa-star"></i>', $fullStars);
		$finalStars .= str_repeat('<i class="fa fa-star-half-o"></i>', $halfStar);
		$finalStars .= str_repeat('<i class="fa fa-star-o"></i>', $emptyStars);

		$item_html 	= '<div class="tableWrapper text-center %s" %s><div class="subscriptionName"> <h2>%s</h2></div><img class="separator center-block img-responsive" src="%s" alt="Dotted Separator"><div class="subscriptionPrice">%s</div><div class="rating">%s</div><img class=" separator center-block img-responsive" src="%s" alt="Dotted Separator"><div class="subscriptionList">%s</div><a class="btn btn-default btn-black" href="%s">%s</a></div>';
        do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($item_html, $extra_class, $finalAnimation, $title, $separator, $finalPrice, $finalStars, $separator, $content, $submit_url, $submit_label);
	}

	public static function testimonials($atts, $content){
		extract(shortcode_atts(array(
			'animated' 		=> 'true',
			'animation' 	=> 'enter right move 10px over 1s after 0.2s',
			'extra_class'	=> '',
			'autoplay' 		=> 'false',
			'show_controls' => 'true',
			'stop_on_hover' => 'false',
			'testimonial_slider_speed' => '4000'

		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);
		$finalAnimation = sprintf('data-scroll-reveal="%s"', $animation);
		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_testimonial',
			'suppress_filters'	=> '0',
			);

		$items = get_posts($args);

		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return FastWP_UI::alert('warning', __('Used [testimonials] shortcode but no testimonial is selected. <br>Please add at least one testimonial before using this shortcode.', 'fastwp'));
		}

 		$items_markup 	= '';
 		$item_markup 	= '<div class="review" %s>
                                <p>
                                    %s
                                </p>
                                <br>
                                <p>
                                    %s
                                </p>
                                <br>
                                <h4>%s</h4>
                                <p class="titulation">%s</p>

                            </div>';


		foreach($items as $item){
			$stars  		= get_post_meta( $item->ID, 'testimonial-stars', true);
			$role  		    = get_post_meta( $item->ID, 'testimonial-role', true);
			$title 			= $item->post_title;
			$i              = 0;
			$stars          = !empty( $stars ) ? esc_html( $stars ) : 5;
			$role           = !empty( $role ) ? esc_html( $role ) : '';
			$title          = $item->post_title;
			$finalStars     = '';
			$fullStars 	    = intval($stars);
			$halfStar 	    = ($fullStars != $stars)? 1 : 0;
			$emptyStars     = 5 - $fullStars - $halfStar;
			$finalStars     .= str_repeat('<i class="fa fa-star"></i>', $fullStars);
			$finalStars     .= str_repeat('<i class="fa fa-star-half-o"></i>', $halfStar);
			$finalStars     .= str_repeat('<i class="fa fa-star-o"></i>', $emptyStars);


            $items_markup .= sprintf($item_markup, $finalAnimation, $finalStars, apply_filters('the_content', sprintf('"%s"', $item->post_content)), $title, $role);
		}

		$carousel_overrides = '{"autoPlay": "'.$autoplay.'", "showControls": "'.$show_controls.'", "autoPlayTimeout": "'.$testimonial_slider_speed.'", "stopOnHover": "'.$stop_on_hover.'"}';
		$blank_markup = '<div id="owl-testimonials" class="owl-carousel" data-carousel-settings=\'%s\'> %s </div>';
		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($blank_markup,$carousel_overrides, $items_markup);
	}

	public static function coming_soon($atts, $content){
		extract(shortcode_atts(array(
			'date' 			=> '',
			'image' 		=> '',
			'color' 		=> '',
			'extra_class'	=> '',
		), $atts));

		$img_src = wp_get_attachment_image_src($image, 'full');
		$date 	= strtotime($date);
		$year 	= date('Y', $date);
		$month 	= date('m', $date);
		$day 	= date('d', $date);
		$hours 	= date('h', $date);
		$minutes = date('i', $date);
		$seconds = date('s', $date);

		$markup = '
		 <section id="intro" class="intro" style="background:url('.$img_src[0].')">
            <div class="black-overlay"></div>
            <div class="container valign">
                <div class="row">
                    <div class="col-md-12 text-center">'.apply_filters('the_content', $content).'</div>
                    <div class="col-md-12 text-center"><div id="countdown"></div></div>
                </div>
            </div>
            <script>
            jQuery(function ($) {
                var austDay = new Date();
                austDay = new Date('.$year.', '.($month-1).', '.$day.', '.$hours.', '.$minutes.', '.$seconds.');
                setTimeout(function(){
               $(\'#countdown\').countdown({until: austDay});},0);
            });
            </script>
        </section>';

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		do_action('fwp_enqueue_script', 'scripts,jquery.plugin.min,jquery.countdown.min,custom'); // Conditional load scripts
		return $markup;
	}

	public static function _model_blank($atts, $content){
		extract(shortcode_atts(array(
			'animated' 		=> 'true',
			'animation' 	=> 'enter right move 10px over 1s after 0.2s',
			'extra_class'	=> '',
		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);
		$blank_markup = $items_markup = '';

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($blank_markup, $items_markup);
	}

	public static function latest_posts($atts, $content){
		extract(shortcode_atts(array(
			'count'			=> '3',
			'grid'			=> '4',
			'target'		=> '_blank',
			'extra_class'	=> '',
			'include'		=> '',
			'exclude'		=> '',
			'more_label'	=> __('More', 'fastwp'),
			'order'			=> 'DESC',
			'orderby' 		=> 'post_date',
			'animated' 		=> 'true',
			'animation' 	=> 'enter right move 10px over 1s after 0.2s',
		), $atts));
		$animated 			= apply_filters('fwp_animation_enable', $animated);
		$finalAnimation 	= ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', $animation):'';


		$args = array(
			'numberposts' 		=> $count,
			'posts_per_page' 	=> $count,
			'post_status' 		=> 'publish',
			'post_type'			=> 'post',
			'suppress_filters'	=> '0',
			'include'			=> $include,
			'exclude'			=> $exclude,
			);

 		$items_markup = '';
		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', __('Used [fwp-latest-posts] shortcode but no post is added yet. <br>Please add at least one post before using this shortcode.', 'fastwp'));
		}

$item = <<<ITEMCONTENT
                        <div class="featureWrapper" id="project-id-%s">
                            <div class="feature-inner">
                                <img alt="thumbnail" class="galleryImage" src="%s">
                                    <div class="caption-heading">
                                        <h5>%s</h5>
                                        <div class="post-info"> <!-- Post meta -->
											<div class="postBy">
												<p>
													<i class="fa fa-pencil"></i>
													Posted by <a href="%s">%s</a> in %s on %s
												</p>
											</div>
										</div> <!-- Post meta  -->
                                        <p>%s</p>
                                        <a class="btn btn-default btn-black %s" href="%s"  %s>%s</a>
                                    </div>
                            </div>
                        </div>
ITEMCONTENT;
	$target = ($target == '')? ' data-toggle="modal"': sprintf(' target="%s"', $target);
	$btn_class = ($target == '')? ' overlay-ajax ' : '';
	$featured_content = '';
	$category = '';
	foreach($items as $project){
		$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
		$author = get_the_author();

		$categories = get_the_category($project->ID);
		foreach ($categories as $cat) {
			$category .= '<a href="'.get_category_link($cat->term_id).'" rel="category tag">'.$cat->name.', </a>';
				}

		$post_time = get_the_date('F j, Y', $project->ID);
		$excerpt = $project->post_excerpt;
		$item_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $project->ID ), 'latest-projects' );

		$featured_content .= sprintf($item, $project->ID, $item_image[0], $project->post_title,$author_url,$author,$category,$post_time, $excerpt, $btn_class, get_permalink($project->ID), $target, $more_label);
		$category = '';
	}


		$html = '<div class="animated-div" %s><div id="owl-posts" class="owl-carousel %s">%s</div>';
		do_action('fwp_enqueue_script', 'scripts,jquery.matchHeight-min,okvideo.min,overlay,modernizr.custom,preloader,custom'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($html, $finalAnimation, $extra_class, $featured_content);
	}

	public static function latest_projects($atts, $content){
		extract(shortcode_atts(array(
			'count'			=> '3',
			'grid'			=> '4',
			'target'		=> '_blank',
			'extra_class'	=> '',
			'include'		=> '',
			'exclude'		=> '',
			'more_label'	=> __('More', 'fastwp'),
			'urder'			=> 'DESC',
			'orderby' 		=> 'post_date',
			'animated' 		=> 'true',
			'animation' 	=> 'enter right move 10px over 1s after 0.2s',
		), $atts));
		$animated 			= apply_filters('fwp_animation_enable', $animated);
		$finalAnimation 	= ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', $animation):'';


		$args = array(
			'numberposts' 		=> $count,
			'posts_per_page' 	=> $count,
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_portfolio',
			'suppress_filters'	=> '0',
			'include'			=> $include,
			'exclude'			=> $exclude,
			);

 		$items_markup = '';
		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', __('Used [fwp-latest-projects] shortcode but no project is added yet. <br>Please add at least one project before using this shortcode.', 'fastwp'));
		}

$item = <<<ITEMCONTENT
                        <div class="featureWrapper" id="project-id-%s">
                            <div class="feature-inner">
                                <img alt="thumbnail" class="galleryImage" src="%s">
                                    <div class="caption-heading">
                                        <h5>%s</h5>
                                        <p>%s</p>
                                        <a class="btn btn-default btn-black %s" href="%s"  %s>%s</a>
                                    </div>
                            </div>
                        </div>
ITEMCONTENT;
	$target = ($target == '')? '' : ($target == 'modal')? ' data-toggle="modal"': sprintf(' target="%s"', $target);
	$btn_class = ($target == 'modal')? ' overlay-ajax ' : '';
	$featured_content = '';
	foreach($items as $project){
		$excerpt = $project->post_excerpt;
		$item_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $project->ID ), 'latest-projects' );

		$featured_content .= sprintf($item, $project->ID, $item_image[0], $project->post_title, $excerpt, $btn_class, get_permalink($project->ID), $target, $more_label);
	}

		$html = '<div class="animated-div" %s><div id="owl-featured" class="owl-carousel %s">%s</div>';
		do_action('fwp_enqueue_script', 'scripts,jquery.matchHeight-min,okvideo.min,overlay,modernizr.custom,preloader,custom'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($html, $finalAnimation, $extra_class, $featured_content);
	}

	public static function owl_slider($atts, $content){
		extract(shortcode_atts(array(
			'items' 		=> '',
			'extra_class'	=> '',
			'arrows_position' => '',
		), $atts));
		$blank_markup 	= $arrows_position == 'center' ? '<div class="owl-carousel fwp-owl-carousel owl-intro">%s</div>' : '<div class="owl-carousel fwp-owl-carousel">%s</div>';

		$item_markup 	= '<img class="img-responsive" src="%s"  alt="image">';
		$items_markup 	= '';
		foreach(explode(',', $items) as $item){
			$item_image 	= wp_get_attachment_image_src($item, 'full' );
			$items_markup 	.= sprintf($item_markup, $item_image[0]);
		}
		do_action('fwp_enqueue_script', 'scripts,custom,owl-carousel,owl-theme'); // Conditional load scripts

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__); return sprintf($blank_markup, $items_markup);
	}

	public static function fwp_project_info($atts, $content){
		extract(shortcode_atts(array(
			'icon' 			=> 'fa-info-circle',
			'extra_class'	=> '',
		), $atts));
		$blank_markup 	= '<div class="fwp-text-with-icon %s"><i class="fa %s"></i> <span class="offset">%s</span></div>';

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $extra_class, $icon, strip_tags(apply_filters('the_content', $content),'<a><strong><em><b><i>'));
	}

	public static function fwp_mailchimp($atts, $content){
		extract(shortcode_atts(array(
			'formid' 			=> '1',
			'email_placeholder' => 'Enter email',
			'success_msg' 		=> 'Thank you for subscribing.<br>Your email (<strong>%s</strong>) was successfully added to database.',
			'fail_msg' 			=> 'Your email (<strong>%s</strong>) cannot be added to database.<br>This occurs when you already subscribed or a server error is encountered.',
			'animated'			=> 'true',
			'animation'			=> 'enter left move 10px over 1s after 0.3s',
			'extra_class'		=> '',
		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', $animation) : '';

		$formInstance 	= $formid;
		$action 		= home_url();
		$rand 			= rand(1000,9999);
		$nonce 			= wp_create_nonce( '_mc4wp_form_nonce' ) ;
		$submittedEmail = '';
		if(isset($_POST['EMAIL']) && !empty($_POST['EMAIL'])){
			if(is_email($_POST['EMAIL'])){
				$submittedEmail = $_POST['EMAIL'];
			}
		}
		$blank_markup 	= '
		<form class="fwpMC4WPForm %s" id="fwp-mailchimp-%s" action="%s" method="post" %s>
			<div class="form-group">
			    <div class="input-group">
			        <div class="input-group-addon" onClick="jQuery(\'#fwp-mailchimp-%s\').submit();"><i class="fa fa-envelope-o"></i></div>
			        <input class="form-control" type="email" name="EMAIL" placeholder="%s">
			    </div>
			</div>
		</form>

        <div class="fwpMC4WPRealForm" style="display:none !important">%s</div>

		<div class="modal fade fwpMC4WP_success" tabindex="-1" role="dialog" >
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      %s
		    </div>
		  </div>
		</div>
		<div class="modal fade fwpMC4WP_fail" tabindex="-1" role="dialog" >
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      %s
		    </div>
		  </div>
		</div>
		';
		$_e_success_msg = (substr_count($success_msg, '%s') == 1)? sprintf($success_msg, $submittedEmail) 	: $success_msg;
		$_e_fail_msg 	= (substr_count($fail_msg, '%s') 	== 1)? sprintf($fail_msg, $submittedEmail) 		: $fail_msg;
		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $extra_class, $rand, $action, $finalAnimation, $rand, $email_placeholder,  do_shortcode('[mc4wp_form]') , $_e_success_msg, $_e_fail_msg );
	}

	public static function okvideobg($atts, $content){
		global $fwp_raw_js, $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'video' 		=> '',
			'image' 		=> '',
			'pageid'		=> '',
			'overlay'		=> 'true',
			'autoplay'		=> 'true',
			'loop'			=> 'true',
			'highdef'		=> 'true',
			'hd'			=> 'true',
			'adproof'		=> 'true',
			'volume'		=> '0',
			'extra_class'	=> '',
		), $atts));
		$item_image = '';
		if($image != ''){
			$item_image 	= wp_get_attachment_image_src($image, 'full' );
			$item_image = (isset($item_image[0]))? $item_image[0] : '';
		}

		$overlay_markup = ($overlay == 'true')? '<div class="black-overlay"></div>':'';
		$page_content = '';

		if($pageid != ''){
			$pageid = apply_filters("fwp_get_translated_page_id", $pageid);
			$pageCt = get_page($pageid);
			if(isset($pageCt->post_content)){
				$page_content = apply_filters('the_content', $pageCt->post_content);
				$fwp_custom_shortcode_css 	.= get_post_meta( $pageCt->ID, '_wpb_shortcodes_custom_css', true );
			}
		}

		$videoURL = ($video != '')? $video : 'http://vimeo.com/18052127';
		$blank_markup = '<section id="intro" class="%s">%s<div class="container valign"><div class="row">%s</div></div></section>';
		$item_image = (isset( $item_image ) && !empty( $item_image ) ) ? $item_image : get_template_directory_uri().'/assets/img/screen-1.jpg';
		if((isset($item_image) && !empty($item_image) && isset($videoURL) && !empty($videoURL)) || (isset($videoURL) && !empty($videoURL))){
			$fwp_raw_js .= "
            jQuery(function($){
                if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                    var _image = '$item_image';
                    if(_image.length > 1)
                    $.backstretch(_image);
                }
                else{
                    $.okvideo({source: '$videoURL', autoplay: $autoplay, loop: $loop, highdef: $highdef, hd: $hd, adproof: $adproof, volume: $volume })
                }
            });";
		}
		do_action('fwp_enqueue_script', 'scripts,okvideo.min,custom'); // Conditional load scripts

		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $extra_class, $overlay_markup, $page_content);
	}

	public static function sliderbg($atts, $content){
		global $fwp_raw_js, $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'images' 		=> '',
			'pageid'		=> '',
			'full_screen'	=> 'true',
			'duration'		=> '2000',
			'fade'			=> '750',
			'overlay'		=> 'true',
			'overlay_type'	=> 'radial',
			'mouse_tracking'=> 'false',
			'extra_class'	=> '',
		), $atts));
		$item_image  = '';
		$show_error  = false;
		$imagesArray = array();
		if($images != ''){
			$images = explode(',', $images);
			foreach($images as $image){
				$item_image = wp_get_attachment_image_src($image, 'full' );
				$item_image = (isset($item_image[0]))? $item_image[0] : '';
				if($item_image != ''){
					$imagesArray[] = '"'.$item_image.'"';
				}
			}

			if(count($imagesArray) == 0){
				$show_error = true;
			}
		} else {
			$show_error = true;
		}

		if($show_error == true){
			return FastWP_UI::alert('warning', '<br><br><br>' . __('Used [fwp-slider-bg] shortcode but no images are added yet. <br>Please select at least one image before using this shortcode.', 'fastwp'));
		}

		if($pageid != ''){
			$pageid = apply_filters("fwp_get_translated_page_id", $pageid);
			$pageCt = get_page($pageid);
			if(isset($pageCt->post_content)){
				$page_content = apply_filters('the_content', $pageCt->post_content);
				$fwp_custom_shortcode_css 	.= get_post_meta( $pageCt->ID, '_wpb_shortcodes_custom_css', true );
			}
		}
		$imagesArrayText = implode(',',$imagesArray);
		$extra_class = $full_screen == 'false' ? 'autoheight' : ' ';
		$container = $full_screen == 'false' ? 'container' : 'container valign';
		$blank_markup = $mouse_tracking == 'false' ? '<section id="intro" class="%s">%s<div class="%s"><div class="row">%s</div></div></section>' :
		'<section id="intro" class="%s"><canvas id="demo-canvas"></canvas>%s<div class="%s"><div class="row">%s</div></div></section>';
		$fwp_raw_js .= '
            jQuery(function($){
 				$.backstretch([
                '.$imagesArrayText.'
            	], {duration: '.$duration.', fade: '.$fade.'});
            });';
		do_action('fwp_enqueue_script', 'scripts,jquery.matchHeight-min,okvideo.min,overlay,modernizr.custom,preloader,custom,'); // Conditional load scripts
		if ($mouse_tracking == 'true') {
			do_action ('fwp_enqueue_script', 'BackgroundEffect');
		};
		$overlay_markup = $overlay == 'true' && $overlay_type == 'radial' ?  '<div class="black-overlay"></div>' : ( $overlay == 'true' && $overlay_type == 'plain' ? '<div class="plainblack-overlay"></div>' : '' );

		return sprintf($blank_markup, $extra_class, $overlay_markup, $container, $page_content);
	}

	public static function fwp_partial_overlay($atts, $content){
		global $fwp_raw_js, $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'image' 		=> '',
			'pageid'		=> '0',
			'extra_class'	=> '',
		), $atts));
		$page_content = '';
		$pageid = apply_filters("fwp_get_translated_page_id", $pageid);
		$pageCt = get_page($pageid);
		if(isset($pageCt->post_content)){
			$page_content 			= apply_filters('the_content', $pageCt->post_content);
			$fwp_custom_shortcode_css 	.= get_post_meta( $pageCt->ID, '_wpb_shortcodes_custom_css', true );
		}

		$item_image = '';
		if($image != ''){
			$item_image 	= wp_get_attachment_image_src($image, 'full' );
			$item_image = (isset($item_image[0]))? $item_image[0] : '';
		}

		$blank_markup = '<div class="container-fluidx partial-grad-separator %s">
                <div class="col-md-7 col-sm-6 hidden-xs image" style="background:#fff url(%s) no-repeat center center; background-size: cover;">
                    <div class="whiteOverlay"></div>
                </div><div class="col-md-5 col-sm-6 col-xs-12 textOverlay text-center">%s</div></div>';
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $extra_class, $item_image, $page_content);
	}

	public static function fwp_img_stellar($atts, $content){
		global $fwp_raw_js, $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'image' 		=> '',
			'alignment'		=> '',
			'data_ratio'	=> '0.5',
			'extra_class'	=> '',
		), $atts));
		if(empty($image)) return;
		$item_image 		= wp_get_attachment_image_src($image, 'full' );
		$item_image 		= (isset($item_image[0]))? $item_image[0] : '';
		$main_class 		= 'fwp-stellar-image';
		$main_class			.= ' '.$alignment;
		$blank_markup		= '<img class="%s %s" src="%s" data-stellar-ratio="%s">';
		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $main_class, $extra_class, $item_image, $data_ratio);
	}

	public static function fwp_video_button ($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'alignment'		=> 'center',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'video_url'		=> 'https://vimeo.com/128234216',
			'margin_top'	=> '',
			'margin_bottom'	=> '',
			'color'			=> '',
			'hover_color'	=> '',
			'extra_class'	=> '',

		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);
		$video_button_id = 'videobtn-'.rand(1000,9999);
		$blank_markup = '<div id="%s" class="PlayTrigger %s" %s>
                            <a href="%s" class="fwpvideotrigger">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="48" height="48" viewBox="0 0 48 48">
                                    <g id="icomoon-ignore">
                                        <line stroke-width="1" x1="" y1="" x2="" y2="" stroke="#449FDB" opacity=""/>
                                    </g>
                                    <path d="M24 2c12.128 0 22 9.87 22 22s-9.872 22-22 22-22-9.87-22-22 9.872-22 22-22zM24 0c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24v0z" fill="#000000"/>
                                    <path d="M17 35.392c-0.172 0-0.346-0.044-0.5-0.134-0.308-0.178-0.5-0.508-0.5-0.866v-20.788c0-0.358 0.192-0.688 0.5-0.866 0.308-0.18 0.692-0.18 1 0l18 10.392c0.308 0.178 0.5 0.508 0.5 0.866s-0.192 0.688-0.5 0.866l-18 10.392c-0.154 0.094-0.328 0.138-0.5 0.138zM18 15.34v17.32l15-8.66-15-8.66z" fill="#000000"/>
                                </svg>

                            </a>
                        </div>';
		$fwp_custom_shortcode_css .= sprintf('#%s {margin-top:%spx;margin-bottom:%spx;text-align:%s;} #%s svg path {fill:%s;} #%s svg:hover path {fill:%s;}',$video_button_id,$margin_top,$margin_bottom,$alignment,$video_button_id,$color,$video_button_id,$hover_color);
		do_action('fwp_enqueue_script', 'scripts,custom,jquery.magnific-popup.min');
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $video_button_id, $extra_class,($animated=='true')?sprintf('data-scroll-reveal="%s"', $animation):'', $video_url);
	}

    /*
	public static function fwp_typewritting ($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'alignment'		=> 'center',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'margin_top'	=> '',
			'margin_bottom'	=> '',
			'extra_class'	=> ''
		), $atts));

		$animated = apply_filters('fwp_animation_enable', $animated);
		$video_button_id = 'videobtn-'.rand(1000,9999);
		$blank_markup = '<div class="PositionRelative js-shortcode-parent %s" %s>
                            <div class="TextStyling fake  js-fake-text">
                              %s
                            </div>
                            <div class="TextTyperWrapper">
                                <div class="TextStyling TextHolder js-typed-text-holder"></div>
                            </div>
                        </div>';
		do_action('fwp_enqueue_script', 'scripts,custom,typed.min');
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $extra_class,($animated=='true')?sprintf('data-scroll-reveal="%s"', $animation):'', $content);
	}
    */

	public static function fwp_image ($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'item' 			=> '',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'extra_class'	=> '',
			'border_width'  => '',
			'border_color'	=> '',
		), $atts));

		$animated = apply_filters('fwp_animation_enable', $animated);

		$image_id = 'fwpimage-'.rand(1000,9999);
		$item_markup 	= '<img id="%s" class="img-responsive %s" src="%s" alt="image" %s>';
		$item_image 	= wp_get_attachment_image_src($item, 'full' );
		$image_src 		= $item_image[0];
		$extra_class  = ($border_width != '') ? 'BorderedItem' : '';
		$fwp_custom_shortcode_css .= sprintf('#%s {border:%spx solid %s;}',$image_id,$border_width,$border_color);
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($item_markup,$image_id, $extra_class,$image_src, ($animated=='true')?sprintf('data-scroll-reveal="%s"', $animation):'');
	}

	public static function fwp_navigation_box ($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'item' 			=> '#',
			'overlay_color'	=> '#333',
			'bkg_opacity'	=> '',
			'extra_class'	=> '',
			'url'			=> '#',
			'tag'			=> 'h3',
			'title'			=> 'Insert Text',
		), $atts));

		$navigation_box_id = 'fwpnavbox-'.rand(1000,9999);
		$item_markup 	= '<div id="%s" class="PositionRelative IntroBox1 IntroBoxHoverWrapper %s">
                            <a data-scroll href="%s">
                                <div class="IntroBoxes">
                                    <div class="IntroBoxTable">
                                        <div class="IntroBoxCell">
                                            <%s>%s</%s>
                                        </div>
                                    </div>
                                </div>
                                <div class="BackgroundImage"></div>
                            </a>
                        </div>';
		$item_image 	= wp_get_attachment_image_src($item, 'full' );
		$image_src 		= $item_image[0];
		$fwp_custom_shortcode_css .= sprintf('#%s .BackgroundImage {background:url("%s") no-repeat center center;}
											#%s .IntroBoxes {background:%s;}
											#%s.IntroBoxHoverWrapper:hover .BackgroundImage {opacity:%s;}',
											$navigation_box_id, $image_src, $navigation_box_id, $overlay_color, $navigation_box_id, $bkg_opacity);
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($item_markup, $navigation_box_id, $extra_class, $url, $tag, $title, $tag, $image_src);
	}

	public static function fwp_timeline($atts, $content){
		extract(shortcode_atts(array(
			'category' 		=> '',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'extra_class'	=> '',
			'title'  		=> '',
			'include'  		=> '',
			'exclude'  		=> '',
		), $atts));

		/**
		#Region Settings
		**/
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$show_title 	= (!empty($title))? true : false;
		$module_content = '';

		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_timeline',
			'suppress_filters'	=> '0'
			);

		if($category != ''){
			$args['tax_query'] =
			array(
	            'taxonomy' 	=> 'timeline-category',
	            'terms' 	=> $category,
	            'include_children' => true
	        );
		}

		if($include != ''){
			$args['include'] = $include;
		}

		if($exclude != ''){
			$args['exclude'] = $exclude;
		}

		/**
		#Region Block Defnitions
		**/
		/* Params: Icon, Title Tag, Title, Title Tag, Content, Timeline item date */
		$item_markup = '<div class="timeline-block"><div class="timeline-icon timeline-icon-hide-border"><i class="fa %s fa-lg"></i></div><div class="timeline-content"><%s>%s</%s>%s<div class="timeline-date">%s</div></div></div>';
        /* Params: Title */
        $title_markup = '<div class="timeline-block timeline-block-icon-only"><div class="timeline-icon timeline-icon-text timeline-icon-hide-border ThickBorderTimeline"><span>%s</span></div><div class="timeline-content"></div></div>';
        /* Params: Extra Class, Animation attributes, Module content*/
        $blank_markup = '<div class="timeline timeline-alternating timeline-collapsing timeline-with-arrows %s" %s>%s</div>';

        /**
		#Region Processing
		**/

		$items = get_posts($args);

		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', __('Used [timeline] shortcode but no timeline items are added yet. <br>Please add at least one timeline item before using this shortcode.', 'fastwp'));
		}

		if($show_title){
			$module_content .= sprintf($title_markup, $title);
		}

		foreach ($items as $index => $item) {
            $icon           = get_post_meta( $item->ID, 'timeline-icon', true );
            $tag            = get_post_meta( $item->ID, 'timeline-tag', true );
            $date           = get_post_meta( $item->ID, 'timeline-date', true );
			$item__icon 	= !empty( $icon ) ? esc_html( $icon ) : 'fa-university';
			$item__tag 		= !empty( $tag ) ? esc_html( $tag ) : 'h3';
			$item__date 	= !empty( $date ) ? esc_html( $date ) : '';
			$item__title 	= $item->post_title;
			$item__content 	= apply_filters('the_content', $item->post_content);

			$module_content .= sprintf($item_markup, $item__icon, $item__tag, $item__title, $item__tag, $item__content, $item__date);
		}

        /**
		#Region Module render
		**/
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $extra_class, ($animated=='true')? sprintf('data-scroll-reveal="%s"', $animation):'', $module_content);
	}

	public static function fwp_tab_icon($atts, $content){
		extract(shortcode_atts(array(
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'extra_class'	=> '',
			'id' 			=> '',
			'title' 		=> '',
			'icon' 			=> '',
			'url'			=> '',
			'link_label'	=> __('Find out more', 'fastwp'),
			'is_active' 	=> 'false'
		), $atts));

		$extra_class .= ($is_active == 'true') ? ' in active ' : '';

		/* Params: TargetID, TargetID, Content */
		$item_markup = '<div role="tabpanel" class="tab-pane fade %s" id="%s" aria-labelledby="%s-tab"><h5 class="ServiceTitleMobile">%s</h5>%s<div class="PaddingTop30"></div><a class="btn btn-default btn-black" href="%s">%s</a><div class="BackgroundIconWrapper"><i class="BackgroundIcon fa %s"></i></div></div>';

        /**
		#Region Module render
		**/
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($item_markup, $extra_class, $id, $id, $title,  do_shortcode($content), $url, $link_label, $icon);
	}

	public static function fwp_tabs_icon($atts, $content){
		extract(shortcode_atts(array(
			'animated'		=> 'false',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'extra_class'	=> '',
		), $atts));

		/**
		#Region Settings
		**/
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$module_titles 	= '';
		$isExpanded 	= 'true';

		/**
		#Region Block Defnitions
		**/

		/* Params: TargetID, TargetID, Content */
		$item_markup 	= '<div role="tabpanel" class="tab-pane fade" id="%s" aria-labelledby="%s-tab">%s</div>';
        /* Params:  TargetID, TargetID, isExpanded, IconClass, Title */
        $title_markup 	= '<div class="ServiceWrapper PaddingVertical30 PaddingHorizontal40 text-center col-xs-4" data-scroll-reveal="enter bottom move 10px over 1s after 0.2s"><a href="#%s" class="ServiceTab" role="tab" data-toggle="tab" aria-controls="%s" aria-expanded="%s"><div class="ServiceWrapperIcon"><i class="fa %s fa-3x"></i><h5 class="ServiceWrapperTitle">%s</h5></div></a></div>';
        /* Params:  Separator image, Tab items */
        $blank_markup 	= '<div class="row %s" role="tablist" %s>%s<div class="clearfix"></div><img class="separator center-block img-responsive small" src="%s" alt="Dotted Separator"><div class="PaddingHorizontal80 CarouselItemDetails text-center"><div id="TabContent" class="tab-content PositionRelative">%s</div></div></div>';

        /**
		#Region Processing
		**/
		preg_match_all( '/fwp_tab_icon title="([^\"]+){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
		preg_match_all( '/fwp_tab_icon(.*?)icon="(.*?)"/is', $content, $icons );

		$rand = rand(1000,9999);
		foreach ($matches[1] as $key => $value) {
			$sanitized_id = sanitize_title($value[0] . $rand);
			$content = str_replace('title="'.$value[0].'"', 'title="'.$value[0].'" id="'.$sanitized_id.'" is_active="'.$isExpanded.'"', $content);
			$icon = (isset($icons[2][$key]))? $icons[2][$key] : 'fa-info';
			$module_titles .= sprintf($title_markup, $sanitized_id, $sanitized_id, $isExpanded, $icon, $value[0]);
			$isExpanded = 'false';
		}

        /**
		#Region Module render
		**/
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		return sprintf($blank_markup, $extra_class, ($animated=='true')? sprintf('data-scroll-reveal="%s"', $animation):'', $module_titles, fwp_main_theme_url . '/assets/img/separatorBlack.png', do_shortcode($content));
	}

	public static function fwp_text_writer($atts, $content){
		extract(shortcode_atts(array(
			'items'			=> '',
			'mode'			=> '0',
			'startdelay'	=> 100,
			'loop'			=> false,
			'backdelay'		=> 500,
			'typespeed'		=> 30,
            'tag'           => 'h1',
			'extra_class'	=> ''
		), $atts));

        do_action('fwp_enqueue_script', 'scripts,custom,typed.min');
        do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);

        $ctnt = urldecode( base64_decode( $items ) );

        if( $mode == '1' ) {

        $lines = explode( "\n", $ctnt );

        if( !empty( $lines ) ) {
            $lines2 = array_map( function( $v ) {
                return '"' . trim( $v ) . '"';
            }, $lines );
        } else {
            $lines2 = array();
        }

        if( !in_array( $tag, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) ) {
            $tag = 'h1';
        }

        }

        $script = '<script>

            jQuery(document).ready(function ($) {';

            if( $mode == '1' ) {

            $script .= '

                $(".TextHolder2").typed({
                    strings: [' . implode( ',', $lines2 ) . '],
                    startDelay: ' . (int) $startdelay . ',
                    typeSpeed: ' . (int) $typespeed . ',
                    backDelay: ' . (int) $backdelay . ',
                    loop: ' . ( (boolean) $loop ? 'true' : 'false' ) . '
                });
            ';

            } else {

            $script .= '

                var htmltext = $(".TextStyling.fake").html();

                $(".TextHolder").typed({
                    strings: [htmltext],
                    contentType: "html",
                  	startDelay: ' . (int) $startdelay . ',
                    loop: ' . ( (boolean) $loop ? 'true' : 'false' ) . ' ,
                    typeSpeed: ' . (int) $typespeed . '
                });
            ';

            }

            $script .= '});

        </script>';

        if( $mode == '1' ) {

		$blank_markup = '<%s class="autotype2">
                            <div class="TextHolder2"></div>
                        </%s>';

        return sprintf( $blank_markup, $tag, $tag ) . $script;

        } else {

        $blank_markup = '<div class="PositionRelative">
                            <div class="TextStyling fake">
                                %s
                            </div>
                            <div class="TextTyperWrapper">
                                <div class="TextStyling TextHolder"></div>
                            </div>
                        </div>';

        return sprintf( $blank_markup, fwp_utils::fwp_escape( $ctnt, array( 'br' => array() ) ) ) . $script;

        }

	}

}

if(!function_exists('FWP_Shortcode_titleWithIcon')){
	function FWP_Shortcode_titleWithIcon($atts, $content){
		return fwp_theme_shortcodes::titleWithIcon($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_separator')){
	function FWP_Shortcode_separator($atts, $content){
		return fwp_theme_shortcodes::separator($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_message')){
	function FWP_Shortcode_message($atts, $content){
		return fwp_theme_shortcodes::message($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_gMap')){
	function FWP_Shortcode_gMap($atts, $content){
		return fwp_theme_shortcodes::gMap($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_titleWithBorder')){
	function FWP_Shortcode_titleWithBorder($atts, $content){
		return fwp_theme_shortcodes::titleWithBorder($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_blockquote')){
	function FWP_Shortcode_blockquote($atts, $content){
		return fwp_theme_shortcodes::blockquote($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_aboutItem')){
	function FWP_Shortcode_aboutItem($atts, $content){
		return fwp_theme_shortcodes::aboutItem($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_portfolio_overlay_markup')){
	function FWP_Shortcode_portfolio_overlay_markup($atts, $content){
		return fwp_theme_shortcodes::portfolio_overlay_markup($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_myPortfolio')){
	function FWP_Shortcode_myPortfolio($atts, $content){
		return fwp_theme_shortcodes::myPortfolio($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_project_preloader_markup')){
	function FWP_Shortcode_project_preloader_markup($atts, $content){
		return fwp_theme_shortcodes::project_preloader_markup($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_ourTeam')){
	function FWP_Shortcode_ourTeam($atts, $content){
		return fwp_theme_shortcodes::ourTeam($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_animatedText')){
	function FWP_Shortcode_animatedText($atts, $content){
		return fwp_theme_shortcodes::animatedText($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_parallaxLetter')){
	function FWP_Shortcode_parallaxLetter($atts, $content){
		return fwp_theme_shortcodes::parallaxLetter($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_ourClients')){
	function FWP_Shortcode_ourClients($atts, $content){
		return fwp_theme_shortcodes::ourClients($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_ourServices')){
	function FWP_Shortcode_ourServices($atts, $content){
		return fwp_theme_shortcodes::ourServices($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_faIcon')){
	function FWP_Shortcode_faIcon($atts, $content){
		return fwp_theme_shortcodes::faIcon($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_counter')){
	function FWP_Shortcode_counter($atts, $content){
		return fwp_theme_shortcodes::counter($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_contactInfo')){
	function FWP_Shortcode_contactInfo($atts, $content){
		return fwp_theme_shortcodes::contactInfo($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_socialWithLink')){
	function FWP_Shortcode_socialWithLink($atts, $content){
		return fwp_theme_shortcodes::socialWithLink($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_clearfix')){
	function FWP_Shortcode_clearfix($atts, $content){
		return fwp_theme_shortcodes::clearfix($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_customButtons')){
	function FWP_Shortcode_customButtons($atts, $content){
		return fwp_theme_shortcodes::customButtons($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_priceTable')){
	function FWP_Shortcode_priceTable($atts, $content){
		return fwp_theme_shortcodes::priceTable($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_testimonials')){
	function FWP_Shortcode_testimonials($atts, $content){
		return fwp_theme_shortcodes::testimonials($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_coming_soon')){
	function FWP_Shortcode_coming_soon($atts, $content){
		return fwp_theme_shortcodes::coming_soon($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_latest_posts')){
	function FWP_Shortcode_latest_posts($atts, $content){
		return fwp_theme_shortcodes::latest_posts($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_latest_projects')){
	function FWP_Shortcode_latest_projects($atts, $content){
		return fwp_theme_shortcodes::latest_projects($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_owl_slider')){
	function FWP_Shortcode_owl_slider($atts, $content){
		return fwp_theme_shortcodes::owl_slider($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_fwp_project_info')){
	function FWP_Shortcode_fwp_project_info($atts, $content){
		return fwp_theme_shortcodes::fwp_project_info($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_fwp_mailchimp')){
	function FWP_Shortcode_fwp_mailchimp($atts, $content){
		return fwp_theme_shortcodes::fwp_mailchimp($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_okvideobg')){
	function FWP_Shortcode_okvideobg($atts, $content){
		return fwp_theme_shortcodes::okvideobg($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_sliderbg')){
	function FWP_Shortcode_sliderbg($atts, $content){
		return fwp_theme_shortcodes::sliderbg($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_fwp_partial_overlay')){
	function FWP_Shortcode_fwp_partial_overlay($atts, $content){
		return fwp_theme_shortcodes::fwp_partial_overlay($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_fwp_img_stellar')){
	function FWP_Shortcode_fwp_img_stellar($atts, $content){
		return fwp_theme_shortcodes::fwp_img_stellar($atts, $content);
	}

}

if(!function_exists('FWP_Shortcode_fwp_video_button')){
	function FWP_Shortcode_fwp_video_button($atts, $content){
		return fwp_theme_shortcodes::fwp_video_button($atts, $content);
	}

}

if(!function_exists('FWP_Shortcode_fwp_typewritting')){
	function FWP_Shortcode_fwp_typewritting($atts, $content){
		return fwp_theme_shortcodes::fwp_typewritting($atts, $content);
	}

}

if(!function_exists('FWP_Shortcode_fwp_image')){
	function FWP_Shortcode_fwp_image($atts, $content){
		return fwp_theme_shortcodes::fwp_image($atts, $content);
	}

}

if(!function_exists('FWP_Shortcode_fwp_navigation_box')){
	function FWP_Shortcode_fwp_navigation_box($atts, $content){
		return fwp_theme_shortcodes::fwp_navigation_box($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_fwp_timeline')){
	function FWP_Shortcode_fwp_timeline($atts, $content){
		return fwp_theme_shortcodes::fwp_timeline($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_fwp_tab_icon')){
	function FWP_Shortcode_fwp_tab_icon($atts, $content){
		return fwp_theme_shortcodes::fwp_tab_icon($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_fwp_tabs_icon')){
	function FWP_Shortcode_fwp_tabs_icon($atts, $content){
		return fwp_theme_shortcodes::fwp_tabs_icon($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_fwp_text_writer')){
	function FWP_Shortcode_fwp_text_writer($atts, $content){
		return fwp_theme_shortcodes::fwp_text_writer($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_myPostGrid')){
	function FWP_Shortcode_myPostGrid($atts, $content){
		return fwp_theme_shortcodes::myPostGrid($atts, $content);
	}
}

global $fwp_shortcodes;
$fwp_shortcodes = array(
	'title-with-icon' => 'titleWithIcon',
	'title-with-border' => 'titleWithBorder',
	'separator' => 'separator',
	'about-item' => 'aboutItem',
	'portfolio' => 'myPortfolio',
	'fwp-post-grid' => 'myPostGrid',
	'our-team' => 'ourTeam',
	'our-clients' => 'ourClients',
	'our-services' => 'ourServices',
	'fa-icon' => 'faIcon',
	'fwp-counter' => 'counter',
	'fwp-price-table' => 'priceTable',
	'fwp-testimonials' => 'testimonials',
	'fwp-contact-info' => 'contactInfo',
	'fwp-clearfix' => 'clearfix',
	'fwp-social-fa' => 'socialWithLink',
	'fwp-map' => 'gMap',
	'fwp-button' => 'customButtons',
	'fwp-message' => 'message',
	'fwp-coming-soon' => 'coming_soon',
	'fwp-anim-text' => 'animatedText',
	'fwp-latest-projects' => 'latest_projects',
	'fwp-latest-posts' => 'latest_posts',
	'fwp-slider' => 'owl_slider',
	'fwp-video-bg' => 'okvideobg',
	'fwp-slider-bg' => 'sliderbg',
	'fwp-project-info' => 'fwp_project_info',
	'fwp-mailchimp' => 'fwp_mailchimp',
	'fwp-partial-overlay' => 'fwp_partial_overlay',
	'fwp-img-stellar' => 'fwp_img_stellar',
	'fwp-blockquote' => 'blockquote',
	'fwp-parallax-letter' => 'parallaxLetter',
	'fwp-video-button' => 'fwp_video_button',
	'fwp-typewritting' => 'fwp_typewritting',
	'fwp-image' => 'fwp_image',
	'fwp-navigation-box' => 'fwp_navigation_box',
	'fwp-timeline' => 'fwp_timeline',
	'fwp_tabs_icon' => 'fwp_tabs_icon',
	'fwp_tab_icon' => 'fwp_tab_icon',
	'fwp_text_writer' => 'fwp_text_writer',
	);