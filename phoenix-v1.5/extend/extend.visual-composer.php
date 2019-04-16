<?php

	function getPostIdAndTitle($post_type = 'page', $value_first = false){
		global $wpdb;
		$sql = $wpdb->prepare("SELECT post_title, ID from $wpdb->posts WHERE `post_type` = '%s' AND `post_status`='publish' ORDER BY `post_title` ASC;",
			$post_type);
		$result = $wpdb->get_results( $sql, ARRAY_A );
		$output = array();
		if(isset($result) && is_array($result)){
			foreach($result as $item){
				if($value_first == true){
					$key = $item['post_title'];
					$value=$item['ID'];
				}else {
					$key = $item['ID'];
					$value=$item['post_title'];
				}
				$output[$key] = $value;
			}
		}
		return $output;
	}

	function fwp_get_categories($key = 'portfolio-category', $isPortfolioFilter = false){
		$terms = get_terms(array($key), array( 'hide_empty' => 0 ) );
		$categories = array();
		if($isPortfolioFilter == true){
			$categories['Show All'] = '.f--all';
			foreach($terms as $k=>$v){
				if(isset($v->name) && isset($v->slug))
					$categories[$v->name] = '.f-'.$v->slug;
			}
		}else{
			foreach($terms as $k=>$v){
				if(isset($v->name) && isset($v->term_id))
					$categories[$v->name] = $v->term_id;
			}
		}
		return $categories;
	}

add_action('init', 'fwp_load_visual_composer_blocks',2);

$fwp_visual_composer_param_blocks = array(

	    array( 'id' => 'vc_row', 'params' => array(

		array(
			"type"          => 'dropdown',
            "group"         => "Phoenix Options",
			"heading" 		=> esc_html__("Boxed Layout",'fastwp-phoenix'),
			"param_name" 	=> 'fwp_boxed',
			'value'			=> array(
							        'No'   => 0,
                                    'Yes'     => 1,
							    	),
			"default" 		=> '',
		),

		array(
			"type"          => 'dropdown',
            "group"         => "Phoenix Options",
			"heading" 		=> esc_html__("Content Offset",'fastwp-phoenix'),
			"param_name" 	=> 'fwp_offset',
			'value'			=> array(
							        'No'   => 0,
                                    'Yes'  => 1,
							    	),
			"default" 		=> '',
		),

        )

        )

        );

