<?php
add_action('init', 						array('FastWP_Actions', 'init'), 10);
add_action('wp_enqueue_scripts',		array('FastWP_Actions', 'enqueue_scripts'));
add_action('admin_enqueue_scripts',		array('FastWP_Actions', 'enqueue_scripts'));
add_action('tgmpa_register', 			array('FastWP_Actions', 'check_required_plugins') );
add_action('attach_footer_info_page', 	array('FastWP_Actions', 'attach_footer_info_page'));
add_action('vc_before_init', 			array('FastWP_Actions', 'set_vc_as_theme'));
add_action('after_setup_theme', 		array('FastWP_Actions', 'fastwp_setup'), 11);	
add_action('_fastwp_no_sections_defined',array('FastWP_Actions', 'no_section_defined'));
add_action('fwp_enqueue_script',		array('FastWP_Actions', 'script_loader'),1);
add_action('wp_footer',					array('FastWP_Actions', 'footer'),1);
add_action('wp_footer', 				array('FastWP_UI', 		'add_custom_css' ), 1000 );
add_action('wp_update_nav_menu_item',   array('FastWP_Actions', 'fastwp_navigation_update'),1,3 );

class FastWP_Actions {
	static function init(){
		self::init_visual_composer_blocks();
        self::init_visual_composer_params_blocks();       
	}

	static function footer(){
		global $fwp_custom_js, $fwp_data, $fwp_raw_js;
			wp_localize_script('custom', 'fastwp', $fwp_custom_js );
		if($fwp_raw_js != ''){
			echo sprintf('<script id="fwp-raw-js">%s</script>', $fwp_raw_js);
		}
		if(isset($fwp_data['custom_js']) && !empty($fwp_data['custom_js'])){
			echo sprintf('<script id="fwp-custom-js">%s</script>', $fwp_data['custom_js']);
		}
	}


	static function  fastwp_setup(){
	    load_theme_textdomain	('fastwp', get_template_directory() . '/locale');
		add_theme_support		('post-formats', array('quote', 'video', 'image', 'audio','gallery'));
		add_image_size			('portfolio-thumb', 370, 241, true ); // Portfolio 370x241 image (cropped if larger)
		/* Not used */
		$args = array();
	//	add_theme_support( 'custom-header', $args );
	//	add_theme_support( 'custom-background', $args );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// This theme uses wp_nav_menu() in one location.
		add_theme_support('menus');
		register_nav_menus( array(
			'primary' => __('Main navigation menu', 'fastwp'),
		) );

		add_theme_support( 'title-tag' ); 

		// This theme uses a custom image size for featured images, displayed on "standard" posts.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
		
	}

	static function enqueue_scripts(){
		global $wp_plugins;
		if(!is_admin()){
			$admin_bar_uri = get_template_directory_uri() . '/assets/css/admin-bar.css';
			if(is_admin_bar_showing() && file_exists($admin_bar_uri)){
				wp_enqueue_style('core-admin-bar', $admin_bar_uri);
			}
			$js_composer_url = plugins_url();
			$testURL = ABSPATH . 'wp-content/plugins/js_composer/assets/css/js_composer.css';
			if(file_exists($testURL)){
				wp_enqueue_style('js-composer', $js_composer_url . '/js_composer/assets/css/js_composer.css');
			}
			wp_enqueue_script('jquery');
		} else {
			wp_enqueue_style( 'wp-color-picker' ); 
			wp_enqueue_script( 'wp-color-picker' ); 

			  // vc editor custom field size

			wp_register_style( 'vc_fastwp_admin', get_template_directory_uri() . '/assets/css/admin.vc.css', false, '1.0.0' );
			wp_enqueue_style( 'vc_fastwp_admin' );
		}
	}

	static function check_required_plugins(){
		global $fwp_required_plugins;
		if(function_exists('tgmpa') && is_array($fwp_required_plugins)){
	    	tgmpa( $fwp_required_plugins );
		}
	}

	static function init_visual_composer_blocks(){
		global $fwp_visual_composer_blocks;

		/* Visual Composer configuration parser for FastWP Themes */
		if ((class_exists('WPBakeryVisualComposer') || class_exists('Vc_Manager')) && function_exists('vc_map')) {
			if(count($fwp_visual_composer_blocks) > 0 && is_array($fwp_visual_composer_blocks)){
				foreach($fwp_visual_composer_blocks as $vc_block){
					vc_map($vc_block);
				} 
			}
		}
	}

	static function init_visual_composer_params_blocks(){
		global $fwp_visual_composer_param_blocks;
		/* Visual Composer configuration parser for FastWP Themes */
		if ((class_exists('WPBakeryVisualComposer') || class_exists('Vc_Manager')) && function_exists('vc_map')) {
			if(count($fwp_visual_composer_param_blocks) > 0 && is_array($fwp_visual_composer_param_blocks)){
				foreach($fwp_visual_composer_param_blocks as $vc_param_block){
				    foreach( $vc_param_block['params'] as $param ) {
    					vc_add_param( $vc_param_block['id'], $param );
                    }
				}
			}
		}
	}

	static function attach_footer_info_page(){
		global $fwp_data, $fwp_custom_shortcode_css;
		if(!isset( $fwp_data['before_footer_page_id']) || empty( $fwp_data['before_footer_page_id'])) 
			return;
		
		$page_id = $fwp_data['before_footer_page_id'];
		$page_object = get_page($page_id);
		if(!isset($page_object->ID)) return;
		$fwp_custom_shortcode_css .= get_post_meta($page_object->ID, '_wpb_shortcodes_custom_css', true );
			
		echo apply_filters('the_content', $page_object->post_content);
	}

	static function set_vc_as_theme() {
		vc_set_as_theme(true);
	}

	static function no_section_defined(){
		echo 'No sections defined !!!';
	}

	static function set_custom_edit_post_columns($columns) {
    	$columns['item_id'] = __( 'Item ID', 'fastwp' );
	   	return $columns;
	}

	static function custom_ID_column( $column, $post_id ) {
	    switch ( $column ) {
	        case 'item_id' :
	            echo  $post_id ; 
	        break;
	    }
	}

	static function script_loader($scripts){
		if(fwp_autoload_scripts == true) return;

		$scripts 	= explode(',', $scripts);
		foreach($scripts as $script){
			$handle = sanitize_title($script);
			wp_enqueue_script($handle);
		}
	}

	static function fastwp_navigation_update($menu_id, $menu_item_db_id, $args){
		if(isset($args['menu-item-menuicon_selected']))
			update_post_meta( $menu_item_db_id, '_menu_item_menuicon_selected', sanitize_key($args['menu-item-menuicon_selected']) );
		if(isset($args['menu-item-menuicon']))
			update_post_meta( $menu_item_db_id, '_menu_item_menuicon', sanitize_key($args['menu-item-menuicon']) );
		if(isset($args['menu-item-menutype']))
			update_post_meta( $menu_item_db_id, '_menu_item_menutype', sanitize_key($args['menu-item-menutype']) );
	}
}