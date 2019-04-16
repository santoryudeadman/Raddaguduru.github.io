<?php

if ( !function_exists( "fastwp_phoenix_add_metaboxes" ) ) {
    function fastwp_phoenix_add_metaboxes( $metaboxes ) {

        $metaboxes = array();

        // Portfolio Post
        $boxSectionsPortfolio = array();
        $boxSectionsPortfolio[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'portfolio-open-type',
        			'type'      => 'select',
                    'options'   => array(
						                'modal' => 'Expander (in-page content)',
						                'singlepage' => 'Single page',
						                'new' => 'Single page (New window)',
						                'lightbox' => 'Post thumbnail full'
					                    ),
        			'title'     => esc_html__( 'Open type', 'fastwp' ),
        			'subtitle'  => esc_html__( 'How this project should open on click', 'fastwp' )
        		),
        		array(
        			'id'        => 'portfolio-view-type',
        			'type'      => 'select',
                    'options'   => array(
	                                    '' => 'Normal',
						                'wide' => 'Wide/Large'
					                    ),
        			'title'     => esc_html__( 'View type', 'fastwp' ),
        			'subtitle'  => esc_html__( 'How to view this picture, wide or normal', 'fastwp' )
        		),
        		array(
                    'id'        =>'portfolio-target-url',
                    'type'      => 'text',
                    'title'     => esc_html__('Target URL', 'fastwp'),
                    'desc'      => esc_html__('Default target url is project url. You can override here', 'fastwp')
        		),
                array(
                    'id'        => 'portfolio-title',
                    'type'      => 'switch',
                    'title'     => esc_html__( 'Portfolio Title', 'fastwp' ),
                    'subtitle'  => esc_html__( 'Enable or disable single portfolio title/category', 'fastwp' ),
                    'default'   => 0,
                    'on'        => 'On',
                    'off'       => 'Off'
                ),
        		array(
        			'id'        => 'portfolio-page-layout',
        			'type'      => 'select',
                    'options'   => array(
                						'0' => 'Boxed',
                						'1' => 'Full Width'
					                    ),
        			'title'     => esc_html__( 'Page Layout', 'fastwp' )
        		),
        	)
        );

        // Testimonial Post
        $boxSectionsTestimonial = array();
        $boxSectionsTestimonial[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'testimonial-role',
        			'type'      => 'text',
        			'title'     => esc_html__( 'Member ocupation', 'fastwp' ),
        			'subtitle'  => esc_html__( 'Ex: Art Director', 'fastwp' ),
        			'default'   => '',
        		),
        		array(
        			'id'         => 'testimonial-stars',
        			'type'       => 'select',
        			'title'      => esc_html__( 'Star rating', 'fastwp' ),
                    'options'   => array( '5' => '5', '4.5' => '4.5', '4' => '4', '3.5' => '3.5', '3' => '3', '2.5' => '2.5', '2' => '2', '1.5' => '1.5', '1' => '1' ),
        			'default'    => 5
        		)
        	)
        );

        // Team Post
        $boxSectionsTeam = array();
        $boxSectionsTeam[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'team-role',
        			'type'      => 'text',
        			'title'     => esc_html__( 'Member role', 'fastwp' ),
        			'default'   => ''
        		),
        		array(
                    'id'        =>'team-social-links',
                    'type'      => 'multi_text',
                    'title'     => esc_html__('Social media', 'fastwp'),
                    'desc'      => esc_html__('Set social media icons. Format: ICON|LINK. Accepted icons: Font Awesome', 'fastwp')
        		)
        	)
        );

        // Service Post
        $boxSectionsService = array();
        $boxSectionsService[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'service-icon',
        			'type'      => 'text',
        			'title'     => esc_html__( 'Font awesome icon', 'fastwp' ),
                    'desc'      => esc_html__( 'Insert here font awesome class name', 'fastwp' ),
        			'default'   => '',
                    'required'  => array( 'service-icon-replacement', '=', '' )
        		),
        		array(
                    'id'        =>'service-icon-color',
                    'type'      => 'color',
                    'title'     => esc_html__('Icon color', 'fastwp'),
                    'desc'      => esc_html__('Select color for icon', 'fastwp'),
                    'required'  => array( 'service-icon-replacement', '=', '' )
        		),
        		array(
        			'id'        => 'service-icon-replacement',
        			'type'      => 'text',
        			'title'     => esc_html__( 'Icon replacement', 'fastwp' ),
                    'desc'      => esc_html__( 'Insert here image url to replace fontawesome icon', 'fastwp' ),
        			'default'   => ''
        		),
        		array(
                    'id'        =>'service-color-background',
                    'type'      => 'color',
                    'title'     => esc_html__('Background color', 'fastwp'),
                    'desc'      => esc_html__('Select background color for icon area (for default layout)', 'fastwp')
        		),
        		array(
                    'id'        =>'service-target-url',
                    'type'      => 'text',
                    'title'     => esc_html__('Target URL', 'fastwp'),
                    'desc'      => esc_html__('Open this page when click on service title (new window)', 'fastwp')
        		)
        	)
        );

        // Timeline Post
        $boxSectionsTimeline = array();
        $boxSectionsTimeline[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'timeline-date',
        			'type'      => 'text',
        			'title'     => esc_html__( 'Timeline date', 'fastwp' ),
                    'desc'      => esc_html__( 'Insert date that will be present next to timeline item in frontend', 'fastwp' ),
        			'default'   => ''
        		),
        		array(
                    'id'        =>'timeline-icon',
                    'type'      => 'text',
                    'title'     => esc_html__('Font awesome icon', 'fastwp'),
                    'desc'      => esc_html__('Insert here font awesome class name used as timeline item icon', 'fastwp')
        		),
        		array(
        			'id'        => 'timeline-tag',
        			'type'      => 'select',
        			'title'     => esc_html__( 'Title tag', 'fastwp' ),
                    'options'   => array( 'h5' => 'H5', 'h4' => 'H4', 'h3' => 'H3', 'h2' => 'H2' ),
                    'desc'      => esc_html__( 'Tag of timeline item title', 'fastwp' )
        		)
        	)
        );

        // Video Post
        $boxSectionsVideoPost = array();
        $boxSectionsVideoPost[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'post-video-url',
        			'type'      => 'text',
        			'title'     => esc_html__( 'Video URL', 'fastwp' ),
        			'subtitle'  => esc_html__( 'YouTube or Vimeo video URL', 'fastwp' ),
        			'default'   => '',
        		),
        		array(
        			'id'         => 'post-video-html',
        			'type'       => 'textarea',
        			'title'      => esc_html__( 'Embedded video', 'fastwp' ),
        			'subtitle'   => esc_html__( 'Use this option when the video does not come from YouTube or Vimeo', 'fastwp' ),
        			'default'    => '',
        		)
        	)
        );

        // Gagllery Post
        $boxSectionsGalleryPost = array();
        $boxSectionsGalleryPost[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'post-gallery',
        			'type'      => 'slides',
        			'title'     => esc_html__( 'Gallery Slider', 'fastwp' ),
        			'subtitle'  => esc_html__( 'Upload images or add from media library.', 'fastwp' ),
        			'placeholder'   => array(
        				'title'         => esc_html__( 'Title', 'fastwp' ),
        			),
        			'show' => array(
        				'title'         => true,
        				'description'   => false,
        				'url'           => false,
        			)
        		)
        	)
        );

        // Audio Post
        $boxSectionsAudioPost = array();
        $boxSectionsAudioPost[] = array(
        	'icon' => 'el-icon-screen',
        	'fields' => array(
        		array(
        			'id'        => 'post-audio-url',
        			'type'      => 'text',
        			'title'     => esc_html__( 'Audio URL', 'fastwp' ),
        			'subtitle'  => esc_html__( 'Audio file URL in format: mp3, ogg, wav.', 'fastwp' ),
        			'default'   => '',
        		)
        	)
        );

        // Declare metaboxes

        $metaboxes[] = array(
		    'id'            => 'portfolio-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'fwp_portfolio' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsPortfolio
        );
        $metaboxes[] = array(
		    'id'            => 'testimonial-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'fwp_testimonial' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsTestimonial
        );
        $metaboxes[] = array(
		    'id'            => 'team-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'fwp_team' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsTeam
        );
        $metaboxes[] = array(
		    'id'            => 'service-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'fwp_service' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsService
        );
        $metaboxes[] = array(
		    'id'            => 'timeline-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'fwp_timeline' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsTimeline
        );
        $metaboxes[] = array(
		    'id'            => 'video-post-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'post' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsVideoPost,
            'post_format'   => array( 'video' )
        );
        $metaboxes[] = array(
		    'id'            => 'gallery-post-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'post' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsGalleryPost,
            'post_format'   => array( 'gallery' )
        );
        $metaboxes[] = array(
            'id'            => 'audio-post-options',
            'title'         => esc_html__( 'Phoenix Options', 'fastwp' ),
            'post_types'    => array( 'post' ),
            'post_format'   => array('audio'),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSectionsAudioPost
        );

        return $metaboxes;
    }

    add_action( 'redux/metaboxes/fwp_data/boxes', 'fastwp_phoenix_add_metaboxes' );

}