function fwp_load_visual_composer_blocks(){
global $fwp_visual_composer_blocks;

$fwp_visual_composer_blocks = array(
	array(
		"name" => __("Video background section",'fastwp'),
		"base" => "fwp-video-bg",
		"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
		"category" => __('Home sections','fastwp'),
		"params" => array(
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,

					"heading" => __("Video",'fastwp'),
					"param_name" => "video",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter Video url",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,

					"heading" => __("Fallback image",'fastwp'),
					"param_name" => "image",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Falback image for devices that don`t support video background",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Overlay content page",'fastwp'),
					"param_name" 	=> "pageid",
					"value" 		=> getPostIdAndTitle('page', true),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),

				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Black overlay",'fastwp'),
					"param_name" 	=> "overlay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Add transparent overlay over content",'fastwp'),
					"admin_label	"=>true,
				 ),

				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Autoplay",'fastwp'),
					"param_name" 	=> "autoplay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Automatically play the video",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"save_always"	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Loop",'fastwp'),
					"param_name" 	=> "loop",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Play continously",'fastwp'),
					"admin_label"	=> true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Highdef",'fastwp'),
					"param_name" 	=> "highdef",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					//  "description" 	=> __("",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("HD",'fastwp'),
					"param_name" 	=> "hd",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
				 //   "description" 	=> __("",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Ad Proof",'fastwp'),
					"param_name" 	=> "adproof",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Remove ads",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Volume",'fastwp'),
					"param_name" => "volume",
					"value" => '0',
					"default" => '0',
					"admin_label"=>false,
					"description" => __("Play volume",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
			
		)
	),

array(
		"name" => __("Slider background section",'fastwp'),
		"base" => "fwp-slider-bg",
		"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	  
		"category" => __('Home sections','fastwp'),
		"params" => array( 
				array(
					"save_always" 	=> true,
					"type" 			=> "attach_images",
					"holder" 		=> false,
					"heading" 		=> __("Images",'fastwp'),
					"param_name" 	=> "images",
					"value" 		=> '',
					"admin_label"	=>false,
					"description" 	=> __("Items to run into background slider",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"save_always" 	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Overlay content page",'fastwp'),
					"param_name" 	=> "pageid",
					"value" 		=> getPostIdAndTitle('page', true),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"save_always" 	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Black overlay",'fastwp'),
					"param_name" 	=> "overlay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Add transparent overlay over content",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"save_always" 	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Overlay type",'fastwp'),
					"param_name" 	=> "overlay_type",
					"value" 		=> array('Radial'=>'radial', 'Plain' => 'plain'),
					"description" 	=> __("Choose Overlay Type",'fastwp'),
					"admin_label	"=>true,
					"dependency"=> array( "element" => "overlay", "value" => "true" )
				 ),
				array(
					"type" 			=> "dropdown",
					"save_always"	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Animated Canvas",'fastwp'),
					"param_name" 	=> "mouse_tracking",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Display a mouse tracking animated canvas over section",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"save_always" 	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Full Screen",'fastwp'),
					"param_name" 	=> "full_screen",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Display slider section as full screen on full width. Default : full screen",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Duration",'fastwp'),
					"param_name" => "duration",
					"value" => '2000',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Fade",'fastwp'),
					"param_name" => "fade",
					"value" => '750',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
			
		)
	),


/** 
A
**/
	array(
		"name" => __("About item",'fastwp'),
		"base" => "about-item",
		"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
		"category" => __('Theme Elements','fastwp'),
		"params" => array(
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Layout type",'fastwp'),
					"param_name" 	=> "layout",
					"value" 		=> array('Icon on Top'=>'icon-top', 'Icon Under' => 'icon-under'),
					"description" 	=> __("Choose About Shortcode Layout",'fastwp'),
					"admin_label	"=>true,
				 ), 
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,			
					"heading" => __("Content",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Your content here",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Title",'fastwp'),
					"param_name" => "title",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Your title here",'fastwp')
				 ),
				array(
					"save_always" 	=> true,
		             'type' => 'iconpicker',
		             'heading' => __( 'Icon', 'fastwp' ),
		             'param_name' => 'icon',
		             'settings' => array(
		                 'emptyIcon' => false,
		                 'iconsPerPage' => 200,
		             ),
		             "description" 	=> esc_html__("Choose what icon do you want to use (use font awesome icons).",'fastwp'),
		         ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"save_always" 	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Animate text",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter left move 5px over 1s after 0.6s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
		)
	),

	array(
			"name" => __("Animated Counter",'fastwp'),
			"base" => "fwp-counter",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Title",'fastwp'),
					"param_name" 	=> "title",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Counter title",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Suffix",'fastwp'),
					"param_name" 	=> "suffix",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Append this to count value",'fastwp')
				 ),

				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Start at",'fastwp'),
					"param_name" 	=> "start",
					"value" 		=> '0',
					"admin_label"	=>true,
					"description" 	=> __("Counter start value",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("End at",'fastwp'),
					"param_name" 	=> "end",
					"value" 		=> '100',
					"admin_label"	=>true,
					"description" 	=> __("Count up to",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Speed",'fastwp'),
					"param_name" 	=> "speed",
					"value" 		=> '2000',
					"admin_label"	=>true,
					//  "description" 	=> __("",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Refresh interval",'fastwp'),
					"param_name" 	=> "interval",
					"value" 		=> '10',
					"admin_label"	=>true,
					//"description" 	=> __("",'fastwp')
				 ),

			),
	),


	array(
			"name" => __("Animated text",'fastwp'),
			"base" => "fwp-anim-text",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(
				
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate text",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter right move 10px over 1s after',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => __("Content",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter content",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
			)
	   ),

/** 
B
**/	/*
	array(
			"name" => __("Block Quote",'fastwp'),
			"base" => "fwp-bq",
			
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Title",'fastwp'),
					"param_name" 	=> "title",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Counter title",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => __("Content",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Your content here",'fastwp')
				 ),
			),
		),	*/
		array(
			"name" => __("Block Quote",'fastwp'),
			"base" => "fwp-blockquote",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(
			 array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"heading" 		=> __("Style",'fastwp'),
					"param_name" 	=> "style",
					"value" 		=> array('Normal'=>'left','Reverse'=>'right',),
					"description" 	=> __("Set text alignment",'fastwp'),
					"admin_label"	=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Animate text",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					'default'		=> 'false',
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label"	=> true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter top move 10px over 1s after 0.2s',
					"admin_label"	=> false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
				array(
					"save_always"	=> true,
					"type" 			=> "textarea_html",
					"holder" 		=> false,
					"heading" 		=> __("Content",'fastwp'),
					"param_name" 	=> "content",
					"value" 		=> '',
					"admin_label"	=> true,
					"description" 	=> __("Your content here",'fastwp')
				 ),
			),
		),
		array(
			"name" => __("Bordered Title",'fastwp'),
			"base" => "title-with-border",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Title",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Your title here",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Align",'fastwp'),
					"param_name" => "text_position",
					"value" => array('Left'=>'left','Center'=>'center','Right'=>'right',),
					"description" => __("Set title text alignment",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,   
					"heading" => __("Border Width",'fastwp'),
					"param_name" => "border_width",
					"value" => '10',
					"admin_label"=>true,
					"description" => __("Border width (without px) default 10",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,  
					"heading" => __("Border Color",'fastwp'),
					"param_name" => "border_color",
					"value" => '#282828',
					"admin_label"=>true,
					"description" => __("Border color for title, default #282828",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Hide border",'fastwp'),
					"param_name" 	=> "hide_border",
					"value" 		=> array('No' => 'false', 'Yes'=>'true'),
					"description" 	=> __("Hide border below 480px",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Responsive border",'fastwp'),
					"param_name" 	=> "responsive_border",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Change border width on resize",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,  
					"heading" => __("Title Color",'fastwp'),
					"param_name" => "color",
					"value" => '#333',
					"admin_label"=>true,
					"description" => __("Select font color for title",'fastwp')
				 ),

				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate text",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter top move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),

				
				 array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Shortcode tag",'fastwp'),
					"param_name" 	=> "tag",
					"value" 		=> array('h1', 'h2', 'h3', 'h4', 'h5'),
					"std"		=> "h2",
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				 array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Aditional class",'fastwp'),
					"param_name" 	=> "extra_class",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Classes to be added on element",'fastwp')
				 ),

			)
	   ),



		array(
			"name" => __("Button",'fastwp'),
			"base" => "fwp-button",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Label (title)",'fastwp'),
					"param_name" 	=> "label",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Button label",'fastwp')
				 ),

				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Type (style)",'fastwp'),
					"param_name" => "type",
					"value" => array(
						'Default (black)'=>'black',
						'White'=>'default',
						'Primary'=>'primary',
						'Success'=>'success',
						'Information'=>'info',
						'Warning'=>'warning',
						'Danger alert'=>'danger',
						'Simple link'=>'link',

						),
					"description" => __("Set type of button (style)",'fastwp'),
					"admin_label"=>true,
				 ),

				array(
					"type" 			=> "textfield",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> __("Link",'fastwp'),
					"param_name" 	=> "link",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("URL where to go when a tag is selected",'fastwp')
				 ),			
				 array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Link target",'fastwp'),
					"param_name" 	=> "target",
					"value" 		=> array('Same page'=>'', 'New window'=>'_blank'),
					"description" 	=> __("Link target is available just for 'a' tag.",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Animate",'fastwp'),
					"param_name" 	=> "animate",
					"value" 		=> array('Yes'=>'true', 'No'=>'false'),
					"description" 	=> __("Link target is available just for 'a' tag.",'fastwp'),
					"default"		=> 'false',		 
				),
				 array(
					"type" 			=> "textfield",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> __("Action",'fastwp'),
					"param_name" 	=> "action",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Javascript action to execute on click",'fastwp')
				 ),	 
				 array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Shortcode tag",'fastwp'),
					"param_name" 	=> "tag",
					"value" 		=> array('button', 'a'),
					"description" 	=> __("Button element type. A elements supports open in new window and url, buttons supports just action",'fastwp'),
					"admin_label	"=>true,
				 ),
				 array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Align",'fastwp'),
					"param_name" 	=> "align",
					"value" 		=> array('Default (no align)'=>'', 'Center'=>'center', 'Right'=>'right'),
					"description" 	=> __("Align button relative to parent width",'fastwp'),
					"admin_label	"=>true,
				 ),
				 array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Aditional class",'fastwp'),
					"param_name" 	=> "extra_class",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Classes to be added on element",'fastwp')
				 ),

			)
	   ),



/** 
C
**/
		array(
			"name" => __("Clearfix",'fastwp'),
			"base" => "fwp-clearfix",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => false
			),

		array(
			"name" => __("Clients carousel",'fastwp'),
			"base" => "our-clients",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,
					
					"heading" => __("Clients",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Each client on new line. Pipe sepparated image and url",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate text",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter right move 10px over 1s after',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
				array(
					"group"     	=> "Slider Options",
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> __("Autoplay",'fastwp'),
					"param_name" 	=> "autoplay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"default"		=> 'true',
					"admin_label"	=>	true,
					"description" 	=> __("Autoscroll clients, if off you can still drag / touchswipe",'fastwp')
				 ),
				array(
					"save_always" 	=> true,
					"group"     	=> "Slider Options",
					"type" 			=> "textfield",
					"holder" 		=> false,
					"heading" 		=> __("Slider speed",'fastwp'),
					"param_name" 	=> "testimonial_slider_speed",
					"value" 		=> '',
					"description" 	=> __("Clients Slider speed in ms. Default 4000ms or 4sec ",'fastwp'),
					"dependency"=> array( "element" => "autoplay", "value" => "true" )

				 ),				 				 
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"group"     	=> "Slider Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Show controls",'fastwp'),
					"param_name" 	=> "show_controls",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"default"		=> 'true',
					"admin_label"	=>true,
					"description" 	=> __("Display carousel navigation arrows",'fastwp')
				 ),
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"group"     	=> "Slider Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Stop on hover",'fastwp'),
					"param_name" 	=> "stop_on_hover",
					"value" 		=> array( 'No' => 'false', 'Yes'=>'true'),
					"default"		=> 'false',
					"admin_label"	=>true,
					"description" 	=> __("Stop carousel on mouse hover.",'fastwp')
				 ),
			   )
			),


		array(
			"name" => __("Coming soon",'fastwp'),
			"base" => "fwp-coming-soon",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Launch date",'fastwp'),
					"param_name" => "date",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Launch date in format 12/21/2014 23:59:59",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => __("Message",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Enter here your informations",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					
					"heading" => __("Background color",'fastwp'),
					"param_name" => "bg_color",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Select background color for section",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,
					
					"heading" => __("Background image",'fastwp'),
					"param_name" => "image",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Select background image for section",'fastwp')
				 ),
				 array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Aditional class",'fastwp'),
					"param_name" 	=> "extra_class",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Classes to be added on element",'fastwp')
				 ),
			),
	   ),

	array(
			"name" => __("Contact info",'fastwp'),
			"base" => "fwp-contact-info",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
		//	"admin_enqueue_css" => $fwp_vc_css_url,
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Icon class",'fastwp'),
					"param_name" => "icon",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Icon class",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => __("Contact info",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Enter here your informations",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter left move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
			),
	   ),


/** 
G
**/

	array(
			"name" => __("Gallery slider",'fastwp'),
			"base" => "fwp-slider",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" => __('Theme Elements','fastwp'),
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "attach_images",
					"holder" => false,					
					"heading" => __("Gallery items",'fastwp'),
					"param_name" => "items",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Select desired images",'fastwp')
				 ),
 				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"save_always"	=> "true",
					"class" 		=> "",
					"heading" 		=> __("Arrow position",'fastwp'),
					"param_name" 	=> "arrows_position",
					"value" 		=> array('Under Slider'=>'', 'Vertical Center' => 'center'),
					"description" 	=> __("Choose slider navigation arrosw position",'fastwp'),
					"admin_label	"=>true,
				 ),
			),
	   ),

	array(
			"name" => __("Google map",'fastwp'),
			"base" => "fwp-map",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => __('Theme Elements','fastwp'),
			"params" => array(
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => esc_html__( 'Center of map', 'basho' ),
					"param_name"    => 'center',
					"value"         => '44.434596,26.080533',
					"admin_label"   => true
				),
				array(
					"save_always"   => true,
					"type" 			=> "dropdown",
					"holder"        => false,
					"heading" 		=> esc_html__( 'Map style', 'basho' ),
					"param_name" 	=> "map_style",
					"value" 		=> array( 'FastwpStyle' => 'fastwp', 'Default Google Style' => 'default' ),
					"description" 	=> esc_html__( 'Choose map style', 'basho' ),
					"admin_label"   => true,
				),
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => esc_html__( 'Default zoom', 'basho' ),
					"param_name"    => "map_zoom",
					"value"         => '8',
					"admin_label"   => true,
				),
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => esc_html__( 'Zoom of map when click on a marker', 'basho' ),
					"param_name"    => "map_izoom",
					"value"         => '12',
					"admin_label"   => true
				),
				array(
                    'type'          => 'param_group',
                    'param_name'    => 'pins',
                    'params'        =>  array(
                            				array(
                            					"save_always"   => true,
                            					"type"          => 'textfield',
                            					"holder"        => false,
                            					"heading"       => esc_html__( 'Marker coordinates', 'basho' ),
                            					"param_name"    => 'marker_addr',
                            					"value"         => '44.434596,26.080533',
                            					"admin_label"   => false,
                            					//"description"   => esc_html__( '', 'basho' )
                            				),
                            				array(
                            					"save_always"   => true,
                            					"type"          => 'textfield',
                            					"holder"        => false,
                            					"heading"       => esc_html__( 'Marker title', 'basho' ),
                            					"param_name"    => 'marker_title',
                            					"value"         => 'Our Location',
                            					"admin_label"   => false,
                            					//"description"   => esc_html__( '', 'basho' )
                            				),
                            				array(
                            					"save_always"   => true,
                            					"type"          => 'textarea',
                            					"holder"        => false,
                            					"heading"       => esc_html__( 'Marker content', 'basho' ),
                            					"param_name"    => 'marker_content',
                            					"admin_label"   => false,
                            					//"description"   => esc_html__( '', 'basho' )
                            				)
                                        )
                ),
 				array(
                    "group"         => esc_html__( 'Extras', 'basho' ),
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => esc_html__("Extra class", 'basho' ),
					"param_name"    => "extra_class",
					"admin_label"   => true
				),
			),
	   ),



/** 
F
**/
		array(
			"name" => __("Font Awesome Icon",'fastwp'),
			"base" => "fa-icon",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Icon class",'fastwp'),
					"param_name" 	=> "icon",
					"value" 		=> '',
					"admin_label"	=>false,
					"description" 	=> __("See documentation for valid icons",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Icon size",'fastwp'),
					"param_name" 	=> "size",
					"value" 		=> array('1X'=>'1', '2X' => '2', '3X'=>'3', '4X' => '4'),
					"description" 	=> __("Icon size relative to original",'fastwp'),
					"admin_label	"=>true,
				 ),
			),
		),  

		array(
			"name" => __("Font Awesome Icons with link",'fastwp'),
			"base" => "fwp-social-fa",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Icon class",'fastwp'),
					"param_name" 	=> "icon",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("URL",'fastwp'),
					"param_name" 	=> "link",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Target",'fastwp'),
					"param_name" 	=> "target",
					"value" 		=> '_blank',
					"admin_label"	=>false,
					"description" 	=> __("",'fastwp')
				 ),

			),
		),  



/** 
I
**/


	array(
			"name" => __("Animated Image",'fastwp'),
			"base" => "fwp-image",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" => __('Theme Elements','fastwp'),
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "attach_images",
					"holder" => false,					
					"heading" => __("Image",'fastwp'),
					"param_name" => "item",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Select desired image - use only 1 image",'fastwp')
				 ),
 				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"save_always" => true,
					"heading" 		=> __("Animate",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter right move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Image Border",'fastwp'),
					"param_name" => "border_width",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Add value for border witdh, only numeric values. Default none",'fastwp')
				),
				 array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					"heading" => __("Border color",'fastwp'),
					"param_name" => "border_color",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Set border color, default transparent",'fastwp')
				),

			),
	   ),



/** 
L
**/
		array(
			"name" => __("Latest projects",'fastwp'),
			"base" => "fwp-latest-projects",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Projects to show",'fastwp'),
					"param_name" => "count",
					"value" => '3',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Target",'fastwp'),
					"param_name" 	=> "target",
					"value" 		=> array('Same window' => '', 'Modal window' => '', 'New window'=>'_blank'),
					"description" 	=> __("Open projects in same window or new window",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Include just those projects",'fastwp'),
					"param_name" => "include",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of projects to show",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Exclude those projects",'fastwp'),
					"param_name" => "exclude",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of projects to ignore",'fastwp')
				),

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("More label",'fastwp'),
					"param_name" => "more_label",
					"value" => __('More','fastwp'),
					"admin_label"=>true,
					"description" => __("Enter here custom label for &quot;More&quot; button.",'fastwp')
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter right move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),
			),
		), 

	array(
			"name" => __("Latest Posts Slider",'fastwp'),
			"base" => "fwp-latest-posts",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Number of posts to show",'fastwp'),
					"param_name" => "count",
					"value" => '3',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),/*
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Target",'fastwp'),
					"param_name" 	=> "target",
					"value" 		=> array('Same window' => '', 'New window'=>'_blank'),
					"description" 	=> __("Open projects in same window or new window",'fastwp'),
					"admin_label	"=>true,
				 ),*/
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Include just those posts",'fastwp'),
					"param_name" => "include",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of projects to show",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Exclude those posts",'fastwp'),
					"param_name" => "exclude",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of projects to ignore",'fastwp')
				),

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("More label",'fastwp'),
					"param_name" => "more_label",
					"value" => __('Read More','fastwp'),
					"admin_label"=>true,
					"description" => __("Enter here custom label for &quot;More&quot; button.",'fastwp')
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter right move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),
			),
		),  


/** 
M
**/
		array(
			"name" => __("Mailchimp subscribe form",'fastwp'),
			"base" => "fwp-mailchimp",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"type" 			=> "textfield",
					"holder" 		=> false,
					"heading" 		=> __("Form ID",'fastwp'),
					"param_name" 	=> "formid",
					"value" 		=> '1',
					"admin_label"	=>false,
					"description" 	=> __("Set Form ID",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" 		=> false,
					"heading" 		=> __("Placeholder text",'fastwp'),
					"param_name" 	=> "email_placeholder",
					"value" 		=> 'Enter email',
					"admin_label"	=>true,
					"description" 	=> __("Set placeholder for email input",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,
					"heading" => __("Success message",'fastwp'),
					"param_name" => "success_msg",
					"value" => 'Thank you for subscribing.<br>Your email (<strong>%s</strong>) was successfully added to database.',
					"admin_label"=>false,
					"description" => __("Set message shown to user when success. Insert '%s' where you want submitted address to be visible.",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,
					"heading" => __("Fail message",'fastwp'),
					"param_name" => "fail_msg",
					"value" => 'Your email (<strong>%s</strong>) cannot be added to database.<br>This occurs when you already subscribed or a server error is encountered.',
					"admin_label"=>false,
					"description" => __("Set message shown to user when submissin fails. Insert '%s' where you want submitted address to be visible.",'fastwp')
				),

				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter left move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),

				array(
					"type" 			=> "textfield",
					"holder" 		=> false,
					"heading" 		=> __("Extra class",'fastwp'),
					"param_name" 	=> "extra_class",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> __("Extra class name",'fastwp')
				 ),
			),
		),  		

		array(
			"name" => __("Mesage box",'fastwp'),
			"base" => "fwp-message",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Message type",'fastwp'),
					"param_name" 	=> "type",
					"value" 		=> array('Success' => 'success', 'Info' => 'info', 'Warning' => 'warning', 'Danger' => 'danger' ),
					"description" 	=> __("Select message box type",'fastwp'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Dismissible message",'fastwp'),
					"param_name" 	=> "dismissible",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> __("Dismiissible message",'fastwp'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => __("Message",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Enter your message here",'fastwp')
				),
			),
		), 

/** 
N
**/


		array(
			"name" => __("Navigation Box",'fastwp'),
			"base" => "fwp-navigation-box",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" => __('Theme Elements','fastwp'),
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,					
					"heading" => __("Image",'fastwp'),
					"param_name" => "item",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Select desired image - use only 1 image",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Link url",'fastwp'),
					"param_name" => "url",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Insert link, for one page use #-s section name strcuture, ex. #s-about",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Title",'fastwp'),
					"param_name" => "title",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Write the text displayed on box - you can use html tags for styling",'fastwp')
				),
				array(
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Title Tag",'fastwp'),
					"param_name" 	=> "tag",
					"value" 		=> array('H1' => 'h1', 'H2' => 'h2', 'H3' => 'h3', 'H4' => 'h4' , 'H5' => 'h5', 'H6' => 'h6'),
					"save_always"	=> true,
					"default"		=> "h3",
					"admin_label"	=> true,
				),
				 array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					"heading" => __("Background ",'fastwp'),
					"param_name" => "overlay_color",
					"value" => '#333',
					"admin_label"=>false,
					"description" => __("Set box overlay color, default #333",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Opacity",'fastwp'),
					"param_name" => "bkg_opacity",
					"value" => '0.3',
					"admin_label"=>true,
					"description" => __("Background opacity on mouse hover. values from 0 to 1",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Extra Class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Add custom class to element. You can use it to modify the syling later via CSS",'fastwp')
				),

			),
	   ), 
/** 
P
**/

		array(
			"name" => __("Parallax letter",'fastwp'),
			"base" => "fwp-parallax-letter",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Letter",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Animation ratio",'fastwp'),
					"param_name" => "anim_ratio",
					"value" => '1.5',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Top position offset",'fastwp'),
					"param_name" => "anim_offset",
					"value" => '0',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Horizontal position",'fastwp'),
					"param_name" => "hposition",
					"value" => '50%',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),


				 array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					"heading" => __("Letter color",'fastwp'),
					"param_name" => "lcolor",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Set color of the letter",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				),
			)
		),

		array(
			"name" => __("Partial gradient",'fastwp'),
			"base" => "fwp-partial-overlay",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 

				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,
					"heading" => __("Select left side image",'fastwp'),
					"param_name" => "image",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Choose an image",'fastwp')
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Overlay content page",'fastwp'),
					"param_name" 	=> "pageid",
					"value" 		=> getPostIdAndTitle('page', true),
					"description" 	=> __("Select page to use above picture and gradient.",'fastwp'),
					"admin_label	"=>true,
				 ),
				
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				),
			)
		),

		array(
			"name" => __("Portfolio",'fastwp'),
			"base" => "portfolio",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Include just those projects",'fastwp'),
					"param_name" => "include",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of projects to show",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Exclude those projects",'fastwp'),
					"param_name" => "exclude",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of projects to ignore",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "checkbox",
					"holder" => false,
					
					"heading" => __("Exclude those categories",'fastwp'),
					"param_name" => "exclude_cat",
					"value" => fwp_get_categories('portfolio-category'),
					"admin_label"=>false,
					"description" => __("Check categories to exclude from portfolio",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					"heading" => __("Default category",'fastwp'),
					"param_name" => "default_cat",
					"value" => fwp_get_categories('portfolio-category', true),
					"admin_label"=>false,
					"description" => __("Select default filter for portfolio",'fastwp')
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"edit_field_class"			=> "w50_fastwp_vc",
					"group"         => "Design Options",
					"class" 		=> "",
					"heading" 		=> __("Overlay visible on mobile",'fastwp'),
					"param_name" 	=> "show_overlay",
					"value" 		=> array('No' => 'No', 'Yes'=>'yes'),
					"description" 	=> __("Show overlay active by default on touch devices like project is hovered",'fastwp'),
					"admin_label	"=> true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"edit_field_class"			=> "w50_fastwp_vc",
					"group"         => "Design Options",
					"class" 		=> "",
					"heading" 		=> __("Boxed style",'fastwp'),
					"param_name" 	=> "boxed",
					"value" 		=> array('No' => 'No', 'Yes'=>'yes'),
					"description" 	=> __("Show portfolio items in container",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Portfolio grid style",'fastwp'),
					"param_name" 	=> "styleid",
					"value" 		=> array('3 Columns(default)' => '0', '2 Columns'=>'1', '4 Columns'=>'2', 'Detalied items'=>'3'),
					"description" 	=> __("Show portfolio items in container",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Portfolio type",'fastwp'),
					"param_name" 	=> "layout",
					"value" 		=> array('Masonry (default)' => '', 'Packery'=>'packery'),
					"description" 	=> __("Portfolio initialization type",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"group"         => "Design Options",
					"save_always" => true,
					"edit_field_class"			=> "w50_fastwp_vc",	
					"heading" => __("Portfolio Gutter",'fastwp'),
					"param_name" => "gutter_width",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Choose portfolio gutter width in px, leave empty for no gutter insert just numeric values",'fastwp')
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"group"         => "Design Options",
					"save_always" => true,
					"edit_field_class"			=> "w50_fastwp_vc",
					"class" 		=> "",
					"heading" 		=> __("Display filters",'fastwp'),
					"param_name" 	=> "show_filters",
					"value" 		=> array('Yes'=>'yes','No' => 'No'),
					"description" 	=> __("Display or not the project filters",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
				 	"group"         => "Design Options",
					"save_always" => true,
					"edit_field_class"			=> "w50_fastwp_vc",
					"type" => "colorpicker",
					"holder" => false,
					"heading" => __("Gutter background color",'fastwp'),
					"param_name" => "gutter_color",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Color for background gutter, also check the row background color for perfect matching",'fastwp')
				),
				 array(
					"save_always" => true,
					"group"         => "Design Options",
					"edit_field_class"			=> "w50_fastwp_vc",
					"type" => "colorpicker",
					"holder" => false,
					"heading" => __("Filter background color",'fastwp'),
					"param_name" => "filter_bg",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Color for background on portfolio filters",'fastwp')
				),
				 array(
					"save_always" => true,
					"group"         => "Design Options",
					"edit_field_class"			=> "w50_fastwp_vc",
					"type" => "colorpicker",
					"holder" => false,
					"heading" => __("Filter buttons color",'fastwp'),
					"param_name" => "filter_col",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Color for filter and border on portfolio filter buttons",'fastwp')
				),
				 array(
					"save_always" => true,
					"type" => "colorpicker",
					"edit_field_class"			=> "w50_fastwp_vc",
					"group"         => "Design Options",
					"holder" => false,
					"heading" => __("Filter hover color",'fastwp'),
					"param_name" => "filter_col_hov",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Color for filter when hover",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,		
					"heading" => __("Label for All projects",'fastwp'),
					"param_name" => "all_label",
					"value" => '',
					"admin_label"=>false,
					"description" => __('Default: "Show all"','fastwp')
				 ),
					array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,   
					"heading" => __("Label for portfolio button",'fastwp'),
					"param_name" => "button_label",
					"value" => 'More',
					"admin_label"=>false,
					"description" => __('Default: "More"','fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"group"         => "Animation Options",
					"class" 		=> "",
					"heading" 		=> __("Animate text",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"group"         => "Animation Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter bottom move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"group"         => "Animation Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Animation delay increase",'fastwp'),
					"param_name" 	=> "anim_delay",
					"value" 		=> '0.1',
					"admin_label"	=>false,
					"description" 	=> __("Animation delay for grouped items aka portfolio filters  (in seconds)",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"group"         => "Extra",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
			)
		),

	array(
			"name" => __("Pricing table",'fastwp'),
			"base" => "fwp-price-table",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
	//		"admin_enqueue_css" => $fwp_vc_css_url,
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Title",'fastwp'),
					"param_name" => "title",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Price table title",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => __("Features list",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Your features list here",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Stars",'fastwp'),
					"param_name" => "stars",
					"value" => '0',
					"admin_label"=>true,
					"description" => __("Number of stars (half values or full values)",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Button label",'fastwp'),
					"param_name" => "submit_label",
					"value" => __('SUBSCRIBE!','fastwp'),
					"admin_label"=>false,
					"description" => __("Button label",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Button target url",'fastwp'),
					"param_name" => "submit_url",
					"value" => '#',
					"admin_label"=>false,
					"description" => __("Url where user goes when click on button",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Button target",'fastwp'),
					"param_name" => "submit_target",
					"value" => '_blank',
					"admin_label"=>false,
					"description" => __("Default: _blank",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Price",'fastwp'),
					"param_name" => "price",
					"value" => '0',
					"admin_label"=>false,
					"description" => __("Price value",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Currency",'fastwp'),
					"param_name" => "currency",
					"value" => '$',
					"admin_label"=>false,
					"description" => __("Currency symbol",'fastwp')
				 ),
				 array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Suffix first",'fastwp'),
					"param_name" => "suffix_first",
					"value" => array('No' => 'false', 'Yes'=>'true' ),
					"description" => __("Suffix first",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Animate text",'fastwp'),
					"param_name" => "animated",
					"value" => array('Yes'=>'true', 'No' => 'false'),
					"description" => __("Animate title on scroll",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Animation settings",'fastwp'),
					"param_name" => "animation",
					"value" => 'enter bottom move 10px over 1s after 0.2s',
					"admin_label"=>false,
					"description" => __("Set settings classes (See theme documentation)",'fastwp')
				 ),
			),
	   ),


		array(
			"name" => __("Project Info",'fastwp'),
			"base" => "fwp-project-info",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Font awesome icon class",'fastwp'),
					"param_name" => "icon",
					"value" => 'fa-info-circle',
					"admin_label"=>true,
					"description" => __("Choose a font awesome icon class",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					"heading" => __("Text",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Your text here",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
			)
		),


/** 
S
**/
		array(
			"name" => __("Separator",'fastwp'),
			"base" => "separator",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					"heading" => __("Color",'fastwp'),
					"param_name" => "icon_color",
					"value" => array('Black'=>'Black', 'White' => 'White'),
					"description" => __("Icon color",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Top space",'fastwp'),
					"param_name" => "offset_top",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Space in pixels",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Bottom space",'fastwp'),
					"param_name" => "offset_bottom",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Space in pixels",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Wrapper class",'fastwp'),
					"param_name" => "wrap_in",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Leave blank if you don`t need to wrap element",'fastwp')
				),
			)
	   ),
		array(
			"name" 		=> __("Services",'fastwp'),
			"base" 		=> "our-services",
			"class" 		=> "",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" 	=> __('Theme Elements','fastwp'),
			"params" 		=> array( 
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Title",'fastwp'),
					"param_name" => "title",
					"value" => '',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Title position",'fastwp'),
					"param_name" => "start_pos",
					"value" => array('Left'=>'left', 'Right' => 'right'),
					"description" => __("",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Grid type",'fastwp'),
					"param_name" => "type",
					"value" => array('Default'=>'default', 'Grid with top icon' => 'icon-top', 'Grid with left icon' => 'icon-left', 'Animated Grid with top icon' => 'animated'),
					"description" => __("",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					
					"heading" => __("Title color",'fastwp'),
					"param_name" => "title_col",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Color for services title (just for default grid type)",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					
					"heading" => __("Color for border",'fastwp'),
					"param_name" => "title_bcol",
					"value" => "",
					"description" => __("Color for services title border (just for default grid type)",'fastwp'),
					"admin_label"=>false,
				 ),
				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,
					
					"heading" => __("Top background image",'fastwp'),
					"param_name" => "title_img",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Background image for services title (just for default grid type)",'fastwp')
				),

 				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					"heading" => __("Overlay above title",'fastwp'),
					"param_name" => "title_overlay",
					"value" => array('Yes'=>'true', 'No' => 'false'),
					"description" => __("",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>false,
					"description" => __("",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,					
					"heading" => __("Include just those services",'fastwp'),
					"param_name" => "include",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of service to show",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,				
					"heading" => __("Exclude those services",'fastwp'),
					"param_name" => "exclude",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter here IDs of service to ignore",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Order by",'fastwp'),
					"param_name" => "by",
					"value" => 'post_date',
					"admin_label"=>false,
					"description" => __("",'fastwp')
				),
 				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Order mode",'fastwp'),
					"param_name" => "order",
					"value" => array('DESC', 'ASC'),
					"description" => __("",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Animate text",'fastwp'),
					"param_name" => "animated",
					"value" => array('Yes'=>'true', 'No' => 'false'),
					"description" => __("Animate title on scroll",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Animation",'fastwp'),
					"param_name" => "animation",
					"value" => 'enter right move 10px over 1s after',
					"admin_label"=>true,
					"description" => __("",'fastwp')
				),
				
			)
	   ),
		array(
			"name" 		=> __("Stellar Image (Parallax)",'fastwp'),
			"base" 		=> "fwp-img-stellar",
			"class" 		=> "",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" 	=> __('Theme Elements','fastwp'),
			"params" 		=> array( 
				
				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,
					
					"heading" => __("Select image",'fastwp'),
					"param_name" => "image",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Background image for services title (just for default grid type)",'fastwp')
				),

 				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Image align",'fastwp'),
					"param_name" => "alignment",
					"value" => array('None (Default)'=>'', 'Left' => 'abs_alignleft', 'Center' => 'abs_aligncenter', 'Right' => 'abs_alignright'),
					"description" => __("",'fastwp'),
					"admin_label"=>true,
				 ),
 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Movement ratio",'fastwp'),
					"param_name" => "data_ratio",
					"value" => "0.5",
					"description" => __("Set movement ratio (Default: 0.5)",'fastwp'),
					"admin_label"=>false,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>false,
					"description" => __("",'fastwp')
				), 
			)
	   ),








