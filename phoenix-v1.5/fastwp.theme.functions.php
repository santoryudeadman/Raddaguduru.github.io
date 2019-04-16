<?php
define('child_theme_url', get_stylesheet_directory_uri());
add_image_size( 'latest-projects', 400, 300, true );

global
	$fwp_load_styles,
	$fwp_load_scripts,
	$fwp_metaboxes,
	$fwp_custom_posts,
	$fwp_required_plugins,
	$fwp_custom_posts_with_id,
	$fwp_custom_taxonomies,
	$fwp_visual_composer_blocks,
	$fwp_shortcodes,
	$fwp_test,
	$fwp_data,
	$fwp_post_navigation_style;

if(!isset($fwp_custom_js)){
	global $fwp_custom_js;
	$fwp_custom_js = array();
}

if(!isset($fwp_post_navigation_style) || is_empty($fwp_post_navigation_style)){
	$fwp_post_navigation_style = 1;
}

$fwp_load_scripts = array(
	'scripts',
	'jquery.countdown.min',
	'jquery.plugin.min',
	'modernizr.custom',
	'okvideo.min',
	'overlay',
	'preloader',
	'//maps.googleapis.com/maps/api/js?key=' . ( !empty( $fwp_data['fwp_gmap_key'] ) ? esc_html( $fwp_data['fwp_gmap_key'] ) : '' ),
	'googleMapInit',
	'jquery.matchHeight-min',
	'BackgroundEffect',
	'jquery.magnific-popup.min',
	'typed.min',
    'packery-mode.pkgd.min',
	'custom',
);

$fwp_load_styles = array(
	'bootstrap.min',
	'font-awesome.min',
	'jquery.countdown',
	'owl.carousel',
	'preloader',
	'layout',
	'responsive',
	'timeline.min',
	'//fonts.googleapis.com/css?family=Lato:100,300'
);

if(isset($fwp_load_styles_child)){
	$fwp_load_styles = array_merge($fwp_load_styles, $fwp_load_styles_child);
}

if(isset($fwp_load_scripts_child)){
	$fwp_load_scripts = array_merge($fwp_load_scripts, $fwp_load_scripts_child);
}

$fwp_custom_posts = null;

add_action('init', 'fwp_theme_init_custom_post_types',1);
function fwp_theme_init_custom_post_types(){
	global $fwp_data, $fwp_custom_posts, $fwp_metaboxes, $fwp_custom_taxonomies ;

$customPortfolioSlug = (isset($fwp_data['fastwp_portfolio_slug'])) ? $fwp_data['fastwp_portfolio_slug'] : 'project';
$fwp_custom_posts = array(
	'fwp_portfolio' => array(
		'name' 				 => 'Portfolio',
		'single' 			 => 'Portfolio Item',
		'multiple' 			 => 'Portfolio Items',
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $customPortfolioSlug ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail')
		)
	),
	'fwp_team' => array(
		'name' 				 => 'Members',
		'single' 			 => 'Member',
		'multiple' 			 => 'Members',
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'member' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail')
		)
	),
	'fwp_service' => array(
		'name' 				 => 'Services',
		'single' 			 => 'Service',
		'multiple' 			 => 'Services',
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'service' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'excerpt')
		)
	),
	'fwp_testimonial' => array(
		'name' 				 => 'Testimonials',
		'single' 			 => 'Testimonial',
		'multiple' 			 => 'Testimonials',
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'testimonial' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author')
		)
	),
	'fwp_timeline' => array(
		'name' 				 => 'Timeline',
		'single' 			 => 'Timeline',
		'multiple' 			 => 'Timeline',
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'timeline' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor')
		)
	),

);

$fwp_custom_taxonomies = array(
	'portfolio-category' => array(
		'post_type' => 'fwp_portfolio',
		'settings' => array(
		    'hierarchical'        => true,
		 //   'labels'              => $labels,
		    'show_ui'             => true,
		    'show_admin_column'   => true,
		    'query_var'           => true,
			'show_in_nav_menus'	  => false,
		    'rewrite'             => array( 'slug' => 'portfolio-category' )
		 )
	 ),
	'timeline-category' => array(
		'post_type' => 'fwp_timeline',
		'settings' => array(
		    'hierarchical'        => true,
		 //   'labels'              => $labels,
		    'show_ui'             => true,
		    'show_admin_column'   => true,
		    'query_var'           => true,
			'show_in_nav_menus'	  => false,
		    'rewrite'             => array( 'slug' => 'portfolio-timeline' )
		 )
	 ),
	);

