<?php

class FastWP_Functions {
	/**
		Register theme scripts and load them depending on global settings.
	**/
	static function register_scripts(){
		global $fwp_load_scripts;
		$fwp_themeUrl 	= (defined('fwp_main_theme_url'))? fwp_main_theme_url : get_template_directory_uri();
		$deps 			= 'jquery';
		$in_footer		= true;
		wp_enqueue_script($deps);
		foreach($fwp_load_scripts as $script){
			$handle = sanitize_title($script);
			$src 	= sprintf('%s/assets/js/%s.js', $fwp_themeUrl, $script);
			if( substr_count( $script, '//' ) ){
				$src = $script;
			} 

			wp_register_script( $handle, $src, $deps, '1.0.0', $in_footer );
			if(fwp_autoload_scripts == true || $handle == 'modernizr-custom' || $handle == 'scripts' || $handle == 'preloader'){
				wp_enqueue_script($handle);
			}
		}
	}
	/**
		Register theme styles and load them depending on global settings.
	**/
	static function register_styles(){
		global $fwp_load_styles;
		$fwp_themeUrl 	= (defined('fwp_main_theme_url'))? fwp_main_theme_url : get_template_directory_uri();
		$in_footer	= true;
		foreach($fwp_load_styles as $style){
			$handle = sanitize_title($style);
			$src 	= sprintf('%s/assets/css/%s.css', $fwp_themeUrl, $style);
			if( substr_count( $style, '//' ) ){
				$src = $style;
			} 
			wp_register_style( $handle, $src);
			if(fwp_autoload_styles == true || $handle == 'preloader' || $handle == 'modernizr-custom'){
				wp_enqueue_style($handle);
			}
		}
	}

	/** 

	**/
	static function add_custom_column(){
		global $fwp_custom_posts_with_id;
		foreach($fwp_custom_posts_with_id as $cpt){
			add_filter( 'manage_edit-'.$cpt.'_columns', array('FastWP_Actions', 'set_custom_edit_post_columns') );
			add_action( 'manage_'.$cpt.'_posts_custom_column' , array('FastWP_Actions', 'custom_ID_column'), 10, 2 );
		}
	}
	
}

add_action('init', array('FastWP_Functions', 'add_custom_column'));
add_action('wp_enqueue_scripts', array('FastWP_Functions', 'register_styles'));
add_action('wp_enqueue_scripts', array('FastWP_Functions', 'register_scripts'));