/** 
T
**/

		array(
			'name' => 'Tab Item',
			'base' => 'fwp_tab_icon',
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	   
			'as_child' => array('only' => 'fwp_tabs_icon' ),'category' => esc_html__('Theme Elements', 'fastwp'),
			'description' => esc_html__('Accordion Item', 'fastwp'),
			'content_element' => true,
			'params' => array(
				array(
					"save_always" => true,
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__('Title', 'fastwp'),
					'description' => 'Add tabs title (should be unique)',
					'param_name' => 'title',
					'value' => 'Tab Item Title',
				),
				array(
					"save_always" => true,
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__('Tab Icon', 'fastwp'),
					'description' => '',
					'param_name' => 'icon',
					'value' => 'fa-info',
				),
				array(
					"save_always" => true,
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__('Button label', 'fastwp'),
					'description' => '',
					'param_name' => 'link_label',
					'value' => 'Find out more',
				),
				array(
					"save_always" => true,
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__('Button URL', 'fastwp'),
					'description' => '',
					'param_name' => 'url',
					'value' => '',
				),
				array(
					"save_always" => true,
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__('Content', 'fastwp'),
					'param_name' => 'content',
					'value' => esc_html__('Content goes here', 'fastwp'),
				),
			)
		),

		array(
			'name' => 'Tabs',
			'base' => 'fwp_tabs_icon',
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	  
			'as_parent' => array('only' => 'fwp_tab_icon'),'category' => esc_html__('Theme Elements', 'fastwp'),
			'description' => esc_html__('Tabs', 'fastwp'),
			'content_element' => true,
			'show_settings_on_create' => false,
			"params" => array(
		        array(
		            "type" => "textfield",
		            "heading" => esc_html__("Placeholder Parameter", 'fastwp'),
		            "param_name" => "tabs_placeholder_param",
					"value" => "Tabs Container",
		            "description" => esc_html__("This is a placeholder parameter of the accordion container. It has no role or effect. Visual Composer does not display shortcodes without parameters.", 'fastwp')
		        )
		    ),
			'js_view' => 'VcColumnView'
		),
		array(
			"name" => __("Team carousel",'fastwp'),
			"base" => "our-team",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array( 
				array(
					"type" 			=> "dropdown",
					"save_always" => true,
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Team Layout",'fastwp'),
					"param_name" 	=> "layout",
					"value" 		=> array('Carousel' => 'carousel', 'Columns'=>'columns'),
					"default"		=> 'carousel',
					"admin_label	"=>true,
					"description" => __("Choose Team Shortcode layout. For columns layout choose individual team members using id field",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Include",'fastwp'),
					"param_name" 	=> "include",
					"value" 		=> '',
					"description" 	=> __("Include just those members",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Exclude",'fastwp'),
					"param_name" 	=> "exclude",
					"value" 		=> '',
					"description" 	=> __("Include all members except this",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"group"     	=> "Slider Options",
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> __("Autoplay",'fastwp'),
					"param_name" 	=> "autoplay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"default"		=> 'true',
					"admin_label"	=>	true,
					"description" 	=> __("Autoscroll team, if off you can still drag / touchswipe",'fastwp')
				 ),
				array(
					"save_always" 	=> true,
					"group"     	=> "Slider Options",
					"type" 			=> "textfield",
					"holder" 		=> false,
					"heading" 		=> __("Slider speed",'fastwp'),
					"param_name" 	=> "slider_speed",
					"value" 		=> '',
					"description" 	=> __("Clients team speed in ms. Default 4000ms or 4sec ",'fastwp'),
					"dependency"=> array( "element" => "autoplay", "value" => "true" )

				 ),				 				 
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"group"     	=> "Slider Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Show controls",'fastwp'),
					"param_name" 	=> "show_controls",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"default"		=> 'true',
					"admin_label"	=>true,
					"description" 	=> __("Display carousel navigation arrows",'fastwp')
				 ),
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"group"     	=> "Slider Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Stop on hover",'fastwp'),
					"param_name" 	=> "stop_on_hover",
					"value" 		=> array( 'No' => 'false', 'Yes'=>'true'),
					"default"		=> 'false',
					"admin_label"	=>true,
					"description" 	=> __("Stop carousel on mouse hover.",'fastwp')
				 ),

			)
		),

	array(
			"name" => __("Testimonials",'fastwp'),
			"base" => "fwp-testimonials",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(				 
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Include",'fastwp'),
					"param_name" => "include",
					"value" => '',
					"description" => __("Testimonial ids to include",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Exclude",'fastwp'),
					"param_name" => "exclude",
					"value" => '',
					"description" => __("Testimonial ids to exclude",'fastwp')
				 ),
				array(
					"group"     	=> "Slider Options",
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> __("Autoplay",'fastwp'),
					"param_name" 	=> "autoplay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"default"		=> 'true',
					"admin_label"	=>	true,
					"description" 	=> __("Autoscroll testimonials, if off you can still drag / touchswipe",'fastwp')
				 ),
				array(
					"save_always" 	=> true,
					"group"     	=> "Slider Options",
					"type" 			=> "textfield",
					"holder" 		=> false,
					"heading" 		=> __("Slider speed",'fastwp'),
					"param_name" 	=> "testimonial_slider_speed",
					"value" 		=> '',
					"description" 	=> __("Testimonial Slider speed in ms. Default 4000ms or 4sec ",'fastwp'),
					"dependency"=> array( "element" => "autoplay", "value" => "true" )

				 ),				 				 
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"group"     	=> "Slider Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Show controls",'fastwp'),
					"param_name" 	=> "show_controls",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"default"		=> 'true',
					"admin_label"	=>true,
					"description" 	=> __("Display carousel navigation arrows",'fastwp')
				 ),
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"group"     	=> "Slider Options",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Stop on hover",'fastwp'),
					"param_name" 	=> "stop_on_hover",
					"value" 		=> array( 'No' => 'false', 'Yes'=>'true'),
					"default"		=> 'false',
					"admin_label"	=>true,
					"description" 	=> __("Stop carousel on mouse hover.",'fastwp')
				 ),
			)
	   ),

	array(
			"name" => __("Text typing",'fastwp'),
			"base" => "fwp_text_writer",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(
					array(
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> __("Typing mode",'fastwp'),
					"param_name" 	=> "mode",
					"value" 		=> array( 'One per row' => 0, 'Continous' => 1 ),
					"default"		=> 0,
					"admin_label"	=>true,
					"description" 	=> __("Mode how typing works",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Title Tag",'fastwp'),
					"param_name" 	=> "tag",
					"value" 		=> array('H1' => 'h1', 'H2' => 'h2', 'H3' => 'h3', 'H4' => 'h4' , 'H5' => 'h5', 'H6' => 'h6'),
					"save_always"	=> true,
					"default"		=> "h1",
					"admin_label"	=> true,
                    "dependency"    => array(
                                            "element" => "mode",
                                            "value" => array( "1" )
                                            )
				),
				array(
					"save_always" => true,
					"type" => "textarea_raw_html",
					"holder" => false,
					"heading" => __("Text lines",'fastwp'),
					"param_name" => "items",
					"value" => '',
					"description" => __("New line represents new item",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> __("Loop",'fastwp'),
					"param_name" 	=> "loop",
					"value" 		=> array('No'=>'false', 'Yes' => 'true'),
					"default"		=> 'false',
					"admin_label"	=> true,
					"description" 	=> __("Typing with loop",'fastwp')
				),
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => __("Back Delay",'fastwp'),
					"param_name"    => "backdelay",
					"value"         => '500',
					"description"   => __("",'fastwp'),
                    "dependency"    => array(
                                            "element" => "mode",
                                            "value" => array( "1" )
                                            )
				),
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => __("Typing speed",'fastwp'),
					"param_name"    => "typespeed",
					"value"         => '30',
				),
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => __("Typing start delay",'fastwp'),
					"param_name"    => "startdelay",
					"value"         => '',
				),
			)
	   ),

	array(
			"name" => __("Timeline",'fastwp'),
			"base" => "fwp-timeline",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
			"params" => array(
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Category",'fastwp'),
					"param_name" 	=> "category",
					"value" 		=> fwp_get_categories('timeline-category'),
					"default"		=> 'true',
					"admin_label"	=>true,
					"description" 	=> __("Select category of timeline items.",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Title",'fastwp'),
					"param_name" => "title",
					"value" => '',
					"description" => __("Displayed title",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Include",'fastwp'),
					"param_name" => "include",
					"value" => '',
					"description" => __("ID`s to include",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Exclude",'fastwp'),
					"param_name" => "exclude",
					"value" => '',
					"description" => __("ID`s to exclude",'fastwp')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => __("Extra module css class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"description" => __("Extra class",'fastwp')
				),
			)
	   ),

	array(
			"name" => __("Title with icon separator",'fastwp'),
			"base" => "title-with-icon",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => __('Theme Elements','fastwp'),
		//	"admin_enqueue_css" => $fwp_vc_css_url,
			"params" => array(

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Title",'fastwp'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Your title here",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					
					"heading" => __("Title color",'fastwp'),
					"param_name" => "color",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Select color",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,					
					"heading" => __("Align",'fastwp'),
					"param_name" => "text_position",
					"value" => array('Left'=>'left','Center'=>'center','Right'=>'right',),
					"description" => __("Set title text alignment",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,			
					"heading" => __("Icon type",'fastwp'),
					"param_name" => "icon",
					"value" => array('Left bars'=>'left-bars', 'Centered icon' => 'v-center'),
					"description" => __("Choose separator type after title",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					"heading" => __("Icon color",'fastwp'),
					"param_name" => "icon_color",
					"value" => array('Black', 'White'),
					"description" => __("Choose separator color",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,
					"heading" => __("Custom Icon",'fastwp'),
					"param_name" => "custom_icon",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Upload your own separator image",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Tag type",'fastwp'),
					"param_name" => "tag_name",
					"value" => array('h1','h2','h3','h4','h5'),
					"std"	=> 'h2',
					"description" => __("Choose tag name",'fastwp'),
					"admin_label"=>true,
				 ),

				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Animate text",'fastwp'),
					"param_name" => "animated",
					"value" => array('Yes'=>'true', 'No' => 'false'),
					"description" => __("Animate title on scroll",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Animation settings",'fastwp'),
					"param_name" => "animation",
					"value" => 'enter left move 10px over 1s after 0.2s',
					"admin_label"=>false,
					"description" => __("Set settings classes (See theme documentation)",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Animate icon",'fastwp'),
					"param_name" => "icon_animated",
					"value" => array('Yes'=>'true', 'No' => 'false'),
					"description" => __("Animate title on scroll",'fastwp'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Icon settings classes",'fastwp'),
					"param_name" => "icon_animation",
					"value" => 'enter left move 10px over 1s after 0.3s',
					"admin_label"=>false,
					"description" => __("Set settings classes (See theme documentation)",'fastwp')
				 ),

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Wrapper class",'fastwp'),
					"param_name" => "wrap_in",
					"value" => '',
					"admin_label"=>false,
					"description" => __("Leave blank if you don`t need to wrap element",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					
					"heading" => __("Wrapper tag",'fastwp'),
					"param_name" => "div",
					"value" => array('div','li','span'),
					"description" => __("Tag for wrapper",'fastwp'),
					"admin_label"=>false,
				 ),


			),
	   ),


/** 
V
**/


	array(
		"name" => __("Video Popup Button",'fastwp'),
		"base" => "fwp-video-button",
		"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
		"category" => __('Theme Elements','fastwp'),
		"params" => array(
				array(
					"save_always"	=>'true',
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> __("Button Alignment",'fastwp'),
					"param_name" 	=> "alignment",
					"value" 		=> array('Center' => 'center', 'Left'=>'left', 'Right' => 'right'),
					"description" 	=> __("Choose Play button alignment",'fastwp'),
					"admin_label	"=>true,
				 ), 
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,	
					"heading" => __("Video Url",'fastwp'),
					"param_name" => "video_url",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Insert video full url Vimeo or Youtube",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,		
					"heading" => __("Margin Top",'fastwp'),
					"param_name" => "margin_top",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter element margin top, numeric values without px suffix",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,		
					"heading" => __("Margin Bottom",'fastwp'),
					"param_name" => "margin_bottom",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Enter element margin bottom, numeric values without px suffix",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,  
					"heading" => __("Icon Color",'fastwp'),
					"param_name" => "color",
					"value" => '',
					"admin_label"=>true,
					"description" => __("color for play icon, default white",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,  
					"heading" => __("Icon Hover Color",'fastwp'),
					"param_name" => "hover_color",
					"value" => '#282828',
					"admin_label"=>true,
					"description" => __("color for icon in hover state , default #aaa",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Extra class",'fastwp'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => __("Extra class name",'fastwp')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animate text",'fastwp'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> __("Animate element on scroll",'fastwp'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> __("Animation settings",'fastwp'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter left move 5px over 1s after 0.6s',
					"admin_label"	=>false,
					"description" 	=> __("Set settings classes (See theme documentation)",'fastwp')
				 ),
		)
	),


	/*
	array(
			"name" => __("Testimonials 2",'fastwp'),
			"base" => "testimonials2",
			
			"category" => __('Theme Elements','fastwp'),
			"params" => array(
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Include",'fastwp'),
					"param_name" => "include",
					"value" => '',
					"description" => __("Testimonial ids to include",'fastwp')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => __("Exclude",'fastwp'),
					"param_name" => "exclude",
					"value" => '',
					"description" => __("Testimonial ids to exclude",'fastwp')
				 ),
			)
	   ),
*/


	);
	
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {class WPBakeryShortCode_fwp_tabs_icon extends WPBakeryShortCodesContainer {}}
if ( class_exists( 'WPBakeryShortCode' ) ) {class WPBakeryShortCode_fwp_tab_icon extends WPBakeryShortCode {}}

if(function_exists('vc_add_default_templates')){
	$data				 = array();
	$data['name']	   = __( 'Fastwp Project Page', 'js_composer' );
	$data['image_path'] = vc_asset_url( 'vc/templates/product_page.png' );
	$data['content']	= <<<CONTENT
	[vc_row][vc_column width="1/1"][fwp-button label="Live Preview" type="black" link="#" target="_blank" tag="button" align="center"][separator][/vc_column][/vc_row][vc_row el_class="container" gmbt_prlx_bg_type="parallax" gmbt_prlx_video_youtube_loop_trigger="0" gmbt_prlx_video_aspect_ratio="16:9" gmbt_prlx_parallax="none" gmbt_prlx_speed="0.3" gmbt_prlx_break_parents="0"][vc_column width="9/12"][vc_column_text]Maids table how learn drift but purse stand yet set. Music me house could among oh as their. Piqued our sister shy nature almost his wicket. Hand dear so we hour to. He we be hastily offence effects he service.
Doubtful two bed way pleasure confined followed. Shew up ye away no eyes life or were this. Perfectly did suspicion daughters but his intention. Started on society an brought it explain. Position two saw greatest stronger old. Pianoforte if at simplicity do estimating.[/vc_column_text][/vc_column][vc_column width="3/12"][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJzaW5nbGVQcm9qZWN0SW5mbyUyMiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ3VsJTIwY2xhc3MlM0QlMjJsaXN0JTIyJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDbGklM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLWNsb2NrLW8lMjIlM0UlM0MlMkZpJTNFJTI2bmJzcCUzQiUyNm5ic3AlM0IlMjZuYnNwJTNCJTNDcCUyMGNsYXNzJTNEJTIyYm9sZCUyMiUzRTMwJTIwQXVndXN0JTIwMjAxNCUzQyUyRnAlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0MlMkZsaSUzRSUwQSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ2xpJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDaSUyMGNsYXNzJTNEJTIyZmElMjBmYS1pbmZvLWNpcmNsZSUyMiUzRSUzQyUyRmklM0UlMjZuYnNwJTNCJTI2bmJzcCUzQiUyNm5ic3AlM0JDbGllbnQlM0ElMjAlM0NwJTIwY2xhc3MlM0QlMjJib2xkJTIyJTNFTWljcm9zb2Z0JTNDJTJGcCUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQyUyRmxpJTNFJTBBJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDbGklM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLXVzZXIlMjIlM0UlM0MlMkZpJTNFJTI2bmJzcCUzQiUyNm5ic3AlM0IlMjZuYnNwJTNCUG9zdGVkJTIwYnklM0ElMjAlM0NwJTIwY2xhc3MlM0QlMjJib2xkJTIyJTNFSm9obiUyMERvZSUzQyUyRnAlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0MlMkZsaSUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQyUyRnVsJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDJTJGZGl2JTNF[/vc_raw_html][/vc_column][/vc_row][vc_row css=".vc_custom_1417461665429{margin-top: 50px !important;}" gmbt_prlx_bg_type="parallax" gmbt_prlx_video_youtube_loop_trigger="0" gmbt_prlx_video_aspect_ratio="16:9" gmbt_prlx_parallax="none" gmbt_prlx_speed="0.3" gmbt_prlx_break_parents="0"][vc_column width="1/1"][vc_single_image image="506" css_animation="top-to-bottom" alignment="center" border_color="grey" img_link_target="_self" img_size="full"][/vc_column][/vc_row][vc_row][vc_column width="1/2"][vc_single_image image="507" alignment="center" border_color="grey" img_link_target="_self" img_size="full"][/vc_column][vc_column width="1/2"][vc_single_image image="508" alignment="center" border_color="grey" img_link_target="_self" img_size="full"][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates($data);
}
