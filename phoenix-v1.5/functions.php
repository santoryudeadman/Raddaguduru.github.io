<?php

define('fwp_core_version', '1.0.5');
define('fwp_theme_path', dirname(__FILE__));
define('fwp_core_uri', sprintf('%s/fastwp/', fwp_theme_path));
defined('fwp_main_theme_url') or define('fwp_main_theme_url', get_template_directory_uri());
defined('fwp_child_theme_url') or define('fwp_child_theme_url', get_stylesheet_directory_uri());
defined('fwp_shortcode_classname') or define('fwp_shortcode_classname', 'fwp_theme_shortcodes');

define('fwp_lib_uri', fwp_core_uri . 'lib/');
define('fwp_lib_url', fwp_main_theme_url . '/fastwp/lib/');
define('fwp_debug', false);
defined('fwp_menu_child_class') or define('fwp_menu_child_class', 'dropdown-menu child');
defined('fwp_autoload_scripts') or define('fwp_autoload_scripts', false);
defined('fwp_autoload_styles') or define('fwp_autoload_styles', true);

// Disable VC Front End Editor
if(function_exists('vc_disable_frontend')){
	vc_disable_frontend();
}

if(!isset($fwp_custom_js)){
	global $fwp_custom_js;
	$fwp_custom_js = array();
}

if(!isset($fwp_demo_found)){
	global $fwp_demo_found;
	$fwp_demo_found = false;
}

if(!isset($fwp_raw_js)){
	global $fwp_raw_js;
	$fwp_raw_js = '';
}

require_once fwp_core_uri . 'fastwp.debug.php';
require_once fwp_core_uri . 'fastwp.core.php';
require_once fwp_core_uri . 'fastwp.core.functions.php';
require_once fwp_core_uri . 'fastwp.core.actions.php';
require_once fwp_core_uri . 'fastwp.core.vc-config.php';
require_once fwp_core_uri . 'fastwp.user.interface.php';
require_once fwp_core_uri . 'fastwp.utils.php';
require_once fwp_core_uri . 'fastwp.abstract.php';
require_once fwp_lib_uri  . 'ReduxCore/framework.php';
require_once fwp_lib_uri  . 'ReduxCore/loader.php';
require_once fwp_core_uri . '/redux-config/fastwp.redux.metabox.config.php';
require_once fwp_core_uri . '/redux-config/fastwp.redux.config.php';
require_once 'fastwp.theme.functions.php';

if( is_admin() ) {
	require_once fwp_lib_uri . 'php/admin.interface.php';
	require_once fwp_lib_uri . 'php/admin.metabox.php';
	require_once fwp_lib_uri . 'php/plugin.activator.php';
	require_once fwp_core_uri . 'fastwp.admin.menu.php';
}

if( !function_exists( 'action_explorer' ) ) {
	add_action('fwp_shortcode_output', 'action_explorer');
	function action_explorer($a){
		fastwp_debug::add_row("Called '$a'");
	}
}

// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 980;

if ( is_singular() ) wp_enqueue_script( "comment-reply" );

if(function_exists('vc_set_default_editor_post_types')){
	$list = array('page', 'fwp_portfolio', 'fwp_fs_sections');
	vc_set_default_editor_post_types( $list );
}


if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'theme_slug_render_title' );
endif;