do_action('fwp_custom_tax_set');
}
$fwp_metaboxes = array(
	'page' 	=> array(
		array(
			'id'		=>'page-metabox',
			'title'		=>'Page / Section setup',
			'position'	=>'side',
			'priority'	=>'high',
			'fields'	=>array(
				array('type'=>'text-display','id'=>'standard-text','title'=>'','desc'=>'Set letter parallax for section. Standalone page is not affected by this setting.', 'class'=>''),

				array('type'=>'multi_text','id'=>'letter_parallax','title'=>'Parallax letter Settings',
					'keys'=> array(
						'text1'=>'Letter 1',
						'ratio1'=>'Letter 1 stellar ratio',
						'offset1'=>'Letter 1 offset',
						'left1'=> 'Letter 1 position relative to left window side (percent)',
						'text2'=>'Letter 2',
						'ratio2'=>'Letter 2 stellar ratio',
						'offset2'=>'Letter 2 offset',
						'left2'=> 'Letter 2 position relative to left window side (percent)',
						'text3'=>'Letter 3',
						'ratio3'=>'Letter 3 stellar ratio',
						'offset3'=>'Letter 3 offset',
						'left3'=> 'Letter 3 position relative to left window side (percent)',
						'text4'=>'Letter 4',
						'ratio4'=>'Letter 4 stellar ratio',
						'offset4'=>'Letter 4 offset',
						'left4'=> 'Letter 4 position relative to left window side (percent)',

					),
					'defaults'=> array(
						'text1'=>'',
						'ratio1'=>'1.5',
						'offset1'=>'0',
						'left1'=> '10',
						'text2'=>'',
						'ratio2'=>'0.5',
						'offset2'=>'200',
						'left2'=>'35',
						'text3'=>'',
						'ratio3'=>'0.25',
						'offset3'=>'150',
						'left3'=>'55',
						'text4'=>'',
						'ratio4'=>'0.75',
						'offset4'=>'100',
						'left4'=>'85',

					),
				'class'=>''),

				array('type'=>'colorpicker'	, 'id'=>'pcolor_t1'	, 'title'=>'Letter 1 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t1','title'=>'Letter 1 after content','desc'=>'Place letter after content', 'class'=>''),

				array('type'=>'colorpicker'	, 'id'=>'pcolor_t2'	, 'title'=>'Letter 2 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t2','title'=>'Letter 2 after content','desc'=>'Place letter after content', 'class'=>''),

				array('type'=>'colorpicker'	, 'id'=>'pcolor_t3'	, 'title'=>'Letter 3 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t3','title'=>'Letter 3 after content','desc'=>'Place letter after content', 'class'=>''),

				array('type'=>'colorpicker'	, 'id'=>'pcolor_t4'	, 'title'=>'Letter 4 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t4','title'=>'Letter 4 after content','desc'=>'Place letter after content', 'class'=>''),

				array('type'=>'colorpicker'	, 'id'=>'section_bg'	, 'title'=>'Section Background', 'class'=>''),

				array('type'=>'select'	, 'id'=>'s_padding_tpl'	, 'title'=>'Section spacing',
					'values'	=> array(
						'none'			=> 'No padding',
						'small-space'	=> 'Small padding',
						'mid-space'		=> 'Normal padding',
						'big-space'		=> 'Big padding',
					)),

				array('type'=>'multi_text', 'id'=>'s_padding_override', 'title'=>'Override padding',
					'keys'=> array(
						'top'	=> 'Top padding',
						'bottom'=> 'Bottom padding',
						'left'	=> 'Left padding',
						'right'	=> 'Right padding',
					),
					'defaults'=> array(
						'top'	=> '',
						'bottom'=> '',
						'left'	=> '',
						'right'	=> '',
					),
				'class'=>''),
			)
		),
	),

);

$fwp_required_plugins = array(
		array(
            'name'				=> 'Envato Market Plugin', // The plugin name
            'slug'				=> 'envato-market', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/envato-market.zip', // The plugin source
            'required'			=> false, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'				=> 'WPBakery Visual Composer', // The plugin name
            'slug'				=> 'js_composer', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/js_composer.zip', // The plugin source
            'required'			=> true, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '4.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
		array(
            'name'				=> 'FastWP Theme extension', // The plugin name
            'slug'				=> 'fastwp-theme-extension', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/fastwp-theme-extension.zip', // The plugin source
            'required'			=> true, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
		array(
            'name'				=> 'FastWP Importer', // The plugin name
            'slug'				=> 'fastwp-wordpress-importer', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/fastwp-wordpress-importer.zip', // The plugin source
            'required'			=> true, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'				=> 'Revolution Slider', // The plugin name
            'slug'				=> 'revslider', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/revslider.zip', // The plugin source
            'required'			=> false, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'      		=> 'Contact Form 7',
            'slug'      		=> 'contact-form-7',
            'required'  		=> true,
            'force_activation'  => false,
        ),
		array(
            'name'      		=> 'Mailchimp for Wordpress',
            'slug'      		=> 'mailchimp-for-wp',
            'required'  		=> true,
            'force_activation'  => true,
        ),

    );

$fwp_custom_posts_with_id = array('fwp_team','fwp_service','fwp_portfolio','fwp_testimonial');
$fwp_themeUrl 	= get_template_directory_uri();
$fwp_vc_css_url = $fwp_themeUrl . '/assets/css/admin.vc.css';

require_once(dirname(__FILE__).'/extend/extend.actions.php');
require_once(dirname(__FILE__).'/extend/extend.filters.php');
require_once(dirname(__FILE__).'/extend/extend.shortcodes.php');
require_once(dirname(__FILE__).'/extend/extend.visual-composer.php');
require_once(dirname(__FILE__).'/extend/extend.blog.php');

